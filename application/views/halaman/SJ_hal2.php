    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Pembuatan Surat Jalan</h2>
                    <div class="entry">                     
    <div>
        <form method='post' action="<?php echo base_url();?>POCO/Proses_SJ_STEP2">
		<input type="hidden" size="2" name="intid_week" value="<?php echo $intid_week;?>" />
<ul style="list-style-type:none; margin:0 0 0 350px;">
<li style="margin:auto auto auto -380px;">
	CAB/SC	: <?php echo $strnama_cabang_spkb;?>
	<h3>NO Surat Jalan : <?php echo $no_po;?><input type="hidden" size="2" name="no_sj" value="<?php echo $no_po;?>" /><input type="hidden" size="2" name="no_spkb" value="<?php echo $no_spkb;?>" /></h3>
    </li>
</ul>
<table style='float:right;'>
	<tr>
    	<td>Bandung</td><td>,</td><td><?php echo date('d - m - Y') ?></td>
    </tr>
	<tr>
    	<td>TANGGAL PO</td><td>:</td><td><input type="text" name="tgl_order" id="demo3" size="15" value="<?php echo $waktu;?>" readonly /></td>
    </tr>
	<tr>
    	<td>TANGGAL SJ</td><td>:</td><td><input type="text" name="tgl_kirim" id="demo4" size="15" value="<?php echo date('Y-m-d') ?>" /><a href="javascript:NewCssCal('demo4','yyyymmdd')"> <img src="<?php echo base_url();?>images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
    </tr>
	<tr>
    	<td>PENGIRIMAN VIA</td><td>:</td><td><input type="text" name="via" size="15" /></td>
    </tr>
</table>
<table border="1" width="100%" style="background-color:#FFF;">
<tr>
	<th width="3" rowspan="2">No.</th>
	<th width="30%" rowspan="2">Nama Barang</th>
	<th width="20%" colspan="2">JUMLAH</th>
	<th width="7%" rowspan="2">Quantity Terkirim</th>
	<th width="40%" rowspan="2">Keterangan</th>
</tr>
<tr>
	<th>PCS</th>
    <th>SET</th>
</tr>
<?php
	$i = 0;
	$no = $i+1; 
			$j = 0;
	$pieces = 0;
	$set = 0;
	
	$temp_intid 			= array();
	$temp_strnama	= array();
	$temp_quantity 	= array();
	$temp_keterangan	=	array();
	$starterkit						=	array(); //untuk starterkit
	
	foreach($query->result() as $row){
		echo "<tr>
			<td align='center'>".$no++."<input type='hidden' name='intid[".$i."]' value='".$row->intid_barang."' size='2' />
			<input type='hidden' name='id[".$i."]' value='".$row->id."' size='2' />
			</td>
			<td><input type='text' name='namaBarang[".$i."]' value='".$row->strnama."' size='30' disabled /></td>";
		if($row->intid_jsatuan == 2){
			$pieces = $pieces + $row->quantity;
		echo "<td align='center'>".$row->quantity."</td>
			<td align ='center'>0</td>";
		}else{
			$set = $set + $row->quantity;
		echo "<td align='center'>0</td><td align='center'>".$row->quantity."</td>";
			}
		echo "<td><input type='text' name='quantity[".$i."]' value='".$row->quantity."' size='2' /></td>
			<td><input type='text' name='keterangan[".$i."]' value='".$row->keterangan."' size='30' />
			</td>
		</tr>";
		
		$qryB= $this->db->query("SELECT starter_kit . * , (
								SELECT strnama
								FROM barang
								WHERE barang.intid_barang = starter_kit.`intid_barang`
								) AS strnama
								FROM  `starter_kit` 
								WHERE  status_barang = 1 and `intid_barang_starterkit` =  '".$row->intid_barang."'
								GROUP BY  `intid_barang` 
							");
							
			if ($qryB->num_rows() != 0){
			
				foreach($qryB->result()as $rows){
				
					$cek = $row->quantity * $rows->intquantity;
					
					$check = 0;
					for($k=0;$k<count($starterkit);$k++){
						
						if($starterkit[$k]['intid_barang'] == $rows->intid_barang){ //kalau ketemu menambahkan starterkit
							
							$starterkit[$k]['quantity']		= $starterkit[$k]['quantity']	+ $cek; //langsung ditambahkan
							$starterkit[$k]['keterangan']	=	$starterkit[$k]['keterangan']." ".$row->keterangan." ".$cek." ";
							$check = 1;
							}
						}
					if($check == 0){//kalau tidak ada sama sekali
						$starterkit[]	=	array( "intid_barang"=>$rows->intid_barang,
																			"strnama"	=> $rows->strnama,
																			"intid_jsatuan"	=>$row->intid_jsatuan,
																			"quantity"	=> $cek,
																			"keterangan"	=> $row->keterangan." ".$cek);
						}
					}
				}
		$i++;
		}
		for($k=0;$k<count($starterkit);$k++){
				
				echo "<tr>
						<td align='center'>".$no++."<input type='hidden' name='Sintid[".$k."]' value=' ".$starterkit[$k]['intid_barang']."' size='2' />
						</td>
						<td><input type='text' name='SnamaBarang[".$k."]' value=' ".$starterkit[$k]['strnama']."' size='30' disabled /></td>";
					if($starterkit[$k]['intid_jsatuan'] == 2){
					echo "<td align='center'>".$starterkit[$k]['quantity']."</td>
						<td align ='center'>-</td>";
					}else{
					echo "<td align='center'>-</td><td align='center'>".$starterkit[$k]['quantity']."</td>";
						}
					echo "<td><input type='text' name='Squantity[".$k."]' value='".$starterkit[$k]['quantity']."' size='2' /></td>
						<td><input type='text' name='Sketerangan[".$k."]' value='".$starterkit[$k]['keterangan']." utk Starterkit' size='30' />
						</td>
					</tr>";
					
				}
		echo "<tr id='content-list'><td colspan='6' align='right'>
		<input type='submit' name='submit' value='CETAK Surat Jalan' style='margin:10px;' />
		</td></tr>";
?>
</table>
<input type="hidden" id="list-data" value="<?php echo $i;?>"/>
<div class="demo" style="margin:20px;">
<div style="float:left;">CARI BARANG : </div> 
	<input id="search" name="search_barang" size="50" />
	<input type="button" name="tambah" value=" + " id="btn_tambah" />
	<label id="label_verify" for="verify"></label>
</div><!-- End demo -->
<div class="temp_data"></div>
    <div class="description">
    <p> <small>*</small> Barang terhapus jika quantity di-set menjadi 0 (nol)<small>*</small></p>
    </div><!-- End demo-description -->
</form>

                      </div></div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
	