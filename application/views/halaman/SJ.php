<body>
<table border="1" width="100%" style="font:Verdana, Geneva, sans-serif; font-size:14px;">
<tr>
	<th>Waktu</th>
    <th>Cabang</th>
    <th>Surat Perintah Keluar Barang</th>
    <th>Perintah Cetak Sj</th>
</tr>
	<?php
    	foreach($query->result() as $row){
			echo "<tr>";
			echo "<td>".$row->waktu."</td>
				<td>".$row->strnama_cabang	."</td>
				<td> <a href='".base_url()."POCO/GET_SPKB/?no=$row->no_spkb' />".$row->no_spkb."</a></td>
				<td align='center'>VIEW || <a href='".base_url()."POCO/Proses_SJ/?no=$row->no_spkb'>CETAK</a> </td>";
			echo "</tr>";
			}
	?>
   </table>
</body>
</html>