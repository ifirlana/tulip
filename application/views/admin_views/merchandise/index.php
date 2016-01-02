<h2>Status PO Merchandise</h2>
<table style='width:100%;background:white;' border = '1' cellspacing='0' cellpadding='1'> 
	<tr><th>Nama Cabang</th><th>Nomor PO</th><th>Nomor SJ</th></tr>
	<?php 
		if(isset($query) and $query->num_rows() > 0 ){
			
			foreach($query->result() as $row){
				if($row->no_spkb != "" and !empty($row->no_spkb)){
					echo "<tr><td>".$row->strnama_cabang."</td><td><a href='".base_url()."POCO/get_PO/?no=".$row->no_po."'>".$row->no_po."</a></td><td><a href='".base_url()."POCO/GET_SJ/?no_sj=".$row->no_sj."&no_spkb=".$row->no_spkb."'>".$row->no_sj."</td></tr>";
					}
				}
			}else{
				
				echo "<tr><th colspan='2'>Tidak ada PO Merchandise</th></tr>";
				}
	?>
	</table>