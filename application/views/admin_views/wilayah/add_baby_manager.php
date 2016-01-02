<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
      <script language="javascript">
    
     $(this).ready( function() {
    		$("#intid_unit").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>baby_managerunit/lookupUnit",
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
            			"<input type='hidden' id='intid_unit' name='intid_unit' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
	//cab2
	$(this).ready( function() {
    		$("#intid_unitbaby").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>baby_managerunit/lookupUnit2",
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
            		$("#result1").append(
            			"<input type='hidden' id='intid_unitbaby' name='intid_unitbaby' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
    </script></div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
    <form action="<?php echo base_url()?>baby_managerunit/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2" class="title">Tambah Data  </td>
      </tr>
       <tr>
        <td width="33%">&nbsp;Nama Baby Unit Manager</td>
        <td width="67%">&nbsp;
          <input type="text" name="intid_unit" id="intid_unit" size="30" /><div id="result"></div></td>
       </tr>
      <tr>
        <td>&nbsp;Dari Unit</td>
        <td>&nbsp;
         <input type="text" name="intid_unitbaby" id="intid_unitbaby" size="30" /><div id="result1"></div></td>
        </tr>

      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>baby_managerunit';"/></td>
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
