<div id='data-load'>
<?php

	if(isset($query) and $query->num_rows() > 0 ){
		echo "<table width='100%' class='table'>
					<tr><th>week</th><th>tahun</th><th>Omset</th></tr>";
		foreach($query->result() as $row){
			echo "<tr>";
				echo "<td>".$row->intid_week."</td>";
				echo "<td>".$row->tahun."</td>";
			echo "<td>".$row->inttotal_omset."</td>";
			echo "</tr>";
			}
		}else{
		
		echo "DATA TIDAK ADA";
		}
?>
</div>