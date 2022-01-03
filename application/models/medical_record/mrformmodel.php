<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH."models/pustakatabelmodel.php";

class MrFormModel extends PustakaTabelModel {
	public function __construct() {
		parent::inisiasi_tabel();
		$this->tableName = 'mr_form';
		$this->primaryKey = 'id';
		$this->resultMode = 'array';
		$this->notFormMR = ['CR-Tes','FT01','FT02','RMHEADER'];
	}
	
	function ambil_mr_latest($kode){
		return $this->find('kode = "'.$kode.'"','mr_form.id desc',1,null,'mr_form.id,title,versi,json_form');
	}

	public function get_form_field($id){
		$result = $this->db->get_where($this->tableName, ['id' => $id])->result_array();
		return $result;
	}
	
	function all_latest_variable_MR(){
		$all = $this->db->query('select group_concat(distinct cc order by cc desc) mr from (
            select concat(id,"|",versi,"|",kode) cc, kode from mr_form where kode not in ("'.implode('","',$this->notFormMR).'")
            ) a group by kode')->result_array();
		
		array_walk($all,function($v) use(&$allLatest){ 
			$n0 = explode(',',$v['mr']);
			$n = explode('|',$n0[0]);
			$allLatest[] = $n[0];
		});
		$allVar = $this->find('id in ('.implode(',',$allLatest).')',null,null,null,'kode,json_form');
		
		foreach($allVar as $v){
			$aV = json_decode($v['json_form'],TRUE);
			$kd = $v['kode'];
			array_walk($aV['form'],function($vl) use (&$return,$kd){
				if($vl['input_type'] != 'static'){
					$return[] = $kd.'.'.$vl['input_name'];
				}
				return;
			});
		}
		return $return;
	}
}