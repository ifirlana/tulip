<script>
//pertama kali load 
	$(document).ready( function() {
		//variabel yang menentukan id input type
			window.idx = 0;
			status = '<?php echo $halaman;?>';
            var out = '';
			$('#label_verify').html();
            $('#search').val();
			//proses setting tempat penginputan
			if(status == 'po'){
				out = "<div id='divListBarang'><ul style='list-style-type:decimal;' id='dataListBarang'><ul style='list-style-type:none;'><li style='float:left; margin-left:-40px;'>JUMLAH</li><li style='float:left;margin-left:10px;'>NAMA BARANG</li><li style='float:left;margin-left:210px;'>KETERANGAN</li><li style='float:left;margin-left:100px;'>Harga</li></ul><br id='content-list'/></ul></div>";
				}
			$(out).insertAfter('.description');           
			
			///menambah variabel ke form
			$('#btn_tambah').bind('click', function(e){			
				if($('.barang_').val() != null){
					$('#search').val('');
					$('#label_verify').html('Berhasil!');
					inputForm(window.idx++,status);
					$('.temp_data').html('');
				}else{
					alert('data harus di pilih dahulu');
					}
				});
				
			});
	
	
	//fungsi yang diterus ditambahin
	/**
	*	@param inputForm
	*	input :	idx berupa integer yang menunjukan identitas variabel, 
	*			status berupa variabel yang digunakan untuk meload kondisi yang digunakan operasi
	*	out	: sesuai kondisi bisa berupa append di $('#dataListBarang').append()
	*	desc: inputForm digunakan untuk menampilkan form yang di operasikkan
	*/
	function inputForm(idx,status){
		console.log("idx : "+idx);
		var out = "";
		if(status == 'po'){
			 out = '<li id="listBarang" class="listBarang_'+idx+'">';
			 out += '<input id="'+idx+'" class="quantity_'+idx+'" name="quantity[]" type="text" size="1" value="0" onKeyUp="return checkInput('+idx+');" />';
			out += '<td><input id="'+idx+'" class="barang_'+idx+'" name="strnama[]" type="text" size="40" value="'+$('.namabarang_').val()+'" readonly = "true"/>';
			out += '<input id="'+idx+'" class="ket_'+idx+'" name="keterangan[]" type="text" size="30" />';
			out += '<input id="'+idx+'" class="intid_'+idx+'" name="intid_barang[]" type="hidden" size="5" value="'+$('.barang_').val()+'" readonly = "true"/>';
			out += '<input id="'+idx+'" class="barang_'+idx+'" name="no[]" type="hidden" size="10" value="'+$('#no_po').val()+'" readonly = "true"/>';
			out += '<input type="hidden" value="'+$('.hargabarang_').val()+'" id="hargaSatuan_'+idx+'" />';
			out += '<span id="here_'+idx+'"></span>';
			out += '</li><br />';
			//$('#content-list').insertAfter(out);
			$(out).insertAfter('#content-list');           
			$('.input-submit').html('<input type="submit" name="submit" value="Cetak" />');
			}else if(status == 'SJ'){
			//Cari nomor Urut
			$('#list-data').val(parseInt($('#list-data').val())+parseInt(1));
			//$halaman Surat Jalan
			out = '<tr>';
			out += '<td align="center">'+$('#list-data').val()+'<input type="hidden" name="Tintid_barang['+idx+']" value="'+$('.barang_').val()+'" size="2" /></td>';
			out += '<td><input type="text" name="TnamaBarang['+idx+']" value="'+$('.namabarang_').val()+'" size="30" disabled /></td>';
			out += '<td align="center">--</td>';
			out += '<td align="center">--</td>';
			out += '<td><input type="text" name="Tquantity['+idx+']" value="0" size="2" /></td>';
			out += '<td><input type="text" name="Tketerangan['+idx+']" value="tambahan barang" size="30" /></td>';
			out += '</tr>';
			$('#content-list').before(out);
				
			}else if(status == 'STTB'){
				//Cari nomor Urut
				$('#list-data').val(parseInt($('#list-data').val())+parseInt(1));
				//$halaman Surat Jalan
				out = '<tr>';
				out += '<td align="center">'+$('#list-data').val()+'<input type="hidden" name="Tintid_barang['+idx+']" value="'+$('.barang_').val()+'" size="2" /></td>';
				out += '<td><input type="text" name="TnamaBarang['+idx+']" value="'+$('.namabarang_').val()+'" size="30" disabled /></td>';
				out += '<td align="center">--</td>';
				out += '<td align="center">--</td>';
				out += '<td><input type="text" name="Tquantity['+idx+']" value="0" size="2" /></td>';
				out += '<td><input type="text" name="Tketerangan['+idx+']" value="tambahan barang" size="30" /></td>';
				out += '</tr>';
				$('#content-list').before(out);
				
			}
			/*
			else if(status == 'sj'){
				out += "<tr>
						<td>&nbsp;</td>
						<td><input type='text' /></td>
						<td><input type='text' /></td>
						<td><input type='text' /></td>
					</tr>";
				$(out).insertAfter('#content-list');  
				}
			*/	
			} 
	//fungsi yang diubah jika di select sama auto complete. yang harus di keluar berupa data ap saja
	function inputData(ui,status){
			$('.temp_data').html('');
			var out = '<input type="hidden" class="barang_" name="barang" type="text" size="1" value="'+ui.item.intid_barang+'" />';
				 out += '<input type="hidden" class="namabarang_" name="barang" type="text" size="1" value="'+ui.item.label+'" />';
				 out += '<input type="hidden" class="hargabarang_" name="barang" type="text" size="1" value="'+ui.item.intharga+'" />';
				 $('.temp_data').html(out);
				} 
	//widget yang berjalan//
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var self = this,
				currentCategory = "";
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					currentCategory = item.barang;
				}
				self._renderItem( ul, item );
			});
		}
	});
	$(function() {
		//barang yang dicari
		var data = [
			<?php
				$temp = array();
			foreach($barang as $row){
				if(isset($row->intharga_jawa) or $row->intharga_jawa != ""){
					$temp[0] = $row->intharga_jawa;
					}else{
						$temp[0] = 0;
						}
				if(isset($row->intharga_luarjawa) or $row->intharga_luarjawa != ""){
					$temp[1] = $row->intharga_luarjawa;
					}else{
						$temp[1] = 0;
						}
				if(isset($row->intpv_jawa) or $row->intpv_jawa != ""){
					$temp[2] = $row->intpv_jawa;
					}else{
						$temp[2] = 0;
						}
				if(isset($row->intpv_luarjawa) or $row->intpv_luarjawa != ""){
					$temp[3] = $row->intpv_luarjawa;
					}else{
						$temp[3] = 0;
						}
				echo "{ label: '".$row->strnama."', intid_barang: '".$row->intid."',";
					
					///wilayah menentukan harga
					if(!isset($intid_wilayah)){$intid_wilayah =1;}
					if($intid_wilayah == 1){
						
						echo "intharga: '".$temp[0]."', intpv:'".$temp[2]."',  ";
						}else{
							
							echo "intharga:'".$temp[1]."', intpv:'".$temp[3]."'";
							}
				echo "},";
			}
			
		?>
		];
		//proses inputan menjadi berhasil
		var dataTemp = "<input type='text' name='name' value='yahuud'/>";
		
		//proses text search
		$("#search").bind('click', function(e){
			$('#label_verify').html('Belum Berhasil!');
			$('#search').val('');
		});
		$( "#search" ).catcomplete({
			minLength: 5,
			
            delay: 0,
            focus: function(event, ui){
				var q			=	$(this).val();
				$(this).val()	=	q;
				$('#label_verify').html('Belum Berhasil!');
			},
            source: data,
			select: function(event, ui){
				$('#label_verify').html('Tolong di-click!');
				//$('.description').html(dataTemp);
				inputData(ui,status);
			}
		});
	});
	
	//get harga untuk setiap pemesanan barang
	
	function checkInput(idx){
		
		$("#here_"+idx).html(formatAsRupiah(parseInt($(".quantity_"+idx).val()) * parseInt($("#hargaSatuan_"+idx).val())));
		hitungTotal();
		}
		
	//hitung total 	
	
	function hitungTotal(){
		
		temp = 0;
		id = window.idx;
		
		for(var i=0; i<= parseInt(id);i++){
		
			if(!isNaN($(".quantity_"+i).val()) && !isNaN($("#hargaSatuan_"+i).val())){
				
				temp += parseInt($(".quantity_"+i).val()) * parseInt($("#hargaSatuan_"+i).val());
				}
			}
		
		$(".simpan-submit").html(" Rp. "+formatAsRupiah(temp));	
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
</script>