<script>
	/** 
	* reset Ulang pilih barang. lalu bisa gunakan ulang proses pengambilan promo
	*/
	function resetPilihBarang()
	{
		//$("#resultPilihBarang").html("");
		$("#resultPilihBarangFree").html("");
		$(".nameBarang").val("");
	}
	
	/** 
	* key yang diijinkan untuk diproses adalah number
	*/
	function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
	 /* window.otherpersen = 0.05; */
	 window.otherpersen = 1;
	 function addGenbatas(omsetx){
	 	$.ajax({
                /* url: "<?php echo base_url(); ?>form_control_penjualan/cariBatas", */
                url: "<?php echo base_url(); ?>form_control_penjualan/cariBatasNew",
                type:'POST',
                data :{
                	idpromo:$("#intid_control_promo").val(), 
                	omsetbatas:omsetx
                },
                dataType: 'json',
                cache:false,
                
                success:function(msg)
                    {
                    	if (msg.response == 'true') {
                    		window.otherpersen = msg.message.diskon;
                     		//hitungTotal();  
                    	}else{
                    		window.otherpersen = 1;
                    	};
					console.log("diskon untuk other",msg.message.diskon);
                       hitungTotal();
                        
                        //addGenBarang("false");
                },
            });
			}
	/**
	*	digunakan untuk menghitung total omset dan pembayaran yang harus dibayar
	*/
	function hitungTotal()
	{
		console.log("hitungtotal start.");
		var inttotal_voucher	=	0;
		var inttotal_omset	=	0;
		var inttotal_10	=	0;
		var inttotal_15	=	0;
		var inttotal_20	=	0;
		var inttotal_kOther	=	0;
		var inttotal_k10	=	0;
		var inttotal_k15	=	0;
		var inttotal_k20	=	0;
		var inttotal_bayar	=	0;
		var intpv				=	0;
		var intcash				=	$("#intcash").val();
		var intdp				=	$("#intdp").val();
		var intdebit			=	$("#intdebit").val();
		var intkredit			=	$("#intkredit").val();
		var intsisa				=	0; 
		var omsetx 			=	0;
		var persenbaru 		=	0;
		
		var temp_komhit 	=	0;
		
		//lakukan pengulangan di div 
		$(".barisForm").each(function(){
			/* console.log(".omset20 ",$(this).find('.omset20').val()); */
			var temp_omset10			=	$(this).find('.omset10').val();//console.log(".omset10 ",temp_omset10);
			var temp_omset15			=	$(this).find('.omset15').val();//console.log(".omset15 ",temp_omset15);
			var temp_omset20			=	$(this).find('.omset20').val();//console.log(".omset20 ",temp_omset20);
			var temp_komisi10			=	$(this).find('.komisi10').val();//console.log(".komisi10 ",temp_komisi10);
			var temp_komisi15			=	$(this).find('.komisi15').val();//console.log(".komisi15 ",temp_komisi15);
			var temp_komisi20			=	$(this).find('.komisi20').val();//console.log(".komisi20 ",temp_komisi20);
			var temp_totalbayar		=	$(this).find('.totalbayar').val();//console.log(".totalbayar ",temp_totalbayar);
			var temp_totalomset		=	$(this).find('.totalomset').val();//console.log(".totalbayar ",temp_totalbayar);
			var temp_intvoucher		=	$(this).find('.intvoucher').val();
			var temp_pv					=	$(this).find('.intpv').val();
			var temp_intqty				=	$(this).find('.intqty ').val();
			var temp_intid_jbarang		=	$(this).find('.intid_jbarang').val();
			/*Buat hitung komisi tambahan*/
			var temp_komtam			=	$(this).find('.komtam ').val();
			/*End Of Komisi Tambahan*/
			var temp_tolbar = 0;
			
			if(isNaN(temp_omset10)){temp_omset10 	= 0;}
			if(isNaN(temp_omset15)){temp_omset15 	= 0;}
			if(isNaN(temp_omset20)){temp_omset20 	= 0;}
			if(isNaN(temp_komisi10)){temp_komisi10 	= 0;}
			if(isNaN(temp_komisi15)){temp_komisi15 	= 0;}
			if(isNaN(temp_komisi20)){temp_komisi20 	= 0;}
			if(isNaN(temp_totalbayar)){temp_totalbayar 	= 0;}
			if(isNaN(temp_intvoucher)){temp_intvoucher	= 0;} 
			if(isNaN(temp_pv)){temp_pv 			= 0;} 
			/* console.log(".intvoucher ",temp_intvoucher); */
			 
			 
			 
		 	inttotal_omset	+=	parseFloat(temp_omset10) + parseFloat(temp_omset15) + parseFloat(temp_omset20);
		
			if(temp_omset10 == 0 && temp_omset15 == 0 && temp_omset20 == 0) // jika masih nol
			{
				if(temp_totalomset == 0){
				inttotal_omset += parseFloat(0);	
				}else{
					
				inttotal_omset +=	parseFloat(temp_totalbayar);
				}
			}
			/* console.log("otherpersen ",window.otherpersen ); */
			omsetx += temp_totalbayar;
			
			if(temp_komtam == 1){
				temp_komhit = inttotal_omset;
				window.omsettolbar = temp_komhit;
				temp_tolbar += temp_totalbayar * window.otherpersen;
				$(this).find('.kotam ').val(parseFloat( temp_tolbar));
			
			}
			/* End of komisi tambahan  */
			persenbaru = window.otherpersen;
			/* console.log("Temp Total Bayar Komisi", temp_tolbar); */
			if(window.otherpersen == 1){
				persenbaru = 0;
				temp_tolbar = 0;
			}
			inttotal_10		+=	parseFloat(temp_omset10);
			inttotal_15		+=	parseFloat(temp_omset15);
			inttotal_20		+=	parseFloat(temp_omset20);
			inttotal_k10		+=	parseFloat(temp_komisi10);
			inttotal_k15		+=	parseFloat(temp_komisi15);
			inttotal_k20		+=	parseFloat(temp_komisi20);
			inttotal_kOther		+=	parseFloat(temp_tolbar);
			inttotal_bayar		+=	parseFloat(temp_totalbayar - temp_tolbar);
			inttotal_voucher	+=	parseFloat(temp_intvoucher * temp_intqty);
			intpv					+=	parseFloat(temp_pv);
			/* console.log(".intvoucher ",inttotal_voucher);
			console.log(".total bayar ",inttotal_bayar); */
 
			});
		
		/*
		* @param intcash > 0
		*/
		
		if(inttotal_voucher > 0 || inttotal_omset > 0 || inttotal_bayar > 0 || intcash >= 0 || intdp > 0 || intdebit > 0 || intkredit > 0)
		{ 
			$("#btn_submit").removeAttr("disabled","disabled");
		}
		else
		{
			$("#btn_submit").attr("disabled","disabled");
		}
		//end.
		
		intsisa = parseFloat(inttotal_bayar - intcash  - intdebit - intkredit - intdp);
		////Start Filter Mines///
		if (inttotal_voucher < 0){
			 inttotal_voucher = 0;
		 }if (inttotal_omset < 0){
			 inttotal_omset = 0;
		 }if (intpv < 0){
			 intpv = 0;
		 }if (inttotal_10 < 0){
			 inttotal_10 = 0;
		 }if (inttotal_15 < 0){
			 inttotal_15 = 0;
		 }if (inttotal_20 < 0){
			 inttotal_20 = 0;
		 }if (inttotal_k10 < 0){
			 inttotal_k10 = 0;
		 }if (inttotal_k15 < 0){
			 inttotal_k15 = 0;
		 }if (inttotal_k20 < 0){
			 inttotal_k20 = 0;
		 }if (persenbaru < 0){
			 persenbaru = 0;
		 }if (inttotal_kOther < 0){
			 inttotal_kOther = 0;
		 }if (inttotal_bayar < 0){
			 inttotal_bayar = 0;
		 }/* if (intsisa < 0){
			 intsisa = 0;
		 } */
		
		////End Filter////////
		$("#inttotal_voucher").val(inttotal_voucher.toFixed(2));
		$("#inttotal_omset").val(inttotal_omset.toFixed(2));
		$("#intpv").val(intpv.toFixed(2));
		$("#inttotal_10").val(inttotal_10.toFixed(2));
		$("#inttotal_15").val(inttotal_15.toFixed(2));
		$("#inttotal_20").val(inttotal_20.toFixed(2));
		$("#inttotal_k10").val(inttotal_k10.toFixed(2));
		$("#inttotal_k15").val(inttotal_k15.toFixed(2));
		$("#inttotal_k20").val(inttotal_k20.toFixed(2));
		$("#nota_persen_kOther").val(parseFloat(persenbaru * 100).toFixed(2));
		$("#persentambah").html(parseFloat(persenbaru * 100).toFixed(2));
		$("#inttotal_kOther").val(parseFloat(inttotal_kOther).toFixed(2));
		$("#inttotal_bayar").val(parseFloat(inttotal_bayar).toFixed(2));
		$("#intsisa").val(intsisa);	
			addGenbatas(window.omsettolbar);
			
		//processing extra
	}
	
	// @param KKreditProcessing
	function KKreditProcessing()
	{
		/* console.log("KKreditProcessing start."); */
		if($("#check_intkkredit").is(":checked") == true)
		{
			/* console.log("KKreditProcessing true."); */
			$("#kkredit-content").removeAttr("style","display:none");
			
			var intkomisi_asi		=	0;
			var inttotal_10		=	$("#inttotal_10").val();
			var inttotal_15		=	$("#inttotal_15").val();
			var inttotal_20		=	$("#inttotal_10").val();
			var inttotal_omset	=	$("#inttotal_omset").val();
			var inttotal_bayar	=	$("#inttotal_bayar").val();
			
			$("#inttotal_k10").val(0);
			$("#inttotal_k15").val(0);
			$("#inttotal_k20").val(0);
			
			$("#intcash").val(0);				
			$("#intdebit").val(0);				
			$("#intsisa").val(0);			
			$("#inttotal_kOther").val(0);
			$("#is_asi").val(1);
			
			var temp		=	(inttotal_10 * 0.07) + (inttotal_15 * 0.12) + (inttotal_20 * 0.17); 
			if(temp == 0)
			{
				temp		= inttotal_omset * 0.17;
			}
			intkomisi_asi = temp;
			
			$("#intkomisi_asi").val(intkomisi_asi);
			
			$("#intcash").attr("readonly",true);				
			$("#intdebit").attr("readonly",true);				
			$("#intsisa").attr("readonly",true);					
			$("#intkredit").attr("readonly",true);
			$("#intkredit").val(inttotal_omset);
			$("#inttotal_bayar").val(inttotal_omset);			
		}
		else
		{
			/* console.log("KKreditProcessing false."); */
			$("#kkredit-content").attr("style","display:none");
			$("#no_kkredit").val(0);				
			$("#is_asi").val(0);
			$("#intkredit").val(0);
			
			$("#intcash").removeAttr("readonly");				
			$("#intdebit").removeAttr("readonly");				
			$("#intsisa").removeAttr("readonly");					
			$("#intkredit").removeAttr("readonly");				
			hitungTotal();
		}
		/* console.log("KKreditProcessing end."); */
	} 
	// end KKreditProcessing.
	
	/** 
	* digunakan untuk hitung baris
	*/
	
	function baris(count)
	{
		/* addGenbatas(window.omsettolbar); */
		//alert();
		pembagi = 1;
		var qty 				= $('.intquantity_'+count).val(); //console.log(".intquantity_"+count+" "+$('.intquantity_'+count).val());
		var intharga 		= $('.hargasatuan_'+count).val();
		var intpv			=	$('.temp_intpv_'+count).val(); //console.log(".intpv_"+count+" "+$('.intpv_'+count).val());
		var omset10		=	$('.temp_omset10_'+count).val(); //console.log(".omset10_"+count+" "+$('.omset10_'+count).val());
		var omset15		=	$('.temp_omset15_'+count).val(); //console.log(".omset15_"+count+" "+$('.omset15_'+count).val());
		var omset20		=	$('.temp_omset20_'+count).val(); //console.log(".omset20_"+count+" "+$('.omset20_'+count).val());
		var omset			=	$('.temp_omset_'+count).val(); //console.log(".omset20_"+count+" "+$('.omset20_'+count).val());
		var intvoucher	=	$('.intvoucher_'+count).val(); //console.log(".intvpucher"+count+" "+$('.intvoucher_'+count).val());
		var dispersen		=	$('.dispersen_'+count).val(); //console.log(".dispersen_"+count+" "+$('.dispersen_'+count).val());
		var hargabaru1 	= 0;
		var intid_jbarang	=	$(".temp_intid_jbarang_"+count).val();
		/* 
		perubahan alur perhitungan untuk komisi
		perhitungan untuk di setiap variable harus dimasukkan diskonnya terlebih dahulu untuk di hitung.
		
		nantinya akan melakukkan pemilihan jika wilayahnya luar indonesia maka akan di gannti dengan:
		"parseFloat" bukan "parseFloat"
		By:Fahmi Hilmansyah
		Created : 11/12/2014
		*/
		var komisi10	=	parseFloat(( ($('.temp_omset10_'+count).val() - intvoucher ) * dispersen ) * 0.1); //console.log(".komisi10_"+count+" "+$('.komisi10_'+count).val());
		var komisi15	=	parseFloat(( ($('.temp_omset15_'+count).val() - intvoucher ) * dispersen ) * 0.15); //console.log(".komisi15_"+count+" "+$('.komisi15_'+count).val());
		var komisi20	=	parseFloat(( ($('.temp_omset20_'+count).val() - intvoucher ) * dispersen ) * 0.2); //console.log(".komisi20_"+count+" "+$('.komisi20_'+count).val());
		var v =	0;
		if(isNaN(qty)){ //set variable
			qty	=	0;}
		
		if(isNaN(intpv)){ //set variable
			intpv	=	0;}

		if(isNaN(omset)){ //set variable
			omset	=	0;}
			
		if(isNaN(omset10)){ //set variable
			omset10	=	0;}
			
		if(isNaN(omset15)){ //set variable
			omset15	=	0;}
			
		if(isNaN(omset20)){ //set variable
			omset20	=	0;}
			
		if(isNaN(komisi10)){ //set variable
			komisi10	=	0;}
			
		if(isNaN(komisi15)){ //set variable
			komisi15	=	0;}
		if(isNaN(komisi20)){ //set variable
			komisi20	=	0;
			}
		if(isNaN(dispersen)){ //set variable
			dispersen	=	1;
			}
		if(isNaN(intvoucher)){ //set variable
			intvoucher	=	0;
			}
			else //jika voucher ada maka dilakukan pengurangan
			{
				if(omset10 > 0 )
				{
					omset10 = parseFloat(omset10 - intvoucher);
				}
				if(omset15 > 0)
				{
					omset15 = parseFloat(omset15 - intvoucher);
				}
				if(omset20 > 0)
				{
					omset20 = parseFloat(omset20 - intvoucher);
				}
				/* if(omset10 >= intvoucher)
				{
					omset10 = parseFloat(omset10 - intvoucher);
				}
				else if(omset15 >= intvoucher)
				{
					omset15 = parseFloat(omset15 - intvoucher);
				}
				else if(omset20 >= intvoucher)
				{
					omset20 = parseFloat(omset20 - intvoucher);
				}
				else
				{
					v = intvoucher; //digunakan untuk mengurangi harga net
				} */
			}
			if(omset10 < 0){
				omset10 = 0
			}
			if(omset15 < 0){
				omset15 = 0
			}
			if(omset20 < 0){
				omset20 = 0
			}
			if(komisi10 < 0){
			komisi10 = 0
			}
			if(komisi15 < 0){
				komisi15 = 0
			}
			if(komisi20 < 0){
				komisi20 = 0
			}
			if(intid_jbarang)
			{
				pembagi = 125000;
			}
		/* 
			nantinya akan melakukkan pemilihan jika wilayahnya luar indonesia maka akan di gannti dengan:
			"parseFloat" bukan "parseFloat"
			By: Fahmi Hilmansyah
			Created: 11-12-2014
		*/
		//console.log("omset10("+omset10+") omset15("+omset15+") omset20("+omset20+") omset("+omset+")");
		/* var inttotal_omset	=	parseFloat(qty * (intharga * dispersen)); */
		var inttotal_omset	=	parseFloat(qty * (( intharga - intvoucher ) * dispersen));
		var intpv_baris		=	parseFloat(qty * (intpv - (intvoucher  /pembagi)) *  dispersen).toFixed(2);
		if(inttotal_omset < 0){
			inttotal_omset = 0;
		}
		if(intpv_baris < 0)
		{
			intpv_baris = 0;
		}
		var total_omset		= parseFloat(qty * omset * dispersen);
		var inttotal_bayar = parseFloat(   (inttotal_omset - (qty * komisi10) - (qty *komisi15) - (qty *komisi20) ));
		//console.log("totalomset("+total_omset+")");
		if(omset10 == 0 && omset15 == 0 && omset20 == 0 && total_omset == 0) 
		{
			inttotal_bayar = parseFloat($(".hargasatuan_"+count).val() * dispersen) * qty; 
			inttotal_omset = 0;
			//inttotal_omset	=	total_omset;
		}
		//var inttotal_bayar = parseFloat(/* qty * */ (inttotal_omset - komisi10 - komisi15 - komisi20) );
		/* berfungsi untuk menghitung total bayar dengan cara total omset - (qyt * komisi) */
		/* console.log("total omset",inttotal_omset);
		console.log("komisi 10",komisi10);
		console.log("komisi 15",komisi15);
		console.log("komisi 20",komisi20);
		console.log("intotal_bayar ("+inttotal_bayar+") = inttotal_omset ("+inttotal_omset+") - komisi10 ("+komisi10+") - komisi15 ("+komisi15+") - komisi20 ("+komisi20+")"); */
		/* //jika omset tidak ada maka total bayar adalah harga satuan */
		
		
		/* 
			nantinya akan melakukkan pemilihan jika wilayahnya luar indonesia maka akan di gannti dengan:
			"parseFloat" bukan "parseFloat"
			By: Fahmi Hilmansyah
			Created: 11-12-2014
		*/
		$(".omset10_"+count).val(parseFloat(qty * omset10 * dispersen).toFixed(2));	
		$(".omset15_"+count).val(parseFloat(qty * omset15 * dispersen).toFixed(2));	
		$(".omset20_"+count).val(parseFloat(qty * omset20 * dispersen).toFixed(2));
		$(".intpv_"+count).val(intpv_baris);
		/* diubah karena komisi nya udah di set di awal
			By: Fahmi Hilmansyah
			Created: 11-12-2014
		*/
		
		/* $(".intharganew_"+count).val(parseFloat(intharga * dispersen).toFixed(2));	 */
		/* $(".intharganew_"+count).val(parseFloat( ( intharga - intvoucher ) * dispersen).toFixed(2));	 */
		/* $(".intharganew_"+count).val(parseFloat(inttotal_omset).toFixed(2));	 */
		hargabaru1 = parseFloat((intharga - intvoucher ) * dispersen).toFixed(2);
		if (hargabaru1 < 0){
			hargabaru1 = 0;
		}
		/* $(".intharganew_"+count).val(parseFloat((intharga - intvoucher ) * dispersen).toFixed(2)); */
		$(".intharganew_"+count).val(parseFloat(hargabaru1).toFixed(2));

		$(".komisi10_"+count).val(parseFloat(qty * komisi10 ).toFixed(2));	
		$(".komisi15_"+count).val(parseFloat(qty * komisi15 ).toFixed(2));	
		$(".komisi20_"+count).val(parseFloat(qty * komisi20 ).toFixed(2));		
		$(".totalbayar_"+count).val(parseFloat(inttotal_bayar).toFixed(2));	
		$(".totalomset_"+count).val(parseFloat(inttotal_omset).toFixed(2));	
		/* untuk hitung komisi tambahan */
		$(".komtam_"+count).val(window.is_komtam);		
		/*End Of Komisi Tambahan*/
		
		hitungTotal();
		/* voucher(); */
		checkGenerateVoucher();
	}
	
	
	/**
	* Pengecekan method post 
	* jika ada kegagalan
	*/
	$('#form_post').submit(function(event)
	{
		var tampung = false;
		$("#tampung").each(function()
		{
			if($(this).find(".tableTampung").html() != null)
			{
				tampung = true;
			}
		});
		if(tampung == true)
		{
			alert("Pemilihan Barang belum Selesai.\n Lengkapi terlebih dahulu atau klik Tambah");
            event.preventDefault();
		
		}
		
		if($(".barisForm").html() == null)
		{
			alert("Maaf data tidak ada. Silahkan input Barang.");
            event.preventDefault();
		}
	});
	//end.
</script>