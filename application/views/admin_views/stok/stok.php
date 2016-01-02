<title>Twin Tulipware</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');?>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />  </head>

<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
          <h2 class="title">Stock</h2>
				        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) *//*echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('stok/add', 'Tambah Data')."</td>";/* else echo ""*/;?>
<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
           <th >No</th>
            <th >Barang</th>
            <th >Supplier</th>
            <th >Jumlah</th>
            <th >Tanggal</th>
			<th >Aksi</th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($stok as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intqty_end; ?></td>
            <td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
            <td align="center" width="190px"><?php  echo anchor ('stok/detail/'.$m->intid_stok, 'Detail'); ?>| <? //echo anchor ('stok/edit/'.$m->intid_stok, 'Edit'); ?>| <?php //echo anchor ('stok/delete/'.$m->intid_stok, 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php endforeach; ?> 
    </tbody>
</table>
          <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
 <td align="left" ><?php echo $pagination; ?></td>
		  <td align="right" width="60%">&nbsp;<a href="<?php echo base_url()?>barang"  title="Kembali ke menu Event" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
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

