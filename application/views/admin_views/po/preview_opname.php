<?php
// bwt bisa didownload langsung
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=stok_opname.xls');
header('Cache-Control: max-age=0');

?>
<p>Stok Offname</p>
	   <table width="158%" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
            <thead>
                <tr align="center" >
                <th width="22" rowspan="2">&nbsp;</th>
                  <th width="233" rowspan="2">Nama Barang</th>
                  <th colspan="2">Stok Akhir</th>
                  <th colspan="2">Fisik</th>
                  <th colspan="2">Selisih</th>
                </tr>
                <tr class="table" align="center" >
                    <th width="46" >Pcs</th>
                    <th width="40">Set</th>
                    <th width="41">Pcs</th>
                    <th width="41" >Set</th>
                    <th width="48">Pcs</th>
                    <th width="56" >Set</th>
                </tr>
            </thead>
            <tbody>

               <?php
                $i=1;
                $no=1;
                if(!empty($op)){
                foreach($op as $m) : 
				//print_r($m['nama']);
				
                ?>
          <tr align='center'>
<td align="left">&nbsp;

</td>
            <td align='left'>&nbsp;<?php echo $m['nama']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['pcsakhir']; ?>
            </td>
            <td align='left'>&nbsp;<?php echo $m['setakhir']; ?>
			</td>
            <td align='left'>&nbsp;<?php echo $m['fisikpcs']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['fisikset']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['selisihpcs']; ?></td>
            <td align='left'>&nbsp;<?php echo $m['selisihset']; ?></td>
            </tr>
            <?php 
            $no++;
            endforeach; }?> 
            </tbody>
        </table>
       
                 

