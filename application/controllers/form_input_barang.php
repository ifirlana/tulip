<?php 

class form_input_barang extends CI_Controller{
	function __construct (){
		parent::__construct();
	} 
	function index(){
		$this->load->view("input_barang/input_barang");
	}
	function lookupbarang(){
		echo "lokupbarang";
	}
}