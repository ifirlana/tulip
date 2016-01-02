<style>
	.show-table-member-tebus-range
	{
		width: 100%;
		margin: auto;
		padding:0;
		display: table;
		clear:both;
		margin:20px auto 20px auto;
	}
	.show-table-member-tebus-left
	{
		border: 1px solid blue;
		width:18%;
		float:left;
		background: white;
		display: table-cell;
		padding:0.5%;
	}
</style>
<h2>Table Pengejaran Rekrut</h2>
<?php
	if(isset($query) and !empty($query))
	{
		//echo $date_start_member;
		$date_end_member = $query[0]->tanggal_akhir;
		$select	= "select datediff('".$date_end_member."','".$date_start_member."') datedif;";
		$db 		= $this->db->query($select)->result();	
		echo "<div class='show-table-member-tebus-range'>";
		for($i=0;$i<$db[0]->datedif;$i++)
		{
			$datenow	=	date('Y-m-d', strtotime($date_start_member . ' + '.$i.' day'));
			
			$select = "select count(*) total from member where member.strkode_upline ='".$strkode_dealer."' and datetanggal = '".$datenow."';";
			
			$datenow = date('d-m-Y, D',strtotime($datenow));
			//echo $select;
			$query = $this->db->query($select)->result();
			echo "<div class='show-table-member-tebus-left'><div><small>".$datenow."</small></div><div><h3>".$query[0]->total."</h3></div> </div>";
		}
		echo "</div>";
	}else
	{
		echo "TIDAK ADA DATA REKRUT";
	}
?>