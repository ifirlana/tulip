<script>

var key = 25;

////////////////untuk meload categoy promo combo
    function load_promo_combo(id){
        disabled_promo(key);
        if($(".comboPaketCheck"+id).attr("checked") == true){  //checkbox jika diklik maka yang checkbox lain harus disabled
            disabled_paket(key);                  
            $(".comboPaketCheck"+id).removeAttr('disabled','disabled');
            $(".comboPaket"+id).removeAttr('disabled','disabled');
            $(".comboPaket"+id).val(1);
            console.log($(".comboPaketCheck"+id).val());

            $("#comboPaketRulesPoint").val($("#comboPaketRules"+id).val());
            $("#comboCheckPoint").val($(".comboPaketCheck"+id).val());
            load_db_promo_combo();//load data promo combo
 
        }
        else{
            //paket combo paket
            $(".comboPaket"+id).val('');
            enable_paket(key);
            //default jika tidak digunakan
            $("#comboCheckPoint").val('');
			$("#comboPaketRulesPoint").val('');
            addBrg_default();
        }
    }
    ////////////////operasi dasar promo disabled promo combo
    function disabled_promo(k){
        for(i=0;i<=k;i++){
           // $(".comboPaketCheck"+i).attr('disabled','disabled');
           console.log(i);
            $(".comboPaket"+i).attr('disabled','disabled');
        }
    }
    /////////////////operasi disabled paket combo
    function disabled_paket(k){
        for(i=0;i<=k;i++){
           // $(".comboPaketCheck"+i).attr('disabled','disabled');
           console.log(i);
            $(".comboPaketCheck"+i).attr('disabled','disabled');
        }
    }
    /////////////////operasi enabled paket
    function enable_paket(k){
        for(i=0;i<=k;i++){
           // $(".comboPaketCheck"+i).attr('disabled','disabled');
           console.log(i);
            $(".comboPaketCheck"+i).removeAttr('disabled','disabled');
        }
    }
    /////////////////operasi dasar mereset promo
    function reset_combo(){
        disabled_paket(key);
        disabled_promo(key);
        for(i=0;i<=key;i++){ 
            $(".comboPaket"+i).val(''); // jumlah paket set jadi null
            $(".comboPaketCheck"+i).removeAttr('checked'); // jumlah paket set jadi null
        }
        enable_paket(key);
    }
    /////mmengambil data ke tabel promocombo
    function load_db_promo_combo(){
	if(window.combol == ''){
	window.combol = 0;
	}
        console.log("load_db_promo_combo:starting");
        $(".id1").autocomplete({
                minLength: 5,
                source:
                function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>combo_controller/newlookupBarangPromoCombo",
                        dataType: 'json',
                        type: 'POST',
                        data: {
                                term: req.term,
                                state: $("#comboCheckPoint").val(),
                                jbarang: $("#tulipormetal").val(),
								promsi: window.combol,
                                },
                         success:
                                    function(data){
                                        if(data.response =="true"){
                                            add(data.message);
                                        }
                                        console.log("!: "+data.infoData);
                                    },
                                });
                            },
                    focus:
                    function(event,ui) {
                    var q = $(this).val();
                    $(this).val(q);
                    },
                            select:
                                function(event, ui) {
                                $("#result1").html(
                                "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' readonly /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                            );
                                $("#result2").html('');
                                $("#result1").removeAttr('style','display:none'); //penanganan tampilan di halaman
                                
                            },
                        });
             console.log("load_db_promo_combo : I ["+$("#comboCheckPoint").val()+", "+$("#tulipormetal").val()+", ]");
            console.log("load_db_promo_combo:ending");
        }
    function load_db_promo_combo_free(){
	if(window.combol == ''){
	window.combol = 0;
	}
           console.log("load_db_promo_combo_free:start");
		$(".id1").autocomplete({
                minLength: 5,
                source:
                function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>combo_controller/newlookupBarangPromoComboFree",
                        dataType: 'json',
                        type: 'POST',
                        data: {
                                term: req.term,
                                state: $("#comboCheckPoint").val(),
                                jbarang: $("#tulipormetal").val(),
                                intid_barang: $("#id_barang").val(),
								promsi: window.combol,
                                },
                         success:
                                    function(data){
                                        if(data.response =="true"){
                                            add(data.message);
                                        }
                                        console.log("!: "+data.infoData);
                                    },
                                });
                            },
                    focus:
                    function(event,ui) {
                    var q = $(this).val();
                    $(this).val(q);
                    },
                            select:
                                function(event, ui) {
                                $("#result2").html(
                                "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                            );
                                $("#result1").attr('style','display:none');
                            },
                        });
             console.log("load_db_promo_combo : I ["+$("#comboCheckPoint").val()+", "+$("#tulipormetal").val()+","+$("#id_barang").val()+" ]");
           console.log("load_db_promo_combo_free:start");
        }
    function addBrg_combo(){
        $("#addBrg").unbind('click');
        $("#addBrg").bind('click',function(e){
           disabled_paket(key);
           disabled_promo(key);                               
          if($(".id1").val()==""){
            alert('Anda belum memilih barang!');
            }else if($('.id1').val() != "" && $("#tracker002").val() == "bayar") { 
                var brg = $('.id1').val();
                var harga = $('#harga_barang').val();
                var id_barang =  $('#id_barang').val();
                var pv =  $('#pv').val();
                var out = '';
                var nomor_nota = $('#nomor_nota').val();
                
                out += 'Banyaknya<br>';
                out += '<input type="text" id="hitaja" name="hitaja[]" value="'+idx+'">';
                out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" onkeyUp="hitung_combo(this.id);" onkeypress="return isNumberKey(event)" />&nbsp;';
                        
                out += '<input id="barang_'+idx+'_intid_barang" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly />';
                out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" readonly>';
                
                out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="0" readonly>';
                        out += '<input id="barang_'+idx+'_intid_id" name="barang['+idx+'][intid_id]" type="text" value="'+id_barang+'">';
                        //001
                        out += '<input id="tracker003_'+idx+'" name="tracker003_'+idx+'" type="hidden" >';
                        out += '<input type="text" name="barang['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
                        out += '<br /><input type="checkbox" id="voucher_'+idx+'" onclick="hitung_combo()" />Voucher&nbsp&nbsp';
                        _statepromo10 = 1;
                        
                        out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
                        out = '<div style="height:60px">' + out + '</div>';
                //$('#result_hasil').append(out);
                $(out).insertAfter('#result_hasil');
                
                $('.id1').val('');
                $('#harga_barang').val('');
                idx++;
                
                }
                else if($('.id1').val() != "" && $("#tracker002").val() == "free"){
                    var brg = $('.id1').val();
                    var jumlah = "";
                    var harga = 0;
                    if ($('#id_free').val() == 0)
                    {
                        alert("barang ilank");
                    }
                    var id_barang =  $('#id_free').val();
                    var total = parseInt(jumlah) * parseInt(harga);
                    var out = '';
                    var nomor_nota = $('#nomor_nota').val();

                    out += '<sup>(Free)</sup>Banyaknya<br>';
                    
                    out += '<input type="text" id="hitaja" name="hitaja[]" value="'+idx+'">';
                    out += '<input id="'+idx+'" class="semua_combo_free_'+idx+'" name="barang_free['+idx+'][intquantity]" type="text" size="1" value="'+jumlah+'" onkeyUp="hitung_combo_free(this.id);" onkeypress="return isNumberKey(event)" />&nbsp;';
                    
                    out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  readonly/>';
                    out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="5" value="'+harga+'" readonly>';
                    out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="2" value="0" readonly>';
                    out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="5" value="0" readonly>';
                    out += '<input name="barang_free['+idx+'][intid_id]" type="text" value="'+id_barang+'">';
                    out += '<input type="text" name="barang_free['+idx+'][nomor_nota]" size="20" value="'+nomor_nota+'" readonly/>';
                    out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a> ';
                    out = '<div style="height:60px">' + out + '</div>';
                    $(out).insertAfter('#result_hasil');
                    
                    
                    $(".id1").val('');
                    $('#pv').val('');
                    $('.frees').attr('disabled', 'disabled');
                    $('.frees').val('');
                    $('#harga_barang_free').val('');
                    $('#jumlah').val('');
                    $('#harga_barang').val('');
                    
                    idx++;
                    }
                return false;  
            });
        console.log("addBrg_combo : "+idx);
        }
    //lakukan perhitungan combo oke
    function hitung_combo(id){
        var batasCombo = 0;
        var total = 0;
        for(i=0;i<key;i++){//woke
            if(!isNaN($("#comboPaket"+i).val())){
                console.log("paket : "+$("#comboPaket"+i).val());
                batasCombo += parseInt($("#comboPaket"+i).val());
                }
        }
        for(j=0;j<=idx;j++){//akumulatif
            if(!isNaN($(".semua_"+j).val())){
               console.log("akum : "+$(".semua_"+j).val());
                total += parseInt($(".semua_"+j).val());
            }
        }
        //mengambil bukan total
        //var total = $(".semua_"+id).val();
        
        console.log("total :"+total+", batas combo : "+batasCombo);
        
		//kondisi jika melebihi qouta        
        if(total > batasCombo){
            alert('Barang melebihi quota');
            $(".semua_"+id).val('');
            }
            else if(total == batasCombo){ // kondisi jika sama dengan pilihan berubah menjadi free
                $(".semua_"+id).attr("readonly","readonly");
                console.log("readonly : "+$(".semua_"+id).val());

                $("#tracker002").val("free");
                console.log("tracker002 : "+$("#tracker002").val());
                
                $("#tracker004").val(batasCombo);
                console.log("tracker004 : "+$("#tracker004").val());
                
                load_db_promo_combo_free();
                $(".id1").focus();
                
                alert('silahkan pilih barang free');
                }
        //bikin semua textbox bernilai 0
        $('#intjumlah1').val(0);
        $('#intjumlah2').val(0);
        $('#intjumlah').val(0);
        $('#intjumlah1hidden').val(0);
        $('#intjumlah2hidden').val(0);
        $('#intvoucher').val(0);
        $('#intpv').val(0);
        $('#komisi1').val(0);
        $('#komisi2').val(0);
        $('#komisi1hidden').val(0);
        $('#komisi2hidden').val(0);
        $('#komisihide').val(0);
        $('#totalbayar').val(0);
        $('#totalbayar1').val(0);
        $('#intcash').val('');
        $('#intdebit').val('');
        $('#intkkredit').val('');

        total_barang(id);

        sisa();
        
        //format smua angka as rupiah
        /*
        $('#intjumlah1').val(formatAsRupiah(parseInt($('#intjumlah1').val())));
        $('#intjumlah2').val(formatAsRupiah(parseInt($('#intjumlah2').val())));
        $('#intjumlah').val(formatAsRupiah(parseInt($('#intjumlah').val())));
        $('#komisi1').val(formatAsRupiah(parseInt($('#komisi1').val())));
        $('#komisi2').val(formatAsRupiah(parseInt($('#komisi2').val())));
        $('#charge3').val(formatAsRupiah(parseInt($('#charge3').val())));
        $('#totalbayar').val(formatAsRupiah(parseInt($('#totalbayar').val())));
        */
        $('#intjumlah1').val(parseInt($('#intjumlah1').val()));
        $('#intjumlah2').val(parseInt($('#intjumlah2').val()));
        $('#intjumlah').val(parseInt($('#intjumlah').val()));
        $('#komisi1').val(parseInt($('#komisi1').val()));
        $('#komisi2').val(parseInt($('#komisi2').val()));
        $('#charge3').val(parseInt($('#charge3').val()));
        $('#totalbayar').val(parseInt($('#totalbayar').val()));
        //hitung sisa pembayaran
       
        //jalankan auto complete handler
        return false;
    }
    function hitung_combo_free(id){
        var _temp = 0;
        for(var i = 0;i <= idx; i++){
            if(!isNaN($(".semua_combo_free_"+i).val())){
                _temp += parseInt($(".semua_combo_free_"+i).val());
            }
        }
        if(_temp > $("#tracker004").val()){
            alert("jumlah barang free tidak sesuai");
            $("#"+id).val('');
            }
            else if(_temp == $("#tracker004").val()){
               
               $("#tracker002").val("bayar");
               console.log("tracker002 : "+$("#tracker002").val());
               
               $("#tracker004").val();
               console.log("tracker004 : "+$("#tracker004").val());
               
                $(".semua_combo_free_"+id).attr("readonly","readonly");
                console.log("readonly : "+ $(".semua_"+id).val());
                
                load_db_promo_combo();
                enable_paket(key);

               //reset_combo(key);

               //autoCompPromoNormal();
               $('.id1').focus();
               alert("silahkan pilih barang bayar");
            }

    }

</script>
