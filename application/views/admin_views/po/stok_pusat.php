<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
       <script type="text/javascript">
                  
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
            		$("#result").append(
            		"<input type='hidden' id='intid_barang' name='intid_barang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
	
           
        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
              <div>	<h2 class="title">Stok Pusat</h2>
                    <div class="entry">
                      <form action="<?php echo base_url()?>po/stok" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
						<table width="685" border="0" id="data" align="center">
                                 <tr>
                                  <td>Barang</td>
                                  <td>&nbsp; <input type="text" name="intid_barang" id="intid_barang" size="50" />
                                  <div id="result"></div></td>
                                  <td>Week</td>
                                  <td><select name="week">
                                  <option value="">-- Pilih --</option>
                                  <?php
                                        for($i=0;$i<count($intid_week);$i++)
                                        {
                                            echo "<option value='$intid_week[$i]'>$intid_week[$i]</option>";
                                        }
                                    ?>
                                </select></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;<input type="submit"  style="background-color:#0099CC "id="search-submit" value="CARI"  onclick="cari()"/></td>
                              </tr>
                        </table>
                      </form>
    <fieldset>
					   <?php if (!empty($po)){?>
            <fieldset>
                <form>
                <table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
     
    <thead>
        <tr  align="center"  class="" bgcolor="#CCCCCC">
            <th rowspan="2">Tanggal Nota</th>
            <th rowspan="2">No Nota</th>
            <th rowspan="2">Nama Dealer</th>
            <th rowspan="2">Upline</th>
            <th rowspan="2">Unit</th>
            <th colspan="2">Stock Awal</th>
			<th colspan="2">Masuk</th>
            <th colspan="2">Keluar</th>
            <th colspan="2">Sisa</th>
	  </tr>
        <tr class="" bgcolor="#CCCCCC">
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
        </tr>    
    </thead>
    <tbody>
	   <?php 
			$i=1;
			$jmlpcsawal=0;
			$jmlsetawal=0;
			$jmlpcsmasuk=0;
			$jmlsetmasuk=0;
			$jmlpcskeluar=0;
			$jmlsetkeluar=0;
			$jmlpcssisa=0;
			$jmlsetsisa=0;
			foreach($po as $m) : 
			$sisa_pcs = ($m->pcs_awal + $m->pcs_masuk) - ($m->pcs_keluar);
			$sisa_set = ($m->set_awal + $m->set_masuk) - ($m->set_keluar);
			
		?>
        
      <tr class='data' align='center' bgcolor="#CCCCCC">
            
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_upline; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_unit; ?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->pcs_awal)) echo $m->pcs_awal; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->set_awal)) echo $m->set_awal; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->pcs_masuk)) echo $m->pcs_masuk; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->set_masuk)) echo $m->set_masuk; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->pcs_keluar)) echo $m->pcs_keluar; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($m->set_keluar)) echo $m->set_keluar; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($sisa_pcs)) echo $sisa_pcs; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($sisa_set)) echo $sisa_set; else echo 0;?></td>
      </tr>
		 <?php 
		 	$jmlpcsawal = $jmlpcsawal + $m->pcs_awal;
			$jmlsetawal = $jmlsetawal + $m->set_awal;
			$jmlpcsmasuk = $jmlpcsmasuk + $m->pcs_masuk;
			$jmlsetmasuk = $jmlsetmasuk + $m->set_masuk;
			$jmlpcskeluar = $jmlpcskeluar + $m->pcs_keluar;
			$jmlsetkeluar = $jmlsetkeluar + $m->set_keluar;
			$jmlpcssisa = $jmlpcssisa + $sisa_pcs;
			$jmlsetsisa = $jmlsetsisa + $sisa_set;
		 	endforeach; ?>         
         <tr class='data' align='center' bgcolor="#CCCCCC">
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;Total</td>
            <td align='center'>&nbsp;<?php if(!empty($jmlpcsawal)) echo $jmlpcsawal; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlsetawal)) echo $jmlsetawal; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlpcsmasuk)) echo $jmlpcsmasuk; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlsetmasuk)) echo $jmlsetmasuk; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlpcskeluar)) echo $jmlpcskeluar; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlsetkeluar)) echo $jmlsetkeluar; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlpcssisa)) echo $jmlpcssisa; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if(!empty($jmlsetsisa)) echo $jmlsetsisa; else echo 0;?></td>
      </tr>
		 
    </tbody>
</table>
<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php //echo $pagination; ?></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
            </form>
            </fieldset>
        <?php }else{ ?>
            <fieldset>
                No Result Found
            </fieldset>
            	<?php } ?>  </div>
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
