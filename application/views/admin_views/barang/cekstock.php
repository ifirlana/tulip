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
        <div class="post">
        <fieldset>
		<legend><strong>STOCK</strong></legend>
       <?php
		/* <form action="<?php echo base_url()?>laporan/cetak_keumingguan" method="post">            
 		*/
		?>
		<form action="<?php echo base_url()?>POCO/cetak_keumingguan1" method="post">            
 		<table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
        	
			<tr width=100px>
				<td width=60%></td>
				<td width=10%></td>
				<td width=10%></td>
				<td width=10%></td>
				<td width=10%></td>
			</tr>
			
            <tr>
            	<td align=right>WEEK : </td>
                <td align=left><select name="intid_week">
					  <option value="">-- Pilih --</option>
					  <?php
							for($i=0;$i<count($intid_week);$i++)
							{
								echo "<option value='$intid_week[$i]'>$intid_week[$i]</option>";
							}
						?>
					</select></td>
				<td>&nbsp;</td>	
				<td align=right>&nbsp;TAHUN : </td>
				<td align=left><select name="tahun"> 
					<?php
						foreach($tahun->result() as $row){
						$sel = ($row->inttahun == date('Y')) ? 'selected' : '';
						echo "<option value='".$row->inttahun."' ".$sel.">".$row->inttahun."</option>";
						}
					?>  
					</select>
				</td>        
				
			</tr>
			
			<tr>
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
			</tr>
			
			<tr>
				<td width=60px>Pilih Barang</td>
				<td width=10px>Set Fisik</td>
				<td width=10px>Pcs Fisik</td>
				<td width=10px>Pcs Hutang</td>
				<td width=10px>Set Hutang</td>
			</tr>
			
			<tr>
				<td><input type="text" class="txtbarang" name="txtbarang" style="width:100%;"></td>
				<td><input type="text" class="txtsetfisik" style="width:100%"></td>
				<td><input type="text" class="txtpcsfisik" style="width:100%"></td>
				<td><input type="text" class="txtsethutang" style="width:100%"></td>
				<td><input type="text" class="txtpcshutang" style="width:100%"></td>
			</tr>
			
			<tr>
				<td><input class="button" type="button" value="Submit"/></td>
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

