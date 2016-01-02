<?php
class Wilayah_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    function getWilayah(){

	   $query = $this->db->query("SELECT *  FROM wilayah
               ORDER BY intid_wilayah ASC");
	   return $query->result();
    }

	function insert($data){
	$data = array(
            'strwilayah' => $this->input->post('strwilayah'));
        $this->db->insert('wilayah', $data);
	}

   function delete($idwilayah){
       $this->db->where('intid_wilayah', $idwilayah);
       $this->db->delete('wilayah');
    }

    function select($idwilayah){
       $query = $this->db->query("select * from wilayah where intid_wilayah = $idwilayah");
	   return $query->result();
    }

	function update($idwilayah){
            $data = array(
            'strwilayah' => $this->input->post('strwilayah'));
            $this->db->where('intid_wilayah', $idwilayah);
            $this->db->update('wilayah',$data);
    }
	
	 function getBaby(){

	   $query = $this->db->query("SELECT a.*, b.strnama_cabang AS cab1, c.strnama_cabang AS cab2
 FROM baby_cabang a, cabang b, cabang c
 WHERE a.intid_cabang=b.intid_cabang
 AND a.intid_cabang2 = c.intid_cabang
 ORDER BY id ASC");
	   return $query->result();
    }

     //test az
        function Cari_baby($limit,$offset,$strnama_cabang)
	{
	    $q = $this->db->query("SELECT a. * , b.strnama_cabang AS cab1, c.strnama_cabang AS cab2
            FROM baby_cabang a, cabang b, cabang c
            WHERE a.intid_cabang=b.intid_cabang
 AND a.intid_cabang2 = c.intid_cabang
			AND b.strnama_cabang LIKE '%$strnama_cabang%' LIMIT $offset,$limit");
	    return $q;

           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}

	 function getBabyManager(){

	   $query = $this->db->query("SELECT unit.strnama_unit , baby_manager.id,
               (SELECT unit.strnama_unit
               FROM unit
               WHERE baby_manager.intid_unitbaby = unit.intid_unit)as baby
               FROM baby_manager, unit
               WHERE baby_manager.intid_unit = unit.intid_unit
               ORDER BY id ASC");
	   return $query->result();
         }
	
	 function getBabyManagerFilter($s){
		
	   $query = $this->db->query("SELECT unit.strnama_unit , baby_manager.id,
                   (SELECT unit.strnama_unit FROM unit WHERE baby_manager.intid_unitbaby = unit.intid_unit)as baby
                   FROM baby_manager, unit
                   WHERE baby_manager.intid_unit = unit.intid_unit
                   and baby_manager.intid_unit = '$s[intid_unit]'
                   ORDER BY id ASC");
	   return $query->result();
    }
	
	function getCabang(){
         $this->db->select('cabang.intid_cabang, cabang.strnama_cabang');
         $this->db->from('cabang');
         return $this->db->get()->result();
     }
	 
	function insert_baby($data){
	$data = array(
            'intid_cabang' => $this->input->post('intid_cabang'),
            'intid_cabang2' => $this->input->post('intid_cabang2')
		);
	
        $this->db->insert('baby_cabang', $data);
	}

      function select2($id2){
       $query = $this->db->query("select * from baby_cabang where id= $id2");
	   return $query->result();
    }
	function update_baby($id2){
	$data = array(
            'intid_cabang' => $this->input->post('intid_cabang'),
            'intid_cabang2' => $this->input->post('intid_cabang2')
		);

         $this->db->where('id', $id2);
            $this->db->update('baby_cabang',$data);
	}
	
	 function delete_baby($id){
       $this->db->where('id', $id);
       $this->db->delete('baby_cabang');
    }
	  function selectUnit($keyword){
        $query = $this->db->query("select intid_unit, upper(strnama_unit) strnama_unit from unit
                where strnama_unit like '$keyword%'");
        return $query->result();
	}
    function selectUnit2($keyword){
        $query = $this->db->query("select intid_unit, upper(strnama_unit) strnama_unit from unit
                where strnama_unit like '$keyword%'");
        return $query->result();
	}
         function insert_babymanager($data){
	$data = array(
            'intid_unit' => $this->input->post('intid_unit'),
            'intid_unitbaby' => $this->input->post('intid_unitbaby')
		    );

        $this->db->insert('baby_manager', $data);
	}

//	 function insert_babymanager($data){
//	$data = array(
//            'intid_unit' => $this->input->post('intid_unitbaby'),
//			'intid_unitbaby' => $this->input->post('intid_unit')
//			);
//
//        $this->db->insert('baby_manager', $data);
//	}
	
	 function delete_babymanager($id){
       $this->db->where('id', $id);
       $this->db->delete('baby_manager');
    }

}
?>
