<?php
class Barang extends CI_Controller{

    private $limit = 10;
	function  __construct() {
    	parent::__construct();
    	$this->load->model('Barang_model');
		$this->load->model('Laporan_model');
		$this->load->model('gathering_model','gth');
		$this->load->model('Penjualan_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation', 'pagination'));
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
	        $this->session->set_userdata('pencarian_barang', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_barang');
	    }
	    $data['nama_barang'] = $this->Barang_model->Cari_barang($batas,$offset,$data['nama']);
	    $tot_hal = $this->Barang_model->tot_hal('barang','strnama',$data['nama']);

	    	$config['base_url'] = base_url() . 'barang/index/';
	        $config['total_rows'] = $tot_hal->num_rows();
	        $config['per_page'] = $batas;
	        $config['uri_segment'] = 3;
	        $config['full_tag_open'] = '<div id="pagination">';
            $config['full_tag_close'] = '</div>';
	        $this->pagination->initialize($config);
	    	$data["paginator"] =$this->pagination->create_links();

	    $this->load->view('admin_views/barang/barang',$data);

    }

     

    function detail($id){
		$profile = $this->Barang_model->selectDetail($id);
        	foreach($profile as $m)
			{
				$data['strnama']			= $m->strnama;
				$data['intharga_jawa']		= $m->intharga_jawa;
				$data['intpv_jawa']			= $m->intpv_jawa;
				$data['intharga_luarjawa']	= $m->intharga_luarjawa;
				$data['intpv_luarjawa']  	= $m->intpv_luarjawa;
				$data['strnama_jbarang']    = $m->strnama_jbarang;
				$data['strnama_jsatuan']    = $m->strnama_jsatuan;
                $data['intum_jawa']	 		= $m->intum_jawa;
				$data['intum_luarjawa']	 	= $m->intum_luarjawa;
				$data['intcicilan_jawa']	= $m->intcicilan_jawa;
				$data['intcicilan_luarjawa']= $m->intcicilan_luarjawa;
                $data['qty']           	    = $m->intqty;
            }
                         
		$this->load->view('admin_views/barang/detail', $data);
	}

	function tambahBarang() {
		$this->load->view('admin_views/barang/tambahBarang');
	}
	
	function cekstock(){
		$week = $this->Laporan_model->selectWeek();
		foreach ($week as $g)
		{
			$data['id'][]	 	= $g->id;
			$data['intid_week'][] 	= $g->intid_week;
		}
		
		$data['tahun'] = $this->gth->selecttahun();
		$this->load->view('admin_views/barang/cekstock',$data);
	}

	function add()
	{
		$this->form_validation->set_rules('strnama', 'Nama Barang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_jsatuan', 'Jenis Satuan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_jbarang', 'Jenis Barang', 'trim|required|xss_clean');
       
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{
			$jbarang = $this->Barang_model->selectJbarang();
			foreach ($jbarang as $g)
			{
				$data['idjb'][]	 	= $g->intid_jbarang;
				$data['namajb'][] 	= $g->strnama_jbarang;
			}
			$jsatuan = $this->Barang_model->selectJsatuan();
			foreach ($jsatuan as $g)
			{
				$data['idjs'][]	 	= $g->intid_jsatuan;
				$data['namajs'][] 	= $g->strnama_jsatuan;
			}
			$this->load->view('admin_views/barang/add', $data);

		}else {
			$this->Barang_model->insert($_POST);
			
			redirect('barang/index');
		}
	}
		function edit($intid_barang)
		{
			if($_POST==NULL)
			{
			$jbarang = $this->Barang_model->selectJbarang();
			foreach ($jbarang as $g)
			{
				$data['idjb'][]	 	= $g->intid_jbarang;
				$data['namajb'][] 	= $g->strnama_jbarang;
			}
			$jsatuan = $this->Barang_model->selectJsatuan();
			foreach ($jsatuan as $g)
			{
				$data['idjs'][]	 	= $g->intid_jsatuan;
				$data['namajs'][] 	= $g->strnama_jsatuan;
			}
				$databarang = $this->Barang_model->select($intid_barang);
				foreach ($databarang as $g)
				{
					$data['intid_barang']	 	= $g->intid_barang;
					$data['intid_jbarang'] 		= $g->intid_jbarang;
					$data['intharga_jawa']	 	= $g->intharga_jawa;
					$data['intpv_jawa']	 	= $g->intpv_jawa;
					$data['intharga_luarjawa']	= $g->intharga_luarjawa;
					$data['intpv_luarjawa']         = $g->intpv_luarjawa;
					$data['intum_jawa']	 	= $g->intum_jawa;
					$data['intum_luarjawa']	 	= $g->intum_luarjawa;
					$data['intcicilan_jawa']	 	= $g->intcicilan_jawa;
					$data['intcicilan_luarjawa']	 	= $g->intcicilan_luarjawa;
					
					$data['strnama'] 		= $g->strnama;
					$data['intid_jsatuan']  	= $g->intid_jsatuan;
                    //$data['intqty']  	= $g->intqty;
					
				}
				$this->load->view('admin_views/barang/edit', $data);
			}else {

				$this->Barang_model->update($intid_barang);
				redirect('barang/index');
			}

		}

	function delete($intid_barang)
	{
		$this->Barang_model->delete($intid_barang);
		redirect('barang/index');
	}

    function baranghadiah(){

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
	        $this->session->set_userdata('pencarian_barang', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_barang');
	    }
	    $data['nama_barang'] = $this->Barang_model->Cari_baranghadiah($batas,$offset,$data['nama']);
	    $tot_hal = $this->Barang_model->tot_hal('barang_hadiah','strnama',$data['nama']);

	    	$config['base_url'] = base_url() . 'barang/baranghadiah/';
	        $config['total_rows'] = $tot_hal->num_rows();
	        $config['per_page'] = $batas;
	        $config['uri_segment'] = 3;
	        $config['full_tag_open'] = '<div id="pagination">';
            $config['full_tag_close'] = '</div>';
	        $this->pagination->initialize($config);
	    	$data["paginator"] =$this->pagination->create_links();

	    $this->load->view('admin_views/barang/baranghadiah',$data);

    }
	
	function addhadiah()
	{
		$this->form_validation->set_rules('strnama', 'Nama Barang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_jsatuan', 'Jenis Satuan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_jbarang', 'Jenis Barang', 'trim|required|xss_clean');
       
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{
			$jbarang = $this->Barang_model->selectJbarang();
			foreach ($jbarang as $g)
			{
				$data['idjb'][]	 	= $g->intid_jbarang;
				$data['namajb'][] 	= $g->strnama_jbarang;
			}
			$jsatuan = $this->Barang_model->selectJsatuan();
			foreach ($jsatuan as $g)
			{
				$data['idjs'][]	 	= $g->intid_jsatuan;
				$data['namajs'][] 	= $g->strnama_jsatuan;
			}
			$this->load->view('admin_views/barang/addhadiah', $data);

		}else {
			$this->Barang_model->inserthadiah($_POST);
			
			redirect('barang/baranghadiah');
		}
	}
		function edithadiah($intid_barang_hadiah)
		{
			if($_POST==NULL)
			{
			$jbarang = $this->Barang_model->selectJbarang();
			foreach ($jbarang as $g)
			{
				$data['idjb'][]	 	= $g->intid_jbarang;
				$data['namajb'][] 	= $g->strnama_jbarang;
			}
			$jsatuan = $this->Barang_model->selectJsatuan();
			foreach ($jsatuan as $g)
			{
				$data['idjs'][]	 	= $g->intid_jsatuan;
				$data['namajs'][] 	= $g->strnama_jsatuan;
			}
				$databarang = $this->Barang_model->selecthadiah($intid_barang_hadiah);
				foreach ($databarang as $g)
				{
					$data['intid_barang']	 	= $g->intid_barang_hadiah;
					$data['intid_jbarang'] 		= $g->intid_jbarang;
					$data['strnama'] 		= $g->strnama;
					$data['intid_jsatuan']  	= $g->intid_jsatuan;
                    
					
				}
				$this->load->view('admin_views/barang/edithadiah', $data);
			}else {

				$this->Barang_model->updatehadiah($intid_barang_hadiah);
				redirect('barang/baranghadiah');
			}

		}

	function deletehadiah($intid_barang_hadiah)
	{
		$this->Barang_model->deletehadiah($intid_barang_hadiah);
		redirect('barang/baranghadiah');
	}
	
	function lihatjenis(){
		$jbarang = $this->Barang_model->selectJbarang();
			foreach ($jbarang as $g)
			{
				$data['idjb'][]	 	= $g->intid_jbarang;
				$data['namajb'][] 	= $g->strnama_jbarang;
			}
			$jsatuan = $this->Barang_model->selectJsatuan();
			foreach ($jsatuan as $g)
			{
				$data['idjs'][]	 	= $g->intid_jsatuan;
				$data['namajs'][] 	= $g->strnama_jsatuan;
			}
		
		$this->load->view('admin_views/barang/tambahBarang',$data);
	}

}
?>
