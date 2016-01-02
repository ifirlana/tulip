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
		   autoComp();
           
		   });
		
		function autoComp(){

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
                
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
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });


                $(".frees").autocomplete({
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
                <div>	<h2 class="title">penjualan spesial</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota" method="post" name="frmjual" id="frmjual">
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
											//KONDISI
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
                                                if($intid_jpenjualan[$i] != 2){
													echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
												}
											}
                                            ?>
                                        </select>         </td>
                                    <td colspan="3">&nbsp;</td>
									<td></td>
                              </tr>
                                <tr>
                                    <td colspan="4"><div id="acuan" style="display:none">Mengacu Nota <input type="text" name="no_nota" id="no_nota" size="20"><input class="button" type="button" value="Cek Omset"  id="cek_omset"/></div></td>
                                    <td><div id="omset" style="display:none"></div></td>
                                    <td>&nbsp;</td>
                              
                              </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td>&nbsp;</td>
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
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50"/></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang Free -&gt;</td>
                                                <td>&nbsp;&nbsp;<input type="text" name="free" class="frees" size="50" disabled="disabled"/></td>
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
                                        <input type="hidden" name="jumlahsementara" id="jumlahsementara"/>                                        </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly" value="0"/>
                                    </td>
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
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Cash</span></td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Sisa</span></td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intsisa" id="intsisa" onkeypress="return isNumberKey(event)"/>
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
/*
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
	$("input[type=submit]").removeAttr("disabled");
    }
*/

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
	$('input[type=submit]').attr('disabled', 'disabled');
    });


    var idx = 1;
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
            if ($('#intid_jpenjualan').attr('value')== 11 || $('#intid_jpenjualan').attr('value')== 12)
			{
        	out += 'Banyaknya<br>';
			out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
			out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
			out += '<input name="barang['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
			out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="4" value="0">';	
			out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0">';
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="4" value="'+total+'" readonly>';
			out += '<input id="kode_barang_'+idx+'" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
			out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
			out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
			out = '<div style="height:60px">' + out + '</div>';
			} else {
			
            out += 'Banyaknya<br>';
            out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
            out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="4" value="'+harga+'">';
            out += '&nbsp;Komisi:&nbsp;<select id="komisi_'+idx+'" name="komisi_'+idx+'" onchange="pindah()"><option value="20">20%</option><option value="10">10%</option><option value="0">0%</option></select>';
			out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'">';
            out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="4" value="'+total+'" readonly>';
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
            out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
			out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
			}
			$(out).insertBefore('#ButtonAdd');
            idx++;
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
				out += '<input id="'+idx+'" class="semua_free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				out += '<input name="barang_free['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
				out += '&nbsp;Harga:&nbsp;<input id="harga_free_'+idx+'" name="barang_free['+idx+'][intid_harga]" type="text" size="4" value="'+harga+'" readonly>';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
				out += '&nbsp;Total:&nbsp;<input id="total_free_'+idx+'" name="barang_free['+idx+'][intid_total]" type="text" size="4" value="'+total+'" readonly>';
				out += '<input name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
				out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
				out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
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

