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
header("Content-Disposition: attachment; filename=Lap_Stock_Cabang.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<body>
<table width="1300" align="center">
<tr>
<td align="center">
<table width="1300" height="165" align="center">
        <tr>
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203">&nbsp;</td>
     	  <td width="41">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
          <td width="41">&nbsp;</td>
        </tr>
        <tr>
          
        </tr>
        <tr>
            
        </tr>
        <tr align="center" class="judul">
            <td colspan="9">
LAPORAN STOCK CABANG <?php echo $cabang;?></td>
            <td>&nbsp;</td>
        </tr>
                
        <tr align="center" class="detail">
          <td colspan="9">WEEK <?php echo $intid_week;?></td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
    <tr>
    	<td align="center">
<table width="1300" height="165" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
                            <thead>
                                <tr   class="data" align="center" >
                                  <th width="49" rowspan="2">Nama Barang</th>
                                  <th colspan="2">Stok Awal</th>
                                  <th colspan="2">Masuk</th>
                                  <th colspan="2" >Keluar</th>
                                  <th colspan="2" >Sisa</th>
                                </tr>
                                <tr   class="data" align="center" >
                                    <th width="22" >Pcs</th>
                                    <th width="23">Set</th>
                                    <th width="23">Pcs</th>
                                    <th width="23" >Set</th>
                                  <th width="28">Pcs</th>
                                  <th width="29" >Set</th>
                                    <th width="22" >Pcs</th>
                                    <th width="23" >Set</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                          <?php
                            foreach($po as $m) :
						  ?>
                          <tr class='data' align='center'>
            				<td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
                            <td align='center'>&nbsp;<span class="detail">
                              <?php if(!empty($m->intqty_begin)) { if ($m->intid_jsatuan==2)  echo $m->intqty_begin; } else {echo 0;}?>
                            </span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if(!empty($m->intqty_begin)) { if ($m->intid_jsatuan==1) echo $m->intqty_begin; } else {echo 0;}?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if(!empty($m->intqty_in)) {if ($m->intid_jsatuan==2)  echo $m->intqty_in;} else {echo 0;}?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if(!empty($m->intqty_in)) {if ($m->intid_jsatuan==1) echo $m->intqty_in;} else {echo 0;}?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if(!empty($m->intqty_out)) {if ($m->intid_jsatuan==2)  echo $m->intqty_out;} else {echo 0;}?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if(!empty($m->intqty_out)) {if ($m->intid_jsatuan==1) echo $m->intqty_out;} else {echo 0;}?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php $end = ($m->intqty_begin + $m->intqty_in) - $m->intqty_out; 
							  if ($m->intid_jsatuan==2)  echo $end; else echo 0;?>
            				</span></td>
            				<td align='center'>&nbsp;<span class="detail">
            				  <?php if ($m->intid_jsatuan==1)  echo $end; else echo 0;?>
            				</span></td>
                            </tr>
							<?php endforeach;?> 
                            </tbody>
                        </table>
                        </td>
    </tr>
</table>
</body>
</html>