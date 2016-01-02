<?php
class Jsatuan_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }
//page
	private $tbl = 'jenis_satuan';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		$this->db->limit($limit, $offset);
  		$this->db->order_by('intid_jsatuan','asc');
		return $this->db->get($this->tbl,$limit,$offset);
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
//    function getJsatuan(){
//
//	   $query = $this->db->query("SELECT *  FROM jenis_satuan
//               ORDER BY intid_jsatuan ASC");
//	   return $query->result();
//    }

	function insert($data){
	$data = array(
            'strnama_jsatuan' => $this->input->post('strnama_jsatuan'));
        $this->db->insert('jenis_satuan', $data);
	}

   function delete($idjsatuan){
       $this->db->where('jenis_satuan', $idjsatuan);
       $this->db->delete('jenis_satuan');
    }

    function select($idjsatuan){
       $query = $this->db->query("select * from jenis_satuan where intid_jsatuan = $idjsatuan");
	   return $query->result();
    }

	function update($idjsatuan){
            $data = array(
            'strnama_jsatuan' => $this->input->post('strnama_jsatuan'));
            $this->db->where('intid_jsatuan', $idjsatuan);
            $this->db->update('jenis_satuan',$data);
    }
}
?>
