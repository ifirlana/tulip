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
header("Content-Disposition: attachment; filename=Lap_Stock_Cabang.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<table width="1300" align="center">
<tr>
<td align="center">
<table width="1300" height="165" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
          <td width="41">&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        <tr>
            
        </tr>
        <tr align="center" class="judul">
            <td colspan="9">
LAPORAN STOCK CABANG <?php echo $cabang;?></td>
            <td>&nbsp;</td>
        </tr>
                
        <tr align="center" class="detail">
          <td colspan="9">WEEK <?php echo $intid_week;?></td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
    <tr>
    	<td align="center">
<table width="1300" height="165" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
                            <thead>
                                <tr   class="data" align="center" >
                                  <th width="20" rowspan="2">Kode Barang</th>
                                  <th width="49" rowspan="2">Nama Barang</th>
                                  <th colspan="2">Stok Awal</th>
                                  <th colspan="2">Masuk</th>
                                  <th colspan="2" >Keluar</th>
								  <th colspan="2" >Sisa</th>
								  <th colspan="2" >Hutang</th>
                                </tr>
                                <tr   class="data" align="center" >
                                    <th width="22" >Pcs</th>
                                    <th width="23">Set</th>
                                    <th width="23">Pcs</th>
                                    <th width="23" >Set</th>
                                  <th width="28">Pcs</th>
                                  <th width="29" >Set</th>
                                  <th width="28">Pcs</th>
                                  <th width="29" >Set</th>
                                    <th width="22" >Pcs</th>
                                    <th width="23" >Set</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($query as $row){
							//perhitungan stock awal
								if($row->intid_jsatuan == 2){
									if($row->pcs_fisik != null){
										$temp = $row->pcs_fisik+ $row->jum_barang_masuk_before - $row->jum_barang_keluar_before - $row->jum_barang_keluar_hadiah_before;
									}else{
										$temp = 0;
									}
									if($row->set_fisik != null){
										$temp1 = $row->set_fisik;
									 }else{
										$temp1 = 0;
									 }
								}else{
									if($row->pcs_fisik != null){
										$temp = $row->pcs_fisik;
									}else{
										$temp = 0;
									}
									if($row->set_fisik != null){
										$temp1 = $row->set_fisik+ $row->jum_barang_masuk_before - $row->jum_barang_keluar_before - $row->jum_barang_keluar_hadiah_before;
									 }else{
										$temp1 = 0;
									 }
									}
								//barang masuk
								if($row->jum_barang_masuk_after == ""){
										$temp2 = 0;
									}else{
										$temp2 = $row->jum_barang_masuk_after;
										}		
								//dari barang keluar hadiah
								if($row->jum_barang_keluar_hadiah_after == ""){
										$temp6 = 0;
									}else{
										$temp6 = $row->jum_barang_keluar_hadiah_after;
										}
								//barang keluar
								if($row->jum_barang_keluar_after == ""){
										$temp3 = 0;
									}else{
										$temp3 = $row->jum_barang_keluar_after + $temp6;
										}
								//mencari sisa atau lebih
								if($row->intid_jsatuan == 2){
									$minus =  $temp + $temp2	- $temp3;		
								}else{
									$minus =  $temp1 + $temp2	- $temp3;	
								}
								if($minus < 0){
									$temp5 =  $minus * (-1);
									//pengecekan sisa
									if($row->intid_jsatuan == 2){
											$temp4		= 0;
											$temp4_	=	$temp1;
										}else{
											$temp4		= $temp;
											$temp4_	= 0;
										}
								}else{
									$temp5 = 0;
									//pengecekan sisa
									if($row->intid_jsatuan == 2){
											$temp4		= $minus;
											$temp4_	=	$temp1;
										}else{
											$temp4		= $temp;
											$temp4_	= $minus;
										}
								}
								
								if($minus < 0){
									echo "<tr style='background:#ff3019;'>";
								}elseif($minus == 0){
									echo "<tr style='background:#eaefb5;'>";
								}else{
									echo "<tr style='background:#a9db80;'>";
								}
								echo "<td align='left'>".$row->intid_barang."</td>";
								echo "<td>".$row->strnama."</td>";
								echo "<td>".$temp."</td>";
								echo "<td>".$temp1."</td>";
								if($row->intid_jsatuan == 2){
									echo "<td>".$temp2."</td>";
									echo "<td>0</td>";
								}else{
									echo "<td>0</td>";
									echo "<td>".$temp2."</td>";
									}
								if($row->intid_jsatuan == 2){
									echo "<td>".$temp3."</td>";
									echo "<td>0</td>";
								}else{
									echo "<td>0</td>";
									echo "<td>".$temp3."</td>";
									}
									echo "<td>".$temp4."</td>";
									echo "<td>".$temp4_."</td>";
								if($row->intid_jsatuan == 2){
									echo "<td>".$temp5."</td>";
									echo "<td>0</td>";
								}else{
									echo "<td>0</td>";
									echo "<td>".$temp5."</td>";
									}
									
									/*
								if($row->intid_jsatuan == 2 and $minus >= 0){
									echo "<td>".$temp4."</td>";
									echo "<td>0</td>";
									echo "<td>0</td>";
									echo "<td>0</td>";
									
								}elseif($row->intid_jsatuan == 1 and $minus >=0){
									echo "<td>0</td>";
									echo "<td>".$temp4."</td>";
									echo "<td>0</td>";
									echo "<td>0</td>";									
								}elseif($row->intid_jsatuan == 2 and $minus < 0){
									echo "<td>0</td>";
									echo "<td>0</td>";									
									echo "<td>".$temp4."</td>";
									echo "<td>0</td>";
								}else{
									echo "<td>0</td>";
									echo "<td>0</td>";									
									echo "<td>0</td>";
									echo "<td>".$temp4."</td>";
								}*/
								
								echo "</tr>";
								}?>
                            </tbody>
                        </table>
                        </td>
    </tr>
</table>
</body>
</html>