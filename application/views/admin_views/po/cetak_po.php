<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak PO</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>

<style>
	td .detail { font-size:12px;
			letter-spacing:3.5px;}
	 .detail { font-size:14px;
			letter-spacing:3.5px;}
</style>
</head>

<body>
<table width="1069" align="center">
	<tr class="detail2">
   	  <td width="1061" colspan="2" align="center">
        <table width="1016" align="center" >
        <tr class="detail">
          <td width="816" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="107" class="detail2"><?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td width="77"><a href="javascript:window.print()" onclick="location.href='../po';"><img src="<?php echo base_url();?>/images/print.jpg"/></a></td>
        </tr>
      <?php if(isset($surat_jalan)):?>
        <tr >
            <td >
            SURAT JALAN
          <td>&nbsp;</td>
        </tr>
        <?php endif;?>
        <tr >
            <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
     
        <tr align="center"class="detail">
          <td colspan="2" > </td>
        </tr>
         <tr align="left" class="detail">
            <td colspan="2" class="detail2">Cabang&nbsp;&nbsp;: <?php echo $default[0]->strnama_cabang?></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="left" class="detail">
            <td colspan="2" class="detail2">No PO : <?php echo $default[0]->no_po?></td>
          <td>&nbsp;</td>
        </tr>
        <?php if(isset($surat_keluar)):?>
        <tr align="left" class="detail">
            <td colspan="2" class="detail2">No SPKB : <?php echo $default[0]->intid_po?>/ <?php echo $week[0]->intid_week;?>/SPKB/<?php echo date('Y')?></td>
          <td>&nbsp;</td>
        </tr>
        <?php endif;?>
    </table>
    </td>
    <tr>
    	<td colspan="2" align="center">
        	<table width="980" border="1" align="center"class="detail">
			    	
             <tr class="detail2" >
			  <th rowspan="2" width="45">No</th>
                	
              <th rowspan="2" width="453">Nama Barang</th>
              <th colspan="2">&nbsp;</th>
               <th rowspan="2" width="111">Ket</th>
                    <?php if(isset($surat_jalan)):?>
                    <th width="152" rowspan="2">Keterangan Barang</th>
                    <?php endif;?>
                </tr>
               <tr>
               
                <th width="54">Pcs</th>
                <th>Set</th>
                </tr> <tr>
                  <td>&nbsp;</td>
                	
                  <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php if(isset($surat_jalan)):?>
                  <td>&nbsp;</td>
                  <?php endif;?>
                </tr>
                <?php
				$i=1;
                $reg_pcs = 0;
				$reg_set = 0;
				foreach($default as  $d):
                ?>
                <tr>
                <td align="center" class="detail"><?php echo $i++; ?></td>
                   
                  <td align="left" class="detail"><?php echo $d->strnama?></td>
                  <td align="center" class="detail"><?php if ($d->intid_jsatuan==2)  echo $d->qty; else echo 0;?></td>
                  <td width="70" align="center" class="detail"><?php if ($d->intid_jsatuan==1) echo $d->qty; else echo 0;?></td>
                  <td width="111" align="left" class="detail"><?php echo $d->ket?></td>
                  <?php if(isset($surat_jalan)):?>
                  <td>
                  	<?php if($d->status==1):?>
                    	
                    <?php else:?>
                  		Barang Kosong
                  	<?php endif;?>                  </td>
                  <?php endif;?>
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
                    <?php if(isset($surat_jalan)):?>
                  <td>&nbsp;</td>
                  <?php endif;?>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php if(isset($surat_jalan)):?>
                  <td>&nbsp;</td>
                  <?php endif;?>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php if(isset($surat_jalan)):?>
                  <td>&nbsp;</td>
                  <?php endif;?>
                </tr>
                <tr class="detail2">
                	<td colspan="2" align="right">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center"><?php echo $reg_pcs; ?></td>
                    <td align="center"><?php echo $reg_set; ?></td>
                    <td>&nbsp;</td>
                     <?php if(isset($surat_jalan)):?>
                  <td>&nbsp;</td>
                  <?php endif;?>
                </tr> 
      </table>      </td>
    </tr>

    <tr>
<td colspan="2" align="center">&nbsp;</td>
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