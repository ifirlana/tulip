<div style="width:100%; margin:10px;">
<label>Kode Voucher</label>
<input type="text" id="nonotavoucher_voucher" name="nonotavoucher[]" placeholder="Kode Voucher" TITLE="MASUKAN KODE VOUCHER ANDA"> 
<button type="button" id="check_voucher" style="border:1px solid black; padding:3px 5px 3px 5px; background-color:aqua;">Check</button>
</div>
<script>
$("#check_voucher").click(function(){
	if( parseInt($("#intid_jpenjualan").val()) == 0){
		alert("Silahkan Pilih Jenis Penjualan Terlebih Dahulu");
	}else{
		$.ajax({
				url: "<?php echo base_url(); ?>form_control_plugins/getDataKodeVoucher",
				type:"POST",
				data:
					{
										intid_dealer : $('#intid_dealer').val(),
										code_voucher:$("#nonotavoucher_voucher").val(),
										intid_cabang		:	$(".intid_cabang").val(),
										count				:	window.count++,
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
				beforeSend:
				function()
				{
					$(".td-loading-form").html("LOADING NIH..");
				},
				success:
				function(data)
				{
					$(".td-loading-form").html("");
					$('#intid_jpenjualan').attr('disabled', true);
					$('#intid_control_promo').attr('disabled', true);
					window.accessible_jenis_penjualan = false;
					$("#formBarang").append(data);
					$(".is_voucher").attr('disabled',true);
					$('#nonotavoucher_voucher').attr('readonly', true);
					$('.intqty').attr('readonly', true);
					hitungTotal();
				}
		});
	}
});
</script>