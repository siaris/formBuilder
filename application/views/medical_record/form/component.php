<style>
aside{
	background-attachment: scroll;
	background-clip: border-box;
	background-color: rgb(34, 45, 50);
	background-image: none;
	background-origin: padding-box;
	background-position: 0% 0%;
	background-position-x: 0%;
	background-position-y: 0%;
	background-repeat: repeat;
	background-size: auto;
	box-sizing: border-box;
	color: rgb(184, 199, 206);
	display: block;
	font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px;
	font-weight: 400;
	height: 1164.55px;
	line-height: 20px;
	overflow-y: auto;
	padding-top: 50px;
	position: absolute;
	right: 0px;
	top: 0px;
	transition-delay: 0s;
	transition-duration: 0.3s;
	transition-property: right;
	transition-timing-function: ease-in-out;
	width: 230px;
	z-index: 1010;
}
</style>
<aside class="control-sidebar control-sidebar-dark toolbox-form"  style="height: 100%; overflow: auto; position: fixed; max-height: 100%; padding-bottom: 50px;">
  <div class="tab-content" style="height: 100%">
  <h4 class="control-sidebar-heading">Forms </h4>
   <div class="tool-wrapper">     
      <table class="table table-responsive table table-striped "  id="tools">
       
	   <?php $i =1; foreach ($crud as $toolbox){ ?>
       <?php if (in_array($toolbox->type, $this->crud_builder->getFieldNotShowInFormComponent())) continue; ?>
          <tr>
             <td class="dragable hide-preview" width="2%">
                <i class="icon-sort text-muted"></i>
                <input type="hidden" name="form[{field_id}][{field_name}][sort]" class="priority" value="{field_id}" >
                <input type="hidden" class="form-id" id="form-id" value="{field_id}" >
                <input type="hidden" name="form[{field_id}][{field_name}][input_type]" class="form-name" id="form-name" value="<?= $toolbox->type ?>" >
             </td>
             <td class="dragable hide-designer" width="10%" style="color: #747474 !important">
			 <span class="demo-icon"><?= $toolbox->icon?></span>
             </td>
             <td class=" hide-designer" width="80%" style="color: #747474 !important">
               <?= ($toolbox->type == 'berkas')?'Pilih Berkas Kunjungan':ucwords(clean_snake_case($toolbox->type)); ?>
             </td>
             <td class="field-name-preview hide-preview" width="30%">
                <div class="setting-container">
                  <i class="icon-minus btn-collapse-setting hide"></i>
				  <div class="box-setting"> 
                      <label>
                          <h5><?= ($toolbox->type == 'berkas')?'Pilih Berkas Kunjungan':ucwords(clean_snake_case($toolbox->type)); ?></h5>
						  <div class="setting-name">field label</div> 
                          <input class="input_setting field_label" name="form[{field_id}][{field_name}][input_label]" value="<?= ucwords(clean_snake_case($toolbox->type)); ?>">
                      </label>
                  </div>
				  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">small tips</div> 
                          <input class="input_setting small_tips" name="form[{field_id}][{field_name}][small_tips]" value="">
                      </label>
                  </div>
                  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">field name</div> 
                          <input class="input_setting field_name" name="form[{field_id}][{field_name}][input_name]" value="<?= $toolbox->type; ?>">
                      </label>
                  </div>                               
                </div>
             </td>
             <td class="hide-preview" width="35%" id="">
				<div class="target-additional">
                <? //display additional config field ?>
				</div>
             </td>
             <td class="hide-preview">
				<i class="icon-copy pointer  clone-item" title="clone item" style="color:#008431;"></i>
                <i class="icon-remove  delete-item" title="delete item" style="color:#DE2C56;"></i>
             </td>
          </tr>
        <?php } ?>
        <tr>
             <td class="dragable hide-preview" width="2%">
                <i class="icon-sort text-muted"></i>
                <input type="hidden" name="form[{field_id}][{field_name}][sort]" class="priority" value="{field_id}" >
                <input type="hidden" class="form-id" id="form-id" value="{field_id}" >
                <input type="hidden" class="form-name" id="form-name" value="{field_name}" >
                <input type="hidden" class="form-name" id="form-name" value="static" name="form[{field_id}][{field_name}][input_type]">
             </td>
             <td class="dragable hide-designer" width="10%" style="color: #747474 !important">
                <i class="icon-bar"></i>
             </td>
              <td class=" hide-designer" width="80%" style="color: #747474 !important">
               Heading
             </td>
             <td class="field-name-preview hide-preview" width="28%">
                <div class="setting-container">
                  <i class="icon-minus btn-collapse-setting hide"></i>
                  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">heading label</div> 
                          <input class="input_setting" name="form[{field_id}][{field_name}][input_label]" value="">
						  <input class="field_name" value="heading" style="display:none">
                      </label>
                  </div>      
                  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">heading type</div> 
                          <div class="">
                              <div class="form-group ">
                                  <select  class="form-control chosen chosen-select " name="form[{field_id}][{field_name}][input_tag]" id="input_type" tabi-ndex="5" data-placeholder="Select Type" >
                                      <?php for ($i=1; $i <=6; $i++){ ?>
                                      <option value="h<?= $i; ?>">H<?= $i; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                      </label>
                  </div>
				  <div class="box-setting"> 
                      <label>
                          <div class="setting-name">small tips</div> 
                          <input class="input_setting" name="form[{field_id}][{field_name}][small_tips]" value="">
						  <input class="field_name" value="heading" style="display:none">
                      </label>
                  </div>				  
             </td>
             <td class="hide-preview">
                <i class="icon-remove pointer  delete-item" title="delete item" style="color:#DE2C56;"></i>
             </td>
        </tr>
        <tr>
             <td class="dragable hide-preview" width="2%">
                <i class="icon-sort text-muted"></i>
                <input type="hidden" name="form[{field_id}][{field_name}][sort]" class="priority" value="{field_id}" >
                <input type="hidden" class="form-id" id="form-id" value="{field_id}" >
                <input type="hidden" class="form-name" id="form-name" value="{field_name}" >
                <input type="hidden" class="form-name" id="form-name" value="static" name="form[{field_id}][{field_name}][input_type]">
                <input class="input_setting" type="hidden" id="imageIsi{field_id}" name="form[{field_id}][{field_name}][input_label]" value="">
                <input class="input_setting" type="hidden" name="form[{field_id}][{field_name}][input_tag]" value="img">
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
                     <div class="dropzone_{field_id}" style="cursor: pointer;" onclick="upload_gambar({field_id})"> Unggah Gambar </div>
                  </div> 
                   <div class="box-setting"> 
                      <label>
                          <div class="setting-name">small tips</div> 
                          <input class="input_setting" name="form[{field_id}][{field_name}][small_tips]" value="">
                          <input class="field_name" value="heading" style="display:none">
                      </label>
                  </div>           
             </td>
             <td class="hide-preview">
             <i class="icon-remove pointer  delete-item" title="delete item" style="color:#DE2C56;"></i>
             </td>
        </tr>
    </table>

    </div>
  </div>
</aside>
<script>
	var input_type = {
		'input' : {
			name: 'Input'
		},
		'textarea' : {
			name: 'Text Area'
		},
		'select' : {
			name: 'Select',
			additional:{
				has_option: 1
			}
		}
	}
	var config_input = {
		has_option_tag : `<div> <input type="checkbox" name="form[{field_id}][{field_name}][is_multiple]" value="1"> Bisa pilih lebih dari satu
				</div><div>add command <input type="text"><input type="button" value="go" class="go"></div><div class="custom-option-container">
                   <div class="custom-option-contain">
                      <div class="custom-option-item">
                        <div class="box-custom-option padding-left-0 box-top"> 
                            <div class="col-md-3">value</div>  <input type="text" name="form[{field_id}][{field_name}][custom_option][0][value]">
                        </div>
                        <a class="text-red delete-option icon-trash" data-original-title="" title=""></a> 
                      </div>
                   </div>
                    <a class="box-custom-option input btn btn-flat btn-block bg-black  add-option"> 
                    <i class="icon-plus"></i> Add new option
                   </a>
                </div>
				`,
	}
	$(document).ready(function() {
		
	})
</script>