<?php
class User_model extends CI_Model{
    
	function   __construct() {
        parent::__construct();
    }
//page
	private $tbl = 'system_user';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		  if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, b.strnama_cabang, c.strname_privilege
               FROM system_user a, cabang b, system_privilege c
               where a.intid_cabang=b.intid_cabang
               and a.intid_privilege = c.intid_privilege
               ORDER BY intid_user ASC LIMIT $offset,$limit");
        return $query->result();
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
    function getUser(){
       
	   $query = $this->db->query("SELECT a.*, b.strnama_cabang, c.strname_privilege 
               FROM system_user a, cabang b, system_privilege c
               where a.intid_cabang=b.intid_cabang
               and a.intid_privilege = c.intid_privilege
               ORDER BY intid_user ASC");
	   return $query->result();
    }
	
	function insert($data){
	$data = array(
            'strnama_user' => $this->input->post('strnama_user'),
            'strpass_user' => md5($this->input->post('strpass_user')),
            'strnama_asli' => $this->input->post('strnama_asli'),
            'intid_privilege' => $this->input->post('intid_privilege'),
            'intid_cabang' => $this->input->post('intid_cabang'), 
			'intid_cabang2' => $this->input->post('intid_cabang2'),
			'intid_cabang3' => $this->input->post('intid_cabang3'),
			'intid_cabang4' => $this->input->post('intid_cabang4'),
			'intid_cabang5' => $this->input->post('intid_cabang5'),
			'intid_cabang6' => $this->input->post('intid_cabang6'),
			'intid_cabang7' => $this->input->post('intid_cabang7'),
			'intid_cabang8' => $this->input->post('intid_cabang8'),
			'intid_cabang9' => $this->input->post('intid_cabang9'),
			'intid_cabang10' => $this->input->post('intid_cabang10'),
            );
        $this->db->insert('system_user', $data);
	}

    function selectCabang(){
       
	   $query = $this->db->query("select * from cabang order by intid_cabang asc");
	   return $query->result();
    }
	
	function selectPrivilege(){
       
	   $query = $this->db->query("select * from system_privilege order by intid_privilege asc");
	   return $query->result();
    }
	
	function delete($id){
       $this->db->where('intid_user', $id);
       $this->db->delete('system_user');
    }
	
	function select($id){
       $query = $this->db->query("select * from system_user where intid_user = $id");
	   return $query->result();
    }

    function getCabang($username){
       $query = $this->db->query("select a.*, b.intkode_cabang, b.intid_wilayah, b.strnama_cabang,b.is_nota,b.is_scanner from system_user a, cabang b where a.intid_cabang = b.intid_cabang and (a.strnama_user = '$username' or a.strnama_asli='$username')");
	   return $query->result();
    }
    
	function getCabangTable($username){
       $query = $this->db->query("select b.* from cabang b where b.strnama_cabang like '$username'");
	   return $query->result();
    }
	function update($id){
        $data = array(	//tambahan
            'strnama_user' => $this->input->post('strnama_user'),
            'strpass_user' => md5($this->input->post('strpass_user')),
            'strnama_asli' => $this->input->post('strnama_asli'),
            'intid_privilege' => $this->input->post('intid_privilege'),
            'intid_cabang' => $this->input->post('intid_cabang')
            ); //akhir tambahan
        $this->db->where('intid_user', $id);
		$this->db->update('system_user', $data);   //tambahn , $data
	}
	
	function selectUserLogin($intid_dealer){
		
		return $this->db->query("select * from user_login where id_dealer = '$intid_dealer'");
		}
}
?>
