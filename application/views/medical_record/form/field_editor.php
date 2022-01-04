<?
$return = [];
$i = 0;
foreach ($form as $k=>$contains){
	if($contains['input_type'] == 'static'){
		switch($contains['input_tag']){
			case 'img':
				$return[$i] = 
			'<tr>
             <td class="dragable hide-preview" width="2%">
                <i class="icon-sort text-muted"></i>
                <input type="hidden" name="form['.$k.'][sort]" class="priority" value="'.$k.'" >
                <input type="hidden" class="form-id" id="form-id" value="'.$k.'" >
                <input type="hidden" class="form-name" id="form-name" value="" >
                <input type="hidden" class="form-name" id="form-name" value="static" name="form['.$k.'][input_type]">
                <input class="input_setting" type="hidden" id="imageIsi'.$k.'" name="form['.$k.'][input_label]" value="'.$contains['input_label'].'">
                <input class="input_setting" type="hidden" name="form['.$k.'][input_tag]" value="img">
             </td>
             <td class="dragable hide-designer" width="10%" style="color: #747474 !important">
                <i class="fa fa-paragraph"></i>
             </td>
             <td class=" hide-designer" width="80%" style="color: #747474 !important">
               Gambar
             </td>
             <td class="field-name-preview hide-preview" width="28%">
                <div class="setting-container">
                  <i class="fa fa-minus btn-collapse-setting"></i>
                  <div class="box-setting"> 
                     <img src="'.$contains['input_label'].'" width="50%">
                  </div> 
                   <div class="box-setting"> 
                      <label>
                          <div class="setting-name">small tips</div> 
                          <input class="input_setting" name="form['.$k.'][small_tips]" value="'.$contains['small_tips'].'">
                          <input class="field_name" value="heading" style="display:none">
                      </label>
                  </div>           
             </td>
             <td class="hide-preview">
                <i class="icon-remove  delete-item" title="delete item" style="color:#DE2C56;"></i>
             </td>
        </tr>';
			break;
			default :
				$options = '';
				for ($j=1; $j <=6; $j++){
					$select = ('h'.$j == $contains['input_tag'])?'selected':'';
					$options .= '<option '.$select.' value="h'.$j.'">H'.$j.'</option>';
				}
				$return[$i] = '<tr>
					<td class="dragable hide-preview" width="2%">
						<i class="icon-sort text-muted"></i>
						<input type="hidden" name="form['.$k.'][sort]" class="priority" value="'.$contains['sort'].'" >
						<input type="hidden" class="form-id" id="form-id" value="'.$k.'" >
						<input type="hidden" class="form-name" id="form-name" value="'.$contains['input_type'].'" name="form['.$k.'][input_type]">
					 </td>
					 <td class="dragable hide-designer" width="10%" style="color: #747474 !important">
						<i class="fa fa-paragraph"></i>
					 </td>
					 <td class=" hide-designer" width="80%" style="color: #747474 !important">
					   Heading
					 </td>
					 <td class="field-name-preview hide-preview" width="28%">
						<div class="setting-container">
						  <i class="fa icon-minus btn-collapse-setting hide"></i>
						  <div class="box-setting"> 
							  <label>
								  <div class="setting-name">heading label</div> 
								  <input class="input_setting" name="form['.$k.'][input_label]" value="'.$contains['input_label'].'">
								  <input class="field_name" value="heading" style="display:none">
							  </label>
						  </div>      
						  <div class="box-setting"> 
							  <label>
								  <div class="setting-name">heading type</div> 
								  <div class="">
									  <div class="form-group ">
										  <select  class="form-control chosen chosen-select " name="form['.$k.'][input_tag]" id="input_type" tabi-ndex="5" data-placeholder="Select Type" >
											  '.$options.'
										  </select>
									  </div>
								  </div>
							  </label>
						  </div>
						  <div class="box-setting"> 
							  <label>
								  <div class="setting-name">small tips</div> 
								  <input class="input_setting" name="form['.$k.'][small_tips]" value="'.$contains['small_tips'].'">
								  <input class="field_name" value="heading" style="display:none">
							  </label>
						  </div>				  
					 </td>
					 <td class="hide-preview">
						<i class="icon-remove  delete-item" title="delete item" style="color:#DE2C56;"></i>
					 </td>
				</tr>';
				break;
		}
	}else{
		$typ = $contains['input_type'] == 'berkas'?ucwords('Pilih Berkas Kunjungan'):ucwords($contains['input_type']);
		$return[$i] = '<tr>
             <td class="dragable hide-preview" width="2%">
                <i class="icon-sort text-muted"></i>
                <input type="hidden" name="form['.$k.'][sort]" class="priority" value="'.$contains['sort'].'" >
                <input type="hidden" class="form-id" id="form-id" value="'.$k.'" >
                <input type="hidden" class="form-name" id="form-name" value="'.$contains['input_type'].'" name="form['.$k.'][input_type]">
             </td>
             <td class="dragable hide-designer" width="10%" style="color: #747474 !important">
             </td>
             <td class=" hide-designer" width="80%" style="color: #747474 !important">
             </td>
             <td class="field-name-preview hide-preview" width="30%">
                <div class="setting-container">
                  <i class="fa icon-minus btn-collapse-setting hide"></i>
				  <div class="box-setting"> 
                      <label>
                          <h5>'.$typ.'</h5>
						  <div class="setting-name">field label</div> 
                          <input class="input_setting field_label" name="form['.$k.'][input_label]" value="'.$contains['input_label'].'">
                      </label>
                  </div>
				  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">small tips</div> 
                          <input class="input_setting small_tips" name="form['.$k.'][small_tips]" value="'.$contains['small_tips'].'">
                      </label>
                  </div>
                  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">field name</div> 
                          <input class="input_setting field_name" name="form['.$k.'][input_name]" value="'.$contains['input_name'].'">
                      </label>
                  </div>                               
                </div>
             </td>
             <td class="hide-preview" width="35%" id="">
				<div class="target-additional">
                {for_additional_input}
				</div>
             </td>
             <td class="hide-preview">
				<i class="fa fa-copy pointer  clone-item" title="clone item" style="color:#008431;"></i>
                <i class="icon-remove delete-item rmv-existed" title="delete item" style="color:#DE2C56;"></i>
             </td>
          </tr>';
		  $additional_input = '';
		  switch($contains['input_type']){
			//select
			case 'select' :
				$checked = (isset($contains['is_multiple']))?'checked':'';
				$options = '';
				foreach($contains['custom_option'] as $l=>$v){
					$trash = ($l > 0)?'<a class="text-red delete-option fa icon-trash" data-original-title="" title="" style="padding-top: 15px;"></a>':'';
					$options .= '<div class="custom-option-item">
                        <div class="box-custom-option padding-left-0 box-top"> 
                            <div class="col-md-3">value</div>  <input type="text" name="form['.$k.'][custom_option]['.$l.'][value]" value="'.$v['value'].'">
                        </div>
                        '.$trash.' 
                      </div>';
				}
				$additional_input = '<div> <input type="checkbox" name="form['.$k.'][is_multiple]" '.$checked.' value="1"> Bisa pilih lebih dari satu
				</div><div class="custom-option-container">
                   <div class="custom-option-contain">
                      '.$options.'
                   </div>
                    <a class="box-custom-option input btn btn-flat btn-block bg-black  add-option"> 
                    <i class="fa fa-plus-circle"></i> Add new option
                   </a>
                </div>'; 
				break;
		}
		//replace additional input
		$return[$i] = str_replace('{for_additional_input}', $additional_input, $return[$i]);
	}
	$i+=1;
}?>
<form class="form-horizontal form-preview">
<?= implode('',$return)?>
</form>