<div id ="loadme" style="display:none; background:rgba(000, 000, 000, 0.9) !important;	position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 2000;">
	<div style="position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -50px;
    margin-left: -50px;
    font-size: 200%;
    color:white;
    ">	
		<i >please wait a moment. . .</i>
	</div>

</div>
<form method="POST" id="form_postM" action="<?php echo base_url();?>probar/InsertNota">
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
		<td><input type="text" name="textfield4" id="intid_unit" name="strnama_unit"  size="25"/></td>
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
										$("#loadme").fadeIn(500);
										},
								success:
									function(data){
										$("#loadme").fadeOut(500);
									if(data.response =="true"){
										
										add(data.message);
										}
									$("#loadformBarang").html('');
									
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
										$("#loadme").fadeIn(500);
										},
								success:
									function(data){
										$("#loadme").fadeOut(500);
										if(data.response =="true"){
												add(data.message);
											}
										$("#loadformBarang").html('');
										},
								});
							},
					focus:
						function(event,ui) {
							
							$(this).val($(this).val());
							},
                    select:
                        function(event, ui) {
							$("#result001").empty();
							$("#result001").append("<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='25' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='25' readonly/><input type='hidden' size='2' id='pengejaranChall' value='"+ui.item.challen+"' readonly><input type='hidden' size='2' id='is_promos' value='"+ui.item.promo+"' readonly><input type='hidden' size='2' id='pengejaranHut' value='"+ui.item.challhut+"' readonly><input type='hidden' size='2' name='intid_dealer' id='intid_dealer' value='"+ui.item.intid_dealer+"' readonly></td>");			
									//addGenBarang();
									},
					});

            });

</script>
 <div id="loadformBarang" style="min-height:300px;">
 </div>
 
 </form>