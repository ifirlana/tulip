<?php
class Unit extends CI_Controller{
    private $limit = 10;
	function  __construct() {
     parent::__construct();
		
	$this->data['css_path'] = base_url().'application/css';
	$this->data['js_path']  = base_url().'application/js';
        $this->load->model('Unit_model');
	$this->load->helper(array('form', 'url'));
	$this->load->library(array('form_validation','pagination'));
      }

	function index($offset=''){
	
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
	        $this->session->set_userdata('pencarian_unit', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_unit');
	    }
	    $data['nama_unit'] = $this->Unit_model->Cari_unit($batas,$offset,$data['nama']);
	    $tot_hal = $this->Unit_model->tot_hal('unit','strnama_unit',$data['nama']);

	    $config['base_url'] = base_url() . 'unit/index/';
	    $config['total_rows'] = $tot_hal->num_rows();
	    $config['per_page'] = $batas;
	    $config['uri_segment'] = 3;
	    $config['full_tag_open'] = '<div id="pagination">';
            $config['full_tag_close'] = '</div>';
	    $this->pagination->initialize($config);
	    $data["pagination"] =$this->pagination->create_links();

	    $this->load->view('admin_views/unit/unit',$data);
    }
	function add()
	{
		$this->form_validation->set_rules('strnama_unit', 'Unit', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		 {
                       $this->load->view('admin_views/unit/add');
		}else{

                        $this->Unit_model->insert($_POST);
			redirect('unit/unit');
                }
	}

      function edit($intid_unit)
		{
			if($_POST==NULL)
			{

				$dataunit = $this->Unit_model->select($intid_unit);
				foreach ($dataunit as $g)
				{
					$data['intid_unit']	 	= $g->intid_unit;
					$data['strnama_unit'] 		= $g->strnama_unit;
				}
				$this->load->view('admin_views/unit/edit', $data);
			}else {
				$this->Unit_model->update($intid_unit);
				redirect('unit/index');
			}

		}


    function delete($intid_unit)
	{
		$this->Unit_model->delete($intid_unit);
		redirect('unit/unit');
	}

}
?>
