<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH."models/pustakatabelmodel.php";

class MrResultModel extends PustakaTabelModel {
	public function __construct() {
		parent::inisiasi_tabel();
		$this->tableName = 'mr_result';
		$this->primaryKey = 'id';
		$this->resultMode = 'array';
		$this->glueMultipleValue = ' && ';
		$this->textResultPreviewC = 4;
	}
	
	public function susun_hasil_save($data = []){
		$return = [];
		if(empty($data))
			return $return;
		array_walk($data,function($v,$k) use (&$return) {
			if(is_array($v))
				$return[$k] = implode($this->glueMultipleValue,$v);
			else
				$return[$k] = $v;
		});
		return $return;
	}
	
	public function merge_doc_with_header($d){
		return '<table><thead><tr><td>'.$d[1]['template'].'</td></tr></thead><tbody><tr><td>'.$d[0]['template'].'</td></tr></tbody></table>';
	}
	
	public function from_daily($idR){
		$this->db->join('mr_form','id_form = mr_form.id','inner');
		$R = $this->find($this->tableName.'.id in ('.implode(',',$idR).')',null,null,null,'kode,json_result,json_form,'.$this->tableName.'.id,date_created,user_created');
		$this->Ar = ['B01'=>[],'O'=>[]];
		foreach($R as $r){
			$this->label_from_daily($r);
		}
		return $this->Ar;
	}
	
	private function label_from_daily($A){
		$K = 'O';
		if(in_array($A['kode'],['RM-B01','RM-B01-A']))
			$K = 'B01';
		$this->Ar[$K][$A['kode'].'+'.$A['id']] = [$A['json_result'],$this->build_preview_text_result(json_decode($A['json_result'],true),json_decode($A['json_form'],true)),display_date($A['date_created'],'d-m-Y H:i'),$A['user_created']];
		
		return;
	}
	
	private function build_preview_text_result($jR,$jF){
		$R = 'previews-text';$i = 0;$Rw = $r = [];
		if(!isset($jF['tPvw'])){
			foreach($jF['form'] as $j){
				if(in_array($j['input_type'],['select','input','textarea'])){
					$r[] = $j['input_name'];
					$i+=1;
				}
				if($i == $this->textResultPreviewC)
					break;
			}
			
			foreach($r as $_r){
				$Rw[] = $jR[$_r];
			}
			$R = implode(' / ',$Rw);
		}
		return $R;
	}
}