<?php
	$totalcash 	= 0;
	$tcash 			= 0;
	$totaldebit	= 0;
	$totalkkredit = 0;
	$totaldp 		= 0;
	$total 			= 0;
	$totalomset	= 0;
	$totalsk		= 0;
	$totallg			= 0;
	$totalll			= 0;
	$totalbayar	= 0;
	$count			=	0;
	for($i=0;$i<count($strnama_cabang);$i++)
	{
		$dstrnama_cabang		=	$strnama_cabang[$i];
		//for($j=0;$j<count($default[$i]);$j++)
		foreach($default[$i] as $row)
		{
			$dstrnama_jpenjualan	= $row['strnama_jpenjualan'];
			//echo $dstrnama_jpenjualan."<br />";
			if($row['query']->num_rows() > 0)
			{
				foreach($row['query']->result() as $rok)
				{
					$dinttotal_omset			=	$rok->inttotal_omset;
					$dsk								=	$rok->sk;
					$dlg								=	$rok->lg;
					$dll								=	$rok->ll;
					$dintcash						=	$rok->totalcash;
					$dintdebit						=	$rok->intdebit;
					$dintkkredit					=	$rok->intkkredit;
					$dis_dp						=	$rok->is_dp;
					$dinttotal_bayar			=	$rok->inttotal_bayar;
					$dintdp							=	$rok->intdp;
			?>
			 
			<?php
				}
			}
			else
			{
					$dinttotal_omset			=	0;
					$dsk								=	0;
					$dlg								=	0;
					$dll								=	0;
					$dintcash						=	0;
					$dintdebit						=	0;
					$dintkkredit					=	0;
					$dis_dp						=	0;
					$dinttotal_bayar			=	0;
					$dintdp							=	0;
			}
			$count++;

			?>
			 <tr class="data">
					<td><?php echo $count;?></td>
					<td><?php echo $dstrnama_jpenjualan;?></td>
					<td align="left"  class="detail"><?php echo $dstrnama_cabang?></td>
					<td  align="justify"  class="detail"><?php 
					if ($dis_dp == 0){
						$dp = $dinttotal_omset;
					} else {
						$dp = 0;
					}
					echo $dp;?></td>
					<td align="justify" class="detail"><?php echo $dsk;?></td>
					<td align="justify"  class="detail"><?php echo $dlg;?></td>
					<td align="justify"  class="detail"><?php echo $dll;?></td>
					<td align="justify"  class="detail"><?php echo $dintcash;?></td>
					<td align="justify"  class="detail"><?php echo $dintdebit;?></td>
					<td align="justify"  class="detail"><?php echo $dintkkredit;?></td>
					<td align="justify"  class="detail">
					<?php 
					if ($dis_dp == 0){
						if ($dintdp == 0) { 
							$a = $dinttotal_bayar; 
						} else if ($dintkkredit != 0){
							$a = $dintkkredit; 
						} else if ($dintdebit != 0){
							$a = $dintdebit; 
						} else { 
							$a= $dintcash + $dintdp;
							//$a .= "cash + dp";
						}
					} else if ($dis_dp == 1){
						$a = $dintcash;
					}
					
					echo $a;?></td>
				</tr>
			<?php
		}
		if(isset($default_undangan) and $default_undangan[$i]['query']->num_rows() > 0)
		{
			foreach($default_undangan[$i]['query']->result() as $rok)
			{
				$dstrnama_jpenjualan	= $default_undangan[$i]['strnama_jpenjualan'];
				//echo $dstrnama_jpenjualan."<br />";
						$dinttotal_omset			=	$rok->inttotal_omset;
						$dsk								=	$rok->sk;
						$dlg								=	$rok->lg;
						$dll								=	$rok->ll;
						$dintcash						=	$rok->totalcash;
						$dintdebit						=	$rok->intdebit;
						$dintkkredit					=	$rok->intkkredit;
						$dis_dp						=	$rok->is_dp;
						$dinttotal_bayar			=	$rok->inttotal_bayar;
						$dintdp							=	$rok->intdp;
				
				$count++;

				?>
				 <tr class="data">
						<td><?php echo $count;?></td>
						<td><?php echo $dstrnama_jpenjualan;?></td>
						<td align="left"  class="detail"><?php echo $dstrnama_cabang?></td>
						<td  align="justify"  class="detail"><?php 
						if ($dis_dp == 0){
							$dp = $dinttotal_omset;
						} else {
							$dp = 0;
						}
						echo $dp;?></td>
						<td align="justify" class="detail"><?php echo $dsk;?></td>
						<td align="justify"  class="detail"><?php echo $dlg;?></td>
						<td align="justify"  class="detail"><?php echo $dll;?></td>
						<td align="justify"  class="detail"><?php echo $dintcash;?></td>
						<td align="justify"  class="detail"><?php echo $dintdebit;?></td>
						<td align="justify"  class="detail"><?php echo $dintkkredit;?></td>
						<td align="justify"  class="detail">
						<?php 
						if ($dis_dp == 0){
							if ($dintdp == 0) { 
								$a = $dinttotal_bayar; 
							} else if ($dintkkredit != 0){
								$a = $dintkkredit; 
							} else if ($dintdebit != 0){
								$a = $dintdebit; 
							} else {
								$a= $dintcash + $dintdp;
								//$a .= "cash + dp";
							}
						} else if ($dis_dp == 1){
							$a = $dintcash;
						}
						
						echo $a;?></td>
					</tr>
				<?php
			}
		}
	}
				/*
                $totalcash = 0;
				$tcash = 0;
				$totaldebit= 0;
				$totalkkredit = 0;
				$totaldp = 0;
				$total = 0;
				$totalomset = 0;
				$totalsk = 0;
				$totallg = 0;
				$totalll = 0;
				$totalbayar = 0;
				if($default->num_rows() > 0)
				{
                foreach($default->result() as  $d):
                ?>
              
                 
                <tr class="data">
                    <td><?php echo $d->strnama_jpenjualan;?></td>
                    <td align="left"  class="detail"><?php echo $d->strnama_cabang?></td>
                    <td  align="justify"  class="detail"><?php 
					if ($d->is_dp == 0){
						$dp = $d->inttotal_omset;
					} else {
						$dp = 0;
					}
					echo $dp;?></td>
                    <td align="justify" class="detail"><?php echo $d->sk;?></td>
                    <td align="justify"  class="detail"><?php echo $d->lg;?></td>
                    <td align="justify"  class="detail"><?php echo $d->ll;?></td>
                    <td align="justify"  class="detail"><?php echo $d->intcash;?></td>
                    <td align="justify"  class="detail"><?php echo $d->intdebit;?></td>
                    <td align="justify"  class="detail"><?php echo $d->intkkredit;?></td>
                    <td align="justify"  class="detail">
					<?php 
					if ($d->is_dp == 0){
						if ($d->intdp == 0) { 
							$a = $d->inttotal_bayar; 
						} else if ($d->intkkredit != 0){
							$a = $d->intkkredit; 
						} else if ($d->intdebit != 0){
							$a = $d->intdebit; 
						} else {
							$a= $d->intcash + $d->intdp;
							//$a .= "cash + dp";
						}
					} else if ($d->is_dp == 1){
						$a = $d->intcash;
					}
					
					echo $a;?></td>
                </tr>
                <?php 
				
				endforeach;?>
				
				<?php
				if(isset($default_undangan) and $default_undangan->num_rows() > 0){
				 foreach($default_undangan->result() as  $du):
                ?>
              
                 
                <tr class="data">
                    <td align="left"  class="detail"><?php echo $du->intno_nota?></td>
                    <td align="left"  class="detail"><?php echo $du->strnama_dealer?></td>
                    <td align="left"  class="detail"><?php echo $du->strnama_upline?></td>
                    <td align="left"  class="detail"><?php echo $du->strnama_unit?></td>
                    <td  align="justify"  class="detail"><?php 
					if ($du->is_dp == 0){
						$dp = $du->inttotal_omset;
					} else {
						$dp = 0;
					}
					echo $dp;?></td>
                    <td align="justify" class="detail"><?php echo $du->sk;?></td>
                    <td align="justify"  class="detail"><?php echo $du->lg;?></td>
                    <td align="justify"  class="detail"><?php echo $du->ll;?></td>
                    <td align="justify"  class="detail">
					<?php 
					if ($du->is_dp == 0){
						if ($du->intdp == 0) { 
							$a = $du->inttotal_bayar; 
						} else if ($du->intkkredit != 0){
							$a = $du->intkkredit; 
						} else if ($du->intdebit != 0){
							$a = $du->intdebit; 
						} else {
							$a= $du->intcash + $du->intdp;
							//$a .= "cash + dp";
						}
					} else if ($du->is_dp == 1){
						$a = $du->intcash;
					}
					
					echo $a;?></td>
    
                </tr>
                <?php 
				$totalcash = $totalcash + $du->intcash;
				//$totalcash = $totalcash + $d->totalcash;
				$tcash = $tcash + $a;
				$totaldebit = $totaldebit + $du->intdebit;
				$totalkkredit = $totalkkredit + $du->intkkredit;
				$totaldp = $totaldp + $du->intdp;
				$totalomset = $totalomset + $dp;
				$totalsk = $totalsk + $du->sk;
				$totallg = $totallg + $du->lg;
				$totalll = $totalll + $du->ll;
				$totalbayar = $totalbayar + $du->inttotal_bayar;
				//$total = $totalcash + $totaldebit + $totalkkredit + $totaldp;
				$total = $totalcash + $totaldebit + $totalkkredit;
				endforeach;
				}
				?>
				<?php
				?>
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
                    <td align="left"  class="detail">&nbsp;</td>
                </tr>
				<?php
				} */
				?>
