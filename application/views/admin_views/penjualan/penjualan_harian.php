<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Penjualan Harian</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>

<body>
      <table width="1330" align="center" > 
         <td width="70" align="right">&nbsp;<a href="javascript:window.print()" onclick="location.href='laporan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>

      </table>
<table width="1330" align="center">
<tr>
   	  <td align="center">

      <table width="1330" align="center">
        <tr>
          <td width="1001" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="97">&nbsp;</td>
          <td width="142"></td>

        </tr>
        <tr class="detail2">
          <td >CABANG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
          <td width="142">&nbsp;
              <?php    echo $default[0]->strnama_cabang?></td>
        </tr>
        <tr class="detail2">
          <td >Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
          <td width="142">&nbsp;<?php echo date('d-m-Y', strtotime($default[0]->tgl))?></td>
        </tr>
        <tr class="detail">
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center"><span class="judul"><strong>LAPORAN PENJUALAN HARIAN</strong></span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="3" ><div align="center" class="judul"></div></td>
        </tr>
      </table>          
</td>
  <tr>
    	<td align="center">
        	<table width="1330" border="1" align="center"  class="detail">
<tr class="detail2">
                	<th width="90"><strong>NO NOTA</strong></th>
              <th width="190"><strong>NAMA DEALER</strong></th>
                    <th width="190"><strong>UPLINE</strong></th>
                    <th width="150"><strong>UNIT</strong></th>
                    <th width="190"><strong>OMSET</strong></th>
                    <th width="190"><strong>SK</strong></th>
                    <th width="190"><strong>LG</strong></th>
                    <th width="190"><strong>LL</strong></th>
                    <th width="190"><strong>NETTO</strong></th>
			</tr>
                <tr class="data">
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left" class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                </tr>
                <?php
                $totalcash = 0;
				$totaldebit= 0;
				$totalkkredit = 0;
				$totaldp = 0;
				$total = 0;
                foreach($default as  $d):
                ?>
              
                 
                <tr class="data">
                    <td align="left"  class="detail"><?php echo $d->intno_nota?></td>
                    <td align="left"  class="detail"><?php echo $d->strnama_dealer?></td>
                    <td align="left"  class="detail"><?php echo $d->strnama_upline?></td>
                    <td align="left"  class="detail"><?php echo $d->strnama_unit?></td>
                    <td align="left"  class="detail"><?php echo "Rp. ".number_format($d->inttotal_omset,2 , ',' , '.')?></td>
                    <td align="left" class="detail"><?php echo "Rp. ".number_format($d->sk,2 , ',' , '.')?></td>
                    <td align="left"  class="detail"><?php echo "Rp. ".number_format($d->lg,2 , ',' , '.')?></td>
                    <td align="left"  class="detail"><?php echo "Rp. ".number_format($d->ll,2 , ',' , '.')?></td>
                    <td align="left"  class="detail"><?php echo "Rp. ".number_format($d->inttotal_bayar,2 , ',' , '.')?></td>
                </tr>
                <?php 
				$totalcash = $totalcash + $d->intcash;
				$totaldebit = $totaldebit + $d->intdebit;
				$totalkkredit = $totalkkredit + $d->intkkredit;
				$totaldp = $totaldp + $d->intdp;
				$total = $totalcash + $totaldebit + $totalkkredit + $totaldp;
				endforeach;?>
                  <tr class="data">
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left" class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                </tr>
                  
				
                <tr class="data">
                    <td colspan="4" align="center"  class="detail2">GRAND TOTAL</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left" class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                    <td align="left"  class="detail">&nbsp;</td>
                </tr>
      </table>      </td>
    </tr>

    <tr class="detail">
<td align="center">
                	<table width="1330" border="0" align="center" >
                <tr class="detail">
                	<td width="227">&nbsp;</td>
                    <td width="772">&nbsp;</td>
                    <td width="152" ></td>
                    <td width="161" ></td>
                </tr>
                      <tr class="detail">
                	<td width="227">&nbsp;</td>
                    <td width="772">&nbsp;</td>
                    <td width="152" class="detail"><div align="left">CASH</div></td>
                    <td width="161" class="detail"><?php echo "Rp. ".number_format($totalcash,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail">
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="detail"><div align="left">DEBIT</div></td>
                    <td class="detail"> <?php echo "Rp. ".number_format($totaldebit,2 , ',' , '.')?></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="detail"><div align="left">CREDIT CARD</div></td>
                    <td class="detail"><?php echo "Rp. ".number_format($totalkkredit,2 , ',' , '.')?></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="detail"><div align="left">DP</div></td>
                    <td class="detail"><?php echo "Rp. ".number_format($totaldp,2 , ',' , '.')?></td>
                </tr>
                <tr class="detail">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="detail"><div align="left"><strong>TOTAL</strong></div></td>
                  <td class="detail"><?php echo "Rp. ".number_format($total,2 , ',' , '.')?></td>
                </tr>
      </table>      </td>
       </tr>
</table>
</body>
</html>