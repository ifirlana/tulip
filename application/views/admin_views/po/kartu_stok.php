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
			
			document.forms["myform"].submit();
				
		}
		
		
        </script>

</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
          <fieldset>
		<legend><strong>KARTU STOK</strong></legend>
        <form action="<?php echo base_url()?>po/kartu_stok" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
                          <table width="90%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;Tanggal</td>
                                <td><input type="text" name="datetgl" id="demo3" size="25" /><a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
                              </tr>

                             <tr>
                                <td>&nbsp;Cabang </td>
                                <?php if ($id_cabang ==1) {?>
                                <td><input type="text" name="intid_cabang" id="intid_cabang"/></td>
                                <td>&nbsp;<div id="result"></div></td>
                                <? } else { ?>
                               <td><input type="text" name="cabang" id="cabang" value="<?php echo $cabang;?>" readonly="readonly"/>
                                </td>
                                <td>&nbsp;</td>
                                <input type="hidden" name="id_cabang" id="id_cabang" value="<?php echo $id_cabang;?>"/>
								<? } ?>
                                
                            </tr>
                              <tr>
                               <td>&nbsp;Pilih Barang</td>
                                  <td><input type="text" name="intid_barang" id="intid_barang" class="id1" size="30" /> <div id="result1"></div></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                              </tr>
                              <tr>
                              	<td><input name="" type="submit" value="Proses"/></td>
                              </tr>
                              </table>
                              </form>
                              <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">
    
        </fieldset>
        <?php if (!empty($po)){?>
            <fieldset>
                <form action="<?php echo base_url()?>po/view_kartustok" method="post" id="myform">
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
			$jmlawal=0;
			$jmlmasuk=0;
			$jmlkeluar=0;
			$jmlsisa=0;
			$onceonly=0;
			foreach($po as $m) : 
		?>
        
      <tr class='data' align='center' bgcolor="#CCCCCC">
            
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_upline; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_unit; ?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_begin; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_begin; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_in; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_in; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_out; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_out; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_end; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_end; else echo 0;?></td>
            </tr>
		 <?php 
			if($onceonly == 0)
			{
		 		$jmlawal = $jmlawal + $m->intqty_begin;
				$onceonly = 1;
			}
			$jmlmasuk = $jmlmasuk + $m->intqty_in;
			$jmlkeluar = $jmlkeluar + $m->intqty_out;
			$jmlsisa = $m->intqty_end;
		 	endforeach; ?>  
			       
         <tr class='data' align='center' bgcolor="#CCCCCC">
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;Total</td>
            <td align='center'><?php if ($m->intid_jsatuan==2)  echo $jmlawal; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==1)  echo $jmlawal; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==2)  echo $jmlmasuk; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==1)  echo $jmlmasuk; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==2)  echo $jmlkeluar; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==1)  echo $jmlkeluar; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==2)  echo $jmlsisa; else echo 0;?></td>
            <td align='center'><?php if ($m->intid_jsatuan==1)  echo $jmlsisa; else echo 0;?></td>
            </tr>
		 <input type="hidden" name="id_cabang" value="<?php echo $id_cabang;?>"/>
         <input type="hidden" name="tgl" value="<?php echo $tgl?>"/>
         <input type="hidden" name="id_barang" value="<?php echo $id_barang;?>"/>
    </tbody>
</table>
<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
  <tr>
    <td align="left" ><?php //echo $pagination; ?><input id="cetak" type="button" value="Cetak" onclick="javascript:view_kartustok();"/></td>
    <td align="right" style="width:75%" ></td>
  </tr>
</table>
                    </form>
            </fieldset>
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

