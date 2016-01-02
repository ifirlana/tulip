<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Pembayaran Mingguan</title><?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

</head>

<body>
<table width="754" align="center">
	<tr class="detail2">
   	  <td align="center">
        <table width="754" align="center" >
        <tr>
          <td width="440" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td align="right"><a href="javascript:window.print()" onclick="location.href='laporan/keuangan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
     	  </tr>
    </table>  
        <table width="754" align="center" class="detail" border="0">
        
        
         <tr align="center">
            <td class="judul"><p align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LAPORAN PEMBAYARAN MINGGUAN <?php echo $cabang;?></strong></p>
</td>
          </tr>
          <tr align="center">
          <td colspan="0">WEEK <?php echo $week[0]->intid_week;?> (<?php echo $week[0]->dateweek_start;?> - <?php echo $week[0]->dateweek_end;?>)</td>
         </tr>
    </table>   </td>
    <tr class="detail">
    	<td align="center">
        	<table width="754" border="0" align="center"  class="detail">
			 <?php
               	 $treguler = 0;
				 $thut = 0;
				 $tchallenge = 0;
				 $tfreehut = 0;
				 $tfree = 0;
				 $ttrade = 0;
				 $tnetto = 0;
				 $tarisan = 0;
				 $tstlhkomisi = 0;
				 $tlain = 0;
				 if ($reguler->num_rows() > 0):
					foreach ($reguler->result() as $row):
			?>
            <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN REGULER :
              <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
              <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr >
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN REGULER</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $treguler = $treguler + $row->omsettulip + $row->omsetmetal + $row->omsettc; echo "Rp. ".number_format($treguler,2 , ',' , '.')?> </td>
                </tr>
               <?php 
			   	 	endforeach;
				 endif;
				 if ($hut->num_rows() > 0):
					foreach ($hut->result() as $row1):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN HUT :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row1->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row1->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row1->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN HUT</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $thut = $thut + $row1->omsettulip + $row1->omsetmetal + $row1->omsettc ; echo "Rp. ".number_format($thut,2 , ',' , '.')?> </td>
                </tr>
             <?php 
			   	 	endforeach;
				 endif;
				 if ($challenge->num_rows() > 0):
					foreach ($challenge->result() as $row2):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN CHALLENGE :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row2->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row2->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row2->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN CHALLENGE</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tchallenge = $tchallenge + $row2->omsettulip + $row2->omsetmetal + $row2->omsettc ; echo "Rp. ".number_format($tchallenge,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 endif;
				 if ($free->num_rows() > 0):
					foreach ($free->result() as $row3):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN 1 FREE 1 :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row3->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row3->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row3->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN 1 FREE 1</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tfree = $tfree + $row3->omsettulip + $row3->omsetmetal + $row3->omsettc ; echo "Rp. ".number_format($tfree,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 endif;
				 if ($freehut->num_rows() > 0):
					foreach ($freehut->result() as $row4):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN 1 FREE 1 HUT:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row4->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row4->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row4->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN 1 FREE 1 HUT</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tfreehut = $tfreehut + $row4->omsettulip + $row4->omsetmetal + $row4->omsettc ; echo "Rp. ".number_format($tfreehut,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 endif;
				 if ($netto->num_rows() > 0):
					foreach ($netto->result() as $row5):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN NETTO:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr>
                    <td class="data">&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row5->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row5->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;TULIP CARE</td>
                  <td>&nbsp;<?php echo "Rp. ".number_format($row5->omsettc,2 , ',' , '.')  ?><hr /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN NETTO</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tnetto = $tnetto + $row5->omsettulip + $row5->omsetmetal + $row5->omsettc ; echo "Rp. ".number_format($tnetto,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 endif;
				 if ($trade->num_rows() > 0):
					foreach ($trade->result() as $row6):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN TRADE IN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;T30</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row6->omsett30,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;T50</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row6->omsett50,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                	<td class="detail2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN TRADE IN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $ttrade = $ttrade + $row6->omsett30 + $row6->omsett50; echo "Rp. ".number_format($ttrade,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 endif;
				 if ($arisan->num_rows() > 0):
					foreach ($arisan->result() as $row7):
			?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN ARISAN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row7->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row7->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN ARISAN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tarisan = $tarisan + $row7->omsettulip + $row7->omsetmetal; echo "Rp. ".number_format($tarisan,2 , ',' , '.')?> <hr /></td>
                </tr>
                <?php endforeach; endif;?>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRAND TOTAL OMSET</td><td>&nbsp;</td>
                    <td>&nbsp;<?php
				   
				 $tsementara = $treguler + $thut + $tchallenge + $tfreehut + $tfree + $ttrade + $tarisan + $tnetto; echo "Rp. ".number_format($tsementara,2 , ',' , '.')?></td>
               	   
              </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>KOMISI 10%</td>
                   	<td>&nbsp;<?php echo "Rp. ".number_format($komisi[0]->komisi10,2 , ',' , '.')?> </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>KOMISI 20%</td>
                   	<td>&nbsp;<?php echo "Rp. ".number_format($komisi[0]->komisi20,2 , ',' , '.')?> <hr /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
               	  <td>&nbsp;<?php $tstlhkomisi = $tstlhkomisi + $tsementara - $komisi[0]->komisi10 - $komisi[0]->komisi20; echo "Rp. ".number_format($tstlhkomisi,2 , ',' , '.')?></td>
                </tr>
               <?php
				 if ($jlain->num_rows() > 0):
					foreach ($jlain->result() as $row8):
			 ?>
              <tr class="detail">
              <td width="372" class="detail2">&nbsp;PENJUALAN LAIN-LAIN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="164">&nbsp;</td>
              </tr>
               
                <tr class="data">
                    <td>&nbsp;STARTER KIT</td>
                    <td align="left"><?php echo "Rp. ".number_format($row8->omsetsk,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;LEVEL GIFT</td>
                    <td><?php echo "Rp. ".number_format($row8->omsetlg,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td> &nbsp;KATALOG + FLAYER + VOUCHER</td>
                  <td><?php echo "Rp. ".number_format($row8->omsetll,2 , ',' , '.')?>
                  <hr /></td>
                 <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tlain = $tlain +  $row8->omsetsk + $row8->omsetlg+ $row8->omsetll; echo "Rp. ".number_format($tlain,2 , ',' , '.')?> <hr /></td>
                </tr>
                <?php endforeach; endif;?>
                <tr class="detail">
                	<td class="detail2">&nbsp;TOTAL PEMBAYARAN</td>
                  <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tall = $tstlhkomisi +  $tlain; echo "Rp. ".number_format($tall,2 , ',' , '.')?> </td>
                </tr>
                <tr>
                	<td>&nbsp;PIUTANG SEBELUMNYA</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php  $piutang = $total_bayar[0]->total_bayar - $sudah_bayar[0]->sudah_bayar; echo "Rp. ".number_format($piutang,2 , ',' , '.');?> <hr /></td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;GRAND TOTAL PEMBAYARAN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tall = $tstlhkomisi +  $tlain; echo "Rp. ".number_format($tall,2 , ',' , '.')?> </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp; </td>
                </tr>
                <tr class="detail">
                	<td>&nbsp;PEMBAYARAN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp; </td>
                </tr>
                <tr >
                	<td colspan="3">
                    <table width="100%" border="1" class="detail" align="center">
			<tr class="detail2">
                	<th width="18%"><strong>TANGGAL</strong></th>
                <th width="25%">NAMA BANK</th>
                    <th width="34%">KETERANGAN</th>
                <th width="23%">&nbsp;</th>
                </tr>
                <?php
				 $tbayar = 0;
                 foreach($pembayaran as  $d):
                ?>
                <tr>
                    <td align="center"><?php echo $d->datetanggal?></td>
                    <td align="center"><?php echo $d->nama_bank?></td>
                    <td align="center"><?php echo $d->keterangan?></td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($d->nominal_bayar,2 , ',' , '.')?></td>
                </tr>
                <?php 
				$tbayar = $tbayar + $d->nominal_bayar;
				endforeach;?>
             </table></td>
                </tr>
                <tr class="detail">
                	<td class="detail2">SALDO YANG MASIH HARUS DIBAYAR</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tsaldo = $tall -  $tbayar; echo "Rp. ".number_format($tsaldo,2 , ',' , '.')?> </td>
                </tr>
      </table>      
      
      </td>
    </tr>
</table>
</body>
</html>