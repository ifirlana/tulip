<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
$(document).ready( function() {
	$("#rec1").dialog({
		autoOpen: false,
		modal: true,
		//width: '200'
	});
	
	$("#bayar").dialog({
            autoOpen: false,
            modal: true,
            width: '300'
        });
    
});
    function view_detailpo(id){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>po/view_retur/'+id,
            data: $(this).serialize(),
            success: function(data) {
                $("#rec1").html(data);
                $('#rec1').dialog('option','width',500);
                $('#rec1').dialog('option','title','PO Detail');
                $('#rec1').dialog('option','buttons',{
                    "Close" : function(){
                        $('#rec1').dialog('close');
                    }	}).dialog('open').css('text-align','center');
            }
        });
    }
	


</script>	
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Surat Retur Barang</h2>
    <div>
	<form method="POST">
		<table width="80%" border="0" cellpadding="1" cellspacing="1" id="data" align="center" style="background:white;">
			<tr><td>Pencarian</td><td><input type="text" name="cari" style="width:100%;" placeholder="masukan week atau nomor surat"/></td><td><input type="submit" value="Cari" /></td></tr>
		</table>
	</form>
	</div>
    <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    <thead>
        <tr  align="center"  class="table">
           <th width="8%">No</th>
            <th width="19%">Cabang</th>
            <th width="17%">Week </th>
            <th width="11%">No Surat</th>
			<th width="26%">Tanggal</th>
            <th width="19%">Action</th>
			</tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			
			if(isset($po)){
			foreach($po as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php  echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intid_week; ?></td>
            <td align='center'>&nbsp;<?php echo $m->no_srb; ?></td>
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp; <?php 
				if($m->is_sttb == 0){
				echo "<a href='".base_url()."POCO/GET_RETUR/?no=".$m->no_srb."'\>";?>View
			<?php echo "</a>";
				}else{
				echo "<a href='".base_url()."POCO/GET_STTB/?no=".$m->no_sttb."'\>";?>View
			<?php echo "</a>";
				
				}
			?></td>
            </tr>
		<?php endforeach; 
				}?> 
		<?php 
			if(isset($po_sparepart)){
			foreach($po_sparepart as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php  echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intid_week; ?></td>
            <td align='center'>&nbsp;<?php echo $m->no_srsp; ?></td>
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp; <?php 
				echo "<a href='".base_url()."po/cetak_surat_retur_sparepart/".$m->intid_retur_sparepart."'\>";?>View<?php echo "</a>";
				if($m->is_sttb == 1){
				echo "|| <a href='".base_url()."sparepart_garansi/GET_STTB/?no=".$m->no_sttb."'\>";?>STTB
			<?php echo "</a>";
				
				}
			?></td>
            </tr>
		<?php endforeach; 
			}?> 
    </tbody>
</table>
          <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php if(isset($pagination)){echo $pagination;} ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
		  </div>
	  </div>
			
	  </div>
		<!-- end #content -->
        <div id="rec1" style="width:400px; height: 100px;"></div>
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

