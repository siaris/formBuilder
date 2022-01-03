<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once "medical_record_controller.php";

class Fb extends Medical_record_controller {
	protected $allows = ['save_notes','show_notes','show_all_notes','go','add_save','upd_v_save','update_save','map_from_daily','save','load_form','change_attribute','load_form_preview'];
	public function __construct() {
        $this->trdParty = ['Date Picker'=>['css/datepicker.css','js/bootstrap-datepicker.js'],'Datetime Picker'=>['css/bootstrap-datetimepicker.css','js/bootstrap-datetimepicker.js'],
		'Facebox'=>['css/facebox.css','js/facebox.js']];
		parent::__construct();
		$this->previewVersion = '';
		$this->kirim_nilai_balik = 'json';
		$this->isSingleThread = true;
	}
	
	protected function init() {
        $this->css_theme_project = array('bootstrap', 'main', 'DT_bootstrap', 'override', 'jquery.slidepanel', 'datepicker', 'style', 'jquery.sliding_menu');
        $this->js_theme_project = array('bootstrap.min', 'jquery.sliding_menu', 'bootstrap-typeahead','jquery.validate.min','moment-with-locales.min', 'bootstrap-datepicker','media/medical_record/medical_record_base');
	}
	
	//halaman
	function form_list(){
		$this->init();
		$this->load->model('medical_record/mrformmodel');
		$this->load->library('grocery_crud/grocery_CRUD_extended');
		$crud = new grocery_CRUD_extended();
		$crud->set_table('mr_form');
		$crud->columns('kode','versi','title','aksi');
		$crud->callback_column('aksi',function($v,$r){
			$ltst = $this->mrformmodel->queryOne('kode = "'.$r->kode.'"','id','versi desc');
			$R = ($r->kode == 'RMHEADER')?'':'<a href="'.BASEURL.'/medical_record/emr/go_preview/'. $r->kode.'/'.$r->versi.'" class="btn btn-small">PREVIEW FORM</a> | ';
			$this->load->model('SuratKeteranganMcuModel');
			$this->SuratKeteranganMcuModel->changeResultMode('array');
			$this->SuratKeteranganMcuModel->tableName = 'mcu_template';
			$this->SuratKeteranganMcuModel->do_empty_fields();
			$idT = $this->SuratKeteranganMcuModel->queryOne('kode = "'.$r->kode.'+'.$r->versi.'"','id',null);
			if(!empty($idT))
				$R .= '<a href="'.BASEURL.'/mcusurat/templateEMR/'. $idT.'" class="btn btn-small">EDIT PRINT</a> | ';
			if($ltst == $r->id && $r->kode <> 'RMHEADER')
				return $R.'<a href="'.BASEURL.'/medical_record/emr/form_add/edit/'. $r->id.'" class="btn btn-small"><i class="icon-edit "></i> EDIT FORM</a> | <a href="'.BASEURL.'/medical_record/emr/form_add/upd_v/'. $r->id.'" class="btn btn-small"><i class="icon-upload"></i> UPDATE VERSI</a>';
			return $R;
		})
		->callback_column('title',function($v){
			return $v;
		});
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_delete();
		$output = $crud->render('<div class=""><a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="" href="'.BASEURL.'/medical_record/emr/form_add/"><i class="fa fa-plus-square-o"></i> + Tambah Form</a></div>');
		$this->view_folder = 'general';
		$this->preRender($output,'List Form','grocery_crud_content');
        return;
	}

	//halaman
	public function form_add($act='add',$id=''){
		$this->template->set_template("template_emr_builder");
		$this->load->helper(['str']);

		$this->load->library('crud_builder');
		$d['act'] = $act;
		$d['id'] = $id;
		$dC['crud'][] = (object)['type'=>'input','icon'=>'&#xe808;'];
		$dC['crud'][] = (object)['type'=>'berkas','icon'=>'&#xe811;'];
		$dC['crud'][] = (object)['type'=>'textarea','icon'=>'&#xe807;'];
		$dC['crud'][] = (object)['type'=>'select','icon'=>'&#xe804;'];
		$d['cmp'] = $this->load->view('medical_record/form/component', $dC, true);
		foreach (array('jquery.validate.min','jquery.alphanumeric','jquery.alphanumeric.pack','media/helpers') as $js) {
            $this->include_js .= "<script type=\"text/javascript\" src=\"" . ASSETURL . "js/" . $js . ".js?".$this->config->item('asset_js_version')."\"></script>";
		}
		$this->include_js .= "<script type=\"text/javascript\" src=\"" . ASSETURL . "emr/js/form.js?".$this->config->item('asset_js_version')."\"></script>";
		$this->template->write('js_bottom_scripts', $this->include_js, FALSE);
		$this->template->write('css', "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . ASSETURL . "emr/css/form.css\" \\>", FALSE);

        $this->template->write_view("js", "var_js",['BASEURL'=>BASEURL],FALSE);
        $this->template->write_view("content", "medical_record/form/form_add", $d);
        $this->template->render();
	}

