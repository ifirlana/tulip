<title>Twin Tulipware</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');?>
<link rel="shortcut icon" href="../../images/favicon.ico" type="image/x-icon" />  </head>

<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
          <h2 class="title">Detail Stock</h2>
<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
		<tr align="center">        </tr>
        
      <tr>
        <td>&nbsp;Nama Barang</td>
        <td><input disabled="disabled" name="strnama" size="50" value="<?php echo $strnama?>"/>        </td>
      </tr>
      <tr>
        <td>&nbsp;Satuan</td>
        <td><input disabled="disabled"type="text" name="intnama_jsatuan" size="10"  value="<?php echo $strnama_jsatuan ?>")/>
        </td>
     
      </tr>
      <tr>
        <td>&nbsp;Cabang</td>
        <td><input disabled="disabled" type="text" name="intpv_jawa" size="5" value="<?php echo $strnama_cabang?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Qty Awal</td>
        <td><input type="text" disabled="disabled" name="intqty_begin" size="10" value="<?php echo $intqty_begin?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Qty Msk</td>
        <td><input disabled="disabled" type="text" name="intqty_in" size="5" value="<?php echo $intqty_in?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Qty Keluar</td>
        <td><input type="text" disabled="disabled" name="intqty_out" size="10" value="<?php echo $intqty_out?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Qty Akhir</td>
        <td><input disabled="disabled" type="text" name="intqty_end" size="5" value="<?php echo $intqty_end?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;Tanggal </td>
        <td><input disabled="disabled" type="text" name="tanggal" size="10" value="<?php echo $tanggal?>"/> 
        &nbsp;</td>
      </tr>      <tr><td>&nbsp;&nbsp;</td></tr>

      </table>
		                <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
 <td align="left" ><?php //echo $pagination; ?></td>
		  <td align="right" width="60%">&nbsp;<a href="<?php echo base_url()?>stok"  title="Kembali ke menu Event" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
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

