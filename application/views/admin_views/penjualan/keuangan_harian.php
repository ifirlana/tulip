<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Pembayaran Harian</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>

<body>
<table width="754" align="center"  >
	<tr class="detail2">
   	  <td align="center"><table width="754" align="center" >
        <tr class="detail2">
          <td width="426" rowspan="2" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td align="right">&nbsp;Cabang :</td>
          <td colspan="2" align="left">&nbsp;<?php echo $cabang;?></td>
          <td width="59" colspan="2" align="right"><a href="javascript:window.print()" onclick="location.href='laporan/keuangan';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr class="detail2">
          <td align="right">Tanggal &nbsp;:</td>
          <td colspan="2" align="left">&nbsp;<?php echo date('d-m-Y') ?></td>
        </tr>
        <tr >
          <td valign="top">&nbsp;</td>
          <td align="CENTER">&nbsp;</td>
          <td colspan="2" align="left">&nbsp;</td>
        </tr>
       
        
      </table>
      <table width="754" border="1" align="center" class="detail">
        <tr>
          <td  class="judul"><p align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LAPORAN PEMBAYARAN HARIAN</p></td>
        </tr>
      </table></td><p>
    <tr class="detail">
    	<td align="center" >
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
              <td width="385" class="detail2">&nbsp;PENJUALAN REGULER :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
              <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr class="data">
                	<td >&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="data">
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
				 elseif ($hut->num_rows() > 0):
					foreach ($hut->result() as $row1):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN HUT :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row1->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr class="data">
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row1->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="data">
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
				 elseif ($challenge->num_rows() > 0):
					foreach ($challenge->result() as $row2):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN CHALLENGE :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row2->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr class="data">
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row2->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="data">
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
				 elseif ($free->num_rows() > 0):
					foreach ($free->result() as $row3):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN 1 FREE 1 :
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row3->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr class="data">
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row3->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="data">
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
				 elseif ($freehut->num_rows() > 0):
					foreach ($freehut->result() as $row4):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN 1 FREE 1 HUT:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr class="data">
                    <td>&nbsp;TULIP</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row4->omsettulip,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr class="data">
                	<td>&nbsp;METAL</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row4->omsetmetal,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="data">
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
				 elseif ($netto->num_rows() > 0):
					foreach ($netto->result() as $row5):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN NETTO:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr class="detail">
                    <td>&nbsp;TULIP</td>
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
				 elseif ($trade->num_rows() > 0):
					foreach ($trade->result() as $row6):
			?>
              <tr class="detail">
              <td width="385"class="detail2">&nbsp;PENJUALAN TRADE IN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
              </tr>
               <tr>
                    <td>&nbsp;T30</td>
                    <td align="left">&nbsp;<?php echo "Rp. ".number_format($row6->omsett30,2 , ',' , '.')?></td>
                    <td align="left">&nbsp;</td>
              </tr>
                <tr>
                	<td>&nbsp;T50</td>
                    <td>&nbsp;<?php echo "Rp. ".number_format($row6->omsett50,2 , ',' , '.')?> </td>
                   	<td>&nbsp;</td>
                </tr>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN TRADE IN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $ttrade = $ttrade + $row6->omsett30 + $row6->omsett50; echo "Rp. ".number_format($ttrade,2 , ',' , '.')?> </td>
                </tr>
                <?php 
			   	 	endforeach;
				 elseif ($arisan->num_rows() > 0):
					foreach ($arisan->result() as $row7):
			?>
              <tr class="detail">
              <td width="385" class="detail2">&nbsp;PENJUALAN ARISAN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
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
                	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL PENJUALAN ARISAN</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tarisan = $tarisan + $row7->omsettulip + $row7->omsetmetal; echo "Rp. ".number_format($tarisan,2 , ',' , '.')?> <hr /></td>
                </tr>
                <?php endforeach; endif;?>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRAND TOTAL OMSET</td>
                    <td>&nbsp;</td>
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
              <td width="385" class="detail2">&nbsp;PENJUALAN LAIN-LAIN:
                <hr /></td>
              <td width="183">&nbsp;</td>
              <td width="172">&nbsp;</td>
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
                <tr class="detail">
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tlain = $tlain +  $row8->omsetsk + $row8->omsetlg+ $row8->omsetll; echo "Rp. ".number_format($tlain,2 , ',' , '.')?> <hr /></td>
                </tr>
                <?php endforeach; endif;?>
                <tr class="detail">
                	<td class="detail2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL BAYAR</td>
                    <td>&nbsp;</td>
                   	<td>&nbsp;<?php $tall = $tstlhkomisi +  $tlain; echo "Rp. ".number_format($tall,2 , ',' , '.')?> </td>
                </tr>
      </table>      </td>
    </tr>
</table>
</body>
</html>