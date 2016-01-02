<?php 
	//added 2014 - 03 - 27
	//halaman ini digunakan untuk menandai form komplain yang akan dimasukan kedalam form_komplainanan
	
	$hasilQuery = $query;
	$hasilSuratJalan = $no_sj;
?>
<h1>Nomor Surat Jalan : <?php echo $no_sj; ?></h1>
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
			$keterangan	=	$hasilQuery->result();
			foreach($hasilQuery->result() as $row){
				echo "<tr><td>".$i."</td><td>".$row->strnama."</td><td>".$row->asli."</td><td>".$row->quantity."</td><td>".$row->keterangan_detail."&nbsp;</td></tr>";
				$i++;
				$count++;
			}
		?>
	</tbody>
	<tr>
		<td>Keterangan Tambahan</td>
		<td colspan="4"><?php echo $keterangan[0]->keterangan_utama;?>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
<p><?php if($this->session->userdata('username') == "admin"){echo "Pengumuman : setelah dikroscek Gudang dapat langsung lapor ke inputer untuk di lakukan perubahan surat jalan.";}?></p>