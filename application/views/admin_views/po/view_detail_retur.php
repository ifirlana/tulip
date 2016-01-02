<?php $this->load->helper('HTML'); 
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
   <tr align="center" class="" bgcolor="#CCCCCC">
        <th rowspan="2">Nama Barang</th>
        <th colspan="2">Reguler</th>
        <th rowspan="2">Keterangan</th>
        
    </tr>
    <tr align="center" class="" bgcolor="#CCCCCC">
    	<th>Pcs</th>
        <th>Set</th>
    </tr>
    <?php foreach($po as $v):?>
    <tr>
        <td align="left"><?php echo $v->strnama?></td>
        <td align="center"><?php if ($v->intid_jsatuan==2)  echo $v->qty; else echo 0;?></td>
        <td align="center"><?php if ($v->intid_jsatuan==1)  echo $v->qty; else echo 0;?></td>
        <td align="left"><?php echo $v->ket?></td>
        
    </tr>
    <?php endforeach;?>
    
</table>
