<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
                $(".id1").autocomplete({

                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>promoavenger/lookupBarangTebus",
                            dataType: 'json',
                            type: 'POST',
                            data: {term:req.term,
                               oms_rule: window.omssisa
                            },
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }else{
                                    alert("Barang Tidak Tersedia / Omset Tidak Cukup");
                                    $('.ui-autocomplete-loading').removeClass("ui-autocomplete-loading");
                                    $(".id1").val('');
                                }
                            },
                        });
                    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.harga + "' size='15' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='id_pv' name='id_pv' value='" + ui.item.pv + "' size='15' /><input type='hidden' id='id_omsrule' name='id_omsrule' value='" + ui.item.omsetrule + "' size='15' />"
                    );

                    },
                });
</script>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
        
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td width="107">
                                
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="122">&nbsp;Silahkan ketik</td>
                                              <td width="256">&nbsp;Nama Barang</td>
                                              <td width="161">Harga</td>
                      <td width="94" rowspan="3"><div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
							<input type="hidden" id="tracker001" value="0" />
							<input type="hidden" id="totallg001" name="totallg001" value="0" />
                                                    </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang Reguler-&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></td>
                                  <td>&nbsp;
                                                    <div id="result1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <div id="ButtonAdd" style="margin-left: 150px"></div></td>
                                            </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="82">&nbsp;</td>
                                    <td width="7">&nbsp;</td>
                                    <td width="213">&nbsp;</td>
                                </tr>
                                
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Omset 20</td>
                                    <td>: Rp.</td>
                                    <td><input type="text" name="" id="omset20" readonly="readonly"/>
                                        <input type="hidden" name="nota_inttotal_20" id="omset20_" /></td>
                                        <input type="hidden" name="nota_inttotal_omset" id="totsomset_" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 20</td>
                                    <td>: Rp.</td>
                                    <td><input type="text" name="" id="komisi20" readonly="readonly"/>
                                        <input type="hidden" name="nota_inttotal_k20" id="komisi20_" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td><input type="text" name="nota_pv" id="nota_pv" readonly="readonly"/>
                                        <input type="hidden" name="nota_pv_" id="nota_pv_" /></td>
                                </tr>
                               <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Voucher</td>
                                    <td>: Rp.</td>
                                    <td><input type="text" name="voucher" id="voucher" readonly="readonly"/>
                                        <input type="hidden" name="nota_intvoucher" id="voucher_" /></td>
                                </tr>
                                 <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total Bayar</td>
                                    <td>: Rp.</td>
                                    <td><input type="text" name="nota_inttotal_bayar" id="totalbayar" readonly="readonly"/>
                                        <input type="hidden" name="nota_inttotal_bayar_" id="totalbayar1" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style2">Cash</span></td>
                                  <td>&nbsp;: Rp.</td>
                                    <td><input type="text" name="nota_intcash" id="intcash"  onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;: Rp.</td>
                                    <td><input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;: Rp.</td>
                                    <td><input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;<span class="style2">Sisa</span></td>
                                  <td>&nbsp;: Rp.</td>
                                    <td><input type="text" readonly name="intsisa" id="intsisa" />
                                        <input type="hidden" name="nota_intsisa" id="intsisahidden" />                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" id="submit" value="Simpan" class="button" onclick="this.form.location='<?php echo base_url();?>form_control_penjualan/insertPromo17845'" /></td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/>
                                    <input name="intid_jpenjualan" type="hidden" value="30" /></td>
                                </tr>
                            </table>
          </td>
                            </tr>
                            </table>
                        </form>
                    
