<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
<div id="page">
        <div id="page-bgtop">
            <div id="content">
			<div class="post">	<h2 class="title">Pengiriman Kartu Member</h2>
				<p>Mencari pengiriman kartu member.</p>
				<p>
					<table id="data">
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td>Unit</td><td><input id="intid_unit" type="text" name="unit" /></td></tr>
						<tr><td>Dealer</td><td><input id="strnama_dealer" type="text" name="dealer" /></td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr id="result_lookup"></tr>
						<tr id="result_dealer"></tr>
					</table>
				</p>
			</div></div>
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
<script>
	$(document).ready(function(){
	
		//unit
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
            		$("#result_lookup").html(
            			"<td>Manager</td><td><input type='text' id='intmanager' name='intmanager' value='" + ui.item.value1 + "' readonly /><input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "'  /></td><input type='hidden' id='strkode_manager' name='strkode_manager' value='" + ui.item.value2 + "' size='30' />"
            		);           		
         		},		
    		});
		
		//dealer
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
		    focus:
				function(req,add) {
					var q = $(this).val();
					$(this).val(q);
					},
			select:
				function(event, ui) {
							$("#result_dealer").html("<td>Upline</td><td><input type='hidden' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' readonly/></td>");
                    },
                });
		});
</script>