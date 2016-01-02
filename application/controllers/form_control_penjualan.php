<?php
	CLASS form_control_penjualan EXTENDS CI_Controller{
		
		private $idNotaCoy = 0;
		function  __construct() 
		{
			parent::__construct();
			$this->load->model('Penjualan_model');
			$this->load->model('user_model');
			$this->load->model('promo_model');
			
		}
		
		function index()
		{			
			//code start here
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
			$week = $this->Penjualan_model->selectWeek();
			$tokenForm = "notaControl";   
			$form_member['setToken'] = $this->logme->generateFormToken($tokenForm);
			$form_member['intno_nota']		=	$this->getno_nota();
			$form_member['intid_cabang']	=	$cabang[0]->intid_cabang;
			$form_member['intid_week']		=	$week[0]->intid_week;
			$form_member['wilayah']		=	$cabang[0]->intid_wilayah;
			$form_member['datetgl']				=	date("Y-m-d");
			$data['title']			= "Penjualan New ver 1.9.9 (BETA)";
			$data['content'] 	= $this->load->view("template/form_member",$form_member,true);
			$data['sidebar'] 	= $this->load->view("admin_views/sidebar_penjualan",$form_member,true);
			$this->load->view("template/main_template",$data);
		}
			
		function controlClass(){
			$jpromo		=	$this->promo_model->getPromoActive();
			$jpenjualan	= $this->promo_model->selectJPenjualan();
			
			foreach($jpromo as $p)
			{
				$data['intid_control_promo'][]	=	$p->intid_control_promo;
				$data['nama_promo'][]			=	$p->nama_promo;
			}
			
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 		= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan; 
					
			}
			$data['content'] = $this->load->view("template/control_input_class",$data,true);
			$this->load->view("template/main_template",$data);
		}
		/**
		* load view form jenis penjualan
		*/
		function form_jenis_penjualan()
		{	
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
			$wilayah = $cabang[0]->intid_wilayah;
			$jpen 					= $this->input->post('intid_jpenjualan');
			$idcbg 					= $this->input->post('idcbg');
			$conpro 				= $this->input->post('intid_control_promo');
			$pengejaranChall	= $this->input->post('pengejaranChall');
			$is_promo				= $this->input->post('promo');
			$is_hut			= $this->input->post('is_hut');
			/*  */
			$jpromo				=	$this->promo_model->getPromoActive($jpen,$idcbg,$wilayah, $is_promo,$is_hut);
			$jpenjualan			= $this->promo_model->selectJPenjualan();
			
			foreach($jpromo as $p)
			{
				$data['intid_control_promo'][]	=	$p->intid_control_promo;
				$data['nama_promo'][]			=	$p->nama_promo;
			}
			
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 		= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan; 
					
			}
			
			$data['pengejaranChall']				=	$pengejaranChall;
			
			//echo $this->load->view("template/form_penjualan",$data,true);
			//echo $this->load->view("template/form_penjualan_20150128",$data,true);
			//echo $this->load->view("template/form_penjualan_20150129",$data,true);
			//echo $this->load->view("template/form_penjualan_20150204",$data,true); //karena ada intid_cabang yang mempengaruhi pemilihan jenis penjualan
			echo $this->load->view("template/form_penjualan",$data,true);
			}
		
		/**
		* load view form jenis penjualan
		*/
		function form_add_Barang(){
			
			$intid_jpenjualan			=	$this->input->post("intid_jpenjualan");
			$intid_control_promo	=	$this->input->post("intid_control_promo");
			
			// check code here
			$data['intid_jpenjualan'] 		= $intid_jpenjualan;
			$data['intid_control_promo']	=	$intid_control_promo;
			
			$data['result']	=	$this->promo_model->selectPromoControl($intid_control_promo,$intid_jpenjualan)->result();
			
			//echo $this->load->view("template/form_addBrg_20150120",$data,true);
			//echo $this->load->view("template/form_addBrg_20150128",$data,true);
			echo $this->load->view($data['result'][0]->view,$data,true);
			}
		
		/**
		* click check promo barang
		*/
		function form_check_promo()
		{
				$form['count'] 					=	$this->input->get("count");
				$form['data']['intno_nota'] 					=	$this->input->get("intno_nota");
				$form['data']['count'] 					=	$this->input->get("count");
				$form['data']['intid_barang'] 		=	$this->input->get("intid_barang");
				$form['data']['intid_jpenjualan']	=	$this->input->get("intid_jpenjualan");
				$form['data']['nameBarang']		=	$this->input->get("nameBarang");
				$form['data']['intpv']					=	$this->input->get("intpv");
				$form['data']['intid_harga']			=	$this->input->get("intid_harga");
				$form['data']['intharga']				=	$this->input->get("intharga");
				$form['data']['intomset10']				=	$this->input->get("intomset10");
				$form['data']['intomset15']				=	$this->input->get("intomset15");
				$form['data']['intomset20']				=	$this->input->get("intomset20");
				/* $form['data']['intkomisi10']				=	$this->input->get("intomset10") * 0.1;
				$form['data']['intkomisi15']				=	$this->input->get("intomset15") * 0.15;
				$form['data']['intkomisi20']				=	$this->input->get("intomset20") * 0.2; */
				$form['data']['intharga']				=	$this->input->get("intharga");
				$form['data']['diskon']				=	$this->input->get("diskon");
				$form['data']['isiPromo']				=	$this->input->get("isiPromo");
				$form['data']['idPromo']				=	$this->input->get("idPromo");
				$form['data']['idPenj']				=	$this->input->get("idPenj");
				$form['data']['isiPenjualan']				=	$this->input->get("isiPenjualan");
			$data['formBarang'] 		= $this->load->view("template/form_hitung_barang",$form,true);
			echo json_encode($data);
		}
		/* 
		* untuk check control promo
		*/
		function controlPromo(){
			$jpen = $this->input->post('intid_jpenjualan');
			$conpro = $this->input->post('intid_control_promo');
			if(!empty($jpen) || $jpen != 0):
			/* untuk mencari promo mana yg aktif sesuai jenis penjualannya*/
			$jpromo		=	$this->promo_model->getPromoActive($jpen);
			endif;
			if(!empty($conpro) || $conpro != 0):
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpenjualan	= $this->promo_model->selectPromoPenjualan($conpro);
			endif;
			$data['response'] = 'false'; 
			if( ! empty($jpromo) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $jpromo as $row )
				{
					$data['message'][] = array( 
											'nama_promo'=>$row->nama_promo,
											'intid_control_promo' => $row->intid_control_promo,
											
										 );  
				}
			}
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $jpenjualan as $row1 )
				{
					$data['message'][] = array( 
											'intid_jpenjualan'=>$row1->intid_jpenjualan,
											'strnama_jpenjualan' => $row1->strnama_jpenjualan,
											
										 );  
				}
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
		}
		function controlPromoCombo(){
		    $prom = $this->input->post('prom');
            $penj = $this->input->post('penj');
            
            /* untuk mencari jenis penjualan berdasarkan promonya */
            $jpenjualan = $this->promo_model->getComboPenjualan($prom);
            
            $data['response'] = 'false'; 
            
            if( ! empty($jpenjualan) )
            {
                $data['response'] = 'true'; 
                $data['message'] = array();
                foreach( $jpenjualan as $rows1 ): 
                $data['message'][] = array(
                    'id_control_combo'=>$rows1->id_control_combo,
                    'id_control_promo'=>$rows1->id_control_promo,
                    'status_pencarian'=>$rows1->status_pencarian,
                    'namaCombo' => $rows1->namaCombo,
                    
                    'stat_bayar' => $rows1->is_bayar,
                    'stat_free' => $rows1->is_free,                     
                );
                endforeach;
            }
            if('IS_AJAX')
            {
                echo json_encode($data); 
                
            }
            else
            {
                echo "";
            }
		}
        function classControllCombo(){
            $prom = $this->input->post('prom');
            $penj = $this->input->post('penj');
             
            /* untuk mencari jenis penjualan berdasarkan promonya */
            $jpenjualan = $this->promo_model->getCombo($prom);
            
            $data['response'] = 'false'; 
            
            if( ! empty($jpenjualan) )
            {
                $data['response'] = 'true'; 
                $data['message'] = array();
                
                $data['message'] = array(
                    'id_control_combo'=>$jpenjualan[0]->id_control_combo,
                    'id_control_promo'=>$jpenjualan[0]->id_control_promo,
                    'status_pencarian'=>$jpenjualan[0]->status_pencarian,
                    'namaCombo' => $jpenjualan[0]->namaCombo,
                    
                    'stat_bayar' => $jpenjualan[0]->is_bayar,
                    'stat_free' => $jpenjualan[0]->is_free,    
                    'id_destiny' => 0,                     
                );
               
            }
            if('IS_AJAX')
            {
                echo json_encode($data); 
                
            }
            else
            {
                echo "";
            }
        }
		function controlPromoJpenjualan(){
		
			$prom 			= $this->input->post('prom');
			$id_cabang	= $this->input->post('id_cabang');
			
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpencarian	= $this->promo_model->selectPromoPencarian($prom);
			
			//$jpenjualan	= $this->promo_model->selectPromoPenjualan($prom);
			$jpenjualan	= $this->promo_model->selectPromoPenjualan_20150205($prom,$id_cabang);
			
			$data['response'] = 'false'; 
			
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				foreach( $jpenjualan as $row1 )
				{
					$data['message'][] = array( 
											'intid_jpenjualan'=>$row1->intid_jpenjualan,
											'strnama_jpenjualan' => $row1->strnama_jpenjualan,
										 );  
				}
			}
			if( ! empty($jpencarian) )
			{
				$data['response'] = 'true'; 
				
					$data['mescari'] = array( 
											'pencarian'=>$jpencarian[0]->pencarian,
											'is_Con_B' => $jpencarian[0]->is_Con_B,
											'is_pengejaran' => $jpencarian[0]->is_pengejaran,
											'is_pengejaranChall' => $jpencarian[0]->is_pengejaranChall,
											'is_pengejaranNG' => $jpencarian[0]->is_pengejaranNG,
										 );  
				
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
		}
		function classControll()
		{
			$prom				= $this->input->post('prom');
			$penj				= $this->input->post('penj');
			$intid_cabang	=	$this->input->post("id_cabang");
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpenjualan	= $this->promo_model->promoClass($prom,$penj);
			
			$data['response'] = 'false'; 
			
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'id_control_class'=>$jpenjualan[0]->id_control_class,
					'id_jpenjualan' => $jpenjualan[0]->id_jpenjualan,
					'id_control_promo' => $jpenjualan[0]->id_control_promo,
					'diskon' => $jpenjualan[0]->diskon,
					'pencarian' => $jpenjualan[0]->pencarian,
					'is_komtam' => $jpenjualan[0]->is_komtam,
					'kom10' => $jpenjualan[0]->kom10,
					'kom15' => $jpenjualan[0]->kom15,
					'kom20' => $jpenjualan[0]->kom20,
					'totomset' => $jpenjualan[0]->totomset,
					'pv' => $jpenjualan[0]->pv,
					'stat_bayar' => $jpenjualan[0]->stat_bayar,
					'stat_free' => $jpenjualan[0]->stat_free,		
					'id_destiny' => $jpenjualan[0]->id_destiny,		
					'lookup_url' => $jpenjualan[0]->lookup_url,		
					'lookup_url_free' => $jpenjualan[0]->lookup_url_free,			
					'is_voucher' => $jpenjualan[0]->is_voucher,					
				);
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
			else
			{
				echo "";
			}
		}
		function classControllBaru()
		{
			$prom				= $this->input->post('prom');
			$penj				= $this->input->post('penj');
			$intid_cabang	=	$this->input->post("id_cabang");
			$id_group_class	=	$this->input->post("id_group_class");
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpenjualan	= $this->promo_model->promoClassBaru($prom,$penj,$id_group_class);
			
			$data['response'] = 'false'; 
			
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'id_control_class'=>$jpenjualan[0]->id_control_class,
					'id_jpenjualan' => $jpenjualan[0]->id_jpenjualan,
					'id_control_promo' => $jpenjualan[0]->id_control_promo,
					'diskon' => $jpenjualan[0]->diskon,
					'pencarian' => $jpenjualan[0]->status_pencarian,
					'is_komtam' => $jpenjualan[0]->is_komtam,
					'kom10' => $jpenjualan[0]->kom10,
					'kom15' => $jpenjualan[0]->kom15,
					'kom20' => $jpenjualan[0]->kom20,
					'totomset' => $jpenjualan[0]->totomset,
					'pv' => $jpenjualan[0]->pv,
					'stat_bayar' => $jpenjualan[0]->stat_bayar,
					'stat_free' => $jpenjualan[0]->stat_free,		
					'id_destiny' => $jpenjualan[0]->id_destiny,		
					'lookup_url' => $jpenjualan[0]->lookup_url,		
					'lookup_url_free' => $jpenjualan[0]->lookup_url_free,			
					'is_voucher' => $jpenjualan[0]->is_voucher,					
				);
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
			else
			{
				echo "";
			}
		}
		function classControllCustom(){
			$prom = $this->input->post('prom');
			$penj = $this->input->post('penj');
			
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpenjualan	= $this->promo_model->promoClassCustom($prom,$penj);
			
			$data['response'] = 'false'; 
			
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'id_control_class'=>$jpenjualan[0]->id_control_class,
					'id_jpenjualan' => $jpenjualan[0]->id_jpenjualan,
					'id_control_promo' => $jpenjualan[0]->id_control_promo,
					'diskon' => $jpenjualan[0]->diskon,
					'kom10' => $jpenjualan[0]->kom10,
					'kom15' => $jpenjualan[0]->kom15,
					'kom20' => $jpenjualan[0]->kom20,
					'totomset' => $jpenjualan[0]->totomset,
					'pv' => $jpenjualan[0]->pv,
					'stat_bayar' => $jpenjualan[0]->stat_bayar,
					'stat_free' => $jpenjualan[0]->stat_free,				
					'id_destiny' => $jpenjualan[0]->id_destiny,					
				);
				/* foreach( $jpenjualan as $row1 )
				{
					$data['message'][] = array( 
											'id_control_class'=>$row1->id_control_class,
											'id_jpenjualan' => $row1->id_jpenjualan,
											'id_control_promo' => $row1->id_control_promo,
											'kom10' => $row1->kom10,
											'kom15' => $row1->kom15,
											'kom20' => $row1->kom20,
											'totomset' => $row1->totomset,
											'pv' => $row1->pv,
											'stat_bayar' => $row1->stat_bayar,
											'stat_free' => $row1->stat_free,
											
										 );  
				} */
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
		}
		
		//@see classControllDestiny
		// desc : mengirim data
		function classControllDestiny()
		{
			$id_destiny = $this->input->post('id_destiny');
			
			/* untuk mencari jenis penjualan berdasarkan promonya */
			$jpenjualan	= $this->promo_model->promoClassDestiny($id_destiny);
			
			$data['response'] = 'false'; 
			
			if( ! empty($jpenjualan) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'id_control_class'=>$jpenjualan[0]->id_control_class,
					'id_jpenjualan' => $jpenjualan[0]->id_jpenjualan,
					'id_control_promo' => $jpenjualan[0]->id_control_promo,
					'diskon' => $jpenjualan[0]->diskon,
					'kom10' => $jpenjualan[0]->kom10,
					'kom15' => $jpenjualan[0]->kom15,
					'kom20' => $jpenjualan[0]->kom20,
					'totomset' => $jpenjualan[0]->totomset,
					'pv' => $jpenjualan[0]->pv,
					'stat_bayar' => $jpenjualan[0]->stat_bayar,
					'stat_free' => $jpenjualan[0]->stat_free,				
					'id_destiny' => $jpenjualan[0]->id_destiny,					
				);
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
		}
		// end classControllDestiny.
		
		/**
		*	@param InsertNota
		*	Semua transaksi kesini GLOBAL TRANSAKSI TRANSACTION
		*	2014 12 16 ifirlana@gmail.com
		*	2015 08 08 ifirlana@gmail.com menambah parameter redirect boolean,return boolean dan mengganti bagian redirect
		*/
		function InsertNota($redirect = true, $return = false)
		{
			//if(){}
			$tokenForm = "notaControl";
			if($this->logme->verifyFormToken($tokenForm)):
			$this->db->trans_begin();
			
			//table nota_tebus_voucher
			$temp_nota_voucher	= $this->input->post("nonotavoucher");
			if(isset($temp_nota_voucher) and !empty($temp_nota_voucher))
			{
				for($i=0;$i < count($temp_nota_voucher) ;$i++)
				{
					$nota_tebus_voucher	= array(
									"code_voucher" => $temp_nota_voucher[$i],
									"intno_nota_lama" => $this->input->post("nota_intno_nota"),
									);
					$this->db->insert("nota_tebus_voucher",$nota_tebus_voucher);
				}
			}
			//table nota
			$nota	=	array(
							"intno_nota" 			=>	$this->input->post("nota_intno_nota"),
							"intid_jpenjualan" 	=>	$this->input->post("nota_intid_jpenjualan"),
							"intid_cabang" 		=>	$this->input->post("intid_cabang"),
							"intid_dealer" 			=>	$this->input->post("intid_dealer"),
							"intid_unit" 				=> 	$this->input->post("id_unit"),
							"datetgl" 					=>	$this->input->post("datetgl"),
							"intid_week" 			=>	$this->input->post("intid_week"),
							"intomset10" 			=>	$this->input->post("nota_inttotal_10"),
							"intomset20" 			=>	$this->input->post("nota_inttotal_20"),
							"inttotal_omset" 		=>	$this->input->post("nota_inttotal_omset"),
							"inttotal_bayar" 		=>	$this->input->post("nota_inttotal_bayar"),
							"intdp" 						=>	$this->input->post("nota_intdp"),
							"intcash" 					=>	$this->input->post("nota_intcash"),
							"intdebit"					=>	$this->input->post("nota_intdebit"),
							"intkkredit" 				=>	$this->input->post("nota_intkkredit"),
							"intsisa" 					=>	$this->input->post("nota_intsisa"),
							"intkomisi10" 			=>	$this->input->post("nota_inttotal_k10"),
							"intkomisi20" 			=>	$this->input->post("nota_inttotal_k20"),
							"intpv" 					=>	$this->input->post("nota_pv"),
							"intvoucher" 			=>	$this->input->post("nota_intvoucher"),
							"is_dp" 					=>	$this->input->post("is_dp"),
							"inttrade_in" 			=>	$this->input->post("nota_inttrade_in"),
							"is_lg" 						=>	$this->input->post("is_lg"),
							"nokk" 					=>	$this->input->post("nokk"),
							"is_asi" 					=>	$this->input->post("is_asi"),
							"intkomisi_asi" 		=>	$this->input->post("intkomisi_asi"),
							"is_arisan" 				=>	$this->input->post("is_arisan"),
							"is_sp"						=>	$this->input->post("is_sp"),
							"intpromo_rekrut" 	=>	$this->input->post("intpromo_rekrut"),
							"halaman" 				=>	$this->input->post("halaman"),
							"intomset15" 			=>	$this->input->post("nota_inttotal_15"),
							"intkomisi15" 			=>	$this->input->post("nota_inttotal_k15"),
							"persen" 			=>	$this->input->post("nota_persen_kOther"),
							"otherKom" 			=>	$this->input->post("nota_inttotal_kOther"),
							"no_kkredit" 			=>	$this->input->post("no_kkredit"),
							);
							
			// table nota_detail				
			$this->db->insert("nota",$nota);
			$id	=	$this->db->insert_id();
			
			$intid_barang		=	$this->input->post("intid_barang");
			$intquantity		=	$this->input->post("intquantity");
			$is_free			=	0;
			$intharga			=	$this->input->post("intharganew");
			$intharganormal		=	$this->input->post("intharga");
			$intpv				=	$this->input->post("intpv");
			$intvoucher			=	$this->input->post("intvoucher");
			$intno_nota			=	$this->input->post("intno_nota");
			$omset10			=	$this->input->post("omset10");
			$omset15			=	$this->input->post("omset15");
			$omset20			=	$this->input->post("omset20");
			$komisi10			=	$this->input->post("komisi10");
			$komisi15			=	$this->input->post("komisi15");
			$komisi20			=	$this->input->post("komisi20");
			$idPromo			=	$this->input->post("idPromo");
			$inttotal_bayar		=	$this->input->post("inttotal_bayar");
			$idPenjualan		=	$this->input->post("idPenjualan");
			$reduced			=	$this->input->post("kotam");
			$is_diskon			=	$this->input->post("is_diskon");
			$intomsets			=	$this->input->post("inttotal_omset");
			$kupon = 0;
			
			$harga_temp = 0;
			for($i=0;$i<count($intid_barang);$i++)
			{
			$nota_detail	=	array(
											"intid_nota"		=>	$id,
											"intid_barang"	=>	$intid_barang[$i],
											"intquantity"		=>	$intquantity[$i],
											"intid_harga"		=> $intid_barang[$i],
											"is_free"			=> 0,
											"intharga"			=>	$intharga[$i],
											"nomor_nota"	=>	$intno_nota[$i],
											"is_hutang"		=> 0,
											"is_diskon"		=> $is_diskon[$i],
											"intnormal"		=> $intharganormal[$i],
											"intpv"				=>	$intpv[$i],
											"intvoucher"		=>	$intvoucher[$i],
											"intomset"	=>	$intomsets[$i],
											"intomset10"	=>	$omset10[$i],
											"intomset15"	=>	$omset15[$i],
											"intomset20"	=>	$omset20[$i],
											"intkomisi"		=> $komisi10[$i] + $komisi15[$i] + $komisi20[$i],
											"inttotal_bayar"			=>	$inttotal_bayar[$i],
											"intid_control_promo"	=>	$idPromo[$i],
											"id_jpenjualan"				=>	$idPenjualan[$i],
											"reduced"				=>	$reduced[$i],
											);
			$this->db->insert("nota_detail",$nota_detail);	
			$harga_temp += $this->cekBrg($intid_barang[$i],$intomsets[$i]);
			}
			/* Start Code */
			$week = $this->input->post("intid_week");
			$id_dealer = $this->input->post("intid_dealer");
			$id_nota = $id;
			$intno_nota = $this->input->post("nota_intno_nota");
			if($week >= 47 and $week <= 52)
			{
				$kupon = floor($harga_temp / 300000);
				for ($i = 0; $i < $kupon ; $i++){
					$this->insKupon($id_dealer,$id_nota,$intno_nota);
				}
			}
			else if($week >= 1 and $week <= 4)
			{
				$kupon = floor($harga_temp / 500000);
				for ($i = 0; $i < $kupon ; $i++){
					$this->insKupon($id_dealer,$id_nota,$intno_nota);
				}
			}
			else if($week >= 5 and $week <= 8)
			{
				$kupon = floor($harga_temp / 800000);
				for ($i = 0; $i < $kupon ; $i++){
					$this->insKupon($id_dealer,$id_nota,$intno_nota);
				}
			}
			else if($week >= 9 and $week <= 13)
			{
				$kupon = floor($harga_temp / 1000000);
				for ($i = 0; $i < $kupon ; $i++){
					$this->insKupon($id_dealer,$id_nota,$intno_nota);
				}
			}
			/* End Of Code  */
			// $this->addVoucherUndangan($id, $intid_barang, $intquantity, $intno_nota, $idPromo,$idPenjualan,$intvoucher); //penambahan voucher
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				redirect('form_control_penjualan/');		
			}
			else
			{
				$this->db->trans_commit();
				/* redirect('laporan/viewNotaid/'.$id);				 */
				if($redirect == true)
				{
					redirect('form_control_penjualan/viewnota/'.$id);				
				}
				
				if($return == true)
				{
					return $id;
				}
			}
			else:
				//redirect('login');
				echo "Gagal Menyimpan  <a href='".base_url()."form_control_penjualan'>Back</a>"; 
				/* $this->session->set_flashdata("messages","<script>document.alert('gagal  menyimpan');</script>");
				redirect("form_control_penjualan");  */
		endif;
		}
		function cekBrg($brg,$omset)
		{
			$cek = $this->db->query("select intid_jbarang from barang where intid_barang = $brg")->result();
			$hasil = $cek[0]->intid_jbarang;
			if($hasil == 2)
			{
				$omset = $omset / 2;
			}
			else if($hasil == 1)
			{
				$omset = $omset;
			}
			else
			{
				$omset = 0;
			}
			return $omset;
		}
		function insKupon($id_dealer,$id_nota,$intno_nota){
			$this->db->trans_begin();
			$insme =  new stdclass();
			$insme->id_user = $id_dealer;
			$insme->intid_nota = $id_nota;
			$insme->nota_number = $intno_nota;
			$insme->date = date("Y-m-d H:i:s");
			$this->db->insert("_coupon",$insme);
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();	
			}
			else
			{
				$this->db->trans_commit();
			}
		}
	//	
	/**
	* @param getno_nota
	* Description : meneksekusi nomor nota yang digunakan cabang
	* return : string() 
	* ifirlana@gmail.com 2014 12 16
	*/
	function getno_nota()
	{
        $cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $week = $this->Penjualan_model->selectWeek();

        $getnota = $this->Penjualan_model->getNoNotaNew();
		$nilai = $getnota[0]->id;
		$id = $nilai + 1;
		$this->Penjualan_model->getNoNotaUpdate($id);

		$kode = $cabang[0]->intid_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $nilai);
        return $kode;

    }
	/* 
	* Function untuk membaca control_batas yang dimana untuk penentuan batasan omset
	*/
	function cariBatas(){
			$totbar				= $this->input->post('omsetbatas');
			$promo				= $this->input->post('idpromo');
			/* Untuk Mencari Batas untuk menentukan diskon */
			$batas	= $this->promo_model->getBatas($totbar,$promo);
			//echo $batas;
			$data['response'] = 'false'; 
			
			if( ! empty($batas) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'diskon'=>$batas[0]->diskon,
					'id_control_promo' => $batas[0]->id_control_promo,
									
				);
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
			else
			{
				echo "";
			}
	}
	/* untuk kontrol batas komisi tambahan versi terbaru */
	function cariBatasNew(){
			$totbar				= $this->input->post('omsetbatas');
			$promo				= $this->input->post('idpromo');
			/* Untuk Mencari Batas untuk menentukan diskon */
			$batas	= $this->promo_model->getBatas($totbar,$promo);
			//echo $batas;
			$data['response'] = 'false'; 
			
			if( ! empty($batas) )
			{
				$data['response'] = 'true'; 
				$data['message'] = array(); 
				$data['message'] = array(
					'diskon'=>$batas[0]->diskon,
					'id_control_promo' => $batas[0]->id_control_promo,
									
				);
			}
			if('IS_AJAX')
			{
				echo json_encode($data); 
				
			}
			else
			{
				echo "";
			}
	}
	function viewnota($id = null,$titlePenjualan = null){
		if($id != '' or !empty($id)):
		$data['intid_nota']	=	$id;
		$data['titlePenjualan'] = $titlePenjualan;
		$qry = $this->promo_model->getpenjualan();
		$paket	=	array();
		$detail	= array();
		$dataNota	=	array();
		$totjum = 0;
		foreach($qry as $rows){
		$qry1 = $this->promo_model->getNotaView($id,$rows->intid_jpenjualan);
			if(!empty($qry1)){
				foreach($qry1 as $rows1){
					$detail[] = array(
					'intid_nota' 					=> $rows1->intid_nota,
					'intno_nota' 					=> $rows1->intno_nota,
					'strnama' 					=> $rows1->strnama,
					'strnama_dealer' 					=> $rows1->strnama_dealer,
					'strnama_unit' 					=> $rows1->strnama_unit,
					'strnama_upline' 					=> $rows1->strnama_upline,
					'strnama_cabang' 					=> $rows1->strnama_cabang,
					'datetgl' 					=> $rows1->datetgl,
					'judul' 						=> $rows1->strnama_jpenjualan,
					'id_jpenjualan' 		=> $rows1->id_jpenjualan,
					'intquantity' 				=> $rows1->intquantity,
					'intharga'	=> $rows1->intharga,
					'inttotal_omset' => $rows1->inttotal_omset,
					'intkomisi15' => $rows1->intkomisi15,
					'intkomisi10' => $rows1->intkomisi10,
					'intkomisi20' => $rows1->intkomisi20,
					'otherKom' => $rows1->otherKom,
					'persen' => $rows1->persen,
					'inttotal_bayar' => $rows1->inttotal_bayar,
					'intdp' => $rows1->intdp,
					'intdebit' => $rows1->intdebit,
					'intcash' => $rows1->intcash,
					'intsisa' => $rows1->intsisa,
					'intkkredit' => $rows1->intkkredit,
					'intpv' => $rows1->intpv,
					'intvoucher' => $rows1->intvoucher,
					'vochernd' => $rows1->vochernd,
					);
				}				
			}
		}
		//masukin judul
		for($i=0;$i<count($detail);$i++)
		{
			$check_judul = false;
			
			for($j =0;$j<count($paket);$j++)
			{
				if($paket[$j]['judul'] == $detail[$i]['judul'])
				{
					$check_judul = true;
				}
			}
			//
			if($check_judul == false)
			{
				$paket[] = array(
					"judul" 					=> $detail[$i]['judul'],
					"strnama"	=> $detail[$i]['strnama'],
					"id_jpenjualan"	=> $detail[$i]['id_jpenjualan'],
					
					);
					
			}
		}
		//
		$keterangan = "";
		/* if(!empty($id) and date("Y-m-d") != "2015-11-30")
		{ */
			$db = $this->db->query("select count(*) total from _coupon where intid_nota = ".$id)->result();
			if($db[0]->total > 0)
			{
				$keterangan .= "Selamat anda mendapatkan ".$db[0]->total." kupon undian.<br />";
				//$keterangan .= "<small>* Kupon dibagikan pada saat gathering dicabang anda terdaftar.<br />** Apabila terjadi perubahan pada nota maka hasil pencapaian kupon anda akan ikut berubah sesuai dengan hasil perubahan yang terjadi.</small>";
			}
		//}
		$data['paket']	=	$paket;
		$data['detail']	=	$detail;
		
		$data['keterangan']	=	$keterangan; 
		$this->load->view("template/cetaknota_template",$data);
		else:
		redirect('penjualan');
	endif;
	}
	function viewnota1($id = null){
		if($id != '' or !empty($id)):
		$qry = $this->promo_model->getpenjualan();
		$paket	=	array();
		$detail	= array();
		$dataNota	=	array();
		$totjum = 0;
		foreach($qry as $rows){
		$qry1 = $this->promo_model->getNotaView($id,$rows->intid_jpenjualan);
			if(!empty($qry1)){
				foreach($qry1 as $rows1){
					$detail[] = array(
					'intno_nota' 					=> $rows1->intno_nota,
					'strnama' 					=> $rows1->strnama,
					'strnama_dealer' 					=> $rows1->strnama_dealer,
					'strnama_unit' 					=> $rows1->strnama_unit,
					'strnama_upline' 					=> $rows1->strnama_upline,
					'strnama_cabang' 					=> $rows1->strnama_cabang,
					'datetgl' 					=> $rows1->datetgl,
					'judul' 						=> $rows1->strnama_jpenjualan,
					'id_jpenjualan' 		=> $rows1->id_jpenjualan,
					'intquantity' 				=> $rows1->intquantity,
					'intharga'	=> $rows1->intharga,
					'inttotal_omset' => $rows1->inttotal_omset,
					'intkomisi15' => $rows1->intkomisi15,
					'intkomisi10' => $rows1->intkomisi10,
					'intkomisi20' => $rows1->intkomisi20,
					'otherKom' => $rows1->otherKom,
					'persen' => $rows1->persen,
					'inttotal_bayar' => $rows1->inttotal_bayar,
					'intdp' => $rows1->intdp,
					'intdebit' => $rows1->intdebit,
					'intcash' => $rows1->intcash,
					'intsisa' => $rows1->intsisa,
					'intkkredit' => $rows1->intkkredit,
					'intpv' => $rows1->intpv,
					'intvoucher' => $rows1->intvoucher,
					'vochernd' => $rows1->vochernd,
					);
				}				
			}
		}
		//masukin judul
		for($i=0;$i<count($detail);$i++)
		{
			$check_judul = false;
			
			for($j =0;$j<count($paket);$j++)
			{
				if($paket[$j]['judul'] == $detail[$i]['judul'])
				{
					$check_judul = true;
				}
			}
			//
			if($check_judul == false)
			{
				$paket[] = array(
					"judul" 					=> $detail[$i]['judul'],
					"strnama"	=> $detail[$i]['strnama'],
					"id_jpenjualan"	=> $detail[$i]['id_jpenjualan'],
					
					);
					
			}
		}
		$data['paket']	=	$paket;
		$data['detail']	=	$detail;
		$this->load->view("template/cetaknota_template1",$data);
		else:
		redirect('penjualan');
	endif;
	}

	function insertPromo17845()
	{
		$id_tebus = $this->input->post("id_tebus");
		$id_notaD = $this->input->post("id_notaD");
		
		$idbaru = $this->InsertNota(false,true);
		
		if($idbaru > 0){				
			for($i=0;$i<count($id_tebus);$i++)
			{
				$insert = array(
					"intid_nota_detail" => $id_tebus[$i],
					"intid_nota_new" 	=> $idbaru,
					"intid_delaer"      => $this->input->post("intid_dealer"),
					"intno_nota_new"	=> $this->input->post("nota_intno_nota"),
					"intid_cabang"		=> $this->input->post("intid_cabang"),
					"intid_nota_old"	=> $id_notaD[$i],
					"halaman"			=> "17845",
					);
				$this->db->insert("nota_tebus",$insert);
			}
		}
		//echo $idbaru;
		redirect('form_control_penjualan/viewnota/'.$idbaru);
	}
	function insertPromoRw()
	{
		$id_tebus = $this->input->post("id_tebus");
		$id_notaOLD = $this->input->post("id_notaOLD");
		/*echo "<pre>";
		print_r($this->input->post());*/
		$idbaru = $this->InsertNota(false,true);
		
		if($idbaru > 0){				
			for($i=0;$i<count($id_tebus);$i++)
			{
				$insert = array(
					"intid_nota_detail" => 0,
					"intid_nota_new" 	=> $idbaru,
					"intid_delaer"      => $this->input->post("intid_dealer"),
					"intno_nota_new"	=> $this->input->post("nota_intno_nota"),
					"intid_cabang"		=> $this->input->post("intid_cabang"),
					"intid_nota_old"	=> $id_notaOLD[$i],
					"halaman"			=> "redwhite",
					);
				$this->db->insert("nota_tebus",$insert);
			}
		}
		//echo $idbaru;
		redirect('form_control_penjualan/viewnota/'.$idbaru);
	}
	function insertPromoTebus()
	{
		$id_tebus = $this->input->post("id_tebus");
		$id_notaOLD = $this->input->post("id_notaOLD");
		//$halaman = $this->input->post("halaman"); //buka ini
		$halaman = "redwhite"; //hapus baris ini
		$idbaru = $this->InsertNota(false,true);
		
		if($idbaru > 0){				
			for($i=0;$i<count($id_tebus);$i++)
			{
				$insert = array(
					"intid_nota_detail" => 0,
					"intid_nota_new" 	=> $idbaru,
					"intid_delaer"      => $this->input->post("intid_dealer"),
					"intno_nota_new"	=> $this->input->post("nota_intno_nota"),
					"intid_cabang"		=> $this->input->post("intid_cabang"),
					"intid_nota_old"	=> $id_notaOLD[$i],
					"halaman"			=> $halaman,
					);
				$this->db->insert("nota_tebus",$insert);
			}
		}
		//echo $idbaru;
		redirect('form_control_penjualan/viewnota/'.$idbaru);
	}

	/**
	*	@see addVoucherUndangan
	*	@param 
	*	$id,
	*	$intid_barang,
	*	$intquantity,
	*	$intno_nota,
	*	$idPromo,
	* 	$idPenjualan,
	*	@log 20150813 ifirlana@gmail.com
	*	@desc fungsi tambahan jika ada voucher ditambahin ke barang
	*/
	private function addVoucherUndangan($id, $intid_barang, $intquantity, $intno_nota, $idPromo,$idPenjualan,$intvoucher)
	{
		for($i=0;$i<count($intid_barang);$i++)
		{
			if($intvoucher[$i] == 50000 or $intvoucher[$i] == 60000)
			{
			$nota_detail	=	array(
										"intid_nota"		=>	$id,
										"intid_barang"		=>	"10989", //voucher
										"intquantity"		=>	$intquantity[$i],
										"intid_harga"		=> 	$intid_barang[$i],
										"is_free"			=> 0,
										"intharga"			=> 0,
										"nomor_nota"		=>	$intno_nota[$i],
										"is_hutang"			=> 0,
										"is_diskon"			=> 1,
										"intnormal"			=>  0,
										"intpv"				=>	0,
										"intvoucher"		=>	0,
										"intomset"			=>	0,
										"intomset10"		=>	0,
										"intomset15"		=>	0,
										"intomset20"		=>	0,
										"intkomisi"			=>  0,
										"inttotal_bayar"		=>	0,
										"intid_control_promo"	=>	$idPromo[$i],
										"id_jpenjualan"			=>	$idPenjualan[$i],
										"reduced"				=>	0,
										);
			$this->db->insert("nota_detail",$nota_detail);	
			}
		}
	}
	/* End function of addVoucherUndangan() */
	
} 
?>