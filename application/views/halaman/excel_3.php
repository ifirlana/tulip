<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=penjualan_mingguan.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<table width="1500" align="center">
<tr>
   	  <td width="1309" align="center">
        <table width="1500" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='laporan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        
        
        <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr align="center">        </tr>
        <tr align="center">        </tr>
        <tr align="center" class="judul">
          <td colspan="2">LAPORAN DEALER BARU</td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="2">WEEK <?php echo $default[0]->intid_week;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="2">PERIODE TGL ( <?php echo date('d-m-Y', strtotime($default[0]->datestart))?> - <?php echo date('d-m-Y', strtotime($default[0]->dateend))?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
  <tr>
    	<td align="center">
       	  <table width="1422" border="3" align="center"  class="detail">
			<tr class="detail2">
			  <th width="102">TGL</th> 
			  <th width="122">NO NOTA</th>
			  <th width="122">ID DEALER</th>
			  <th width="252">NAMA DEALER</th>
			  <th width="252">NAMA CABANG</th>
              <th width="237">UPLINE</th>
              <th width="122">UNIT</th>
              <th width="302">ITEM</th>
              <th width="79">QTY</th>
              <th width="150">HARGA</th>
			</tr>
                <?php
				 $totalqty=0;
				 $totalharga=0;
                 foreach($default as  $d):
                	if ($d->intid_wilayah==1){
                            $harga = $d->intharga_jawa;
                        }else {
                                $harga = $d->intharga_luarjawa;
                        }
				?>
                <tr class="detail2">
                  <td align="center"><?php echo date('d-m-Y', strtotime($d->datetgl))?></td>
                  <td align="center"><?php echo $d->intno_nota?></td>
                  <td align="center"><?php echo $d->intid_dealer?></td>
                  <td align="left"><?php echo $d->strnama_dealer?></td>
                  <td align="left"><?php echo $d->strnama_cabang?></td>
                  <td align="left"><?php echo $d->strnama_upline?></td>
                  <td align="center"><?php echo $d->strnama_unit?></td>
                  <td align="left"><?php echo $d->strnama?></td>
                  <td align="center"><?php echo $d->intquantity?></td>
                  <td align="center"><?php echo $harga;?></td>
              </tr>
                <?php 
				 $totalqty = $totalqty + $d->intquantity;
				 $totalharga = $totalharga + $harga;
				 endforeach;?>
               <tr>
                 <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
               </tr>
               <tr class="detail2">
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>GRAND TOTAL</td>
                  <td align="center"><?php echo $totalqty;?></td>
                  <td align="center"><?php echo $totalharga;?></td>
                </tr>
    </table>      </td>
    </tr>
</table>
</body>
</html>