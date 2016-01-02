<?php $this->load->helper('HTML'); 
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<script language="javascript">
$(document).ready( function() {
		
		$('#dialog_peringatan').dialog({
		autoOpen: false,
		bgiFrame: true,
		draggable: false,
		sizeable: false
	});
    
});

function buat_surat(){
		var cek_box = $('#form_entry :checked').length;
		var intid_po = $('#intid_po').val();
		var no_spkb = $('#no_spkb').val();
		if (cek_box <= 0 ) {
			
		
			
			info = '<STRONG>Maaf... Anda Belum Memilih barang ada atau tidak !</STRONG>';
			$('#dialog_peringatan').text('').append(info).dialog('option','buttons',{
				'Keluar':function() {
				$(this).dialog('close');
				}
			}).dialog('open').css('color','red');
		}else{
			
			$('#form_entry').ajaxSubmit({
							url:'<?php echo base_url(); ?>po/update_stat_brg',
							type:'POST',
							success: function(data) {
								location.href = '<?php echo base_url(); ?>po/cetak_sj/' + intid_po;
							}
						});
			}


}
</script>
<div id="dialog_peringatan" title="PERINGATAN"></div>
<form id="form_entry">
<table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
    <tr align="center" class="" bgcolor="#CCCCCC">
        <th rowspan="2">&nbsp;</th>
        <th rowspan="2">Nama Barang</th>
        <th colspan="2">Reguler</th>
        <th colspan="2">Free</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr align="center" class="" bgcolor="#CCCCCC">
    	<th>Pcs</th>
        <th>Set</th>
        <th>Pcs</th>
        <th>Set</th>
    </tr>
    <?php foreach($po as $v):?>
    <tr>
        <td><input type="checkbox" name="sj[]" value="<?php echo $v->intid_detail_po?>" /><input type="text" name="no_spkb" id="no_spkb" value="<?php echo  $v->no_spkb?>" /></td>
        <td align="left"><?php echo $v->strnama?><input type="text" name="no_spkb" value="<?php echo  $v->no_spkb?>" /></td>
        <td align="center"><?php echo $v->reg_pcs?></td>
        <td align="center"><?php echo $v->reg_set?></td>
        <td align="center"><?php echo $v->free_pcs?></td>
        <td align="center"><?php echo $v->free_set?></td>
        <td align="left"><?php echo $v->ket?></td>
     </tr>
    <?php endforeach;?>
</table>
<br />
<p align="center">
<input type="hidden" name="intid_po" id="intid_po" value="<?php echo $po[0]->intid_po?>" />
<input type="button" onclick="buat_surat()" value="Cetak Surat Jalan" />
</p>
</form>
