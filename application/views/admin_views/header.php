<div id="logo">
		<h1>&nbsp;</h1>
		</div>
	<hr />
	<div id="header">
	<?php 
			$qry = $this->db->query("select * from notice where is_active = '1' and curdate() between tgl_mulai and tgl_akhir")->result();
			
	?>
		<marquee behavior="scroll" direction="left" style="color:red;font-size:20px;padding-top:6px;">
		<?php
			$isi="";
			foreach($qry as $ros):
				$isi .= ucwords($ros->isi)." || ";
			endforeach;
			echo $isi;
//			SEMANGAT...YAH...SEMANGAT...YAH... || PROMO 1 FREE 1 HUT SUDAH DIMULAI  
		?>
		</marquee>
    </div>
	<!-- end #logo -->
	<div id="header">
    	<link rel="stylesheet" href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.8.13.custom.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/jquery-ui.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
		<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jQuery/ui/jquery-ui-1.8rc3.custom.js"></script>
        <script src="<?php echo base_url()?>assets/javascript/jQuery/form/jquery.form.js" type='text/javascript'></script>
        	
        <style>
        .ui-dialog-titlebar-close{
            display: none;
        }
		.myButton {
	-moz-box-shadow:inset 0px 39px 0px -24px #e67a73;
	-webkit-box-shadow:inset 0px 39px 0px -24px #e67a73;
	box-shadow:inset 0px 39px 0px -24px #e67a73;
	background-color:#e4685d;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #ffffff;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	padding:6px 6px;
	text-decoration:none;
	text-shadow:0px 1px 0px #b23e35;
}
.myButton:hover {
	background-color:#eb675f;
}
.myButton:active {
	position:relative;
	top:1px;
}
.notf{
	background-color:#eb675f;
	padding : 10px 10px;
}
.isiFormBarang:nth-child(odd) {
   background-color: #fff;
}
.isiFormBarang:nth-child(even) {
   background-color: #ccc;
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
				if($is_nota == 1){ //&&  strtouper($username) != "PONTIANAK"){
						if (($this->session->userdata('privilege')== 1)||($this->session->userdata('privilege')== 2)||($this->session->userdata('privilege')== 4)){?> 
						<li>
						<?php echo anchor('penjualan','Nota');?>
						</li>
						<?php } 
					}
					/* 
					else{
						echo anchor('penjualan/mini_after_pass','Nota');
					}
					*/
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
