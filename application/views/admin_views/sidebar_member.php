<div id="sidebar">
			<ul>
				<li>
					<ul>
                        <li><b><a href="<?php echo base_url(); ?>/website">Daftar</a> </b></li>
                        <?php if (($this->session->userdata('privilege')== 1)) {?><li><b><?php echo anchor('website/resetPass','Hard Reset'); ?></b></li> <?php } ?>
                        
                     <!--   <li><b><a href="<?php echo base_url(); ?>/website/resetPass">Ubah Data</a> </b></li>-->
	                </ul>
	            </li>
			</ul>
		</div>
		<!-- end #sidebar -->