<script type="text/javascript">
    $(document).ready(function()
        {
            $("#submit").bind("click",function()
                {
                    if(isNaN($("#totalbayar1").val()))
                    {
                        alert("Error");
                        return false;
                    }
                });

           $(".intqty").live("keyup",function()
            {
                if(window.omssisa < 0){
                    $(this).val(0);

                    kali($(this).data('gid'));
                    alert("barang melebihi kuota");
                }
            });
        });
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
        var d = parseInt(document.getElementById('totalbayar1').value);
        var t = a + b + c;
        var sisa = d - t;
        document.getElementById('intsisa').value = formatAsDollars(sisa);
        $('#intsisahidden').val(sisa);
    }

    $('#frmjual').submit(function(event){

        if($("#totalbayar").val()==""){
            alert('Belum ada Transaksi Barang!');
            event.preventDefault();
        }

    });

	idx=1;
    $('#addBrg').bind('click', function(e){

        if(($(".id1").val()=="")){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var id_barang =  $('#id_barang').val(); 
            var total = jumlah * harga;
            var pv  = $('#id_pv').val();
            var omsetrule  = $('#id_omsrule').val();
            var out = '';
            out += 'Banyaknya<br>'; 
			out += '<input autocomplete="off" class="intqty" data-gid="'+idx+'" id="'+idx+'" name="intquantity[]" type="text" size="2" value="'+jumlah+'" onkeyUp="kali(this.id)"  />&nbsp;';
            out += '<input readonly id="barang001_'+idx+'" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            out += '&nbsp;Harga:&nbsp;<input readonly  id="harga_'+idx+'" name="intharganew[]" type="text" size="8" value="'+harga+'">';
			out += '&nbsp;Total:&nbsp;<input  readonly id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="8" value="'+total+'">';
            out += '<input name="intid_barang[]" type="hidden" value="'+id_barang+'">';
            out += '<input name="intno_nota[]" type="hidden" value="'+$("#nomor_nota").val()+'">';
            out += '<input name="intharga[]" id="intharganew'+idx+'" type="hidden" value="'+harga+'">';
            out += '<input name="intvoucher[]" id="intvoucher_'+idx+'" type="hidden" value="0">';
            out += '<input name="intpv[]" id="intpv_'+idx+'" type="hidden" value="'+pv+'">';
            out += '<input name="omset10[]" id="omset10_'+idx+'" type="hidden" value="0">';
            out += '<input name="omset15[]" id="omset15_'+idx+'" type="hidden" value="0">';
            out += '<input name="omset20[]" id="omset20_'+idx+'" type="hidden" value="0">';
            out += '<input name="komisi10[]" id="komisi10_'+idx+'" type="hidden" value="0">';
            out += '<input name="komisi15[]" id="komisi15_'+idx+'" type="hidden" value="0">';
            out += '<input name="komisi20[]" id="komisi20_'+idx+'" type="hidden" value="0">';
            out += '<input name="idPromo[]" id="idPromo_'+idx+'" type="hidden" value="89">';
            out += '<input name="inttotal_bayar[]" id="inttotal_bayar_'+idx+'" type="hidden" value="0">';
            out += '<input name="idPenjualan[]" id="idPenjualan_'+idx+'" type="hidden" value="'+$("#nota_intid_jpenjualan").val()+'">';
            out += '<input name="kotam[]" id="kotam_'+idx+'" type="hidden" value="0">';
            out += '<input name="is_diskon[]" id="is_diskon_'+idx+'" type="hidden" value="0">';
            out += '<input name="inttotal_omset[]" id="inttotal_omset_'+idx+'" type="hidden" value="0">';
            out += '<input name="" id="omsetrule_'+idx+'" type="hidden" value="'+omsetrule+'">';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
            $('.id1').val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            
			}
			return false;
    	});
	
    function formatNumber(num)
        {
            var n = num.toString();
            var nums = n.split('.');
            var newNum = "";
            if (nums.length > 1)
            {
                var dec = nums[1].substring(0,2);
                newNum = nums[0] + "," + dec;
            }
            else
            {
                newNum = num;
            }
            return (newNum)
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

	/**
	* function kali yg baru
	* @param id (nomor row keberapa yg lagi diketik)
	*/

    
	function kali(id){
		id = id || $('#tracker001').val();

		$("#del"+id).remove();
		//kalau tracker lebih kecil dari id yg sekarang -> ganti
		if (parseInt($('#tracker001').val()) < parseInt(id))
		{
			$('#tracker001').val(id);
		}

		$('#totallg001').val(0);
		var _temppv = 0;
		var _tempqty = 0;
		var omset20		= 0;
		var komisi20	= 0;
        var totalbayar = 0;
		var omsetrulex = 0;
		var intvoucher = $("#intvoucher").val();
		
		if(isNaN(intvoucher))
		{
			intvoucher = 0;
		}

		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) 
		{
			
			qty 		= $("#"+i).val();
			hargasatuan = $("#harga_"+i).val();
			
			if(!isNaN(qty) && !isNaN(hargasatuan))
			{
				/*$("#total_"+i).val(parseInt(qty) * parseInt(hargasatuan));
                $("#omset20_"+i).val(parseInt(qty) * parseInt(hargasatuan));
                $("#komisi20_"+i).val(parseFloat($("#omset20_"+i).val()) * 0.2);
                $("#inttotal_omset_"+i).val($("#omset20_"+i).val());
                $("#inttotal_bayar_"+i).val(parseFloat($("#omset20_"+i).val()) - parseFloat($("#komisi20_"+i).val()));*/
                
                $("#total_"+i).val(parseInt(qty) * parseInt(hargasatuan));
                $("#omset20_"+i).val(0);
                $("#komisi20_"+i).val(0.00);
                $("#inttotal_omset_"+i).val(0);
                $("#inttotal_bayar_"+i).val(parseInt(qty) * parseInt(hargasatuan));
                _temppv = _temppv + parseFloat(qty * 0);
                omset20 = 0;//parseInt(omset20) + parseInt($("#total_"+i).val());
                totalbayar += parseInt(qty) * parseInt(hargasatuan);
                omsetrulex += parseInt(qty) * parseInt($("#omsetrule_"+i).val());
				console.log("omset20 "+omset20);
            }
        }   
        //console.log("omset20 "+omset20+", intvoucher "+intvoucher);
        omset20     = omset20 - intvoucher;
        _temppv     = 0;//parseFloat(_temppv) - parseFloat($("#temp_pv").val());
        if(omset20 < 0) //omset tidak ada
        {
            omset20 = 0;
            _temppv = 0;
        }
        komisi20    = omset20 * 0.2;
        //totalbayar    = omset20 - komisi20;
        /**
        * kasih kondisi jika voucher dibawah noll
        */
        $("#omsbrg").val(parseInt(omsetrulex));
        $("#totsomset_").val(parseInt(omset20));
        $("#omset20").val(parseInt(omset20));
        $("#omset20_").val(parseInt(omset20));
        $("#komisi20").val(parseInt(komisi20));
        $("#komisi20_").val(parseInt(komisi20));
        $("#voucher").val(parseInt(0));
        $("#voucher_").val(parseInt(0));
        $("#nota_pv").val(_temppv.toFixed(2));
        $("#nota_pv_").val(_temppv.toFixed(2));
        $("#totalbayar").val(parseInt(totalbayar));
        $("#totalbayar1").val(parseInt(totalbayar));
        $("#intcash").val(0);
        window.omsbrg = omsetrulex;
        window.omssisa = window.totomsets - window.omsbrg ;
        $('#omssisa').val(window.omssisa);

        sisa();
    }
         
    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })

    function formatAsRupiah(ObjVal) {

        mnt = ObjVal;

        mnt -= 0;

        mnt = (Math.round(mnt*100))/100;

        ObjVal = (mnt == Math.floor(mnt)) ? mnt + '.00' : ( (mnt*10 == Math.floor(mnt*10)) ? mnt + '0' : mnt);

        if (isNaN(ObjVal)) {ObjVal ="0.00";}

        return ObjVal;
    }

    function formatAsDollars(amount){

        if (isNaN(amount)) {
            return "0.00";
        }
        amount = Math.round(amount*100)/100;

        var amount_str = String(amount);

        var amount_array = amount_str.split(".");

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

        amount_array[0] = dollar_array.join(",");

        return (amount_array.join("."));
    }

</script>