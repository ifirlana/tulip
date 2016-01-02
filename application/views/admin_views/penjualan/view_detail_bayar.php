<?php $this->load->helper('HTML'); 
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<h2 class="title">
    No. Nota : <?php echo $max_id?><br>
    Dealer : <?php echo $total_bayar->strnama_dealer?><br>
    Unit : <?php echo $total_bayar->strnama_unit?><br>
    Group : <?php echo $total_bayar->group?><br>
    </h2>
<p>&nbsp;</p>
<?php if($total_bayar->intjeniscicilan == 5):?>
<form id="arisan_form" method="post">
    
    <table width="70%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
        <tr align="center" class="" bgcolor="grey">
            <th colspan="7">Angsuran</th>
         </tr>
         <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>Keluar Barang</th>
        </tr>
        <?php
        if(empty($view_bayar)){
        ?>
        <tr>
            <td colspan="6" align="center" bgcolor="red">Belum Ada Pembayaran Arisan</td>
        </tr>
        <?php
        }else{
        $no=1;
        foreach($view_bayar as $v): //echo $v->intid_arisan; echo $max_id;?>
       
        <tr>
            <td align="center"><?php echo ($v->c1==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 1,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>
';?></td>
            <td align="center"><?php echo ($v->c2==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 2,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>
'?></td>
            <td align="center"><?php echo ($v->c3==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 3,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>
'?></td>
            <td align="center"><?php echo ($v->c4==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 4,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>
'?></td>
            <td align="center"><?php echo ($v->c5==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 5,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>
'?></td>
		 <td align="center"><?php 
			if($v->keluar_barang==0){
				if($v->c1!=0 &&$v->c2!=0 &&$v->c3!=0 &&$v->c4!=0 &&$v->c5!=0){
					echo '<a title=\'keluar barang\' href=\'javascript:void(0)\' onclick=\'keluar_barang('.$v->intid_arisan.', 5,'.$intid_unit.','.$intid_dealer.','.$intid_awal.')\'>Click Disini</a>';
				}else{
					echo "Pelunasan dahulu"; 
					}
			}else{
				echo '<img title="Keluar Barang" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>';
			}
			?></td>

            
        </tr>
        <?php $no++;endforeach; }?>
    </table>
</form>
<?php else:?>
<form id="arisan_form" method="post">
    <table width="70%" border="1" style="font-size: 12px;" cellpadding="1" cellspacing="1" align="center">
        <tr align="center" class="" bgcolor="grey">
            <th colspan="8">Angsuran</th>
         </tr>
         <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>Keluar Barang</th>
        </tr>
        <?php
        if(empty($view_bayar)){
        ?>
        <tr>
            <td colspan="5" align="center" bgcolor="red">Belum Ada Pembayaran Arisan</td>
        </tr>
        <?php
        }else{
        $no=1;
        foreach($view_bayar as $v):?>
        <tr>
     <td align="center"><?php echo ($v->c1==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 1,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>';?></td>
     <td align="center"><?php echo ($v->c2==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 2,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php echo ($v->c3==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 3,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php echo ($v->c4==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 4,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php echo ($v->c5==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 5,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php echo ($v->c6==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 6,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php echo ($v->c7==0)?'<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'klik_bayar('.$v->intid_arisan.', 7,'.$v->intid_arisan_detail.')\'>Belum Bayar</a>':'<img title="Sudah Bayar" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'?></td>
     <td align="center"><?php 
	 if($v->keluar_barang==0){
		if($v->c1!=0&&$v->c2!=0&&$v->c3!=0&&$v->c4!=0&&$v->c5!=0&&$v->c6!=0&&$v->c7!=0){
			echo '<a title=\'Klik Untuk Bayar\' href=\'javascript:void(0)\' onclick=\'keluar_barang('.$v->intid_arisan.', 7,'.$intid_unit.','.$intid_dealer.','.$intid_awal.')\'>Click Disini</a>';
		}else{
			echo 'pelunasan dahulu';
			}
	 }else{
		echo '<img title="Keluar Barang" src="'.base_url().'images/ico_alpha_CheckMarkGreen_2_16x16.png" align="absmiddle"/>'; 
	 }?></td>
        </tr>
        <?php $no++;endforeach; }?> 
    </table>
</form>

<?php endif;?>
<script>
	function klik_bayar(id, cicilan,intid_nota){
        var no_nota = $("#intno_nota").val();
		$('#klik_b').html('');
        $('#klik_b').html('Are You Sure ??');
        $('#klik_b').dialog('option','width',450);
                    $('#klik_b').dialog('option','title','Confirm');
                    $('#klik_b').dialog('option','buttons',{"Ok" : function(){
                    $('#klik_b').dialog('close');
                    $.ajax({
                                  type: 'POST',
                                  url: '<?php echo base_url(); ?>penjualan/update_cicilan/'+id+'/'+cicilan+'/'+no_nota+'/'+intid_nota,
                                  data: $(this).formSerialize(),
								  success: function(data) {
                                      location.href='<?php echo base_url(); ?>penjualan/cetak_arisan/'+id+'/'+no_nota;
                                  }
                              })

		},"Cancel" : function()
			{
				$('#klik_b').dialog('close');
			}
		}).dialog('open');        
    }
	function keluar_barang(id, cicilan, unit, member,detail){
        var no_nota = $("#intno_nota").val();
		$('#klik_b').html('');
        $('#klik_b').html('Are You Sure ??');
        $('#klik_b').dialog('option','width',450);
                    $('#klik_b').dialog('option','title','Confirm');
                    $('#klik_b').dialog('option','buttons',{"Ok" : function(){
                    $('#klik_b').dialog('close');
                    $.ajax({
                                  type: 'POST',
                                  url: '<?php echo base_url(); ?>penjualan/update_cicilan_keluar_barang/'+id+'/'+cicilan+'/'+no_nota+'/'+unit+'/'+member+'/'+detail,
                                  data: $(this).formSerialize(),
								  dataType: 'json',
								  success: function(data) {
                                    console.log(data);
									location.href='<?php echo base_url(); ?>penjualan/cetak_notahadiah/?kode='+data.intid_nota;
									
									}
                              })

		},"Cancel" : function()
			{
				$('#klik_b').dialog('close');
			}
		}).dialog('open');        
    }
</script>