<?php
class A_risan_model extends CI_Model{
    function  __construct() {
        parent::__construct();
    }

    function getA_risan(){

	   $query = $this->db->query("SELECT a.*, b.strnama,b.intharga_luarjawa, b.intharga_jawa
            FROM arisan a, barang b
            WHERE a.intid_barang=b.intid_barang
            ORDER BY intid_arisan ASC");
	   return $query->result();
    }
    function selectBarang(){
        $query = $this->db->query("select * from barang order by intid_barang asc");
        return $query->result();
    }
	 function selectGroup(){
         $select = 'select *,(select count(*) from arisan where arisan.group = group_cek.group) as total from group_cek order by group_cek.group desc limit 0,1';
            //echo $select."<br />";
            $query = $this->db->query($select);
                return $query->result();
    }
	 function selectGroupall(){
         $select = 'select * from group_cek order by group_cek.group asc';
            //echo $select."<br />";
            $query = $this->db->query($select);
                return $query->result();
    }
	 function insertGroup($data){  
        //$month = strtotime(date($data['batas']),'%m') + 1;
        $data['cont']   =   20;
        //$temp = strtotime(date($data['batas']),'%Y') .'-'. $month.'-'.strtotime(date($data['batas']),'%d');
        $temp = date('Y',strtotime($data['batas'])) .'-'.$data['month'].'-'.date('d',strtotime($data['batas']));
       // Pengecekan group_cek;
        $insert = 'insert into group_cek values("'.$data['group'].'","'.$temp.'","'.$data['cont'].'")';
            //echo $select."<br />";
        $this->db->query($insert);     
    }
	function updateGroup($data){
        $update = 'update group_cek set batas = "'.$data['batas'].'" where group_cek.group = '.$data['group'].'';
        return $this->db->query($update);
    }
}

?>
