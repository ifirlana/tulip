<table  width="100%" border="0" id="data" align="center">
	<tr>
		<td>Jenis Promo</td>
		<td>
			<input type="hidden" name="intid_control_promo" id ="ppenjualans" >
		<select id="intid_control_promo">
			<option value="0">-- Pilih Jenis Promo --</option>
			<?php
				//KONDISI
				for($i=0;$i<count($nama_promo);$i++) {
				// 1 free 1 net di akses semua
						echo "<option value='$intid_control_promo[$i]'>$nama_promo[$i]</option>";
					}
				?>
		</select>			
		</td>
		<td>&nbsp;</td>
		<td>
			</td>
		<td>&nbsp;Jenis Penjualan</td>
		<td>&nbsp;
			<input type="hidden" name="nota_intid_jpenjualan" id ="jpenjualans" value="0" >
				<select name="nota_intid_jpenjualan_t" id="intid_jpenjualan">
				<option value="0">-- Pilih Jenis Penjualan--</option>
				<?php
				//KONDISI
				/* for($i=0;$i<count($strnama_jpenjualan);$i++) {
				// 1 free 1 net di akses semua
						echo "<option value='$intid_jpenjualan[$i]'>$strnama_jpenjualan[$i]</option>";
					} */
				?>
			</select>         </td>
		
			
	</tr>
	<tr>
		<td colspan="6" align="center"><?php $this->load->view('template/voucher_nota') ?></td>
	</tr>
	
