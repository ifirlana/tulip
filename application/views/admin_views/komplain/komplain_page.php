   <script type="text/javascript">
   $(document).ready(function(){

   	$("#search").autocomplete(
		{
			minLength: 2,
            source:
				function(req, add)
				{
					$.ajax(
					{
						url: "<?php echo base_url(); ?>komplain/lookupBarang",
						dataType: 'json',
						type: 'POST',
						data: req,
						success:
							function(data)
							{
                                if(data.response =="true")
								{
                                    add(data.message);
									$('#label_verify').html('Pilih Dahulu');
                                }
								else if(data.response =="false")
								{
									$(this).data().term = null;
									$('#label_verify').html('Tidak Ada Data');
								}
                            },
                    });
                },
		    focus:
				function(event,ui) 
				{
					$(this).val($(this).val());
				},
			select:
				function(event, ui) 
				{
					$('#label_verify').html('Silahkan di Click \"+\"');
					inputData(ui,status);
                },
		});
   });
   </script> 
	
<div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">SJ KOMPLAIN</h2>
                    <div class="entry">                     
    <div>
        <ul style="list-style-type:none; margin:0 auto 50px -30px;">
            <li>Nomor SJ
                <ul style="list-style-type:square;">
                    <li style="font:Verdana, Geneva, sans-serif; font-size:18px;"><h3><?php echo "$no_po";?></h3></li>
                    </ul>
            </li>
        </ul>
    </div>
<div class="demo1">
	<label for="search" id="search_label">Masukan Nama Barang Tambahan</label>
	<input id="search" name="search_barang" size="50" />
	<input type="button" name="tambah" value=" + " id="btn_tambah" />
	<label id="label_verify" for="verify"></label>
</div><!-- End demo -->
<form method='post' action="<?php if(!isset($url)){echo base_url()."komplain/edit_do";}else{echo $url;}?>">
<input type="hidden" name="no_poH" id="no_po" value="<?php echo "$no_po";?>" readonly = "true"/>

<br>
<table border="1" width="100%" cellspacing=0 cellpadding=0 id="myTable">
		<tr><th colspan="5">Barang Komplain</th></tr>
		<tr> 
			<th>NAMA BARANG</th>
			<th>DIKIRIM</th>
			<th>DITERIMA</th>
			<th>KETERANGAN</th>
			<th>ACTION</th>
		</tr>
<?php 
	$cabang = 0;
	//echo "Ini Cabang ID:".$intid_cabang;
	$i=2;
if(!empty($detail) and $detail->num_rows() > 0)
{
foreach ($detail->result() as $isi):
$cabang = $isi->intid_cabang;
	if(isset($isi->intid_barang))
	{
	?>
		
			<tr>
				<td align="center"><input id ="strnama1_x" name="strnama1[]" type="text" size="30" value="<?php echo $isi->strnama;?>" readonly = "true"/></td>
				<td align="center">
					<input id="qtyubah1_x"   name="qtyubah1[]" type="text" size="10" value="<?php echo $isi->asli;?>" disabled />
					<input  name="qtyubahH1[]" type="hidden" size="5" value="<?php echo $isi->asli;?>" readonly = "true"/>
				</td>
				<td align="center">
					<input id = "qtyditerima1_x" style = "text-align: center; font-weight:bold;" name="qtyditerima1[]" type="text" size="5" value="<?php echo $isi->quantity;?>" />
					<input  name="qtyditerimaH1[]" type="hidden" size="5" value="<?php echo $isi->quantity;?>" readonly = "true"/>

				</td>
				<td align="center"><input  id="keterangan1_x" name="keterangan1[]" type="text" size="30" value="<?php echo $isi->keterangan;?>" />
					<input  name="intid_barang1[]" type="hidden" size="5" value="<?php echo $isi->intid_barang;?>" readonly = "true"/>
					<input  name="no_po1[]" type="hidden" size="10" value="<?php echo $isi->no;?>" readonly = "true"/>
					<input  name="intid_cabang1[]" type="hidden" size="5" value="<?php echo $cabang;?>" readonly = "true"/>
				</td>
				<td align="center">
					<a href="#" class="delRowBtn">Hapus</a>  
				</td>
				
			</tr>

	<?php 
	$i++;
	}
endforeach;
} ?>
		
</table>
<div class="temp_data"></div>

    <div class="description" style="margin:5px; font-size:10px;">
    <p><small>*</small>Barang terhapus jika quantity di-set menjadi 0 (nol)<small>*</small></p>
    </div><!-- End demo-description -->
	<input type="submit" name="submit" value="Cetak" />
</form>
<!-- //// -->
                      </div></div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
	<script>
	/* 
function delRow(id)
{
document.getElementById("myTable").deleteRow(2);
} */
$(function(){
    var tbl = $("#table");
	$(document.body).delegate(".delRowBtn", "click", function(){
        $(this).closest("tr").remove();        
    }); 
	});
</script>

</body>
</html>