
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
        <h2 class="title"> barang </h2>
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('barang/addhadiah', 'Tambah data')."</td>";?>
</tr>
</table>

    <form method="post" action="<?php echo base_url(); ?>barang/baranghadiah">
	<table width="590" cellpadding="5" align="center">
<tr>
  <td width="190">Masukkan Nama Barang </td><td><input type="text" name="nama" size="50" autocomplete="off" /></td></tr>
	
	</table>
	</form>
    <?php $banyak = count($nama_barang->result_array()); ?>
	   <tr><td>Ditemukan <b><?php echo $banyak?></b> hasil pencarian dengan kata <b><?php echo $nama?> </b></td></tr>
          <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr   class="table" align="center" >
           <th >No</th>
            <th >Nama Barang </th>
            <th>Jenis Barang</th>
            <th>Satuan</th>
			<th >Aksi</th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
		$i=1;	
		if(count($nama_barang->result_array())>0)
	    {
	        foreach($nama_barang->result_array() as $nd)
	        {
		
			
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $nd['strnama'];  ?></td>
            <td align="center">&nbsp;<?php echo $nd['strnama_jbarang']; ?></td>
            
            <td align="right">&nbsp;<?php echo $nd['strnama_jsatuan'];?></td>
            <td align="center" width="190px"><?php echo anchor ('barang/edithadiah/'.$nd['intid_barang_hadiah'], 'Edit'); ?>| <?php echo anchor ('barang/deletehadiah/'.$nd['intid_barang_hadiah'], 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php 
		}
	    }
	    else
	    {
	        echo '<tr><td>Tidak ditemukan barang dengan nama <b>"'.$nama.'"</b></td></tr>';
	    }
		 ?> 
	
    </tbody>
</table>
<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php echo $paginator; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
		<div id="pager1"></div>  <!--pagination div-->
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

