<body>
<div align="right" style="margin-right:80px;"><h3 style="float:right;"></h3></div>
<div style="height:80px;"><img src="<?php echo base_url();?>images/logo.jpg" align="left" /></div>
<?php
$susun = array();
			//susun barang dengan semua jumlah yang ad po-nya
			for($k=0;$k<sizeof($arr);$k++){
					//masukan quantity sesuai dengan intid_barang
						//lakukan pencarian 
						$temp = 0;
						for($i=0;$i<sizeof($susun);$i++){
							if($susun[$i]['intid_barang'] == $arr[$k]['intid_barang']){
								$susun[$i]['quantity'] = $susun[$i]['quantity'] + $arr[$k]['quantity'];
								$susun[$i]['keterangan'] .=  $arr[$k]['keterangan'].", ";
								$temp = 1;
								}
							}
						//jika tidak ditemukan pencarian, masukan sebagai data abaru	
						if($temp == 0){
							$susun[]	= array('intid_barang' => $arr[$k]['intid_barang'],
																		   'strnama' => $arr[$k]['strnama'],
																		   'quantity' => $arr[$k]['quantity'],
																		   'intid_jsatuan' => $arr[$k]['intid_jsatuan'],
																		   'keterangan' => $arr[$k]['keterangan']
																		   );
							}
						
					}		
			//sekarang menampilkan semua data yang disusun
			for($i=0;$i<sizeof($susun);$i++){
				//echo "".$susun[$i]['intid_barang'].", ".$susun[$i]['strnama']." ,".$susun[$i]['quantity']."<br />";
				}	
?>
<div style="float:right; margin-right:60px;"></div>
<form method="post" action="<?php echo base_url()."POCO/Proses_SPKB";?>">
<input type="hidden" name="intid_cabang" value="<?php echo $intid_cabang;?>" />
<table>
<tr><td>TANGGAL </td><td>:</td><td><?php echo date('d-m-Y')?></td></tr>
<tr><td>CABANG</td><td>:</td><td><?php echo strtoupper($strnama_cabang);?></td></tr>
<?php
	for($i=0;$i<sizeof($po);$i++){
		echo "<tr><td>NO. PO</td><td>:</td><td><h3>".$po[$i]."</h3></td></tr>";
		}
?>
</table>
<!-- NO SPKB : <?php //echo $no_SPKB; ?> --><br />
<table width="100%" border="1">
<tr>
	<th rowspan="2">No.</th>
	<th rowspan="2">Nama Barang</th>
	<th colspan="2">JUMLAH</th>
	<th rowspan="2">Keterangan</th>
    </tr>
   <tr>
   		<th>PCS</th>
        <th>SET</th>
   </tr>
    <?php
    $no = 1;
	$pieces = 0;
	$set = 0;
	//sekarang menampilkan semua data yang disusun
	for($i=0;$i<sizeof($susun);$i++){
		echo "<tr>
			<td align='center'>".$no++."</td>
			<td><input type='text' name='namaBarang[".$i."]' value='".$susun[$i]['strnama']."' size='50' disabled /><input type='hidden' name='intidBarang[".$i."]' value='".$susun[$i]['intid_barang']."' /></td>";
		if($susun[$i]['intid_jsatuan'] == 2){
			$pieces = $pieces +$susun[$i]['quantity'];
			echo "<td align='center'><input type='text' name='quantity[".$i."]' value='".$susun[$i]['quantity']."' size='3' readonly /></td><td align='center'>0</td>";
		}else{
			$set = $set + $susun[$i]['quantity'];
			echo "<td align='center'>0</td><td align='center'><input type='text' name='quantity[".$i."]' value='".$susun[$i]['quantity']."' size='3' readonly /></td>";
			}
		echo "<td><input type='text' name='keterangan[".$i."]' value='".$susun[$i]['keterangan']."' size='20' readonly /></td>
			</tr>";
		}	
?>
<tr>
	<td align="right" colspan="2">JUMLAH</td>
	<td align="center"><?php echo $pieces;?></td>
	<td align="center"><?php echo $set;?></td>
	<td></td>
</tr>
</table>
<input type="hidden" name="SPKB" value="<?php echo $no_SPKB; ?>" />
<input type="hidden" name="intid_week" value="<?php echo $intid_week; ?>" />
<?php 
echo $input_type;
?>
<br /><div align="right">
<input type="submit" name="submit" value="Cetak SPKB"/>
</div>
</form>
</body>
</html>