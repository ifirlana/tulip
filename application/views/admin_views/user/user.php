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
 <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('user/add', 'Tambah User')."</td>";/* else echo ""*/;?>
<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <?php //echo anchor ('admin/user/add', 'Add'); ?>
    <thead>
        <tr  align="center"  class="table">
           <th >No</th>
            <th >Username</th>
            <th >Nama User </th>
            <th >Cabang</th>
            <th >Privilege</th>
			<th >Aksi</th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($user as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m->strnama_user; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_asli ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strname_privilege; ?></td>
            <td align="center" width="190px"><?php echo anchor ('user/edit/'.$m->intid_user, 'Edit'); ?>| <?php echo anchor ('user/delete/'.$m->intid_user, 'Hapus'); ?></td>
        </tr>
		<?php endforeach; ?> 
	
    </tbody>
</table><table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php echo $pagination; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
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

