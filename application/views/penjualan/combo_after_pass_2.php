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
				reset_form(); //reset form user
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
					focus:
					function(event,ui) {
					var q = $(this).val();
					$(this).val() = q;
					},
                    select:
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
					focus:
					function(event,ui) {
					var q = $(this).val();
					$(this).val() = q;
					},
                    select:
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

                autoComp();
            });

 </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Combo Training</h2>
		<div>
                    <div id="entry" class="entry" >
                        <form action="<?php echo base_url()?>penjualan/combo_after" method="post" name="frmjual" id="frmjual">
						<input type="hidden" name="halaman" readonly="readonly" value="train">
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
                                    <td>&nbsp;<select name="intid_jpenjualan" id="intid_jpenjualan">
                                            <option value="">-- Pilih --</option>
                                            <?php
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
													echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
											}
                                            ?>
                                  </select>         </td>
                                    <td colspan="3"></td>
                                    <td>
                                        <input type="hidden" name="chkBox20" id="chkBox20" />
                                        </td>
					<td>&nbsp;</td>
                                    	<td>&nbsp;</td>
                              </tr>
				<tr>
					<td>&nbsp;Jenis Barang</td>
					<td>&nbsp;<select name="tulipormetal" id="tulipormetal">
							<option value="1">TULIP</option>
							<option value="2">METAL</option>
					</select>         </td>
					<td colspan="3">&nbsp;</td>
                                    	<td><input type="hidden" name="chkBox10" id="chkBox10" />&nbsp;<input type="hidden" name="txtpromo10" id="txtpromo10" size="1" />
                                        </td>
					<td>&nbsp;</td>
                                    	<td>&nbsp;</td>
				</tr>
                                <tr style="display:none;">
					<td>&nbsp;</td>
                                    	<td>&nbsp;</td>
					<td colspan="3">Voucher</td>
					<td><input type="hidden" name="chkV" id="chkV"/>
                                    	</td>
                                </tr>
								<tr>
					<td>&nbsp;</td>
                                    	<td>&nbsp;</td>
					<td colspan="3">&nbsp;</td>
					<td><input type="hidden" name="chkSmart" id="chkSmart" />
                                    	</td>
                                </tr>
                                <tr>
                                    <td colspan="6">&nbsp;
                                    <input type="hidden" id="id_wilayah" value="<?php echo $intid_wilayah;?>" />
                                    
                                        <div align="center" id="title"></div></td>
                                </tr>
                            </table>
                           <?php $submenu['intid_cabang'] = $id_cabang; ?>
						   <?php $this->load->view("penjualan/combo/submenu1",$submenu);?>                            
                            <table id="data">
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="116">&nbsp;Silahkan ketik</td>
                                              <td width="367">&nbsp;Nama Barang</td>
                                              <td width="87">Harga</td>
