<?php
class Home extends CI_Controller{

	function  __construct() {
        parent::__construct();
      //  $this->load->model('Home_model');
	
      }

	function index(){

		$this->load->view('admin_views/home/promo');
    }
    function promo()
	{
		$this->load->view('admin_views/home/promo');
	}
    function lgift()
	{
		redirect('kajedugbenjol');
		//$this->load->view('admin_views/home/lgift');
	}
    function boom()
	{
		$this->load->view('admin_views/home/boom');
	}
}

?>