/*______________________________________________________________________
|									|
|									|
|									|
|									|
|				Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/

	/*
	* function kali_sepuluh yg baru
	*/
	function kali_sepuluh(id){
		var total=0;
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}
		$('.frees').removeAttr('disabled');
		if ($('#intid_jpenjualan').attr('value')== 11 || $('#intid_jpenjualan').attr('value')== 12)
		{
			$('.frees').attr('disabled','disabled');
			for(var i=1; i<= parseInt($('#tracker001').val());i++){
				var jumlah = $('.semua_'+ i).val();
				var harga = parseInt($('#harga_' + i).val());
				if(jumlah >=0){
					var t = jumlah * harga;
					$('#total_' + i).val(t);
					total += t;
					$('#intjumlahfree').val(total);
				}
			}
		} else {
			for(var i=1; i<= parseInt($('#tracker001').val());i++){
				var jumlah = $('.semua_free_'+ i).val();
				var harga = parseInt($('#harga_free_' + i).val());
				if(jumlah >=0){
					var t = jumlah * harga;
					$('#total_free_' + i).val(t);
					total += t;
					$('#intjumlahfree').val(total);
				}
			}
		}
		if($('#komisi1hidden').val() == ""){
			var kom1 = 0;
		}else{
			var kom1 = parseInt($('#komisi1hidden').val());
		}
		if($('#komisi2hidden').val() == ""){
			var kom2 = 0;
		}else{
			var kom2 = parseInt($('#komisi2hidden').val());
		}
		if($('#intjumlahhidden').val() == ""){
			var intjum = 0;
		}else{
			var intjum = parseInt($('#intjumlahhidden').val());
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
        
		var omset = intjum1 + intjum2;
		

		$('#intjumlah').val(formatAsRupiah(omset));
		$('#intjumlahhidden').val(omset);
		
		var omsetall = omset + intjumfree;

		var totals = omsetall - kom1 - kom2;

		$('#totalbayar').val(formatAsRupiah(totals));
		$('#totalbayar1').val(totals);

		/*khusus untuk big tumbler dan new medium storage box dan fine mug dan medium bowl
		if (($('#intid_jpenjualan').attr('value') == 11 || $('#intid_jpenjualan').attr('value')== 12) && parseInt($('#tracker001').val()) < 2 && 
			((parseInt($('#kode_barang_'+id).val()) >= 447 && parseInt($('#kode_barang_'+id).val()) <= 458) ||
			(parseInt($('#kode_barang_'+id).val()) >= 1219 && parseInt($('#kode_barang_'+id).val()) <= 1230) ||
			(parseInt($('#kode_barang_'+id).val()) >= 1244 && parseInt($('#kode_barang_'+id).val()) <= 1248) ||
			(parseInt($('#kode_barang_'+id).val()) >= 376 && parseInt($('#kode_barang_'+id).val()) <= 381) ||
			(parseInt($('#kode_barang_'+id).val()) == 2346)))
		{
			$('.id1').removeAttr('disabled');
		}
		else {
			$('.id1').attr('disabled','disabled');
		}*/
		
	}

	/*
	* jenis penjualan combobox handler	
	*/
	$('#intid_jpenjualan').change(function() {
		$('.id1').removeAttr('disabled');
		document.getElementById('acuan').style.display='none';
		document.getElementById('omset').style.display='none';
		if ($(this).attr('value')== 1)
		{
			var title = "Nota Penjualan Reguler";
			$("#title").text(title);
            
		}
		else if ($(this).attr('value')== 2) {
			var title = "Nota Penjualan Hut";
			$("#title").text(title);
            
		}
		else  if ($(this).attr('value')== 3) {
			var title = "Nota Penjualan Challenge";
			$("#title").text(title);
		}
		else  if ($(this).attr('value')== 11) {
			var title = "Nota Penjualan Special Price";
			$("#title").text(title);
			document.getElementById('acuan').style.display='block';
			document.getElementById('omset').style.display='block';
        	}
		else  if ($(this).attr('value')== 12) {
			var title = "Nota Penjualan Point";
			$("#title").text(title);
        	} 
	});
	
	/*
	* button Cek Omset handler
	*/
	$('#cek_omset').click(function() {
		var form_data = {
			no_nota : $('#no_nota').val(),
			ajax : '1'
		};
		$.ajax({
			url: "<?php echo base_url(); ?>penjualan/hitungomset",
			type: 'POST',
			async : false,
			data: form_data,
			success: function(msg) {
				$('#omset').html(msg);
				if (parseInt($('#omset').find('input:first').attr('value')) >= 0)
				{
					$('.id1').removeAttr('disabled');
				}
				else {
					$('.id1').attr('disabled','disabled');
					$('.frees').attr('disabled','disabled');
				}
			}
		});
		return false;
	});

	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*
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
			if (parseInt($('.semua_'+ i).val()) != '')
			{
				_totalQuantity += parseInt($('.semua_'+ i).val());
			}
		}

		//harga total barang setelah harga dikalikan dengan jumlah
		var _totalHarga = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			$('#total_' + i).val(parseInt($('.semua_'+ i).val()) * parseInt($('#harga_' + i).val()));
			if($('.semua_'+ i).val() == ''){$('#total_' + i).val(0);}
			_totalHarga += parseInt($('#total_' + i));
		}

		/______________________________________________________________________________
		|										|
		|			Kode yg bisa brubah2 tergantung promonya		|
		|______________________________________________________________________________/

		//kalau jumlah sudah memenuhi kelipatan 2 dari promo do this pengurangan harga terkecil
		if (_totalQuantity >= 3)
		{
			var _multipleShow = new Array();
			for (var k = 1; k <= parseInt($('#tracker001').val()); k++) {
				_multipleShow[k] = 1;
			}
			for (var i = 1; i <= _totalQuantity/3; i++) {
				var _hargaTerkecil = 0;
				var _index = 0;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ j).val()) > 0 && (parseInt($('#harga_'+ j).val()) < _hargaTerkecil || _hargaTerkecil == 0) )
					{
						_hargaTerkecil = parseInt($('#harga_'+ j).val());
						_index = j;
						if (parseInt($('#total_'+ j).val()) != parseInt($('.semua_'+ j).val()) * parseInt($('#harga_'+ j).val()))
						{
							_multipleShow[j] += 1;
						}
					}
				}
				$('#total_'+ _index).val((parseInt($('.semua_'+ _index).val()) - _multipleShow[_index]) * parseInt($('#harga_'+ _index).val()));
			}
		}

		/______________________________________________________________________________
		|										|
		|		End Of Kode yg bisa brubah2 tergantung promonya			|
		|______________________________________________________________________________/

		//total semua harga barang yg di order di nota ini
		var _total = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0)
			{
				_total += parseInt($('#total_'+ i).val());
			}
		}

		//masukin total harga ke textbox bawah yg diatas tombol simpan
		$('#intjumlah1').val(_total);
		$('#intjumlah').val(parseInt($('#intjumlah1').val()) + parseInt($('#intjumlah2').val()));
		$('#totalbayar').val(parseInt($('#intjumlah').val()));

		//total semua pv yg di didapat di nota ini
		var _totalPV = 0;
		if ($('#intid_jpenjualan').attr('value') != 2)
		{
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				_totalPV += (parseInt($('#total_'+ i).val()) / parseInt($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
			}
			$('#intpv').val(_totalPV.toFixed(2));
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
		
		//apabila voucher di checklist
		if ($("#chkV10").attr('checked') == true)
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			$('#intvoucher').val(_voucher);
			$('#intjumlah1').val(parseInt($('#intjumlah1').val()) - _voucher);
			$('#intjumlah').val(parseInt($('#intjumlah').val()) - _voucher);
			$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 100000));
			$('#komisi1').val(parseInt($('#komisi1').val()) - (_voucher * 0.1));
			$('#totalbayar').val((parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val())) - parseInt($('#komisi2').val()));
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
		$('#totalbayar').val(formatAsRupiah(parseInt($('#totalbayar').val())));

		sisa();

		return false;
	}
