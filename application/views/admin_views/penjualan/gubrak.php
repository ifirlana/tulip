<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.error_message{ padding:5px 10px 5px 10px;min-height:5px; width:80px;color:#F00; background-color:#000;display:block;}
-->
</style>

<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            //for unit
            $(document).ready( function() {
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
                            dataType: 'json',
                            type: 'POST',
                            data: req,
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
					focus:
					function(event,ui) {
					var q = $(this).val();
					$(this).val() = q;
					},
                    select:
                        function(event, ui) {
						$("#strnama_dealer").val("");
						$("#result001").empty();
						$("#result").empty();
                        $("#result").append(
                        "<input type='text' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });


                $("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
					focus:
					function(event,ui) {
					var q = $(this).val();
					$(this).val() = q;
					},
                    select:
                        function(event, ui) {
						$("#result001").empty();
                        $("#result001").append(
                       	"<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/></td>"
                    );
                    },
                });

                $("#strnama_upline").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                });

                autoComp();
            });

            //for barang

            function autoComp(){

		var ur = "";
		var jumlah = 0;
                if($("#chkBox20").attr('checked') == false){
                    	ur = "bayar";
			$("#tracker002").val('bayar');
                }else if ($("#chkBox20").attr('checked') == true) {
			if (parseInt($('#tracker001').val()) == 0)
			{
				ur = "bayar";
				$("#tracker002").val('bayar');
			}else{
             			for(var i=1; i<= parseInt($('#tracker001').val());i++){
                			jumlah = jumlah + parseInt($('.duapuluh_'+ i).val());
                			if(jumlah >=0){
						if(jumlah >= parseInt($('#txtpromo20').val())){
							ur = "free";
							$("#tracker002").val('free');
							alert("Silakan Pilih Barang Free");
 						}else{
							ur = "bayar";
							$("#tracker002").val('bayar');
						}
                			}
            			}
                	}
		}

		if (ur == "bayar")
		{
                $(".id1").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangPromo20",
                            dataType: 'json',
                            type: 'POST',
                            data: req,
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='text' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='text' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });
		}else{
		$(".id1").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree20",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('#id_barang').val(),
                             },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='text' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });
		}

                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarangFree20",
                            dataType: 'json',
                            type: 'POST',
                           	data: {
                                term: req.term,
                                state: $('#id_barang').val(),
                             },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='text' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

            function autoCompPromo10(){

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";

                $(".id1").autocomplete({

                    minLength: 2,
                    source:
                        function(req, add){


                        $.ajax({
                            url: ur,
                            dataType: 'json',
                            type: 'POST',
                            data: req,
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='text' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='text' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );
                    },
                });


                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_barang').val(),
                             },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='text' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='text' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

 </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Paket Gubrak</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/gubrak_pass">
            <?php echo form_label('password','for="gubrakpass"'); ?><br />
            <?php echo form_input('gubrakpass',set_value('gubrakpass'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
        </div>
	</div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">

/*	
    function sisa()
    {
        if($('#intcash').val() == ""){
            var a = 0;
        }else{
            var a = parseInt($('#intcash').val());
        }
        if($('#intkkredit').val() == ""){
            var b = 0;
        }else{
            var b = parseInt($('#intkkredit').val());
        }
        if($('#intdebit').val() == ""){
            var c = 0;
        }else{
            var c = parseInt($('#intdebit').val());
        }
        var d = parseInt($('#totalbayar1').val());
        var t = a + b + c;
        var sisa = d - t;
		$('#intsisa').val(formatAsDollars(-sisa));
        $('#intsisahidden').val(sisa);
		$("input[type=submit]").removeAttr("disabled");
    }
*/

    $('#frmjual').submit(function(event){

        if($("#intid_unit").val()==""){
            alert('Unit tidak Boleh Kosong!');
            $("#intid_unit").focus();
            event.preventDefault();
        }

        if($("#intjumlah").val()==""){
            alert('Belum ada Transaksi Barang!');
            event.preventDefault();
        }

        if($("#totalbayar").val()==""){
            alert('Belum ada Transaksi Barang!');
            event.preventDefault();
        }

        if($("#intid_jpenjualan").val()==""){
            alert('Anda Belum Memilih Jenis Penjualan!');
            event.preventDefault();
        }

    });


    var idx = 1;
    var idxf=1;
    var idx10 = 1;
    var idx20 = 1;
	
    $('#addBrg').bind('click', function(e){
        if($(".id1").val()=="" && $(".frees").val()==""){
            alert('Anda belum memilih barang!');
        }else if($('.id1').val() != "" && $("#tracker002").val() == "bayar") {		
			var brg = $('.id1').val();
			var jumlah = $('#jumlah').val();
			var harga = $('#harga_barang').val();
			var id_barang =  $('#id_barang').val();
			var pv =  $('#pv').val();
			var total = jumlah * harga;

			var out = '';
			if ($('#tracker001').val() > 0 || idx > 1) {
				for (var i = 1; i <= $('#tracker001').val(); i++) {
					if ($('.duapuluh_'+ i).val() == null)
					{
						idx = i;
					}
				}
			}
			out += 'Banyaknya<br>';
		if($("#chkBox20").attr('checked') == true){
                	out += '<input type="text"  id="hit20" name="hit20[]" value="'+idx+'">';
                	out += '<input id="'+idx+'" class="duapuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
            	}
		else if($("#chkBox10").attr('checked') == true){
                	out += '<input id="'+idx+'" class="sepuluh_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
                	out += '<input type="text" id="hit10" name="hit10[]" value="'+idx+'">';
		}
		else{
                	out += '<input type="text" id="hitaja" name="hitaja[]" value="'+idx+'">';
                	out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali(this.id); return lain2();" onkeypress="return isNumberKey(event)" />&nbsp;';
            	}           
			out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
			out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
			out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
            
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
            		out += '<input name="barang['+idx+'][intid_id]" type="text" value="'+id_barang+'">';
            		out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            		out = '<div style="height:60px">' + out + '</div>';
			$(out).insertBefore('#ButtonAdd');
			idx++;
			idx10++;
            		idx20++;
			$('.id1').val('');
			$('#jumlah').val('');
			$('#harga_barang').val('');
			$('#pv').val('');
		
       }
        return false;

    });


	$('#addBrg').bind('click', function(e){
		if($('.frees').val() != "" || ($('.id1').val() != "" && $("#tracker002").val() == "free"))
			{
				var brg = $('.id1').val();
				var jumlah = $('#jumlah').val();
				var harga = $('#harga_barang_free').val();
				var id_barang =  $('#id_free').val();
				var total = jumlah * harga;
				var out = '';

				out += '<sup>(Free)</sup>Banyaknya<br>';
				out += '<input type="text" id="hitfree10" name="hitfree10[]" value="'+idx+'">';
				out += '<input id="'+idx+'" class="free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="kali_sepuluh(this.id)" onkeypress="return isNumberKey(event)" />&nbsp;';
				
				out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly/>';
				out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
				out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
				out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="'+total+'" readonly>';
				out += '<input name="barang_free['+idx+'][intid_id]" type="text" value="'+id_barang+'">';
				out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a> ';
				out = '<div style="height:60px">' + out + '</div>';
				$(out).insertBefore('#ButtonAdd');
				idx++;
				idxf++;
				$('.id1').val('');
				$('#harga_barang_free').val('');
				$('#jumlah').val('');
				$('#harga_barang').val('');
			}
			return false;

    	});

    var jf=0;
	function kali_sepuluh(id){
       
		$("#del"+id).remove();
	if($("#chkBox10").attr('checked') == true){
            var cs2 = parseInt($('#hitfree10').val());
			var textpromo10 = parseInt($("#txtpromo10").val());
            
			for(var i=parseInt(cs2); i<= parseInt(id);i++){
                
				var jumlahfree = parseInt($('.free_'+ i).val());
                jf = jf + jumlahfree;
			}
						
			if(jumlahfree >= 0){
						
						if(jf > textpromo10){
							alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
							
						}

						if(jf >= textpromo10){
							$('#addBrg').attr('disabled', 'disabled');
							$('.frees').attr('disabled', 'disabled');
							
						}else{
							$('#addBrg').removeAttr('disabled');
							$('.frees').removeAttr('disabled');
							
						}
		 	}
        }

        if($("#chkBox20").attr('checked') == true){
            var cs2 = document.getElementsByName("hitfree20[]").length;
            var textpromo20 = parseInt($("#txtpromo20").val());
			
			var id_b = id + 2;
            for(var i=cs2+1 ; i<= parseInt(id);i++){
                var jumlahfree = Number($('.free20_'+ i).val());
				jf = Number(jf) + jumlahfree;
                                
            }
			var batas20 = textpromo20 * 3;	
			        if(jumlahfree > batas20){
                        alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
                    }
					if(cs2 >= batas20){
                        $('#addBrg').attr('disabled', 'disabled');
                        $('.frees').attr('disabled', 'disabled');
                        
                    }else{
                        $('#addBrg').removeAttr('disabled');
                        $('.frees').removeAttr('disabled');
                        
                    }
         }
     }

/*______________________________________________________________________
|									|
|									|
|									|
|									|
|				Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/

	/*
	* Password Handler
	*/
	$("#grandbutton1").bind('click', function(e){
      		if($("#grandpass").val() == "asd")
		{
			$("#entry").attr("style","display:block");
			$("#grandentry").attr("style","display:none");
		}
		else {
			$("#grandalert").attr("style","display:block;color:red;");
		}
		return false;
    	});

	/*
	* jenis penjualan combobox handler	
	*/
	$('#intid_jpenjualan').change(function(){
		$('#txtpromo10').val('');
		kali();
		
		if ($(this).attr('value')== 1)
		{
			var title = "Nota Penjualan Reguler";
			$('#title').text(title);
		}
		else if ($(this).attr('value')== 2) {
			var title = "Nota Penjualan Chall Hut";
			$('#title').text(title);
			$('#intpv').val(0);
		}
		else if ($(this).attr('value')== 3) {
			var title = "Nota Penjualan Challenge";
			$('#title').text(title);
		} 
	});	

	/*
	* promo checklist handler
	*/
	$("#chkBox20").click(function(){
      		autoComp();
		$("#chkV").attr("checked",false);
		$("#chkBox10").attr("checked",false);
		$("#txtpromo10").val("");
		$("#txtpromo20").val("");
		$("#txtpromo10").attr("disabled","disabled");
		$("#chkV10").attr("disabled","disabled");
		if($("#chkBox20").attr('checked') == true){
			$("#chkBox10").attr("checked",false);
			$("#txtpromo10").val("");
			$("#txtpromo20").val("");
			$("#txtpromo10").attr("disabled","disabled");
			$("#chkV10").attr("disabled","disabled");
			count = document.getElementsByName("hit20[]").length;
			var jmlbrg = parseInt($('#jumlahbrg20').val());
			var textpromo20 = parseInt($("#txtpromo20").val());
			$("#txtpromo20").attr("disabled","");
			if ($('#txtvoucher').val()==1){
				$("#chkV20").attr("disabled","disabled");
			} else {
				$("#chkV20").attr("disabled","");
			}
		}else{
			$('#addBrg').removeAttr('disabled');
			$('.id1').removeAttr('disabled');
			$('.frees').attr('disabled', 'disabled');
			$("#txtpromo20").attr("disabled","disabled");
			$("#chkV20").attr("disabled","disabled");
			$("#jumlahbrg20").val(' ');
			$("#jumlahsementara").val($("#intjumlah2hidden").val());
		}
    	});

     	$("#txtpromo20").keyup(function(){
            	$('#addBrg').removeAttr('disabled');
            	$('.id1').removeAttr('disabled');
     	});

	$("#chkBox10").click(function(){
      		autoCompPromo10();
		$("#chkV").attr("checked",false);
		$("#chkBox20").attr("checked",false);
		$("#txtpromo20").val("");
		$("#txtpromo10").val("");
		$("#txtpromo20").attr("disabled","disabled");
		$("#chkV20").attr("disabled","disabled");
        	if($("#chkBox10").attr("checked") == true){
			$("#chkBox20").attr("checked",false);
			$("#txtpromo20").val("");
			$("#txtpromo10").val("");
			$("#txtpromo20").attr("disabled","disabled");
			$("#chkV20").attr("disabled","disabled");
           		$("#txtpromo10").attr("disabled","");
			if ($('#txtvoucher').val()==1){
				$("#chkV10").attr("disabled","disabled");
			} else {
				$("#chkV10").attr("disabled","");
			}
        	}else{
			//$('#txtp10').val('');
            		$('#addBrg').removeAttr('disabled');
            		$('.id1').removeAttr('disabled');
            		$(".frees").attr("disabled","disabled");
            		$("#txtpromo10").attr("disabled","disabled");
			$("#chkV10").attr("disabled","disabled");
        	}
    	});
	
     	$("#txtpromo10").keyup(function(){
		$('#addBrg').removeAttr('disabled');
            	$('.id1').removeAttr('disabled');
		d = $("#txtp10").val();
		$("#txtps10").val(d);
    	});


	/*
	* voucher checklist handler
	*/
	$('#chkV').click(function(){
		if ($('#totalBayar').val() != '')
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			if ($('#chkV').attr('checked') == false)
			{
				kali();
				$('#intvoucher').val(0);
			}
			else {
				kali();
				$('#intvoucher').val(_voucher);
			}
		}
    	});

	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/
	function kaliasd(id){
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}		

		//itung jumlah barang total yg sudah di order dibantu pakai tracker bwt tau brp row barang yg udah keluar
		var _totalQuantity = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('.sepuluh001_'+ i).val()) != '')
				{
					_totalQuantity += parseInt($('.sepuluh001_'+ i).val());
				}
			}
		}

		//harga total barang setelah harga dikalikan dengan jumlah
		var _totalHarga = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				$('#total_' + i).val(parseInt($('.sepuluh001_'+ i).val()) * parseInt($('#harga_' + i).val()));
				if($('.sepuluh001_'+ i).val() == ''){$('#total_' + i).val(0);}
				_totalHarga += parseInt($('#total_' + i));
			}
		}

		/*______________________________________________________________________________
		|										|
		|			Kode yg bisa brubah2 tergantung promonya		|
		|______________________________________________________________________________*/

		//kalau jumlah sudah memenuhi kelipatan 2 dari promo do this pengurangan harga terkecil
		/*if (_totalQuantity >= 3)
		{
			var _multipleShow = new Array();
			for (var k = 1; k <= parseInt($('#tracker001').val()); k++) {
				_multipleShow[k] = 1;
			}
			for (var i = 1; i <= _totalQuantity/3; i++) {
				var _hargaTerkecil = 0;
				var _index = 0;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
						if (parseInt($('#total_'+ j).val()) > 0 && (parseInt($('#harga_'+ j).val()) < _hargaTerkecil || _hargaTerkecil == 0) )
						{
							_hargaTerkecil = parseInt($('#harga_'+ j).val());
							_index = j;
							if (parseInt($('#total_'+ j).val()) != parseInt($('.sepuluh001_'+ j).val()) * parseInt($('#harga_'+ j).val()))
							{
								_multipleShow[j] += 1;
							}
						}
					}
				}
				$('#total_'+ _index).val((parseInt($('.sepuluh001_'+ _index).val()) - _multipleShow[_index]) * parseInt($('#harga_'+ _index).val()));
			}
		}*/
		//kode baru promo yg bisa licik
		if (_totalQuantity % 3 == 2)
		{
			alert("Silakan Pilih Barang Gratis 1");
		}
		if (_totalQuantity >= 3)
		{
			var _multiply3 = 0;
			var _tempQuantity = 0;
			var _free = false;
			var _jumlahBarangFree = Math.floor(_totalQuantity / 3);
			for (var i = 1; i <= parseInt(_jumlahBarangFree); i++) {
				_multiply3 += 3;
				_tempQuantity = 0;
				_free = false;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ j).val()) >= 0 && parseInt($('#harga_'+ j).val()) >= 0 && parseFloat($('#pv_'+ j).val()) >= 0) {
						_tempQuantity += parseInt($('.sepuluh001_'+ j).val());
						if (_tempQuantity >= _multiply3 && _free == false)
						{
							$('#total_' + j).val(parseInt($('#total_' + j).val()) - parseInt($('#harga_'+ j).val()));
							_free = true;
						}
					}
				}
			}
		}

		/*
		* masukin smua list harga bwt smua barang ke dalam array lalu di sort dari harga termahal
		*
		var _tempArray = new Array();
		var k = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				for (var j = 1; j <= $('.sepuluh001_'+ i).val(); j++) {
					_tempArray[k] = $('#harga_'+ i).val()
					k++;
				}
			}
		}
		_tempArray.sort(function(a,b){return b-a});

		
		* array yg uda di sort setiap peringkat kelipatan 3 nya harga barang yg cocok dibikin gratis
		*
		if (_totalQuantity >= 3)
		{
			var _multiply3 = 2;
			var _free = false;
			var _jumlahBarangFree = Math.floor(_totalQuantity / 3);
			for (var i = 1; i <= parseInt(_jumlahBarangFree); i++) {
				_free = false;
				for (var j = 1; j <= parseInt($('#tracker001').val()); j++) {
					if (parseInt($('#total_'+ j).val()) >= 0 && parseInt($('#harga_'+ j).val()) >= 0 && parseFloat($('#pv_'+ j).val()) >= 0) {
						if ($('.sepuluh001_'+ j).val() != 0 && $('#total_' + j).val() != 0 && $('#harga_'+ j).val() == _tempArray[_multiply3] && _free == false)
						{
							$('#total_' + j).val(parseInt($('#total_' + j).val()) - parseInt($('#harga_'+ j).val()));
							_free = true;
						}
					}
				}
				_multiply3 += 3;
			}
		}*/

		/*______________________________________________________________________________
		|										|
		|		End Of Kode yg bisa brubah2 tergantung promonya			|
		|______________________________________________________________________________*/

		//total semua harga barang yg di order di nota ini
		var _total = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
				if (parseInt($('#total_'+ i).val()) >= 0)
				{
					_total += parseInt($('#total_'+ i).val());
					$('.sepuluh_'+ i).val($('#total_'+ i).val() / $('#harga_'+ i).val());
					$('.free_'+ i).val($('.sepuluh001_'+ i).val() - $('.sepuluh_'+ i).val());
					if ($('.free_'+ i).val() == 0)
					{
						$('#barang_free001_'+ i).val('');
					}
					else {
						$('#barang_free001_'+ i).val($('#brg001_'+ i).val());
					}
					if ($('.sepuluh_'+ i).val() == 0)
					{
						$('#barang001_'+ i).val('');
					}
					else {
						$('#barang001_'+ i).val($('#brg001_'+ i).val());
					}
				}
			}
		}

		//masukin total harga ke textbox bawah yg diatas tombol simpan
		$('#intjumlah1').val(_total);
		$('#intjumlah').val(parseInt($('#intjumlah1').val()) + parseInt($('#intjumlah2').val()));
		$('#totalbayar').val(parseInt($('#intjumlah').val()));

		//total semua pv yg di didapat di nota ini
		var _totalPV = 0;
		if ($('#intid_jpenjualan').attr('value') != 2)
		{
			for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
				if (parseInt($('#total_'+ i).val()) >= 0 && parseInt($('#harga_'+ i).val()) >= 0 && parseFloat($('#pv_'+ i).val()) >= 0) {
					_totalPV += (parseInt($('#total_'+ i).val()) / parseInt($('#harga_'+ i).val())) * parseFloat($('#pv_'+ i).val());
				}
			}
			$('#intpv').val(_totalPV.toFixed(2));
		}

		//hitung komisi 10% dan kurangi totalbayar
		if ($('#intjumlah1').val() != '')
		{
			$('#komisi1').val(parseInt($('#intjumlah1').val()) * 0.1);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi1').val()));
		}

		//hitung komisi 20% dan kurangi totalbayar
		if ($('#intjumlah2').val() != '')
		{
			$('#komisi2').val(parseInt($('#intjumlah2').val()) * 0.2);
			$('#totalbayar').val(parseInt($('#totalbayar').val()) - parseInt($('#komisi2').val()));
		}
		
		//apabila voucher di checklist
		if ($("#chkV").attr('checked') == true)
		{
			var _voucher = 0;
			if ($('#id_wilayah').val() == 1){
				_voucher = 50000;
			} else {
				_voucher = 60000;
			}
			$('#intjumlah1').val(parseInt($('#intjumlah1').val()) - _voucher);
			$('#intjumlah').val(parseInt($('#intjumlah').val()) - _voucher);
			$('#intpv').val(parseFloat($('#intpv').val()) - (_voucher / 100000));
			$('#komisi1').val(parseInt($('#komisi1').val()) - (_voucher * 0.1));
			$('#totalbayar').val((parseInt($('#intjumlah').val()) - parseInt($('#komisi1').val())) - parseInt($('#komisi2').val()));
		}

		//kirim smua hasil hitungan ke textbox hidden yg akan di submit ke halaman berikutnya yaitu print
		$('#intjumlah1hidden').val($('#intjumlah1').val());
		$('#intjumlahhidden').val($('#intjumlah').val());
		$('#komisi1hidden').val($('#komisi1').val());
		$('#totalbayar1').val($('#totalbayar').val());

		//format smua angka as rupiah
		$('#intjumlah1').val(formatAsRupiah(parseInt($('#intjumlah1').val())));
		$('#intjumlah').val(formatAsRupiah(parseInt($('#intjumlah').val())));
		$('#komisi1').val(formatAsRupiah(parseInt($('#komisi1').val())));
		$('#totalbayar').val(formatAsRupiah(parseInt($('#totalbayar').val())));

		sisa();

		return false;
	}

	/**
	* function sisa yg baru
	*/
	function sisa() {
		var _cash = 0;
		var _kredit = 0;
		var _debit = 0;
		
		if ($('#intcash').val() == '' && $('#intkkredit').val() == '' && $('#intdebit').val() == '')
		{
			$('#intsisa').val('');
			$('#intsisahidden').val('');
			$("input[type=submit]").attr('disabled','disabled');
		}
		else {
			if ($('#intcash').val() != '') {_cash = parseInt($('#intcash').val());}
			if ($('#intkkredit').val() != '') {_kredit = parseInt($('#intkkredit').val());}
			if ($('#intdebit').val() != '') {_debit = parseInt($('#intdebit').val());}
			var _bayar = _cash + _kredit + _debit;

			$('#intsisa').val(formatAsRupiah(-(unformatFromRupiah($('#totalbayar').val()) - _bayar)));
			$('#intsisahidden').val(unformatFromRupiah($('#totalbayar').val()) - _bayar);			
			$("input[type=submit]").removeAttr("disabled");
		}
	}

	/**
	* function formatAsRupiah yg baru dan unformatFromRupiah
	* @param amount (angka int yg bakal dirubah ke rupiah)
	*/
	function formatAsRupiah(amount){
        	if (isNaN(amount)) {
            		return "0,00";
        	}
        	amount = Math.round(amount*100)/100;
        	var amount_str = String(amount);
        	var amount_array = amount_str.split(",");
        	if (amount_array[1] == undefined) {
            		amount_array[1] = "00";
        	}
        	if (amount_array[1].length == 1) {
            		amount_array[1] += "0";
        	}
        	var dollar_array = new Array();
        	var start;
        	var end = amount_array[0].length;
        	while (end>0) {
            		start = Math.max(end-3, 0);
            		dollar_array.unshift(amount_array[0].slice(start, end));
            		end = start;
        	}
        	amount_array[0] = dollar_array.join(".");

        	return (amount_array.join(","));
    	}
	function unformatFromRupiah(_amount){
		var _split = _amount.split(".");
		var _array = 0;
		for(var i = 0; i <= Math.round(((_amount.length - 3) / 3)); i++){
			_array += _split[i - 1];
		}
		if (_array.substr(0,1) == '0')
		{
			_array.substr(1);
			return(parseInt(_array.substr(1)));
		}
		if (_array.substr(0,3) == 'NaN')
		{
			_array.substr(3);
			return(parseInt(_array.substr(3)));
		}
		return (parseInt(_array));
	}

