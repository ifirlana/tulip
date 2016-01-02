<?php
$this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />
    </div>
	<div id="page">
	<div id="page-bgtop">
		<div id="content">
			<div class="post">	<h2 class="title">penjualan </h2>
				<div class="entry">              
       <form action="<?php echo base_url()?>penjualan/saveNota"  method="post" name="frmjual" id="frmjual">
        <input type='hidden' name="strkode_upline" value="<?php echo $strkode_upline;?>" />
		<div id="error"><?php echo validation_errors(); ?></div>
        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
            <tr>
            	<td width="10%">&nbsp;</td>
              <td width="58%" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $strnama_cabang;?></td>
              <td width="3%">,</td>
              <td width="29%"><?php echo date("Y-m-d");?></td>
          </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                <td align="center">:</td>
                <td><?php echo $strnama_dealer;?></td>
            </tr>
            <tr>
            	<td align="right">&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Up Line</td>
                <td align="center">:</td>
                <td><?php echo $strnama_upline;?></td>
            </tr>
            <tr>
            	<td align="right">&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit</td>
                <td align="center">:</td>
                <td><?php echo $strnama_unit;?></td>
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
            <tr>
            	<td>Nota No :</td>
                <td><input type="text" name="intno_nota" size="30" value="<?php echo $max_id?>" readonly ></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
             <tr>
             <td  colspan="4">
             <table border="1"  width="95%" cellpadding="0" cellspacing="0" id="data" align="center">
             <tr>
            	<td>Banyaknya</td>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Jumlah</td>
            </tr>
             <tr>
            	<td align="center"><input type="text" name="intquantity" id="intquantity" value="1" readonly="readonly" size="2"/></td>
                <td><?php echo $strnama;?></td>
                <td><?php 
						if ($intid_wilayah == 1) {
							echo $intharga_jawa; 
							}
							elseif($intid_wilayah == 2) {
								echo $intharga_luarjawa;
								}
							elseif($intid_wilayah == 3) {
								echo $intharga_kualalumpur;
								}
							elseif($intid_wilayah == 4) {
								echo $intharga_luarkualalumpur;
								} ?></td>
                <td><?php if ($intid_wilayah == 1) {
							echo $intharga_jawa; 
							}
							elseif($intid_wilayah == 2) {
								echo $intharga_luarjawa;
								}
							elseif($intid_wilayah == 3) {
								echo $intharga_kualalumpur;
								}
							elseif($intid_wilayah == 4) {
								echo $intharga_luarkualalumpur;
								} ?>
				<input type="hidden" name="intomset"  value="<?php if ($intid_wilayah == 1) {
							echo $intharga_jawa; 
							}
							elseif($intid_wilayah == 2) {
								echo $intharga_luarjawa;
								}
							elseif($intid_wilayah == 3) {
								echo $intharga_kualalumpur;
								}
							elseif($intid_wilayah == 4) {
								echo $intharga_luarkualalumpur;
								} ?>"/></td>
            </tr>
            <?php 
			$i = 0;
			foreach($default as  $d):
			?>
            <tr>
            	<td align="center"><input type="text" name="intquantity_<?php echo $i++;?>" id="intquantity" value="<?php echo $d->intquantity?>" readonly="readonly" size="2"/></td>
                <td><?php echo $d->strnama;?></td>
                <td>0</td>
                <td>0</td>
            </tr>
            <?php endforeach; ?>
            <tr>
               <td colspan="4">
                  <div id="ButtonAdd" style="margin-left: 150px"></div></td>
              </tr>
            </table>
			<?php //$this->load->view("admin_views/penjualan/tambahan_bonus_barang_starterkit",$tambahan_bonus_barang_starterkit);?>                
            </td>
             <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DP</td>
                <td>:</td>
                <td><input type="text" name="intdp" id="intdp" onchange="return sisa();"/></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cash</td>
                <td>:</td>
                <td><input type="text" name="intcash" id="intcash" onchange="return sisa();"/></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Debit</td>
                <td>:</td>
                <td><input type="text" name="intdebit" id="intdebit" onchange="return sisa();"/></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kartu Kredit</td>
                <td>:</td>
                <td><input type="text" name="intkkredit" id="intkkredit" onchange="return sisa();"/></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sisa</td>
                <td>:</td>
                <td><input type="text" name="intsisa" id="intsisa" /></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">
              <input type="submit" value="Save" class="button"/>
              &nbsp;
              <input class="button" type="button" value="Cancel" onclick="location.href='penjualan';"/>
	      	 <input type="hidden" name="intid_unit" value="<?php echo $intid_unit;?>"/>
              <input type="hidden" name="intid_dealer" value="<?php echo $intid_dealer;?>"/>
              <input type="hidden" name="intid_cabang" value="<?php echo $intid_cabang;?>"/>
              <input type="hidden" name="intid_barang" value="<?php echo $intid_starterkit;?>"/>
              <input type="hidden" id="total" value="<?php if ($intid_wilayah == 1) {
							echo $intharga_jawa; 
							}
							elseif($intid_wilayah == 2) {
								echo $intharga_luarjawa;
								}
							elseif($intid_wilayah == 3) {
								echo $intharga_kualalumpur;
								}
							elseif($intid_wilayah == 4) {
								echo $intharga_luarkualalumpur;
								} ?>"/>  
			   <input type="hidden" id="intharga" name="intharga" value="<?php if ($intid_wilayah == 1) {
							echo $intharga_jawa; 
							}
							elseif($intid_wilayah == 2) {
								echo $intharga_luarjawa;
								}
							elseif($intid_wilayah == 3) {
								echo $intharga_kualalumpur;
								}
							elseif($intid_wilayah == 4) {
								echo $intharga_luarkualalumpur;
								} ?>"/>
              <input name="intid_jpenjualan" type="hidden" value="10" />
              <input type="hidden" name="totalbayar1" id="totalbayar1" />
              </td>
            </tr>
        </table>


        </form>
		               
			  </div>
			</div></div>
			</div>
		<?php $this->load->view('admin_views/sidebar_penjualan'); ?>
		<div style="clear: both;">&nbsp;</div>
	</div>
	</div>
	<div id="footer-bgcontent">
	<?php $this->load->view('admin_views/footer'); ?></div>
