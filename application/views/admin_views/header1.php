<div id="logo">
		<h1>&nbsp;</h1>
		</div>
	<hr />
	<!-- end #logo -->
	<script type="text/javascript" >
			
				window.base_url ="<?php echo base_url(); ?>";
			</script>
	<div id="header">
    	<link rel="stylesheet" href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.8.13.custom.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/jquery-ui.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
		<script src="<?php echo base_url()?>assets/jquery.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>assets/mylogi.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jQuery/ui/jquery-ui-1.8rc3.custom.js"></script>
        <script src="<?php echo base_url()?>assets/javascript/jQuery/form/jquery.form.js" type='text/javascript'></script>
        	
        <style>
        .ui-dialog-titlebar-close{
            display: none;
        }
        </style>
	    <meta charset="UTF-8">
		<div id="menu">
			<ul>
				<li><?php echo anchor('site/home', 'Home'); ?></li>
           		<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('dealer','Master');?></li><?php } ?>
				<?php
					$username = $this->session->userdata('username');
					$is_nota = $this->session->userdata('is_nota');
				if($is_nota == 1){
						if (($this->session->userdata('privilege')== 1)||($this->session->userdata('privilege')== 2)||($this->session->userdata('privilege')== 4)){?> 
						<li>
						<?php echo anchor('penjualan','Nota');?>
						</li>
						<?php } 
					}
					?>
                <li><?php echo anchor('laporan','Laporan');?></li>
				<li><?php echo anchor('po','Gudang') ?></li>
			   <?php	echo "<li>".anchor('gathering','Gathering')."</li>";  ?>
				<li><?php echo anchor('calon_manager','Manager');?></li>
				<li><?php echo anchor('login/logout','Logout');?>
                
</li>
				
		  </ul>
		</div>
        <ul align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selamat Datang, <?php echo $this->session->userdata('username'); ?></ul>				
		<!-- end #menu -->
		<!--<div id="search">
			<form method="get" action="">
				<fieldset>
				<input type="text" name="s" id="search-text" size="15" />
				<input type="submit" id="search-submit" value="GO" />
				</fieldset>
			</form>
		</div>-->
        
		<!-- end #search -->
	</div>
