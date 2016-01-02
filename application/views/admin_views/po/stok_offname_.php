<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
  <script type="text/javascript">
            //for cabang
            $(document).ready( function() {
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
        
	
		function hitung(){
			
			var jum = $('#jum_opname').val();
			
			for(var a=1;a<=jum;a++){
				var fisik_pcs = Number($('#fisikpcs_'+a).val());
				var fisik_set = Number($('#fisikset_'+a).val());
				var pcsakhir = Number($('#pcsakhir_'+a).val());
				var setakhir = Number($('#setakhir_'+a).val());
				
				if(fisik_pcs != ''){
					$('#selisihpcs_'+a).val(pcsakhir - fisik_pcs ); 
				}
				if(fisik_set != ''){
					$('#selisihset_'+a).val(setakhir - fisik_set); 
				}
				}
			}
		   
		</script>
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> STOK OPNAME</h2>
         <form action="<?php echo base_url()?>po/Lap_stock_op" method="post" name="frmjual" id="frmjual">
                          <table width="90%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;Cabang </td>
                                <?php if ($id_cabang ==1) {?>
                                <td><input type="text" name="intid_cabang" id="intid_cabang"/></td>
                                <td>&nbsp;<div id="result"></div></td>
                                <? } else { ?>
                               <td><input type="text" name="cabang" id="cabang" value="<?php echo $cabang;?>" readonly="readonly"/>                                
                               </td>
                                <td>&nbsp;</td>
                                <input type="hidden" name="intid_cabang" id="intid_cabang" value="<?php echo $id_cabang;?>"/>
                                <? } ?>
                                
                            </tr>
                             <tr>
                                <td>&nbsp;Tanggal</td>
                                <td><input type="text" name="datetgl" id="demo3" size="25" /><a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
                              </tr>

                             <tr>
                              	<td><input name="" type="submit" value="Proses"/></td>
                              </tr>
                              </table>
          </form>
           
		<?php if (!empty($po)){?>      
        <input type="hidden" name="jum_opname" id="jum_opname" value="<?=count($po)?>" />
        <form id="form_opname" action="<?php echo base_url()?>po/preview_opname" method="post">
        <fieldset>
        <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
            <thead>
                <tr class="table" align="center" >
                <th width="22" rowspan="2">&nbsp;</th>
                  <th width="95" rowspan="2">Nama Barang</th>
                  <th colspan="2">Stok Akhir</th>
                  <th colspan="2">Fisik</th>
                  <th colspan="2">Selisih</th>
                </tr>
                <tr class="table" align="center" >
                    <th width="23" >Pcs</th>
                    <th width="23">Set</th>
                    <th width="30">Pcs</th>
                    <th width="30" >Set</th>
                    <th width="30">Pcs</th>
                    <th width="30" >Set</th>
                </tr>
            </thead>
            <tbody>

               <?php
                $i=1;
                $no=1;
                if(!empty($po)){
                foreach($po as $m) : 
				

                ?>
          <tr class='data' align='center'>
<td align="left"><input type="checkbox" checked="checked" name="pilih[<?=$no?>]" value="<?php echo $m->intid_barang?>" />
<input id="nama<?=$no?>" name="nama[<?=$no?>]" type="hidden"  size="5" value="<?php echo $m->strnama; ?>"/>
</td>
            <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
            <td align='left'>&nbsp;<?php if (!empty($m->pcs_akhir)) echo $m->pcs_akhir; else echo 0;?>
            <input id="pcsakhir_<?=$no?>" name="pcsakhir[<?=$no?>]" type="hidden"  size="5" value="<?php echo $m->pcs_akhir; ?>"/>
            </td>
            <td align='left'>&nbsp;<?php if (!empty($m->set_akhir)) echo $m->set_akhir; else echo 0; ?>
            <input id="setakhir_<?=$no?>" name="setakhir[<?=$no?>]" type="hidden"  size="5" value="<?php echo $m->set_akhir; ?>"/></td>
            <td align='left'>&nbsp;<input name="fisikpcs[<?php echo $no?>]" id="fisikpcs_<?=$no?>" onkeyup="hitung()" type="text" size="5" class="number" digit_decimal="2"/></td>
            <td align='left'>&nbsp;<input name="fisikset[<?php echo $no?>]" id="fisikset_<?=$no?>" type="text" onkeyup="hitung()" size="5" class="number" digit_decimal="2"/></td>
            <td align='left'>&nbsp;<input name="selisihpcs[<?php echo $no?>]" id="selisihpcs_<?=$no?>" type="text" size="5"  readonly="readonly"/></td>
            <td align='left'>&nbsp;<input name="selisihset[<?php echo $no?>]" id="selisihset_<?=$no?>" type="text" size="5" readonly="readonly"/></td>
            </tr>
            <?php 
            $no++;
            endforeach; }?> 
            </tbody>
        </table>
        </fieldset>
<?php }else{ ?>
    <fieldset>
    No Result Found
    </fieldset>
<?php } ?>                   

<p align="center"><input type="submit" name="update" value="Simpan" /></p>
</form>
		  </div>
	  </div>
			
	  </div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div id="rec1" style="width:800px; height: 100px;"></div>
        <div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

