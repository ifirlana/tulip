<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<img src="<?php echo base_url().'images/logo.jpg'?>" align="left" />
<div style="display:block; height:80px;" align="right">
	 <a href="javascript:window.print()" onclick="location.href='<?php echo base_url()."po"?>';"><img align="right" src="<?php echo base_url();?>/images/print.jpg"/></a></div>
<br />
<table>
<tr>
	<td>TANGGAL</td><td>:</td><td><?php echo date('d - m - Y, H:i:s',strtotime($query[0]->timeNow)); ?></td></tr>
    <tr>
	<td>CABANG</td><td>:</td><td><?php echo strtoupper($query[0]->strnama_cabang); ?></td></tr>
	<tr>
    <td><h3>NO PO</h3></td><td> :</td><td><h3><b><?php echo $query[0]->no_po; ?></b></h3></td>
    </tr>
</table>
<br  />
<table border="1" width="100%">
<tr>
	<th rowspan="2">NO.</th>
    <th rowspan="2">NAMA BARANG</th>
    <th colspan="2">JUMLAH</th>
    <th rowspan="2">KETERANGAN</th>
</tr>
<tr>
	<th>PCS</th>
	<th>SET</th>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<!-- <ul style="list-style-type:decimal;"> -->
<?php 
	$count_Totalpiece = 0;
	$count_Totalset = 0;
	$no = 1;
	$querym = $this->db->query("select * from merchandise");
	
	foreach($query as $row){
		//echo "<li>";
		if($row->intid_jsatuan == 2){
			$count_Totalpiece = $count_Totalpiece + $row->quantity;
		}else{
				$count_Totalset	=	$count_Totalset + $row->quantity;
			}
		echo "<tr style='padding:5px;'>";
		echo "<td align='center'>".$no++."</td>";
		$check = false;
		foreach($querym->result() as $rok)
		{
			if($rok->intid_barang == $row->intid_barang)
			{
				$check = true;
			}
		}
		if($check == true)
		{
			echo "<td><b>".$row->strnama."</b></td>";
		}
		else
		{
			echo "<td>".$row->strnama."</td>";
		}
		if($row->intid_jsatuan == 2){
			echo "<td align='center'>".$row->quantity."</td>";
			echo "<td align='center'>0</td>";
			}else{
				echo "<td align='center'>0</td>";
				echo "<td align='center'>".$row->quantity."</td>";
			}
		echo "<td>".$row->keterangan."</td>";
		echo "</tr>";
		//echo "</li>";
		}
?>
<!-- </ul> -->
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="right"><b>JUMLAH</b></td>
    <td align="center"><b><?php echo "".$count_Totalpiece."";?></b></td>
	<td align="center"><b><?php echo "".$count_Totalset."";?></b></td>
	<td>&nbsp;</td>
</tr>
</table>
<table width="100%">
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td width="20%">&nbsp;</td>
	<td width="20%">&nbsp;</td>
	<td width="20%">&nbsp;</td>
	<td width="40%" align="center">ADM.CABANG</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="center">( ........................ )</td>
</tr>
</table>
</body>
</html>