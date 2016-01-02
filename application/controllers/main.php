<?php
class MAIN extends CI_Controller{
	var $data = array(
			'title'	  => '',
			'content' => '',
			'sidebar' => 'penjualan',
			);
    //untuk penamanaan form
    var $dataform = array(
            ''  =>  '', 
            'id_bayar'  =>  'id_bayar',
            'class_bayar'   => 'class_bayar',
            'id_free'   =>  'id_free',
            'class_free'    => 'class_free',
            'id_button'    => 'addBrg',
            'output_pemilihan_barang' => 'result1',
            'nomor_nota' => 'nomor_nota',
            'id_jenis_penjualan' => 'id_jenis_penjualan',
            'list_barang'    => 'result_hasil',
            'tracker_status'   => 'tracker_009',
            'id_formPembayaran_10persen' => 'id_formPembayaran_10persen',
            'id_formPembayaran_20persen' => 'id_formPembayaran_20persen',
            'id_formPembayaran_totalomset' => 'id_formPembayaran_totalomset',
            'id_formPembayaran_pv' => 'id_formPembayaran_pv',
            'id_formPembayaran_komisi10' => 'id_formPembayaran_komisi10',
            'id_formPembayaran_komisi20' => 'id_formPembayaran_komisi20',
            'id_formPembayaran_totalbayar' => 'id_formPembayaran_totalbayar',
            'id_formPembayaran_cash' => 'id_formPembayaran_cash',
            'id_formPembayaran_debit' => 'id_formPembayaran_debit',
            'id_formPembayaran_kartukredit' => 'id_formPembayaran_kartukredit',
            'id_formPembayaran_sisa' => 'id_formPembayaran_sisa',
            'class_formPembayaran_10persen' => 'class_formPembayaran_10persen',
            'class_formPembayaran_20persen' => 'class_formPembayaran_20persen',
            'class_formPembayaran_totalomset' => 'class_formPembayaran_totalomset',
            'class_formPembayaran_pv' => 'class_formPembayaran_pv',
            'class_formPembayaran_komisi10' => 'class_formPembayaran_komisi10',
            'class_formPembayaran_komisi20' => 'class_formPembayaran_komisi20',
            'class_formPembayaran_totalbayar' => 'class_formPembayaran_totalbayar',
            'class_formPembayaran_cash' => 'class_formPembayaran_cash',
            'class_formPembayaran_debit' => 'class_formPembayaran_debit',
            'class_formPembayaran_kartudebit' => 'class_formPembayaran_kartudebit',
            'class_formPembayaran_sisa' => 'class_formPembayaran_sisa',
            'tracker_free'  => 'tracker_free',
            'tracker_intid'  => 'tracker_intid',
            'id_form_check10' => 'id_form_check10',
            );
     var $count_list=0;
	function  __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
		$this->load->model('User_model');
		$this->load->model('Cabang_model');
		$this->load->model('Cm_model');
		$this->load->model('Penjualan_model');
        $this->load->model('MAIN_MODEL','M');
		$this->load->helper(array('html','form', 'url','jq_plugin'));
		$this->load->library(array('form_validation','pagination'));
        //variabel diset global
	   }
	function index(){
	    $this->show();
    }

    function SAVE_NOTA(){
        $nomor_nota = $this->input->post('nomor_nota');
        $id_jenis_penjualan = $this->input->post('id_jenis_penjualan');
        $intid_cabang = $this->input->post('intid_cabang');
        $id_unit = $this->input->post('id_unit');
        $this->input->post('strkode_dealer');
        $intid_dealer = $this->input->post('intid_dealer');
        $intid_week = $this->input->post('intid_week');
        $id_formPembayaran_10persen = $this->input->post('id_formPembayaran_10persen');
        $id_formPembayaran_20persen = $this->input->post('id_formPembayaran_20persen');
        $id_formPembayaran_totalomset = $this->input->post('id_formPembayaran_totalomset');
        $id_formPembayaran_totalbayar = $this->input->post('id_formPembayaran_totalbayar');
        $cash = $this->input->post('id_formPembayaran_cash');
        $dp = 0;
        $id_formPembayaran_debit = $this->input->post('id_formPembayaran_debit');
        $id_formPembayaran_kartukredit = $this->input->post('id_formPembayaran_kartukredit');
        $id_formPembayaran_sisa = $this->input->post('id_formPembayaran_sisa');
        $id_formPembayaran_komisi10 = $this->input->post('id_formPembayaran_komisi10');
        $id_formPembayaran_komisi20 = $this->input->post('id_formPembayaran_komisi20');
        $id_formPembayaran_pv = $this->input->post('id_formPembayaran_pv');
        $voucher = 0;
        $is_dp = 0;
        $nokk = 0;
        $is_asi = 0;
        $intkomisi_asi = 0;
        $is_arisan = 0;
        $intradein = 0;
        $is_lg = 0;
        $halaman = $this->input->post('halaman');
        $barang = $this->input->post('barang');
        $this->db->trans_start();
       $data = array(
            'intno_nota' => $nomor_nota,
            'intid_jpenjualan' => $id_jenis_penjualan,
            'intid_cabang' => $intid_cabang,
            'intid_dealer' => $intid_dealer,
            'intid_unit'    => $id_unit,
            'datetgl'   => date('Y-m-d'),
            'intid_week' => $intid_week,
            'intomset10' => $id_formPembayaran_10persen,
            'intomset20' => $id_formPembayaran_20persen,
            'inttotal_omset' => $id_formPembayaran_totalomset,
            'inttotal_bayar' => $id_formPembayaran_totalbayar,
            'intdp' => $dp,
            'intcash' => $cash,
            'intdebit' => $id_formPembayaran_debit,
            'intkkredit' => $id_formPembayaran_kartukredit,
            'intsisa' => $id_formPembayaran_sisa,
            'intkomisi10' => $id_formPembayaran_komisi10,
            'intkomisi20' => $id_formPembayaran_komisi20,
            'intpv' => $id_formPembayaran_pv,
            'intvoucher' => $voucher,
            'is_dp' => $is_dp,
            'inttrade_in' => $intradein,
            'is_lg' => $is_lg,
            'nokk' => $nokk,
            'is_asi' => $is_asi,
            'intkomisi_asi' => $intkomisi_asi,
            'is_arisan' => $is_arisan,
            'halaman' => $halaman
            );
        $id = $this->M->insertNOTA($data);
            for($i=1;$i<=sizeof($barang);$i++){
                if(isset($barang[$i]['intid_id'])){
                    if($barang[$i]['intid_harga'] == 0){
                        $is_free = 1;
                    }else{
                        $is_free = 0;
                    }   
                $detail = array(
                                'intid_nota'            => $id,
                                'intid_barang'          => $barang[$i]['intid_id'],
                                'intquantity'           => $barang[$i]['intquantity'],
                                'intid_harga'           => $barang[$i]['intid_id'],
                                'intharga'              => $barang[$i]['intid_harga'],
                                'is_free'               => $is_free,
                                'nomor_nota'            => $barang[$i]['nomor_nota'],
                                );
                 $this->M->insertNOTADETAIL($detail);
                // echo $barang[$i]['intid_id']." | ".$barang[$i]['intquantity']." | ".$barang[$i]['intid_id']." | ".$barang[$i]['intid_harga']." | ".$barang[$i]['nomor_nota']."<br />";
             }
        }
        $this->db->trans_complete();
        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
        redirect('penjualan/cetak_nota');
    }
    function show()
	{
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);
		$week = $this->Penjualan_model->selectWeek();  
        $data['user'] = $cabang[0]->intid_user;
		$data['intid_privilege'] = $cabang[0]->intid_privilege;

        $data['cabang'] = $nm_cabang[0]->strnama_cabang;
		$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['intid_wilayah'] = $nm_cabang[0]->intid_wilayah;
        $data['intid_week'] = $week[0]->intid_week;
        $data['halaman'] = 'spct';
        $this->dataform['cabang'] = $nm_cabang[0]->intid_cabang;
        
		$data['intid_cabang']	= $nm_cabang[0]->intid_cabang;
        $data['datetgl']			= date("Y-m-d");
		
		//table_getno_nota
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $week = $this->Penjualan_model->selectWeek();  
        $getnota = $this->Penjualan_model->getNoNotaNew();
        $nilai = $getnota[0]->id;
        $id = $nilai + 1;
        $this->Penjualan_model->getNoNotaUpdate($id);
        $this->dataform['kode'] = $cabang[0]->intid_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $nilai);
       //end.
	   
		$var = "";
	   //content
	    
        $var .= "<form method='POST' action='".base_url()."MAIN/SAVE_NOTA'/>";
		$var .= $this->load->view("temp/form_member",$data,true);
		$var .= $this->load->view("temp/table_getno_nota",$this->dataform,true);
		$var .= $this->load->view("temp/main_getDataJenisPenjualan",$this->dataform,true);
		$var .= $this->load->view("temp/form_pilih_barang",$data,true);
		$var .= $this->load->view("temp/main_getPembayaran",$this->dataform,true);
		$var .= "</form>";

        $this->data['title'] = "SPECIAL PROMO CABANG ".$data['cabang'];
		$this->data['content'] = $var;
		
		//echo $var;
	    $this->load->view('template/template',$this->data);
		
	}
 }
?>