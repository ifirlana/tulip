<div class="message" style="background-color: white; padding:3px;"> INFO : Jangan Lupa Click  "Tambah"</div>
<table width="100%" id="data"  align="center">
		<tr>
			<td colspan="5"><b><?php if(isset($result[0]->stat_bayar)){echo $result[0]->stat_bayar." ";}
			if(isset($result[0]->stat_free) and $result[0]->stat_free > 0){echo "Free ".$result[0]->stat_free;} ?></b></td>
		</tr>
		<tr>
			<td width="116">Silahkan ketik</td>
			<td width="367">Nama Barang</td>
			<td width="87">Harga</td>
			<td width="63" rowspan="2">
				<div id="data" class="statusBarang">
					<input type="hidden" class="addBrgTampung" name="addBrg" value="Tampung" disabled />
					&nbsp;
					Bayar
				</div>
			</td>
  </tr>
		<tr id="formAddBrg">
			<td>Pilih Barang </td>
			<td><input type="text" name="" class="nameBarang"  style="width:100%;" disabled/></td>
			<td><div id="resultPilihBarang"></div><div id="resultPilihBarangFree"></div></td>
		</tr>
</table>
<div>
<div id="tampung" style="padding:8px 0 8px 0;background-color:yellow;border-radius:4px;">
	<!-- tampung-->
</div>
<div id="addBarang" style="width:100%; margin-left: auto; margin-right: auto; border:1px solid black;">
		<!-- <input type="button" class="addBrg" name="addBrg" value="Tambah" style="width:100px; height:50px; "/> -->
		<input type="button" class="addBrg" name="addBrg" value="Tambah" style="width:100px; height:50px; background-color:#A7C942;  color:#FFF; border-radius: 25px; font-family: 'tahoma';">
</div>