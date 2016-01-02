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
<h2 class="title">Surat Retur</h2>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*
<td><img  src='<?php echo base_url(); ?>images/img10.png' align='absmiddle'/> Retur Antar Cabang diambil alih oleh Branch Support</td> */ ?>
<?php 
//diambil alih oleh branch support
echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/STTB_INSERT', 'Retur Barang Antar Cabang Khusus')."</td>";?>
</tr>
</table>
<!--
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php ?>//echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjr', 'Surat Jalan Pengganti Retur')."</td>";?>
</tr>
</table>-->
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sreturpusat_rejec', 'Retur Sparepart / Garansi')."</td>";?>
</tr>
</table>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/surat_retur', 'Data Tanda Terima Sparepart')."</td>";?>
</tr>
</table>
<?php /*
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/barang_servicePusat', 'Retur Barang Service')."</td>";?>
</tr>
</table>
*/?>
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

