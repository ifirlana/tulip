<script>
	$(document).ready(function()
	{
		
		var base_me		= "<?php echo base_url();?>";
		
		$(".nameBarang").bind("keypress",function()
		{
			
			console.log(base_me);
			$(".nameBarang").autocomplete({
						minLength: 5,
						source:
							function(req, add){
							$.ajax({
								url: base_me+'lookup/lookupBarangSaja',
								dataType: 'json',
								type: 'POST',
								data: {
										term				: req.term,
										
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
								$("#addTbarang").empty();
								getBarang(ui.item.code);
						//getContclass();
						},
					});
				});
				

			function getBarang(cde){
			$.ajax({
			 url: "<?php echo base_url(); ?>lookup/getBarangSaja",
			 type: 'POST',
			 dataType:'json',
			 data:{code:cde},
			 beforeSend:
				function(){										
					$("#loadme").fadeIn(500);
					},
			success:
				function(data){
					$("#loadme").fadeOut(500);
					console.log("data "+data);
					console.log("data 1"+data.message[1]);
					
					$.each(data.message,function(key,val)
						{
							//console.log(data.message[key].id);
							$("#addTbarang").append("<tr><td ><input type='hidden' name='intid_barang[]' value='"+data.message[key].id+"'><input type='hidden' name='code_barang[]' value='"+data.message[key].code+"'> "+data.message[key].value+"</td><td align='center'><label class='delRowBtn' style='width:100%; padding:0px 20px 0px 20px ; border:1px solid black; background-color: #FFB2B2;'>Hapus</label></td></tr>");
						});
					},
				});
			}
			$(document).delegate(".delRowBtn", "click", function(){
		        $(this).closest("tr").remove();        
		    }); 
		
		});
	
</script>