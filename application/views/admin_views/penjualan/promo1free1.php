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
		 $(document).ready( function() {
		 //inisialisasi ke bentuk yang seharusnya
			$('#intjumlahOmsethidden').val(0);	//total omset
			$('#intjumlahOmset').val(0);	//total omset
			$('#intjumlah1hidden').val(0);	//osmet10
			$('#intjumlah2hidden').val(0);	//omset20
			$('#intjumlah1').val(0); //omset10
			$('#intjumlah2').val(0);	//omset20
			$('#intjumlahtradehidden').val(0);
			$('#intvoucher').val(0);	//voucher
			$('#jumlahsementara').val(0);
			$('#intkomisiasi').val(0);
			$('#totalbayarhidden').val(0); //total bayar
			$('#totalbayar').val(0);	//total bayar
			$('#komisi1hidden').val(0);
			$('#komisi1').val(0);
			changepilihbarang(1);
			counting_promo();
			$('#tracker001').val(0);
			$('#tracker009_id').val(0);
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
                       	"<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><input type='hidden' align='top' id='intid_dealer' name='intid_dealer' value='" + ui.item.intid_dealer + "' size='15' readonly/><br><td><input type='text' id='nama_upline' name='nama_upline' value='" + ui.item.value2 + "' size='15' readonly/></td>"
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
								key: "1fre1",
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
 function autoComp(){

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatuBayar";
                
                $(".id1").autocomplete({

                    minLength: 5,
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
					focus:
					function(event,ui) {
					var q = $(this).val();
					$(this).val() = q;
					},
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"						
                    );
                        $("#resultpilih").html('1 free 1');
						if ($('#harga_barang').val()<$('#harga').val())
						{
							$('#harga').val($('#harga_barang').val());
						} else {
							$('#harga').val($('#harga').val());
						}

                    },
                });


                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatu",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('#temp_intid_barang').val(),
								key : "1fre1",
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
                        $("#result1").html("<input type='text' id='harga_barang' name='harga_barang' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='0' size='15' />");
                    },
                });

            }
		
		</script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title" style="background-color:#00CCFF; color:#000000; padding: 2px 2px 2px 30px;">Promo 1 Free 1</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota_vers2" method="post" name="frmjual" id="frmjual">
                            <input type="hidden" name="halaman" readonly="readonly" value="1F1">
                        <div id="error"><?php echo validation_errors(); ?></div>	
                            <table width="685" border="0" id="data" align="center"/>
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
                                    <td>&nbsp;<input type="text" id="nomor_nota" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly >
									</td>
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
								</tr>
								
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td>&nbsp;</td>
                              </tr>
                                <tr>
                                    <td colspan="6">&nbsp;
                                    <input type="hidden" id="id_wilayah" value="<?php echo $intid_wilayah;?>" />
                                    
                                        <div align="center" id="title"></div></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><table width="661" border="0" id="data" align="center"  class="formPilihBarang" style="background:#FFFFFF; ">
                                            <tr>
                                                <td width="116">&nbsp;</td>
                                              <td width="367">&nbsp;Nama Barang</td>
                                              <td width="87">Harga</td>
