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
    <form action="" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2">Edit Data Wilayah</td>
      </tr>
      <tr>
        <td>&nbsp;Nama Wilayah</td>
        <td><input type="text" name="strwilayah" size="50" value="<?php echo $strwilayah?>"/></td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Edit" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>wilayah';"/></td>
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
	<!-- end #footer -->


