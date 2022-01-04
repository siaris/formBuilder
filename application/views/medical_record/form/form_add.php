
<script type="text/javascript" src="<?= ASSETURL.'/js/vue/2.3.2.js'?>"></script>
<script type="text/javascript" src="<?= ASSETURL.'/js/vue/axios.js'?>"></script>
<script language="Javascript" type="text/javascript" src="<?= ASSETURL.'/js/edit_area/edit_area_full.js'?>"></script>
<script src="<?= ASSETURL; ?>js/dropzone.min.js"></script>
<style>
.btn-round-element, .btn-round-element-free {
	background-attachment: scroll;
	background-clip: border-box;
	background-color: rgb(0, 179, 36);
	background-image: none;
	background-origin: padding-box;
	background-position: 0% 0%;
	background-position-x: 0%;
	background-position-y: 0%;
	background-repeat: repeat;
	background-size: auto;
	border-bottom-left-radius: 100%;
	border-bottom-right-radius: 100%;
	border-top-left-radius: 100%;
	border-top-right-radius: 100%;
	bottom: 20px;
	box-shadow: rgba(0, 0, 0, 0.1) 5px 5px 1px 0px;
	box-sizing: border-box;
	color: rgb(255, 255, 255);
	cursor: pointer;
	font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 25px;
	font-weight: 700;
	height: 40px;
	line-height: 35.7167px;
	position: fixed;
	right: 20px;
	text-align: center;
	
	transform-origin: 20px 20px;
	transition-delay: 0s;
	transition-duration: 0.5s;
	transition-property: all;
	transition-timing-function: ease;
	width: 40px;
	z-index: 2147483647;
	-moz-user-select: none;
}
.control-sidebar-open{
    right: 0;
}
</style>
<?foreach($this->trdParty as $k=>$v){
	$thirdP[] = $k;
}?>
<div class="col-md-12 col-box-form">
         <div class="box box-warning">
            <div class="box-body ">
               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                     <div class="widget-user-image">
                     </div>
                     <!-- /.widget-form-image -->
                     <h3 class="widget-user-username">Modif Form</h3>
                     <h5 class="widget-user-desc"></h5>
                     <hr>
                  </div>
				  <form action="<?= BASEURL?>/medical_record/page/save" name="form_form" class="form-horizontal" id="form_form" method="POST" accept-charset="utf-8">
				  <input type="hidden" name="id" id="id">
                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Kode <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="kode" id="kode" value="" placeholder="Kode">
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Versi <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="versi" id="versi" placeholder="Versi" value="">
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="label" class="col-sm-2 control-label">Title </label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                        <small class="info help-block">Judul form.</small>
                     </div>
                  </div>
                  <hr>
				  <div class="col-md-12 padding-left-0 padding-right-0">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                          <ul class="nav nav-tabs">
                            <li class="active"><a class=" active btn-form-designer" href="#tab_1" data-toggle="tab"><i class="fa icon-code text-green"></i> Form Designer</a></li>
                            <li><a class=" active btn-form-preview" href="#tab_2" data-toggle="tab"><i class="fa icon-tv text-green"></i> Form Preview</a></li>
                            <li> <span class="loading3 loading-hide" style="display:none;"><img src="<?= ASSETURL; ?>img/loading-spin-primary.svg"> <i>Loading, Getting data</i></span></li>

                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane rest-page-test active" id="tab_1">
                              <div class="wrapper-form">
                               <table class="table table-responsive table table-striped table-form"  id="diagnosis_list">
                               <tbody>
                                 <tr class="sort-placeholder">
                                   <td colspan="4">Drag Form Here</td>
                                 </tr>
                               </tbody>
                               </table>
                              </div>
							  
								<div class="form-group">
								<label class="col-sm-2 control-label">3rd-Party</label>
									<div class="col-sm-8">
										<select name="thirdparty[]" id="thirdparty" multiple="" class="form-control">
											<?foreach($thirdP as $k=>$v){?>
											<option value="<?= $k?>"><?= $v?></option>
											<?}?>
										</select>
									</div>
								</div>
							  
								<div class="form-group">
								<label class="col-sm-2 control-label">Script</label>
									<div class="col-sm-8">
									<code><textarea rows="30" cols="120" name="script" id="script_form">/*This is remark*/</textarea></code>
									<small class="info help-block">JavaScript Only</small>
									</div>
								</div>
                               <div class="view-nav">
                                 <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back'><i class="ion ion-ios-list-outline" ></i> Save and Go to The List</a>
								 <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='refresh'><i class="ion ion-ios-list-outline" ></i> Save</a>
                                 <a class="btn btn-flat btn-default btn_action" id="btn_cancel" ><i class="fa icon-undo" ></i> Cancel</a>
                                 <span class="loading loading-hide" style="display:none;"><img src="<?= ASSETURL; ?>img/loading-spin-primary.svg"> <i>Loading, Saving data</i></span>
                              </div>
                            </div>
                            <div class="tab-pane rest-page-test" id="tab_2">
                              <div class="preview-form display-none">
                              </div>
                            </div>

                          </div>
                        </div>
                    </div>	
					<div class="validation_rules" style="display: none"></div>
					<div class="message no-message-padding"></div>
				  
				  </form>
                </div>
            </div>
        </div>
  </div>
  <div class="btn-round-element noselect btn-tool" title="Add Block Element" data-toggle="control-sidebar">
	<span>+</span>
  </div>
  <div class="btn-round-element-free" title="" style="bottom: 120px;background-color: cadetblue;" onclick="javasript:document.body.scrollTop = 0;document.documentElement.scrollTop = 0;">
	<i class="icon-double-angle-up"></i>
  </div>
  <div class="btn-round-element-free" title="" style="bottom: 70px;background-color: cadetblue;" onclick="javasript:window.scrollTo(0,document.body.scrollHeight);">
	<i class="icon-double-angle-down"></i>
  </div>
  <?= $cmp?>
