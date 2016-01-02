    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">SURAT JALAN RETUR SPAREPART</h2>
                    <div class="entry">
<div style="display:block; width:100%;height:30px;margin:5px auto 5px auto;">
	<form method="POST" action="<?php echo base_url().'POCO/SJ3_INSERT';?>">
		<label>masukan nama cabang :</label><input type="text" name="cabang" id="cabang" /><input type="submit" name="bttnCabang" value="cari" />
		</form>
</div>
	<?php if(isset($pagination)){
		echo "<div align='center' style='margin:10px auto 10px auto; display:block;'>".$pagination."</div>";
	}else{
		echo "<small>pagination tidak aktif</small><br />";
	}?>					
    <div id="result">
<table border="1" width="100%" style="font:Verdana, Geneva, sans-serif; font-size:14px; background-color:#FFF;">
<tr>
	<th>Waktu</th>
    <th>Cabang</th>
    <th>Surat Tanda Terima Barang</th>
    <th>Perintah Cetak Sj</th>
</tr>
	<?php
    	foreach($query->result() as $row){
			echo "<tr>";
			echo "<td>".$row->waktu."</td>
				<td>".$row->strnama_cabang	."</td>
				<td> <a href='".base_url()."POCO/GET_STTB3/?no=$row->no_sttb' />".$row->no_sttb."</a></td>
				<td align='center'><a href='".base_url()."POCO/Proses_SJ3/?no=$row->no_sttb'>CETAK</a> </td>";
			echo "</tr>";
			}
	?>
   </table>


                      </div></div></div></div>
        <!-- end #content -->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
