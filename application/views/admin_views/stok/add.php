<title>Twin Tulipware</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');?></head>
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
		        		url: "<?php echo base_url(); ?>stok/lookupBarang",
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
    <form action="<?php echo base_url()?>stok/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2" class="title">Tambah Data  </td>
      </tr>
      <tr>
        <td>&nbsp;Barang</td>
        <td><input type="text" name="intid_barang" id="intid_barang" size="30" /></td>
      </tr>
      
      <tr>
        <td>&nbsp;Supplier</td>
        <td><input type="text" name="supplier" size="30" /></td>
      </tr>
    
      <tr>
        <td>&nbsp;Jumlah Barang</td>
        <td><input type="text" name="intqty" size="30" /></td>
      </tr>  <tr>
        <td>&nbsp;Tanggal</td>
       <td><input type="text" name="tanggal" id="demo2" maxlength="25" size="25" class="text_box" />
          <a href="javascript:NewCssCal('demo2','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='stok';"/>
            			</td>
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
	<!-- end #footer -->


