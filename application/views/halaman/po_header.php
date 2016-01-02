<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
    </div>
   <style>
   	#search{ padding:0; margin: 0 5px 0 5px; height:25px; float:left;}
	#search_label{ float:left;}
	#divListBarang{ background-color:#CCC; border-radius:20px;}
   </style>
