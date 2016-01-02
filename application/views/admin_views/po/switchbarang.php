<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            $(document).ready( function() {
                $("#intno_nota").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupNoNota",
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
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
							$("#strnama_dealer").val("");
							$("#result").empty();
                        	$("#result").append(
                        	"<input type='text' align='top' id='strnama_dealer' name='strnama_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strnama_upline' name='strnama_upline' value='" + ui.item.value2 + "' size='30' readonly/><input type='text' id='strnama_unit' name='strnama_unit' value='" + ui.item.value2 + "' size='30' readonly/></td>"
                    		);
                    	},
                });

				autoComp();
            });

            //for barang
            function autoComp(){

                var ur = "<?php echo base_url(); ?>penjualan/lookupBarang";
                
                $(".id1").autocomplete({

                    minLength: 2,
                    source:
                        function(req, add){


                        $.ajax({
                            url: ur,
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
		    focus:
			function(event,ui) {
			var q = $(this).val();
			$(this).val() = q;
		    },
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );
                    },
                });


                $(".frees").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){

                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupBarang",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_barang').val(),
                             },
                            success:
                                function(data){
                                if(data.response =="true"){
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
                        $("#result2").html(
                        "<input type='text' id='harga_barang_free' name='harga_barang_free' value='0' size='5' readonly='readonly'/><input type='hidden' id='id_free' name='id_free' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='0' size='15' readonly='readonly'/>"
                    );
                    },
                });


            }

        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Switch Barang</h2>
                    <div class="entry">
                        <form action="<?php echo base_url()?>penjualan/nota" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                            <table width="685" border="0" id="data" align="center">
                                <tr>
                                    <td width="107">
                                
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="316">&nbsp;</td>
                                    <td colspan="3">&nbsp;</td>
                                    <td width="213">&nbsp;</td>
                              </tr>
                                <tr>
                                    <td colspan="6"><div align="center" id="title"></div></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="116">&nbsp;Silahkan ketik</td>
                                              <td width="367">&nbsp;Nama Barang</td>
                                      </tr>
                                            <tr>
                                                <td>Barang Lama-&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                <input type="text" name="barang[1][intid_barang]" class="id1" size="50" /></td>
                                            </tr>
                                            <tr>
                                                <td> Barang Baru -&gt;</td>
                                                <td>&nbsp;&nbsp;<input type="text" name="free" class="frees" size="50" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <div id="ButtonAdd" style="margin-left: 150px"></div></td>
                                            </tr>
                                  </table></td>
                                </tr>
                                <tr>
  									<td>&nbsp;</td>
                                  	<td>&nbsp;</td>
                                  	<td>&nbsp;</td>
                                    <td width="190">No Nota</td>
                                    <td>:</td>
                                    <td><input type="text" name="no_nota" id="intno_nota"/></td>
                                </tr>
	                            <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>Nama</td>
                                  <td>:</td>
                                  <td><div id="result"></div></td>
	                            </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" disabled="disabled" class="button"/></td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='gudang';"/></td>
                                </tr>
                            </td>
                            </tr>
                            </table>
                        </form>
                    </div>
                </div></div>
        </div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          var charCode;
		  if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

