<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php $this->load->helper('HTML');
	echo link_tag('css/style2.css');
	echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<style>
	div.page{
		padding:10px;
		font-size:14px;
		letter-spacing:3.5px;
	}
	div.header{
		margin-top:5px;
		margin-bottom:5px;
		overflow:hidden;
		font-weight:bold;
	}
	div.header div{
		margin-top:10px;
	}
	div.header div div{
		margin-top:0px;
		padding-right:5px;
	}
	div.header div div.label{
		width:70px;
	}
	div.header div div.colon{
		width:10px;
	}
	div.header div div.value{
		width:300px;
	}
	div.content{
		margin-right:20px;
		display:block;
		float:left;
		text-align:left;
	}
	div.content div div.left{
		float:left;
		margin-left:10px;
	}
	div.content div div.right{
		float:right;
		margin-right:10px;
	}
	div.content div div.harga{
		width:150px;
	}
	div.content div div.bayar{
		width:250px;
	}
	div.highlight{
		font-weight:bold;
		font-size:18px;
	}
	div.block{
		margin-top:3px;
		overflow:hidden;
	}
	div.block div{
		width:150px;
	}
	div.block div, div.header div{
		display:block;
		float:left;
		text-align:left;
	}
</style>
</head>
<body>
<?php /*
<div class="page">
	<div class="header">
		<div><img width="120px" src="<?php echo base_url();?>images/logo.jpg" /></div>
		<div style="margin-left:30px;margin-right:100px;">
			<span>
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
				}
				?>
				Nota&nbsp Pembayaran&nbsp <?php echo $judul;?>
			</span>
			<br/>
			<br/>
			<br/>
			NOTA&nbsp NO&nbsp :&nbsp <?php echo $default[0]->intno_nota?>
		</div>
		<div>
			<div><?php echo $default[0]->strnama_cabang?>, <?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></div>
			<div class="block" style="clear:both;">
				<div class="label">Nama</div><div class="colon">:</div><div class="value"><?php echo $default[0]->strnama_dealer?></div><br/>
				<div class="label">Upline</div><div class="colon">:</div><div class="value"><?php echo $default[0]->strnama_upline?></div><br/>
				<div class="label">Unit</div><div class="colon">:</div><div class="value"><?php echo $default[0]->strnama_unit?></div><br/>
			</div>
		</div>
		<div style="width:20px;margin-left:50px"><a href="javascript:window.print()" onclick="location.href='../../../../../bayar_arisan';"><img width="30px" src="<?php echo base_url();?>/images/print.jpg"/></a></div>
	</div>
	<div class="content" style="width:700px;">
		<div class="header" style="border-bottom: 1px solid #000;">
			<div class="left" style="width:40px;">Qty</div>
			<div class="left" style="width:320px;">Nama Barang</div>
			<div class="right harga">Jumlah</div>
			<div class="right harga">Harga</div>
		</div>
		<?php
			$total = 0;
			foreach($default as  $d):
				if($d->intid_jpenjualan == 11 || $d->intid_jpenjualan == 12){ 
					$harga = $d->intharga;
				} else if($d->is_free == 1){
					$harga = 0;
				}else{
					if ($d->intid_wilayah==1){
						$harga = $d->intharga_jawa;
					}else {
						 $harga = $d->intharga_luarjawa;
					}
				}
		?>
		<div class="block">
			<div class="left" style="width:40px;"><?php echo $d->intquantity?></div>
			<div class="left" style="width:320px;"><?php echo $d->strnama?></div>
			<div class="right harga"><?php $jumlah = $harga * $d->intquantity; echo "Rp. ".number_format($jumlah,0 , ',' , '.');
                    $total = $total + $jumlah;
				?>
			</div>
			<div class="right harga"><?php echo "Rp. ".number_format($harga,0 , ',' , '.')?></div>
		</div>
		<?php endforeach;?>
		<div class="block" style="float:right;border-top-style:double;margin-top:10px;">
			<div class="right harga"><?php echo "Rp. ".number_format($total,0 , ',' , '.')?></div>
			<div class="right harga">Total</div>
		</div>
	</div>
	<div class="content" style="margin-left:10px;margin-top:30px;">
		<div class="block highlight">
			<div>Omset</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->inttotal_omset,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>PV</div>
			<div class="bayar"><?php echo "".number_format($default[0]->intpv,2 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Cicilan</div>
			<div class="bayar"><?php $cicil = ($cicilan*$default[0]->intquantity); echo "Rp. ".number_format(0,2 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Komisi 20%</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intkomisi20,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Komisi 10%</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intkomisi10,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Cash</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intcash,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Debit</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intdebit,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Credit Card</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intkkredit,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div>Sisa</div>
			<div class="bayar"><?php echo "Rp. ".number_format($default[0]->intsisa,0 , ',' , '.')?></div>
		</div>
		<div class="block">
			<div style="font-size:8px;width:300px;">*Barang yg sudah dibeli tidak dapat ditukarkan/dikembalikan</div>
		</div>
	</div>
	<div style="clear:both;padding-top:10px;">
		<div class="block" style="float:left;margin-left:65px;">
			<div style="text-align:center;">(PEMBELI)</div>
		</div>
		<div class="block" style="float:left;margin-left:65px;">
			<div style="text-align:center;">(KASIR)</div>
		</div>
		<div class="block" style="float:left;margin-left:65px;">
			<div style="text-align:center;">(GUDANG)</div>
		</div>
	</div>
</div>
*/
?>
<table width="800" align="center" class="detail">
	<tr class="detail2">
   	  <td colspan="2" align="center">
        <table width="800" align="center" >
        <tr class="detail2">
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203"> <?php echo $default[0]->strnama_cabang?>, <?php echo date('d-m-Y')?></td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='../../../../../bayar_arisan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr>
            <td align="justify"> Nama&nbsp;&nbsp;: <?php echo $default[0]->strnama_dealer?></td>
            <td width="41">&nbsp;</td>
        </tr>
        <tr>
            <td> Upline&nbsp;&nbsp;: <?php echo $default[0]->strnama_upline?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td> Unit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $default[0]->strnama_unit?> </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" class="detail">
                NOTA  NO. : <?php echo $default[0]->intno_nota?>        	</td>
                <td>&nbsp;</td>
        </tr>
        <tr align="center">
            <td colspan="2" class="judul" align="center">
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
				} else if ($default[0]->intid_jpenjualan==9)
				{
					$judul ="Arisan";
				}

				?>
                 Nota Pembayaran <?php echo $judul;?></td>
                <td>&nbsp;</td>
        </tr>
    </table>
    </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<table width="800" border="1" align="center"  class="detail">
			<tr class="detail2">
                	<th>Banyaknya</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr><tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                $total = 0;
                foreach($default as  $d):
                    if($d->is_free == 1){
                        $harga = 0;
                    }else{
                        if ($d->intid_wilayah==1){
                            $harga = $d->intharga_jawa;
							$cicilan = $d->intcicilan_jawa;
                        }else {
                            $harga = $d->intharga_luarjawa;
							$cicilan = $d->intcicilan_luarjawa;
                        }
                    }
                    ?>
                <tr>
                    <td align="center"  class='style-css'><?php echo $d->intquantity?></td>
                    <td align="left"  class='style-css-nama'><?php echo $d->strnama?></td>
                    <td  align="justify"  class='style-css'><?php echo "Rp. ".number_format($harga,2 , ',' , '.')?></td>
                    <td align="justify"  class='style-css'><?php $jumlah = $harga * $d->intquantity; echo "Rp. ".number_format($jumlah,2 , ',' , '.');
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
                	<td colspan="3" align="right" class="detail">&nbsp;Jumlah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="justify"><?php echo "Rp. ".number_format($total,2 , ',' , '.')?></td>
                </tr>
            </table>      </td>
    </tr>

    <tr>
