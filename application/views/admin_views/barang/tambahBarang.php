<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
	  
	</script>
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
        <fieldset>
		<legend><strong>FORM TAMBAH DATA BARANG</strong></legend>
       <?php
		/* <form action="<?php echo base_url()?>laporan/cetak_keumingguan" method="post">            
 		*/
		?>
		<form method="post">            
 		<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
        	
			<tr> <td width="20%">NAMA : </td> 
				 <td align=left ><input type="teks" class="txtnama" style="width:75%">	
			</tr> 
			<tr><td>&nbsp;</td></tr>
			<tr> <td>JENIS SATUAN : </td>
				  <td><select name="intid_jsatuan">
                  <option value="1">Set</option>
                  <option value="2">Pcs</option>
                </select></td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>JENIS BARANG : </td>
				 <td><select name="intid_jbarang">
            <option value="">-- Pilih --</option>
					<?php
						for($i=0;$i<count($namajb);$i++)
						{
						echo "<option value='$idjb[$i]'>$namajb[$i]</option>";
						}
					?>
                </select></td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>QTY :  </td>
				 <td align=left><input type="teks" class="txtqty" style="width:10%" value="0">
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>STATUS BARANG :  </td>
				 <td align=left> <select name="intid_status"> 
					<option value="0">Non-aktif</option>
					<option value="1">Aktif</option>
				 </td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>HADIAH :  </td>
				 <td align=left> <select name="intid_hadiah"> 
					<option value="0">Non-aktif</option>
					<option value="1">Aktif</option>
				 </td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>SPAREPART :  </td>
				 <td align=left> <select name="intid_sparepart"> 
					<option value="0">Non-aktif</option>
					<option value="1">Aktif</option>
				 </td>			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>TANGGAL AWAL :  </td>
				 <td><input type="text" name="tglawal" id="tglawal" size="10%" /><a href="javascript:NewCssCal('tglawal','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>TANGGAL AKHIR :  </td>
				 <td><input type="text" name="tglakhir" id="tglakhir" size="10%" /><a href="javascript:NewCssCal('tglakhir','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			<tr> <td>KODE :  </td>
				 <td align=left><input type="teks" class="txtkode" style="width:10%" value="0">
			</tr>
            
			<tr>
				<td>&nbsp;</td>
			</tr>
			
            <tr>
           		<th></th>
            	<td><input type="submit" value="Submit" class="button"/></td>
           </tr>
		</table>	
        </form>    
        </fieldset>
          
            
           
		  </div>
			</div>
			
		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_laporan'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

