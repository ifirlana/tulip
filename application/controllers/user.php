<?php
class User extends CI_Controller{
    private $limit = 10;
	function  __construct() {
        parent::__construct();
        $this->load->model('User_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation', 'pagination'));
    }

    function index(){
        $this->load->library('pagination'); //load library pagination
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		$config['base_url'] = site_url('user/index/');
		$config['total_rows'] = $this->User_model->countData();
		$config['per_page'] = $this->limit;
		$config['num_links'] = 2;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset']=$offset;
		$data['jumlah_data']=$this->User_model->countData();
		$data['user']	= $this->User_model->get_list_data($this->limit,$offset);
	//   	$data['user'] = $this->User_model->getUser();
        $this->load->view('admin_views/user/user', $data);
    }

    

	function add()
	{
		$this->form_validation->set_rules('strnama_user', 'Nama User', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_cabang', 'Cabang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intid_privilege', 'Privilege', 'trim|required|xss_clean');
		
		
		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');
				
		if ($this->form_validation->run() == FALSE)
		{
			$cabang = $this->User_model->selectCabang();
			foreach ($cabang as $g)
			{
				$data['id'][]	 	= $g->intid_cabang;
				$data['nama'][] 	= $g->strnama_cabang;
			}
			$privilege = $this->User_model->selectPrivilege();
			foreach ($privilege as $g)
			{
				$data['idpri'][]	 	= $g->intid_privilege;
				$data['privilege'][] 	= $g->strname_privilege;
			}
			$this->load->view('admin_views/user/add', $data);
		
		}else {
			$this->User_model->insert($_POST);
			redirect('user/index');
		}
	}	
		function edit($id)
		{
			if($_POST==NULL)
			{
				$cabang = $this->User_model->selectCabang();
				foreach ($cabang as $g)
				{
					$data['idcabang'][]	 	= $g->intid_cabang;
					$data['namacabang'][] 	= $g->strnama_cabang;
				}
				$privilege = $this->User_model->selectPrivilege();
				foreach ($privilege as $g)
				{
					$data['idpri'][]	 	= $g->intid_privilege;
					$data['privilege'][] 	= $g->strname_privilege;
				}
				$datauser= $this->User_model->select($id);
				foreach ($datauser as $g)
				{
					$data['intid_user']	 		= $g->intid_user;
					$data['strnama_user'] 		= $g->strnama_user;
					$data['strpass_user']	 	= $g->strpass_user;
					$data['strnama_asli'] 		= $g->strnama_asli;
					$data['intid_privilege']	= $g->intid_privilege;
					$data['intid_cabang'] 		= $g->intid_cabang;
				}
				$this->load->view('admin_views/user/edit', $data);
			}else {
				
				$this->User_model->update($id);
				redirect('user/index');
			}
		
		}
	
	function delete($id)
	{
		$this->User_model->delete($id);
		redirect('user/index');
	}
}
?>
