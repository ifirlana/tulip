<script>
	$(document).ready(function()
	{
		window.isiTitle					=	"STARTERKIT";
		window.stat						= "bayar"; // {bayar, free}
		window.id_barang				= 0;
		window.id_barang_temp	= 0;
		window.id_destiny				= 0; // set default
		
		window.id_qty					= 0;
		window.intqtyid					= 0;
		
		url									= "";
		window.nama_barang		=	"";
		window.url_bayar 				=	"lookup/lookupStarterkitTambahan"; // set default
		window.url_free				=	window.lookup_url_free;	 // set default
		var idPromo						= $('#intid_control_promo').val();
		var idPenj							= $('#intid_jpenjualan').val();
		var base_me					= "<?php echo base_url();?>";
		window.code					=	"";
		window.code1					=	"";
		window.otherpersen 			= 1;
		window.omsettolbar 		= 0;
		
		$(".nameBarang").attr("disabled",false);
		
		$(".nameBarang").bind("keypress",function()
		{
			
			if(window.stat == "bayar") // status bayar
				{
					 url 	=	window.url_bayar;
					
				}
			if(window.stat == "free") // status free
				{
					url	=	window.url_free; 
					console.log("Kode Barang",window.code1);
					
				}
			 
			$(".nameBarang").autocomplete(
			{
						minLength: 5,
						source:
							function(req, add){
							$.ajax({
								url: base_me+url,
								dataType: 'json',
								type: 'POST',
								data: {
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
									function(data){
									if(data.response =="true"){
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
						var q = $(this).val();
						$(this).val(q);
					},
				select:
					function(event, ui) 
					{
						$(".addBrgTampung").attr("disabled",false);
						temp = "<input type='hidden' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='id_jbarang' name='id_jbarang' value='" + ui.item.intid_jbarang + "' size='15' />";
						window.code				=	ui.item.code; // gagal tinggal chek dan dihapus
						window.code1				=	ui.item.code;
						window.id_barang_temp = ui.item.id; // id_barang
						
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
							window.accessible_jenis_penjualan = false;
					},
			});
		});
	});
</script>