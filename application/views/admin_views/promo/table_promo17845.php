<input type="hidden" id="intvoucher" />
<input type="hidden" id="temp_pv" />
<table border='1' cellspacing="0" cellpadding="2" bgcolor="white" width="100%">
<tr>
	<th>&nbsp;</th> 
	<th>nama barang</th>
	<th>quantity</th>
	<th>normal</th>
	<th>Bonus</th>
</tr>

	<?php
	$bonus = 0.45;

	foreach($query->result() as $row)
	{
		for ($x = 0; $x < $row->qtynew; $x++):
				$voucher = ($row->intharga)* $bonus;
				// $voucher = (($row->qtynew>1? ($row->qtynew - 1):$row->qtynew) * $row->intharga)* $bonus;
			
				echo "<tr class=\"ls-barang\">";
				echo "<td><span id=".$row->intid_detail_nota."-".$x."></span><input type='checkbox' data-idDetail=".$row->intid_detail_nota."-".$x." class='ls-checkbox' name='id_tebus[]' data-intqty='1' data-voucher='".$voucher."' data-pv='".($row->intpv / $row->intquantity)."' data-intid_nota='".$row->intid_nota."' value='".$row->intid_detail_nota."' /></td>";
				echo "<td>".$row->strnama."</td>";
				echo "<td>1</td>";
				//echo "<td>".$row->intquantity." : ".$row->total." , ".$row->intid_detail_nota."</td>";
				echo "<td>".$row->intharga."</td>";
				echo "<td class='td-voucher'>".$voucher."</td>";		
				echo "</tr>";
		endfor;
		/*if(($row->intquantity < $row->total) or $row->total == 0) // kondisi jika total = quantity maka berhenti,
		{
			if($row->intquantity > 1)
			{dsadsaasdasdasd
				for($i = 0; $i< $row->intquantity; $i++)
				{
					$voucher = (1 * $row->intharga)* $bonus;
				
					echo "<tr class=\"ls-barang\">";
					echo "<td><span id=".$row->intid_detail_nota."></span><input type='checkbox' class='ls-checkbox' name='id_tebus[]' data-intqty='1' data-voucher='".$voucher."' data-pv='".$row->intpv."' data-intid_nota='".$row->intid_nota."' value='".$row->intid_detail_nota."' /></td>";
					echo "<td>".$row->strnama."</td>";
					echo "<td>1 : ".$row->total." , ".$row->intid_detail_nota."</td>";
					echo "<td>".$row->intharga."</td>";
					echo "<td class='td-voucher'>".$voucher."</td>";		
					echo "</tr>";
				}
			}
			else
			{ 
				$voucher = ($row->intquantity * $row->intharga)* $bonus;
			
				echo "<tr class=\"ls-barang\">";
				echo "<td><span id=".$row->intid_detail_nota."></span><input type='checkbox' class='ls-checkbox' name='id_tebus[]' data-intqty='".$row->intquantity."' data-voucher='".$voucher."' data-pv='".$row->intpv."' data-intid_nota='".$row->intid_nota."' value='".$row->intid_detail_nota."' /></td>";
				echo "<td>".$row->strnama."</td>";
				echo "<td>".$row->intquantity." : ".$row->total." , ".$row->intid_detail_nota."</td>";
				echo "<td>".$row->intharga."</td>";
				echo "<td class='td-voucher'>".$voucher."</td>";		
				echo "</tr>";
			}
		}*/
	}
	?>

</table>
<script>
$(document).ready(function()
	{
		bonus = <?php echo $bonus;?>;
		$(".ls-checkbox").bind("click",function()
			{
				temp = 0;
				temp_pv = 0;
				$(".ls-checkbox").each(function()
					{
						var temp_val = $(this).data("idDetail");
						// var temp_val = $(this).val();

						if($(this).attr("checked"))
						{
							//parent = $(this).parent();
							temp += parseInt($(this).data('voucher'));
							temp_pv += parseFloat($(this).data('pv')) * bonus; 

							out = "<input type='hidden' name='id_notaD[]' value='"+$(this).data('intid_nota')+"'>";
							$("#"+temp_val).html(out);
						} 
						else if(!$(this).attr("checked"))
						{
							$("#"+temp_val).html(""); 	
						}
					});
				$("#intvoucher").val(temp);
				$("#temp_pv").val(temp_pv);
				if(parseInt(temp) != 0)
				{
					$.ajax({					
						url: "<?php echo base_url(); ?>promo17845/tebuspromo",
						type: 'POST',
						beforeSend:
							function() 
							{
								$("#Pembayaran-Div").html("<h2>Loading..</h2>");
							},
						success:
							 function (data){
	                         $("#Pembayaran-Div").html(data);
						},
						error:
						function()
						{
							$("#Pembayaran-Div").html("<h2>Error! Coba Lagi..</h2>");
						}
					});
				}
				else
				{
					$("#Pembayaran-Div").html("");
				}
			});
	});
/**
function clickMe()
{
}
*/
</script>
<div id="Pembayaran-Div"></div>