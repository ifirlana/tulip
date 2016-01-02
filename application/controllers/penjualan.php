<?php
 class Penjualan extends CI_Controller{
    
	function  __construct() {
        parent::__construct();
		$this->load->model('User_model');
        $this->load->model('Week_model');
        $this->load->model('Cabang_model');
        $this->load->model('Penjualan_model');
        $this->load->model('stock_barang_model','sbm');
		$this->load->model('Barang_model');
		$this->load->model('scan_model','scan_mdl');
		$this->load->model('membership_model','mdl_membership'); // 19 november 2013
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('barang_model');
		$this->load->model('combo_model','combo_mdl');
		if($this->session->userdata('is_nota') == 0)
		{
			redirect("login");
		}
		//added 2014 - 04 -03
		//kondisi kalau session mati
		/*
		if($this->session->userdata('username')){
		
		}
		else{
			$this->session->set_flashdata('message', 'Waktu penggunaan telah habis. Anda telah logout.');
			redirect("login");
			}
			*/
	}
   

	function lookup()
	{
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectCabang($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
                                        ''
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
	
	function lookupUnit(){
		
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

	
	function lookupUpline(){
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
	
	//added 2014 04 08 ifirlana@gmail.com
	//desc untuk penjualan abo
	
	function lookupDownline(){
		$keyword = $this->input->post('term');
		$unit = $this->input->post('unit');
		$upline = $this->input->post('upline');
		
		$data['response'] = 'false'; 
		$query = $this->Penjualan_model->selectDownline($keyword, $unit, $upline); 
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
					'week_kelahiran' => $row->intid_week,
					'starterkit' => $row->intid_starterkit,
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
	
	
	function getno_nota(){
        $cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $week = $this->Penjualan_model->selectWeek();
        /*$max = $this->Penjualan_model->get_MaxNota()->result();
        $getnota = $this->Penjualan_model->getNoNota($max[0]->intid_nota);
		if(empty($getnota[0]->intno_nota)){
			$nilai =1;
		} else {
			$nilai = $getnota[0]->intno_nota;
		}*/

        $getnota = $this->Penjualan_model->getNoNotaNew();
		$nilai = $getnota[0]->id;
		$id = $nilai + 1;
		$this->Penjualan_model->getNoNotaUpdate($id);
		//$noUrut = (int) substr($nilai, 6, 9);
        //$noUrut++;
        //$kode = $cabang[0]->intkode_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $noUrut);
		$kode = $cabang[0]->intid_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $nilai);
        return $kode;

    }

    function cetak_nota(){
		$data['back_url'] = $this->input->get('back_url');
        $max = $this->Penjualan_model->get_MaxNota()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNota($id);
        $data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_nota', $data);
	}

	function lookupBarang(){
		$keyword = $this->input->post('term');
		$jbarang = $this->input->post('state');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang($keyword, $jbarang); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangNoMetal(){
		$keyword = $this->input->post('term');
		$jbarang = 1;//$this->input->post('state');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang($keyword, $jbarang); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	
	function lookupBarangd20k15(){
		$keyword = $this->input->post('term');
		$jbarang = $this->input->post('state');
        $data['response'] = 'false'; 
		$cbg = $this->User_model->getCabang($this->session->userdata('username'));
		
        $query = $this->Penjualan_model->selectBarangControlPromo($keyword,"dis20k15", $cbg[0]->intid_cabang,$cbg[0]->intid_wilayah); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
										'is_voucher' => $row->is_voucher
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
	function saveNota()
	{
		$this->db->trans_start(); //transaction data
		$this->Penjualan_model->insertSaveNota($_POST);
		$id =$this->db->insert_id();
		$intid_barang = $this->input->post('intid_barang');
		$intharga = $this->input->post('intomset');
		
		//tambahan bonus
		$intid_barang_bonus 	= $this->input->post('intid_barang_bonus');
		$intquantity_bonus	 	= $this->input->post('intquantity_bonus');
		
		$i = $this->db->query("select intid_harga from harga where intid_barang  = $intid_barang");
        $intid_harga = $i->result();
		$data1 = array(
            'intid_nota' => $id,
            'intid_barang' => $this->input->post('intid_barang'),
			'intquantity' => $this->input->post('intquantity'),
			'intid_harga' => $intid_harga[0]->intid_harga,
			'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
			'intharga' => $intharga,
            
		);
		$this->Penjualan_model->add($data1);
		//$this->Penjualan_model->addStok($this->input->post('intid_barang'), $this->input->post('intquantity'), $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
		
		$j = $this->db->query("select intid_barang,intquantity from starter_kit where intid_barang_starterkit  = $intid_barang and  (select intid_week from week where curdate() between dateweek_start and dateweek_end) between intid_week_start and intid_week_end");
        $result = $j->result();
		for($i=0;$i<=sizeof($result);$i++){
			if(!empty($result[$i]->intid_barang)){
				$detail = array(
						'intid_nota' 			=> $id,
						'intid_barang'	        => $result[$i]->intid_barang,
						'intquantity'		    => $result[$i]->intquantity,
						'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
						'is_free' 				=> 1
				);
				$this->Penjualan_model->add($detail);
				//$this->Penjualan_model->addStok($result[$i]->intid_barang, 1, $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
			}
		}
		
		// tambahan barang bonus
		if(isset($intid_barang_bonus) and !empty($intid_barang_bonus))
		{
			for($i=0;$i<count($intid_barang_bonus);$i++)
			{
				$detail = array(
							'intid_nota' 			=> $id,
							'intid_barang'	        => $intid_barang_bonus[$i],
							'intquantity'		    => $intquantity_bonus[$i],
							'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
							'is_free' 				=> 1
					);
				$this->Penjualan_model->add($detail);
			}
		}
		// end.
		
		$row = $this->Penjualan_model->get_fromkodemember($this->input->post('intid_dealer'));		
		//menambah ke tabel rekrut maksimal 2//
		$this->Penjualan_model->insertGroupRekrutHadiah($this->input->post('strkode_upline'),$row[0]->strkode_dealer,$this->input->post('intno_nota'),'4',$this->input->post('intharga'));			
		
		//lakukan penginputan barcode data dan antrian
		$data_staterkit['intid_dealer'] = $this->input->post('intid_dealer');
		$data_staterkit['intid_cabang'] = $this->input->post('intid_cabang');
		
		$this->mdl_membership->insert_starterkit_barcode($data_staterkit);
		//end
		
		$this->db->trans_complete();//trasaksi data complete
		redirect('penjualan/cetak_stater');
	}

	function lglain()
	{
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_lglain', $data);
		 }else{
		 
		 	$id = $this->Penjualan_model->insertNotaHal($_POST,'LGLAIN');
			
			//ini penting bwt dirubah
			/*
			$r = $this->Penjualan_model->cekNota001($this->input->post('strkode_dealer'), $this->input->post('id_unit'), $this->input->post('totallg001'));
			for($i=0;$i<=sizeof($r);$i++){ 
				if(!empty($r[$i]->intid_nota)){	
					$this->Penjualan_model->updateNotaLg($r[$i]->intid_nota);
				}
			}
			*/
		
/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
				
			//$max = $this->Penjualan_model->get_MaxNota()->result();
            //$id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $noNota //$data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			 
		 $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota($nomor_nota[$pilih[$i]]);
				}
			}
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
		
		
			 
		
	}
	function lglain1()
	{
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_lglainnew', $data);
		 }else{
		 
		 	$id = $this->Penjualan_model->insertNotaHal($_POST,'LGLAINTam');
			
			//ini penting bwt dirubah
			/*
			$r = $this->Penjualan_model->cekNota001($this->input->post('strkode_dealer'), $this->input->post('id_unit'), $this->input->post('totallg001'));
			for($i=0;$i<=sizeof($r);$i++){ 
				if(!empty($r[$i]->intid_nota)){	
					$this->Penjualan_model->updateNotaLg($r[$i]->intid_nota);
				}
			}
			*/
		
/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
				
			//$max = $this->Penjualan_model->get_MaxNota()->result();
            //$id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'inttotal_bayar'	=> ( $data[$i]['intquantity'] * $data[$i]['intid_harga'] ),
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $noNota //$data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			 
		 $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota_new($nomor_nota[$pilih[$i]]);
				}
			}
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
		
		
			 
		
	}
	function lglainthink()
	{
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_lglainthink', $data);
		 }else{
		 
		 	$id = $this->Penjualan_model->insertNotaHal($_POST,'LGLAINthink');
			
			//ini penting bwt dirubah
			/*
			$r = $this->Penjualan_model->cekNota001($this->input->post('strkode_dealer'), $this->input->post('id_unit'), $this->input->post('totallg001'));
			for($i=0;$i<=sizeof($r);$i++){ 
				if(!empty($r[$i]->intid_nota)){	
					$this->Penjualan_model->updateNotaLg($r[$i]->intid_nota);
				}
			}
			*/
		
/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
				
			//$max = $this->Penjualan_model->get_MaxNota()->result();
            //$id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'inttotal_bayar'	=> ( $data[$i]['intquantity'] * $data[$i]['intid_harga'] ),
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $noNota //$data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			 
		 $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota_think($nomor_nota[$pilih[$i]]);
				}
			}
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
		
		
			 
		
	}
	function lglainoval()
	{
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_lglainoval', $data);
		 }else{
		 
		 	$id = $this->Penjualan_model->insertNotaHal($_POST,'LGLAINOval');
			
			//ini penting bwt dirubah
			/*
			$r = $this->Penjualan_model->cekNota001($this->input->post('strkode_dealer'), $this->input->post('id_unit'), $this->input->post('totallg001'));
			for($i=0;$i<=sizeof($r);$i++){ 
				if(!empty($r[$i]->intid_nota)){	
					$this->Penjualan_model->updateNotaLg($r[$i]->intid_nota);
				}
			}
			*/
		
/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
				
			//$max = $this->Penjualan_model->get_MaxNota()->result();
            //$id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'inttotal_bayar'	=> ( $data[$i]['intquantity'] * $data[$i]['intid_harga'] ),
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $noNota //$data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			 
		 $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota_oval($nomor_nota[$pilih[$i]]);
				}
			}
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
		
		
			 
		
	}
	
	function lglainrekrut10()
	{
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_rekrut10', $data);
		 }else{
		 
		 	$id = $this->Penjualan_model->insertNotaHal($_POST,'tebusRekrut10');
			
			
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'inttotal_bayar'	=> ( $data[$i]['intquantity'] * $data[$i]['intid_harga'] ),
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $noNota //$data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			 
		 $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				/* if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota_ten($nomor_nota[$pilih[$i]]);
				} */
						$this->Penjualan_model->updateNotaLgLain_intno_nota_ten($pilih[$i]);
			}
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
		
		
			 
		
	}
	
	function rekrutpersen()
	{
	
		//redirect('penjualan/perbaikan');
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			
			$jpenjualan = $this->Penjualan_model->getJenisPenjualanRekrut();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;
			

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/nota_rekrutpersen', $data);
			
		}else 
		{
		
			$jpenjualan = $this->Penjualan_model->getJenisPenjualanRekrut();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$id = $this->Penjualan_model->insertNotaHal($_POST,'tebusRekrut');
			
			$data = $this->input->post('barang');
			 
            for($i=1;$i<=sizeof($data);$i++){
			$noNota = 0;
			if (isset($data[$i]['nomor_nota']) == null || isset($data[$i]['nomor_nota']) == 0 || isset($data[$i]['nomor_nota']) == ''){
			$noNota = 0;
			}else{
			$noNota =isset($data[$i]['nomor_nota']);
			}
			
			//fahmi
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	    => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								 'id_jpenjualan'		=> $this->input->post('intid_jpenjualan'),
								'intomset10' 		=> $this->input->post('jml10'),
								'intpv' 					=> $this->input->post('intpv'),
								'intomset'			 	=> $this->input->post('jumlah'),
								'inttotal_bayar' 		=> $this->input->post('totalbayar1'),
								'nomor_nota'		=> $this->input->post('intno_nota')//$noNota //$data[$i]['nomor_nota']intno_nota
								);

            $this->Penjualan_model->add($detail);
			// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
				 
				
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
				   
			 }
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		  
			$pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
		//	var_dump($pilih );
			//$id_nota = $this->input->post('intid_nota');
			 for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				  // if(!empty($dataTebus[$i]['nomor_nota'])){
						//$this->Penjualan_model->tambahDataTebus($nomor_nota[$pilih[$i]],$id_nota[$pilih[$i]],'tebusRekrut');
					$db = $this->db->query("select intid_nota, intid_cabang from nota where intno_nota = '$pilih[$i]'");
					foreach($db->result() as $row){
					$data_tebus = array(	
						'intid_nota_old' 	=>$row->intid_nota,
						'intno_nota_old' 	=>$pilih[$i],
						'intid_nota_new'	=>$id,
						'intno_nota_new'	=>$this->input->post('intno_nota'),
						'intid_cabang'		=>$data['id_cabang'],
						'halaman' 				=>'tebusRekrut'
						);}
					$this->Penjualan_model->tambahDataTebus($data_tebus);
			} 

			/* $pilih = $this->input->post('pilih');
			$nomor_nota = $this->input->post('nomor_nota');
			for($i = 0; $i < sizeof($pilih);$i++){
				//echo ">>".$nomor_nota[$pilih[$i]]."<br />";
				if(!empty($nomor_nota[$pilih[$i]])){	
						$this->Penjualan_model->updateNotaLgLain_intno_nota_oval($nomor_nota[$pilih[$i]]);
				}
			} */
		 
			//redirect('penjualan/cetak_notalg');
			redirect('laporan/viewNotaid/'.$id);
		}
	}
	
	function check_omset() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun($id[0]->intid_dealer,$tahun,$wilayah);
				
				$this->load->view('admin_views/penjualan/omset', $data);
    }
	function check_omset_lain() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun_lain($id[0]->intid_dealer,$tahun,$wilayah);
				
				$this->load->view('admin_views/penjualan/omsetlain', $data);
    }
	function check_omset_lain_oval() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun_lain_oval($id[0]->intid_dealer,$tahun,$wilayah);
				
				$this->load->view('admin_views/penjualan/omsetlainoval', $data);
    }
    function check_omset_lain_new() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun_lain_new($id[0]->intid_dealer,$tahun,$wilayah);
				
				$this->load->view('admin_views/penjualan/omsetlainnew', $data);
    }
	function check_omset_lain_think() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun_lain_think($id[0]->intid_dealer,$tahun,$wilayah);
				
				$this->load->view('admin_views/penjualan/omsetlainthink', $data);
    }
	//buat tebus yg 10
	function check_omset_rekrut_sepuluh() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['omset'] = $this->Penjualan_model->getOmset_tahun_rekrut10_new($this->input->post('strkode_dealer'),$tahun,$wilayah);
					//echo $id[0]->intid_dealer;
				//var_dump($data['omset'] );
				$this->load->view('admin_views/penjualan/omsetlainrekrut10', $data);
    }
	function check_omset_lain_new_1() {
				
				$tahun = date('Y');
				
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$wilayah =  $cabang[0]->intid_wilayah;
				//echo $wilayah;
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$tebus['date_start_member']	= "2015-05-05";
				$tebus['date_end_member']		= "2015-05-30";
				$data['omset'] 		= $this->Penjualan_model->getOmset_tahun_rekrut_new_2($this->input->post('strkode_dealer'),$tebus['date_start_member'],$tebus['date_end_member']);
				// $data['omset'] = $this->Penjualan_model->getOmset_tahun_lain_new_1($this->input->post('strkode_dealer'),$tahun,$wilayah);
				$tebus['query'] 				= $data['omset'];
				$tebus['strkode_dealer']	= $this->input->post('strkode_dealer');
				//$this->load->view("penjualan/promorekrut/show_table_member_tebus_rekrut",$tebus);
				$this->load->view("penjualan/promorekrut/btn_promo_rekrut");
				$this->load->view('admin_views/penjualan/omsetlainnew_1', $data);
    }
	function getTable_member_tebus_rekrut()
	{
			$tebus['date_start_member']		= "2015-05-05";
			$tebus['date_end_member']		= "2015-05-30";
			$data['omset'] 		= $this->Penjualan_model->getOmset_tahun_rekrut_new_2($this->input->post('strkode_dealer'),$tebus['date_start_member'],$tebus['date_end_member']);
			// $data['omset'] = $this->Penjualan_model->getOmset_tahun_lain_new_1($this->input->post('strkode_dealer'),$tahun,$wilayah);
			$tebus['query'] 				= $data['omset'];
			$tebus['strkode_dealer']	= $this->input->post('strkode_dealer');
			$this->load->view("penjualan/promorekrut/show_table_member_tebus_rekrut",$tebus);
	}
	function tebuslg(){
		$this->load->view('admin_views/penjualan/tebuslg');
	}function tebuslglain(){
		$this->load->view('admin_views/penjualan/tebuslglain');
	}
	function tebuslglainnew(){
		$this->load->view('admin_views/penjualan/tebuslglainnew');
	}
	function tebuslglainthink(){
		$this->load->view('admin_views/penjualan/tebuslglainthink');
	}
	function tebuslglainoval(){
		$this->load->view('admin_views/penjualan/tebuslglainoval');
	}
	function tebuslglainnew_rekrut(){
		
			$jpenjualan = $this->Penjualan_model->getJenisPenjualanRekrut();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
		$this->load->view('admin_views/penjualan/tebuslglainnew_rekrut',$data);
	}
	//ini buat tebus rekrut yg 10
	function tebuslglainnew_rekrut10(){
		
			$jpenjualan = $this->Penjualan_model->getJenisPenjualanRekrut();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
		$this->load->view('admin_views/penjualan/tebuslglain_rekrut10',$data);
	}
	
	function lookupBarangLg(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangLg($keyword);
		if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                   
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->lg,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
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
	
	function cetak_notalg(){
        $max = $this->Penjualan_model->get_MaxNota()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNota($id);
        $data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_notalg', $data);
	}
	function dp_()
	{
		//kalau dibutuhkan password tinggal dibatasi dengan tanda //
		redirect('penjualan/dp');
		
		$data['error_message'] = "";
		if($this->input->post('grandpass')){
					$data['result'] = $this->Penjualan_model->get_password("dp", $this->input->post('grandpass'));
					if($data['result'] > 0){
						//$temp =md5('pass');
						redirect('penjualan/dp');
						//$this->load->view('admin_views/penjualan/mini_after_pass',$data);
						/*
						$cabang = $this->User_model->getCabang($this->session->userdata('username'));
						$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

						$data['cabang'] = $nm_cabang[0]->strnama_cabang;
						$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
						$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


						$data['user'] = $this->session->userdata('username');
						$data['max_id'] = $this->getno_notadp();
						
						$jpenjualan = $this->Penjualan_model->selectJPenjualan();
						foreach ($jpenjualan as $g)
						{
							$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
							$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
						}
						
						$this->load->view('admin_views/penjualan/nota_dp', $data);
						*/
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/dp_', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/dp_', $data);
		}
	}
	
	function dp(){
	//redirect("penjualan");
		if (!$_POST)
		{
            /*
			if($temp!=md5('pass')){
				redirect('penjualan/dp_');
			}
			*/
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_notadp();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualan();
			foreach ($jpenjualan as $g)
			{
			//kondisi TRADE IN tidak boleh digunakan
				if($cabang[0]->intid_cabang == 1){
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}else{
						if($g->intid_jpenjualan != 4){
							$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
							$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
							}
					}
			/*
				if($g->intid_jpenjualan != 4){
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
				*/
			}
			
			$this->load->view('admin_views/penjualan/nota_dp', $data);
		 }else{
			
			$this->db->trans_start();

            $this->Penjualan_model->insertNota($_POST);
			
			$max = $this->Penjualan_model->get_MaxNotaDp()->result();
            $id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'is_diskon'			=> $data[$i]['is_diskon'],
								'intnormal'			=> $data[$i]['intnormal'],
								'intvoucher'			=> $data[$i]['intvoucher']
								);

             $this->Penjualan_model->add($detail);
            }
            }

             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
             
            
             if(!empty($data_free[$i]['intid_id'])){
             
              
             $detail_free = array(
							'intid_nota' 			=> $id,
							'intid_barang'	        => $data_free[$i]['intid_id'],
							'intquantity'		    => $data_free[$i]['intquantity'],
                            'is_free' 				=> 1,
							'intid_harga'			=> 0,
							'nomor_nota'			=> $data_free[$i]['nomor_nota'],
							'is_diskon'			=> $data_free[$i]['is_diskon'],
							'intnormal'			=> $data_free[$i]['intnormal'],
							'intvoucher'			=> $data_free[$i]['intvoucher'],
							);
             $this->Penjualan_model->add($detail_free);
             }
               
		 	}
			$this->db->trans_complete();
			redirect('penjualan/cetak_notadp');
		}
		
	}
	
	function cetak_notadp(){
        $max = $this->Penjualan_model->get_MaxNotaDp()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNotaDp($id);
        $data['default'] = $this->Penjualan_model->get_CetakNotaDp($id);
        $this->load->view('admin_views/penjualan/cetak_notadp', $data);
	}
	
	function lunas() 
	{
		   $cabang = $this->User_model->getCabang($this->session->userdata('username'));
			
			$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] 			= $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] 		= $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] 	= $nm_cabang[0]->intid_wilayah;
			if($data['intid_wilayah'] == 1)
			{
				$data['price_type']		=	"Jawa";
			}else
			{
				$data['price_type']		=	"Luar Jawa";
			}
		$this->load->view('admin_views/penjualan/search_notadp',$data);
	
	}
	
	function lookupDp(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		$id_cabang = $nm_cabang[0]->intid_cabang;
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectNotaDp($keyword, $id_cabang); 
		if( ! empty($query) )
        {
			$data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                if($row->intlevel_dealer == 1)
				{
					$type_membership = 4;
				}
				else
				{
					$type_membership = 1;
				}
				$data['message'][] = array( 
                                        'id'						=>$row->intid_nota,
										'intid_unit'			=> $row->intid_unit,
										'intid_dealer'		=> $row->intid_dealer,
                                        'value' 				=> $row->intno_nota,
                                        'type_membership' => $type_membership, 
										'membership_name' => $row->strnama_dealer,
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
	
	function check_notadp() {
        if($this->input->post('ajax') == '1') 
		{

           
                $data['datadp'] = $this->Penjualan_model->getNotaDp($this->input->post('intno_nota'));
							
				$this->load->view('admin_views/penjualan/check_notadp', $data);
           
        }
    }
	
	function pelunasan_dp() {
        if($this->input->post('ajax') == '1') {

				$data['instalment_number']	=	$this->input->post("instalment_number");
                $data['id_unit']					=	$this->input->post("id_unit");
                $data['id_dealer']					=	$this->input->post("id_dealer");
                $data['type_membership']					=	$this->input->post("type_membership");
                $data['membership_name']					=	$this->input->post("membership_name");
                $datadp = $this->Penjualan_model->pelunasanNotaDp($this->input->post('no_notadp'));
				foreach ($datadp as $g)
				{
					$data['intid_dealer']	 				= $g->intid_dealer;
					$data['intid_upline']	 				= $g->intid_upline;
					$data['datetgl']	 					= $g->datetgl;
					$data['intid_week']	 					= $g->intid_week;
					$data['strnama_dealer']	 			= $g->strnama_dealer;
					$data['strnama_upline']	 			= $g->strnama_upline;
					$data['strkode_dealer']	 			= $g->strkode_dealer;
					$data['strnama_unit']	 			= $g->strnama_unit;
					$data['intomset10']	 				= $g->intomset10;
					$data['intomset20']	 				= $g->intomset20;
					$data['intdp']	 					= $g->intdp;
					$data['inttotal_omset']	 			= $g->inttotal_omset;
					$data['intkomisi10']	 			= $g->intkomisi10;
					$data['intkomisi20']	 			= $g->intkomisi20;
					$data['intpv']	 					= $g->intpv;
					$data['inttotal_bayar']	 			= $g->inttotal_bayar;
					$data['intsisa']	 				= $g->intsisa;
					$data['intid_nota']	 				= $g->intid_nota;
				}
				
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
			
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

				$data['cabang'] 			= $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] 		= $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] 	= $nm_cabang[0]->intid_wilayah;
				if($data['intid_wilayah'] == 1)
				{
					$data['price_type']		=	"Jawa";
				}else
				{
					$data['price_type']		=	"Luar Jawa";
				}
				
				$data['detaildp'] = $this->Penjualan_model->pelunasanNotaDetailDp($this->input->post('no_notadp'));
				
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            	$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$data['cabang'] = $nm_cabang[0]->strnama_cabang;
            	$data['intid_cabang'] = $nm_cabang[0]->intid_cabang;
				
				$week = $this->Penjualan_model->selectWeek();
        		$data['intid_week']= $week[0]->intid_week;


			    $data['max_id'] = $this->getno_nota();			
				$this->load->view('admin_views/penjualan/nota_lunasdp', $data);
           
        }
    }
	
	function lunasdp(){
        //kondisi
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		
		$this->Penjualan_model->updateNota($_POST);
		$id = $this->input->post('intid_nota');
		//input ke stok
		$stok = $this->Penjualan_model->GetBarang($id);
		$intid_id = $stok[0]->intid_barang;
        $intquantity = $stok[0]->intquantity;
		//$this->Penjualan_model->addStok($intid_id, $intquantity, $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
		//end 
		//$ada = $this->Penjualan_model->get_CetakNota($id);
       	/** */
		$insert = array(
								'nota_number' 			=> $this->input->post('intno_nota'),
								'instalment_number'	=> $this->input->post('instalment_number'),
								'type_nota'				=> 3, 
								'id_branch'				=> $this->input->post('id_branch'),
								'branch_name'			=> $this->input->post('branch_name'),
								'type_price'				=> $this->input->post('type_price'),
								'price_type'				=> $this->input->post('price_type'),
								'type_membership'	=> $this->input->post('type_membership'),
								'membership_name'	=> $this->input->post('membership_name'),
								'id_unit'					=> $this->input->post('id_unit'),
								'unit_name'				=> $this->input->post('strnama_unit'),
								'upline'					=> $this->input->post('intid_upline'),
								'upline_name'			=> $this->input->post('strnama_upline'),
								'id_user'					=> $this->input->post('intid_dealer'),
								'active'					=> 1,
								'week'					=> $this->input->post('week'),
								'date'						=> $this->input->post('datetgl'),
								'total_cost'				=> $this->input->post('totalbayar'),
								'cash'						=> $this->input->post('intcash'),
								'debit'	=>	 $this->input->post('intdebit'),
								'credit'	=>	 $this->input->post('intkkredit'),
								'reg_by'	=>	 $this->session->userdata('id_user'),
								); 
		/**/
		$this->db->insert('_instalment',$insert);
		$data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_lunasnota', $data);
		//redirect('penjualan/cetak_notalunasdp');
		
	}
	
	function cetak_notalunasdp($id){
        //$max = $this->Penjualan_model->get_MaxNota()->result();
        //$id = $max[0]->intid_nota;
		//echo $id = $this->input->post('intid_nota');
        $ada = $this->Penjualan_model->get_CetakNota($id);
       	$data['default'] = $this->Penjualan_model->get_CetakNota($id);
        //$this->load->view('admin_views/penjualan/cetak_lunasnota', $data);
	}
	/*
	//digantikan dengan arisan yang baru 28 agustus 2013
	function a_risan()
	{
          
		$this->form_validation->set_rules('intid_unit', 'Unit', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			$group1 = $this->Penjualan_model->Limitgroupsatu();
			$data['group1'] = $group1[0]->group1;
			$group2 = $this->Penjualan_model->Limitgroupdua();
			$data['group2'] = $group2[0]->group2;
			$group3 = $this->Penjualan_model->Limitgrouptiga();
			$data['group3'] = $group3[0]->group3;
			$group4 = $this->Penjualan_model->Limitgroupempat();
			$data['group4'] = $group4[0]->group4;
			$group5 = $this->Penjualan_model->Limitgrouplima();
			$data['group5'] = $group5[0]->group5;
			$group6 = $this->Penjualan_model->Limitgroupenam();
			$data['group6'] = $group6[0]->group6;
			$group7 = $this->Penjualan_model->Limitgrouptujuh();
			$data['group7'] = $group7[0]->group7;
			$group8 = $this->Penjualan_model->Limitgroupdelapan();
			$data['group8'] = $group8[0]->group8;
			$group9 = $this->Penjualan_model->Limitgroupsembilan();
			$data['group9'] = $group9[0]->group9;
			$group10 = $this->Penjualan_model->Limitgroupsepuluh();
			$data['group10'] = $group10[0]->group10;
			$group11 = $this->Penjualan_model->Limitgroupsebelas();
			$data['group11'] = $group11[0]->group11;
			$group12 = $this->Penjualan_model->Limitgroupduabelas();
			$data['group12'] = $group12[0]->group12;
			$group13 = $this->Penjualan_model->Limitgrouptigabelas();
			$data['group13'] = $group13[0]->group13;
			$group14 = $this->Penjualan_model->Limitgroupempatbelas();
			$data['group14'] = $group14[0]->group14;
			$group15 = $this->Penjualan_model->Limitgrouplimabelas();
			$data['group15'] = $group15[0]->group15;
			$this->load->view('admin_views/penjualan/a_risan', $data);
		 }else{

            $this->Penjualan_model->insertArisan($_POST);
            $max = $this->Penjualan_model->get_MaxArisan()->result();
            $id = $max[0]->intid_darisan;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
               // print_r($data[$i]);
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
							'intid_arisan_detail' => $id,
							'intuang_muka' 			=> $data[$i]['intuang_muka'],
							'intid_barang'	        => $data[$i]['intid_id'],
							'intcicilan'		    => $data[$i]['intcicilan'] - 1
                            );

             $this->Penjualan_model->addArisan($detail);
            }
            }
            redirect('admin/penjualan/a_risan');
			
		}
		
	}
	*/
	function a_risan()
	{
        $this->load->model('a_risan_model','a_m');

		$this->form_validation->set_rules('intid_unit', 'Unit', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
        
        if ($this->form_validation->run() == FALSE)
		{
          
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
            //Proses Pengecekan
            
            // cek kondisi group_cek
            //// $select = 'select if(max(batas) >= ), from group_cek';
            // cek group_cek
            //$query = $this->barurekursif();
            //echo $query[0]->group;
            //echo $query[0]->batas;
            
           //buat select nya
            $data['cek2'] = $this->rekursif_group();
            
            $this->load->view('admin_views/penjualan/a_risan', $data);
		 }else{

            $this->Penjualan_model->insertArisan($_POST);
            $max = $this->Penjualan_model->get_MaxArisan()->result();
            $id = $max[0]->intid_darisan;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
               // print_r($data[$i]);
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
							'intid_arisan_detail' => $id,
							'intuang_muka' 			=> $data[$i]['intuang_muka'],
							'intid_barang'	        => $data[$i]['intid_id'],
							'intcicilan'		    => $data[$i]['intcicilan'] - 1
                            );

             $this->Penjualan_model->addArisan($detail);
            }
            }
            redirect('admin/penjualan/a_risan');
			
		}
	}
	//untuk membantuk pencarian group arisan
	function rekursif_group(){
        $this->load->model('a_risan_model');
        $query = $this->a_risan_model->selectGroup();
       // echo $query[0]->batas;
       // echo date('Y-m-d');
        if($query[0]->batas <= date('Y-m-d') and $query[0]->total > 0){
            $data['group'] = $query[0]->group + 1;
            $data['month'] = date('m',strtotime($query[0]->batas))+1;
			if( $data['month'] >= 13){
				$data['month']  = $data['month']  - 12;
			}
            $data['batas'] = $query[0]->batas;
            $this->a_risan_model->insertGroup($data);
            //echo "group";
            return $this->rekursif_group();
        }elseif($query[0]->total >= $query[0]->jumlah){
            $data['group'] = $query[0]->group + 1;
            $data['month'] = date('m',strtotime($query[0]->batas));
            $data['batas'] = $query[0]->batas;
            $this->a_risan_model->insertGroup($data);
          //  echo "group";
            return $this->rekursif_group();
        }elseif($query[0]->batas <= date('Y-m-d') and $query[0]->total == 0){
             $data['group'] = $query[0]->group;
            $data['month'] = date('m',strtotime($query[0]->batas))+1;
			if( $data['month'] >= 13){
				$data['month']  = $data['month']  - 12;
			}
            $data['batas'] = $query[0]->batas;
            $this->a_risan_model->updateGroup($data);
          //  echo "group";
            return $this->rekursif_group();
        }else{
            //echo "yuhuu<br/>";
            return $query;
            }
    }
	///dimatikan untuk sementara
	/*
    function bayar_arisan() {
        $data['form_action']	= site_url('penjualan/bayar_arisan');
        $var = "bulan";
        $terpilih = date('m');
        $bulan = 1;
        $b=12;
        $data['combo_bulan'] = $this->combonamabln($bulan, $b, $var, $terpilih);
        // Load data
        $data['bulan'] = "";
        $data['b'] = "";
        $data['tahun'] = "";
        $data['group'] = "";
        $data['jenis'] = "";
		$data['max_id'] = $this->getno_nota();
        if($_POST) {

            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
   
            $id_cabang = $nm_cabang[0]->intid_cabang;
			$data['arisan'] = $this->Penjualan_model->get_all_arisan($_POST, $id_cabang);
            $data['bulan'] = $this->nama_bulan($this->input->post('bulan'));
            $data['b'] = $this->input->post('bulan');
            $data['tahun'] = $this->input->post('tahun');
            $data['group'] = $this->input->post('group');
            $data['jenis'] = $this->input->post('arisan');

            $ses = array(
						'bulan_session' => $this->input->post('bulan'),
						'tahun_session'=> $this->input->post('tahun'),
						'group_session' => $this->input->post('group')

					);
						$this->session->set_userdata($ses);
            
        }
        $this->load->view('admin_views/penjualan/bayar_arisan', $data);
    }
*/