	//halaman
	function load_form_edit_ready($id){
		$this->load->model('medical_record/mrformmodel');
		$template_form_path = 'medical_record/form/';
		$this->data = [];
		
		$data = $this->mrformmodel->get_form_field($id);
		
		
		$data_json_decode = json_decode($data[0]['json_form'],true);
		
		$preview = $this->load->view($template_form_path.'field_editor', $data_json_decode, true);
		$head_data = [$id,$data[0]['kode'],$data[0]['versi'],$data[0]['title'],$data_json_decode['script']];
		
		if(isset($data_json_decode['thirdparty']))
			$head_data[] = $data_json_decode['thirdparty'];
		
		return $this->response(['success' => true, 'html' => $preview, 'head' => $head_data]);
	}

	//halaman
	function preview(){
		$this->load->library('parser');
		$this->load->helper('file');
		$this->load->library('crud_builder', [
			'crud' => $_POST['form']
			]);

		$template_form_path = 'medical_record/form/';
		$this->data = ['pre'=>''];
		
		$validate = $this->crud_builder->validateAll();
		
		if ($validate->isError()) {
			return $this->response([
				'success' => false,
				'message' => $validate->getErrorMessage()
				]);
			exit;
		}
		
		$preview = $this->load->view($template_form_path.'form_prima_preview', $this->data, true);
		
		return $this->response(['success' => true, 'html' => $preview]);
	}

	function response($data, $status = 200){
        die(json_encode($data));

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }
	
	//halaman
	public function go($kode,$detail_reg = 0,$id = 0){
		$this->init();
		$this->addJs = $this->addCss = [];
		$this->addJs[] = 'vue/2.3.2';
		$this->addJs[] = 'vue/axios';
		$this->addCss[] = 'alt-aris-style';
		$this->folder_views_gc = 'medical_record';
		$data['view'] = 'emr';
		$data['title'] = '';
		$data['kode'] = $kode;
		$data['detail_reg'] = $detail_reg;
		$data['K'] = []; 
		$data['previewVersion'] = $this->previewVersion;
		$data['alreadyDefinedId'] = $id;
		if(!empty($detail_reg)){
			$this->load->model(['pendaftaranmodel']);
			$this->pendaftaranmodel->changeResultMode('array');
			$K = $this->pendaftaranmodel->load_data_in_right_column('',$detail_reg,FALSE);
			$data['K'] = $K[0];
		}
		$this->template->write_view("js_bottom_scripts", 'medical_record/emr_js', []);
		$this->render_defined_request($data);
		return;
	}

	private function render_defined_request($d){
        if ($this->input->is_ajax_request()){
            $this->js_theme_project = $this->addJs;
            $this->css_theme_project = $this->addCss;
            $this->addCss();
            $this->addJs('js');
            $this->template->write_view("content", $this->folder_views_gc."/".$d['view'], $d);
            $this->template->render();
            return;
        }
        //merge asset
        $this->js_theme_project = array_merge($this->js_theme_project,$this->addJs);
        $this->css_theme_project = array_merge($this->css_theme_project,$this->addCss);
        $this->preRender($d);
        return;
    }
	
	private function ambil_mr_latest($kode){
		return $this->mrformmodel->find('kode = "'.$kode.'"','mr_form.id desc',1,null,'mr_form.id,title,versi,json_form');
	}