<td colspan="2" align="center">
                		<table width="800" border="1" align="center" class="detail">
               <tr class="detail2">
                    <td width="170" align="center">&nbsp;</td>
                    <td width="268" align="center">&nbsp;</td>
                    <td width="114" align="left">Omset</td>
                    <td align="justify"><?php //echo "Rp. ".number_format($default[0]->inttotal_omset *$default[0]->intquantity* $sisa,2 , ',' , '.')?><?php echo "Rp. ".number_format($default[0]->inttotal_omset,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                    <td width="170" align="center">&nbsp;</td>
                    <td width="268" align="center">&nbsp;</td>
                    <td width="114" align="left">PV</td>
                    <td><?php //echo "&nbsp;&nbsp;&nbsp;&nbsp;".number_format($default[0]->intpv *$default[0]->intquantity* $sisa,2 , ',' , '.')?><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".number_format($default[0]->intpv ,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                    <td width="170" align="center">&nbsp;</td>
                    <td width="268" align="center">&nbsp;</td>
                    <td width="114" align="left">Cicilan</td>
                    <td align="justify"><?php 
					$cicil = ($cicilan*$default[0]->intquantity);
					echo "Rp. ".number_format(0,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                    <td width="170" align="center">&nbsp;</td>
                    <td width="268" align="center">&nbsp;</td>
                    <td width="114" align="left">Komisi 20%</td>
                    <td align="justify"><?php //echo "Rp. ".number_format($default[0]->intkomisi20 *$default[0]->intquantity * $sisa,2 , ',' , '.')?><?php echo "Rp. ".number_format($default[0]->intkomisi20,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                    <td width="170" align="center">&nbsp;</td>
                    <td width="268" align="center">&nbsp;</td>
                    <td width="114" align="left">Komisi 10%</td>
                    <td align="justify"><?php //echo "Rp. ".number_format($default[0]->intkomisi10 *$default[0]->intquantity * $sisa,2 , ',' , '.')?><?php echo "Rp. ".number_format($default[0]->intkomisi10,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left">Cash</td>
                    <td align="justify"><?php 
					//$cash = $cicil - ($default[0]->intkomisi20 * $sisa) - ($default[0]->intkomisi10 * $sisa);
					echo "Rp. ".number_format(0,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">  
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left">Debit</td>
                    <td align="justify"><?php echo "Rp. ".number_format($default[0]->intdebit,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left">Credit Card</td>
                    <td align="justify"><?php echo "Rp. ".number_format($default[0]->intkkredit,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail2">
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left">Sisa</td>
                    <td align="justify"><?php echo "Rp. ".number_format($default[0]->intsisa,2 , ',' , '.')?></td>
                </tr>
        </table>
      </td>
       </tr>
                <tr>
                	<td colspan="2" align="center">
              	<table width="800" align="center" class="detail">
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