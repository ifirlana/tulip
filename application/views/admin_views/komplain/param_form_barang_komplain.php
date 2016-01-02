<h2>Data Barang Komplain</h2>
<p>
	<form method="GET">
		<table id="data">
		<tr><td>Cabang</td><td><input type="text" id="id_cabang" /></td>
			<td>Week</td><td><select name="intid_week">
                  <option value="">-- Pilih --</option>
                  <?php
                        for($i=0;$i<count($intid_week);$i++)
                        {
                            echo "<option value='$intid_week[$i]'>$intid_week[$i]</option>";
                        }
                    ?>
                </select></td>
			<td>Tahun</td><td><select name="tahun">
				<?php
					foreach($tahun->result() as $row){
					echo "<option value='".$row->inttahun."'>".$row->inttahun."</option>";
				  }
				?>                   
                </select></td>
			<td><input type="submit" value="search" /></td></tr>
		</table>
		<div id= "result"></div>
	</fom>
		<div id= "result_query">
			<?php
				if(isset($query) and $query->num_rows()  > 0){
					echo "<table id='data' style='background:white;' cellpadding='5' width='100%' border='1' cellspacing='0'>";
					echo "<tr><th>No Surat Jalan</th><th>Nomor Nota</th><th>Nama Cabang</th><th>Tanggal</th><th>Action</th></.tr>";
					foreach($query->result() as $row){
						echo "<tr><td>".$row->keterangan."</td><td>".$row->intno_nota."</td><td>".$row->strnama_cabang."</td><td>".$row->datetgl."</td><td><a href='".base_url()."laporan/viewNotaHadiah/".$row->intid_nota."'>view</a></td></tr>";
						}
					echo "</table>";
					}else{
						echo "<h3>No Data</h3>";
						}?>
		</div>
</p>
<script>
	  $(document).ready( function() {
		$("#id_cabang").autocomplete({
						minLength: 2,
						source: 
						function(req, add){
							$.ajax({
								url: "<?php echo base_url(); ?>penjualan/lookup",
								dataType: 'json',
								type: 'POST',
								data: req,
								success:    
								function(data){
									if(data.response =="true"){
										add(data.message);
									}
								},
							});
						},
					select: 
						function(event, ui) {
							$("#result").html(
								"<input type='hidden' id='intid_cabang' name='intid_cabang' value='" + ui.item.id + "' size='30' />"
							);           		
						},		
					});
			});
</script>