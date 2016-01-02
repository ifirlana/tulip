<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
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
                    select:
                        function(event, ui) {
                        $("#result1").html(
                        "<input type='text' id='harga_barang' name='harga_barang' value='" + ui.item.value1 + "' size='5' readonly='readonly'/><input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='15' /><input type='hidden' id='pv' name='pv' value='" + ui.item.value3 + "' size='15' readonly='readonly'/><input type='hidden' id='id_harga' name='id_harga' value='" + ui.item.value7 + "' size='15' />"
                    );

                    },
                });
	
	function cek(){
		var x=0;
		for (var i=0;i < document.form1.elements.length;i++)
		{
			var e = document.form1.elements[i];
			
			if (e.type == 'checkbox')
			{
				if(e.checked){
					x++;
				}
			}
		}
		
		if(x > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function save_data(){
		
		var isi = document.getElementById('detail').innerHTML;

		if( isi == false){
			document.getElementById('alert').innerHTML = '<ul class="message error grid_12"><li>Harus ada data yang diceklis</li><li class="close-bt"></li></ul><br>';
			
		}else{
			document.getElementById('alert').innerHTML = '';
			
			if(cek()){
				document.forms["form1"].submit();
			}else{
				document.getElementById('alert').innerHTML = '<ul class="message error grid_12"><li>Harus ada data yang diceklis</li><li class="close-bt"></li></ul><br>';
			}
			
		}
		
	}
	
	function get_po(spkb){
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url().'po/get_barang_by_po/'?>' + spkb, 
			success: function(data) {
				$('#detail').html(data);
			}
		});
	}
	
</script>

</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Surat Jalan</h2>
                         <div id="alert"></div>
                          <?php
							$attributes = array('name' => 'form1', 'id' => 'form1');
							echo form_open('po/cetak_sj', $attributes);
						  ?>
                          <table width="685" border="0" id="data" align="center">
                              <tr>
                               <td>Filter No SPKB/SRB</td>
                                  <td>&nbsp; 
                                  <select name="spkb" id="spkb" onchange="javascript:get_po(this.value);">
                                  <option value="">-- Pilih --</option>
                                  <?php
                                        for($i=0;$i<count($intid_po);$i++)
                                        {
                                            echo "<option value='$intid_po[$i]'>$no_spkb[$i]</option>";
                                        }
                                    ?>
                                </select>
                                  <div id="result"></div></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
          
                              </td></tr>
                              </table>
                              
    
    <table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
    <tr align="center" class="" bgcolor="#CCCCCC">
        <th rowspan="2">&nbsp;</th>
        <th rowspan="2">Nama Barang</th>
        <th colspan="2">Reguler</th>
        <th colspan="2">Free</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr align="center" class="" bgcolor="#CCCCCC">
    	<th>Pcs</th>
        <th>Set</th>
        <th>Pcs</th>
        <th>Set</th>
    </tr>
    <tbody id="detail">
							
	</tbody>
</table>
<input name="" type="button" onclick="javascript:save_data();" value="Cetak Surat Jalan"/>
</form>
   </div>
	  </div>
			
	  </div>
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

