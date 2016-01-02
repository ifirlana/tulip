<?php
class Week extends CI_Controller {
    private $limit = 10;
    function  __construct() {
        parent::__construct();
        $this->load->model('Week_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation','pagination'));
    }

    function combonamabln($awal, $akhir, $var, $terpilih) {
        $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei",
                "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember");
        $b='';
        $b.="<select name=$var id=$var>";
        $b.="<option value=''>-All-</option>";
        for ($bln=$awal; $bln<=$akhir; $bln++) {
            if ($bln==$terpilih)
                $b.="<option value=$bln selected>$nama_bln[$bln]</option>";
            else
                $b.="<option value=$bln>$nama_bln[$bln]</option>";
        }
        $b.="</select> ";
        return $b;
    }

    function index($offset='') {

        $this->load->library('pagination'); //load library pagination
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $config['base_url'] = site_url('week/index/');
        $config['total_rows'] = $this->Week_model->countData();
        $config['per_page'] = $this->limit;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']=$offset;
        $data['jumlah_data']=$this->Week_model->countData();
        $data['form_action'] = site_url('week/index');
        if($_POST){
            $data['week']	= $this->Week_model->get_list_data_search($this->limit,$offset, $_POST)->result();
            $terpilih = $this->input->post('bulan');
        }else{
            $data['week']	= $this->Week_model->get_list_data($this->limit,$offset)->result();
            $terpilih = date('m');
        }

        //$data['week'] = $this->Week_model->getWeek();

        $var = "bulan";
        
        $bulan=1;
        $b=12;
        $data['combo_bulan'] = $this->combonamabln($bulan, $b, $var, $terpilih);
        
        $this->load->view('admin_views/week/week', $data);
    }

     
    function add() {
        $this->form_validation->set_rules('dateweek_start', 'Start week', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dateweek_end', 'End week', 'trim|required|xss_clean');

        $this->form_validation->set_message('required', ' %s tidak boleh kosong !!');

        if ($this->form_validation->run() == FALSE) {
            $awal=1;
            $akhir=12;
            $var='bulan';
            $terpilih=date('m');
            $data['nama_bulan'] = $this->combonamabln($awal, $akhir, $var, $terpilih);
            $this->load->view('admin_views/week/add', $data);
        }else {

            $this->Week_model->insert($_POST);
            redirect('week/week');
        }
    }

    
    function edit($intid_week) {
        if($_POST==NULL) {
            $awal=1;
            $akhir=12;
            $var='bulan';
            $terpilih=date('m');
            $dataweek = $this->Week_model->select($intid_week);
            foreach ($dataweek as $g) {
                $data['intid_week']	 	= $g->intid_week;
                $data['intbulan']	 	= $g->intbulan;
                $data['dateweek_start'] 	= $g->dateweek_start;
                $data['dateweek_end'] 		= $g->dateweek_end;
                $data['nama_bulan'] = $this->combonamabln($awal, $akhir, $var, $data['intbulan']);

            }



            $this->load->view('admin_views/week/edit', $data);
        }else {
            $this->Week_model->update($intid_week);
            redirect('week/index');
        }

    }


    function delete($intid_week) {
        $this->Week_model->delete($intid_week);
        redirect('week/week');
    }

}
?>
