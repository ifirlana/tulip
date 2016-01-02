<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<script src="<?php echo base_url()?>js/jquery2.js" type="text/javascript"></script>
        <script>
		$(document).ready(function(){
		console.log("starting");
		
		$("#btnExport").click(function(e) {
			window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
			e.preventDefault();
		});
		
		});

		var tableToExcel = (function() {
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
			window.open('coba/calon/');
		  }
		})()
		</script>
</head>
<body>
	<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
<div id="testTable">

<?php
	if(!isset($view)){
		$view = "TIDAK ADA DATA";
	}else{
		echo $view;
	}
?>
	</div>
</body>
</html>