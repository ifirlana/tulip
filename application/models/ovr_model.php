<?php
class Ovr_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    //page
	private $tbl = 'member';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		 if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, b.intomset, c.strnama_dealer
                    FROM offriding a, omset b, member c
               where a.intid_omset=b.intid_omset
               and a.intid_dealer= c.intid_dealer ORDER BY intid_or ASC LIMIT $offset,$limit");
		return $query->result();
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
    function getOvr(){

	   $query = $this->db->query("SELECT a.*, b.intomset, c.strnama_dealer
                    FROM offriding a, omset b, member c
               where a.intid_omset=b.intid_omset
               and a.intid_dealer= c.intid_dealer ORDER BY intid_or ASC");
	   return $query->result();
    }

   function insert($data){
       $dealer = $this->input->post('strnama_dealer');
        $i = $this->db->query("select intid_dealer from member where strnama_dealer like '$dealer%'");
        $intid_dealer = $i->result();

        $data = array(
            'intid_omset' => $this->input->post('intid_omset'),
            'intid_dealer' => $intid_dealer[0]->intid_dealer,
            'intor' => $this->input->post('intor')
        );
        $this->db->insert('orr', $data);
	}

   function selectOmset(){

	   $query = $this->db->query("select * from omset order by intid_omset asc");
	   return $query->result();
    }


   /* function selectDealer(){

	   $query = $this->db->query("select * from dealer order by intid_dealer asc");
	   return $query->result();
    }
*/
 function selectDealer($keyword){
        $query = $this->db->query("select intid_dealer, upper(strnama_dealer) strnama_dealer from member where strnama_dealer like '$keyword%'");
        return $query->result();
	}
    function delete($idovr){
       $this->db->where('intid_or', $idovr);
       $this->db->delete('offriding');
    }

    function select($idovr){
       $query = $this->db->query("select * from offriding where intid_or= $idovr");
        return $query->result();
    }

	function update($idovr){
            $data = array(
            'intid_omset' => $this->input->post('intid_omset'),
            'intid_dealer' => $this->input->post('intid_dealer'),
            'intor' => $this->input->post('intor')
        );
            $this->db->where('intid_or', $idovr);
            $this->db->update('offriding',$data);
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
      $query = $this->db->query("SELECT a.*, b.intomset, c.strnama_dealer
                    FROM offriding a, omset b, member c
               where a.intid_omset=b.intid_omset
               and a.intid_dealer= c.intid_dealer
              ORDER BY $sidx $sord LIMIT $start , $limit");
      return $query->result();
  }

  function get($intid_or){
    $query = $this->db->getwhere('offriding',array('intid_or'=>$intid_or));
    return $query->row_array();
  }
//end of test paging

}
?>
