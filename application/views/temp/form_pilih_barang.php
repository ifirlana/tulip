<table>
                        <tr>
                            <td colspan='6'>&nbsp;<input type='hidden' name='textfield' id='txtp10' />
                                                        <input type='hidden' id='id_wilayah' value='<?php echo $intid_wilayah; ?>' />
                                                        <div align='center' id='title'></div>
                                </td>
                        </tr>
                        <tr>
                            <td colspan='6'><table width='100%' border='1' id='data' align='center'>
                                                        <tr>
                                                            <td width='116'>&nbsp;Silahkan ketik</td>
                                                            <td width='367'>&nbsp;Nama Barang</td>
                                                            <td width='87' rowspan='2'>Harga<br />
                                                                <div id='<?php echo $output_pemilihan_barang; ?>'></div>
                                                            </td>
                                                            <td width='63' rowspan='2'>
                                                                <div id='data'>
                                                                    <input type='button' id='<?php echo $id_button;?>' name='<?php echo $id_button;?>' value='Tambah' />
                                                                    <input type='hidden' id='<?php echo $tracker_intid;?>' value='0' />
                                                                    <input type='hidden' id='<?php echo $tracker_status;?>' value='bayar' />
                                                                    <input type='hidden' id='<?php echo $tracker_free;?>' value='0' />
                                                                </div>    
                                                            </td>
                                                        </tr>
                                                        <tr id='ganti_bayar'>
                                                            <td style='background:yellow;'>&nbsp;Pilih Barang -&gt;
                                                                <input type='hidden' name='barang[1][intquantity]' id='jumlah' size='5' /></td>
                                                            <td>&nbsp;
                                                                <input type='text' name='barang[1][intid_barang]' id= '<?php echo $id_bayar;?>' class='<?php echo $class_bayar;?>' size='50' /></td>
                                                        </tr>
                                                        <tr id='ganti_free' style='display:none;'>
                                                            <td style='background:green;'>&nbsp;Pilih Barang Free -&gt;</td>
                                                            <td>&nbsp;&nbsp;<input type='text' name='free' id ='<?php echo $id_free;?>' class='<?php echo $class_free;?>' size='50' /><div id='result2'></div></td>
                                                            
                                                        </tr>
                                                            <tr>
                                                                <td colspan='4'>
                                                                    <div id='<?php echo $list_barang;?>'></div></td>
                                                            </tr>
                                            </table>
                            </td>
                        </tr>
                </table><script>
                        var idc = 0;
                        $(function() {
                            $("#tracker_009").val('bayar');
                            $("#tracker_free").val(0);
                            $("#id_bayar").click(function(){
                                $("#result1").html('');
                                $("#id_bayar").val('');
                                $("#id_jenis_penjualan_temp").attr('disabled','disabled');
                                hitungsisa();
                            });
                            $("#id_free").click(function(){
                                $("#result1").html('');
                                $("#id_free").val('');
                               hitungsisa();
                            });
                            
                    $(".class_bayar").autocomplete({
                                                    minLength: 5,
                                                    selectFirst: true,
                                                    source:
                                                        function(req, add){
                                                        $.ajax({                                 	
															url: '<?php echo base_url();?>penjualan/lookupBarangSpecialCabangDis',                                    
															dataType: 'json',
                                                            type: 'POST',
                                                            data: {
                                                                    term: req.term,
                                                                    cabang: 1 
                                                                 },
                                                            success:
                                                                function(data){
                                                                if(data.response =='true'){
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
                                                            "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                                                                );
                                                            $("#tracker_intid").val(ui.item.id);
                                                    },
                                                });
                    $(".class_free").autocomplete({
                                                    minLength: 5,
                                                    selectFirst: true,
                                                    source:
                                                        function(req, add){
                                                        $.ajax({
                                                            url: '<?php echo base_url();?>penjualan/lookupBarangSpecialToday_FREE',
                                                            dataType: 'json',
                                                            type: 'POST',
                                                            data: {
                                                                    term: req.term,
                                                                    state: $("#tracker_intid").val(),
                                                                    cabang: 1,
                                                                 },
                                                            success:
                                                                function(data){
                                                                if(data.response =='true'){
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
                                                            "<input type='text' id='harga_barang' name='harga_barang' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='0' size='15' />"
                                                                );
                                                    },
                                                });
                    $("#addBrg").click(function(){
                        idc++;
                        var brg = $("#id_bayar").val();
                        var brg_free = $("#id_free").val();
                        var jumlah = $('#jumlah').val();
                        var harga = $('#harga_barang').val();
                        var id_barang =  $('#id_barang').val();
                        var pv =  $('#pv').val();
                        var total = jumlah * harga;
                        var nomor_nota = $('#nomor_nota').val();
                        var out = '';     if($("#result1").html() == ''){
                            alert('Anda Belum memilih dengan benar.');
                            }else if($("#tracker_009").val() == 'bayar' && $("#result1").html() != ''){
                                    out += "Barang Berbayar Banyaknya : <br />";
                                    if($("#<?php echo $id_jenis_penjualan; ?>").val() == 26)
									{ // Chall SC
										out += "<input id='" + idc + "' class='semua_" + idc + "' name='barang["+idc+"][intquantity]' type='text' size='1' value='" + jumlah + "' onkeyUp='hitungpembayaran(this.id)' onkeypress='return isNumberKey(event)' />&nbsp;";
									}
									else
									{	 // Special Today
										out += "<input id='" + idc + "' class='duapuluh_" + idc + "' name='barang["+idc+"][intquantity]' type='text' size='1' value='" + jumlah + "' onkeyUp='hitungpembayaran(this.id)' onkeypress='return isNumberKey(event)' />&nbsp;";
									}									
                                    out += "<input name='barang["+idc+"][intid_barang]' type='text' size='50' value='" + brg + "'  readonly />";
                                    out += "&nbsp;Harga:&nbsp;<input id='harga_" + idc + "' name='barang["+idc+"][intid_harga]' type='text' size='5' value='" + harga + "' readonly />";
                                    out += "&nbsp;PV:&nbsp;<input id='pv_" + idc + "' name='pv["+idc+"][intpv]' type='text' size='1' value='" + pv + "' readonly />";
                                    out += "&nbsp;Total:&nbsp;<input id='total_" + idc + "' name='barang["+idc+"][intid_total]' type='text' size='5' value='" + total + "' readonly />";
                                    out += "<input id='barang_" + idc + "_intid_id' name='barang["+idc+"][intid_id]' type='hidden' value='"+id_barang+"'>";
                                    out += "<input id='nomornota_" + idc + "_intid_id' name='barang["+idc+"][nomor_nota]' type='hidden' value='"+$("#nomor_nota").val()+"'>";
                                    out += "<input id='promo_" + idc + "' name='barang["+idc+"][promo]' type='hidden' value='SpecialToday'>";
                                    if($("#<?php echo $id_jenis_penjualan; ?>").val() == 26) 
									{ // Chall SC
										out += "<input id='status_" + idc + "' name='barang["+idc+"][status]' type='hidden' value='chsc'>";
                                    }
									else 
									{ // Special Today
										out += "<input id='status_" + idc + "' name='barang["+idc+"][status]' type='hidden' value='spct'>";
                                    }
									out += "<a href='#hapus' class='delRow' onclick='$(this).parent().remove()' id='del" + idc + "'>hapus</a> ";

                                    $("#id_bayar").val('');
                                    out = "<div style='min-height:20px;width:95%;background:yellow;padding:10px 10px 10px 10px;'>"+out+"</div>";
                                }else if($("#tracker_009").val() == 'free' && $("#result1").html() != ''){
                                    out += "Barang free Banyaknya : <br />";
                                    out += "<input id='" + idc + "' class='free_" + idc + "' name='barang["+idc+"][intquantity]' type='text' size='1' value='" + jumlah + "' onkeyUp='hitungfree(this.id)' onkeypress='return isNumberKey(event)' />&nbsp;";       
                                    out += "<input name='barang["+idc+"][intid_barang]' type='text' size='50' value='" + brg_free + "'  readonly />";
                                    out += "&nbsp;Harga:&nbsp;<input id='harga_" + idc + "' name='barang["+idc+"][intid_harga]' type='text' size='5' value='0' readonly />";
                                    out += "&nbsp;PV:&nbsp;<input id='pv_" + idc + "' name='pv["+idc+"][intpv]' type='text' size='1' value='0' readonly />";
                                    out += "&nbsp;Total:&nbsp;<input id='total_" + idc + "' name='barang["+idc+"][intid_total]' type='text' size='5' value='0' readonly />";
                                    out += "<input id='barang_" + idc + "_intid_id' name='barang["+idc+"][intid_id]' type='hidden' value='"+id_barang+"'>";
                                    out += "<input id='nomornota_" + idc + "_intid_id' name='barang["+idc+"][nomor_nota]' type='hidden' value='"+$("#nomor_nota").val()+"'>";
                                    out += "<input id='promo_" + idc + "' name='barang["+idc+"][promo]' type='hidden' value='FREEToday'>";
                                    out += "<input id='status_" + idc + "' name='barang["+idc+"][status]' type='hidden' value='spct'>";
                                    out += "<a href='#hapus' class='delRow' onclick='$(this).parent().remove()' id='del" + idc + "'>hapus</a> ";

                                    $("#id_bayar").val('');
                                    out = "<div style='min-height:20px;width:95%;background:green;padding:10px 10px 10px 10px;'>"+out+"</div>";
                            }
                                $("#result_hasil").append(out);
                                $("#result1").html('');
                    });
                            //hitung sisa penjualan
                             $("#id_formPembayaran_cash").keyup(function() {
                                totalbayar = parseInt($('#id_formPembayaran_totalbayar').val());
                                cash        = parseInt($('#id_formPembayaran_cash').val());
                                $("#id_formPembayaran_sisa").val(totalbayar - cash);
                                if($("#id_formPembayaran_sisa").val() > 0){
                                     $('input[type=submit]').removeAttr('disabled');
                                 }
                                        });
                            });
                            function hitungfree(id){
                                $('#del'+id).remove();
                                var total = 0;
                                var t_jumlah = 0;
                                for(i=0;i<=idc;i++) {
                                    t_jumlah = $('.free_'+i+'').val();
                                    if(isNaN(t_jumlah)){
                                        t_jumlah = 0;
                                    }
                                    //special today
                                    if( $('#promo_'+i+'').val() == 'FREEToday'){
                                            total = parseInt(total) + parseInt(t_jumlah);
                                            }
                                    }
                                if( $('#promo_'+id+'').val() == 'FREEToday'){
                                    if(total > $("#tracker_free").val()){
                                        alert('jumlah melebihi free promo');
                                        $('.free_'+id+'').val(0);
                                    }else if(total == $("#tracker_free").val()){
                                        //berhasil memenuhi
                                        $("#tracker_009").val('bayar');
                                        $("#tracker_free").val(0);
                                       
                                        for(i=0;i<=idc;i++) {
                                            t_jumlah = $('.free_'+i+'').val();
                                            if(isNaN(t_jumlah)){
                                                t_jumlah = 0;
                                            }
                                            //special today
                                            if( $('#promo_'+i+'').val() == 'FREEToday'){
                                                    $('#promo_'+i+'').val('oke!');
                                                    $('#'+i+'').attr('readonly','readonly');
                                                    
                                                    }
                                            if($('#promo_'+i+'').val() == 'SpecialToday'){
                                                    $('#promo_'+i+'').val('oke!');
                                                    $('#'+i+'').attr('readonly','readonly');
                                                   
                                                 }
                                            }

                                        alert('silahkan lanjutkan promo berikutnya');
                                        $('#ganti_free').css({'display':'none'});
                                        $('#ganti_free').attr('disabled','disabled');
                                        $('#ganti_bayar').removeAttr('style');
                                        $('#ganti_bayar').removeAttr('disabled','disabled');
                                    }
                                }
                            }
                            function hitungpembayaran(id){
                                     $('#del'+id).remove();
        
                                    hitungsisa();
                                  //  promo10();
								  diskon30();
                                }
                            function promo10(){
                                var total = 0;
                                for(i=0;i<=idc;i++) {
                                    //var t_jumlah = $('#'+i+'').val();
                                    //alert(t_jumlah);
                                        if($('#barang_"+i+"_intid_id').val() != ''){
                                            //special today
                                            if( $('#promo_'+i+'').val() == 'SpecialToday'){
                                                var t_jumlah = $('#'+i+'').val();
                                                total = parseInt(total) + parseInt(t_jumlah);
                                                }
                                            }
                                    }
                                    answer = total % 2;
                                    pass = total / 2;
                                    //alert('answer :'+answer+', '+pass+'');
                                    if(answer == 0 && pass >= 1){
                                        for(i=0;i<=idc;i++) {
                                            if($('#barang_"+i+"_intid_id').val() != ''){
                                                //special today
                                                if( $('#promo_'+i+'').val() == 'SpecialToday'){
                                                    ///attribut nya di readonly
                                                    }
                                                }
                                        }
                                        //alert('silahkan pilih barang free');
                                        $("#tracker_009").val('free');
                                        $("#tracker_free").val(pass);
                                        $('#ganti_free').removeAttr('style');
                                        $('#ganti_free').removeAttr('disabled');
                                        $('#ganti_bayar').css({'display':'none'});
                                        $('#ganti_bayar').attr('disabled');
                                        }else{
                                            $("#tracker_009").val('bayar');
                                            $("#tracker_free").val(0);
                                            $('#ganti_free').css({'display':'none'});
                                            $('#ganti_free').attr('disabled');
                                            $('#ganti_bayar').removeAttr('style');
                                            $('#ganti_bayar').removeAttr('disabled');
                                            }

                                   
								}
							 function diskon30(){
                                var total = 0;
                                for(i=0;i<=idc;i++) {
                                    //var t_jumlah = $('#'+i+'').val();
                                    //alert(t_jumlah);
                                        if($('#barang_"+i+"_intid_id').val() != ''){
                                            //special today
                                            if( $('#promo_'+i+'').val() == 'SpecialToday'){
                                                var t_jumlah = $('#'+i+'').val();
                                                total = parseInt(total) + parseInt(t_jumlah);
                                                }
                                            }
                                    }
                                    answer = total % 2;
                                    pass = total / 2;
                                    //alert('answer :'+answer+', '+pass+'');
                                            $("#tracker_009").val('bayar');
                                            $("#tracker_free").val(0);
                                            $('#ganti_free').css({'display':'none'});
                                            $('#ganti_free').attr('disabled');
                                            $('#ganti_bayar').removeAttr('style');
                                            $('#ganti_bayar').removeAttr('disabled');
                                            

                                   
                            }
                            function hitungsisa() {
                                    omset10 = 0;
                                    omset20 = 0;
                                    totalomset = 0;
                                    pv = 0;
                                    komisi10 = 0;
                                    komisi20 = 0;
                                    totalbayar = 0;
                                    cash = '';
                                    debit = 0;
                                    kartukredit = 0;
                                    sisa = 0;
                                        for(i=0;i<=idc;i++) {
                                            if($('#barang_"+i+"_intid_id').val() != ''){
                                                    var t_jumlah = parseInt($('#'+i+'').val());
                                                    var t_harga = parseInt($('#harga_'+i+'').val());
                                                    var t_pv = parseFloat($('#pv_'+i+'').val());
                                                    var t_total = parseInt(t_harga * t_jumlah);

                                                    $('#total_'+i+'').val(t_total);
                                                    
                                                    // special today
                                                    if( $('#status_'+i+'').val() == 'spct'){
                                                        komisi10 = komisi10 + ( t_total * 0.1);
                                                        omset10 = omset10 + t_total;
                                                        totalomset = totalomset + t_total;
                                                        totalbayar = totalbayar + (t_total * 0.9);
														if($("#id_jenis_penjualan").val() == 2){
															pv = 0;
														}else {
															pv = pv + (t_jumlah * t_pv); 
														}
													}
													
													//  Chall SC
													if( $('#status_'+i+'').val() == 'chsc'){
													
                                                        totalbayar	= totalbayar + t_total;
														pv 				= pv + (t_jumlah * t_pv); 
														
													}
                                            }
                                        }
                                    //alert(''+omset10+' ,'+omset20+' ,'+totalomset+' ,'+pv+' ,'+komisi10+' ,'+komisi20+' ,'+totalbayar+' ,'+debit+' ,'+kartukredit+' ,');
                                    pv = (pv).toFixed(2);
                                    $("#id_formPembayaran_10persen").val(omset10);
                                    $("#id_formPembayaran_20persen").val(omset20);
                                    $("#id_formPembayaran_totalomset").val(totalomset);
                                    $("#id_formPembayaran_pv").val(pv);
                                    $("#id_formPembayaran_komisi10").val(komisi10);
                                    $("#id_formPembayaran_komisi20").val(komisi20);
                                    $("#id_formPembayaran_totalbayar").val(totalbayar);
                                    $("#id_formPembayaran_cash").val(cash);
                                    $("#id_formPembayaran_debit").val(debit);
                                    $("#id_formPembayaran_kartukredit").val(kartukredit);
                                    $("#id_formPembayaran_sisa").val(totalbayar);
									
									powerby(totalomset);
                                }
							function powerby(omset){
								if($('#chkSmart').attr('checked') == true){
									$("#id_formPembayaran_komisi10").val(0);
                                    $("#id_formPembayaran_komisi20").val(0);
									var charge = 0;
									
									if(parseInt(omset) >= 500000){
										
										$("#id_formPembayaran_totalbayar").val(omset);
										$("#id_formPembayaran_sisa").val(omset);
									}
									else if(parseInt(omset) < 500000){
										charge = parseFloat(omset) * 0.03;
										omset = parseFloat(omset) - parseFloat(charge);
										
										$("#id_formPembayaran_totalbayar").val(omset);
										$("#id_formPembayaran_kartukredit").val(charge);
										$("#id_formPembayaran_sisa").val(omset);
										
										$("#cash").attr('style','display:none;');
										$("#sisa").attr('style','display:none;');
										$("#debit").attr('style','display:none;');
									}
										$("#cash").attr('style','display:none;');
										$("#sisa").attr('style','display:none;');
										$("#debit").attr('style','display:none;');
										$(".button").removeAttr('disabled');
								}else{
									$("#cash").removeAttr('style','display:none;');
									$("#sisa").removeAttr('style','display:none;');
									$("#debit").removeAttr('style','display:none;');
										
									}
							}	
                            function isNumberKey(evt){
                                      var charCode = (evt.which) ? evt.which : event.keyCode;
                                      if (charCode != 46 && charCode > 31 
                                        && (charCode < 48 || charCode > 57))
                                         return false;

                                      return true;
                                   }
                    </script>