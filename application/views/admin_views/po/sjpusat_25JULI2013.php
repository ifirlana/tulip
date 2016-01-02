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
<h2 class="title">Surat Jalan</h2>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/SJ_INSERT', 'Surat Jalan PO')."</td>";?>
</tr>
</table>
<!--<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php //echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjr', 'Surat Jalan Pengganti Retur')."</td>";?>
</tr>
</table>-->
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjAdd_RSP', 'Surat Jalan Retur Barang')."</td>";?>
</tr>
</table>	
<? /*
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php// echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjbiasa', 'Surat Jalan')."</td>";?>
</tr>
</table>	
*/ ?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjdata', 'Data Surat Jalan')."</td>";?>
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