	private function get_konten($p){
		$this->load->model(['medical_record/mrresultmodel']);
		$submit = $p; $attr_emr = $attr_dec = []; $allowed_action = 'new';
		if(isset($submit['definedId'])){
			if($submit['definedId'] != 'new'){
				$this->mrresultmodel->db->join('mr_form','mr_form.id=id_form','inner');
				$result = $this->mrresultmodel->find('mr_result.id = '.$submit['definedId'].' and mr_form.kode = "'.$submit['kode'].'"',null,1,null,'mr_result.id id,id_form,json_result,status');
				if(isset($result[0]['json_result'])){
					$attr_emr = [$result[0]['status'],json_decode($result[0]['json_result'],true),$result[0]['id']];
					$allowed_action = 'update';
				}
			}
		}else{
			$this->load->model('polikunjunganpasienmodel');
			$attr_enc = $this->polikunjunganpasienmodel->find('id = "'.$submit['detail_reg'].'"',null,null,null,'attr_tambahan');
			
			if(!empty($attr_enc)){
				if(isset($attr_enc[0]->attr_tambahan)){
					$attr_dec = json_decode($attr_enc[0]->attr_tambahan,true);
					if(isset($attr_dec['emr'])){
						if(!empty($attr_dec['emr'])){
							$this->mrresultmodel->db->join('mr_form','mr_form.id=id_form','inner');
							$result = $this->mrresultmodel->find('mr_result.id in ("'.implode('","',$attr_dec['emr']).'") and mr_form.kode = "'.$submit['kode'].'"',null,1,null,'mr_result.id id,id_form,json_result,status');
							if(isset($result[0]['json_result'])){
								$attr_emr = [$result[0]['status'],json_decode($result[0]['json_result'],true),$result[0]['id']];
								$allowed_action = 'update';
							}
						}
					}
				}
			}
		}
		return [$attr_emr,$attr_dec,$allowed_action];
	}
	
	//halaman
	public function load_form(){
		if($this->input->post()){
			$this->load->model(['polikunjunganpasienmodel','medical_record/mrresultmodel','medical_record/mrformmodel']);
			$this->load->library('parser');
			$submit = $this->input->post();
			
			//cari konten
			$Kntn = $this->get_konten($submit);
			$attr_emr = $Kntn[0]; $attr_dec = $Kntn[1]; $allowed_action = $Kntn[2];
			//end cari konten
			
			//cari form
			if(isset($attr_dec['emr'])){
				$this->mrformmodel->db->join('mr_result','mr_form.id=id_form','inner');
				$this->mrformmodel->db->where('mr_result.id in ("'.implode('","',$attr_dec['emr']).'")');
				$form = $this->mrformmodel->find('kode = "'.$submit['kode'].'"',null,1,null,'mr_form.id,title,versi,json_form');
				if(empty($form))
					$form = $this->mrformmodel->ambil_mr_latest($submit['kode']);
			}else{
				$form = $this->mrformmodel->ambil_mr_latest($submit['kode']);
			}
			
			$form_el = json_decode($form[0]['json_form'],true);
			$id_form = $form[0]['id'];
			
			$this->crud_builder = new stdClass();
			$this->crud_builder->crud = $form_el['form'];
			$_POST['script'] = $form_el['script'];
			if(isset($form_el['thirdparty']))
				$_POST['thirdparty'] = $form_el['thirdparty'];
			
			$preview = $this->parser->parse('medical_record/form/form_prima_preview', ['title'=>'<div class="modal-header"><h3>'.$form[0]['title'].'</h3></div>'], true);
			//end cari form
			
			echo json_encode(['success'=>true,'respon'=>[[$preview,$id_form],$attr_emr,$allowed_action]]);
			
		}
	}
	
