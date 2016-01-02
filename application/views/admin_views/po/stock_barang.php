<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />  </head>

<head>
<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Twin Tulipware</title>
</head>

<body>
<div id="page1">
    <div id="wrapper">
<!-----------------------------------Kode yg manggil header----------------------------------->
<?php $this->load->view('admin_views/header'); ?><hr />
<!-------------------------------------------------------------------------------------------->
	</div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div>	<h2 class="title">Stock Barang</h2>
                    <div class="entry"><div>
						<form action="<?php echo base_url()?>po/stock_cabang" method="post" style="float:left;">
							<input type="hidden" name="halaman"  value="stock">
							<div id="error"><?php echo validation_errors(); ?></div>
							<?php echo $cabang; ?><br />
							<br />
							
							<?php if ($this->session->userdata('username') == "admin") { ?>
								<select name="cabang">
								<option value="">-- Pilih --</option>
								<?php
								for($i=0;$i<count($strnama_cabang);$i++)
								{
									echo "<option value='".$strnama_cabang[$i]."'>".$strnama_cabang[$i]."</option>";
								}
								?>
								</select>
								<input type="submit" value="Lihat stock" />
							<?php } ?>
						</form>
						</div><br /><br /><br /><br /><div>
						<form action="<?php echo base_url()?>po/kunci_stock" method="post">
							<?php if($stock_cabang != null) {
								$tgl_terakhir_so =  $stock_cabang[0]->as_of_date;
								if ($this->session->userdata('username') == "admin") { ?>
									<input type="submit" value="Kunci stock" style="float:right;" />
									<input type="hidden" name="id_cabang" style="display:none" value="<?php echo $id_cabang; ?>" />
									<select name="year" style="float:right;">
										<option value="">-- Year --</option>
										<?php
										date_default_timezone_set('Asia/Jakarta');
										
										$t = explode('-',$tgl_terakhir_so);
										$date = date('Y-m-d-H-i-s');
										$d = explode('-',$date);
										for($i = 0; $i <= $d[0]-$t[0]; $i++)
										{
											echo "<option value='".($d[0]-$i)."'>".($d[0]-$i)."</option>";
										}
										?>
									</select>
									<select name="month" style="float:right;">
										<option value="">-- Month --</option>
										<?php
										for($i = 0; $i <= $d[1]-$t[1]; $i++)
										{
											echo "<option value='".($d[1]-$i)."'>".($d[1]-$i)."</option>";
										}
										?>
									</select>
									<select name="day" style="float:right;">
										<option value="">-- Day --</option>
										<?php
										for($i = 1; $i <= 31; $i++)
										{
											echo "<option value='".$i."'>".$i."</option>";
										}
										?>
									</select>
									<input type="hidden" name="time" value="<?php echo "$d[3]:$d[4]:$d[5]" ?>" /><br /><br />
							<?php }
							} ?>
							<table cellspacing="0" cellpadding="0" border="0" width="600" style="background-color:white"><tr><td>
								<table cellspacing="0" cellpadding="1" border="1" width="600" >
									<tr>
										<th rowspan="2" width="20">ID Barang</th>
										<th rowspan="2">Nama Barang</th>
										<th colspan="2" width="50">SO awal saat tanggal <br /><?php if($stock_cabang != null) {echo $tgl_terakhir_so;} ?></th>
										<th colspan="2" width="50">Hutang barang</th>
										<th colspan="2" width="50">Stock yg masuk setelah tanggal tersebut</th>
										<th colspan="2" width="50">Stock yg keluar setelah tanggal tersebut</th>
										<th colspan="2" width="50">Stock saat ini</th>
										<th rowspan="3" width="11"></th>
									</tr>
									<tr>
										<th width="24">Set</th>
										<th width="24">Pcs</th>
										<th width="24">Set</th>
										<th width="24">Pcs</th>
										<th width="24">Set</th>
										<th width="24">Pcs</th>
										<th width="24">Set</th>
										<th width="24">Pcs</th>
										<th width="24">Set</th>
										<th width="24">Pcs</th>
									</tr>
								</table>
							</td></tr><tr><td><div style="width:600px; height:500px; overflow:auto;">
								<table cellspacing="0" cellpadding="1" border="1" width="600" style="clear:both;" >
									<?php
									$idx = 0;
									foreach($stock_cabang as  $d):
									?>
									<tr>
										<td width="41"><input type="text" name="stock[<?php echo $idx; ?>][intid_barang]" style="background:none;border:none;width:41px;" readonly value="<?php echo $d->intid_barang; ?>" /></td>
										<td><?php echo $d->strnama; ?></td>
										<td width="24"><?php echo $d->set_fisik; ?></td>
										<td width="24"><?php echo $d->pcs_fisik; ?></td>
										<td width="24"><input type="text" name="stock[<?php echo $idx; ?>][set_hutang]" style="background:none;border:none;width:24px;" readonly value="<?php echo $d->set_hutang; ?>" /></td>
										<td width="24"><input type="text" name="stock[<?php echo $idx; ?>][pcs_hutang]" style="background:none;border:none;width:24px;" readonly value="<?php echo $d->pcs_hutang; ?>" /></td>
										<td width="24"><!-- bwt diisi ama kode po pa iklas --></td>
										<td width="24"><!-- bwt diisi ama kode po pa iklas --></td>
										<td width="24"><?php echo $d->intquantity; ?></td>
										<td width="24"></td>
										<td width="24"><input type="text" name="stock[<?php echo $idx; ?>][set_fisik]" style="background:none;border:none;width:24px;" readonly value="<?php echo $d->set_fisik - $d->intquantity; ?>" /></td>
										<td width="24"><input type="text" name="stock[<?php echo $idx; ?>][pcs_fisik]" style="background:none;border:none;width:24px;" readonly value="<?php echo $d->pcs_fisik; ?>" /></td>
										<td width="11"></td>
									</tr>
									<?php
									$idx++;
									endforeach;
									?>
								</table> 
							</div></td></tr></table>
						</form></div>
                    </div>
                </div>
			</div>
        </div>
        <!-- end #content -->
<!-----------------------------------Kode yg manggil sidebar---------------------------------->
        <?php $this->load->view('admin_views/sidebar_gudang'); ?><!-- end #sidebar -->
<!-------------------------------------------------------------------------------------------->
        <div style="clear: both;">&nbsp;</div>
    </div>
</div>
<!-- end #page -->
<div id="footer-bgcontent">
<!-----------------------------------Kode yg manggil footer----------------------------------->
    <?php $this->load->view('admin_views/footer'); ?></div>
<!-------------------------------------------------------------------------------------------->
</body>
</html>
