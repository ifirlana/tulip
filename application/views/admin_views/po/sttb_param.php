<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
<div id="page">
<div id="page-bgtop">
<div id="content">
<div class="post">
<h2 class="title">STTB</h2>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sttbAdd', 'Buat STTB')."</td>";?>
</tr>
</table>	
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sttbdata', 'Data STTB')."</td>";?>
</tr>
</table>

		  </div>
			</div>
			
		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

