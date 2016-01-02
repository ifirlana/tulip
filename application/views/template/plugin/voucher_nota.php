<div style="width:100%; margin:10px;">
<label>No. Nota Penebusan: </label><input type="text" id="nonotavoucher" name="nonotavoucher[]" placeholder="No. Nota Sebelumnya" title="Masukkan No Nota Anda"> <label id="checkdong" style="border:1px solid black; padding:3px 5px 3px 5px; background-color:aqua;">Check</label>
</div>
<script>
$("#checkdong").click(function(){
	if( parseInt($("#intid_jpenjualan").val()) == 0){
		alert("Silahkan Pilih Jenis Penjualan Terlebih Dahulu");
	}else{
		$.ajax({
				url: "<?php echo base_url(); ?>form_control_plugins/getData",
				type:"POST",
				dataType:"HTML",
				data:
					{
										intid_dealer : $('#intid_dealer').val(),
										code_voucher:$("#nonotavoucher").val(),
										count				:	999,
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
				beforeSend: function(){
					$(".td-loading-form").html("TUNGGU SEBENTAR YA.... ");
				},
				
				success:function(data){
					/* if (data == null){
					alert(data);
					} */
					$(".td-loading-form").html("");
					$('#intid_jpenjualan').attr('disabled', true);
					$('#intid_control_promo').attr('disabled', true);
					$('#nonotavoucher').attr('readonly', true);
					$(".td-loading-form").html("");
					$("#formBarang").html(data);
					$(".is_voucher").attr('disabled',true);
					$('.intqty').attr('readonly', true);
					hitungTotal();
				}
		});
	}
});
</script>