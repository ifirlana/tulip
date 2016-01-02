 <?php 
 /*
					if(isset($query) and $query->num_rows() > 0){
						echo "Pre Order Cabang<br />";
						echo "<table style='width:100%;background:white;' border = '1' cellspacing='0' cellpadding='5'>";
						echo "<tr><th>Nomor Pre Order (PO)</th><th>Status Proses</th></tr>";
						foreach($query->result() as $row){
							echo "<tr><td>".$row->no_po."</td>";
							
							if($row->no_spkb != "" and $row->no_sj == ""){
								echo "<td>sedang di buat spkb</td>";
								}
								else if($row->no_spkb != "" and $row->no_sj != ""){
									echo "<td>sedang on the way</td>";
									}else{
										echo "<td>Sedang di proses gudang</td>";
										}
										
							echo "</tr>";
						}
						echo "</table>";
					}else{
						echo "<p>Belum ada Notifikasi PreOrder</p>";
					}
						echo "<p><small>HUBUNGI KANTOR PUSAT JIKA TERJADI KEKELIRUAN</small></p>";
				*/
				?>
<?php
	$hasil = $query->result();
?>
<h2>Status PO</h2>
<table style='width:100%;background:white;' border = '1' cellspacing='0' cellpadding='1'> 
<?php 
	if($this->session->userdata('username') == "admin"){ 
		
		echo "<tr><th>Nomor PO</th><th>WEEK</th><th>TAHUN</th><th>Cabang</th><th>BS</th><th>STATUS</th></tr>";
		
		}
		else{
	?>
	
		<tr><th>Surat PO</th><th>Surat SPKB</th><th>Surat SJ</th><th>WEEK</th><th>TAHUN</th><th>STATUS</th></tr>
	<?php
	}?>
 <?php
 if($query->num_rows() > 0){ 
	foreach($hasil as $row){
	
		if($this->session->userdata('username') == "admin"){ 
			
					echo "<tr><td>".$row->no_po."&nbsp;</td>
						<td>".$row->intid_week."&nbsp;</td>
						<td>".$row->tahun."&nbsp;</td>";
					echo "<td>".$row->strnama_cabang."</td><td>".$row->strnama."</td>";
					echo "<td class='danger' colspan='2'>Sedang proses Acc Branch Support (BS).</td></tr>";

					}
			else{
				if($row->is_verified != 2){
					echo "<tr>
						<td>".$row->no_po."&nbsp;</td>
						<td>".$row->no_spkb."&nbsp;</td>
						<td>".$row->no_sj."&nbsp;</td> 
						<td>".$row->intid_week."&nbsp;</td>
						<td>".$row->tahun."&nbsp;</td>";
					
					//jika sudah terbuat spkb
					if(!empty($row->no_spkb)){
						
						//jika sudah dibuat surat jalan
						if(!empty($row->no_sj)){
							echo "<td class='info'>Sedang di Perjalanan.</td>";
						}
						//jika bukan surat jalan maka
						else{
							echo "<td class='warning'>Sedang diproses Gudang.</td>";
						} 
					}
					//kalau tidak ada
					else{
						if($row->is_verified == 1){
							echo "<td class='info'>Menunggu Respon Gudang.</td>"; 
							}else{
								echo "<td class='danger'>Sedang proses Acc Branch Support (BS).</td>";
								}
						}
					echo "</tr>";
					}
				}
		}
	}
	else{
		echo "<tr class='text-center label-warning'><td colspan='7'> - Belum Punya PO - </td>";
		echo "</tr>";
	}
 ?>
 </table>			