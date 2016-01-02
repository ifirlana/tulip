<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Penjualan Nota</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<style>
	h3{
		color:black;
	}
</style>
</head>

<body>
<table width="1000" align="center">
	<tr class="detail2">
   	  <td colspan="2" align="center">
        <table width="1000" align="center" >
        <tr class="detail">
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203"> <?php echo $default[0]->strnama_cabang?>, <?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='<?php 
		  if(!empty($back_urls)){
				$back_url = base_url()."".$back_urls;
				}else{
				  $back_url = base_url()."penjualan";
				  }
		  echo $back_url;?>';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr class="detail">
            <td align="left" ><h3>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $default[0]->strnama_dealer?></h3></td>
            <td width="41">&nbsp;</td>
        </tr>
        <tr class="detail">
            <td   align="left"><h3>Upline&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $default[0]->strnama_upline?></h3></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="detail">
            <td align="left"><h3>Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $default[0]->strnama_unit?></h3></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="detail">
            <td colspan="2">
                <h3>NOTA NO : <?php echo $default[0]->intno_nota?> </h3></td>
                <td>&nbsp;</td>
        </tr>
        <tr align="center" class="judul">
            <td colspan="2">
                <?php
				if ($default[0]->intid_jpenjualan==1)
				{
					$judul ="Reguler";
				} else if ($default[0]->intid_jpenjualan==2)
				{
					$judul ="Chall Hut";
				} else if ($default[0]->intid_jpenjualan==3)
				{
					$judul ="Challenge";
				} else if ($default[0]->intid_jpenjualan==4)
				{
					$judul ="Trade In";
				} else if ($default[0]->intid_jpenjualan==5)
				{
					$judul ="1 Free 1 HUT";
				} else if ($default[0]->intid_jpenjualan==6)
				{
					$judul ="1 Free 1 10%";
				} else if ($default[0]->intid_jpenjualan==7)
				{
					$judul ="Netto";
				}else if ($default[0]->intid_jpenjualan==8)
				{
					$judul ="Lain-lain";
				}else if ($default[0]->intid_jpenjualan==9)
				{
					$judul ="Arisan";
				}else if ($default[0]->intid_jpenjualan==10)
				{
					$judul ="Starter Kit";
				}else if ($default[0]->intid_jpenjualan==11)
				{
					$judul ="Special Price";
				}else if ($default[0]->intid_jpenjualan==12)
				{
					$judul ="Point";
				}else if ($default[0]->intid_jpenjualan==13)
				{
					$judul ="Metal 50%";
				}else if ($default[0]->intid_jpenjualan==16)
				{
					$judul ="Diskon 40%";
				}else if ($default[0]->intid_jpenjualan==17)
				{
					$judul ="Promo Rekrut";
				}else if ($default[0]->intid_jpenjualan==18)
				{
					$judul ="Diskon 50%";
				}else if ($default[0]->intid_jpenjualan==19)
				{
					$judul ="Diskon 60% Net";
				}else if ($default[0]->intid_jpenjualan==20)
				{
					$judul ="Diskon 35%";
				}else if ($default[0]->intid_jpenjualan==21)
				{
					$judul ="Agogo";
				}else if ($default[0]->intid_jpenjualan==22)
				{
					$judul ="Serbu";
				}else if ($default[0]->intid_jpenjualan==23)
				{
					$judul ="Cepek";
				}else if ($default[0]->intid_jpenjualan==24)
				{
					$judul ="Romance";
				}else if ($default[0]->intid_jpenjualan==25)
				{
					$judul ="Big Surprise";
				}else if ($default[0]->intid_jpenjualan==26)
				{
					$judul ="Chall SC";
				}else if ($default[0]->intid_jpenjualan==27)
				{
					$judul ="Waffle Pan Special Surprise";
				}else if ($default[0]->intid_jpenjualan==28)
				{
					$judul ="Hoki Promo 75";
				}else if ($default[0]->intid_jpenjualan==29)
				{
					$judul ="Hoki Promo 150";
				}
				

				?>
                 <h3>Nota Penjualan <?php if(isset($judul)){
				 echo $judul;
				 }?></h3></td>
                <td>&nbsp;</td>
        </tr>
    </table>
    </td>
    </tr>
	<?php
		if(isset($default[0]->barcode_data) and $default[0]->intid_jpenjualan==10){
			echo "<tr>
						<td colspan='2'>";
			echo "BARCODE : ".$default[0]->barcode_data;
			echo  "</td>
					</tr>";
		}
	?>
    <tr>
    	<td colspan="2" align="center">
        	<table width="1000" border="1" align="center"  class="detail">
			<tr class="detail2">
                	<th width="132">Banyaknya</th>
              <th>Nama Barang</th>
              <th width="171">Harga</th>
              <th width="171">Jumlah</th>
              </tr><tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                $total = 0;
                foreach($default as  $d):
                    if($d->intid_jpenjualan == 11 || $d->intid_jpenjualan == 12){ 
						$harga = $d->intharga;
					} else if($d->is_free == 1){
                        $harga = 0;
                    }else{
                        if ($d->intid_wilayah==1){
							$harga = $d->intharga;
                            //$harga = $d->intharga_jawa;
                        }else {
                            $harga = $d->intharga;
							//$harga = $d->intharga_luarjawa;
                        }
                    }
                    ?>
                <tr>
                    <td align="center"  class='style-css'><?php echo $d->intquantity?></td>
                    <td align="left"  class='style-css-nama'><?php echo $d->strnama?></td>
                    <td  align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($harga,2 , ',' , '.')?></td>
                    <td  align="justify" class='style-css'><?php $jumlah = $harga * $d->intquantity; if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($jumlah,2 , ',' , '.');
                    $total = $total + $jumlah;
                    ?></td>
                </tr>
                <?php endforeach;?>

                
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="3" align="right" class="detail2"  class='style-css'>&nbsp;Jumlah &nbsp;&nbsp;&nbsp;</td>
                    <td  align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($total,2 , ',' , '.')?></td>
                </tr>
            </table>      </td>
    </tr>

    <tr>
