
<script>
                $(function() {
    			$('#form_tujukin').hide();
				$('#intid_unit').autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: '<?php echo base_url(); ?>penjualan/lookupUnit',
                            dataType: 'json',
                            type: 'POST',
                            data: req,
                            success:
                                function(data){
                                if(data.response =='true'){
                                    add(data.message);
                               			}
                            		},
                        		});
                    		},
					    focus:
							function(event,ui) {
								var q = $(this).val();
								$(this).val() = q;
							    },
			            select:
			                function(event, ui) {
								$('#strnama_dealer').val('');
								$('#result001').empty();
								$('#result').empty();
							    $('#result').html("<input type='hidden' id='id_unit' name='id_unit' value='"+ ui.item.id +"' size='10' />");
							    },
							});
                    });
    			</script><script>
                $(function() {
                    $('#strnama_dealer').autocomplete({
                        minLength: 2,
                        source:
                            function(req, add){
                            $.ajax({
                                url: '<?php echo base_url(); ?>penjualan/lookupUpline',
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    term: req.term,
                                    state: $('#id_unit').val(),

                                },
                                success:
                                    function(data){
                                    if(data.response =='true'){
                                        add(data.message);
                                        }
                                    },
                                });
                            },
                        focus:
                            function(event,ui) {
                            var q = $(this).val();
                            $(this).val() = q;
                            },
                        select:
                            function(event, ui) {
                            $('#result001').empty();
                            $('#result001').append("<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' readonly/><input type='hidden' id='intid_dealer' name='intid_dealer' value='" + ui.item.intid_dealer + "' readonly/></td>");
                            },
                    });
                });
                </script><table border="0" id="data" align="center" style="width:100%;">
                    <tr>
                        <td width="107">&nbsp;</td>
                        <td width="316">&nbsp;</td>
                        <td width="35">&nbsp;</td>
                        <td ><?php echo $cabang; ?>
                            <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">
                            <input type="hidden" name="intid_week" size="30" readonly="readonly" value="<?php echo $intid_week; ?>">
                            <input type="hidden" name="halaman" size="30" readonly="readonly" value="sprb">
                        </td>
                        <td>&nbsp;,</td>
                        <td>&nbsp;<?php echo $datetgl; ?></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;Unit</td>
                        <td>&nbsp;:</td>
                        <td><input type="text" name="textfield4" id="intid_unit"  size="25"/></td>
                    </tr>
                    <tr>
	                    <td>&nbsp;</td>
	                    <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="82">&nbsp;Nama</td>
                        <td width="7">&nbsp;:</td>
                        <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="25"/></td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;No Kartu<br /><br />&nbsp;Upline :</td>
                        <td>&nbsp;:</td>
                        <td valign="top">&nbsp;<div id="result"></div><div id="result001"></div></td>
                    </tr></table>