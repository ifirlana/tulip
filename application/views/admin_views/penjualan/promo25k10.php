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
		window.is_launch = <?php echo $is_launch;?>;
		
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
								if ($("#smart").attr('checked') == true)
								{
									$('#harga_barang').val(data.value1 * 0.6);
								} else {
									$('#harga_barang').val(data.value1 / 2);
								}
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
                        	"<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/><input type='hidden' size='2' id='pengejaranChall' value='"+ui.item.challhut+"' readonly></td>"
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

            });

            

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
                <div>	<h2 class="title">Penjualan Dis 25% Komisi 10% </h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota" method="post" name="frmjual" id="frmjual">
						<input type="hidden" name="halaman"  value="bin25k10">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    
                                    <td >&nbsp;<?php echo $cabang; ?>
                                    <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?> id="id_cabang"">         </td>
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
                                    <td>&nbsp;<input type="hidden" name="intid_jpenjualan" value="" id="post_intid_jpenjualan"/><select name="intid_jpenjualan" id="intid_jpenjualan">
                                            <option value="">-- Pilih --</option>
                                            <?php
											//KONDISI
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
											// 1 free 1 net di akses semua
													echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
												}
                                            ?>
                                        </select>         </td>
                                    <td colspan="3" style="display:none;">Paket Promo 20%</td>
                                    <td style="display:none;">
                                        <input type="checkbox" name="chkBox20" id="chkBox20" disabled="disabled"/>
                                        <input type="hidden" name="txtpromo20" id="txtpromo20"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg20">
                                        <input type="hidden" name="chkV20" id="chkV20" disabled="disabled"/>
										<?php //echo"<input type="checkbox" name="chkV20" id="chkV20" disabled="disabled"/> Voucher;?>
                                        
                                        <input type="hidden" name="txtvoucher" id="txtvoucher"  size="4" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" style="display:none;">Paket Promo 10%</td>
                                    <td style="display:none;">
                                        <input type="checkbox" name="chkBox10" id="chkBox10" disabled="disabled"/>
                                        <input type="hidden" name="txtpromo10" id="txtpromo10" size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrg10">
                                        <input type="hidden" name="chkV10" id="chkV10" disabled="disabled"/>
                                       <?php //echo"<input type="checkbox" name="chkV10" id="chkV10" disabled="disabled"/> Voucher;?>
                                         </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" style="display:none;">Trade In</td>
                                    <td style="display:none;"><input type="checkbox" name="chkBoxTrade" id="chkBoxTrade" disabled="disabled" style="display:none;"/>
                                        &nbsp;&nbsp;&nbsp;<select name="komisitradetext" id="komisitrade" disabled="disabled">
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
                                        </select><input type='hidden' name='komisitrade' class='komisitrade' value='0' size='2' readonly /></td>
                                </tr>
                                <tr>
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
                                        	<li><input type="checkbox" id="smart" name="smart" />Smart Spending</li>
					</ul>
                                    </div></td>

                                    <td colspan="3" style="display:none;">1 Free 1 HUT</td>
                                    <td style="display:none;">
                                        <input type="checkbox" name="chkBoxFreeHut" id="chkBoxFreeHut" disabled="disabled"/>
                                        <input type="hidden" name="txtfreehut" id="txtfreehut"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>
                                        <input type="hidden" id="jumlahbrgfreehut">                                    </td>
                                </tr>
                                <tr style="display:none;">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">1 Free 1 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBoxFree" id="chkBoxFree" disabled="disabled"/>
                                        <input type="hidden" name="txtfree" id="txtfree"  size="4" disabled="disabled" onkeypress="return isNumberKey(event)"/>        </td>
                                    	<input type="hidden" id="jumlahbrgfree">
                                </tr>
								<?php
								/*
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Voucher</td>
                                    <td>
                                        <input type="checkbox" name="chkV" id="chkV" disabled="disabled"/></td>
                                    <input type="hidden" id="jumlahbrgfree"> 
                              </tr>
							  */
							  ?>
								<tr style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Power Buy Mandiri</td>
									<td ><input type="checkbox" name="chkSmart" id="chkSmart" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Free Lain-lain</td>
									<td ><input type="checkbox" name="chklainlain" id="chklainlain" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain2" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 50%</td>
									<td ><input type="checkbox" name="chktulip50" id="chktulip50" />
                                    </td>
                                </tr>
								
                              <tr id="showattrlainlain3" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 50% komisi 10%</td>
									<td ><input type="checkbox" name="chktulip50_10" id="chktulip50_10"  <?php if($id_cabang == 28 or $id_cabang == 1){?><?php }else{?>disabled<?php }?>/>
                                    </td>
                                </tr>
								<tr id="showattrlainlain4" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 20% komisi 20%</td>
									<td >
									<input type="checkbox" name="chktulip20_20" id="chktulip20_20" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain5" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 30% komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip30_10" id="chktulip30_10" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain5" style="display:none;" >
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 60% net</td>
									<td >
										<input type="checkbox" name="chktulip60_net" id="chktulip60_net" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain5" >
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 25% Komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip25_10" id="chktulip25_10" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain6" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Metal 20% komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip20_10" id="chktulip20_10" />
                                    </td>
                                </tr>
								<tr id="showattrlainlain7" style="display:none;">
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Special Bonus</td>
									<td >
										<input type="checkbox" name="chktulip20_sb" id="chktulip20_sb" />
                                    </td>
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
														<input type="hidden" id="tracker001" value="0" />
														<input type="hidden" id="tracker002" value="bayar" />
														<input type="hidden" id="tracker004" value="" />
                                                    </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang -&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" id="brgsuka" size="50" /></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div></td>
                                            </tr>
                                            <tr>
                                                <td style="display:none;">&nbsp;Pilih Barang Free -&gt;</td>
                                                <td style="display:none;">&nbsp;&nbsp;<input type="text" name="free" class="frees" size="50" disabled  /></td>
                                                <td style="display:none;">&nbsp;<div id="result2"></div></td>
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
								<?php $matuang = "Rp.";
										if($id_wilayah == 4){
										$matuang ="RM";
										}
									?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Omset 10%<br />Omset 20%<br />Total Omset</td>
                                    <td>:<br />:<br />:</td>
                                    <td>
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="jml10" id="intjumlah1" readonly="readonly"/><br />
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="jml20" id="intjumlah2" readonly="readonly"/><br />
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="jumlah" id="intjumlah" readonly="readonly"/>

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
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="komisi2" id="komisi2" readonly="readonly"/>
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
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="komisi1" id="komisi1" readonly="readonly"/>
                                        <input type="hidden" name="komisi1hidden" id="komisi1hidden"/>                                    </td>
                                </tr>
								<tr id="charge" style="display:none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Charge 3%</td>
                                    <td>:</td>
                                    <td>
                                        <?php echo $matuang;?><!-- Rp. --><input type="text" name="charge3" id="charge3" readonly="readonly" />
									</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="totalbayar" id="totalbayar" readonly="readonly"/>
                                        <input type="hidden" name="totalbayar1" id="totalbayar1" />
                                        <input type="hidden" name="totalbayar2" id="totalbayar2" />         </td>
                                </tr>
                                <tr id="cash">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">Cash</span></td>
                                  <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr id="debit">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr id="kkredit">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)" /></td>
                                </tr>
                                <tr id="sisa">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style1">&nbsp;Sisa</span></td>
                                  <td>&nbsp;:</td>
                                    <td><?php echo $matuang;?><!-- Rp. --><input type="text" name="intsisa" id="intsisa" onkeypress="return isNumberKey(event)" />
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
            var a = parseFloat($('#intcash').val());
        }
        if($('#intkkredit').val() == ""){
            var b = 0;
        }else{
            var b = parseFloat($('#intkkredit').val());
        }
        if($('#intdebit').val() == ""){
            var c = 0;
        }else{
            var c = parseFloat($('#intdebit').val());
        }
        var d = parseFloat($('#totalbayar1').val());
        var t = a + b + c;
        var sisa = d - t;
		$('#intsisa').val(formatAsDollars(-sisa));
        $('#intsisahidden').val(sisa);
	$("input[type=submit]").removeAttr("disabled");
		/* sisa_baru(); */
    }
	var status_free = 0;

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

	$('#intid_jpenjualan').attr("disabled","disabled");
	//keterangan
	//menyimpan nilai tradeIn ke input type text karena jika didisabled maka value yang akan dikirim akan tidak termasukan
	$('.komisitrade').val($('#komisitrade').val());
	$('#komisitrade').attr("disabled",true);
