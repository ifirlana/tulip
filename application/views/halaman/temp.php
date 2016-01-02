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
			<?php 
				if(isset($view)){
					
					if(isset($data)){
						
						$this->load->view($view,$data);
						}else{
							
							$this->load->view($view);
							}
					}
				?>
			</div>
			</div>
		
		<?php 
			if(!isset($sidebar)){
				
				$this->load->view('admin_views/sidebar_penjualan'); 
				}else{
					
					$this->load->view($sidebar);
					}
			?>
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	