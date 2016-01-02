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
    function view_detailretur(id){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>po/view_retur_sparepart/'+id,
            data: $(this).serialize(),
            success: function(data) {
                $("#rec1").html(data);
                $('#rec1').dialog('option','width',500);
                $('#rec1').dialog('option','title','Retur Detail');
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
        <div class="post">  <h2 class="title"> SURAT RETUR SPAREPART</h2>
          <p>Filter SRSP</p>
<form action="<?php echo base_url()?>po/sreturpusat_rejec" method="post">
	<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    	<tr class="table">
        	<td>Berdasarkan Nama Cabang : <input type="text" name="cari" size="50" /></td>
        </tr>
    </table>
</form>
		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    
    <thead>
        <tr  align="center"  class="table">
           <th width="8%">No</th>
            <th width="19%">Cabang</th>
            <th width="17%">Week </th>
            <th width="20%">No SRSP</th>
			<th width="17%">Tanggal</th>
            <th width="19%">Action</th>
			</tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($po as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php  echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intid_week; ?></td>
            <td align='center'>&nbsp;<?php echo "<a href='javascript:void(0)' onclick='view_detailretur(".$m->intid_retur_sparepart.")'\>";?><?php echo $m->no_srsp; ?><?php echo "</a>";?></td>
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp; <?php echo "<a href='".base_url()."po/cetak_surat_retur_sparepart/$m->intid_retur_sparepart' target='_blank'>";?>View  <?php echo "</a>";?>| 
		 	<?php echo "<a href='".base_url()."sparepart_garansi/pra_retursparepart/?no=".$m->no_srsp."' target='_blank'>"?>
         	Next
		 	<?php echo "</a>"?></td>
            </tr>
		<?php endforeach; ?> 
    </tbody>
</table>
          <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php echo $pagination; ?></td>
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

