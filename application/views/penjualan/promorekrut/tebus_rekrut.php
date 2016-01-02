<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
		
                $(".id1").autocomplete({

                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>promorekrut/lookupBarang",
                            dataType: 'json',
                            type: 'POST',
                            data: {
									term: req.term,
                                    state: $("#promo").val(),
									},
							success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='15' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' />"
                    );

                    },
                });
	$(document).ready(function(){
	
	window.idx=0;
    
	$('#addBrg').bind('click', function(e){
		
       
	   if(($(".id1").val()=="")){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{
			
			idx = window.idx + 1;	
		
            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var id_barang =  $('#id_barang').val();
            var total = jumlah * harga;
            var out = '';
            out += 'Banyaknya<br>';
			out += '<input id="'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="2" value="'+jumlah+'" onkeyUp="kali(this.id)"  />&nbsp;';
            out += '<input id="barang001_'+idx+'" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="8" value="'+harga+'">';
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="8" value="'+total+'">';
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
            out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()">hapus</a> ';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            $('.id1').val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            
			var temp = parseInt($("#menu_jumlah").val()) + parseInt($("#"+$("#promo").val()).val());	
			$("#menu_jumlah").val(temp);
			
			$(".id1").attr("disabled",true);
			$("#addBrg").attr("disabled",true);
			kali();
			}
			return false;
    	});
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

<h2 class="title">PROMO REKRUT</h2>
        
                            <table width="685" border="0" id="data" align="center">
							<tr>
                                    <td colspan="6">
										<table width="50%" border="1" id="data" align="center" style="background:white;">
										 <tr>
                                                <td colspan='2'>&nbsp;Silahkan pilih</td>
											</tr>
											<?php 
											$count = 1;
											//promo submenu
											foreach($rekrut as $row){?>
											<tr>
												<td>&nbsp;<input type='checkbox' onClick='HitungRekrut(this.id)' value='<?php echo $row->max; ?>' class='status_<?php echo $count;?>'  id='<?php echo $row->status; ?>' /></td>
												<td>Diskon <?php echo $row->status; ?>%</td>
												</tr>
											<?php 
											$count ++;
											}?>
											</table>
									<input type="hidden" id="menu_promorekrut" value="<?php $count = $count - 1;
									echo $count; ?>">
									<input type="hidden" id="promo" value="0">
									<input type="hidden" id="menu_jumlah" value="0">
									</td>
							</tr>
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
                                                <td>&nbsp;Pilih Barang-&gt;
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
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="totalbayar" id="totalbayar" readonly="readonly"/>
                                        <input type="hidden" name="totalbayar1" id="totalbayar1" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><span class="style2">Cash</span></td>
                                  <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intcash" id="intcash"  onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Debit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intdebit" id="intdebit" onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Kartu Kredit</td>
                                    <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intkkredit" id="intkkredit" onkeyUp="return sisa();"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;<span class="style2">Sisa</span></td>
                                  <td>&nbsp;:</td>
                                    <td>Rp.<input type="text" name="intsisa" id="intsisa" />
                                        <input type="hidden" name="intsisahidden" id="intsisahidden" />                                    </td>
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
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" class="button"/></td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/>
                                    <input name="intid_jpenjualan" type="hidden" value="17" /></td>
                                </tr>
                            </table>
          </td>
                            </tr>
                            </table>
                        </form>
                    
<script type="text/javascript">
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

		//hitung omset bwt motong rekrut
		//hitung harga LG bwt motong nota
		//$('#totallg001').val(0);
		var _tempval = 1;
		var _tempqty = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			var _baranglg = $('#barang001_'+ i).val();
			
			_tempqty = parseInt($('#' + i).val());
			if ($('#' + i).val() == "")
			{
				_tempqty = 0;
			}
			/* $('#totallg001').val(parseInt($('#totallg001').val()) + (_tempval * _tempqty));
			
			if (parseInt($('#totallg001').val()) > parseInt($('#total').val()))
			{
				alert("Penebusan barang melebihi rekrut yg anda miliki");
				$('#totallg001').val(parseInt($('#totallg001').val()) - (_tempval * _tempqty));
				$('#' + i).val(0);
			} */
			if (_tempqty > _tempval) 
			{
				alert("Penebusan barang melebihi rekrut yg anda miliki");
				$('#' + i).val(0);
			}else{
				alert("silahkan lanjutkan penjualan");
				hidden_chosen();
				checkBox_menu_open();
				}
		}

		/*
		* kode lama
		*/
		var jml=0;
		var total =0;
		for(var i=1; i<= parseInt($('#tracker001').val());i++){
			var jumlah = $('#'+ i).val();
			var harga = parseInt($('#harga_' + i).val());
			var tot = jumlah * harga;
			total += tot;
			$('#total_' + i).val(tot);	
		}
		if($('#' + i).val() != ""){
			jml += total;
		}	
		$('#totalbayar').val(formatAsDollars(jml));
		$('#totalbayar1').val(jml);
		sisa();
	}


/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
	
/* 
	function kali(id){
        
		var jml=0;
		var total =0;
		
		 for(var i=1; i<= parseInt(id);i++){
                 //alert(i);
            var jumlah = $('#'+ i).val();
			var harga = parseInt($('#harga_' + i).val());
			var tot = jumlah * harga;
			total += tot;
			$('#total_' + i).val(tot);	
		}
		
		

		if($('#' + i).val() != ""){
           jml += total;
		}
		
		
		
			
		$('#totalbayar').val(formatAsDollars(jml));
		$('#totalbayar1').val(jml)
    }            
*/
    	 
	
/* 
    $('#ButtonAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })
 */
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
<script type="text/javascript">
		function HitungRekrut(id){
			
			var temp = parseInt($("#menu_jumlah").val()) + parseInt($("#"+id).val());
			console.log("total "+$("#total").val()+"  "+temp);
			$("#promo").val(id); //set promo
			
			checkBox_menu(); 
			
			if($("#total").val() <  temp){
				
				//alert("promo rekrut tidak berhasil." +parseInt($("#"+id).val()));
				$('.id1').attr("disabled","disabled");
				$('#addBrg').attr("disabled","disabled");
				$("#"+id).attr("checked",false);
				checkBox_menu(); 
				}
				else{
					
					$('.id1').removeAttr("disabled","disabled");
					$('#addBrg').removeAttr("disabled","disabled");
					//$("#jumlah").val(temp);
					}
			}
			
			function checkBox_menu(){
				//disabled or abled menu
				var check = 0;
				var menu_promorekrut	=	parseInt($("#menu_promorekrut").val());
				for(i=0; i<=menu_promorekrut; i++){
					
					if($(".status_"+i).attr("checked") == false){
						
						$(".status_"+i).attr("disabled","disabled");
						}
						
					if($(".status_"+i).attr("checked") == true){
						check = 1;
						}
					}
				if(check == 0){
					console.log("check = 0, maka able check box");
					for(i=0; i<=menu_promorekrut; i++){
						$(".status_"+i).removeAttr("disabled");
						$("#promo").val(0); 
						}
					}
				//end
				}
			function checkBox_menu_open(){
				var menu_promorekrut	=	parseInt($("#menu_promorekrut").val());
				for(i=0; i<=menu_promorekrut; i++){
						$(".status_"+i).removeAttr("disabled");
						$(".status_"+i).attr("checked",false);
					}
				}
			
	</script>
