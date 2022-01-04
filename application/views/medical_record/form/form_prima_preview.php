<script src="<?= ASSETURL."/js/media/emr/helpers.js?_=".$this->config->item('asset_js_version')?>"></script>
<?

if(isset($_POST['thirdparty'])){
	$rd = array_values($this->trdParty);
	$tr = $_POST['thirdparty'];
	foreach($tr as $v) 
		foreach($rd[$v] as $pth)
			if(preg_match('/.css/',$pth)) echo '<link rel="stylesheet" type="text/css" href="'.ASSETURL.'/'.$pth.'" \>';
			else echo ' <script src="'.ASSETURL.'/'.$pth.'"></script>';
			
}

$form = [];
$i = 0;
foreach ($this->crud_builder->crud as $contains){
	$tips = '<small class="info help-block">'.$contains['small_tips'].'</small>';
	if($contains['input_type'] == 'static'){
		switch($contains['input_tag']){
			case 'img':
				$form[$i] = '<div class="col-sm-14 col-md-offset-2"><img src="'.$contains['input_label'].'" height="300px;" >'.$tips.'</div><hr>';
				break;
			default :
				$form[$i] = '<div class="col-sm-14 col-md-offset-2"><'.$contains['input_tag'].'>'.$contains['input_label'].'</'.$contains['input_tag'].'>'.$tips.'</div><hr>';
				break;
		}
		
	}else{
		$label = '<label for="label" class="col-sm-2 control-label">'.$contains['input_label'].'</label>';
		switch($contains['input_type']){
			case 'select':
				$multiple = (isset($contains['is_multiple']))?'multiple':'';
				$options = [];
				foreach($contains['custom_option'] as $f){
					$options[] = '<option value="'.$f['value'].'">'.$f['value'].'</option>';
				}
				$size = (isset($contains['is_multiple']))?'size="'.count($contains['custom_option']).'"':'';
				$field =  '<div class="col-sm-8"><'.$contains['input_type'].' name="form['.$contains['input_name'].'][]" '.$multiple.' class="form-control" rel="'.$contains['input_name'].'" '.$size.'>'.implode('',$options).'</'.$contains['input_type'].'>'.$tips.'</div>';
				$field .= ($multiple == 'multiple')?'<script type="text/javascript">$(\'[rel="'.$contains['input_name'].'"]\').mousedown(function(e){     e.preventDefault();     var scroll = this.scrollTop;     e.target.selected = !e.target.selected;     setTimeout(function(){this.scrollTop = scroll;}, 0);     $(this).focus(); }).mousemove(function(e){e.preventDefault()});</script>':'';
				break;
			case 'textarea':
				$field =  '<div class="col-sm-8"><'.$contains['input_type'].' name="form['.$contains['input_name'].']" class="form-control" rel="'.$contains['input_name'].'"></'.$contains['input_type'].'>'.$tips.'</div>';
				break;
			case 'berkas':
				$field = '<div class="col-sm-8"><select name="form['.$contains['input_name'].'][]"  class="form-control select-berkas" rel="'.$contains['input_name'].'" ><option value=""></option></select>'.$tips.'</div><br/><div class="col-sm-8 target-select-berkas"></div>';
				break;
			default :
				$field =  '<div class="col-sm-8"><'.$contains['input_type'].' name="form['.$contains['input_name'].']" class="form-control" rel="'.$contains['input_name'].'" value="" />'.$tips.'</div>';
				break;
		}
		$form[$i] = '<div class="form-group">'.$label.$field.'</div>';
	}
	$i+=1;
}?>
<form class="form-horizontal form-preview">
<?= (isset($title))? $title : ''?>
<?= implode('',$form)?>
<div id="addit"></div>
</form>
<script type="text/javascript">
	<?= $_POST['script']?>
</script>
<script type="text/javascript">
console.log('file view di simrs')

<?if (isset($pre)) {?>

//do all state for not save

if(typeof EMRFormInitiated !== 'undefined')
	EMRFormInitiated.act()

if(typeof EMRFormFilled !== 'undefined')
	EMRFormFilled.init()

<?}?>
</script>