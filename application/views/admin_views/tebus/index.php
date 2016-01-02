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
			<p><h2 class="title">Tebus Retur Garansi</h2></p>
						<p>Masukan srsp yang diterima oleh konsumen, berikan nota tersebut beserta barang untuk konsumen</p>
						<form method="POST" action="<?php echo base_url();?>POCO/Tebussparepart">
						<table id="data">
								<tr><td>Nomor Surat</td><td><input type="text" name="surat" /></td></tr>
								<tr><td colspan="2"><input type="submit" id="id-surat" name="btn-surat" value="Tebus"  /></td></tr>
						</table>
						</form>
					
			<?php
				if(isset($query) and $query->num_rows() > 0){
					$result	=	$query->result();
					echo "<form method='POST' action = '".base_url()."POCO/TerimaTebussparepart'>";
					echo "<input type='hidden' name='intid_dealer' value='".$result[0]->intid_dealer."' />";
					echo "<input type='hidden' name='no_srsp' value='".$result[0]->no_srsp."' />";
					echo "<input type='hidden' name='intno_nota' value='".$intno_nota."' />";
					echo "<input type='hidden' name='intid_cabang' value='".$intid_cabang."' />";
					echo "<input type='hidden' name='jenis_nota' value='RT13' />";
					echo "<table id='data'>";
					echo "<tr><th>Nama Barang</th><th>Jumlah</th><th>&nbsp;</th></tr>";
					foreach($query->result() as $row){
						echo "<tr>";
						echo "<td>".$row->strnama."</td>";
						echo "<td>".$row->qty."</td>";
						echo "<td><input type='checkbox' name='check[]' value='".$row->id."' /></td>";
						echo "</tr>";
						}
					echo "<tr><th colspan='3'><input type='submit'  name='btn-surat' value='Submit'  /></th></tr>";
					echo "</table>";
					echo "</form>";
					}
			?>	
			</div>
			</div>
			</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->