function bayar_arisan() {
        $data['form_action']	= site_url('penjualan/bayar_arisan');
        $var = "bulan";
        $terpilih = date('m');
        $bulan = 1;
        $b=12;
        $data['combo_bulan'] = $this->combonamabln($bulan, $b, $var, $terpilih);
        // Load data
        $data['bulan'] = "";
        $data['b'] = "";
        $data['tahun'] = "";
        $data['group'] = "";
        $data['jenis'] = "";
		$data['max_id'] = $this->getno_nota();
        if($_POST) {
			if($this->input->post('id_unit')==""){
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
   
            $id_cabang = $nm_cabang[0]->intid_cabang;
			$data['arisan'] = $this->Penjualan_model->get_all_arisan($_POST, $id_cabang);
            $data['bulan'] = $this->nama_bulan($this->input->post('bulan'));
            $data['b'] = $this->input->post('bulan');
            $data['tahun'] = $this->input->post('tahun');
            $data['group'] = $this->input->post('group');
            $data['jenis'] = $this->input->post('arisan');

            $ses = array(
						'bulan_session' => $this->input->post('bulan'),
						'tahun_session'=> $this->input->post('tahun'),
						'group_session' => $this->input->post('group')

					);
						$this->session->set_userdata($ses);
			}else{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
	   
				$id_cabang = $nm_cabang[0]->intid_cabang;
				$data['arisan'] = $this->Penjualan_model->get_all_arisan_ver1($_POST, $id_cabang);
				$data['bulan'] = $this->nama_bulan($this->input->post('bulan'));
				$data['b'] = $this->input->post('bulan');
				$data['tahun'] = $this->input->post('tahun');
				$data['group'] = $this->input->post('group');
				$data['jenis'] = $this->input->post('arisan');
				$ses = array(
							'bulan_session' => $this->input->post('bulan'),
							'tahun_session'=> $this->input->post('tahun'),
							'group_session' => $this->input->post('group')

						);
							$this->session->set_userdata($ses);				
			}            
        }
		$this->load->model('a_risan_model');
		$data['query_group'] = $this->a_risan_model->selectGroupall();
        $this->load->view('admin_views/penjualan/bayar_arisan', $data);
    }
    function ubah_pemenang($id, $group, $jenis, $bln, $tahun){
       $get_p = $this->Penjualan_model->pemenang_terakhir($id, $group);
	   $urutan = $get_p->urutan;
	   if($urutan==0){
		   $u=1;
		}else{
		   $u = $urutan + 1;
		}
        $this->Penjualan_model->update_pemenang($id, $u);
        
		/*$sisa_blmmenang = $this->Penjualan_model->getJumlahArisanGroup($id, $group, $jenis, $bln, $tahun);
		
		if($sisa_blmmenang->jum_sisa == 0){
			$sisa=1;
		}else{
			$sisa=$sisa_blmmenang->jum_sisa;
		}
		$data['sisa'] = $sisa;*/
		
		//tambahan insert ke table nota ketika update pemenang arisan
		$intno_nota = $this->getno_nota();
		$this->Penjualan_model->insertNotaArisanPemenang($intno_nota, $id);
//001
		$this->Penjualan_model->updateArisan001($id, $intno_nota);

		$data['default'] = $this->Penjualan_model->get_notaArisan($intno_nota);
		$this->load->view('admin_views/penjualan/cetak_pemenang', $data);
        
    }
	
	 function cetak_pemenang(){
        $max = $this->Penjualan_model->get_MaxNota()->result();
        $id = $max[0]->intid_nota;
        $data['default'] = $this->Penjualan_model->get_CetakArisan($id);
        $this->load->view('admin_views/penjualan/cetak_pemenang', $data);
	}
	
    function view_bayar($id,$intid_nota,$intid_unit,$intid_dealer,$intid_awal) {
        $var = "bulan_bayar";
        $terpilih = date('m');
        $bulan = 1;
        $b=12;
		$data['intid_unit']	= $intid_unit;
		$data['intid_dealer']	=	$intid_dealer;
		$data['intid_awal']	=	$intid_awal;
        $data['combo_bulan'] = $this->combonamabln($bulan, $b, $var, $terpilih);
        $data['view_bayar'] = $this->Penjualan_model->viewDetailbayar($id);
		$data['total_bayar'] = $this->Penjualan_model->viewTotalbayar($id);
        $data['id_nota'] = $id;
		$data['max_id'] = $this->uri->segment(4);
		$this->load->view('admin_views/penjualan/view_detail_bayar', $data);
    }

    function hapus_arisan($id, $bulan, $tahun, $group) {
        $this->Penjualan_model->delete_arisan($id);
        $this->session->set_flashdata('message', '1 Data Arisan berhasil dihapus');
          
        redirect('penjualan/bayar_arisan');
       
    }

    function update_cicilan($id, $cicilan,$no_nota,$intid_nota){
		$m = $this->Penjualan_model->viewTotalbayar($id);
        $this->Penjualan_model->update_cicilan($id, $cicilan, $no_nota);
    }
	
    function simpan_arisan($id) {
		$bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $ket = $this->input->post('ket');
        if ($this->cek_arisan($id, $bulan, $tahun) === true)
		{
					$cek = $this->Penjualan_model->add_arisan_detail($id, $ket, $bulan, $tahun);
    				echo $cek;
		}
		else
		{
			echo "double";
		}
	}

	function cek_arisan($id, $bulan, $tahun){
		
		$cek = $this->Penjualan_model->cek_arisan($id, $bulan, $tahun)->num_rows();
		
		if ($cek > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

    function nama_bulan($bulan) {
        switch ($bulan) {
            case '1':
                $b = "Januari";
                break;
            case '2':
                $b = "Februari";
                break;
            case '3':
                $b = "Maret";
                break;
            case '4':
                $b = "April";
                break;
            case '5':
                $b = "Mei";
                break;
            case '6':
                $b = "Juni";
                break;
            case '7':
                $b = "Juli";
                break;
            case '8':
                $b = "Agustus";
                break;
            case '9':
                $b = "September";
                break;
            case '10':
                $b = "Oktober";
                break;
            case '11':
                $b = "November";
                break;
            case '12':
                $b = "Desember";
                break;

        }

        return $b;

    }

    function combonamabln($awal, $akhir, $var, $terpilih) {
        $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei",
                "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember");
        $b='';
        $b.="<select name=$var id=$var>";
        for ($bln=$awal; $bln<=$akhir; $bln++) {
            if ($bln==$terpilih)
                $b.="<option value=$bln selected>$nama_bln[$bln]</option>";
            else
                $b.="<option value=$bln>$nama_bln[$bln]</option>";
        }
        $b.="</select> ";
        return $b;
    }

    
	function saveArisan()
	{
		$this->Penjualan_model->insertSaveArisan($_POST);
		redirect('penjualan/a_srisan');
	}
	
	function cetak_arisan(){
        $id = $this->uri->segment(3);
        $intno_nota = $this->uri->segment(4);
		$query	=	$this->Penjualan_model->get_nota($intno_nota);
		if($query->num_rows() > 0){
			//do nothing
			}else{
				$this->Penjualan_model->insertNotaArisan($intno_nota, $id);
			}
		$data['default'] = $this->Penjualan_model->get_CetakArisan($id);
		$data['no_nota'] = $this->uri->segment(4);
		$this->load->view('admin_views/penjualan/cetak_arisan', $data);
	}
	
	function lookupKC(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectKC($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
                                        ''
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
	function lookupbabyKC(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectbabyKC($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
                                        ''
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
	function lookupSC(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectSC($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
                                        'fee' => $row->fee,
                                        ''
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
	
	function spesial(){
        
        
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;

			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;
			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			//$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial(); //karena tidak support dengan penjualan netto
			$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial_ver2();
			foreach ($jpenjualan as $g)
			{
				//bandung only
				if($g->intid_jpenjualan == 7 and ($nm_cabang[0]->intid_cabang == 2 or $nm_cabang[0]->intid_cabang == 28 or $nm_cabang[0]->intid_cabang == 1)){
					//echo "yo<br/>";
					$data['intid_jpenjualan'][]	 	= 14;
					$data['strnama_jpenjualan'][] 	= "SPECIAL BANDUNG";
				}
				if($g->intid_jpenjualan == 24 and (  $nm_cabang[0]->intid_cabang == 1)){
					//echo "yo<br/>";
					$data['intid_jpenjualan'][]	 	= 24;
					$data['strnama_jpenjualan'][] 	= "ROMANCE";
				}
				if($g->intid_jpenjualan == 11 or $g->intid_jpenjualan == 12){
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
			}
			
			$this->load->view('admin_views/penjualan/spesial', $data);
		 }else{
             //transaction untuk perubahan secara manual
			$this->db->trans_begin();
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'nomor_nota'			=> $data[$i]['nomor_nota']								
								);
				 $this->Penjualan_model->add($detail);
	
				// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 
				}
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
               
		 	}
			if ($this->db->trans_status() === FALSE)
				{
					//trasaction : rollback jika transaksi gagal 
					$this->db->trans_rollback();
					redirect('penjualan/');
				}
				else
				{
					//trasaction : commit jika terjadi transaksi berhasil
					$this->db->trans_commit();
					redirect('penjualan/cetak_nota');
					
				}
			
		}
    }
	function spesial1(){
        
        
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;

			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;
			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			//$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial(); //karena tidak support dengan penjualan netto
			$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial_ver2();
			foreach ($jpenjualan as $g)
			{
				//bandung only
				if($g->intid_jpenjualan == 7 and ($nm_cabang[0]->intid_cabang == 2 or $nm_cabang[0]->intid_cabang == 28 or $nm_cabang[0]->intid_cabang == 1)){
					//echo "yo<br/>";
					$data['intid_jpenjualan'][]	 	= 14;
					$data['strnama_jpenjualan'][] 	= "SPECIAL BANDUNG";
				}
				if($g->intid_jpenjualan == 11 or $g->intid_jpenjualan == 12){
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
			}
			
			$this->load->view('admin_views/penjualan/spesial123', $data);
		 }else{
             
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'nomor_nota'			=> $data[$i]['nomor_nota']								
								);
				 $this->Penjualan_model->add($detail);
	
				// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 
				}
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' => 1,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
               
		 	}
            redirect('penjualan/cetak_nota');
			
		}
    }
	
	function istimewa(){
		
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$this->load->view('admin_views/penjualan/istimewa', $data);
		 }else{
             
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;


            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail);
	
				 //$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 
				}
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				  
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 }
               
		 	}
            redirect('penjualan/cetak_nota_asi');
			
		}
	}
	
	function lookupManager(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
		$query = $this->Penjualan_model->selectManager($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_unit,
                                        'value' => $row->strnama_dealer,
                                        'value1' => $row->strkode_upline,
										'value2' => $row->strnama_upline,
										'value3' => $row->intlevel_dealer,
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
	
	function hadiah1231(){
		$this->load->model('PO_model_1');
		if (!$_POST)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$dataTemp['name']	=	'jenis_nota';
			$dataTemp['id']	=	'jenis_nota';
			$data['jenis_nota'] = $this->PO_model_1->get_jenis_notaHadiah($dataTemp);
			$this->load->view('admin_views/penjualan/nota_hadiah', $data);
		 }else{

            $this->Penjualan_model->insertNotaHadiah($_POST);
			
			$max = $this->Penjualan_model->get_MaxNotaHadiah()->result();
            $id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
							'intid_nota' 			=> $id,
							'intid_barang'	        => $data[$i]['intid_id'],
							'intquantity'		    => $data[$i]['intquantity'],
							'ket'		   			=> $data[$i]['ket'],
                            				'nomor_nota'			=> $data[$i]['nomor_nota']
							);

             $this->Penjualan_model->addhadiah($detail);
			 
			// $this->Penjualan_model->addStokHadiah($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
            }
            }
			redirect('penjualan/cetak_notahadiah');
		}
		
	}
	function hadiah(){
		$this->load->model('PO_model_1');
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
		if (!$_POST)
		{
            
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$dataTemp['name']	=	'jenis_nota';
			$dataTemp['id']	=	'jenis_nota';
			$data['jenis_nota'] = $this->PO_model_1->get_jenis_notaHadiah($dataTemp);
			$this->load->view('admin_views/penjualan/nota_hadiah123', $data);
		 }else{

            $this->Penjualan_model->insertNotaHadiah($_POST);
			
			$max = $this->Penjualan_model->get_MaxNotaHadiah()->result();
            $id = $max[0]->intid_nota;
            $data = $this->input->post('barang');
            $intid_barang = $this->input->post('intid_barang');
            $nama_barang = $this->input->post('nama_barang');
            $ket = $this->input->post('ket');
            $nomor_nota = $this->input->post('nomor_nota');
            $intquantity = $this->input->post('intquantity');
				//give me five          
	           if($this->input->post('jenis_nota') == "HGM5")
	           {
	           	$this->givemefive($cabang,$intid_barang, $intquantity);
	           }
            for($i=0;$i<count($intid_barang);$i++){
	            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $intid_barang[$i],
								'intquantity'		    => $intquantity[$i],
								'ket'		   			=> $ket[$i],
	                           	'nomor_nota'			=> $nomor_nota[$i],
								);

	            $this->db->insert("nota_detail_hadiah",$detail);
            }
			redirect('penjualan/cetak_notahadiah/?kode='.$id);
		}
		
	}
	function givemefive($cabang,$intid_barang, $intquantity)
	{
		 for($i=0;$i<count($intid_barang);$i++)
		 {
	            
				 	$cbg = $cabang[0]->intid_cabang;
				 	$qrs = $this->db->query("select * from stock_gm5 where intid_cabang = $cbg and intid_barang =".$intid_barang[$i])->result();
				 	$tqty = $intquantity[$i] - $qrs[0]->qty;
				 	$brg = array('qty' => $tqty);
				 	$this->db->where("intid_cabang",$cbg);
				 	$this->db->where("intid_barang",$intid_barang[$i]);
				 	$this->db->update("stock_gm5",$brg);
		}
	}
	//modified 2014-03-21 ifirlana@gmail.com
	
	function lookupBarangHadiah(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangHadiah_reguler($keyword); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array(
                    'id'=>$row->intid_barang_hadiah,
					'value'=>$row->strnama
                                        
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
	function lookupBarangHadiahGM5(){
		$keyword = $this->input->post('term');
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));

        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangHadiah_regulerGM5($keyword,$cabang[0]->intid_cabang); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array(
                    'id'=>$row->intid_barang_hadiah,
					'value'=>$row->strnama
                                        
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
	//yang lama tidak dipakai tgl 28 Agustus 2013 oleh ikhlas
	//diganti ama yang baru dibawahnya
	function cetak_notahadiah(){
        $max = $this->Penjualan_model->get_MaxNotaHadiah()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNotaHadiah($id);
        $data['default'] = $this->Penjualan_model->get_CetakNotaHadiah($id);
        $this->load->view('admin_views/penjualan/cetak_notahadiah', $data);
	}
	*/
	function cetak_notahadiah(){
		$kode	=	$this->input->get('kode');
		if(empty($kode) or $kode == ''){
			$max = $this->Penjualan_model->get_MaxNotaHadiah()->result();
			$id = $max[0]->intid_nota;
			$ada = $this->Penjualan_model->get_CetakNotaHadiah($id);
			$data['default'] = $this->Penjualan_model->get_CetakNotaHadiah($id);
		}else{
			$data['default'] = $this->Penjualan_model->get_CetakNotaHadiah($kode);
		}
	  $this->load->view('admin_views/penjualan/cetak_notahadiah', $data);
	}
	
	//kondisi pertama
	function hitungomset()
	{
		//kasih kondisi waktu pemakaian.
		$query0 = $this->db->query("select * from control_program where kode='spcr' ");
		$hasil = $query0->result();
		$no_nota = $this->input->post('no_nota');
		$data = 'false';
		$strkode_dealer = $this->input->post('strkode_dealer');
		$select = "select nota.*,member.strkode_dealer,member.strnama_upline from nota left join member on member.intid_dealer = nota.intid_dealer where 
											intno_nota like '$no_nota' 
											and is_sp = 0 
											and nota.intid_jpenjualan != 11 
											 and nota.intid_jpenjualan != 12
											 and nota.intid_jpenjualan != 10
											 and nota.intid_jpenjualan != 8
											 and nota.is_dp = 0
											 and member.strkode_dealer like '".$strkode_dealer."%' 
											and inttotal_omset >= 350000
											and nota.datetgl BETWEEN '".$hasil[0]->date_start ."' and '".$hasil[0]->date_end ."' ";
        $query = $this->db->query($select);
        if($query->num_rows() > 0)
        {
        	$hasil = $query->result();
            $data = "OMSET : <input type='hidden' name='intid_nota_sp[0]' value='".$hasil[0]->intid_nota."' readonly/>
            		<input type='text' name='inttotal_omset' value='".$hasil[0]->inttotal_omset."' readonly/>
					 <input type='hidden' id='id_unit' class='intid_unit' name='id_unit' value='".$hasil[0]->intid_unit."'  readonly='reaedonly' />
					 <input type='hidden' id='strkode_dealer' name='strkode_dealer' value='".$hasil[0]->strkode_dealer."' readonly='readonly' />
					 <input type='hidden' id='strkode_upline' name='strkode_upline' value='".$hasil[0]->strnama_upline."' readonly='readonly' />";
        	}
        echo $data; 
	}
	function hitungomset2()
	{
		//kasih kondisi waktu pemakaian.
		$query0 = $this->db->query("select * from control_program where kode='spcr' ");
		$hasil = $query0->result();
		$tanggal = $this->input->post('tanggal');
		$strkode_dealer = $this->input->post('strkode_dealer');
		//jika kosong maka di set menjadi bahasa yang aneh
		if($strkode_dealer == ""){
			$strkode_dealer = md5('Y-m-d');
			}
		$data = 'false';
		$temporary = "";
		$increment = 0;
		$select = "select nota.*, 
									member.strkode_dealer, 
									member.strnama_upline 
							from nota left join member on member.intid_dealer = nota.intid_dealer 
							where 
									is_sp = 0 
									and nota.intid_jpenjualan != 11 
									and nota.intid_jpenjualan != 12
									and nota.intid_jpenjualan != 10
									and nota.intid_jpenjualan != 8
									and nota.is_dp = 0
									and nota.datetgl = '".$tanggal."'
									and member.strkode_dealer like '".$strkode_dealer."%' 
									and nota.datetgl BETWEEN '".$hasil[0]->date_start ."' and '".$hasil[0]->date_end ."' ";
        $query = $this->db->query($select);
        if($query->num_rows() > 0)
        {
			/*
        	$hasil = $query->result();
            $data = "OMSET : <input type='hidden' name='intid_nota_sp' value='".$hasil[0]->intid_nota."' readonly/>
            		<input type='text' name='inttotal_omset' value='".$hasil[0]->inttotal_omset."' readonly/>
					 <input type='hidden' id='id_unit' class='intid_unit' name='id_unit' value='".$hasil[0]->intid_unit."'  readonly='reaedonly' />
					 <input type='hidden' id='strkode_dealer' name='strkode_dealer' value='".$hasil[0]->strkode_dealer."' readonly='readonly' />
					 <input type='hidden' id='strkode_upline' name='strkode_upline' value='".$hasil[0]->strnama_upline."' readonly='readonly' />";
        	*/
			$temporary = "<table border='1' style='background:white;font-size:13px;'>
									<tr>
										<th>No Nota</th>
										<th>Omset</th>
										<th>Checked</th>
									</tr>
									";
			foreach($query->result() as $row){
			$increment++;
			$inc=$increment;
				$temporary .= "<tr>
											<td>".$row->intno_nota."<input type='hidden' id='inttotal_omset_".$increment."' value='".$row->inttotal_omset."'></td>
											<td>".$row->inttotal_omset."</td>
											<td>
												<div  id='checkbox_div' class='checkbox_div_".$increment."'><input type='checkbox' name='intid_nota_sp[]' value='".$row->intid_nota."' id='nonota_".$increment."'  onClick='cekOmset(this.id)'>
													</div>
												<div id='checkbox_hidden' class='checkbox_hidden_".$increment." style='display:none;'>&nbsp;
													</div>
											</td>
										</tr>";
				}
				$temporary .= "<tr><td >Total Omset: <input type='hidden' id='tracker009' name='tracker009' value='$inc'></td><td colspan='2'><input type='text' id='totOmset' value = '0'/></td></tr></table><input type='hidden' id='increment' value='".$increment."' size='2' readonly='readonly' >";
			$data = $temporary;
			}
			//$data = "tanggal ".$tanggal.", kode_dealer : ".$strkode_dealer;
			//$data = $select;
		echo $data; 
	}
	function hitungomset21()
	{
		//kasih kondisi waktu pemakaian.
		$query0 = $this->db->query("select * from control_program where kode='spcr' ");
		$hasil = $query0->result();
		$tanggal = $this->input->post('tanggal');
		$strkode_dealer = $this->input->post('strkode_dealer');
		//jika kosong maka di set menjadi bahasa yang aneh
		if($strkode_dealer == ""){
			$strkode_dealer = md5('Y-m-d');
			}
		$data = 'false';
		$temporary = "";
		$increment = 0;
		$select = "select nota.*, 
									member.strkode_dealer, 
									member.strnama_upline 
							from nota left join member on member.intid_dealer = nota.intid_dealer 
							where 
									is_sp = 0 
									and nota.intid_jpenjualan != 11 
									and nota.intid_jpenjualan != 12
									and nota.intid_jpenjualan != 10
									and nota.intid_jpenjualan != 8
									and nota.is_dp = 0
									and nota.datetgl = '".$tanggal."'
									and member.strkode_dealer like '".$strkode_dealer."%' 
									and nota.datetgl BETWEEN '".$hasil[0]->date_start ."' and '".$hasil[0]->date_end ."' ";
        $query = $this->db->query($select);
        if($query->num_rows() > 0)
        {
			/*
        	$hasil = $query->result();
            $data = "OMSET : <input type='hidden' name='intid_nota_sp' value='".$hasil[0]->intid_nota."' readonly/>
            		<input type='text' name='inttotal_omset' value='".$hasil[0]->inttotal_omset."' readonly/>
					 <input type='hidden' id='id_unit' class='intid_unit' name='id_unit' value='".$hasil[0]->intid_unit."'  readonly='reaedonly' />
					 <input type='hidden' id='strkode_dealer' name='strkode_dealer' value='".$hasil[0]->strkode_dealer."' readonly='readonly' />
					 <input type='hidden' id='strkode_upline' name='strkode_upline' value='".$hasil[0]->strnama_upline."' readonly='readonly' />";
        	*/
			$temporary = "<table border='1' style='background:white;font-size:13px;'>
									<tr>
										<th>No Nota</th>
										<th>Omset</th>
										<th>Checked</th>
									</tr>
									";
			$inc=0;						
			foreach($query->result() as $row){
			$increment++;
			$inc=$increment;
				$temporary .= "<tr>
											<td>".$row->intno_nota."<input type='hidden' id='inttotal_omset_".$increment."' value='".$row->inttotal_omset."'></td>
											<td>".$row->inttotal_omset."</td>
											<td align='center'>
												<div  id='checkbox_div' class='checkbox_div_".$increment."'><input type='checkbox' name='intid_nota_sp[]' value='".$row->intid_nota."' id='nonota_".$increment."' onClick='cekOmset(this.id)' > 
													</div>
												<div id='checkbox_hidden' class='checkbox_hidden_".$increment." style='display:none;'>&nbsp;
													</div>
											</td>
										</tr>";
				}
				$temporary .= "<tr><td >Total Omset: <input type='hidden' id='tracker009' name='tracker009' value='$inc'></td><td colspan='2'><input type='text' id='totOmset' value = '0' readonly/></td></tr></table><input type='hidden' id='increment' value='".$increment."' size='2' readonly='readonly' >";
			$data = $temporary;
			}
			//$data = "tanggal ".$tanggal.", kode_dealer : ".$strkode_dealer;
			//$data = $select;
		echo $data; 
	}
	function hitungomset22()
	{
		//kasih kondisi waktu pemakaian.
		$query0 = $this->db->query("select * from control_program where kode='spcr' ");
		$hasil = $query0->result();
		$tanggal = $this->input->post('tanggal');
		$strkode_dealer = $this->input->post('strkode_dealer');
		//jika kosong maka di set menjadi bahasa yang aneh
		if($strkode_dealer == ""){
			$strkode_dealer = md5('Y-m-d');
			}
		$data = 'false';
		$temporary = "";
		$increment = 0;
		$select = "select nota.*, 
									member.strkode_dealer, 
									member.strnama_upline 
							from nota left join member on member.intid_dealer = nota.intid_dealer 
							where 
									is_sp = 0 
									and nota.intid_jpenjualan != 11 
									and nota.intid_jpenjualan != 12
									and nota.intid_jpenjualan != 10
									and nota.intid_jpenjualan != 8
									and nota.is_dp = 0
									and nota.datetgl = '".$tanggal."'
									and member.strkode_dealer like '".$strkode_dealer."%' 
									and nota.datetgl BETWEEN '".$hasil[0]->date_start ."' and '".$hasil[0]->date_end ."' ";
        $query = $this->db->query($select);
        if($query->num_rows() > 0)
        {
			/*
        	$hasil = $query->result();
            $data = "OMSET : <input type='hidden' name='intid_nota_sp' value='".$hasil[0]->intid_nota."' readonly/>
            		<input type='text' name='inttotal_omset' value='".$hasil[0]->inttotal_omset."' readonly/>
					 <input type='hidden' id='id_unit' class='intid_unit' name='id_unit' value='".$hasil[0]->intid_unit."'  readonly='reaedonly' />
					 <input type='hidden' id='strkode_dealer' name='strkode_dealer' value='".$hasil[0]->strkode_dealer."' readonly='readonly' />
					 <input type='hidden' id='strkode_upline' name='strkode_upline' value='".$hasil[0]->strnama_upline."' readonly='readonly' />";
        	*/
			$temporary = "<table border='1' style='background:white;font-size:13px;'>
									<tr>
										<th>No Nota</th>
										<th>Omset</th>
										<th>Checked</th>
									</tr>
									";
			$inc=0;						
			foreach($query->result() as $row){
			$increment++;
			$inc=$increment;
				$temporary .= "
										<script>
										$(document).ready(function (){
	
										$('#chkboxom').bind('click',function() {
											alert('bakekok');
										});
										});
										</script>
										<tr>
											<td>".$row->intno_nota."<input type='hidden' id='inttotal_omset_".$increment."' value='".$row->inttotal_omset."'></td>
											<td>".$row->inttotal_omset."</td>
											<td align='center'>
												<div  id='checkbox_div' class='checkbox_div_".$increment."'><input type='checkbox' name='intid_nota_sp[]' value='".$row->intid_nota."' id='nonota_".$increment."' onClick='cekOmset(this.id)' > <input type='checkbox' id='chkboxom'>
													</div>
												<div id='checkbox_hidden' class='checkbox_hidden_".$increment." style='display:none;'>&nbsp;
													</div>
											</td>
										</tr>";
				}
				$temporary .= "<tr><td >Total Omset: <input type='hidden' id='tracker009' name='tracker009' value='$inc'></td><td colspan='2'><input type='text' id='totOmset' value = '0'/></td></tr></table><input type='hidden' id='increment' value='".$increment."' size='2' readonly='readonly' >";
			$data = $temporary;
			}
			//$data = "tanggal ".$tanggal.", kode_dealer : ".$strkode_dealer;
			//$data = $select;
		echo $data; 
	}
	
	//ifirlana@gmail.com
	//added 2014-04-08
	
	function hitungomsetAbo()
	{
		//kasih kondisi waktu pemakaian.
		//$query0 = $this->db->query("select * from control_program where kode='spcr' ");
		//$hasil = $query0->result();
		$tanggal = $this->input->post('tanggal');
		$tanggalSekarang = date("Y-m-d");
		
		$strkode_dealer = $this->input->post('strkode_dealer');
		//jika kosong maka di set menjadi bahasa yang aneh
		if($strkode_dealer == ""){
			$strkode_dealer = md5('Y-m-d');
			}
		$data = 'false';
		$temporary = "";
		$increment = 0;
		$select = "select nota.*, 
									member.strkode_dealer, 
									member.strnama_upline 
							from nota left join member on member.intid_dealer = nota.intid_dealer 
							where 
									nota.intid_jpenjualan != 11 
									and nota.intid_jpenjualan != 12
									and nota.intid_jpenjualan != 10
									and nota.intid_jpenjualan != 8
									and nota.is_dp = 0
									and member.strkode_dealer like '".$strkode_dealer."%' 
									and nota.datetgl >= '".$tanggal."' and nota.datetgl <= '".$tanggalSekarang ."' ";
        $query = $this->db->query($select);
        if($query->num_rows() > 0)
        {
			/*
        	$hasil = $query->result();
            $data = "OMSET : <input type='hidden' name='intid_nota_sp' value='".$hasil[0]->intid_nota."' readonly/>
            		<input type='text' name='inttotal_omset' value='".$hasil[0]->inttotal_omset."' readonly/>
					 <input type='hidden' id='id_unit' class='intid_unit' name='id_unit' value='".$hasil[0]->intid_unit."'  readonly='reaedonly' />
					 <input type='hidden' id='strkode_dealer' name='strkode_dealer' value='".$hasil[0]->strkode_dealer."' readonly='readonly' />
					 <input type='hidden' id='strkode_upline' name='strkode_upline' value='".$hasil[0]->strnama_upline."' readonly='readonly' />";
        	*/
			$temporary = "<table border='1' style='background:white;font-size:13px;'>
									<tr>
										<th>No Nota</th>
										<th>Omset</th>
										<th>Checked</th>
									</tr>
									";
			foreach($query->result() as $row){
			$increment++;
				$temporary .= "<tr>
											<td>".$row->intno_nota."<input type='hidden' id='inttotal_omset_".$increment."' value='".$row->inttotal_omset."'></td>
											<td>".$row->inttotal_omset."</td>
											<td>
												<div  id='checkbox_div' class='checkbox_div_".$increment."'><input type='checkbox' name='intid_nota_sp[]' value='".$row->intid_nota."' id='nonota_".$increment."' onclick='checked_box()'>
													</div>
												<div id='checkbox_hidden' class='checkbox_hidden_".$increment." style='display:none;'>&nbsp;
													</div>
											</td>
										</tr>";
				}
				$temporary .= "<tr><td colspan='2'>Total Omset</td><td id='totalomsetabo'>&nbsp;</td></tr>";
				$temporary .= "</table><input type='hidden' id='increment' value='".$increment."' size='2' readonly='readonly' >";
			$data = $temporary;
			}
			//$data = "tanggal ".$tanggal.", kode_dealer : ".$strkode_dealer;
			//$data = $select;
		echo $data; 
	}
	
	//modified by ifirlana@gmail.com 30 oktober 2013
	//perancangan masih berantakan,
	//pengembagan diluar konstruksi yang awal sehingga masih terdapat bug-bug yang belum dapat diselesaikan.
	
	function promo()
	{
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

        $data['cabang'] = $nm_cabang[0]->strnama_cabang;
        $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


		$data['user'] = $this->session->userdata('username');
        $data['max_id'] = $this->getno_nota();
		//kondisi pengecualian barang tulip dan barang metal
		$jbarang =	$this->barang_model->selectJbarang();
		foreach ($jbarang as $k)
		{
			if($k->intid_jbarang == 1 or $k->intid_jbarang == 2){
				$data['intid_jbarang'][]	 	= $k->intid_jbarang;
				$data['strnama_jbarang'][] 	= $k->strnama_jbarang;
				}
		}
		//ending	
		$jpenjualan = $this->Penjualan_model->selectJPenjualanPromo();
		foreach ($jpenjualan as $g)
		{
			$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
			$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
		}
		$this->load->view('admin_views/penjualan/promo', $data);
		//$this->load->view('test/promo', $data);
	}
	//end modified
	function lookupBarangFree(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
		$data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangFree($keyword, $state);
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
                }else{
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->promo,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
	
	function netto(){
        
        
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$this->load->view('admin_views/penjualan/netto', $data);
		 }else{
             
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']								
								);
				 $this->Penjualan_model->add($detail);
	
				// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				 
				}
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
				 }
               
		 	}
			
            redirect('penjualan/cetak_nota');
			
		}
    }

