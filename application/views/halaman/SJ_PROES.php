<body>
<ul>
<li>NO Surat Jalan : <?php echo $no_SJ;?></li>
</ul>
<table border="1" width="100%">
<tr>
	<th>No.</th>
	<th width="40%">Nama Barang</th>
	<th width="5%">Quantity</th>
	<th width="15%">Keterangan</th>
</tr>
<?php
	$i = 0;
	foreach($query->result() as $row){
		echo "<tr>
			<td></td>
			<td><input type='text' name='namaBarang[".$i."]' value='".$row->strnama."' size='50' disabled /></td>
			<td><input type='text' name='quantity[".$i."]' value='".$row->quantity."' size='2' /></td>
			<td><input type='text' name='keterangan[".$i."]' value='".$row->keterangan."' size='10' /></td>
		</tr><div id='result'></div>
		";
		$i++;
		}
?>
</table>
<div class="temp_data"></div>
<div style="width:100%;margin:20px;">
	<input type="text" name="namaBarang" id="search" value="" size="50" />
    <input type="button" id="btn_tambah" name="btnBarang" value="Tambah Barang" />
</div>
<div class="input-submit"></div>
</body>
</html>