<script type="text/javascript">
    function sisa()
	  {
	   if($('#intdp').val() == ""){
            var a = 0;
        }else{
            var a = parseInt($('#intdp').val());
		}
		if($('#intcash').val() == ""){
            var b = 0;
        }else{
            var b = parseInt($('#intcash').val());
		}
        if($('#intkkredit').val() == ""){
            var c = 0;
        }else{
            var c = parseInt($('#intkkredit').val());
		}
        if($('#intdebit').val() == ""){
            var d = 0;
        }else{
            var d = parseInt($('#intdebit').val());
		}
        var e = parseInt($('#total').val());
        var t = a + b + c + d;
		var sisa = e - t;
		$('#intsisa').val(formatAsDollars(sisa));
        $('#totalbayar1').val(e);
	  }
	  
	  function formatAsDollars(amount){

        if (isNaN(amount)) {
            return "0.00";
        }
        amount = Math.round(amount*100)/100;

        var amount_str = String(amount);

        var amount_array = amount_str.split(".");

        if (amount_array[1] == undefined) {
            amount_array[1] = "00";
        }
        if (amount_array[1].length == 1) {
            amount_array[1] += "0";
        }
        var dollar_array = new Array();
        var start;
        var end = amount_array[0].length;
        while (end>0) {
            start = Math.max(end-3, 0);
            dollar_array.unshift(amount_array[0].slice(start, end));
            end = start;
        }

        amount_array[0] = dollar_array.join(",");

        return (amount_array.join("."));
    }
</script>
