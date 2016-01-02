<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Penjualan Harian</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<?php

if(!isset($filename)){
	$filename = "penjualan_harian".date("DdMYHis").".xls";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$filename);
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
      <table width="100%" align="center" > 
        
      </table>
<table width="100%" align="center">
<tr>
   	  <td align="center">

      <table width="" align="center">
        <tr>
          <td width="" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="">&nbsp;</td>
          <td width=""></td>

        </tr>
        <tr class="detail">
          <td >CABANG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
          <td width="">ALL
              <?php    //echo $default[0]->strnama_cabang?></td>
        </tr>
        <tr class="detail">
          <td >TANGGAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
          <td width="">&nbsp;<?php echo date('d-m-Y', strtotime($date_start))?></td>
        </tr>
        <tr class="detail">
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center"><span class="judul"><strong>LAPORAN PENJUALAN HARIAN</strong></span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="3" ><div align="center" class="judul"></div></td>
        </tr>
      </table>          
</td>
  <tr>
    	<td align="center">
        	<table width="100%" border="1" align="center"  class="detail">
<tr class="detail2">
                	<th>No.</th>
                	<th><strong>JENIS PENJUALAN</strong></th>
              <th><strong>NAMA CABANG</strong></th>
                    <th><strong>OMSET</strong></th>
                    <th><strong>SK</strong></th>
                    <th><strong>LG</strong></th>
                    <th><strong>LL</strong></th>
                    <th><strong>CASH</strong></th>
                    <th><strong>DEBET</strong></th>
                    <th><strong>KREDIT</strong></th>
                    <th><strong>NETTO</strong></th>
			</tr>