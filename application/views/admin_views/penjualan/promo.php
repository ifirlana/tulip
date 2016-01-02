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
				$('#intid_jbarang').removeAttr('disabled','disabled');//remove attr jenis barang
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

            //for barang

            function autoComp(){

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarangPromo10_jbarang";
                
                $(".id1").autocomplete({

                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: ur,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                intid_jbarang: $('#intid_jbarang').val(),
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
						
                    );
						
						if ($('#harga_barang').val()<$('#harga').val())
						{
							$('#harga').val($('#harga_barang').val());
						} else {
							$('#harga').val($('#harga').val());
						}

                    },
                });


                $(".frees").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree10",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('#harga').val(),
                                intid_jbarang: $('#intid_jbarang').val(),
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
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });
			/*
                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('#harga').val(),
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
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });
*/

            }

 </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">2 Free 1 Termurah</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota" method="post" name="frmjual" id="frmjual">
                            <input type="hidden" name="halaman" readonly="readonly" value="2F1T">
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
                                    <td>&nbsp;<input type="text" id="nomor_nota" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly ><input type="hidden" id="harga" name="harga" size="15" value="3498000"/></td>
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
                                    <td>Jenis Barang</td>
                                    <td><select name="intid_jbarang" id="intid_jbarang">
                                            <?php
                                            for($i=0;$i<count($strnama_jbarang);$i++) {
													echo "<option value='$intid_jbarang[$i]'>$strnama_jbarang[$i]</option>";
											}
                                            ?></td>
                                    <td colspan="3">Voucher</td>
                                    <td>
                                        <input type="checkbox" name="chkV" id="chkV" /></td>
                                    <input type="hidden" id="jumlahbrgfree"> 
                              </tr>
								<tr>
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Smart Spending</td>
									<td><input type="checkbox" name="chkSmart" id="chkSmart" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td>&nbsp;</td>
                              </tr>
                                <tr>
                                    <td colspan="6">&nbsp;
                                    <input type="hidden" name="textfield" id="txtps10" />
                                    <input type="hidden" name="textfield" id="txtp10" />
                                    <input type="hidden" name="textfield" id="txtfs10" />
                                    <input type="hidden" name="textfield" id="txtf10" />
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
                                                <td><!-- &nbsp;Pilih Barang Free -&gt; --></td>
                                                <td>&nbsp;&nbsp;<input type="hidden" name="free" class="frees" size="50" disabled  /></td>
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
                                        Rp.<input type="text" name="jumlah" id="intjumlah" readonly="readonly" value="0"/>

                                        
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
    var idxf=1;
	
    $('#addBrg').bind('click', function(e){
        if(($(".id1").val()=="") &&($(".frees").val()=="")){
            alert('Anda belum memilih barang!');
        }else if($('.id1').val() != "") {

		/*______________________________________________________________________________
		|																				|
		|					Kode yg bisa brubah2 tergantung promonya					|
		|			Kode kalau tombol tambah ditekan dia check harga 1 atau 2 barang	|
		|				sebelumnya apabila melebihi, barang tidak dikeluarkan			|
		|______________________________________________________________________________*/

		var _totalQuantity = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.sepuluh001_'+ i).val()) != '')
			{
				_totalQuantity += parseInt($('.sepuluh001_'+ i).val());
			}
		}
		var _tracker = parseInt($('#tracker001').val());
		var _harga = parseInt($('#harga_barang').val());
		if (_tracker == 0) {_tracker = 1;}
		if (_totalQuantity % 3 == 2 && $('.sepuluh001_' + _tracker).val() > 1 && _harga > $('#harga_' + _tracker).val())
		{
			alert('Barang yg anda pilih melebihi harga barang sebelumnya');
		} else if (_totalQuantity % 3 == 2 && $('.sepuluh001_' + _tracker).val() == 1 && (_harga > $('#harga_' + _tracker).val() || _harga > $('#harga_' + (parseInt(_tracker) - 1)).val()))
		{
			alert('Barang yg anda pilih melebihi harga barang sebelumnya');
		} else if (($('.sepuluh001_' + _tracker).val() == 0 && _totalQuantity % 3 == 2) || ($('.sepuluh001_' + _tracker).val() == "" && $('#harga_' + _tracker).val() != undefined) || $('.sepuluh001_' + _tracker).val() == "0")
		{
			alert('Barang yg terakhir anda pilih belum terisi dengan benar');

		/*______________________________________________________________________________
		|										|
		|		End Of Kode yg bisa brubah2 tergantung promonya			|
		|______________________________________________________________________________*/

		} else {
			$('#intid_jbarang').attr('disabled','disabled');//jenis barang disabled
			var brg = $('.id1').val();
			var jumlah = $('#jumlah').val();
			var harga = $('#harga_barang').val();
			var id_barang =  $('#id_barang').val();
			var pv =  $('#pv').val();
			var total = jumlah * harga;
			var nomor_nota = $('#nomor_nota').val();

			var out = '';
			if ($('#tracker001').val() > 0 || idx > 1) {
				for (var i = 1; i <= $('#tracker001').val(); i++) {
					if ($('.sepuluh001_'+ i).val() == null)
					{
						idx = i;
					}
				}
			}
			out += 'Banyaknya<br>';
			out += '<input id="'+idx+'" class="sepuluh001_'+idx+'" type="text" min="0" style="width: 50;" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
			out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="hidden" min="0" style="width: 50;" size="1" value="'+jumlah+'" />&nbsp;';
			out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';             
			out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
			out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
			out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
            
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
			out += '<input id="barang001_'+idx+'" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
			out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="hidden" size="1" value="'+jumlah+'" />&nbsp;';
			out += '<input id="barang_free001_'+idx+'" name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
			out += '<input id="brg001_'+idx+'" type="hidden" value="'+id_barang+'">';
			out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
			out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
			out = '<div style="height:60px">' + out + '</div>';
			$(out).insertBefore('#ButtonAdd');
			idx++;
			$('.id1').val('');
			$('#jumlah').val('');
			$('#harga_barang').val('');
			$('#pv').val('');
		}
       }
        return false;

    });


	$('#addBrg').bind('click', function(e){
		if($('.frees').val() != "")
			{
				$('#intid_jbarang').attr('disabled','disabled');//jenis barang disabled
				var brg = $('.frees').val();
				var jumlah = $('#jumlah').val();
				var harga = $('#harga_barang_free').val();
				var id_barang =  $('#id_free').val();
				var total = jumlah * harga;
				var out = '';
				var nomor_nota = $('#nomor_nota').val();

				out += '<sup>(Free)</sup>Banyaknya<br>';
				out += '<input type="text" id="hitfree10" name="hitfree10[]" value="'+idx+'">';
				out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				
				out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly/>';
				out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
				out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
				out += '<input name="barang_free['+idx+'][intid_id]" type="text" value="'+id_barang+'">';
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

    var jf=0;
	function kali_sepuluh(id){
       
		$("#del"+id).remove();
            var cs2 = parseInt($('#hitfree10').val());
			var textpromo10 = parseInt($("#txtpromo10").val());
            
			for(var i=parseInt(cs2); i<= parseInt(id);i++){
                
				var jumlahfree = parseInt($('.free_'+ i).val());
                jf = jf + jumlahfree;
			}
						
									
			if(jf > textpromo10){
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
							
			}

			$('#txtf10').val(jf);
            	
				if($("#txtfs10").val()==''){
					var jf10 = jf;
				}else{
					jf10 = jf - $("#txtfs10").val();
				}
			if(jf10 >= textpromo10){
				$('#addBrg').attr('disabled', 'disabled');
				$('.frees').attr('disabled', 'disabled');
			}else{
				$('#addBrg').removeAttr('disabled');
				$('.frees').removeAttr('disabled');
			}
		 	
       
     }

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
	* jenis penjualan combobox handler	
	*/
	$('#intid_jpenjualan').change(function(){
		kali();
		
		if ($(this).attr('value')== 1)
		{
			var title = "Nota Penjualan Reguler";
			$('#title').text(title);
		}
		else if ($(this).attr('value')== 2) {
			var title = "Nota Penjualan Chall Hut";
			$('#title').text(title);
			$('#intpv').val(0);
		}
		else if ($(this).attr('value')== 3) {
			var title = "Nota Penjualan Challenge";
			$('#title').text(title);
		} 
		else if ($(this).attr('value')== 7) {
			var title = "Nota Penjualan Netto";
			$('#title').text(title);
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
				kali();
				$('#intvoucher').val(0);
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
			document.getElementById("charge").style.display = '';
			document.getElementById("cash").style.display = 'none';
			document.getElementById("debit").style.display = 'none';
			document.getElementById("kkredit").style.display = 'none';
			document.getElementById("sisa").style.display = 'none';
			kali();
		} else {
			document.getElementById("charge").style.display = 'none';
			document.getElementById("cash").style.display = '';
			document.getElementById("debit").style.display = '';
			document.getElementById("kkredit").style.display = '';
			document.getElementById("sisa").style.display = '';
			kali();
		}
    });

	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kali(id){
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}		

		//itung jumlah barang total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh001_'+ i).val()) != '')
				{
					_totalQuantity += parseInt($('.sepuluh001_'+ i).val());
				}
			}
		}

		//harga total barang setelah harga dikalikan dengan jumlah
		var _totalHarga = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.sepuluh001_'+ i).val()) * parseInt($('#harga_' + i).val()));
				if($('.sepuluh001_'+ i).val() == ''){$('#total_' + i).val(0);}
				_totalHarga += parseInt($('#total_' + i));
			}
		}

		/*______________________________________________________________________________
		|										|
		|			Kode yg bisa brubah2 tergantung promonya		|
		|______________________________________________________________________________*/

		//kalau jumlah sudah memenuhi kelipatan 2 dari promo do this pengurangan harga terkecil
		/*if (_totalQuantity >= 3)
		{
			var _multipleShow = new Array();
			for (var k = 1; k <= parseInt($('#tracker001').val()); k++) {
				_multipleShow[k] = 1;
			}
			for (var i = 1; i <= _totalQuantity/3; i++) {
				var _hargaTerkecil = 0;
				var _index = 0;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
						if (parseInt($('#total_'+ j).val()) > 0 && (parseInt($('#harga_'+ j).val()) < _hargaTerkecil || _hargaTerkecil == 0) )
						{
							_hargaTerkecil = parseInt($('#harga_'+ j).val());
							_index = j;
							if (parseInt($('#total_'+ j).val()) != parseInt($('.sepuluh001_'+ j).val()) * parseInt($('#harga_'+ j).val()))
							{
								_multipleShow[j] += 1;
							}
						}
					}
				}
				$('#total_'+ _index).val((parseInt($('.sepuluh001_'+ _index).val()) - _multipleShow[_index]) * parseInt($('#harga_'+ _index).val()));
			}
		}*/
		//kode baru promo yg bisa licik
		if (_totalQuantity % 3 == 2)
		{
			alert("Silakan Pilih Barang Gratis 1");
		}
		if (_totalQuantity >= 3)
		{
			var _multiply3 = 0;
			var _tempQuantity = 0;
			var _free = false;
			var _jumlahBarangFree = Math.floor(_totalQuantity / 3);
			for (var i = 1; i <= parseInt(_jumlahBarangFree); i++) {
				_multiply3 += 3;
				_tempQuantity = 0;
				_free = false;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ j).val()) >= 0 && parseInt($('#harga_'+ j).val()) >= 0 && parseFloat($('#pv_'+ j).val()) >= 0) {
						_tempQuantity += parseInt($('.sepuluh001_'+ j).val());
						if (_tempQuantity >= _multiply3 && _free == false)
						{
							$('#total_' + j).val(parseInt($('#total_' + j).val()) - parseInt($('#harga_'+ j).val()));
							_free = true;
						}
					}
				}
			}
		}

		/*
		* masukin smua list harga bwt smua barang ke dalam array lalu di sort dari harga termahal
		*
		var _tempArray = new Array();
		var k = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				for (var j = 1; j <= $('.sepuluh001_'+ i).val(); j++) {
					_tempArray[k] = $('#harga_'+ i).val()
					k++;
				}
			}
		}
		_tempArray.sort(function(a,b){return b-a});

		
		* array yg uda di sort setiap peringkat kelipatan 3 nya harga barang yg cocok dibikin gratis
		*
		if (_totalQuantity >= 3)
		{
			var _multiply3 = 2;
			var _free = false;
			var _jumlahBarangFree = Math.floor(_totalQuantity / 3);
			for (var i = 1; i <= parseInt(_jumlahBarangFree); i++) {
				_free = false;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ j).val()) >= 0 && parseInt($('#harga_'+ j).val()) >= 0 && parseFloat($('#pv_'+ j).val()) >= 0) {
						if ($('.sepuluh001_'+ j).val() != 0 && $('#total_' + j).val() != 0 && $('#harga_'+ j).val() == _tempArray[_multiply3] && _free == false)
						{
							$('#total_' + j).val(parseInt($('#total_' + j).val()) - parseInt($('#harga_'+ j).val()));
							_free = true;
						}
					}
				}
				_multiply3 += 3;
			}
		}*/

		/*______________________________________________________________________________
		|										|
		|		End Of Kode yg bisa brubah2 tergantung promonya			|
		|______________________________________________________________________________*/

		//total semua harga barang yg di order di nota ini
		var _total = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('#total_'+ i).val()) >= 0)
				{
					_total += parseInt($('#total_'+ i).val());
					$('.sepuluh_'+ i).val($('#total_'+ i).val() / $('#harga_'+ i).val());
					$('.free_'+ i).val($('.sepuluh001_'+ i).val() - $('.sepuluh_'+ i).val());
					if ($('.free_'+ i).val() == 0)
					{
						$('#barang_free001_'+ i).val('');
					}
					else {
						$('#barang_free001_'+ i).val($('#brg001_'+ i).val());
					}
					if ($('.sepuluh_'+ i).val() == 0)
					{
						$('#barang001_'+ i).val('');
					}
					else {
						$('#barang001_'+ i).val($('#brg001_'+ i).val());
					}
				}
			}
		}

		//masukin total harga ke textbox bawah yg diatas tombol simpan
		$('#intjumlah1').val(_total);
		$('#intjumlah').val(parseInt($('#intjumlah1').val()) + parseInt($('#intjumlah2').val()));
		$('#totalbayar').val(parseInt($('#intjumlah').val()));

		//total semua pv yg di didapat di nota ini
		var _totalPV = 0;
		if ($('#intid_jpenjualan').attr('value') != 2 && $('#intid_jpenjualan').attr('value') != 7)
		{
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
					_totalPV += (parseInt($('#total_'+ i).val()) / parseInt($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
				}
			}
			$('#intpv').val(_totalPV.toFixed(2));
		}

		//hitung komisi 10% dan kurangi totalbayar
		if ($('#intjumlah1').val() != '' && $('#intid_jpenjualan').attr('value') != 7)
		{
			$('#komisi1').val(parseInt($('#intjumlah1').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi1').val()));
		}

		//hitung komisi 20% dan kurangi totalbayar
		if ($('#intjumlah2').val() != '' && $('#intid_jpenjualan').attr('value') != 7)
		{
			$('#komisi2').val(parseInt($('#intjumlah2').val()) * 0.2);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi2').val()));
		}
		
		//apabila voucher di checklist
		if ($("#chkV").attr('checked') == true)
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			$('#intvoucher').val(_voucher);
			$('#intjumlah1').val(parseInt($('#intjumlah1').val()) - _voucher);
			if ($('#intjumlah1').val() < 0) {$('#intjumlah1').val(0);}
			$('#intjumlah').val(parseInt($('#intjumlah').val()) - _voucher);
			if ($('#intjumlah').val() < 0) {$('#intjumlah').val(0);}
			if ($('#intid_jpenjualan').attr('value') != 2 && $('#intid_jpenjualan').attr('value') != 7)
			{
				$('#intpv').val((parseFloat($('#intpv').val()) - (_voucher / 100000)).toFixed(2));
				if ($('#intpv').val() < 0) {$('#intpv').val(0);}
			}
			if ($('#intid_jpenjualan').attr('value') != 7)
			{
				$('#komisi1').val(parseInt($('#komisi1').val()) - (_voucher * 0.1));
				if ($('#komisi1').val() < 0) {$('#komisi1').val(0);}
			}
			$('#totalbayar').val((parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val())) - parseInt($('#komisi2').val()));
			if ($('#totalbayar').val() < 0) {$('#totalbayar').val(0);}
		}
		
		//apabila smart spending di checklist
		if ($("#chkSmart").attr("checked") == true) {
			$('#komisi1').val(0);
			if (parseInt($('#intjumlah').val()) < 500000) {
				$('#charge3').val(parseInt($('#intjumlah').val()) * 0.03);
				$("#asi").empty();
			} else {
				$('#charge3').val(0);
                $("#asi").append('<input type="hidden" name="is_asi" id="is_asi" value="on" />');
			}
			$('#totalbayar').val(parseInt($('#intjumlah').val()) + parseInt($('#charge3').val()));
			$('#intkkredit').val($('#totalbayar').val());
			$('#intkomisiasi').val(Math.floor(_totalHarga * 0.17));
		}

		//kirim smua hasil hitungan ke textbox hidden yg akan di submit ke halaman berikutnya yaitu print
		$('#intjumlah1hidden').val($('#intjumlah1').val());
		$('#intjumlahhidden').val($('#intjumlah').val());
		$('#komisi1hidden').val($('#komisi1').val());
		$('#totalbayar1').val($('#totalbayar').val());

		//format smua angka as rupiah
		$('#intjumlah1').val(formatAsRupiah(parseInt($('#intjumlah1').val())));
		$('#intjumlah').val(formatAsRupiah(parseInt($('#intjumlah').val())));
		$('#komisi1').val(formatAsRupiah(parseInt($('#komisi1').val())));
		$('#charge3').val(formatAsRupiah(parseInt($('#charge3').val())));
		$('#totalbayar').val(formatAsRupiah(parseInt($('#totalbayar').val())));

		sisa();

		return false;
	}

	/**
	* function sisa yg baru
	*/
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
             return false;

          return true;
       }
</script>

