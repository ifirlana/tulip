<form method="POST" id="form_post" action="<?php echo base_url();?>form_control_penjualan/InsertNota">
<input type="hidden" name="token" value="<?php echo $setToken ?>">
<input type="hidden" class="intid_cabang" name="intid_cabang" value="<?php echo $intid_cabang?>" size="2" readonly />
<input type="hidden" class="intid_wilayah" name="intid_wilayah" value="<?php echo $wilayah?>" size="2" readonly />
<input type="hidden" class="intid_week" name="intid_week" value="<?php echo $intid_week?>" size="2" readonly />
<input type="hidden" class="tahun" name="tahun" value="<?php echo date("Y");?>" readonly />
<input type="hidden" class="halaman" name="halaman" value="Form Control" readonly />
<input type="hidden" class="datetgl" name="datetgl" value="<?php echo $datetgl?>" size="2" readonly />
 <table width="100%" border="0" id="data" align="center">
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
		<td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="25" disabled/></td>
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
		<td>No Nota</td>
		<td>
			<input type="text" class="nota_intno_nota" name="nota_intno_nota" value="<?php if(isset($intno_nota)){echo $intno_nota;}?>" size="13" readonly>
			<input type="hidden" class="temp_nota_intno_nota" value="<?php if(isset($intno_nota)){echo $intno_nota;}?>" size="13" readonly>
		</td>
		<!--
		<script>
			function check()
			{
				if(document.getElementById('jenis penjualan') && document.getElementById('jenis promo'))
				{
					ambil intid_dealer
					ambil kodevoucher
					ambil jenis promo
					ambil jenis penjualan
					ajax masuk ke database
						cek _voucher_product_redeem sudah ada nomor vouchernya atau tidak
							if tidak
								_voucher_product join nota cek intid_dealer = != cek jenis penjualan = != cek jenis promo = !=
								if return true
									masukin data productnya ke tdTampung
								else
									alert voucher harus digunakan untuk promosi dan jenis penjualan yg sama dengan nota sebelumnya
							else
								alert voucher ini sudah ditebus
				}
				else
				{
					alert pilih dulu jenis penjualan dan jenis promo
				}
			}
		</script>
		<input type="text" id="kodevoucher"><input type="button" onclick="check();">
		-->
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
 </table>
 <script>
	  $(document).ready( function() {
		  window.accessible_jenis_penjualan	=	true;
				$("#intid_unit").focus();
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
							$.ajax({
								url: "<?php echo base_url(); ?>penjualan/lookupUnit",
								dataType: 'json',
								type: 'POST',
								data: req,
								beforeSend:
									function(){										
										$("#loadformPenjualan").html("<h3>Loading..</h3>");
										},
								success:
									function(data){
									if(data.response =="true"){
										
										add(data.message);
										}
									$("#loadformPenjualan").html('');
									
									},
								});
							},
					focus:
						function(event,ui) {
							
							$(this).val($(this).val());
							},
                    select:
                        function(event, ui) {
							
							//$("#strnama_dealer").focus();
							$("#strnama_dealer").attr("disabled",false);
							$("#strnama_dealer").val("");
							$("#result001").empty();
							$("#result").empty();
							$("#result").append("<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />");
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
								beforeSend:
									function(){										
										$("#loadformPenjualan").html("<h3>Loading..</h3>");
										},
								success:
									function(data){
										if(data.response =="true"){
												add(data.message);
											}
										$("#loadformPenjualan").html('');
										},
								});
							},
					focus:
						function(event,ui) {
							
							$(this).val($(this).val());
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
							$("#result001").append("<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='25' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='25' readonly/><input type='hidden' size='2' id='pengejaranChall' value='"+ui.item.challen+"' readonly><input type='hidden' size='2' id='is_promos' value='"+ui.item.promo+"' readonly><input type='hidden' size='2' id='pengejaranHut' value='"+ui.item.challhut+"' readonly><input type='hidden' size='2' name='intid_dealer' id='intid_dealer' value='"+ui.item.intid_dealer+"' readonly></td>");			
							if(ui.item.value4 == 0) {$("#metal_1").removeAttr("disabled");} else {$("#track1").val(1);}
							if(ui.item.value5 == 0) {$("#metal_2").removeAttr("disabled");} else {$("#track2").val(1);}
							if(ui.item.value6 == 0) {$("#metal_3").removeAttr("disabled");} else {$("#track3").val(1);}
							if(ui.item.value7 == 0) {$("#metal_4").removeAttr("disabled");} else {$("#track4").val(1);}
							if(ui.item.value8 == 0) {$("#metal_5").removeAttr("disabled");} else {$("#track5").val(1);}
							if(ui.item.value9 == 0) {$("#metal_6").removeAttr("disabled");} else {$("#track6").val(1);}
							
							loadJenis(); //load jenis penjualan
									},
					});

            });
</script>
<?php 
		if(isset($script_loadJenis))
		{
			echo $script_loadJenis;
		}
		else
		{
	?>
<script>
	function loadJenis()
	{
		$.ajax({
			url: "<?php echo base_url(); ?>form_control_penjualan/form_jenis_penjualan",
			type: 'POST',
			data: {idcbg : $('.intid_cabang').val(),
						pengejaranChall : $("#pengejaranChall").val(),
						promo : $("#is_promos").val(),
						is_hut : $("#pengejaranHut").val(),
						},
			beforeSend:
				function(){										
					$("#loadformPenjualan").html("<h3>Loading..</h3>");
					},
			success:
				function(data){
					$("#loadformPenjualan").html(data);
					},
				});
	}				
 </script>
 <?php
			}
		?>			
 <div id="loadformPenjualan" style="min-height:300px;">
 </div>
 </form>