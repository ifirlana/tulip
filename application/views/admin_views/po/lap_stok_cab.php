<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
     <script type="text/javascript">
            //for cabang
         $(document).ready( function() {
			$("#id_cabang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>penjualan/lookup",
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
            		$("#result3").append(
            			"<input type='hidden' id='intid_cabang' name='intid_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
 			$("#cabang").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>penjualan/lookupCabangBs",
		          		dataType: 'json',
		          		type: 'POST',
		          		 data: {
                                term: req.term,
                                state: $('#intid_user').val(),

                            },
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
            		$("#result3").append(
            			"<input type='hidden' id='intid_cabang' name='intid_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		</script>
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Laporan Stok Cabang</h2>
   <form action="<?php echo base_url()?>po/lap_stok_cab" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                          <table width="685" border="0" id="data" align="center">
                              <tr>
                                  <td>
                         

                              <tr>
                                <td>&nbsp;CABANG : </td>
                                <?php if ($intid_privilege ==1) {?>
                                <td><input type="text" name="id_cabang" id="id_cabang"/></td>
                                <td>&nbsp;<div id="result3"></div></td>
                                <? } else if ($intid_privilege ==2){ ?>
                                <td><input type="text" name="cabang" id="cabang" value="<?php echo $cabang;?>" readonly="readonly"/></td>
                                <td>&nbsp;</td>
                                 <input type="text" name="intid_cabang" id="intid_cabang" value="<?php echo $id_cabang;?>" readonly="readonly"/>
                                <? } else if ($intid_privilege ==5) {?>
                                <td><input type="text" name="cabang" id="cabang"/></td>
                                <td>&nbsp;<div id="result4"></div></td>
                                <?php } ?>
                               <input type="hidden" name="intid_user" id="intid_user" value="<?php echo $intid_user;?>" readonly="readonly"/>
                            </tr>
                              <tr>
                                  <td>&nbsp;Week</td>
                                  <td>&nbsp;
								  <select name="intid_week" id="intid_week">
                                      <option value="">-- Pilih --</option>
                                      <?php
                                            for($i=0;$i<count($id);$i++)
                                            {
                                                echo "<option value='$intw[$i]'>$id[$i]</option>";
                                            }
									?>
                                    </select>
									</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              </td></tr>
                              <tr>
                              	<td><input type="submit" name="submit" value="Proses" /></td>
                              </tr>
                              </table>
                              </form>
                        <fieldset>
						<?php if (!empty($po)){?>      
		 				<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                            <thead>
                                <tr   class="data" align="center" >
                                  <th width="49" rowspan="2">Nama Barang</th>
                                  <th colspan="2">Stok Awal</th>
                                  <th colspan="2">Masuk</th>
                                  <th colspan="2" >Keluar</th>
                                  <th colspan="2" >Sisa</th>
                                </tr>
                                <tr   class="data" align="center" >
                                    <th width="22" >Pcs</th>
                                    <th width="23">Set</th>
                                    <th width="23">Pcs</th>
                                    <th width="23" >Set</th>
                                  <th width="28">Pcs</th>
                                  <th width="29" >Set</th>
                                    <th width="22" >Pcs</th>
                                    <th width="23" >Set</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                               <?php
                                $i=1;
								if(!empty($po)){
								foreach($po as $m) : 
								$sisa_pcs = ($m->pcs_awal + $m->pcs_masuk) - ($m->pcs_keluar);
								$sisa_set = ($m->set_awal + $m->set_masuk) - ($m->set_keluar);
								?>

                          <tr class='data' align='center'>
            
                            <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
                            <td align='center'>&nbsp;<?php if(!empty($m->pcs_awal)) echo $m->pcs_awal; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($m->set_awal)) echo $m->set_awal; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($m->pcs_masuk)) echo $m->pcs_masuk; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($m->set_masuk)) echo $m->set_masuk; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($m->pcs_keluar)) echo $m->pcs_keluar; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($m->set_keluar)) echo $m->set_keluar; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($sisa_pcs)) echo $sisa_pcs; else echo 0;?></td>
            				<td align='center'>&nbsp;<?php if(!empty($sisa_set)) echo $sisa_set; else echo 0;?></td>
                            </tr>
							<?php endforeach; }?> 
                            </tbody>
                        </table>
                        </fieldset>
                        <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                          <tr>
                            <td align="left" ><?php echo $this->pagination->create_links();//$pagination; ?></td>
                            <td align="right" style="width:75%" ></td>
                          </tr>
                        </table><div id="pager1"></div>
        		<?php }else{ ?>
            		<fieldset>
                	No Result Found
            		</fieldset>
            	<?php } ?>
         
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

