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
	 #non-printable { 
	 border: 1px solid black;
	 float:right;
	 z-index:1000;
	 }
	body{
	font-family: "Times New Roman", Georgia, Serif;
	}
    @media print
    {
    	#non-printable { display: none; }
    	#printable {display: block; }
    }
	.detail21{
	font-size:14px;
	color:#000000;
	}
	.npen{
	font-size:14px;
	font-weight:bolder;
	color:#000000;
	text-transform: uppercase;
	}
	
</style>
</head>

<body>
<div style="width:100%;background-color:blue;display:block;">
		  <a id="non-printable" href="javascript:window.print()" onclick="location.href='<?php if(isset($back_url) and !empty($back_url)){echo $back_url;}else{echo base_url()."penjualan";}?>';"><img src="<?php echo base_url();?>/images/print.jpg"/></a>
</div>
<div id="printable">
<table width=100%   align="center" style="margin: 2%;">
	<tr class="detail21">
   	  <td colspan="2" align="center">
        <table  width=100% align="center" >
        <tr >
          <td  rowspan="1" valign="top" class="logos" ><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
     	  <td align="left" class="detail21">
			<table width=100%  >
				<tr>
				<td></td>
					<td width=60% class="detail21" >
					<span style="margin-right:2em; ">
						<?php if(isset($detail[0]['strnama_cabang'])){
							echo "<b>".strtoupper( $detail[0]['strnama_cabang']);
						  }?></span>, <?php if(isset($detail[0]['datetgl'])){
							echo date('d-m-Y', strtotime($detail[0]['datetgl']))."</b>";
						  }?>
					</td>
				</tr>
				<tr>
				<td></td>
					<td align="left" class="detail21">
						<b><span style="margin-right:2.1em; ">NAMA</span>: <?php if(isset($detail[0]['strnama_dealer'])){
					  echo "".strtoupper($detail[0]['strnama_dealer'])."</b>";}?>
					  </td>
				</tr>
				<tr  >
				<td></td>
					<td   align="left" class="detail21"><b><span style="margin-right:1.5em; ">UPLINE</span>: <?php if(isset($detail[0]['strnama_upline'])){
					  echo "".strtoupper($detail[0]['strnama_upline']."</b>");
					}?></td>
				</tr>
				<tr  >
				<td></td>
					<td align="left" class="detail21"><b><span style="margin-right:2.7em; ">UNIT</span>: <?php if(isset($detail[0]['strnama_unit'])){
					  echo "".strtoupper($detail[0]['strnama_unit'])."</b>";}?></td>
				</tr>
			</table>
		</td>
        </tr>
		<tr  >
            <td >
                <h3>NOTA NO : <?php if(isset($detail[0]['intno_nota'])){
                  echo "<b>".$detail[0]['intno_nota']."</b>";
                }?> </h3></td>
        </tr>
    </table>
    </td>
    </tr>
        
                <?php
				$totjum =0;
				$intkomisi10=0;
				$intkomisi15=0;
				$intkomisi20=0;
				$intkomisitambah=0;
				$intvoucher=0;
				$inttotal_omset=0;
				$intpv=0;
				$inttotal_bayar=0;
				$intcash=0;
				$intdp=0;
				$intdebit=0;
				$intkkredit=0;
				$persen=0;
				$intsisa=0;
				$tempvocher=0;
				$hasarr = array();
				echo "<!--  //DETAIL ".count($detail).", PAKET ".count($paket)." -->";
				if(count($detail) == 0 and count($paket) == 0)
				{
					echo "<script>window.location=\"".base_url()."laporan/viewnotaid/".$intid_nota."\"</script>";
				}
				for($i=0;$i<count($paket);$i++)
				{
					
				?>
		<tr align="center" class="judul">
            <td colspan="2">          
                <div class="npen"> <?php if(isset($titlePenjualan)){echo $titlePenjualan."<br />";}?>Nota Penjualan <?php echo $paket[$i]['judul'];?></div>
            </td>
                <td>&nbsp;</td>
        </tr>
    <tr>
    	<td colspan="2" align="center">
        	<table align="center"   style="border:thin; font-size:16px; width:100%;	font-weight:bolder; color:#121212;">
			<tr>
                	<th   class="detail21" style="  border-bottom-style: solid;">Qty</th>
              <th  class="detail21" style=" border-bottom-style: solid;">Nama Barang</th>
              <th  class="detail21" align ="right" style="  border-bottom-style: solid;">Harga</th>
              <th  class="detail21" align ="right" style="  border-bottom-style: solid;">Harga Total</th>
              </tr>
				
<?php		
					for($j=0;$j<count($detail);$j++)
					{
					$tempvocher = 	$detail[$j]['intvoucher'];
					$intvoucher += ( $detail[$j]['vochernd'] * $detail[$j]['intquantity'] );
					$inttotal_omset = $detail[$j]['inttotal_omset'];
					$intkomisi10 = $detail[$j]['intkomisi10'];
					$intkomisi15 = $detail[$j]['intkomisi15'];
					$intkomisi20 = $detail[$j]['intkomisi20'];
					$intkomisitambah = $detail[$j]['otherKom'];
					$intdp = $detail[$j]['intdp'];
					$intdebit = $detail[$j]['intdebit'];
					$intcash = $detail[$j]['intcash'];
					$intsisa = $detail[$j]['intsisa'];
					$intkkredit = $detail[$j]['intkkredit'];
					$inttotal_bayar = $detail[$j]['inttotal_bayar'];
					$persen = $detail[$j]['persen'];
					$intpv = $detail[$j]['intpv'];
					echo "<!-- alert ".$detail[$i]['id_jpenjualan']." <br />-->";
						if($paket[$i]['id_jpenjualan'] == $detail[$j]['id_jpenjualan'])
						{
							echo "
								<tr> 
									<td align='center'  class='detail21' >".$detail[$j]['intquantity']."</td>
									<td class='detail21' >".$detail[$j]['strnama']."</td>
									<td align='right' class='detail21' >".number_format($detail[$j]['intharga'])."</td>
									<td align='right' class='detail21' >".number_format($detail[$j]['intquantity'] * $detail[$j]['intharga'])."</td>
								</tr>";
							$totjum +=$detail[$j]['intquantity'] * $detail[$j]['intharga'];
							
						}
					
					}
					echo "
							<tr>
								<td>&nbsp;</td><td>&nbsp;</td>
							</tr>
							
						</table>
					
				";
				}
				echo "
							<tr style='width:60%'>
								<td  align='right' class='detail21'   ><span style='margin-right: 8em;'><b>Total : </b></span><span><b>
								 ".number_format($totjum)." </b></span></td>
								
							</tr>
							<tr>
								<td>&nbsp;</td> 
							</tr>
							<tr>
								<td>&nbsp;</td> 
							</tr>
							</td>
				</tr>
			";
			$intvoucher = $intvoucher  + $tempvocher;
				?>

