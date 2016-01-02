<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            //for unit
            $(document).ready( function() {
			$('#showResult').show();
            //$('#showResult').hide();
			$('.radio_pod').attr('checked',true);

					$('#1').attr('disabled', true);
					$('#2').attr('disabled', true);
					$('#3').attr('disabled', true);					
					$('#buttonsubmit').hide();
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
                        "<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='25' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='25' readonly/></td>"
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
			/**
			* button cekrekrut 
			* @param action click untuk memproses strkode_dealer untuk melakukan proses pencarian.
			*
			$('#cekrekrut').click(function() {
				$('#result1').html('');
				$('#result2').html('');
				
				var form_data = {
					strkode_dealer : $('#strkode_dealer').val(),
					ajax : '1'
				};
				$.ajax({					
					url: "<?php //echo base_url(); ?>penjualan/check_rekrut",
					type: 'POST',
					async : false,
					data: form_data,
					success:
						 function (data){
                         $("#message").html(data);
					},
				});
				//alert("total rekrut : "+$('#totalrekrut001').val()+"");				
				//pengecekan dilakukan untuk menentukan bisa readonly
				//$('#totalrekrut001').val(3);
				var queue = 0;		
				var temp = 0;	
				if(parseInt($('#totalrekrut001').val()) > 1 ){
				 
					$('#showResult').show();
					$('#1').val('');
					$('#2').val('');
					$('#3').val('');
					$('#1').attr('disabled', true);
					$('#2').attr('disabled', true);
					$('#3').attr('disabled', true);
					
					///bikin pengulangan
					//lakukan perbaikan
					
					for(var i = 0; i <= $('#totalrekrut001').val();i++){
						if($('#is_tebus_'+i).val() == 0){
							temp = temp + 1;
						}else if($('#is_tebus_'+i).val() == 1){
							queue = queue +1;
						}
					}
					//alert('temp dan queue .'+temp+', '+queue);
					
					if(temp == 2 && queue == 0 ){
						alert('Silahkan tebus barang rekrut 1!');
						$('#1').attr('disabled', false);
						$('#2').attr('disabled', true);
						$('#3').attr('disabled', true);
						$('#buttonsubmit').show();
					}else if(temp == 3 && queue == 0){
						alert('Silahkan tebus barang rekrut 1 dan 2!');
						$('#1').attr('disabled', false);
						$('#2').attr('disabled', false);
						$('#3').attr('disabled', true);
						$('#buttonsubmit').show();
					}else if(temp == 4 && queue == 0){
						alert('Silahkan tebus barang rekrut 1, 2, dan 3!');
						$('#1').attr('disabled', false);
						$('#2').attr('disabled', false);
						$('#3').attr('disabled', false);
						$('#buttonsubmit').show();
					}else if(temp == 1 && queue == 2){
						alert('Silahkan tebus barang rekrut 2!');
						$('#1').attr('disabled', true);
						$('#2').attr('disabled', false);
						$('#3').attr('disabled', true);
						$('#buttonsubmit').show();
					}else if(temp == 2 && queue == 2){
						alert('Silahkan tebus barang rekrut 2 dan 3!');
						$('#1').attr('disabled', true);
						$('#2').attr('disabled', false);
						$('#3').attr('disabled', false);
						$('#buttonsubmit').show();
					}else if(temp == 1 && queue == 3){
						alert('Silahkan tebus barang rekrut 3!');
						$('#1').attr('disabled', true);
						$('#2').attr('disabled', true);
						$('#3').attr('disabled', false);
						$('#buttonsubmit').show();
					}else{
						alert('barang rekrut sudah ditebus.');
						$('#1').attr('disabled', true);
						$('#2').attr('disabled', true);
						$('#3').attr('disabled', true);
					}

					
				}				
				return false;
        	});
				
            });
			*/
			/**
			* button cekrekrut 
			* @param action click untuk memproses strkode_dealer untuk melakukan proses pencarian.
			*/
			$('#cekrekrut').click(function() {
				$('#result1').html('');
				$('#result2').html('');
				//lakukan pengecekan radio button
				if($('.radio_pod').attr('checked') == true || $('.radio_mede').attr('checked') == true){				
					//pencarian kondisi paket 108 atau 215
					/*
					if($('#radio_id').val() == "pod"){
						var urlget = "<?php echo base_url(); ?>penjualan/check_rekrut_pod";
					}else if($('#radio_id').val() == "mede"){
						var urlget = "<?php echo base_url(); ?>penjualan/check_rekrut_mede";		
					}
					*/
					if($('.radio_pod').attr('checked') == true){
						var urlget = "<?php echo base_url(); ?>penjualan/check_rekrut_pod";
					}else if($('.radio_mede').attr('checked') == true){
						var urlget = "<?php echo base_url(); ?>penjualan/check_rekrut_mede";		
					}
					alert(urlget);
					var form_data = {
						strkode_dealer : $('#strkode_dealer').val(),
						ajax : '1'
					};
					$.ajax({					
						url: urlget,
						type: 'POST',
						async : false,
						data: form_data,
						success:
							 function (data){
							 $("#message").html(data);
						},
					});
					//alert("total rekrut : "+$('#totalrekrut001').val()+"");				
					//pengecekan dilakukan untuk menentukan bisa readonly
					//$('#totalrekrut001').val(3);
					var queue = 0;		
					var temp = 0;	
					if(parseInt($('#totalrekrut001').val()) > 1 ){
					 
						$('#showResult').show();
						$('#1').val('');
						$('#2').val('');
						$('#3').val('');
						$('#1').attr('disabled', true);
						$('#2').attr('disabled', true);
						$('#3').attr('disabled', true);
						
						///bikin pengulangan
						//lakukan perbaikan
						
						for(var i = 0; i <= $('#totalrekrut001').val();i++){
							if($('#is_tebus_'+i).val() == 0){
								temp = temp + 1;
							}else if($('#is_tebus_'+i).val() == 1){
								queue = queue +1;
							}
						}
						//alert('temp dan queue .'+temp+', '+queue);
						
						if(temp == 2 && queue == 0 ){
							alert('Silahkan tebus barang rekrut 1!');
							$('#1').attr('disabled', false);
							$('#2').attr('disabled', true);
							$('#3').attr('disabled', true);
							$('#buttonsubmit').show();
						}else if(temp == 3 && queue == 0){
							alert('Silahkan tebus barang rekrut 1 dan 2!');
							$('#1').attr('disabled', false);
							$('#2').attr('disabled', false);
							$('#3').attr('disabled', true);
							$('#buttonsubmit').show();
						}else if(temp == 4 && queue == 0){
							alert('Silahkan tebus barang rekrut 1, 2, dan 3!');
							$('#1').attr('disabled', false);
							$('#2').attr('disabled', false);
							$('#3').attr('disabled', false);
							$('#buttonsubmit').show();
						}else if(temp == 1 && queue == 2){
							alert('Silahkan tebus barang rekrut 2!');
							$('#1').attr('disabled', true);
							$('#2').attr('disabled', false);
							$('#3').attr('disabled', true);
							$('#buttonsubmit').show();
						}else if(temp == 2 && queue == 2){
							alert('Silahkan tebus barang rekrut 2 dan 3!');
							$('#1').attr('disabled', true);
							$('#2').attr('disabled', false);
							$('#3').attr('disabled', false);
							$('#buttonsubmit').show();
						}else if(temp == 1 && queue == 3){
							alert('Silahkan tebus barang rekrut 3!');
							$('#1').attr('disabled', true);
							$('#2').attr('disabled', true);
							$('#3').attr('disabled', false);
							$('#buttonsubmit').show();
						}else{
							alert('barang rekrut sudah ditebus.');
							$('#1').attr('disabled', true);
							$('#2').attr('disabled', true);
							$('#3').attr('disabled', true);
						}
						
					}				
					return false;
				}else{
					alert('please click any radio button!');
				}
        	});
				
            });
		function kali(id){
			//alert('id : '+id);
			/*
			if(id == 1){
				var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupSatu"; 
			}else if(id == 2){
				var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupDua"; 
			}else if(id == 3){
				var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupTiga"; 
			}*/
			for(var i = 1; i<= $('#totalrekrut001').val();i++){
				var harga1 = $('#harga_luarjawa_'+i).val();
				var harga2 = $('#harga_jawa_'+i).val();
				if(i == 2){
					if(harga1 == 118000 || harga2 == 108000){
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupSatu108";
					}else{
						
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupSatu";
					} 
				}else if(id == 2){
					if(harga1 == 118000 || harga2 == 108000){
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupDua108"; 
					}else{
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupDua"; 
					}
				}else if(id == 3){
					if(harga1 == 118000 || harga2 == 108000){
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupTiga108"; 
					}else{
						var ur = "<?php echo base_url(); ?>penjualan/lookupBarangGroupTiga"; 
					}
				}	
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
                $("#td"+id).append(
                 "<input type='hidden' id='harga_barang' name='harga_barang' value='0' size='5' readonly='readonly'/><input type='hidden' name='barang["+id+"][intid_barang]' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv_"+id+"' name='pv["+id+"][intpv]' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='harga_"+id+"' name='barang["+id+"][intid_harga]' value='" + ui.item.value7 + "' size='15' />done"
                );
            },
        });   
	}

        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">penjualan Tebus Rekrut Hadiah</h2>
                     <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/hadiah_rekrut" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td >&nbsp;<?php echo $cabang; ?>
                                        <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">
					<input type="hidden" id="intid_wilayah001" name="intid_wilayah001" size="30" readonly="readonly" value="<?php echo $id_wilayah; ?>">       </td>
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
                                    <td width="120">&nbsp;Nama</td>
                                    <td width="7">&nbsp;:</td>
                                    <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer"/ size="25"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;No Kartu<br /><br />
                                    &nbsp;Upline &nbsp;&nbsp;</td>
                                    <td>&nbsp;:</td>
                                    <td>&nbsp;<div id="result"></div><div id="result001"></div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;No. Nota</td>
                                  <td>&nbsp;
                                      <input type="text" name="intno_nota" size="20" value="<?php echo $max_id?>" readonly="readonly" /></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  <td align="left">Pilih Paket Rekrut</td>
                                  <td>:</td>
                                  <td><ul>
										<li style="list-style-type:none;margin:auto auto auto -30px;"><input type="radio" name="pilih_paket" id="radio_id" class="radio_pod" value="pod">PAKET POD</li>
										<li style="list-style-type:none;margin:auto auto auto -30px;"><input type="radio" name="pilih_paket" id="radio_id" class="radio_mede" value="mede">PAKET MEDE</li>
										</ul></td>
                                </tr>
								<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><input type="button" name="button" id="cekrekrut" value="Cek Rekrut" /><input type="hidden" name="is_lg" value="1"/> </td>
                                </tr>
                              </table>
</td>
                            </tr>
                            </table>
                       	<form method="post" action="<?php echo base_url()."/penjualan/save_nota_rekrut"?>">
						<div id="message"></div>
						<div id="showResult">
							<table>
							<tr>
								<td>Tebus Hadiah Rekrut 1 </td>
								<td><input type="text" name="strnama_barang_hadiah_1" id="1" size="50" class="id1" onkeyUp="kali(this.id)" /></td>
								<td id="td1"></td>
							</tr><tr>
								<td>Tebus Hadiah Rekrut 2 </td>
								<td><input type="text" name="strnama_barang_hadiah_2" id="2" size="50" class="id1" onkeyUp="kali(this.id)"/></td>
								<td id="td2"></td>
							</tr><tr>
								<td>Tebus Hadiah Rekrut 3 </td>
								<td><input type="text" name="strnama_barang_hadiah_3" id="3" size="50" class="id1" onkeyUp="kali(this.id)"/></td>
								<td id="td3"></td>
								</tr>
							</table>
							<div id="result1"></div>
							<div id="result2"></div>
								<input id='buttonsubmit' type='submit' name='submit' value='Tebus Barang' />
						</form>
						</div>
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
	</script>