<script>
var act = '<?= $act?>'
$(document).ready(function() {
    $('#id').val('');
	$('#versi').numeric({allow:"."})
	$('#kode').alphanumeric({allow:"-"})
    //tabel preview
	$(document).find("#diagnosis_list tbody").sortable({
        helper: fixHelperModified,
        handle: 'td:first',
        start: function() {
            $(this).addClass('target-area');
            updatePlaceHolder();
        },
        stop: function(event, ui) {
            renumber_table('#diagnosis_list');
            updatePlaceHolder();
        }
    });
    if(act != 'edit') $('a[data-stype="refresh"]').addClass('hide')

    $(document).on('change', 'input.switch-button', function() {
        if ($(this).prop('checked')) {
            $(this).parents('.box-setting').find('.input_setting').fadeOut('easeInOutQuart');
        } else {
            $(this).parents('.box-setting').find('.input_setting').focus().fadeIn('easeInOutQuart');
        }
    });

    $(document).find(".trash").sortable({
        connectWith: $(document).find("#diagnosis_list tbody"),
    });
	
	//tools
    $("#tools tbody").sortable({
        connectWith: $(document).find("#diagnosis_list tbody"),
        helper: 'clone',
        placeholder: "ui-state-highlight",
        start: function(ui, event) {
            $('.toolbox-form').css('overflow', '');
            $('.toolbox-form').css('overflow-y', '');
            updatePlaceHolder();
        },
        remove: function(event, ui) {
            ui.item.enableSelection().clone().prependTo($(".toolbox-form .tool-wrapper table tbody"));
            $('.toolbox-form').css('overflow-y', 'auto');
            updatePlaceHolder();
            renumber_table('#diagnosis_list');
			
			var t_input_type = ui.item.find('.field_name').val()
			
			//cek jika ada additional
			if(typeof input_type[t_input_type] !== 'undefined')
				if(typeof input_type[t_input_type]['additional'] !== 'undefined'){
				//tambah additional
					for(o in input_type[t_input_type]['additional']){
						ui.item.find('.target-additional').html(
							config_input[o+'_tag']
						)
					}
				}
			
            var id_field = getUnixId();
            var tpl = ui.item.html()
                .replaceAll('[{field_name}]', '')
                .replaceAll('{field_id}', id_field);

            ui.item.replaceWith('<tr class="new-item-sortable">' + tpl + '</tr>');

            var new_item_sortable = $('.new-item-sortable');

            // new_item_sortable.find('.chosen-select').chosen('destroy');
            new_item_sortable.find('#input_type_chosen, #validation_chosen,#relation_table_chosen, #relation_value_chosen, #relation_label_chosen').remove();
            // new_item_sortable.find('.chosen-select').chosen();

            /*added default validation rules*/
            new_item_sortable.find('.validation').each(function() {
                var id = $(this).parents('tr').find('#form-id').val();
                var name = $(this).parents('tr').find('#form-name').val();

                addValidation($(this), id, name, 'required', 'no');
            });

            // new_item_sortable.find('.switch-button').switchButton({
                // labels_placement: 'right',
                // on_label: 'yes',
                // off_label: 'no'
            // });
            $('.new-item-sortable').removeClass('new-item-sortable');

        }
    }).disableSelection();
	
	//flip flop the form builder
    function updatePlaceHolder() {
        if ($('.table-form tr[class!="sort-placeholder"]').length <= 0) {
            $('.table-form .sort-placeholder').show();
        } else {
            $('.table-form .sort-placeholder').hide();
        }
    }

    /*update validation*/
    $(document).find('table tr .input_type').each(function() {
        updateValidation($(this));

        var relation = $(this).find('option:selected').attr('relation');
        var custom_value = $(this).find('option:selected').attr('custom-value');
        var table_relation = $(this).parents('td').find('.relation_table');
        var custom_option_container = $(this).parents('td').find('.custom-option-container');

        if (relation == 1) {
            table_relation.val('').trigger('chosen:updated').parents('.form-group').show();

        } else {
            $(this).parents('td').find('.relation_field').parents('.form-group').hide();
            $(this).parents('td').find('.relation_field').val('');
        }

        if (custom_value == 1) {
            custom_option_container.show();

        } else {
            custom_option_container.hide();
        }
    });

    $('.btn-tool').click(function(event) {
        $('.toolbox-form').css('overflow-y', 'auto');

        return false;
    });

    $('.btn-form-designer').click(function(event) {
        // $('.control-sidebar').addClass('control-sidebar-open');
        // buttonToggleSideBarClose($('.btn-round-element'));
		return
    });

    var preview = $('#preview');

    $('.btn-form-preview').click(function() {
		
		$('#edit_area_toggle_checkbox_script_form').click()
			
        if ($('.table-form tr[class!="sort-placeholder"]').length <= 0) {
            $('.control-sidebar').addClass('control-sidebar-open');
            toastr['warning']('Please make form first');
            buttonToggleSideBarOpen($('.btn-round-element'));
            return false;
        }
        $('.control-sidebar').removeClass('control-sidebar-open');
        $('.loading3').show();

        var form_form = $('#form_form');
        var data_post = form_form.serialize();
        $('.preview-form').html('');

        $.ajax({
                url: BASEURL + '/medical_record/emr/preview',
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                $('.message').html('');
                if (res.success) {
                    $('.preview-form').html(res.html);
                    $('.preview-form').show();

                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                    $('.message').fadeIn();
                }

            })
            .fail(function() {
                $('.message').printMessage({
                    message: 'Error getting data',
                    type: 'warning'
                });
            })
            .always(function() {
                $('.loading3').hide();
            });
			$('#edit_area_toggle_checkbox_script_form').click()
    });

    $('.btn_save').click(function() {
        $('.message').hide();
		$('#edit_area_toggle_checkbox_script_form').click()
        var form_form = $('#form_form');
        var data_post = form_form.serializeArray();
        var save_type = $(this).attr('data-stype');
		if(act === 'edit')
			url_save = '/medical_record/emr/update_save/'+id_ref
		else if(act === 'upd_v')
			url_save = '/medical_record/emr/upd_v_save'
		else
			url_save = '/medical_record/emr/add_save'

        data_post.push({
            name: 'save_type',
            value: save_type
        });

        $('.loading').show();

        $.ajax({
                url: BASEURL + url_save,
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                if (res.success) {
                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }else{
						window.location.reload();
						return;
					}

                    if (typeof res.id != 'undefined') {
                        $('#id').val(res.id);
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn();

                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                    $('.message').fadeIn();
                }
            })
            .fail(function() {
                $('.message').printMessage({
                    message: 'Error save data',
                    type: 'warning'
                });
            })
            .always(function() {
                $('.loading').hide();
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 3000);
            });

        return false;
    }); /*end btn save*/

    //Helper function to keep table row from collapsing when being sorted
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    //Renumber table rows
    function renumber_table(tableID) {
        $(tableID + " tr").each(function() {
            count = $(this).parent().children().index($(this)) + 1;
            $(this).find('.priority').val(count);
        });
    }
	
	if(act === 'edit')
		$('.widget-user-desc').html('Edit Form')
	else if(act === 'upd_v')
		$('.widget-user-desc').html('Update Versi Form')
	else
		$('.widget-user-desc').html('Buat Form Baru')
	
	$.fn.printMessage = function(opsi) {
          var opsi = $.extend({
              type: 'success',
              message: 'Success',
              timeout: 500000
          }, opsi);

          $(this).hide();
          $(this).html(' <div class="col-md-12 message-alert" ><div class="callout callout-' + opsi.type + '"><h4>' + opsi.type + '!  <a href="#" class="close pull-right" >&times;</a></h4>' + opsi.message + '</div></div>');
          $(this).slideDown('slow');
          // Run the effect
          setTimeout(function() {
              $('.message-alert').slideUp('slow');
          }, opsi.timeout);

          var parentElem  = $(this);

          $(this).find('.message-alert .close').click(function(event) {
            event.preventDefault();
            parentElem.html('');
          });
    };
	
	$(document).on('click', 'input.go', function() {
		let eV = $(this).closest('div').find('input[type="text"]').val()
		callE['init'](eV,this)
		return
	})
}); /*end doc ready*/