<td width="63" rowspan="2"><div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
							<input type="hidden" id="tracker001" value="0" />
							<input type="hidden" id="tracker002" value="bayar" />
                            <input type="hidden" id="tracker004" value="" />
                                                                 </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang -&gt;
                                                    </td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div><div id="result2"></div></td>
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
                                <table id="data" style="width:100%;">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="width:40%;">&nbsp;</td>
                                    <td  style="width:10%;">Omset 10%<br />Omset 20%<br />Total Omset</td>
                                    <td  style="width:10%;">:<br />:<br />:</td>
                                    <td  style="width:30%;">
                                        Rp.<input type="text" name="jml10" id="intjumlah1" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jml20" id="intjumlah2" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jumlah" id="intjumlah" readonly="readonly" value="0"/>

                                        
                                        <input type="hidden" name="jml10" id="intjumlah1hidden"/>
                                        <input type="hidden" name="jml20" id="intjumlah2hidden"/>
                                        <input type="hidden" name="jumlah" id="intjumlahhidden"/>
                                        <input type="hidden" name="intvoucher" id="intvoucher"/>
										<div id="asi"></div><input type="hidden" name="intkomisiasi" id="intkomisiasi"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly" value="0"/>
                                        <input type="hidden" name="intpv_trade" id="intpv_trade"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly" value="0"/>
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
                                        Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly" value="0"/>
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
                                    <td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly" value="0"/>
                                        <input type="hidden" name="totalbayar1" id="totalbayar1" />       </td>
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
                                    <td colspan="2">&nbsp;</td>
                                    <td>&nbsp;&nbsp;<input type="submit" value="Simpan" disabled="disabled" class="button"/></td>
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
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">


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
    var idxf = 1;
    var idx10 = 1;
    var idx20 = 1;
	var _statepromo10 = 0;
	$('#addBrg').bind('click', function(e){
		if($(".id1").val()==""){
            alert('Anda belum memilih barang!');
        }else if($('.id1').val() != "" && $("#tracker002").val() == "bayar") {		
			var brg = $('.id1').val();
			var harga = $('#harga_barang').val();
			var id_barang =  $('#id_barang').val();
			var pv =  $('#pv').val();
			var out = '';
			var nomor_nota = $('#nomor_nota').val();
			
			out += 'Banyaknya<br>';
			if($("#chkBox20").attr('checked') == true){
						out += '<input type="hidden"  id="hit20" name="hit20[]" value="'+idx+'">';
						out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
						out += '<input id="tracker003_'+idx+'" name="tracker003_'+idx+'" type="hidden" >';
                    
					}
			else if($("#chkBox10").attr('checked') == true){
						out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
						out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
			             out += '<input id="tracker003_'+idx+'" name="tracker003_'+idx+'" type="hidden" >';
                    
            }
            else if($("#comboCheckPoint").val() != ""){//untuk combo
                        out += '<input id="'+idx+'" class="combo_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                        out += '<input type="hidden" id="hitcombo" name="hitcombo[]" value="'+idx+'">';
                        out += '<input id="tracker003_combo_'+idx+'" name="tracker003_combo_'+idx+'" type="hidden" value="1"><input type="hidden" size="3" id="comboCheck'+idx+'" value="'+$("#comboPaketRulesPoint").val()+'" readonly />';
            }
			else{
						out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
						out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" onkeyUp="kali(this.id);" onkeypress="return isNumberKey(event)" />&nbsp;';
			}           
					
			out += '<input id="barang_'+idx+'_intid_barang" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
			out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
			out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
			
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="0" readonly>';
					out += '<input id="barang_'+idx+'_intid_id" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
					//001
					out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					if (($("#chkBox10").attr('checked') == true /*&& _statepromo10 == 1*/) == false)
					{
						out += '<br /><input type="checkbox" id="voucher_'+idx+'" onclick="kali()" />Voucher<input type="text" size="1" id="nominal_voucher_'+idx+'" onkeyUp="kali(this.id);" onkeypress="return isNumberKey(event)" />&nbsp&nbsp';
					}
					if ($("#chkBox10").attr('checked') == true)
					{
						_statepromo10 = 1;
					}
					
					out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
					out = '<div style="height:60px">' + out + '</div>';
			$(out).insertAfter('#ButtonAdd');
			
			//001
			ajaxgila(idx);
			
			idx++;
			idx10++;
			idx20++;
			$('.id1').val('');
			$('#harga_barang').val('');
	   }
        return false;
    });


	$('#addBrg').bind('click', function(e){
		if($('.id1').val() != "" && $("#tracker002").val() == "free")
			{
				var brg = $('.id1').val();
				var harga = $('#harga_barang_free').val();
				var id_barang =  $('#id_free').val();
				var nomor_nota = $('#nomor_nota').val();
				
				/*______________________________________________________________________________
				|																				|
				|					Kode yg bisa brubah2 tergantung promonya					|
				|		Kode kalau tombol tambah ditekan dia check harga 1 atau 2 barang		|
				|			sebelumnya apabila melebihi, barang tidak dikeluarkan				|
				|______________________________________________________________________________*/	
				
					var _tracker = parseInt($('#tracker001').val());
					if (_tracker == 0) {_tracker = 1;}
					if ($("#chkBox10").attr('checked') == true) {
						while ($('#harga_' + _tracker).val() == 0 && _tracker > 0) {
							_tracker = _tracker - 1;
						}
					}
					if ($("#chkBox10").attr('checked') == true && parseInt($('#trackhargatemp').val()) > parseInt($('#harga_' + _tracker).val()))
					{
						alert('Barang yg anda pilih melebihi harga barang sebelumnya');
					} else {
				
				/*______________________________________________________________________________
				|																				|
				|				End Of Kode yg bisa brubah2 tergantung promonya					|
				|______________________________________________________________________________*/
				
					var out = '';
					out += '<sup>(Free)</sup>Banyaknya<br>';
					out += '<input type="hidden" id="hitfree10" name="hitfree10[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
					
					out += '<input id="barang_'+idx+'_intid_barang" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly/>';
					out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
					out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
					out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="0" readonly>';
					out += '<input id="barang_free_'+idx+'_intid_id" name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
					out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					out += '<input type="hidden" id="freeCombo'+idx+'" size="3" value="'+$("#comboPaketRulesPoint").val()+'" readonly/>';
					out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a> ';
					out = '<div style="height:60px">' + out + '</div>';
					$(out).insertAfter('#ButtonAdd');
					idx++;
					idxf++;
					$('.id1').val('');
					$('#harga_barang').val('');
				}
			}
			return false;
    	});

