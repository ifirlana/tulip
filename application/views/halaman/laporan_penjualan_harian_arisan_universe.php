<table width="1500" align="center">
<tr>
   	  <td width="1309" align="center">
        ARISAN </td>
  <tr>
    	<td align="center">
       	  <table width="100%" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
       <tr  align="center">
           <th rowspan="2">No</th>
           <th rowspan="2">Cabang</th>
           <th rowspan="2">Nama Dealer</th>
           <th rowspan="2">Upline</th>
            <th rowspan="2">Unit</th>
           <!-- <th rowspan="2">Cicilan ke-</th>-->
            <th colspan="3">Harga</th>
            <th rowspan="2">Komisi</th>
            <th rowspan="2">Netto</th>
            <th rowspan="2">Omset</th>
            <th rowspan="2">PV</th>
        </tr>
        <tr  align="center">
        <td>Retail</td>
        <td>DP</td>
        <td>Angsuran</td>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
        if(!empty($default) and $default != null)
		{
          	$i=1;
			foreach($default as $m) :
			if ($m->intid_wilayah==1){
                //$harga = $m->intharga_jawa;
				$cicil = $m->intcicilan_jawa;
				$um = $m->intum_jawa;
            }else {
                //$harga = $m->inthrga_luarjawa;
				$cicil = $m->intcicilan_luarjawa;
				$um = $m->intum_luarjawa;
            }
          
		?>
     	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
            <td align='left'><?php echo $m->strnama_cabang; ?></td>
            <td align='left'><?php echo $m->strnama_dealer; ?></td>
            <td align='left'><?php echo $m->strnama_upline; ?></td>
            <td align='left'><?php echo $m->strnama_unit; ?></td>
            <!--<td align='left'>&nbsp;<?php 
			/*if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1&&$m->c6==1&&$m->c7==1){
			$cicilan="7";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1&&$m->c6==1){
			$cicilan="6";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1&&$m->c5==1){
			$cicilan="5";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1&&$m->c4==1){
			$cicilan="4";
			}else if($m->c1==1&&$m->c2==1&&$m->c3==1){
			$cicilan="3";
			}else if($m->c1==1&&$m->c2==1) {
			$cicilan="2";
			}else if($m->c1==1){
			$cicilan="1";
			} else {
			$cicilan="0";
			}
			echo $cicilan;*/ ?></td>-->
            <td align='left'><?php echo $m->retail;?></td>
            <td align='left'><?php echo $um;?></td>
            <td align='left'><?php echo $cicil; ?></td>
          	<td align='right'>
			<?php 
			if ($m->intkomisi10<>0){
				$komisi = $m->intkomisi10;
			} else if ($m->intkomisi20<>0){
				$komisi = $m->intkomisi20;
			} else if (($m->intkomisi10<>0) && ($m->intkomisi20<>0)){
				$komisi = $m->intkomisi10 + $m->intkomisi20;
			} else {
				$komisi = 0;
			}
			
			echo $komisi; ?></td>
            <td align='right'><?php echo $m->inttotal_bayar; ?></td>
            <td align='right'><?php echo $m->inttotal_omset; ?></td>
            <td align='right'><?php echo $m->intpv; ?></td>	
        </tr>
		<?php
        endforeach;
        ?>
        
        <?php
        }else{
        ?>
    <tr>
        <td colspan="11" align="center">
            No Data Display
        </td>
    </tr>
    <?php } ?>

    </tbody>
</table>    </td>
    </tr>
</table>