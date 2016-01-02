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
        <div class="post">  <h2 class="title"> Surat Jalan Cabang &nbsp;<?php //echo $cabang; ?>
                                        <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php //echo $id_cabang; ?>"></h2>
            <form action="<?php echo $form_action?>" method="post">
                        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
                            <tr>
                             
                                <td style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?>Filter Bulan : </b><?php echo $combo_bulan?>
                                    <input type="submit" name="submit" value="Cari"> </td></tr>
                            <tr><td></td> </tr>
                        </table>
                            </form>
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    
    <thead>
        <tr  align="center"  class="table">
           <th>No</th>
            <th>Cabang</th>
            <th>Date </th>
            <th>Nama Barang</th>
			<th>Jumlah</th>
			</tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($po as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intquantity; ?></td>
            </tr>
		<?php endforeach; ?> 
    </tbody>
</table>
          <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php //echo $pagination; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
		  </div>
	  </div>
			
	  </div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_po'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

