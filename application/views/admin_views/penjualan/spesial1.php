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
                        $("#result").html(
                        "<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' readonly='readonly' />"
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
                        $("#result001").html(
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
		  // autoComp();
           //autoCompSpecial();
           set_pembayaran();
		   set_form_barang();
		   });
        //membuat pembayaran menjadi set nol kembali
		function set_pembayaran(){
            $('#intjumlah1').val(0);
            $('#intjumlah2').val(0);
            $('#intjumlah').val(0);
            $('#intpv').val(0);
            $('#komisi2').val(0);
            $('#komisi1').val(0);
            $('#totalbayar').val(0);

            $('#intcash').val('');
        }
		//membuat form pemilihan barang sesuai dengan ketentuannya
		function set_form_barang(){
			$('#intid_jpenjualan').removeAttr('disabled','disabled');
			$('#addBrg').removeAttr('disabled','disabled');
			$('#formPoint').attr('style','display:none');
			$('#halaman').val('SPP');
			//untuk point reward
			$('.point_10').removeAttr('checked','checked');
			$('.point_10').removeAttr('disabled','disabled');
			$('.point_20').removeAttr('checked','checked');
			$('.point_20').removeAttr('disabled','disabled');
			$('.point_30').removeAttr('checked','checked');
			$('.point_30').removeAttr('disabled','disabled');
		}
		//untuk pemilihan barang autocompspecial di tabel promocabang dengan kondisi yang ditentukan oleh pemilihan
        function autoCompSpecial(){
            var ur = "<?php echo base_url(); ?>penjualan/lookupBarangSpecialPrice";
                
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
                            $("#result1").html("<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='2' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' class='intid_barang_free' value='" + ui.item.intid_barang_free + "' size='2' readonly='readonly'/>");
                            },
                    });
				$(".frees").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangSpecialPrice",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('.intid_barang_free').val(),
								bayar: $('#id_barang').val(),
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='2' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' readonly /><input type='hidden' class='intid_barang_last' value='" + ui.item.intid_barang_free + "' size='2' readonly='readonly'/>"
                    );
                    },
                });

        }
			//untuk pemilihan barang autocompspecial di tabel promocabang dengan kondisi yang ditentukan oleh pemilihan
        function autoCompPoint(){
            var ur = "<?php echo base_url(); ?>penjualan/lookupBarangPoint";
                if($('.point_10').is(':checked') == true){
					var simp = $('.point_10').val();
					}
				if($('.point_20').is(':checked') == true){
					var simp = $('.point_20').val();
					}
				if($('.point_30').is(':checked') == true){
					var simp = $('.point_30').val();
					}
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
									rules:simp,
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
                            $("#result1").html("<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='2' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' class='intid_barang_free' value='" + ui.item.intid_barang_free + "' size='2' readonly='readonly'/>");
                            },
                    });
				$(".frees").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangPoint",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
								rules:simp,
                                state: $('.intid_barang_free').val(),
								bayar: $('#id_barang').val(),
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='2' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' readonly /><input type='hidden' class='intid_barang_last' value='" + ui.item.intid_barang_free + "' size='2' readonly='readonly'/>"
                    );
                    },
                });

        }
		function autoCompPromoNormal() {
		$(".id1").autocomplete({
                    minLength: 5,
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

                    },
                });
	}
	</script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Penjualan Spesial 1</h2>
                    <div class="entry">
					<!-- savespecialtoday temp -->
                        <form action="<?php echo base_url()?>penjualan/savespecialtoday" method="post" name="frmjual" id="frmjual">
						<input type='hidden' name='halaman' id='halaman' value='SPP' readonly= 'readonly' />
						<input type="hidden" id="intid_wilayah001" name="intid_wilayah001" size="30" readonly="readonly" value="<?php echo $id_wilayah; ?>">       </td>
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    
                                    <td >&nbsp;<?php echo $cabang; ?>
                                    <input type="hidden" name="intid_cabang" id="id_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">         </td>
                                    <td>&nbsp;,</td>
                                    <td>&nbsp;<?php echo date("d-m-Y");?></td>
                                </tr>
                                <tr id='FormUNIT'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;Unit</td>
                                    <td>&nbsp;:</td>
                                    <td><input type="text" name="textfield4" id="intid_unit"  size="25"/></td>
                                </tr>
                                <tr id='FormNama'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="82">&nbsp;Nama</td>
                                    <td width="7">&nbsp;:</td>
                                    <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="25"/></td>
                                </tr>
                                <tr id='FormKartu'>
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
                                    <td><input type='hidden'  name="intid_jpenjualan" class='intid_jpenjualan' readonly='readonly' />
										<select id="intid_jpenjualan">
                                            <option value="">-- Pilih --</option>
                                            <?php
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
                                                echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
                                            }
                                            ?>
                                        </select></td>
                                    <td colspan="1">&nbsp;</td>
                                    <td colspan='2'>
									<?php 
										//hint ! 8 oktober 2013
										//kondisi jika ada perubahan untuk penjualan point reward
									?>
										<div id='formPoint' style='display:none;'>
											<input type='checkbox' id='pointForm' class='point_10' value='pr10'>10 point<br />
											<input type='checkbox' id='pointForm' class='point_20' value='pr20'>20 point<br />
											<input type='checkbox' id='pointForm' class='point_30' value='pr30'>30 point<br />
										</div>
										</td>
									<td></td>
                              </tr>
                                <tr>
                                    <td colspan="4"><div id="acuan" style="display:none">
											Mengacu Nota : <?php echo date('D-M-Y');?><input type='hidden' name='tanggal_sekarang' id='tanggal_sekarang' value='<?php echo date('Y-m-d');?>' readonly='readonly'><input class="button" type="button" value="Cek Omset"  id="cek_omset"/></div>
										</td>
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
                                <tr id='formpilihbarang' style='display:none;'>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center" cellspacing=0 cellpadding=0>
                                            <tr>
                                                <td width="116">&nbsp;Silahkan ketik</td>
												<td width="367">&nbsp;Nama Barang</td>
												<td width="87">Harga</td>
												<td width="63" rowspan='2' >
													<div id="data">
														<input type="button" id="addBrg" name="addBrg" value="Tambah" />
														<input type="hidden" id="tracker001" value="0" />
                                                    </div>    
												</td>
                                      </tr>
                                            <tr  id='formBayar' >
                                                <td>&nbsp;Pilih Barang -&gt; <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;<input type="text" name="barang[1][intid_barang]" class="id1" size="50"/></td>
												<td>&nbsp;<div id="result1"></div></td>
                                            </tr>
											
											<?php
											// hint ! 8 oktober 2013
											// digunakan kalau ada kondisi seperti intid_barang_disertakan barangnya
											?>
											<tr id='formFree' style='display:none;'>
                                                <td>&nbsp;Pilih Barang Satu Lagi -&gt;</td>
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
                                    <td style='width:150px;'>Omset 10%<br />Omset 20%<br />Total Omset</td>
                                    <td>:<br />:<br />:</td>
									<?php $matuang = "Rp.";
										if($id_wilayah == 4){
										$matuang ="RM";
										}
									?>
                                    <td style='width:200px;'>
                                        <?php echo $matuang;?><input type="text" name="jml10" id="intjumlah1" readonly="readonly" value="0"/><br />
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="jml20" id="intjumlah2" readonly="readonly" value="0"/><br />
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="jumlah" id="intjumlah" readonly="readonly" value="0"/>

                                        <input type="hidden" name="jml10" id="intjumlah1hidden"/>
                                        <input type="hidden" name="jml20" id="intjumlah2hidden"/>
                                        <input type="hidden" name="jumlah_" id="intjumlahhidden"/>
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
                                       <?php echo $matuang;?><!--  Rp. --><input type="text" name="komisi2" id="komisi2" readonly="readonly" value="0"/>
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
                                       <?php echo $matuang;?><!-- Rp. --><input type="text" name="komisi1" id="komisi1" readonly="readonly" value="0"/>
                                        <input type="hidden" name="komisi1hidden" id="komisi1hidden"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="totalbayar1" id="totalbayar" readonly="readonly" value="0"/>
                                        <input type="hidden" name="totalbayar" id="totalbayar1" />
                                        <input type="hidden" name="totalbayar2" id="totalbayar2" />         </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Cash</span></td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp.--><input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Sisa</span></td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intsisa" id="intsisa" onkeypress="return isNumberKey(event)"/>
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
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" disabled="disabled" class="button" id="bttnSubmit" /></td>
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
		if($(".intid_unit").val()==""){
			if($("#intid_unit").val()==""){
				alert('Unit tidak Boleh Kosong!');
				$("#intid_unit").focus();
				event.preventDefault();
				}
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
		//setelah masukan barang, jangan ada lagi pengubahan jenis penjualan
		//akan membuat percuma jenis penjualan
		$('#intid_jpenjualan').attr('disabled','disabled');
		$('.intid_jpenjualan').val($('#intid_jpenjualan').val());
        
		if(($(".id1").val()=="") &&($(".frees").val()=="")){
            alert('Anda belum memilih barang!');

			}
		else if(($('.id1').val() != "") && ($('#harga_barang').val() != ""))
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
					out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
					out += '<input name="barang['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
					out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="4" value="'+harga+'" readonly>';	
					out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
					out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="4" value="'+total+'" readonly>';
					out += '<input id="kode_barang_'+idx+'" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'" readonly="readonly">';
					out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
					out = '<div style="height:60px">' + out + '</div>';
					
				} 
				//kondisi penjualan selain special price dan point reward
				else {
				
					out += 'Banyaknya<br>';
					out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
					out += '<input name="barang['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
					out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="4" value="'+harga+'" onkeyUp="pindah('+idx+')">';
					out += '&nbsp;Komisi:&nbsp;<select id="komisi_'+idx+'" name="komisi_'+idx+'" onchange="pindah('+idx+')"><option value="20">20%</option><option value="10">10%</option><option value="0">0%</option></select>';
					out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="0">';
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
					// hint ! 8 oktober 2013
					//lakukan kondisi jika pemilihan barang  mengeluarakan intid_barang_free sama dengan 0, maka tombol add barang tidak akan keluar.
					//dengan kata lain jika ada barang yang sesuai lakukan lagi pemilihan barang
					if($('.intid_barang_free').val() > 0){
						//perubahan kondisi pemilihan barang
						$('#formBayar').attr('style','display:none;');
						$('#formFree').removeAttr('style','display:none;');
						$('.frees').removeAttr('disabled','disabled');
						//alert('tidak tertutup');
						}else{
							
							if($('#intid_jpenjualan').attr('value') != 11 && $('#intid_jpenjualan').attr('value') != 7 && $('#intid_jpenjualan').attr('value') != 14){								
								//mencegah penambahan barang yang tidak sesuai promo
								//dalam kondisi bayar dan free
								//alert('tertutup');
								$('.id1').attr('disabled','disabled');
								$('#addBrg').attr('disabled','disabled');
								}
							}
			} else 	
			if(($('.frees').val() != "") && ($('#harga_barang_free').val() != ""))
			{
				var brg = $('.frees').val();
				var jumlah = $('#jumlah').val();
				var harga = $('#harga_barang_free').val();
				var id_barang_free =  $('#id_free').val();
				var total = jumlah * harga;
				var out = '';
				var nomor_nota = $('#nomor_nota').val();

				out += '<sup>(Free)</sup>Banyaknya<br>';
				out += '<input id="'+idx+'" class="semua_free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_free(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				out += '<input name="barang_free['+idx+'][intid_barang]" type="text" size="40" value="'+brg+'" readonly />';
				out += '&nbsp;Harga:&nbsp;<input id="harga_free_'+idx+'" name="barang_free['+idx+'][intid_harga]" type="text" size="4" value="0" readonly>';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
				out += '&nbsp;Total:&nbsp;<input id="total_free_'+idx+'" name="barang_free['+idx+'][intid_total]" type="text" size="4" value="0" readonly>';
				out += '<input name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang_free+'" readonly ="readonly">';
				out += '<input type="hidden" name="barang_free['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
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
				//percobaan
				//dipisahkan untuk fungsi yang sama
				if($('.intid_barang_last').val() > 0){
					//perubahan kondisi pemilihan barang
					$('#formBayar').attr('style','display:none;');
					$('#formFree').removeAttr('style','display:none;');
					$('.frees').removeAttr('disabled','disabled');
					//alert('free didalam');
					}else{
						//mencegah penambahan barang yang tidak sesuai promo
						//dalam kondisi  free
						//alert('tertutup');
						$('#addBrg').attr('disabled','disabled');
						}
			}
		//lakukan cara mendisabled 
		var z = $('#increment').val();
		for(i=z;i>=0;i--){
			if(!isNaN($('#nonota_'+i).val())){
				$('.checkbox_div_'+i).attr('style','display:none;');
				$('.checkbox_hidden_'+i).removeAttr('style','display:none;');
				//
				if($('#nonota_'+i).attr('checked') == true){
					$('.checkbox_hidden_'+i).html('ok');
					}else{
						$('.checkbox_hidden_'+i).html('-');
						}
				}
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
	*
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
		}*
		hitungPembayaran();
	}
	*/
	/*
	* jenis penjualan combobox handler	
	*/
	$('#intid_jpenjualan').change(function() {
			//lakukan penyetingan kembali
        set_pembayaran();
		set_form_barang();
		   
		$('.id1').removeAttr('disabled');
		document.getElementById('acuan').style.display='none';
		document.getElementById('omset').style.display='none';
		if ($(this).attr('value')== 14)
		{
			var title = "Nota Penjualan Special Bandung";
			$("#title").text(title);
            $("#formpilihbarang").removeAttr('style','style');
			$('#FormUNIT').removeAttr('style','display:none');
			$('#FormNama').removeAttr('style','display:none');
			$('#FormKartu').removeAttr('style','display:none');
			//$("#result").html(' ');
            //$("#result001").html(' ');
			//$("#intid_unit").val('');
			//$("#strnama_dealer").val('');
            autoCompPromoNormal();
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
            $("#formpilihbarang").css('display','none');
			//$('#FormUNIT').attr('style','display:none');
			//$('#FormNama').attr('style','display:none');
			//$('#FormKartu').attr('style','display:none');
        	//$("#result").html(' ');
            //$("#result001").html(' ');
			
            }
		else  if ($(this).attr('value')== 12) {
			var title = "Nota Penjualan Point";
			$("#title").text(title);
            $("#formpilihbarang").removeAttr('style','style');
			$("#formPoint").removeAttr('style','display:none');
			$('#FormUNIT').removeAttr('style','display:none');
			$('#FormNama').removeAttr('style','display:none');
			$('#FormKartu').removeAttr('style','display:none');
        	} 	
	});
	//kondisi untuk jquery agar bisa di checked hanya satu lagi
	$('#pointForm').live('change', function(){
			if($(this).is(':checked')){
				$('.point_10').attr('disabled','disabled');
				$('.point_20').attr('disabled','disabled');
				$('.point_30').attr('disabled','disabled');
				//perubahan halaman untuk penyimpanan nota
				if($('.point_10').is(':checked') == true){
					$('#halaman').val($('.point_10').val());
					}
				if($('.point_20').is(':checked') == true){
					$('#halaman').val($('.point_20').val());
					}
				if($('.point_30').is(':checked') == true){
					$('#halaman').val($('.point_30').val());
					}
			}
			//setelah dicheked baru meload autocompletenya
			autoCompPoint();
		});


	/*
	* button Cek Omset handler
	*/
	
	function cekOmset(id){
		var temp = 0;
		var x = 0;
			for(var i=0; i <= $('#tracker009').val();i++){
				x = i+1;
				//alert('helo '+i);
				//alert( $('#inttotal_omset_'+(i+1)).val() );
				//alert( $('#nonota_'+(x)).attr('checked'));
				//alert(i);
				if($('#nonota_'+i).attr('checked') == true){
					temp = parseInt(temp) + parseInt($('#inttotal_omset_'+i).val());
					//alert(temp);
				}
			}
			$('#totOmset').val(temp);
		/* alert('ada: '+temp); */
	}
	$(document).ready(function (){
	
	$('#chkboxom').click(function() {
		alert('bakekok');
	});
	});
	$('#cek_omset').click(function() {
		var form_data = {
			no_nota : $('#no_nota').val(),
			ajax : '1',
			strkode_dealer : $('#strkode_dealer').val(),
			tanggal : $('#tanggal_sekarang').val(),
		};
        var_arr = new Array();
        //alert('yuhu');
        
        $.ajax({
                 url: "<?php echo base_url(); ?>penjualan/hitungomset21",
                 type: 'POST',
                 data: form_data,
                 success:
                    function(msg){
                        if(msg == 'false'){
                            alert("Tidak Bisa Diproses");
                            }else{
								$('#intid_unit').attr('disabled','disabled');
								$('#strnama_dealer').attr('disabled','disabled');
                                //display dibuka
                                $('#acuan').html(msg);
                                $('#formpilihbarang').removeAttr('style');
                                autoCompSpecial();
                                }
                    },
                });
        /*
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
        */
		return false;
	});
    $('#intcash').keyup(function(){
        temp =  $('#intcash').val();
        ttlbyr = $('#totalbayar').val();
        hasil = parseInt(ttlbyr) - parseInt(temp);
        //output
        $('#intsisa').val(hasil);
        $('#intdebit').val(0);
        $('#intkkredit').val(0);
        if($('#intsisa').val() >= 0){
            //
            $('#bttnSubmit').removeAttr('disabled','disabled');
            }
    });
	
	/**
	* function sisa yg baru
	*/
    function hitungPembayaran(){
        temp = 0;
        for(i=0;i<=idx;i++){
            if($('#total_'+i).val()){
                temp = parseInt(temp) + parseInt($('#total_'+i).val());
            }
        }
        //alert('yooo');
       $('#totalbayar').val(temp);
       $('#intjumlah').val(0);
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
        //alert('sisa | kondisi satu');
		}
		else {
			if ($('#intcash').val() != '') {_cash = parseInt($('#intcash').val());}
			if ($('#intkkredit').val() != '') {_kredit = parseInt($('#intkkredit').val());}
			if ($('#intdebit').val() != '') {_debit = parseInt($('#intdebit').val());}
			var _bayar = _cash + _kredit + _debit;

			$('#intsisa').val(formatAsRupiah(-(unformatFromRupiah($('#totalbayar').val()) - _bayar)));
			$('#intsisahidden').val(unformatFromRupiah($('#totalbayar').val()) - _bayar);			
			$("input[type=submit]").removeAttr("disabled");
        //alert('sisa | kondisi dua');
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

	function pindah(id){
		kali(id);
	}
    function kali(id){
		var increment_barang = idx;
		var special_price_control = 0;
		if ($('#intid_wilayah001').val() == "3")
			{
				special_price_control= 0;
			}else if($('#intid_wilayah001').val() == "4"){
				special_price_control = 100; 
			}
			else{
				special_price_control = 350000;
			}
		//var special_price_control = 350000; //untuk mengontrol pengambilan jumlah barang
		set_pembayaran();
        var total=0;
		var pivi=0;
		//proses pengecekan junlah barang yang dipilih.
		//jika kondisi selain jenis penjualan reguler dan special price maka harus berjumlah 1
		if($('#intid_jpenjualan').val() != 7 && $('#intid_jpenjualan').val() != 11 && $('#intid_jpenjualan').val() != 14){
			if($('#'+id).val() != 1){
					alert('jumlah barang harus 1');
					$('#'+id).val('') ;
			}else if($('#'+id).val() == 1){
					$('#'+id).attr('readonly','readonly') ;
			}
		}
		//lakukan hitung omset yang dipilih dari special price 
		if($('#intid_jpenjualan').val() ==11){
			var temporary = $('#increment').val();
			var temporary_omset  = 0;
			var temporary_nominal = 0;
			var temporary_jumlah = 0;
			//pengecekan omset
			for(var i=1; i<=temporary;i++){
				//pengecekan nonota 
				if(!isNaN($('#nonota_'+i).val())){
					//checked true
					if($("#nonota_"+i).attr('checked') == true){
						temporary_omset = parseInt($('#inttotal_omset_'+i).val()) + parseInt(temporary_omset);
						}
					}
				}
			//pengecekan semua nominal quantity
			//alert(increment_barang);
			for(var z=0;z<=increment_barang;z++){
				if(!isNaN($('.semua_'+z).val())){
					temporary_jumlah = parseInt(temporary_jumlah) + parseInt($('.semua_'+z).val());
					}
				}
			//lakukan perbandingan omset temporary / 350000 dengan jumlah barang yang dimasukan
			temporary_nominal = parseInt(temporary_omset) / parseInt(special_price_control);	
			//pembulatan math.floor agar membandingkan lebih mudah dengan integer
			temporary_nominal = Math.floor(temporary_nominal);
			//
			//alert(temporary_nominal+','+temporary_jumlah);
			
			if(parseInt($("#id_cabang").val()) != 1){ //untuk BUKAN ADMIN
				console.log("id_cabang not 1");
				if(temporary_jumlah > temporary_nominal){
					alert('penebusan hanya '+temporary_nominal);
					$('.semua_'+id).val(0);
					}else if(temporary_jumlah == temporary_nominal){ //kondisi hanya sementara karena freenya sudah tidak ada
						alert('jumlah barang sudah terpilih silahkan lanjutkan pembayaran');
						
						$('.id1').attr('disabled','disabled');
						$('#addBrg').attr('disabled','disabled');
						}
						
				}else{
					
					console.log("id_cabang is 1");
					}
			}
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
    	
        var temp = 0;
            hitungPembayaran();
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
	function kali_free(id){
		var increment_barang = idx;
		var temporary = $('#increment').val();
		var temporary_omset  = 0;
		var temporary_nominal = 0;
		var temporary_jumlah = 0;
		
		//pengecekan semua nominal quantity
		//alert(increment_barang);
		for(var z=0;z<=increment_barang;z++){
			if(!isNaN($('.semua_free_'+z).val())){
				temporary_jumlah = parseInt(temporary_jumlah) + parseInt($('.semua_free_'+z).val());
				}
			}
		//lakukan perbandingan omset temporary / 350000 dengan jumlah barang yang dimasukan
		temporary_nominal = parseInt(temporary_omset) / parseInt(special_price_control);	
		//pembulatan math.floor agar membandingkan lebih mudah dengan integer
		temporary_nominal = Math.floor(temporary_nominal);
		//
		//alert(temporary_nominal+','+temporary_jumlah);
		
		if(parseInt($("#id_cabang").val()) != 1){ //untuk BUKAN ADMIN
			
		
			if(temporary_jumlah > temporary){
				alert('penebusan hanya '+temporary);
				$('.semua_free_'+id).val(0);
				}else if(temporary_jumlah == temporary){ //kondisi jika barang yang dipilih sesuai dengan jumlah tertera
					alert('pemilihan barang free berhasil');
					
					}
			}
	}
        
   

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })



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

