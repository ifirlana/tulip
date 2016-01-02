<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
	<script type="text/javascript">
	    $(this).ready( function() {
    		$("#intid_barang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>promosi/lookupBarang",
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
            		$("#result").append(
            			"<input type='hidden' id='intid_barang' name='intid_barang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		//-----free-----//
		$(this).ready( function() {
    		$("#intid_barang_free").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>promosi/lookupFree",
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
            		$("#result2").append(
            			"<input type='hidden' id='intid_barang_free' name='intid_barang_free' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		$(this).ready( function() {
    		$("#intid_barang_free1").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>promosi/lookupFree",
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
            		$("#result3").append(
            			"<input type='hidden' id='intid_barang_free1' name='intid_barang_free1' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		//free3
		$(this).ready( function() {
    		$("#intid_barang_free2").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>promosi/lookupFree",
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
            		$("#result4").append(
            			"<input type='hidden' id='intid_barang_free2' name='intid_barang_free2' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
	    </script>
    </div>
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
				<div class="entry"> 
				<form action="<?php echo base_url()?>promosi/add2" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2">Tambah Data Promosi</td>
      </tr>
     <tr>
        <td width="32%">&nbsp;Start Week</td>
        <td width="68%"><select name="intid_week_start">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($idw);$i++)
				{
					echo "<option value='$idw[$i]'>$idw[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;End Week</td>
        <td><select name="intid_week_end">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($ide);$i++)
				{
					echo "<option value='$ide[$i]'>$ide[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      	<td>&nbsp;Nama Barang</td>
        <td><input type="text" name="intid_barang" id="intid_barang" size="50" /><div id="result"></div>
         </td>
      </tr>
	   <tr>
      	<td>&nbsp;Nama Barang Free 1</td>
        <td><input type="text" name="intid_barang_free" id="intid_barang_free" size="50" /><div id="result2"></div>
        </td>
      </tr>
      <tr>
      	<td>&nbsp;Nama Barang Free 2</td>
        <td><input type="text" name="intid_barang_free1" id="intid_barang_free1" size="50" /><div id="result3"></div>
        </td>
      </tr>
      <tr>
      	<td>&nbsp;Nama Barang Free 3</td>
        <td><input type="text" name="intid_barang_free2" id="intid_barang_free2" size="50" /><div id="result4"></div>
        </td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;
			<input class="button" type="button" value="Cancel" onclick="location.href='promosi2';"/>
			
			</td>
        </tr>
 </table>

</form>
</div>
	</div>

		</div>
	<?php $this->load->view('admin_views/sidebar_master'); ?>
    <div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	