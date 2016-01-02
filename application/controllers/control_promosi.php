<?php
	class control_promosi extends CI_Controller
	{
	
		/**
		* created 2015 01 21 ifirlana@gmail.com
		* DESC  
		* digunakan untuk default pemanggilan layout.
		* semua aturan disesuaikan, kecuali perubahan yang diluar logika function ini
		* modified 2015 02 04 ifirlana@gmail.com
		* diganti method get e post
		*/
		public function promo_default()
		{
			$form['count'] 											=	$this->input->post("count");
			$form['statusBarang'] 								=	$this->input->post("statusBarang");
			$form['data']['intno_nota']	 					=	$this->input->post("intno_nota");
				//penambahan rules untuk keyup
				if($this->input->post("keyup") != null)
				{
					$form['data']['keyup'] 						=	$this->input->post("keyup");
				}
				$form['data']['count'] 							=	$this->input->post("count");
				$form['data']['intid_barang'] 				=	$this->input->post("intid_barang");
				$form['data']['intid_jpenjualan']			=	$this->input->post("intid_jpenjualan");
				$form['data']['nameBarang']					=	$this->input->post("nameBarang");
				$form['data']['intid_harga']					=	$this->input->post("intid_harga");
				
				$form['data']['isiPromo']						=	$this->input->post("isiPromo");
				$form['data']['idPromo']						=	$this->input->post("idPromo");
				$form['data']['idPenj']							=	$this->input->post("idPenj");
				$form['data']['isiPenjualan']					=	$this->input->post("isiPenjualan");
				$form['data']['intid_jbarang']					=	$this->input->post("intid_jbarang");
				$form['data']['class_intqty']					=	$form['statusBarang'];
				if($form['statusBarang'] == "free")
				{
					$form['data']['intpv']						=	0;
					$form['data']['intharga']					=	0;
					$form['data']['intomset10']				=	0;
					$form['data']['intomset15']				=	0;
					$form['data']['intomset20']				=	0;
						/* $form['data']['intkomisi10']				=	$this->input->get("intomset10") * 0.1;
					$form['data']['intkomisi15']				=	$this->input->get("intomset15") * 0.15;
					$form['data']['intkomisi20']				=	$this->input->get("intomset20") * 0.2; */
					$form['data']['intharga']					=	0;
					$form['data']['diskon']						=	1;
				}else
				{
					$form['data']['intpv']						=	$this->input->post("intpv");
					$form['data']['inttotal_omset']			=	$this->input->post("intomset");
					$form['data']['intomset10']				=	$this->input->post("intomset10");
					$form['data']['intomset15']				=	$this->input->post("intomset15");
					$form['data']['intomset20']				=	$this->input->post("intomset20");
					/* $form['data']['intkomisi10']				=	$this->input->get("intomset10") * 0.1;
					$form['data']['intkomisi15']				=	$this->input->get("intomset15") * 0.15;
					$form['data']['intkomisi20']				=	$this->input->get("intomset20") * 0.2; */
					$form['data']['intharga']					=	$this->input->post("intharga");
					$form['data']['diskon']						=	$this->input->post("diskon");
				}
			$data['formBarang'] 		= $this->load->view("template/form_hitung_barang",$form,true);
			echo json_encode($data);
		}
	// end.
		/**
		* created 2015 01 21 ifirlana@gmail.com
		* DESC  
		* digunakan untuk default pemanggilan layout destiny.
		* semua aturan disesuaikan, kecuali perubahan yang diluar logika function ini
		*/
		public function promo_kondisi()
		{
			$form['count'] 					=	$this->input->get_post("count");
			$form['statusBarang'] 					=	$this->input->get_post("statusBarang");
			$form['data']['intno_nota'] 					=	$this->input->get_post("intno_nota");
			//penambahan rules untuk keyup
			if($this->input->get("keyup") != null)
			{
				$form['data']['keyup'] 					=	$this->input->get_post("keyup");
			}
			$form['data']['count'] 					=	$this->input->get_post("count");
			$form['data']['intid_barang'] 		=	$this->input->get_post("intid_barang");
			$form['data']['intid_jpenjualan']	=	$this->input->get_post("intid_jpenjualan");
			$form['data']['nameBarang']		=	$this->input->get_post("nameBarang");
			$form['data']['intid_harga']			=	$this->input->get_post("intid_harga");
			
			$form['data']['isiPromo']				=	$this->input->get_post("isiPromo");
			$form['data']['idPromo']				=	$this->input->get_post("idPromo");
			$form['data']['idPenj']				=	$this->input->get_post("idPenj");
			$form['data']['isiPenjualan']		=	$this->input->get_post("isiPenjualan");
			$form['data']['intid_jbarang']					=	$this->input->get_post("intid_jbarang");
			$form['data']['class_intqty']			=	$form['statusBarang'];
			
				$form['data']['intpv']					=	$this->input->get_post("intpv");
				$form['data']['intharga']				=	$this->input->get_post("intharga");
				$form['data']['intomset10']				=	$this->input->get_post("intomset10");
				$form['data']['intomset15']				=	$this->input->get_post("intomset15");
				$form['data']['intomset20']				=	$this->input->get_post("intomset20");
				$form['data']['intharga']				=	$this->input->get_post("intharga");
				$form['data']['diskon']				=	$this->input->get_post("diskon");
				
			$data['formBarang'] 		= $this->load->view("template/form_hitung_barang",$form,true);
			echo json_encode($data);
		}
	// end.
	}