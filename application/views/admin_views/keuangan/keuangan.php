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
			<div class="post">	<h2 class="title">Keuangan </h2>
				<div class="entry">      
                <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img11.png' align='absmiddle'/>".anchor('penjualan', 'Starter Kit')."</td>";/* else echo ""*/;?>
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img11.png' align='absmiddle'/>".anchor('penjualan/print_nota', 'Nota baru')."</td>";/* else echo ""*/;?>

<td align="right" style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?></b></td></tr>
</table>        
                  <form action="<?php echo base_url()?>dealer/dealer"  method="post" >
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                  </form>
		               
			  </div>
			</div></div>
			</div>
		
		<?php $this->load->view('admin_views/sidebar_penjualan'); ?>
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	