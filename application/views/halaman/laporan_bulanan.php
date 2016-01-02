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
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=penjualan_bulanan.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<table width="1500" align="center">
<tr>
   	  <td width="1309" align="center">
        <table width="1500" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41">&nbsp;</td>
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
          <td colspan="2">LAPORAN PENJUALAN <?php echo $default[0]->strnama_cabang_asli;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="judul"> 
          <td colspan="2"><?php echo $default[0]->strnama_jpenjualan?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="detail">
          <td colspan="2">BULAN  <?php echo $bulan?> ( <?php echo $default[0]->datestart;?>  - <?php echo $default[0]->dateend;?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
  <tr>
    	<td align="center">
       	  <table width="1500" border="3" align="center"  class="detail">
			<tr class="detail2"> 
			 <!-- <th width="190">CABANG</th> -->
			  <th width="190">NAMA DEALER</th>
              <th width="190">UPLINE</th>
              <th width="150">UNIT</th>
            <!--  <th colspan="9">TOTAL</th>  -->
              <th colspan="9">TOTAL</th>
            </tr>
                
                <tr class="detail2">
                  <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td width="150" align="center">T</td>
                  <td width="150" align="center">M</td>
                  <td width="150" align="center">TC</td>
                  <td width="150" align="center">LG</td>
                  <td width="150" align="center">LL</td>
                  <td width="150" align="center">BRUTO</td>
                  <td width="120" align="center">DISC</td>
                  <td width="120" align="center">NETT</td>
                  <td width="70" align="center">PV</td>
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
				<tr class="detail">
                    <!-- <td align="justify"><?php echo $d->strnama_cabang?></td> -->
                    <td align="justify"><?php echo $d->strnama_dealer?></td>
                    <td align="justify"><?php echo $d->strnama_upline?></td>
                    <td align="justify"><?php echo $d->strnama_unit?></td>
                    <td align="justify"><?php 
					if(!empty($d->omsett))
					{
					if ($d->intid_jpenjualan ==4)
					{
						if (!empty($d->tradein_t)) {
							echo $d->tradein_t;
						} 
						/* else {
							echo $d->inttotal_omset;
						} */
					} else {
						echo $d->omsett ;
					}
					}
					/*
					else{
						echo ' false';
					} */?></td>
                    <td align="justify"><?php 
					if(!empty($d->omsetm))
					{
					if ($d->intid_jpenjualan ==4)
					{ 
						if (!empty($d->tradein_m)) {
							echo $d->tradein_m;
						} 
						/* else {
							echo $d->inttotal_omset;
						} */
					} else {
						echo $d->omsetm;
					}
					}?></td>
                    <td align="justify"><?php 
					if(!empty($d->omsettc))
					{
					if ($d->intid_jpenjualan ==4)
					{ 
						echo '';
						// echo $d->inttotal_omset;
					} else {
						echo $d->omsettc;
					}
					}?></td>
                    <td align="justify"><?php 
					if(!empty($d->omsetlg))
					{
					if ($d->intid_jpenjualan ==4)
					{ 
						echo $d->inttotal_omset;
					} else {
						echo $d->omsetlg;
					}
					}?></td>
                    <td align="justify"><?php 
					if(!empty($d->omsetll) and $d->omsetll > 0)
					{
					if ($d->intid_jpenjualan ==4)
					{ 
						echo $d->inttotal_omset;
					} else {
						echo $d->omsetll;
					}
					}
					?></td>
                    <td align="justify"><?php $bruto = $d->omsett + $d->omsetm + $d->omsettc + $d->omsetlg+ $d->omsetll; 
					if ($d->intid_jpenjualan ==4)
					{ 
						echo $d->inttotal_omset;
					} else {
						echo $bruto;
					}?></td>
                    <td align="justify">
					<?php 
					$disc = $d->intkomisi10 + $d->intkomisi15 + $d->intkomisi20 + $d->otherKom;
					echo $disc;?></td>
                    <td><?php 
					$nett = $d->inttotal_bayar;
					echo $nett;?></td>
                    <td><?php echo $d->intpv?></td>
                </tr>
                <?php
			if ($d->intid_jpenjualan == 4)
			{
				if(!empty($d->omsett))
				{
					if (!empty($d->tradein_t)) {
						$totalt=$totalt + $d->tradein_t;
					} 
					/* else {
						$totalt=$totalt + $d->inttotal_omset;
					} */
				}
				if(!empty($d->omsetm))
				{
					if (!empty($d->tradein_m)) {
						$totalm=$totalm + $d->tradein_m;
					} 
					/* else {
						$totalm=$totalm + $d->inttotal_omset;
					} */
				}
				if(!empty($d->omsettc))
				{
					$totaltc=$totaltc /* + $d->inttotal_omset */;
				}
				if(!empty($d->omsetlg))
				{
					$totallg=$totallg + $d->inttotal_omset;
				}
				if(!empty($d->omsetll))
				{
					$totalll=$totalll + $d->inttotal_omset;
				}
				$totalomset= $totalomset + $d->inttotal_omset;
			} else {
				$totalt=$totalt + $d->omsett;
				$totalm=$totalm + $d->omsetm;
				$totaltc=$totaltc + $d->omsettc;
				$totallg=$totallg + $d->omsetlg;
				$totalll=$totalll + $d->omsetll;
				$totalomset= $totalomset + $d->inttotal_omset;
			}
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
                  
                </tr>
                 <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="detail2">TOTAL</td>
				  <!-- <td align ="center">&nbsp;</td> -->
                  <td align="justify"><?php echo $totalt;?></td>
	              <td align="justify"><?php echo $totalm;?></td>
                  <td align="justify"><?php echo $totaltc;?></td>
                  <td align="justify"><?php echo $totallg;?></td>
                  <td align="justify"><?php echo $totalll;?></td>
                  <td align="justify"><?php $totalbruto = $totalt + $totalm + $totaltc + $totallg + $totalll; 
				  if ($d->intid_jpenjualan ==4)
					{ 
						echo $totalomset;
					} else {
						echo $totalbruto;
					}
				  ?></td>
                  <td align="justify"><?php echo $totalkomisi;?></td>
                  <td align="justify"><?php echo $totalnett;?></td>
                  <td align="justify"><?php echo $totalpv;?></td>
                </tr>
    </table>      </td>
    </tr>
</table>
</body>
</html>