<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<?php $this->load->view('admin_views/header'); ?><hr />
<div id="wrapper">
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
            url: '<?php echo base_url(); ?>po/view_po/'+id,
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
        <div class="post">  <h2 class="title"> PO Barang</h2>
          <?php //if ($this->session->userdata('privilege')== 1)echo "<td  align='left' style='width:75%' ><img  src='".base_url()."images/img10.png' align='absmiddle'/>".anchor('po/poAdd', 'Tambah PO')."</td>";?>

		  <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
    
    <thead>
        <tr  align="center"  class="table">
           <th width="20">No</th>
            <th width="51">Cabang</th>
            <th width="129">No. PO / Tanggal </th>
            <th>Aksi</th>
			</tr>
    </thead>
    <tbody>
	
    <!-- ============isi ============ -->
		
		<?php 
			$i=1;
			foreach($po as $m) : 
			
		?>
        
      	<tr class='data' align='center'>
            <td ><?php echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='center'>&nbsp;
                 <?php  //echo anchor ('po/view_detailpo/'.$m->intid_po);?>
         <?php echo "<a href='javascript:void(0)' onclick='view_detailpo(".$m->intid_po.")'\>";?>
		 <?php echo $m->no_po. " / ".$m->datetgl."</a>"?>
            </td>
            <td align="center" width="86"><?php echo anchor ('po/delete/'.$m->intid_po, 'Hapus', array('onClick' =>"return confirm ('Apakah Anda yakin akan menghapus data ')")); ?></td>
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
      <div id="rec1" style="width:400px; height: 100px;"></div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

