<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Login_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}

	function md5hash($pass, $md5)
	{
		$ins = array(
			'text' => $pass,
			'md5' => $md5
			);
		$insert_query = $this->db->insert_string('_md5hash', $ins);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);
	}
	
	function get_user($username, $password){
		$this->db->flush_cache();
		$this->db->select('system_user.*, cabang.intid_cabang, cabang.strnama_cabang,cabang.is_nota,cabang.is_dp');
		$this->db->from('system_user');
		$this->db->join('cabang', 'cabang.intid_cabang = system_user.intid_cabang');
		$this->db->where('strnama_user', $username);
		$this->db->where('strpass_user', md5($password));
		return $this->db->get();
	}
	function cek_get_user_only($username, $password){
	$query = $this->db->query('select c.strnama_cabang,c.intid_cabang from cabang c inner join system_user su on c.intid_cabang = su.intid_cabang 
		where 
			su.strnama_user = "'.$username.'" and
			su.strpass_user = "'.md5($password).'"');
		$row =	$query->result();
		$i = 0;
		//masukan data dimana cabang yang boleh menggunakan web
		switch($row[0]->strnama_cabang){
			case "Tasikmalaya":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			/*
			case "Semarang":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Gading Serpong":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;		
			case "Meulaboh":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;		
			case "Kelapa Gading":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Samarinda":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Ujung Berung":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			 
			case "Cilegon":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;		
			case "Sumedang":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Serang":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Kopo":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Kemanggisan":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Bandung":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;
				*/			
			case "Admin":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;			
			case "Depok 2":
				//kondisi jika diperbolehkan 
				$i = 1;
				break;	
		}
		
		if($i == 1){
			return 1;
		}else{
			return $i;
		}
	}
	function get_userByToken($token){
		$this->db->flush_cache();
		$this->db->where('token', $token);
		return $this->db->get('users_token');
	}
	
	function get_logged_as($id){
		$this->db->flush_cache();
		$this->db->select('system_user.strnama_asli as nama, system_user.intid_privilege as level');
		$this->db->from('system_user');
		$this->db->where('system_user.intid_user', $id);
		
		$query = $this->db->get();
		
		return $query->row()->nama.' ('.$query->row()->level.')';
	}
	
	function set_token($userid, $token){
		$this->db->flush_cache();
		$this->db->where('intid_user', $userid);
		$this->db->delete('users_token');
		$this->db->flush_cache();
		$this->db->set('intid_user', $userid);
		$this->db->set('token', $token);
		$this->db->insert('users_token');
	}
	function settingwaktuSekarang(){
		date_default_timezone_set('Asia/Jakarta');
				
		$sekarang = new DateTime();
		$menit = $sekarang -> getOffset() / 60;
		 
		$tanda = ($menit < 0 ? -1 : 1);
		$menit = abs($menit);
		$jam = floor($menit / 60);
		$menit -= $jam * 60;
		 
		$offset = sprintf('%+d:%02d', $tanda * $jam, $menit);
		 
		//mysql_connect($server, $username, $password);
		//mysql_select_db($database);
		$this->db->query("SET time_zone = '$offset'"); 
		//mysql_query("SET time_zone = '$offset'");

	}
	
}
