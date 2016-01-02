<?php
class Lg_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }
//page
	private $tbl = 'lg';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		 if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, b.inttotal, c.strnama_dealer, d.intomset
                                    FROM lg a, tipe_lg b, member c, omset d
                                    WHERE a.intid_tipelg=b.intid_tipelg
                                    AND a.intid_dealer= c.intid_dealer
                                    AND a.intid_omset= d.intid_omset
                                    ORDER BY intid_lg ASC LIMIT $offset,$limit");
		return $query->result();
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
    

	function insert($data){
	$data = array(
            'intid_tipelg' => $this->input->post('intid_tipelg'),
            'intid_dealer' => $this->input->post('intid_dealer'),
            'intid_omset' => $this->input->post('intid_omset')
            );
        $this->db->insert('lg', $data);
	}

    function selectTlg(){

	   $query = $this->db->query("select * from tipe_lg order by intid_tipelg asc");
	   return $query->result();
    }


   function selectDealer($keyword){
        $query = $this->db->query("select intid_dealer, upper(strnama_dealer) strnama_dealer from member where strnama_dealer like '$keyword%'");
        return $query->result();
	}
    function selectOmset(){

	   $query = $this->db->query("select * from omset order by intid_omset asc");
	   return $query->result();
    }

	function delete($id){
       $this->db->where('intid_lg', $id);
       $this->db->delete('lg');
    }

	function select($id){
       $query = $this->db->query("select * from lg where intid_lg = $id");
	   return $query->result();
    }

	function update($id){
        $data = array(	//tambahan
            'intid_tipelg' => $this->input->post('intid_tipelg'),
            'intid_dealer' => $this->input->post('intid_dealer'),
            'intid_omset' => $this->input->post('intid_omset')
            ); //akhir tambahan
        $this->db->where('intid_lg', $id);
		$this->db->update('lg', $data);   //tambahn , $data
	}
 
}
?>
