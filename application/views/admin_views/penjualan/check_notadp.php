<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready( function() {
       
            $('#lunas').click(function() {

                
            var form_data = {
                no_notadp 	: $('#no_notadp').val(),
				instalment_number	: $("#instalment_number").val(),
				id_unit 					: $('#id_unit').val(),
				id_dealer				: $("#id_dealer").val(),
				type_membership		: $("#type_membership").val(),
				membership_name	: $("#membership_name").val(),
                ajax : '1'
            };
            $.ajax({
                url: "<?php echo base_url(); ?>penjualan/pelunasan_dp",
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
echo link_tag('css/style2.css');?>
<h2 class="title">Check Nota DP</h2>
<table width="685" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
            <th >No</th>
            <th >Tanggal</th>
            <th >No Nota Dp</th>
            <th >Total Bayar</th>
            <th >DP</th>
            <th >Sisa</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=1;
			$total = 0;
			foreach($datadp as $m) :

		?>

      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
			<td align='left'>&nbsp;<?php echo $m->intno_nota; ?><input id="no_notadp" type="hidden" value="<?php echo $m->intno_nota; ?>"/></td>
            <td align='right'>&nbsp;<?php echo number_format($m->inttotal_bayar); ?></td>
            <td align='right'>&nbsp;<?php echo number_format($m->intdp); ?></td>
            <td align='right'>&nbsp;<?php echo number_format($m->intsisa); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class='data' align='center'>
        	<td align="right" colspan="6">&nbsp;</td>
        </tr>
        <tr class='data' align='center'>
        	<td align="center" colspan="6"><input type="button" name="lunas" id="lunas" value="Pelunasan" /></td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<div id="message2"></div>
