<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?>
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
            			"<input type='hidden' id='id_cabang' name='id_cabang' value='" + ui.item.id + "' size='30' />"
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
           
		
		$("#rec1").dialog({
			autoOpen: false,
			modal: true,
			
		});
		
		function view_kartustok(){
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>po/view_kartustok',
				data: $('#frmjual').formSerialize(),
				//data:{"tes":"tes"},
				success: function(data) {
					$("#rec1").html(data);
					$('#rec1').dialog('option','width',500);
					$('#rec1').dialog('option','title','Kartu Stok');
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
        <div class="post">
          <fieldset>
		<legend><strong>KARTU STOK PUSAT</strong></legend>
        <form action="<?php echo base_url()?>po/kartu_stok" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                          <table width="90%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;Tanggal</td>
                                <td><input type="text" name="datetgl" id="demo3" size="25" /><a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
                              </tr>

                            
                              <tr>
                               <td>&nbsp;Pilih Barang</td>
                                  <td><input type="text" name="intid_barang" id="intid_barang" class="id1" size="50" /> <div id="result1"></div></td>
                                  
                              </tr>
                              <tr>
                              	<td><input name="" type="submit" value="Proses"/></td>
                              </tr>
                              </table>
          </form>
    
        </fieldset>
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