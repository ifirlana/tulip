<?php
 class lookup_destiny extends CI_Controller{
    
	function  __construct() 
	{
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Week_model');
        $this->load->model('promo_model','promo_model');
        $this->load->model('lookup/lookup_model','lookup_model');
        $this->load->model('control/control_model','control_model');
        
	}
		
		
		//	function lookupBarangKondisi()
		//	digunakan diprebarui lookupBarang()
		/* 
		* Function lookupBarang()
		* Berfungsi untuk lookup barang All Item berdasarkan table harga
		*
		*/
		function lookupBarang()
		{
			$keyword				= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$id_destiny				= $this->input->post('id_destiny');
			$data['response']		= 'false'; 
			$query					= $this->lookup_model->selectBarangPromo($keyword); 
			$kondisi					= $this->promo_model->promoClassDestiny($id_destiny); 
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					if($cabang[0]->intid_wilayah == 1) //wilayah jawa
					{
						$hrg		= $row->intharga_jawa;
						$pv		= $row->intpv_jawa;
						$um		= $row->intum_jawa;
						$cicilan	= $row->intcicilan_jawa;
					}
					elseif($cabang[0]->intid_wilayah == 2) //wilayah luar jawa
					{
						$hrg		= $row->intharga_luarjawa;
						$pv		= $row->intpv_luarjawa;
						$um		= $row->intum_luarjawa;
						$cicilan	= $row->intcicilan_luarjawa;
					}
					else if($cabang[0]->intid_wilayah == 3) //wilayah kuala lumpur
					{
						$hrg		= $row->intharga_kualalumpur;
						$pv		= $row->intpv_kualalumpur;
						$um		= 0;
						$cicilan	= 0;
					}
					else if($cabang[0]->intid_wilayah == 4) //wilayah luar kuala lumpur
					{
						$hrg		= $row->intharga_luarkualalumpur;
						$pv		= $row->intpv_luarkualalumpur;
						$um		= 0;
						$cicilan	= 0;
					}
					$data['message'][] = array(
											'id'				=>$row->intid_barang,
											'value'		=>$row->strnama,
											'value1'		=> $hrg,
											'value2'		=> $row->intharga_luarjawa,
											'value3'		=> $pv,
											'value4'		=> $row->intpv_luarjawa,
											'value5'		=> $um,
											'value6'		=> $cicilan,
											'value7'		=> $row->intid_harga,
											'stat_bayar'		=> $kondisi[0]->stat_bayar,
											'stat_free'			=> $kondisi[0]->stat_free,
											'id_destiny'		=> $kondisi[0]->id_destiny,
											'code'		=> $row->code,
											'intid_jbarang'	=>	$row->intid_jbarang,
										 );
				}
			}
			if('IS_AJAX')
			{ 
				echo json_encode($data); 
			} 
			else
			{
				$data['message'][]['value'] = "ERROR";
				echo json_encode($data);
			}
		}
		// end destiny.
} 