<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?>
<div id="page1">
<?php $this->load->view('admin_views/header'); ?>
</head>
<style>

.field_error{
	clear:both;
	color:#F00;
	margin-left:150px;
}
</style>

<div id="wrapper">
    <script type="text/javascript">
    $(document).ready( function() {
	$('div.result-satu').hide();
	$("#intid_unit").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUnit",
                            dataType: 'json',
                            type: 'POST',
                            data: req,
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
			$("#strnama_dealer").val("");
			$("#result001").empty();
			$("#result").empty();
                        $("#result").append(
                        "<input type='hidden' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                    );
                    },
                });
		                $("#strnama_dealer").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                    focus:function(event,ui){var q=$(this).val();$(this).val()=q;},select:
                        function(event, ui) {
			$("#result001").empty();
                        $("#result001").append(
                        "kode : <input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' size='23' readonly/>, upline : <input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='23' readonly/>"
                    );
                    },
                });

                $("#strnama_upline").autocomplete({
                    minLength: 2,
                    source:
                        function(req, add){
                        $.ajax({
                            url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                term: req.term,
                                state: $('#id_unit').val(),

                            },
                            success:
                                function(data){
                                if(data.response =="true"){
                                    add(data.message);
                                }
                            },
                        });
                    },
                });

        $("#bayar").dialog({
            autoOpen: false,
            modal: true,
            width: '300'
        });

        $("#f_error").dialog({
		autoOpen: false,
		modal: true
	});

     $("#klik_b").dialog({
		autoOpen: false,
		modal: true
	});

    });
	

     function view_bayar(id,detail,unit, member){
		var no_nota = $("#intno_nota").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>penjualan/view_bayar/'+id+'/'+no_nota+'/'+unit+'/'+member+'/'+detail,
            data: $(this).serialize(),
            success: function(data) {
                $("#bayar").html(data);
                $('#bayar').dialog('option','width',1000);
                $('#bayar').dialog('option','title','Pembayaran Arisan');
                $('#bayar').dialog('option','buttons',{
                    
                    "Close" : function(){
                        $('#bayar').dialog('close');
                    }	}).dialog('open').css('text-align','center');
            }
        });
    }

    function simpan_bayar(){
        var id_nota = $("#id_nota").val();
        var bulan = $('#bulan_bayar').val();
        var tahun = $('#tahun_bayar').val();
        var ket = $('#keterangan').val();
        var form = $('#arisan_form');
       $(form).ajaxSubmit({
            type: 'POST',
            url: '<?php echo base_url(); ?>penjualan/simpan_arisan/'+id_nota,
            data: {'bulan':bulan,
                    'tahun' :tahun,
                    'ket' :ket
        },

            success: function(data) {
                if (data=="double"){
                    $('#f_error').html('Sudah Melakukan Pembayaran Dibulan ini, Silahkan Pilih Bulan Lain');
                    $('#f_error').dialog('option','title','Confirm');
                    $('#f_error').dialog('option','buttons',{"Ok" : function(){
                    $('#f_error').dialog('close');

		}
		}).dialog('open');
	
                }else{
                    //alert(locate);
                     $('#f_error').html('Pembayaran Sukses');
                    $('#f_error').dialog('option','title','Confirm');
                    $('#f_error').dialog('option','buttons',{"Ok" : function(){
                    $('#f_error').dialog('close');
                    $("#bayar").dialog('close');

		}
		}).dialog('open');
                    
                   }
            }
        });
    }

   
	function actionName(){
		if($('.action-name').attr('checked') == false){
			$('#intid_unit').val("");
			$('#strnama_dealer').val("");
			$('#id_unit').remove();
			$('#result001').html('');
			$('div.result-satu').hide();
			$('div.result-dua').show();
		
		}else if($('.action-name').attr('checked') == true){
			
			$('div.result-dua').hide();
			$('div.result-satu').show();
		}
	}
</script>
</div>

<div id="page">
    <div id="page-bgtop">
        <div id="content">
            <div class="post">  <h2 class="title">DATA ARISAN</h2><br>

<?php
	echo ! empty($h2_title) ? '<h2>' . $h2_title . '</h2>': '';
	echo ! empty($message) ? '<p class="field_error">' . $message . '</p>': '';

	$flashmessage = $this->session->flashdata('message');
	echo ! empty($flashmessage) ? '<p class="field_error">' . $flashmessage . '</p>': '';
?>
<ul class="">
	<li><input type="checkbox" id="action-name" class="action-name" onClick="actionName()"> search by name</li>
</ul>
<div class="result-satu">
	<form method="post" action="<?php echo $form_action?>">
		<ul>
			<li>Unit : <input type="text" id="intid_unit" /></li> 
			<li>Nama : <input type='text' name='strnama_dealer' id='strnama_dealer' /></li>
			<div id="result"></div>
			<div id="result001"></div>
			<li>Bulan&nbsp; <?php echo $combo_bulan?>
                                <input type="text" name="tahun" id="tahun" size="5" value="<?php echo date('Y')?>">
                                </li>
			<li><input type="submit" name="submit" value="submit" /></li>
		</form>
		</div>
