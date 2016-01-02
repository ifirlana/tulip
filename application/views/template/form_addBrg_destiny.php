<?php $this->load->view("template/script_hitungTotal");?>
<div class="message" style="background-color: white; padding:5px; border-radius:5px"> Jangan Lupa untuk <small>Click</small> <b>Tambah</b>. </div>
<table width="100%" id="data"  align="center">
		<tr>
			<td colspan="5" id="title-formAddBrg"><?php if(isset($result[0]->stat_bayar)){echo "Pilih <b>".$result[0]->stat_bayar." Barang </b>";}
			if(isset($result[0]->stat_free) and $result[0]->stat_free > 0){echo " Kemudian  pilih <b>".$result[0]->stat_free." Barang Kembali</b>.";} ?></td>
		</tr>
		<tr>
			<td width="116">Silahkan ketik</td>
			<td width="367">Nama Barang</td>
			<td width="87">Harga</td>
			<td width="63" rowspan="2">
				<div id="data" class="statusBarang">
					<input type="hidden" class="addBrgTampung" name="addBrg" value="Tampung" disabled />
					&nbsp;
					Bayar
				</div>
			</td>
  </tr>
		<tr id="formAddBrg">
			<td>Pilih Barang </td>
			<td><input type="text" name="" class="nameBarang"  style="width:100%;" disabled/></td>
			<td><div id="resultPilihBarang"></div><div id="resultPilihBarangFree"></div></td>
		</tr>
</table>
<div>
<div id="tampung" style="padding:8px 0 8px 0;background-color:yellow;border-radius:4px;">
	<!-- tampung-->
</div>
<div id="addBarang" style="width:100%; margin-left: auto; margin-right: auto; border:1px solid black;">
		<!-- <input type="button" class="addBrg" name="addBrg" value="Tambah" style="width:100px; height:50px; "/> -->
		<input type="button" class="addBrg" name="addBrg" value="Tambah" style="width:100px; height:50px; background-color:#A7C942;  color:#FFF; border-radius: 25px; font-family: 'tahoma';">
