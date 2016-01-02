<body>
<style type="text/css">
	body{
		background-color:#36C;
		}
	#wrapper{
		background-color:#CCC;
		padding:10px 5px 10px 5px;
		}
	#menu ul{list-style-type:none; 
				display:block; 
				height:40px; 
				width:9%; 
				background-color:#FFF;
				font-size:14px;}
	#menu ul li{float:left; margin:5px 20px 3px 15px;}
	#menu ul li a{text-decoration:none;}
</style>
<div>
<img src="<?php echo base_url();?>/images/header_1t3_1.jpg" width="100%"/>
</div>
<meta charset="UTF-8">
		<div id="menu">
			<ul>
				<li><?php echo anchor('site/home', 'Home'); ?></li>
           		<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('dealer','Master');?></li><?php } ?>
				<?php if (($this->session->userdata('privilege')== 1)||($this->session->userdata('privilege')== 2)||($this->session->userdata('privilege')== 4)){?><li><?php echo anchor('penjualan','Nota');?></li><?php } ?>
                <li><?php echo anchor('laporan','Laporan');?></li>
                <li><?php echo anchor('po','Gudang');?></li>
				<li><?php echo anchor('calon_manager','Manager');?></li>
				<li><?php echo anchor('login/logout','Logout');?>
                
</li>
				
		  </ul>
		</div>
        