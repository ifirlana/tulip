<script type="text/javascript">
	$('.prs').click(function() 
	{
		
		$("#loadFormaddBrg").html("");			
		if($(this).is(":checked") == true)
		{
			$.ajax(
			{
				url:"<?php echo base_url();?>form_control_tebus/form_add_Barang",
				type:"POST",
				data: $(".config").serializeArray(),
				dataType:"HTML",
				beforeSend:function()
				{
					$("#loading-tebus-rekrut").show();
				},
				error:
				function(data)
				{
					alert(data.status);
					$("#loading-tebus-rekrut").hide();
				},
				success:function(data)
				{
					$("#loading-tebus-rekrut").hide();
					$("#loadFormaddBrg").html(data);
					$(".nameBarang").removeAttr("disabled");
					window.url_bayar				=	$("#id_lookup_url_bayar").val();
					window.url_free					=	$("#id_lookup_url_free").val();
					window.lookup_url_bayar	=	$("#id_lookup_url_bayar").val();
					window.pencarian				=	$("#id_pencarian").val();
					window.stat_bayar				=	$("#id_isbayar").val();
					window.stat_free				=	$("#id_isfree").val();
				}
			});
		}
    });
		window.persen = 1;
		$("#loadFormaddBrg").html("");
		$('#persen1').attr("disabled",true);
		$('#persen2').attr("disabled",true);
		$('#persen3').attr("disabled",true);
		$('#persen4').attr("disabled",true);
		var cekOmset = function (id){
			var temp = 0;
			var temptebus = 0;
			var temptlain = 0;
			
			/* var isi = $("input:checked").length; */
			var isi = $(".chkuser").length;

			for(var i=0; i <= $('#tracker009').val();i++){
				//alert('helo '+i);
					if(($('#id_'+i).attr('checked') == true) && ($('#id_'+i).attr('disabled') == false)){	
						temp += 1;
					}
					if($('#id_'+i).attr('disabled') == true){
						temptebus += 1;
						temptlain += 1;
						//console.log("eeee");
					}
			
			}
			
			//gak kepake ternyata hahaha
			 var totaltemp = 0;	
				totaltemp = 	temp + temptebus; 
			
				console.log("temp" , temp);
				console.log("temptlain" , temptlain);
				console.log("temptebus" , temptebus);
				console.log("total" , temptlain + temp);
		
			$('#total1').val(temptebus);
			$('#total').val(temp);
				 if(temp >= 2){
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
				$('#persen1').attr("disabled",true);
				
				//(temp+temptebus)/2 >= 2) &&
				
				
					
				if(temptebus > 0)
				{}else {}
				
					$('.prs').attr("disabled",true);
					var cex = parseFloat(totaltemp / 10);
					if(cex <= 1){
						cex=1;
					}else{
						cex= Math.floor(cex) + 1;

					}
					
					/* if (temp / 10 >= 1){
//						$('.prs').attr("disabled",true);
						$('#persen4').attr("disabled",false);
					} */
					if ((totaltemp / 2 == cex && totaltemp % 2 == 0) /* && (temp < 4) */) {
//						$('.prs').attr("disabled",true);
						$('#persen1').attr("disabled",false);
					}else
					if ((totaltemp / 4 == cex  && totaltemp % 4 == 0)/*  && (temp < 6) */) {
//						$('.prs').attr("disabled",true);
						$('#persen2').attr("disabled",false);
					}else
					if ((totaltemp / 6 == cex && totaltemp % 6 == 0)/*  && (temp < 10) */) {
//						$('.prs').attr("disabled",true);
						$('#persen3').attr("disabled",false);
					}else
					if ((totaltemp / 8 == cex && totaltemp % 8 == 0)/*  && (temp < 10) */) {
//						$('.prs').attr("disabled",true);
						$('#persen1').attr("disabled",false);
					}else
					if ((totaltemp / 10 == cex && totaltemp % 10 == 0)/*  && (temp < 10) */) {
//						$('.prs').attr("disabled",true);
						$('#persen2').attr("disabled",false);
					}
					//else
					//if ((temp / 8 == cex && temp % 8 == 0)/*  && (temp < 10) */) {
//						$('.prs').attr("disabled",true);
						//$('#persen1').attr("disabled",false);
					//}
					
					
		}
		
		$('.prs').click(function(){
			$("#loadFormaddBrg").html("");
			if($(".prs").is(":checked") == true)
			{
				window.persen  = $(this).val();
				$('.prs').attr("disabled",true);				
			}		
			//alert("Anda mendapatkan : "+ window.persen);
		});
	</script>