<?php
class Omset_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }
//page
	private $tbl = 'omset';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		 if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, b.strnama_dealer
               FROM omset a, member b
               Where a.intid_dealer=b.intid_dealer
               ORDER BY intid_omset ASC LIMIT $offset,$limit");
		return $query->result();
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
    function getOmset(){

	   $query = $this->db->query("SELECT a.*, b.strnama_dealer 
               FROM omset a, member b
               Where a.intid_dealer=b.intid_dealer
               ORDER BY intid_omset ASC");
	   return $query->result();
    }

    function insert($data){
	$data = array(
            'intid_dealer' => $this->input->post('intid_dealer'),
            'intomset' => $this->input->post('intomset'));
        $this->db->insert('omset', $data);
	}

   /* function selectDealer(){

	   $query = $this->db->query("select * from member order by intid_dealer asc");
	   return $query->result();
    }*/
	
	function selectDealer($keyword){
        $query = $this->db->query("select intid_dealer, upper(strnama_dealer) strnama_dealer from member where strnama_dealer like '$keyword%'");
        return $query->result();
	}
   function delete($idomset){
       $this->db->where('intid_omset', $idomset);
       $this->db->delete('omset');
    }

    function select($idomset){
       $query = $this->db->query("select * from omset where intid_omset = $idomset");
	   return $query->result();
    }

	function update($idomset){
            $data = array(
            'intid_dealer' => $this->input->post('intid_dealer'),
            'intomset' => $this->input->post('intomset'));
            $this->db->where('intid_omset', $idomset);
            $this->db->update('omset',$data);
    }
     //test paging
  function getAllGrid($start,$limit,$sidx,$sord,$where){
//    $this->db->select('intid_unit,strnama_unit'); -->cara 1
//    $this->db->limit($limit);
//    if($where != NULL)$this->db->where($where,NULL,FALSE);
//    $this->db->order_by($sidx,$sord);
//    $query = $this->db->get('unit',$limit,$start);
//
//    return $query->result();
      //cara 2
      $query = $this->db->query("SELECT a.*, b.strnama_dealer
               FROM omset a, member b
               Where a.intid_dealer=b.intid_dealer
              ORDER BY $sidx $sord LIMIT $start , $limit");
      return $query->result();
  }

  function get($intid_omset){
    $query = $this->db->getwhere('omset',array('intid_omset'=>$intid_omset));
    return $query->row_array();
  }
//end of test paging
	function getSelect(){
		$select	=	"select intid_week, year(datetgl) tahun, strnama_jpenjualan, sum(inttotal_omset) inttotal_omset from nota, jenis_penjualan where nota.intid_jpenjualan = jenis_penjualan.intid_jpenjualan and intid_dealer = '110210' group by intid_week, year(datetgl)  order by datetgl";
			
			
		return $this->db->query($select);
		}
}
?>