/*______________________________________________________________________
|																		|
|																		|
|																		|
|																		|
|								Kode Baru								|
|																		|
|																		|
|																		|
|______________________________________________________________________*/

	/*
	* auto complete handler	
	*/
	function autoComp() {
		if ($("#chkBox20").attr('checked') == true) {
			if ($("#tracker002").val() == "bayar")
			{
				autoCompPromo20Bayar();
			} else if ($("#tracker002").val() == "free") {
				autoCompPromo20Free();
			}
		} else if ($("#chkBox10").attr('checked') == true) {
			if ($("#tracker002").val() == "bayar")
			{
				autoCompPromo10Bayar();
			} else if ($("#tracker002").val() == "free") {
				autoCompPromo10Free();
			}
		} else if($("#comboCheckPoint").val() != "") {
			if ($("#tracker002").val() == "bayar")
            {
                load_db_promo_combo();
            } else if ($("#tracker002").val() == "free") {
                load_db_promo_combo_free();
            }
		}else{
                autoCompPromo10Bayar();
        }
	}
    /*
	* auto complete bwt promo 20 yg bayar	
	*/
	function autoCompPromo20Bayar() {
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangPromo20",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#tulipormetal').val(),

                            },
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
						if ($(".id1").val() == "") { $('#tulipormetal').attr("disabled",""); }
						else { $('#tulipormetal').attr("disabled","disabled"); }
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });
	}
	/*
	* auto complete bwt promo 20 yg free	
	*/
	function autoCompPromo20Free() {
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree20",
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
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
					);
                    },
                });
	}
	/*
	* auto complete bwt promo 10 yg bayar	
	*/
	function autoCompPromo10Bayar(){
                $(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#tulipormetal').val(),

                            },
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
						if ($(".id1").val() == "") { $('#tulipormetal').attr("disabled",""); }
						else { $('#tulipormetal').attr("disabled","disabled"); }
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
                    );
                    },
                });
	}
	/*
	* auto complete bwt promo 10 yg free	
	*/
	function autoCompPromo10Free() {
                $(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
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
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='trackhargatemp' name'trackhargatemp' value='" + ui.item.value1 + "' readonly />"
                    );
                    },
                });
	}

	/*
	* jenis penjualan combobox handler	
	*/
	$('#intid_jpenjualan').change(function(){
		$('#txtpromo10').val('');
		$("#chkBox10").removeAttr("disabled");
		$("#chkBox20").removeAttr("disabled");
		if ($("#chkSmart").attr("checked") == true && $('#intid_jpenjualan').attr('value')!= 1) {
			$("#chkBox10").attr("checked",false);
			$("#chkBox20").attr("checked",false);
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
		}
		
		kali();
		
		if ($('#intid_jpenjualan').attr('value')== 1)
		{
			var title = "Nota Penjualan Reguler";
			$('#title').text(title);
		}
		else if ($('#intid_jpenjualan').attr('value')== 2) {
			var title = "Nota Penjualan Chall Hut";
			$('#title').text(title);
			$('#intpv').val(0);
		}
		else if ($('#intid_jpenjualan').attr('value')== 3) {
			var title = "Nota Penjualan Challenge";
			$('#title').text(title);
		}
	});	

	/*
	* promo checklist handler
	*/
	$("#chkBox20").click(function(){
		$("#chkBox10").attr("checked",false);
		//$("#txtpromo10").val("");
		$("#txtpromo20").val("");
		//$("#txtpromo10").attr("disabled","disabled");
		$("#chkV10").attr("disabled","disabled");
		if($("#chkBox20").attr('checked') == true){
			$("#chkBox10").attr("checked",false);
			//$("#txtpromo10").val("");
			$("#txtpromo20").val("");
			//$("#txtpromo10").attr("disabled","disabled");
			$("#chkV10").attr("disabled","disabled");
			count = document.getElementsByName("hit20[]").length;
			var jmlbrg = parseInt($('#jumlahbrg20').val());
			var textpromo20 = parseInt($("#txtpromo20").val());
			$("#txtpromo20").attr("disabled","");
			if ($('#txtvoucher').val()==1){
				$("#chkV20").attr("disabled","disabled");
			} else {
				$("#chkV20").attr("disabled","");
			}
		}else{
			$('#addBrg').removeAttr('disabled');
			$('.id1').removeAttr('disabled');
			$('.frees').attr('disabled', 'disabled');
			$("#txtpromo20").attr("disabled","disabled");
			$("#chkV20").attr("disabled","disabled");
		}
		autoComp();
		kali();
	});
	$("#txtpromo20").keyup(function(){
		$('#addBrg').removeAttr('disabled');
		$('.id1').removeAttr('disabled');
	});
	$("#chkBox10").click(function(){
		$("#chkBox20").attr("checked",false);
		$("#txtpromo20").val("");
		//$("#txtpromo10").val("");
		$("#txtpromo20").attr("disabled","disabled");
		$("#chkV20").attr("disabled","disabled");
        	if($("#chkBox10").attr("checked") == true){
			$("#chkBox20").attr("checked",false);
			$("#txtpromo20").val("");
			//$("#txtpromo10").val("");
			$("#txtpromo20").attr("disabled","disabled");
			$("#chkV20").attr("disabled","disabled");
           		$("#txtpromo10").attr("disabled","");
			if ($('#txtvoucher').val()==1){
				$("#chkV10").attr("disabled","disabled");
			} else {
				$("#chkV10").attr("disabled","");
			}
        	}else{
            		$('#addBrg').removeAttr('disabled');
            		$('.id1').removeAttr('disabled');
            		$(".frees").attr("disabled","disabled");
            		//$("#txtpromo10").attr("disabled","disabled");
			$("#chkV10").attr("disabled","disabled");
        	}
		autoComp();
		kali();
	});
	$("#txtpromo10").keyup(function(){
		$('#addBrg').removeAttr('disabled');
		$('.id1').removeAttr('disabled');
		var _totalQuantity10 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.sepuluh_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh_'+ i).val()) != '')
				{
					_totalQuantity10 += parseInt($('.sepuluh_'+ i).val());
				}
			}
		}
		if ($("#txtpromo10").val() > (_totalQuantity10 / 2).toFixed(0))
		{
			alert("Jumlah voucher melebihi jumlah barang");
			$("#txtpromo10").val(0);
		}
		else
		{
			kali();
		}
	});

	/*
	* voucher checklist handler
	*/
	$('#chkV').click(function(){
		if ($('#totalBayar').val() != '')
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			if ($('#chkV').attr('checked') == false)
			{
				$('#intvoucher').val(0);
                kali();
			} else {
				kali();
				$('#intvoucher').val(_voucher);
			}
		}
    });
	
	/*
	* smart spending checklist handler
	*/
	$('#chkSmart').click(function(){
		if ($("#chkSmart").attr("checked") == true)
		{
			if ($('#intid_jpenjualan').attr('value') == 2 || $('#intid_jpenjualan').attr('value') == 3)
			{
				$("#chkBox10").attr("checked",false);
				$("#chkBox20").attr("checked",false);
				$("#chkBox10").attr("disabled","disabled");
				$("#chkBox20").attr("disabled","disabled");
				autoComp();
			}
			document.getElementById("charge").style.display = '';
			document.getElementById("cash").style.display = 'none';
			document.getElementById("debit").style.display = 'none';
			document.getElementById("kkredit").style.display = 'none';
			document.getElementById("sisa").style.display = 'none';
			kali();
		} else {
			$("#chkBox10").removeAttr("disabled");
			$("#chkBox20").removeAttr("disabled");
			document.getElementById("charge").style.display = 'none';
			document.getElementById("cash").style.display = '';
			document.getElementById("debit").style.display = '';
			document.getElementById("kkredit").style.display = '';
			document.getElementById("sisa").style.display = '';
			kali();
		}
    });
		
	/*
	* search database brp barang free yg boleh dikeluarkan untuk barang id ini
	*/
	function ajaxgila(id) {
		
		$(function(){
			var dataString = $("input#id_barang").val($('#barang_'+id+'_intid_id').val());
			$.ajax({
						url: "<?php echo base_url(); ?>penjualan/lookuptracker003",
						type: 'POST',
						data: dataString,
						success:function(data){
							$('#tracker003_'+ id).val(data);
						}
			});			
		});
	}
	
	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kali(id){
		
		//bikin semua textbox bernilai 0
		$('#intjumlah1').val(0);
		$('#intjumlah2').val(0);
		$('#intjumlah').val(0);
		$('#intjumlah1hidden').val(0);
		$('#intjumlah2hidden').val(0);
		$('#intvoucher').val(0);
		$('#intpv').val(0);
		$('#komisi1').val(0);
		$('#komisi2').val(0);
		$('#komisi1hidden').val(0);
		$('#komisi2hidden').val(0);
		$('#komisihide').val(0);
		$('#totalbayar').val(0);
		$('#totalbayar1').val(0);
		$('#intcash').val('');
		$('#intdebit').val('');
		$('#intkkredit').val('');

		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}		

		//itung jumlah barang normal total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityNormal = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.semua_'+ i).val()) >= 0) {
				if (parseInt($('.semua_'+ i).val()) != '')
				{
					_totalQuantityNormal += parseInt($('.semua_'+ i).val());
				}
			}
		}
		//itung jumlah barang omset 10 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity10 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.sepuluh_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh_'+ i).val()) != '')
				{
					_totalQuantity10 += parseInt($('.sepuluh_'+ i).val());
				}
			}
		}
		//itung jumlah barang omset 20 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity20 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.duapuluh_'+ i).val()) >= 0) {
				if (parseInt($('.duapuluh_'+ i).val()) != '')
				{
					_totalQuantity20 += parseInt($('.duapuluh_'+ i).val());
				}
			}
		}
        //itung jumlah barang omset 10 combo total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
        var _totalQuantitycombo = 0;
        for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
            if (parseInt($('.combo_'+ i).val()) >= 0) {
                if (parseInt($('.combo_'+ i).val()) != '')
                {
                    _totalQuantitycombo += parseInt($('.combo_'+ i).val());
                }
            }
        }
		//itung jumlah barang free total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.free_'+ i).val()) >=0) {
				if (parseInt($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseInt($('.free_'+ i).val());
				}
			}
		}

		//harga total barang normal setelah harga dikalikan dengan jumlah
		var _totalHargaNormal = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('.semua_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('.semua_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.semua_'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHargaNormal += parseInt($('#total_' + i).val());
			}
		}
		//harga total barang omset 10 setelah harga dikalikan dengan jumlah
		var _totalHarga10 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('.sepuluh_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('.sepuluh_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.sepuluh_'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHarga10 += parseInt($('#total_' + i).val());
			}
		}
		//harga total barang omset 20 setelah harga dikalikan dengan jumlah
		var _totalHarga20 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('.duapuluh_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('.duapuluh_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.duapuluh_'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHarga20 += parseInt($('#total_' + i).val());
			}
		}
        //harga total barang omset 10 setelah harga dikalikan dengan jumlah
        var _totalHargacombo = 0;
        for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
            if($('.combo_'+ i).val() == '') {
                $('#total_' + i).val(0);
            } else if (parseInt($('.combo_'+ i).val()) >= 0) {
                $('#total_' + i).val(parseInt($('.combo_'+ i).val()) * parseInt($('#harga_' + i).val()));
                _totalHargacombo += parseInt($('#total_' + i).val());
				///pengecekan jumlah voucher 
				if(parseInt($('#nominal_voucher_'+i).val()) > parseInt($(".combo_"+i).val())){
					$('#nominal_voucher_'+i).val('');
					$('#voucher_'+i).removeAttr('checked');
					alert("Voucher tidak sesuai dengan paket.");
					}
            }
        }

		/*______________________________________________________________________________
		|																				|
		|					Kode yg bisa brubah2 tergantung promonya					|
		|______________________________________________________________________________*/
		///pengecekan apakah voucher lebih besar dari paket barangnya
		//@proses_pengecekan_jumlah_voucher
		//console.log("@proses_pengecekan_jumlah_voucher starting.. ");
		for (var i = 0; i <= parseInt($('#tracker001').val()); i++) {
			console.log("@proses_pengecekan_jumlah_voucher 1");
			if(!isNaN($(".combo_"+i).val()) && !isNaN($('#nominal_voucher_'+i).val())){
			//console.log("@proses_pengecekan_jumlah_voucher 2");
				if($('#nominal_voucher_'+i).val() > $(".combo_"+i).val()){
					$('#nominal_voucher_'+i).val(0);
					alert("Voucher tidak sesuai dengan paket.");
					}
				}
			}
		//console.log("@proses_pengecekan_jumlah_voucher ending.. ");
		
		//hitung jumlah total barang free yg boleh dikeluarkan
		var _tempCount = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh_'+ i).val()) > 0) {
					_tempCount += parseInt($('.sepuluh_'+ i).val()) / 2;
				}
				else if (parseInt($('.duapuluh_'+ i).val()) > 0 && $("#chkSmart").attr("checked") != true) {
					_tempCount += parseInt($('#tracker003_'+ i).val()) * parseInt($('.duapuluh_'+ i).val());
				}
                else if(parseInt($('.combo_'+ i).val()) > 0 && $("#comboCheck"+i).val() != "1fre0"){ // total free combo
                    _tempCount += parseInt($('#tracker003_combo_'+ i).val()) * parseInt($('.combo_'+ i).val());
                    console.log("starting free  : "+$('#tracker003_'+ i).val()+ " + "+$('.combo_'+ i).val());
                }
			}
		}
		$('#tracker004').val(Math.floor(_tempCount));
        //console.log("free : "+$('#tracker004').val()+" : "+_totalQuantityFree);

		//cek apakah jumlah barang bayar dan free sudah benar
		if ($('#tracker004').val() > _totalQuantityFree) {
			alert("Silakan pilih barang free");
			$('#tracker002').val("free");
			load_db_promo_combo_free();
            //$(".id1").focus();
		} else if ($('#tracker004').val() == _totalQuantityFree) {
			$('#tracker002').val("bayar");
		} else if ($('#tracker004').val() < _totalQuantityFree) {
			alert("Jumlah barang free melebihi quota");
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				$('.free_'+ i).val('');
			}
		}
		
		
		//kurangi harga total barang dengan checklist voucher di tiap detail barang
		var _v = 0;
		var _totalv = 0;
		if ($('#id_wilayah').val() == 1){
			_v = 50000;
		} else {
			_v = 60000;
		}
        //@proses_hitung_voucher
		var _totalv10 = parseInt($('#txtpromo10').val()) * _v;
		if(isNaN(_totalv10)){
			_totalv10 = 0;
		}
		
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
		
			if(!isNaN($('#nominal_voucher_'+i).val())){
					_temp_voucher = parseInt($('#nominal_voucher_'+i).val());
				}else{
					_temp_voucher = 0;
				}
				
			if ($('#id_wilayah').val() == 1){
				//jika nominal sama dengan NaN berarti diset 0
				
				_v = 50000 * _temp_voucher;
			} else if($('#id_wilayah').val() == 2) {
				
				_v = 60000 * _temp_voucher;
			}
			/*
			if (parseInt($('.sepuluh_'+ i).val()) >= 0 && _totalv10 > 0)
			{
				/*$('#total_' + i).val(parseInt($('#total_' + i).val()) - _v);
				if (parseInt($('#total_' + i).val()) < 0)
				{
					_v = parseInt($('.sepuluh_' + i).val()) * parseInt($('#harga_'+ i).val());
					$('#total_' + i).val(0);
				}*//*
				if (parseInt($('#total_' + i).val()) - _totalv10 < 0)
				{
					_totalv10 -= parseInt($('#total_' + i).val());
					_totalHarga10 -= parseInt($('#total_' + i).val());
					_totalv += parseInt($('#total_' + i).val());
					$('#total_' + i).val(0);
				}
				else
				{
					_totalHarga10 -= _totalv10;
					_totalv += _totalv10;
					$('#total_' + i).val(parseInt($('#total_' + i).val()) - _totalv10);
					_totalv10 = 0;
				}
			}
			*/
			if ($('#voucher_'+ i).attr("checked") == true) {
              //  console.log("@proses_hitung_voucher starting.. ");
				if (parseInt($('.duapuluh_'+ i).val()) >= 0)
				{
					$('#total_' + i).val(parseInt($('#total_' + i).val()) - _v);
					if (parseInt($('#total_' + i).val()) < 0)
					{
						_v = parseInt($('.duapuluh_' + i).val()) * parseInt($('#harga_'+ i).val());
						$('#total_' + i).val(0);
					}
					_totalHarga20 -= _v;
					_totalv += _v;
				}
				else if (parseInt($('.semua_'+ i).val()) >= 0) {
					$('#total_' + i).val(parseInt($('#total_' + i).val()) - _v);
					if (parseInt($('#total_' + i).val()) < 0)
					{
						_v = parseInt($('.semua_' + i).val()) * parseInt($('#harga_'+ i).val());
						$('#total_' + i).val(0);
					}
					_totalHargaNormal -= _v;
					_totalv += _v ;
				}

                else if (parseInt($('.combo_'+ i).val()) >= 0) {
                    $('#total_' + i).val(parseInt($('#total_' + i).val()) - _v);
                    if (parseInt($('#total_' + i).val()) < 0)
                    {
                        _v = parseInt($('.combo_' + i).val()) * parseInt($('#harga_'+ i).val());
                        $('#total_' + i).val(0);
                    }
                    _totalHargacombo -= _v;
                    _totalv += _v;
                   // console.log("@proses_hitung_voucher voucher combo : "+_totalv+", "+_totalHargacombo);
                }
			 
            //console.log("@proses_hitung_voucher ending.. ");
            }
		}
		
		$('#intvoucher').val(_totalv);
		
		if (($("#chkBox10").attr("checked") == true || $("#chkBox20").attr("checked") == true) && parseInt($('#tracker001').val()) != 0)
		{
			$("#chkSmart").attr("disabled","disabled");
		}

		/*______________________________________________________________________________
		|																				|
		|				End Of Kode yg bisa brubah2 tergantung promonya					|
		|______________________________________________________________________________*/

		//total semua harga barang yg di order di nota ini
		var _total = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('#total_'+ i).val()) >= 0)
				{
					_total += parseInt($('#total_'+ i).val());
				}
			}
		}

		//masukin total harga ke textbox bawah yg diatas tombol simpan
		$('#intjumlah1').val(_totalHarga10 + _totalHargacombo);
		$('#intjumlah2').val(_totalHarga20 + _totalHargaNormal);
		$('#intjumlah').val(parseInt($('#intjumlah1').val()) + parseInt($('#intjumlah2').val()));
		$('#totalbayar').val(parseInt($('#intjumlah').val()));

		//total semua pv yg di didapat di nota ini
        //@proses_PV

		var _totalPV = 0.00;
		if ($('#intid_jpenjualan').attr('value') != 2)
		{
			var _vpv = 0;
			if ($('#id_wilayah').val() == 1){
				_vpv = 0.5;
			} else {
				_vpv = 0.6;
			}
            //console.log("@proses_PV tracker001 : "+$('#tracker001').val());
			//var _vpv10 = parseInt($('#txtpromo10').val()) * _vpv;
			var _vpv10 = 0;
            for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				if (parseFloat($('#pv_'+ i).val()) > 0) {
					//_totalPV += (parseInt($('#total_'+ i).val()) / parseInt($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
					_totalPV += parseFloat($('#pv_'+ i).val()) * parseInt($('#'+ i).val());
                    //console.log("@proses_PV _totalPV _1 : "+_totalPV+", "+$('#pv_'+ i).val()+", "+$('#'+ i).val());
                    if ($('#voucher_'+ i).attr("checked") == true)
					{
                        if(!isNaN($('#nominal_voucher_'+ i).val())){ //pengurangan di voucher
                             if ($('#id_wilayah').val() == 1){
                                _vpv = 0.5 * parseFloat($('#nominal_voucher_'+ i).val());
                                } else {
                                    _vpv = 0.6 * parseFloat($('#nominal_voucher_'+ i).val());
                                }     

                               // console.log("@proses_PV _totalPV _1. 1 : "+_totalPV+", "+_vpv+" ");
                        }
                        else{
                            if ($('#id_wilayah').val() == 1){
                                _vpv = 0.5;
                                } else {
                                    _vpv = 0.6;
                                }
                               // console.log("@proses_PV _totalPV _1. 2 : " +_totalPV+", "+_vpv+" ");       
                        }
                    
						//jika barang yang dipilih  adalah metal maka vouchernya berkurang setengahnya.
						if($('#tulipormetal').val() == 2){
							_vpv = parseFloat(_vpv) * 0.5;
						}
						if(!isNaN(_vpv))
						{
							_totalPV -= _vpv;
						}
					}
                 //   console.log("@proses_PV _totalPV _2 : "+_totalPV + " , "+_vpv+" ");
				}
			}
			$('#intpv').val(_totalPV.toFixed(2));
		}else{
		//line ikhlas tambahan 13042013
			$('#intpv').val(0);
		///ending/////
		}

		//hitung komisi 10% dan kurangi totalbayar
		if ($('#intjumlah1').val() != '')
		{
			$('#komisi1').val(parseInt($('#intjumlah1').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi1').val()));
		}

		//hitung komisi 20% dan kurangi totalbayar
		if ($('#intjumlah2').val() != '')
		{
			$('#komisi2').val(parseInt($('#intjumlah2').val()) * 0.2);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi2').val()));
		}
		
        //@proses_voucher_tunggal
		//apabila voucher di checklist
		if ($("#chkV").attr('checked') == true)
		{
           /// console.log("@proses_voucher_tunggal starting..");
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			
            $('#intvoucher').val(_voucher);

			if ($('#intjumlah1').val() != '' && $('#intjumlah1').val() != 0)
			{
				$('#intjumlah1').val(parseInt($('#intjumlah1').val()) - _voucher);
			} else {
				$('#intjumlah2').val(parseInt($('#intjumlah2').val()) - _voucher);
			}
			$('#intjumlah').val(parseInt($('#intjumlah').val()) - _voucher);
////999
			//line ikhlas 13042013
			//agar challance hut tidak memiliki pv
			if ($('#intid_jpenjualan').attr('value') != 2){
				if($('#tulipormetal').val() == 1){
					$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 100000));
				} else if($('#tulipormetal').val() == 2){
					$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 200000));
				}
			}
			///ending
			if ($('#komisi1').val() != '' && $('#komisi1').val() != 0)
			{
				$('#komisi1').val(parseInt($('#komisi1').val()) - (_voucher * 0.1));
			} else {
				$('#komisi2').val(parseInt($('#komisi2').val()) - (_voucher * 0.2));
			}
			$('#totalbayar').val((parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val())) - parseInt($('#komisi2').val()));
		  
         //   console.log("@proses_voucher_tunggal ending..");
        }
		
		//apabila smart spending di checklist
		if ($("#chkSmart").attr("checked") == true) {
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			if (parseInt($('#intjumlah').val()) < 500000) {
				$('#charge3').val(parseInt($('#intjumlah').val()) * 0.03);
				$("#asi").empty();
			} else {
				$('#charge3').val(0);
                $("#asi").append('<input type="hidden" name="is_asi" id="is_asi" value="on" />');
			}
			$('#totalbayar').val(parseInt($('#intjumlah').val()) + parseInt($('#charge3').val()));
			$('#intkkredit').val($('#totalbayar').val());
			$('#intkomisiasi').val(Math.floor((_totalHargaNormal * 0.17) + (_totalHarga10 * 0.07) + (_totalHarga20 * 0.17)));
		}

		//kirim smua hasil hitungan ke textbox hidden yg akan di submit ke halaman berikutnya yaitu print
		$('#intjumlah1hidden').val($('#intjumlah1').val());
		$('#intjumlah2hidden').val($('#intjumlah2').val());
		$('#intjumlahhidden').val($('#intjumlah').val());
		$('#komisi1hidden').val($('#komisi1').val());
		$('#komisi2hidden').val($('#komisi2').val());
		$('#totalbayar1').val($('#totalbayar').val());

		//format smua angka as rupiah
		$('#intjumlah1').val(formatAsRupiah(parseInt($('#intjumlah1').val())));
		$('#intjumlah2').val(formatAsRupiah(parseInt($('#intjumlah2').val())));
		$('#intjumlah').val(formatAsRupiah(parseInt($('#intjumlah').val())));
		$('#komisi1').val(formatAsRupiah(parseInt($('#komisi1').val())));
		$('#komisi2').val(formatAsRupiah(parseInt($('#komisi2').val())));
		$('#charge3').val(formatAsRupiah(parseInt($('#charge3').val())));
		$('#totalbayar').val(formatAsRupiah(parseInt($('#totalbayar').val())));

		//hitung sisa pembayaran
		sisa();

		//jalankan auto complete handler
		autoComp();
		
		return false;
	}

	/**
	* function kali_sepuluh yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kali_sepuluh(id) {
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}
		
		//itung jumlah barang free total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
		
			if (parseInt($('.free_'+ i).val()) >=0 && parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseInt($('.free_'+ i).val());					
				}
			}
		}
		//patokan bnyaknya barang 
		var _temp = 0;
		for (var i = 0; i <= parseInt($('#tracker001').val()); i++) {
		
			if (parseInt($('.combo_'+ i).val()) >=0) {
			if($("#comboCheck"+i).val() == "1fre0"){
				_temp += parseInt(0) * parseInt($(".combo_"+i).val());
				}
				else if($("#comboCheck"+i).val() == "1fre1"){
					_temp += parseInt(1) * parseInt($(".combo_"+i).val());
					}
					else if($("#comboCheck"+i).val() == "1fre2"){
						_temp += parseInt(2) * parseInt($(".combo_"+i).val());
						}
						else if($("#comboCheck"+i).val() == "1fre3"){
							_temp += parseInt(3) * parseInt($(".combo_"+i).val());
							}
							
			}
		}
		
		
		if (_temp > _totalQuantityFree) {
			alert("Anda masih boleh memilih barang free");
			$('#tracker002').val("free");
		} else if (_temp == _totalQuantityFree) {
			alert("Silakan pilih promo berikutnya");
			$('#tracker002').val("bayar");
			load_db_promo_combo();
            _statepromo10 = 0;
            //$(".id1").focus();
            
		} else if (_temp < _totalQuantityFree) {
			alert("Jumlah barang free melebihi quota");
			$('.free_'+ id).val('');
		}
		
		//jalankan auto complete handler
		autoComp();
		
		return false;
	}
	
	/**
	* function sisa yg baru
	*/
	function sisa() {
		var _cash = 0;
		var _kredit = 0;
		var _debit = 0;
		$("input[type=submit]").removeAttr("disabled");
		if ($('#intcash').val() == '' && $('#intkkredit').val() == '' && $('#intdebit').val() == '')
		{
			$('#intsisa').val('');
			$('#intsisahidden').val('');
			$("input[type=submit]").attr('disabled','disabled');
		}
		else {
			if ($('#intcash').val() != '') {_cash = parseInt($('#intcash').val());}
			if ($('#intkkredit').val() != '') {_kredit = parseInt($('#intkkredit').val());}
			if ($('#intdebit').val() != '') {_debit = parseInt($('#intdebit').val());}
			var _bayar = _cash + _kredit + _debit;

			$('#intsisa').val(formatAsRupiah(-(unformatFromRupiah($('#totalbayar').val()) - _bayar)));
			$('#intsisahidden').val(unformatFromRupiah($('#totalbayar').val()) - _bayar);			
			$("input[type=submit]").removeAttr("disabled");
		}
	}

	/**
	* function formatAsRupiah yg baru dan unformatFromRupiah
	* @param amount (angka int yg bakal dirubah ke rupiah)
	*/
	function formatAsRupiah(amount){
        	if (isNaN(amount)) {
            		return "0,00";
        	}
        	amount = Math.round(amount*100)/100;
        	var amount_str = String(amount);
        	var amount_array = amount_str.split(",");
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
        	amount_array[0] = dollar_array.join(".");

        	return (amount_array.join(","));
    	}
	function unformatFromRupiah(_amount){
		var _split = _amount.split(".");
		var _array = 0;
		for(var i = 0; i <= Math.round(((_amount.length - 3) / 3)); i++){
			_array += _split[i - 1];
		}
		if (_array.substr(0,1) == '0')
		{
			_array.substr(1);
			return(parseInt(_array.substr(1)));
		}
		if (_array.substr(0,3) == 'NaN')
		{
			_array.substr(3);
			return(parseInt(_array.substr(3)));
		}
		return (parseInt(_array));
	}

