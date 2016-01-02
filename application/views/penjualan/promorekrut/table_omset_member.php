<h2 class="title">Omset</h2>
<table width="100%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
            <th >No</th>
            <th >Tanggal</th>
            <th >No Nota</th>
            <th >Nama Member</th>
            <th width="30" >Status Nota</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
			$i=0;
			$total = 0;
			if(isset($omset) and !empty($omset))
			{
				foreach($omset as $m) :				
				$temp = $i;
				$i = $i + 1;
				$isdes='';
				if($m->status_nota == 1):
				$isdes = "checked disabled";
				endif;
			?>
		
			<tr class='data' align='center'>
				<td ><?php echo $i; ?><input type='checkbox'  name='pilih[]' class ='chkuser' onClick='cekOmset(this.id)' id='id_<?php echo $temp; ?>' <?php echo $isdes;?> value = '<?php echo $m->intno_nota;?>' />
				<input type='hidden' name='nomor_nota[]' id='intno_nota_<?php echo $temp;?>' value='<?php echo $m->intno_nota;?>' /></td>
				<td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
				<td align='left'>&nbsp;<?php echo $m->intno_nota; ?></td>
				<td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
				<td align='left'>&nbsp;<?php echo $m->status_nota; ?></td>
				
				
			</tr>
			<?php 
			//$total = $total + $m->inttotal_omset;
			endforeach; 
		}?>
		
		<tr class='data' align='center'>
        	<td align="right" colspan="2">
			<input type='hidden' id='tracker009' name='tracker009' value='<?php echo $temp;?>' />
			<input type='hidden' id='tracker099' value='' />
				Jumlah Rekrut yang ditebus </td>
				<td align="left">&nbsp;<?php //echo number_format($total)?><input type='text' id='total' value='0' readonly /></td>
				<td >Pernah tebus </td>
				<td align="left">&nbsp;<?php //echo number_format($total)?><input type='text' id='total1' value='0' readonly /></td>
        </tr>
		
    </tbody>
</table>
<table width="100%">
	<tr align="center">
			<td><h2 class="title">PERSEN</h2></td>
			<td><input type="checkbox" name="persen" id="persen1" class="prs" value="0.7">Diskon 30%</td>
			<td><input type="checkbox" name="persen" id="persen2" class="prs"  value="0.65">Diskon 35%</td>
			<td><input type="checkbox" name="persen" id="persen3" class="prs"  value="0.6">Diskon 40%</td>
			<!-- <td><input type="checkbox" name="persen" id="persen4" class="prs"  value="0.55">Diskon 45%</td> -->
	</tr>
	

</table>
