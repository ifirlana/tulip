<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
            //for unit
            $(document).ready( function() {
                $("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
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
                        "<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });
				
				$("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

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
                        $("#result1").html(
                        "<input type='hidden' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "'/><input type='hidden' align='top' id='intid_dealer' name='intid_dealer' value='" + ui.item.intid_dealer + "'/>"
                    );
						$("#formSubmit").html("<input type='submit' value='Cari' class='button' id='submit'/>");
                    },
                });
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
            		$("#result3").html(
            			"<input type='hidden' id='intid_cabang' name='intid_cabang' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
			
		/*  */
		$("#formSubmit").bind("click",function(){
			
			$.ajax({
		        		url: "<?php echo base_url(); ?>website/getDataDaftarMember",
		          		type: 'POST',
		          		data: {
							intid_dealer : $("#intid_dealer").val(),
							},
						beforeSend:
						function(){
							$("#result_submit").html("Loading ..");
							},						
		          		success:    
		            	function(data){
							$("#result_submit").html(data);
		            	},
              		});
			});	
	
	});
	</script>
</div>

	<div id="page">
	<div id="page-bgtop">
		<div id="content">
        <div class="post">
          <fieldset>
		<legend><strong>DAFTAR WEBSITE PERSONAL</strong></legend>
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
            <tr>
        		<td>&nbsp;UNIT : </td>
        		<td><input type="text" name="textfield4" id="intid_unit" /><div id="result"></div></td>
     	 	</tr>
            <tr>
        		<td>&nbsp;NAMA DEALER : </td>
        		<td><input type="text" name="strnama_dealer" id="strnama_dealer"/><div id="result1"></div></td>
     	 	</tr>
            <tr>
        		<td>&nbsp;</td>
        		<td>&nbsp;</td>
            </tr>
            <tr>
           		<th></th>
            	<td id="formSubmit">&nbsp;</td>
           </tr>
		</table>	
        </fieldset>
			<div id="result_submit"></div>
		  </div>
		</div>
			
		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_member'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->

