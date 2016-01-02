<?php
class response_ajax extends CI_Controller{

    function  __construct() {
        parent::__construct();
        $this->load->model('Omset_model','mdl_omset');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation', 'pagination'));
    }
	
	function index(){
		$key	=	$this->input->get("jsonp");
		
		$data['username']	=	$this->input->get("username");
		$data['password']	=	$this->input->get("password");
		
		$this->load->view("response_ajax/header");
		$this->load->view("response_ajax/sidebar");
		
		$data['query']	=	$this->mdl_omset->getSelect();
		$this->load->view("response_ajax/test",$data);
		
		//$content	.=	$this->load->view("response_ajax/test",$data);
		//$data_encode[]['message']	=	$content;
		//echo $content
		//echo $data_encode['message'];
		//echo json_encode($data_encode);
		}
	}
?>