<table id="data" style="width:100%;">
<? /*
<tr>
    <td style="width:70%;" align='center'>&nbsp;</td>
    <td style="width:10%;">Combo 2</td>
    <td style="width:20%;">
	    <input type="checkbox" class="comboPaketCheck2" value="comb2" onclick="load_promo_combo(2)" />
	    <input type="hidden" id="comboPaket2" class="comboPaket2" name="comboPaket2" size="2" disabled="disabled"/>
    </td>
</tr>
*/ 
	$query	=	$this->combo_mdl->selectPromocombo();
	$i = 1;
	foreach($query->result() as $row){
		if($i == 61or $i== 71 or $i == 81){//editan ntr hapus aja 
		
			echo "<tr>
					<td style='width:70%;' align='center'>&nbsp;</td>
					<td style='width:10%;'>Combo Pemilu ".$i."</td>";
			}
			else{//editan ntr hapus aja ini bagian aslinya
			echo "<tr>
					<td style='width:70%;' align='center'>&nbsp;</td>
					<td style='width:10%;'>Combo ".$i."</td>";
					} 
			echo "<td style='width:20%;'>
						<input type='checkbox' class='comboPaketCheck".$i."' value='".$row->kode."' onclick='load_promo_combo(".$i.")' />
						<input type='hidden' id='comboPaket".$i."' class='comboPaket".$i."' name='comboPaket".$i."' size='2' disabled='disabled'/>
						<input type='text' id='comboPaketRules".$i."' class='comboPaketRules".$i."' name='comboPaketRules".$i."' size='4' disabled='disabled' value='".$row->status."'/>
					</td>
				</tr>";
			
			$i++;
	}
?>

</table>
<input type='hidden' id='comboPaketRulesPoint' value="" readonly>         
<input type='hidden' id='comboCheckPoint' size='8' value="" readonly>         