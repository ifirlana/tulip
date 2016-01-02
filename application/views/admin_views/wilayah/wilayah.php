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
				<h2 class="title">Wilayah </h2>
				
				<div class="entry">
                 <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img11.png' align='absmiddle'/>".anchor('cabang', 'Cabang')."</td>";/* else echo ""*/;?>

<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img11.png' align='absmiddle'/>".anchor('baby_cabang', 'Baby Cabang')."</td>";/* else echo ""*/;?>

<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
                <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('Wilayah/add', 'Tambah data')."</td>";/* else echo ""*/;?>

<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
						  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr   class="table" align="center" >
           <th >No</th>
            <th ><span class="style2">Nama Wilayah</span></th>
			<th ><span class="style2">Aksi</span></th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
				$i=1;	foreach($wilayah as $m) : 
	
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m->strwilayah; ?></td>
            <td align="center" width="190px"><?php echo anchor ('wilayah/edit/'.$m->intid_wilayah, 'Edit'); ?>| <?php echo anchor ('wilayah/delete/'.$m->intid_wilayah, 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php endforeach; ?> 
	
    </tbody>
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

