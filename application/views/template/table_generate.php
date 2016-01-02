<?php
if(isset($header))
{
	echo $header;
} 
	?>
<table width="100%" border='1' cellspacing="0">
	<?php 
	if(isset($query))
	{
		if(!isset($content_header))
		{
			echo "<tr>";
			foreach($query->list_fields() as $col)
			{
				echo "<th align='center'>".$col."</th>";
			}
			echo "</tr>";
		}
		else
		{
			echo $content_header;
		}
		foreach($query->result_array() as $key)
		{
			echo "<tr>";
			foreach($key as $row)
			{
				echo "<td>".$row."</td>";
			}
			echo "</tr>";
		}
	}
	?>
</table>