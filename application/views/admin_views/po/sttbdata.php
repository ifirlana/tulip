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
	
           
        </script>
    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
              <div>	<h2 class="title">STTB</h2>
                    <div class="entry">
                      <form action="<?php echo base_url()?>po/sttbdata" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
						<table width="685" border="0" id="data" align="center">
                                 <tr>
                                  <td>Cabang</td>
                                  <td>&nbsp; <input type="text" name="intid_cabang" id="intid_cabang" size="20" />
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
   <?php if (!empty($default)){?>
   <fieldset>
   <table width="200" border="0"  align="center">
  	<tr>
    <td width="677">&nbsp;
            <table width="600" height="83" border="0" align="center" id="data" class="data">
            <tr  align="center"  class="table">
           	<th width="8%">No</th>
            <th width="19%">Cabang</th>
            <th width="17%">Week </th>
            <th width="11%">No STTB</th>
			<th width="26%">Tanggal</th>
            <th width="19%">Action</th>
			</tr>
            <?php 
			$i=1;
			foreach($default as $m) : 
			
		?>         
           <tr class='data' align='center'>
            <td ><?php  echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_cabang; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intid_week; ?></td>
            <td align='center'>&nbsp;<?php echo $m->no_sttb; ?></td>
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='center'>&nbsp; <?php echo "<a href='view_sttb/$m->intid_sttb' target='_blank'>";?>View<?php echo "</a>";?></td>
          </tr>
          <?php endforeach;?>
        </table></td>
    </tr>
</table>
</fieldset>
        <?php }else{ ?>
            <fieldset>
                No Result Found
            </fieldset>
            <?php } ?>

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
