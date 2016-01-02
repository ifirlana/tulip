<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready( function() {
			//$('#show_tebus_lg').show();
            $('#show_tebus_lg').hide();
			$('#submit2').click(function() {

                
            var form_data = {
                strkode_dealer : $('#strkode_dealer').val(),
                ajax : '1'
            };
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/tebuslglain",
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
            <th >Omset</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=0;
			$total = 0;
			foreach($omset as $m) :				
			$temp = $i;
			$i = $i + 1;
		?>
	
      	<tr class='data' align='center'>
			<td ><?php echo $i; ?><input type='checkbox' value='<?php echo $temp; ?>' name='pilih[]' onClick='cekOmset(this.id)' id='id_<?php echo $temp; ?>' />
			<input type='hidden' name='nomor_nota[]' id='intno_nota_<?php echo $temp;?>' value='<?php echo $m->intno_nota;?>' /></td>
            <td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
			<td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
            <td align='left'>&nbsp;<?php echo number_format($m->inttotal_omset); ?><input type='hidden' id='omset_<?php echo $temp; ?>' value='<?php echo $m->inttotal_omset; ?>' /></td>
            
        </tr>
        <?php 
		$total = $total + $m->inttotal_omset;
		endforeach; ?>
		
		<tr class='data' align='center'>
        	<td align="right" colspan="3">
		<input type='hidden' id='tracker009' name='tracker009' value='<?php echo $temp;?>' />
		<input type='hidden' id='tracker099' value='' />
		Jumlah Omset yang ditebus </td>
            <td align="left">&nbsp;<?php //echo number_format($total)?><input type='text' id='total' value='0' readonly /></td>
        </tr>
    </tbody>
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
		function cekOmset(id){
			var temp = 0;
			for(var i=0; i <= $('#tracker009').val();i++){
				//alert('helo '+i);
				if($('#id_'+i).attr('checked') == true){
					temp = parseInt(temp) + parseInt($('#omset_'+i).val());
				}
			}
			$('#total').val(temp);
				if(temp >= 350000){
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
			/* 
			if($('#intid_wilayah001').val() == 1 ){
				if(temp >= 1000000 && temp < 1500000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 1');
					$('#tracker099').val('LG1');
					$('#show_tebus_lg').show();
				}else if(temp >= 1500000 && temp < 2350000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 2');
					$('#tracker099').val('LG2');
					$('#show_tebus_lg').show();
				}else if(temp >= 2350000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 3');
					$('#tracker099').val('LG3');
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
			}else if($('#intid_wilayah001').val() == 2 ){
				if(temp >= 1100000 && temp < 1650000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 1');
					$('#tracker099').val('LG1');
					$('#show_tebus_lg').show();
				}else if(temp >= 1650000 && temp < 2600000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 2');
					$('#tracker099').val('LG2');
					$('#show_tebus_lg').show();
				}else if(temp >= 2600000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 3');
					$('#tracker099').val('LG3');
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
			}else if($('#intid_wilayah001').val() == 3 ){
				if(temp >= 375 && temp < 525){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 1');
					$('#tracker099').val('LG1');
					$('#show_tebus_lg').show();
				}else if(temp >= 525 && temp < 9000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 2');
					$('#tracker099').val('LG2');
					$('#show_tebus_lg').show();
				}else if(temp >= 900){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 3');
					$('#tracker099').val('LG3');
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
			}else if($('#intid_wilayah001').val() == 4 ){
				if(temp >= 400 && temp < 575){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 1');
					$('#tracker099').val('LG1');
					$('#show_tebus_lg').show();
				}else if(temp >= 575 && temp < 9000){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 2');
					$('#tracker099').val('LG2');
					$('#show_tebus_lg').show();
				}else if(temp >= 900){
					//alert('Nominal Sudah Mencukupi! Silahkan Tebus LG 3');
					$('#tracker099').val('LG3');
					$('#show_tebus_lg').show();
				}else{
					 $('#show_tebus_lg').hide();
					 $('#message2').html('');	
				}
			} */
		}
	</script>
            <p>&nbsp;</p>
<div id="message2"></div>
