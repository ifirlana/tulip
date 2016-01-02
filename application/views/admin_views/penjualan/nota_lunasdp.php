<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

                        <form action="<?php echo base_url()?>penjualan/lunasdp" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <input type="hidden"	name="instalment_number" value='<?php echo $instalment_number?>' />
                            <input type="hidden"	name="id_branch" value='<?php echo $intid_cabang?>' />
                            <input type="hidden"	name="type_price" value='<?php echo $intid_wilayah?>' />
                            <input type="hidden"	name="branch_name" value='<?php echo $cabang?>' />
							<input type="hidden"	name="price_type" value='<?php echo $price_type?>' />
							<input type="hidden"	name="type_membership" value='<?php echo $type_membership?>' />
							<input type="hidden"	name="intid_dealer" value='<?php echo $id_dealer?>' />
							<input type="hidden"	name="membership_name" value='<?php echo $membership_name?>' />
							<input type="hidden"	name="datetgl" value='<?php echo $datetgl?>' />
							<input type="hidden"	name="week" value="<?php echo $intid_week?>" />
							<table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td >&nbsp;<?php echo $cabang; ?>
                                         <input type="hidden" name="name_intid_cabang" size="30" readonly="readonly" value="<?php echo $cabang; ?>">         </td>
										<input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">         </td>
                                    <td>&nbsp;,</td>
                                    <td>&nbsp;<?php echo date("d-m-Y");?></td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;Unit</td>
                                    <td>&nbsp;:</td>
                                    <td><input type="hidden" name="id_unit"  value="<?php echo $id_unit;?>" readonly="readonly"/><input type="text" name="strnama_unit" id="intid_unit"  value="<?php echo $strnama_unit;?>" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="82">&nbsp;Nama</td>
                                    <td width="7">&nbsp;:</td>
                                    <td width="213">
										<input type="text" name="strnama_dealer" id="strnama_dealer" value="<?php echo $strnama_dealer;?>" readonly="readonly"/>
										</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;No Kartu</td>
                                    <td>&nbsp;:</td>
                                    <td><input type="text" name="strnama_dealer2" id="strnama_dealer2" value="<?php echo $strkode_dealer;?>" readonly="readonly"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;Upline</td>
                                    <td>&nbsp;:</td>
                                    <td><input type='hidden' name='intid_upline' value="<?php echo $intid_upline;?>" readonly><input type="text" name="strnama_upline" id="strnama_dealer2" value="<?php echo $strnama_upline;?>" readonly="readonly"/></td>
                                </tr>

                                <tr>
                                    <td>&nbsp;No. Nota</td>
                                    <td>&nbsp;<input type="text" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly >
										<input type="hidden" name="intid_week" size="20" value="<?php echo $intid_week?>"></td>
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
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                    <table width="685" border="1" id="data" align="center">
                                      <tr>
                                        <td>Banyaknya</td>
                                        <td>Nama Barang</td>
                                        <td>Harga</td>
                                      </tr>
                                      <?php
										foreach($detaildp as $m) :
									  ?>
                                      <tr>
                                        <td align="center"><?php echo $m->intquantity; ?></td>
                                        <td><?php echo $m->strnama; ?></td>
                                        <td><?php echo ($m->intquantity*$m->intharga); ?></td>
                                      </tr>
                                      <?php endforeach; ?>
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
                                        Rp.<input type="text" name="jml10" id="intjumlah1" readonly="readonly" value="<?php echo $intomset10;?>"/><br />
                                        Rp.<input type="text" name="jml20" id="intjumlah2" readonly="readonly" value="<?php echo $intomset20;?>"/><br />
                                        Rp.<input type="text" name="jumlah" id="intjumlah" readonly="readonly" value="<?php echo $inttotal_omset;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="intpv" id="intpv"  readonly="readonly" value="<?php echo $intpv;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly" value="<?php echo $intkomisi20;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 10%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly" value="<?php echo $intkomisi10;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly" value="<?php echo $inttotal_bayar;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>DP</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="dp" id="dp" readonly="readonly" value="<?php echo $intdp;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kurang</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="kurang" id="kurang" readonly="readonly" value="<?php echo $intsisa;?>"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Cash</span></td>
                                  <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intcash" id="intcash"  onkeyUp="return sisa(this.id);"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa(this.id);"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa(this.id);"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;<span class="style1">Sisa</span></td>
                                  <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intsisa" id="intsisa" />
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
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" class="button"/><input type="hidden" name="intid_nota" value="<?php echo $intid_nota?>"/> </td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/></td>
                                </tr>
                            </table>
                      </td>
                            </tr>
                            </table>
                        </form>
                    </div>
                </div></div>
        </div>
        
    </div>
</div>
<script type="text/javascript">
    function sisa($id)
    {
	if($id == "intcash") {$('#intcash').val($('#kurang').val());$('#intkkredit').val(0);$('#intdebit').val(0);}
	if($id == "intkkredit") {$('#intkkredit').val($('#kurang').val());$('#intcash').val(0);$('#intdebit').val(0);}
	if($id == "intdebit") {$('#intdebit').val($('#kurang').val());$('#intkkredit').val(0);$('#intcash').val(0);}
        if($('#intcash').val() == ""){
            var a = 0;
        }else{
            var a = parseInt($('#intcash').val());
        }
        if($('#intkkredit').val() == ""){
            var b = 0;
        }else{
            var b = parseInt($('#intkkredit').val());
        }
        if($('#intdebit').val() == ""){
            var c = 0;
        }else{
            var c = parseInt($('#intdebit').val());
        }
        var d = parseInt($('#kurang').val());
        var t = a + b + c;
        var sisa = d - t;
        document.getElementById('intsisa').value = formatAsDollars(-sisa);
        $('#intsisahidden').val(sisa);
    }

    function formatNumber(num)
        {
            var n = num.toString();
            var nums = n.split('.');
            var newNum = "";
            if (nums.length > 1)
            {
                var dec = nums[1].substring(0,2);
                newNum = nums[0] + "," + dec;
            }
            else
            {
                newNum = num;
            }
            return (newNum)
        }

   function formatAsRupiah(ObjVal) {

        mnt = ObjVal;

        mnt -= 0;

        mnt = (Math.round(mnt*100))/100;

        ObjVal = (mnt == Math.floor(mnt)) ? mnt + '.00' : ( (mnt*10 == Math.floor(mnt*10)) ? mnt + '0' : mnt);

        if (isNaN(ObjVal)) {ObjVal ="0.00";}

        return ObjVal;
    }

    function formatAsDollars(amount){

        if (isNaN(amount)) {
            return "0.00";
        }
        amount = Math.round(amount*100)/100;

        var amount_str = String(amount);

        var amount_array = amount_str.split(".");

        if (amount_array[1] == undefined) {
            amount_array[1] = "00";
        }
        if (amount_array[1].length == 1) {
            amount_array[1] += "0";
        }
        var dollar_array = new Array();
        var start;
        var end = amount_array[0].length;
        while (end>0) {
            start = Math.max(end-3, 0);
            dollar_array.unshift(amount_array[0].slice(start, end));
            end = start;
        }

        amount_array[0] = dollar_array.join(",");

        return (amount_array.join("."));
    }

</script>

