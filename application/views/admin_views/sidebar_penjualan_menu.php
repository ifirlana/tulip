<div id="sidebar">
<?php
	//untuk mengaktifkan control program
	$query = $this->db->query("select *,(select count(*) from control_program cp where CURDATE() BETWEEN cp.date_start and cp.date_end and cp.kode = c.kode)total from control_program c group by c.kode");
	//echo $query->num_rows()."<br />";
		$datacontrolprogram = array();
		foreach($query->result() as $row){
			$datacontrolprogram[$row->kode] = array("cek" =>$row->total);
			}
				$is_nota = $this->session->userdata('is_nota');
				$is_dp = $this->session->userdata('is_dp');
				if($is_nota == 1){
	?>
			<ul>
				<li>
					
					<ul>
                     
	<li><?php echo anchor('_registration','Starter Kit');?></li>
	<li><?php echo anchor('promorekrut','promorekrut');?></li>
                      <li><?php 
						echo anchor('penjualan/a_risan','DP Arisan');
						//echo anchor('penjualan/maintanance','DP Arisan');
						?></li>
                      <li><?php echo anchor('penjualan/bayar_arisan','Pembayaran Cicilan Arisan');?></li>
                    <?php if($is_dp == 1){  ?>
						<li><?php echo anchor('penjualan/dp_','DP');?></li> 
						<?php } ?>
                      <li><?php //echo anchor('penjualan/lunas','Pelunasan DP');?></li>
                      <li><?php echo anchor('penjualan/nota','Penjualan Lunas');?></li>
                      <li><?php echo anchor('evan/nota','Penjualan Lunas Efan');?></li>
                      <li><?php echo anchor('evan/notakomisi15','Penjualan 20% komisi 15% Efan');?></li>
					  <?php 
						//kondisi untuk spcr "special price"  untuk dihilangkan atau dimunculkan
					  if($datacontrolprogram["spcr"]["cek"] == 0){?>
                      <li><?php echo anchor('penjualan/spesial','Penjualan Spesial');?></li>
					  <?php }?>
                      <?php //<li> echo anchor('penjualan/istimewa','Smart Spending');</li> ?>
                      <li><?php echo anchor('penjualan/lg','LG');?></li>
                      <li><?php echo anchor('penjualan/hadiah','Hadiah');?></li>
                      <li><?php echo anchor('penjualan/promo','Promo 2 Free 1 Termurah'); ?></li>               
					  <li><?php echo anchor('penjualan/grand','Promo Password');?></li>
					                   
			<li><?php //echo anchor('promo2030/nota','Promo 20% - 30%');?></li>   
			<li><?php //echo anchor('diskon50/nota','Promo 50%');?></li>   
            					
 
			<li><?php echo anchor('penjualan/mini','Promo Mini Demo');?></li>               
			<li><?php //echo anchor('penjualan/gubrak_pass','Paket Gubrak');?></li> 
			<?php 
						//kondisi untuk spcr "special promo cabang"  untuk dihilangkan atau dimunculkan
					  /* if($datacontrolprogram["spct"]["cek"] == 1){ */?>
			<li><?php //echo anchor('MAIN/','Special Promo Cabang');?></li>      
            	<?php }?>	                       
                <?php 
						//kondisi untuk penebusan upline abo  untuk dihilangkan atau dimunculkan
					  if($datacontrolprogram["abo"]["cek"] == 1 ){?>
						<li><?php echo anchor('penjualan/specialBeforeAbo','Penebusan Rek Ayo Rek');?></li>      
						<?php }?>	      
                     <?php  echo "<li>".anchor('membershipBarcode','Barcode Member')."</li>"; ?>
					 
                    </ul>
					
				
                   
			</ul>
			<?php } ?>
		</div>
		<!-- end #sidebar -->