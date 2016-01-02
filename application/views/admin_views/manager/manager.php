<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Twin Tulipware</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<body>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
	<!-- end #logo -->
	
		<!-- end #menu -->
		<!-- end #search -->
	</div>
	<!-- end #header -->
	<!-- end #header-wrapper -->
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
			<div class="post">
				<h2 class="title">manager </h2>
				<form method="post" action="<?php echo base_url(); ?>manager/index">
	<table width="590" cellpadding="5" align="center">
<tr>
  <td width="164">Masukkan Nama Manager</td>
  <td width="398"><input type="text" name="nama" size="50" autocomplete="off" /></td></tr>
	
	</table>
	</form><?php
    $banyak = count($nama_manager->result_array()); ?>
	   <tr><td>Ditemukan <b><?php echo $banyak?></b> hasil pencarian dengan kata <b><?php echo $nama?> </b></td></tr>
		        <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
           <th >No</th>
           <th >Kode</th>
            <th >Nama</th>
            <th >Upline</th>
            <th >Parent</th>
            <th >Unit</th>

        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			//foreach($dealer as $m) : 
			if(count($nama_manager->result_array())>0)
	    {
	        foreach($nama_manager->result_array() as $m)
	        {
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='left'>&nbsp;<?php echo $m['strkode_dealer']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['strnama_dealer']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['strnama_upline']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['intparent_leveldealer']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['strnama_unit']; ?></td>
          
        </tr>
		<?php //endforeach;
		}
		}
	    else
	    {
	        echo '<tr><td>Tidak ditemukan Manager dengan nama <b>"'.$nama.'"</b></td></tr>';
	    } ?> 
    </tbody>
</table>
		  <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
 <td align="left" ><?php echo $pagination; ?></td>
		  </tr>
</table></div>
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

</body>
</html>
