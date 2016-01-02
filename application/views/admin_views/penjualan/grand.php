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
                <div>	<h2 class="title">Grand Demo</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/grand">
            <?php echo form_label('password','for="grandpass"'); ?><br />
            <?php echo form_input('grandpass',set_value('grandpass'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
            <div >   <h2 class="title">Promo 45% Fine Dining Set</h2>
                <div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/p45finedining">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
            </div>
			<div >   <h2 class="title">Promo Red White</h2>
                <div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/predwhite">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
            </div>
			<div >   <h2 class="title">Promo Avenger</h2>
                <div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/pavenger">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
            </div>
            <div >	<h2 class="title">Promo Tulip Charity</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/povalsuprase">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Promo Think Green</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/pthink">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			  <div>	<h2 class="title">Paket Combo</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/combo">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('combopass',set_value('combopass'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			 <div>	<h2 class="title">Paket Combo Training</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/combotraining">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('combopass',set_value('combopass'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			 <div >	<h2 class="title">Promo Diskon 40%</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/diskon40">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Promo Big SURPRISE</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/bigsuprase">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Promo Waffle Pan Special SURPRISE</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/wafflesuprase">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div style="display:none">	<h2 class="title">Promo Diskon 40% No Komisi</h2>
				<div id="grandentry" >
            <form method="post" action="<?php echo base_url();?>penjualan/diskon40nokomisi">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			
			<div style="display:none;">	<h2 class="title">Promo Diskon 50%</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/diskon50">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div> 
			<div >	<h2 class="title">Grand Promo</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/diskonpromo4020">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Be To Be</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/betobe">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Net Voucher</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/netvoucher">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<div >	<h2 class="title">Promo Diskon 20 Komisi 15</h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/nota20k15">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php echo $error_message;?>
             </div>
			</div>
			<?php if( strtoupper($this->session->userdata('username')) == "BINTULU" || strtoupper($this->session->userdata('username')) == "ADMIN"){  ?>
			<div >	<h2 class="title">Promo Bintulu </h2>
				<div id="grandentry" style="display:block">
            <form method="post" action="<?php echo base_url();?>penjualan/diskonpromo60netto">
            <?php echo form_label('password','for="combopass"'); ?><br />
            <?php echo form_input('diskon',set_value('diskon'));?>
            <?php echo form_submit('submit_login','Login'); ?>
            </form>
               <?php  echo $error_message;?>
             </div>
			</div>
			
			
			
			<?php } ?>
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

