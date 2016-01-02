<table id="data" align="center"><tr>
                                    <td>&nbsp;Jenis Penjualan</td>
                                    <td>&nbsp;<input type="hidden" name="intid_jpenjualan" value="" id="post_intid_jpenjualan"/>
                                 		<?php 
										 echo $echo_intid_jpenjualan
										?>
										</td>
                                    <td colspan="3" style="display:none;">Paket Promo 20%</td>
                                    <td style="display:none;">
                                        <input type="checkbox" name="chkBox20" id="chkBox20" disabled="disabled"/>
                                        <input type="hidden" name="txtpromo20" id="txtpromo20"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg20">
                                        <input type="hidden" name="chkV20" id="chkV20" disabled="disabled"/>
										<?php //echo"<input type="checkbox" name="chkV20" id="chkV20" disabled="disabled"/> Voucher;?>
                                        
                                        <input type="hidden" name="txtvoucher" id="txtvoucher"  size="4" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" style="display:none;">Paket Promo 10%</td>
                                    <td style="display:none;">
                                        <input type="checkbox" name="chkBox10" id="chkBox10" disabled="disabled"/>
                                        <input type="hidden" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg10">
                                        <input type="hidden" name="chkV10" id="chkV10" disabled="disabled"/>
                                       <?php //echo"<input type="checkbox" name="chkV10" id="chkV10" disabled="disabled"/> Voucher;?>
                                         </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" style="display:none;">Trade In</td>
                                    <td style="display:none;"><input type="checkbox" name="chkBoxTrade" id="chkBoxTrade" disabled="disabled" style="display:none;"/>
                                        &nbsp;&nbsp;&nbsp;<select name="komisitradetext" id="komisitrade" disabled="disabled">
                                            <option value="0">0%</option>
                                            <option value="10">10%</option>
                                            <option value="20">20%</option>
                                            <option value="30">30%</option>
                                            <option value="40">40%</option>
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70">70%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                        </select><input type='hidden' name='komisitrade' class='komisitrade' value='0' size='2' readonly /></td>
                                </tr>           
                                <tr style="display:none;">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">1 Free 1 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBoxFree" id="chkBoxFree" disabled="disabled"/>
                                        <input type="hidden" name="txtfree" id="txtfree"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>        </td>
                                    	<input type="hidden" id="jumlahbrgfree">
                                </tr>
								<?php
								/*
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Voucher</td>
                                    <td>
                                        <input type="checkbox" name="chkV" id="chkV" disabled="disabled"/></td>
                                    <input type="hidden" id="jumlahbrgfree"> 
                              </tr>
							  */
							  ?>
								<tr style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Power Buy Mandiri</td>
									<td ><input type="checkbox" name="chkSmart" id="chkSmart" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Free Lain-lain</td>
									<td ><input type="checkbox" name="chklainlain" id="chklainlain" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain2" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 50%</td>
									<td ><input type="checkbox" name="chktulip50" id="chktulip50" />
                                    </td>
                                </tr>
								
                              <tr id="showattrlainlain3" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 50% komisi 10%</td>
									<td ><input type="checkbox" name="chktulip50_10" id="chktulip50_10"  <?php if($id_cabang == 28 or $id_cabang == 1){?><?php }else{?>disabled<?php }?>/>
                                    </td>
                                </tr>
								<tr id="showattrlainlain4" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 20% komisi 20%</td>
									<td >
									<input type="checkbox" name="chktulip20_20" id="chktulip20_20" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain5" >
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 30% komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip30_10" id="chktulip30_10" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain6" >
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Metal 30% komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip30_10M" id="chktulip30_10M" />
                                    </td>
                                </tr>
								<tr>
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Voucher</td>
									<td >
										<input type="checkbox" name="chkvocherbaru" id="chkvocherbaru" />
                                    </td>
								</tr>
                                <tr>
                                    <td colspan="6">&nbsp;<input type="hidden" name="textfield" id="txtp10" />
                                    <input type="hidden" name="textfield" id="txtps10" />
                                    <input type="hidden" name="textfield" id="onefree" />
                                     <input type="hidden" name="textfield" id="onesfree" />
                                    <input type="hidden" name="textfield" id="onefreehut" />
                                    <input type="hidden" name="textfield" id="onesfreehut" />
                                    <input type="hidden" name="textfield" id="freeonefree" />
                                    <input type="hidden" name="textfield" id="freeonefreehut" />
                                    <input type="hidden" id="id_wilayah" value="<?php echo $intid_wilayah;?>" />
                                    
                                        <div align="center" id="title"></div></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="116">&nbsp;Silahkan ketik</td>
                                              <td width="367">&nbsp;Nama Barang</td>
                                              <td width="87">Harga</td>
<td width="63" rowspan="3"><div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
														<input type="hidden" id="tracker001" value="0" />
														<input type="hidden" id="tracker002" value="bayar" />
														<input type="hidden" id="tracker004" value="" />
                                                    </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang -&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" id="brgsuka" size="50" /></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div></td>
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
                                  </table></td>
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
										<div id="asi"></div><input type="hidden" name="intkomisiasi" id="intkomisiasi"/></td>
                                        </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly"/>
                                        <input type="hidden" name="intpv_trade" id="intpv_trade"/>                                    </td>
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
                                        <input type="hidden" name="komisihide" id="komisihide"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 10%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly"/>
                                        <input type="hidden" name="komisi1hidden" id="komisi1hidden"/>                                    </td>
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
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" disabled="disabled" class="button"/></td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/></td>
                                </tr>
								</table>