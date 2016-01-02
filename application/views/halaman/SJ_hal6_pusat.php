<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
	$(document).ready( function() {
    		$("#intid_cabang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupCabang",
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
            		$("#result").html(
            			"<input type='hidden' id='id_cabang' name='id_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
                console.log("hidden"+$("#id_cabang").val());
         		},		
    		});
	    });
</script>

</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Surat Jalan Dari Pusat</h2>
                         <div id="alert"></div>
                       <form action="<?php if(!isset($url)){echo base_url()."POCO/sjbuat/";}else{echo $url;}?>" method="post" name="frmjual" id="frmjual">
                          <table width="90%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>

                             <tr>
                                <td>&nbsp;Cabang </td>
                                <td><input type="text" name="intid_cabang" id="intid_cabang"/></td>
                                <td>&nbsp;<div id="result"></div></td>
                            </tr>
                              <tr>
                              	<td><input name="" type="submit" value="Buat Surat Jalan"/></td>
                              </tr>
                              </table>
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

