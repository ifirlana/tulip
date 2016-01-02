<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
 //for barang            
 $(document).ready( function() {
	$('#tracker').val(0);
	$('#alert_input').html('');
    		$(".id1").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupBarangPO",
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
           
        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">BUAT PO</h2>
                    <div class="entry">
                      <form action="<?php echo base_url()?>po/poAdd" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                          <table width="685" border="0" id="data" align="center">
                              <tr>
                                  <td width="157">
                              <tr>
                                  <td colspan="2">NO. PO : <?php echo $maxId?>/
								  <?php echo $week[0]->intid_week;?>/PO/<?php echo date('m')?>/
								  <?php echo date('Y')?>
                                  <input type="hidden" name="no_po" value="<?php echo $maxId."/".$week[0]->intid_week."/PO/".date('m')."/".date('Y')?>" />
                                  <input type="hidden" name="tracker" id="tracker" size="2" value="0" />
                                  </td>
                                <td width="14">&nbsp;</td>
                                <td width="41" >Tanggal</td>
                                <td width="10">:</td>
                                <td width="142"><?php echo date("j F Y");?></td>
                            </tr>

                              <tr>
                                  <td>&nbsp;</td>
                          <td width="317">&nbsp;</td>
                                <td>&nbsp;</td>
                                  <td>Cabang</td>
                                <td>:</td>
                                  <td><?php echo $cabang; ?>
                                  <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>" /></td>
                            </tr>
                              <tr>
                                  <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                  <td>Week</td>
                                <td>:</td>
                                  <td><?php echo $week[0]->intid_week;?>
                                  <input type="hidden" name="intid_week" value="<?php echo  $week[0]->intid_week; ?>" />
                                  </td>
                            </tr>
                              <tr>
                                  <td colspan="6">&nbsp;
                                      <div align="center" id="title"></div></td>
                              </tr>
                              <tr>
                                  <td colspan="6"><table width="661" border="1" id="data" align="center">
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
												<td colspan="3"><div id="alert_input"  style='padding:0 0 0 15px;' align='left'>&nbsp;</div></td>
											</tr>
                                            <tr>
                                              <td colspan="3"><div id="result">&nbsp;</div></td>
                                          </tr>
                                             <tr>
                                          <!--<td align="center" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reguler&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Free</td>-->
                                          </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <div id="ButtonAdd" style="margin-left: 150px"></div></td>
                                            </tr>
                                        </table></td>
                              </tr>
                              <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                               <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><input type="submit" id="simpan" value="Simpan" class="button"/></td>
                                    <td>&nbsp;</td>
                                    <td><input class="button" type="button" value="Cancel" onclick="location.href='po';"/></td>
                                </tr>
                          </table>
        </td>
                            </tr>
                            </table>
                      </form>
                    </div>
                </div></div>
        </div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">
    
    var idx = 1;
  	var idxf=1;
    $('#addBrg').bind('click', function(e){

        if($(".id1").val()==""){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{
			 var trc = $('#tracker').val();
			 if(trc != 0){
					trc= parseInt(trc)+parseInt(1);
					$('#tracker').val(trc);
				 }else{
					$('#tracker').val(1);
				 }
            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var id_barang =  $('#id_barang').val();
			var free = $('#free').val();
			
			
			
			var out = '';
           out += 'No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama Barang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Banyak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
			out +='Keterangan<br>'

            out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
			 out += '<input id="baris_'+idx+'" type="text" size="2" value="'+idx+'" disabled />';
            out += '<input id="barang_intid_barang_'+idx+'" name="barang['+idx+'][intid_barang]" type="text" size="60" value="'+brg+'"  />';
            
            out += '<input type="hidden" id="barang_intid_id_'+idx+'" name="barang['+idx+'][intid_id]" value="'+id_barang+'">&nbsp;';
			out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][intquantity]" type="text" size="3" value="0" onkeyUp="kali_sepuluh(this.id)"/>&nbsp;';
			out += '<input name="barang['+idx+'][ket]" type="text" size="10" />';      
            out += '<a href="#hapus" class="delRow" onclick="$(this).parent().remove()" id="del'+idx+'">hapus</a>';
            out = '<div style="height:60px">' + out + '</div>';
			$(out).insertAfter('#ButtonAdd');
            
			$('#alert_input').html('terakhir menambahkan : <h4>'+brg+'</h4>');
            idx++;
            
			var tracker = $('#tracker').val();
			var count = 0;
				
			for(var i = 1; i <= tracker; i++){
				if($('#barang_intid_id_'+i).length > 0){
					for(var j = 1; j < i;j++){
							if($('#barang_intid_id_'+j).length > 0){
								if($('#barang_intid_id_'+j).val() == $('#barang_intid_id_'+i).val()){
									count = parseInt(count) + parseInt(1); 
									//alert('hello');
								}else{
									//alert('keluar');
								}			
						}
					}
					//alert('masuk');
				}else{
					//alert('keluar');
				}
			}
			if(count > 0){
				alert('Warning! Barang yang sudah terpilih lebih dari satu jenis');
			}
			
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