//999
	/////line ikhlas 11042013//
	function grand()
	{
		$data['error_message'] = "";
		if($this->input->post('grandpass')){
					$data['result'] = $this->Penjualan_model->get_password("grand", $this->input->post('grandpass'));
					if($data['result'] > 0){
					redirect('penjualan/grand_pass');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	
	/////line ikhlas 11042013//
	function grand_pass(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			
					$data['cabang'] = $nm_cabang[0]->strnama_cabang;
					$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
					$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
					
					if($nm_cabang[0]->intid_cabang == 1){
						
						$data['query_cabang']	=	$this->Cabang_model->selectCab();
						}
			
					$data['user'] = $this->session->userdata('username');
					$data['max_id'] = $this->getno_nota();
					if($nm_cabang[0]->intid_cabang == 0){	
						$data_temp[0] = '6';
						$jpenjualan = $this->Penjualan_model->selectJPenjualanCustom($data_temp);
					}else{
						$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
					}
					foreach ($jpenjualan as $g)
					{
						$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
						$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
						$data['intid_jpenjualan'][]	 	= 5;
						$data['strnama_jpenjualan'][] 	= "1 Free 1 HUT/ Nett";
					/* YANG LAMA */
				/* $this->load->view('admin_views/penjualan/grand_after_pass1',$data); */
				/* $this->load->view('admin_views/penjualan/grand_after_pass3',$data); */
				// $this->load->view('admin_views/penjualan/grand_after_pass31',$data);
				/* created 17/11/2014 */
				$this->load->view('admin_views/penjualan/grand_after_pass311',$data);
	}
	function grand_pass2(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			
					$data['cabang'] = $nm_cabang[0]->strnama_cabang;
					$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
					$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
					
					if($nm_cabang[0]->intid_cabang == 1){
						
						$data['query_cabang']	=	$this->Cabang_model->selectCab();
						}
			
					$data['user'] = $this->session->userdata('username');
					$data['max_id'] = $this->getno_nota();
					if($nm_cabang[0]->intid_cabang == 0){	
						$data_temp[0] = '6';
						$jpenjualan = $this->Penjualan_model->selectJPenjualanCustom($data_temp);
					}else{
						$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
					}
					foreach ($jpenjualan as $g)
					{
						$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
						$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
						$data['intid_jpenjualan'][]	 	= 5;
						$data['strnama_jpenjualan'][] 	= "1 Free 1 HUT/ Nett";
					
				$this->load->view('admin_views/penjualan/grand_after_pass1',$data);
	}
	function grand_pass1(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			
					$data['cabang'] = $nm_cabang[0]->strnama_cabang;
					$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
					$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
					
					if($nm_cabang[0]->intid_cabang == 1){
						
						$data['query_cabang']	=	$this->Cabang_model->selectCab();
						}
			
					$data['user'] = $this->session->userdata('username');
					$data['max_id'] = $this->getno_nota();
					$jpenjualan = $this->Penjualan_model->selectJPenjualanPromo4010();
					foreach ($jpenjualan as $g)
					{
						$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
						$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
					/* if($nm_cabang[0]->intid_cabang == 0){	
						$data_temp[0] = '6';
						$jpenjualan = $this->Penjualan_model->selectJPenjualanCustom($data_temp);
					}else{
						$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
					}
					foreach ($jpenjualan as $g)
					{
						$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
						$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					} */
/* 						$data['intid_jpenjualan'][]	 	= 5;
						$data['strnama_jpenjualan'][] 	= "1 Free 1 HUT/ Nett";
 */					
				// $this->load->view('admin_views/penjualan/grand_after_pass2',$data);
				$this->load->view('admin_views/penjualan/grand_after_pass311',$data);
	}
	
	function cetak_nota_grand(){
		$max = $this->Penjualan_model->get_MaxNota()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNota($id);
        $data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_nota_grand', $data);
	}
	function nota_grand(){
        
        
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
			
			
            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualan();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$this->load->view('admin_views/penjualan/nota', $data);
		 }else{
             $this->db->trans_start();
            $this->Penjualan_model->insertNotaHal($_POST,'grand');
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota'],
								'is_diskon'			=> $data[$i]['promoada'],
								'intnormal'			=> $data[$i]['harga_asli'],
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'intvoucher'			=> $data[$i]['voucherada'],
								);
				 $this->Penjualan_model->add($detail);
				if($this->input->post('buat_arisan')!="arisan") {
				// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				}
				 }
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				if($this->input->post('buat_arisan')!="arisan") {
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
				}
				 }
               
		 	}

		//001
		$smartspending = $this->input->post('chkSmart');
		if ($smartspending == "on") {
			redirect('penjualan/cetak_nota_asi');
		}
		
			
            if($this->input->post('radio')==6){
                $ci = '5';
            }else{
                $ci='7';
            }

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
			 }
            
            $this->db->trans_complete();
            redirect('penjualan/cetak_nota_grand');
			
		}
    }
	////ending
	
	function mini()
	{
		$data['error_message'] = "";
		$temp = $this->session->userdata('username');
					
		if($this->input->post('grandpass')){
					$data['result'] = $this->Penjualan_model->get_password("mini", $this->input->post('grandpass'));
					
					if($data['result'] > 0 ){
						redirect("penjualan/mini_after_pass");
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/mini', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/mini', $data);
		}
	}
	function mini_after_pass(){
		//echo $this->session->userdata('username')."<br/>";
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

		$data['cabang'] = $nm_cabang[0]->strnama_cabang;
		$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;

		$data['back_url'] = base_url()."penjualan/mini_after_pass";
		$data['user'] = $this->session->userdata('username');
		$data['max_id'] = $this->getno_nota();
			
		$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
		foreach ($jpenjualan as $g)
		{
			$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
			$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
		}
		/* $this->load->view('admin_views/penjualan/mini_after_pass',$data); */
		$this->load->view('admin_views/penjualan/mini_after_pass12',$data);
	}function mini_after_pass1(){
		//echo $this->session->userdata('username')."<br/>";
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

		$data['cabang'] = $nm_cabang[0]->strnama_cabang;
		$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;

		$data['back_url'] = base_url()."penjualan/mini_after_pass";
		$data['user'] = $this->session->userdata('username');
		$data['max_id'] = $this->getno_nota();
			
		$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
		foreach ($jpenjualan as $g)
		{
			$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
			$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
		}
		$this->load->view('admin_views/penjualan/mini_after_pass123',$data);
	}
	function seluruh_nota()
	{
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        	$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

        	$data['cabang'] = $nm_cabang[0]->strnama_cabang;
        	$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


		$data['user'] = $this->session->userdata('username');
        	$data['max_id'] = $this->getno_nota();
			
		$jpenjualan = $this->Penjualan_model->selectJPenjualanPromo();
		foreach ($jpenjualan as $g)
		{
			$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
			$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
		}
		$this->load->view('admin_views/penjualan/seluruh_nota', $data);
	}

/////////////////////////////////////////////////////////////////////////////
	function lookuptracker003(){
		$keyword = $this->input->post('id_barang');
		if($keyword == 967){
			$total = 3;
		}elseif($keyword == 966){
			$total = 1;
		}else{
			$total = $this->Penjualan_model->selectfortracker003($keyword);
		}
		echo ($total); 
		
	}

function lookupNamaBarang_2(){
	$id = $this->input->post('id_barang');		
			
			$total = $this->Penjualan_model->selectNamaBarangB($id);			
			foreach($total as $rok){
				}
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $rok->intharga_jawa;
                }else{
                    $hrg = $rok->intharga_luarjawa;
                }
		    echo json_encode(array(
					'id'=>$rok->intid_barang,
					'value'=>$rok->strnama,
                                        'value1' => $hrg,
                                        'value7' => $rok->intid_harga,
                                     ));         
	}
