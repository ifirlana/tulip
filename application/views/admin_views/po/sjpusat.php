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
<?php 
	//
	//custom code untuk cabang merchandise
	//-------------------------------------------//
	
	if(isset($id_cabang) and $id_cabang == 102){
	?>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center"  style="background:white;">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/sjbiasa_merchandise', 'PO Dari Merchandise')."</td>";?>
</tr>
</table>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center" style="background:white;">
	<tr>
	<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjdata_merchandise', 'Data Surat Jalan Marchandise')."</td>";?>
	</tr>
</table> 
		
	<?php
	}
	else{
	?>	

<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/SJ_INSERT', 'Surat Jalan PO')."</td>";?>
</tr>
</table>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('komplain/', 'Surat Jalan Komplain')."</td>";?>
</tr>
</table>
<!--<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php //echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjr', 'Surat Jalan Pengganti Retur')."</td>";?>
</tr>
</table>-->
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/SJ2_INSERT', 'Surat Jalan Retur Barang Antar Cabang')."</td>";?>
</tr>
</table>	
<table width="95%" border="0" cellpadding="5" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/sjbiasa', ' PO Dari Pusat')."</td>";?>
</tr>
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjcopybiasa', ' Copy PO')."</td>";?>
</tr>
</table>	
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('POCO/SJ3_INSERT', 'Surat Jalan Retur Sparepart')."</td>";?>
</tr>
</table>

<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center" style="background:white;">
	<tr>
	<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjdata', 'Data Surat Jalan')."</td>";?>
	</tr>
</table>

<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center" style="background:white;">
	<tr>
	<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('retur/LaporanTandaTerimaKonsumen', 'Data Terima Barang Konsumen')."</td>";?>
	</tr>
</table>

<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center" style="background:white;">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/laporan_barang_komplain', 'Data Barang Komplain')."</td>";?>
</tr>
</table>

<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center" style="background:white;">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/sjdata_komplain', 'Data Surat Jalan Komplain')."</td>";?>
</tr>
</table>

<?php }?>

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

