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
        <div class="post">  <h2 class="title"> Promosi 20% </h2>
 <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('promosi/add2', 'Tambah Promosi')."</td>";?>
</tr>
</table>


<form method="post" action="<?php echo base_url(); ?>promosi/promosi2">
	<table width="590" cellpadding="5" align="center">
<tr>
  <td width="172">Masukkan Nama Barang</td>
  <td width="390"><input type="text" name="nama" size="50" autocomplete="off" /></td></tr>
	
	</table>
	</form>
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    
    <thead>
        <tr  align="center"  class="table">
           <th width="43">No</th>
            <th width="100">Week Start</th>
            <th width="100">Week End</th>
            <th width="278">Nama Barang</th>
			<th width="265">Free Barang</th>
			<th>Aksi</th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			//foreach($promo as $m) : 
			if(count($nama_promo20->result_array())>0)
		    {
	        foreach($nama_promo20->result_array() as $nd)
	        {
		?>
        
      	<tr class='data' align='center'>
            <td ><?php echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo "Week ".$nd['intid_week_start']; ?></td>
            <td align='left'>&nbsp;<?php echo "Week ".$nd['intid_week_end']; ?></td>
            <td align='left'>&nbsp;<?php echo $nd['strnama']; ?></td>
            <td align='left'>&nbsp;<?php echo $nd['nama']; ?></td>
            <td align="center" width="116"><?php echo anchor ('promosi/edit2/'.$nd['intid_promo'], 'Edit'); ?>| <?php echo anchor ('promosi/delete2/'.$nd['intid_promo'], 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php  }
	    }
	    else
	    {
	        echo '<tr><td>Tidak ditemukan Barang Promo 20 dengan nama <b>"'.$nama.'"</b></td></tr>';
	    }//endforeach; ?> 
    </tbody>
</table>
            <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php echo $pagination; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table><table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>

		  <td align="left" width="60%">&nbsp;<a href="<?php echo base_url()?>Barang"  title="Kembali ke menu Barang" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
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

