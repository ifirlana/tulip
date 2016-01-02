<?php
class Dealer_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    //page
	private $tbl = 'member';

   function insert($data){
	$data = array(
            'intid_cabang' => $this->input->post('intid_cabang'),
            'strnama_dealer' => $this->input->post('strnama_dealer'),
            'strno_ktp' => $this->input->post('strno_ktp'),
            'strnama_upline' => $this->input->post('strnama_upline'),
            'intid_unit' => $this->input->post('intid_unit'),
            'stralamat' => $this->input->post('stralamat'),
            'strtlp' => $this->input->post('strtlp'),
            'strtmp_lahir' => $this->input->post('strtmp_lahir'),
            'stragama' => $this->input->post('stragama'),
            'intid_bank' => $this->input->post('intid_bank'),
            'intno_rekening' => $this->input->post('intno_rekening'),
            'intmanager' => $this->input->post('intmanager'),

            );
        $this->db->insert('member', $data);
	}

   function selectCabang(){

	   $query = $this->db->query("select * from cabang order by intid_cabang asc");
	   return $query->result();
    }


//    function selectUnit(){
//
//	   $query = $this->db->query("select * from unit order by intid_unit asc");
//	   return $query->result();
//    }
    function selectBank(){

	   $query = $this->db->query("select * from bank order by intid_bank asc");
	   return $query->result();
    }
//    function selectUpline(){
//
//	   $query = $this->db->query("select * from member order by strkode_dealer asc");
//	   return $query->result();
//    }
//    function selectManager(){
//
//	   $query = $this->db->query("select * from member where intlevel_dealer=1 ");
//	   return $query->result();
//    }

    function delete($id){
       $this->db->where('intid_dealer', $id);
       $this->db->delete('member');
    }


//    function select($id)
//	{
//	return $this->db->get_where($this->tbl, array('intid_dealer'=>$id))->row();
//	}

function select($intid_dealer){
       $query = $this->db->query("select member.*, unit.* ,cabang.*
               from member, unit, cabang
               where member.intid_unit = unit.intid_unit
               AND member.intid_cabang = cabang.intid_cabang
               AND member.intid_dealer= $intid_dealer");
	   return $query->result();
    }
 function selectUnit($keyword){
        $query = $this->db->query("select intid_unit, upper(strnama_unit) strnama_unit from unit where strnama_unit like '$keyword%'");
        return $query->result();
	}
    function selectDetail($id){
//       $query = $this->db->query("SELECT a.*, b.strnama_cabang, c.strnama_unit , d.strnama_bank
//                                    FROM member a
//                                    LEFT JOIN cabang b
//                                    ON a.intid_cabang = b.intid_cabang
//                                    LEFT JOIN unit c
//                                    ON a.intid_unit=c.intid_unit
//                                    LEFT JOIN bank d
//                                    ON a.intid_bank = d.intid_bank
//                                    And a.intid_dealer = '$id'");
       $query = $this->db->query("SELECT DISTINCT a.*, b.strnama_cabang, c.strnama_unit
       FROM member a
       JOIN cabang b
       ON a.intid_cabang = b.intid_cabang
       JOIN unit c
       ON a.intid_unit=c.intid_unit
                                    And a.intid_dealer = '$id'");
	   return $query->result();
    }

	function update($id){
            $data = array(
            'intid_cabang' => $this->input->post('intid_cabang'),
            'strnama_dealer' => $this->input->post('strnama_dealer'),
            'strno_ktp' => $this->input->post('strno_ktp'),
            'strnama_upline' => $this->input->post('strnama_upline'),
            'intid_unit' => $this->input->post('intid_unit'),
            'stralamat' => $this->input->post('stralamat'),
            'strtlp' => $this->input->post('strtlp'),
            'strtmp_lahir' => $this->input->post('strtmp_lahir'),
            'stragama' => $this->input->post('stragama'),
            'intid_bank' => $this->input->post('intid_bank'),
            'intno_rekening' => $this->input->post('intno_rekening'),
            'intmanager' => $this->input->post('intmanager')

            );
            $this->db->where('intid_dealer', $id);
            $this->db->update('member',$data);
    }

         //test az
        function Cari_dealer($limit,$offset,$dealer)
	{
	    //$q = $this->db->query("select * from member where strnama_dealer like '%$dealer%' LIMIT $offset,$limit");
	    $q = $this->db->query("SELECT DISTINCT a.*,b.strnama_unit
                                   FROM member a
                                   JOIN unit b ON a.intid_unit = b.intid_unit where strnama_dealer like '%$dealer%' LIMIT $offset,$limit");
	    return $q;
	}
       
	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}

//end of test

}
?>
