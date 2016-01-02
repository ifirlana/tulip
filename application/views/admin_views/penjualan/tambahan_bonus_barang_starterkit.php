<?php 
	if(isset($query) and !empty($query))
	{?>
<table border="1"  width="95%" cellpadding="0" cellspacing="0" id="data" align="center">
	<tr>
		<td><center><h3>Pilih Warna</center><h3></td>
		<td><select name="intid_barang_bonus[]">
			<?php
				foreach($query->result() as $Row)
				{
					echo "<option value='".$Row->intid_barang."'>".$Row->strnama."</option>";
				}
				?>
		</select>
		 Qty <input type="text" size="2" name="intquantity_bonus[]" value="1" readonly/></td>
		<td>
			&nbsp;
		</td>
	</tr>
	<tr><td id='temp_tambahan_bonus_barang_starterkit'></td></tr>
</table>
<script>
	$(document).ready(function()
	{
		alert("Silahkan pilih warna Splash Bottle");
	});
</script> 
<?php 
	}
	?>