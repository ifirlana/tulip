<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />  </head>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Twin Tulipware</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');?>

<body>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?>
	<hr />
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">Welcome to Twin Tulipware </a></h2>
					<p><h2>HARAP DIBACA DULU !!</h2></p>
					<?php $this->load->view("admin_views/kajedugbenjol/kajedugbenjol_efan");?>
					<p><h2>Notifikasi</h2></p>
					<p><?php $this->load->view("admin_views/komplain/show_komplain",$komplain);?></p>
					
					<p><?php 
						if($status == true):
					$this->load->view("admin_views/canibal/canibal_show",$canibal);
					endif;
					?></p>
					<?php $this->load->view("admin_views/po/notifikasi_po",$po);?>
					<?php $this->load->view("admin_views/retur/notifikasi_retur",$retur);?>
					
					<?php //$this->load->view("admin_views/sparepart/notifikasi_sparepart",$sparepart);?>
			</div>
		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar'); ?>
	  <div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?>
	</div>
	<!-- end #footer -->
</div></div>
</body>
</html>
