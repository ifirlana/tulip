<div id="sidebar">
			<ul>
				<li>
					<ul>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('bank','Bank');?></li><?php }?>
					<?php if (($this->session->userdata('privilege')== 1)||($this->session->userdata('privilege')== 3)){?><li><?php echo anchor('barang','Barang');?></li><?php } ?>
                    <?php if (($this->session->userdata('privilege')== 1)||($this->session->userdata('privilege')== 3)){?><li><?php echo anchor('barang/baranghadiah','Barang Hadiah');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('dealer/home','Dealer');?></li><?php } ?>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('event','Event');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('kc','Kepala Cabang');?></li><?php } ?>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('manager','Manager');?></li><?php } ?>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('unit','Unit');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('user','User');?></li><?php } ?>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('wilayah','Wilayah');?></li><?php } ?>
                    <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('gathering/masterGathering','Gathering');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('pengejaran/master','Pengejaran');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('dealer/dealerpromo','Member Status');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('website/index','Registrasi Member App');?></li><?php } ?>
					<?php if ($this->session->userdata('privilege')== 1){?><li><?php //echo anchor('dealer/cabangakses','Cabang Status');?></li><?php } ?>
					
                    
                    </ul>
                   
				</li>	
				</ul>
		</div>
		<!-- end #sidebar -->