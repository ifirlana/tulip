<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
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
		
		function check_all(val) {
			var checkbox = document.myform.elements['pilih[]'];
			if ( checkbox.length > 0 ) {
				for (i = 0; i < checkbox.length; i++) {
					if ( val.checked ) {
						checkbox[i].checked = true;
					}
					else {
						checkbox[i].checked = false;
					}
				}
			}
			else {
				if ( val.checked ) {
					checkbox.checked = true;
				}
				else {
					checkbox.checked = false;
				}
			}
		}
		
		function cek(){
		var x=0;
		for (var i=0;i < document.myform.elements.length;i++)
		{
			var e = document.myform.elements[i];
			
			if (e.type == 'checkbox')
			{
				if(e.checked){
					x++;
				}
			}
		}
		
		if(x > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function save_data(){
		
		var isi = document.getElementById('detail').innerHTML;

		if( isi == false){
			document.getElementById('alert').innerHTML = '<ul class="message error grid_12"><li>Harus ada data yang diceklis</li><li class="close-bt"></li></ul><br>';
		}else{
			document.getElementById('alert').innerHTML = '';
			if(cek()){
				document.forms["myform"].submit();
			}else{
				document.getElementById('alert').innerHTML = '<ul class="message error grid_12"><li>Harus ada data yang diceklis</li><li class="close-bt"></li></ul><br>';
			}
			
		}
		
	}
</script>

</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">  <h2 class="title"> Surat Jalan</h2>
                         <div id="alert"></div>
                       <form action="<?php echo base_url()?>po/sjr" method="post" name="frmjual" id="frmjual">
                          <table width="90%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>

                             <tr>
                                <td>&nbsp;Cabang </td>
                                <td><input type="text" name="intid_cabang" id="intid_cabang"/></td>
                                <td>&nbsp;<div id="result"></div></td>
                            </tr>
                              <tr>
                              	<td><input name="" type="submit" value="Proses"/></td>
                              </tr>
                              </table>
   </form>
   <form action="<?php echo base_url()?>po/buat_sjr" method="post" name="myform" id="myform">  
    <?php if (!empty($default)){?>
    <table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
    <tr align="center" class="" bgcolor="#CCCCCC">
        <th>&nbsp;</th>
        <th>SRB</th>
        <th>Cabang</th>
    </tr>
    <tbody id="detail">
		<?php 
			$i=1;
			foreach($default as $m) : 
		?>
        <tr class='data' align='center' bgcolor="#CCCCCC">
        <td><input type="checkbox" name="pilih[]" value="<?php echo $m->intid_retur;?>" /></td>
        <td><?php echo $m->no_srb; ?></td>
        <td><?php echo $m->strnama_cabang; ?><input type="hidden" name="intid_cabang" value="<?php echo $m->intid_cabang;?>"/></td>
        </tr>	
        <?php 
		$i++;
		endforeach; ?>				
		<tr>
        <td colspan="3"><input type="checkbox" onclick="check_all(this)" />Select All/Unselect All<br /></td>
        </tr>
    </tbody>
</table>
<?php }?>
<input name="" type="button" onclick="javascript:save_data();" value="Buat Surat Jalan"/>
</form>
   </div>
	  </div>
			
	  </div>
		<?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

