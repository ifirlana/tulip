<div id="wrapper">
<form method='post' action="<?php echo base_url();?>POCO/proses_po">
    <div>
        <ul style="list-style-type:none;">
            <li>Nomor Pre Order 
                <ul style="list-style-type:square">
                    <li><input type="text" name="no_po" id="no_po" value="<?php echo $no_po;?>" readonly = 	"true"/><input type="text" name="intid_week" value="<?php echo $intid_week;?>" size="2"/><input type="text" name="intid_cabang" value="<?php echo $intid_cabang;?>" size="2" /></li>
                    </ul>
            </li>
        </ul>
    </div>
<div class="demo">
	<label for="search">Search: </label>
	<input id="search" name="search_barang" size="50" />
	<input type="button" name="tambah" value=" + " id="btn_tambah" />
	<label id="label_verify" for="verify"></label>
</div><!-- End demo -->
<div class="temp_data"></div>
    <div class="description">
    <p> <small>*</small> Barang terhapus jika quantity di-set menjadi 0 (nol)<small>*</small></p>
    </div><!-- End demo-description -->
    <div class="input-submit"></div>
</form>
</div>
</body>
</html>
