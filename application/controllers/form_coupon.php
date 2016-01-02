<?php

require_once APPPATH.'controllers/form_control_penjualan.php';

CLASS form_coupon EXTENDS form_control_penjualan
{
	function  __construct() 
	{
        parent::__construct();
		$this->load->model('User_model');
        $this->load->model('Week_model');
        $this->load->model('Cabang_model');
        $this->load->model('Penjualan_model');
        $this->load->model('lookup/lookuptebus_model');
        $this->load->model('stock_barang_model','sbm');
		$this->load->model('Barang_model');
		$this->load->model('scan_model','scan_mdl');
		$this->load->model('membership_model','mdl_membership'); // 19 november 2013
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('barang_model');
		$this->load->model('combo_model','combo_mdl');
	
	}
	function index()
	{
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
        $tokenForm = "notaControl";   
		$data['setToken'] = $this->logme->generateFormToken($tokenForm);
        $week 							= $this->Penjualan_model->selectWeek();
		$data['intid_week']		=	$week[0]->intid_week;
				
        $data['cabang'] = $nm_cabang[0]->strnama_cabang;
        $data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['id_wilayah'] = $nm_cabang[0]->intid_wilayah;

		$data['user'] = $this->session->userdata('username');
		 	
 		$this->load->view("admin_views/promo/promocoupon",$data); 
	}
	function checkOmset()
 	{
 		$strkode_dealer = $this->input->post("strkode_dealer");
 		$intid_barang	= "9816,9817,9818,9819,9820,9821,11043"; // fine dining set
 		$datestart		=	"2015-11-27";
 		$dateend			=	"2015-12-31";
 		$jpen 				= 1;
 		$idprom			= 1;
		
		$select = "SELECT
						nota.intno_nota,nota.intid_nota,nota.inttotal_omset,nota.datetgl
					FROM
						member
					LEFT JOIN nota ON nota.intid_dealer = member.intid_dealer
					LEFT JOIN cabang ON cabang.intid_cabang = nota.intid_cabang
					WHERE
						member.strkode_dealer = '".$strkode_dealer."' 
					and nota.inttotal_omset > 0
					and nota.datetgl = curdate()
					and nota.intid_nota not in (select intid_nota_old from nota_tebus where halaman like 'coupon')
					";

		$data['query'] = $this->db->query($select);
		//print_r($data['query']->result());
		$this->load->view("admin_views/promo/table_promocoupon",$data);
 	}
 	function tebuspromo()
 	{
 		$this->load->view("admin_views/promo/tebuspromocoupon"); 
 	} 
	function insertCoupon(){
		
	}
}