/* 	if ($("#status_free").val() == 1) {
		//$("#tracker002").val("free") ;
		status_free = $("#status_free").val();
		console.log(status_free);
	}  else{
	console.log("tidak ada Free");
	status_free = $("#status_free").val();
	} */
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
            if($("#chkBox20").attr('checked') == true || $("#chktulip20_20").attr("checked") == true || $("#chktulip20_sb").attr("checked") == true){
                out += '<input type="hidden"  id="hit20" name="hit20[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            else if($("#chkBox10").attr('checked') == true || $("#chktulip50_10").attr("checked") == true || $("#chktulip25_10").attr("checked") == true || $("#chktulip30_10").attr("checked") == true||$("#chktulip20_10").attr("checked") == true){ // else if($("#chkBox10").attr('checked') == true){
                out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" class="status_free_'+idx+'" value="'+status_free+'"><input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
            }

            else if($("#chkBoxTrade").attr('checked') == true){
                out += '<input type="hidden" id="hittrade" name="hittrade[]" value="'+idx+'">';
                out += '<input id="'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            }

            else if($("#chkBoxFreeHut").attr('checked') == true){
                out += '<input id="'+idx+'" class="onefreehuts_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hitfreehut" name="hitfreehut[]" value="'+idx+'">';
            }
			/*untuk cek status free lain lain*/
			/* else if($("#chklainlain").attr('checked') == true){
                out += '<input id="'+idx+'" class="freelainlain_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hitfreelainlain" name="hitfreelainlain[]" value="'+idx+'">';
            } */

            else if($("#chkBoxFree").attr('checked') == true){
                out += '<input id="'+idx+'" class="onefrees_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                out += '<input type="hidden" id="hitfree" name="hitfree[]" value="'+idx+'">';
            }else{
                out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id); return lain2();" onkeypress="return isNumberKey(event)" />&nbsp;';
            }
