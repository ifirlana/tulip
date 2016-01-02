<?php
class Cabang extends CI_Controller{

    	function  __construct() {
        parent::__construct();
        $this->load->model('Cabang_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation', 'pagination'));
    }

    function index($id=''){

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
	        $this->session->set_userdata('pencarian_cabang', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_cabang');
	    }
	    $data['nama_cabang'] = $this->Cabang_model->Cari_cabang($batas,$offset,$data['nama']);
	    $tot_hal = $this->Cabang_model->tot_hal('cabang','strnama_cabang',$data['nama']);

	    $config['base_url'] = base_url() . 'cabang/index/';
	        $config['total_rows'] = $tot_hal->num_rows();
	        $config['per_page'] = $batas;
	        $config['uri_segment'] = 3;
	        $config['full_tag_open'] = '<div id="pagination">';
                $config['full_tag_close'] = '</div>';
                $this->pagination->initialize($config);
	        $this->pagination->initialize($config);
	    $data["pagination"] =$this->pagination->create_links();

	    $this->load->view('admin_views/cabang/cabang',$data);
    }
   
    function detail($id){
		$profile = $this->Cabang_model->selectDetail($id);

			foreach($profile as $m)
			{
				$data['intkode_cabang']		= $m->intkode_cabang;
				$data['jenis_cabang']		= $m->jenis_cabang;
				$data['strwilayah']		= $m->strwilayah;
				$data['strnama_cabang']		= $m->strnama_cabang;
				$data['strkepala_cabang']	= $m->strkepala_cabang;
				$data['stradm_cabang']  	= $m->stradm_cabang;
				$data['stralamat']        	= $m->stralamat;
				$data['strtelepon']        	= $m->strtelepon;
				$data['strket']          	= $m->strket;
				

			}

		$this->load->view('admin_views/cabang/detail', $data);
	}
        


        function add()
	{
		$this->form_validation->set_rules('intid_wilayah', 'Wilayah', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intkode_cabang', 'KOde Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('jenis_cabang', 'Jenis Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strnama_cabang', 'Nama Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strkepala_cabang', 'Nama Kepala Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('stradm_cabang', 'Nama Administrasi Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('stralamat', 'Alamat', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strtelepon', 'Telepon', 'trim|required|xss_clean');
		$this->form_validation->set_rules('strket', 'Keterangan', 'trim|required|xss_clean');


		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{
			$wilayah = $this->Cabang_model->selectWilayah();
                       foreach ($wilayah as $g)

			{
				$data['idw'][]	 	= $g->intid_wilayah;
				$data['namaw'][] 	= $g->strwilayah;
			}

			$this->load->view('admin_views/cabang/add', $data);

		}else {
			$this->Cabang_model->insert($_POST);
			redirect('cabang/index');
		}
	}
		function edit($id)
		{
			if($_POST==NULL)
			{
			$wilayah = $this->Cabang_model->selectWilayah();
                       foreach ($wilayah as $g)

			{
				$data['idw'][]	 	= $g->intid_wilayah;
				$data['namaw'][] 	= $g->strwilayah;
			}


			$datacab = $this->Cabang_model->select($id);
			foreach ($datacab as $g)
				{
					$data['intid_cabang'] 		= $g->intid_cabang;
					$data['intid_wilayah']		= $g->intid_wilayah;
					$data['jenis_cabang']		= $g->jenis_cabang;
					$data['intkode_cabang']	 	= $g->intkode_cabang;
					$data['strnama_cabang']	 	= $g->strnama_cabang;
					$data['strkepala_cabang']	= $g->strkepala_cabang;
					$data['stradm_cabang']          = $g->stradm_cabang;
					$data['stralamat']              = $g->stralamat;
					$data['strtelepon']             = $g->strtelepon;
					$data['strket']             = $g->strket;

				}
				$this->load->view('admin_views/cabang/edit', $data);
			}else {

				$this->Cabang_model->update($id);
				redirect('cabang/index');
			}

		}

	function delete($id)
	{
		$this->Cabang_model->delete($id);
		redirect('cabang/index');
	}
	


}