*/
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
|									|
|									|
|									|
|									|
|			End Of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/


    function kali(id){
        var total=0;
		var pivi=0;
        $("#del"+id).remove();

            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
				if(jumlah >=0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
					var pv = parseFloat($('#pv_' + i).val());
                	var jpv = jumlah * pv;
					pivi +=jpv;
				}
								
					if ($("#komisi_"+ i).val()== 10)
					{
						
						if ($("#jumlahsementara").val()!= " ")
						{
							var jmlomset = total - $("#jumlahsementara").val();
							$('#intjumlah1').val(formatAsRupiah(jmlomset));
							$('#intjumlah1hidden').val(jmlomset);
							var komisi = (parseInt(jmlomset) * 10) / 100;
							$('#komisi1').val(formatAsRupiah(komisi));
							$('#komisi1hidden').val(komisi);
						}else 
						{
							$('#intjumlah1').val(formatAsRupiah(total));
							$('#intjumlah1hidden').val(total);
							var komisi = (parseInt(total) * 10) / 100;
							$('#komisi1').val(formatAsRupiah(komisi));
							$('#komisi1hidden').val(komisi);
						}
					} else if ($("#komisi_"+ i).val()== 20)
					{
						var komisi = (parseInt(total) * 20) / 100;
						$('#komisi2').val(formatAsRupiah(komisi));
						$('#komisi2hidden').val(komisi);
						$('#intjumlah2').val(formatAsRupiah(total));
						$('#intjumlah2hidden').val(total);
					}
			    
            }
					
		$('#intpv').val(formatNumber(pivi));
            
		if($('#komisi1hidden').val() == ""){
            var kom1 = 0;
        }else{
            var kom1 = parseInt($('#komisi1hidden').val());
        }
        if($('#komisi2hidden').val() == ""){
            var kom2 = 0;
        }else{
            var kom2 = parseInt($('#komisi2hidden').val());
        }
        if($('#intjumlahhidden').val() == ""){
            var intjum = 0;
        }else{
            var intjum = parseInt($('#intjumlahhidden').val());
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
        
        var omset = intjum1 + intjum2;
		
        $('#intjumlah').val(formatAsRupiah(omset));
        $('#intjumlahhidden').val(omset);

        var totals = omset - kom1 - kom2;

        $('#totalbayar').val(formatAsRupiah(totals));
        $('#totalbayar1').val(totals);
    		
		}
		
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

        
   

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })


