<script>
	function loadJenis()
	{
		$.ajax(
		{
			url: "<?php echo base_url(); ?>form_control_tebus/form_jenis_penjualan",
			type: 'POST',
			data: 
			{
				idcbg : $('.intid_cabang').val(),
				pengejaranChall : $("#pengejaranChall").val(),
			},
			beforeSend:
				function()
				{										
					$("#loadformPenjualan").html("<h3>Loading..</h3>");
					
				},
			success:
				function(data)
				{
					$("#loadformPenjualan").html(data);
				},
		});
	}				
 </script>