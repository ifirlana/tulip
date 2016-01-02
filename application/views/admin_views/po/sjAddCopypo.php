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
            		$("#result").html(
            			"<input type='hidden' id='id_cabang' name='id_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
</script> 
                         <div id="alert"></div>
                       <form action="<?php if(isset($url)){echo $url;}?>" method="post" name="frmjual" id="frmjual">
                          <table width="100%" border="0" id="data" align="center">
                             <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>

                             <tr>
                                <td>&nbsp;Silahkan masukan nomor preorder </td>
                                <td><input type="text" name="no_po_copy"/></td>
                                <td>&nbsp;<div id="result_copy"></div></td>
                            </tr>
                             <tr>
                                <td>&nbsp;Cabang </td>
                                <td><input type="text" name="intid_cabang" id="intid_cabang"/></td>
                                <td>&nbsp;<div id="result"></div></td>
                            </tr>
                              <tr>
                              	<td><input name="" type="submit" value="Buat Surat Jalan"/></td>
                              </tr>
                              </table>
   </form>