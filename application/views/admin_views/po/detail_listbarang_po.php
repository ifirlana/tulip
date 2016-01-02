<?php
	if(isset($query) and $query->num_rows() > 0)
	{
		$i = 0;
		echo "<p><div id='divListBarang'><br /><ul style='list-style-type:decimal;' id='dataListBarang'>";
		foreach($query->result() as $Rows)
		{
			echo "<li  id='listBarang'>
			<input name='quantity[]' type='text' size='1' value='".$Rows->quantity."'  />
           <input name='strnama[]' type='text' size='40' value='".$Rows->strnama."' readonly='true'  />
           <input name='keterangan[]' type='text' size='30' value='".$Rows->keterangan."'  />
           <input name='intid_barang[]' type='hidden' size='5' value='".$Rows->intid_barang."'  />
           <input name='no[]' type='hidden' size='10' value='".$no_po."' readonly='true' />
		   <input type='hidden' id='hargaSatuan_'   value='0' />
           </li>";
		   $i++;
		}
		echo "</ul><input type='submit'></div></p>";
	}
?>