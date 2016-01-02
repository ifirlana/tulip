<body>
<form method='post' action="<?php echo base_url();?>POCO/Proses_SJ">
<ul>
<li>NO Surat Jalan : <?php echo $no_po;?><input type="hidden" size="2" name="no_sj" value="<?php echo $no_po;?>" /><input type="hidden" size="2" name="no_spkb" value="<?php echo $no_spkb;?>" /></li>
</ul>
<table border="1" width="100%">
<tr>
	<th width="3">No.</th>
	<th width="40%">Nama Barang</th>
	<th width="7%">Quantity</th>
	<th width="10%">Quantity Terkirim</th>
	<th width="40%">Keterangan</th>
</tr>
<?php
	$i = 0;
	$no = $i+1; 
	foreach($query->result() as $row){
		echo "<tr>
			<td align='center'>".$no++."<input type='hidden' name='intid[".$i."]' value='".$row->intid_barang."' size='2' />
			</td>
			<td><input type='text' name='namaBarang[".$i."]' value='".$row->strnama."' size='50' disabled /></td>
			<td align='center'>".$row->quantity."</td>
			<td><input type='text' name='quantity[".$i."]' value='".$row->quantity."' size='2' /></td>
			<td><input type='text' name='keterangan[".$i."]' value='".$row->keterangan."' size='50' />
			</td>
		</tr>";
		$i++;
		}
		echo "<tr id='content-list'><td colspan='5' align='right'>
		<input type='submit' name='submit' value='CETAK Surat Jalan' style='margin:10px;' />
		</td></tr>";
?>
</table>
<input type="hidden" id="list-data" value="<?php echo $i;?>"/>
<div class="demo">
	<label for="search">Search: </label>
	<input id="search" name="search_barang" size="50" />
	<input type="button" name="tambah" value=" + " id="btn_tambah" />
	<label id="label_verify" for="verify"></label>
</div><!-- End demo -->
<div class="temp_data"></div>
    <div class="description">
    <p> <small>*</small> Barang terhapus jika quantity di-set menjadi 0 (nol)<small>*</small></p>
    </div><!-- End demo-description -->
</form>
</body>
</html>
