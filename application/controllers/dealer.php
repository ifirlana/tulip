<?php
class Dealer extends CI_Controller{

        private $limit=10;
	function  __construct() {
        parent::__construct();
        $this->load->model('Dealer_model');
        $this->load->model('Unit_model');
	$this->load->helper(array('form', 'url'));
	$this->load->library(array('form_validation','pagination'));
    }

    function index($offset='') {

        if ($this->session->userdata('is_logged_in') == TRUE) {
             $this->load->view('admin_views/dealer/index');
        }
        else {
            redirect('login');
        }

    }
	 function dealerpromo(){
    	$this->load->view('admin_views/dealer/dealerconf');
    }
	function pengejaran(){
    	$this->load->view('admin_views/dealer/tampil_pengejaran');
    }
    function dealerpromoupdate(){
    	$this->load->model('penjualan_model');
    	$id = $this->input->post('id');
        $rull = $this->input->post('rull');
        $valid = $this->input->post('valid');
        $this->penjualan_model->updateDealerStat($id,$rull,$valid);
    }
	
	function cabangakses(){
    	$this->load->view('admin_views/dealer/cabangconf');
    }
    function cabangaksesupdate(){
    	$this->load->model('penjualan_model');
    	$id = $this->input->post('id');
        $rull = $this->input->post('rull');
        $valid = $this->input->post('valid');
        $this->penjualan_model->updateCabangStat($id,$rull,$valid);
    }

    function home(){

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
	        $this->session->set_userdata('pencarian_dealer', $data['nama']);
	    }
	    else
	    {
	        $data['nama'] = $this->session->userdata('pencarian_dealer');
	    }
	    $data['nama_dealer'] = $this->Dealer_model->Cari_dealer($batas,$offset,$data['nama']);
	    $tot_hal = $this->Dealer_model->tot_hal('member','strnama_dealer',$data['nama']);

	    $config['base_url'] = base_url() . 'dealer/home/';
	        $config['total_rows'] = $tot_hal->num_rows();
	        $config['per_page'] = $batas;
	        $config['uri_segment'] = 3;
	        $config['full_tag_open'] = '<div id="pagination">';
                $config['full_tag_close'] = '</div>';
	        $this->pagination->initialize($config);
	    $data["paginator"] =$this->pagination->create_links();

	    $this->load->view('admin_views/dealer/dealer',$data);
           
    }

//test

    function detail($id){
		$profile = $this->Dealer_model->selectDetail($id);

			foreach($profile as $m)
			{
				$data['strnama_dealer']		= $m->strnama_dealer;
				$data['stralamat']		= $m->stralamat;
				$data['strtlp']          	= $m->strtlp ;
				$data['strno_ktp']          	= $m->strno_ktp;
				$data['strtmp_lahir']		= $m->strtmp_lahir;
				$data['stragama']		= $m->stragama;
				$data['strkode_dealer']		= $m->strkode_dealer;
				$data['strnama_upline']		= $m->strnama_upline;
				$data['strkode_upline']		= $m->strkode_upline;
				$data['strnama_unit']		= $m->strnama_unit;
				$data['datetgl_lahir']		= $m->datetgl_lahir;
				//$data['strnama_bank']		= $m->strnama_bank;
				$data['intno_rekening']		= $m->intno_rekening;
				$data['strnama_cabang']		= $m->strnama_cabang;

			}
		//$data['privilege'] = $this->privilege;
		$this->load->view('admin_views/dealer/detail', $data);
	}

 //end test
    function edit($intid_dealer)
		{
			if($_POST==NULL)
			{
//				$cabang = $this->Dealer_model->selectCabang();
//				foreach ($cabang as $g)
//				{
//					$data['idcab'][] 	= $g->intid_cabang;
//					$data['namacab'][] 	= $g->strnama_cabang;
//				}
//				$upline = $this->Dealer_model->selectUpline();
//				foreach ($upline as $g)
//				{
//					$data['idup'][]         = $g->intid_dealer;
//					$data['namaup'][] 	= $g->strnama_upline;
//				}
//                                $unit = $this->Dealer_model->selectUnit();
//				foreach ($unit as $g)
//				{
//					$data['idun'][]         = $g->intid_unit;
//					$data['namaun'][] 	= $g->strnama_unit;
//				}
//                                $manager = $this->Dealer_model->selectManager();
//				foreach ($manager as $g)
//				{
//					$data['idm'][]         = $g->intmanager;
//					$data['namam'][] 	= $g->strnama_dealer;
//				}
//                                $bank = $this->Dealer_model->selectBank();
//				foreach ($bank as $g)
//				{
//					$data['idb'][]         = $g->intid_bank;
//					$data['namab'][] 	= $g->strnama_bank;
//				}
				$datauser= $this->Dealer_model->select($intid_dealer);
				foreach ($datauser as $g)
				{
					$data['intid_dealer'] 		= $g->intid_dealer;
					$data['strkode_dealer'] 	= $g->strkode_dealer;
					$data['intid_cabang'] 		= $g->intid_cabang;
					$data['strnama_dealer']		= $g->strnama_dealer;
					$data['strno_ktp']	 	= $g->strno_ktp;
					$data['strkode_upline']		= $g->strkode_upline;
					$data['strnama_upline']		= $g->strnama_upline;
					//$data['strnama_unit']           = $g->strnama_unit;
					$data['intid_unit']             = $g->intid_unit;
					$data['stralamat']              = $g->stralamat;
					$data['strtlp']                = $g->strtlp;
					$data['strtmp_lahir']           = $g->strtmp_lahir;
					$data['datetgl_lahir']          = $g->datetgl_lahir;
					$data['stragama']               = $g->stragama;
					$data['intid_bank']           = $g->intid_bank;
					//$data['strnama_bank']           = $g->strnama_bank;
					$data['intno_rekening']         = $g->intno_rekening;
					//$data['intmanager']             = $g->intmanager;

				}
				$this->load->view('admin_views/dealer/edit', $data);
			}else {
				$this->Dealer_model->update($id);
				redirect('dealer/index');
			}

		}
 function lookupUnit(){
	$keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->Dealer_model->selectUnit($keyword);
        if( ! empty($query) )
        {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=>$row->intid_unit,
                                        'value' => $row->strnama_unit,
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
	function delete($id)
	{
		$this->Dealer_model->delete($id);
		redirect('dealer/index');
	}

         
}
?>
