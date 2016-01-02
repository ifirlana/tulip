<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
  <script type="text/javascript">
           
 //for barang
            $(this).ready( function() {
    		$("#intid_barang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupBarang",
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
            			"<input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		
		function check_all(val) {
			var checkbox = document.myform.elements['pilih[]'];
			if ( checkbox.length > 0 ) {
				for (i = 0; i < checkbox.length; i++) {
					if ( val.checked ) {
						checkbox[i].checked = true;
					}
					else {
						checkbox[i].checked = false;
					}
				}
			}
			else {
				if ( val.checked ) {
					checkbox.checked = true;
				}
				else {
					checkbox.checked = false;
				}
			}
		}
		
</script>
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> INPUT STOK PUSAT</h2>
         <form name="myform" id="myform" action="<?php echo base_url()?>po/inputstokpusat" method="post">
        <fieldset>
        <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
            <thead>
                <tr class="table" align="center" >
                <th width="178" rowspan="2">&nbsp;</th>
                  <th width="461" rowspan="2">Nama Barang</th>
                  <th colspan="2">Stok</th>
                </tr>
                <tr class="table" align="center" >
                  <th width="160" >Pcs</th>
                  <th width="163">Set</th>
                </tr>
            </thead>
            <tbody>

               <?php
                $no=1;
                foreach($barang as $m) : 
				?>
          <tr class='data' align='center'>
		  <td align="left"><input type="checkbox" name="pilih[]" value="<?php echo $m->intid_barang?>" />
          <input id="nama<?php echo $no?>" name="nama[<?php echo $no?>]" type="hidden"  size="5" value="<?php echo $m->strnama; ?>"/>
		  </td>
           <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
           <td align='center'>&nbsp;<input name="stokpcs[]" id="stokpcs_<?php echo $no?>" type="text" size="5" class="number" digit_decimal="2"/></td>
            <td align='center'>&nbsp;<input name="stokset[]" id="stokset_<?php echo $no?>" type="text" size="5" class="number" digit_decimal="2"/></td>
            </tr>
            <?php 
            $no++;
            endforeach;?> 
            <tr>
            <td colspan="4"><input type="checkbox" onclick="check_all(this)" />Select All/Unselect All<br /></td>
            </tr>
            </tbody>
        </table>
        </fieldset>
<p align="center"><input type="submit" name="update" value="Simpan" /></p>
</form>
		  </div>
	  </div>
			
	  </div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div id="rec1" style="width:800px; height: 100px;"></div>
        <div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