//////////////////////////////////////////////////30Maret2013 line ikhlas

function gubrak(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualan();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$this->load->view('admin_views/penjualan/nota_gubrak', $data);
		 }else{
             
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail);
				if($this->input->post('buat_arisan')!="arisan") {
				 //$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				}
				 }
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				if($this->input->post('buat_arisan')!="arisan") {
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
				}
				 }
               
		 	}
			
            if($this->input->post('radio')==6){
                $ci = '5';
            }else{
                $ci='7';
            }

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
			 }
            
            
            redirect('penjualan/cetak_nota');
			
		}
	}
/////////////line ikhlas 30032013
	function lookupBarangGubrak(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangGubrak($keyword);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
										'value'=>$row->promo,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => $row->intid_harga,
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
	///////////end 30032013
	
//////////////////////////////////////////////////02042013 line ikhlas
	function gubrak_pass(){
	//jangan lupa dibuka kembali tanda komentar nya setelah promo beres.
	/*
	$data['error_message'] ="";
	if($this->input->post('gubrakpass')){
		$data['result'] = $this->Penjualan_model->get_password("gubrak", $this->input->post('gubrakpass'));
					if($data['result'] > 0){
					redirect('penjualan/gubrak_1');
					//$this->gubrak_1();
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/gubrak', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/gubrak', $data);					
			}
	*/
	redirect('penjualan/gubrak_1');
	}	
//////////////////////////////////////////////////02042013 line ikhlas
function gubrak_1(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualan();
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
			}
			
			$this->load->view('admin_views/penjualan/nota_gubrak', $data);
		 }else{
             
            $this->Penjualan_model->insertNota($_POST);
            
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail);
				if($this->input->post('buat_arisan')!="arisan") {
				 //$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				}
				 }
            }

             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail_free);
				if($this->input->post('buat_arisan')!="arisan") {
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
				}
				 }
               
		 	}
			
            if($this->input->post('radio')==6){
                $ci = '5';
            }else{
                $ci='7';
            }

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
			 }
            
            
            redirect('penjualan/cetak_nota_gubrak');
			
		}
	}
		////////////////line ikhlas firlana 04April2013///////////////////////
	function cetak_nota_gubrak(){
        $max = $this->Penjualan_model->get_MaxNota()->result();
        $id = $max[0]->intid_nota;
        $ada = $this->Penjualan_model->get_CetakNota($id);
        $data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_nota_gubrak', $data);
	}
	/////////////////////line ikhlas 03APril 2013////////////
	function lookupBarangFreegubrak(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
		$data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangFreeGubrak($keyword, $state);
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
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row-> 	intpv_luarkualalumpur;
                }
				
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->promo,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
	///line ikhlas 24April//
