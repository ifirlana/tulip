
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
          <h2 class="title">data cabang</h2>
				
				<div class="entry">
    
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
		<tr align="center">
        
        </tr>
        
      <tr>
        <td>&nbsp;Kode Cabang</td>
        <td><input disabled="disabled" name="intkode_cabang" size="30" value="<?php echo $intkode_cabang?>"/>        </td>
      </tr>
      <tr>
        <td>&nbsp;Wilayah</td>
        <td><input disabled="disabled"type="text" name="strwilayah" size="50" value="<?php echo $strwilayah?>"/></td>
      </tr>
       <tr>
        <td>&nbsp;Jenis</td>
        <td><input disabled="disabled"type="text" name="jenis_cabang" size="50" value="<?php echo $jenis_cabang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Nama Cabang</td>
        <td><input disabled="disabled" type="text" name="strnama_cabang" size="50" value="<?php echo $strnama_cabang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp; Kepala Cabang</td>
        <td><input type="text" disabled="disabled" name="strkepala_cabang" size="50" value="<?php echo $strkepala_cabang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Adm Cabang</td>
        <td><input disabled="disabled" type="text" name="stradm_cabang" size="50" value="<?php echo $stradm_cabang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Alamat</td>
        <td><input disabled="disabled" type="text" name="stralamat" size="50" value="<?php echo $stralamat?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Telepon</td>
        <td><input type="text" disabled="disabled" name="strtelepon" size="50" value="<?php echo $strtelepon?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Keterangan</td>
        <td><input type="text" disabled="disabled" name="strket" size="50" value="<?php echo $strket?>"/></td>
      </tr>
      </table>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>

		  <td align="left" width="60%">&nbsp;<a href="<?php echo base_url()?>cabang"  title="Kembali ke  Cabang" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
</table>
       
		  </div>
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