var callE = function(){
	function inti(s,obj){
		setO(obj)
		fMatc = s.match(/^([a-z]{1,}?)\((.*)\)/)
		switch(fMatc[1]){
			case 'rg':
				Param = explode(',',fMatc[2])
				range()
				break
			case 'cl':
				clear()
				break
			case 'cle':
				clearempty()
				break
			default:
				break
		}
		$(Obj).closest('div').find('input[type="text"]').val('')
		return
	}
	function setO(obj){
		Obj = obj
	}
	function range(){
		// clear()
		//do Range
		Arr = Range(parseFloat(Param[0]),parseFloat(Param[1]),parseFloat(Param[2]))
		
		for(i in Arr){
			$(Obj).closest('.target-additional').find('a.box-custom-option.add-option').click()
		}
		for(i in Arr){
			nd = $(Obj).closest('.target-additional').find('.custom-option-contain input[type="text"]')[i]
			console.log(nd)
			$(nd).val(Arr[i])
		}
		
		//display
		return
	}
	function clear(){
		$(Obj).closest('.target-additional').find('a.fa.delete-option').addClass('click-clear')
		$('.click-clear').each(e => $('.click-clear')[e].click())
		return
	}
	function clearempty(){
		$(Obj).closest('.target-additional').find('a.fa.delete-option').addClass('click-clear')
		//console.log($(Obj).closest('.target-additional').find('a.fa.delete-option'))
		$('.click-clear').each(e => {
			nd = $('.click-clear')[e]
			console.log($(nd).closest('div.custom-option-item').find('input[type="text"]'))
			if($(nd).closest('div.custom-option-item').find('input[type="text"]').val() == '')
				$('.click-clear')[e].click()
		})
		$('.click-clear').removeClass('click-clear')
		return
	}
	return{
		init: inti
	}
}()