//009
	/**
	* untuk menu sidebar hadiah rekrut
	* @param hadiah_rekrut
	*/
	function hadiah_rekrut()
	{
		//redirect('penjualan/maintanance');
		$idt = 0;
		$id = 0;					
		$temp = 0;
		$datanota = 0;
		$datanotadetail =0;
		
		if (!$_POST)
		{
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			//$this->load->view('admin_views/penjualan/nota_lg', $data);
			$this->load->view('admin_views/penjualan/nota_hadiah_rekrut', $data);
		 }else{
			$data = $this->input->post('barang');
				$member = $this->input->post('id');
				if($this->input->post('totalrekrut001') == 2){
					$temp = 1;
				}elseif($this->input->post('totalrekrut001') == 3){
					$temp = 2;
				}elseif($this->input->post('totalrekrut001') >= 4){
					$temp = 3;
				}
				$week = $this->Penjualan_model->selectWeek();
				//pengecekan nota terseida//
				$count = $this->Penjualan_model->cek_nota($this->input->post('intno_nota'));
			if($count == 0){
				$intid_dealer = $this->Penjualan_model->get_iddealer($this->input->post('strkode_dealer'));
				//memasukan data ke dalam tabel nota
				$datanota = array(
							'intno_nota' => $this->input->post('intno_nota'),
								'intid_cabang' => $this->input->post('intid_cabang'),
								'datetgl' => date('Y-m-d'),
								'intid_dealer' => $intid_dealer,
								'intid_unit' => $this->input->post('id_unit'),
								'intid_week' => $week[0]->intid_week,
								'nomor_nota'			=> $data[$i]['nomor_nota']								
						);
				$id = $this->Penjualan_model->insertNotaRekrutcoba($datanota);
			
				//memasukan data ke dalam notadetail.
				for($i=1;$i <= $temp;$i++){
				
					if(!empty($data[$i]['intid_barang'])){
						$datanotadetail = array(
							'intid_nota' => $id,
							'intid_barang' => $data[$i]['intid_barang'],
							'intquantity' => '1',
							'ket' => md5('REKRUTHADIAH')
							);
						$idt = $this->Penjualan_model->insertNotaRekrutdetail($datanotadetail);
						}
					}
				//data tabel rekrut hadiah detail berubah sesuai jumlah yang keluar di halaman sebelumnya.
				for($j=1;$j <= $this->input->post('totalrekrut001');$j++){
					$id_group = $this->Penjualan_model->updaterekrut_hadiah_detail($member[$j],$this->input->post('intno_nota'));
					$temp = $member[$j];			
				}
				//kalau sudah empat personeil maka status rekrut hadiah berubah.
				if($this->input->post('totalrekrut001') == 4){
					//echo "member : ".$member[$j];
					$kode = $this->Penjualan_model->selectUplinefromKode($temp);
					//echo "kode : ".$kode[0]->strkode_upline."<br />";
					
					//kasih status group untuk pemasukan sesuai id. 
					//$this->Penjualan_model->updaterekrut_hadiah($kode[0]->strkode_upline,$this->input->post('intno_nota'),$id_group);
					$this->Penjualan_model->updaterekrut_hadiah($kode[0]->strkode_upline,$this->input->post('intno_nota'),$id_group[0]->id_group);						
				}
				 redirect('penjualan/cetak_notahadiah');
			}else{
				
				 redirect('penjualan/cetak_notahadiah');
			}	
		}
	}
	/**
	* Kalau terjadi sesuatu misalkan check rekrut dibalikan kondisi semula,
	* maka fungsi check_rekrut dibuka dan fungsi check_rekrut_pod dan check_rekrut_mede di hidden
	* @param check_rekrut
	* @param check_rekrut_pod
	* @param check_rekrut_mede
	*
	function check_rekrut() {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['rekrut'] = $this->Penjualan_model->get_rekrut_hadiah($id[0]->intid_dealer);
				
				$this->load->view('admin_views/penjualan/rekrut', $data);
		}
		*/
	function check_rekrut_pod() {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['rekrut'] = $this->Penjualan_model->get_rekrut_hadiah($id[0]->intid_dealer,215000);
				$data['judul'] = "POWER OF DREAM";
				$this->load->view('admin_views/penjualan/rekrut', $data);
		}
	function check_rekrut_mede() {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
           		$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            	$id_cabang = $nm_cabang[0]->intid_cabang;
				$id = $this->Penjualan_model->getidDealer($this->input->post('strkode_dealer'));
				//$data['omset'] = $this->Penjualan_model->getOmset($id[0]->intid_dealer, $id_cabang);
				$data['rekrut'] = $this->Penjualan_model->get_rekrut_hadiah($id[0]->intid_dealer,108000);
				$data['judul'] = "Make Everyday Exciting";
				$this->load->view('admin_views/penjualan/rekrut', $data);
		}	
	
	/**
	* Pencarian lookup tabel per group masih kurang bagus
	* @param lookupBarangGroupSatu
	* @param lookupBarangGroupDua
	* @param lookupBarangGroupTiga
	* @param lookupBarangGroupSatu108
	* @param lookupBarangGroupDua108
	* @param lookupBarangGroupTiga108
	*/
	function lookupBarangGroupSatu(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahSatu($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangGroupDua(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahDua($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangGroupTiga(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahTiga($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangGroupSatu108(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahSatu108($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangGroupDua108(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahDua108($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intharga_kualalumpur;
					$um = 0;
					$cicilan =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangGroupTiga108(){
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangRekrutHadiahTiga108($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	function maintanance(){
		$this->load->view('admin_views/maintanance');
	}
	
	function cetak_arisan_test(){
        $id = $this->uri->segment(3);
       $data['default'] = $this->Penjualan_model->get_CetakArisan($id);
		$data['no_nota'] = $this->uri->segment(4);
		$this->load->view('admin_views/penjualan/cetak_arisan', $data);
	}
	function lookupBarangLg1(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangLg1($keyword);
		if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                   
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->lg,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
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
	function lookupBarangLg2(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangLg2($keyword);
		if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                   
                }
				elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    
                }
				elseif($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    
                }
				elseif($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->lg,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
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
	function lookupBarangLg3(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangLg3($keyword);
		if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                   
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->lg,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
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
	function lookupUplineNonManager(){
		$keyword = $this->input->post('term');
		$unit = $this->input->post('state');
		$data['response'] = 'false'; 
		$query = $this->Penjualan_model->selectUplineNonManager($keyword, $unit); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->strkode_dealer,
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
	//** diperuntukkan untuk halaman promo1free1
	function promo1free1()
	{
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

        $data['cabang'] = $nm_cabang[0]->strnama_cabang;
        $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


		$data['user'] = $this->session->userdata('username');
        $data['max_id'] = $this->getno_nota();
			
		$jpenjualan = $this->Penjualan_model->selectJPenjualanPromo1free1();
		foreach ($jpenjualan as $g)
		{
			$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
			$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
		}
		$this->load->view('admin_views/penjualan/promo1free1', $data);
	}
	////////////////////////////////////
	/*
function lookupBarangSatuFreeSatuBayar(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangSatuFreeSatuBayar($keyword,'1fre1'); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }else{
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	*/
//////////////////////////////////////////////////////////
function lookupBarangSatuFreeSatu(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
		$key	=	$this->input->post('key');
		$data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangSatuFreeSatu($keyword, $state, $key);
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
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
                }
                else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
                }
                else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
                }
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->promo,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
////////////////////////////////////////////////
function nota_vers2(){
		$id_nota = "";
		$size = $this->input->post('tracker001');
		$temp = array();
		$this->load->model('mamal_model');
		$week = $this->Penjualan_model->selectWeek();
        $intid_week= $week[0]->intid_week;
		if(isset($_POST['intdp'])){
			$is_dp = 1;
			$cash = $this->input->post('intdp');
		} else { 
			$is_dp = 0;
			$cash = $this->input->post('intcash');
		}
		if(isset($_POST['is_lg'])){
			$is_lg = 1;
		} else {
			$is_lg = 0;
		}
		if(isset($_POST['is_asi'])){
			$is_asi = 1;
			$kredit = $this->input->post('totalbayarhidden');
			$komisiasi = $this->input->post('intkomisiasi');
		} else {
			$is_asi = 0;
			$kredit = $this->input->post('intkkredit');
			$komisiasi = 0;
		}
		$data['intno_nota']=$this->input->post('intno_nota');
		$data['intid_jpenjualan']=$this->input->post('intid_jpenjualan');
		$data['intid_cabang']=$this->input->post('intid_cabang');
		$data['intid_dealer']=$this->input->post('intid_dealer');
		$data['intid_unit']=$this->input->post('id_unit');
		$data['datetgl']=date('Y-m-d');
		$data['intid_week']=$intid_week;
		$data['intomset10']=$this->input->post('jml10hidden');
		$data['intomset20']=$this->input->post('jml20hidden');
		$data['inttotal_omset']=$this->input->post('jumlahOmsethidden');
		$data['inttotal_bayar']=$this->input->post('totalbayarhidden');
		$data['intdp']=$this->input->post('intdp');
		$data['intcash']=$cash;
		$data['intdebit']=$this->input->post('intdebit');
		$data['intkkredit']=$this->input->post('intkkredit');
		$data['intsisa']=$this->input->post('intsisahidden');
		$data['intkomisi10']=$this->input->post('komisi1hidden');
		$data['intkomisi20']=$this->input->post('komisi2hidden');
		$data['intpv']=$this->input->post('intpv');
		$data['intvoucher']=$this->input->post('intvoucher');
		$data['is_dp']=$is_dp;
		$data['inttrade_in']=$this->input->post('komisitrade');
		$data['is_lg']=$is_lg;
		$data['is_asi']=$is_asi;
		$data['nokk']=$this->input->post('nokk');
		$data['intkomisi_asi']=$komisiasi;
		$data['is_arisan']= $this->input->post('is_arisan');
		$data['halaman']=$this->input->post('halaman');
		/*
		for($i = 1; $i<=sizeof($data);$i++){
			echo $i.", ".$data[$i]."<br />";
		}
		*/
		$id_nota = $this->mamal_model->elephant($data,'nota',1);
		//echo "id ;".$id;
		if(!empty($id_nota)){
			$barang = $this->input->post('barang');
			//echo "length ; ".sizeof($barang)."<br />";
			for($cont = 1;$cont <= $size;$cont++){
				 if(!empty($barang[$cont]['intquantity'])){
				 	$temp[$cont][0] = $id_nota;
				 	$temp[$cont][1] = $barang[$cont]['intid_barang'];
				 	$temp[$cont][2] = $barang[$cont]['intquantity'];
					if($barang[$cont]['harga'] == 0){
								$temp[$cont][3]	= 0;
								$temp[$cont][4]	= 1;
							}else{
								$temp[$cont][3] = $barang[$cont]['intid_barang'];
								$temp[$cont][4]	= 0;
							}
				 	$temp[$cont][5] = $barang[$cont]['harga'];
				 	}
				}
				/*
				for(){
					echo "temp, ".."".."".."".."".."".."".."";
				}
				*/
					///baru sistem memasukan
					for($cont = 1;$cont <= sizeof($temp);$cont++){
						$data_detail = array();
						if(!empty($barang[$cont]['intquantity'])){
							$data_detail['intid_nota']	= $id_nota;
							$data_detail['intid_barang'] = $temp[$cont][1];
							$data_detail['intquantity']	= $temp[$cont][2];
							if($barang[$cont]['harga'] == 0){
								$data_detail['intid_harga']	= $temp[$cont][3];
								$data_detail['is_free']	= $temp[$cont][4];
							}else{
								$data_detail['intid_harga'] = $temp[$cont][3];
								$data_detail['is_free']	= $temp[$cont][4];
							}
							$data_detail['intharga'] = $temp[$cont][5];
							$id = $this->mamal_model->elephant($data_detail,'nota_detail',1);
							//echo "intid_nota : ".$data_detail['intid_nota'].", intid_barang : ".$data_detail['intid_barang'].", intquantity : ".$data_detail['intquantity'].",intid_harag ".$data_detail['intid_harga'].", nominal ".$data_detail['intharga']."<br />";
							if(empty($id)){
								 $this->session->set_flashdata('messages', '<script>alert("PERINGATAN! terjadi Gangguan pada penginputan barang.");</script>');
								}	
							}	
				}
			redirect('penjualan/cetak_nota');
			
		}else{
				$this->session->set_flashdata('messages', '<script>PERINGATAN! terjadi Gangguan pada penginputan Nota.</script>');
		}
	}
	////////////////////////////////////////
	//IKHLAS 10AGUSTUS2013
function lookupBarangSatuFreeSatufree(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
		$data['response'] = 'false';
       $cabang = $this->User_model->getCabang($this->session->userdata('username'));
		 $query = $this->Penjualan_model->lookupBarangSatuFreeSatufree($keyword, $state,'1fre1',$cabang[0]->intid_cabang);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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

	//
	function lookupBarangSatuFreeSatufreeALLITEM(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
        $code = $this->input->post('code');
		
		$data['response'] = 'false';
		
		$temp	=	substr($state, 0, 4);
        
		//$query = $this->Penjualan_model->lookupBarangSatuFreeSatufreeALLITEM($keyword);
		$query = $this->Penjualan_model->lookupBarangSatuFreeSatufreeALLITEM_try($keyword, $code);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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

	
	function lookupTradeIn(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $keyword = $this->input->post('term');
		$key = "td".$this->input->post('state');
        $key_K['intid_cabang'] = $cabang[0]->intid_cabang;
		$data['response'] = 'false'; 
		//kustomisasi karena permintaan untuk tanggal 22 oktober 2013 khusus jember, dan depok 2 sebagai tester
        //if($key_K['intid_cabang'] == 60 or $key_K['intid_cabang'] == 28){
			$query = $this->Penjualan_model->lookupBarangTradeIn($keyword,$key, $cabang[0]->intid_cabang); 
		//}
		//ending
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
function lookupBarangSatuFreeSatuBayar(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangSatuFreeSatuBayar($keyword,'1fre1',$cabang[0]->intid_cabang); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	function cobaPreg(){
	$isi="303 MC MS FS";
	echo $isi."<br>";
	echo preg_replace("/ MS|| FS|| KS/","",$isi );
	}
function lookupBarangSatuFreeSatuBayarALLITEM(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangAllItem($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
										//'code_barang' => $row->code_barang
										'code_barang' => preg_replace("/ MS|| FS|| KS/","",$row->code_barang)
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
	
	//launching
	
	function lookupBarangSatuFreeSatuBayarLaunching(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangLaunching($keyword); 
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
										//'code_barang' => $row->code_barang
										'code_barang' => preg_replace("/ MS|| FS|| KS/","",$row->code_barang)
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
	
	function lookupBarangSpecialToday(){
		$keyword = $this->input->post('term');
		$cabang = $this->input->post('cabang');
        $data['response'] = 'false'; 
        //$query = $this->Penjualan_model->selectBarang($keyword, 3); 
        $query = $this->Penjualan_model->selectBarangDuaFreeSatu($keyword,'spct',$cabang);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangSpecialCabangDis(){
		$keyword = $this->input->post('term');
		/* $cabang = $this->input->post('cabang'); */
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		
		//$cabang = $this->input->post('cabang');
        $data['response'] = 'false'; 
        //$query = $this->Penjualan_model->selectBarang($keyword, 3); 
        $query = $this->Penjualan_model->selectBarangDis($keyword,'dis30',$cabang[0]->intid_cabang); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa * 0.7;
                    $pv = $row->intpv_jawa * 0.7;
					$um = $row->intum_jawa * 0.7;
					$cicilan = $row->intcicilan_jawa * 0.7;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa * 0.7;
                    $pv = $row->intpv_luarjawa * 0.7;
					$um = $row->intum_luarjawa * 0.7;
					$cicilan = $row->intcicilan_luarjawa * 0.7;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangSpecialToday_FREE(){
		$keyword = $this->input->post('term');
		$intid_barang = $this->input->post('state');
		$cabang = $this->input->post('cabang');
        $data['response'] = 'false'; 
        //$query = $this->Penjualan_model->selectBarang($keyword, 3); 
        $query = $this->Penjualan_model->selectBarangDuaFreeSatu_free($keyword,'spct',$cabang,$intid_barang);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	//ending 
	//lookup barang special proce
	function lookupBarangSpecialPrice(){
		$keyword = $this->input->post('term');
		$free = $this->input->post('state');
		$intid_barang = $this->input->post('bayar');
		$keterangan = $keyword.",".$free.",".$intid_barang;
		if($free == ''){
			$cabang = 0;
			$data['response'] = 'false'; 
			//$query = $this->Penjualan_model->selectBarang($keyword, 3); 
			$query = $this->Penjualan_model->selectBarangPromoCabang($keyword,'spcr',$cabang);
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					if($cabang[0]->intid_wilayah == 1){
						$hrg = $row->intspecial_jawa;
						$pv = $row->intpv_jawa;
						$um = $row->intum_jawa;
						$cicilan = $row->intcicilan_jawa;
					}
					else if($cabang[0]->intid_wilayah == 2){
						$hrg = $row->intspecial_luarjawa;
						$pv = $row->intpv_luarjawa;
						$um = $row->intum_luarjawa;
						$cicilan = $row->intcicilan_luarjawa;
					}
					else if($cabang[0]->intid_wilayah == 3){
						/* $hrg = 0; */
						$hrg = $row->intspecial_kualalumpur;
						$pv = 0;
						$um = 0;
						$cicilan = 0;
					}
					else if($cabang[0]->intid_wilayah == 4){
						/* $hrg = 0; */
						$hrg = $row->intspecial_luarkualalumpur;
						$pv = 0;
						$um =0;
						$cicilan = 0;
					}
					$data['message'][] = array(
											'id'	=>	$row->intid_barang,
											'value'	=>	$row->strnama,
											'value1' => $hrg,
											'value2' => $row->intspecial_luarjawa,
											'value3' => $pv,
											'value4' => $row->intpv_luarjawa,
											'value5' => $um,
											'value6' => $cicilan,
											'value7' => $row->intid_harga,
											'intid_barang_free' => $row->intid_barang_free 
										 );
				}
						   
			}
		} 
		else {
				$cabang = 0;
				$data['response'] = 'false'; 
				//$query = $this->Penjualan_model->selectBarang($keyword, 3); 
				$query2 = $this->Penjualan_model->selectBarangPromoCabangFree($keyword,'spcr',$cabang,$intid_barang);
				if( ! empty($query2) )
				{
					$data['response'] = 'true'; 
					$data['message'] = array(); 
					foreach( $query2 as $row1 )
					{
						$cabang = $this->User_model->getCabang($this->session->userdata('username'));
						if($cabang[0]->intid_wilayah == 1){
							$hrg = $row1->intspecial_jawa;
							$pv = $row1->intpv_jawa;
							$um = $row1->intum_jawa;
							$cicilan = $row1->intcicilan_jawa;
						}
						else if($cabang[0]->intid_wilayah == 2){
							$hrg = $row->intspecial_luarjawa;
							$pv = $row->intpv_luarjawa;
							$um = $row->intum_luarjawa;
							$cicilan = $row->intcicilan_luarjawa;
						}
						else if($cabang[0]->intid_wilayah == 3){
							$hrg = 0;
							$pv = 0;
							$um = 0;
							$cicilan = 0;
						}
						else if($cabang[0]->intid_wilayah == 4){
							$hrg = 0;
							$pv = 0;
							$um =0;
							$cicilan = 0;
						}
						$data['message'][] = array(
												'id'	=>	$row1->intid_barang_pilih,
												'value'	=>	$row1->strnama,
												'value1' => $hrg,
												'value2' => $row1->intspecial_luarjawa,
												'value3' => $pv,
												'value4' => $row1->intpv_luarjawa,
												'value5' => $um,
												'value6' => $cicilan,
												'value7' => $row1->intid_harga,
												'intid_barang_free' => 0,
											 );
					}
							   
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
	function savespecialtoday(){
		if($_POST){
			$this->db->trans_start(); 
			$intid_nota_sp = $this->input->post('intid_nota_sp');
			//echo ": ".$this->input->post('jumlah');
			$hal = $this->input->post('halaman');
			if(empty($hal)){
				$hal = "";
				}else{
					$hal = $this->input->post('halaman');
					}
			//oke ROCK N ROLL 
			//begin transaction		
            //$this->Penjualan_model->insertNota($_POST);
			//echo  $this->input->post('strkode_dealer').",".$this->input->post('id_unit');
            $this->Penjualan_model->insertNotaHal($_POST,$hal);
           	
			//untuk kondisi coba dulu deh
			for($i=sizeof($intid_nota_sp);$i>=0;$i--){
					if(isset($intid_nota_sp[$i])){
						$dataTemp = array(
									   'is_sp' => 1,
									);

						$this->db->where('intid_nota', $intid_nota_sp[$i]);
						$this->db->update('nota', $dataTemp); 
						}					
					}
			/*		*/
					/*
			if($intid_nota_sp[0]){
           		$dataTemp = array(
				               'is_sp' => 1,
				            );

				$this->db->where('intid_nota', $intid_nota_sp[0]);
				$this->db->update('nota', $dataTemp); 
           		}
				*/
           	$max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'id_jpenjualan'			=> $this->input->post('intid_jpenjualan'),
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					$this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
						//$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
						}
					}
           		}
            $data_free = $this->input->post('barang_free');
			if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
					 }
				 //untuk sementara
			if(isset($data_free[$i]['nomor_nota'])){
					$temp = $data_free[$i]['nomor_nota'];
				 }else{
					$temp = "";
					 }
            for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
					$detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $temp
									);
					 $this->Penjualan_model->add($detail_free);
					 if($this->input->post('buat_arisan')!="arisan") {
					 	//$this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
						}
				 	}
				}

		//001
		$smartspending = $this->input->post('chkSmart');
		if ($smartspending == "on") {
			redirect('penjualan/cetak_nota_asi');
			}
		
			
        if($this->input->post('radio')==6){
            $ci = '5';
            }else{
                $ci='7';
           		}

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
				}
            
            $this->db->trans_complete(); 
            if ($this->db->trans_status() === FALSE)
				{
				    $this->db->trans_rollback();
				}
				else
				{
				    $this->db->trans_commit();
				   redirect('penjualan/cetak_nota');
				
				}
			}
	}
	function temp(){
		$dealer = $this->input->post('strkode_dealer');
		$unit = $this->input->post('id_unit');
		//$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
        //$intid_dealer = $i->result();
		echo "".$dealer.", ".$unit;
	}
	function lookupBarangPoint(){
	/*
		$keyword = $this->input->post('term');
		$cekP = $this->input->post('state');
		$cabang = 0;
			$data['response'] = 'false'; 
			$point = $cekP;
			/*
			if($cekP == 'pr10'){
				$point = 'pr10';
			}else if($cekP == 20){
				$point = 'pr20';
			}else{
				$point = 'pr30';
			}
			*
			//$query = $this->Penjualan_model->selectBarang($keyword, 3); 
			$query = $this->Penjualan_model->selectBarangPromoCabang($keyword,$point,$cabang);
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					if($cabang[0]->intid_wilayah == 1){
						$hrg = $row->intpoint_jawa;
						$pv = $row->intpv_jawa;
						$um = $row->intum_jawa;
						$cicilan = $row->intcicilan_jawa;
					}else{
						$hrg = $row->intpoint_luarjawa;
						$pv = $row->intpv_luarjawa;
						$um = $row->intum_luarjawa;
						$cicilan = $row->intcicilan_luarjawa;
					}
					$data['message'][] = array(
											'id'	=>	$row->intid_barang,
											'value'	=>	$row->strnama,
											'value1' => $hrg,
											'value2' => $row->intspecial_luarjawa,
											'value3' => $pv,
											'value4' => $row->intpv_luarjawa,
											'value5' => $um,
											'value6' => $cicilan,
											'value7' => $row->intid_harga,
											'intid_barang_free' => intid_ 
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
        }*/
		$keyword = $this->input->post('term');
		$cekP = $this->input->post('rules');
		$free = $this->input->post('state');
		$intid_barang = $this->input->post('bayar');
		if($free == ''){
			$point = $cekP;
			$cabang = 0;
			$data['response'] = 'false'; 
			//$query = $this->Penjualan_model->selectBarang($keyword, 3); 
			//$query = $this->Penjualan_model->selectBarangPromoCabang($keyword,'spcr',$cabang);
			$query = $this->Penjualan_model->selectBarangPromoCabang($keyword,$point,$cabang);
			if( ! empty($query) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $query as $row )
				{
					$cabang = $this->User_model->getCabang($this->session->userdata('username'));
					if($cabang[0]->intid_wilayah == 1){
						$hrg = $row->intpoint_jawa;
						$pv = $row->intpv_jawa;
						$um = $row->intum_jawa;
						$cicilan = $row->intcicilan_jawa;
					}
					else if($cabang[0]->intid_wilayah == 2){
						$hrg = $row->intpoint_luarjawa;
						$pv = $row->intpv_luarjawa;
						$um = $row->intum_luarjawa;
						$cicilan = $row->intcicilan_luarjawa;
					}
					else if($cabang[0]->intid_wilayah == 3){
						$hrg = 0;
						$pv = 0;
						$um = 0;
						$cicilan = 0;
					}
					else if($cabang[0]->intid_wilayah == 4){
						$hrg = 0;
						$pv = 0;
						$um =0;
						$cicilan = 0;
					}
					$data['message'][] = array(
											'id'	=>	$row->intid_barang,
											'value'	=>	$row->strnama,
											'value1' => $hrg,
											'value2' => $row->intspecial_luarjawa,
											'value3' => $pv,
											'value4' => $row->intpv_luarjawa,
											'value5' => $um,
											'value6' => $cicilan,
											'value7' => $row->intid_harga,
											'intid_barang_free' => $row->intid_barang_free 
										 );
				}
						   
			}
		} 
		else {
				$cabang = 0;
				$data['response'] = 'false'; 
				//$query = $this->Penjualan_model->selectBarang($keyword, 3); 
				$query = $this->Penjualan_model->selectBarangPromoCabangFree($keyword,$cekP,$cabang,$intid_barang);
				if( ! empty($query) )
				{
					$data['response'] = 'true'; 
					$data['message'] = array(); 
					foreach( $query as $row )
					{
						$cabang = $this->User_model->getCabang($this->session->userdata('username'));
						if($cabang[0]->intid_wilayah == 1){
							$hrg = $row->intspecial_jawa;
							$pv = $row->intpv_jawa;
							$um = $row->intum_jawa;
							$cicilan = $row->intcicilan_jawa;
						}
						else if($cabang[0]->intid_wilayah == 2){
							$hrg = $row->intpoint_luarjawa;
							$pv = $row->intpv_luarjawa;
							$um = $row->intum_luarjawa;
							$cicilan = $row->intcicilan_luarjawa;
						}
						else if($cabang[0]->intid_wilayah == 3){
							$hrg = 0;
							$pv = 0;
							$um = 0;
							$cicilan = 0;
						}
						else if($cabang[0]->intid_wilayah == 4){
							$hrg = 0;
							$pv = 0;
							$um =0;
							$cicilan = 0;
						}
						$data['message'][] = array(
												'id'	=>	$row->intid_barang_pilih,
												'value'	=>	$row->strnama,
												'value1' => $hrg,
												'value2' => $row->intspecial_luarjawa,
												'value3' => $pv,
												'value4' => $row->intpv_luarjawa,
												'value5' => $um,
												'value6' => $cicilan,
												'value7' => $row->intid_harga,
												'intid_barang_free' => 0,
											 );
					}
							   
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
		function lookupBarangPromo10_jbarang(){
		$keyword = $this->input->post('term');
		$intid_jbarang = $this->input->post('intid_jbarang');
        $data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangPromo10_jbarang($keyword,$intid_jbarang);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
					else if($cabang[0]->intid_wilayah == 2){
						$hrg = $row->intharga_luarjawa;
						$pv = $row->intpv_luarjawa;
						$um = $row->intum_luarjawa;
						$cicilan = $row->intcicilan_luarjawa;
					}
					else if($cabang[0]->intid_wilayah == 3){
						$hrg = 0;
						$pv = 0;
						$um = 0;
						$cicilan = 0;
					}
					else if($cabang[0]->intid_wilayah == 4){
						$hrg = 0;
						$pv = 0;
						$um =0;
						$cicilan = 0;
					}
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
										'value'=>$row->promo,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
										'value5' => $um,
										'value6' => $cicilan,
                                        'value7' => $row->intid_harga,
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
	function lookupBarangFree10_jbarang(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
        $intid_jbarang = $this->input->post('intid_jbarang');
		
		$data['response'] = 'false';
        $query = $this->Penjualan_model->selectBarangFree10_jbarang($keyword, $state,$intid_jbarang);
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
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
                }
                else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur;
                    $pv = $row->intpv_kualalumpur;
                }
                else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur;
                    $pv = $row->intpv_luarkualalumpur;
                }
                $data['message'][] = array(
                                       'id'=>$row->intid_barang,
                                       'value'=>$row->promo,
                                       'value1' => $hrg,
                                       'value2' => $row->intharga_luarjawa,
                                       'value3' => $pv,
                                       'value4' => $row->intpv_luarjawa,
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
	function combo(){
		$data['error_message'] = "";
		if($this->input->post('combopass')){
					$data['result'] = $this->Penjualan_model->get_password("combo", $this->input->post('combopass'));
					if($data['result'] > 0){
					//redirect('penjualan/combo_after');
					redirect('penjualan/combo_penjualan');
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
		redirect('penjualan/grand');
	}
	function combotraining(){
		$data['error_message'] = "";
		if($this->input->post('combopass')){
					$data['result'] = $this->Penjualan_model->get_password("combotraining", $this->input->post('combopass'));
					if($data['result'] > 0){
					redirect('penjualan/combo_after_training');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
		redirect('penjualan/grand');
	}
	function cetak_nota_combo(){
		$id = $this->input->get('id');
		if($id == ""){
			$max = $this->Penjualan_model->get_MaxNota()->result();
			$id = $max[0]->intid_nota;
		}
		$ada = $this->Penjualan_model->get_CetakNota($id);
        $data['default'] = $this->Penjualan_model->get_CetakNota($id);
        $this->load->view('admin_views/penjualan/cetak_nota_combo', $data);
	}
	
	/* tidak digunakan lagi*/
	function combo_after(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
					$this->load->view('penjualan/combo_after_pass_20140911',$data);
				$this->load->view("penjualan/combo/javascript");
				///$this->load->view('penjualan/combo_20140910',$data);
			//	$this->load->view("penjualan/combo/javascript");
		}
			else{
             /* $this->db->trans_start(); */
			 /*
				TRANSACTIONS
				CodeIgniter's database abstraction allows you to use transactions with databases that support transaction-safe table types.
				In MySQL, you'll need to be running InnoDB or BDB table types rather than the more common MyISAM. Most other database platforms support transactions natively.
			*/
			//transaction untuk perubahan secara manual
			$this->db->trans_start();
			
				$this->Penjualan_model->insertNotaHal($_POST,'combo');
				
				$max = $this->Penjualan_model->get_MaxNota()->result();
				$id = $max[0]->intid_nota;

				$data = $this->input->post('barang');
				for($i=1;$i<=sizeof($data);$i++){
					if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
					}
					 }
				}

				 $data_free = $this->input->post('barang_free');
					 if(sizeof($data_free) <= 1){
						 $d = sizeof($data_free) + 1;
					 }else{
						 $d = sizeof($data_free);
					 }
				 for($i=1;$i<=30;$i++){
					 if(!empty($data_free[$i]['intid_id'])){
					 
					 $detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail_free);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
					}
					 }
				   
				}

			//001
			$smartspending = $this->input->post('chkSmart');
			if ($smartspending == "on") {
				redirect('penjualan/cetak_nota_asi');
			}
			
				
				if($this->input->post('radio')==6){
					$ci = '5';
				}else{
					$ci='7';
				}

				//pilih cicilan
				if($this->input->post('buat_arisan')=="arisan"){

						$arisan = array(
										'intid_arisan_detail' 	=> $id,
										'intuang_muka'		    => $this->input->post('intuangmukahide'),
										'intcicilan'            => $this->input->post('intcicilanhide'),
										'intjeniscicilan'		=> $ci,
										'group'                 => $this->input->post('group')
										);
						$this->Penjualan_model->add_arisan($arisan);
						$id_arisan =$this->db->insert_id();
						$bulan = date('m');
						$tahun = date('Y');
						$ket = 'Pembayaran Cicilan langsung Ketika Daftar';
						$ket_um = 'Pembayaran Uang Muka';
						$this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
						$cicil_cek = $this->input->post('intc');
						for ($v=1;$v<=7;$v++){
							 if(!empty($cicil_cek[$v])){
								$this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
							 }
						}
				 }
				
				 $this->db->trans_complete();
				redirect('penjualan/cetak_nota_combo/?id='. $id); 
				 
				 //transaction : melihat kondisi jika terjadi kegagalan atau berhasil
            /* if ($this->db->trans_status() === FALSE)
				{
					//trasaction : rollback jika transaksi gagal 
					$this->db->trans_rollback();
					redirect('penjualan/');
				}
				else
				{
					//trasaction : commit jika terjadi transaksi berhasil
					$this->db->trans_commit();
					if ($smartspending == "on") { //cetak nota smartspending
						redirect('penjualan/cetak_nota_asi');
					}else{//cetak nota reguler
							//redirect('penjualan/cetak_nota/?back_url='.$back_url.'');
							//redirect('laporan/viewNotaid/'.$id);
							redirect('penjualan/cetak_nota_combo/?id='. $id); 
							}
				} */
				
			}
		}
		function combo_after123(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
				/* $this->load->view('penjualan/combo_20140910',$data); */
				$this->load->view('penjualan/combo_after_pass_20140911_1',$data);
				$this->load->view("penjualan/combo/javascript_dp");
		}
			else{
             /* $this->db->trans_start(); */
			 /*
				TRANSACTIONS
				CodeIgniter's database abstraction allows you to use transactions with databases that support transaction-safe table types.
				In MySQL, you'll need to be running InnoDB or BDB table types rather than the more common MyISAM. Most other database platforms support transactions natively.
			*/
			//transaction untuk perubahan secara manual
			$this->db->trans_begin();
			
				$this->Penjualan_model->insertNotaHal($_POST,'combo');
				
				$max = $this->Penjualan_model->get_MaxNota()->result();
				$id = $max[0]->intid_nota;

				$data = $this->input->post('barang');
				for($i=1;$i<=sizeof($data);$i++){
					if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
					}
					 }
				}

				 $data_free = $this->input->post('barang_free');
					 if(sizeof($data_free) <= 1){
						 $d = sizeof($data_free) + 1;
					 }else{
						 $d = sizeof($data_free);
					 }
				 for($i=1;$i<=30;$i++){
					 if(!empty($data_free[$i]['intid_id'])){
					 
					 $detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail_free);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
					}
					 }
				   
				}

			//001
			$smartspending = $this->input->post('chkSmart');
			if ($smartspending == "on") {
				redirect('penjualan/cetak_nota_asi');
			}
			
				
				if($this->input->post('radio')==6){
					$ci = '5';
				}else{
					$ci='7';
				}

				//pilih cicilan
				if($this->input->post('buat_arisan')=="arisan"){

						$arisan = array(
										'intid_arisan_detail' 	=> $id,
										'intuang_muka'		    => $this->input->post('intuangmukahide'),
										'intcicilan'            => $this->input->post('intcicilanhide'),
										'intjeniscicilan'		=> $ci,
										'group'                 => $this->input->post('group')
										);
						$this->Penjualan_model->add_arisan($arisan);
						$id_arisan =$this->db->insert_id();
						$bulan = date('m');
						$tahun = date('Y');
						$ket = 'Pembayaran Cicilan langsung Ketika Daftar';
						$ket_um = 'Pembayaran Uang Muka';
						$this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
						$cicil_cek = $this->input->post('intc');
						for ($v=1;$v<=7;$v++){
							 if(!empty($cicil_cek[$v])){
								$this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
							 }
						}
				 }
				
				/* $this->db->trans_complete();
				redirect('penjualan/cetak_nota_combo/?id='. $id); 
				 */
				 //transaction : melihat kondisi jika terjadi kegagalan atau berhasil
            if ($this->db->trans_status() === FALSE)
				{
					//trasaction : rollback jika transaksi gagal 
					$this->db->trans_rollback();
					redirect('penjualan/');
				}
				else
				{
					//trasaction : commit jika terjadi transaksi berhasil
					$this->db->trans_commit();
					if ($smartspending == "on") { //cetak nota smartspending
						redirect('penjualan/cetak_nota_asi');
					}else{//cetak nota reguler
							//redirect('penjualan/cetak_nota/?back_url='.$back_url.'');
							//redirect('laporan/viewNotaid/'.$id);
							redirect('penjualan/cetak_nota_combo/?id='. $id); 
							}
				}
				
			}
		}
	/* end*/
		
		function combo_after_training(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
				$this->load->view('penjualan/combo_after_pass_2',$data);
				$this->load->view("penjualan/combo/javascript_promotraining");
		}
			else{
             $this->db->trans_start();
				$this->Penjualan_model->insertNotaHal($_POST,'combo');
				
				$max = $this->Penjualan_model->get_MaxNota()->result();
				$id = $max[0]->intid_nota;

				$data = $this->input->post('barang');
				for($i=1;$i<=sizeof($data);$i++){
					if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
					}
					 }
				}

				 $data_free = $this->input->post('barang_free');
					 if(sizeof($data_free) <= 1){
						 $d = sizeof($data_free) + 1;
					 }else{
						 $d = sizeof($data_free);
					 }
				 for($i=1;$i<=30;$i++){
					 if(!empty($data_free[$i]['intid_id'])){
					 
					 $detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail_free);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
					}
					 }
				   
				}

			//001
			$smartspending = $this->input->post('chkSmart');
			if ($smartspending == "on") {
				redirect('penjualan/cetak_nota_asi');
			}
			
				
				if($this->input->post('radio')==6){
					$ci = '5';
				}else{
					$ci='7';
				}

				//pilih cicilan
				if($this->input->post('buat_arisan')=="arisan"){

						$arisan = array(
										'intid_arisan_detail' 	=> $id,
										'intuang_muka'		    => $this->input->post('intuangmukahide'),
										'intcicilan'            => $this->input->post('intcicilanhide'),
										'intjeniscicilan'		=> $ci,
										'group'                 => $this->input->post('group')
										);
						$this->Penjualan_model->add_arisan($arisan);
						$id_arisan =$this->db->insert_id();
						$bulan = date('m');
						$tahun = date('Y');
						$ket = 'Pembayaran Cicilan langsung Ketika Daftar';
						$ket_um = 'Pembayaran Uang Muka';
						$this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
						$cicil_cek = $this->input->post('intc');
						for ($v=1;$v<=7;$v++){
							 if(!empty($cicil_cek[$v])){
								$this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
							 }
						}
				 }
				
				$this->db->trans_complete();
				redirect('penjualan/cetak_nota_combo/?id='. $id); 
				
			}
		}
	function specialBeforeAbo(){
		
		$this->load->view('penjualan/abo/selectUpline');
		}	
	function spesialABO(){
        
        
			$data['intid_dealer'] 	= $this->input->post("intid_dealer");
			$data['strkode_dealer'] 	= $this->input->post("strkode_dealer");
			$data['intid_unit'] 		= $this->input->post("id_unit");
			
			$data['unit']				=	$this->input->post("unit");
			$data['strnama_dealer']	=	$this->input->post("strnama_dealer");
			
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			//$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial(); //karena tidak support dengan penjualan netto
			/*
			$jpenjualan = $this->Penjualan_model->selectJPenjualanSpesial_ver2();
			foreach ($jpenjualan as $g)
			{
				/*
				//bandung only
				if($g->intid_jpenjualan == 7 and ($nm_cabang[0]->intid_cabang == 2 or $nm_cabang[0]->intid_cabang == 28 or $nm_cabang[0]->intid_cabang == 1)){
					//echo "yo<br/>";
					$data['intid_jpenjualan'][]	 	= 14;
					$data['strnama_jpenjualan'][] 	= "SPECIAL BANDUNG";
				}
				if($g->intid_jpenjualan == 11 or $g->intid_jpenjualan == 12){
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
					*
			}
			*/
			$data['intid_jpenjualan'][]	 	= 1;
			$data['strnama_jpenjualan'][] 	= "REGULAR Rek Ayo Rek";
		
			
			
			$this->load->view('admin_views/penjualan/abo', $data);
			
		}
	function saveAbo(){
		if($_POST){
			$this->db->trans_start(); 
			$intid_nota_sp = $this->input->post('intid_nota_sp');
			//echo ": ".$this->input->post('jumlah');
			$hal = $this->input->post('halaman');
			if(empty($hal)){
				$hal = "";
				}else{
					$hal = $this->input->post('halaman');
					}
			//oke ROCK N ROLL 
			//begin transaction		
            //$this->Penjualan_model->insertNota($_POST);
			//echo  $this->input->post('strkode_dealer').",".$this->input->post('id_unit');
            $this->Penjualan_model->insertNotaHal($_POST,$hal);
           	
			//untuk kondisi coba dulu deh
			//for($i=sizeof($intid_nota_sp);$i>=0;$i--){
					//if(isset($intid_nota_sp[$i])){
						$downline = $this->input->post('downline');
						$dataCek = array(
									   'is_abo' => 1,
									);

						$this->db->where('strkode_dealer', $downline);
						$this->db->update('member', $dataCek); 
				//		}					
				//	}
			/*		*/
					/*
			if($intid_nota_sp[0]){
           		$dataTemp = array(
				               'is_sp' => 1,
				            );

				$this->db->where('intid_nota', $intid_nota_sp[0]);
				$this->db->update('nota', $dataTemp); 
           		}
				*/
           	$max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					$this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
						//$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
						}
					}
           		}
            $data_free = $this->input->post('barang_free');
			if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
					 }
				 //untuk sementara
			if(isset($data_free[$i]['nomor_nota'])){
					$temp = $data_free[$i]['nomor_nota'];
				 }else{
					$temp = "";
					 }
            for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
					$detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $temp
									);
					 $this->Penjualan_model->add($detail_free);
					 if($this->input->post('buat_arisan')!="arisan") {
					 	//$this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
						}
				 	}
				}

		//001
		$smartspending = $this->input->post('chkSmart');
		if ($smartspending == "on") {
			redirect('penjualan/cetak_nota_asi');
			}
		
			
        if($this->input->post('radio')==6){
            $ci = '5';
            }else{
                $ci='7';
           		}

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
				}
            
            $this->db->trans_complete(); 
            if ($this->db->trans_status() === FALSE)
				{
				    $this->db->trans_rollback();
				}
				else
				{
				    $this->db->trans_commit();
				   redirect('penjualan/cetak_nota');
				
				}
			}
		}
	
	//ifirlana@gmail.com 2014 04 17
	//desc : menggantikan lookupBarangLain yang lama. 
	
	function lookupBarangLaintipe2(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangLaintipe2($keyword); 
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
                }else{
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
                }
                $data['message'][] = array( 
                                        'id'=>$row->intid_barang,
                                        'value' => $row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
	
	//function for free barang lain
	
	function lookupBarangLainFree(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangLain($keyword); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {

                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = 0;
                    $pv = 0;
                }else{
                    $hrg = 0;
                    $pv =0;
                }
                $data['message'][] = array( 
                                        'id'=>$row->intid_barang,
                                        'value' => $row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
	
	//function for free barang lain
	
	function lookupBarangLainTulip50(){
		
			$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang($keyword,1); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {

                 $cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa / 2;
                    $pv = $row->intpv_jawa  / 2;
                }else{
                    $hrg = $row->intharga_luarjawa / 2;
                    $pv = $row->intpv_luarjawa / 2;
                }
                $data['message'][] = array( 
                                        'id'=>$row->intid_barang,
                                        'value' => $row->strnama,
                                        'value1' => $hrg,
										'value2' => $row->intharga_luarjawa,
										'value3' => $pv,
										'value4' => $row->intpv_luarjawa,
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
	
	//ujicoba stok
	function nota_stock(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
            $cabang = $this->User_model->getCabang($this->session->userdata('username'));
			//kondisikan ke penjualantipesat.php
			/*
			if($cabang[0]->is_scanner == 1){
				redirect("penjualantipesatu");
			}
			*/
			if ($cabang[0]->is_nota == 0 ){
				redirect('site/home');
			}
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
			$data['is_launch'] = $nm_cabang[0]->is_launch;


			$data['user'] = $this->session->userdata('username');
            $data['max_id'] = $this->getno_nota();
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualan();
			
			foreach ($jpenjualan as $g)
			{
				if($cabang[0]->intid_cabang == 1 or $cabang[0]->intid_cabang == 43){ //kecuali admin
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
					}
					else if($nm_cabang[0]->intid_wilayah == 4 or $nm_cabang[0]->intid_wilayah == 3){
						$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
						$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan; 
						}
						else{
							if($g->intid_jpenjualan != 4){ //tradein forbidden
								$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
								$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
								}
							}
					/*
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				*/
			}
			
			$this->load->view('admin_views/penjualan/nota_20140627', $data);
		 }else{
             $hal = $this->input->post('halaman');
			if(empty($hal)){
				$hal = "";
			}else{
				$hal = $this->input->post('halaman');
			}
			
				$back_url = $this->input->post('back_url');
				if(empty($back_url)){
					$back_url = "";
					}
			/*
				TRANSACTIONS
				CodeIgniter's database abstraction allows you to use transactions with databases that support transaction-safe table types.
				In MySQL, you'll need to be running InnoDB or BDB table types rather than the more common MyISAM. Most other database platforms support transactions natively.
			*/
			//transaction untuk perubahan secara manual
			$this->db->trans_begin();

            //$this->Penjualan_model->insertNota($_POST);
            $this->Penjualan_model->insertNotaHal($_POST,$hal);
           
            $max = $this->Penjualan_model->get_MaxNota()->result();
            $id = $max[0]->intid_nota;

			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
				if(!empty($data[$i]['intid_id'])){
				$detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);
				 $this->Penjualan_model->add($detail);
				if($this->input->post('buat_arisan')!="arisan") {
				 //$this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
				}
				 }
            }
             $data_free = $this->input->post('barang_free');
				 if(sizeof($data_free) <= 1){
					 $d = sizeof($data_free) + 1;
				 }else{
					 $d = sizeof($data_free);
				 }
				 //untuk sementara
				 if(isset($data_free[$i]['nomor_nota'])){
					$temp = $data_free[$i]['nomor_nota'];
				 }else{
					$temp = "";
				 }
             for($i=1;$i<=30;$i++){
				 if(!empty($data_free[$i]['intid_id'])){
				 
				 $detail_free = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data_free[$i]['intid_id'],
								'intquantity'		    => $data_free[$i]['intquantity'],
								'is_free' 				=> 1,
								'intid_harga'			=> 0,
								'nomor_nota'			=> $temp
								);
				 $this->Penjualan_model->add($detail_free);
				if($this->input->post('buat_arisan')!="arisan") {
				// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
				}
				 }
               
		 	}

		//001
		$smartspending = $this->input->post('chkSmart');
		
            if($this->input->post('radio')==6){
                $ci = '5';
            }else{
                $ci='7';
            }

            //pilih cicilan
            if($this->input->post('buat_arisan')=="arisan"){

                    $arisan = array(
                                    'intid_arisan_detail' 	=> $id,
                                    'intuang_muka'		    => $this->input->post('intuangmukahide'),
                                    'intcicilan'            => $this->input->post('intcicilanhide'),
                                    'intjeniscicilan'		=> $ci,
                                    'group'                 => $this->input->post('group')
                                    );
                    $this->Penjualan_model->add_arisan($arisan);
                    $id_arisan =$this->db->insert_id();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $ket = 'Pembayaran Cicilan langsung Ketika Daftar';
                    $ket_um = 'Pembayaran Uang Muka';
                    $this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
                    $cicil_cek = $this->input->post('intc');
                    for ($v=1;$v<=7;$v++){
                         if(!empty($cicil_cek[$v])){
                            $this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
                         }
                    }
			 }
            //transaction : melihat kondisi jika terjadi kegagalan atau berhasil
            if ($this->db->trans_status() === FALSE)
				{
					//trasaction : rollback jika transaksi gagal 
					$this->db->trans_rollback();
					redirect('penjualan/');
				}
				else
				{
					//trasaction : commit jika terjadi transaksi berhasil
					$this->db->trans_commit();
					if ($smartspending == "on") { //cetak nota smartspending
						redirect('penjualan/cetak_nota_asi');
					}else{//cetak nota reguler
							redirect('penjualan/cetak_nota/?back_url='.$back_url.'');
							}
				}
		}
		}
		
		//NEW
		//2014 06 27  stock barang
		function lookupBarangStock(){
			$keyword = $this->input->post('term');
			$jbarang = $this->input->post('state');
			$data['response'] = 'false'; 
			
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
			$query = $this->sbm->selectBarang($keyword, $jbarang,$cabang[0]->intid_cabang); 
			
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
						$um = $row->intum_jawa;
						$cicilan = $row->intcicilan_jawa;
						$jumlah_quantity = $row->jumlah_quantity;
					}elseif($cabang[0]->intid_wilayah == 2){
						$hrg = $row->intharga_luarjawa;
						$pv = $row->intpv_luarjawa;
						$um = $row->intum_luarjawa;
						$cicilan = $row->intcicilan_luarjawa;
						$jumlah_quantity = $row->jumlah_quantity;
					}
					else if($cabang[0]->intid_wilayah == 3){
						$hrg = $row->intharga_kualalumpur;
						$pv = $row->intpv_kualalumpur;
						$um = 0;
						$cicilan = 0;
						$jumlah_quantity = $row->jumlah_quantity;
					}
					else if($cabang[0]->intid_wilayah == 4){
						$hrg = $row->intharga_luarkualalumpur;
						$pv = $row->intpv_luarkualalumpur;
						$um = 0;
						$cicilan = 0;
						$jumlah_quantity = $row->jumlah_quantity;
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
											'value7' => $row->intid_harga,
											'value_quantity' =>$jumlah_quantity,
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
	
	//launching 
	function lookupBarangSatuFreeSatuBayarLaunchingBarang(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarangSatuFreeSatuBayar($keyword,'lanch',$cabang[0]->intid_cabang); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa;
                    $pv = $row->intpv_jawa;
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangSatuFreeSatufreeLaunchingBarang(){
		$keyword = $this->input->post('term');
        $state = $this->input->post('state');
		$data['response'] = 'false';
       $cabang = $this->User_model->getCabang($this->session->userdata('username'));
		 $query = $this->Penjualan_model->lookupBarangSatuFreeSatufree($keyword, $state,'lanch',$cabang[0]->intid_cabang);
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
					$um = $row->intum_jawa;
					$cicilan = $row->intcicilan_jawa;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa;
                    $pv = $row->intpv_luarjawa;
					$um = $row->intum_luarjawa;
					$cicilan = $row->intcicilan_luarjawa;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangDiskon20(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang40($keyword,'kom15'); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa*0.8;
                    $pv = $row->intpv_jawa*0.8;
					$um = $row->intum_jawa*0.8;
					$cicilan = $row->intcicilan_jawa*0.8;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa*0.8;
                    $pv = $row->intpv_luarjawa*0.8;
					$um = $row->intum_luarjawa*0.8;
					$cicilan = $row->intcicilan_luarjawa*0.8;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	
	//start
	function lookupBarangDiskon50(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang40($keyword,'dis50',$cabang[0]->intid_cabang, $cabang[0]->intid_wilayah); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa*0.5;
                    $pv = $row->intpv_jawa*0.5;
					$um = $row->intum_jawa*0.5;
					$cicilan = $row->intcicilan_jawa*0.5;
                }
				else if($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa*0.5;
                    $pv = $row->intpv_luarjawa*0.5;
					$um = $row->intum_luarjawa*0.5;
					$cicilan = $row->intcicilan_luarjawa*0.5;
                }
				else if($cabang[0]->intid_wilayah == 3){
                    $hrg = $row->intharga_kualalumpur*0.5;
                    $pv = $row->intpv_kualalumpur*0.5;
					$um = 0;
					$cicilan = 0;
                }
				else if($cabang[0]->intid_wilayah == 4){
                    $hrg = $row->intharga_luarkualalumpur*0.5;
                    $pv = $row->intpv_luarkualalumpur*0.5;
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	
	function lookupBarangDiskon40nokomisi(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
		$state = $this->input->post('state');
		$vocherpromo = 0;
		$voucherpvpromo = 0;
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang40($keyword,'dis40nokomisi'); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
					 if($row->intid_jbarang == 2 && $state == 1){
						$vocherpromo = 50000;
						$voucherpvpromo = 0.5;
					} else {
						$vocherpromo = 0;
						$voucherpvpromo = 0 ;
					}
                    $hrg = ($row->intharga_jawa - $vocherpromo)*0.6;
                    $pv = ($row->intpv_jawa - $voucherpvpromo)*0.6;
					$um = $row->intum_jawa*0.6;
					$cicilan = $row->intcicilan_jawa*0.6;
                }
				else if($cabang[0]->intid_wilayah == 2){
				/* if($row->intid_jbarang == 2){
						$vocherpromo = 60000;
						$voucherpvpromo = 0.6;
					} */
                    $hrg = ($row->intharga_luarjawa - $vocherpromo)*0.6;
                    $pv = ($row->intpv_luarjawa - $voucherpvpromo)*0.6;
					$um = $row->intum_luarjawa*0.6;
					$cicilan = $row->intcicilan_luarjawa*0.6;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	function lookupBarangDiskon40(){

		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$keyword = $this->input->post('term');
		$state = $this->input->post('state');
		$vocherpromo = 0;
		$voucherpvpromo = 0;
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectBarang40($keyword,'dis40',$cabang[0]->intid_cabang, $cabang[0]->intid_wilayah); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
               
                if($cabang[0]->intid_wilayah == 1){
					 if($row->intid_jbarang == 2 && $state == 1){
						$vocherpromo = 50000;
						$voucherpvpromo = 0.5;
					} else {
						$vocherpromo = 0;
						$voucherpvpromo = 0 ;
					}
                    $hrg = ($row->intharga_jawa - $vocherpromo)*0.6;
                    $pv = ($row->intpv_jawa - $voucherpvpromo)*0.6;
					$um = $row->intum_jawa*0.6;
					$cicilan = $row->intcicilan_jawa*0.6;
                }
				else if($cabang[0]->intid_wilayah == 2){
					if($row->intid_jbarang == 2 && $state == 1){
						$vocherpromo = 60000;
						$voucherpvpromo = 0.6;
					}
                    $hrg = ($row->intharga_luarjawa - $vocherpromo)*0.6;
                    $pv = ($row->intpv_luarjawa - $voucherpvpromo)*0.6;
					$um = $row->intum_luarjawa*0.6;
					$cicilan = $row->intcicilan_luarjawa*0.6;
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
					$um =0;
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
                                        'value7' => $row->intid_harga,
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
	
	/////line ikhlas 11042013//
	function diskon40()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("diskon40", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('diskon40/nota_terbaru');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function bigsuprase()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("lglain", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/lglain');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function wafflesuprase()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("lgwaffle", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/lglain1');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function povalsuprase()
	{ 
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("lgoval", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/lglainoval');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function p45finedining()
	{ 
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("45finedining", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('promo17845');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function predwhite()
	{ 
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("prRedWhite", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('promorw');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function pavenger()
	{ 
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("PaketAvenger", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('promoavenger');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function pthink()
	{ 
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("think", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/lglainthink');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function betobe()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("betobe", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/notabetobe');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function nota20k15()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("dis20k15", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/notad20k15');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function netvoucher()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("netvoucher", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('voucher/nota');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}/////line ikhlas 11042013//
	function diskon40nokomisi()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("diskon40nokomisi", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('diskon40nokomisi/nota');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}

	function diskon50()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("diskon50", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('diskon50/nota');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function diskonpromo60netto()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("diskonpromobintulu", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('promo60net/nota25k10');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function diskonpromo4020()
	{
		$data['error_message'] = "";
		if($this->input->post('diskon')){
					$data['result'] = $this->Penjualan_model->get_password("diskonpromo4020", $this->input->post('diskon'));
					if($data['result'] > 0){
					redirect('penjualan/grand_pass1');
					
				}else{
					$data['error_message'] = "<div class='error_message'> login salah</div>";
					$this->load->view('admin_views/penjualan/grand', $data);
					}
		}else{
			$this->load->view('admin_views/penjualan/grand', $data);
		}
	}
	function hitung_data(){
		$select = "select * from member where intid_cabang =104 group by intid_dealer";
		echo $select."<br />";
		$query = $this->db->query($select);
		foreach($query->result() as $row){
			$this->db->trans_start(); //transaction data
		
			$data_staterkit['intid_dealer'] 	= $row->intid_dealer;
			$data_staterkit['intid_cabang']	= $row->intid_cabang;
			echo $row->strnama_dealer." ".$row->intid_dealer.", ".$row->intid_cabang."<br />";
			//$this->mdl_membership->insert_starterkit_barcode($data_staterkit);
			
			$this->db->trans_complete();//trasaksi data complete
			}
		}
	/**
	* combo terbaru inputan 
	* 
	*/
	function combo_pass(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
				$this->load->view('penjualan/combo_after_pass',$data);
			//	$this->load->view("penjualan/combo/javascript");
		}
			else{
             $this->db->trans_start();
				$this->Penjualan_model->insertNotaHal_combo($_POST,'combo');
				
				$max = $this->Penjualan_model->get_MaxNota()->result();
				$id = $max[0]->intid_nota;

				$data = $this->input->post('barang');
				for($i=1;$i<=sizeof($data);$i++){
					if(!empty($data[$i]['intid_id'])){
					$detail = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data[$i]['intid_id'],
									'intquantity'		    => $data[$i]['intquantity'],
									'intid_harga'		    => $data[$i]['intid_id'],
									'intharga'				=> $data[$i]['intid_harga'],
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data[$i]['intid_id'], $data[$i]['intquantity'], $this->input->post('intid_cabang'), $this->input->post('intno_nota'));
					}
					 }
				}

				 $data_free = $this->input->post('barang_free');
					 if(sizeof($data_free) <= 1){
						 $d = sizeof($data_free) + 1;
					 }else{
						 $d = sizeof($data_free);
					 }
				 for($i=1;$i<=30;$i++){
					 if(!empty($data_free[$i]['intid_id'])){
					 
					 $detail_free = array(
									'intid_nota' 			=> $id,
									'intid_barang'	        => $data_free[$i]['intid_id'],
									'intquantity'		    => $data_free[$i]['intquantity'],
									'is_free' 				=> 1,
									'intid_harga'			=> 0,
									'nomor_nota'			=> $data[$i]['nomor_nota']
									);
					 $this->Penjualan_model->add($detail_free);
					if($this->input->post('buat_arisan')!="arisan") {
					// $this->Penjualan_model->addStok($data_free[$i]['intid_id'], $data_free[$i]['intquantity'], $this->input->post('intid_cabang'),$this->input->post('intno_nota'));
					}
					 }
				   
				}

			//001
			$smartspending = $this->input->post('chkSmart');
			if ($smartspending == "on") {
				redirect('penjualan/cetak_nota_asi');
			}
			
				
				if($this->input->post('radio')==6){
					$ci = '5';
				}else{
					$ci='7';
				}

				//pilih cicilan
				if($this->input->post('buat_arisan')=="arisan"){

						$arisan = array(
										'intid_arisan_detail' 	=> $id,
										'intuang_muka'		    => $this->input->post('intuangmukahide'),
										'intcicilan'            => $this->input->post('intcicilanhide'),
										'intjeniscicilan'		=> $ci,
										'group'                 => $this->input->post('group')
										);
						$this->Penjualan_model->add_arisan($arisan);
						$id_arisan =$this->db->insert_id();
						$bulan = date('m');
						$tahun = date('Y');
						$ket = 'Pembayaran Cicilan langsung Ketika Daftar';
						$ket_um = 'Pembayaran Uang Muka';
						$this->Penjualan_model->add_arisan_detail_um($id_arisan, $ket_um);
						$cicil_cek = $this->input->post('intc');
						for ($v=1;$v<=7;$v++){
							 if(!empty($cicil_cek[$v])){
								$this->Penjualan_model->add_arisan_detail_langsung($id_arisan, $ket);
							 }
						}
				 }
				
				$this->db->trans_complete();
				redirect('penjualan/cetak_nota_combo/?id='. $id); 
				
			}
		}
	/**
	*	combo yang digunanakan yang terbaru
	*/
	function combo_penjualan(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				$week = $this->Penjualan_model->selectWeek();//.
				$data['intid_week']	=	$week[0]->intid_week;
				/* select promo controll */
				$data['prom'] = $this->combo_mdl->selectControllPromo();
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
				
				/* $this->load->view('test/combo_test1',$data); */
				/* $this->load->view('test/combo_test4',$data); */
				$this->load->view('test/combo_test5',$data);
				$this->load->view("penjualan/combo/javascriptnew1");				
				/* $this->load->view('test/combo_test',$data);
				$this->load->view("penjualan/combo/javascript"); */
		}
		}
		function combo_penjualan1(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				$week = $this->Penjualan_model->selectWeek();//.
				$data['intid_week']	=	$week[0]->intid_week;
				$data['prom'] = $this->combo_mdl->selectControllPromo();
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
				$this->load->view('test/combo_test5',$data);
				$this->load->view("penjualan/combo/javascriptnew2");
		}
		}
	//end
	function combo_dp(){
			
			$this->db->trans_start();
			$hal=$this->input->post('halaman');
			$urlslink = $this->input->post('urlslink');
			
            /* $id	=	$this->Penjualan_model->insertNotaHal_terbaru($_POST,"comdp"); */
            $id	=	$this->Penjualan_model->insertNotaHal_terbaru($_POST,$hal);
			
			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
            }
            }
			 
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
             
            
             if(!empty($data_free[$i]['intid_id'])){
             
              
             $detail_free = array(
							'intid_nota' 			=> $id,
							'intid_barang'	        => $data_free[$i]['intid_id'],
							'intquantity'		    => $data_free[$i]['intquantity'],
                            'is_free' 				=> 1,
							'intid_harga'			=> 0,
							//'nomor_nota'			=> $data[$i]['nomor_nota']
							);
             $this->Penjualan_model->add($detail_free);
             }
               
		 	} 
			
			$this->db->trans_complete();
			if($this->input->post('is_dp') == 1){
				redirect('penjualan/cetak_notadp/?id='.$id);
				}else{
					/* redirect('laporan/viewNotaid/'.$id.'/?url=');	 */		
						redirect('laporan/viewNotaid/'.$id.'/?url='.$urlslink);
					}
		}
		function combo_dp1(){
			
			$this->db->trans_start();
			$hal=$this->input->post('halaman');
			$urlslink = $this->input->post('urlslink');
			
            /* $id	=	$this->Penjualan_model->insertNotaHal_terbaru($_POST,"comdp"); */
            $id	=	$this->Penjualan_model->insertNotaHal_terbaru($_POST,$hal);
			
			$data = $this->input->post('barang');
            for($i=1;$i<=sizeof($data);$i++){
            if(!empty($data[$i]['intid_id'])){
            $detail = array(
								'intid_nota' 			=> $id,
								'intid_barang'	        => $data[$i]['intid_id'],
								'intquantity'		    => $data[$i]['intquantity'],
								'intid_harga'		    => $data[$i]['intid_id'],
								'intharga'				=> $data[$i]['intid_harga'],
								'nomor_nota'			=> $data[$i]['nomor_nota']
								);

             $this->Penjualan_model->add($detail);
            }
            }
			 
             $data_free = $this->input->post('barang_free');
             if(sizeof($data_free) <= 1){
                 $d = sizeof($data_free) + 1;
             }else{
                 $d = sizeof($data_free);
             }
             for($i=1;$i<=30;$i++){
             
            
             if(!empty($data_free[$i]['intid_id'])){
             
              
             $detail_free = array(
							'intid_nota' 			=> $id,
							'intid_barang'	        => $data_free[$i]['intid_id'],
							'intquantity'		    => $data_free[$i]['intquantity'],
                            'is_free' 				=> 1,
							'intid_harga'			=> 0,
							//'nomor_nota'			=> $data[$i]['nomor_nota']
							);
             $this->Penjualan_model->add($detail_free);
             }
               
		 	} 
			
			$this->db->trans_complete();
			if($this->input->post('is_dp') == 1){
				redirect('penjualan/cetak_notadp/?id='.$id);
				}else{
					//echo $urlslink;
					redirect('laporan/viewNotaid/'.$id.'/?url='.$urlslink);							
					}
		}
	function lookupBarangMini2030(){
		$keyword = $this->input->post('term');
		$jbarang = $this->input->post('state');
        $data['response'] = 'false'; 
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $query = $this->Penjualan_model->selectMini2030($keyword, $jbarang,$cabang[0]->intid_cabang); 
		if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                //$cabang = $this->User_model->getCabang($this->session->userdata('username'));
                if($cabang[0]->intid_wilayah == 1){
                    $hrg = $row->intharga_jawa/*  * 0.7 */;
                    $pv = $row->intpv_jawa /* * 0.7 */;
					$um = $row->intum_jawa/*  * 0.7 */;
					$cicilan = $row->intcicilan_jawa/*  * 0.7 */;
                }elseif($cabang[0]->intid_wilayah == 2){
                    $hrg = $row->intharga_luarjawa /* * 0.7 */;
                    $pv = $row->intpv_luarjawa /* * 0.7 */;
					$um = $row->intum_luarjawa/*  * 0.7 */;
					$cicilan = $row->intcicilan_luarjawa/*  * 0.7 */;
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
                                        'value7' => $row->intid_harga,
                                        'value8' => $row->status_free,
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
	function combo_penjualan_test(){
		$this->form_validation->set_rules('intno_nota', 'No Nota', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
		if ($this->form_validation->run() == FALSE)
		{
				$cabang = $this->User_model->getCabang($this->session->userdata('username'));
				$nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		
				$data['cabang'] = $nm_cabang[0]->strnama_cabang;
				$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
				$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
		
		
				$data['user'] = $this->session->userdata('username');
				$data['max_id'] = $this->getno_nota();
				
				$jpenjualan = $this->Penjualan_model->selectJPenjualanReguler();//untuk hari pemilu saja.
				
				$week = $this->Penjualan_model->selectWeek();//.
				$data['intid_week']	=	$week[0]->intid_week;
				
				//$jpenjualan = $this->Penjualan_model->selectJPenjualanNotTrade();
				foreach ($jpenjualan as $g)
				{
					$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
					$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan;
				}
					
				$this->load->view('test/combo_test',$data);
				$this->load->view("penjualan/combo/javascript");
		}
		}
	
	/**
	*	@param update_cicilan_keluar_barang
	*	desc
	*	mengeluarkan data barang di nota_hadiah
	*/
	function update_cicilan_keluar_barang($id, $cicilan,$no_nota,$id_unit,$intid_dealer,$intid_awal){
	
		$m = $this->Penjualan_model->viewTotalbayar($id);
        $this->Penjualan_model->update_cicilan_keluar_barang($id, $cicilan, $no_nota);
		
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $intid_cabang = $cabang[0]->intid_cabang;
		
		$tgl = date("Y-m-d");
		$week = $this->Penjualan_model->selectWeek();
        $intid_week= $week[0]->intid_week;
		
		$data = array(
            'intno_nota' => $no_nota,
            'intid_cabang' => $intid_cabang,
            'datetgl' => $tgl,
			'intid_dealer' => $intid_dealer,
			'intid_unit' => $id_unit,
			'intid_week' => $intid_week,
			'jenis_nota' => 'AR01',
			'keterangan' => 'Pengambilan Barang'
		);
        $this->db->insert('nota_hadiah', $data);
		$intid_nota =$this->db->insert_id();
		
		$barang= "";
		$db = $this->db->query("select * from nota_detail where intid_nota = '$intid_awal'");
		foreach($db->result() as $row){
			$detail = array(
									'intid_nota' => $intid_nota,
									'intid_barang' => $row->intid_barang,
									'intquantity' => $row->intquantity,
									'ket' => 'keluar barang',
									'nomor_nota' => $row->nomor_nota,
									);
			$this->Penjualan_model->addhadiah($detail);
			
			}
		$penjualan['intid_nota']	=$intid_nota;
		
		echo json_encode($penjualan);
		}
	function lookupCabangBsStock(){
		$keyword = $this->input->post('term');
		$user = $this->input->post('state');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectCabangBsStok($keyword, $user); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
										'tanggal_stock' => $row->tanggal_stock,
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
	function lookupSelectBsStock(){
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->Penjualan_model->selectCabangBsStok($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->intid_cabang,
                                        'value' => $row->strnama_cabang,
										'tanggal_stok' => $row->tanggal_stok,
                                        ''
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
	* calon_manager/form_manager
	*/
	function selectMemberNotGraduate()
	{
		$keyword	= $this->input->post('term');
		$unit 			= $this->input->post('state');
		$data['response'] = 'false';
		$query = $this->Penjualan_model->selectMemberNotGraduate($keyword, $unit); 
        if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=>$row->strkode_dealer,
                                        'value' => $row->strnama_dealer,
                                        'value1' => $row->strkode_upline,
										'value2' => $row->strnama_upline,
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
	// end. lookupUplineCalonNotGraduate
	function addTest()
	{
		$this->form_validation->set_rules('strkode_dealer', 'Kode Member', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strno_ktp', 'No KTP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strnama_dealer', 'Nama Member', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strkode_upline', 'Kode Upline', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
				
		if ($this->form_validation->run() == FALSE)
		{
			
			
			$bank = $this->Penjualan_model->selectBank();
			foreach ($bank as $g)
			{
				$data['intid_bank'][]	 	= $g->intid_bank;
				$data['strnama_bank'][] 	= $g->strnama_bank;
			}
			
			$starterkit = $this->Penjualan_model->selectStarterkit();
			foreach ($starterkit as $g)
			{
				$data['idstarterkit'][]		= $g->intid_barang;
				$data['namastarterkit'][] 	= $g->strnama;
				$data['id_harga'][] 		= $g->intid_harga;
				$data['hargajawa'][] 		= $g->intharga_jawa;
				$data['hargaluarjawa'][] 	= $g->intharga_luarjawa;
				$data['harga_kualalumpur'][] 		= $g->intharga_kualalumpur;
				$data['harga_luarkualalumpur'][] 	= $g->intharga_luarkualalumpur;
			}
			
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
            $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

            $data['cabang'] = $nm_cabang[0]->strnama_cabang;
            $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
			
			//$kodemax = $this->Penjualan_model->selectmaxkode();
			//$max = substr($kodemax[0]->kodemax, 1,8)+1;
			
			$getmember = $this->Penjualan_model->getNoMemberNew();
			$nilai = $getmember[0]->id;
			$id = $nilai + 1;
			$this->Penjualan_model->getNoMemberUpdate($id);
			
			$data['kode_dealer']= "M".$nilai;			
			$this->load->view('admin_views/penjualan/penjualan123', $data);
			
		
		}
		
	}
	
	function lookupNamaUser()
	{
		$keyword = $this->input->post('term');
        $data['response'] = '0'; 
        $query = $this->Penjualan_model->selectJumlahNama($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
				if($row->total > 0)
				{
					$data['response'] = "Jumlah Nama yang kembar ".$row->total." orang";
				}
				else
				{
					$data['response'] = "Nama diperbolehkan";
				}
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
?>