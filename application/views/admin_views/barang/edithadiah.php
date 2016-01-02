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
        <td colspan="2">Edit Data Barang </td>
      </tr>
       <tr>
        <td width="29%">&nbsp;Jenis Barang</td>
        <td width="71%"><select name="intid_jbarang">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($namajb);$i++)
				{
					if($intid_jbarang==$idjb[$i]){ $style="selected"; }else{ $style=""; }
					echo "<option value='$idjb[$i]' $style>$namajb[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      
      <tr>
        <td>&nbsp;Nama Barang</td>
        <td><input type="text" name="strnama" size="30" value="<?php echo $strnama?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Satuan</td>
        <td><select name="intid_jsatuan">
           <option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($namajs);$i++)
				{
					if($intid_jsatuan==$idjs[$i]){ $style="selected"; }else{ $style=""; }
					echo "<option value='$idjs[$i]' $style>$namajs[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Edit" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>barang/baranghadiah';"/></td>
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


