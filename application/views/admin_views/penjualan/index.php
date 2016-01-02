<!DOCTYPE html>
<html>
<head>
	<title>Twin tulipware</title>
<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<body>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
<div id="page">
        <div id="page-bgtop">
            <div id="content">
			<div class="post">	<h2 class="title">penjualan </h2>
				<div class="entry">      
                   <div class="mainpenjualan">
				
			  </div>
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
	<!-- end #footer -->
</body>
</html>