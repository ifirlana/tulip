<table  width="100%" border="0" id="data" align="center">
	<tr>
		<td>Jenis Promo</td>
		<td>
		<select id="intid_control_promo">
			<option value="0">-- Pilih Jenis Promo --</option>
			<?php
				//KONDISI
				for($i=0;$i<count($nama_promo);$i++) {
				// 1 free 1 net di akses semua
						echo "<option value='$intid_control_promo[$i]'>$nama_promo[$i]</option>";
					}
				?>
		</select>			
		</td>
		<td>&nbsp;</td>
		<td>
			</td>
		<td>&nbsp;Jenis Penjualan</td>
		<td>&nbsp;
				<select name="intid_jpenjualan" id="intid_jpenjualan">
				<option value="0">-- Pilih Jenis Penjualan--</option>
				<?php
				//KONDISI
				for($i=0;$i<count($strnama_jpenjualan);$i++) {
				// 1 free 1 net di akses semua
						echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
					}
				?>
			</select>         </td>
		
			
	</tr>
	
</table>