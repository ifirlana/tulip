<?php
require_once APPPATH.'controllers/form_control_penjualan.php';

CLASS form_control_tebus EXTENDS form_control_penjualan
{
	
	function  __construct() 
	{
		parent::__construct();
		$this->load->model('control/tebus_model',"tModel");
		$this->load->model('class/control_class_tebus_model',"cModel");
		$this->json_view = array(
			"content" => "",
			);
	}
	
	function load_promo()
	{
		$data['query_promo'] 		= $this->tModel->getPromo();
		$data['query_penjualan']	= $this->tModel->getPromo();
		$this->load->view("template_tebus/form_promo",$data);
	}
}