	//halaman save
	public function save(){
		// $this->output->enable_profiler(TRUE);
		if($this->input->post()){
			$this->load->model(['medical_record/mrresultmodel']);
			$submit = $this->input->post();
			//save result
			if($submit['allowed_action'] == 'update'){
				$data_result['id'] = $submit['id_result'];
				$data_result['user_updated'] = $this->session->userdata['userLogin']['id'];
				$retID = false;
			}else{
				$data_result['id_form'] = $submit['id_form'];
				$data_result['user_created'] = $this->session->userdata['userLogin']['id'];
				$data_result['date_created'] = date('Y-m-d H:i:s');
				$retID = true;
			}
			$data_result['json_result'] = json_encode($this->mrresultmodel->susun_hasil_save($submit['form']));
			$return_save = $this->mrresultmodel->save($data_result,$retID);
			$submit['id_result'] = ($retID === true)?$return_save:$submit['id_result'];
			$save_pk = $insert_n = false;
			//save poli kunjungan
			if(!empty($submit['detail_reg'])){
				$this->load->model(['polikunjunganpasienmodel']);
				$attr_enc = $this->polikunjunganpasienmodel->find('id = "'.$submit['detail_reg'].'"',null,null,null,'attr_tambahan');
				if(!empty($attr_enc)){
					if(isset($attr_enc[0]->attr_tambahan)){
						$attr_dec = json_decode($attr_enc[0]->attr_tambahan,true);
						if(isset($attr_dec['emr'])){
							if(!in_array($submit['id_result'],$attr_dec['emr'])){
								$attr_dec['emr'][] = $submit['id_result'];
								$save_pk = true;
							}
						}else{
							$attr_dec['emr'] = [];
							$attr_dec['emr'][] = $submit['id_result'];
							$save_pk = true;
						}
					}else{
						$attr_dec['emr'] = [];
						$attr_dec['emr'][] = $submit['id_result'];
						$save_pk = true;
					}
				}else{
					$attr_dec['emr'] = [];
					$attr_dec['emr'][] = $submit['id_result'];
					$save_pk = true;
				}
				if($save_pk){
					$data_save = ['id'=>$submit['detail_reg'],'attr_tambahan'=>json_encode($attr_dec)];
					$this->polikunjunganpasienmodel->save($data_save);
				}
			}else{
				$this->load->model(['medical_record/mrformmodel','medical_record/dailynotesmodel']);
				$id = date('Y-m-d');
				//dailynotes
				$attr_enc = $this->dailynotesmodel->find('id = "'.$id.'"',null,null,null,'notes_json');
				$kF = $this->mrformmodel->queryOne('id = '.$submit['id_form'],'kode',null);
				if(!empty($attr_enc)){
					if(isset($attr_enc[0]['notes_json'])){
						$attr_dec = json_decode($attr_enc[0]['notes_json'],true);
						if(!isset($attr_dec[$kF]))
							$attr_dec[$kF] = [];
						$attr_dec[$kF][] = $submit['id_result'];
						$save_pk = true;
					}
				}else{
					//insert
					$insert_n = true;
					$attr_dec[$kF] = [];
					$attr_dec[$kF][] = $submit['id_result'];
					$save_pk = true;
				}
				
				if($save_pk){
					if($insert_n)
						$this->dailynotesmodel->db->query('insert into daily_notes(id) values("'.$id.'")');
					$this->dailynotesmodel->save(['id'=>$id,'notes_json'=>json_encode($attr_dec)]);
				}
			}
		}
		echo json_encode(['success'=>true,'message'=>'Dokumen MR berhasil disimpan!']);
	}

	protected function save_mr_doc($id = 0){
		// $this->output->enable_profiler(FALSE);
		$this->form_validation->set_rules('form[]', 'Form', 'required');
		
		if ($this->form_validation->run()) {
			$this->load->model('medical_record/mrformmodel');
			$submit = $this->input->post();
			
			$this->load->library('parser');
			$this->load->helper('file');
			$this->load->library('crud_builder', [
				'crud' => $_POST['form']
				]);
				
			$this->data = [];
			
			$validate = $this->crud_builder->validateAll();
			
			if ($validate->isError()) {
				return $this->response([
					'success' => false,
					'message' => $validate->getErrorMessage()
					]);
				exit;
			}
			$form_arr = [];
			$i=0;
			//make compact value to insert
			foreach($submit['form'] as $key=>$v){
				$form_arr[$i] = $v;
				if(isset($v['custom_option'])){
					$form_arr[$i]['custom_option'] = [];
					foreach($v['custom_option'] as $x){
						$form_arr[$i]['custom_option'][] = ['value'=>$x['value']];
					}
				}
				$i+=1;
			}
			$submit['form'] = $form_arr;
			
			$thirdparty = (!isset($submit['thirdparty']))?[]:$submit['thirdparty'];
			//save to table
			$save_data = [
				'kode' 			=> $submit['kode'],
				'title' 			=> $submit['title'],
				'versi'		=> $submit['versi'],
				'json_form' => json_encode(['form'=>$submit['form'],'script'=>$submit['script'],'thirdparty'=>$thirdparty])
			];
			if(!empty($id)){
				$id_form = $id;
				$affected_rows = $this->mrformmodel->update($id, $save_data);
			}else{
				$id_form = $this->mrformmodel->save($save_data);
				$this->_addTemplate($submit['kode'],$submit['versi'],$submit['title']);
			}
			$this->response['message'] = 'Your data has been successfully saved into the database.';
        	$this->response['success'] = true;
			$this->response['redirect'] = site_url('medical_record/emr/form_list');
				
		}else{
			$this->response['success'] = false;
			$this->response['message'] = validation_errors();
		}
		//return
		return json_encode($this->response);
	}

