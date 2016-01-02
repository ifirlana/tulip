<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Fee Baby Kc</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<?php
if(!isset($title))
{
	$title = "excel_data";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$title.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<?php echo $tampilan;?>
</body>
</html>