const Range = (start, stop, step = 1) =>
  Array(Math.ceil((stop - start) / step)).fill(start).map((x, y) => x + y * step)

var IDELoader = function(){
	function inti(){
		editAreaLoader.init({
			id: "script_form"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "y"
			,allow_toggle: true
			,word_wrap: true
			,language: "en"
			,syntax: "js"
            ,show_line_colors: true	
            ,toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help"
			})
			$('.sidebar-toggle').click()
	}
	return{
			init: inti
	}
}()

</script>
<?if(!empty($id)){?>
<script type="text/javascript">
var id_ref = <?= $id?>;
const app = new Vue({
	el:'.box-body',
	data() {
		return {
			id: id_ref,
			act: act
		}
	},
	mounted: function(){
		this.loadForm()
	},
	methods:{
		loadForm(){
			axios.post(BASEURL+'/medical_record/emr/load_form_edit_ready/'+this.id, null, {crossdomain: false})
			.then((resp) => {
					console.log(resp.data)
					//hilangin text drop area
					$('.table-form .sort-placeholder').hide();
					//bangun field form
					$("#diagnosis_list tbody").html(resp.data['html'])
					//isi form header
					$('#form_form #id').val(resp.data.head[0])
					$('#form_form #kode').val(resp.data.head[1])
					$('#form_form #versi').val(resp.data.head[2])
					$('#form_form #title').val(resp.data.head[3])
					$('#form_form #script_form').val(resp.data.head[4])
					$('#form_form #thirdparty').val(resp.data.head[5])
					IDELoader.init()
					//tentukan mana yg readonly dan editable
					if(this.act === 'edit'){
						//kode dan versi readonly
						$('#form_form #kode').prop('readonly', true);
						$('#form_form #versi').prop('readonly', true);
						
						$('#diagnosis_list input.field_name').prop('readonly', true);
						$('#diagnosis_list input.field_name').removeClass('field_name').addClass('field_name_readonly');
						$('.rmv-existed').hide()
						
					}else{
						//kode readonly
						$('#form_form #kode').prop('readonly', true);
						$('#diagnosis_list input.field_name').each(function (i,O){
							if(O.value.match(/^_./)){
								$('[value="'+O.value+'"]').addClass('field_name_readonly').removeClass('field_name').prop('readonly',true).closest('tr').find('i.icon-remove').addClass('hide')
							}	
						})
					}
			})
			return
		}
	}
})
</script>

<?}else{?>
<script type="text/javascript">
IDELoader.init()
</script>
<?}?>
<script type="text/javascript">
  function upload_gambar(x){
   Dropzone.autoDiscover = false;

   var myDropzone = new Dropzone(".dropzone_"+x, {
    url: "<?php echo base_url('medical_record/emr/upload_image') ?>",
    acceptedFiles: "image/*",
    maxFilesize: 2000,
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks: true,
    clickable: true,
	uploadMultiple: false,
	maxFiles: 1,
    sending: function(a,b,c) {
      a.token   = Math.random();
      randomKey   = $('#randomKey').val();
      c.append("token",a.token); //Menmpersiapkan token untuk masing masing foto
      c.append("randomKey",randomKey);
    },
    success: function( file, response ){
         obj = JSON.parse(response);
         $('#imageIsi'+x).val(obj.nm_file);
         //myDropzone.removeFile(file);
         $('.dz-success-mark').hide();
         $('.dz-error-mark').hide();
    },
    removedfile: function(file) { 
    // var name = file.name;
    var token= file.token;
    var randomKey = $('#randomKey').val();
    $.ajax({
      type: "post",
      url: "fungsi/apus/"+$('#imageIsi'+x).val(),
      data:{token:token, randomKey:randomKey},
      dataType: 'json',
      cache:false,
    });
    // remove the thumbnail
    var previewElement;
    return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
   }
  });
}
</script>