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
		function promo50(ID,num,id_cabang,track){
			$("#metal_1").attr("disabled","disabled");
			$("#metal_2").attr("disabled","disabled");
			$("#metal_3").attr("disabled","disabled");
			$("#metal_4").attr("disabled","disabled");
			$("#metal_5").attr("disabled","disabled");
			$("#metal_6").attr("disabled","disabled");
			if(track == "metal_1") {$("#track1").val(1);}
			if(track == "metal_2") {$("#track2").val(1);}
			if(track == "metal_3") {$("#track3").val(1);}
			if(track == "metal_4") {$("#track4").val(1);}
			if(track == "metal_5") {$("#track5").val(1);}
			if(track == "metal_6") {$("#track6").val(1);}
			if(ID.checked){
				$("#result1").empty();
				$("#result1").append(
                        	"<input type='text' id='harga_barang' name='harga_barang' value='' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='' size='15' /><input type='hidden' id='pv' name='pv' value='' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='' size='15' />"
                   		);
				var temp,test;
				$(function(){								   
					$(".metal").live('click',function(e){
						$.ajax({
							url: "<?php echo base_url(); ?>penjualan/lookupNamaBarang_2",
							type: 'POST',
							dataType: 'json',
							data: {
								id_barang: num
							},
							success:function(data){
								$('.id1').val(data.value);
								$('#harga_barang').val(data.value1 / 2);
								$('#id_barang').val(data.id);
								$('#id_harga').val(data.value7);
							}
						});		
					});										
				});
						
			}
		}
            //for unit
            $(document).ready( function() {
				
				////30maret2013//////////										
				$("#tidak_dimunculkan").hide();
				$("#tidak_dimunculkan1").hide();
				$("#tidak_dimunculkan2").hide();
				$("#tidak_dimunculkan3").hide();									
				//$("#paketpromo10").hide();
				//$("#tradein").hide();
				//$("#free1hut").hide();
				//$("#free110").hide();
				
				////////end//////////////////
				/////line ikhlas //////////////						
				$("#form_tujukin").hide();
				/////////////////end///////////////
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
			$("#track1").val(0);
			$("#track2").val(0);
			$("#track3").val(0);
			$("#track4").val(0);
			$("#track5").val(0);
			$("#track6").val(0);
			$("#metal_1").attr("disabled","disabled");
			$("#metal_2").attr("disabled","disabled");
			$("#metal_3").attr("disabled","disabled");
			$("#metal_4").attr("disabled","disabled");
			$("#metal_5").attr("disabled","disabled");
			$("#metal_6").attr("disabled","disabled");
                        $("#result001").empty();
                        $("#result001").append(
                        	"<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/></td>"
			);
			if(ui.item.value4 == 0) {$("#metal_1").removeAttr("disabled");} else {$("#track1").val(1);}
			if(ui.item.value5 == 0) {$("#metal_2").removeAttr("disabled");} else {$("#track2").val(1);}
			if(ui.item.value6 == 0) {$("#metal_3").removeAttr("disabled");} else {$("#track3").val(1);}
			if(ui.item.value7 == 0) {$("#metal_4").removeAttr("disabled");} else {$("#track4").val(1);}
			if(ui.item.value8 == 0) {$("#metal_5").removeAttr("disabled");} else {$("#track5").val(1);}
			if(ui.item.value9 == 0) {$("#metal_6").removeAttr("disabled");} else {$("#track6").val(1);}
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
                autoCompPromo10();
                hut();
                tradein();
                satufreesatu();

            });

            //for barang

            function autoComp(){
				//line ikhlas 30032013
                if($("#chkBox20").attr('checked') == false){
                   // var ur = "<?php //echo base_url(); ?>penjualan/lookupBarang";
                
				}else if ($("#chkBox20").attr('checked') == true) {

                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGubrak";
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


                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFreegubrak",
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
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

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


            }

//////////////line ikhlas////////////////////////////////
function pilih_barang(){
	if($("#intid_jpenjualan").val() == 13){
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
			$("#chkV").attr("checked",false);
			$("#chkV").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
		$("#form_tujukin").show();
		}else{
			$("#form_tujukin").hide();
			}
	}
////////////////////////////////////////////////////////

        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">penjualan</h2>
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
                                    <td>&nbsp;<select name="intid_jpenjualan" id="intid_jpenjualan" onchange="pilih_barang()">
                                            <option value="">-- Pilih --</option>
                                            <?php
											//line ikhlas firlana 30032013
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
												if($strnama_jpenjualan[$i] == "REGULER" or $strnama_jpenjualan[$i] == "CHALL HUT" or $strnama_jpenjualan[$i] == "CHALLENGE" or $strnama_jpenjualan[$i] == "NETTO" ){
                                                echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
												}
											}
											////end///
                                            ?>
                                        </select>         </td>
                                    <td colspan="3">Paket Gubrak</td>
                                    <td>
                                        <input type="checkbox" name="chkBox20" id="chkBox20" disabled="disabled"/>
                                        x
                                        <input type="text" name="txtpromo20" id="txtpromo20"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg20">
                                        <input type="checkbox" name="chkV20" id="chkV20" disabled="disabled"/>
                                        Voucher
                                        <input type="hidden" name="txtvoucher" id="txtvoucher"  size="4" /></td>
                                </tr>
                                <tr id="tidak_dimunculkan">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" id="paketpromo10">Paket Promo 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBox10" id="chkBox10" disabled="disabled"/>
                                        x
                                        <input type="text" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg10">
                                        <input type="checkbox" name="chkV10" id="chkV10" disabled="disabled"/>
                                        Voucher</td>
                                </tr>
                                <tr id="tidak_dimunculkan1">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" id="tradein">Trade In</td>
                                    <td><input type="checkbox" name="chkBoxTrade" id="chkBoxTrade" disabled="disabled"/>
                                        &nbsp;&nbsp;&nbsp;<select name="komisitrade" id="komisitrade" disabled="disabled">
                                            <option value="0">0%</option>
                                            <option value="10">10%</option>
                                            <option value="20">20%</option>
                                            <option value="30">30%</option>
                                            <option value="40">40%</option>
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70">70%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                        </select></td>
                                </tr>
                                <tr id="tidak_dimunculkan2">
                                    <td>&nbsp;</td>