/*______________________________________________________________________
|																		|
|																		|
|																		|
|																		|
|							End Of Kode Baru							|
|																		|
|																		|
|																		|
|______________________________________________________________________*/

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })

	function isNumberKey(evt)
       	{
        	var charCode = (evt.which) ? evt.which : event.keyCode;
          	if (charCode != 46 && charCode > 31 
            		&& (charCode < 48 || charCode > 57))
             	{return false;}

          	return true;
       	}
		
	function reset_form(){
		$("#tracker001").val(0);
		$("#tracker002").val("bayar");
		$("#tracker004").val("");
		$("#result1").html('');
		$("#result2").html('');
		$(".id1").val('');
		$("#intid_unit").val('');
		$("#strnama_dealer").val('');
		$("#strnama_dealer").val('');
		var idx = 0;
		autoComp();
		reset_combo();
			//bikin semua textbox bernilai 0
		$('#intjumlah1').val(0);
		$('#intjumlah2').val(0);
		$('#intjumlah').val(0);
		$('#intjumlah1hidden').val(0);
		$('#intjumlah2hidden').val(0);
		$('#intvoucher').val(0);
		$('#intpv').val(0);
		$('#komisi1').val(0);
		$('#komisi2').val(0);
		$('#komisi1hidden').val(0);
		$('#komisi2hidden').val(0);
		$('#komisihide').val(0);
		$('#totalbayar').val(0);
		$('#totalbayar1').val(0);
		$('#intcash').val('');
		$('#intdebit').val('');
		$('#intkkredit').val('');

	}
</script>
<?php $this->load->view("penjualan/combo/javascript");?>