</table>
<script>
	$(document).ready(function(){
	$('#tempPromoBarang').hide();
		window.count = 0;
		/* 
		* created by: fahmi hilmansyah
		* berfungsi untuk men-setting nilai variable
		*/
		window.lookup_url_bayar	= "";
		window.lookup_url_free 	= "";
		window.kom10 = 0;
		window.kom15 = 0;
		window.pencarian = '';
		window.pencarian_asli = '';
		window.kom20 = 1;
		window.diskon = 0;
		window.pv = 1;
		window.isbayar = 1;
		window.isfree	= 0;
		window.isfreeT = 0;
		window.koms20=0;
		window.omset	=0;
		window.isCon = 0;
		window.is_komtam=0;
		window.is_voucher=0;
		window.id_destiny = 0;
		function addGenBarang(stat){
			 $.ajax({
			 url: "<?php echo base_url(); ?>form_control_penjualan/form_add_Barang",
			 type: 'POST',
			 data:{intid_control_promo:$("#intid_control_promo").val(), intid_jpenjualan:$("#intid_jpenjualan").val()},
			 beforeSend:
				function(){										
					$("#loadFormaddBrg").html("<h3>Loading..</h3>");
					},
			success:
				function(data){
					$("#loadFormaddBrg").html(data);
					if(stat == "true")
					{
						$('.nameBarang ').attr("disabled",false);
					}
					},
				});
			}
		
		function loadFiturPromo(id_control_promo,url)
				{
				    console.log("cikluk");
				    $.ajax({
                    url: "<?php echo base_url(); ?>form_control_penjualan/"+url,
                    type:'POST',
                    data :{prom:id_control_promo},
                    dataType: 'json',
                    cache:false,
                    
                    success:function(msg)
                        {
                            $("#jpromocombo").empty();
                            $("#jpromocombo").append("<option value=''>-- Silahkan Pilih --</option>");
                            $.each(msg.message,function()
                            {
                                $("#jpromocombo").append("<option value="+this.id_control_combo+">"+this.namaCombo+"</option>");
                            });
                           /*
                            window.pencarian = msg.mescari.pencarian;
                                                       window.isCon = msg.mescari.is_Con_B;
                                                       console.log('Pencariannya : ',window.pencarian);
                                                       console.log('ubah vontrol IsCon : ',window.isCon);*/
                           
                            //addGenBarang("false");
                    },
                });
					
				}
		
		function ubahControl( proms,urls,id_cabang,jpen/* jpen,cprom */){
			
			$.ajax({
				url: "<?php echo base_url(); ?>form_control_penjualan/"+urls,
				type:'POST',
				data :
				{
					prom:proms,
					id_cabang:id_cabang,
				},
				dataType: 'json',
				cache:false,
				beforeSend:function(){
							$("#intid_jpenjualan").empty();
							$("#loadFormaddBrg").html("<div class='notf'><center><b>Silahkan <br> Pilih Jenis Penjualan</b></center></div>");
						},
				success:function(msg)
					{
						$("#intid_jpenjualan").empty();
								$("#intid_jpenjualan").append("<option value='0'>-- Silahkan Pilih --</option>");
								
								$.each(msg.message,function()
								{
									$("#intid_jpenjualan").append("<option value="+this.intid_jpenjualan+">"+this.strnama_jpenjualan+"</option>");
									
								});
							
						
						
						window.pencarian = msg.mescari.pencarian;
						window.pencarian_asli = msg.mescari.pencarian;
						
						window.isCon = msg.mescari.is_Con_B;
						console.log('Pencariannya : ',window.pencarian);
						console.log('ubah vontrol IsCon : ',window.isCon);
						//addGenBarang("false");
				},
			});
			
			}
			function ubahControlCombo( proms,urls,jpen/* jpen,cprom */){
            
            $.ajax({
                url: "<?php echo base_url(); ?>form_control_penjualan/"+urls,
                type:'POST',
                data :{prom:proms},
                dataType: 'json',
                cache:false,
                
                success:function(msg)
                    {
                       
                        window.pencarian = msg.message.status_pencarian;
                        window.isbayar = msg.message.stat_bayar;
						window.isfree	= msg.message.stat_free;
                        
                        console.log('Pencariannya : ',window.pencarian);
                        console.log('Pencariannya isbayar: ',window.isbayar);
                        console.log('Pencariannya isfree: ',window.isfree);
                        
                        //addGenBarang("false");
                },
            });
            }
			function classControl( proms,penjs,urls/* jpen,cprom */){
			   
				/* if (window.pencarian_asli == "combo") {
						   loadFiturPromo($('#intid_control_promo').val(),"controlPromoCombo");
					} */
			   
			$.ajax({ 
				url: "<?php echo base_url(); ?>form_control_penjualan/"+urls,
				type:'POST',
				data :{prom:proms,penj:penjs},
				dataType: 'json',
				cache:false,
				success:function(msg){
				
						
						if(msg.response == 'true' ){
						addGenBarang("true");
						console.log("Response",msg.response);
						window.kom10 	= msg.message.kom10;
						window.kom15 	=  msg.message.kom15;
						window.kom20 	=  msg.message.kom20;
						window.omset 	=  msg.message.totomset;
						window.diskon 	=  msg.message.diskon;
						window.pv 			=  msg.message.pv;
						window.is_komtam 			=  msg.message.is_komtam;
						if($('#jpenjualans').val() != '0')
						{
							window.pencarian		= msg.message.pencarian;
							window.pencarian_asli	= msg.message.pencarian;
						}	
						
						window.isbayar				=  msg.message.stat_bayar;
						window.isfree					=  msg.message.stat_free;
						
						window.lookup_url_bayar	= msg.message.lookup_url;
						window.lookup_url_free 	= msg.message.lookup_url_free;
						window.is_voucher 			= msg.message.is_voucher;
						window.id_destiny			= msg.message.id_destiny;
						console.log("window.is_voucher ",window.is_voucher);
						console.log("kom10 ",msg.message.kom10);
						console.log("kom15 ",window.kom15);
						console.log("kom20 ",window.kom20);
						console.log("diskon ",window.diskon);
						console.log("PV ",window.pv);
						console.log("isbayar ",window.isbayar);
						console.log("isfree ",window.isfree);
						console.log("id_destiny ",window.id_destiny);
						}else{
							if($('#jpenjualans').val() != '0'){
								
							//addGenBarang("false");
							$('.nameBarang ').attr("disabled",true);
							alert("Mohon Maaf Promo Ini \n Tidak Sesuai Dengan Jenis Penjualannya");
							}
						}
					
				},
			});
			}
		
		
		$(document).delegate('#intid_control_promo', 'change', function()
		{
		   /*  $('#tempPromoBarang').hide();*/
		   $('.halaman').val($("#intid_control_promo option[value='" + $("#intid_control_promo").val() +"'").text());
			$('#ppenjualans').val($(this).val()); 
			
			//if(window.accessible_jenis_penjualan == false)
			//{
			if($('#jpenjualans').val() == '0'){
				ubahControl($(this).val(),"controlPromoJpenjualan",$(".intid_cabang").val(),$("#intid_jpenjualan").val());
			}else{
			classControl($('#intid_control_promo').val(),$('#jpenjualans').val(),"classControll"); 
			}
		});
		$(document).delegate('#intid_jpenjualan', 'change click', function()
		{
		    /* console.log(window.pencarian_asli);
		    if (window.pencarian_asli == "combo")
			{
                $('#tempPromoBarang').show();
            }
			else
			{
                $('#tempPromoBarang').hide();
            } */
			if(window.accessible_jenis_penjualan == true)
			{
				$('#jpenjualans').val($(this).val());
				classControl($('#intid_control_promo').val(),$(this).val(),"classControll"); 
			}
			else
			{
				alert("jenis penjualan tidak boleh diganti");
			}
		});
		$(document).delegate('#jpromocombo', 'change', function()
		{
			//$('#ppenjualans').val($(this).val());
            ubahControlCombo($(this).val(),"classControllCombo");
			//ubahControlCombo($('#jpromocombo').val(),$(this).val(),"classControllCombo"); 
		});
		
			/*
			* created by ifirlana@gmail.com
			* #check_intdp
			* proses pembuatan dp
			*/
			$("#check_intdp").bind("click",function()
			{
				if($("#check_intdp").is(":checked") == true)
				{
					alert("DP. :true");
					$("#intcash").val(0);
					$("#intcash").attr("disabled","disabled");
					$("#intdp").removeAttr("disabled");
					$("#is_dp").val(1);
					$(".nota_intno_nota").val("DP."+$(".temp_nota_intno_nota").val());
					
				}else
				{
					alert("DP. :false");
					
					$("#intcash").removeAttr("disabled");
					$("#intdp").val(0);
					$("#intdp").attr("disabled","disabled");
					$("#is_dp").val(0);
					$(".nota_intno_nota").val($(".temp_nota_intno_nota").val());
					
				}
				hitungTotal();
			});
			// end check_intdp.
			
			/*
			* created by ifirlana@gmail.com
			* #check_intkkredit
			* proses pembuatan dp
			*/
			$("#check_intkkredit").bind("click",function()
			{
				alert("Power Buy Mandiri");
				KKreditProcessing();
			});
			// end check_intdp.
		});

