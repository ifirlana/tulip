
<?php
 class lookup extends CI_Controller{
    
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
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromo($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		function lookupBarangBlue()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromoBlue($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		function lookupBarangSaja()
		{
			$keyword					= $this->input->post('term');
			
			$query						= $this->lookup_model->selectKode($keyword); 
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					
					$data['message'][] = array(
											'id'				=>$row->id,
											'value'		=>$row->nama_barang,
											'code'		=> $row->code,
											
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
		function getBarangSaja()
		{
			$keyword					= $this->input->post('code');
			$query						= $this->lookup_model->selectBarangKode($keyword); 
			$data['response'] = 'false';
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					
					$data['message'][] = array(
											'id'		=>$row->intid_barang,
											'value'		=>$row->strnama,
											'code'		=> $row->code,
										 );
				}
			}
			
			//$hello['message'][] = array("id"=>"YESA");
			//$hello['message'][] = array("id"=>"yuhu");
			echo json_encode($data);
			//echo json_encode($data);  
		}
		function getBarangHargaSaja()
		{
			$keyword					= $this->input->post('code');
			$query						= $this->lookup_model->selectBarangHargaKode($keyword); 
			$data['response'] = 'false';
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					
					$data['message'][] = array(
											'id'		=>$row->intid_barang,
											'value'		=>$row->strnama,
											'hjawa'		=>$row->intharga_jawa,
											'hljawa'		=>$row->intharga_luarjawa,
											'pvjawa'		=>$row->intpv_jawa,
											'pvljawa'		=>$row->intpv_luarjawa,
											'code'		=> $row->code,
										 );
				}
			}
			
			//$hello['message'][] = array("id"=>"YESA");
			//$hello['message'][] = array("id"=>"yuhu");
			echo json_encode($data);
			//echo json_encode($data);  
		}
		function getBarangKodeSaja()
		{
			$keyword					= $this->input->post('code');
			$query						= $this->lookup_model->selectBarangHargaKode($keyword); 
			$data['response'] = 'false';
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					
					$data['message'][] = array(
											'id'		=>$row->intid_barang,
											'value'		=>$row->strnama,
											'hjawa'		=>$row->intharga_jawa,
											'hljawa'		=>$row->intharga_luarjawa,
											'pvjawa'		=>$row->intpv_jawa,
											'pvljawa'		=>$row->intpv_luarjawa,
											'code'		=> $row->code,
										 );
				}
			}
			
			//$hello['message'][] = array("id"=>"YESA");
			//$hello['message'][] = array("id"=>"yuhu");
			echo json_encode($data);
			//echo json_encode($data);  
		}
		function lookupBarangNotSparepart()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromo($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		/* 
		* Function lookupBarangMetal()
		* Berfungsi untuk lookup barang metal berdasarkan table harga
		*
		*/
		function lookupBarangMetal()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromoMetal($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		/* 
		* Function lookupBarangTulip()
		* Berfungsi untuk lookup barang tulip berdasarkan table harga
		*
		*/
		function lookupBarangTulip()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromoTulip($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		function lookupBarangTulipNoBlue()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromoTulipNoBlue($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		function lookupBarangLainlain()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPromoLainlain($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		function lookupTebusCoba()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangTebus($keyword); 
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
						$um		= 0;
						$cicilan	= 0;
					}
					elseif($cabang[0]->intid_wilayah == 2) //wilayah luar jawa
					{
						$hrg		= $row->intharga_luarjawa;
						$pv		= $row->intpv_luarjawa;
						$um		= 0;
						$cicilan	= 0;
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
											'value7'		=> 0,
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
		function lookupTebusThink()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangTebusThink($keyword); 
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
						$um		= 0;
						$cicilan	= 0;
					}
					elseif($cabang[0]->intid_wilayah == 2) //wilayah luar jawa
					{
						$hrg		= $row->intharga_luarjawa;
						$pv		= $row->intpv_luarjawa;
						$um		= 0;
						$cicilan	= 0;
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
											'value7'		=> 0,
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
		function lookupTebusOval()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangTebusOval($keyword); 
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
						$um		= 0;
						$cicilan	= 0;
					}
					elseif($cabang[0]->intid_wilayah == 2) //wilayah luar jawa
					{
						$hrg		= $row->intharga_luarjawa;
						$pv		= $row->intpv_luarjawa;
						$um		= 0;
						$cicilan	= 0;
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
											'value7'		=> 0,
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
/*
*	Digunakan untuk lookupbarang custom
*/
	
	function lookupBarangCombo()
	{
		$keyword 				= $this->input->post('term');
		$jbarang 					= $this->input->post('state');
		$id_barang 				= $this->input->post('id_barang');
		$id_penjualan			= $this->input->post('id_penjualan');
		$id_destiny				= $this->input->post('id_destiny');
		$stat_bayar				= $this->input->post('stat_bayar');
		$stat_free				= $this->input->post('stat_free');
		$id_promo				= $this->input->post('id_promo');
		$pencarian				= $this->input->post('pencarian');
		$code				= $this->input->post('code');
		$intidcbg				= $this->input->post('intidcbg');
        $data['response'] 	= 'false'; 
        $query 						= $this->lookup_model->selectBarangPenjualanCombo($keyword,$pencarian,$id_promo,$code,$intidcbg); 
		$kondisi					= $this->control_model->selectKondisiClass($id_destiny);
		
		if(isset($kondisi[0]->id_destiny))
		{
			$stat_bayar	=	$kondisi[0]->stat_bayar;
			$stat_free	=	$kondisi[0]->stat_free;
			$id_destiny	=	$kondisi[0]->id_destiny;
		}
		
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = 0;
					$cicilan = 0;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
					$um = 0;
					$cicilan = 0;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => 0,
										'stat_bayar'		=> $row->qtybayar,
										'stat_free'			=> $row->qtyfree,
										'status_pencarian'			=> $row->status_pencarian,
										'id_destiny'		=> $id_destiny,
										'code'	=> $row->code,
										'intid_jbarang'	=>	$row->intid_jbarang,
										'id_group_class'	=>	$row->id_group_class, 
										'id_control_combo'	=>	$row->id_control_combo,
                                     );
            }
			           
        }
		
		 
        if('IS_AJAX')
        {
            echo json_encode($data); 
            
        }
        else
        {
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
	function lookupBarangCustom()
	{
		$keyword 				= $this->input->post('term');
		$jbarang 					= $this->input->post('state');
		$id_barang 				= $this->input->post('id_barang');
		$id_penjualan			= $this->input->post('id_penjualan');
		$id_destiny				= $this->input->post('id_destiny');
		$stat_bayar				= $this->input->post('stat_bayar');
		$stat_free				= $this->input->post('stat_free');
		$id_promo				= $this->input->post('id_promo');
		$pencarian				= $this->input->post('pencarian');
		$intidcbg				= $this->input->post('intidcbg');
		$code				= $this->input->post('code');
        $data['response'] 	= 'false'; 
        $query 						= $this->lookup_model->selectBarangPenjualanCustom($keyword,$pencarian,$code,$intidcbg); 
		$kondisi					= $this->control_model->selectKondisiClass($id_destiny);
		
		if(isset($kondisi[0]->id_destiny))
		{
			$stat_bayar	=	$kondisi[0]->stat_bayar;
			$stat_free	=	$kondisi[0]->stat_free;
			$id_destiny	=	$kondisi[0]->id_destiny;
		}
		
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = 0;
					$cicilan = 0;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
					$um = 0;
					$cicilan = 0;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => 0,
										'stat_bayar'		=> $stat_bayar,
										'stat_free'			=> $stat_free,
										'id_destiny'		=> $id_destiny,
										'code'	=> $row->code,
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
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
	
	/**
	* digunakan untuk function default barang free
	*/
	
	function lookupBarangFree()
	{
		$keyword 				= $this->input->post('term');
		$jbarang 					= $this->input->post('state');
		$id_barang 				= $this->input->post('id_barang');
		$id_penjualan			= $this->input->post('id_penjualan');
		$id_destiny				= $this->input->post('id_destiny');
		$stat_bayar				= $this->input->post('stat_bayar');
		$stat_free				= $this->input->post('stat_free');
		$id_promo				= $this->input->post('id_promo');
		$pencarian				= $this->input->post('pencarian');
		$intidcbg				= $this->input->post('intidcbg');
		$code						= $this->input->post('code');
		$data['response'] 	= 'false'; 
        $query 						= $this->lookup_model->selectBarangPenjualanFreeCustom($keyword, $id_barang, $pencarian, $id_promo,$code,$intidcbg); 
		//echo $data['message'] = $query;
		$kondisi					= $this->control_model->selectKondisiClass($id_destiny); 
		
		if(isset($kondisi[0]->id_destiny))
		{
			$stat_bayar	=	$kondisi[0]->stat_bayar;
			$stat_free	=	$kondisi[0]->stat_free;
			$id_destiny	=	$kondisi[0]->id_destiny;
		}
		
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = 0;
					$cicilan = 0;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
					$um = 0;
					$cicilan = 0;
                }
                $data['message'][] = array(
                                        /* 'id'=>$row->intid_barang, */
                                        'id'=>$row->intid_barang_free,
										'value'=>$row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => 0,
										/* 'stat_bayar'		=> $stat_bayar,
										'stat_free'			=> $stat_free, */
										'stat_bayar'		=> $row->qtybayar,
										'stat_free'			=> $row->qtyfree,
										'status_pencarian'			=> $row->status_pencarian,
										'id_destiny'		=> $id_destiny,
										'code'	=> $row->code,
											'intid_jbarang'	=>	$row->intid_jbarang,
											'id_group_class'	=>	$row->id_group_class,
										'id_control_combo'	=>	$row->id_control_combo,
                                     );
            }
			           
        }
		
		if('IS_AJAX')
        {
            echo json_encode($data); 
            
        }
        else
        {
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
	
	function lookupBarangDestiny()
	{
		$keyword 				= $this->input->post('term');
		$jbarang 				= $this->input->post('state');
		$id_barang 				= $this->input->post('id_barang');
		$id_penjualan			= $this->input->post('id_penjualan');
		$id_destiny				= $this->input->post('id_destiny');
		$stat_bayar			= $this->input->post('stat_bayar');
		$stat_free				= $this->input->post('stat_free');
		$id_promo				= $this->input->post('id_promo');
		$pencarian				= $this->input->post('pencarian');
		$intidcbg				= $this->input->post('intidcbg');
		$code					= $this->input->post('code');
        $data['response'] 	= 'false'; 
       // $query 					= $this->lookup_model->selectBarangPenjualanCustom($keyword,$pencarian,$code,$intidcbg); 
		$query						= $this->lookup_model->selectBarangPromo($keyword); 
		$kondisi					= $this->control_model->selectKondisiClassDetail($id_destiny);
		
		if(isset($kondisi[0]->id_destiny))
		{
			$stat_bayar	=	$kondisi[0]->stat_bayar;
			$stat_free	=	$kondisi[0]->stat_free;
			$id_destiny	=	$kondisi[0]->id_destiny;
		}
		
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = 0;
					$cicilan = 0;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
					$um = 0;
					$cicilan = 0;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => 0,
										'stat_bayar'		=> $stat_bayar,
										'stat_free'			=> $stat_free,
										'id_destiny'		=> $id_destiny,
										'code'	=> $row->code,
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
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
		/* 
		* Function lookupBarang()
		* Berfungsi untuk lookup barang All Item berdasarkan table harga
		*
		*/
		function lookupBarangSparepart()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangSparepart($keyword); 
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		// end. lookupSparepart
		
		//
		//	function lookupBarangKondisi()
		//	digunakan diprebarui lookupBarang()
		/* 
		* Function lookupBarangFreeCode()
		* Berfungsi untuk lookup barang All Item berdasarkan table harga
		*
		*/
		function lookupBarangFreeCode()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$code					= $this->input->post('code1');
			$nama_barang					= $this->input->post('nama_barang');
			$data['response']		= 'false'; 
			
			$query						= $this->lookup_model->selectBarangPromoCode($keyword," ",$nama_barang);
			$kondisi					= $this->promo_model->promoClass($id_promo,$id_penjualan); 
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
											'id_destiny'		=> 0,
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
		//	function lookupBarangTebus()
		//	digunakan diprebarui lookupBarangTebus()
		/* 
		* Function lookupBarangTebus()
		* Berfungsi untuk lookup barang All Item berdasarkan table harga
		*
		*/
		function lookupBarangTebus()
		{
			$keyword					= $this->input->post('term');
			$id_barang				= $this->input->post('id_barang');
			$id_penjualan			= $this->input->post('id_penjualan');
			$id_control_class		= $this->input->post('id_control_class');
			$id_promo				= $this->input->post('id_promo');
			$pencarian				= $this->input->post('pencarian');
			$data['response']		= 'false'; 
			$query						= $this->lookup_model->selectBarangPenjualanCustomTebus($keyword,$pencarian); 
			$kondisi					= $this->promo_model->selectPromoControlTebus($id_promo,$id_penjualan)->result(); 
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
						$um		= 0;
						$cicilan	= 0;
					}
					elseif($cabang[0]->intid_wilayah == 2) //wilayah luar jawa
					{
						$hrg		= $row->intharga_luarjawa;
						$pv		= $row->intpv_luarjawa;
						$um		= 0;
						$cicilan	= 0;
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
											'value7'		=> 0,
											'stat_bayar'		=> $kondisi[0]->stat_bayar,
											'stat_free'			=> $kondisi[0]->stat_free,
											'id_destiny'		=> 0,
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
		
	function lookupUnit()
	{
		
        $this->load->model('Penjualan_model');
		
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectUnit($keyword); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_unit,
                                        'value' => $row->strnama_unit,
                                        'value1' => $row->strnama_dealer,
					'value2' => $row->strkode_dealer,
                                     );  
            }
			           
        }
		
		 
        if('IS_AJAX')
        {
            echo json_encode($data); 
            
        }
        else
        {
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
	
	function lookupUpline()
	{
		
        $this->load->model('Penjualan_model');
		
		$keyword = $this->input->post('term');
		$unit = $this->input->post('state');
		$data['response'] = 'false'; 
		$query = $this->Penjualan_model->selectUpline($keyword, $unit); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->strkode_dealer,
										'intid_dealer' => $row->intid_dealer,
                                        'value' => strtoupper($row->strnama_dealer),
                                        'value1' => $row->strkode_upline,
					'value2' => $row->strnama_upline,
					'value3' => $row->intlevel_dealer,
					'value4' => $row->steamer,
					'value5' => $row->emc,
					'value6' => $row->chooper,
					'value7' => $row->metal_5lt,
					'value8' => $row->metal_7lt,
					'value9' => $row->metal_7in1,
					'challhut' =>$row->is_hut,
					'promo' =>$row->is_promo,
					'challen' => $row->is_ng,
                                     );  
            }
        }
        if('IS_AJAX')
        {
            echo json_encode($data); 
            
        }
        else
        {
            $this->load->view('admin_views/autocomplete/index',$data); 
        }
	}
} 