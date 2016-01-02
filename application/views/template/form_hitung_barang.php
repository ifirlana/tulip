<div class="barisForm <?php if(isset($class)){echo $class;}?>">
<?php $this->load->view("template/structure_input_barang",$data);?>
 <label><input type="checkbox" data-stats="<?php  if(isset($statusBarang)){echo $statusBarang;} ?>" data-idvoch ="<?php echo $count;?>" class="is_voucher <?php if(isset($class_voucher)){echo $class_voucher;}?>" id="is_voucher is_voucher_<?php echo $count;?>"> voucher</label>
 <!--status komisi tambahan --><input type="hidden" name="komtam[]" class="komtam komtam_<?php echo $count;?>" size="4" value="0">
 <!-- komisi tambahan --><input type="hidden" name="kotam[]" class="kotam kotam_<?php echo $count;?>" size="4" value="0">

<!-- Untuk Hapus Baris -->
 <!-- <label class="hapusBarisForm myButton">Hapus</label>  -->
</div>
<script>


	$(document).ready(function(){
		
		if(isfree > 0){
			$('.barisForm').addClass('paket');
		}
	/* window.isiPenj=$("#intid_jpenjualan option[value='" + $("#intid_jpenjualan").val() +"'").text();
			$('.isiPromo').html(window.isiTitle);
			$('.isiPenjualan').html(window.isiPenj);
			$('.status').val(window.isiTitle);
			$('.idPromo').val($('#intid_control_promo').val());
			$('.idPenjualan').val($('#intid_jpenjualan').val()); */
			$(".is_voucher").live("click",function(){
				var idcount= $(this).data('idvoch');
				var statx= $(this).data('stats');
				console.log(statx);
				//baris(idvoch);
				if(window.is_voucher == 1){
					if (statx == "free"){
						$(this).attr("disabled",true);
						$(this).attr("checked",false);
						$(".intvoucher_"+idcount).val("0");
						/* baris(count); */
						baris(idcount);
					}else{
						if($('.intid_wilayah').val() == 1){
							$(".intvoucher_"+idcount).val("50000");
						}else if($('.intid_wilayah').val() == 2){
							$(".intvoucher_"+idcount).val("60000");
						}
					}
					if ($(this).attr("checked") == false){
						$(".intvoucher_"+idcount).val("0");
					}
					/* baris(count); */
					baris(idcount);
				}else {
					$(this).attr("disabled",true);
					$(this).attr("checked",false);
					$(".intvoucher_"+idcount).val("0");
					/* baris(count); */
					baris(idcount);
				}
					hitungTotal();
				/* alert('is_voucher active');
				$(".barisForm").each(function(){
					if($(this).find(".is_voucher").is(":checked") == true)
					{
						$(this).find(".intvoucher ").val("50000");
					}else{
						$(this).find(".intvoucher ").val("0");
					}
				}); */
				//voucher();
				});
				$(".hapusBarisForm").live("click",function(){
					hitungBarisTampung();
					$(this).parent('.barisForm').parent().remove(); 
					$(this).find(".intqty").removeClass("bayar");
					$(this).find(".intqty").removeClass("free");
					hitungTotalTampung();
					//hitungBarisTampung();
					hitungTotal();
					 
				});
				
				
				
	});
	
	/**
	* voucher 
	*/
	/* function voucher()
	{		
		if($( ".is_voucher:checked" ).length > 0) //kalau ada ambil data undangan
		{
			var qty = 0;
			var check = 0
			$(".barisForm").each(function(){
					//console.log("voucher : "+$(this).find(".is_voucher").is(":checked"));
					if($(this).find(".is_voucher").is(":checked") == true)
					{
						qty += parseFloat($(this).find(".intqty").val());
						console.log(".intqty  "+qty);
					}
			});
			
			//	console.log("undangan awal :",$('.undangan').length);
			$(".barisForm").each(function(){
				//	console.log(".barisForm "+$(this).parent().find(".undangan_qty").val()+" form_barang");
				if(!isNaN($(this).parent().find(".undangan_qty").val()))
				{
					check = 1;
				}
			});
			//	console.log("check  "+check);
			if(check == 0)
			{
				var barisForm = window.count++;
				$.ajax({
				url: "<?php echo base_url(); ?>promosi/undanganvoucher",
				type:'POST',
				data :{intquantity:qty,count:barisForm},
				dataType: 'json',
				beforeSend:function(){
					$(".undangan").html("<h3>Loading...<h3>");
					},
				cache:true,
				success:function(data){
						 $.each(data, function(key, value){
										
							$("#"+key).prepend(value);
							});
						}
					});
			}
			else{
				//	jika diketahui form voucher is not NaN maka langsung di replace
				//	diketahui maka qty langsung disimpan
				if(!isNaN($(".undangan_qty").val()))
				{
					$(".undangan_qty").val(qty);
				}
				console.log(".undangan  "+$(".undangan_qty").val());
			}
			
		}else
		{
			console.log(":voucher "+qty);
			$(".undangan").remove();
		}
		
		//	console.log("undangan akhir :",$('.undangan').length);
	} */	
	
</script>