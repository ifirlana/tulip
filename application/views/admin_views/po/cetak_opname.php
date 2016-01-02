<h2 class="title"> Laporan Stok Opname</h2>
                            <a href="javascript:window.print()" onclick="location.href='../../../po/Lap_stock_op';"><img src="<?php echo base_url();?>/images/print.jpg"/></a>
		 <table width="90%" border="1" cellpadding="1" cellspacing="1" id="data" align="center">
                            <thead>
                                <tr class="table" align="center" bgcolor="#CCCCCC" >
                                 <!-- <th width="27" >&nbsp;</th>
                                  <th width="183">&nbsp;</th>
                                 --> 
                                 <th width="49" rowspan="2">Nama Barang</th>
                                 <th colspan="2">Stok Awal</th>
                                  <th colspan="2">Masuk</th>
                                  <th colspan="2" >Keluar</th>
                                  <th colspan="2" >Fisik</th>
                                  <th colspan="2" >Sisa</th>
                                </tr>
                                <tr bgcolor="#CCCCCC"  class="table" align="center" >
                                    <th width="22" >Set</th>
                                    <th width="23">Pcs</th>
                                    <th width="23">Set</th>
                                    <th width="23" >Pcs</th>
                                  <th width="28">Set</th>
                                  <th width="29" >Pcs</th>
                                  <th width="22" >Set</th>
                                    <th width="23" >Pcs</th>
                                    <th width="22" >Set</th>
                                    <th width="23" >Pcs</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                <!-- ============isi ============ -->

                                <?php
                                $i=1;
								if(!empty($po)){
foreach($po as $m) : 
    ?>

                          <tr class='data' align='center'>
            
           <!-- <td align='left'>&nbsp;<?php echo $m->datetgl; ?></td>-->
            <td align='left'>&nbsp;<?php echo $m->strnama; ?></td>
            <td align='left'>&nbsp;<?php //echo $m->pcs_awal; 
			$brg_m = $this->db->query("select nota_detail.intquantity as set_awal from nota_detail
			inner join barang on barang.intid_barang = nota_detail.intid_barang
			inner join nota on nota.intid_nota = nota_detail.intid_nota
			where barang.intid_jsatuan=2  and barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($brg_m)){
				$set_awal = $brg_m->set_awal;
			}else{
				$set_awal=0;
			}
			echo $set_awal;
			?></td>
            <td align='left'>&nbsp;<?php 
			$brg_m2 = $this->db->query("select nota_detail.intquantity as pcs_awal from nota_detail
			inner join barang on barang.intid_barang = nota_detail.intid_barang
			inner join nota on nota.intid_nota = nota_detail.intid_nota
			where barang.intid_jsatuan=1  and barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($brg_m2)){
				$pcs_awal = $brg_m2->pcs_awal;
			
			}else{
				$pcs_awal=0;
				}
			echo $pcs_awal;	
			?></td>
            <td align='left'>&nbsp;<?php 
			$set_m = $this->db->query("select a.reg_set as set_masuk from po_detail a
			inner join barang on barang.intid_barang = a.intid_barang
			inner join po on po.intid_po = a.intid_po
			where barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($set_m)){
				$set_masuk=$set_m->set_masuk;
			
			}else{
				$set_masuk=0;
				}
				echo $set_masuk;
			 ?></td>
            <td align='left'>&nbsp;<?php 
			$set_m = $this->db->query("select a.reg_pcs as pcs_masuk from po_detail a
			inner join barang on barang.intid_barang = a.intid_barang
			inner join po on po.intid_po = a.intid_po
			where barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($set_m)){
				$pcs_masuk = $set_m->pcs_masuk;
			
			}else{
				$pcs_masuk=0;
				}
				echo $pcs_masuk;
			?></td>
            <td align='left'>&nbsp;<?php 
			$set_m = $this->db->query("select retur_detail.set as ret_set from retur_detail
			inner join barang on barang.intid_barang = retur_detail.intid_barang
			inner join retur on retur.intid_retur = retur_detail.intid_retur
			
			where barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($set_m)){
				$ret_set=$set_m->ret_set;
			
			}else{
				$ret_set=0;
				}
				echo $ret_set;
			 ?></td>
            <td align='left'>&nbsp;<?php 
			$set_m = $this->db->query("select retur_detail.pcs as ret_pcs from retur_detail
			inner join barang on barang.intid_barang = retur_detail.intid_barang
			inner join retur on retur.intid_retur = retur_detail.intid_retur
			
			where barang.intid_barang='".$m->intid_barang."'")->row();
			if(!empty($set_m)){
				$ret_pcs = $set_m->ret_pcs;
			
			}else{
				$ret_pcs=0;
				}
			echo $ret_pcs;	
			 ?></td>
           <td align='left'>&nbsp;<?php 
		   if(!empty($m->fisik_pcs)){
			   $fisik_pcs=$m->fisik_pcs;
		   echo $m->fisik_pcs; 
		   }else{
			   $fisik_pcs=0;
			   }
		   ?></td>
            <td align='left'>&nbsp;<?php 
			if(!empty($m->fisik_set)){
				$fisik_set=$m->fisik_set;
			 
			}else{
				
				$fisik_set=0;}
				echo $fisik_set;
			?></td>
        <?php 
		$sisa_pcs = ($pcs_awal + $pcs_masuk + $fisik_set) - ($ret_set);
	    $sisa_set = ($set_awal + $set_masuk + $fisik_pcs) - ($ret_pcs);

		?>
            <td align='left'>&nbsp;<?php echo $sisa_pcs; ?></td>
            <td align='left'>&nbsp;<?php echo $sisa_set; ?></td>
            </tr>
<?php endforeach; 
								}?> 
                            </tbody>
                        </table>
          <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
 
