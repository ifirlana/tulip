<?php
	class form_control_registrasi extends CI_Controller
	{
		function   __construct() 
		{
			parent::__construct();
			$this->load->model("control_registrasi_model","mdl_c_reg");
		}

		function index()
		{
			$form	=	array("query"=>"");
			$data	=	array("content"=>"");
			
			$this->mdl_c_reg->active();
			$form['query']	=	$this->mdl_c_reg->query();
			$data['content']	=	$this->load->view("promo/form_registrasi_pengejaran_barang",$form,true);
			//echo $data['content'];
			$this->load->view("template/template",$data);
		}
		
		function view_promo_registrasi()
		{
			$id	=	$this->input->post("id");
		
			$this->mdl_c_reg->where_id($id);
			$this->mdl_c_reg->active();
			$query	=	$this->mdl_reg->query()->result();
			
			$data['.content']	=	$this->load->view($query[0]->view,'',true);
			echo json_encode($data);
		}
	}