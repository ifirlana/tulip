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
<table width="1200" align="center">
	<tr>
   	  <td align="center">
        <table width="1100" height="165" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='laporan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
          <td width="41">&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        <tr>
            
        </tr>
        <tr align="center" class="judul">
            <td colspan="2">
LAPORAN PENJUALAN <?php echo $default[0]->strnama_cabang;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="judul">
          <td colspan="2"><?php echo $default[0]->strnama_jpenjualan?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="2">PERIODE <?php if ($month=='01')
		  { 
		  	echo 'JANUARI';
		  } else if ($month=='02')
		  {
		  	echo 'FEBRUARI';
		  } else if ($month=='03')
		  {
		  	echo 'MARET';
		  } else if ($month=='04')
		  {
		  	echo 'APRIL';
		  } else if ($month=='05')
		  {
		  	echo 'MEI';
		  } else if ($month=='06')
		  {
		  	echo 'JUNI';
		  } else if ($month=='07')
		  {
		  	echo 'JULI';
		  } else if ($month=='08')
		  {
		  	echo 'AGUSTUS';
		  } else if ($month=='09')
		  {
		  	echo 'SEPTEMBER';
		  } else if ($month=='10')
		  {
		  	echo 'OKTOBER';
		  } else if ($month=='11')
		  {
		  	echo 'NOVEMBER';
		  } else if ($month=='12')
		  {
		  	echo 'Desember';
		  }
		  			?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td>WEEK <?php echo $week_start[0]->intid_week;?> - <?php echo $week_end[0]->intid_week;?> ( <?php echo $week_start[0]->dateweek_start;?> - <?php echo $week_start[0]->dateweek_end;?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
    <tr>
    	<td align="center">
        	<table width="1200" border="3" align="center" class="detail">
			<tr class="detail2">
			  <th width="200">NAMA DEALER</th>
                    <th width="200">UPLINE</th>
                    <th width="100">UNIT</th>
                    <th colspan="10">TOTAL</th>
              </tr>
                
                <tr class="detail2">
                  <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td width="150" align="center">T</td>
                    <td width="150" align="center">M</td>
                    <td width="150" align="center">TC</td>
                    <td width="150" align="center">SK</td>
                    <td width="150" align="center">LG</td>
                    <td width="150" align="center">LL</td>
                    <td width="150" align="center">BRUTO</td>
                    <td width="150" align="center">DISC</td>
                    <td width="150" align="center">NETT</td>
                    <td width="50" align="center">PV</td>
                </tr>
                  <tr class="detail2">
                  <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="150" align="center">&nbsp;</td>
                    <td width="50" align="center">&nbsp;</td>
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
                  <td align="left" ><?php echo $d->strnama_dealer?></td>
                    <td align="left"><?php echo $d->strnama_upline?></td>
                    <td align="left"><?php echo $d->strnama_unit?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsett,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsetm,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsettc,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsetsk,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsetlg,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->omsetll,2 , ',' , '.')?></td>
                    <td align="left"><?php echo "Rp. ".number_format($d->inttotal_omset,2 , ',' , '.')?></td>
                    <td>
					<?php 
					$disc = $d->intkomisi10 + $d->intkomisi20;
					echo "Rp. ".number_format($disc,2 , ',' , '.')?></td>
                    <td><?php 
					$nett = $d->inttotal_omset - $disc;
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
                 <tr class="data">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
	              <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="data">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="detail2">TOTAL</td>
                  <td><?php echo "Rp. ".number_format($totalt,2 , ',' , '.');?></td>
	              <td><?php echo "Rp. ".number_format($totalm,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totaltc,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totalsk,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totallg,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totalll,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totalomset,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totalkomisi,2 , ',' , '.');?></td>
                  <td><?php echo "Rp. ".number_format($totalnett,2 , ',' , '.');?></td>
                  <td><?php echo $totalpv;?></td>
                </tr>
      </table>      </td>
    </tr>
</table>
</body>
</html>