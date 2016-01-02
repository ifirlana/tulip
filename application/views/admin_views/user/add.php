<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
<script type="application/javascript">
$(document).ready(function(){
	$(".so_no").hide();
}); 

function get_so()
	{
		if($('#intid_privilege').val() == 5)
		{
			$(".so_no").show();
		} else {
			$(".so_no").hide();
		}
	}

</script>
</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
    <form action="<?php echo base_url()?>user/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%" id="myTABLE">
      <tr align="center">
        <td colspan="2" class="title">Tambah Data User </td>
      </tr>
      <tr>
        <td>&nbsp;Username </td>
        <td><input type="text" name="strnama_user" size="30" /></td>
      </tr>
      <tr>
        <td>&nbsp;Password </td>
        <td><input type="password" name="strpass_user" size="30"/></td>
      </tr>
      <tr>
        <td>&nbsp;Nama</td>
        <td><input type="text" name="strnama_asli" size="50"/></td>
      </tr>
      <tr>
        <td>&nbsp;Privilege</td>
        <td><select name="intid_privilege" id="intid_privilege" onchange="get_so()">
            <option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($privilege);$i++)
				{
					echo "<option value='$idpri[$i]'>$privilege[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;Cabang</td>
        <td><select name="intid_cabang">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang2</td>
        <td><select name="intid_cabang2">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang3</td>
        <td><select name="intid_cabang3">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang4</td>
        <td><select name="intid_cabang4">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang5</td>
        <td><select name="intid_cabang5">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang6</td>
        <td><select name="intid_cabang6">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang7</td>
        <td><select name="intid_cabang7">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang8</td>
        <td><select name="intid_cabang8">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang9</td>
        <td><select name="intid_cabang9">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr class="so_no">
        <td>&nbsp;Cabang10</td>
        <td><select name="intid_cabang10">
			<option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($nama);$i++)
				{
					echo "<option value='$id[$i]'>$nama[$i]</option>";
				}
			?>
			</select></td>
      </tr>
      <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>user';"/></td>
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


