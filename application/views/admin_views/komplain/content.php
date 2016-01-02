<html>
	<head>
		<title>Form Komplain SJ</title>
	</head>
	<body>
		<div><a href="<?php if(!isset($back_url) and empty($back_url)){echo base_url()."po";}else{echo $back_url;}?>">BACK</a></div>
		<h1>FORM KOMPLAIN SURAT JALAN</h1>
		<div id="container">
			<?php
				if(!isset($url)){
					
					$this->load->view("admin_views/komplain/form_komplain",$form_komplain);
				}else{
					
					$this->load->view($url,$form_komplain);
					}
			?>
		</div>
	</body>
</html>