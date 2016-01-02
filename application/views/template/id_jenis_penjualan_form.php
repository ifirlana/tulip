<input type="hidden" name="nota_intid_jpenjualan" id ="jpenjualans" value="0" >
<select name="nota_intid_jpenjualan_t" class="config" id="intid_jpenjualan">
	<option value="0">-- Pilih Jenis Penjualan--</option>
	<?php
		
			foreach($query as $row)
			{
				echo "<option value=\"".$row->intid_jpenjualan."\">".$row->strnama_jpenjualan."</option>";
			}
		
	?>
</select>
<?php
	if(!isset($script) or $script == "" or empty($script) or $script == null)
	{
?> 
<script>
	$(document).ready(function()
	{
		$("#intid_jpenjualan").bind("change",function()
		{
			
			var	value			= $("#intid_jpenjualan").val();
			var	valuePromo	=	"<?php if(isset($promo)){ echo $promo;}else{ echo "0";}?>";
			var	url				=	"<?php if(isset($url)){ echo $url;}else{ echo "#";}?>";
			var	cabang		=	"<?php if(isset($intid_cabang)){ echo $intid_cabang;}else{ echo "0";}?>";
			
			if(value != 0) //harus berpromo.
			{
				con("value running");
			
				 $.ajax(
				 {
                    url		: url,
                    type	: 'POST',
                    data 	:
					{
						idjpenjualan		:	value,
						cabang				:	cabang,
						idPromo			:	valuePromo,
						view_data		:	window.view,
					},
                    dataType	:	'json',
                    cache		:	false,
                    beforeSend:
						function()
						{										
							$('#loadme').fadeIn(500);
						},
                    success		:	function(data)
                        {
                        	$('#loadme').fadeOut(500);
                            $.each(data, function(key)
							{
							/**
								$.each(key,function(keyV,val)
								{
									if(key == "html")
									{
										$(keyV).html(val);
										console.log("html "+keyV+" "+val):
									}
									if(key == "value")
									{
										$(keyV).val(val);
										console.log("value "+keyV+" "+val);
									}
								});
								*/
								console.log("hello");
							});	
                    	},
					});			
			}
			
			$("#jpenjualans").val(value); //set ke hidden
		});
	});
</script>
<?php 
	}
	else
	{
		echo $script;
	}?>