<?php $this->load->helper('HTML'); 
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<script language="javascript">
function validasi_form(formData, jqForm, options){
	$('#informasi').dialog('option','width',450);
	$("#informasi").html('');
	var cek = false;
	var triger = $("#triger_detail").val();
	if (triger == 0){
		$("#informasi").append("Please");
		cek = true;
	}else{
		$("#form_opname input").each(function(){
			if ($(this).hasClass('required') || $(this).hasClass('number')){
				val = $(this).val();
				name = $(this).attr('title');
				if (val == ''){
					$("#informasi").append("- <font color='red'><b>"+name+"</b></font> Must Filled<br/>");
					cek = true;
				}
			}
		});
	}	
	
	if (cek){
		$('#informasi').dialog('option','title','Confirm');
		$('#informasi').dialog('option','buttons',{"OK" : function(){ 
			$('#informasi').dialog('close')
		}
		}).dialog('open').css('text-align','left');
		return false;
	}
}

</script>
<form id="form_opname">
<input type="hidden" name="no_po" value="<?php echo $no_po?>" id="no_po" />
<table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
   <tr align="center" class="" bgcolor="#CCCCCC">
        <th rowspan="2">Nama Barang</th>
        <th colspan="2">Reguler</th>
        <th colspan="2">Free</th>
        <th colspan="2">Fisik</th>
        <th rowspan="2">Keterangan</th>
        
    </tr>
    <tr align="center" class="" bgcolor="#CCCCCC">
    	<th>Pcs</th>
        <th>Set</th>
        <th>Pcs</th>
        <th>Set</th>
        <th>Pcs</th>
        <th>Set</th>
    </tr>
    <?php 
	$no=1;
	foreach($po as $v):?>
    <tr>
        <td align="left"><?php echo $v->strnama?></td>
        <td align="center"><?php echo $v->reg_pcs?></td>
        <td align="center"><?php echo $v->reg_set?></td>
        <td align="center"><?php echo $v->free_pcs?></td>
        <td align="center"><?php echo $v->free_set?></td>
        <td align="center"><input style="background-color:#CCC" type="text" name="fisik_pcs[<?php echo $no;?>]"  size="10" title="Fisik Pcs<?php echo $no?>"/></td>
        <td align="center"><input style="background-color:#CCC" type="text" name="fisik_set[<?php echo $no;?>]" size="10" title="Fisik Set<?php echo $no?>" />
        <input type="hidden" name="detail_po[<?php echo $no?>]" id="detail_po[<?php echo $no?>]" value="<?php echo $v->intid_detail_po?>" />
        </td>
        <td align="left"><?php echo $v->ket?></td>
        
    </tr>
    <?php 
	$no++;
	endforeach;?>
    
</table>
<p align="center"><input type="button" name="update" value="cetak" onclick="saving()" /></p>
</form>