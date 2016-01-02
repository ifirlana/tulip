<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready( function() {
       
            $('#submit2').click(function() {

                
            var form_data = {
                strkode_dealer : $('#strkode_dealer').val(),
                ajax : '1'
            };
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/tebuslg",
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
            <th >Nama Rekrutan</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=1;
			$total = 0;
			foreach($rekrut as $m) {
			$total=$total+1;
			echo "<tr class='data' align='center'>
				<td >".$i++."</td>
				<td align='left'>&nbsp;".$m->tanggal."</td>
				<td align='left'>&nbsp;".$m->intno_nota."</td>
				<td align='left'>&nbsp;".$m->strnama_dealer."
				<input type='hidden' id='is_tebus_".$total."' value='".$m->is_tebus."' />
				<input type='hidden' name='id[".$total."]' value='".$m->child_id."' />
				<input type='hidden' name='harga_luarjawa' id='harga_luarjawa_".$total."' value='".$m->intharga_luarjawa."' />
				<input type='hidden' name='harga_jawa' id='harga_jawa_".$total."' value='".$m->intharga_jawa."' />
				</td>
				</tr>";
			}
		?>
        <tr class='data' align='center'>
        	<td align="right" colspan="3">Jumlah</td>
            <td align="left">&nbsp;<?php echo $total;?></td>
        </tr>
    </tbody>
</table>
<table width="685" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
	<tr>
    	<td colspan="3" align="center"><input type="hidden" id="totalrekrut001" name="totalrekrut001" value="<?php echo $total; ?>" />
   	    <?php //if (($total)>=800000) echo '<br />'.form_submit('submit','Tebus LG','id="submit2" class="button"');else echo '';?>
		</td>
    </tr>
</table>
                
                <p>&nbsp;</p>
<div id="message2"></div>
