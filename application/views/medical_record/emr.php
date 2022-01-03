<div class="box-content" id="app">
	<?if(!empty($detail_reg)){?>
	<table class="table table-bordered">
    <tr>
    	<td colspan="4" style="background-color: #c1c1c1"><b>Identitas Pasien</b></td>
	</tr>
	<tr>
    	<td><?= '['.$K['no_rm'].'] '.$K['nama'].' ('.$K['jenis_kelamin'].') '.display_date($K['tanggal_lahir'])?></td>
    	</tr>
		<tr>
			<td><?= $K['nama_poli'].', register tgl '.display_date($K['tanggal'])?></td>
		</tr>	
    </table>
	<?}?>
	<main class="main" id="form-target">
	</main>
	<input type="hidden" id="kode" value="<?= $kode?>">
	<input type="hidden" id="id_result" :value="id_result">
	<input type="hidden" id="id_form" :value="id_form">
	<input type="hidden" id="detail_reg" value="<?= $detail_reg?>">
	<input type="hidden" id="previewVersion" value="<?= $previewVersion?>">
	<input type="hidden" id="alreadyDefinedId" value="<?= $alreadyDefinedId?>">
	<input type="hidden" id="allowed_action" :value="allowed_action">
	<div class="form-group"><div class="col-sm-1"><button @click.prevent="saveMR()" class="btn btn-primary" v-bind:class="{ disabled: isSaveClicked }">Simpan</button></div></div>
</div>