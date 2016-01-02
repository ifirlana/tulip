<?php $this->load->view("template/script_hitungTotal");?>
<div class="message" style="background-color: white; padding:3px;"> INFO : Jangan Lupa Click  "Tambah"</div>
<table width="100%" id="data"  align="center">
		<tr>
			<td colspan="5"><b><?php if(isset($result[0]->stat_bayar)){echo $result[0]->stat_bayar." ";}
			if(isset($result[0]->stat_free) and $result[0]->stat_free > 0){echo "Free ".$result[0]->stat_free;} ?></b></td>
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
	function removeByrFre(){
		$("#tampung").each(function(){
			$(this).find(".intqty").removeClass("bayar");
			$(this).find(".intqty").removeClass("free");
			$(this).find(".intqty").attr("readonly",true);
			
		});
	}
	function modByr(){
			
			var byrbarus = 0;
		$(".tdTampung").each(function(){
			if(isNaN(parseInt($(this).find('.bayar').val())))
			{
				byrbarus += 0;
			}
			else
			{
				console.log("bayar "+$(this).find('.bayar').val());
				byrbarus += parseInt($(this).find('.bayar').val());
			}
		});
			if(  window.id_group_class!='0'){
			/* jika barang bayar tidak sama dengan 1 */
			if((byrbarus % window.isbayar) == 0){
				classControl($('#intid_control_promo').val(),$('#jpenjualans').val(),"classControllBaru");
				removeByrFre();
						/*hitungBarisTampung();
					$(".message").prepend("<p style='background-color:#FFB2B2;'>Warning : Barang Bayar Belum Selesai. </p>");
						*/
						exit();
				}
			}
	}
	$(document).ready(function()
	{
		console.log("update initialize");
		window.isiTitle=$("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text();
		window.stat			= "bayar"; // {bayar, free}
		window.id_barang	= 0;
		window.id_barang_temp	= 0;
		window.id_destiny	= 0; // set default
		window.bayar	=	0;
		window.id_qty	= 0;
		window.intqtyid	= 0;
		
		url							= "";
		window.nama_barang	=	"";
		window.url_bayar 	=	window.lookup_url_bayar; // set default
		window.url_free	=	window.lookup_url_free;	 // set default
		var idPromo			= $('#intid_control_promo').val();
		var idPenj				= $('#intid_jpenjualan').val();
		var base_me		= "<?php echo base_url();?>";
		window.code		=	"";
		window.code1		=	"";
		/* window.otherpersen = 0.05; */
		 window.otherpersen = 1;
		 window.omsettolbar = 0;
		$(".nameBarang").bind("keypress",function()
		{
			if(window.id_control_class_baru != 0){
				/*Perintah AJAX untuk lookup controll class baru ngambil rule yang ada
					Jika qty bayar sudah mencukupi dan id_control_class_baru bernilai > 0
					langsung kasih alert silahkan masukkin
					barang promo lanjutan
				*/
				if(window.lockNameBarang == true)
				{
					removeByrFre();
				}
			}
			
			if(window.stat == "bayar") // status bayar
				{
					 url 	=	window.url_bayar;
					/*
					// tidak digunakan untuk karena menggunakan database					
					if(window.pencarian == "default")
					{
							//console.log("cilukba default");
							url = base_me+'lookup/lookupBarang';
					}
					else{
							//console.log("masuk else euy");
							url = base_me+'lookup/lookupBarangCustom';
					} 
					*/
				}
			if(window.stat == "free") // status free
				{
					url	=	window.url_free; 
					console.log("Kode Barang",window.code1);
					/* 
					// tidak digunakan untuk karena menggunakan database
					if(window.pencarian == "default"){
							//console.log("cilukba default");
							url = base_me+'lookup/lookupBarang';
					}else{
						//console.log("masuk else euy");
						url = base_me+'lookup/lookupBarangFree';
					} */
				}
			 
			$(".nameBarang").autocomplete({
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
										id_group_class: window.id_group_class,
										id_control_combo: window.id_control_class_baru,
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
				function(event,ui) {
				var q = $(this).val();
				$(this).val(q);
				},
						select:
							function(event, ui) {
							$(".addBrgTampung").attr("disabled",false);
							temp = "<input type='hidden' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' /><input type='hidden' id='id_jbarang' name='id_jbarang' value='" + ui.item.intid_jbarang + "' size='15' />";
							window.code				=	ui.item.code; // gagal tinggal chek dan dihapus
							window.code1				=	ui.item.code;
							console.log("Kode Barang",window.code1);
							console.log("Kode Barang ASAL",ui.item.code);
							window.id_barang_temp = ui.item.id; // id_barang
							//window.isbayar 	= ui.item.stat_bayar; // patokan kondisi berikutnya {1, > 1}
							//window.isfree 		= ui.item.stat_free; //patokan meload promo berikutnya {0, >0 }
							//window.id_destiny = ui.item.id_destiny; //patokan load berikutnya {0, != 0}
							window.isfreeT = ui.item.stat_free;
							if(window.pencarian_asli == "combo"){
								window.isbayar = ui.item.stat_bayar;
								window.isfree = ui.item.stat_free;
							}
							console.log("Pencarian AddBRG: ",window.pencarian);
							console.log("isbayar AddBRG: ",window.isbayar);
							console.log("isfree AddBRG: ",window.isfree);
							window.id_control_class_baru = ui.item.id_control_combo ;
							window.id_group_class = ui.item.id_group_class ;
							if( !window.id_control_class_baru  || !window.id_group_class ){
								window.id_control_class_baru = 0;
								window.id_group_class = 0;
							}
							console.log("id_control_class_baru : ",window.id_control_class_baru);
							console.log("id_group_class: ",window.id_group_class);
							
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
								//$('#intid_control_promo').attr('disabled', true);
								$('#intid_jpenjualan').attr('disabled', true);
								getData();// get Data Barang
								window.accessible_jenis_penjualan = false;
						//getContclass();
						},
					});
				});
				function classControlBaru( proms,penjs,urls)
				{
			
					$.ajax(
					{
						url: "<?php echo base_url(); ?>form_control_penjualan/"+urls,
						type:'POST',
						data :
						{
							prom:proms,
							penj:penjs
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
								window.id_destiny	=  msg.message.id_destiny;
								window.code			=	msg.message.code;
								console.log("omset ",window.omset);
							}
						
						},
					});
				}
				function getContclass()
				{
					console.log("Running");
					var ab=0;
					var tamplen = parseInt($("#tampung").find(".tdTampung").length);
					
					//console.log("tampunga: ", tamplen);
					//console.log("tampungan Mod: ", (tamplen % 2));
					//console.log("window isCon: ", window.isCon );
						 	
					if(parseInt(tamplen % 2) == 1)
					{
						console.log(window.isCon );
						if(window.isCon == 1){
							classControlBaru($('#intid_control_promo').val(),$('#intid_jpenjualan').val(),"classControllCustom");
						}else{
							classControlBaru($('#intid_control_promo').val(),$('#intid_jpenjualan').val(),"classControll");
						}
						//console.log("ganjil");										
					}
					else
					{
						//console.log("Genap");
						classControlBaru($('#intid_control_promo').val(),$('#intid_jpenjualan').val(),"classControll");
					}
				}
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
						/* var intid_barang			=	window.id_barang; //var intid_barang			= $("#id_barang").val(); */
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
										function(data){
									   $.each(data, function(key, value){
											
											$(".tableTampung").prepend("<tr class='isiFormBarang'><td class='tdTampung '>"+value+"</td></tr>");
											resetPilihBarang();
											});	
											if(window.pencarian_asli != "combo"){
											getContclass();
											}
										},
									});
					}
					else
					{
						alert("Silahkan Pilih Barang yang Benar!");
					}
					
		}
		//moving content.
		
		$(".addBrg").bind("click",function()
		{
			var byrbarus=0;
			if(window.stat == "free"){
				hitungBarisTampung();
				$(".message").prepend("<p style='background-color:#FFB2B2;'>Warning : Barang Free Belum Selesai. </p>");
				exit();
			}
			console.log("window is bayar addbrg: ",window.isbayar);
			$(".tdTampung").each(function()
			{
				console.log("tdTampung",parseInt($(this).find(".intqty").val()) );
				if(parseInt($(this).find('.intqty ').val()) == 0 || $(this).find('.intqty ').val() == '' ){
					console.log("dalam if",parseInt($(this).find(".intqty").val()) );
					$(this).find('.barisForm').parent().remove();  
				}
				if(isNaN(parseInt($(this).find('.bayar').val())))
				{
					byrbarus += 0;
				}
				else
				{
					console.log("bayar "+$(this).find('.bayar').val());
					byrbarus += parseInt($(this).find('.bayar').val());
				}
			});
			
			/* jika barang bayar tidak sama dengan 1 */
				console.log(" byrbarus ",byrbarus," window.isbayar ",window.isbayar);
			if((byrbarus % window.isbayar) != 0 /*&& byrbarus > 0*/){
						hitungBarisTampung();
					$(".message").prepend("<p style='background-color:#FFB2B2;'>Warning : Barang Bayar Belum Selesai. </p>");
						exit();
				}
			/*console.log("byrbarus "+byrbarus+", window.isbayar "+window.isbayar);
				if(window.isbayar > 1){
					$(".tdTampung").each(function()
					{
	
					});
					if (parseInt(byrbarus) != window.isbayar){
						$(".message").prepend("<p style='background-color:#FFB2B2;'>Warning : Barang Bayar Belum Selesai. </p>");
						hitungBarisTampung();
						exit();
					}
				}*/
			
			
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
				//$(this).find(".hapusBarisForm").html("");
				//$(this).find(".barisForm").removeClass("hapusBarisForm");
				$(this).find(".intqty").removeClass("bayar");
				$(this).find(".intqty").removeClass("free");
				$(this).find("#data").prependTo("#formBarang");
				
				//baris($(this).find());
				//alert($('#tampung').parent().parent().find(".intqty").val());
			});
			window.id_group_class = 0;
			classControl($('#intid_control_promo').val(),$('#jpenjualans').val(),"classControll"); 
			console.log("Add Brg window.pencarian_asli ", window.pencarian_asli);
			console.log("Jpenjualan ", $('#jpenjualans').val());
			console.log("control promo  ", $('#intid_control_promo').val());
			/* Ditambahkan tgl 29102015*/
			/* End */
			/* if(window.pencarian_asli == "combo"){
			window.pencarian	= window.pencarian_asli;
			} */
		});
			
			$(".hapusPaketForm").live("click",function()
			{
				$(this).parent().parent().parent().parent().remove(); 
				$(this).find(".intqty").removeClass("bayar");
				$(this).find(".intqty").removeClass("free");
				hitungTotal();
				hitungBarisTampung();
			});
			
			$(".free").live("keyup",function()
			{
				$(".bayar").attr("readonly",true);
			});
			
			$(".intqty").live("keyup",function()
			{
				//console.log(".intqty live");
				window.id_qty	= $(this).data('intqty');
				window.intqtyid	=  $("#"+$(this).data('intqty')).val();
				hitungTotal();
				//addGenbatas(window.omsettolbar);
				hitungBarisTampung();
			});
		});
				
	function hitungBarisTampung()
	{
		var bayar		= 0;
		var free 		= 0;
		//console.log("hitungbaristampung coy");
		//$("#tampung").each(function(){ //hitung jumlah barang bayar dan  free
		$(".tdTampung").each(function(){ //hitung jumlah barang bayar dan  free
			if(isNaN($(this).find(".bayar").val()))
			{
				bayar += parseInt(0);
			}else
			{
				bayar += parseInt($(this).find(".bayar").val());
			}
			if(isNaN($(this).find(".free").val()))
			{
				free += parseInt(0);
			}else
			{
				free += parseInt($(this).find(".free").val());
			}
		// alert(bayar+" "+free);
			});
			if(window.isfreeT > 0){
			window.isfree = window.isfreeT;
			}
			console.log("Bayar Hitung Tampung", window.isbayar);
			console.log("Free Hitung Tampung", window.isfree);
		var temp = parseInt(bayar / window.isbayar) * window.isfree;
		console.log("Free dari variable", free);
		console.log("Temp dari variable", temp);
		
		if(free < temp)
		{
			var cek = temp - free;
			//alert("masukan barang free sebanyak "+cek + " \n ");
			$(".message").html("<p>Info : Masukan barang free sebanyak "+cek + " \n </p>");
			
			window.stat = "free";
			$(".statusBarang").html(window.stat);
		}
		else if(free > temp)
		{
			var cek = free - temp;
			var tothas =  window.intqtyid - cek;
			$('#'+window.id_qty).val(tothas);
			//alert("<p>free melebihi qouta ! "+cek+ "</p>");
			$(".message").html("<p>Info : free melebihi qouta ! "+cek+ "</p>");
			
			//$("#"+$(this).attr("id")).val(parseInt(0));
			$(".tdTampung").each(function() //kosongin semua free
			{ 
				//$(this).find(".free").val(0);
			});
		}
		else if(free == temp || free == 0)
		{
			//alert("silahkan klik tambah untuk mengakhiri atau lanjutkan pilih barang.");
			$(".message").html("<p>Info : Silahkan klik tambah untuk mengakhiri atau lanjutkan pilih barang.</p>");
			
			window.stat 			= "bayar";
			if(window.pencarian_asli == "combo"){
			window.pencarian	= window.pencarian_asli;
			}
			/* window.pencarian	= window.pencarian_asli; */
			$(".statusBarang").html(window.stat);
			loadRekursifLookup(window.id_destiny);
			/* di add pada tanggal 07-05-2015 */
			if($('.intqty ').val() == 0 || $('.intqty ').val() == '' ){
				exit();			
			}else{
				console.log("free",free,"temp",temp,"free - temp", free - temp);
				if(window.isfree > 0 ){
					if(((free - temp) == 0 && (bayar  % window.isbayar) == 0)){
						console.log("id_group_class "+typeof window.id_group_class+ ", id_control_class_baru "+window.id_control_class_baru);
						if(  window.id_group_class=='0'){
							jQuery('.addBrg').focus().click();
							console.log("Masuknih kedalam bro");
							exit();			
						}else{
							classControl($('#intid_control_promo').val(),$('#jpenjualans').val(),"classControllBaru");
								window.lockNameBarang = true;
							removeByrFre();
						}
					}
				}else{
					if(  window.id_group_class!= 0 && ((bayar  % window.isbayar) == 0) ){
							classControl($('#intid_control_promo').val(),$('#jpenjualans').val(),"classControllBaru");
							console.log("didalam IF")
								//window.lockNameBarang = false;
								window.lockNameBarang = true;
							removeByrFre();
							exit();						
						}
						console.log("diluar IF",window.id_group_class);
								window.lockNameBarang = false;
					//modByr();
					exit();
					}
			}
		}
	}
	function loadRekursifLookup(id_destiny)
	{
		if(parseInt(id_destiny) != 0)
		{
			window.url_bayar	= "lookup/lookupBarangDestiny";
			window.url_free 	= "lookup/lookupBarangDestiny";
		}
		else
		{
			window.url_bayar	= window.lookup_url_bayar;
			window.url_free 	= window.lookup_url_free;
		}
	}
	
	
</script>
<?php $this->load->view("template/script/scriptGenerateVoucher");?>