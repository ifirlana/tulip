<?php
class Promosi extends CI_Controller{

    private $limit = 10;
	
	function  __construct() {
        parent::__construct();
        $this->load->model('Promosi_model');
        $this->load->model('User_model');
		$this->load->model('Cabang_model');
		$this->load->model('dealer_model');
		$this->load->model('week_model');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','pagination'));
     }

	function index(){

        $page=$this->uri->segment(3);
	    $batas=10;
	    if(!$page):
	    $offset = 0;
	    else:
	    $offset = $page;
	    endif;

	    $data['nama']="";
	    $postkata = $this->input->post('nama');
	    if(!empty($postkata))
	    {
	        $data['nama'] = $this->input->post('nama');
	        $this->session->set_userdata('pencarian_promo10', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_promo10');
	    }
	    $data['nama_promo10'] = $this->Promosi_model->Cari_promo10($batas,$offset,$data['nama']);
	    $tot_hal = $this->Promosi_model->tot_hal('barang','strnama',$data['nama']);

	    $config['base_url'] = base_url() . 'promosi/index/';
	        $config['total_rows'] = $tot_hal->num_rows();
	        $config['per_page'] = $batas;
	        $config['uri_segment'] = 3;
	        $config['full_tag_open'] = '<div id="pagination">';
                $config['full_tag_close'] = '</div>';
                $this->pagination->initialize($config);
	        $this->pagination->initialize($config);
	    $data["pagination"] =$this->pagination->create_links();

	    $this->load->view('admin_views/promosi/promosi',$data);
    }
	
	function add()
	{
		$this->form_validation->set_rules('intid_week_start', 'Minggu Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_week_end', 'Minggu Akhir', 'trim|required|xss_clean');


		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{
			
                $week = $this->Promosi_model->selectWeek();
				foreach ($week as $g)
				{
					$data['idw'][]	        = $g->intid_week;
					$data['ide'][]	        = $g->intid_week;
					
				}
			$this->load->view('admin_views/promosi/add', $data);
                        

		}else {
			$this->Promosi_model->insert($_POST);
			redirect('promosi/promosi');
		}
	}

    function lookupBarang(){
	$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Promosi_model->selectBarang($keyword);
        if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
                                        'value' => $row->strnama,
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
	
    function lookupFree(){
	$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Promosi_model->selectBarangFree($keyword);
        if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=>$row->intid_barang,
                                        'value' => $row->strnama,
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

	function edit($intid_promo)
		{
			if($_POST==NULL)
			{
              $week = $this->Promosi_model->selectWeek();
				foreach ($week as $g)
				{
					$data['idw'][]	        = $g->intid_week;
					$data['ide'][]	        = $g->intid_week;
				}
                $datapromo= $this->Promosi_model->select($intid_promo);
				foreach ($datapromo as $g)
				{
					$data['intid_promo']	 	= $g->intid_promo;
					$data['intid_week_start'] 	= $g->intid_week_start;
					$data['intid_week_end'] 	= $g->intid_week_end;
					$data['intid_barang'] 		= $g->intid_barang;
					$data['intid_barang_free']  = $g->intid_barang_free;
					$data['strnama'] 			= $g->strnama;
					$data['nama']  				= $g->nama;
				}
				$this->load->view('admin_views/promosi/edit', $data);
			}else {
				$this->Promosi_model->update($intid_promo);
				redirect('promosi/index');
			}

		}
	

    function delete($intid_promo)
	{
		$this->Promosi_model->delete($intid_promo);
		redirect('promosi');
	}
  
function promosi2()
	{

        $page=$this->uri->segment(3);
	    $batas=10;
	    if(!$page):
	    $offset = 0;
	    else:
	    $offset = $page;
	    endif;

	    $data['nama']="";
	    $postkata = $this->input->post('nama');
	    if(!empty($postkata))
	    {
	        $data['nama'] = $this->input->post('nama');
	        $this->session->set_userdata('pencarian_promo20', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_promo10');
	    }
	    $data['nama_promo20'] = $this->Promosi_model->Cari_promo20($batas,$offset,$data['nama']);
	    $tot_hal = $this->Promosi_model->tot_hal2('barang','strnama',$data['nama']);

	    $config['base_url'] = base_url() . 'promosi/promosi2/';
	    $config['total_rows'] = $tot_hal->num_rows();
	    $config['per_page'] = $batas;
	    $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
	    $this->pagination->initialize($config);
	    $data["pagination"] =$this->pagination->create_links();

	    $this->load->view('admin_views/promosi/promosi2',$data);
	}
        function add2()
	{
		$this->form_validation->set_rules('intid_week_start', 'Minggu Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_week_end', 'Minggu Akhir', 'trim|required|xss_clean');


		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{

                $week = $this->Promosi_model->selectWeek();
				foreach ($week as $g)
				{
					$data['idw'][]	        = $g->intid_week;
					$data['ide'][]	        = $g->intid_week;
					
				}
			$this->load->view('admin_views/promosi/add2', $data);

		}else {
			$this->Promosi_model->insert2($_POST);
			redirect('promosi/promosi2');
		}
	}

        function edit2($intid_promo)
		{
			if($_POST==NULL)
			{
                         $week = $this->Promosi_model->selectWeek();
				foreach ($week as $g)
				{
					$data['idw'][]	        = $g->intid_week;
					$data['ide'][]	        = $g->intid_week;
				}
                $datapromo2= $this->Promosi_model->select2($intid_promo);
				foreach ($datapromo2 as $g)
				{
					$data['intid_promo']	 	= $g->intid_promo;
					$data['intid_week_start'] 	= $g->intid_week_start;
					$data['intid_week_end'] 	= $g->intid_week_end;
					$data['intid_barang'] 		= $g->intid_barang;
					$data['intid_barang_free']  = $g->intid_barang_free;
					$data['intid_barang_free1'] = $g->intid_barang_free1;
					$data['intid_barang_free2'] = $g->intid_barang_free2;
					$data['strnama']      		= $g->strnama;
					$data['nama'] 				= $g->nama;
					
				}
				$this->load->view('admin_views/promosi/edit2', $data);
			}else {
				$this->Promosi_model->update2($intid_promo);
				redirect('promosi/promosi2');
			}

		}

    function delete2($intid_promo)
	{
		$this->Promosi_model->delete2($intid_promo);
		redirect('promosi/promosi2');
	}
	//promosi starterkit ABO
	/*
	* Tujuan	: untuk mentrack DEALER YANG MEMBELI penjualan starterkit abo.
	* Deskripsi	: Dengan mengambil periode starterkit ABO MAKA MENJADI PATOKAN PENJUALAN.
	*/
	/* function PROMOSI_STARTTERKIT_ABO(){
	
	/*
		$intid_cabang = $this->input->post('intid_cabang');
		$intid_week	=	$this->input->post('intid_week');
		$tahun	=	$this->input->post('tahun');
		
		$dataTemp['intid_week']	=	$intid_week;
		$dataTemp['intid_cabang']	=	$intid_cabang;
		//untuk starterkitnya dibuat manual
		$dataTemp['intid_starterkit']	=	6135;
		$dataTemp['tahun']	=	$tahun;
		
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		
		$var = "";
		$var_temp = "";
		//dibuat manual
			//echo $intid_week.", ".$intid_cabang.", <br />";
				//echo $intid_cabang. " : ".$intid_week."" ;
			if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
			
				$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO_all($dataTemp);
				}
				else{//kalau cabang lain yang masuk
				
					$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO($dataTemp);
					}
			if($query->num_rows() > 0){
			///
				if($intid_week == 16){
					$a = $intid_week + 1;
					$b = $a + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					$intid_week3 = $b;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
						$dataTemp3['intid_dealer']	=	$row->intid_dealer;
						$dataTemp3['intid_week']	=	$b;
						$query_3	=	$this->Promosi_model->get_omset_week($dataTemp3);
						$total_omset3 = $query_3->result();
						
										
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset  + $total_omset3[0]->inttotal_omset ;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 800000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week3."&d=".$row->intid_dealer."'>".$total_omset3[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>Omset week ".$b."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
				}elseif($intid_week == 17){
					$a = $intid_week + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
								
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset ;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 800000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
				}elseif($intid_week == 18){
				
					foreach($query->result() as $row){
						
						if($row->is_acc_abo == 0){
						
							$cabang = $this->User_model->getCabang($this->session->userdata('username'));
							$nm_cabang = $this->Cabang_model->select($intid_cabang);
						
							$dataTemp1['intid_dealer']	=	$row->intid_dealer;
							$dataTemp1['intid_week']	=	$intid_week;
							$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
							$total_omset1 = $query_1->result();
							
							$var_temp .= "<tr>";
							if($cabang[0]->intid_cabang == 1){
							
							$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
								}
							$var_temp .="
									<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
									<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>
									<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>";
							$total = $total_omset1[0]->inttotal_omset;
							$var_temp .= "<td style='padding:5px;'>".$total."</td>";
							
							//muncul kalau admin
							if($cabang[0]->intid_cabang == 1){
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 800000 && $nm_cabang[0]->intid_wilayah == 1){
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}else{
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
								$var_temp .="</tr>";
								}
							}
						}
					
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Cabang</th>";}
					$var .=	"	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";

					}
					//echo $var;
			}else{
				$var .= "<p>Tidak ada Penjualan Starterkit ABO di week-".$intid_week.". Untuk kembali silahkan klik <a href='".base_url()."Laporan'>disni</a></p>";
			}
		$data['view'] = $var;
		$this->load->view('halaman/PROMOSI',$data);
		*
		/*
	$intid_cabang = $this->input->post('intid_cabang');
		$intid_week	=	$this->input->post('intid_week');
		$tahun	=	$this->input->post('tahun');
		
		$dataTemp['intid_week']	=	$intid_week;
		$dataTemp['intid_cabang']	=	$intid_cabang;
		//untuk starterkitnya dibuat manual
		$dataTemp['intid_starterkit']	=	6135;
		$dataTemp['tahun']	=	$tahun;
		
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		
		$var = "";
		$var_temp = "";
		//dibuat manual
			//echo $intid_week.", ".$intid_cabang.", <br />";
				//echo $intid_cabang. " : ".$intid_week."" ;
			if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
			
				$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO_all($dataTemp);
				}
				else{//kalau cabang lain yang masuk
				
					$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO($dataTemp);
					}
			if($query->num_rows() > 0){
			///
				if($intid_week == 27){
					$a = $intid_week + 1;
					$b	= $a + 1;
					$c	=	$b + 1;
					$d	=	$c + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					$intid_week3 = $b;
					$intid_week4 = $c;
					$intid_week5 = $d;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
						$dataTemp3['intid_dealer']	=	$row->intid_dealer;
						$dataTemp3['intid_week']	=	$b;
						$query_3	=	$this->Promosi_model->get_omset_week($dataTemp3);
						$total_omset3 = $query_3->result();
						
						$dataTemp4['intid_dealer']	=	$row->intid_dealer;
						$dataTemp4['intid_week']	=	$c;
						$query_4	=	$this->Promosi_model->get_omset_week($dataTemp4);
						$total_omset4 = $query_4->result();
						
						$dataTemp5['intid_dealer']	=	$row->intid_dealer;
						$dataTemp5['intid_week']	=	$d;
						$query_5	=	$this->Promosi_model->get_omset_week($dataTemp5);
						$total_omset5 = $query_5->result();
						
										
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset  + $total_omset3[0]->inttotal_omset+ $total_omset4[0]->inttotal_omset  + $total_omset5[0]->inttotal_omset ;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 900000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset5[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset5[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week3."&d=".$row->intid_dealer."'>".$total_omset3[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week4."&d=".$row->intid_dealer."'>".$total_omset4[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week5."&d=".$row->intid_dealer."'>".$total_omset5[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset5[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>Omset week ".$b."</th>
									<th>Omset week ".$c."</th>
									<th>Omset week ".$d."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
				}else if($intid_week == 28){
					$a = $intid_week + 1;
					$b	= $a + 1;
					$c	=	$b + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					$intid_week3 = $b;
					$intid_week4 = $c;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
						$dataTemp3['intid_dealer']	=	$row->intid_dealer;
						$dataTemp3['intid_week']	=	$b;
						$query_3	=	$this->Promosi_model->get_omset_week($dataTemp3);
						$total_omset3 = $query_3->result();
						
						$dataTemp4['intid_dealer']	=	$row->intid_dealer;
						$dataTemp4['intid_week']	=	$c;
						$query_4	=	$this->Promosi_model->get_omset_week($dataTemp4);
						$total_omset4 = $query_4->result();
								
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset + $total_omset3[0]->inttotal_omset + $total_omset4[0]->inttotal_omset ;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 900000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week3."&d=".$row->intid_dealer."'>".$total_omset3[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week4."&d=".$row->intid_dealer."'>".$total_omset4[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset4[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>Omset week ".$b."</th>
									<th>Omset week ".$c."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
				}else if($intid_week == 29){
					$a = $intid_week + 1;
					$b	= $a + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					$intid_week3 = $b;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
						$dataTemp3['intid_dealer']	=	$row->intid_dealer;
						$dataTemp3['intid_week']	=	$b;
						$query_3	=	$this->Promosi_model->get_omset_week($dataTemp3);
						$total_omset3 = $query_3->result();
						
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset + $total_omset3[0]->inttotal_omset;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 900000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week3."&d=".$row->intid_dealer."'>".$total_omset3[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset3[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>Omset week ".$b	."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
					}else if($intid_week == 30){
					$a = $intid_week + 1;
					
					$intid_week1 = $intid_week;
					$intid_week2 = $a;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$dataTemp2['intid_dealer']	=	$row->intid_dealer;
						$dataTemp2['intid_week']	=	$a;
						$query_2	=	$this->Promosi_model->get_omset_week($dataTemp2);
						$total_omset2 = $query_2->result();
						
						$total = $total_omset1[0]->inttotal_omset + $total_omset2[0]->inttotal_omset;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 900000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
															<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
																<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>
													<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week2."&d=".$row->intid_dealer."'>".$total_omset2[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>
												<td style='padding:5px;'>".$total_omset2[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
					}else if($intid_week == 31){
					
					$intid_week1 = $intid_week;
					
					foreach($query->result() as $row){
					
						$nm_cabang = $this->Cabang_model->select($intid_cabang);
					
						$dataTemp1['intid_dealer']	=	$row->intid_dealer;
						$dataTemp1['intid_week']	=	$intid_week;
						$query_1	=	$this->Promosi_model->get_omset_week($dataTemp1);
						$total_omset1 = $query_1->result();
						
						$total = $total_omset1[0]->inttotal_omset;
									
						//muncul kalau admin
						if($cabang[0]->intid_cabang == 1){
								
								if($row->is_acc_abo == 0){
									
									$var_temp .= "<tr>";
									
									$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
											
									$var_temp .= "
											<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
											<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
									
									//kondisi kalau cabang luar jawa atau didalam jawa
									if($total <= 900000 && $nm_cabang[0]->intid_wilayah == 1){
										
										$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>";
										$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
										$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
										<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
										<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										elseif($total <= 1000000 && $nm_cabang[0]->intid_wilayah == 2){
										
											$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
										
											$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
										}
										else{
											
											$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$intid_week1."&d=".$row->intid_dealer."'>".$total_omset1[0]->inttotal_omset."</a></td>";
											$var_temp .= "<td style='padding:5px;'>".$total."</td>";
											
											$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
											}
										$var_temp .="</tr>";
									}
							}
							else{ //bukan admin
								
								$var_temp .= "<tr>";
								$var_temp .= "
										<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
										<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
								
								$var_temp .= "<td style='padding:5px;'>".$total_omset1[0]->inttotal_omset."</td>";
								$var_temp .= "<td style='padding:5px;'>".$total."</td>";
								$var_temp .="</tr>";
									
								}
						}
					$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>
									<th>Omset week ".$intid_week."</th>
									<th>Omset week ".$a."</th>
									<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
					}
					//echo $var;
			}else{
				$var .= "<p>Tidak ada Penjualan Starterkit ABO di week-".$intid_week.". Untuk kembali silahkan klik <a href='".base_url()."Laporan'>disni</a></p>"; 
			}
		$data['view'] = $var;
		$this->load->view('halaman/PROMOSI',$data);	
	}
	*/
	function promo_stepdown_dealer(){
		$intid_dealer = $this->input->post('intid_dealer');
		
		$var = "";
		$dataTemp['intid_dealer']	=	$intid_dealer;
		$query_3	=	$this->Promosi_model->get_nota_dealer($dataTemp);
		
		$dataTemp['intid_dealer']	=	$intid_dealer;
		$query_4	=	$this->Promosi_model->get_dealer($dataTemp);
		$member	=	$query_4->result();
		
			foreach($query_3->result() as $row){
				$var .= "NO NOTA : ".$row->intno_nota.' . terupdate untuk '.strtoupper($member[0]->strnama_upline)." ".$member[0]->intid_upline." dari  ". strtoupper($member[0]->strnama_dealer)." ".$intid_dealer."<br />";
				$dataTemp2['intid_dealer'] = $member[0]->intid_upline;
				$dataTemp2['intid_nota'] = $row->intid_nota;
				$this->Promosi_model->insert_nota_history_from_nota($dataTemp2);
				$this->Promosi_model->update_nota($dataTemp2);
				//memasukan barang untuk bulan september 
				///$this->Promosi_model->insert_kelengkapanABO($dataTemp2);
			}
			$this->Promosi_model->delete_member($dataTemp);
			$var .= "<br /><a href='".base_url()."laporan/sales/'>BACK</a>";
		$data['view']	= $var;
		$this->load->view('halaman/PROMOSI',$data);
	}
	function go_down($data){
		//end coding
		$select = "select * from member where strkode_upline = '".$data['strkode_dealer']."' ";
		$query = $this->db->query($select);
		if($query->num_rows() > 0 ){
		return 1;
		}
		return 0;
	}
	
	//function untuk stepup dealer
	//added 2014 04 14
	
	function stepup_abo_dealer(){
		
		$intid_week = $this->input->get("w");
		$intid_dealer = $this->input->get("d"); 
		
		$query	=	$this->dealer_model->select($intid_dealer);
		$dateend	=	$this->week_model->selectenddate($intid_week, date('Y'));
		$datesend = $dateend[0]->dateweek_end;
		
		echo "<a href='".base_url()."laporan/sales'>BACK</a>";	
			echo "<table width='100%' border='1' cellspacing='0' cellpadding='5'>";
			foreach($query as $row){
				/*
				echo "Nama Dealer : ".$row->strnama_dealer."<br />";
				echo "Cabang Kelahiran : ".$row->strnama_cabang."<br />";
				echo "Nama Dealer : ".$row->strnama_dealer."<br />";
				echo "Nama Dealer : ".$row->strnama_dealer."<br />";
				*/
				
				echo "<form method='POST' action='".base_url()."promosi/acc_abo'><tr><td colspan='3'><input type='hidden' name='intid_dealer' value='".$intid_dealer."'>&nbsp;</td></tr>";
				echo "<tr><td>Unit</td><td>:</td><td>".$row->strnama_unit."</td></tr>";
				echo "<tr><td>Nama Dealer</td><td>:</td><td>".$row->strnama_dealer."</td></tr>";
				echo "<tr><td>Tanggal</td><td>:</td><td>".$row->datetanggal." menjadi <input type='text' name='datetanggal' value='".$datesend."' /></td></tr>";
				echo "<tr><td>Week</td><td>:</td><td>".$row->intid_week." menjadi <input type='text' name='intid_week' value='".$intid_week."' size='3' /></td></tr>";
				echo "<tr><td>Cabang</td><td>:</td><td>".$row->strnama_cabang."</td></tr>";
				echo "<tr><td colspan='2'>&nbsp;</td><td>";
				echo "<input type='submit' name='submit' value='ACC Menjadi Dealer'>"; 
				echo "</td></tr>";
				echo "<tr><td colspan='3'>&nbsp;</td></tr></form>";
				}
			echo "</table>";
		}
	function acc_abo(){
		
		$intid_week = $this->input->post("intid_week");
		$intid_dealer = $this->input->post("intid_dealer");
		$datetanggal = $this->input->post("datetanggal");
		
		$select	=	"UPDATE member set is_acc_abo = 1, intid_week = ".$intid_week.", datetanggal = '".$datetanggal."' where intid_dealer = ".$intid_dealer."";
		
		$query	=	$this->db->query($select);
		redirect("laporan/sales");
	}
	//promosi starterkit ABO
	/*
	* Tujuan	: untuk mentrack DEALER YANG MEMBELI penjualan starterkit abo.
	* Deskripsi	: Dengan mengambil periode starterkit ABO MAKA MENJADI PATOKAN PENJUALAN.
	*/
	 function PROMOSI_STARTTERKIT_ABO(){
			$this->load->model('abo_model','mdl_abo');
		
		
		$intid_cabang = $this->input->post('intid_cabang');
		$intid_week	=	$this->input->post('intid_week');
		$tahun	=	$this->input->post('tahun');
		
		$query_week	=	$this->mdl_abo->getWeekAbo($intid_week);
		$syarat	=	$query_week->result();
		
		$dataTemp['intid_week']	=	$intid_week;
		$dataTemp['intid_cabang']	=	$intid_cabang;
		//untuk starterkitnya dibuat manual
		$dataTemp['intid_starterkit']	=	6135;
		$dataTemp['tahun']	=	$tahun;
		
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
		$var_temp	=	"";
		$var = "";
		$total=	0;
		
		if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
		
			$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO_all($dataTemp);
			}
			else{//kalau cabang lain yang masuk
			
				$query	=	$this->Promosi_model->get_Promosi_starterkit_ABO($dataTemp);
				}
			
		if($query->num_rows() > 0){
			
			foreach($query->result() as $row){
			$total=	0;
					$var_temp .= "<tr>";
					if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
						
						$var_temp .= "<td>".$row->strnama_cabang."</td>"; // kalau hanya admin.
						}								
					$var_temp .= "
							<td style='padding:5px;'>".strtoupper($row->strnama_dealer)."</td>
							<td style='padding:5px;'>".strtoupper($row->strnama_upline)."</td>";
						
						//hitung total omset syarat
						foreach($query_week->result() as $rok){
						
							$nm_cabang = $this->Cabang_model->select($intid_cabang);
							
							$dataTemp_1['intid_dealer']	=	$row->intid_dealer;
							$dataTemp_1['intid_week']	=	$rok->intid_week;
							$query_1	=	$this->Promosi_model->get_omset_week($dataTemp_1);
							$total_omset_1 = $query_1->result();
							
							$total = $total_omset_1[0]->inttotal_omset + $total;
							if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
						
								if($row->is_acc_abo == 0){
									$var_temp .= "<td style='padding:5px;'><a href='".base_url()."promosi/stepup_abo_dealer/?w=".$rok->intid_week."&d=".$row->intid_dealer."'>".$total_omset_1[0]->inttotal_omset."</a></td>";
									}else{
										$var_temp .= "<td style='padding:5px;'>".$total_omset_1[0]->inttotal_omset."</td>";
										}
								}
								else{
									$var_temp .= "<td style='padding:5px;'>".$total_omset_1[0]->inttotal_omset."</td>";
									}
							}
						$var_temp .= "<td style='padding:5px;'>".$total."</td>";
												
						if($cabang[0]->intid_cabang  == 1){ //kalau admin yang masuk
						//htung omset syarat
							if($total <= $syarat[0]->jawa	&& $nm_cabang[0]->intid_wilayah == 1){
								$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
											<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
											<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
												
								}elseif($total <= $syarat[0]->luar_jawa && $nm_cabang[0]->intid_wilayah == 2){
									
									$var_temp .= "<td style='padding:5px;'><form method='POST' action='".base_url()."PROMOSI/promo_stepdown_dealer'>
									<input type='hidden' name='intid_dealer' value='".$row->intid_dealer."' />
									<input type='submit' name='buttonSubmit' value='step Down' /></form></td>";
									}
									else{
												$var_temp .= "<td style='padding:5px;'><csnter><i>SUCCESS</i></center></td>";
												}
									}else{
												
										}
					$var_temp .= "</tr>";
					}
				}else{
					$var .= "<p>Tidak ada Penjualan Starterkit ABO di week-".$intid_week.". Untuk kembali silahkan klik <a href='".base_url()."Laporan'>disni</a></p>"; 
				}
		$var .= "<p><a href='".base_url()."laporan/sales'>BACK</a></p>";
					$var .= "<h3>WEEK PENCARIAN STARTERKIT ABO: ".$intid_week."</h3>";
					$var .= "<table border= 1 style='padding:5px;width:100%;'>
								<tr style='background:rgb(143,200,0);'>";
								
					if($cabang[0]->intid_cabang == 1){$var .= "<th>Nama Cabang</th>";}
					
					$var .= "	<th>NAMA KONSUMEN</th>
									<th>NAMA UPLINE MEMBER</th>";
					
					foreach($query_week->result() as $rok){
							$var .= "<th>Omset week ".$rok->intid_week."</th>";
							}
					$var .= "	<th>TOTAL</th>";
									if($cabang[0]->intid_cabang == 1){
										$var .= "<th>ACTION</th>";
									}
					$var .=	"</tr>";
					$var .= $var_temp;
					$var .= "</table>";
					
		$data['view'] = $var;
		//echo $data['view'];
		$this->load->view('halaman/PROMOSI',$data);
		}
	//END BUILDING
	
	/**
	* digunakan untuk mendapatkan undangan voucher 
	*/
	function undanganvoucher()
	{
		$form['count'] 					=	$this->input->post("count");
		$form['data']['count'] 					=	$this->input->post("count");
		$form['data']['intqty']	=	$this->input->post("intquantity");
		$form['data']['class_intqty']	=	"undangan_qty";
		$form['data']['intid_barang'] 		=	1202;
		$form['data']['intid_jpenjualan']	=	0;
		$form['data']['nameBarang']		=	"Undangan";
		$form['data']['intpv']					=	0;
		$form['data']['intid_harga']			=	0;
		$form['data']['intharga']				=	0;
		$form['data']['diskon']				=	$this->input->get("diskon");
		$form['data']['intomset10']				=	0;
		$form['data']['intomset15']				=	0;
		$form['data']['intomset20']				=	0;
		$form['data']['intkomisi10']				=	0;
		$form['data']['intkomisi15']				=	0;
		$form['data']['intkomisi20']				=	0;
		$form['data']['intharga']					=	0;
		
		$data['formBarang']	=	$this->load->view("promo/undangan_voucher",$form,true);
		echo json_encode($data);
		
		/* $data = $this->load->view("promo/undangan_voucher",$form,true);
		echo $data; */
	}
}
?>
