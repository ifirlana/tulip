<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak STTB</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

</head>

<body>
<table width="1000" align="center">
	<tr class="detail2">
   	  <td colspan="2" align="center">
        <table width="1000" align="center" >
        <tr class="detail">
          <td width="778" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="145" class="detail2"><?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td width="61"><a href="javascript:window.print()" onclick="location.href='../po/index';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr class="detail">
            <td > Cabang&nbsp;&nbsp;: <?php echo $default[0]->strnama_cabang?></td>
            <td width="61">&nbsp;</td>
        </tr>
        <tr class="detail">
            <td > Week&nbsp;&nbsp;: <?php echo $default[0]->intid_week?>
            <td>&nbsp;</td>
        </tr>
        <tr >
            <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr >
            <td colspan="2" >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php if(isset($surat_keluar)):?>
        <tr align="left" class="detail">
            <td colspan="2" class="detail2">No STTB : <?php echo $default[0]->intid_retur?>/ <?php echo $week[0]->intid_week;?>/STTB/<?php echo date('Y')?></td>
          <td>&nbsp;</td>
        </tr>
        <?php endif;?>
    </table>
    </td>
    <tr>
    	<td colspan="2" align="center">
        	<table width="865" border="1" align="center"class="detail">
			<tr class="detail2">
			  <th rowspan="2" width="45">NO </th>
                	
              <th rowspan="2" width="453">NAMA BARANG</th>
              <th colspan="2">&nbsp;</th>
                    <th rowspan="2" width="209">KET</th>
                </tr>
               <tr>
               
                <th width="54">PCS</th>
                <th>SET</th>
               </tr> 
               <tr>
                  <td>&nbsp;</td>
                	
                  <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
				$i=1;
                $reg_pcs = 0;
				$reg_set = 0;
				foreach($default as  $d):
                ?>
                <tr>
                  <td align="center" class="detail"><?php echo $i; $i++; ?></td>
                   
                  <td align="left" class="detail"><?php echo $d->strnama?></td>
                  <td align="center" class="detail"><?php if ($d->intid_jsatuan==2)  echo $d->qty; else echo 0;?></td>
                  <td width="70" align="center" class="detail"><?php if ($d->intid_jsatuan==1) echo $d->qty; else echo 0;?></td>
                  <td width="70" align="left" class="detail"><?php echo $d->ket?></td>
              </tr>
                <?php 
				if ($d->intid_jsatuan==1)
				{
					$reg_set = $reg_set + $d->qty;
				} else{
					$reg_pcs = $reg_pcs + $d->qty;
				}
				endforeach;?>

                <tr>
                  <td>&nbsp;</td>
                	
                  <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                
                <tr class="detail2">
                	<td colspan="2" align="right">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center"><?php echo $reg_pcs; ?></td>
                    <td align="center"><?php echo $reg_set; ?></td>
                    <td>&nbsp;</td>
                </tr> 
      </table>      </td>
    </tr>

    <tr>
	<td colspan="2" align="left">&nbsp;</td>
  	</tr>
    
                <tr>
                	<td colspan="2" align="center">&nbsp;
              <table width="1000" align="center">
  				<tr class="detail">
                	<td width="229" colspan="4" align="center">&nbsp;</td>
       			  <td width="229" colspan="4" align="center">&nbsp;</td>
       			  <td width="229" colspan="4" align="center">ADM. GUDANG</td>
                </tr>
                <tr>
                	<td width="229" colspan="4" align="right">&nbsp;</td>
                    <td width="229" colspan="4" align="right">&nbsp;</td>
                  <td width="229" colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
               		 <td width="229" colspan="4" align="right">&nbsp;</td>
                	 <td width="229" colspan="4" align="right">&nbsp;</td>
               	  <td width="229" colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="230" colspan="4" align="center">&nbsp;</td>
                  <td width="230" colspan="4" align="center">&nbsp;</td>
                  <td width="230" colspan="4" align="center">(....................)</td>
                </tr>
                  </table>                  </td>
                </tr>
    
</table>
</body>
</html>