<?php
class Starterkit_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    private $tbl = 'starter_kit';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit,$offset,$strnama)
  	{
		 $q = $this->db->query("SELECT a. * , b.strnama, c.strnama as nama
            FROM starter_kit a, barang b, barang c
            WHERE a.intid_barang_starterkit = b.intid_barang
            AND a.intid_barang = c.intid_barang
			AND b.strnama LIKE '%$strnama%' LIMIT $offset,$limit");
	     return $q;
  	}
	
	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
	
	function selectWeek(){

	   $query = $this->db->query("select * from week order by intid_week asc");
	   return $query->result();
    }

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}

    function getStarterkit(){

       $query = $this->db->query("SELECT * FROM STARTER_KIT ORDER BY intid_starterkit ASC");
	   return $query->result();
    }

	function insert($data){
	$data = array(
            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
            'intid_barang_starterkit' => $this->input->post('intid_barang1'),
            'intid_barang' => $this->input->post('intid_barang2')
            );
     $this->db->insert('starter_kit', $data);
	}

   function selectBarang($keyword){
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.* from barang a, harga b where a.intid_barang = b.intid_barang and CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%'");
        return $query->result();
	}

	function selectJbarang(){

	   $query = $this->db->query("select * from jenis_barang order by intid_jbarang asc");
	   return $query->result();
    }

	function delete($idst){
       $this->db->where('intid_starterkit', $idst);
       $this->db->delete('starter_kit');
    }

	function select($idst){
       $query = $this->db->query("select a.*, b.strnama, c.strnama as nama 
		from starter_kit a, barang b, barang c 
		where a.intid_barang_starterkit = b.intid_barang
		and  a.intid_barang = c.intid_barang
		and a.intid_starterkit = $idst");
	   return $query->result();
    }

    function selectDetail($id){
       $query = $this->db->query("SELECT * FROM STARTER_KIT
               where intid_starterkit= '$id'");
	   return $query->result();
    }
 
	function update($idst){
        $data = array(
            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
            'intid_barang_starterkit' => $this->input->post('intid_barang1'),
            'intid_barang' => $this->input->post('intid_barang2')
        );
        $this->db->where('intid_starterkit', $idst);
        $this->db->update('starter_kit',$data);
    }
}
?>
