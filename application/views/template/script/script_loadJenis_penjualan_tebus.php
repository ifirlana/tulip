<script>
	/**
	*	@script_loadJenis_penjualan_tebus
	*/
	$(document).ready(function()
	{
		//$(document).undelegate('#intid_control_promo','change click'); //reset
	
		//alert();
		$('#loadme').hide();
		$('#intid_control_promo').bind('change', function()
		{
			con("#intid_control_promo change running");
			$("#tempPromoBarang").html("");
			$("#loadFormaddBrg").html("");
			$("#formBarang").html("");
			var value = $("#intid_control_promo").val();
			
			if(value != 0) //harus berpromo.
			{
				con("value running");
			
				 $.ajax(
				 {
                    url		: "<?php echo base_url();?>form_control_tebus/load_formjenispenjualan",
                    type	: 'POST',
                    data 	:$(".config").serializeArray(),
                    dataType	:	'json',
                    cache		:	false,
                    beforeSend:
						function()
						{										
							$('#loadme').fadeIn(500);
						},
                    success		:	function(data)
                        {
                        	$('#loadme').fadeOut(500);
                            $.each(data, function(key, value)
							{
								$(key).html(value);
							});	
                    	},
					});			
			}
			$("#ppenjualans").val(value); //set ke hidden
			loadFormTebusView();
		});
	});
	
	function loadFormTebusView()
	{
		con("start view ");
		$.ajax(
		{
			url: "<?php echo base_url(); ?>form_control_tebus/load_view_form",
			type: 'POST',
			data: 
			{
				idPromo : $('#intid_control_promo').val(),
			},
			beforeSend:
				function()
				{										
					//$("#loadformPenjualan").html("<h3>Loading..</h3>");
				},
			success:
				function(data)
				{
					window.view = data;
					$("#id_view").val(data);
					con("view "+window.view);
				},
		});
		con("end view ");
	}
	function con(message)
	{
		console.log(message);
	}
</script>	