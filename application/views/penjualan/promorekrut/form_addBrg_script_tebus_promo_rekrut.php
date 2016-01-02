<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
	{
		//alert("<?php echo $stat_bayar.", ".$stat_free.", ".$lookup_url.", ".$lookup_url_free;?>");
		$("#form_post").attr("action","<?php echo base_url(); ?>form_control_tebus/insertNotaRekrut");
		console.log("change #form_post action");
		console.log("update initialize form_addBrg_script");
		window.isiTitle					= $("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
		window.stat					= "bayar"; // {bayar, free}
		window.id_barang			= 0;
		window.id_barang_temp	= 0;
		window.id_destiny			= 0; // set default
		window.id_qty					= 0;
		window.intqtyid				= 0;
		window.stat_bayar 			= <?php echo $stat_bayar?>;
		window.stat_free				= <?php echo $stat_free?>;
		url									= "";
		window.nama_barang		=	false;
		window.url_bayar 			=	"<?php echo $lookup_url; ?>"; // set default
		window.url_free				=	"<?php echo $lookup_url_free?>";	 // set default
		var idPromo				= $('#intid_control_promo').val();
		var idPenj				= $('#intid_jpenjualan').val();
		var base_me		= "<?php echo base_url();?>";
		window.code		=	false;
		window.code1		=	false;
		 window.otherpersen		= 1;
		 window.omsettolbar		= 0;
		$(".nameBarang").bind("keyup",function()
		{	
			if(window.stat == "bayar") // status bayar
				{
					 url 	=	window.url_bayar;
				}
			if(window.stat == "free") // status free
				{
					url		=	window.url_free; 
				}
			 //console.log("url "+base_me+url);
			 $(".nameBarang").autocomplete(
			 {
				minLength: 5,
				source:
					function(req, add)
					{
						$.ajax(
						{
							url: base_me+url,
							dataType: 'json',
							type: 'POST',
							data: 
							{
								term				: req.term,
								id_barang		: window.id_barang,
								id_penjualan	: idPenj,
								pencarian		: window.pencarian,
								id_promo		: idPromo,
								id_destiny		: window.id_destiny,
								stat_bayar	: window.stat_bayar,
								stat_free 		: window.stat_free,
								code				: window.code,
								code1				: window.code1,
								intidcbg		: $('.intid_cabang').val(),
								nama_barang	:	window.nama_barang,
							},
							error:
								function(data)
								{
									alert("barang tidak tersedia. error:");
								},
							success:
								function(data)
								{
									if(data.response =="true")
									{
										add(data.message);
									}
									else if(data.response =="false")
									{
										alert("barang tidak tersedia. false:");
									}
								},
						});
					},	
				focus:
					function(event,ui) 
					{
						$(this).val($(this).val());
					},
				select:
					function(event, ui) 
					{
						$(".addBrgTampung").attr("disabled",false);
						temp = "<input type='hidden' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='id_jbarang' name='id_jbarang' value='" + ui.item.intid_jbarang + "' size='15' />";
						window.code					=	ui.item.code; // gagal tinggal chek dan dihapus
						window.code1					=	ui.item.code;
						window.id_barang_temp = ui.item.id; // id_barang
						window.isfreeT 				= ui.item.stat_free;
						if(window.stat == "bayar") // status bayar
							{
								window.id_barang = ui.item.id; // id_barang
								$("#resultPilihBarang").html(temp);
								window.nama_barang	=	$(".nameBarang").val();
								$("#resultPilihBarangFree").html("");
							}
						if(window.stat == "free") // status free
							{
								window.pencarian = ui.item.status_pencarian;
								$("#resultPilihBarangFree").html(temp);
							}
							$('#intid_jpenjualan').attr('disabled', true);
							getData();// get Data Barang				
					}
			 });
		});
	});
	//	proses pengechekan barang untuk perhitungan barang
	// Langsung diproses..
	function getData()
	{
		if(!isNaN($("#id_barang").val()))
		{
					window.count++;
					console.log("id_barang : "+$("#id_barang").val());
					var contpromo 			= $("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
					var ipenj 						= $("#intid_jpenjualan option[value='" + $("#intid_jpenjualan").val() +"'").text();
					var intid_barang					=	window.id_barang_temp; var intid_jpenjualan			=	0;
					var intpv								=	0;
					var nameBarang 				= "";
					var intid_harga				=	0;
					var intharga					=	0;
					var totalomset				=	0;
					var intharga10				=	0;
					var intharga15				=	0;
					var intharga20				=	0;
					var intno_nota				=	$(".nota_intno_nota").val();
					var diskon 						= window.diskon;
					var stat 						= window.stat;
					
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
						else
						{
							intharga20 = '0';
						}
						
						if (window.omset == 1){
							totalomset = $("#harga_barang").val();
						}
						else
						{
							totalomset = '0';
						}
					}
					if(!isNaN($("#id_jbarang").val()))
					{
						intid_jbarang = $("#id_jbarang").val();
					}
					if(!isNaN($("#pv").val())) //intid_jpenjualan untuk patokan parameter
					{
						if(window.pv == 1)
						{
							intpv = $("#pv").val();
						}
						else
						{
							intpv = '0';
						}
					}
					
					if(!isNaN($(".nameBarang").val()) || $(".nameBarang").val() != "") //nameBarang untuk patokan parameter
					{
						nameBarang = $(".nameBarang").val();
					}
					
					/**
					* Check tampung exists atau null
					*/
					$("#tampung").each(function()
					{
						if($(this).find(".tableTampung").html() == null)
						{
							//$("#tampung").html("<table id='data' class='tableTampung ' width='100%'><tr><th><?php if(isset($result[0]->stat_bayar)){echo $result[0]->stat_bayar." ";} ?><?php if(isset($result[0]->stat_free) and $result[0]->stat_free > 0){echo "Free ".$result[0]->stat_free;} ?></th></tr></table>");
							$("#tampung").html("<table id='data' class='tableTampung ' width='100%'><tr><th>&nbsp;Paket "+contpromo+"</th></tr></table>");
						}
					});
					//end.
					
					/*
					* digunakan jika akan menggunakan method GET
					var dataGet = "count="+window.count+"
						&idPromo="+idPromo+"
						&idPenj="+idPenj+"
						&isiPromo="+contpromo+"
						&isiPenjualan="+ipenj+"
						&intid_barang="+intid_barang+"
						&intid_jpenjualan="+intid_jpenjualan+"
						&nameBarang="+nameBarang+"
						&intid_harga="+intid_harga+"
						&intharga="+intharga+"
						&intomset10="+intharga10+"
						&intomset15="+intharga15+"
						&intomset20="+intharga20+"
						&intpv="+intpv+"
						&diskon="+diskon+"
						&intno_nota="+intno_nota+"
						&statusBarang="+stat); // variable yang digunakan untuk parameter promo
						*/
					$.ajax({
								url: "<?php echo base_url(); ?>control_promosi/promo_default",
								dataType: 'json',
								type: 'POST',
								data: 
								{
									count				:	window.count,
									idPromo				:	idPromo,
									idPenj				:	idPenj,
									isiPromo				:	contpromo,
									isiPenjualan			:	ipenj,
									intid_barang		:	intid_barang,
									intid_jpenjualan	:	intid_jpenjualan,
									nameBarang		:	nameBarang,
									intid_harga			:	intid_harga,
									intharga				:	intharga,
									intomset				:	totalomset,
									intomset10			:	intharga10,
									intomset15			:	intharga15,
									intomset20			:	intharga20,
									intpv					:	intpv,
									diskon				:	diskon,
									intno_nota			:	intno_nota,
									statusBarang		:	stat,
									intid_jbarang		:	intid_jbarang,
								},
								success:
									function(data)
									{
									   $.each(data, function(key, value)
									   {
											
											$(".tableTampung").prepend("<tr class='isiFormBarang'><td class='tdTampung '>"+value+"</td></tr>");
											resetPilihBarang();
										});	
									},
								});
				}
				else
				{
					alert("Silahkan Pilih Barang yang Benar!");
				}
				
	}
</script>