<td colspan="2" align="center">
                		<table width="1000" border="1" align="center" class="detail">
               <tr class="detail2">
                   <td>&nbsp;</td>
                 <td width="174" align="left"  class='style-css'>Voucher</td>
                 <td width="173" align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intvoucher,2 , ',' , '.')?></td>
                </tr>
               <tr class="detail2">
               <td>&nbsp;</td>
                 <td width="174" align="left"  class='style-css'>Omset</td>
                 <td align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->inttotal_omset,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                <td>&nbsp;</td>
                  <td width="174" align="left"  class='style-css'>PV</td>
                  <td align="justify"  class='style-css'><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format($default[0]->intpv,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                <td>&nbsp;</td>
                  <td width="174" align="left"  class='style-css'>Komisi 20%</td>
                  <td align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intkomisi20,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                <td>&nbsp;</td>
                  <td width="174" align="left"  class='style-css'>Komisi 10%</td>
                  <td align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intkomisi10,2 , ',' , '.')?></td>
                </tr>
				<tr class="detail2" >
                <td>&nbsp;</td>
                  <td width="174" align="left"  class='style-css'>Komisi 15%</td>
                  <td align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intkomisi15,2 , ',' , '.')?></td>
                </tr>
				<td>&nbsp;</td>
                  <td width="174" align="left"  class='style-css'>Komisi + <?php echo number_format($default[0]->persen,2); ?>%</td>
                  <td align="justify"  class='style-css'><?php  if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->otherKom,2 , ',' , '.')?></td>
                </tr>
				<tr class="detail2">
               <td>&nbsp;</td>
                 <td width="174" align="left"  class='style-css'>Total Bayar</td>
                 <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->inttotal_bayar,2 , ',' , '.')?></td>
                </tr>


                <tr class="detail2">
                <td>&nbsp;</td>
                    <td align="left"  class='style-css'>Cash</td>
                    <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intcash,2 , ',' , '.')?></td>
                </tr>
                <td>&nbsp;</td>
                    <td align="left"  class='style-css'>DP</td>
                    <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intdp,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">  
                <td>&nbsp;</td>
                    <td align="left"  class='style-css'>Debit</td>
                    <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intdebit,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                <td>&nbsp;</td>
                    <td align="left"  class='style-css'>Credit Card</td>
                    <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intkkredit,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                <td>&nbsp;</td>
                    <td align="left"  class='style-css'>Sisa</td>
                    <td align="justify"  class='style-css'><?php if($default[0]->intid_wilayah == 3 or $default[0]->intid_wilayah == 4){echo "RM. ";}else{echo "Rp. ";} echo number_format($default[0]->intsisa,2 , ',' , '.')?></td>
                </tr>
        </table>
      </td>
       </tr>
                <tr>
                	<td colspan="2" align="center">
              	<table width="1000" align="center" >
                        <tr class="detail2">
                          <td width="229" colspan="4" align="center">GUDANG</td>
                          <td width="229" colspan="4" align="center">PEMBELI</td>
                          <td width="229" colspan="4" align="center">KASIR</td>
                        </tr>
                        <tr>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                          <td width="229" colspan="4" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="230" colspan="4" align="center">(....................)</td>
                          <td width="230" colspan="4" align="center">(....................)</td>
                          <td width="230" colspan="4" align="center">(....................)</td>
                        </tr>
                      </table>      </td>
                </tr>

</table>
</body>
</html>