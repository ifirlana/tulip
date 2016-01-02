
<table style="width:100%;"><tr>
                    <td width='40%'><small>Jenis Penjualan</small> : <select name='<?php echo $id_jenis_penjualan; ?>' id='<?php echo $id_jenis_penjualan; ?>'>
                        <option value='1'>REGULER</option>
                        <option value='2'>CHALL HUT</option>
                        <option value='3'>CHALLENGE</option><option value='26'>CHALL SC</option>       </select><input type='hidden' name='<?php echo $id_jenis_penjualan; ?>_temp' value='' /></td>
                    <td width='30%'>&nbsp;</td> 
                    <td colspan='3' style='width:80%;'>&nbsp;</td> 
                    <td width='10%'>&nbsp;</td>
                </tr><tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td colspan="3"><small>Paket Promo 10%</small></td>
                                                <td>
                                                    <input type="checkbox" name="chkBox10" id="<?php echo $id_form_check10;?>" disabled="disabled" checked />
                                                    <input type="hidden" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/> 
                                                    <input type="hidden" id="jumlahbrg10">
                                                    <input type="hidden" name="chkV10" id="chkV10" disabled="disabled"/>
                                                    </td>
                                            </tr> <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td colspan="3">Power Buy Mandiri</td>
                                                    <td><input type="checkbox" name="chkSmart" id="chkSmart" />
                                                    </td>
                                            </tr>
                                            </table>