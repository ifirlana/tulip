
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
	<script type="text/javascript">
	    $(this).ready( function() {
			$("#intid_unit").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>ranting/lookupUnit",
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
         	});
	    });
		
	    </script>
	</div>
	
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
				<h2 class="title">Ranting Unit </h2>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
            <tr>
            <td> <?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/xls_icon.gif' align='absmiddle'/>".anchor('ranting/printXls/'.$unit, 'Print Xls')."</td>";?>
            <?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/pdf_logo.gif' align='absmiddle'/>".anchor('ranting/printPdf/'.$unit, 'Print Pdf')."</td>";?>
            </td>
            </tr>
            </table>	
            <form id="form1" name="form1" method="post" action="<?php echo base_url()?>ranting/search">				
            <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                <thead>
                     <tr>
                          <td>&nbsp;Unit</td>
                          <td><input type="text" name="intid_unit" id="intid_unit" size="30" /></td>
                        </tr>
                     <tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </form>
			<?php if ($show==1) {?>
            <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                <thead>
                <tr  align="center"  class="table">
                    <th >No</th>
                    <th >Kode Dealer</th>
                    <th >Nama Dealer</th>
                    <th >Kode Upline</th>
                    <th >Nama Upline</th>
        		</tr>   
                </thead>
                <tbody>
				<?php 
                    $i=1;
                    foreach($ranting as $m) : 
                    
                ?>
                
                <tr class='tr_data' align='center'>
                    <td ><?php echo $i++; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strkode_dealer; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strkode_upline; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strnama_upline; ?></td>
        
                </tr>
                <?php endforeach; ?> 
	
                </tbody>
            </table>
			<?php }?>
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

