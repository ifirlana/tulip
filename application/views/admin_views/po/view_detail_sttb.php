<?php $this->load->helper('HTML'); 
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
    <tr align="center" class="" bgcolor="#CCCCCC">
        <th>Nama Barang</th>
    	<th>Pcs</th>
        <th>Set</th>
        <th>Keterangan</th>
    </tr>
    <?php foreach($po as $v):?>
    <tr>
        <td align="center"><?php echo $v->strnama?></td>
        <td align="center"><?php echo $v->pcs?></td>
        <td align="center"><?php echo $v->set?></td>
        <td align="center"><?php echo $v->ket?></td>
        
    </tr>
    <?php endforeach;?>
    
</table>
<p align="center"><a href="<?php echo base_url()?>po/cetak_surat_sttb/<?php echo $po[0]->intid_sttb?>" target="_blank">Print</a></p>
