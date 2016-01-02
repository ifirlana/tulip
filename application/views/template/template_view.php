<html>
<head>
<title><?php if(isset($title)){ echo $title;}else{
	echo "twintulipware Indonesia";
}?></title>
<link rel="stylesheet" href="<?php echo base_url()?>css/ui-lightness/jquery-ui-1.8.13.custom.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/css" media="all" />
<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jQuery/ui/jquery-ui-1.8rc3.custom.js"></script>
<script src="<?php echo base_url()?>assets/javascript/jQuery/form/jquery.form.js" type='text/javascript'></script>

<?php 
	if(isset($style)){
		echo "<style>".$style."</style>";
	}?>
</head> 
<body>
	<?php 
	if(isset($content)){
		echo $content;
	}else{
		echo "no content.";
	}?>
<?php 
	if(isset($javascript)){
		echo "<script>".$javascript."</script>";
	}?>
</body>
</html>      