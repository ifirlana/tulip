<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<div class="content-btn-promo-rekrut">
	<h2>Table Pengejaran</h2>
	<p><input type="button" class="btn-promo-rekrut" value="Show Table pengejaran" /></p>
	<p class="message-btn-promo-rekrut"></p>
</div>
<script>
$(document).ready(function()
{
	console.log("run");
	
	$(".btn-promo-rekrut").bind("click",function()
	{
		console.log("btn-promo-rekrut ..");
		$.ajax(
		{
			url: "<?php echo base_url(); ?>penjualan/getTable_member_tebus_rekrut",
			type: 'POST',
			async : false,
			data: {strkode_dealer : $("#strkode_dealer").val()},
			beforeSend:
				function()
				{
					$(".message-btn-promo-rekrut").html("LOADING..");
				},
			success: function(data) {
				$('.content-btn-promo-rekrut').html(data);
			}
        });
	});
});
</script>