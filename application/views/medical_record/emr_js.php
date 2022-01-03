<script type="text/javascript">
const glueMultipleValue = ' && '
var notesKunjungan = {}
var app = new Vue({
	el:'#app',
	data() {
		return {
			kode: function(){
				return $('#kode').val()
			},
			detail_reg: function(){
				return $('#detail_reg').val()
			},
			definedId: function(){
				return $('#alreadyDefinedId').val()
			},
			id_form: '',
			id_result: '',
			allowed_action: 'new',
			isSaveClicked: false,
			resultForm: {}
		}
	},
	mounted: async function(){
		if($('#previewVersion').val() == '') await this.initForm()
		else await this.initFormForPreview()
		this.getOtherEMR()
	},
	methods:{
		initForm(){
			var data = new FormData();
			data.append('kode', this.kode());
			if(this.definedId() == 0) data.append('detail_reg', this.detail_reg());
			else data.append('definedId', this.definedId())
			axios.post(BASEURL+'/medical_record/emr/load_form/', data, {crossdomain: false})
			.then(async (resp) => {
					$('main#form-target').html(resp.data['respon'][0][0]);
					this.id_form = resp.data['respon'][0][1]
					await this.getNotesKunjungan()
					if(typeof EMRFormInitiated !== 'undefined')
						EMRFormInitiated.act()
					if(resp.data['respon'][1]){
						this.fillForm(resp.data['respon'][1]);
						this.id_result = resp.data['respon'][1][2]
					}
					this.allowed_action = resp.data['respon'][2]
					if(typeof EMRFormFilled !== 'undefined')
						EMRFormFilled.init()
					return
			})
			return
		},
		fillForm(data){
			this.resultForm = data[1]
			for(d in data[1]){
				if($('[rel="'+d+'"]').is("select")){
					var sel = document.querySelector('[rel="'+d+'"]')
					var value_list = data[1][d].split(glueMultipleValue)
					for (vl in value_list){
						for ( var i = 0, len = sel.options.length; i < len; i++ ) {
							if(value_list[vl] === sel.options[i]['value']){
								//selected
								sel.options[i].setAttribute('selected','');
								//pop
								delete value_list[vl]
							}
						}
					}
					
					var filtered = value_list.filter(function (el) {
					  return el != null;
					});
					
					if(filtered.length > 0){
						var noteMoreThanOne = (filtered.length > 1)?'. Ada '+filtered.length+' jawaban, dipisahkan dengan tanda "'+glueMultipleValue+'".':'';
						$('<small>ada jawaban belum terpilih yaitu : '+filtered.join(glueMultipleValue)+' </small><small>'+noteMoreThanOne+'</small>').insertBefore('[rel="'+d+'"]')
					}
				}else
					$('[rel="'+d+'"]').val(data[1][d])
				$('[rel="'+d+'"]').change()
			}
			return
		},
		async saveMR(){
			this.isSaveClicked = true
			if(typeof EMRdoBeforeSubmit !== 'undefined'){
				let nxt = EMRdoBeforeSubmit.init()
				if(nxt === false)
					return nxt
			}
			var form = document.querySelector('.form-preview');
			var data = new FormData(form);
			data.append('detail_reg', this.detail_reg());
			data.append('id_result', $('#id_result').val());
			data.append('id_form', $('#id_form').val());
			data.append('allowed_action', $('#allowed_action').val());
			axios.post(BASEURL+'/medical_record/emr/save/', data, {crossdomain: false})
			.then((resp) => {
				if(resp.data['success'] === true){
					alert(resp.data['message'])
					if(typeof EMRdoAfterSubmit !== 'undefined'){
						EMRdoAfterSubmit.init()
					}else{
						window.location.replace(BASEURL)
						this.isSaveClicked = false
					}
					return
				}
			})
		},
		getOtherEMR(){
			if(this.detail_reg() != '0'){
				axios.get(BASEURL+'/medical_record/emr_generator/get_mr/'+this.detail_reg())
				.then((R) => {
					if(R.data !== null){
						D = R.data
						for(i in D){
							t = `<div class="bg-info" style="padding:5px;">
								<a style="color:#FFF" onclick="PopupCenter('`+D[i][1]+`','', 1000, 700)" href="" data-toggle="modal">`+D[i][0]+`</a>
							</div>`
										$('#form-target').prepend(t)
									}
					}
				})
			}
		},
		async getNotesKunjungan(){
			if(($('.select-berkas').length > 0)){
				let dCNotes = await axios.get(BASEURL+'/medical_record/emr/show_all_notes/'+this.detail_reg()+'/0/').then((resp) => resp.data)
				let R = dCNotes.result
				let O = []
				for(i of R){
					if(i.PImg != '')
						O.push({'k': i.Tx,'v': i.PImg})
				}
				if(O.length > 0){
					addOption($('.select-berkas'),O,'v','k')
					$('.select-berkas').on('change',function(){
						if($(this).val() == '')
							$(this).closest('div.form-group').find('div.target-select-berkas').html('')
						else
							$(this).closest('div.form-group').find('div.target-select-berkas').html('<img src="'+ROOTURL+$(this).val()+'"/>')
					})
				}
			}
			return
		},
		initFormForPreview(){
			let data = new FormData();
			data.append('kode', this.kode());
			data.append('versi', $('#previewVersion').val());
			axios.post(BASEURL+'/medical_record/emr/load_form_preview/', data, {crossdomain: false})
			.then(async (resp) => {
					$('main#form-target').html(resp.data['respon'][0][0]);
					this.id_form = resp.data['respon'][0][1]
					await this.getNotesKunjungan()
					if(typeof EMRFormInitiated !== 'undefined')
						EMRFormInitiated.act()
					if(typeof EMRFormFilled !== 'undefined')
						EMRFormFilled.init()
					return
			})
			return
		}
	}
})
</script>