/* ikhlas5010 */
			if($("#chktulip50_10").attr("checked") == true){
				
				harga = harga / 2;
				pv	=	parseFloat(pv) / 2;
				autoComp();
				kali();
				}
				/* fahmibaru2030 */
				if($("#chktulip30_10").attr("checked") == true){
				
				// harga = harga * 0.7;
				harga =  Math.ceil(harga * 0.7);
				pv	=	(parseFloat(pv) * 0.7).toFixed(2);
				autoComp();
				kali();
				}
				if($("#chktulip60_net").attr("checked") == true){
				
				// harga = harga * 0.7; 
				harga = /*  Math.ceil */(parseFloat(harga) * 0.4).toFixed(2);
/* 				pv	=	(parseFloat(pv) * 0.4).toFixed(2); */
				autoComp();
				kali();
				}
				if($("#chktulip25_10").attr("checked") == true){
				
				// harga = harga * 0.7; 
				harga = /*  Math.ceil */(parseFloat(harga) * 0.75).toFixed(2);
/* 				pv	=	(parseFloat(pv) * 0.4).toFixed(2); */
				autoComp();
				kali();
				}
				if($("#chktulip20_20").attr("checked") == true){
				
				harga = harga * 0.8;
				pv	=	(parseFloat(pv) * 0.8).toFixed(2);
				autoComp();
				kali();
				}
				if($("#chktulip20_10").attr("checked") == true){
				
				// harga = harga * 0.8;
				harga =  Math.ceil(harga * 0.8);
				pv	=	(parseFloat(pv) * 0.8).toFixed(2);
				autoComp();
				kali();
				}
			
            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
            
			if($("#intid_jpenjualan").val() == 7 || $("#intid_jpenjualan").val() == 19){
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="0" readonly>';
            }else{
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
            }
            out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
            out += '<input id="barang_'+idx+'_intid_id" name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
			
					//001
					out += '<input id="tracker003_'+idx+'" name="tracker003_'+idx+'" type="hidden" >';
					out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
					
			out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
			
			//001
			ajaxgila(idx);
			
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
/* 	  if ($("#status_free").val() == 1) {
		$("#tracker002").val("free") ;
		status_free = $("#status_free").val();
		console.log(status_free);
	}  else{
	console.log("tidak ada Free");
	status_free = $("#status_free").val();
	} */		
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
				if($("#chkBox10").attr('checked') == true || $("#chktulip50_10").attr("checked") == true||$("#chktulip30_10").attr("checked") == true||$("#chktulip20_10").attr("checked") == true){
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
				$('.id1').val('');
				$('#pv').val('');
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
            var cs2 = parseFloat($('#hitfree10').val());
			var textpromo10 = parseFloat($("#txtpromo10").val());
            
			for(var i=parseFloat(cs2); i<= parseFloat(id);i++){
                
				var jumlahfree = parseFloat($('.free_'+ i).val());
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
            var textpromo20 = parseFloat($("#txtpromo20").val());
			
			var id_b = id + 2;
            for(var i=cs2+1 ; i<= parseFloat(id);i++){
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
			var cs2 = parseFloat($('#hitonefree').val());
			var txtfree = parseFloat($("#txtfree").val());
		    
            for(var i=parseFloat(id); i<= parseFloat(id);i++){
               		//alert(i);
					var jumlahfree = parseFloat($('.freeone_'+ i).val());
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
				var cs3 = parseFloat($('#hitonefreehut').val());
				var limitfreehut = parseFloat($('#txtfreehut').val());
                for(var i=parseFloat(id); i<= parseFloat(id);i++){

                    var jumlahfree = parseFloat($('.freeonehut_'+ i).val());
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
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                
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
        var limit10 = parseFloat($('#txtpromo10').val());
        var limitfreehut = $('#txtfreehut').val();
        var limitfree = $('#txtfree').val();
        $("#del"+id).remove();
		$("#intid_jpenjualan").attr('readonly','readonly');
        if($("#chkBox20").attr('checked') == true || $("#chktulip20_20").attr('checked') == true || $("#chktulip20_sb").attr('checked') == true){

            var cs = document.getElementsByName("hit20[]").length;
			if(cs > 1){
				var sid = cs + 1;
			}else{
				var sid = cs;
			}
            var lim20 = limit20;


             for(var i=sid; i<= parseFloat(id);i++){

                var jumlah = parseFloat($('.duapuluh_'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
			if(jumlah > parseFloat($('#txtpromo20').val())){
                            break;
                        }

                }
            }

			for(var i=1; i<= parseFloat(id);i++){

                var jumlah = parseFloat($('.duapuluh_'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;


                }
            }

            $('#jumlahbrg20').val(jml);

            var j20 = parseFloat($('#jumlahbrg20').val());


            if(j20 >= lim20){
                $('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
            }

            if($('#komisihide').val() != ""){
                var komhide = parseFloat($('#komisihide').val());
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

            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);

            var total = parseFloat($('#intjumlah2hidden').val());

	if($('#intid_jpenjualan').val() != 7) {

            var disc = 20;
            var komisi20 = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi20 < 0)
		{
			komisi20 = 0;
		}

            $('#komisi2').val(formatAsDollars(komisi20));
            $('#komisi2hidden').val(komisi20);

	}
//sasaran fahmi
        }else if($("#chkBox20").attr('checked') == true || $("#chktulip20_20").attr('checked') == true || $("#chktulip20_sb").attr('checked') == true){

            var cs = document.getElementsByName("hit20[]").length;
			if(cs > 1){
				var sid = cs + 1;
			}else{
				var sid = cs;
			}
            var lim20 = limit20;


             for(var i=sid; i<= parseFloat(id);i++){

                var jumlah = parseFloat($('.duapuluh_'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
			if(jumlah > parseFloat($('#txtpromo20').val())){
                            break;
                        }

                }
            }

			for(var i=1; i<= parseFloat(id);i++){

                var jumlah = parseFloat($('.duapuluh_'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;


                }
            }

            $('#jumlahbrg20').val(jml);

            var j20 = parseFloat($('#jumlahbrg20').val());


            if(j20 >= lim20){
                $('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
            }

            if($('#komisihide').val() != ""){
                var komhide = parseFloat($('#komisihide').val());
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

            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);

            var total = parseFloat($('#intjumlah2hidden').val());

	if($('#intid_jpenjualan').val() != 7) {

            var disc = 20;
            var komisi20 = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi20 < 0)
		{
			komisi20 = 0;
		}

            $('#komisi2').val(formatAsDollars(komisi20));
            $('#komisi2hidden').val(komisi20);

	}
//sasaran fahmi
        }else if($("#chkBox10").attr('checked') == true || $("#chktulip30_10").attr('checked') == true || $("#chktulip20_10").attr('checked') == true){

			var csfree = parseFloat($('#hit10').val());
			var tt = limit10 * 2;
			

	    	var ju=0;
            for(var i=parseFloat(csfree); i<= parseFloat(id);i++){
                var jumlah = parseFloat($('.sepuluh_'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
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
            var total = parseFloat($('#intjumlah1hidden').val());

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
                for(var i=cs3; i<= parseFloat(id);i++){

                    var jumlah = parseFloat($('.onefreehuts_'+ i).val());
                   	var harga = parseFloat($('#harga_' + i).val());
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
                for(var i=cs3; i<= parseFloat(id);i++){
                    
                    var jumlah = parseFloat($('.onefrees_'+ i).val());
                    var harga = parseFloat($('#harga_' + i).val());
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

            for(var i=cs; i<= parseFloat(id);i++){

                var jumlah = parseFloat($('#'+ i).val());
                var harga = parseFloat($('#harga_' + i).val());
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


            var komtrade = parseFloat($('#komisitrade').val());
            var totkom = (total * komtrade) /100;


			//pv dihitung dari pv barang bukan dari komisi tapi dari barang yang memiliki pv
			$('#komisi1hidden').val(totkom);
            var jumhide = parseFloat($('#intjumlahhidden').val());
            var totOm = total - parseFloat($('#komisi1hidden').val());
            var totOm = total - parseFloat($('#komisi1hidden').val());
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

			$('#intjumlah').val((jumtothide));
            $('#intjumlahtradehidden').val(jumtothide);

				$('#intpv_trade').val(jumtothide/100000);
				//$('#intpv_trade').val();
			

		} else if($("#intid_jpenjualan").val()==7 ){
		//for netto
			var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
				console.log('perhitungan dimulai');
                    var t = jumlah * harga;
					console.log(t);
                    $('#total_' + i).val(t);
                    total += t;
					console.log($('#total_' + i).val());
                }
            }
			console.log("Ini berdasarkan pemilihan jenis penjualan");
			$('#intjumlah1').val('0');
				$('#intjumlah2').val('0');
				$('#intjumlah').val('0');
				$('#intpv').val('0');
				$('#komisi2').val('0');
				$('#komisi1').val('0');
				$('#komisi1hidden').val('0');
				$('#komisi2hidden').val('0');
                /* $('#intjumlah2hidden').val(total); */

        //end netto
		} else if($("#intid_jpenjualan").val()==19 ){
		//for netto
			var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
				console.log('perhitungan dimulai');
                    var t = jumlah * harga;
					console.log(t);
                    $('#total_' + i).val(t);
                    total += t;
					console.log($('#total_' + i).val());
                }
            }
			console.log("Ini berdasarkan pemilihan jenis penjualan 19");
			$('#intjumlah1').val('0');
				$('#intjumlah2').val('0');
				/* $('#intjumlah').val('0'); */
				$('#intpv').val('0');
				$('#komisi2').val('0');
				$('#komisi1').val('0');
				$('#komisi1hidden').val('0');
				$('#komisi2hidden').val('0');
                /* $('#intjumlah2hidden').val(total); */

        //end netto
		} else if($("#intid_jpenjualan").val()==8){
		//for lain-lain
			
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                
                var t = jumlah * harga;
			    $('#total_' + i).val(t);
                total += t;
             }
				
				/* $('#intjumlah2hidden').val(total); */
				$('#intjumlah2hidden').val('0');
						
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
		//fahmi2030
        /* else if($("#chktulip30_10").attr('checked') == true){
			//alert('aaa');
			//$("#chktulip20_20").attr("checked",false);
			//$("#chktulip30_10").attr("checked",false);
			//$("#chkBox20").attr("checked",false);
			//$("#chktulip20_20").attr("disabled","disabled");
			//$("#chktulip30_10").attr("disabled","disabled");
			//$("#chkBox20").attr("disabled","disabled");
            var csaja = document.getElementsByName("hit10").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
                    var t = jumlah * harga ;
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
				var x = parseFloat($('#jumlahsementara').val()) + totalreg;

				if($('#chkV').attr('checked') == true && x < 0)
				{
					x = 0;
				}

				$('#intjumlah1').val(formatAsDollars(x));
            	$('#intjumlah1hidden').val(x);
			} else {

				if($('#chkV').attr('checked') == true && totalreg < 0)
				{
					totalreg = 0;
				}

				$('#intjumlah1').val(formatAsDollars(totalreg));
            	$('#intjumlah1hidden').val(totalreg);

            }
			
			//$('#intjumlah2').val(formatAsDollars(totalreg));
            //$('#intjumlah2hidden').val(totalreg);
			$('#komisihide').val(total);

            var t = parseFloat($('#intjumlah1hidden').val());
            var disc = 10;
            var komisi = (t * disc) / 100;
			//var komisi

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}

            $('#komisi1').val(formatAsDollars(komisi));
            $('#komisi1hidden').val(komisi);
			
			
			
        } */
		//untuk lain lain fahmi
		/* else if($("#chktulip20_20").attr('checked') == true) {
			//$("#chktulip20_20").attr("checked",false);
			//$("#chktulip30_10").attr("checked",false);
			///$("#chkBox20").attr("checked",false);
			//$("#chktulip20_20").attr("disabled","disabled");
			//$("#chktulip30_10").attr("disabled","disabled");
            var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
                if(jumlah >=0){
                    var t = jumlah * harga ;
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
				var x = parseFloat($('#jumlahsementara').val()) + totalreg;

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

            var t = parseFloat($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi = (t * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}

            $('#komisi2').val(formatAsDollars(komisi));
            $('#komisi2hidden').val(komisi);
			
			
			
        }
		 */else{
						console.log("Ini berdasarkan pemilihan else terakhir");

            var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseFloat(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseFloat($('#harga_' + i).val());
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
				var x = parseFloat($('#jumlahsementara').val()) + totalreg;

				if($('#chkV').attr('checked') == true && x < 0)
				{
					x = 0;
				}

				/* $('#intjumlah2').val(formatAsDollars(x));
            	$('#intjumlah2hidden').val(x); */
			} else {

				if($('#chkV').attr('checked') == true && totalreg < 0)
				{
					totalreg = 0;
				}

				/* $('#intjumlah2').val(formatAsDollars(totalreg));
            	$('#intjumlah2hidden').val(totalreg); */

            }
			
			//$('#intjumlah2').val(formatAsDollars(totalreg));
            //$('#intjumlah2hidden').val(totalreg);
			/* $('#komisihide').val(total); */

            /* var t = parseFloat($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi = (t * disc) / 100; */

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}

/*             $('#komisi2').val(formatAsDollars(komisi));
            $('#komisi2hidden').val(komisi);
 */			
			
			
        }
		//end fahmi2030


        for(var i=1; i<= parseFloat(id);i++){
            if($('#' + i).val() != ""){
                var jumlah = parseFloat($('#'+ i).val());
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
		/* edited fahmi */
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
            var kom1 = parseFloat($('#komisi1hidden').val()).toFixed(2);
        }
        if($('#komisi2hidden').val() == ""){
            var kom2 = 0;
        }else{
            var kom2 = parseFloat($('#komisi2hidden').val()).toFixed(2);
        }
        if($('#intjumlahhidden').val() == ""){
            var intjum = 0;
        }else{
            var intjum = parseFloat($('#intjumlahhidden').val()).toFixed(2);
        }

        if($('#intjumlahtradehidden').val() == ""){
            var intjumt = 0;
        }else{
            var intjumt = parseFloat($('#intjumlahtradehidden').val());
        }

        if($('#intjumlah1hidden').val() == ""){
            var intjum1 = 0;
        }else{
            var intjum1 = parseFloat($('#intjumlah1hidden').val());
        }
        if($('#intjumlah2hidden').val() == ""){
            var intjum2 = 0;
        }else{
            var intjum2 = parseFloat($('#intjumlah2hidden').val());
        }
        if($('#intjumlahfree').val() == ""){
            var intjumfree = 0;
        }else{
            var intjumfree = parseFloat($('#intjumlahfree').val());
        }

        var omset = intjum1 + intjum2 + intjumfree + intjumt;

		if($('#chkV').attr('checked') == true && omset < 0)
		{
			omset = 0;
		}

        $('#intjumlah').val((omset));
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
	/* punyafahmibaru */
	 if($("#intid_jpenjualan").val() < 9 || $("#intid_jpenjualan").val() == 19) {
		kali_baru(id);
	}  
    }

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })




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
    });//check the checkboxfahmi
	//brgsuka
	if ($('#chktulip30_10').attr('checked') == false || $('#chktulip30_10').attr('checked') == false|| $('#chktulip20_10').attr('checked') == false){
		  $("#brgsuka").attr("disabled","disabled");
	  }
	  
    $("#chktulip30_10").click(function(){
      if ($('#chktulip30_10').attr('checked') == true){
		  $("#chktulip20_20").attr("disabled","disabled");
		  $("#chktulip20_sb").attr("disabled","disabled");
		  $("#chktulip20_10").attr("disabled","disabled");
		   $('#brgsuka').removeAttr('disabled');
		   jbarang = 0;
		   autoComp();
	  }else{
		 /* $('#chktulip20_10').removeAttr('disabled'); */
		 $('#chktulip20_20').removeAttr('disabled');
		 $("#brgsuka").attr("disabled","disabled");
	  }
    });
    $("#chktulip60_net").click(function(){
      if ($('#chktulip60_net').attr('checked') == true){
		  $("#chktulip20_20").attr("disabled","disabled");
		  $("#chktulip20_sb").attr("disabled","disabled");
		  $("#chktulip20_10").attr("disabled","disabled");
		   $('#brgsuka').removeAttr('disabled');
		   jbarang = 0;
		   autoComp();
	  }else{
		 /* $('#chktulip20_10').removeAttr('disabled'); */
		 $('#chktulip20_20').removeAttr('disabled');
		 $("#brgsuka").attr("disabled","disabled");
	  }
    });
    $("#chktulip25_10").click(function(){
      if ($('#chktulip25_10').attr('checked') == true){
		  $("#chktulip20_20").attr("disabled","disabled");
		  $("#chktulip20_sb").attr("disabled","disabled");
		  $("#chktulip20_10").attr("disabled","disabled");
		  $("#chktulip60_net").attr("disabled","disabled");
		   $('#brgsuka').removeAttr('disabled');
		   jbarang = 0;
		   autoComp();
	  }else{
		 /* $('#chktulip20_10').removeAttr('disabled'); */
		 $('#chktulip20_20').removeAttr('disabled');
		 $("#brgsuka").attr("disabled","disabled");
	  }
    });
	$("#chktulip20_10").click(function(){
      if ($('#chktulip20_10').attr('checked') == true){
		  $("#chktulip20_20").attr("disabled","disabled");
		  $("#chktulip20_sb").attr("disabled","disabled");
		  $("#chktulip30_10").attr("disabled","disabled");
		  jbarang = 0;
		   $('#brgsuka').removeAttr('disabled');
		   autoComp();
	  }else{
		/*  $('#chktulip20_20').removeAttr('disabled');
		 
		 $('#chktulip30_10').removeAttr('disabled'); */
		 $("#brgsuka").attr("disabled","disabled");
	  }
    });
	$("#chktulip20_sb").click(function(){
      if ($('#chktulip20_sb').attr('checked') == true){
		  $("#chktulip20_20").attr("disabled","disabled");
		  $("#chktulip20_10").attr("disabled","disabled");
		  $("#chktulip30_10").attr("disabled","disabled");
		  jbarang = 0;
		   $('#brgsuka').removeAttr('disabled');
		   autoComp();
	  }else{
		/*  $('#chktulip20_20').removeAttr('disabled');
		 
		 $('#chktulip30_10').removeAttr('disabled'); */
		 $("#brgsuka").attr("disabled","disabled");
	  }
    });
	$("#chktulip20_20").click(function(){
      if ($('#chktulip20_20').attr('checked') == true){
		  $("#chktulip30_10").attr("disabled","disabled");
		  $("#chktulip20_10").attr("disabled","disabled");
		  $('#brgsuka').removeAttr('disabled');
		  jbarang = 1;
		  autoComp();
	  }else{
		 $('#chktulip30_10').removeAttr('disabled');
		 /* $('#chktulip20_10').removeAttr('disabled'); */
		 $("#brgsuka").attr("disabled","disabled");
	  }
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
	/* fahmijenis */
		if ($('#intid_jpenjualan').attr('value') == 2) {
			
			/* hut(); */
			if($("#chktulip30_10").attr("checked") == true /* || $("#chktulip20_10").attr("checked") == true */){ //tulip 50 komisi 10
				
				//autoCompPromo50();//config
					autoCompPromoNormal();
					/* alert(':)'); */
				}
				else{
					/* alert(':('); */
			hut();
					}
				if( $("#chktulip20_10").attr("checked") == true || $("#chktulip20_sb").attr("checked") == true){
					autoCompPromo20Bayar();
				}
			
		} else if ($('#intid_jpenjualan').attr('value') == 4) {
			tradein();
			//alert("1");
		} else if ($('#intid_jpenjualan').attr('value') == 5){
			
			console.log("Pengejaran chall HUT : "+$("#pengejaranChall").val());
			if((!isNaN($("#pengejaranChall").val())&&$("#pengejaranChall").val() == 1)){
				 
				//alert("Silahkan lan");
					satufreesatuAllItem();
					console.log("true");
				}else{
						if(window.is_launch == 0){			
							
							alert("anda tidak terdaftar!");
							window.location.href="<?php echo base_url();?>penjualan";
							console.log("false");
							}else if(window.is_launch == 1){
								
								//satufreesatuLaunch(); // kalau kondisi 1 free 1 all item
								satufreesatuLaunchingBarang();
								console.log("launching true");
					
								}else{
									alert("isi data member");
									window.location.href="<?php echo base_url();?>penjualan";
									}
					}
					
			//satufreesatuAllItem();
				
		} else if( $('#intid_jpenjualan').attr('value') == 6) {
			satufreesatu();
			//alert("2");
		} else if ($('#intid_jpenjualan').attr('value') == 7) {
			netto();
			//alert("3");
		} else if ($('#intid_jpenjualan').attr('value') == 8) {
			
			showattribute_lainlain();
		//	alert("4");
		}else if ($('#intid_jpenjualan').attr('value') == 13) {
			autoCompMetal50();
		//	alert("4");
		} else {
			if($("#chktulip50_10").attr("checked") == true){ //tulip 50 komisi 10
				
				autoCompPromo50();//config
				}
				
				
				else{
					if( $("#chktulip20_10").attr("checked") == true || $("#chktulip20_sb").attr("checked") == true){
					autoCompPromo20Bayar();
				}else{
					autoCompPromoNormal();}
					}
		}
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
		}
		/* fahmifree */
		 else if (/* $("#chktulip30_10").attr('checked') == true ||  */$("#chktulip20_10").attr('checked') == true || $("#chktulip20_sb").attr('checked') == true) {
			/* if ($("#tracker002").val() == "bayar")
			{
				autoCompPromoNormal();
			} else */ if ($("#tracker002").val() == "free" ) {
				autoCompPromo20Free();
			}
		} 
	}
	
	///attribute for intid_jpenjualan == 8
	
	function showattribute_lainlain(){
		
		if($('#intid_jpenjualan').attr('value') == 8){
			
			$("#showattrlainlain").removeAttr("style","display:none");
			$("#showattrlainlain2").removeAttr("style","display:none");
			$("#komisitrade").removeAttr("disabled","disabled");
			}else{
				
				$("#showattrlainlain").attr("style","display:none");
				$("#showattrlainlain2").attr("style","display:none");
				$("#komisitrade").attr("disabled","disabled");
				}
			$("#chklainlain").attr("checked",false);
			lain();
		}
		
	//reload lookup method
	
	$("#chklainlain").bind("click",function(){
		if($('#chklainlain').attr('checked') == true){
			$("#chktulip50").attr("checked",false);
			}
		lain();
		});
	$("#chktulip50").bind("click",function(){
		if($('#chktulip50').attr('checked') == true){
			$("#chklainlain").attr("checked",false);
			}
		lain();
		});
		/* untukfahmilook */
		
	
	/*
	* auto complete bwt promo normal yg ga pilih apa2	
	*/
	function autoCompPromoNormal() {
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){ 
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang2030",
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='status_free' name='status_free' value='" + ui.item.value8 + "' size='15' />"
                    );

                    },
                });
	}
	
	function autoCompPromo50() {
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
	/*
	* auto complete bwt promo normal yg ga pilih apa2	
	*/
	function autoCompMetal50() {
	console.log("autoCompMetal50");
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangMetal50",
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
	}	/*
	* auto complete bwt promo normal yg ga pilih apa2	
	*/
	var jbarang = 0;
	/* if ($('#chktulip20_10').attr('checked') == true){
		jbarang = 2;
	} */
	function autoCompPromoNormal() {
	/* pengaturanfahmi */
	var aturlook;
	if($("#chktulip60_net").attr('checked') == true){
		aturlook='lookupBarangNetto60';
	}else if($("#chktulip25_10").attr('checked') == true){
		aturlook='lookupBarang';
	}else{
		aturlook='lookupBarang203030';
	}
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/"+aturlook,  
                            dataType: 'json',
                            type: 'POST',
							data:  {
                                term: req.term,
                                state: jbarang,

                            },
                            /* data: req, */
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='status_free' name='status_free' value='" + ui.item.value8 + "' size='15' />"
                    );

                    },
                });
	}
	/* Buat AutoCompMetalFahmi*/
	function autoCompPromoNormalMetal() {
	console.log('Metal');
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                            dataType: 'json',
                            type: 'POST',
                            data:  {
                                term: req.term,
                                state: 2,

                            },
							/* req, */
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
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
	
	/*
	* metal 50% checklist handler
	*/
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
			$("#post_intid_jpenjualan").val($("#intid_jpenjualan").val());
		}
		else if ($('#intid_jpenjualan').attr('value')== 2) {
			var title = "Nota Penjualan Chall Hut";
			$('#title').text(title);
			$('#intpv').val(0);
			$("#post_intid_jpenjualan").val($("#intid_jpenjualan").val());
		}
		else if ($('#intid_jpenjualan').attr('value')== 3) {
			var title = "Nota Penjualan Challenge";
			$('#title').text(title);
			$("#post_intid_jpenjualan").val($("#intid_jpenjualan").val());
		}else if ($('#intid_jpenjualan').attr('value')== 7) {
			var title = "Nota Penjualan Netto";
			$('#title').text(title);
			$("#post_intid_jpenjualan").val($("#intid_jpenjualan").val());
		}
		else if ($('#intid_jpenjualan').attr('value')== 19) {
			var title = "Nota Penjualan Diskon 60 Net";
			$('#title').text(title);
			$("#post_intid_jpenjualan").val($("#intid_jpenjualan").val());
		}
		else if ($('#intid_jpenjualan').attr('value')== 13) {
			var title = "Nota Penjualan Metal 50%";
			$('#title').text(title);
			$("#chkSmart").attr("checked",false);
			$("#chkSmart").attr("disabled","disabled");
			autoComp();
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
			if ($('#intid_jpenjualan').attr('value') == 2 || $('#intid_jpenjualan').attr('value') == 3 || $('#intid_jpenjualan').attr('value') == 4 || $('#intid_jpenjualan').attr('value') == 5 || $('#intid_jpenjualan').attr('value') == 6 || $('#intid_jpenjualan').attr('value') == 7 || $('#intid_jpenjualan').attr('value') == 19)
			{
				$("#chkBox10").attr("checked",false);
				$("#chkBox20").attr("checked",false);
				$("#chkBoxTrade").attr("checked",false);
				$("#chkBoxFreeHut").attr("checked",false);
				$("#chkBoxFree").attr("checked",false);
				$("#chkBox10").attr("disabled","disabled");
				$("#chkBox20").attr("disabled","disabled");
				$("#chkBoxTrade").attr("disabled","disabled");
				$("#chkBoxFreeHut").attr("disabled","disabled");
				$("#chkBoxFree").attr("disabled","disabled");
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
			if ($('#intid_jpenjualan').attr('value') == 4) { $("#chkBoxTrade").removeAttr("disabled"); }
			if ($('#intid_jpenjualan').attr('value') == 5) { $("#chkBoxFreeHut").removeAttr("disabled"); }
			if ($('#intid_jpenjualan').attr('value') == 6) { $("#chkBoxFree").removeAttr("disabled"); }
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
		if (parseFloat($('#tracker001').val()) < parseFloat(id))
		{
			$('#tracker001').val(id);
		}		

		//itung jumlah barang normal total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityNormal = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.semua_'+ i).val()) >= 0) {
				if (parseFloat($('.semua_'+ i).val()) != '')
				{
					_totalQuantityNormal += parseFloat($('.semua_'+ i).val());
				}
			}
		}
		//itung jumlah barang omset 10 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity10 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.sepuluh_'+ i).val()) >= 0) {
				if (parseFloat($('.sepuluh_'+ i).val()) != '')
				{
					_totalQuantity10 += parseFloat($('.sepuluh_'+ i).val());
				}
			}
		}
		//itung jumlah barang omset 20 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity20 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.duapuluh_'+ i).val()) >= 0) {
				if (parseFloat($('.duapuluh_'+ i).val()) != '')
				{
					_totalQuantity20 += parseFloat($('.duapuluh_'+ i).val());
				}
			}
		}
		//itung jumlah barang free normal total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.free_'+ i).val()) >=0) {
				if (parseFloat($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseFloat($('.free_'+ i).val());
				}
			}
		}
		//itung jumlah barang free promo 20 total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree20 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.free20_'+ i).val()) >=0) {
				if (parseFloat($('.free20_'+ i).val()) != '')
				{
					_totalQuantityFree20 += parseFloat($('.free20_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F1HUT = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.onefreehuts_'+ i).val()) >=0) {
				if (parseFloat($('.onefreehuts_'+ i).val()) != '')
				{
					_totalQuantity1F1HUT += parseFloat($('.onefreehuts_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F1HUT = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.freeonehut_'+ i).val()) >=0) {
				if (parseFloat($('.freeonehut_'+ i).val()) != '')
				{
					_totalQuantityFree1F1HUT += parseFloat($('.freeonehut_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F110 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.onefrees_'+ i).val()) >=0) {
				if (parseFloat($('.onefrees_'+ i).val()) != '')
				{
					_totalQuantity1F110 += parseFloat($('.onefrees_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F110 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.freeone_'+ i).val()) >=0) {
				if (parseFloat($('.freeone_'+ i).val()) != '')
				{
					_totalQuantityFree1F110 += parseFloat($('.freeone_'+ i).val());
				}
			}
		}
		
		//harga total barang semua setelah harga dikalikan dengan jumlah
		var _totalHargaSemua = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('#'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('#'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('#'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHargaSemua += parseFloat($('#total_' + i).val());
			}
		}

		//harga total barang normal setelah harga dikalikan dengan jumlah
		var _totalHargaNormal = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('.semua_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('.semua_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('.semua_'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHargaNormal += parseFloat($('#total_' + i).val());
			}
		}
		//harga total barang omset 10 setelah harga dikalikan dengan jumlah
		var _totalHarga10 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('.sepuluh_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('.sepuluh_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('.sepuluh_'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHarga10 += parseFloat($('#total_' + i).val());
			}
		}
		//harga total barang omset 20 setelah harga dikalikan dengan jumlah
		var _totalHarga20 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('.duapuluh_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('.duapuluh_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('.duapuluh_'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHarga20 += parseFloat($('#total_' + i).val());
			}
		}
		
		//harga total barang 1 Free 1 HUT/Nett setelah harga dikalikan dengan jumlah
		var _totalHargaFreeHUT = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('.onefreehuts_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('.onefreehuts_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('.onefreehuts_'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHargaFreeHUT += parseFloat($('#total_' + i).val());
			}
		}
		
		//harga total barang 1 Free 1 HUT 10% setelah harga dikalikan dengan jumlah
		var _totalHargaFrees = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if($('.onefrees_'+ i).val() == '') {
				$('#total_' + i).val(0);
			} else if (parseFloat($('.onefrees_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseFloat($('.onefrees_'+ i).val()) * parseFloat($('#harga_' + i).val()));
				_totalHargaFrees += parseFloat($('#total_' + i).val());
			}
		}

		//total semua harga barang yg di order di nota ini
		var _total = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('#total_'+ i).val()) >= 0 && parseFloat($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseFloat($('#total_'+ i).val()) >= 0)
				{
					_total += parseFloat($('#total_'+ i).val());
				}
			}
		}

		//masukin total harga ke textbox bawah yg diatas tombol simpan
		$('#intjumlah1').val(_totalHarga10);
		$('#intjumlah2').val(_totalHarga20 + _totalHargaNormal);
		$('#intjumlah').val(parseFloat($('#intjumlah1').val()) + parseFloat($('#intjumlah2').val()) + _totalHargaFreeHUT + _totalHargaFrees);
		$('#totalbayar').val(parseFloat($('#intjumlah').val()));

		//total semua pv yg didapat di nota ini
		var _totalPV = 0;
		if ($('#intid_jpenjualan').attr('value') != 2)
		{
			for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
				if (parseFloat($('#pv_'+ i).val()) > 0) {
					_totalPV += (parseFloat($('#total_'+ i).val()) / parseFloat($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
				}
			}
			$('#intpv').val(_totalPV.toFixed(2));
		}
		
		//hitung komisi 10% dan kurangi totalbayar
		if ($('#intjumlah1').val() != '' && $('#intid_jpenjualan').attr('value') != 4 && $('#intid_jpenjualan').attr('value') != 7 && $('#intid_jpenjualan').attr('value') != 19 && $('#intid_jpenjualan').attr('value') != 8)
		{
			$('#komisi1').val(parseFloat($('#intjumlah1').val()) * 0.1);
			$('#totalbayar').val(parseFloat($('#totalbayar').val()) - parseFloat($('#komisi1').val()));
		}

		//hitung komisi 20% dan kurangi totalbayar
		if ($('#intjumlah2').val() != '' && $('#intid_jpenjualan').attr('value') != 4 && $('#intid_jpenjualan').attr('value') != 7 && $('#intid_jpenjualan').attr('value') != 19 && $('#intid_jpenjualan').attr('value') != 8)
		{
			$('#komisi2').val(parseFloat($('#intjumlah2').val()) * 0.2);
			$('#totalbayar').val(parseFloat($('#totalbayar').val()) - parseFloat($('#komisi2').val()));
		}
		
		/*______________________________________________________________________________
		|																				|
		|					Kode yg bisa brubah2 tergantung promonya					|
		|______________________________________________________________________________*/

		//promo 10 dan 20
		//hitung jumlah total barang free yg boleh dikeluarkan
		var _tempCount = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
		/* fahmitracker */
			if($("#chktulip50_10").attr("checked") == true||$("#chktulip30_10").attr("checked") == true||$("#chktulip20_10").attr("checked") == true ||$("#chktulip20_sb").attr("checked") == true /* && status_free == 1 */){
				if (parseFloat($('#total_'+ i).val()) >= 0 && parseFloat($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
					if (parseFloat($('.sepuluh_'+ i).val()) > 0 && parseFloat($('.status_free_'+ i).val()) == 1) {
						console.log(_tempCount+' ada');
						_tempCount += parseFloat($('.sepuluh_'+ i).val()) /* / 2 */;
					}
					//buat tracker metal 20% komisi 10%
					if (parseFloat($('.sepuluh_'+ i).val()) > 0 && $("#chktulip20_10").attr("checked") == true) {
						console.log(_tempCount+' ada'); 
						_tempCount += parseFloat($('.sepuluh_'+ i).val()) /* / 2 */;
					}
					if (parseFloat($('.duapuluh_'+ i).val()) > 0 && $("#chktulip20_sb").attr("checked") == true) {
						console.log(_tempCount+' ada'); 
						_tempCount += parseFloat($('.duapuluh_'+ i).val()) /* / 2 */;
					}
					/* if (parseFloat($('.duapuluh_'+ i).val()) > 0 && $("#chkSmart").attr("checked") != true) {
						_tempCount += parseFloat($('#tracker003_'+ i).val()) * parseFloat($('.duapuluh_'+ i).val());
					} */
				}
			}/* else{
				if (parseFloat($('#total_'+ i).val()) >= 0 && parseFloat($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
					if (parseFloat($('.sepuluh_'+ i).val()) > 0) {
						_tempCount += parseFloat($('.sepuluh_'+ i).val()) / 2;
					}
					if (parseFloat($('.duapuluh_'+ i).val()) > 0 && $("#chkSmart").attr("checked") != true) {
						_tempCount += parseFloat($('#tracker003_'+ i).val()) * parseFloat($('.duapuluh_'+ i).val());
					}
				}
			} */
		}
		console.log(_tempCount+"tracker"+status_free);
		//if( status_free == 1){
		$('#tracker004').val(Math.floor(_tempCount));
		console.log(Math.floor(_tempCount));
		//}
		
		/* alert(_tempCount); */
		
		//cek apakah jumlah barang bayar dan free sudah benar
		//check tambahan tulip50% komisi 10%
		
		if ((parseFloat($('#tracker004').val()) > _totalQuantityFree + _totalQuantityFree20) && (status_free == 1) ) {
			//if( $("#chktulip50_10").attr("checked") != true){ //not working
			
				alert("Silakan pilih barang freeeeeeeeeee");
				$('#tracker002').val("free");
				status_free = 0;
				//}
			//	else{
					//do nothing..
				//	}
				
		}
		//untuk tracker004 bagian metal 20% komisi 10%
		if ((parseFloat($('#tracker004').val()) > _totalQuantityFree + _totalQuantityFree20) || $("#chktulip20_10").attr("checked") == true || $("#chktulip20_sb").attr("checked") == true ) {
			//if( $("#chktulip50_10").attr("checked") != true){ //not working
			
				alert("Silakan pilih barang freeeeeeeeeee");
				$('#tracker002').val("free");
				status_free = 0;
				//}
			//	else{
					//do nothing..
				//	}
				
		}
		else if ($('#tracker004').val() == _totalQuantityFree + _totalQuantityFree20) {
			$('#tracker002').val("bayar");
		} else if ($('#tracker004').val() < _totalQuantityFree + _totalQuantityFree20) {
			alert("Jumlah barang free melebihi quota");
			for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
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
			
			for(var i = 1; i <= parseFloat($('#tracker001').val()); i++){
			_temppv += $('#pv_' + i).val() * parseFloat((100 - parseFloat($('#komisitrade').val()))/100)* $('#'+i).val();
			}
			_temppv = _temppv.toFixed(2);
			//$('#intpv').val((parseFloat($('#intjumlah').val()) / 100000).toFixed(2));
			$('#intpv').val(_temppv);
			$('#komisi1').val(parseFloat($('#intjumlah').val()) * 0.1);
			$('#totalbayar').val(parseFloat($('#intjumlah').val()) - parseFloat($('#komisi1').val()));
		}
		
		//promo 1 free 1 hut/nett
		if ($('#intid_jpenjualan').attr('value') == 5)
		{
			$('#intjumlah1').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah').val(_totalHargaFreeHUT);
			$('#intpv').val((parseFloat($('#intjumlah').val()) / 100000).toFixed(2));
			$('#totalbayar').val(parseFloat($('#intjumlah').val()));
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
				for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
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
			$('#intpv').val((parseFloat($('#intjumlah').val()) / 100000).toFixed(2));
			$('#komisi1').val(parseFloat($('#intjumlah').val()) * 0.1);
			$('#totalbayar').val(parseFloat($('#intjumlah').val()) - parseFloat($('#komisi1').val()));
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
				for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
					$('.freeone_'+i).val('');
				}
			}
		}
		
		//promo netto
		if ($('#intid_jpenjualan').attr('value') == 7)
		{
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah2hidden').val(0);

			$('#intpv').val(0);
		}
		if ($('#intid_jpenjualan').attr('value') == 19)
		{
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			$('#intjumlah2').val(0);
			$('#intjumlah2hidden').val(0);

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
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			$('#intvoucher').val(_voucher);
			if ($('#intjumlah1').val() != '' && $('#intjumlah1').val() != 0)
			{
				$('#intjumlah1').val(parseFloat($('#intjumlah1').val()) - _voucher);
			} else {
				$('#intjumlah2').val(parseFloat($('#intjumlah2').val()) - _voucher);
			}
			$('#intjumlah').val(parseFloat($('#intjumlah').val()) - _voucher);
			$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 100000));
			if ($('#komisi1').val() != '' && $('#komisi1').val() != 0)
			{
				$('#komisi1').val(parseFloat($('#komisi1').val()) - (_voucher * 0.1));
			} else {
				$('#komisi2').val(parseFloat($('#komisi2').val()) - (_voucher * 0.2));
			}
			$('#totalbayar').val((parseFloat($('#intjumlah').val()) - parseFloat($('#komisi1').val())) - parseFloat($('#komisi2').val()));
			if ($('#intpv').val() < 0) { $('#intpv').val(0); }
		}
		
		//apabila smart spending di checklist
		if ($("#chkSmart").attr("checked") == true) {
			$('#komisi1').val(0);
			$('#komisi2').val(0);
			if (parseFloat($('#intjumlah').val()) < 500000) {
				$('#charge3').val(parseFloat($('#intjumlah').val()) * 0.03);
				$("#asi").empty();
			} else {
				$('#charge3').val(0);
                $("#asi").append('<input type="hidden" name="is_asi" id="is_asi" value="on" />');
			}
			$('#totalbayar').val(parseFloat($('#intjumlah').val()) + parseFloat($('#charge3').val()));
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
		$('#intjumlah1').val((parseFloat($('#intjumlah1').val())));
		$('#intjumlah2').val((parseFloat($('#intjumlah2').val())));
		$('#intjumlah').val((parseFloat($('#intjumlah').val())));
		$('#komisi1').val((parseFloat($('#komisi1').val())));
		$('#komisi2').val((parseFloat($('#komisi2').val())));
		$('#charge3').val(formatAsRupiah(parseFloat($('#charge3').val())));
		$('#totalbayar').val((parseFloat($('#totalbayar').val())));

		//hitung sisa pembayaran
		sisa();

		return false;
	}
	
	/**
	* function kali_sepuluh yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kali_sepuluh_baru(id) {
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseFloat($('#tracker001').val()) < parseFloat(id))
		{
			$('#tracker001').val(id);
		}
		
		//itung jumlah barang free total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.free20_'+ i).val()) >=0 && parseFloat($('#total_'+ i).val()) >= 0 && parseFloat($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseFloat($('.free20_'+ i).val()) != '')
				{
					_totalQuantityFree += parseFloat($('.free20_'+ i).val());
				}
			}
			else if (parseFloat($('.free_'+ i).val()) >=0 && parseFloat($('#total_'+ i).val()) >= 0 && parseFloat($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseFloat($('.free_'+ i).val()) != '')
				{
					_totalQuantityFree += parseFloat($('.free_'+ i).val());
				}
			}
		}
		
		//itung jumlah barang 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F1HUT = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.onefreehuts_'+ i).val()) >=0) {
				if (parseFloat($('.onefreehuts_'+ i).val()) != '')
				{
					_totalQuantity1F1HUT += parseFloat($('.onefreehuts_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 hut yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F1HUT = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.freeonehut_'+ i).val()) >=0) {
				if (parseFloat($('.freeonehut_'+ i).val()) != '')
				{
					_totalQuantityFree1F1HUT += parseFloat($('.freeonehut_'+ i).val());
				}
			}
		}
		//itung jumlah barang 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity1F110 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.onefrees_'+ i).val()) >=0) {
				if (parseFloat($('.onefrees_'+ i).val()) != '')
				{
					_totalQuantity1F110 += parseFloat($('.onefrees_'+ i).val());
				}
			}
		}
		//itung jumlah barang free 1 free 1 10% yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantityFree1F110 = 0;
		for (var i = 1; i <= parseFloat($('#tracker001').val()); i++) {
			if (parseFloat($('.freeone_'+ i).val()) >=0) {
				if (parseFloat($('.freeone_'+ i).val()) != '')
				{
					_totalQuantityFree1F110 += parseFloat($('.freeone_'+ i).val());
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
		if ($('#intid_jpenjualan').attr('value') == 6 || $('#intid_jpenjualan').attr('value') == 8)
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
		
		if ($('#tracker004').val() > _totalQuantityFree && (status_free == 1)) {
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
	
	/**
	* function sisa yg baru
	*/
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
			if ($('#intcash').val() != '') {_cash = parseFloat($('#intcash').val());}
			if ($('#intkkredit').val() != '') {_kredit = parseFloat($('#intkkredit').val());}
			if ($('#intdebit').val() != '') {_debit = parseFloat($('#intdebit').val());}
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
			return(parseFloat(_array.substr(1)));
		}
		if (_array.substr(0,3) == 'NaN')
		{
			_array.substr(3);
			return(parseFloat(_array.substr(3)));
		}
		return (parseFloat(_array));
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
				var jmlbrg = parseFloat($('#jumlahbrg20').val());
				var textpromo20 = parseFloat($("#txtpromo20").val());
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
      autoComp();
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

        var jmlbrg = parseFloat($('#jumlahbrgfreehut').val());
        var limitfreehut = parseFloat($("#txtfreehut").val());
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

        var jmlbrg = parseFloat($('#jumlahbrgfree').val());
        var limitfree = parseFloat($("#txtfree").val());
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
	if ($("#tracker002").val() == "bayar")
	{
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });
	} else if ($("#tracker002").val() == "free") {
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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });
	}
    }

    function tradein(){
	if ($("#tracker002").val() == "bayar")
	{
		/*
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
		*/
		  var ur = "<?php echo base_url(); ?>penjualan/lookupTradeIn";
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
                                state: $('#komisitrade').val(),
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
                    "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
                );
                },
            });
	} else if ($("#tracker002").val() == "free") {

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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });
	}
    }
