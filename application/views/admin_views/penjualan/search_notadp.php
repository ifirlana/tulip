<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            //for unit
            $(document).ready( function() {
                $("#intno_nota").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupDp",
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
						$("#instalment_number").val(ui.item.value);
                        $("#result-lookup").html(
                        "<input type='hidden' id='id_unit' name='intid_unit' value='" + ui.item.intid_unit + "' size='10' readonly /><input type='hidden' name='intid_dealer' id='id_dealer' value='"+ui.item.intid_dealer+"' readonly /><input type='hidden' name='type_membership' id='type_membership' value='"+ui.item.type_membership+"' readonly /><input type='hidden' name='membership_name' id='membership_name' value='"+ui.item.membership_name+"' readonly />"
						);
                    },
                });
				
				$('#cari').click(function() {
				var form_data = {
					intno_nota : $('#intno_nota').val(),
					ajax : '1'
				};
				$.ajax({					
					url: "<?php echo base_url(); ?>penjualan/check_notadp",
					type: 'POST',
					async : false,
					data: form_data,
					success:
						 function (data){
                         $("#message").html(data);
					},
				});
				return false;
        	});
			
			});
        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">PELUNASAN DP</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/lunasdp" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
							<div id="result-lookup"></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td width="149">
                                <tr>
                                    <td>No Nota DP</td>
                                    <td width="10">:</td>
                                    <td width="269"><input type="text" name="textfield4" id="intno_nota" /><input type="hidden" name="instalment_number" id="instalment_number" value="" readonly/></td>
                                    <td width="100"><input type="button" name="btnsearch" id="cari" value="Search" /></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td width="60">&nbsp;</td>
                                    <td width="6">&nbsp;</td>
                                    <td width="165">&nbsp;</td>
                                </tr>
                              </table>
</td>
                            </tr>
                            </table>
                       
                        <div id="message"></div>
                       </form>
                    </div>
                </div></div>
        </div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>