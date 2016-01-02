<table width="685" border="0" cellspacing='0' id="data" align="center">
	<tr>
		<td colspan="6">
		<table width="661" border="1" id="data" align="center">
				<tr>
					<td width="116">&nbsp;Silahkan ketik</td>
					<td width="367">&nbsp;Nama Barang</td>
					<td width="87">Harga</td>
					<td width="63" rowspan="3">
						<div id="data">
							<input type="button" id="addBrg" name="addBrg" value="Tambah" />
							<input type="hidden" id="tracker001" value="0" />
							<input type="hidden" id="tracker002" value="bayar" />
							<input type="hidden" id="tracker004" value="" />
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;Pilih Barang -&gt;
						<input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
					<td>&nbsp;<input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></td>
					<td>&nbsp;<div id="result1"></div></td>
				</tr>
				<tr>
					<td style="display:none;">&nbsp;Pilih Barang Free -&gt;</td>
					<td style="display:none;">&nbsp;&nbsp;<input type="text" name="free" class="frees" size="50" disabled  /></td>
					<td style="display:none;">&nbsp;<div id="result2"></div></td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="ButtonAdd" style="margin-left: 150px"></div></td>
				</tr>
	  </table>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td width="100">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="200">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Omset 10%<br />Omset 20%<br />Total Omset</td>
		<td>:<br />:<br />:</td>
		<td>
			Rp.<input type="text" name="jml10" id="intjumlah1" readonly="readonly"/><br />
			Rp.<input type="text" name="jml20" id="intjumlah2" readonly="readonly"/><br />
			Rp.<input type="text" name="jumlah" id="intjumlah" readonly="readonly"/>

			<input type="hidden" name="jml10" id="intjumlah1hidden"/>
			<input type="hidden" name="jml20" id="intjumlah2hidden"/>
			<input type="hidden" name="jumlah" id="intjumlahhidden"/>
			<input type="hidden" name="jumlahtrade" id="intjumlahtradehidden"/>
			<input type="hidden" name="jumlahfree" id="intjumlahfree"/>
			<input type="hidden" name="intvoucher" id="intvoucher"/>
			<input type="hidden" name="jumlahsementara" id="jumlahsementara"/>
			<div id="asi"></div><input type="hidden" name="intkomisiasi" id="intkomisiasi"/>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>PV</td>
		<td>:</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly"/>
			<input type="hidden" name="intpv_trade" id="intpv_trade"/>
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Komisi 20%</td>
		<td>:</td>
		<td>
			Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly"/>
			<input type="hidden" name="komisi2hidden" id="komisi2hidden"/>
			<input type="hidden" name="komisihide" id="komisihide"/>
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Komisi 10%</td>
		<td>:</td>
		<td>
			Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly"/>
			<input type="hidden" name="komisi1hidden" id="komisi1hidden"/>
			</td>
	</tr>
	<tr id="charge" style="display:none">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Charge 3%</td>
		<td>:</td>
		<td>
			Rp.<input type="text" name="charge3" id="charge3" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Total Bayar</td>
		<td>:</td>
		<td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly"/>
			<input type="hidden" name="totalbayar1" id="totalbayar1" />
			<input type="hidden" name="totalbayar2" id="totalbayar2" />         </td>
	</tr>
	<tr id="cash">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><span class="style1">Cash</span></td>
	  <td>&nbsp;:</td>
		<td>Rp.<input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
	</tr>
	<tr id="debit">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Debit</td>
		<td>&nbsp;:</td>
		<td>Rp.<input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
	</tr>
	<tr id="kkredit">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Kartu Kredit</td>
		<td>&nbsp;:</td>
		<td>Rp.<input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
	</tr>
	<tr id="sisa">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><span class="style1">&nbsp;Sisa</span></td>
	  <td>&nbsp;:</td>
		<td>Rp.<input type="text" name="intsisa" id="intsisa" onkeypress="return isNumberKey(event)" />
			<input type="hidden" name="intsisahidden" id="intsisahidden" />                                    </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align='right'>&nbsp;&nbsp;<input type="submit" value="Simpan" disabled="disabled" class="button"/></td>
		<td>&nbsp;</td>
		<td><input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/></td>
	</tr>
</table>
</form>
</div>
</div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>


