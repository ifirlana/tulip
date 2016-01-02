<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Surat Jalan</h2>
          
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    
    <thead>
        <tr  align="center"  class="table">
           	<th width="8%">No</th>
            <th width="19%">Cabang</th>
            <th width="17%">Week </th>
            <th width="11%">No SJ</th>
			<th width="26%">Tanggal</th>
            <th width="19%">Action</th>
			</tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($po as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php  echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intid_week; ?></td>
            <td align='center'>&nbsp;<?php echo $m->no_sj; ?></td>
            <td align='left'>&nbsp;<?php echo $m->tgl_kirim; ?></td>
            <td align='center'>&nbsp; <?php echo "<a href='".base_url()."po/view_sj/$m->intid_sj' target='_blank'>";?>View<?php echo "</a>";?></td>
            </tr>
		<?php endforeach; ?> 
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
			
	  </div>
		<!-- end #content -->
       	<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->