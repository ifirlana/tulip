<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
<div id="page">
        <div id="page-bgtop">
            <div id="content">
            	<h2 class="title">
			 	<?php
			 		if(isset($title)){
			 			echo $title;
			 		}else{
			 			echo "NONE TEXT";
			 		}
			 	?>
			 </h2>
			<div class="post">
			 <div class="entry"> 
				<?php 
				if(isset($content)){
					//hell yeah
						echo $content;
				}else{
					echo '     
	                   <div class="mainpenjualan">
						</div>';
				}
			  ?>
			  </div>
			</div></div>
			</div>
		<!-- end #content -->
		<?php
		if(isset($sidebar) and $sidebar != 'penjualan')
		{
			//<!-- end #sidebar --> 
			echo $sidebar;
		 
		}elseif(isset($sidebar) and $sidebar == 'penjualan'){ 
			//echo "sidebar : ".$sidebar."<br />";
				$this->load->view('admin_views/sidebar_penjualan');
		}else{
			echo ""; 
			}?>
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->
