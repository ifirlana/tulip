<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
            <script language="javascript">
    
     $(this).ready( function() {
    		$("#intid_barang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>tboom/lookupBarang",
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
	
    </script>
</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
    <form action="" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2" class="title">Edit Data  </td>
      </tr>
     
      <tr>
        <td>&nbsp;Wilayah</td>
        <td><select name="intid_wilayah">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($nama);$i++)
				{
					if($intid_wilayah==$id[$i]){ $style="selected"; }else{ $style=""; }
					echo "<option value='$id[$i]' $style>$nama[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;Barang</td>
        <td><input type="text" name="intid_barang"  id="intid_barang" size="50" value="<?php echo $intid_barang; ?>" /><div id="result"></div></td>
      </tr>
       <tr>
        <td>&nbsp;Total</td>
        <td><input type="text" name="inttotal" size="10" value="<?php echo $inttotal;?>"/></td>
      </tr>
        <tr>
        <td>&nbsp;Start Week</td>
        <td><select name="intid_week_start">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($idw);$i++)
				{
					if($intid_week_start==$idw[$i]){ $style="selected"; }else{ $style=""; }
					echo "<option value='$idw[$i]' $style>$idw[$i]</option>";
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
					if($intid_week_end==$ide[$i]){ $style="selected"; }else{ $style=""; }
					echo "<option value='$ide[$i]' $style>$ide[$i]</option>";
				}
			?>
        </select></td>
      </tr>
     
      <tr>
            <th></th>
            <td><input type="submit" value="Edit" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>tboom';"/></td>
      </tr>
 </table>

</form>
</div>

		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_master'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
