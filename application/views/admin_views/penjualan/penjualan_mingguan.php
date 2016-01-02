<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>

<body>
<table width="1500" align="center">
<tr>
   	  <td width="1309" align="center">
        <table width="1500" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='laporan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        
        
        <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr align="center">
            
        </tr>
        <tr align="center">
         
        </tr>
        <tr align="center" class="judul">
          <td colspan="2">LAPORAN PENJUALAN <?php echo $default[0]->strnama_cabang;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="judul"> 
          <td colspan="2"><?php echo $default[0]->strnama_jpenjualan?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="2">WEEK 36 ( <?php echo $default[0]->datestart;?>  - <?php echo $default[0]->dateend;?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
  <tr>
    	<td align="center">
       	  <table width="1500" border="3" align="center"  class="detail">
			<tr class="detail2"> 
			  <th width="190">NAMA DEALER</th>
              <th width="190">UPLINE</th>
              <th width="150">UNIT</th>
              <th colspan="10">TOTAL</th>
            </tr>
                
                <tr class="detail2">
                  <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td width="150" align="left"><div align="center">T</div></td>
                  <td width="150" align="center">M</td>
                  <td width="150" align="left"><div align="center">TC</div></td>
                  <td width="150" align="left"><div align="center">SK</div></td>
                  <td width="150" align="left"><div align="center">LG</div></td>
                  <td width="150" align="left"><div align="center">LL</div></td>
                  <td width="150" align="left"><div align="center">BRUTO</div></td>
                  <td width="120" align="left"><div align="center">DISC</div></td>
                  <td width="120" align="left"><div align="center">NETT</div></td>
                  <td width="70" align="left"><div align="center">PV</div></td>
              </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
	              <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
                <?php
				$totalt=0;
				$totalm=0;
				$totaltc=0;
				$totalsk=0;
				$totallg=0;
				$totalll=0;
				$totalomset=0;
				$totalkomisi=0;
				$totalnett=0;
				$totalpv=0;
                 foreach($default as  $d):
                ?>
				<tr>
                  <td><?php echo $d->strnama_dealer?></td>
                    <td><?php echo $d->strnama_upline?></td>
                    <td><?php echo $d->strnama_unit?></td>
                    <td><?php echo "Rp. ".number_format($d->omsett,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->omsetm,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->omsettc,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->omsetsk,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->omsetlg,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->omsetll,2 , ',' , '.')?></td>
                    <td><?php echo "Rp. ".number_format($d->inttotal_omset,2 , ',' , '.')?></td>
                    <td>
					<?php 
					$disc = $d->intkomisi10 + $d->intkomisi20;
					echo "Rp. ".number_format($disc,2 , ',' , '.')?></td>
                    <td><?php 
					$nett = $d->inttotal_bayar;
					echo "Rp. ".number_format($nett,2 , ',' , '.')?></td>
                    <td><?php echo $d->intpv?></td>
                </tr>
                <?php
				$totalt=$totalt + $d->omsett;
				$totalm=$totalm + $d->omsetm;
				$totaltc=$totaltc + $d->omsettc;
				$totalsk=$totalsk + $d->omsetsk;
				$totallg=$totallg + $d->omsetlg;
				$totalll=$totalll + $d->omsetll;
				$totalomset= $totalomset + $d->inttotal_omset;
				$totalkomisi=$totalkomisi + $disc;
				$totalnett= $totalnett + $nett;
				$totalpv=$totalpv + $d->intpv; 
				endforeach;?>
                
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
	              <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
                 <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="detail2">TOTAL</td>
                  <td align="left"><?php echo "Rp. ".number_format($totalt,2 , ',' , '.');?></td>
	              <td align="left"><?php echo "Rp. ".number_format($totalm,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totaltc,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totalsk,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totallg,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totalll,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totalomset,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totalkomisi,2 , ',' , '.');?></td>
                  <td align="left"><?php echo "Rp. ".number_format($totalnett,2 , ',' , '.');?></td>
                  <td align="left"><?php echo $totalpv;?></td>
                </tr>
    </table>      </td>
    </tr>
</table>
</body>
</html>