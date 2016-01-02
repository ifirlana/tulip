<?php
$this->load->helper('HTML');
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
			<div class="post">
			<p><h2 class="title">Master Class</h2></p>
			<p><h3>Notifikasi</h3></p>
			  	
					<?php
						/* untuk merchadise memantau */
						if(isset($intid_cabang) and $intid_cabang == 102){///untuk bu MEi
							$select 	=	"select *,(select strnama_cabang from cabang where cabang.intid_cabang = po_.intid_cabang)strnama_cabang 
								from po_ 
								left join spkb
								on po_.no_spkb = spkb.no_spkb
								where po_.no_po like '%POMERCHNDS%' order by po_.time desc";
							$merchandise['query']	=	$this->db->query($select);
							
							$this->load->view("admin_views/merchandise/index",$merchandise);
							
							}else{
					?>
					<p><?php $this->load->view("admin_views/komplain/show_komplain",$komplain);?></p>
					<?php $this->load->view("admin_views/po/notifikasi_po",$po);?>
					<?php $this->load->view("admin_views/retur/notifikasi_retur",$retur);?>
					<?php $this->load->view("admin_views/sparepart/notifikasi_sparepart",$sparepart);?>
					
					<?php
						}?>
				 <div class="mainpo">
			  </div>
			</div></div>
			</div>
		<!-- end #content -->
		<?php 
			if($this->session->userdata('username') == "adi"){
				$this->load->view('admin_views/sidebar_gudang_adi');
				}else{
				$this->load->view('admin_views/sidebar_gudang');
				}
				?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->
