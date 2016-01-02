<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.error_message{ padding:5px 10px 5px 10px;min-height:5px; width:80px;color:#F00; background-color:#000;display:block;}
-->
</style>

<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Mini Demo</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/mini">
            <?php echo form_label('password','for="grandpass"'); ?><br />
            <?php echo form_input('grandpass',set_value('grandpass'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
        </div>
	</div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>