<!-- //999 -->
                                    <td><div id="form_tujukin">
                                    	<ul style="list-style-type:none">
                                        	<li><input type="hidden" id="track1" value="0" /><input type="checkbox" class="metal" id="metal_1" name="promo_metal[1]" disabled="disabled" onclick="promo50(this,967,<?php echo $id_cabang; ?>,this.id)" />STEAMER</li>
                                        	<li><input type="hidden" id="track2" value="0" /><input type="checkbox" class="metal" id="metal_2" name="promo_metal[2]" disabled="disabled" onclick="promo50(this,961,<?php echo $id_cabang; ?>,this.id)" />EMC</li>
                                        	<li><input type="hidden" id="track3" value="0" /><input type="checkbox" class="metal" id="metal_3" name="promo_metal[3]" disabled="disabled" onclick="promo50(this,966,<?php echo $id_cabang; ?>,this.id)" />CHOOPER + BLENDER</li>
                                        	<li><input type="hidden" id="track4" value="0" /><input type="checkbox" class="metal" id="metal_4" name="promo_metal[4]" disabled="disabled" onclick="promo50(this,971,<?php echo $id_cabang; ?>,this.id)" />PRESTO 5LT</li>
                                        	<li><input type="hidden" id="track5" value="0" /><input type="checkbox" class="metal" id="metal_5" name="promo_metal[5]" disabled="disabled" onclick="promo50(this,970,<?php echo $id_cabang; ?>,this.id)" />PRESTO 7LT</li>
                                        	<li><input type="hidden" id="track6" value="0" /><input type="checkbox" class="metal" id="metal_6" name="promo_metal[6]" disabled="disabled" onclick="promo50(this,969,<?php echo $id_cabang; ?>,this.id)" />PRESTO 7 IN 1</li>
                                        </ul>
                                    </div></td>

                                    <td colspan="3" id="free1hut">1 Free 1 HUT</td>
                                    <td>
                                        <input type="checkbox" name="chkBoxFreeHut" id="chkBoxFreeHut" disabled="disabled"/>
                                        x
                                        <input type="text" name="txtfreehut" id="txtfreehut"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrgfreehut">                                    </td>
                                </tr>
                                <tr id="tidak_dimunculkan3">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" id="free110">1 Free 1 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBoxFree" id="chkBoxFree" disabled="disabled"/>
                                        x
                                        <input type="text" name="txtfree" id="txtfree"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>        </td>
                                    	<input type="hidden" id="jumlahbrgfree">
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Voucher</td>
                                    <td>
                                        <input type="checkbox" name="chkV" id="chkV" disabled="disabled"/></td>
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
                                        </td>
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
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20%</td>
                                    <td>:</td>
                                    <td>
                                        Rp.<input type="text" name="komisi2" id="komisi2" readonly="readonly"/>
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
                                        Rp.<input type="text" name="komisi1" id="komisi1" readonly="readonly"/>
                                        <input type="hidden" name="komisi1hidden" id="komisi1hidden"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly"/>
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
	function lain2()
	{
		if($('#intid_jpenjualan').val() == 8)
		{
			$('#intjumlah').val('0');
			$('#intjumlah2hidden').val('0');
			$('#intjumlahhidden').val('0');
		}
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
    var total001=0;
    $('#addBrg').bind('click', function(e){

//001
	if($("#track1").val() == 0) {$("#metal_1").removeAttr("disabled");}
	if($("#track2").val() == 0) {$("#metal_2").removeAttr("disabled");}
	if($("#track3").val() == 0) {$("#metal_3").removeAttr("disabled");}
	if($("#track4").val() == 0) {$("#metal_4").removeAttr("disabled");}
	if($("#track5").val() == 0) {$("#metal_5").removeAttr("disabled");}
	if($("#track6").val() == 0) {$("#metal_6").removeAttr("disabled");}

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
                        alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
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
						alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
		
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
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
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

    }


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
                            alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
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
				$('.id1').attr('disabled', 'disabled');
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
				if ($('#id_wilayah').val() == 1){
					sall=s-50000;
					$('#intvoucher').val(50000);
				} else {
					sall=s-60000;
					$('#intvoucher').val(60000);
				}
				
				$('#txtvoucher').val(1);
			} else {
				sall=s;
			}

		if($('#chkV').attr('checked') == true && sall < 0)
		{
			sall = 0;
		}
//line ikhlas firlana 30032013
            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);
