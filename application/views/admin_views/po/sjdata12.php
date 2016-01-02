<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header');  ?><hr />
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
         	focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select: 
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
              <div>	<h2 class="title"><?php if(isset($title)){ echo $title;}else{echo "Data Surat Jalan";}?></h2>
                    <div class="entry">
                      <form action="<?php if(isset($url)){ echo $url;}else{echo base_url()."po/sjdata12";}?>" method="post" name="frmjual" id="frmjual">
                            <div id="error"><?php echo validation_errors(); ?></div>
						<table width="685" border="0" id="data" align="center">
                                 <tr>
                                  <td>Cabang = &nbsp; <?php 
									if($this->session->userdata('privilege')== 1){
										if(isset($id_cabang) and $id_cabang == 102){
											echo "All Cabang";
										}else{
											echo '<input type="text" name="intid_cabang" id="intid_cabang" size="20" />';
										}
									  }else{
										echo "<input type='text' id='id_cabang' name='nama_cabang' value='".$cabang."'  disabled />
										<input type='hidden' id='id_cabang' name='id_cabang' value='".$id_cabang."' size='30' />";
								  		} ?>
								  	<br> Tanggal Awal = <input type="text" name="tgl_awal" id="tgl_awal" size="10" value="<?php echo date("Y-m-d");?>" /><a href="javascript:NewCssCal('tgl_awal','yyyymmdd')"><img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a> 
								<br>	Tanggal Akhir = <input type="text" name="tgl_akhir" id="tgl_akhir" size="10" value="<?php echo date("Y-m-d");?>" /><a href="javascript:NewCssCal('tgl_akhir','yyyymmdd')"><img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a> 

								  <div id="result"></div>
								  &nbsp;<input type="submit"  style="background-color:#0099CC "id="search-submit" value="CARI"  onclick="cari()"/>
								  </td>
                              </tr>
                        </table>
                      </form>
   <?php if (!empty($default) or !empty($default2)or !empty($default3)){
	   echo '<fieldset>
   <table width="200" border="0"  align="center">
  	<tr>
    <td width="677">&nbsp;
            <table width="600" height="83" border="0" align="center" id="data" class="data">
            <tr  align="center"  class="table">
           	<th width="8%">No</th>
            <th width="19%">Cabang</th>
            <th width="17%">Week </th>
            <th width="11%">No SJ</th>
			<th width="26%">Tanggal</th>
            <th width="19%">Action</th>
			</tr>';
			$i=1;
			foreach($default as $m) { 
			
			echo "
			   <tr class='data' align='center'>
				<td >".$i++."</td>
				<td align='left'>&nbsp;".$m->strnama_cabang."</td>
				<td align='left'>&nbsp;".$m->week_sj."</td>
				<td align='center'>&nbsp;".$m->no_sj."</td>
				<td align='left'>&nbsp;".$m->tgl_kirim."</td>
				<td align='center'>&nbsp;<a href='".base_url()."POCO/GET_SJ/?no_sj=".$m->no_sj."&no_spkb=".$m->no_spkb."' target='_blank'>	
				View</a>";
			if($id_cabang == 1 and $m->terkirim == 0){
				echo " || <a href='".base_url()."POCO/EDIT_SJ/?no_sj=".$m->no_sj."&no_spkb=".$m->no_spkb."' target='_blank'>EDIT</a>";	
			}
			echo "</td>
			  </tr>";
		  	}
			foreach($default2 as $K) { 
			echo "
			   <tr class='data' align='center'>
				<td >".$i++."</td>
				<td align='left'>&nbsp;".$K->strnama_cabang."</td>
				<td align='left'>&nbsp;".$K->week."</td>
				<td align='center'>&nbsp;".$K->no_sj."</td>
				<td align='left'>&nbsp;".$K->tgl_kirim."</td>
				<td align='center'>&nbsp;<a href='".base_url()."POCO/GET_SJ2/?no_sj=".$K->no_sj."&no_sttb=".$K->no_sttb."' target='_blank'>	
				View</a>";
			if($id_cabang == 1 and $K->terkirim == 0){
				echo " || <a href='".base_url()."POCO/EDIT_SJ2/?no_sj=".$K->no_sj."&no_sttb=".$K->no_sttb."' target='_blank'>EDIT</a>";	
			}
			echo "</td>
			  </tr>";
		  	}
			foreach($default3 as $Ke) { 
			echo "
			   <tr class='data' align='center'>
				<td >".$i++."</td>
				<td align='left'>&nbsp;".$Ke->strnama_cabang."</td>
				<td align='left'>&nbsp;".$Ke->week."</td>
				<td align='center'>&nbsp;".$Ke->no_sj."</td>
				<td align='left'>&nbsp;".$Ke->tgl_kirim."</td>
				<td align='center'>&nbsp;<a href='".base_url()."POCO/GET_SJ3/?no_sj=".$Ke->no_sj."&no_sttb=".$Ke->no_sttb."' target='_blank'>	
				View</a>";
			if($id_cabang == 1 and $Ke->terkirim == 0){
				echo " || <a href='".base_url()."sparepart_garansi/EDIT_SJ_SPAREPART/?no_sj=".$Ke->no_sj."&no_sttb=".$Ke->no_sttb."' target='_blank'>EDIT</a>";	
			}
			echo "</td>
			  </tr>";
		  	}
		  echo "</table></td>
				</tr>
			</table>
			</fieldset>"; 
		}else{ 
            echo "<fieldset>
                No Result Found
            </fieldset>";
             } ?>
                </div>
                </div></div>
        </div>
        <!-- end #content -->
       
        <?php $this->load->view("admin_views/sidebar_gudang_adi") ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>