<?php 
	//if($keterangan !=null)
	//{
		echo "<tr><td colspan='2'>".$keterangan."</td></tr>";
	//}
?>
    <tr>
<td colspan="2" align="center">
	
                		<table width=100% >
						<tr>
							<td rowspan="10">
								<table width = 100% align="center" >
                        <tr class="detail21">
                          <td  colspan="4" align="center" >GUDANG</td>
                          <td  colspan="4" align="center" >PEMBELI</td>
                          <td  colspan="4" align="center" >KASIR</td>
                        </tr>
                        <tr>
                          <td  colspan="4" align="right" >&nbsp;</td>
                          <td  colspan="4" align="right" >&nbsp;</td>
                          <td  colspan="4" align="right" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td  colspan="4" align="right" >&nbsp;</td>
                          <td  colspan="4" align="right" >&nbsp;</td>
                          <td  colspan="4" align="right" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td  colspan="4" align="center" >(....................)</td>
                          <td  colspan="4" align="center" >(....................)</td>
                          <td  colspan="4" align="center" >(....................)</td>
                        </tr>
                      </table>
							</td>
							<td  align="right"  >&nbsp;</td>
							<td  align="right"  >&nbsp;</td>
						</tr>
						<?php if ($intvoucher != 0 ):
						?>
               <tr class="detail21">
                 <td  align="right"  ><b>Voucher</b></td>
                 <td  align="right"  ><?php 
                // if(isset($intvoucher)){
                        echo "<b>".number_format($intvoucher)."</b>";
                  //    }?></td>
                </tr>
				<?php endif;
				if($inttotal_omset  != 0):
				?>
               <tr class="detail21">
                 <td  align="right"  ><b>Omset</b></td>
                 <td align="right"  ><?php 
                 //if(isset($inttotal_omset)){
                    echo "<b>".number_format($inttotal_omset)."</b>";
                  //}?></td>
                </tr>
				<?php endif;
				if($intpv  >= 0):
				?>
                <tr class="detail21">
                  <td align="right"  ><b>PV</b></td>
                  <td align="right"  ><?php 
                  //if(isset($intpv)){
                    echo "<b>".number_format($intpv,2)."</b>";
                  //}?></td>
                </tr>
				<?php endif;
				if($intkomisi20  != 0):
				?>
                <tr class="detail21">
                  <td  align="right"  ><b>Komisi 20%</b></td>
                  <td align="right"  ><?php 
                  if(isset($intkomisi20)){
                    echo "<b>".number_format($intkomisi20)."</b>";
                  }?></td>
                </tr>
				<?php endif;
				if($intkomisi15  != 0):
				?>
				<tr class="detail21">
                  <td  align="right"  ><b>Komisi 15%</b></td>
                  <td align="right"  ><?php 
                  if(isset($intkomisi15)){
                    echo "<b>".number_format($intkomisi15)."</b>";
                  }?></td>
                </tr>
				<?php endif;
				if($intkomisi10  != 0):
				?>
                <tr class="detail21">
                  <td  align="right"  ><b>Komisi 10%</b></td>
                  <td align="right"  ><?php 
                  if(isset($intkomisi10)){
                    echo "<b>".number_format($intkomisi10)."</b>";
                  }?></td>
                </tr>
				<?php endif;
				if($intkomisitambah  != 0):
				?>
				<tr class="detail21">
                  <td  align="right"  ><b>Komisi + <?php echo number_format($persen); ?>%</b></td>
                  <td align="right"  ><?php 
                  if(isset($intkomisitambah)){
                    echo "<b>".number_format($intkomisitambah)."</b>";
                  }?></td>
                </tr>
				<?php endif;
				//if($inttotal_bayar  != 0):
				?>
               <tr class="detail21">
                 <td  align="right"  ><b>Total Bayar</b></td>
                 <td align="right"  ><?php 
                 if(isset($inttotal_bayar)){
                  echo "<b>".number_format($inttotal_bayar)."</b>";
                  }?></td>
                </tr>
				<?php //endif;
				//if($intcash  != 0):
				?>
                <tr class="detail21">
                    <td align="right"  ><b>Cash</b></td>
                    <td align="right"  ><?php 
                    if(isset($intcash)){
                      echo "<b>".number_format($intcash)."</b>";
                    }?></td>
                </tr>
				<?php //endif;
				if($intdp  != 0):
				?>
				<tr class="detail21">
                    <td align="right"  ><b>DP</b></td>
                    <td align="right"  ><?php 
                    if(isset($intdp)){
                      echo "<b>".number_format($intdp)."</b>";
                    }?></td>
                </tr>
				<?php endif;
				if($intdebit  != 0):
				?>
                <tr class="detail21">  
                    <td align="right"  ><b>Debit</b></td>
                    <td align="right"  ><?php 
                    if(isset($intdebit)){
                      echo "<b>".number_format($intdebit)."</b>";
                    }?></td>
                </tr>
				<?php endif;
				if($intkkredit  != 0):
				?>
                <tr class="detail21">
                    <td align="right"  ><b>Credit Card</b></td>
                    <td align="right"  ><?php 
                    if(isset($intkkredit)){
                      echo "<b>".number_format($intkkredit)."</b>";
                    }?></td>
                </tr>
				<?php endif;
				if($intsisa  != 0):
				?>
                <tr class="detail21">
                    <td align="right"  ><b>Sisa</b></td>
                    <td align="right"  ><?php 
                    if(isset($intsisa)){
                      echo "<b>".number_format($intsisa)."</b>";
                    }?></td>
                </tr>
				<?php endif;
				?>
        </table>
      </td>
       </tr>
                <tr>
                	<td colspan="2" align="center">
              	      </td>
                </tr>

</table>
</div>
</body>
</html>