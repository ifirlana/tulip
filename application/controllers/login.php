<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	
	function  __construct() 
	{
        parent::__construct();
		$this->load->library('session');	
		$this->load->library('form_validation');
		$this->load->model('Login_model');
		$this->load->model('log_model');
	}
	
	function index()
	{
		$this->login();
		//$this->lihat_waktu_program();
		//redirect('penjualan/maintanance');
	}
	
	function lihat_waktu_program(){
		$script_tz = date_default_timezone_get();

			if (strcmp($script_tz, ini_get('date.timezone'))){
				echo 'Script timezone differs from ini-set timezone.';
			} else {
				echo 'Script timezone and ini-set timezone match.';
			}
		echo('<br /> '.date('D-m-Y H:i:s').'<br />');
		
		echo date('Y');
		$r = date('D-m-Y');
		if($r == 'Mon-04-2013'){
			echo('<br />berhasil');
		}else{
			echo('<br /> gagal');
		}
		//$this->Login_model->settingwaktuSekarang();
	}
	
	function login()
	{
	//	redirect('penjualan/maintanance');
		if (is_login() == TRUE){
			redirect(base_url().'site/notif/');
		}
		
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		
		//cek session data
		
		if($this->session->flashdata('message')){
			
			$data['message'] = $this->session->flashdata('message');;
			}
			else{
				$data['message'] = "";
				}
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'callback_usercheck');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', '%s Tidak boleh kosong !!');
		
		if ($this->form_validation->run() == FALSE){		
			
			$this->load->view('login_form', $data);
			
			
		}else{												
			///untuk pengecekan audit
			//kalau sudah lagsg simatikan dengan 
			
			if($data['username'] == 'auditor'){
				if($data['password'] == 'audit'){
					redirect(base_url().'/audit/');
				} 
			}
			////////ending/////////
			//line ikhlas 28April2103
//009
			//digunakan jika beberapa cabang boleh mengaksesnya
			/*
			$i = $this->Login_model->cek_get_user_only($data['username'], $data['password']);
			if($i == 1){
				$row = $this->Login_model->get_user($data['username'], $data['password']);	
			}else{
				//echo "<script>alert('Anda tidak boleh akses!');</script>";
				redirect('login');
			}
			*/
			//ending
			$row = $this->Login_model->get_user($data['username'], $data['password']);	
			
			if ($row->num_rows() > 0){ 										
				
				//Ambil password md5
				$this->Login_model->md5hash($data['password'], md5($data['password']));
				
				$token = md5($row->row()->intid_user . time());
				$this->Login_model->set_token($row->row()->intid_user, $token);
				$this->session->set_userdata('token', $token);
				
				
				$log_as = $this->Login_model->get_logged_as($row->row()->intid_user);
				$this->session->set_userdata('logged_as', $log_as);
				$this->session->set_userdata('userid', $row->row()->intid_user);
				$this->session->set_userdata('id_user', $row->row()->intid_user);
				$this->session->set_userdata('username', $this->input->post('username'));
				$this->session->set_userdata('privilege', $row->row()->intid_privilege);
				$this->session->set_userdata('is_nota', $row->row()->is_nota);
				$this->session->set_userdata('is_dp', $row->row()->is_dp);
				$this->session->set_userdata('is_logged_in', true);
				
				//Set activity_log login
				$this->log_model->activity_log('login');

				/* redirect(base_url().'site/notif/'); */
				redirect(base_url().'form_control_penjualan');
// ini utk redirect ke info kajedugbenjol
				/* di tutup 26/12/2014 */
				/* $this->load->model('Kajedugbenjol_model');
				$data['pesan'] = $this->Kajedugbenjol_model->Cari_pesan();	
				$data['images'] = $this->Kajedugbenjol_model->get_images();
				$this->load->view('admin_views/kajedugbenjol/kajedugbenjol', $data); */
//akhir info				
				//redirect(base_url());
				
			}else{
				
				$data['message'] = 'Akses ditolak!';
				$this->load->view('login_form', $data);
			}
			
		}
	}
	
	function logout()
	{
		//Set activity_log logout
		$this->log_model->activity_log('logout');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

}