//sebelumnya
//            $('#intjumlah2').val(formatAsDollars(sall));
//            $('#intjumlah2hidden').val(sall);

            var total = parseInt($('#intjumlah2hidden').val());

	if($('#intid_jpenjualan').val() != 7) {
//line ikhlas firlana 30032013
            var disc = 10;
            var komisi10 = (total * disc) / 100;
//sebelumnya
//            var disc = 20;
//           var komisi20 = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi10 < 0)
		{
			komisi10 = 0;
		}

		
            $('#komisi1').val(formatAsDollars(komisi10));
            $('#komisi1hidden').val(komisi10);
//sebelumnya
//    $('#komisi2').val(formatAsDollars(komisi20));
//            $('#komisi2hidden').val(komisi20);

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

        }else
            if($("#chkBoxFreeHut").attr('checked') == true){
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
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			if(jfh >= limitfreehut){
               	$('#addBrg').removeAttr('disabled');
				$('.id1').attr('disabled', 'disabled');
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
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			if(jf >= limitfree){
				$('#addBrg').removeAttr('disabled');
				$('.id1').attr('disabled', 'disabled');
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
            $('#intpv').val(formatNumber(pivi));
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
	    focus:
		function(event,ui) {
		var q = $(this).val();
		$(this).val() = q;
	    },
            select:
                function(event, ui) {
                $("#result1").append(
                "<input type='text' id='id_barang' name='id_barang' value='" + ui.item.value1 + "' size='15' /><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });

    }


    //check the checkbox
    $("#chkBoxTrade").click(function(){
        tradein();
	$("#chkV").attr("checked",false);
        if($("#chkBoxTrade").attr('checked') == true){
            $("#komisitrade").attr("disabled","");
        }else if($("#chkBoxTrade").attr('checked') == false){
            document.frmjual.komisitrade.disabled = true;
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
        }
    });

//001
$("#metal_1").click(function(){
	$("#metal_1").attr("disabled","disabled");
});
$("#metal_2").click(function(){
	$("#metal_2").attr("disabled","disabled");
});
$("#metal_3").click(function(){
	$("#metal_3").attr("disabled","disabled");
});
$("#metal_4").click(function(){
	$("#metal_4").attr("disabled","disabled");
});
$("#metal_5").click(function(){
	$("#metal_5").attr("disabled","disabled");
});
$("#metal_6").click(function(){
	$("#metal_6").attr("disabled","disabled");
});


	$("#chkBox20").click(function(){
      	autoComp();
		$("#chkV").attr("checked",false);
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
    });

     $("#txtpromo20").keyup(function(){

            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
     });

	$("#chkBox10").click(function(){
      autoCompPromo10();
	$("#chkV").attr("checked",false);

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
    });
		
	 
     $("#txtpromo10").keyup(function(){


            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
			d = $("#txtp10").val();
			$("#txtps10").val(d);


    });

    $("#chkBoxFreeHut").click(function(){
        hut();
	$("#chkV").attr("checked",false);
	$("#txtfreehut").val('');
        if($("#chkBoxFreeHut").attr('checked') == true){

            count = document.getElementsByName("hitfreehut").length;
            $("#txtfreehut").attr("disabled","");
        }else{
			$("#txtfreehut").attr("disabled","disabled");
            $(".frees").attr("disabled","disabled");
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
			$('#jumlahbrgfreehut').val(' ');
        }
    });

     $("#txtfreehut").keyup(function(){

        var jmlbrg = parseInt($('#jumlahbrgfreehut').val());
        var limitfreehut = parseInt($("#txtfreehut").val());
		$('#jumlahbrgfreehut').val(limitfreehut);
        $('#addBrg').removeAttr('disabled');
        $('.id1').removeAttr('disabled');
		var h = $("#onefreehut").val();
		$("#onesfreehut").val(h);

    });

    $("#chkBoxFree").click(function(){
        satufreesatu();
	$("#chkV").attr("checked",false);
	$("#txtfree").val('');
        if($("#chkBoxFree").attr('checked') == true){
			count = document.getElementsByName("hitfree").length;
            $("#txtfree").attr("disabled","");
        } else if($("#chkBoxFree").attr('checked') == false){
			//$('#onefree').val('');
            $(".frees").attr("disabled","disabled");
            $("#txtfree").attr("disabled","disabled");
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
			var g = $('#jumlahbrgfree').val();
			$("#freeonefree").val(g);
			$('#jumlahbrgfree').val(' ');
			}

    });
     $("#txtfree").keyup(function(){

        var jmlbrg = parseInt($('#jumlahbrgfree').val());
        var limitfree = parseInt($("#txtfree").val());
		$('#jumlahbrgfree').val(limitfree);
        $('#addBrg').removeAttr('disabled');
        $('.id1').removeAttr('disabled');
		var f = $("#onefree").val();
		$("#onesfree").val(f);
		
    });
    $("#chkV").click(function(){
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
	    focus:
		function(event,ui) {
		var q = $(this).val();
		$(this).val() = q;
	    },
            select:
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

    }

    function tradein(){

         var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
         $(".id1").autocomplete({
            minLength: 1,
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

    }

    function satufreesatu(){
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";

        $(".id1").autocomplete({
            minLength: 1,
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
	    focus:
		function(event,ui) {
		var q = $(this).val();
		$(this).val() = q;
	    },
            select:
                function(event, ui) {
                $("#result2").html(
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='intid_harga' name='intid_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });


    }
	//netto
	function netto(){
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";

        $(".id1").autocomplete({
            minLength: 1,
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });
    }
	//for lain-lain
	function lain(){
		
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";

        $(".id1").autocomplete({
            minLength: 1,
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
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
    }

    $('#intid_jpenjualan').change(function()
    {
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
	$("#chkV").attr("checked",false);
        if ($(this).attr('value')== 1)
        {
            var title = "Nota Penjualan Reguler";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","");
			$("#chkBox10").attr("disabled","");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$("#chkV").attr("disabled","");
        } else  if ($(this).attr('value')== 2)
        {
            var title = "Nota Penjualan Chall Hut";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","");
			$("#chkBox10").attr("disabled","");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$("#chkV").attr("disabled","");
        } else  if ($(this).attr('value')== 3)
        {
            var title = "Nota Penjualan Challenge";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","");
			$("#chkBox10").attr("disabled","");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$("#chkV").attr("disabled","");
        } else  if ($(this).attr('value')== 4)
        {
            var title = "Nota Penjualan Trade In";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","");
        } else  if ($(this).attr('value')== 5)
        {
            var title = "Nota Penjualan 1 Free 1 Hut";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","");
			$("#chkBoxFree").attr("disabled","disabled");
        } else  if ($(this).attr('value')== 6)
        {
            var title = "Nota Penjualan 1 Free 1 10%";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","");
        } else  if ($(this).attr('value')== 7)
        {
            var title = "Nota Penjualan Netto";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","");
			$("#chkBox10").attr("disabled","");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			netto();
        }
		else  if ($(this).attr('value')== 8)
        {
            var title = "Nota Penjualan Lain-lain";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$('.frees').removeAttr('disabled');
			lain();
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

