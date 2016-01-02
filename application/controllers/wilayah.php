<?php
class Wilayah extends CI_Controller{
    function  __construct() {
        parent::__construct();
        $this->load->model('Wilayah_model');
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
      }

	function index($offset=''){

	$data['wilayah'] = $this->Wilayah_model->getWilayah();

        $this->load->view('admin_views/wilayah/wilayah', $data);
    }

	function add()
	{
		$this->form_validation->set_rules('strwilayah', 'Nama Wilayah', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		 {
                       $this->load->view('admin_views/wilayah/add');
		}else{

                        $this->Wilayah_model->insert($_POST);
			redirect('wilayah/wilayah');
                }
	}

      function edit($intid_wilayah)
		{
			if($_POST==NULL)
			{

				$datawilayah = $this->Wilayah_model->select($intid_wilayah);
				foreach ($datawilayah as $g)
				{
					$data['intid_wilayah']	 	= $g->intid_wilayah;
					$data['strwilayah'] 		= $g->strwilayah;
				}
				$this->load->view('admin_views/wilayah/edit', $data);
			}else {
				$this->Wilayah_model->update($intid_wilayah);
				redirect('wilayah/index');
			}

		}


    function delete($intid_wilayah)
	{
		$this->Wilayah_model->delete($intid_wilayah);
		redirect('wilayah/wilayah');
	}

}
?>