<div class="result-dua">
                 <form method="post" action="<?php echo $form_action?>">
                 <input name="intno_nota" id="intno_nota" type="hidden" value="<?php echo $max_id?>" />
                 <table>
                        <tr>
                            <td>
                                Cari Arisan 
                                <select name="arisan" id="arisan">
                                    <option value="">-Choose-</option>
                                    <option value="5">5x</option>
                                    <option value="7">7x</option>
                                </select>
                                Bulan&nbsp; <?php echo $combo_bulan?>
                                <input type="text" name="tahun" id="tahun" size="5" value="<?php echo date('Y')?>">
                                    Group&nbsp;
                                <select name="group" id="group" >
											<?php
												foreach($query_group as $row){
													echo "<option value='".$row->group."'>".$row->group."</option>";
												}
											?>
                                        </select>
                                <input type="submit" name="submit" value="Cari">
                            </td>
                        </tr>
                        
                    </table>
                </form>
				</div>
                <h3 class="title"><p align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ::. Arisan <?php echo $jenis. "x"?> Bulan <?php echo "<strong>" .$bulan." ".$tahun."</strong>"."
                            GROUP : <strong>".$group."</strong> .::"?></p></h3>
                
		<?php if(!empty($arisan)){?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
        <thead>
        <tr  align="center" class="table" >
           <th >No</th>
           <th >Nama Dealer</th>
           <th>Upline</th>
            <th >Unit</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th >Group</th>
            <th>Tanggal ikut</th>
            <th >Action</th>
            <th>Pembayaran</th>
        </tr>
    </thead>
    <tbody>

    <!-- ============isi ============ -->

		<?php
        if(!empty($arisan)){
            $i=1;
			foreach($arisan as $m) :
            $tahun = date('Y');
		?>
      	<tr class='data' align='center'>
			<td ><?php echo $i++; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_dealer; ?></td>
            <td align='left'>&nbsp;<?php  echo $m->strnama_upline; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama_unit; ?></td>
            <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
            <td align='left'>&nbsp;<?php echo $m->intquantity; ?></td>
            <td align='left'>&nbsp;<?php echo $m->group; ?></td>
            <td align='left'>&nbsp;<?php echo $m->tanggal; ?></td>
           <td align='left'>&nbsp;<?php 
		   if ($this->session->userdata('privilege')== 1){
		   echo anchor('penjualan/hapus_arisan/'.$m->intid_arisan."/".$b."/".$tahun."/".$m->group,'Hapus',array('class'=> 'delete','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')")) ?>
               	<?php 
				if($m->winner==0):?>
                <a href="<?php echo base_url()?>penjualan/ubah_pemenang/<?php echo $m->intid_arisan ?>/<?php echo $m->group?>/<?php echo $m->intjeniscicilan?>/<?php echo $b?>/<?php echo $tahun?>" title="Ubah Pemenang" onclick="return confirm ('Jika Anda Klik OK maka peserta Arisan dianggap sebagai Pemenang')">
                    <img  src="<?php echo base_url()?>images/bintang2.gif" align="absmiddle"/>
                </a>
                
                <?php endif;}?>
                
            </td>
            <td>
                <?php if($m->winner==0):?>
                <?php echo '<a href=\'javascript:void(0)\' onclick=\'view_bayar('.$m->intid_arisan.','.$m->intid_arisan_detail.','.$m->intid_unit.','.$m->intid_dealer.')\'>Cek Bayar</a>'?>
                <?php else:?>
                <img  src="<?php echo base_url()?>images/bintang.gif" align="absmiddle" title="Pemenang"/>
                <?php endif; ?>
            </td>
        </tr>
		<?php
        endforeach;
        ?>
        <tr><td colspan="5">Ket : <img  src="<?php echo base_url()?>images/bintang.gif" align="absmiddle"/>=Pemenang</td></tr>
        <?php
        }else{
        ?>
    <tr>
        <td colspan="6" align="center">
            No Data Display
        </td>
    </tr>
    <?php } ?>

    </tbody>
</table>
<?php }else{ ?>
         		
       No Result Found
       <?php } ?>    
                <input type="hidden" name="bulan_p" id="bulan" value="<?php echo $b?>">
                <input type="hidden" name="tahun_p" id="tahun" value="<?php echo $tahun?>">
                <input type="hidden" name="group_p" id="group" value="<?php echo $group?>">
<div id="bayar" style="width:400px; height: 100px;"></div>
<div id="f_error" style="width:400px; height: 100px;"></div>
<div id="klik_b" style="width:400px; height: 100px;"></div>
            </div>
        </div>

    </div>
    <!-- end #content -->
    <?php $this->load->view('admin_views/sidebar_penjualan'); ?><!-- end #sidebar -->
    <div style="clear: both;">&nbsp;</div>
</div>

<!-- end #page -->
<div id="footer-bgcontent">
    <?php $this->load->view('admin_views/footer'); ?></div>
<!-- end #footer -->
