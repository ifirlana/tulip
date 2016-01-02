<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rekap Pengeluaran Barang Mingguan</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=keluar_barang_mingguan_pusat.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<table width="1069" align="center" >
	<tr class="detail2">
   	  <td width="1061" colspan="2" align="center">
        <table width="1016" align="center" >
        <tr class="detail">
          <td width="816" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="107" class="detail2">&nbsp;</td>
     	  <td width="77"><a href="javascript:window.print()" onclick="location.href='../po';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr >
            <td >
          
          <td>&nbsp;</td>
        </tr>
        <tr >
            <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
     
        <tr align="center"class="detail">
          <td colspan="2" > </td>
       </tr>
        <tr align="left" class="detail">
          <td colspan="4" class="detail2"><h2 class="title">REKAP PENGELUARAN BARANG MINGGUAN PUSAT</h2></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="left" class="detail">
          <td colspan="4" class="detail2" align="center"><strong>Week <?php echo $week;?></strong></td>
          <td>&nbsp;</td>
        </tr>
    </table>
    </td>
    <tr>
    	<td colspan="2" align="center">
        	<table width="1069" border="1" align="center"class="detail">
			    	
             <tr class="detail2" >
			  <th rowspan="2" width="45">No</th>
                	
              <th rowspan="2" width="453">Nama Barang</th>
             </tr>
               <tr>
               
                <th width="54">Pcs</th>
                <th>Set</th>
               </tr> <tr>
                  <td>&nbsp;</td>
                	
                  <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
				$i=1;
                $reg_pcs = 0;
				$reg_set = 0;
				foreach($default as  $d):
                ?>
                <tr>
                <td align="center" class="detail"><?php echo $i++; ?></td>
                   
                  <td align="left" class="detail"><?php echo $d->strnama?></td>
                  <td align="center" class="detail"><?php if($d->intid_jsatuan == 2) echo $d->intquantity; else echo 0;?></td>
                  <td width="70" align="center" class="detail"><?php if($d->intid_jsatuan == 1) echo $d->intquantity; else echo 0;?></td>
              </tr>
                <?php 
				if ($d->intid_jsatuan == 2){
					$reg_pcs=$reg_pcs + $d->intquantity;
				} else if ($d->intid_jsatuan == 1){
					$reg_set=$reg_set + $d->intquantity;
				}
				endforeach;
				?>

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
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="detail2">
                	<td colspan="2" align="right">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center"><?php echo  $reg_pcs; ?></td>
                     <td align="center"><?php echo  $reg_set; ?></td>
                 </tr> 
      </table>      </td>
    </tr>

    <tr>
<td colspan="2" align="center">&nbsp;</td>
  </tr>
                <tr>
                	<td colspan="2" align="center">&nbsp;
              <table width="1000" align="center">
  				<tr class="detail">
                	<td width="229" colspan="4" align="center">&nbsp;</td>
       			  <td width="229" colspan="4" align="center">&nbsp;</td>
       			  <td width="229" colspan="4" align="center">ADM. GUDANG</td>
                </tr>
                <tr>
                	<td width="229" colspan="4" align="right">&nbsp;</td>
                    <td width="229" colspan="4" align="right">&nbsp;</td>
                  <td width="229" colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
               		 <td width="229" colspan="4" align="right">&nbsp;</td>
                	 <td width="229" colspan="4" align="right">&nbsp;</td>
               	  <td width="229" colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="230" colspan="4" align="center">&nbsp;</td>
                  <td width="230" colspan="4" align="center">&nbsp;</td>
                  <td width="230" colspan="4" align="center">(....................)</td>
                </tr>
                  </table>                  </td>
                </tr>
    
</table>
</body>
</html>