</div>
<script>
	$(document).ready(function()
	{
		window.isiTitle					=	$("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
		window.stat					=	"bayar"; // {bayar, free}
		window.id_barang			=	0;
		window.id_barang_temp	=	0;
		//window.id_destiny			=	window.id_destiny; // set default
		url									=	"";
		window.url_bayar				=	window.lookup_url_bayar; 	// set default
		window.url_free				=	window.lookup_url_free;	// set default
		window.kelipatan				=	1; // set kelipatan
		window.status_destiny		=	false; //{false, true}
		var idPromo			=	$('#intid_control_promo').val();
		var idPenj				=	$('#intid_jpenjualan').val();
		var base_me			=	"<?php echo base_url();?>";
		window.code			=	0;
		window.otherpersen	=	1;
		window.omsettolbar	=	0;
		window.stat_bayar	=	window.isbayar;
		window.stat_free		=	window.isfree;
		window.first_choose		=	true;
		window.batasBarangTerpilih	=	0;
		
		$(".nameBarang").bind("keypress",function()
		{
			if(window.stat == "bayar") // status bayar
			{
				 url 	=	window.url_bayar;
			}
			if(window.stat == "free") // status free
			{
				 url	=	window.url_free; 					
			}
			
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
								stat_bayar		: window.stat_bayar,
								stat_free 		: window.stat_free,
								code				: window.code,
								intidcbg			: $('.intid_cabang').val(),
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
						if(window.stat == "bayar") // status bayar
						{
							window.id_barang = ui.item.id; // id_barang
							$("#resultPilihBarang").html(temp);
							$("#resultPilihBarangFree").html("");
						}
						if(window.status_destiny == true) //jika status destiny belum bisa dilakukan
						{
							window.stat_bayar = ui.item.stat_bayar;
							window.stat_free = ui.item.stat_free;
							window.id_destiny = ui.item.id_destiny;
							console.log("stat_barang1 "+window.stat_bayar);
							console.log("stat_barang2 "+window.stat_free);
							console.log("id_destiny "+window.id_destiny);
							$("#title-formAddBrg").html("Pilih "+window.stat_bayar+" Barang Kemudian pilih "+window.stat_free+" Barang Berikutnya");
						}
						classControl(window.id_destiny,"classControllDestiny");
						getData();		
						$(".nameBarang").attr("disabled",true);
					},
			});
			
			removeStat("bayar"); //melakukan pembatalan pengubahan kuantity
		});
		
		$(".intqty").live("keyup",function()
		{
			hitungBarisTampung();
		});
		
		//
		$(".addBrg").bind("click",function()
		{
			
			$("#tampung").each(function()
			{
				$(this).find(".is_voucher").attr("disabled",true);
				$(this).find(".intqty").attr("readonly",true);
				$(this).find(".totalomset").attr("readonly",true);
				$(this).find(".intqty").removeAttr("onkeyup","keyupDefault(this.id)");
				$(this).find(".intqty").attr("onkeyup","baris(this.id)");
				
				$(".tableTampung").prepend("<tr><td><label class='hapusPaketForm myButton'>Hapus</label></td></tr>");//hapus											
				$(this).find("#data").removeClass("tableTampung");
				$(this).find(".hapusBarisForm").remove();
				$(this).find(".intqty").removeClass("bayar");
				$(this).find(".intqty").removeClass("free");
				$(this).find("#data").prependTo("#formBarang");
				
			});
		});
	});
	
	//
	function hitungBarisTampung()
	{
		var barang1						= 0;
		var barang2 						= 0;
		var tempBarisTampung			= 0;
		
		$(".tdTampung").each(function()
		{ 
			//hitung jumlah barang barang1 dan  barang2
			if(isNaN($(this).find(".bayar").val()))
			{
				barang1 += parseInt(0);
			}else
			{
				barang1 += parseInt($(this).find(".bayar").val());
			}			
		});
		
		tempBarisTampung = parseInt(barang1 / window.stat_bayar) * window.kelipatan; //hitung multiply
		
		console.log("tempBarisTampung "+tempBarisTampung);
		
		if(tempBarisTampung > 1)
		{
			alert("Memilih jumlah barang harus 1 "); //temporary
		}
		
		if(window.first_choose == true) //pertama kali memilih
		{
			window.status_destiny	= true;
			window.first_choose = false;
			window.kelipatan = tempBarisTampung * window.stat_free;
			
			console.log("Silahkan memilih barang berikutnya sebanyak "+window.kelipatan+"x "+window.first_choose+". :F");				
			window.batasBarangTerpilih = window.kelipatan;
			removeStat("bayar"); //melakukan pembatalan pengubahan kuantity
		}
		else if(window.first_choose == false) //pemilihan barang berikutnya
		{
			temp_1 						= window.kelipatan * window.stat_free;
			
			if(temp_1 == tempBarisTampung && window.batasBarangTerpilih == tempBarisTampung
			)
			{
				window.status_destiny	= true;
				console.log("Silahkan memilih barang berikutnya sebanyak "+temp_1+" x "+window.first_choose+".");window.batasBarangTerpilih = temp_1;			
			}
			else if(window.batasBarangTerpilih < tempBarisTampung)
			{
				$(".tdTampung").each(function()
				{ 
					$(this).find(".bayar").val(0);							
				});
				console.log("barang melewati batas pilihan "+window.batasBarangTerpilih+" "+tempBarisTampung);
				alert("Memilih jumlah barang harus 1 "); //temporary
			}
			else
			{
				var check	=	temp_1 - tempBarisTampung;
				console.log("Pilih Lagi "+check);
			}
		}
		/*
		if(parseInt(tempBarisTampung) > 0)
		{
			window.kelipatan 		= tempBarisTampung;
			if(window.first_choose == false)
			{
				temp_1 						= window.kelipatan * window.stat_free;
				if(temp_1 == tempBarisTampung)
				{
					window.status_destiny	= true;
					console.log("Silahkan memilih barang berikutnya sebanyak "+temp_1+" x "+window.first_choose+".");			
				}
				else
				{
					var check	=	temp_1 - tempBarisTampung;
					console.log("Pilih Lagi "+check);
				}
			}
			else if(window.first_choose == true)
			{
				window.status_destiny	= true;
				window.first_choose = false;
				console.log("Silahkan memilih barang berikutnya sebanyak "+window.kelipatan+"x "+window.first_choose+". :F");				
				
				removeStat("bayar"); //melakukan pembatalan pengubahan kuantity
			}
		}
		else if(window.batasBarangTerpilih < tempBarisTampung)
		{
			$(".tdTampung").each(function()
			{ 
				$(this).find(".bayar").val(0);							
			});
			alert("barang melewati batas pilihan");
		}
		*/
		$(".nameBarang").removeAttr("disabled");			
	}
	// end..
	
	// @see removeStat
	// desc digunakan untuk melepas perhitungan data
	function removeStat(stat)
	{
		$("#tampung").each(function()
		{
			
			$(this).find(".intqty").attr("readonly",true);
			$(this).find(".intqty").removeClass(stat);
		});
	}
	// end removeStat.
	
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
						var intid_barang				=	window.id_barang_temp; //var intid_barang			= $("#id_barang").val();
						var intid_jbarang				=	0;
						var intid_jpenjualan			=	0;
						var intpv						=	0;
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
								$("#tampung").html("<table id='data' class='tableTampung ' width='100%'><tr><th>&nbsp;Paket "+contpromo+"</th></tr></table>");
							}
						});
						//end.

						$.ajax({
									url: "<?php echo base_url(); ?>control_promosi/promo_kondisi",
									dataType: 'json',
									type: 'POST',
									data: 
									{
										count				:	window.count,
									//	idPromo				:	idPromo,
									//	idPenj				:	idPenj,
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
											});
						
											resetPilihBarang();
										},
									});
					}
					else
					{
						alert("Silahkan Pilih Barang yang Benar!");
					}
	}
	// end..
	
	//
	function classControl( id_destiny,urls)
	{
		$.ajax(
					{
						url: "<?php echo base_url(); ?>form_control_penjualan/"+urls,
						type:'POST',
						data :
						{
							id_destiny:id_destiny,
						},
						dataType: 'json',
						cache:false,
						success:function(msg)
						{	
							if(msg.response == 'true' )
							{							
								console.log("Response",msg.response);
								window.kom10 		= msg.message.kom10;
								window.kom15 		=  msg.message.kom15;
								window.kom20 		=  msg.message.kom20;
								window.omset			=  msg.message.totomset;
								window.diskon	 		=  msg.message.diskon;
								window.pv 				=  msg.message.pv;
								window.isbayar		=  msg.message.stat_bayar;
								window.isfree			=  msg.message.stat_free;
								window.code			=	msg.message.code;
								console.log("kom10 ",window.kom10);
								console.log("kom15 ",window.kom15);
								console.log("kom20 ",window.kom20);
								console.log("omset ",window.omset);
								console.log("diskon ",window.diskon);
								console.log("pv ",window.pv);
								console.log("isbayar ",window.isbayar);
								console.log("isfree ",window.isfree);
								console.log("code ",window.code);
							}
						
						},
					});
	}
	// end..
	
</script>
<?php $this->load->view("template/script/scriptGenerateVoucher");?>