<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
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
	</script>
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
        <fieldset>
		<legend><strong>CETAK LAPORAN KUPON</strong></legend>
        <form  method="post">            
 		<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
        	<?php /*
			 <tr>
            	<td>&nbsp;CABANG : </td>
                <?php if ($id_cabang ==1) {
				echo('<td><input type="text" name="id_cabang" id="id_cabang"/></td>
                <td>&nbsp;<div id="result3"></div></td>
				'); } else { echo('
                <td><input type="text" name="cabang" id="cabang" value="'.$cabang.'"/>
                </td>
                <td>&nbsp;</td>
                 <input type="hidden" name="intid_cabang" id="intid_cabang" value="'.$id_cabang.'" readonly="readonly"/>');
                 } ?>
               
            </tr>
            */?>
            <tr>
            	<td>&nbsp;WEEK : </td>
                <td><select name="intid_week">
                  <option value="">-- Pilih --</option>
                  <?php
                        for($i=0;$i<count($intid_week);$i++)
                        {
                            echo "<option value='".$intid_week[$i]."'>".$intid_week[$i]."</option>";
                        }
                    ?>
                </select></td>
                <td>&nbsp;<div id="result3"></div></td>
            </tr>
			 <tr>
            	<td>&nbsp;Tahun : </td>
                <td><select name="tahun">
				<?php
					foreach($tahun->result() as $row){
					/* echo "<option value='".$row->inttahun."'>".$row->inttahun."</option>"; */
					$sel = ($row->inttahun == date('Y')) ? 'selected' : '';
					echo "<option value='".$row->inttahun."' ".$sel.">".$row->inttahun."</option>";

				  }
				?>                   
                </select></td>
                <td>&nbsp;</td>
				
            </tr>
            <tr>
        		<td>&nbsp;</td>
        		<td>&nbsp;</td>
     	 	</tr>
            <tr>
           		<th></th>
            	<td><!-- <input type="submit" value="Cetak" class="button"/> -->
					<input type="submit" onclick="this.form.action='<?php echo base_url()?>Coupon/laporan';" value="submit" />
        			<input class="button" type="button" value="Cancel" onclick="location.href='sales';"/>                </td>
           </tr>
		</table>	
        </form>    
        </fieldset>
		  </div>
			</div>
			
		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_laporan'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

