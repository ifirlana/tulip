<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            //for unit
            $(document).ready( function() {
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
                            dataType: 'json',
                            type: 'POST',
                            data: req,
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
			$("#strnama_dealer").val("");
			$("#result001").empty();
			$("#result").empty();
                        $("#result").append(
                        "<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });


                $("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result001").empty();
                        $("#result001").append(
                        "<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/></td>"
                    );
                    },
                });

                $("#strnama_upline").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                });


                autoCompPromo10();
                hut();
                satufreesatu();

            });
          

            function autoCompPromo10(){

                if($("#chkBox10").attr('checked') == false){
                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
                }else if ($("#chkBox10").attr('checked') == true) {

                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarangPromo10";
                }

                $(".id1").autocomplete({

                    minLength: 2,
                    source:
                        function(req, add){


                        $.ajax({
                            url: ur,
                            dataType: 'json',
                            type: 'POST',
                            data: req,
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );
                    },
                });


                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree10",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_barang').val(),
                             },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">penjualan smart spending</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/istimewa" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    
                                    <td >&nbsp;<?php echo $cabang; ?>
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
                                    <td><input type="text" name="textfield4" id="intid_unit"  size="25"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="82">&nbsp;Nama</td>
                                    <td width="7">&nbsp;:</td>
                                    <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="25"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;No Kartu<br /><br />&nbsp;Upline :</td>
                                    <td>&nbsp;:</td>
                                    <td valign="top">&nbsp;<div id="result"></div><div id="result001"></div></td>
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
                                    <td>&nbsp;No. Nota</td>
                                    <td>&nbsp;<input type="text" id="nomor_nota" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly ></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;Jenis Penjualan</td>
                                    <td>&nbsp;
                                      <select name="intid_jpenjualan" id="intid_jpenjualan">
                                        <option value="">-- Pilih --</option>
                                        <?php
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
                                                echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
                                            }
                                            ?>
                                      </select></td>
                                  <td colspan="3">&nbsp;</td>
                              <td>&nbsp;</td>
                              </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Paket Promo 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBox10" id="chkBox10" disabled="disabled"/>
                                        x
                                        <input type="text" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg10"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <input type="hidden" id="jumlahbrgfree"> 
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
                                                    </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang -&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang Free -&gt;</td>
                                                <td>&nbsp;&nbsp;<input type="text" name="free" class="frees" size="50" disabled  /></td>
                                                <td>&nbsp;<div id="result2"></div></td>
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
                                        <input type="hidden" name="intkomisiasi" id="intkomisiasi"/></td>
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
                                <tr id="cicilan" style="display:none">
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>Cicilan 0%</td>
                                  <td>:</td>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="is_asi" id="is_asi"/></td>
                                </tr>
                                <tr id="komisi20" style="display:none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly"/>
                                        <!--<input type="hidden" name="komisihide" id="komisihide"/> -->                                   </td>
                                </tr>
                                <tr id="komisi10" style="display:none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 10%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly"/>
                                        <!--<input type="hidden" name="komisi1hidden" id="komisi1hidden"/> -->                                   </td>
                                </tr>
                                <tr id="charge" style="display:none">
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>Charge 3%</td>
                                  <td>:</td>
                                  <td>Rp.<input name="charge3" id="charge3" type="text" readonly/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Total Bayar</span></td>
                                  <td>:</td>
                                    <td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly"/>
                                        <input type="hidden" name="totalbayar1" id="totalbayar1" />
                                        <input type="hidden" name="totalbayar2" id="totalbayar2" />         </td>
                                </tr>
                                <tr>
                                    <td>No Kartu Kredit</td>
                                    <td><input type="text" name="nokk" id="nokk" maxlength="16"/></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" class="button"/></td>
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
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">
    function sisa()
    {
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
        var d = parseInt($('#totalbayar1').val());
        var t = a + b + c;
        var sisa = d - t;
		$('#intsisa').val(formatAsDollars(-sisa));
        $('#intsisahidden').val(sisa);
    }

    $('#frmjual').submit(function(event){

        if($("#intid_unit").val()==""){
            alert('Unit tidak Boleh Kosong!');
            $("#intid_unit").focus();
            event.preventDefault();
        }

        if($("#intjumlah").val()==""){
            alert('Belum ada Transaksi Barang!');
            event.preventDefault();
        }

        if($("#totalbayar").val()==""){
            alert('Belum ada Transaksi Barang!');
            event.preventDefault();
        }

        if($("#intid_jpenjualan").val()==""){
            alert('Anda Belum Memilih Jenis Penjualan!');
            event.preventDefault();
        }

    });


    var idx = 1;
    var idx10 = 1;
    var idx20 = 1;
    var idfreehut = 1;
    var idfree = 1;
    var idxf=1;
    $('#addBrg').bind('click', function(e){

        if(($(".id1").val()=="") &&($(".frees").val()=="")){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var id_barang =  $('#id_barang').val();
            var pv =  $('#pv').val();
            var total = jumlah * harga;

            var out = '';
		var nomor_nota = $('#nomor_nota').val();
            out += 'Banyaknya<br>';
            if($("#chkBox20").attr('checked') == true){
                out += '<input type="hidden"  id="hit20" name="hit20[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            else if($("#chkBox10").attr('checked') == true){
                out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
            }

            /*else if($("#chkBoxTrade").attr('checked') == true){
                out += '<input type="hidden" id="hittrade" name="hittrade[]" value="'+idx+'">';
                out += '<input id="'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            else if($("#chkBoxFreeHut").attr('checked') == true){
                out += '<input id="'+idx+'" class="onefreehuts_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hitfreehut" name="hitfreehut[]" value="'+idx+'">';
            }

            else if($("#chkBoxFree").attr('checked') == true){
                out += '<input id="'+idx+'" class="onefrees_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hitfree" name="hitfree[]" value="'+idx+'">';
            }*/else{
                out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
            if($("#chkBoxTrade").attr('checked') == true){
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="0" readonly>';
            }else{
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
            }
            out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
            out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
		out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
            idx10++;
            idx20++;
            idfreehut++;
            idfree++;
            $('.id1').val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            $('#pv').val('');
       }
        return false;

    });


	$('#addBrg').bind('click', function(e){
		if($('.frees').val() != "")
			{
				var brg = $('.frees').val();
				var jumlah = $('#jumlah').val();
				var harga = $('#harga_barang_free').val();
				var id_barang =  $('#id_free').val();
				var total = jumlah * harga;
				var out = '';
				var nomor_nota = $('#nomor_nota').val();

				out += '<sup>(Free)</sup>Banyaknya<br>';
				if($("#chkBox10").attr('checked') == true){
					out += '<input type="hidden" id="hitfree10" name="hitfree10[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)"  />&nbsp;';
				}else if($("#chkBox20").attr('checked') == true){
					out += '<input type="hidden" id="hitfree20" name="hitfree20[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="free20_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)"  />&nbsp;';
				}else if($("#chkBoxFree").attr('checked') == true){
					out += '<input type="hidden" id="hitonefree" name="hitonefree[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="freeone_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)"  />&nbsp;';
				}else if($("#chkBoxFreeHut").attr('checked') == true){
					out += '<input type="hidden" id="hitonefreehut" name="hitonefreehut[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="freeonehut_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)"  />&nbsp;';
				}else{
					out += '<input id="'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)"  />&nbsp;';
				}
				out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
				out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'">';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0">';
				out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'">';
				out += '<input name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
				out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
				out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a> ';
				out = '<div style="height:60px">' + out + '</div>';
				$(out).insertBefore('#ButtonAdd');
				idx++;
				idxf++;
				$('.frees').attr('disabled', 'disabled');
				$('.frees').val('');
				$('#harga_barang_free').val('');
				$('#jumlah').val('');
				$('#harga_barang').val('');
			}
			return false;

    	});

    function kali_sepuluh(id){
        var jf=0;
		$("#del"+id).remove();
        if($("#chkBox10").attr('checked') == true){
            //var cs2 = document.getElementsByName("hitfree10[]").length;
            var cs2 = parseInt($('#hitfree10').val());
			var textpromo10 = parseInt($("#txtpromo10").val());
            
			
			//for(var i=cs2+1; i<= parseInt(id);i++){
			for(var i=parseInt(cs2); i<= parseInt(id);i++){
                
				var jumlahfree = parseInt($('.free_'+ i).val());
                jf = jf + jumlahfree;
				//jf += jumlahfree;
            }
			
			//$('#free10').val(jf);		
			
			if(jumlahfree >= 0){
						//if(jumlahfree > textpromo10){
						if(jf > textpromo10){
							alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
							
						}

						if(jf >= textpromo10){
							$('#addBrg').attr('disabled', 'disabled');
							$('.frees').attr('disabled', 'disabled');
							
						}else{
							$('#addBrg').removeAttr('disabled');
							$('.frees').removeAttr('disabled');
							
						}
		 	}
        }

        
    }


    function kali(id){
        var jml=0;
        var pivi=0;

        var totaldua=0;
        var total=0;
        var jmlpv=0;
        var j=0;
		

        var limit20 = $('#txtpromo20').val();
        var limit10 = parseInt($('#txtpromo10').val());
        var limitfreehut = $('#txtfreehut').val();
        var limitfree = $('#txtfree').val();
        $("#del"+id).remove();

        if($("#chkBox10").attr('checked') == true){

			var csfree = parseInt($('#hit10').val());
			var tt = limit10 * 2;
			

	    	var ju=0;
            for(var i=parseInt(csfree); i<= parseInt(id);i++){
                var jumlah = parseInt($('.sepuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                var pv = parseFloat($('#pv_' + i).val());
				
                if(jumlah >= 0){

                    if(harga >= 0){

                       var tot = jumlah * harga;
                            $('#total_' + i).val(tot);
                            total += tot;
                            j = j+jumlah;
							ju = ju + jumlah;

                    }	
                }

            }

            $('#jumlahbrg10').val(j);
			
			
			if(jumlah > tt){
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			$('#txtp10').val(j);
            			
			if($("#txtps10").val()==''){
				var j10 = j;
			}else{
				j10 = j - $("#txtps10").val();
			}
				
			if(j10 >= tt){
                $('#addBrg').removeAttr('disabled');
				$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');

            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
            }
			
			if($("#chkV10").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){
					total10=total-50000;
					$('#intvoucher').val(50000);
				} else {
					total10=total-60000;
					$('#intvoucher').val(60000);
				}
				$('#txtvoucher').val(1);
			} else {
				total10=total;
			}
            $('#intjumlah1').val(formatAsDollars(total10));
            $('#intjumlah1hidden').val(total10);
            var total = parseInt($('#intjumlah1hidden').val());
            var disc = 7;
            var komisi = (total * disc) / 100;

            if($('#intkomisiasi').val()!=""){
               	var totkom = komisi;
                //$('#komisi1hidden').val(totkom);
                //$('#komisi1').val(formatAsDollars(totkom));
				$('#intkomisiasi').val(totkom);
                $('#komisi1').val(0);
            }else{
                //$('#komisi1hidden').val(komisi);
                //$('#komisi1').val(formatAsDollars(komisi));
				$('#intkomisiasi').val(komisi);
                $('#komisi1').val(0);
            }


        }else{

            var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
                }
            }

            			    
				if($("#chkV").attr('checked') == true){
					if ($('#id_wilayah').val() == 1){
						totalreg=total-50000;
						$('#intvoucher').val(50000);
					} else {
						totalreg=total-60000;
						$('#intvoucher').val(60000);
					}
					$('#txtvoucher').val(1);
				} else {
					totalreg=total;
				}
				
				
			if ($('#jumlahsementara').val()!= ""){
				var x = parseInt($('#jumlahsementara').val()) + totalreg;
				$('#intjumlah2').val(formatAsDollars(x));
            	$('#intjumlah2hidden').val(x);
			} else {
				$('#intjumlah2').val(formatAsDollars(totalreg));
            	$('#intjumlah2hidden').val(totalreg);

            }
			$('#komisihide').val(total);

            var t = parseInt($('#intjumlah2hidden').val());
            var disc = 17;
            var komisi = (t * disc) / 100;
            //$('#komisi2').val(formatAsDollars(komisi));
            //$('#komisi2hidden').val(komisi);
			$('#komisi2').val(0);
            $('#intkomisiasi').val(komisi);
			
			
			
        }


        for(var i=1; i<= parseInt(id);i++){
            if($('#' + i).val() != ""){
                var jumlah = parseInt($('#'+ i).val());
                var pv = parseFloat($('#pv_' + i).val());
                var jpv = jumlah * pv;
                if(jpv >= 0){
                     pivi +=jpv;
                }
            }
        }
		

        	
		//pv for HUT
		if($("#intid_jpenjualan").val()==2){
			pivi = 0
		}

        $('#intpv').val(formatNumber(pivi));
        
        function formatNumber(num)
        {
            var n = num.toString();
            var nums = n.split('.');
            var newNum = "";
            if (nums.length > 1)
            {
                var dec = nums[1].substring(0,2);
                newNum = nums[0] + "." + dec;
            }
            else
            {
                newNum = num;
            }
            return (newNum)
        }

        
        if($('#intkomisiasi').val() == ""){
            var kom = 0;
        }else{
            var kom = parseInt($('#intkomisiasi').val());
        }
        if($('#intjumlahhidden').val() == ""){
            var intjum = 0;
        }else{
            var intjum = parseInt($('#intjumlahhidden').val());
        }

        if($('#intjumlahtradehidden').val() == ""){
            var intjumt = 0;
        }else{
            var intjumt = parseInt($('#intjumlahtradehidden').val());
        }

        if($('#intjumlah1hidden').val() == ""){
            var intjum1 = 0;
        }else{
            var intjum1 = parseInt($('#intjumlah1hidden').val());
        }
        if($('#intjumlah2hidden').val() == ""){
            var intjum2 = 0;
        }else{
            var intjum2 = parseInt($('#intjumlah2hidden').val());
        }
        if($('#intjumlahfree').val() == ""){
            var intjumfree = 0;
        }else{
            var intjumfree = parseInt($('#intjumlahfree').val());
        }

        var omset = intjum1 + intjum2 + intjumfree + intjumt;
		
        $('#intjumlah').val(formatAsDollars(omset));
        $('#intjumlahhidden').val(omset);

        var totals = omset;
		
		var charge = 0.3 * totals;
		
		$('#charge3').val(formatAsDollars(charge));
		
		var totalbayar = totals+charge;

    	if (omset>=500000)
		{
				document.getElementById("cicilan").style.display = '';
				document.getElementById("komisi20").style.display = 'none';
				document.getElementById("komisi10").style.display = 'none';
				document.getElementById("charge").style.display = 'none';
				$('#totalbayar').val(formatAsDollars(omset));
				$('#totalbayar1').val(omset);
		} else if (omset<500000){
				document.getElementById("komisi20").style.display = '';
				document.getElementById("komisi10").style.display = '';
				document.getElementById("charge").style.display = '';
				$('#totalbayar').val(formatAsDollars(totalbayar));
				$('#totalbayar1').val(totalbayar);
		}   		
    }
	
	

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })


    function auto(){

        $(".id1").autocomplete({
            minLength: 2,
            source:
                function(req, add){
                $.ajax({
                    url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success:
                        function(data){
                        if(data.response =="true"){
                            add(data.message);
                        }
                    },
                });
            },
            focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                function(event, ui) {
                $("#result1").append(
                "<input type='text' id='id_barang' name='id_barang' value='" + ui.item.value1 + "' size='15' /><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });

    }


    //check the checkbox
    
	$("#chkBox10").click(function(){
        autoCompPromo10();
	$("#txtpromo10").val("");
        if($("#chkBox10").attr('checked') == true){
           	$("#txtpromo10").attr("disabled","");
			if ($('#txtvoucher').val()==1){
					$("#chkV10").attr("disabled","disabled");
			} else {
					$("#chkV10").attr("disabled","");
			}
			
			

        }else{
			//$('#txtp10').val('');
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            $(".frees").attr("disabled","disabled");
            $("#txtpromo10").attr("disabled","disabled");
			$("#chkV10").attr("disabled","disabled");
			
			

        }
    });
		
	 //var d=0;
     $("#txtpromo10").keyup(function(){


            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
			//var pro10 = $('#txtpromo10').val();
				/*d = parseInt($("#txtp10").val());
				if($("#txtp10").val()==''){
					var d = 1;
				}else{
					var d = d + 1;
				}
				alert(d);*/
				d = $("#txtp10").val();
				$("#txtps10").val(d);


    });

    function hut(){
        $(".id1").autocomplete({
            minLength: 1,
            source:
                function(req, add){
                $.ajax({
                    url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success:
                        function(data){
                        if(data.response =="true"){
                            add(data.message);
                        }
                    },
                });
            },
            focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                function(event, ui) {
                $("#result1").html(
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });

        $(".frees").autocomplete({
            minLength: 2,
            source:
                function(req, add){

                $.ajax({
                    url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success:
                        function(data){
                        if(data.response =="true"){
                            add(data.message);
                        }
                    },
                });
            },
            focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                function(event, ui) {
                $("#result2").html(
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });

    }

    

    $('#intid_jpenjualan').change(function()
    {
	$("#chkBox10").attr("checked",false);
	$("#txtpromo10").val("");
        if ($(this).attr('value')== 1)
        {
            var title = "Nota Penjualan Reguler";
            $("#title").text(title);
            $("#chkBox10").attr("disabled","");
			
        } else  if ($(this).attr('value')== 2)
        {
            var title = "Nota Penjualan Hut";
            $("#title").text(title);
            $("#txtpromo10").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","");
        
		} else  if ($(this).attr('value')== 3)
        {
            var title = "Nota Penjualan Challenge";
            $("#title").text(title);
            $("#txtpromo10").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
		} 


    });


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

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>