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
        <td>&nbsp;Harga Jawa</td>
        <td><input type="text" name="harga_jawa" value="<?php echo $intharga_jawa?>" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;Harga Luar jawa</td>
        <td><input type="text" name="harga_luar_jawa" size="10" value="<?php echo $intharga_luarjawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;PV Jawa</td>
        <td><input type="text" name="pv_jawa" size="5" value="<?php echo $intpv_jawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;PV Luar Jawa</td>
        <td><input type="text" name="pv_luar_jawa" value="<?php echo $intpv_luarjawa?>" size="5" /></td>
      </tr>      <tr><td>&nbsp;&nbsp;</td></tr>

       <tr>
        <td colspan="2" align="justify" class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>:: Untuk Arisan ::</u></td>
      </tr>
      <tr><td>&nbsp;&nbsp;</td></tr>
       <tr>
        <td>&nbsp;Uang Muka Jawa</td>
        <td><input type="text" name="um_jawa" size="10" value="<?php echo $intum_jawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Uang Muka Luar Jawa</td>
        <td><input type="text" name="um_luar_jawa" size="10" value="<?php echo $intum_luarjawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Jawa</td>
        <td><input type="text" name="cicilan_jawa" size="10" value="<?php echo $intcicilan_jawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Luar Jawa</td>
        <td><input type="text" name="cicilan_luar_jawa" size="10" value="<?php echo $intcicilan_luarjawa?>" /></td>
      </tr>

      <tr>
            <th></th>
            <td><input type="submit" value="Edit" class="button"/>&nbsp;<input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>barang';"/></td>
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


