<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=kartu_stok.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
 
<table width="90%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center" bgcolor="#FFFFFF">
     
    	<thead>
        <tr  align="center"  class="" bgcolor="#CCCCCC">
            <th rowspan="2">Tanggal Nota</th>
            <th rowspan="2">No Nota</th>
            <th rowspan="2">Nama Dealer</th>
            <th rowspan="2">Upline</th>
            <th rowspan="2">Unit</th>
            <th colspan="2">Stock Awal</th>
			<th colspan="2">Masuk</th>
            <th colspan="2">Keluar</th>
            <th colspan="2">Sisa</th>
			</tr>
        <tr class="" bgcolor="#CCCCCC">
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
                    <th>Pcs</th>
                    <th>Set</th>
        </tr>    
    </thead>
    <tbody>
	   <?php 
			$i=1;
			$jmlawal=0;
			$jmlmasuk=0;
			$jmlkeluar=0;
			$jmlsisa=0;
			foreach($po as $m) : 
		?>
        
      <tr class='data' align='center' bgcolor="#CCCCCC">
            
            <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_upline; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_unit; ?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_begin; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_begin; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_in; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_in; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_out; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_out; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==2)  echo $m->intqty_end; else echo 0;?></td>
            <td align='center'>&nbsp;<?php if ($m->intid_jsatuan==1)  echo $m->intqty_end; else echo 0;?></td>
            </tr>
		 <?php 
		 	$jmlawal = $jmlawal + $m->intqty_begin;
			$jmlmasuk = $jmlmasuk + $m->intqty_in;
			$jmlkeluar = $jmlkeluar + $m->intqty_out;
			$jmlsisa = $jmlsisa + $m->intqty_end;
		 	endforeach; ?>         
         <!--<tr class='data' align='center' bgcolor="#CCCCCC">
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;</td>
            <td align='left'>&nbsp;Total</td>
            <td align='center'><?php //if ($m->intid_jsatuan==2)  echo $jmlawal; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==1)  echo $jmlawal; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==2)  echo $jmlmasuk; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==1)  echo $jmlmasuk; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==2)  echo $jmlkeluar; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==1)  echo $jmlkeluar; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==2)  echo $jmlsisa; else echo 0;?></td>
            <td align='center'><?php //if ($m->intid_jsatuan==1)  echo $jmlsisa; else echo 0;?></td>
            </tr>-->
	</tbody>
</table>