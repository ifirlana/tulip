<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
    <script type="text/javascript">
	   $(this).ready( function() {
    		$("#id_cabang_upline").autocomplete({
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
            			"<input type='hidden' id='intid_cabang_upline' name='intid_cabang_upline' value='" + ui.item.id + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		//for unit 
		$(this).ready( function() {
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
            		$("#result").append(
            			"<input type='text' id='intmanager' name='intmanager' value='" + ui.item.value1 + "' size='30' />",
						"<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='30' />",
						"<input type='hidden' id='strkode_manager' name='strkode_manager' value='" + ui.item.value2 + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		//for upline
		$(this).ready( function() {
			$("#strnama_upline").autocomplete({
      			minLength: 2,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>penjualan/lookupUpline",
		          		dataType: 'json',
		          		type: 'POST',
		          		//data: req,
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
            		$("#result1").append(
            			"<input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.id + "' size='30' /><img  src='<?php echo base_url()?>images/asterix3.jpg' align='absmiddle' title='Asterix'/>",
						"<input type='hidden' id='intlevel_dealer' name='intlevel_dealer' value='" + ui.item.value3 + "' size='30' />"
            		);           		
         		},		
    		});
	    });
		
		function cek()
		{
			var y = document.getElementById("strno_ktp").value;
			if(y.length<16)
			{ 
				alert('Jumlah digit No KTP kurang! Harus 16 digit.');
				return false;
			} else {
				return true;
			}
		}
	</script>
</div>
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
			<div class="post">	<h2 class="title">STARTER KIT</h2>
				<div class="entry">      
        <form id="starterkitForm" method="post" action="<?php echo base_url()?>penjualan/add">
        <div id="error"><?php echo validation_errors(); ?></div>
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
		<tr align="center">
        <td  class="title "colspan="2">Data Pribadi</td>
        </tr>
        
      <tr>
        <td>&nbsp;Nama </td>
        <td id="error"><input type="text" name="strnama_dealer" size="30" >
          <img  src="<?php echo base_url()?>images/asterix3.jpg" align="absmiddle" title="Asterix"/></td>
      </tr>
      <tr>
        <td>&nbsp;No. KTP</td>
        <td id="error"><input type="text" name="strno_ktp" id="strno_ktp" size="30"  maxlength="16" onchange="return cek();">
          <img  src="<?php echo base_url()?>images/asterix3.jpg" align="absmiddle" title="Asterix"/></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Kelamin</td>
        <td><input name="strjk" type="radio" value="PRIA" checked />PRIA<input name="strjk" type="radio" value="WANITA"/>WANITA</td>
      </tr>
      <tr>
        <td>&nbsp;Status</td>
        <td><select id="strstatus" name="strstatus">
          	<option value="KAWIN">KAWIN</option>
            <option value="TIDAK KAWIN">TIDAK KAWIN</option>
            <option value="JANDA/DUDA">JANDA/DUDA</option>
            </select>
        </td>
      </tr>
      <tr>
        <td>&nbsp;Tempat Lahir</td>
        <td><input type="text" name="strtmp_lahir" size="50" ></td>
      </tr>
      <tr>
        <td>&nbsp;Tanggal Lahir</td>
        <td><input type="text" name="datetgl_lahir" id="demo3" size="25" /><a href="javascript:NewCssCal('demo3','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
      </tr>
      <tr>
        <td>&nbsp;Alamat</td>
        <td><input type="text" name="stralamat" size="50" ></td>
      </tr>
      <tr>
        <td>&nbsp; No. Telepon</td>
        <td><input type="text" name="strtlp" size="50" >        </td>
      </tr>
      <tr>
        <td>&nbsp; Email</td>
        <td><input type="text" name="stremail" size="50" >        </td>
      </tr>
      <tr>
        <td>&nbsp; Warga Negara</td>
        <td><input type="text" name="strwarganegara" size="50" >        </td>
      </tr>
      <tr>
        <td>&nbsp; Pekerjaan</td>
        <td><input type="text" name="strwpekerjaan" size="50" >        </td>
      </tr>
      <tr>
        <td>&nbsp;Agama</td>
        <td><select id="stragama" name="stragama">
			<option value="">&nbsp;-- Pilih -- </option>
            <option value="ISLAM">&nbsp;ISLAM</option>
            <option value="KRISTEN">&nbsp;KRISTEN</option>
            <option value="KATOLIK">&nbsp;KATOLIK</option>
            <option value="HINDU">&nbsp;HINDU</option>
            <option value="BUDHA">&nbsp;BUDHA</option>
            <option value="KONGHUCU">&nbsp;KONGHUCU</option>
			</select></td>
      </tr>
      <tr align="center">
        <td  class="title "colspan="2">Data Keanggotaan</td>
        </tr>
        <tr>
        <td>&nbsp;No Kartu</td>
        <td id="error"><input type="text" name="strkode_dealer" size="30"  value="<?php echo $kode_dealer;?>" readonly="readonly"/>
          </td>
      </tr>
      <tr>
          <td>&nbsp;Cabang</td>
          <td><input type="text" name="cabang" size="20" value="<?php echo $cabang?>" readonly >
          <input type="hidden" name="intid_cabang" size="20" value="<?php echo $id_cabang?>"></td>
        </tr>
      <tr>
          <td>&nbsp;Unit</td>
          <td><input type="text" name="intid_unit" id="intid_unit" size="30" /><img  src="<?php echo base_url()?>images/asterix3.jpg" align="absmiddle" title="Asterix"/>          </td>
        </tr>
      <tr>
          <td>&nbsp;Manager</td>
          <td><div id="result"></div></td>
      </tr>
      <tr>
          <td>&nbsp;Upline</td>
          <td><input type="text" name="strnama_upline" id="strnama_upline" size="30" /><img  src="<?php echo base_url()?>images/asterix3.jpg" align="absmiddle" title="Asterix"/></td>
      </tr>
      <tr>
          <td>&nbsp;No Kartu Upline</td>
          <td><div id="result1"></div></td>
      </tr>
       <tr>
          <td>&nbsp;Telepon/HP</td>
          <td><input type="text" name="strtelp_upline" id="strtelp_upline" size="30" /></td>
      </tr>
       <tr>
          <td>&nbsp;Cabang</td>
          <td><input type="text" name="id_cabang_upline" id="id_cabang_upline" size="30" />
          <div id="result3"></div>          </td>
        </tr>
      <tr align="center">
        <td  class="title "colspan="2">Data Bank</td>
        </tr>
        <tr>
        <td>&nbsp;Nama Bank</td>
        <td><select name="intid_bank">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($strnama_bank);$i++)
				{
					echo "<option value='$intid_bank[$i]'>$strnama_bank[$i]</option>";
				}
			?>
        </select></td>
        </tr>
        <tr>
          <td>&nbsp;Nama Pemilik Rekening</td>
          <td><input type="text" name="strnama_pemilikrekening" size="30" /></td>
        </tr> 
        <tr>
          <td>&nbsp;No. Rekening</td>
          <td><input type="text" name="intno_rekening" size="30" /></td>
        </tr> 
        <tr align="center">
        <td  class="title "colspan="2">Starter Kit</td>
        </tr>
        <tr>
        <td>&nbsp;Jenis</td>
        <td>&nbsp;<select name="intid_starterkit">
          <option value="">-- Pilih --</option>
          <?php
				for($i=0;$i<count($namastarterkit);$i++)
				{
					echo "<option value='$idstarterkit[$i]'>$namastarterkit[$i]</option>";
				}
			?>
        </select></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Next" class="button"/>
              &nbsp;
              <input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/></td></tr>
</table>

        </form>
		               
                                    <div id="error"> <img  src="<?php echo base_url()?>images/asterix3.jpg" align="absmiddle" title="Asterix"/> : Wajib Diisi</div></div>
			</div></div>
			</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->
