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
            			"<input type='hidden' id='id_barang' name='id_barang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
	function check_all(val) {
			var checkbox = document.myform.elements['pilih[]'];
			if ( checkbox.length > 0 ) {
				for (i = 0; i < checkbox.length; i++) {
					if ( val.checked ) {
						checkbox[i].checked = true;
					}
					else {
						checkbox[i].checked = false;
					}
				}
			}
			else {
				if ( val.checked ) {
					checkbox.checked = true;
				}
				else {
					checkbox.checked = false;
				}
			}
		}	
	function cek(){
		var x=0;
		for (var i=0;i < document.myform.elements.length;i++)
		{
			var e = document.myform.elements[i];
			
			if (e.type == 'checkbox')
			{
				if(e.checked){
					x++;
				}
			}
		}
		
		if(x > 0){
			return true;
		}else{
			return false;
		}
	}
</script>

</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Buat Surat Jalan</h2>
        <div id="alert"></div>
    <form name="myform" id="myform" action="<?php echo base_url()?>po/save_sjpo" method="post">
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
          <th rowspan="2">&nbsp;</th>
          <th rowspan="2">Nama Barang</th>
          <th colspan="2">&nbsp;</th>
          <th rowspan="2">Barang yang dikirim</th>
          <th rowspan="2">Keterangan</th>
          <th rowspan="2">Stok cabang</th>
          <th rowspan="2">Stok Pusat</th>
        </tr>
        <tr align="center" class="" bgcolor="#CCCCCC">
          <th>Pcs</th>
          <th>Set</th>
        </tr>
        <tbody>
          <?php 
			$i=0;
			foreach($default as $m) : 
			
	?>
          
          <tr>
            <td><input type="checkbox" name="pilih[]" value="<?php echo $i;?>"/>
			<input type="hidden" name="main[]" value="<?php echo $m->intid_barang;?>_<?php echo $m->intid_po;?>_<?php echo $id_cabang;?>_<?php echo $m->qty;?>" />
			<input  name="no_spkb" type="hidden" size="10" value="<?php echo $m->no_spkb;?>"/></td>
            <td><input type="text" name="namabarang" size="50"  value="<?php echo $m->strnama;?>" readonly="readonly"/></td>
            <td><input name="qty" type="text" size="2" value="<?php if ($m->intid_jsatuan==2)  echo $m->qty; else echo 0;?>" readonly="readonly"/></td>
            <td><input name="qty" type="text" size="2" value="<?php if ($m->intid_jsatuan==1)  echo $m->qty; else echo 0;?>" readonly="readonly"/></td>
            <td><input name="quantity[]"  type="text" size="2" /></td>
            <td><textarea name="keterangan[]" cols="10" rows="1"><?php echo $m->ket;?></textarea></td>
            <td><input id="stok" name="stok" type="text" size="2" value="<?php echo $m->jumlah;?>" readonly="readonly"/></td>
            <td><input id="stok" name="stok" type="text" size="2" value="<?php echo $m->jumlah_pusat;?>" readonly="readonly"/></td>
          </tr>
          
          <?php $i++; endforeach;?>
        <tr>
        <td colspan="6"><input type="checkbox" onclick="check_all(this)" />Select All/Unselect All<br /></td>
        </tr>
        </tbody>
      </table>
      <table width="661" border="1" id="data" align="center">
                                            <tr>
                                                <td width="159">&nbsp;Silahkan ketik</td>
                                              <td width="371">&nbsp;Nama Barang</td>
                                      <td width="109" rowspan="2"><div id="data">
                                                        <input type="button" id="addBrg" name="addBrg" value="Tambah" />
                                                    </div>    </td>
                                    </tr>
                                            <tr>
                                                <td>&nbsp;Barang -&gt;
                                                    <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                                <td>&nbsp;
                                                    <input type="text" name="barang[1][intid_barang]" class="id1" size="50" />
                                                    <div id="result1"></div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="3">&nbsp;<div id="result"></div></td>
                                          </tr>
                                          <tr>
                                                <td colspan="4">
                                                    <div id="ButtonAdd" style="margin-left: 150px"></div></td>
              </tr>
            </table>
      <input name="" type="submit" value="Cetak Surat Jalan"/>
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
<script type="text/javascript">
    
    var idx = 1;
  	var idxf=1;
    $('#addBrg').bind('click', function(e){

        if($(".id1").val()==""){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var id_barang =  $('#id_barang').val();
			var free = $('#free').val();


            var out = '';
           out += 'Nama Barang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Banyak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
			out +='Keterangan<br>'

            out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="30" value="'+brg+'"  />';
            
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">&nbsp;';
			out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="5" value="0" onkeyUp="kali_sepuluh(this.id)"/>&nbsp;';
			out += '<input name="barang['+idx+'][ket]" type="text" size="30" />';      
            out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
            $('.id1').val('');
            $('#jumlah').val('');
          	$("#del"+id).remove();

        }
      
        return false;

    });

	function kali_sepuluh(id){
        $("#del"+id).remove();
	}
	
    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })



</script>


