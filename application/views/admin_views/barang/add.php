  <title>Twin Tulipware</title>
       <link rel="stylesheet" href="<?php echo base_url()?>css/ui-lightness/jquery-ui.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.theme.css" type="text/	css" media="all" />
		<script src="<?php echo base_url()?>js/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
	    <meta charset="UTF-8">
	    
	    <style>
	    	/* Autocomplete
			----------------------------------*/
			.ui-autocomplete { position: absolute; cursor: default; }	
			.ui-autocomplete-loading { background: white  url('../images/ui-anim_basic_16x16.gif')right center no-repeat; }*/

			/* workarounds */
			* html .ui-autocomplete { width:1px; } /* without this, the menu expands to 100% in IE6 */

			/* Menu
			----------------------------------*/
			.ui-menu {
				list-style:none;
				padding: 2px;
				margin: 0;
				display:block;
			}
			.ui-menu .ui-menu {
				margin-top: -3px;
			}
			.ui-menu .ui-menu-item {
				margin:0;
				padding: 0;
				zoom: 1;
				float: left;
				clear: left;
				width: 100%;
				font-size:80%;
			}
			.ui-menu .ui-menu-item a {
				text-decoration:none;
				display:block;
				padding:.2em .4em;
				line-height:1.5;
				zoom:1;
			}
			.ui-menu .ui-menu-item a.ui-state-hover,
			.ui-menu .ui-menu-item a.ui-state-active {
				font-weight: normal;
				margin: -1px;
			}
	    </style>
	    
	    <script type="text/javascript">
	    $(this).ready( function() {
    		$("#intid_barang").autocomplete({
      			minLength: 1,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>autocomplete/lookup",
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
            			"<li>"+ ui.item.value + "</li>"
            		);           		
         		},		
    		});
	    });
	    </script>
	    
	

<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>


<div id="page1">
<div id="wrapper">
	<?php $this->load->view('admin_views/header'); ?><hr />
</div>
<div id="page">
	<div id="page-bgtop">
		<div id="content">
		  <div class="post">
    <form action="<?php echo base_url()?>barang/add" method="post">
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="100%">
      <tr align="center">
        <td colspan="2" class="title">Tambah Data barang</td>
      </tr>
      <tr>
        <td>&nbsp;Nama Barang</td>
        <td><input type="text" name="strnama" size="50" /></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Barang</td>
        <td><select name="intid_jbarang">
            <option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($namajb);$i++)
				{
					echo "<option value='$idjb[$i]'>$namajb[$i]</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Satuan</td>
        <td><select name="intid_jsatuan">
            <option value="">-- Pilih --</option>
			<?php
				for($i=0;$i<count($namajs);$i++)
				{
					echo "<option value='$idjs[$i]'>$namajs[$i]</option>";
				}
			?>
        </select></td>
      </tr>
       <!--<tr>
        <td>&nbsp;Quantity</td>
        <td><input type="text" name="qty" size="10" /></td>
      </tr>-->
       <tr>
        <td>&nbsp;Harga Jawa</td>
        <td><input type="text" name="harga_jawa" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;Harga Luar jawa</td>
        <td><input type="text" name="harga_luar_jawa" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;PV Jawa</td>
        <td><input type="text" name="pv_jawa" size="5" /></td>
      </tr>
       <tr>
        <td>&nbsp;PV Luar Jawa</td>
        <td><input type="text" name="pv_luar_jawa" size="5" /></td>
      </tr>      <tr><td>&nbsp;&nbsp;</td></tr>

       <tr>
        <td colspan="2" align="center">&nbsp;<u>:: Untuk Arisan ::</u></td>
      </tr>      <tr><td>&nbsp;&nbsp;</td></tr>

       <tr>
        <td>&nbsp;Uang Muka Jawa</td>
        <td><input type="text" name="um_jawa" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;Uang Muka Luar Jawa</td>
        <td><input type="text" name="um_luar_jawa" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Jawa</td>
        <td><input type="text" name="cicilan_jawa" size="10" /></td>
      </tr>
       <tr>
        <td>&nbsp;Cicilan Luar Jawa</td>
        <td><input type="text" name="cicilan_luar_jawa" size="10" /></td>
      </tr>
       <tr>
            <th></th>
            <td><input type="submit" value="Save" class="button"/>&nbsp;
              <input class="button" type="button" value="Cancel" onclick="location.href='<?php echo base_url()?>barang';"/></td>
        </tr>
 </table>

</form>
</div>

		</div>
		<!-- end #content -->
		<?php $this->load->view('admin_views/sidebar_master'); ?><!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<!-- end #page -->
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
	<!-- end #footer -->