<td width="63" rowspan="3"><div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
														<input type="hidden" name="tracker001" id="tracker001" value="0" size="1" />
														<input type="hidden" id="tracker009_id" value="0" size="1" />
														<input type="hidden" id="temp_intid_barang" value="" readonly />
                                                    </div>    </td>
                                      </tr>
                                            <tr>
													<td><div id="resultpilih">&nbsp;Pilih Barang -&gt;</div>
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
												<div id="field_id1">
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></div>
												<div id="field_frees">
												<input type="text" name="free" class="frees" size="50" /></div></td>
                                  <td><div style="width:80%;height:80%; background-color:#009900;display:block; box-shadow:0 0 3px #000000;">
								  &nbsp;
								  <div id="result1" ></div>
								  </div></td>
                                            </tr>
                                            <tr>
                                                <td><!-- &nbsp;Pilih Barang Free -&gt; --></td>
                                                <td>&nbsp;&nbsp;</td>
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
                                        Rp.<input type="text" name="jml10" id="intjumlah1" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jml20" id="intjumlah2" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jumlahOmset" id="intjumlahOmset" readonly="readonly" value="0"/>
										<input type="hidden" name="jumlahOmsethidden" id="intjumlahOmsethidden" value="0"/>
                                        <input type="hidden" name="intvoucher" id="intvoucher"/>
                                        
                                       </td>
                                        </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly" value="0"/> </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly" value="0"/>
                                        <input type="hidden" name="komisi2hidden" id="komisi2hidden"/>                               </td>
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
                                        <input type="hidden" name="totalbayarhidden" id="totalbayarhidden" />       </td>
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
<script>
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

	//buat ulang hehe
	var idx = 0;
    var idxf=0;
	
	$('#addBrg').bind('click', function(e){
			var promo = '';
			//jenis promo yang dikeluarkan, untuk menjadi judul
			if($('#intid_jpenjualan').val() == 5){
				promo = "1 free 1 HUT/ NET";
			}else if($('#intid_jpenjualan').val() == 6){
				promo = "1 free 1 10%";
			}
			
       if(isNaN($("#harga_barang").val())){
            alert('Anda belum memilih barang dengan Benar!');
        }else if(!isNaN($('#harga_barang').val()) && $('#harga_barang').val()!= 0 && $('#intid_jpenjualan').val() != ""){
			
			var nama_brg = $('.id1').val();
			var jumlah = $('#jumlah').val();
			var harga = $('#harga_barang').val();
			var id_barang =  $('#id_barang').val();
			var pv =  $('#pv').val();
			var total = jumlah * harga;
			var out = '';
			var nomor_nota = $('#nomor_nota').val();
			
			idx = parseInt($('#tracker001').val()) + parseInt(1);
			$('#tracker001').val(idx);
			
			/* percobaan */
			out = '<div id="style_'+idx+'" class="pilihPromo1Free1">Promo '+promo+', Banyaknya<br />';
			out += 'jumlah<input type="button" id="'+idx+'" class="k_'+idx+'" name="kurang" value="-" size="1" onclick="kurang_qty(this.id);" /><input type="text" name="barang['+idx+'][intquantity]" id="'+idx+'" class="main_'+idx+'" min="0" style="width: 50;" size="1" value="0" onkeyUp="operasiHitung(this.id)" onkeypress="return isNumberKey(event)" readonly /><input type="button" id="'+idx+'" class="t_'+idx+'" name="tambah" value="+" size="1" onClick="tambah_qty(this.id);" />, ';
			out += '<input name="barang['+idx+'][nama_barang]" type="text" size="50" value="'+nama_brg+'"  readonly /><br />';
			out += 'Harga  <input id="harga_'+idx+'" name="barang['+idx+'][harga]" type="text" size="10" value="'+harga+'"  readonly />, ';
			out += 'PV  <input id="pv_'+idx+'" name="barang['+idx+'][pv]" type="text" size="1" value="'+pv+'" readonly><br />';
            out += 'Total  <input id="total_'+idx+'" name="barang['+idx+'][total]" type="text" size="1" value="'+pv+'" readonly>';
            out += '<input type="hidden" id="barang_'+idx+'" name="barang['+idx+'][intid_barang]" value="'+id_barang+'" size="2" />';
			out += '<input type="hidden" id="promo_'+idx+'" value="'+$('#intid_jpenjualan').val()+'" size="2" />';
			out += '<div id="child_'+idx+'"></div></div>';
			out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					
			
			$(out).insertAfter('#ButtonAdd');
			idx++;
			$('.id1').val('');
			$('#result1').html('');
			$("#resultpilih").html('Pilih Barang ->');
			
		}else{
			var nama_brg = $('.frees').val();
			var jumlah = $('#jumlah').val();
			var harga = $('#harga_barang').val();
			var id_barang =  $('#id_barang').val();
			var pv =  $('#pv').val();
			var total = jumlah * harga;
			var out = '';
			var nomor_nota = $('#nomor_nota').val();
			
			idx = parseInt($('#tracker001').val()) + parseInt(1);
			$('#tracker001').val(idx);
			
			/* percobaan */
			out = '<div class="pilihPromo1Free1_free"><sup>(Free)</sup>'+promo+' Banyaknya<br>';
			out += 'jumlah<input type="button" id="'+idx+'" class="k_'+idx+'" name="kurang" value="-" size="1" onclick="kurang_qty_free(this.id);" /> <input type="text" name="barang['+idx+'][intquantity]" id="'+idx+'" class="main_'+idx+'" min="0" style="width: 50;" size="1" value="0" onkeyUp="operasiFree(this.id)" onkeypress="return isNumberKey(event)" /><input type="button" id="'+idx+'" class="t_'+idx+'" name="tambah" value="+" size="1" onClick="tambah_qty_free(this.id);" />, ';
			out += '<input type="text" name="barang['+idx+'][nama_barang]" size="50" value="'+nama_brg+'"  readonly /><br />';
			out += 'Harga  <input id="harga_'+idx+'" name="barang['+idx+'][harga]" type="text" size="10" value="'+harga+'"  readonly />, ';
			out += 'PV  <input id="pv_'+idx+'" name="barang['+idx+'][pv]" type="text" size="1" value="'+pv+'" readonly>';
            out += 'Total  <input id="total_'+idx+'" name="barang['+idx+'][total]" type="text" size="1" value="'+pv+'" readonly>';
            out += '<input type="hidden" id="barang_'+idx+'" name="barang['+idx+'][intid_barang]" value="'+id_barang+'" size="2" />';
			out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
			out += '<a href="#hapus" class="delRow" onclick="removepromo(this.id)" id="'+idx+'">hapus</a>';
			out += '<input type="hidden" id="parent_'+idx+'" size="1" value="'+$('#tracker009_id').val()+'">';
			out += '<div id="child_'+idx+'"></div></div>';
					
			
			$(out).insertBefore('#child_'+$('#tracker009_id').val());
			
			idx++;
			$('#result1').html('');
			$('.frees').val('');
			$("#resultpilih").html('Pilih Barang ->');
		}
		return false;
	   });
