
<table border='0' cellpadding='0' cellspacing='0' style='width:100%;font-family:Sans-serif;font-size:100%;'>
                                <tr>
                                    <td style='width:30%;'>&nbsp;</td>
                                    <td style='width:20%;'>&nbsp;</td>
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
                                        Rp.<input type='text' name='id_formPembayaran_10persen' id='id_formPembayaran_10persen' readonly='readonly' value='0' /><br />
                                        Rp.<input type='text' name='id_formPembayaran_20persen' id='id_formPembayaran_20persen' readonly='readonly' value='0' /><br />
                                        Rp.<input type='text' name='id_formPembayaran_totalomset' id='id_formPembayaran_totalomset' readonly='readonly' value='0' />

                                        <input type='hidden' name='jml10' id='intjumlah1hidden' />
                                        <input type='hidden' name='jml20' id='intjumlah2hidden' />
                                        <input type='hidden' name='jumlah' id='intjumlahhidden' />
                                        <input type='hidden' name='jumlahtrade' id='intjumlahtradehidden' />
                                        <input type='hidden' name='jumlahfree' id='intjumlahfree'/>
                                        <input type='hidden' name='intvoucher' id='intvoucher' />
                                        <input type='hidden' name='jumlahsementara' id='jumlahsementara'/>
                                        <div id='asi'></div><input type='hidden' name='intkomisiasi' id='intkomisiasi'/></td>
                                        </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='id_formPembayaran_pv' id='id_formPembayaran_pv'  readonly='readonly' value='0'/>
                                        <input type='hidden' name='intpv_trade' id='intpv_trade'/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type='text' name='id_formPembayaran_komisi20' id='id_formPembayaran_komisi20' readonly='readonly' value='0'/>
                                        <input type='hidden' name='komisi2hidden' id='komisi2hidden'/>
                                        <input type='hidden' name='komisihide' id='komisihide'/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 10%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type='text' name='id_formPembayaran_komisi10' id='id_formPembayaran_komisi10' readonly='readonly' value='0'/>
                                        <input type='hidden' name='komisi1hidden' id='komisi1hidden' />                                    </td>
                                </tr>
                                <tr id='charge' style='display:none'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Charge 3%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type='text' name='charge3' id='' readonly='readonly' value='0' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td>Rp.<input type='text' name='id_formPembayaran_totalbayar' id='id_formPembayaran_totalbayar' readonly='readonly' value='0'/>
                                        <input type='hidden' name='totalbayar1' id='totalbayar1' />
                                        <input type='hidden' name='totalbayar2' id='totalbayar2' />         </td>
                                </tr>
                                <tr id='cash'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style='background:rgb(228,245,252);'><span class='style1'>Cash</span></td>
                                  <td style='background:rgb(228,245,252);'>&nbsp;:</td>
                                    <td style='background:rgb(228,245,252);'>Rp.<input type='text' name='id_formPembayaran_cash' id='id_formPembayaran_cash'  onkeyUp='return sisa();' onkeypress='return isNumberKey(event)' value='0' /></td>
                                </tr>
                                <tr id='debit'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type='text' name='id_formPembayaran_debit' id='id_formPembayaran_debit' onkeyUp='return sisa();' onkeypress='return isNumberKey(event)' value='0' /></td>
                                </tr>
                                <tr id='kkredit'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type='text' name='id_formPembayaran_kartukredit' id='id_formPembayaran_kartukredit' onkeyUp='return sisa();' onkeypress='return isNumberKey(event)' value='0' /></td>
                                </tr>
                                <tr id='sisa'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class='style1'>&nbsp;Sisa</span></td>
                                  <td>&nbsp;:</td>
                                    <td>Rp.<input type='text' name='id_formPembayaran_sisa' id='id_formPembayaran_sisa' onkeypress='return isNumberKey(event)' value='0' />
                                        <input type='hidden' name='intsisahidden' id='intsisahidden' />                                    </td>
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
                                    <td colspan='2' align='right'><input type='submit' value='Simpan' disabled='disabled' class='button'/></td>
                                    <td>&nbsp;</td>
                                    <td><input class='button' type='button' value='Cancel' onclick='location.href='penjualan';'/></td>
                                </tr>
                            </table>