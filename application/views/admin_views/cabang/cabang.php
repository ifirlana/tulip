
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
				<h2 class="title">Cabang </h2>
				       
				
		</script>

	<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('cabang/add', 'Tambah data')."</td>";/* else echo ""*/;?>
<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
			<form method="post" action="<?php echo base_url(); ?>cabang/index">
	<table width="590" cellpadding="5" align="center">
<tr>
  <td width="221">Masukkan Nama Cabang</td>
  <td width="341"><input type="text" name="nama" size="50" autocomplete="off" /></td></tr>
	
	</table>
	</form><?php
    $banyak = count($nama_cabang->result_array()); ?>
	   <tr><td>Ditemukan <b><?php echo $banyak?></b> hasil pencarian dengan kata <b><?php echo $nama?> </b></td></tr>
            	<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr   class="table" align="center" >
           <th >No</th>
            <th ><span class="style2">Wilayah</span></th>
            <th ><span class="style2">Cabang</span></th>
             <th ><span class="style2">Kep.Cabang</span></th>
            
			<th ><span class="style2">Aksi</span></th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
				$i=1;	//foreach($cabang as $m) : 
		if(count($nama_cabang->result_array())>0)
	    {
	        foreach($nama_cabang->result_array() as $m)
	        {
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m['strwilayah']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['strnama_cabang']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['strkepala_cabang']; ?></td>
            
            <td align="center" width="190px">
			<a href="<?php echo base_url()?>cabang/detail/<?php echo $m['intid_cabang']?>" title="Detail data"><img  src="<?php echo base_url()?>images/view.png" align="absmiddle"/> Detail</a>
			<?php echo anchor ('cabang/edit/'.$m['intid_cabang'], 'Edit'); ?>| <?php echo anchor ('cabang/delete/'.$m['intid_cabang'], 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php //endforeach; 
		}
		}
	    else
	    {
	        echo '<tr><td>Tidak ditemukan Cabang dengan nama <b>"'.$nama.'"</b></td></tr>';
	    }?> 
    </tbody>
</table>
		<div id="pager1"></div>  <!--pagination div-->
			<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
    <td align="left" ><?php echo $pagination; ?></td>
		  <td align="right" width="60%">&nbsp;<a href="<?php echo base_url()?>wilayah"  title="Kembali ke menu Wilayah" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
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

