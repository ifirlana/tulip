<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Penjualan Nota</title>
<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<style>
	div.page{
		padding:10px;
		font-size:14px;
		letter-spacing:3.5px;
	}
	div.header{
		margin-top:5px;
		margin-bottom:5px;
		overflow:hidden;
		font-weight:bold;
	}
	div.header div{
		margin-top:10px;
	}
	div.header div div{
		margin-top:0px;
		padding-right:5px;
	}
	div.header div div.label{
		width:70px;
	}
	div.header div div.colon{
		width:10px;
	}
	div.header div div.value{
		width:300px;
	}
	div.content{
		margin-right:20px;
		display:block;
		float:left;
		text-align:left;
	}
	div.content div div.left{
		float:left;
		margin-left:10px;
	}
	div.content div div.right{
		float:right;
		margin-right:10px;
	}
	div.content div div.harga{
		width:150px;
	}
	div.content div div.bayar{
		width:250px;
	}
	div.highlight{
		font-weight:bold;
		font-size:18px;
	}
	div.block{
		margin-top:3px;
		overflow:hidden;
	}
	div.block div{
		width:150px;
	}
	div.block div, div.header div{
		display:block;
		float:left;
		text-align:left;
	}
</style>
</head>

<body>
<?php
?>
<table width="1000" align="center">
	<tr class="detail2">
   	  <td align="center">
        <table width="1000" align="center" >
        <tr class="detail">
          <td width="440" rowspan="4" valign="top"><img src="<?php echo base_url();?>images/logo.jpg" />&nbsp;</td>
          <td width="203"> <?php if(isset($default[0]->strnama_cabang)){echo $default[0]->strnama_cabang;}?>, <?php echo date('d-m-Y', strtotime($default[0]->datetgl))?></td>
     	  <td width="41"><a href="javascript:window.print()" onclick="location.href='<?php echo base_url()."laporan/";?>';"><img src="<?php echo base_url();?>/images/print.jpg"/></a><?php
		  if(strtoupper($this->session->userdata('username'))== "ADMIN"){
			echo "<a href='".base_url()."sparepart_garansi/GET_EXCEL_NOTA_HADIAH/?intid_nota=".$default[0]->intid_nota."'><img src='".base_url()."images/xls_icon.gif'/></a>";
			}
		  ?></td>
        </tr>
        <tr class="detail">
            <td align="left" ><h3>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php if(isset($default[0]->strnama_cabang)){echo $default[0]->strnama_dealer;}?></h3></td>
            <td width="41">&nbsp;</td>
        </tr>
        <tr class="detail">
            <td   align="left"><h3> Upline&nbsp;&nbsp;&nbsp;&nbsp;: <?php if(isset($default[0]->strnama_cabang)){echo $default[0]->strnama_upline;}?></h3></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="detail">
            <td align="left"><h3> Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php if(isset($default[0]->strnama_cabang)){echo $default[0]->strnama_unit;}?></h3> </td>
            <td>&nbsp;</td>
        </tr>
        <?php
        	if($default[0]->jenis_nota == "RC13"){
        		echo "<tr class='detail'>
            <td align='left'><h3> Nama Konsumen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$default[0]->keterangan."</h3> </td>
            <td>&nbsp;</td>
        </tr>";
        	}
			else if($default[0]->jenis_nota == "HDK13"){
				echo "<tr class='detail'>
            <td align='left'><h3> No Surat Jalan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$default[0]->keterangan."</h3> </td>
            <td>&nbsp;</td>
        </tr>";
				}
        ?>
		<?php  
		if($default[0]->jenis_nota != "HDK13"){
				echo "<tr class='detail'>
				<td colspan='2'><h3>
				NOTA NO. : ".$default[0]->intno_nota."   </h3>   	</td>
				<td>&nbsp;</td>
        </tr>
		";
				}?>        
		
		<!-- <tr class="detail">
            <td colspan="2"><h3>
                NOTA NO. : <?php //echo $default[0]->intno_nota?>     </h3>   	</td>
                <td>&nbsp;</td>
        </tr>-->
        <tr align="center" class="judul">
            <td colspan="2"><h3>
                <?php echo "Nota Penjualan ".$default[0]->strnama_penjualan; ?></h3></td>
          <td>&nbsp;</td>
        </tr>
    </table>    </td>
    </tr>
    <tr>
    	<td align="center">
        	<table width="646" border="1" align="center"  class="detail">
			<tr class="detail2">
              <th width="100">Jumlah</th>
              <th width="348"  style="padding:0 10px 0 10px;">Nama Barang</th>
              <th width="348">Keterangan</th>
              </tr>
              <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
              </tr>
                <?php
                $total = 0;
                foreach($default as  $d):
                ?>
                <tr>
                    <td align="center"  class='style-css'><?php echo $d->intquantity?></td>
                    <td align="left"  class='style-css-nama'><?php echo $d->strnama?></td>
                    <td align="left"  class='style-css'><?php 
					if(md5('REKRUTHADIAH') == $d->ket){
							echo 'REKRUT HADIAH';
						}else{
							echo $d->ket;
						}
						?></td>
                </tr>
                <?php endforeach;?>

                
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
      </table>      </td>
    </tr>
                <tr>
                	<td align="center">
              	<table width="1000" align="center" >
                        <tr class="detail2">
                          <td width="229" colspan="4" align="center">GUDANG</td>
                          <td width="229" colspan="4" align="center">PEMBELI</td>
                          <td width="229" colspan="4" align="center">KASIR</td>
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
                          <td width="230" colspan="4" align="center">(....................)</td>
                          <td width="230" colspan="4" align="center">(....................)</td>
                        </tr>
                      </table>      </td>
                </tr>
</table>
</body>
</html>