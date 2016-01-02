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
header("Content-Disposition: attachment; filename=penjualan_arisanmingguan.xls");
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
        <tr align="center">
            
        </tr>
        <tr align="center">
         
        </tr>
        <tr align="center" class="judul">
          <td colspan="2">LAPORAN PENJUALAN ALL CABANG</td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="judul"> 
          <td colspan="2">ARISAN</td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="detail">
          <td colspan="2">WEEK <?php echo $default[0]->intid_week?> ( <?php echo $default[0]->datestart;?>  - <?php echo $default[0]->dateend;?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
  <tr>
    	<td align="center">
       	  <table width="100%" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
       <tr  align="center">
           <th rowspan="2">No</th>
           <th rowspan="2">Cabang</th>
           <th rowspan="2">Id Dealer</th>
           <th rowspan="2">Nama Dealer</th>
           <th rowspan="2">Upline</th>
            <th rowspan="2">Unit</th>
           <!-- <th rowspan="2">Cicilan ke-</th>-->
            <th colspan="3">Harga</th>
            <th rowspan="2">Komisi</th>
            <th rowspan="2">Netto</th>
            <th rowspan="2">Omset</th>
            <th rowspan="2">PV</th>
        </tr>
        <tr  align="center">
        <td>Retail</td>
        <td>DP</td>
        <td>Angsuran</td>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
        if(!empty($default)){
          	$i=1;
			foreach($default as $m) :
			if ($m->intid_wilayah==1){
                //$harga = $m->intharga_jawa;
				$cicil = $m->intcicilan_jawa;
				$um = $m->intum_jawa;
            }else {
                //$harga = $m->inthrga_luarjawa;
				$cicil = $m->intcicilan_luarjawa;
				$um = $m->intum_luarjawa;
            }
          
		?>
     	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
            <td align='left'><?php echo $m->strnama_cabang; ?></td>
            <td align='left'><?php echo $m->intid_dealer; ?></td>
            <td align='left'><?php echo $m->strnama_dealer; ?></td>
            <td align='left'><?php echo $m->strnama_upline; ?></td>
            <td align='left'><?php echo $m->strnama_unit; ?></td>
            <!--<td align='left'>&nbsp;<?php 
			/*if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1&&$m->c6==1&&$m->c7==1){
			$cicilan="7";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1&&$m->c6==1){
			$cicilan="6";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1){
			$cicilan="5";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1){
			$cicilan="4";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1){
			$cicilan="3";
			}else if($m->c1==1&&$m->c2==1) {
			$cicilan="2";
			}else if($m->c1==1){
			$cicilan="1";
			} else {
			$cicilan="0";
			}
			echo $cicilan;*/ ?></td>-->
            <td align='left'><?php echo $m->retail;?></td>
            <td align='left'><?php echo $um;?></td>
            <td align='left'><?php echo $cicil; ?></td>
          	<td align='right'>
			<?php 
			if ($m->intkomisi10<>0){
				$komisi = $m->intkomisi10;
			} else if ($m->intkomisi20<>0){
				$komisi = $m->intkomisi20;
			} else if (($m->intkomisi10<>0) && ($m->intkomisi20<>0)){
				$komisi = $m->intkomisi10 + $m->intkomisi20;
			} else {
				$komisi = 0;
			}
			
			echo $komisi; ?></td>
            <td align='right'><?php echo $m->inttotal_bayar; ?></td>
            <td align='right'><?php echo $m->inttotal_omset; ?></td>
            <td align='right'><?php echo $m->intpv; ?></td>	
        </tr>
		<?php
        endforeach;
        ?>
        
        <?php
        }else{
        ?>
    <tr>
        <td colspan="11" align="center">
            No Data Display
        </td>
    </tr>
    <?php } ?>

    </tbody>
</table>    </td>
    </tr>
</table>
</body>
</html>