/*
    $('#intid_jpenjualan').change(function()
    {
        if ($(this).attr('value')== 1)
        {
            var title = "Nota Penjualan Reguler";
            $("#title").text(title);
            
        } else  if ($(this).attr('value')== 2)
        {
            var title = "Nota Penjualan Hut" ;
            $("#title").text(title);
            
        } else  if ($(this).attr('value')== 3)
        {
            var title = "Nota Penjualan Challenge";
            $("#title").text(title);
            
        } else  if ($(this).attr('value')== 11)
        {
            var title = "Nota Penjualan Special Price";
            $("#title").text(title);
			document.getElementById('acuan').style.display='block';
			document.getElementById('omset').style.display='block';
			$('.id1').attr("disabled","disabled");
			$('.frees').attr("disabled","disabled");
        } else  if ($(this).attr('value')== 12)
        {
            var title = "Nota Penjualan Point";
            $("#title").text(title);
			$('.id1').attr("disabled","");
			$('.frees').attr("disabled","disabled");
        }
    });
*/
/*
    function formatAsRupiah(ObjVal) {

        mnt = ObjVal;

        mnt -= 0;

        mnt = (Math.round(mnt*100))/100;

        ObjVal = (mnt == Math.floor(mnt)) ? mnt + '.00' : ( (mnt*10 == Math.floor(mnt*10)) ? mnt + '0' : mnt);

        if (isNaN(ObjVal)) {ObjVal ="0.00";}

        return ObjVal;
    }
*/

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
	
/*
	function pindah()
	{
		$("#jumlahsementara").val($("#intjumlah2hidden").val());
	}
	
	$('#cek_omset').click(function() {
          var form_data = {
              no_nota : $('#no_nota').val(),
              ajax : '1'
           };
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/hitungomset",
                type: 'POST',
                async : false,
                data: form_data,
                success: function(msg) {
                    $('#omset').html(msg);
if (parseInt($('#omset').find('input:first').attr('value')) > 300000)
		{
			alert('haleluya');
		}
                }
            });
            return false;
       });
*/

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

