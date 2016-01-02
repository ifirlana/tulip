<div id="sidebar">
			<ul>
				<li>
					
					<ul>
                     
                      <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('calon_manager/breakdown','BreakDown Manager');?></li><?php }?>
					  <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('coba1/coba/','OR CM');?></li><?php }?>
					  <?php //if (($this->session->userdata('privilege')== 1))?><!--<li><?php //echo anchor('calon_manager/data_manager','Data Manager');?></li>-->
                      <?php if ($this->session->userdata('privilege')== 1){?><li><?php echo anchor('calon_manager/data_pra','Data Pra CM');?></li><?php }?>
					  <?php if (($this->session->userdata('privilege')== 1)&&($this->session->userdata('privilege')== 2))?><li><?php 
					  echo anchor('calon_manager/register','Register Manager');
					 // echo anchor('penjualan/maintanance','Register Manager');?></li>
                      <?php if (($this->session->userdata('privilege')== 1)&&($this->session->userdata('privilege')== 2))?><li><?php
					  echo anchor('calon_manager/calon','Seleksi CM');
					   //echo anchor('penjualan/maintanance','Seleksi CM')?></li>
                      <?php if (($this->session->userdata('privilege')== 1)&&($this->session->userdata('privilege')== 2))?><li><?php echo anchor('calon_manager/view_rekrut2','View Ranting');?></li> 
					  <li><?php echo anchor('website','Register Member Online');?></li>
                      
                      
            	    </ul>
					
				
                   
			</ul>
		</div>
		<!-- end #sidebar -->