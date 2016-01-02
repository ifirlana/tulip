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
    <form action="<?php echo base_url()?>cabang/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2" class="title">Tambah Data Cabang</td>
      </tr>
      <tr>
        <td>&nbsp;Wilayah</td>
        <td><select name="intid_wilayah">
            <option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($namaw);$i++)
				{
					echo "<option value='$idw[$i]'>$namaw[$i]</option>";
				}
			?>
        </select></td>
      </tr>
       <tr>
        <td>&nbsp;Jenis </td>
         <td><input name="jenis_cabang" type="radio" value="Cabang" checked />CABANG<input name="jenis_cabang" type="radio" value="Stockist"/>STOCKIST</td>
       </tr>
      <tr>
        <td>&nbsp;Kode Cabang</td>
        <td><input type="text" name="intkode_cabang" size="30" /></td>
       </tr>
      <tr>
        <td>&nbsp;Nama Cabang</td>
        <td><input type="text" name="strnama_cabang" size="30" /></td>
      </tr>
       <tr>
        <td>&nbsp;Nama Kepala Cabang</td>
        <td><input type="text" name="strkepala_cabang" size="30" /></td>
       </tr>
       <tr>
        <td>&nbsp;Nama Admin</td>
        <td><input type="text" name="stradm_cabang" size="30" /></td>
      </tr>
       <tr>
        <td>&nbsp;Alamat</td>
        <td><textarea name="stralamat" cols="50" rows="3" class="textarea"></textarea></td>
       </tr>
       <tr>
        <td>&nbsp;No Telepon</td>
        <td><input type="text" name="strtelepon" size="30" /></td>
      </tr>
       <tr>
        <td>&nbsp;Keterangan</td>
        <td><input type="text" name="strket" size="30" /></td>
       </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>cabang';"/></td>
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


