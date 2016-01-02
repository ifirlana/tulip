
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
          <h2 class="title">data barang</h2>
				<div class="entry">
    
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
		<tr align="center">        </tr>
        
      <tr>
        <td>&nbsp;Nama Barang</td>
        <td><input disabled="disabled" name="strnama" size="50" value="<?php echo $strnama?>"/>        </td>
      </tr>
      <tr>
        <td>&nbsp;Harga P.Jawa</td>
        <td><input disabled="disabled"type="text" name="intharga_jawa" size="10" value="<?=number_format($intharga_jawa,2,",",".");?>"/>
        </td>
     
      </tr>
      <tr>
        <td>&nbsp;PV P.Jawa</td>
        <td><input disabled="disabled" type="text" name="intpv_jawa" size="5" value="<?php echo $intpv_jawa?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Harga Luar Jawa</td>
        <td><input type="text" disabled="disabled" name="intharga_luarjawa" size="10" value="<?=number_format($intharga_luarjawa,2,",",".")?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;PV Luar Jawa</td>
        <td><input disabled="disabled" type="text" name="intpv_luarjawa" size="5" value="<?php echo $intpv_luarjawa?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Barang</td>
        <td><input type="text" disabled="disabled" name="strnama_jbarang" size="10" value="<?php echo $strnama_jbarang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Satuan</td>
        <td><input disabled="disabled" type="text" name="strnama_jsatuan" size="5" value="<?php echo $strnama_jsatuan?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Quantity</td>
        <td><input disabled="disabled" type="text" name="qty" size="3" value="<?php echo $qty?>"/> &nbsp;Buah</td>
      </tr>      <tr><td>&nbsp;&nbsp;</td></tr>

      <tr>
        <td colspan="2" align="justify" class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>:: Untuk Arisan ::</u></td>
      </tr>
      
      <tr><td>&nbsp;</td></tr>
       <tr>
        <td>&nbsp;Uang Muka Jawa</td>
        <td><input  disabled="disabled" type="text" name="um_jawa" size="10" value="<?php echo $intum_jawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Uang Muka Luar Jawa</td>
        <td><input  disabled="disabled" type="text" name="um_luar_jawa" size="10" value="<?php echo $intum_luarjawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Jawa</td>
        <td><input disabled="disabled" type="text" name="cicilan_jawa" size="10" value="<?php echo $intcicilan_jawa?>" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Luar Jawa</td>
        <td><input  disabled="disabled" type="text" name="cicilan_luar_jawa" size="10" value="<?php echo $intcicilan_luarjawa?>" /></td>
      </tr>
      </table>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>

		  <td align="left" width="60%">&nbsp;<a href="<?php echo base_url()?>barang"  title="Kembali ke  Barang" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
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

