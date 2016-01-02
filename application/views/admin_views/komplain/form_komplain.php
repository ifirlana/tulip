<?php 
	//added 2014 - 03 - 27
	//halaman ini digunakan untuk menandai form komplain yang akan dimasukan kedalam form_komplainanan
	
	$hasilQuery = $query;
	$hasilSuratJalan = $no_sj;
?>
<h1>Nomor Surat Jalan : <?php echo $no_sj; ?></h1>
<form method="POST" action="<?php echo base_url();?>POCO/terima_sj/">
<input type="hidden" name="no" value="<?php echo $no_sj; ?>"/>
<table width='100%' cellspacing='0' border='1' cellpadding = '3'>
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Barang</th>
			<th>Jumlah</th>
			<th>Jumlah Diterima</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;
			$count = 0;
			foreach($hasilQuery->result() as $row){
				echo "<tr><td>".$i."</td><td>".$row->strnama."</td><td>".$row->quantity."</td><td><input type='hidden' name='intid_barang[".$count."]' value='".$row->intid_barang."' /><input type='text' name='quantity[".$count."]' size='2' maxlength='3' value='".$row->quantity."' /><input type='hidden' name='asli[".$count."]' size='2' maxlength='3' value='".$row->quantity."' /></td><td><input type='text' name='keterangan[".$count."]' size='20' maxlength='255' value='' /></td></tr>";
				$i++;
				$count++;
			}
		?>
	</tbody>
	<tr>
		<td>Keterangan Tambahan</td>
		<td colspan="4"><textarea name="mainKeterangan" rows="4" cols="50"></textarea></td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
		<td><input type="submit" value="Submit" /></td>
	</tr>
</table>
</form>