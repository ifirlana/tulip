<?php
class Cabang_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

     //test az
        function Cari_cabang($limit,$offset,$strnama_cabang)
	{
	    $q = $this->db->query("SELECT a. * , b.strwilayah
            FROM cabang a, wilayah b
            WHERE a.intid_wilayah = b.intid_wilayah
            AND a.strnama_cabang LIKE '%$strnama_cabang%' LIMIT $offset,$limit");
	    return $q;

           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
   //page

      function insert($data){
	$data = array(
            'intid_wilayah' => $this->input->post('intid_wilayah'),
            'intkode_cabang' => $this->input->post('intkode_cabang'),
            'jenis_cabang' => $this->input->post('jenis_cabang'),
            'strnama_cabang' => $this->input->post('strnama_cabang'),
            'strkepala_cabang' => $this->input->post('strkepala_cabang'),
            'stradm_cabang' => $this->input->post('stradm_cabang'),
            'stralamat' => $this->input->post('stralamat'),
            'strtelepon' => $this->input->post('strtelepon'),
            'strket' => $this->input->post('strket')
            );
        $this->db->insert('cabang', $data);
	}

    
    function selectWilayah(){

	   $query = $this->db->query("select * from wilayah order by intid_wilayah asc");
	   return $query->result();
    }

	function delete($id){
       $this->db->where('intid_cabang', $id);
       $this->db->delete('cabang');
    }

	function select($id){
       $query = $this->db->query("select *, upper(strnama_cabang) strnama_cabang, intid_wilayah from cabang where intid_cabang= $id");
	   return $query->result();
    }
	function selectCab(){
       $query = $this->db->query("select * from cabang order by strnama_cabang ASC");
	   return $query->result();
    }
//test
    function selectDetail($id){
       $query = $this->db->query("SELECT a.*, b.strwilayah
               FROM cabang a, wilayah b
               where a.intid_wilayah =b.intid_wilayah and
               a.intid_cabang= '$id'");
	   return $query->result();
    }
 //end test
	function update($id){
        $data = array(	//tambahan
            'intid_wilayah' => $this->input->post('intid_wilayah'),
            'intkode_cabang' => $this->input->post('intkode_cabang'),
            'jenis_cabang' => $this->input->post('jenis_cabang'),
            'strnama_cabang' => $this->input->post('strnama_cabang'),
            'strkepala_cabang' => $this->input->post('strkepala_cabang'),
            'stradm_cabang' => $this->input->post('stradm_cabang'),
            'stralamat' => $this->input->post('stralamat'),
            'strtelepon' => $this->input->post('strtelepon'),
            'strket' => $this->input->post('strket')
            ); //akhir tambahan
        $this->db->where('intid_cabang', $id);
		$this->db->update('cabang', $data);   //tambahn , $data
	}
	
	  function selectCabang($keyword){
        $query = $this->db->query("select intid_cabang, upper(strnama_cabang) strnama_cabang from cabang where strnama_cabang like '$keyword%'");
        return $query->result();
	}
	  function selectCabang2($keyword){
        $query = $this->db->query("select intid_cabang, upper(strnama_cabang) strnama_cabang from cabang where strnama_cabang like '$keyword%'");
        return $query->result();
	}
	
	function cabang_persen($intid_cabang)
	{
		$select = "select * from cabang_persen where intid_cabang  = $intid_cabang";
		return $this->db->query($select); 
	}
}
?>