<?php
	class voucher extends CI_Controller{
	
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
		$this->load->model('voucher_model','voucher_mdl');
		
		}
	function cekKode(){
		$keyword = $this->input->post('keykode');
		$data['response'] = 'false';
		$qry = $this->voucher_mdl->getKey_code($keyword); 
		
		if(! empty($qry)){
			$data['response'] = 'true';
			/* $this->voucher_mdl->updateVoucher($keyword); */
			foreach($qry as $row):
				 $data['isi'] = array( 
                                        'nominal'=>$row->nominal,
                                        'nominal_controll' => $row->nominal_controll,
                                       
                                     );  
			endforeach;
		}
		 if('IS_AJAX')
        {
            echo json_encode($data); 
            
        }
	}
   function nota(){
        
        
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
			
			$jpenjualan = $this->Penjualan_model->selectJPenjualanVoucher();
			
			foreach ($jpenjualan as $g)
			{
				$data['intid_jpenjualan'][]	 	= $g->intid_jpenjualan;
				$data['strnama_jpenjualan'][] 	= $g->strnama_jpenjualan; 
					
			}
			
			$this->load->view('admin_views/penjualan/penjualan_voucher', $data);
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
					//update kodevoucher fahmi
					$kodevoucher = $this->input->post('kodevoucheracc');
					$this->voucher_mdl->updateVoucher($kodevoucher);
					//insert backup kode voucher fahmi
					$strkodedealer=$this->input->post('strkode_dealer');
					$this->voucher_mdl->insertdetailvoucher($kodevoucher,$strkodedealer);
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
	}