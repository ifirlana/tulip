<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>print</title>
</head>

<body>
<?php
	if(!isset($url)){
		$url = "#";
		}
?>
<div style="display:block; height:80px;"><img src="<?php echo base_url();?>images/logo.jpg" align="left" />
<a href="<?php echo $url;?>" ><img align="right" src="<?php echo base_url();?>/images/xls_icon.gif"/></a>
<a href="javascript:window.print()" onclick="location.href='../../po';"><img align="right" src="<?php echo base_url();?>/images/print.jpg"/></a></div>
<?php
echo $tampilan;
?>
<!--
<table width="100%">
	<tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td width="20%" align="center">ADM GUDANG</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td width="20%" align="center">(..............................)</td>
    </tr>
-->
</table>
</body>
</html>