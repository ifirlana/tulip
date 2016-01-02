    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">BUAT SPKB DARI PO</h2>
                    <div class="entry">                     
    <div>

<label>Masukan Cabang</label>
<input type="text" name="cabang" id="cabang" class="cabang" />
<input type="button" name="spkb_button" id="spkb_button" class="spkb_button" value="search" />
<div id="result"><?php echo $tampilkan; ?></div>
</body>
<script type="text/javascript">   
	$('.spkb_button').click(function(){
				var json_data = {
						strnama_cabang	:	$('.cabang').val(),
						intid_week	:	<?php echo $intid_week;?>,
						ajax : 1
						}
								$.ajax({
										   url	:	"<?php echo base_url()."POCO/FORM_SPKB_RESULT";?>",
										   type : 'POST',
										   data : json_data,
										   success:function(data){
											   $('#result').html(data);
											   },
										   }); 
									});
    </script>
</html>

                      </div></div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