</script>
<div id="tempPromoBarang" style="padding: 5px 5px 0px 5px;" align="center" >
Pilih Combo:    <select  id="jpromocombo">
                <option value="0">-- Pilih Jenis Combo--</option>
    </select>
</div> <!-- digunakan untuk load tambahan fitur baru dari promo dan jenis penjualan -->
<div id="loadFormaddBrg"></div> <!-- digunakan untuk load form barang yang fix-->
<div id="formBarang" ></div><!-- digunakan menyimpan barang yang fix -->
<div id="formHitungTotal"><!-- digunakan total barang yang bernilai -->
	<table id="data" width="100%" style="background-color:none;">
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Total Voucher</td>
			<td>&nbsp;</td>
			<input type="hidden" name="nota_intvoucher"	id="nota_intvoucher" value="0" readonly>
			<td><input type="text" name=""	id="inttotal_voucher" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Total Omset</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_omset" id="inttotal_omset" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>PV</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_pv" id="intpv" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Omset 10 % </td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_10" id="inttotal_10" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Omset 15%</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_15" id="inttotal_15" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Omset 20%</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_20" id="inttotal_20" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>komisi 10 % </td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_k10" id="inttotal_k10" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>komisi 15%</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_k15" id="inttotal_k15" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>komisi 20%</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_k20" id="inttotal_k20" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Komisi + <span id="persentambah"></span>%</td>
			<td>&nbsp;</td>
			<td>
			<input type="text" name="nota_inttotal_kOther" id="inttotal_kOther" value="0" readonly></td>
			<input type="hidden" name="nota_persen_kOther" id="nota_persen_kOther" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Total Bayar</td> 
			<td>&nbsp;</td>
			<td><input type="text" name="nota_inttotal_bayar" id="inttotal_bayar" value="0" readonly></td>
		</tr>
		<tr">
			<td width="50%">&nbsp;</td>
			<td style="background-color:yellow;">Cash</td>
			<td>&nbsp;</td>
			<td style="background-color:yellow;"><input type="text" name="nota_intcash" id="intcash" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td style="background-color: rgb(1, 232, 101);">Debit</td>
			<td>&nbsp;</td>
			<td style="background-color: rgb(1, 232, 101);"><input type="text" name="nota_intdebit" id="intdebit" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;
				<span id="kkredit-content" style="display:none;"><!-- kartu kredit -->
					Masukan Nomor <input type='text' id="no_kkredit" name='no_kkredit' value='0' maxlength='20'/>
					<input type='hidden' id="intkomisi_asi" name='intkomisi_asi' value='0' size="5"/>
					<input type='hidden' id="is_asi" name='is_asi' value='0' size="2"/>
				</span>
			</td>
			<td style="background-color: rgb(6, 104, 234);">Kartu Kredit</td>
			<td><input type="checkbox" id="check_intkkredit" /></td>
			<td style="background-color: rgb(6, 104, 234);"><input type="text" name="nota_intkkredit" id="intkredit" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();"></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td style="background-color:red;">DP </td>
			<td><input type="checkbox" id="check_intdp" <?php
			if($this->session->userdata('is_dp') == 0){ ?> disabled <?php }?>
		/></td>
			<td style="background-color:red;"><input type="text" name="nota_intdp" id="intdp" placeholder="0" onkeypress="return isNumberKey(event);" onkeyup="hitungTotal();" value="0" disabled>
			<input type="hidden" name="is_dp" id="is_dp" value="0" size="1" readonly /></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td>Sisa</td>
			<td>&nbsp;</td>
			<td><input type="text" name="nota_intsisa" id="intsisa" value="0" readonly></td>
		</tr>
		<tr>
			<td width="50%">&nbsp;</td>
			<td colspan="2"><input type="submit" id="btn_submit" name="submit" value="submit" disabled /></td>
		</tr>
	</table>
</div>