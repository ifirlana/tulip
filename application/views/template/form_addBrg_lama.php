<table width="100%" id="data" align="center">
		<tr>
			<td colspan="5"><b><span id="titlePromo">Promo Standart</span></b></td>
		</tr>
		<tr>
			<td width="116">Silahkan ketik</td>
			<td width="367">Nama Barang</td>
			<td width="87">Harga</td>
			<td width="63" rowspan="2">
				<div id="data">
					<input type="button" class="addBrg" name="addBrg" value="Tambah" disabled />
				</div>
			</td>
  </tr>
		<tr id="formAddBrg">
			<td>Pilih Barang </td>
			<td><input type="text" name="" class="nameBarang"  style="width:100%;" disabled/></td>
			<td><div id="resultPilihBarang"></div></td>
		</tr>
</table>
<div>
tampung
	<!-- tampung-->
</div>
<script>
	$(document).ready(function(){
	window.isiTitle=$("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
	
		$('#titlePromo').html(isiTitle);
		
		/* $(document).delegate('.nameBarang','keyPress', function (){
						if($(".nameBarang").val() == ''){
							$(".addBrg").attr("disabled",false);
						}else{
							$(".addBrg").attr("disabled",false);
						}
		}); */
		
		$(".nameBarang").autocomplete({
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
			$(this).val(q);
		    },
                    select:
                        function(event, ui) {
						$(".addBrg").attr("disabled",false);
                        $("#resultPilihBarang").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='text' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='text' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });
			
			//	proses pengechekan barang untuk perhitungan barang
			
			$(".addBrg").bind("click",function(){
				$(".addBrg").attr("disabled",true);
				if(!isNaN($("#id_barang").val())){
						window.count++;
						var contpromo = $("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
						var ipenj = $("#intid_jpenjualan option[value='" + $("#intid_jpenjualan").val() +"'").text();
						var idPromo = $('#intid_control_promo').val()
						var idPenj=$('#intid_jpenjualan').val();
						var intid_barang		= $("#id_barang").val();
						var intid_jpenjualan	=	0;
						var intpv					=	0;
						var nameBarang 		= "";
						var intid_harga			=	0;
						var intharga				=	0;
						var intharga10				=	0;
						var intharga15				=	0;
						var intharga20				=	0;
						var intno_nota				=	$(".nota_intno_nota").val();
						var diskon = window.diskon;
						if(!isNaN($("#intid_jpenjualan").val())) //intid_jpenjualan untuk patokan parameter
						{
							intid_jpenjualan = $("#intid_jpenjualan").val();
						}
						
						if(!isNaN($("#id_harga").val())) //intharga untuk patokan parameter
						{
							intid_harga = $("#id_harga").val();
						}
						
						if(!isNaN($("#harga_barang").val())) //intharga untuk patokan parameter
						{
							intharga = $("#harga_barang").val();
							if (window.kom10 == 1){
								intharga10 = $("#harga_barang").val();
							}
							else{
								intharga10 = '0';
							}
							if (window.kom15 == 1){
								intharga15 = $("#harga_barang").val();
							}
							else{
								intharga15 = '0';
							}
							if (window.kom20 == 1){
								intharga20 = $("#harga_barang").val();
							}
							else{
								intharga20 = '0';
							}
						}
						
						if(!isNaN($("#pv").val())) //intid_jpenjualan untuk patokan parameter
						{
							if(window.pv == 1){
							intpv = $("#pv").val();
							}else{
							intpv = '0';
							}
						}
						
						if(!isNaN($(".nameBarang").val()) || $(".nameBarang").val() != "") //nameBarang untuk patokan parameter
						{
							nameBarang = $(".nameBarang").val();
						}
						
						var dataGet = "count="+window.count+"&idPromo="+idPromo+"&idPenj="+idPenj+"&isiPromo="+contpromo+"&isiPenjualan="+ipenj+"&intid_barang="+intid_barang+"&intid_jpenjualan="+intid_jpenjualan+"&nameBarang="+nameBarang+"&intid_harga="+intid_harga+"&intharga="+intharga+"&intomset10="+intharga10+"&intomset15="+intharga15+"&intomset20="+intharga20+"&intpv="+intpv+"&diskon="+diskon+"&intno_nota="+intno_nota; // variable yang digunakan untuk parameter promo

						$.ajax({
									url: "<?php echo base_url(); ?>form_control_penjualan/form_check_promo",
									dataType: 'json',
									type: 'GET',
									data: dataGet,
									success:
										function(data){
									   $.each(data, function(key, value){
											
											$("#"+key).prepend(value);
											resetPilihBarang();
											});	
										},
									});
					}
					else
					{
						alert("Silahkan Pilih Barang yang Benar!");
					}
				});
				
		});
	<?php  $this->load->view("template/script_hitungTotal");?>
</script>