<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak RETUR BARANG</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

</head>

<body>
<table width="1000" align="center" class="detail">
	<tr class="detail2">
   	  <td colspan="2" align="center">
        <table width="1000" align="center" class="detail">
        <tr class="detail2">
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203" class="detail2"><?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='po';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
        <tr>
            <td > Cabang&nbsp;&nbsp;: <?php echo $default[0]->strnama_cabang?></td>
            <td width="41">&nbsp;</td>
        </tr>
        <tr >
            <td > Week&nbsp;&nbsp;: <?php //echo $default[0]->intid_week?>
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
        <tr align="center">
            <td colspan="2" class="judul">
                RETUR BARANG</td>
          <td>&nbsp;</td>
        </tr>
    </table>
    </td>
    <tr>
    	<td colspan="2" align="center">
        	<table width="1000" border="1" align="center"class="detail">
			<tr class="detail2">
			  <th width="53">No</th>
                	
              <th width="563">Nama Barang</th>
                    <th width="177">Jumlah</th>
                    <th width="179">Ket</th>
                </tr>
                <?php
				$i=1;
                $total = 0;
			
                foreach($default as  $d):
                   
                    ?>
                <tr>
                  <td align="center" class="detail"><?php echo $i++; ?></td>
                   
                  <td align="left" class="detail"><?php echo $d->strnama?></td>
                    <td align="center" class="detail"><?php echo $d->intquantity?></td>
                  <td align="left" class="detail"><?php echo $d->ket?></td>
              </tr>
                <?php 
				$total=$total + $d->intquantity; 
				endforeach;?>

                <tr>
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
                </tr>
                <tr>
                  <td>&nbsp;</td>
                	
                  <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="detail2">
                	<td colspan="2" align="right">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center"><?php echo  $total; ?></td>
                     <td align="center">&nbsp;</td>
                </tr> 
      </table>      </td>
    </tr>

    <tr>
<td colspan="2" align="center">&nbsp;</td>
  </tr>
                <tr>
                	<td colspan="2" align="center">&nbsp;
              <table width="1000" align="center">
  				<tr class="detail2">
                	<td width="229" colspan="4" align="center">GUDANG</td>
          			<td width="229" colspan="4" align="center">&nbsp;</td>
       			  <td width="229" colspan="4" align="center">&nbsp;</td>
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
                	<td width="230" colspan="4" align="center">(....................)</td>
                    <td width="230" colspan="4" align="center">&nbsp;</td>
                  <td width="230" colspan="4" align="center">&nbsp;</td>
                </tr>
                  </table>                  </td>
                </tr>
    
</table>
</body>
</html>