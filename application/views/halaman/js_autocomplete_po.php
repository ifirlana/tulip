<script>
//pertama kali load 
	$(document).ready( function() 
	{
		window.idx = 0;
		status 				= '<?php echo $halaman;?>';
		intid_wilayah 	= <?php echo $intid_wilayah;?>;
		var out = '';
		$('#label_verify').html();
		$('#search').val();
		//proses setting tempat penginputan
		if(status == 'po')
		{
			out = "<div id='divListBarang'><ul style='list-style-type:decimal;' id='dataListBarang'><ul style='list-style-type:none;'><li style='float:left; margin-left:-40px;'>JUMLAH</li><li style='float:left;margin-left:10px;'>NAMA BARANG</li><li style='float:left;margin-left:210px;'>KETERANGAN</li><li style='float:left;margin-left:100px;'>Harga</li></ul><br id='content-list'/></ul></div>";
		}
		$(out).insertAfter('.description');           
			
			///menambah variabel ke form
		$('#btn_tambah').bind('click', function(e)
		{			
			if($('.barang_').val() != null)
			{
				$('#search').val('');
				$('#label_verify').html('Berhasil!');
				inputForm(window.idx++,status);
				$('.temp_data').html('');
			}
			else
			{
				alert('data harus di pilih dahulu');
			}
		});
		
		$("#search").autocomplete(
		{
			minLength: 2,
            source:
				function(req, add)
				{
					$.ajax(
					{
						<?php if(isset($url_barang))
							{
								echo "url:'".$url_barang."',";
							}
							else
							{
							?>
							url: "<?php echo base_url(); ?>POCO/lookupBarangPO",
							<?php 
							}
							?>
						dataType: 'json',
						type: 'POST',
						data: req,
						beforeSend:
							function()
							{
								$('#label_verify').html('Tunggu Lagi Loading!');
							},
						success:
							function(data)
							{
                                if(data.response =="true")
								{
                                    add(data.message);
									$('#label_verify').html('Pilih Dahulu');
                                }
								else if(data.response =="false")
								{
									$(this).data().term = null;
									$('#label_verify').html('Tidak Ada Data');
								}
                            },
                    });
                },
		    focus:
				function(event,ui) 
				{
					$(this).val($(this).val());
				},
			select:
				function(event, ui) 
				{
					$('#label_verify').html('Silahkan di Click \"+\"');
					inputData(ui,status);
                },
		});
	});
	function inputData(ui,status)
	{
		$('.temp_data').html('');
		var out = '<input type="hidden" class="barang_" name="barang" type="text" size="1" value="'+ui.item.intid_barang+'" />';
			 out += '<input type="hidden" class="namabarang_" name="barang" type="text" size="1" value="'+ui.item.label+'" />';
			 out += '<input type="hidden" class="hargabarang_" name="barang" type="text" size="1" value="'+ui.item.intharga+'" />';
			 $('.temp_data').html(out);
	}
	
	function inputForm(idx,status)
	{
		
		console.log("idx : "+idx);
		var out = "";
		if(status == 'po')
		{
			 out = '<li id="listBarang" class="listBarang_'+idx+'">';
			 out += '<input id="'+idx+'" class="quantity_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="1" value="0" onKeyUp="return checkInput('+idx+');" />';
			out += '<td><input id="'+idx+'" class="barang_'+idx+'" name="barang['+idx+'][strnama]" type="text" size="40" value="'+$('.namabarang_').val()+'" readonly = "true"/>';
			out += '<input id="'+idx+'" class="ket_'+idx+'" name="barang['+idx+'][keterangan]" type="text" size="30" />';
			out += '<input id="'+idx+'" class="intid_'+idx+'" name="barang['+idx+'][intid_barang]" type="hidden" size="5" value="'+$('.barang_').val()+'" readonly = "true"/>';
			out += '<input id="'+idx+'" class="barang_'+idx+'" name="barang['+idx+'][no_po]" type="hidden" size="10" value="'+$('#no_po').val()+'" readonly = "true"/>';
			out += '<input type="hidden" value="'+$('.hargabarang_').val()+'" id="hargaSatuan_'+idx+'" />';
			out += '<span id="here_'+idx+'"></span>';
			out += '</li><br />';
			//$('#content-list').insertAfter(out);
			$(out).insertAfter('#content-list');           
			$('.input-submit').html('<input type="submit" name="submit" value="Cetak" />');
		}
		else if(status == 'SJ')
		{
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
		else if(status == 'STTB')
		{
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
	}
	function checkInput(idx)
	{	
		$("#here_"+idx).html(formatAsRupiah(parseInt($(".quantity_"+idx).val()) * parseInt($("#hargaSatuan_"+idx).val())));
		hitungTotal();
	}
	function hitungTotal()
	{
		
		temp = 0;
		id = window.idx;
		
		for(var i=0; i<= parseInt(id);i++){
		
			if(!isNaN($(".quantity_"+i).val()) && !isNaN($("#hargaSatuan_"+i).val())){
				
				temp += parseInt($(".quantity_"+i).val()) * parseInt($("#hargaSatuan_"+i).val());
				}
			}
		
		$(".simpan-submit").html(" Rp. "+formatAsRupiah(temp));	
	}
	
	function formatAsRupiah(amount)
	{
		if (isNaN(amount)) 
		{
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