/*
    function satufreesatu(){
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
	if ($("#tracker002").val() == "bayar")
	{
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });
	} else if ($("#tracker002").val() == "free") {
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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='intid_harga' name='intid_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });
	}

    }
	*/
	//lookup satu free satu 
    function satufreesatu(){

        	if ($("#tracker002").val() == "bayar")
        	{

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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
                    );
                    },
                });
        	} else if ($("#tracker002").val() == "free") {
                $(".id1").autocomplete({
                        minLength: 5,
                        source:
                            function(req, add){

                            $.ajax({
                                url: "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatufree",
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

    }
	
	//launching barang
	function satufreesatuLaunchingBarang(){

        	if ($("#tracker002").val() == "bayar")
        	{

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatuBayarLaunchingBarang";
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
                    );
                    },
                });
        	} else if ($("#tracker002").val() == "free") {
                $(".id1").autocomplete({
                        minLength: 5,
                        source:
                            function(req, add){

                            $.ajax({
                                url: "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatufreeLaunchingBarang",
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

    }
	
	function satufreesatuAllItem(){

        	if ($("#tracker002").val() == "bayar")
        	{

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatuBayarALLITEM";
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
                    );
					window.namaBarang	= ui.item.value;
					window.codeBarang	= ui.item.code_barang;
					console.log("namaBarang "+window.namaBarang+", codeBarang "+window.codeBarang);
                    },
                });
        	} else if ($("#tracker002").val() == "free") {
                $(".id1").autocomplete({
                        minLength: 5,
                        source:
                            function(req, add){

                            $.ajax({
                                url: "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatufreeALLITEM",
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    term: req.term,
                                    state: window.namaBarang,
                                    code: window.codeBarang,
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

    }
	
	//launching
	
	function satufreesatuLaunch(){
	
			console.log("start 1 free 1 launching");
        	if ($("#tracker002").val() == "bayar")
        	{

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatuBayarLaunching";
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
                    );
					window.namaBarang	= ui.item.value;
					window.codeBarang	= ui.item.code_barang;
					console.log("namaBarang "+window.namaBarang+", codeBarang "+window.codeBarang);
                    },
                });
        	} else if ($("#tracker002").val() == "free") {
                $(".id1").autocomplete({
                        minLength: 5,
                        source:
                            function(req, add){

                            $.ajax({
                                url: "<?php echo base_url(); ?>penjualan/lookupBarangSatuFreeSatufreeALLITEM",
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    term: req.term,
                                    state: window.namaBarang,
                                    code: window.codeBarang,
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

    }
	
	//netto
	function netto(){
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarangNetto60";

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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
            );
            },
        });
    }
	//for lain-lain
	function lain(){
	
		if($('#chklainlain').attr('checked') == true){
		
		var ur = "<?php echo base_url(); ?>penjualan/lookupBarangLainFree";
			if ($("#tracker002").val() == "bayar")
			{
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
						"<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
					);
					},
				});
			} else if ($("#tracker002").val() == "free") {
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
						"<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
					);
					},
				});
			}
		}
		else if($('#chktulip50').attr('checked') == true){
			var ur = "<?php echo base_url(); ?>penjualan/lookupBarangLainTulip50";
			if ($("#tracker002").val() == "bayar")
			{
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
						"<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
					);
					},
				});
			} else if ($("#tracker002").val() == "free") {
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
						"<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
					);
					},
				});
			}
		}else{
			
			var ur = "<?php echo base_url(); ?>penjualan/lookupBarangLain";
			if ($("#tracker002").val() == "bayar")
			{
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
						"<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value5 + "' size='15' />"
					);
					},
				});
			} else if ($("#tracker002").val() == "free") {
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
						"<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
					);
					},
				});
			}
			}
    }

    $('#intid_jpenjualan').change(function()
    {
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
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
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
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
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
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
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
			$("#chkBoxTrade").attr("checked",true);
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
        } else  if ($(this).attr('value')== 5)
        {
            var title = "Nota Penjualan 1 Free 1 Hut";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","");
			$("#chkBoxFreeHut").attr("checked",true);
			$("#chkBoxFree").attr("disabled","disabled");
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
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
			$("#chkBoxFree").attr("checked",true);
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
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
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
			netto();
        } else  if ($(this).attr('value')== 19)
        {
            var title = "Nota Penjualan Diskon 60 Net";
            $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","");
			$("#chkBox10").attr("disabled","");
			$("#chkBoxTrade").attr("disabled","disabled");
			$("#chkBoxFreeHut").attr("disabled","disabled");
			$("#chkBoxFree").attr("disabled","disabled");
			$("#showattrlainlain").attr("style","display:none;");
			$("#showattrlainlain2").attr("style","display:none;");
			autoComp();
			kali();
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
		
		//001
		if ($("#chkSmart").attr("checked") == true && $('#intid_jpenjualan').attr('value')!= 1) {
			$("#chkBox10").attr("checked",false);
			$("#chkBox20").attr("checked",false);
			$("#chkBox10").attr("disabled","disabled");
			$("#chkBox20").attr("disabled","disabled");
		}
		
		kali();
		
    });


    function formatAsRupiahasd(ObjVal) {

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

