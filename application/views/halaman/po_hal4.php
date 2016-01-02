    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	                     
  <?php 
  	if(isset($tampilkan)){
		echo $tampilkan;
	}else{
		echo "tidak ada yang ditampilkan";
		}?>
  <!-- //// -->
                     </div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
