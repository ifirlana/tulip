
function jpenjualan(inicari){
	$.ajax({
		url:window.base_url+"promo60net/lookuppenjualan",
		type:'POST',
		data :{promodis:inicari},
		dataType: 'json',
		cache:false,
		beforeSend:function(){
					$("#intid_jpenjualan").empty();
				},
		success:function(msg){
			$("#intid_jpenjualan").append("<option value=''>-- Silahkan Pilih --</option>");
			$.each(msg.message,function(){
				$("#intid_jpenjualan").append("<option value="+this.intid_jpenjualan+">"+this.strnama_jpenjualan+"</option>");
			});
			console.log();
		},
	});
}
$(document).delegate('#chktulip25_10', 'change', function(){
		jpenjualan('dis25k10');
		//alert('aa');
	});
	$(document).delegate('#chktulip35_10','change',function(){
		jpenjualan('dis35k10');
	});
	
