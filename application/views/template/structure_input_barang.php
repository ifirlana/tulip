<input type="text"  data-intqty="<?php echo $count;?>"  name="intquantity[]" id="<?php echo $count;?>" class="intqty intquantity_<?php echo $count;?> <?php if(isset($class_intqty)){echo $class_intqty;}?>" size="2"  name="intquantity[]" maxlength="3" value="<?php if(isset($intqty)){echo $intqty;}else{echo 0;}?>" style="width:5%;" onkeyup="baris(<?php echo $count;?>); <?php if(isset($keyup)){ echo $keyup; } ?>" onkeypress="return isNumberKey(event);" autocomplete="off" />
<input type="text" class="name_<?php echo $count;?>" value="<?php if(isset($nameBarang)){ echo $nameBarang;}?>" style="width:50%;" disabled>
, Harga
<input type="text" name="intharga[]" class="hargasatuan hargasatuan_<?php echo $count;?>" size="4" value="<?php if(empty($intharga)){echo 0;}else{echo $intharga;}?>" readonly> PV :	
 = <input type="text" name="intpv[]" class="intpv intpv_<?php echo $count;?>" size="2" value="<?php if(empty($pv)){echo 0;}else{echo $pv;}?>" readonly>	
 <!--tem_om20--> <input type="hidden" class="temp_intpv_<?php echo $count;?>" size="2" value="<?php if(empty($intpv)){echo 0;}else{echo $intpv;}?>" readonly>
 = 
Omset<input type="text" name="inttotal_omset[]" class="totalomset totalomset_<?php echo $count;?>" size="4" value="<?php if(empty($inttotal_omset)){echo 0;}else{echo $inttotal_omset;}?>" readonly>
Bayar <input type="text" name="inttotal_bayar[]" class="totalbayar totalbayar_<?php echo $count;?>" size="4" value="<?php if(isset($inttotal_bayar)){echo $inttotal_bayar;}else{echo 0;}?>" readonly>
<!--dispersen --><input type="hidden" name="is_diskon[]" class="dispersen dispersen_<?php echo $count;?>" size="4" value="<?php if(($diskon) == 0){echo 1;}else{echo $diskon;}?>">

 <!--idbrg--> <input type="hidden" name="intid_barang[]" class="intid_barang_<?php echo $count;?>" size="4" name="intid_barang[]" value="<?php if(isset($intid_barang)){echo $intid_barang;}?>" readonly>
 <!-- hasil perhitungan setiap barang--> <input type="hidden" name="intharganew[]" class="intharganew intharganew_<?php echo $count;?>" size="4" value="<?php if(empty($intharganew)){echo 0;}else{echo $intharganew;}?>">
 <!-- oms10--> <input type="hidden" name="omset10[]" class="omset10 omset10_<?php echo $count;?>" size="4" value="<?php if(isset($omset10)){echo $omset10;}else{echo 0;}?>">
 <!--oms15 --><input type="hidden" name="omset15[]" class="omset15 omset15_<?php echo $count;?>" size="4" value="<?php if(isset($omset15)){echo $omset15;}else{echo 0;}?>">
 <!--oms20 --><input type="hidden" name="omset20[]" class="omset20 omset20_<?php echo $count;?>" size="4" value="<?php if(isset($omset20)){echo $omset20;}else{echo 0;}?>">
 <!--kom15 --><input type="hidden" name="komisi15[]" class="komisi15 komisi15_<?php echo $count;?>" size="4" value="<?php if(isset($komisi15)){echo $komisi15;}else{echo 0;}?>">
 <!--kom10 --><input type="hidden" name="komisi10[]" class="komisi10 komisi10_<?php echo $count;?>" size="4" value="<?php if(isset($komisi10)){echo $komisi10;}else{echo 0;}?>">
 <!--kom20 --><input type ="hidden" name="komisi20[]" class="komisi20 komisi20_<?php echo $count;?>" size="4" value="<?php if(isset($komisi20)){echo $komisi20;}else{echo 0;}?>">
 <!--tem_om10--> <input type="hidden" class="temp_omset10_<?php echo $count;?>" size="4" value="<?php if(empty($intomset10)){echo 0;}else{echo $intomset10;}?>">
 <!--tem_om15--> <input type="hidden" class="temp_omset15_<?php echo $count;?>" size="4" value="<?php if(empty($intomset15)){echo 0;}else{echo $intomset15;}?>">
 <!--tem_om20--> <input type="hidden" class="temp_omset20_<?php echo $count;?>" size="4" value="<?php if(empty($intomset20)){echo 0;}else{echo $intomset20;}?>">
 <!--tem_om20--> <input type="hidden" class="temp_omset_<?php echo $count;?>" size="4" value="<?php if(empty($inttotal_omset)){echo 0;}else{echo $inttotal_omset;}?>">
 <!--tem jbarang--> <input type="hidden" class="intid_jbarang temp_intid_jbarang_<?php echo $count;?>" size="4" value="<?php if(empty($intid_jbarang)){echo 0;}else{echo $intid_jbarang;}?>">
 <!--stat--> <input type="hidden" name="status[]" class="status status_<?php echo $count;?>" size="4" value="<?php echo $isiPromo ;?>">
<!-- intnonota--> <input type="hidden" name="intno_nota[]" size="4" value="<?php if(empty($intno_nota)){echo 0;}else{echo $intno_nota;}?>">
 <!--intvoc--> <input type="hidden" name="intvoucher[]" class="intvoucher intvoucher_<?php echo $count;?>" size="4" value="0">
<!-- id_promo--><input type="hidden" name="idPromo[]" id="idPromo" class="idPromo idPromo_<?php echo $count;?>" size="4" value="<?php echo $idPromo ;?> ">
 <!--id_penjualan--><input type="hidden" name="idPenjualan[]" id="idPenjualan" class="idPenjualan idPenjualan_<?php echo $count;?>" size="4" value="<?php echo $idPenj ;?>">
