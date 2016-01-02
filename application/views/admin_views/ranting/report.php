<table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                <thead>
                <tr  align="center"  class="table">
                    <th >No</th>
                    <th >Kode Dealer</th>
                    <th >Nama Dealer</th>
                    <th >Kode Upline</th>
                    <th >Nama Upline</th>
        		</tr>   
                </thead>
                <tbody>
				<?php 
                    $i=1;
                    foreach($ranting as $m) : 
                    
                ?>
                
                <tr class='tr_data' align='center'>
                    <td ><?php echo $i++; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strkode_dealer; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strkode_upline; ?></td>
                    <td align='left'>&nbsp;<?php echo $m->strnama_upline; ?></td>
        
                </tr>
                <?php endforeach; ?> 
	
                </tbody>
            </table>
			<?php }?>