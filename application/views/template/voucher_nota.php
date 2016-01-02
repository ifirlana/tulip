<label>No. Nota Older: </label><input type="text" id="nonotavoucher" placeholder="No. Nota Sebelumnya"> <label id="checkdong" style="border:1px solid black; padding:3px 5px 3px 5px; background-color:aqua;">Check</label>
<script>
$("#checkdong").click(function(){
	if( parseInt($("#intid_jpenjualan").val()) == 0){
		alert("Silahkan Pilih Jenis Penjualan Terlebih Dahulu");
	}else{
		$.ajax({
				url: "<?php echo base_url(); ?>form_control_plugins/getData",
				type:"POST",
				dataType:"JSON",
				data:
					{
										code_voucher:$("#nonotavoucher").val(),
										count				:	window.count,
										idPromo				:	$('#intid_control_promo').val(),
										idPenj				:	 $('#intid_jpenjualan').val(),
										isiPromo				:	$("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text(),
										isiPenjualan			:	$("#intid_jpenjualan option[value='" + $("#intid_jpenjualan").val() +"'").text(),
										kom10 : window.kom10,
										kom15 : window.kom15,
										kom20 : window.kom20,
										omset : window.omset,
										diskon :window.diskon,
										pv : window.pv,
										
									},
				
				
				success:function(data){
					
				}
		});
	}
});
</script>