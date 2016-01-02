<?php
class Omset extends CI_Controller{

    private $limit = 10;
	function  __construct() {
        parent::__construct();
        $this->load->model('Omset_model');
	$this->load->helper(array('form', 'url'));
	$this->load->library(array('form_validation', 'pagination'));
    }

    function index($offset=''){
         $this->load->library('pagination'); //load library pagination
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		$config['base_url'] = site_url('omset/index/');
		$config['total_rows'] = $this->Omset_model->countData();
		$config['per_page'] = $this->limit;
		$config['num_links'] = 2;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset']=$offset;
		$data['jumlah_data']=$this->Omset_model->countData();
		$data['omset']	= $this->Omset_model->get_list_data($this->limit,$offset);

	//$data['omset'] = $this->Omset_model->getOmset();
        $this->load->view('admin_views/omset/omset', $data);
    }
	
	 function lookup(){
	$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Omset_model->selectDealer($keyword);
        if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=>$row->intid_dealer,
                                        'value' => $row->strnama_dealer,
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
	function add()
	{
		$this->form_validation->set_rules('intid_dealer', 'Nama Dealer', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intomset', 'Total', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

		if ($this->form_validation->run() == FALSE)
		{
			 /*$dealer = $this->Lg_model->selectDealer();
			foreach ($dealer as $g)
			{
				$data['idd'][]          = $g->intid_dealer;
				$data['namad'][] 	= $g->strnama_dealer;
			}*/
			$this->load->view('admin_views/omset/add', $data);

		}else {
			$this->Omset_model->insert($_POST);
			redirect('omset/index');
		}
	}
		function edit($idomset)
		{
			if($_POST==NULL)
			{
				$dealer = $this->Omset_model->selectDealer();
				foreach ($dealer as $g)
				{
					$data['id'][]	 	= $g->intid_dealer;
					$data['nama'][] 	= $g->strnama_dealer;
				}

				$dataomset= $this->Omset_model->select($idomset);
				foreach ($dataomset as $g)
				{
					$data['intid_omset'] 		= $g->intid_omset;
					$data['intid_dealer'] 		= $g->intid_dealer;
					$data['intomset']	 	= $g->intomset;


				}
				$this->load->view('admin_views/omset/edit', $data);
			}else {
				$this->Omset_model->update($idomset);
				redirect('omset/index');
			}

		}

	function delete($id)
	{
		$this->Omset_model->delete($id);
		redirect('omset/index');
	}

       

}
?>