	private function _addTemplate($k,$v,$t){
		$this->load->model('SuratKeteranganMcuModel');
		$this->SuratKeteranganMcuModel->changeResultMode('array');
		$this->SuratKeteranganMcuModel->tableName = 'mcu_template';
		$this->SuratKeteranganMcuModel->do_empty_fields();
		$this->SuratKeteranganMcuModel->save(['jenis'=>$t,
			'tanggal'=>date('Y-m-d H:i:s'),
			'user'=>$this->session->userdata['userLogin']['id'],
			'unit_pengelola'=>'MIK',
			'kode'=>$k.'+'.$v]);
		return;
	}

	function check_duplicate(){
		$this->load->model('medical_record/mrformmodel');
		$this->mrformmodel->db->select('id');
		$this->mrformmodel->db->from('mr_form');
		$this->mrformmodel->db->where('kode', $this->input->post('kode'));
		$this->mrformmodel->db->where('versi', $this->input->post('versi'));
		$query = $this->mrformmodel->db->get();
		$num = $query->num_rows();
		if ($num > 0) {
			$this->form_validation->set_message('check_duplicate', 'Versi Sudah Ada Sebelumnya');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//halaman
	public function add_save(){
		$this->load->library(['form_validation']);
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required|alpha_dash');
		$this->form_validation->set_rules('versi', 'Versi', 'trim|required|numeric_dot|callback_check_duplicate');
		$this->form_validation->set_rules('title', 'Title', 'trim|alpha_numeric_spaces');

		echo $this->save_mr_doc();
	}
	
	//halaman
	public function upd_v_save(){
		$this->load->library(['form_validation']);
		$this->form_validation->set_rules('versi', 'Versi', 'trim|required|numeric_dot|callback_check_duplicate');
		$this->form_validation->set_rules('title', 'Title', 'trim|alpha_numeric_spaces');
		
		echo $this->save_mr_doc();
	}
	
	//halaman
	public function update_save($id = 0){
		if(empty($id))
			return;
		$this->load->library(['form_validation']);
		$this->form_validation->set_rules('title', 'Title', 'trim|alpha_numeric_spaces');
		echo $this->save_mr_doc($id);
	}
	
	private function dummyNotes(){
		return [['notes_json'=>json_encode(['notesmedis'=>[["Tx"=> "D1",
		"D" => date('Y-m-d H:i:s'),
		"Uid" => $this->session->userdata['userLogin']['id'],
		"O"=> ['st'=>'c'],
		"PImg"=> "/newserverr/assets/img/rsuppersahabatan.png"]
		]])
		]];
	}
	
	private function append_PK($Attr,$R){
		$D = json_decode($R,TRUE);
		if(isset($D['_spgdt_id']))
			if(!empty($D['_spgdt_id']))
				$Attr['emr'][] = '_spgdt_id.'.$D['_spgdt_id'];
		return $Attr;
	}
	
	//halaman
	function go_preview($kode,$v){
		$this->template->write('js_bottom_scripts','<script>$(document).ready(function() {app.isSaveClicked = true; $("#content button.btn").parent("div").addClass("hide");});</script>', FALSE);
		$this->previewVersion = $v;
		$this->go($kode);
	}
	
	//halaman
	public function load_form_preview(){
		if($this->input->post()){
			$this->load->model(['medical_record/mrformmodel']);
			$this->load->library('parser');
			$submit = $this->input->post();
			
			$form = $this->mrformmodel->find('kode = "'.$submit['kode'].'" AND versi = "'.$submit['versi'].'"',null,1,null,'mr_form.id,title,versi,json_form');
			
			$form_el = json_decode($form[0]['json_form'],true);
			$id_form = $form[0]['id'];
			
			$this->crud_builder = new stdClass();
			$this->crud_builder->crud = $form_el['form'];
			$_POST['script'] = $form_el['script'];
			if(isset($form_el['thirdparty']))
				$_POST['thirdparty'] = $form_el['thirdparty'];
			
			$preview = $this->parser->parse('medical_record/form/form_prima_preview', ['title'=>'<div class="modal-header"><h3>'.$form[0]['title'].'</h3></div>'], true);
			
			echo json_encode(['success'=>true,'respon'=>[[$preview,$id_form],[],'']]);
			
		}
	}
}?>