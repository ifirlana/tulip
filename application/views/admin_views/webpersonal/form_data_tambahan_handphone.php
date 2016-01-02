<fieldset>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="left">
<?php
	foreach($query->result() as $row){
		echo "<input type='hidden' name='strkode_dealer' id='strkode_dealer' value='".$row->strkode_dealer."' />";
		echo "<tr><td>&nbsp;</td><td><h2>Dealer :</h2></td><td colspan='2'><h2>".$row->strnama_dealer."</h2></td></tr>";
		echo "<tr><td>&nbsp;</td><td><h2>Upline :</h2></td><td colspan='2'><h2>".$row->strnama_upline."</h2></td></tr>";
		echo "<tr><td>&nbsp;</td><td><h2>Alamat :</h2></td><td colspan='2'><h2>".$row->stralamat."</h2></td></tr>";
		echo "<tr><td>&nbsp;</td><td><h2>email</h2></td><td><input type='text' name='email' value='".$row->stremail."' id='email' style='padding:2px;' required/><small>*wajib diisi</small></td></tr>";
		echo "<tr><td>&nbsp;</td><td><h2>Handphone / SMS</h2></td><td><input type='text' name='handphone' value='".$row->strtlp."' id='handphone' style='padding:2px;' required /><small>*wajib diisi</small></td></tr>";
		echo "<tr><td colspan='3'>&nbsp;</td></tr>";
		echo "<tr><td>&nbsp;</td><td colspan='2'><input type='submit' id='submitDaftar' value='submit' /></td></tr>";
		
		}
?>
           
</table>
<div id="result_dealer"></div>
</fieldset>
<script>
	$(document).ready(function(){
		/*
		$("#handphone").bind("keyup",function(){
			
			$("#submitDaftar").removeAttr("disabled");
			});
			*/
		///	
		$("#submitDaftar").bind("click",function(){
			if($('#email').val() == null || $('#handphone').val() == null || $('#email').val() == '' || $('#handphone').val() == ''){
				alert("Maaf Silahkan Isikan Email / No.Handphone !");
			}else{
			$.ajax({
		        		url: "<?php echo base_url(); ?>website/PostDaftarMember",
		          		type: 'POST',
		          		data: {
							intid_dealer 	: $("#intid_dealer").val(),
							strkode_dealer 	: $("#strkode_dealer").val(),
							handphone 		: $("#handphone").val(),
							email 		: $("#email").val(),
							},
						beforeSend:
						function(){
							$("#result_dealer").html("Loading ..");
							},						
		          		success:    
		            	function(data){
							$("#result_dealer").html(data);
		            	},
              		});
			}
			});
		});
</script>
		