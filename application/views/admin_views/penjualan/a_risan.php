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

        $("#radio7").click(function(){
                if($("#radio7").attr('checked') == true){
                    $('#intc_6').removeAttr('disabled');
                    $('#intc_7').removeAttr('disabled');
                    var rad = $("#radio7").val();
                    $("#radio_hide").val(rad);

                }else{

                    $("#intc_6").attr("disabled","disabled");
                    $("#intc_7").attr("disabled","disabled");
                }
        });

        $("#radio5").click(function(){
                if($("#radio5").attr('checked') == true){
                    $("#intc_6").attr("disabled","disabled");
                    $("#intc_7").attr("disabled","disabled");
                    var rad = $("#radio5").val();
                    $("#radio_hide").val(rad);
                }
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
                        "<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='23' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='23' readonly/></td>"
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
                
				/* Promo30komisi10 */
				$("#chktulip30_10").bind("click",function(){
					console.log("autoCompPromo30komisi10 sudah terload");
					autoCompPromo30komisi10();
					});
				
				
            });

            //for barang

            function autoComp(){
				console.log("autoComp running");
                 if ($("#chkBox20").attr('checked') == true) {

                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarangPromo20";
                }else{
                    
					var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
					}
               
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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='intuang_muka' name='intuang_muka' value='" + ui.item.value5 + "' size='15' readonly='readonly'/><input type='hidden' id='intcicilan' name='intcicilan' value='" + ui.item.value6 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });


                $(".frees").autocomplete({
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
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='8' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

            function autoCompPromo10(){
				
				console.log("autoCompPromo10 Running");
				
                if($("#chkBox10").attr('checked') == false){
                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
                }else if ($("#chkBox10").attr('checked') == true) {

                    var ur = "<?php echo base_url(); ?>penjualan/lookupBarangPromo10";
                }

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
                         "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='intuang_muka' name='intuang_muka' value='" + ui.item.value5 + "' size='15' readonly='readonly'/><input type='hidden' id='intcicilan' name='intcicilan' value='" + ui.item.value6 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );
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
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='8' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>   <h2 class="title">Arisan</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota" method="post" name="frmjual" id="frmjual">
                            <input type="hidden" name="intno_nota" value="001">
                            <input type="hidden" name="tracker009" id="tracker009" class="tracker009" value="0" size="2">
                            <input type="hidden" name="buat_arisan" value="arisan">
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
                                    <td><input type="text" name="textfield4" id="intid_unit"  size="23"/></td>
                              </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="82">&nbsp;Nama</td>
                                    <td width="7">&nbsp;:</td>
                                    <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="23"/></td>
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
                                    <td>&nbsp;No. Nota</td>
                                    <td>&nbsp;<input type="text" id="nomor_nota" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly ></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                              <?php 
							  /**
							  <!-- Promo 2013 / 2014 -->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                      <input type="hidden" name="intid_jpenjualan" value="1"><input type="hidden" name="is_arisan" value="1"></td>
                                    <td colspan="3">Paket Promo 20%</td>
                                    <td>
                                        <input type="checkbox" name="chkBox20" id="chkBox20" />
                                        x
                                        <input type="text" name="txtpromo20" id="txtpromo20" onkeypress="return isNumberKey(event)" size="4" disabled="disabled"/>
                                        <input type="hidden" id="jumlahbrg20">                                        </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Paket Promo 10%</td>
                                    <td>
                                        <input type="checkbox" name="chkBox10" id="chkBox10"/>
                                        x
                                        <input type="text" name="txtpromo10" id="txtpromo10" onkeypress="return isNumberKey(event)" size="4" disabled="disabled"/>
                                        <input type="hidden" id="jumlahbrg10">                                        </td>
                                </tr>
								<!-- End Promo 2013 / 2014 -->
								*/
								?>
								<!-- @param Promo30komisi10 -->
								<tr id="showattrlainlain5" >
									<td>&nbsp;</td>
                                    <td>&nbsp;</td>
									<td colspan="3">Tulip 30% komisi 10%</td>
									<td >
										<input type="checkbox" name="chktulip30_10" id="chktulip30_10" />
                                    </td>
                                </tr>				
								<!-- -->
								<!-- @param special bonus -->
								<tr>
                                    <td>&nbsp;</td>
                                    <td>
                                      <input type="hidden" name="intid_jpenjualan" value="1"><input type="hidden" name="is_arisan" value="1"></td>
                                    <td colspan="3">Special Bonus</td>
                                    <td>
                                        <input type="checkbox" name="chkBox20" id="chkBox20" />
                                        x
                                        <input type="text" name="txtpromo20" id="txtpromo20" onkeypress="return isNumberKey(event)" size="4" disabled="disabled"/>
                                        <input type="hidden" id="jumlahbrg20">                                        </td>
                                </tr>
                                <!-- -->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Group</td>
                                    <td><select name="group" id="group" >
                                        <?php /*
                                            for($i=0;$i < sizeof($cek);$i++){
                                                echo '<option value="'.$cek[$i]['group'].'" >'.$cek[$i]['group'].'</option>';
                                            }*/
                                            foreach($cek2 as $row){
                                                echo '<option value="'.$row->group.'" >'.$row->group.'</option>';
                                            }
                                           ?>
                                        </select>
                                            <?
                                        /* tidak digunakan lagi 
										//tgl 28agustus2013
										echo "yoo : ".$group4.",".$group4_; ?>
                                        &nbsp;&nbsp;<select name="group" id="group" >
                                           <?php
                                                if($group1 > 20){?>
                                                 <option value="1" disabled="disabled">1</option>
                                                <? } else if($group1 < 21 and $group1_ == 1){?>
                                                   <option value="1">1</option>
                                                <?php }else{?> 
                                                    <option value="1" disabled="disabled">1</option>
                                                <?php } 
                                                if($group2 > 20){?>
                                                  <option value="2" disabled="disabled">2</option>
                                                <? } else if($group2 < 21 and $group2_ == 1){?>
                                                   <option value="2">2</option>
                                                <?php }else{?> 
                                                    <option value="2" disabled="disabled">2</option>
                                                <?php }  
                                                if($group3 > 20){?>
                                                  <option value="3" disabled="disabled">3</option>
                                                <? } else if($group3 < 21 and $group3_ == 1){?>
                                                   <option value="3">3</option>
                                                <?php }else{?> 
                                                    <option value="3" disabled="disabled">3</option>
                                                <?php }  
                                                if($group4 > 20){?>
                                                  <option value="4" disabled="disabled">4</option>
                                                <? } else if($group4 < 21 and $group4_ == 1){?>
                                                   <option value="4">4</option>
                                                <?php }else{?> 
                                                    <option value="4" disabled="disabled">4</option>
                                                <?php } ?>
                                                <?php
                                             /* if ($group1 > 20){ ?>
                                                <option value="1" disabled="disabled">1</option>
                                            <?php } else { ?>
                                                <option value="1">1</option>
                                            <?php } ?>
                                            <?php if ($group2 > 20){ ?>
                                                <option value="2" disabled="disabled">2</option>
                                            <?php } else { ?>
                                                <option value="2">2</option>
                                            <?php } ?>
                                            <?php if ($group3 > 20){ ?>
                                                <option value="3" disabled="disabled">3</option>
                                            <?php } else { ?>
                                                <option value="3">3</option>
                                            <?php } ?>
                                            <?php if ($group4 > 20){ ?>
                                                <option value="4" disabled="disabled">4</option>
                                            <?php } else { ?>
                                                <option value="4">4</option>
                                            <?php } ?>
                                            <?php if ($group5 > 20){ ?>
                                                <option value="5" disabled="disabled">5</option>
                                            <?php } else { ?>
                                                <option value="5">5</option>
                                            <?php } ?>
                                            <?php if ($group6 > 20){ ?>
                                                <option value="6" disabled="disabled">6</option>
                                            <?php } else { ?>
                                                <option value="6">6</option>
                                            <?php } ?>
                                            <?php if ($group7 > 20){ ?>
                                                <option value="7" disabled="disabled">7</option>
                                            <?php } else { ?>
                                                <option value="7">7</option>
                                            <?php } ?>
                                            <?php if ($group8 > 20){ ?>
                                                <option value="8" disabled="disabled">8</option>
                                            <?php } else { ?>
                                                <option value="8">8</option>
                                            <?php } ?>
                                            <?php if ($group9 > 20){ ?>
                                                <option value="9" disabled="disabled">9</option>
                                            <?php } else { ?>
                                                <option value="9">9</option>
                                            <?php } ?>
                                            <?php if ($group10 > 20){ ?>
                                                <option value="10" disabled="disabled">10</option>
                                            <?php } else { ?>
                                                <option value="10">10</option>
                                            <?php } ?>
                        <?php if ($group11 > 20){ ?>
                                                <option value="11" disabled="disabled">11</option>
                                            <?php } else { ?>
                                                <option value="11">11</option>
                                            <?php } ?>
                        <?php if ($group12 > 20){ ?>
                                                <option value="12" disabled="disabled">12</option>
                                            <?php } else { ?>
                                                <option value="12">12</option>
                                            <?php } ?>
                                            <?php if ($group13 > 20){ ?>
                                                <option value="13" disabled="disabled">13</option>
                                            <?php } else { ?>
                                                <option value="13">13</option>
                                            <?php } ?>
                                            <?php if ($group14 > 20){ ?>
                                                <option value="14" disabled="disabled">14</option>
                                            <?php } else { ?>
                                                <option value="14">14</option>
                                            <?php } ?>
                        <?php if ($group15 > 20){ ?>
                                                <option value="15" disabled="disabled">15</option>
                                            <?php } else { ?>
                                                <option value="15">15</option>
                                            <?php */ ?>
                                       </select></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">Arisan</td>
        <td>&nbsp;
            <input name="radio" id="radio5" type="radio" value="6" />
        5x
        <input name="radio" id="radio7" type="radio" value="8" />
        <input type="hidden" name="intcicilan" id="radio_hide" class="radio_hide" value="">
          7x</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                              <td>&nbsp;</td>
                                  <input type="hidden" id="jumlahbrgfree">
                                </tr>
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="116">&nbsp;Silahkan ketik</td>
                                                <td width="349">&nbsp;Nama Barang</td>
                                                <td width="82">Harga</td>
                                                <td width="86" rowspan="3"><div id="data">
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
                                    <td>Uang Muka</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="um" id="um" readonly="readonly"/><br /></td>
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
                                        <input type="hidden" name="intuangmuka2" id="intuangmuka2"/>
                                        <input type="hidden" id="id_wilayah" value="<?php echo $intid_wilayah;?>" />
                                        
                                        
                                        <input type="hidden" name="intcicilanhide" id="intcicilanhide" value="0"/>
                                        <input type="hidden" name="intuangmukahide" id="intuangmukahide" value="0"/>                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="intpv" id="intpv"  readonly="readonly"/>
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
                                    <td>Rp.<input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();" onkeypress="return isNumberKey(event)"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();" onkeypress="return isNumberKey(event)"/></td>
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
        var d = parseInt(document.getElementById('totalbayar1').value);
        var t = a + b + c;
        var sisa = d - t;
        document.getElementById('intsisa').value = formatAsDollars(-sisa);
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
    $('input[type=submit]').attr('disabled', 'disabled');
    });

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


    var idx = 1;
    var idx10 = 1;
    var idx20 = 1;
    var idxf=1;
    $('#addBrg').bind('click', function(e){
        if($('#radio_hide').val()==""){
            alert('Anda Belum Memilih Jenis Arisan!');
        
        }else if(($(".id1").val()=="") &&($(".frees").val()=="")){
            alert('Anda belum memilih barang!');

            
        }else if($('.id1').val() != "")
            {
            var arisan = parseInt($('#radio_hide').val());
            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var id_barang =  $('#id_barang').val();
            var pv =  $('#pv').val();
            var total = (jumlah * harga);
            var r5 =$('#radio5')
            var r7 =$('#radio7')
            var c1 =$('#intc_1').val();
            var um = $('#intuang_muka').val();
            var cicil = $('#intcicilan').val();
            
            var out = '';
        var nomor_nota = $('#nomor_nota').val();
            out += 'Banyaknya<br>';
            if($("#chkBox20").attr('checked') == true){
                out += '<input type="hidden"  id="hit20" name="hit20[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
            }

            else if($("#chkBox10").attr('checked') == true){
                out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
            }
            else if($("#chktulip30_10").attr('checked') == true){ //promo30komisi10
				
				/* fahmibaru2030 */ 
				/* ikhlastambahin */
				if($("#chktulip30_10").attr("checked") == true){
				
					// harga = harga * 0.7;
					harga =  Math.ceil(harga * 0.7);
					um =  Math.ceil(um * 0.7); //uang muka
					cicil=  Math.ceil(cicil * 0.7); // cicilan
					pv	=	(parseFloat(pv) * 0.7).toFixed(2); 
				}
				
			
                out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                out += '<input type="hidden" id="hit10" name="hit10[]" value="'+idx+'">';
            }
            else{
                out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
            }




            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="2" value="'+harga+'" readonly>';
            out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" class="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
                       
            out += '<input id="um_'+idx+'" name="barang['+idx+'][intuang_muka]" type="hidden" size="1" value="'+um+'">&nbsp;<input id="cicil_'+idx+'" name="barang['+idx+'][intcicilan]" type="hidden" size="1" value="'+cicil+'">&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
            out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
            out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
            idx10++;
            idx20++;
           
            $('.id1').val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            $('#pv').val('');
            $('#intuang_muka').val('');
            $('#intcicilan').val('');

            /*if($("#chkBox20").attr('checked') == true){
                count = document.getElementsByName("hit20[]").length;
                var textpromo20 = parseInt($("#txtpromo20").val());
                
                if(count >= textpromo20){
                    $('#addBrg').attr('disabled', 'disabled');
                    $('.id1').attr('disabled', 'disabled');
                    $('.frees').attr('disabled', 'disabled');
                }else{
                    $('#addBrg').removeAttr('disabled');
                    $('.id1').removeAttr('disabled');
                }
            }

           
        }

        if($("#chkBox10").attr('checked') == true){
            var count = document.getElementsByName("hit10[]").length;
            var count_free = document.getElementsByName("hitfree10[]").length;
            var textpromo10 = parseInt($("#txtpromo10").val());
            var tt = textpromo10 * 2;

            if(count == tt){
                $('#addBrg').attr('disabled', 'disabled');
                $('.id1').attr('disabled', 'disabled');
                $('.frees').attr('disabled', 'disabled');

            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');

            }
            if(count_free == textpromo10){
                $('#addBrg').attr('disabled', 'disabled');
                $('.frees').attr('disabled', 'disabled');
                $('.id1').attr('disabled', 'disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.frees').removeAttr('disabled');
                $('.id1').attr('disabled', 'disabled');
            }*/
			
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
                    out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                }else if($("#chkBox20").attr('checked') == true){
                    out += '<input type="hidden" id="hitfree20" name="hitfree20[]" value="'+idx+'">';
                    out += '<input id="'+idx+'" class="free20_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                }else if($("#chkBoxFree").attr('checked') == true){
                    out += '<input type="hidden" id="hitonefree" name="hitonefree[]" value="'+idxf+'">';
                    out += '<input id="'+idxf+'" class="freeone_'+idxf+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                }else if($("#chkBoxFreeHut").attr('checked') == true){
                    out += '<input type="hidden" id="hitonefreehut" name="hitonefreehut[]" value="'+idxf+'">';
                    out += '<input id="'+idxf+'" class="freeonehut_'+idxf+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                }else{
                    out += '<input id="'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)"  />&nbsp;';
                }
                out += '<input name="barang['+idx+'][intid_barang]" type="text" size="30" value="'+brg+'"  />';
                out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="2" value="'+harga+'" readonly>';
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="8" value="0" readonly>';
                out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="3" value="'+total+'" readonly>';
                out += '<input name="barang_free['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
                out += '<input type="hidden" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
                        out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()">hapus</a> ';
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
        if($("#chkBox10").attr('checked') == true){
            var cs2 = document.getElementsByName("hitfree10[]").length;
            var textpromo10 = parseInt($("#txtpromo10").val());
            for(var i=cs2+1; i<= parseInt(id);i++){
                var jumlahfree = parseInt($('.free_'+ i).val());
                jf = jf + jumlahfree;
                if(jumlahfree >= 0){
                        if(jumlahfree > textpromo10){
                            alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
                            break;
                        }
        
                        if(jumlahfree >= textpromo10){
                            $('#addBrg').attr('disabled', 'disabled');
                            $('.frees').attr('disabled', 'disabled');
                            break;
                        }else{
                            $('#addBrg').removeAttr('disabled');
                            $('.frees').removeAttr('disabled');
                            break;
                        }
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
            //alert(cs2);
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
            var cs2 = parseInt($('#hitonefree').val());

            var txtfree = parseInt($("#txtfree").val());
            for(var i=cs2; i<= parseInt(id);i++){
                var jumlahfree = parseInt($('.freeone_'+ i).val());

                jf = jf + jumlahfree;

            }
            

            if(jf > txtfree){
                alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
               
            }

            if(jf >= txtfree){
                $('#addBrg').attr('disabled', 'disabled');
                $('.frees').attr('disabled', 'disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.frees').removeAttr('disabled');
            }
        }

        if($("#chkBoxFreeHut").attr('checked') == true){
            var cs2 = parseInt($('#hitonefreehut').val());

            var txtfreehut = parseInt($("#txtfreehut").val());
            for(var i=cs2; i<= parseInt(id);i++){
                var jumlahfree = parseInt($('.freeonehut_'+ i).val());
                jf = jf + jumlahfree;

            }
            
            if(jf > txtfreehut){
                alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
               
            }

            if(jf >= txtfreehut){
                $('#addBrg').attr('disabled', 'disabled');
                $('.frees').attr('disabled', 'disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.frees').removeAttr('disabled');
            }
        }
    }


    function kali(id){
        var jml=0;
        var pivi=0;
        var UC=0;
        var totaldua=0;
        var total=0;
        var jum=0;
        var jmlpv=0;
        var j=0;
        var jumcicil=0;
        var jumum=0;
        var arisan = parseInt($('#radio_hide').val());
        var limit20 = $('#txtpromo20').val();
        var limit10 = parseInt($('#txtpromo10').val());
        $("#del"+id).remove();
       //kode ikhlas
        //pengecekan pembatasan dari total harga barang Arisan
        list = idx;
        totalTemp = 0;
        //alert('list : '+list);
        for(i=0;i < list;i++){
            //eval(type1) * eval(type2)
            cek = $('#total_'+i).val();
            if(cek == null){
                //alert('gagal ini '+i);
            }else{
                totalTemp = eval(totalTemp) + ( eval($('#'+i).val()) * eval($('#harga_'+i).val()));
                //alert('totalTemp : '+totalTemp);
            }
        }
        arisan_rules = false;
		/*
		// diperbaiki lagi 2014 04 29
		
        if($("#radio5").attr('checked') == true){  
            if(totalTemp > 625000){
               // alert('Cicilan Arisan tidak boleh lebih dari Rp.625.000 ');
                $('#'+id).val(0);
            }else if(totalTemp >= 100000){
               arisan_rules = true;
            }else{
              //  alert('Cicilan Arisan Minimal Rp.100.000 ');            
            }
        }
        if($("#radio7").attr('checked') == true){  
            if(totalTemp > 3698000){
             //   alert('Cicilan Arisan tidak boleh lebih dari Rp.3.698.000 ');
                $('#'+id).val(0);
            }else if(totalTemp >= 1088000){
                arisan_rules = true;
            }else{
             //   alert('Cicilan Arisan Minimal Rp.1.088.000 ');          
            }
        }
		*/
        arisan_rules = true;
        ////end kode ikhlas
    if($("#chkBox20").attr('checked') == true){
        //009
            $('#intcicilanhide').val(0);
            var hasilcicilan=0;
            
            
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
            var UA=0;
            for(var i=1; i <= parseInt(id);i++){

                var jumlah = parseInt($('.duapuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                var ucil  = parseInt($('#cicil_' + i).val());
                var umuk  = parseInt($('#um_' + i).val());
                if(jumlah > 0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;
                        jumcicil = jumcicil+ucil;
                        jumum = jumum+umuk;
                        UA = UA + umuk; 
                        hasilcicilan += (parseInt(ucil) * parseInt(jumlah));
                        //alert('jumcicil : '+jumcicil);
                }
            }
  
            $('#intuang_muka').val(jml*UA);
            $("#um").val(formatAsDollars(jml*UA));
            $('#jumlahbrg20').val(jml);
            $('#intcicilanhide').val(jumcicil);
            
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

           /* if($('#intcicilanhide').val() != ""){
                var inc = parseInt($('#intcicilanhide').val());
                var sc = inc + jumcicil;
            }else{
                var sc = inc;
            }

            $('#intcicilanhide').val(sc);*/

            if($('#intuangmukahide').val() != ""){
                var inu = parseInt($('#intuangmukahide').val());
                var sm = inu + jumum;
            }else{
                var sm = inu;
            }

            //$('#intuangmukahide').val(sm*jml);
            
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

            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);
            
            var total = parseInt($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi20 = (((total * disc) / 100)/arisan);
            $('#komisi2').val(formatAsDollars(komisi20));
            $('#komisi2hidden').val(komisi20);
            
             var omset = harga*jumlah/arisan;
            $('#intjumlah2').val(formatAsDollars(omset));
            $('#intjumlah2hidden').val(omset);
        //009   
            $('#intuangmukahide').val(jml*UA);
            $('#intcicilanhide').val(hasilcicilan);
        

        }  else if($("#chkBox10").attr('checked') == true){
            
            $('#intcicilanhide').val(0);
            var hasilcicilan=0;
            
            var csfree = parseInt($('#hit10').val());
            var tt = limit10 * 2;
            
            var UB=0;
            var ju=0;
            for(var i=parseInt(csfree); i<= parseInt(id);i++){
                var ucil  = parseInt($('#cicil_' + i).val());
                var umuk  = parseInt($('#um_' + i).val());
                
                var jumlah = parseInt($('.sepuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                var pv = parseFloat($('#pv_' + i).val());
                //test
                var cicil= parseFloat($('#cicil_' + i).val());
                //end test
                if(jumlah >= 0){

                    if(harga >= 0){

                       var tot = jumlah * harga;
                            $('#total_' + i).val(tot);
                            total += tot;
                            j += jumlah;
                            ju = ju + jumlah;
                            jumcicil = jumcicil+ucil;
                            jumum = jumum+umuk;
                            UB=UB+umuk;
                            hasilcicilan += (parseInt(ucil) * parseInt(jumlah));
                        }
                }

            }
            $('#intuang_muka').val(j*umuk);
            //$('#intuangmukahide').val(j*umuk);
            $('#intcicilanhide').val(j*ucil);
            
            var sm = parseInt($('#intuangmukahide').val());
            $("#um").val(formatAsDollars(j*umuk));
            
            $('#jumlahbrg10').val(j);
            
            if(jumlah > tt){
                alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
            }
            
            if(j >= tt){
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
            $('#intjumlah1').val(formatAsDollars(total10/arisan));
            $('#intjumlah1hidden').val(total10/arisan);
            var total = parseInt($('#intjumlah1hidden').val());
            var disc = 10;
            var komisi =(((total10 * disc) / 100)/arisan);

            if($('#komisi1hidden').val()!=""){
                var totkom = komisi;
                $('#komisi1hidden').val(totkom);
                $('#komisi1').val(formatAsDollars(totkom));
            }else{
                $('#komisi1hidden').val(komisi);
                $('#komisi1').val(formatAsDollars(komisi));
            }
            
            /*if($('#intcicilanhide').val() != ""){
                var inc = parseInt($('#intcicilanhide').val());
                var sc = inc + jumcicil;
            }else{
                var sc = inc;
            }

            $('#intcicilanhide').val(sc)
            /*if($('#intuangmukahide').val() != ""){
                var inu = parseInt($('#intuangmukahide').val());
                alert(inu);
                alert(jumum);
                var sm = inu + jumum;
                //var sm = jumum;
            }else{
                var sm = inu;
            }*/

            //$('#intuangmukahide').val(sm*j);
            //$('#intuangmukahide').val(sm);
            $('#intuangmukahide').val(j*umuk);
            $('#intcicilanhide').val(hasilcicilan);
                   
        } else if($("#chktulip30_10").attr('checked') == true){
            
            $('#intcicilanhide').val(0);
            var hasilcicilan=0;
            
            var csfree = parseInt($('#hit10').val());
            var tt = limit10 * 2;
            
            var UB=0;
            var ju=0;
            for(var i=parseInt(csfree); i<= parseInt(id);i++){
                var ucil  = parseInt($('#cicil_' + i).val());
                var umuk  = parseInt($('#um_' + i).val());
                
                var jumlah = parseInt($('.sepuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                var pv = parseFloat($('#pv_' + i).val());
                //test
                var cicil= parseFloat($('#cicil_' + i).val());
                //end test
                if(jumlah >= 0){

                    if(harga >= 0){

                       var tot = jumlah * harga;
                            $('#total_' + i).val(tot);
                            total += tot;
                            j += jumlah;
                            ju = ju + jumlah;
                            jumcicil = jumcicil+ucil;
                            jumum = jumum+umuk;
                            UB=UB+umuk;
                            hasilcicilan += (parseInt(ucil) * parseInt(jumlah));
                        }
                }

            }
            $('#intuang_muka').val(j*umuk);
            //$('#intuangmukahide').val(j*umuk);
            $('#intcicilanhide').val(j*ucil);
            
            var sm = parseInt($('#intuangmukahide').val());
            $("#um").val(formatAsDollars(j*umuk));
            
            $('#jumlahbrg10').val(j);
            
            if(jumlah > tt){
                alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
            }
            
            if(j >= 999){
                $('#addBrg').removeAttr('disabled');
                $('.id1').attr('disabled', 'disabled');
                $('.frees').removeAttr('disabled');
                
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
                $('.frees').attr('disabled', 'disabled');
            }

            if($("#chktulip30_10_voucher").attr('checked') == true){
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
            $('#intjumlah1').val(formatAsDollars(total10/arisan));
            $('#intjumlah1hidden').val(total10/arisan);
            var total = parseInt($('#intjumlah1hidden').val());
            var disc = 10;
            var komisi =(((total10 * disc) / 100)/arisan);

            if($('#komisi1hidden').val()!=""){
                var totkom = komisi;
                $('#komisi1hidden').val(totkom);
                $('#komisi1').val(formatAsDollars(totkom));
            }else{
                $('#komisi1hidden').val(komisi);
                $('#komisi1').val(formatAsDollars(komisi));
            }
            
            /*if($('#intcicilanhide').val() != ""){
                var inc = parseInt($('#intcicilanhide').val());
                var sc = inc + jumcicil;
            }else{
                var sc = inc;
            }

            $('#intcicilanhide').val(sc)
            /*if($('#intuangmukahide').val() != ""){
                var inu = parseInt($('#intuangmukahide').val());
                alert(inu);
                alert(jumum);
                var sm = inu + jumum;
                //var sm = jumum;
            }else{
                var sm = inu;
            }*/

            //$('#intuangmukahide').val(sm*j);
            //$('#intuangmukahide').val(sm);
            $('#intuangmukahide').val(j*umuk);
            $('#intcicilanhide').val(hasilcicilan);
                   
        }
        else{
            $('#intcicilanhide').val(0);
            var hasilcicilan=0;
            
            var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){
                var ucil  = parseInt($('#cicil_' + i).val());
                var umuk  = parseInt($('#um_' + i).val());
                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                var uangmuka = parseInt($('#um_' + i).val());
                if(jumlah > 0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
                    var jmlum = jumlah * uangmuka;
                    jum += jmlum;
                    jumum = jumum+umuk;
                    jumcicil = jumcicil+ucil;
                    j = j+jumlah;
                    UC = UC + umuk;
                    hasilcicilan += (parseInt(ucil) * parseInt(jumlah));
                }
            }
            
            
            $("#um").val(formatAsDollars(jum));
            $('#intjumlah2').val(formatAsDollars(total/arisan));
            $('#intjumlah2hidden').val(total/arisan);
            
            $('#komisihide').val(total);

            var t = parseInt($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi = (total * disc) / 100 / arisan;
            $('#komisi2').val(formatAsDollars(komisi));
            $('#komisi2hidden').val(komisi);
            /*
            if($('#intcicilanhide').val() != ""){
                var inc = parseInt($('#intcicilanhide').val());
                var sc = inc + jumcicil;
            }else{
                var sc = inc;
            }
            */
            //$('#intcicilanhide').val(sc);
            $('#intcicilanhide').val(hasilcicilan);
            $('#intuangmukahide').val(jum);
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
        
        $('#intpv').val(formatNumber(pivi/arisan));
            
            
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

        
        if($('#komisi1hidden').val() != ""){
           var kom1 = parseInt($('#komisi1hidden').val());
           var totals = parseInt($('#intuangmukahide').val()) - kom1;
        }else{
       
           var kom2 = parseInt($('#komisi2hidden').val());
           var totals = parseInt($('#intuangmukahide').val()) - kom2;
        }
        
        $('#totalbayar').val(formatAsDollars(totals));
        $('#totalbayar1').val(totals);
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='intuang_muka' name='intuang_muka' value='" + ui.item.value5 + "' size='15' readonly='readonly'/><input type='hidden' id='intcicilan' name='intcicilan' value='" + ui.item.value6 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
            );
            },
        });

    }


    //check the checkbox
    $("#chkBoxTrade").click(function(){
        tradein();
        if($("#chkBoxTrade").attr('checked') == true){
            $("#komisitrade").attr("disabled","");
        }else if($("#chkBoxTrade").attr('checked') == false){
            document.frmjual.komisitrade.disabled = true;
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
        }
    });

    
    $("#chkBox20").click(function(){
        autoComp();
    $("#chkBox10").attr("checked",false);
    $("#txtpromo10").val("");
    $("#txtpromo20").val("");
    $("#txtpromo10").attr("disabled","disabled");
    $("#chkV10").attr("checked",false);
    $("#chkV10").attr("disabled","disabled");
    if($("#chkBox20").attr('checked') == true){
            
            count = document.getElementsByName("hit20[]").length;
            var jmlbrg = parseInt($('#jumlahbrg20').val());
            var textpromo20 = parseInt($("#txtpromo20").val());
            $("#txtpromo20").attr("disabled","");
            $("#chkV20").attr("disabled","");
        }else{
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            $('.frees').attr('disabled', 'disabled');
            $("#txtpromo20").attr("disabled","disabled");
            $("#chkV20").attr("disabled","disabled");
            $("#jumlahbrg20").val(' ');
        }
    });

     $("#txtpromo20").keyup(function(){

            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
     });

    $("#chkBox10").click(function(){
        autoCompPromo10();
    $("#chkBox20").attr("checked",false);
    $("#txtpromo20").val("");
    $("#txtpromo10").val("");
    $("#txtpromo20").attr("disabled","disabled");
    $("#chkV20").attr("checked",false);
    $("#chkV20").attr("disabled","disabled");
        if($("#chkBox10").attr('checked') == true){
        var count = document.getElementsByName("hit10[]").length;
            var count_free = document.getElementsByName("hitfree10[]").length;
            var textpromo10 = parseInt($("#txtpromo10").val());
            var tt = textpromo10 * 2;
            var jmlbrg = parseInt($('#jumlahbrg10').val());
            $("#txtpromo10").attr("disabled","");
            $("#chkV10").attr("disabled","");
        }else{
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            $(".frees").attr("disabled","disabled");
            $("#txtpromo10").attr("disabled","disabled");
            $("#chkV10").attr("disabled","disabled");
            
        }
    });

     $("#txtpromo10").keyup(function(){

        
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
      

    });

    $("#chkBoxFreeHut").click(function(){
        hut();
        if($("#chkBoxFreeHut").attr('checked') == true){

            count = document.getElementsByName("hitfreehut").length;
            if(count >=1){
                $('#addBrg').attr('disabled', 'disabled');
                $('.id1').attr('disabled', 'disabled');
                $('.frees').removeAttr('disabled');
                
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
                $('.frees').attr('disabled', 'disabled');
                
            }
            
            $("#txtfreehut").attr("disabled","");
        }else{
            $("#txtfreehut").attr("disabled","disabled");
            $(".frees").attr("disabled","disabled");
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            
        }
    });

     $("#jumlahbrgfreehut").keyup(function(){

        var jmlbrg = parseInt($('#jumlahbrgfreehut').val());
        var limitfreehut = parseInt($("#txtfreehut").val());
        
        if(jmlbrg >= limitfreehut){
           $('#addBrg').attr('disabled', 'disabled');
                $('.id1').attr('disabled', 'disabled');
        }else{
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
        }

    });

    $("#chkBoxFree").click(function(){
        satufreesatu();
        if($("#chkBoxFree").attr('checked') == true){
            
                count = document.getElementsByName("hitfree").length;
                if(count >=1){
                    $('#addBrg').attr('disabled', 'disabled');
                    $('.id1').attr('disabled', 'disabled');
                    $('.frees').removeAttr('disabled');
                    
                }else{
                    $('#addBrg').removeAttr('disabled');
                    $('.id1').removeAttr('disabled');
                    
                }
            
            $("#txtfree").attr("disabled","");
        } else if($("#chkBoxFree").attr('checked') == false){
            $(".frees").attr("disabled","disabled");
            $("#txtfree").attr("disabled","disabled");
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            
            }

    });
     $("#jumlahbrgfree").keyup(function(){

        var jmlbrg = parseInt($('#jumlahbrgfree').val());
        var limitfree = parseInt($("#txtfree").val());
        
        if(jmlbrg >= limitfree){
           $('#addBrg').attr('disabled', 'disabled');
                $('.id1').attr('disabled', 'disabled');
        }else{
            $('#addBrg').removeAttr('disabled');
            $('.id1').removeAttr('disabled');
            $('.frees').removeAttr('disabled');
        }

    });


    function hut(){
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
            focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                function(event, ui) {
                $("#result1").html(
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='8' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });

    }

    function tradein(){

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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='8' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });

    }

    function satufreesatu(){
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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/>"
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
                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='8' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
            );
            },
        });


    }
    
    //for lain-lain 
    function lain(){
        var ur = "<?php echo base_url(); ?>penjualan/lookupBarangLain";

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
                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='8'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/><input type='text' id='intuang_muka' name='intuang_muka' value='" + ui.item.value5 + "' size='15' readonly='readonly'/><input type='hidden' id='intcicilan' name='intcicilan' value='" + ui.item.value6 + "' size='15' readonly='readonly'/>"
            );
            },
        });
    }

    $('#intid_jpenjualan').change(function()
    {
        if ($(this).attr('value')== 9)
        {
            var title = "Nota Penjualan Reguler";
           // $("#title").text(title);
            $("#komisitrade").attr("disabled","disabled");
            $("#chkBox20").attr("disabled","");
            $("#chkBox10").attr("disabled","");
            $("#chkBoxTrade").attr("disabled","disabled");
            $("#chkBoxFreeHut").attr("disabled","disabled");
            $("#chkBoxFree").attr("disabled","disabled");
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
            lain();
        }


    });
	
	/** ikhlas firlana   2014 09 10*/
	/* Promo30komisi10 */	
	
	function autoCompPromo30komisi10() {
	
		$(".id1").autocomplete({
                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang203030",  
                            dataType: 'json',
                            type: 'POST',
							data:  {
                                term: req.term,
                                state: 1,

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
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='status_free' name='status_free' value='" + ui.item.value8 + "' size='15' /><input type='hidden' id='intuang_muka' name='intuang_muka' value='" + ui.item.value5 + "' size='15' readonly='readonly'/><input type='hidden' id='intcicilan' name='intcicilan' value='" + ui.item.value6 + "' size='15' readonly='readonly'/>"
                    );

                    },
                });
	}
	/* end */

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


