<table border="1" cellpadding='5' cellspacing='0' width="100%" style="background-color:#FFF;">
    <tr>
    	<th>NO</th>
		<th>WEEK</th>
    	<th>SURAT JALAN</th>
    	<th>ACTION</th>
    </tr>
    <?php 
		$no = 1;
		foreach($query->result() as $rok){
			echo "<tr>
			<td>".$no++."</td>";
			echo "<td align='center'>".$rok->week."</td>";
			echo "<td align='center'><a href='".base_url()."POCO/GET_SJ/?no_sj=".$rok->no_sj."&no_spkb=".$rok->no_spkb."'>".$rok->no_sj."</a></td>";
			echo "<td align='center'>";					
			if(empty($rok->status) and $rok->status == ""){
				
				echo "<a href='".base_url()."POCO/sj_accept/?no=".$rok->no_sj."' style='color:green;'>Terima</a> |";
				echo "<a href='".base_url()."POCO/komplain_menu/?no=".$rok->no_sj."' style='color:red;'>Komplain</a>";
				}
				elseif($rok->status == 1){
					
					//echo "<a href='".base_url()."POCO/sj_accept/?no=".$rok->no_sj."' style='color:green;'>Terima</a> |";
					echo "Sudah di perbarui";
					}else{
						/*<a href='".base_url()."POCO/sj_accept/?no=".$rok->no_sj."' style='color:green;'>Terima</a> |";
						//echo "<td align='center'>Terima |";
						*/
						echo "Sedang di Proses";
						}
			echo "</td></tr>";
		}
		foreach($query2->result() as $rol){
			echo "<tr>
			<td>".$no++."</td>";
			echo "<td align='center'>".$rol->week."</td>";
			echo "<td align='center'><a href='".base_url()."POCO/GET_SJ2/?no_sj=".$rol->no_sj."&no_sttb=".$rol->no_sttb."'>".$rol->no_sj."</a></td>";
			echo "<td align='center'><a href='".base_url()."POCO/sj_sttb_accept/?no=".$rol->no_sj."' style='color:green;'>Terima</a></td>";
			echo "</tr>";
		}
		foreach($query3->result() as $rok){
			echo "<tr>
			<td>".$no++."</td>";
			echo "<td align='center'>".$rok->week."</td>";
			echo "<td align='center'><a href='".base_url()."POCO/GET_SJ3/?no_sj=".$rok->no_sj_sparepart."&no_sttb=".$rok->no_sttb."'>".$rok->no_sj_sparepart."</a></td>";
			echo "<td align='center'>";
			if(empty($rok->status) and $rok->status == ""){
				
				#echo "<a href='".base_url()."sparepart_garansi/komplain_menu/?no=".$rok->no_sj_sparepart."' style='color:red;'>Komplain</a>";
				echo "<a href='".base_url()."POCO/sj_accept_sparepart/?no=".$rok->no_sj_sparepart."&week=".$intid_week."'>Terima</a> | ";
				echo "<a href='".base_url()."sparepart_garansi/komplain_menu/?no=".$rok->no_sj_sparepart."' style='color:red;'>Komplain</a>";
				}
				elseif($rok->status == 1){
					
					echo "Sudah di perbarui";
					}else{
						echo "Sedang di Proses";
						}
			echo "</td>";
			echo "</tr>";
		}
		?>
        </table>