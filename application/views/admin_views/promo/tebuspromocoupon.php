<div>
	<table id="data" width="100%">
	<tr>
		<td><h2>Coupon</h2></td>
		<td><img src='https://img.modern-house.us/medium/2/online%20coupon%20codes.jpg' class="img" style="width:60px"/></td>
	</tr>
	<tr>
		<td colspan='2'>
		<table width="100%" border='1' cellpadding='5' cellspacing='0'>
			<thead><tr><th colspan='3'>&nbsp;</th></tr></thead>
			<tbody class="jumlahCoupon">Table Coupon</tbody>
		</table>
		</td>
	</tr>
	</table>
</div>
<div id="loading"><h2>Loading..</h2></div>
<script>
	$(document).ready(function()
	{
		var total		=	0;
		$(".ls-checkbox").each(function()
		{		
			if($(this).attr("checked"))
			{			
				var temp = $(this).data("omsets");
				total += parseInt(temp);
			}
		});
		total = Math.floor(total / 300000);
		console.log("total : "+total);
		
		if(total > 0)
		{
			var string = "";
			for(var i = 0;i < total;i++)
			{
				string += '<tr><td>Coupon</td><td><img src="https://img.modern-house.us/medium/2/online%20coupon%20codes.jpg" class="img" style="width:60px"/></td><td><input type="text" size="2" class="inputCoupon[]" name="jumlah" value="1" readonly/></td></tr>';
			}
			string += "<tr><td colspan='2'><input type='submit' name='submit' value='Simpan' onClick='this.form.action=\'<?php echo base_url("form_coupon/insertCoupon");?>\' /><td></tr>";
			$(".jumlahCoupon").html(string);
			$("#loading").hide();
		}else
		{
			$("#loading").html("<h2>Tebus Promo</h2>");
		}
	});
</script>