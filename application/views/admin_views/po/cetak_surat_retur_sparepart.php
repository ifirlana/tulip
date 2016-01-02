<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cetak Surat Retur</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

</head>

<body>
<table width="100%" align="center" >
	<tr class="detail2">
   	  <td colspan="2" align="center">
        <table width="100%" align="center">
        <tr class="detail">
          <td  rowspan="5" colspan="2" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" width="120" height="50"/>&nbsp;</td>
          <td  class="detail2"><?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td ><a href="javascript:window.print()" onclick="location.href='../sretur';"><img src="<?php echo base_url();?>/images/print.jpg" width="25" height="25"/></a> <a href="<?php echo base_url();?>po/cetak_surat_retur_sparepart_excel/<?php echo $id;?>">EXCEL</a></td>
        </tr>
		  <tr  class="detail3">
            <td width="30%" colspan="2"> Cabang&nbsp;&nbsp;: <?php echo $default[0]->strnama_cabang?></td>
            <td >&nbsp;</td>
        </tr>
        <tr  class="detail3">
            <td colspan="2"> Week&nbsp;&nbsp;: <?php echo $default[0]->intid_week?>
            <td>&nbsp;</td>
        </tr>
        <tr  class="detail3">
            <td colspan="3">Unit : &nbsp;<?php echo $default[0]->nama_unit?></td>
        </tr>
        <tr  class="detail3">
            <td colspan="3">Dealer : &nbsp;<?php echo $default[0]->nama_dealer?></td>
        </tr>
        <tr  class="detail">
            <td colspan="3" align="center"><?php if(isset($judul)){echo $judul;}else{echo "<h3>Tanda Terima Retur Garansi</h3>";}?> </td>
        </tr>
        <tr >
            <td colspan="2" >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr align="left"  class="detail">
            <td colspan="3"  class="detail2">
                NO SRSP: <?php echo $default[0]->no_srsp?></td>
          <td>&nbsp;</td>
        </tr>
         <?php if(isset($surat_keluar)):?>
        <tr align="left" class="detail">
            <td colspan="3" class="detail2">No STTB : <?php echo $maxId;?>/<?php echo $default[0]->intid_retur_sparepart?>/ <?php echo $week[0]->intid_week;?>/STTB/<?php echo date('m')?>/<?php echo date('Y')?></td>
          <td>&nbsp;</td>
        </tr>
        <?php endif;?>
    </table>
    </td>
    <tr>
    	<td colspan="3" align="center">
        	<table width="100%" border="1" align="center"class="detail">
				<tr class="detail2">
				  <th rowspan="2" width="45">NO </th>
                  <th rowspan="2" width="453">NAMA BARANG</th>
				  <th rowspan="2">PCS</th>
				  <th rowspan="2" width="209">KET</th>
                </tr>
               <tr>
                </tr>
                <?php
				$i=1;
                $reg_pcs = 0;
				$reg_set = 0;
				foreach($default as  $d):
                   
                    ?>
                <tr>
                  <td  align="center" class="detail3"><h3><?php echo $i;$i++; ?></h3></td>
                  <td width="60%" align="left" class="detail3"><?php echo $d->strnama?></td>
                  <td align="center" class="detail3"><?php  echo $d->qty; ?></td>
                  <td  width="20%"  align="left" class="detail3"><h3><?php echo $d->ket?></h3></td>
              </tr>
                <?php 
					$reg_pcs = $reg_pcs + $d->qty;
				
				endforeach;?>


                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                
                <tr class="detail2">
                	<td colspan="2" align="right" class="detail3">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center" class="detail3"><?php echo $reg_pcs; ?></td>
                  <td>&nbsp;</td>
                </tr> 
      </table>      </td>
    </tr>

    <tr>
	<td colspan="3" align="left">&nbsp;</td>
  	</tr>
   
                <tr>
                	<td colspan="3" align="center">&nbsp;
              <table width="100%" align="center">
  				<tr class="detail">
                	<td  colspan="4" align="center" class="detail4">KONSUMEN</td>
       			  <td  colspan="4" align="center">&nbsp;</td>
       			  <td  colspan="4" align="center" class="detail4">ADM. GUDANG</td>
                </tr>
                <tr>
                	<td  colspan="4" align="right">&nbsp;</td>
                    <td  colspan="4" align="right">&nbsp;</td>
                  <td  colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
               		 <td  colspan="4" align="right">&nbsp;</td>
                	 <td  colspan="4" align="right">&nbsp;</td>
               	  <td  colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="4" align="center">(....................)</td>
                  <td colspan="4" align="center">&nbsp;</td>
                  <td  colspan="4" align="center">(....................)</td>
                </tr>
                  </table>                  </td>
                </tr>
    
</table>
</body>
</html>