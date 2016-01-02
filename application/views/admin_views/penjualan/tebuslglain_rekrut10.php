<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
				/* Buat menghitung keluaran barang LGLAIN*/
				var totlglain = 0;
				totlglain = parseInt(parseInt($('#total').val()));
				
				$('#totallg001').val(totlglain);
				alert('Total Yang Akan Ditebus '+totlglain+' Rekrutan');
              /* end of buat menghitung barang lg lain */
				$(".id1").autocomplete({

                    minLength: 5,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
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
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang'  value='" + ui.item.value1 + "' size='15' readonly='readonly'/><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' />"
                    );

                    },
                });
</script>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td width="107">
									
								<tr>
										<td>Jenis Penjualan</td>
										<td>&nbsp;
										    <select name="intid_jpenjualan" id="intid_jpenjualan">
                                            <option value="">-- Pilih --</option>
                                            <?php
                                            for($i=0;$i<count($strnama_jpenjualan);$i++) {
													echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
											}
                                            ?>
                                  </select>         </td>
								</tr>
								
                                
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="122">&nbsp;Silahkan ketik</td>
												<td width="256">&nbsp;Nama Barang</td>
												<td width="161">Harga</td>
												<td width="94" rowspan="3">
												
													<div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
														<input type="hidden" id="tracker001" value="0" />
														<input type="hidden" id="totallg001" name="totallg001" value="0" />
                                                    </div>    </td>
                                      </tr>
                                            <tr>
                                                <td>&nbsp;Pilih Barang -&gt;
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
                                    <td>Total Omset</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="totom10" id="totom10" readonly="readonly"/>
                                        <input type="hidden" name="jumlah" id="jumlah1" /></td>
                                </tr>
								
								<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>PV</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="totalPV" id="totalPV" readonly="readonly"/>
                                        <input type="hidden" name="intpv" id="intpv" /></td>
                                </tr>
								
								 <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Omset 10 %</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="omset10" id="omset10" readonly="readonly"/>
                                        <input type="hidden" name="jml10" id="jml10" /></td>
                                </tr>
								
								<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Komisi 10 %</td>
                                    <td>:</td>
                                    <td>Rp.<input type="text" name="komisi10" id="komisi10" readonly="readonly"/>
                                        <input type="hidden" name="komisi1hidden" id="komisi1hidden" /></td>
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
                                    <!--<input name="intid_jpenjualan" type="hidden" value="27" /></td>-->
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
		 if($("#intid_jpenjualan").val()==0){
            alert('Anda belum memilih jenis penjualan!');
            event.preventDefault();
        }
		
		});
		/* $('#addBrg').click(function(){
			alert('cilukba');
		}); */
	var idx=1;
    $('#addBrg').bind('click', function(e){
	//alert();

        if(($(".id1").val()=="")){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var harga = ($('#harga_barang').val() * window.persen).toFixed(2);
            var id_barang =  $('#id_barang').val();
			//harga = harga/2;
            var total = (jumlah * harga * window.persen).toFixed(2);
			var pv = ($('#pv').val()*window.persen).toFixed(2);
            var out = '';
			out += '<div class="lglain">'
            out += 'Banyaknya<br>';
			out += '<input id="'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="2" value="'+jumlah+'" class="idcari" onkeyUp="kali(this.id)"  />&nbsp;';
            out += '<input id="barang001_'+idx+'" name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            out += '&nbsp;Harga:&nbsp;<input id="harga_'+idx+'" name="barang['+idx+'][intid_harga]" type="text" size="8" class="isharga" value="'+harga+'">';
           if($("#intid_jpenjualan").val() == 2){
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="0" class=ispv readonly>';
            }else{
                out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" value="'+pv+'" class=ispv readonly>';
            }
		   
		   // out += '&nbsp;PV:&nbsp;<input id="pv_'+idx+'" name="pv['+idx+'][intpv]" type="text" size="1" class="ispv" value="'+pv+'" readonly>';
			out += '&nbsp;Total:&nbsp;<input id="total_'+idx+'" name="barang['+idx+'][intid_total]" type="text" size="8" class="istotal" value="'+total+'">';
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">';
            out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()">hapus</a> ';
            out = '<div style="height:60px">' + out + '</div></div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
            $('.id1').val('');
            $('#jumlah').val('');
            $('#harga_barang').val('');
            
			 }
			
		//	return false;
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

 /*
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

		//hitung harga LG bwt motong nota
		//$('#totallg001').val(0);
		var _tempval = 0;
		var _tempqty = 0;
		for (var i = 1; i <= parseInt($('#tracker001').val()); i++) {
			var _baranglg = $('#barang001_'+ i).val();
			
			$('#totallg001').val(parseInt($('#totallg001').val()) + (_tempval * _tempqty));
			
			if (parseInt($('#totallg001').val()) > parseInt($('#total').val()))
			{
				alert("Penebusan barang melebihi omset yg anda miliki");
				$('#totallg001').val(parseInt($('#totallg001').val()) - (_tempval * _tempqty));
				$('#' + i).val(0);
			}
		}

	
		hitungtotal();
	}
	function hitungtotal(){
		var qt = 0;
		var qtt = 0;
		var hrg = 0;
		var hrgt = 0;
		var tots=0;
		var totom = 0;
		var oms10 = 0;
		var kom10 = 0;
		var pivi = 0;
		var persen = 0;
		
		$('.prs').click(function(){
			window.persen  = $(this).val();
			
			//alert(persen);
		});
		
			
		$('.lglain').each(function(){
			qt = $(this).find('.idcari').val();
			hrg = $(this).find('.isharga').val();
			tots = $(this).find('.istotal').val();
			pivi = $(this).find('.ispv').val();
			if (isNaN(qt)){
				qt = 0;
			}
			if (isNaN(hrg)){
				hrg = 0;
			}
			if (isNaN(tots)){
				tots = 0;
			}
			
			
			
			oms10 = hrg;
			totom = oms10;
			kom10 = oms10 * 0.1;
			pivit = qt * pivi; 
			hrgt += parseInt(oms10 - kom10);
			$(this).find('.istotal').val($(this).find('.isharga').val() * $(this).find('.idcari').val());
			qtt += parseInt(qt);
			console.log("Qty Awal: "+qt,"Qty Jumlah: "+qtt);
			if(qtt > 1){
				console.log('lebih besar coy');
				$(this).find('.idcari').val(0);
				alert('Barang Melebihi Jumlah Kuota Seharusnya!');
				hitungtotal();
				exit();
			}else if (qtt = 1){
				$('#addBrg').attr('disabled',true);
				$('.id1').attr('disabled',true);
			
			}
				console.log($(this).find('.isharga').val(), hrgt);
		});
		$('#totom10').val(formatAsDollars(totom));
		$('#omset10').val(formatAsDollars(oms10));
		$('#komisi10').val(formatAsDollars(kom10));
		$('#totalPV').val(formatAsDollars(pivit));
		$('#totalbayar').val(formatAsDollars(hrgt));
		$('#jml10').val(oms10);
		$('#jumlah1').val(totom);
		$('#komisi1hidden').val(kom10);
		$('#intpv').val(pivit);
		$('#totalbayar1').val(hrgt);
		//alert(totom);
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

