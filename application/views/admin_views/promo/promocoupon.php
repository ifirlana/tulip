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
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
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
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
			$("#strnama_dealer").val("");
			$("#result001").empty();
			$("#result").empty();
                        $("#result").append(
                        "<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });


                $("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
                        $("#result001").empty();
                        $("#result001").append(
                        "<input type='hidden' name='intid_dealer' value='"+ui.item.intid_dealer+"' /><input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='25' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='25' readonly/></td>"
                    );
                    },
                });

                $("#strnama_upline").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                });
			
			$('#cekomset').click(function() {
				var form_data = {
					strkode_dealer : $('#strkode_dealer').val(),
					ajax : '1'
				};
				$.ajax({					
					url: "<?php echo base_url(); ?>form_coupon/checkOmset",
					type: 'POST',
					data: form_data,
					beforeSend:
						function()
						{
							$("#message").html("<h2>Loading..</h2>");
						},
					success:
						 function (data){
                         $("#message").html(data);
					},
					error:
					function()
					{
						$("#message").html("<h2>Error! Coba Lagi..</h2>");
					}
				});
				return false;
        	});

            });
        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Promo Coupon</h2>
                    <div class="entry">
                        <form action="<?php echo base_url();?>form_control_penjualan/insertPromoRw" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td>
                                <tr>
                                    <td width="107">&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td >&nbsp;<?php echo $cabang; ?>
                                        <input type="hidden" name="token" size="30" readonly="readonly" value="<?php echo $setToken; ?>">
                                         <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">
										 <input type="hidden" name="halaman" size="30" readonly="readonly" value="<?php echo "predwhite"; ?>">
										<input type="hidden" id="intid_wilayah001" name="intid_wilayah001" size="30" readonly="readonly" value="<?php echo $id_wilayah; ?>">       </td>
                                        <input type="hidden" name="datetgl" size="30" value="<?php echo date("Y-m-d");?>">
                                        <input type="hidden" name="intid_week" size="30" value="<?php echo $intid_week;?>">        </td>
                                    <td>&nbsp;,</td>
                                    <td>&nbsp;<?php echo date("d-m-Y");?></td>
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
                                    <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer"/ size="25"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;No Kartu<br /><br />
                                    &nbsp;Upline &nbsp;&nbsp;</td>
                                    <td>&nbsp;:</td>
                                    <td>&nbsp;<div id="result"></div><div id="result001"></div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><input type="button" name="button" id="cekomset" value="Cek Omset" /><input type="hidden" name="is_lg" value="0"/> </td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
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