
<script>
	$(document).ready(function(){
		///

		$("#handphone").bind("keyup",function(){
			
			$("#submitDaftar").removeAttr("disabled");
			});
		var email = $("#stremail").val();
		var hp =$("#strhp").val();
			$("#resEm").html(email);
			$("#resHp").html(hp);
			
		///	
		function sendnow(urls,texts){
			$.ajax({
			url: "<?php echo base_url(); ?>website/"+urls,
				type: 'POST',
				data: {
					text1:texts,
					text2:$("#intid_dealer").val()
				},
			beforeSend:
			function(){
				$("#resulthasil").html("Loading ..");
				},						
				success:    
			function(data){
				$("#resulthasil").html(data);
			},
			});
		}
		$(".sendsM").bind("click",function(){
			var result = $('#'+$(this).data('isi')).html();
			var urls=$(this).data('urls');
			sendnow(urls,result);
			//alert("cilukba"+result+" urls "+urls);
			});
		});
</script>

<div id="resulthasil"></div>
<fieldset>
<h2><label>Cara ini Boleh dilakukan apabila Member Ingin Mengganti Email Lamanya Menjadi Email Baru Untuk Masuk Ke Sistem Member Online</label></hr>
</fieldset>
<fieldset>
<!--<div>
	<h2><label>Kirim Form Reset ke : <span id="resEm"></span> </label> </h2><button data-isi="resEm" data-urls="sendEmailForgotPassword" class="sendsM">Send Email</button>
</div>
</fieldset>
<fieldset>
<div>
	<h2><label>Kirim Password Baru ke No.Hp : <span id="resHp"></span> </label> </h2><button data-isi="resHp" data-urls="sendHpPassword" class="sendsM">Send Password</button>
</div>-->
<div>
    <h2><label>Sebelum melakukan Hard Reset, Admin Wajib Memastikan identitas member sesuai dengan KTPnya <span id="hardres"></span> </label> </h2>
	<h2><label>Reset Ulang : <span id="hardres"></span> </label> </h2><button data-isi="hardres" data-urls="hardreset" class="sendsM">Hapus Data</button>
</div>
</fieldset>		