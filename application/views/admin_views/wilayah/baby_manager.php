<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
 <script type="text/javascript">
            //for unit
            $(document).ready( function() {
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
                            dataType: 'json',
                            type: 'POST',
                            data: req,
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    select:
                        function(event, ui) {
                        $("#result").append(
                        "<input type='hidden' id='id_unit' name='intid_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });
				});
				
				</script>	
	</div>
	
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
				<h2 class="title">Baby Manager </h2>
				
				<div class="entry">
                 <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<?php /*if ($privilege == 1) */echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('baby_managerunit/add', 'Tambah data')."</td>";/* else echo ""*/;?></table>
                <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
<tr>

<td align="center" style="width:95%" ><b>Cari Berdasarkan Unit :</b> 
<form action="<?php echo base_url()?>baby_managerunit/index" method="post">
	<input type="text" name="cari" id="intid_unit" /> <div id="result"></div>&nbsp;
</form>
</td></tr>
</table>
						  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr   class="table" align="center" >
           <th >No</th>
           <th><span class="style2">Baby Manager</span></th>
            <th><span class="style2">Dari Unit</span></th>
			<th><span class="style2">Aksi</span></th>
        </tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
    <?php if(empty($wilayah)):?>
    <tr>
    	<td colspan="4" align="center">Data Kosong</td>
    </tr>
		
		<?php else:
				$i=1;	foreach($wilayah as $m) : 
	
		?>
        
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
			<td align='justify'>&nbsp;<?php echo $m->strnama_unit; ?></td>
            <td align='justify'>&nbsp;<?php echo $m->baby; ?></td>
            <td align="center" width="190px"><?php //echo anchor ('baby_cabang/edit/'.$m->id, 'Edit'); ?> <?php echo anchor ('baby_managerunit/delete/'.$m->id, 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
        </tr>
		<?php endforeach; endif;?> 
	
    </tbody>
</table>

				</div>
			</div>

		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_master'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

