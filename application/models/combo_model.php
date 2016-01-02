<?php
class combo_model extends CI_Model{
    
	function   __construct() {
        parent::__construct();
    }
	function selectControllPromo(){
	$qry = $this->db->query("select * from control_promo where pencarian='combo' and is_active = 1");
	return $qry->result();
	}
function selectBarang($keyword, $jbarang, $intid_cabang = 0, $combo = 0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $select = "select a.intid_barang, 
        	upper(a.strnama) strnama, 
        	h.* 
        	from 
	        	barang a inner join promocombo h on h.intid_barang = a.intid_barang 
        	where  CURDATE() BETWEEN h.tanggal_awal and h.tanggal_akhir and 
			a.strnama like '$keyword%' 
        			AND (h.intid_cabang = '$intid_cabang' or h.intid_cabang = 0) and (h.combo = '$combo' or h.combo is NULL) group by a.intid_barang";
        $query = $this->db->query($select);
        return $query->result();
        //return $select;
	}
function newselectBarang($keyword, $jbarang, $intid_cabang = 0, $combo = 0, $idcontrolprogram=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $select = "select a.intid_barang, 
        	upper(a.strnama) strnama, 
        	h.* 
        	from 
	        	barang a inner join promocombo h on h.intid_barang = a.intid_barang 
        	where  CURDATE() BETWEEN h.tanggal_awal and h.tanggal_akhir and 
			a.strnama like '$keyword%' 
        			AND (h.intid_cabang = '$intid_cabang' or h.intid_cabang = 0) and (h.combo = '$combo' or h.combo is NULL) and h.id_control_promo = $idcontrolprogram group by a.intid_barang";
        $query = $this->db->query($select);
        return $query->result();
        //return $select;
	}
function selectBarangFree($keyword, $jbarang, $intid_cabang = 0, $combo = 0, $intid_barang = 0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $select = "select a.intid_barang intid_barang_free, 
        	upper(a.strnama) strnama, 
        	h.* 
        	from 
	        	barang a inner join promocombo h on h.intid_barang_free = a.intid_barang 
        	where  CURDATE() BETWEEN h.tanggal_awal and h.tanggal_akhir and a.strnama like '$keyword%' 
        			AND (h.intid_cabang = '$intid_cabang' or h.intid_cabang = 0) and h.combo = '$combo' and h.intid_barang = '$intid_barang' group by a.intid_barang";
        $query = $this->db->query($select);
        return $query->result();
        //return $select;
	}
function selectPromocombo($promo=0){
	$select = "select * from control_program where kode like 'comb%' and `id_control_promo` = $promo and is_active = 1 order by id_control_program asc #kode asc";
	return $this->db->query($select);
	}
function selectPromocomboTraining( $intid_cabang = 0){
	if($intid_cabang == 0){
		
		$select = "select * from combo_submenu where kode like 'comb%' and intid_cabang = 0 order by kode asc";
		}
		else{
			
			//$select = "select * from combo_submenu where kode like 'comb%' and ( intid_cabang = ".$intid_cabang.") order by kode asc";
			$select = "select * from combo_submenu where kode like 'comb%' and ( intid_cabang = ".$intid_cabang.") order by intid_submenu asc";
			}
	return $this->db->query($select);
	}

function selectBarangPromoTraining($keyword, $jbarang, $intid_cabang = 0, $combo = 0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $select = "select a.intid_barang, 
        	upper(a.strnama) strnama, 
        	h.* 
        	from 
	        	barang a inner join promotraining h on h.intid_barang = a.intid_barang 
        	where  CURDATE() BETWEEN h.tanggal_awal and h.tanggal_akhir and a.strnama like '$keyword%' 
        			AND (h.intid_cabang = '$intid_cabang' or h.intid_cabang = 0) and (h.combo = '$combo' or h.combo is NULL) group by a.intid_barang";
        $query = $this->db->query($select);
        return $query->result();
        //return $select;
	}
function selectBarangFreePromoTraining($keyword, $jbarang, $intid_cabang = 0, $combo = 0, $intid_barang = 0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $select = "select a.intid_barang intid_barang_free, 
        	upper(a.strnama) strnama, 
        	h.* 
        	from 
	        	barang a inner join promotraining h on h.intid_barang_free = a.intid_barang 
        	where  CURDATE() BETWEEN h.tanggal_awal and h.tanggal_akhir and a.strnama like '$keyword%' 
        			AND (h.intid_cabang = '$intid_cabang' or h.intid_cabang = 0) and h.combo = '$combo' and h.intid_barang = '$intid_barang' group by a.intid_barang";
        $query = $this->db->query($select);
        return $query->result();
        //return $select;
	}
}
?>