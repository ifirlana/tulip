<div id ="loadme" style="background:rgba(000, 000, 000, 0.9) !important;	position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 2000;">
	<div style="position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -50px;
    margin-left: -50px;
    font-size: 200%;
    color:white;
    ">	
		<i >please wait a moment. . .</i>
	</div>

</div>
<table  width="100%" border="0" id="data" align="center">
	<tr>
		<td>Jenis Promo</td>
		<td  id="id_jenis_promo_form">
			<input type="hidden" name="intid_control_promo" id ="ppenjualans" >
		<select id="intid_control_promo" class="config" name="config[intid_control_promo]">
			<option value="0">-- Pilih Jenis Promo --</option>
			<?php
				//KONDISI
				/*
				*
				for($i=0;$i<count($nama_promo);$i++) {
				// 1 free 1 net di akses semua
						echo "<option value='$intid_control_promo[$i]'>$nama_promo[$i]</option>";
					}
				*/
				if($query->num_rows() > 0)
				{
					foreach($query->result() as $row)
					{
						echo "<option value='".$row->intid_control_promo_tebus."'>".$row->nama_promo."</option>";
					}
				}
				?>
		</select>			
		</td>
		<td>&nbsp;</td>
		<td>
			</td>
		<td>&nbsp;Jenis Penjualan</td>
		<td id="id_jenis_penjualan_form">&nbsp;
			<input type="hidden" name="nota_intid_jpenjualan" id ="jpenjualans" value="0" >
				<select name="nota_intid_jpenjualan_t" class="config" name="config[intid_jpenjualan]" id="intid_jpenjualan">
				<option value="0">-- Pilih Jenis Penjualan--</option>
			</select>       
		</td>	
	</tr>
</table>
<input type="hidden" class="config" id="id_count" name="config[count]" value="0" alt="count" />
<input type="hidden" class="config" id="id_lookup_url_bayar" name="config[lookup_url_bayar]"  value="0" />
<input type="hidden" class="config" id="id_lookup_url_free" name="config[lookup_url_free]"  value="0" />
<input type="hidden" class="config" id="id_kom10" name="config[kom10]"  value="0" />
<input type="hidden" class="config" id="id_kom15" name="config[kom15]"  value="0" />
<input type="hidden" class="config" id="id_kom20" name="config[kom20]"  value="0" />
<input type="hidden" class="config" id="id_omset" name="config[omset]"  value="0" />
<input type="hidden" class="config" id ="id_config" name="config[pencarian]"  value="0" />
<input type="hidden" class="config" id="id_diskon" name="config[diskon]"  value="1" />
<input type="hidden" class="config" id="id_pv" name="config[pv]"  value="0" />
<input type="hidden" class="config" id="id_isbayar" name="config[isbayar]"  value="1" />
<input type="hidden" class="config" id="id_isfree" 	name="config[isfree]"  value="0" />
<input type="hidden" class="config" id="id_isCon" name="config[isCon]"  value="0" />
<input type="hidden" class="config" id="id_is_komtam" name="config[is_komtam]"  value="0" />
<input type="hidden" class="config" id="id_is_voucher" name="config[is_voucher]"  value="0" />
<input type="hidden" class="config" id="id_view" name="config[view]"  value="0" />
<?php 
if(isset($script))
	{
		echo $script;
	}
?>

<div id="tempPromoBarang" style="padding: 5px 5px 0px 5px;" align="center" >
<!--Pilih Combo:    <select  id="jpromocombo">
                <option value="0">-- Pilih Jenis Combo--</option>
    </select>
	-->
</div> <!-- digunakan untuk load tambahan fitur baru dari promo dan jenis penjualan -->
<div id="loadFormaddBrg"></div> <!-- digunakan untuk load form barang yang fix-->
<div id="formBarang" ></div><!-- digunakan menyimpan barang yang fix -->
<div id="formHitungTotal"><!-- digunakan total barang yang bernilai -->
	<table id="data" width="100%" style="background-color:none;">
		<tr>
			<td rowspan="17" width="60%"></td>
			<td>Total Voucher</td>
			<input type="hidden" name="nota_intvoucher"	id="" value="0" readonly>
			<td><input type="text" name=""	id="inttotal_voucher" value="0" readonly></td>
		</tr>
		<tr>
			<td>Total Omset</td>
			<td><input type="text" name="nota_inttotal_omset" id="inttotal_omset" value="0" readonly></td>
		</tr>
		<tr>
			<td>PV</td>
			<td><input type="text" name="nota_pv" id="intpv" value="0" readonly></td>
		</tr>
		<tr>
			<td>Omset 10 % </td>
			<td><input type="text" name="nota_inttotal_10" id="inttotal_10" value="0" readonly></td>
		</tr>
		<tr>
			<td>Omset 15%</td>
			<td><input type="text" name="nota_inttotal_15" id="inttotal_15" value="0" readonly></td>
		</tr>
		<tr>
			<td>Omset 20%</td>
			<td><input type="text" name="nota_inttotal_20" id="inttotal_20" value="0" readonly></td>
		</tr>
		<tr>
			<td>komisi 10 % </td>
			<td><input type="text" name="nota_inttotal_k10" id="inttotal_k10" value="0" readonly></td>
		</tr>
		<tr>
			<td>komisi 15%</td>
			<td><input type="text" name="nota_inttotal_k15" id="inttotal_k15" value="0" readonly></td>
		</tr>
		<tr>
			<td>komisi 20%</td>
			<td><input type="text" name="nota_inttotal_k20" id="inttotal_k20" value="0" readonly></td>
		</tr>
		<tr>
			<td>Komisi + <span id="persentambah"></span>%</td>
			<td>
			<input type="text" name="nota_inttotal_kOther" id="inttotal_kOther" value="0" readonly></td>
			<input type="hidden" name="nota_persen_kOther" id="nota_persen_kOther" value="0" readonly></td>
		</tr>
		<tr>
			<td>Total Bayar</td> 
			<td><input type="text" name="nota_inttotal_bayar" id="inttotal_bayar" value="0" readonly></td>
		</tr>
		<tr style="background-color:yellow;">
			<td style="background-color:yellow;">Cash</td>
			<td style="background-color:yellow;"><input type="text" name="nota_intcash" id="intcash" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr style="background-color: rgb(1, 232, 101);">
			<td style="background-color: rgb(1, 232, 101);">Debit</td>
			<td style="background-color: rgb(1, 232, 101);"><input type="text" name="nota_intdebit" id="intdebit" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr style="background-color: rgb(6, 104, 234);">
			<td style="background-color: rgb(6, 104, 234);">Kartu Kredit</td>
			<td style="background-color: rgb(6, 104, 234);"><input type="text" name="nota_intkkredit" id="intkredit" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr style="background-color:red;">
			<td style="background-color:red;">DP <input type="checkbox" id="check_intdp" <?php
			if($this->session->userdata('is_dp') == 0)
			{
			?> disabled <?php 
			}?>
		/></td>
			<td style="background-color:red;"><input type="text" name="nota_intdp" id="intdp" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();" value="0" disabled>
			<input type="hidden" name="is_dp" id="is_dp" value="0" size="1" readonly /></td>
		</tr>
		<tr>
			<td>Sisa</td>
			<td><input type="text" name="nota_intsisa" id="intsisa" value="0" readonly></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" id="btn_submit" name="submit" value="submit" disabled /></td>
		</tr>
	</table>
</div>