function operasiHitung(id){
		var colour = 'background-color:#FF0000;';
		
		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		
		var _totalQuantity = $('.main_'+ id).val();
		
		//harga total barang setelah harga dikalikan dengan jumlah
		var _totalHarga = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.main_'+ i).val()) * parseInt($('#harga_' + i).val()));
				if(!isNaN($('.main_'+ i).val()) && $('.main_'+ i).val()== ''){
					$('#total_' + i).val(0);
					}
				_totalHarga += parseInt($('#total_' + i));
			}
		}
		$('#tracker009_id').val(id);
		$('.main_'+id).val(_totalQuantity);
		//mengkunci perubahan jumlah barang reguler
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++){	
			if($('#tracker009_id').val() == i){
				$('.main_'+i).attr('disabled',false);
				$('.t_'+i).attr('disabled',false);
				$('.k_'+i).attr('disabled',false);
				}else{
				$('.main_'+i).attr('disabled',true);
				$('.t_'+i).attr('disabled',true);
				$('.k_'+i).attr('disabled',true);
				}
		}
		
		$('#style_'+id).attr('style',colour);
		$('#temp_intid_barang').val($('#barang_'+id).val());
		changepilihbarang(2);
		//alert('Silahkan masukan barang free! sejumlah '+_totalQuantity);
		counting_promo();
}
function operasiFree(id){
	var colour = 'background-color:#FFFF00;';
	var _check = $('#parent_'+id).val();
	var _tempQuantity = $('.main_'+_check).val();
	var _tempfreeQuantity = 0;
	var tempfree = $('.main_'+id).val();
	
	var tempparent = $('.main_'+_check).val();
	//alert(' id :'+id+', check :'+_check);
	//alert('hello _child :'+templagilagi+', _parent :'+templagi+'');
	if( tempfree > tempparent ){
		alert('jumlah barang free melebihi jumlah penjualan barang!');
		$('.main_'+id).val(0);
	}else{
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {			
			if( _check == $('#parent_'+i).val()){
				/////pengujian penambahan quantity
				_tempfreeQuantity += parseInt($('.main_'+i).val());
				//alert('penjumlahan'+_tempfreeQuantity+'');
				
				}
			}
			//alert('looping :'+$('#parent_'+i).val()+', cek :'+_check+'');
			if( _tempfreeQuantity == tempparent){
					//alert('barang free sudah maksimal');
					
					//mengkunci perubahan jumlah barang reguler
					for (var i = 1; i <= parseInt($('#tracker001').val()); i++){	
						$('.main_'+i).attr('disabled',false);	
						$('.t_'+i).attr('disabled',false);	
						$('.k_'+i).attr('disabled',false);
					}
					$('#style_'+_check).attr('style',colour);
					changepilihbarang(1);
			}
	}
	counting_promo();
}
function changepilihbarang(or){
	if(or == 1){
		$('#field_id1').show();
		$('#field_frees').hide();
	}else if(or == 2){
		$('#field_id1').hide();
		$('#field_frees').show();
	}
}
function counting_promo(){

	var _temphitung =	0;
	var _jumlahOmset	=	0;
	var _intjumlah1	=	0;
	var _intjumlah2	=	0;
	var _totalbayar	=	0;
	var _komisi10	=	0;
	//kode yang akan diubah sesuai dengan promo
	for(var i = 1; i <= $('#tracker001').val();i++){
		//alert('i : '+i+' '+$('#promo_'+i).val());
		if(parseInt($('#promo_'+i).val()) > 0){
			// 1 free 1 net
			if($('#promo_'+i).val() == 5){
					_totalbayar += parseInt($('.main_'+i).val()) * parseInt($('#harga_'+i).val());
				}
				// 1 free 1 10%
				else if($('#promo_'+i).val() == 6){
				
					_jumlahOmset += parseInt($('.main_'+i).val()) * parseInt($('#harga_'+i).val());
					_komisi10 += parseInt(_jumlahOmset) * 0.1;
					_totalbayar += parseInt(_jumlahOmset) - parseInt(_komisi10);
					//alert('jumlahOmset '+_jumlahOmset+', komisi10 '+_komisi10);
				}
			}
	}
	/*
		$('#intjumlahOmsethidden').val(parseInt(_jumlahOmset)+parseInt($('#intjumlahOmsethidden').val()));	//total omset
		$('#intjumlahOmset').val(formatAsRupiah($('#intjumlahOmsethidden').val()));	//total omset
		$('#intjumlah1hidden').val(parseInt(_intjumlah1)+parseInt($('#intjumlah1hidden').val()));	//osmet10
		$('#intjumlah2hidden').val(parseInt(_intjumlah2)+parseInt($('#intjumlah2hidden').val()));	//omset20
		$('#intjumlah1').val(formatAsRupiah($('#intjumlah1hidden').val())); //omset10
		$('#intjumlah2').val(formatAsRupiah($('#intjumlah2hidden').val()));	//omset20
		$('#intjumlahtradehidden').val();
		$('#intdebit').attr('readonly',true); //debit otomatis
		$('#intkkredit').attr('readonly',true); //kredit otomatis
		$('#intvoucher').val();	//voucher
		$('#jumlahsementara').val();
		$('#intkomisiasi').val();
		$('#totalbayarhidden').val(parseInt(_totalbayar)+parseInt($('#totalbayarhidden').val())); //total bayar
		$('#totalbayar').val(formatAsRupiah(_totalbayar));	//total bayar
		$('#komisi1hidden').val(parseInt(_komisi10)+parseInt($('#komisi1hidden').val()));
		$('#komisi1').val(formatAsRupiah($('#komisi1hidden').val()));
	*/
		$('#intjumlahOmsethidden').val(parseInt(_jumlahOmset));	//total omset
		$('#intjumlahOmset').val(formatAsRupiah($('#intjumlahOmsethidden').val()));	//total omset
		$('#intjumlah1hidden').val(parseInt(_intjumlah1));	//osmet10
		$('#intjumlah2hidden').val(parseInt(_intjumlah2));	//omset20
		$('#intjumlah1').val(formatAsRupiah($('#intjumlah1hidden').val())); //omset10
		$('#intjumlah2').val(formatAsRupiah($('#intjumlah2hidden').val()));	//omset20
		$('#intjumlahtradehidden').val();
		$('#intdebit').attr('readonly',true); //debit otomatis
		$('#intkkredit').attr('readonly',true); //kredit otomatis
		$('#intvoucher').val();	//voucher
		$('#jumlahsementara').val();
		$('#intkomisiasi').val();
		$('#totalbayarhidden').val(parseInt(_totalbayar)); //total bayar
		$('#totalbayar').val(formatAsRupiah(_totalbayar));	//total bayar
		$('#komisi1hidden').val(parseInt(_komisi10));
		$('#komisi1').val(formatAsRupiah($('#komisi1hidden').val()));
}
function sisa() {
		var _cash = 0;
		var _kredit = 0;
		var _debit = 0;
		
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
function removepromo(id){
	$('.main_'+id).val('');
	$('#'+id).parent().remove();
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
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
function kurang_qty(id){
		var _tempQ = 0;
		for(var i = 1; i <= parseInt($('#tracker001').val()); i++){
			if($('#parent_'+i).val() == id){
			_tempQ = parseInt($('.main_'+i).val()) + parseInt(_tempQ);
			}
			//alert('i: '+i);
		}
		if(parseInt($('.main_'+id).val()) > parseInt(_tempQ)){
			if(parseInt($('.main_'+id).val()) > 1){
			$('.main_'+id).val(parseInt($('.main_'+id).val()) - parseInt(1));
			}
		operasiHitung(id);		
		}
		for(var i =1; i<= parseInt($('#tracker001').val()); i++){
			operasiFree(i);
		}
}
function kurang_qty_free(id){
	if(parseInt($('.main_'+id).val()) > 1){
			$('.main_'+id).val(parseInt($('.main_'+id).val()) - parseInt(1));
		}
		operasiFree(id);
}
function tambah_qty(id){
	if(isNaN($('.main_'+id).val())){
		$('.main_'+id).val(0);
	}
	$('.main_'+id).val(parseInt($('.main_'+id).val()) + parseInt(1));
	operasiHitung(id);
}
function tambah_qty_free(id){
	if(isNaN($('.main_'+id).val())){
		$('.main_'+id).val(0);
	}
	$('.main_'+id).val(parseInt($('.main_'+id).val()) + parseInt(1));
	operasiFree(id);
}
</script>

