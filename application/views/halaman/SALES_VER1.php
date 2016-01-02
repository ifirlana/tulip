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
header("Content-Disposition: attachment; filename=sales.xls");
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
          <td colspan="2">LAPORAN SALES <?php echo $default[0]->strnama_cabang;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center" class="detail">
          <td colspan="2">WEEK <?php echo $default[0]->intid_week?> ( <?php echo $default[0]->datestart;?>  - <?php echo $default[0]->dateend;?>)</td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
  <tr>
    	<td align="center">
       	  <table width="1500" border="1" align="center"  class="detail">
			<tr class="detail2"> 
			  <th width="190">TANGGAL</th>
              <th width="190">NO NOTA</th>
              <th width="150">JENIS NOTA</th>
              <th>NAMA</th>
              <th>UPLINE</th>
              <th>UNIT</th>
              <th>NAMA BARANG </th>
              <th>QUANTITY</th>
            <!--  <th colspan="9">OMSET</th> -->
              <th colspan="8">OMSET</th> 
              <th>NETTO</th>
              <th>TOTAL</th>
              <th>PV</th>
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
                  <td width="150" align="center"><strong>OMSET10</strong></td>
                 <!-- 
					///omset15
					<td width="120" align="center"><strong>OMSET15</strong></td> -->
                  <td width="120" align="center"><strong>OMSET20</strong></td>
                  <td width="150" align="center"><strong>NETTO</strong></td>
                  <td width="120" align="center"><strong>SPECIAL PRICE</strong></td>
		  <td width="150" align="center"><strong>POINT</strong></td>
                  <td width="120" align="center"><strong>SK</strong></td>
                  <td width="150" align="center"><strong>LG</strong></td>
                  <td width="120" align="center"><strong>LL</strong></td>
                  <td width="120" align="center">&nbsp;</td>
                  <td width="70" align="center">&nbsp;</td>
                  <td width="70" align="center">&nbsp;</td>
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
                <!--  
					///omset15
					<td align="left">&nbsp;</td> -->
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
                  <td align="left">&nbsp;</td>
               </tr>
                <?php
				$totalnett=0;
				$totalpv=0;
                foreach($default as  $d):
                ?>
				<tr class="detail">
                    <td align="justify"><?php echo $d->datetgl?></td>
                    <td align="justify"><?php echo $d->intno_nota?></td>
                    <td align="justify"><?php echo $d->strnama_jpenjualan?></td>
                    <td align="justify"><?php 
					if($d->strnama_dealer){
						echo $d->strnama_dealer;
						}?><?php 
					if($d->keterangan_tambahan){
						echo $d->keterangan_tambahan;
						}?></td>
                    <td align="justify"><?php 
					if($d->strnama_upline){
						echo $d->strnama_upline;
					}?></td>
                    <td align="justify"><?php 
					if($d->strnama_unit){
					echo $d->strnama_unit;
					}?></td>
                    <td colspan="2" align="justify"><table width="100%" border="1">
                    <?php
						$q = $this->Laporan_model->get_DetailCetakSales($d->intid_nota, $d->strnama_jpenjualan);
						$total = 0;
						foreach($q as  $row):	
					?>
                      <tr>
                        <td align="justify">
						<?php 
						if ($row->is_arisan == 0)
						{
							echo $row->strnama;
						} else if ($row->is_arisan == 1)
						{
							if ($row->winner == 1 || ($row->intjeniscicilan == 5 && $row->c5 != 0) || ($row->intjeniscicilan == 7 && $row->c7 != 0))
							{
								echo $row->strnama;
							} else {
								echo " ";
							}
						}
						?></td>
                    	<td align="justify"><?php 
						if ($row->is_arisan == 0)
						{
							echo $row->intquantity;
						} else if ($row->is_arisan == 1)
						{
							if ($row->winner == 1 || ($row->intjeniscicilan == 5 && $row->c5 != 0) || ($row->intjeniscicilan == 7 && $row->c7 != 0))
							{
								echo $row->intquantity;
							} else {
								echo " ";
							}
						}
						?></td>
                      </tr>
                    <?php 
					endforeach;?>
                    </table></td>
                    <td align="justify"><?php 
					if($d->intid_jpenjualan == 14){
						if($d->intomset10 > 0){
								echo '0';
								}else{
									echo '0';
								}?></td>
							<?php 
							///omset15
							/*
							<td align="justify"><?php 
							if($d->intomset15 > 0){
								echo '0';
								}else{
									echo "0";
								}?></td> */ ?>
							<td align="justify"><?php 
							if($d->intomset20 > 0){
								echo '0';
								}else{
									echo "0";
								}?></td>
						<td align="justify"><?php if (!empty($d->omsetnetto) and $d->omsetnetto > 0) {
								echo '0';
								} else {
									echo '0';
									}?></td>
								<td align="justify"><?php if (!empty($d->omsetspecialprice) and $d->omsetspecialprice > 0) {
								echo $d->omsetspecialprice;
								} else {
									echo '0';
									}?></td>
						<td align="justify"><?php if (!empty($d->omsetpoint) and $d->omsetpoint > 0) {echo $d->omsetpoint;} else {echo '0';}?></td>
								<td align="justify"><?php if (!empty($d->omsetsk) and $d->omsetsk > 0) {echo $d->omsetsk;} else {echo '0';}?></td>
								<td align="justify"><?php if (!empty($d->omsetlg) and $d->omsetlg > 0) {echo $d->omsetlg;} else {echo '0';}?></td>
								<td align="justify"><?php if (!empty($d->omsetll) and $d->omsetll > 0) {echo $d->omsetll +  $d->intomset10 + $d->intomset15+ $d->intomset20 + $d->omsetnetto;} else {echo $d->inttotal_bayar;}?></td>
							  <td><?php 
							  if($d->inttotal_bayar >0){
								  echo $d->inttotal_bayar;
								  }else{
									echo '0';
								  }?></td>
								<td>&nbsp;</td>
								<td><?php 
								if($d->intpv > 0){
									echo $d->intpv;
									}else{
										echo '0';
									}?></td>
							</tr>
							<?php
					}else{
							if($d->intomset10 > 0){
								echo $d->intomset10;
								}else{
									echo '0';
								}?></td>
								<?php /* 
							<td align="justify"><?php 
							if($d->intomset15 > 0){
								echo $d->intomset15;
								}else{
									echo "0";
								}?></td> */
								?>
							<td align="justify"><?php 
							if($d->intomset20 > 0){
								echo $d->intomset20;
								}else{
									echo "0";
								}?></td>
					<td align="justify"><?php if (!empty($d->omsetnetto) and $d->omsetnetto > 0) {
							echo $d->omsetnetto;
							} else {
								echo 0;
								}?></td>
							<td align="justify"><?php if (!empty($d->omsetspecialprice) and $d->omsetspecialprice > 0) {
							echo $d->omsetspecialprice;
							} else {
								echo 0;
								}?></td>
					<td align="justify"><?php if (!empty($d->omsetpoint) and $d->omsetpoint > 0) {echo $d->omsetpoint;} else {echo 0;}?></td>
							<td align="justify"><?php if (!empty($d->omsetsk) and $d->omsetsk > 0) {echo $d->omsetsk;} else {echo 0;}?></td>
							<td align="justify"><?php if (!empty($d->omsetlg) and $d->omsetlg > 0) {echo $d->omsetlg;} else {echo 0;}?></td>
							<td align="justify"><?php if (!empty($d->omsetll) and $d->omsetll > 0) {echo $d->omsetll;} else {echo 0;}?></td>
						  <td><?php 
						  if($d->inttotal_bayar >0){
							  echo $d->inttotal_bayar;
							  }else{
								echo '0';
							  }?></td>
							<td>&nbsp;</td>
							<td><?php 
							if($d->intpv > 0){
								echo $d->intpv;
								}else{
									echo '0';
								}?></td>
						</tr>
						<?php
				}
				$totalnett= $totalnett + $d->inttotal_bayar;
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
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
    </table>      </td>
    </tr>
</table>
</body>
</html>