/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End Of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/


function kali(id){
        var jml=0;
        var pivi=0;

        var totaldua=0;
        var total=0;
        var jmlpv=0;
        var j=0;
		

        var limit20 = $('#txtpromo20').val();
        var limit10 = parseInt($('#txtpromo10').val());
        var limitfreehut = $('#txtfreehut').val();
        var limitfree = $('#txtfree').val();
        $("#del"+id).remove();

		id = id || $('#tracker001').val();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}

        if($("#chkBox20").attr('checked') == true){

            var cs = document.getElementsByName("hit20[]").length;
			if(cs > 1){
				var sid = cs + 1;
			}else{
				var sid = cs;
			}
            var lim20 = limit20;


             for(var i=sid; i<= parseInt(id);i++){

                var jumlah = parseInt($('.duapuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
			if(jumlah > parseInt($('#txtpromo20').val())){
                            alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
                            break;
                        }

                }
            }

			for(var i=1; i<= parseInt(id);i++){

                var jumlah = parseInt($('.duapuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;


                }
            }

            $('#jumlahbrg20').val(jml);

            var j20 = parseInt($('#jumlahbrg20').val());


            if(j20 >= lim20){
                $('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
            }

            if($('#komisihide').val() != ""){
                var komhide = parseInt($('#komisihide').val());
                var s = komhide + total;
            }else{
                var s = total;
            }

            if($("#chkV20").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){
					sall=s-50000;
					$('#intvoucher').val(50000);
				} else {
					sall=s-60000;
					$('#intvoucher').val(60000);
				}
				
				$('#txtvoucher').val(1);
			} else {
				sall=s;
			}

		if($('#chkV').attr('checked') == true && sall < 0)
		{
			sall = 0;
		}

            $('#intjumlah2').val(formatAsDollars(sall));
            $('#intjumlah2hidden').val(sall);

            var total = parseInt($('#intjumlah2hidden').val());

	if($('#intid_jpenjualan').val() != 7) {

            var disc = 20;
            var komisi20 = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi20 < 0)
		{
			komisi20 = 0;
		}

            $('#komisi2').val(formatAsDollars(komisi20));
            $('#komisi2hidden').val(komisi20);

	}

        }else if($("#chkBox10").attr('checked') == true){

			var csfree = parseInt($('#hit10').val());
			var tt = limit10 * 2;
			

	    	var ju=0;
            for(var i=parseInt(csfree); i<= parseInt(id);i++){
                var jumlah = parseInt($('.sepuluh_'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                var pv = parseFloat($('#pv_' + i).val());
				
                if(jumlah >= 0){

                    if(harga >= 0){

                       var tot = jumlah * harga;
                            $('#total_' + i).val(tot);
                            total += tot;
                            j = j+jumlah;
							ju = ju + jumlah;

                    }	
                }

            }

            $('#jumlahbrg10').val(j);
			
			
			if(jumlah > tt){
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			$('#txtp10').val(j);
            			
			if($("#txtps10").val()==''){
				var j10 = j;
			}else{
				j10 = j - $("#txtps10").val();
			}
				
			if(j10 >= tt){
                $('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');

            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
            }
			
			if($("#chkV10").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){
					total10=total-50000;
					$('#intvoucher').val(50000);
				} else {
					total10=total-60000;
					$('#intvoucher').val(60000);
				}
				$('#txtvoucher').val(1);
			} else {
				total10=total;
			}

		if($('#chkV').attr('checked') == true && total10 < 0)
		{
			total10 = 0;
		}

            $('#intjumlah1').val(formatAsDollars(total10));
            $('#intjumlah1hidden').val(total10);
            var total = parseInt($('#intjumlah1hidden').val());

	if($('#intid_jpenjualan').val() != 7) {

            var disc = 10;
            var komisi = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}

            if($('#komisi1hidden').val()!=""){
               	var totkom = komisi;
                $('#komisi1hidden').val(totkom);
                $('#komisi1').val(formatAsDollars(totkom));
            }else{
                $('#komisi1hidden').val(komisi);
                $('#komisi1').val(formatAsDollars(komisi));
            }

	}

        }else
            if($("#chkBoxFreeHut").attr('checked') == true){
                var cs3 = $('#hitfreehut').val();
                var jfreehut = 0;
                for(var i=cs3; i<= parseInt(id);i++){

                    var jumlah = parseInt($('.onefreehuts_'+ i).val());
                   	var harga = parseInt($('#harga_' + i).val());
					var pv = parseFloat($('#pv_' + i).val());
                    var tot = jumlah * harga;
					if(tot>=0){
						
						$('#total_' + i).val(Number(tot));
						total += tot;
						jfreehut += jumlah;
							
					}

                }
			
			$('#onefreehut').val(jfreehut);
            			
			if($("#onesfreehut").val()==''){
				var jfh = jfreehut;
			}else{
				jfh = jfreehut - $("#onesfreehut").val();
			}	
            
			//$('#jumlahbrgfreehut').val(jfreehut);
            
			if(jfh > limitfreehut){
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			if(jfh >= limitfreehut){
               	$('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
            }else{
                $('#addBrg').removeAttr('disabled');
                $('.id1').removeAttr('disabled');
            }
            
			$('#intjumlah1').val(formatAsDollars(total));
            $('#intjumlah1hidden').val(total);
			//$('#intjumlahfree').val(total);


        }else if($("#chkBoxFree").attr('checked') == true){

                var cs3 = $('#hitfree').val();
                var jfree = 0;
                for(var i=cs3; i<= parseInt(id);i++){
                    
                    var jumlah = parseInt($('.onefrees_'+ i).val());
                    var harga = parseInt($('#harga_' + i).val());
					var pv = parseFloat($('#pv_' + i).val());
                    var tot = jumlah * harga;
						
						if(tot>=0){
						$('#total_' + i).val(Number(tot));
						total += tot;
						jfree += jumlah;
						}
				}
						
            //$('#jumlahbrgfree').val(jfree);
                   
			$('#onefree').val(jfree);
            			
			if($("#onesfree").val()==''){
				var jf = jfree;
			}else{
				var jf = jfree;
				jf = jfree - $("#onesfree").val();
			}	
			
			if(jf > limitfree){
				alert('Anda Memasukan Jumlah Barang yang Tidak Sesuai!');
			}
			
			if(jf >= limitfree){
				$('#addBrg').removeAttr('disabled');
				//$('.id1').attr('disabled', 'disabled');
				$('.frees').removeAttr('disabled');
			}else{
				$('#addBrg').removeAttr('disabled');
				$('.id1').removeAttr('disabled');
				$('.frees').attr('disabled', 'disabled');
			}

			var disc = 10;
            var komisi = (total * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}
            
			if($('#komisi1hidden').val()!=""){

                var totkom = komisi;
                $('#komisi1hidden').val(totkom);
                $('#komisi1').val(formatAsDollars(totkom));
            }else{
                $('#komisi1hidden').val(komisi);
                $('#komisi1').val(formatAsDollars(komisi));
            }

		if($('#chkV').attr('checked') == true && total < 0)
		{
			total = 0;
		}
			
			$('#intjumlah1').val(formatAsDollars(total));
            $('#intjumlah1hidden').val(total);
			//$('#intjumlahfree').val(total);
       
	   }else if($("#chkBoxTrade").attr('checked') == true){
            var cs = $('#hittrade').val();

            for(var i=cs; i<= parseInt(id);i++){

                var jumlah = parseInt($('#'+ i).val());
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){

                    if(harga >=0){
                        var tot = jumlah * harga;
                        $('#total_' + i).val(tot);
                        total += tot;
                        totaldua += tot;
                        jml += jumlah;
                    }
                }
            }


            var komtrade = parseInt($('#komisitrade').val());
            var totkom = (total * komtrade) /100;



			$('#komisi1hidden').val(totkom);
            var jumhide = parseInt($('#intjumlahhidden').val());
            var totOm = total - parseInt($('#komisi1hidden').val());
			var komtrade = (totOm*10)/100;

		if($('#chkV').attr('checked') == true && komtrade < 0)
		{
			komtrade = 0;
		}

				$('#komisihide').val(formatAsDollars(komtrade));
				$('#komisi1').val(formatAsDollars(komtrade));
				$('#komisi1hidden').val(komtrade);

                var jumtothide = totOm;

		if($('#chkV').attr('checked') == true && jumtothide < 0)
		{
			jumtothide = 0;
		}

				$('#intjumlah').val(formatAsDollars(jumtothide));
                $('#intjumlahtradehidden').val(jumtothide);

            $('#intpv_trade').val(jumtothide/100000);


		} else if($("#intid_jpenjualan").val()==7){
		//for netto
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                if(jumlah >=0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
                }
            }

                $('#intjumlah2hidden').val(total);

        //end netto
		} else if($("#intid_jpenjualan").val()==8){
		//for lain-lain
			
			//var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());
                
                var t = jumlah * harga;
			    $('#total_' + i).val(t);
                total += t;
             }
				
				$('#intjumlah2hidden').val(total);
						
				$('#intjumlah1').val('0');
				$('#intjumlah2').val('0');
				$('#intjumlah').val('0');
				$('#intpv').val('0');
				$('#komisi2').val('0');
				$('#komisi1').val('0');
				$('#komisi1hidden').val('0');
				$('#komisi2hidden').val('0');
	    //end lain-lain
		}
        else{

            var csaja = document.getElementsByName("hitaja[]").length;
            for(var i=1; i<= parseInt(id);i++){

                var jumlah = $('.semua_'+ i).val();
                var harga = parseInt($('#harga_' + i).val());

                if(jumlah >=0){
                    var t = jumlah * harga;
                    $('#total_' + i).val(t);
                    total += t;
                }
            }

            			    
				if($("#chkV").attr('checked') == true){
					if ($('#id_wilayah').val() == 1){
						totalreg=total-50000;
						$('#intvoucher').val(50000);
					} else {
						totalreg=total-60000;
						$('#intvoucher').val(60000);
					}
					$('#txtvoucher').val(1);
				} else {
					totalreg=total;
				}
				
				
			if ($('#jumlahsementara').val()!= ""){
				var x = parseInt($('#jumlahsementara').val()) + totalreg;

		if($('#chkV').attr('checked') == true && x < 0)
		{
			x = 0;
		}

				$('#intjumlah2').val(formatAsDollars(x));
            	$('#intjumlah2hidden').val(x);
			} else {

		if($('#chkV').attr('checked') == true && totalreg < 0)
		{
			totalreg = 0;
		}

				$('#intjumlah2').val(formatAsDollars(totalreg));
            	$('#intjumlah2hidden').val(totalreg);

            }
			
			//$('#intjumlah2').val(formatAsDollars(totalreg));
            //$('#intjumlah2hidden').val(totalreg);
			$('#komisihide').val(total);

            var t = parseInt($('#intjumlah2hidden').val());
            var disc = 20;
            var komisi = (t * disc) / 100;

		if($('#chkV').attr('checked') == true && komisi < 0)
		{
			komisi = 0;
		}

            $('#komisi2').val(formatAsDollars(komisi));
            $('#komisi2hidden').val(komisi);
			
			
			
        }


        for(var i=1; i<= parseInt(id);i++){
            if($('#' + i).val() != ""){
                var jumlah = parseInt($('#'+ i).val());
                var pv = parseFloat($('#pv_' + i).val());
                var jpv = jumlah * pv;
                if(jpv >= 0){
                     pivi +=jpv;
                }
            }
        }
		

        if($("#chkV20").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
		} else {
				pivi=pivi;
		}

		if($("#chkV10").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
		} else {
				pivi=pivi;
		}
		
		if($("#chkV").attr('checked') == true){
				if ($('#id_wilayah').val() == 1){ 
					pivi=pivi-0.5;
				} else {
					pivi=pivi-0.6;
				}
		} else {
				pivi=pivi;
		}
		
		//pv for HUT
		if($("#intid_jpenjualan").val()==2){
			pivi = 0
		}

        if($('#intpv_trade').val() != ""){
            var trade_pv = parseFloat($('#intpv_trade').val());
            var pvt = trade_pv;


            $('#intpv').val(formatNumber(pvt));
        }else{
            $('#intpv').val(formatNumber(pivi));
        }

        function formatNumber(num)
        {
            var n = num.toString();
            var nums = n.split('.');
            var newNum = "";
            if (nums.length > 1)
            {
                var dec = nums[1].substring(0,2);
                newNum = nums[0] + "." + dec;
            }
            else
            {
                newNum = num;
            }
            return (newNum)
        }

        if($('#komisi1hidden').val() == ""){
            var kom1 = 0;
        }else{
            var kom1 = parseInt($('#komisi1hidden').val());
        }
        if($('#komisi2hidden').val() == ""){
            var kom2 = 0;
        }else{
            var kom2 = parseInt($('#komisi2hidden').val());
        }
        if($('#intjumlahhidden').val() == ""){
            var intjum = 0;
        }else{
            var intjum = parseInt($('#intjumlahhidden').val());
        }

        if($('#intjumlahtradehidden').val() == ""){
            var intjumt = 0;
        }else{
            var intjumt = parseInt($('#intjumlahtradehidden').val());
        }

        if($('#intjumlah1hidden').val() == ""){
            var intjum1 = 0;
        }else{
            var intjum1 = parseInt($('#intjumlah1hidden').val());
        }
        if($('#intjumlah2hidden').val() == ""){
            var intjum2 = 0;
        }else{
            var intjum2 = parseInt($('#intjumlah2hidden').val());
        }
        if($('#intjumlahfree').val() == ""){
            var intjumfree = 0;
        }else{
            var intjumfree = parseInt($('#intjumlahfree').val());
        }

        var omset = intjum1 + intjum2 + intjumfree + intjumt;

		if($('#chkV').attr('checked') == true && omset < 0)
		{
			omset = 0;
		}

        $('#intjumlah').val(formatAsDollars(omset));
        $('#intjumlahhidden').val(omset);

        var totals = omset - kom1 - kom2;

		if($('#chkV').attr('checked') == true)
		{
			if(totals < 0){totals = 0;}
			if(parseFloat($('#intpv').val()) < 0){$('#intpv').val(0);}
			if(parseFloat($('#intpv_trade').val()) < 0){$('#intpv_trade').val(0);}
		}

        $('#totalbayar').val(formatAsDollars(totals));
        $('#totalbayar1').val(totals);
	autoComp();
    }

    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })

