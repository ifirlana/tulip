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
		
            function autoCompPromoNormal() {
				console.log("autoCompPromoNormal ");
				$("#id1").autocomplete({
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
					function() {
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
			
						
			function autoComp() {
					if ($('#intid_jpenjualan').attr('value') == 2) {
						hut();
					} else if ($('#intid_jpenjualan').attr('value') == 4) {
						tradein();
						//alert("1");
					} else if ($('#intid_jpenjualan').attr('value') == 5 || $('#intid_jpenjualan').attr('value') == 6) {
						satufreesatu();
						//alert("2");
					} else if ($('#intid_jpenjualan').attr('value') == 7) {
						netto();
						//alert("3");
					} else if ($('#intid_jpenjualan').attr('value') == 8) {
						lain();
					//	alert("4");
					} else {
						autoCompPromoNormal();
							console.log("running : autoCompPromoNormal ");
					}
					
					if ($("#chkBox20").attr('checked') == true) {
						if ($("#tracker002").val() == "bayar")
						{
							autoCompPromo20Bayar();
							console.log("running : autoCompPromo20Bayar ");
							
						} else if ($("#tracker002").val() == "free") {
							
							autoCompPromo20Free();
							console.log("running : autoCompPromo20Free ");	
						}
						
					} else if ($("#chkBox10").attr('checked') == true) {
						if ($("#tracker002").val() == "bayar")
						{
							autoCompPromo10Bayar();
							console.log("running : autoCompPromo10Bayar ");
						} else if ($("#tracker002").val() == "free") {
							autoCompPromo10Free();
							console.log("running : autoCompPromo10Free ");
						}
					}
				}
				
			//for unit
            $(document).ready( function() {
			
			window.pod = 0;
			
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
                        "<input type='hidden' id='id_unit' value='" + ui.item.id + "' size='10' readonly='readonly' />"
                    );
                    },
                });


                $("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupDownline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                unit: $('#id_unit').val(),
                                upline: $('#id_upline').val(),


                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(){
							var q=$(this).val();
							$(this).val(q);
							},
					select:
                        function(event, ui) {
                        $("#result001").empty();
                        $("#result001").html(
                        "<input type='text' align='top' name='downline' id='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/><input type='hidden' id='id_starterkit' value='"+ui.item.starterkit+"'></td>"
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
           //autoCompSpecial();
          set_pembayaran();
		  set_form_barang();
		   
		   autoComp();
		   /* 
		   $("#formpilihbarang").removeAttr("style","display:none");
		   $("#id1").removeAttr("disabled",true);
		   
		   $('#id1').attr('readonly', true);
		   
		   $("#formpilihbarang").removeAttr("style","display:none");
		   $("#id1").removeAttr("readonly");
		   $("#id1").removeAttr("disabled");
		   */
		   
		   //custom editan
		   $('#id1').attr('disabled', true);
		   $("#form_submenu").attr("style","display:none");
		  
			//kali();
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
	
	</script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Penebusan ABO</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/saveAbo" method="post" name="frmjual" id="frmjual">
						<input type='hidden' name='halaman' id='halaman' value='SPP' readonly= 'readonly' />
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">Unit <?php echo $unit;?><input type="hidden" id="id_unit" name="id_unit" value="<?php echo $intid_unit;?>"></td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    
                                    <td >&nbsp;<?php echo $cabang; ?>
                                    <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">         </td>
                                    <td>&nbsp;,</td>
                                    <td>&nbsp;<?php echo date("d-m-Y");?></td>
                                </tr>
                                <tr id='FormUNIT'>
                                    <td colspan="2">Upline <?php echo $strnama_dealer;?><input type="hidden" name="strkode_dealer" id="id_upline" value="<?php echo $strkode_dealer;?>"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;Unit</td>
                                    <td>&nbsp;:</td>
                                    <td><input type="text" name="hidden" id="intid_unit"  size="25" value="<?php echo $unit;?>" readonly/></td>
                                </tr>
                                <tr id='FormNama'>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="82">&nbsp;Nama Downline</td>
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
                                    <td>
										<select name="intid_jpenjualan" id="intid_jpenjualan">
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
											Mengacu Nota : Awal 30 Juni 2014<input type='hidden' name='tanggal_sekarang' id='tanggal_sekarang' value='2014-05-30' readonly='readonly'><input class="button" type="button" value="Cek Omset"  id="cek_omset"/></div>
										</td>
                                    <td><div id="omset" style="display:none"></div></td>
                                    <td>&nbsp;</td>
                              
                              </tr>
							  <?php /* penambahan form submenu  */ ?>
							  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="4">
									  <div id="form_submenu">
									  <table border="0" id="data">
										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td colspan="3">  Paket Promo 20% </td>
											<td>  <input type="checkbox" name="chkBox20" id="chkBox20" disabled="disabled"/>
												<input type="hidden" name="txtpromo20" id="txtpromo20"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
												<input type="hidden" id="jumlahbrg20">
												<input type="hidden" name="chkV20" id="chkV20" disabled="disabled"/>
												<?php //echo"<input type="checkbox" name="chkV20" id="chkV20" disabled="disabled"/> Voucher;?>
												
												<input type="hidden" name="txtvoucher" id="txtvoucher"  size="4" /></td>
										</tr>
										<tr>
											<td colspan="2">&nbsp;<input type="hidden" name="textfield" id="txtp10" />
												
											   <input type="hidden" name="textfield" id="txtps10" />
											<input type="hidden" name="textfield" id="onefree" />
											 <input type="hidden" name="textfield" id="onesfree" />
											<input type="hidden" name="textfield" id="onefreehut" />
											<input type="hidden" name="textfield" id="onesfreehut" />
											<input type="hidden" name="textfield" id="freeonefree" />
											<input type="hidden" name="textfield" id="freeonefreehut" />
											<input type="hidden" id="id_wilayah" value="<?php echo $intid_wilayah;?>" />
											
												</td>
											<td colspan="3" >  Paket Promo 10%</td>
											<td><input type="checkbox" name="chkBox10" id="chkBox10" disabled="disabled"/>
												<input type="hidden" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
												<input type="hidden" id="jumlahbrg10">
												<input type="hidden" name="chkV10" id="chkV10" disabled="disabled"/>
											   <?php //echo"<input type="checkbox" name="chkV10" id="chkV10" disabled="disabled"/> Voucher;?>
											   </td>
										</tr>
										 <tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td colspan="3">Voucher</td>
											<td>
												<input type="checkbox" name="chkV" id="chkV" onclick="kali()"/></td>
										</tr>
										</table>
										</div>
									</td>
								</tr>
								<tr><td colspan="6"><div align="center" id="title"></div></td></tr>
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
														<input type="hidden" id="tracker002" value="bayar" />
														<input type="hidden" id="tracker004" value="" />
                                                    </div>    
												</td>
                                      </tr>
                                            <tr  id='formBayar' >
                                                <td>&nbsp;Pilih Barang -&gt; <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;<input type="text" name="barang[1][intid_barang]" class="id1" size="50" id="id1" /></td>
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
                                    <td style='width:200px;'>
                                        Rp.<input type="text" name="jml10" id="intjumlah1" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jml20" id="intjumlah2" readonly="readonly" value="0"/><br />
                                        Rp.<input type="text" name="jumlah" id="intjumlah" readonly="readonly" value="0"/>

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
                                    <td>Rp.<input type="text" name="totalbayar1" id="totalbayar" readonly="readonly" value="0"/>
                                        <input type="hidden" name="totalbayar" id="totalbayar1" />
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

	/**
	LOOKUP BARANG
	
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
						$("#harga_barang").val(0);
                        $("#result2").html(
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
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangPromo10",
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='text' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
                    );
                    },
                });
	}
	/*
	* auto complete bwt promo 10 yg free	
	*/
	function autoCompPromo10Free() {
				console.log("autoCompPromo10Free @start");
                $(".id1").autocomplete({
                    minLength: 5,
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
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
						$("#harga_barang").val(0);
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='trackhargatemp' name'trackhargatemp' value='" + ui.item.value1 + "' readonly />"
                    );
                    },
                });
	}
	
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

		$('#intid_jpenjualan').attr("disabled","disabled");
		//keterangan
		//menyimpan nilai tradeIn ke input type text karena jika didisabled maka value yang akan dikirim akan tidak termasukan
		$('.komisitrade').val($('#komisitrade').val());
		$('#komisitrade').attr("disabled","disabled");
	//001
		if($("#track1").val() == 0) {$("#metal_1").removeAttr("disabled");}
		if($("#track2").val() == 0) {$("#metal_2").removeAttr("disabled");}
		if($("#track3").val() == 0) {$("#metal_3").removeAttr("disabled");}
		if($("#track4").val() == 0) {$("#metal_4").removeAttr("disabled");}
		if($("#track5").val() == 0) {$("#metal_5").removeAttr("disabled");}
		if($("#track6").val() == 0) {$("#metal_6").removeAttr("disabled");}

        if(($(".id1").val()=="") &&($(".frees").val()=="")){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "" && $("#tracker002").val() == "bayar")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var id_barang =  $('#id_barang').val();
            var pv =  $('#pv').val();
            var total = jumlah * harga;
			var nomor_nota = $('#nomor_nota').val();

            var out = '';
            out += 'Banyaknya<br>';
            if($("#chkBox20").attr('checked') == true){
                out += '<input type="hidden"  id="hit20" name="hit20[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            else if($("#chkBox10").attr('checked') == true){
                out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
            }

            else if($("#chkBoxTrade").attr('checked') == true){
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
            }else{
                out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id); return lain2();" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
            if($("#intid_jpenjualan").val() == 7){
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="0" readonly>';
            }else{
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
            }
            out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
            out += '<input id="barang_'+idx+'_intid_id" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
			
					//001
					out += '<input id="tracker003_'+idx+'" name="tracker003_'+idx+'" type="hidden" value="1">';
					out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					
			out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
			
			//001
			//ajaxgila(idx);
			
            idx++;
            idxf++;
            $('#id1').val('');
			$(".id1").val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            $('#pv').val('');
       }
        return false;

    });


	$('#addBrg').bind('click', function(e){
		if($('.id1').val() != "" && $("#tracker002").val() == "free")
			{
				var brg = $('.id1').val();
				var jumlah = $('#jumlah').val();
				var harga = 0;
				if ($('#id_free').val() == 0)
				{
					alert("barang ilank");
				}
				var id_barang =  $('#id_free').val();
				var total = jumlah * harga;
				var out = '';
				var nomor_nota = $('#nomor_nota').val();

				out += '<sup>(Free)</sup>Banyaknya<br>';
				if($("#chkBox10").attr('checked') == true){
					out += '<input type="hidden" id="hitfree10" name="hitfree10[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				}else if($("#chkBox20").attr('checked') == true){
					out += '<input type="hidden" id="hitfree20" name="hitfree20[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="free20_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				}else if($("#chkBoxFree").attr('checked') == true){
					out += '<input type="hidden" id="hitonefree" name="hitonefree[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="freeone_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				}else if($("#chkBoxFreeHut").attr('checked') == true){
					out += '<input type="hidden" id="hitonefreehut" name="hitonefreehut[]" value="'+idx+'">';
					out += '<input id="'+idx+'" class="freeonehut_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				}else{
					//out += '<input id="'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
					out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                	out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id); return lain2();" onkeypress="return isNumberKey(event)" />&nbsp;';
				}
				out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly/>';
				out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
				out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
				out += '<input name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
				out += '<input type="hidden" name="barang_free['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
				out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a> ';
				out = '<div style="height:60px">' + out + '</div>';
				$(out).insertBefore('#ButtonAdd');
				
				idx++;
				idxf++;
				$('#id1').val('');
				$(".id1").val("");
				$('#pv').val('');
				$('.frees').attr('disabled', 'disabled');
				$('.frees').val('');
				$('#harga_barang_free').val('');
				$('#jumlah').val('');
				$('#harga_barang').val('');
			}
			return false;

    	});
	$("#chkBox20").click(function(){
		  autoComp();
		  $("#chkBox10").attr("checked",false);
		});
	$("#chkBox10").click(function(){
		  autoComp();
		  $("#chkBox20").attr("checked",false); 
		});
	/*
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
*/
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

		$('#txtpromo10').val('');
		$("#chkBox10").removeAttr("disabled");
		$("#chkBox20").removeAttr("disabled");

		$("#chkBox20").attr("checked",false);
		$("#txtpromo20").val("");
		$("#txtpromo20").attr("disabled","disabled");
		$("#chkV20").attr("checked",false);
		$("#chkBox10").attr("checked",false);
		$("#txtpromo10").val("");
		$("#txtpromo10").attr("disabled","disabled");
		$("#chkV10").attr("checked",false);
		$("#chkBoxTrade").attr("checked",false);
		$("#komisitrade").val("0%");
		$("#komisitrade").attr("disabled","disabled");
		$("#chkBoxFreeHut").attr("checked",false);
		$("#txtfreehut").val("");
		$("#txtfreehut").attr("disabled","disabled");
		$("#chkBoxFree").attr("checked",false);
		$("#txtfree").val("");
		$("#txtfree").attr("disabled","disabled");
		//$("#chkV").attr("checked",false);
		
		//$('.id1').removeAttr('disabled');
		$('.id1').attr('disabled',true);
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
		else  if ($(this).attr('value')== 1) {
			var title = "Nota Penjualan Reguler";
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
                 url: "<?php echo base_url(); ?>penjualan/hitungomsetAbo",
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
		sisa_baru();
    }

	function sisa_baru() {
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
			$('#intid_jpenjualan').removeAttr("disabled");
		}
	}
	/**
	* function formatAsRupiah yg baru dan unformatFromRupiah
	* @param amount (angka int yg bakal dirubah ke rupiah)
	*/
	function formatAsRupiah(amount){
	/*
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
			*/
			return amount;
    	}
	function unformatFromRupiah(_amount){
	/*
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
		*/
		return _amount;
	}

	//checkbox penjualan reguler
	
	$("#chkBox20").click(function(){
      	autoComp();
		//$("#chkV").attr("checked",false);
		$("#chkBox10").attr("checked",false);
		$("#txtpromo10").val("");
		$("#txtpromo20").val("");
		$("#txtpromo10").attr("disabled","disabled");
		$("#chkV10").attr("disabled","disabled");
			if($("#chkBox20").attr('checked') == true){
				$("#chkBox10").attr("checked",false);
				$("#txtpromo10").val("");
				$("#txtpromo20").val("");
				$("#txtpromo10").attr("disabled","disabled");
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
				$("#jumlahbrg20").val(' ');
				$("#jumlahsementara").val($("#intjumlah2hidden").val());
			}
		if($("#intid_jpenjualan").val()==7)
		{
			$("#chkV20").attr("disabled","disabled");
		}
		console.log("running : paket promo 20");
    });

	$("#chkBox10").click(function(){
      autoComp();
		//$("#chkV").attr("checked",false);
		$("#chkBox20").attr("checked",false);
		$("#txtpromo20").val("");
		$("#txtpromo10").val("");
		$("#txtpromo20").attr("disabled","disabled");
		$("#chkV20").attr("disabled","disabled");
			if($("#chkBox10").attr("checked") == true){
			$("#chkBox20").attr("checked",false);
			$("#txtpromo20").val("");
			$("#txtpromo10").val("");
			$("#txtpromo20").attr("disabled","disabled");
			$("#chkV20").attr("disabled","disabled");
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
			if($("#intid_jpenjualan").val()==7)
			{
				$("#chkV10").attr("disabled","disabled");
			}
			
			console.log("running : paket promo 10");
		});
			
	///
	
	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kali_baru(id){
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
		//itung jumlah barang free normal total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.free_'+ i).val()) >=0) {
				if (parseInt($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseInt($('.free_'+ i).val());
				}
			}
		}
		//itung jumlah barang free promo 20 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree20 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.free20_'+ i).val()) >=0) {
				if (parseInt($('.free20_'+ i).val()) != '')
				{
					_totalQuantityFree20 += parseInt($('.free20_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F1HUT = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.onefreehuts_'+ i).val()) >=0) {
				if (parseInt($('.onefreehuts_'+ i).val()) != '')
				{
					_totalQuantity1F1HUT += parseInt($('.onefreehuts_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F1HUT = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.freeonehut_'+ i).val()) >=0) {
				if (parseInt($('.freeonehut_'+ i).val()) != '')
				{
					_totalQuantityFree1F1HUT += parseInt($('.freeonehut_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F110 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.onefrees_'+ i).val()) >=0) {
				if (parseInt($('.onefrees_'+ i).val()) != '')
				{
					_totalQuantity1F110 += parseInt($('.onefrees_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F110 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.freeone_'+ i).val()) >=0) {
				if (parseInt($('.freeone_'+ i).val()) != '')
				{
					_totalQuantityFree1F110 += parseInt($('.freeone_'+ i).val());
				}
			}
		}
		
		//harga total barang semua setelah harga dikalikan dengan jumlah
		var _totalHargaSemua = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('#'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('#'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('#'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHargaSemua += parseInt($('#total_' + i).val());
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
		
		//harga total barang 1 Free 1 HUT/Nett setelah harga dikalikan dengan jumlah
		var _totalHargaFreeHUT = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('.onefreehuts_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('.onefreehuts_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.onefreehuts_'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHargaFreeHUT += parseInt($('#total_' + i).val());
			}
		}
		
		//harga total barang 1 Free 1 HUT 10% setelah harga dikalikan dengan jumlah
		var _totalHargaFrees = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if($('.onefrees_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseInt($('.onefrees_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.onefrees_'+ i).val()) * parseInt($('#harga_' + i).val()));
				_totalHargaFrees += parseInt($('#total_' + i).val());
			}
		}

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
		$('#intjumlah1').val(_totalHarga10);
		$('#intjumlah2').val(_totalHarga20 + _totalHargaNormal);
		$('#intjumlah').val(parseInt($('#intjumlah1').val()) + parseInt($('#intjumlah2').val()) + _totalHargaFreeHUT + _totalHargaFrees);
		$('#totalbayar').val(parseInt($('#intjumlah').val()));

		//total semua pv yg didapat di nota ini
		var _totalPV = 0;
		if ($('#intid_jpenjualan').attr('value') != 2)
		{
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				if (parseFloat($('#pv_'+ i).val()) > 0) {
					_totalPV += (parseInt($('#total_'+ i).val()) / parseInt($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
				}
			}
			$('#intpv').val(_totalPV.toFixed(2));
		}
		
		//hitung komisi 10% dan kurangi totalbayar
		if ($('#intjumlah1').val() != '' && $('#intid_jpenjualan').attr('value') != 4 && $('#intid_jpenjualan').attr('value') != 7 && $('#intid_jpenjualan').attr('value') != 8)
		{
			$('#komisi1').val(parseInt($('#intjumlah1').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi1').val()));
		}

		//hitung komisi 20% dan kurangi totalbayar
		if ($('#intjumlah2').val() != '' && $('#intid_jpenjualan').attr('value') != 4 && $('#intid_jpenjualan').attr('value') != 7 && $('#intid_jpenjualan').attr('value') != 8)
		{
			$('#komisi2').val(parseInt($('#intjumlah2').val()) * 0.2);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi2').val()));
		}
		
		/*______________________________________________________________________________
		|																				|
		|					Kode yg bisa brubah2 tergantung promonya					|
		|______________________________________________________________________________*/

		//promo 10 dan 20
		//hitung jumlah total barang free yg boleh dikeluarkan
		var _tempCount = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh_'+ i).val()) > 0) {
					_tempCount += parseInt($('.sepuluh_'+ i).val()) / 2;
				}
				if (parseInt($('.duapuluh_'+ i).val()) > 0 && $("#chkSmart").attr("checked") != true) {
					_tempCount += parseInt($('#tracker003_'+ i).val()) * parseInt($('.duapuluh_'+ i).val());
					console.log("hitung 20 : "+parseInt($('#tracker003_'+ i).val())+" * "+parseInt($('.duapuluh_'+ i).val())+" += "+_tempCount);
				}
			}
		}
		$('#tracker004').val(Math.floor(_tempCount));
		//cek apakah jumlah barang bayar dan free sudah benar
		if (parseInt($('#tracker004').val()) > _totalQuantityFree + _totalQuantityFree20) {
			alert("Silakan pilih barang freeeeeeeeeee");
			$('#tracker002').val("free");
		} else if ($('#tracker004').val() == _totalQuantityFree + _totalQuantityFree20) { 
			$('#tracker002').val("bayar");
		} else if ($('#tracker004').val() < _totalQuantityFree + _totalQuantityFree20) {
			alert("Jumlah barang free melebihi quota");
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				$('.free20_'+ i).val('');
				$('.free_'+ i).val('');
			}
		}
		
		//promo trade in
		var _temppv = 0;
		if ($('#intid_jpenjualan').attr('value') == 4)
		{
			$('#intjumlah1').val(_totalHargaSemua - (_totalHargaSemua * $('#komisitrade').val() / 100));
			$('#intjumlah2').val(0);
			$('#intjumlah').val(_totalHargaSemua - (_totalHargaSemua * $('#komisitrade').val() / 100));
			
			for(var i = 1; i <= parseInt($('#tracker001').val()); i++){
			_temppv += $('#pv_' + i).val() * parseFloat((100 - parseInt($('#komisitrade').val()))/100)* $('#'+i).val();
			}
			_temppv = _temppv.toFixed(2);
			//$('#intpv').val((parseInt($('#intjumlah').val()) / 100000).toFixed(2));
			$('#intpv').val(_temppv);
			$('#komisi1').val(parseInt($('#intjumlah').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val()));
		}
		
		//promo 1 free 1 hut/nett
		if ($('#intid_jpenjualan').attr('value') == 5)
		{
			$('#intjumlah1').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah').val(_totalHargaFreeHUT);
			$('#intpv').val((parseInt($('#intjumlah').val()) / 100000).toFixed(2));
			$('#totalbayar').val(parseInt($('#intjumlah').val()));
			if (_totalQuantity1F1HUT > _totalQuantityFree1F1HUT)
			{
				$('#tracker002').val("free");
				alert("Silakan pilih barang free");
			}
			else if (_totalQuantity1F1HUT == _totalQuantityFree1F1HUT && _totalQuantity1F1HUT != 0)
			{
				$('#tracker002').val("bayar");
				alert("Promo sukses");
			}
			else if (_totalQuantity1F1HUT < _totalQuantityFree1F1HUT)
			{
				$('#tracker002').val("bayar");
				alert("Barang free melebihi jumlah promo");
				for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
					$('.freeonehut_'+i).val('');
				}
			}
		}
		
		//promo 1 free 1 10%
		if ($('#intid_jpenjualan').attr('value') == 6)
		{
			$('#intjumlah1').val(_totalHargaFrees);
			$('#intjumlah2').val(0);
			$('#intjumlah').val(_totalHargaFrees);
			$('#intpv').val((parseInt($('#intjumlah').val()) / 100000).toFixed(2));
			$('#komisi1').val(parseInt($('#intjumlah').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val()));
			if (_totalQuantity1F110 > _totalQuantityFree1F110)
			{
				$('#tracker002').val("free");
				alert("Silakan pilih barang free");
			}
			else if (_totalQuantity1F110 == _totalQuantityFree1F110 && _totalQuantity1F110 != 0)
			{
				$('#tracker002').val("bayar");
				alert("Promo sukses");
			}
			else if (_totalQuantity1F110 < _totalQuantityFree1F110)
			{
				$('#tracker002').val("bayar");
				alert("Barang free melebihi jumlah promo");
				for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
					$('.freeone_'+i).val('');
				}
			}
		}
		
		//promo netto
		if ($('#intid_jpenjualan').attr('value') == 7)
		{
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			$('#intpv').val(0);
		}
		
		//promo lain-lain
		if ($('#intid_jpenjualan').attr('value') == 8)
		{
			$('#intjumlah1').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah').val(0);
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			$('#intpv').val(0);
		}
		autoComp();

		/*______________________________________________________________________________
		|																				|
		|				End Of Kode yg bisa brubah2 tergantung promonya					|
		|______________________________________________________________________________*/
		
		//apabila voucher di checklist
		if ($("#chkV").attr('checked') == true)
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
			
				if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							_voucher = 100000;
							}
							else{
								
								_voucher = 50000;
								}
			} else {
			
				if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							_voucher = 100000;
							}
							else{
								
								_voucher = 50000;
								}
			}
			$('#intvoucher').val(_voucher);
			if ($('#intjumlah1').val() != '' && $('#intjumlah1').val() != 0)
			{
				$('#intjumlah1').val(parseInt($('#intjumlah1').val()) - _voucher);
			} else {
				$('#intjumlah2').val(parseInt($('#intjumlah2').val()) - _voucher);
			}
			$('#intjumlah').val(parseInt($('#intjumlah').val()) - _voucher);
			$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 100000));
			if ($('#komisi1').val() != '' && $('#komisi1').val() != 0)
			{
				$('#komisi1').val(parseInt($('#komisi1').val()) - (_voucher * 0.1));
			} else {
				$('#komisi2').val(parseInt($('#komisi2').val()) - (_voucher * 0.2));
			}
			$('#totalbayar').val((parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val())) - parseInt($('#komisi2').val()));
			if ($('#intpv').val() < 0) { $('#intpv').val(0); }
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
			if ($("#chkBox20").attr("checked") == true) {
				$('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
			}
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

		return false;
	}
	
	//
	
	function pindah(id){
		kali(id);
	}
	/*
    function kali(id){
		
		var increment_barang = idx;
		var special_price_control = 350000; //untuk mengontrol pengambilan jumlah barang
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
			if(temporary_jumlah > temporary_nominal){
				alert('penebusan hanya '+temporary_nominal);
				$('.semua_'+id).val(0);
				}else if(temporary_jumlah == temporary_nominal){ //kondisi hanya sementara karena freenya sudah tidak ada
					alert('jumlah barang sudah terpilih silahkan lanjutkan pembayaran');
					
					$('.id1').attr('disabled','disabled');
					$('#addBrg').attr('disabled','disabled');
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
		if(temporary_jumlah > temporary){
			alert('penebusan hanya '+temporary);
			$('.semua_free_'+id).val(0);
			}else if(temporary_jumlah == temporary){ //kondisi jika barang yang dipilih sesuai dengan jumlah tertera
				alert('pemilihan barang free berhasil');
				
				}
	}
     */
	
    function kali(id){
//001
		if($("#intid_jpenjualan").val() == 13 && $(".semua_" + id).val() > 1)
		{
			alert("Tidak boleh lebih dari 1");
			$(".semua_" + id).val(0);
		}

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
		$("#intid_jpenjualan").attr('readonly','readonly');
		
        if($("#chkBox20").attr('checked') == true){

            var cs = document.getElementsByName("hit20[]").length;
			if(cs > 1){
				var sid = cs + 1;
			}else{
				var sid = cs;
			}
            var lim20 = limit20;


            for(var i=sid; i<= parseInt(id);i++){

                var jumlah = parseInt($('.duapuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
					if(jumlah > parseInt($('#txtpromo20').val())){
							console.log("break : ");
                            break;
                        }
					}
				}

			for(var i=1; i<= parseInt(id);i++){

                var jumlah = parseInt($('.duapuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;
						}
				}

            $('#jumlahbrg20').val(jml);

            var j20 = parseInt($('#jumlahbrg20').val());


            if(j20 >= lim20){
                
				$('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
				}else{
					
					$('#addBrg').removeAttr('disabled');
					$('.id1').removeAttr('disabled');
					}

            if($('#komisihide').val() != ""){
			
                var komhide = parseInt($('#komisihide').val());
                var s = komhide + total;
				}else{
				
					var s = total;
					}

            if($("#chkV20").attr('checked') == true){
			/*
				if ($('#id_wilayah').val() == 1){
				
					sall=s-50000;
					$('#intvoucher').val(50000);
					} else {
					
						sall=s-60000;
						$('#intvoucher').val(60000);
						}*/
				if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							//totalreg=total-100000;
							//$('#intvoucher').val(100000);
							sall=s-100000;
							$('#intvoucher').val(100000);
							}
							else{
								
								//totalreg=total-50000;
								//$('#intvoucher').val(50000);
								sall=s-50000;
								$('#intvoucher').val(50000);
								}
				$('#txtvoucher').val(1);
				} else {
				
					sall=s;
					}

		if($('#chkV').attr('checked') == true && sall < 0){
		
			sall = 0;
			}

            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);

            var total = parseInt($('#intjumlah2hidden').val());

		if($('#intid_jpenjualan').val() != 7) {

				var disc = 20;
				var komisi20 = (total * disc) / 100;

			if($('#chkV').attr('checked') == true && komisi20 < 0){
			
				komisi20 = 0;
				}

				$('#komisi2').val(formatAsDollars(komisi20));
				$('#komisi2hidden').val(komisi20);
				
				console.log("?? $('#intid_jpenjualan').val() != 7 ");

			}

        }else if($("#chkBox10").attr('checked') == true){

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
			}
			
			$('#txtp10').val(j);
            			
			if($("#txtps10").val()==''){
				var j10 = j;
			}else{
				j10 = j - $("#txtps10").val();
			}
				
			if(j10 >= tt){
                $('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');

            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
            }
			
			if($("#chkV10").attr('checked') == true){
			/*
				if ($('#id_wilayah').val() == 1){
					total10=total-50000;
					$('#intvoucher').val(50000);
				} else {
					total10=total-60000;
					$('#intvoucher').val(60000);
				}*/
				if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							//totalreg=total-100000;
							//$('#intvoucher').val(100000);
							sall=s-100000;
							$('#intvoucher').val(100000);
							}
							else{
								
								//totalreg=total-50000;
								//$('#intvoucher').val(50000);
								sall=s-50000;
								$('#intvoucher').val(50000);
								}
				$('#txtvoucher').val(1);
			} else {
				total10=total;
			}

			if($('#chkV').attr('checked') == true && total10 < 0)
			{
				total10 = 0;
			}

				$('#intjumlah1').val(formatAsDollars(total10));
				$('#intjumlah1hidden').val(total10);
				var total = parseInt($('#intjumlah1hidden').val());

			if($('#intid_jpenjualan').val() != 7) {

					var disc = 10;
					var komisi = (total * disc) / 100;

				if($('#chkV').attr('checked') == true && komisi < 0)
				{
					komisi = 0;
				}

					if($('#komisi1hidden').val()!=""){
						var totkom = komisi;
						$('#komisi1hidden').val(totkom);
						$('#komisi1').val(formatAsDollars(totkom));
					}else{
						$('#komisi1hidden').val(komisi);
						$('#komisi1').val(formatAsDollars(komisi));
					}

			}

        }else if($("#chkBoxFreeHut").attr('checked') == true){
                var cs3 = $('#hitfreehut').val();
                var jfreehut = 0;
                for(var i=cs3; i<= parseInt(id);i++){

                    var jumlah = parseInt($('.onefreehuts_'+ i).val());
                   	var harga = parseInt($('#harga_' + i).val());
					var pv = parseFloat($('#pv_' + i).val());
                    var tot = jumlah * harga;
					if(tot>=0){
						
						$('#total_' + i).val(Number(tot));
						total += tot;
						jfreehut += jumlah;
							
					}

                }
			
			$('#onefreehut').val(jfreehut);
            			
			if($("#onesfreehut").val()==''){
				var jfh = jfreehut;
			}else{
				jfh = jfreehut - $("#onesfreehut").val();
			}	
            
			//$('#jumlahbrgfreehut').val(jfreehut);
            
			if(jfh > limitfreehut){
			}
			
			if(jfh >= limitfreehut){
               	$('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
            }
            
			$('#intjumlah1').val(formatAsDollars(total));
            $('#intjumlah1hidden').val(total);
			//$('#intjumlahfree').val(total);


        }else if($("#chkBoxFree").attr('checked') == true){

                var cs3 = $('#hitfree').val();
                var jfree = 0;
                for(var i=cs3; i<= parseInt(id);i++){
                    
                    var jumlah = parseInt($('.onefrees_'+ i).val());
                    var harga = parseInt($('#harga_' + i).val());
					var pv = parseFloat($('#pv_' + i).val());
                    var tot = jumlah * harga;
						
						if(tot>=0){
						$('#total_' + i).val(Number(tot));
						total += tot;
						jfree += jumlah;
						}
				}
						
            //$('#jumlahbrgfree').val(jfree);
                   
			$('#onefree').val(jfree);
            			
			if($("#onesfree").val()==''){
				var jf = jfree;
			}else{
				var jf = jfree;
				jf = jfree - $("#onesfree").val();
			}	
			
			if(jf > limitfree){
			}
			
			if(jf >= limitfree){
				$('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
			}else{
				$('#addBrg').removeAttr('disabled');
				$('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
			}

			var disc = 10;
            var komisi = (total * disc) / 100;

			if($('#chkV').attr('checked') == true && komisi < 0)
			{
				komisi = 0;
			}
            
			if($('#komisi1hidden').val()!=""){

                var totkom = komisi;
                $('#komisi1hidden').val(totkom);
                $('#komisi1').val(formatAsDollars(totkom));
            }else{
                $('#komisi1hidden').val(komisi);
                $('#komisi1').val(formatAsDollars(komisi));
            }

			if($('#chkV').attr('checked') == true && total < 0)
			{
				total = 0;
			}
			
			$('#intjumlah1').val(formatAsDollars(total));
            $('#intjumlah1hidden').val(total);
			//$('#intjumlahfree').val(total);
       
	   }else if($("#chkBoxTrade").attr('checked') == true){
	   
            var cs = $('#hittrade').val();

            for(var i=cs; i<= parseInt(id);i++){

                var jumlah = parseInt($('#'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){

                    if(harga >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;
                    }
                }
            }


            var komtrade = parseInt($('#komisitrade').val());
            var totkom = (total * komtrade) /100;


			//pv dihitung dari pv barang bukan dari komisi tapi dari barang yang memiliki pv
			$('#komisi1hidden').val(totkom);
            var jumhide = parseInt($('#intjumlahhidden').val());
            var totOm = total - parseInt($('#komisi1hidden').val());
			var komtrade = (totOm*10)/100;

			if($('#chkV').attr('checked') == true && komtrade < 0)
			{
				komtrade = 0;
			}

				$('#komisihide').val(formatAsDollars(komtrade));
				$('#komisi1').val(formatAsDollars(komtrade));
				$('#komisi1hidden').val(komtrade);

                var jumtothide = totOm;

			if($('#chkV').attr('checked') == true && jumtothide < 0)
			{
				jumtothide = 0;
			}

			$('#intjumlah').val(formatAsDollars(jumtothide));
            $('#intjumlahtradehidden').val(jumtothide);

				$('#intpv_trade').val(jumtothide/100000);
				//$('#intpv_trade').val();
			

		} else if($("#intid_jpenjualan").val()==7){
		//for netto
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
                }
            }

                $('#intjumlah2hidden').val(total);

        //end netto
		} else if($("#intid_jpenjualan").val()==8){
		//for lain-lain
			
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                
                var t = jumlah * harga;
			    $('#total_' + i).val(t);
                total += t;
             }
				
				$('#intjumlah2hidden').val(total);
						
				$('#intjumlah1').val('0');
				$('#intjumlah2').val('0');
				$('#intjumlah').val('0');
				$('#intpv').val('0');
				$('#komisi2').val('0');
				$('#komisi1').val('0');
				$('#komisi1hidden').val('0');
				$('#komisi2hidden').val('0');
	    //end lain-lain
		}
        else{

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
	
            	//voucher		    
				if($("#chkV").attr('checked') == true){
					if ($('#id_wilayah').val() == 1){
						
						//kondisi menyesal
						if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							totalreg=total-100000;
							$('#intvoucher').val(100000);
							}
							else{
								
								totalreg=total-50000;
								$('#intvoucher').val(50000);
								}
						//end		
					} else {
						
						//kondisi menyesal
						if($('#id_starterkit').val() == "6467" || $('#id_starterkit').val() == "6468" || $('#id_starterkit').val() == "6469" || $('#id_starterkit').val() == "6470" || $('#id_starterkit').val() == "6471" || $('#id_starterkit').val() == "6472"){
							
							totalreg=total-100000;
							$('#intvoucher').val(100000);
							}
							else{
								
								totalreg=total-50000;
								$('#intvoucher').val(50000);
								}
						//end
						}
					$('#txtvoucher').val(1);
				} else {
					totalreg=total;
				}
				
				
			if ($('#jumlahsementara').val()!= ""){
				var x = parseInt($('#jumlahsementara').val()) + totalreg;

			if($('#chkV').attr('checked') == true && x < 0)
			{
				x = 0;
			}

				$('#intjumlah2').val(formatAsDollars(x));
            	$('#intjumlah2hidden').val(x);
			} else {

			if($('#chkV').attr('checked') == true && totalreg < 0)
			{
				totalreg = 0;
			}

				$('#intjumlah2').val(formatAsDollars(totalreg));
            	$('#intjumlah2hidden').val(totalreg);

            }
			
			//$('#intjumlah2').val(formatAsDollars(totalreg));
            //$('#intjumlah2hidden').val(totalreg);
			$('#komisihide').val(total);

            var t = parseInt($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi = (t * disc) / 100;

			if($('#chkV').attr('checked') == true && komisi < 0)
			{
				komisi = 0;
			}

            $('#komisi2').val(formatAsDollars(komisi));
            $('#komisi2hidden').val(komisi);
			
			
			
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
			

        if($("#chkV20").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
			} else {
					pivi=pivi;
			}

		if($("#chkV10").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
		} else {
				pivi=pivi;
			}
		
		if($("#chkV").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
		} else {
				pivi=pivi;
		}
		
		//pv for HUT
		if($("#intid_jpenjualan").val()==2){
			pivi = 0
			}

        if($('#intpv_trade').val() != ""){
            var trade_pv = parseFloat($('#intpv_trade').val());
            var pvt = trade_pv;


            $('#intpv').val(formatNumber(pvt));
			}else{
				
				console.log("pivi trade");
				$('#intpv').val(formatNumber(pivi));
				}

		//modified 2014 04 08 ifirlana@gmail.com
		
        function formatNumber(num)
        {
            return (num);
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

		if($('#chkV').attr('checked') == true && omset < 0)
		{
			omset = 0;
		}

        $('#intjumlah').val(formatAsDollars(omset));
        $('#intjumlahhidden').val(omset);

        var totals = omset - kom1 - kom2;

		if($('#chkV').attr('checked') == true)
		{
			if(totals < 0){totals = 0;}
			if(parseFloat($('#intpv').val()) < 0){$('#intpv').val(0);}
			if(parseFloat($('#intpv_trade').val()) < 0){$('#intpv_trade').val(0);}
			}

        $('#totalbayar').val(formatAsDollars(totals));
        $('#totalbayar1').val(totals);
		if($("#intid_jpenjualan").val()==5){$('#intjumlah1').val(0);$('#intjumlah1hidden').val(0);}
		if($("#intid_jpenjualan").val()==13)
		{
			$('#intjumlah1').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah').val(0);
			$('#intjumlah1hidden').val(0);
			$('#intjumlah2hidden').val(0);
			$('#intjumlahhidden').val(0);
			$('#intjumlahtradehidden').val(0);
			$('#intjumlahfree').val(0);
			$('#intvoucher').val(0);
			$('#jumlahsementara').val(0);
			$('#intpv').val(0);
			$('#intpv_trade').val(0);
			$('#komisi2').val(0);
			$('#komisi2hidden').val(0);
			$('#komisihide').val(0);
			$('#komisi1').val(0);
			$('#komisi1hidden').val(0);
			$('#totalbayar').val(formatAsDollars(omset));
			$('#totalbayar1').val(omset);
			$('#totalbayar2').val(0);
			}
		if($("#intid_jpenjualan").val() < 9) {
			kali_baru(id);
			}
		console.log("running : kali()");
    }
   

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })



    function formatAsDollars(amount){


        return amount;
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

    function kali_sepuluh(id){
        //var jf=0;
		$("#del"+id).remove();
        if($("#chkBox10").attr('checked') == true){
            var cs2 = parseInt($('#hitfree10').val());
			var textpromo10 = parseInt($("#txtpromo10").val());
            
			for(var i=parseInt(cs2); i<= parseInt(id);i++){
                
				var jumlahfree = parseInt($('.free_'+ i).val());
                jf = jf + jumlahfree;
			}
						
			if(jumlahfree >= 0){
						
						if(jf > textpromo10){
							
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

        if($("#chkBox20").attr('checked') == true){
            var cs2 = document.getElementsByName("hitfree20[]").length;
            var textpromo20 = parseInt($("#txtpromo20").val());
			
			var id_b = id + 2;
            for(var i=cs2+1 ; i<= parseInt(id);i++){
                var jumlahfree = Number($('.free20_'+ i).val());
				jf = Number(jf) + jumlahfree;
                                
            }
			var batas20 = textpromo20 * 3;	
			        if(jumlahfree > batas20){
                    }
					if(cs2 >= batas20){
                        $('#addBrg').attr('disabled', 'disabled');
                        $('.frees').attr('disabled', 'disabled');
                        
                    }else{
                        $('#addBrg').removeAttr('disabled');
                        $('.frees').removeAttr('disabled');
                        
                    }
         }

        if($("#chkBoxFree").attr('checked') == true){
           	//var jumlahfree = 0
			var jf = 0
			var cs2 = parseInt($('#hitonefree').val());
			var txtfree = parseInt($("#txtfree").val());
		    
            for(var i=parseInt(id); i<= parseInt(id);i++){
               		//alert(i);
					var jumlahfree = parseInt($('.freeone_'+ i).val());
					//jf = jf + jumlahfree;
					jf += jumlahfree;
			}
			//alert(jf);
			if($("#freeonefree").val()==''){
				var jf1f = jf;
			}else{
				var fr = $("#freeonefree").val();
				var jf1f = jf - fr;
			}
			
			if(jf1f > txtfree){
						
			}
					
			if(jf1f >= txtfree){
					$('#addBrg').attr('disabled', 'disabled');
					$('.frees').attr('disabled', 'disabled');
				}else{
					$('#addBrg').removeAttr('disabled');
					$('.frees').removeAttr('disabled');
			}

        }

        if($("#chkBoxFreeHut").attr('checked') == true){
                jf = 0;
				var cs3 = parseInt($('#hitonefreehut').val());
				var limitfreehut = parseInt($('#txtfreehut').val());
                for(var i=parseInt(id); i<= parseInt(id);i++){

                    var jumlahfree = parseInt($('.freeonehut_'+ i).val());
                   	jf += jumlahfree;
                }
			
			//$('#freeonefreehut').val(jf);
			if($("#freeonefreehut").val()==''){
				var jf1h = jf;
			}else{
				var fr = $("#freeonefreehut").val();
				var jf1h = jf - fr;
			}
						
			if(jf1h > limitfreehut){
			}
			
			if(jf1h >= limitfreehut){
               	    $('#addBrg').attr('disabled', 'disabled');
					$('.frees').attr('disabled', 'disabled');
				}else{
					$('#addBrg').removeAttr('disabled');
					$('.frees').removeAttr('disabled');
            }
            
		}
		
		if($("#intid_jpenjualan").val()==8){
		//for lain-lain
			
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                
                var t = jumlah * harga;
			    $('#total_' + i).val(t);
                total += t;
             }
				
				$('#intjumlah2hidden').val(total);
						
				$('#intjumlah1').val('0');
				$('#intjumlah2').val('0');
				$('#intjumlah').val('0');
				$('#intpv').val('0');
				$('#komisi2').val('0');
				$('#komisi1').val('0');
				$('#komisi1hidden').val('0');
				$('#komisi2hidden').val('0');
	    //end lain-lain
		}	
		kali_sepuluh_baru(id);
    }


function kali_sepuluh_baru(id) {
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
			if (parseInt($('.free20_'+ i).val()) >=0 && parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.free20_'+ i).val()) != '')
				{
					_totalQuantityFree += parseInt($('.free20_'+ i).val());
				}
			}
			else if (parseInt($('.free_'+ i).val()) >=0 && parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseInt($('.free_'+ i).val());
				}
			}
		}
		
		//itung jumlah barang 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F1HUT = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.onefreehuts_'+ i).val()) >=0) {
				if (parseInt($('.onefreehuts_'+ i).val()) != '')
				{
					_totalQuantity1F1HUT += parseInt($('.onefreehuts_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F1HUT = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.freeonehut_'+ i).val()) >=0) {
				if (parseInt($('.freeonehut_'+ i).val()) != '')
				{
					_totalQuantityFree1F1HUT += parseInt($('.freeonehut_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F110 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.onefrees_'+ i).val()) >=0) {
				if (parseInt($('.onefrees_'+ i).val()) != '')
				{
					_totalQuantity1F110 += parseInt($('.onefrees_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F110 = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('.freeone_'+ i).val()) >=0) {
				if (parseInt($('.freeone_'+ i).val()) != '')
				{
					_totalQuantityFree1F110 += parseInt($('.freeone_'+ i).val());
				}
			}
		}
		
		//promo 1 free 1 hut/nett
		if ($('#intid_jpenjualan').attr('value') == 5)
		{
			if (_totalQuantity1F1HUT > _totalQuantityFree1F1HUT)
			{
				$('#tracker002').val("free");
				alert("Silakan pilih barang free");
			}
			else if (_totalQuantity1F1HUT == _totalQuantityFree1F1HUT && _totalQuantity1F1HUT != 0)
			{
				$('#tracker002').val("bayar");
				alert("Promo sukses");
			}
			else if (_totalQuantity1F1HUT < _totalQuantityFree1F1HUT)
			{
				$('#tracker002').val("bayar");
				alert("Barang free melebihi jumlah promo");
				$('.freeonehut_'+id).val('');
			}
		}
		
		//promo 1 free 1 10%
		if ($('#intid_jpenjualan').attr('value') == 6)
		{
			if (_totalQuantity1F110 > _totalQuantityFree1F110)
			{
				$('#tracker002').val("free");
				alert("Silakan pilih barang free");
			}
			else if (_totalQuantity1F110 == _totalQuantityFree1F110 && _totalQuantity1F110 != 0)
			{
				$('#tracker002').val("bayar");
				alert("Promo sukses");
			}
			else if (_totalQuantity1F110 < _totalQuantityFree1F110)
			{
				$('#tracker002').val("bayar");
				alert("Barang free melebihi jumlah promo");
				$('.freeone_'+id).val('');
			}
		}
		
		if ($('#tracker004').val() > _totalQuantityFree) {
			alert("Anda masih boleh memilih barang free");
			$('#tracker002').val("free");
		} else if ($('#tracker004').val() == _totalQuantityFree && _totalQuantityFree != 0) {
			alert("Silakan pilih promo berikutnya");
			$('#tracker002').val("bayar");
		} else if ($('#tracker004').val() < _totalQuantityFree) {
			alert("Jumlah barang free melebihi quota");
			$('.free20_'+ id).val('');
			$('.free_'+ id).val('');
		}
		
		//jalankan auto complete handler
		autoComp();
		
		return false;
	}
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
	   
function checked_box(){

	temporary_jumlah = 0;
	increment = $("#increment").val();
	
	for(var z=0;z<=increment;z++){
			
			if(!isNaN($('#nonota_'+z).val()) && $('#nonota_'+z).attr("checked") == true){
				
					temporary_jumlah += parseInt($('#inttotal_omset_'+z).val());
				}
			}
	
	//alert(temporary_jumlah);
	
	$("#totalomsetabo").html("Rp. "+temporary_jumlah);
	
	$("#id1").val("");
	
	//kondisi wilayah
	var minimal = 0;
	if($('#id_wilayah').val() == 1){ //di pulau jawa
		
		minimal = 900000;
		}
		else{ //di luar pulau jawa
			
			minimal = 1000000;
			}
	console.log($('#id_wilayah').val());	
	if(parseInt(temporary_jumlah) >= parseInt(minimal)){//standart minimal melakukan penjualan
		
		$("#id1").removeAttr("readonly");
		$("#id1").removeAttr("disabled");
		
		 $("#form_submenu").removeAttr("style","display:none");
		 $("#chkV").attr("checked",true);
		 $("#chkV").attr("disabled",true);
		 kali();	
		}
		else{
			
			$("#id1").attr("readonly",true);
			$("#id1").attr("disabled",true);
			
			$("#form_submenu").attr("style","display:none");
			$("#chkV").removeAttr("checked");
			$("#chkV").removeAttr("disabled");
			kali();	
			}
			
	}
function disabled_checked_box(){
	
	increment = $("#increment").val();
	
	for(var z=0;z<=increment;z++){
		
		$('#nonota_'+z).attr("readonly",true);
		$('#nonota_'+z).attr("disabled",true);
		}
	}
</script>

