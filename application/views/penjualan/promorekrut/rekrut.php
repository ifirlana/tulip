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
                url: "<?php echo base_url(); ?>promorekrut/tebus_rekrut",
                type: 'POST',
                async : false,
                data: form_data,
                success: function(msg2) {
                    $('#message2').html(msg2);
					$("#show_tebus_rekrut").attr("style","display:none");
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
            <th >Kode dealer</th>
            <th >Nama dealer</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=0;
			$total = 0;
			foreach($rekrut as $m){				
			$temp = $i;
			$i = $i + 1;
		?>
	
      	<tr class='data' align='center'>
			<td ><?php echo $i; ?><span id="check_id_<?php echo $i; ?>">
			<input type='checkbox' value='<?php echo $i; ?>' name="pilih[<?php echo $temp; ?>]" onClick='cekRekrut(this.id)' class="pilih_<?php echo $i; ?>" id='id_<?php echo $i; ?>' value='<?php echo $i;?>' /></span>
			<input type='hidden' name='intid_dealer[<?php echo $i;?>]' id='intid_dealer_<?php echo $i;?>' value='<?php echo $m->intid_dealer;?>' /></td>
            <td align='left'>&nbsp;<?php echo $m->datetanggal; ?></td>
			<td align='left'>&nbsp;<?php echo $m->strkode_dealer; ?></td>
            <td align='left'>
			&nbsp;<?php echo $m->strnama_dealer; ?>
			<input type='hidden' id='omset_<?php echo $i; ?>' value='<?php echo $m->strnama_dealer; ?>' /></td>
            
        </tr>
        <?php 
			} ?>
		<tr class='data' align='center'>
        	<td align="right" colspan="3">
		<input type='hidden' id='tracker009' name='tracker009' value='<?php echo $i;?>' />
		<input type='hidden' id='tracker099' value='' />
		Jumlah Rekrut yang ditebus </td>
            <td align="left">&nbsp;<?php //echo number_format($total)?><input type='text' id='total' value='0' readonly /></td>
        </tr>
    </tbody>
</table>
<table width="685" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
	<tr>
    	<td colspan="3" align="center"><input type="hidden" id="totalRekrut" value="<?php echo $total ?>" />
		
		<div id="message2">
		<div id="show_tebus_rekrut" style="display:none;"> 
			<?php echo '<br />'.form_submit('submit','Tebus Rekrut','id="submit2" class="button"');?>
		</div>
		</div>
		</td>
    </tr>
</table>
    <script type="text/javascript">
		function cekRekrut(id){
			var temp = 0;
			for(var i=0; i <= $('#tracker009').val();i++){
				
				if($('#id_'+i).attr('checked') == true){
					temp = parseInt(temp) + parseInt(1);
				}
			}
			$('#total').val(temp);
			
			//
			if(!isNaN($("#total").val()) || $("#total").val() > 0){
				
				$("#show_tebus_rekrut").removeAttr("style");
				}
				else{
				
					$("#show_tebus_rekrut").attr("style","display:none");
					}
			}
		function hidden_chosen(){ 
			var _temp	=	$("#tracker009").val();
			for(i=1;i<_temp;i++){
				
				if($(".pilih_"+i).attr("checked") == true){
					$("#check_id_"+i).attr("style","display:none;");
					}
				}
			}
	</script>
            <p>&nbsp;</p>
