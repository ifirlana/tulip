<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready( function() {
	$('#persen1').attr("disabled",true);
	/* $('#persen2').attr("disabled",true);
	$('#persen3').attr("disabled",true);
	$('#persen4').attr("disabled",true); */
			//$('#show_tebus_lg').show();
            $('#show_tebus_lg').hide();
			$('#submit2').click(function() {

                
            var form_data = {
                strkode_dealer : $('#strkode_dealer').val(),
                ajax : '1'
            };
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/tebuslglainnew_rekrut10",
                type: 'POST',
                async : false,
                data: form_data,
                success: function(msg2) {
                    $('#message2').html(msg2);
                }
            });
            return false;
            
        });
    });
</script>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<h2 class="title">Omset</h2>
<table width="685" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
            <th >No</th>
            <th >Tanggal</th>
            <th >No Nota</th>
            <th >Nama Member</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=0;
			$total = 0;
			/* if(isset($omset) and !empty($omset))
			{ */
				foreach($omset as $m) :				
				$temp = $i;
				$i = $i + 1;
				$isdes='';
				/* if($m->status_nota == 1):
				$isdes = "checked disabled";
				endif; */
			?>
		
			<tr class='data' align='center'>
				<td ><?php echo $i; ?><input type='checkbox'  name='pilih[]' class ='chkuser clickme' onClick='cekOmset(this.id)' id='id_<?php echo $temp; ?>' <?php echo $isdes;?> value = '<?php echo $m->intno_nota;?>' />
				<input type='hidden' name='nomor_nota[]' id='intno_nota_<?php echo $temp;?>' value='<?php echo $m->intno_nota;?>' /></td>
				<td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
				<td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
				<td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
				
				
			</tr>
			<?php 
			//$total = $total + $m->inttotal_omset;
			endforeach; 
		//}
		?>
		
		<tr class='data' align='center'>
        	<td align="right" colspan="3">
			<input type='hidden' id='tracker009' name='tracker009' value='<?php echo $temp;?>' />
			<input type='hidden' id='tracker099' value='' />
				Jumlah Rekrut yang ditebus </td>
				<td align="left">&nbsp;<?php //echo number_format($total)?><input type='text' id='total' value='0' readonly /></td>
				
        </tr>
		
    </tbody>
</table>
<table>
	<tr align=center>
			<td><h2 class="title">PERSEN</h2></td>
			<!--<td><input type="checkbox" name="persen" id="persen1" class="prs" value="0.7">Diskon 30%</td>
			<td><input type="checkbox" name="persen" id="persen2" class="prs"  value="0.65">Diskon 35%</td>
			<td><input type="checkbox" name="persen" id="persen3" class="prs"  value="0.6">Diskon 40%</td> -->
			<td><input type="checkbox" name="persen" id="persen1" class="prs"  value="0.55">Diskon 45%</td>
	</tr>
	

</table>
		
<table width="685" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
	<tr>
    	<td colspan="3" align="center"><input type="hidden" id="totalomset001" value="<?php echo $total ?>" />
		<div id="show_tebus_lg"> 
			<?php echo '<br />'.form_submit('submit','Tebus','id="submit2" class="button"');?>
		</div>
		</td>
    </tr>
</table>
    <script type="text/javascript">
		/* 	var tem = 0;
		$('.clickme').click(function(){
			
			if($(this).attr("checked") == true){
					tem +=1;
					
			}else{
			tem -=1;
			}
			if(tem == 10){
				$('#persen1').attr("disabled",false);
			}else{
			$('#persen1').attr("disabled",true);
			}
			//alert(tem);
		}); */
		window.persen = 1;
		var cekOmset = function (id){
			var temp = 0;
			var temptebus = 0;
			var temptlain = 0;
			
			/* var isi = $("input:checked").length; */
			var isi = $(".chkuser").length;

				
					for(var i=0; i <= $('#tracker009').val();i++){
						//alert('helo '+i);
						if(($('#id_'+i).attr('checked') == true) && ($('#id_'+i).attr('disabled') == false)){
							temp += 1;
						}
					}
					
					/*if(($('#id_'+i).attr('checked') == true) && ($('#id_'+i).attr('disabled') == false)){	
						temp += 1;
					}
					 if($('#id_'+i).attr('disabled') == true){
						temptebus += 1;
						temptlain += 1;
						//console.log("eeee");
					} */
				
				
				console.log("temp" , temp);
				//console.log("temptlain" , temptlain);
				//console.log("temptebus" , temptebus);
				//console.log("total" , temptlain + temp);
		
			$('#total1').val(temptebus);
			$('#total').val(temp);
				 if(parseInt(temp) == 10 )
				 {
					$('#persen1').attr("disabled",false);
					$('#show_tebus_lg').show();
				}
				else{
					console.log("teset");
					$('#persen1').attr("disabled",true);
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
				
				
		}
		$('.prs').click(function(){
			window.persen  = $(this).val();
			$('.prs').attr("disabled",true);
					
			//alert("Anda mendapatkan : "+ window.persen);
		});
	</script>
            <p>&nbsp;</p>
<div id="message2"></div>
