    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">BUAT PO</h2>
                    <div class="entry">                     
    <div>
        <ul style="list-style-type:none; margin:0 auto 50px -30px;">
            <li>Nomor PO Barang
                <ul style="list-style-type:square;">
                    <li style="font:Verdana, Geneva, sans-serif; font-size:18px;"><h3><?php echo $no_po;?></h3></li>
                    </ul>
            </li>
        </ul>
    </div>
<div class="demo1">
	<label for="search" id="search_label">Masukan Nama Barang </label>
	<input id="search" name="search_barang" size="50" />
	<input type="button" name="tambah" value=" + " id="btn_tambah" />
	<label id="label_verify" for="verify"></label>
</div><!-- End demo -->
<form method='post' action="<?php if(!isset($url)){echo base_url()."POCO/proses_po";}else{echo $url;}?>">
<input type="hidden" name="no_po" id="no_po" value="<?php echo $no_po;?>" readonly = "true"/>
<input type="hidden" name="intid_week" value="<?php echo $intid_week;?>" size="2"/>
<input type="hidden" name="intid_cabang" value="<?php echo $intid_cabang;?>" size="2" />
<?php 
if(isset($content))
{
	echo $content;
}
?>
<div class="temp_data"></div>
    <div class="description" style="margin:5px; font-size:10px;">
    <p><small>*</small>Barang terhapus jika quantity di-set menjadi 0 (nol)<small>*</small></p>
    </div><!-- End demo-description -->
    <span class="input-submit" style="margin:auto auto 50px auto;"></span><font color="red"><span class="simpan-submit" style="padding:3px;margin:auto auto 50px auto;background:white;"></span></font>
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
</body>
</html>