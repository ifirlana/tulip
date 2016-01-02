<input type="hidden" id="intvoucher" />
<input type="hidden" id="temp_pv" />
<table border='1' cellspacing="0" cellpadding="2" bgcolor="white" width="100%">
<tr>
	<th>&nbsp;</th> 
	<th>No. Nota</th>
	<th>Tanggal</th>
	<th>Omset</th>
</tr>

	<?php
	$bonus = 0.45;
	
	foreach($query->result() as $row)
	{
		
				$voucher = 0* $bonus;			
				echo "<tr class=\"ls-barang\">";
				echo "<td><span id=".$row->intid_nota."></span><input type='checkbox' data-omsets ='".$row->inttotal_omset."' data-idDetail=".$row->intid_nota." class='ls-checkbox' name='id_tebus[]' data-intid_nota='".$row->intid_nota."' value='".$row->intid_nota."' /></td>";
				echo "<td>".$row->intno_nota."</td>";
				echo "<td>".$row->datetgl."</td>";
				echo "<td>".$row->inttotal_omset."</td>";
				echo "</tr>";
		
	}
	?>
<tr>
	<td>&nbsp;</td>
	<td>Total Omset:<input type="text" name="" id="totomsets" value="0" readonly placeholder=""></td>
	<td>Omset Barang:<input type="text" name="" value="0" id="omsbrg" readonly placeholder=""></td>
	<td>Omset Sisa:<input type="text" name="" value="0" id="omssisa" readonly placeholder=""></td>
</tr>
</table>
<script>
$(document).ready(function()
	{
		window.omssisa = 0;
	window.omsbrg = 0;
	window.totomsets =0;
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
							temp += parseInt($(this).data('omsets'));
							temp_pv += 0;//parseFloat($(this).data('pv')) * bonus; 
							$("#omsbrg").val(0);
							window.omsbrg = 0;
							out = "<input type='hidden' name='id_notaOLD[]' value='"+$(this).data('intid_nota')+"'>";
							$("#"+temp_val).html(out);
						} 
						else if(!$(this).attr("checked"))
						{
							window.totomsets -= parseInt($(this).data('omsets'));
							/*reset omset barang jadi 0*/
							$("#omsbrg").val(0);
							window.omsbrg = 0;
							$("#"+temp_val).html(""); 	
						}
					});
				$("#totomsets").val(temp);
				if(parseInt(temp) != 0)
				{
					$.ajax({					
						url: "<?php echo base_url(); ?>promorw/tebuspromo",
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
				window.totomsets = temp;
				window.omssisa = window.totomsets - window.omsbrg ;
				$('#omssisa').val(window.omssisa);
			});
	});
/**
function clickMe()
{
}
*/
</script>
<div id="Pembayaran-Div"></div>