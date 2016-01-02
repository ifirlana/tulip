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
				<h2 class="title">Unit </h2>
				
				<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('unit/add', 'Tambah data')."</td>";/* else echo ""*/;?>
<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
<form method="post" action="<?php echo base_url(); ?>unit/index">
	<table width="590" cellpadding="5" align="center">
<tr>
  <td width="164">Masukkan Nama Unit</td>
  <td width="398"><input type="text" name="nama" size="50" autocomplete="off" /></td></tr>
	
	</table>
	</form><?php
    $banyak = count($nama_unit->result_array()); ?>
	   <tr><td>Ditemukan <b><?php echo $banyak?></b> hasil pencarian dengan kata <b><?php echo $nama?> </b></td></tr>
<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr   class="table" align="center" >
           <th >No</th>
            <th >Nama Unit</th>
			<th >Aksi</th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			//foreach($unit as $m) : 
			if(count($nama_unit->result_array())>0)
	    {
	        foreach($nama_unit->result_array() as $m)
	        {
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m['strnama_unit']; ?></td>
            <td align="center" width="190px"><?php echo anchor ('unit/edit/'.$m['intid_unit'], 'Edit'); ?>| <?php echo anchor ('unit/delete/'.$m['intid_unit'], 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php //endforeach; 
		}
		}
	    else
	    {
	        echo '<tr><td>Tidak ditemukan Unit dengan nama <b>"'.$nama.'"</b></td></tr>';
	    }
		?> 
	
    </tbody>
</table>
<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php echo $pagination; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
		

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

