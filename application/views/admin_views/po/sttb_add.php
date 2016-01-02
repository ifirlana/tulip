<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
        <script type="text/javascript">
            //for cabang
             $(this).ready( function() {
    		$("#intid_cabang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupCabang",
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
            			"<input type='hidden' id='intid_cabang' name='intid_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
	
 //for barang
             $(this).ready( function() {
    		$("#intid_barang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>po/lookupBarang",
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
                <div>	<h2 class="title">Buat Surat Tanda Terima Barang</h2><div class="entry">
                      <form action="<?php echo base_url()?>po/sttbAdd" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                          <table width="685" border="0" id="data" align="center">
                              <tr>
                                  <td>
                              <tr>
                                  <td width="96">&nbsp;<?php echo date("d-m-Y");?></td>
                                  <td width="277">&nbsp;</td>
                                  <td width="27">&nbsp;</td>
                                  <td width="68" >&nbsp;</td>
                                  <td width="10">&nbsp;,</td>
                                  <td width="181">&nbsp;</td>
                              </tr>
<tr>
                               <td>No. Surat Jalan</td>
                                  <td>&nbsp; <input type="text" name="no_surat" id="no_surat" size="30" /></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              <tr>
                               <td>Cabang</td>
                                 <td><?php echo $cabang; ?>
                                  <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>" /></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              <tr>
                                  <td>&nbsp;Week</td>
                                  <td>&nbsp;<select name="intid_week" id="intid_week">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($id);$i++)
				{
					echo "<option value='$intw[$i]'>$id[$i]</option>";
				}
			?>
        </select></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              <tr>
                                  <td colspan="6">&nbsp;
                                      <div align="center" id="title"></div></td>
                              </tr>
                              <tr>
                                  <td colspan="6"><table width="661" border="0" id="data" align="center">
                                          <tr>
                                              <td width="98">&nbsp;Silahkan ketik</td>
                                            <td width="335">&nbsp;Nama Barang</td>
                                            <td width="84">&nbsp;</td>
                                    <td width="126" rowspan="3"><div id="data">
                                                      <input type="button" id="addBrg" name="addBrg" value="Tambah" />
                                                  </div>    </td>
                                    </tr>
                                          <tr>
                                              <td>&nbsp;Pilih Barang -&gt;
                                                  <input type="hidden" name="barang[1][intquantity]" id="jumlah" size="5" /></td>
                                              <td>&nbsp;
                                                  <input type="text" name="intid_barang" id="intid_barang" class="id1" size="50" />
                                                  
                                                  </td>
                                              <td>&nbsp;
                                                  <div id="result1"></div></td>
                                          </tr>
                                          <tr>
                                              <td colspan="3">&nbsp;                                                <div id="result"></div></td>
                                          </tr>
                                          <tr>
                                              <td colspan="4" align="left">
                                              	<div id="ButtonAdd" style="margin-left: 150px">
                                                  </div></td>
                                          </tr>
                                      </table></td>
                              </tr>
                             <!-- <tr>
                                  <td>Keterangan</td>
                                  <td>&nbsp;<textarea name="ket" cols="50"></textarea></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>-->
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
                                  <td colspan="2">&nbsp;&nbsp;<input type="submit" value="Simpan" class="button"/></td>
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
    $('#addBrg').bind('click', function(e){

        if($(".id1").val()==""){
            alert('Anda belum memilih barang!');

        }else if($('.id1').val() != "")
			{

            var brg = $('.id1').val();
            var jumlah = $('#jumlah').val();
            var id_barang =  $('#id_barang').val();

            var out = '';
          
			out +='Nama Barang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PCS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keterangan<br>'

                out += '<input type="hidden" id="hitaja" name="hitaja[]" value="'+idx+'">';
                
            

            out += '<input name="barang['+idx+'][intid_barang]" type="text" size="50" value="'+brg+'"  />';
            
            out += '<input name="barang['+idx+'][intid_id]" type="hidden" value="'+id_barang+'">&nbsp;';
			out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][pcs]" type="text" size="2" value="0"  />&nbsp;';
			out += '<input id="'+idx+'" class="semua_'+idx+'" name="barang['+idx+'][set]" type="text" size="2" value="0" />&nbsp;';
			out += '<input name="barang['+idx+'][ket]" type="text" size="30" />';   
            out += ' <a href="#hapus" class="delRow" onclick="$(this).parent().remove()">hapus</a> ';
            out = '<div style="height:60px">' + out + '</div>';
            $(out).insertBefore('#ButtonAdd');
            idx++;
             $('#intid_barang').val('');
            $('#jumlah').val('');
           // $('#harga_barang').val('');
          //  $('#pv').val('');

        }
      
        return false;

    });

	

   
    $('#btnAdd').click(function(){
        $('#ButtonAdd').html($('#inputBrg').html());
    })


function kali(){
	$('.id1').val('');
	}
    function formatAsRupiah(ObjVal) {

        mnt = ObjVal;

        mnt -= 0;

        mnt = (Math.round(mnt*100))/100;

        ObjVal = (mnt == Math.floor(mnt)) ? mnt + '.00' : ( (mnt*10 == Math.floor(mnt*10)) ? mnt + '0' : mnt);

        if (isNaN(ObjVal)) {ObjVal ="0.00";}

        return ObjVal;
    }

    function formatAsDollars(amount){

        if (isNaN(amount)) {
            return "0.00";
        }
        amount = Math.round(amount*100)/100;

        var amount_str = String(amount);

        var amount_array = amount_str.split(".");

        if (amount_array[1] == undefined) {
            amount_array[1] = "00";
        }
        if (amount_array[1].length == 1) {
            amount_array[1] += "0";
        }
        var dollar_array = new Array();
        var start;
        var end = amount_array[0].length;
        while (end>0) {
            start = Math.max(end-3, 0);
            dollar_array.unshift(amount_array[0].slice(start, end));
            end = start;
        }

        amount_array[0] = dollar_array.join(",");

        return (amount_array.join("."));
    }
	
	$('#frmjual').submit(function(event){

        if($("#intid_week").val()==""){
            alert('Week tidak Boleh Kosong!');
            $("#intid_week").focus();
            event.preventDefault();
        }
		 else if($("#no_surat").val()==""){
            alert('No Surat tidak Boleh Kosong!');
            $("#no_surat").focus();
            event.preventDefault();
        }
});

</script>

