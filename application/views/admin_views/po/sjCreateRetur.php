<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
	$(document).ready( function() {
    		$(".id1").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupBarangSj",
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
            		$("#result1").html(
            			"<input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='30' /><input type='text' id='stokakhir' name='stokakhir' value='" + ui.item.value1 + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		
	
	function save_data(){
		document.forms["myform"].submit();
	}
</script>

</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Buat Surat Jalan</h2>
        <div id="alert"></div>
    <form name="myform" id="myform" action="<?php echo base_url()?>po/save_sjretur" method="post">
      <table width="685" border="0" id="data" align="center">
          <tr>
            <td>CAB/SC</td>
            <td><?php echo $cabang;?><input type="hidden" name="intid_cabang" value="<?php echo $id_cabang;?>" /></td>
            <td>&nbsp;</td>
            <td>Bandung,</td>
            <td>&nbsp;</td>
            <td><?php echo date("j F Y");?></td>
          </tr>
          <tr>
            <td colspan="2">NO. SJ : <?php echo $maxId?>/
            <?php echo $week[0]->intid_week;?>/SJ/<?php echo date('m')?>/
            <?php echo date('Y')?>
            <input type="hidden" name="no_sj" value="<?php echo $maxId."/".$week[0]->intid_week."/PO/".date('m')."/".date('Y')?>" />            </td>
            <td width="11">&nbsp;</td>
            <td width="61" >Tgl Order</td>
            <td width="3">:</td>
            <td><input type="text" name="tgl_order" id="demo3" size="15" /><a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td width="300">&nbsp;</td>
             <td>&nbsp;</td>
             <td>Tgl Kirim</td>
             <td>:</td>
             <td><input type="text" name="tgl_kirim" id="demo4" size="15" /><a href="javascript:NewCssCal('demo4','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
          </tr>
          <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>Via</td>
             <td>:</td>
             <td><input type="text" name="via" id="via" /></td>
          </tr>
          </table>
      <table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
        <tr align="center" class="" bgcolor="#CCCCCC">
          <th rowspan="2">Nama Barang</th>
          <th rowspan="2">Nama Barang Yang Dikirim</th>
          <th colspan="2">&nbsp;</th>
          <th rowspan="2">Keterangan</th>
          <th rowspan="2">Stok</th>
        </tr>
        <tr align="center" class="" bgcolor="#CCCCCC">
          <th>Pcs</th>
          <th>Set</th>
          </tr>
        <tbody id="detail">
          <?php 
			$i=1;
			foreach($default as $m) : 
	?>
          <tr>
            <td><input type="text" size="40"  value="<?php echo $m->strnama;?>" readonly="readonly"/></td>
            <td><input type="text" name="namabarang" class="id1" size="40"  /><div id="result1"></div></td>
            <td><input name="qty" type="text" size="2" value="<?php if ($m->intid_jsatuan==2)  echo $m->qty; else echo 0;?>"/ readonly="readonly"></td>
            <td><input name="qty" type="text" size="2" value="<?php if ($m->intid_jsatuan==1)  echo $m->qty; else echo 0;?>" readonly="readonly"/></td>
            <td><textarea name="textarea" cols="10" rows="1"><?php echo $m->ket;?></textarea></td>
            <td><input name="stok" type="text" size="2" value="<?php echo $m->intqty_end;?>" readonly="readonly"/><div id="result1"></div></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <input type="hidden" name="intid_retur" value="<?php echo $default[0]->intid_retur;?>" />
      <input type="hidden" name="no_srb" value="<?php echo $default[0]->no_srb;?>" />
      <input name="" type="button" onclick="javascript:save_data();" value="Cetak Surat Jalan"/>
</form>
   </div>
	  </div>
			
	  </div>
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

