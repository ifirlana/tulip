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
    <form action="<?php echo base_url()?>week/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td  class="title "colspan="2">Tambah Data Week</td>
        </tr>
          <tr>
        <td>&nbsp;Minggu ke-</td>
        <td><input type="text" name="week" size="5" /></td>
      </tr>
      <tr>
          <td>&nbsp;Untuk Bulan</td>
          <td><?php echo $nama_bulan?></td>
      </tr>
      <tr>
        <td>&nbsp;Start Week</td>
        <td><input type="text" name="dateweek_start" id="demo3" maxlength="25" size="25" class="text_box" />
          <a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
      </tr>
      <tr>
        <td>&nbsp;End Week</td>
        <td><input type="text" name="dateweek_end" id="demo2" maxlength="25" size="25" class="text_box" />
          <a href="javascript:NewCssCal('demo2','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='week';"/></td>
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


