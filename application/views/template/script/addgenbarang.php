<script type="text/javascript">
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
									checkMember();
									},
					});
					
					

            });
	function checkMember()
	{
		$.ajax(
		{
			 url: "<?php echo base_url(); ?>probar/check_member_favourite",
			 type: 'POST',
			 data:{intid_dealer:$("#intid_dealer").val()},
			 beforeSend:
				function(){										
					$("#loadformBarang").html("<h3>Loading..</h3>");
					},
			success:
				function(data)
				{
					if(data == "0")
					{
						addGenBarang();
					}
					else
					{
						alert("Maaf sudah terdaftar. sebanyak "+data);
					$("#loadformBarang").html("");
					}
				},
		});
	}
	function addGenBarang(stat){
			 $.ajax({
			 url: "<?php echo base_url(); ?>probar/form_add_Barang",
			 type: 'POST',
			 data:{intid_control_promo:64, intid_jpenjualan:0},
			 beforeSend:
				function(){										
					$("#loadformBarang").html("<h3>Loading..</h3>");
					},
			success:
				function(data){
					$("#loadformBarang").html(data);
					if(stat == "true")
					{
						$('.nameBarang ').attr("disabled",false);
					}
					},
				});
			}

</script>