/*	
	$('#intid_jpenjualan').change(function()
    {
	$("#txtpromo10").val("");
	
        if ($(this).attr('value')== 1)
        {
            var title = "Nota Penjualan Reguler";
            $("#title").text(title);
        } else  if ($(this).attr('value')== 2)
        {
            var title = "Nota Penjualan Chall Hut";
            $("#title").text(title);
        } else  if ($(this).attr('value')== 3)
        {
            var title = "Nota Penjualan Challenge";
            $("#title").text(title);
        } 
    });
*/

/*
	$("#txtpromo10").keyup(function(){
		$('#addBrg').removeAttr('disabled');
            	$('.id1').removeAttr('disabled');
		d = $("#txtp10").val();
		$("#txtps10").val(d);
		e = $("#txtf10").val();
		$("#txtfs10").val(e);
    	});
*/
	
    function formatAsDollars(ObjVal) {

        mnt = ObjVal;

        mnt -= 0;

        mnt = (Math.round(mnt*100))/100;

        ObjVal = (mnt == Math.floor(mnt)) ? mnt + '.00' : ( (mnt*10 == Math.floor(mnt*10)) ? mnt + '0' : mnt);

        if (isNaN(ObjVal)) {ObjVal ="0.00";}

        return ObjVal;
    }

    

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

