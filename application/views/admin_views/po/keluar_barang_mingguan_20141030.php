<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rekap Pengeluaran Barang Mingguan</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
</head>
<?php
	if(!isset($nama_file))
	{ 
		$nama_file = "keluar_barang_mingguan";
	}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$nama_file.".xls");
header("Pragma: no-cache");
header("Expires: 0"); 
?>
<body>
<table width="1069" align="center" >
	<tr class="detail2">
   	  <td width="1061" colspan="2" align="center">
        <table width="1016" align="center" >
        <tr class="detail">
          <td width="816" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="107" class="detail2">&nbsp;</td>
     	  <td width="77">&nbsp;</td>
        </tr>
        <tr >
            <td >
          
          <td>&nbsp;</td>
        </tr>
        <tr >
            <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
     
        <tr align="center"class="detail">
          <td colspan="2" > </td>
       </tr>
        <tr align="left" class="detail">
          <td colspan="4" class="detail2"><h2 class="title"><?php if(!isset($title)){?> REKAP PENGELUARAN BARANG MINGGUAN <?php echo $cabang;?><?php }else { echo $title; }?></h2></td>
          <td>&nbsp;</td>
        </tr>
        <tr align="left" class="detail">
          <td colspan="4" class="detail2" align="center"><?php if(!isset($description)){?><strong>Week <?php echo $week;?></strong><?php }else { echo $description; }?></td>
          <td>&nbsp;</td>
        </tr>
    </table>
    </td>
    <tr>
    	<td colspan="2" align="center">
        	<table width="1069" border="1" align="center"class="detail">
			    	
             <tr class="detail2" >
			  <th rowspan="2" width="45">No</th>
                	
              <th rowspan="2" width="453">Nama Barang</th>
             </tr>
               <tr>
               
                <th width="54">Pcs</th>
                <th>Set</th>
                <th>keterangan</th>
               </tr> <tr>
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
				$keterangan_nota = ""; //tambahan keterangan nota
				$keterangan_hadiah = "";
                $intquantity = $d->intquantity_nota + $d->intquantity_arisan + $d->intquantity_hadiah + $d->intquantity_returcabang + $d->intquantity_sparepart + $d->intquantity_kanibal;
				
				if(!empty($d->intquantity_nota) and (!empty($d->intquantity_sparepart) or !empty($d->intquantity_returcabang) or !empty($d->intquantity_hadiah))){
					
					$keterangan_nota = "sales, ";
					}
				
				if(!empty($d->intquantity_hadiah) and (!empty($d->intquantity_sparepart) or !empty($d->intquantity_returcabang) or !empty($d->intquantity_nota))){
					
					$keterangan_nota = "hadiah, ";
					}
					
				$keterangan = $keterangan_nota.$keterangan_hadiah.$d->keterangan_returcabang ." ". $d->keterangan_sparepart." ".$d->keterangan_kanibal;
				if(!empty($intquantity)){
				?>
                <tr>
                <td align="center" class="detail"><?php echo $i++; ?></td>
                   
                  <td align="left" class="detail"><?php echo $d->strnama?></td>
                  <td align="center" class="detail"><?php if($d->intid_jsatuan == 2) echo $intquantity; else echo 0;?></td>
                  <td width="70" align="center" class="detail"><?php if($d->intid_jsatuan == 1) echo $intquantity; else echo 0;?></td>
				  <td><?php if(isset($keterangan)){ echo $keterangan;}?></td>
              </tr>
                <?php 
				if ($d->intid_jsatuan == 2){
					$reg_pcs=$reg_pcs + $intquantity;
				} else if ($d->intid_jsatuan == 1){
					$reg_set=$reg_set + $intquantity;
				}
				}
				endforeach;
				
				$temp_1 = 0; //total undangan
				if(isset($default_undangan))
				{
					foreach($default_undangan->result() as $row)
					{
						$temp_1 = $temp_1 + $row->total_undangan_nota+$row->total_undangan_nota_detail;
						//$temp_2 = $row->undangan_nota+$row->undangan_nota_detail;
										
					}
					echo "<tr>
					  <td align='center' class='detail'>".$i++."</td>
					  <td align='left' class='detail'>Undangan</td>
					  <td align='center' class='detail'>0</td>
					  <td width='70' align='center' class='detail'>".$temp_1."</td>
					  <td>&nbsp;</td>
						</tr>";
				}
				
				?>

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
                <tr>
                  <td>&nbsp;</td>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="detail2">
                	<td colspan="2" align="right">&nbsp;Jumlah&nbsp;&nbsp;</td>
                    <td align="center"><?php echo  $reg_pcs; ?></td>
                     <td align="center"><?php echo  $reg_set+$temp_1; ?></td>
					<td>&nbsp;</td>
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