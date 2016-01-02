<?php
	if(isset($query) and $query->num_rows() > 0){
		?>
		<h2>Table Komplain Surat Jalan</h2>
		<table border="1" cellspacing="0" style="background:white;width:100%;">
		<tr><th>No</th><th>Time</th><th>Cabang</th><th>&nbsp;</th></tr>
			<?php
			
			foreach($query->result() as $row){
				
				if($row->status == 0){
					
					echo "<tr><td>".$row->no."</td><td>".date("D, d-M-Y H:i:s",strtotime($row->date_added))."</td><td>".$row->strnama_cabang."</td><td><a href='".base_url()."poco/view_komplain_sj/?no=".$row->no."'>view</a></td><tr>";
					}
				}
			?>
		</table>
<?php
		}
		else{
			?>
			<h2>Tidak Ada Komplain</h2>
			<?php }
?>