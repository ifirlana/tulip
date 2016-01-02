<?php
class lookup_model extends CI_Model{
    
	function   __construct() 
	{
        parent::__construct();
    }
	
	/**
	
	*/
	function selectBarangPenjualan($keyword)
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				and CURDATE() BETWEEN b.date_start and b.date_end 
				and CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				and a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 
				AND a.intid_jbarang != 6 
				AND a.intid_jbarang != 4 
				AND a.status_barang = 1
				");
			return $query->result();
		}
	/**
		@param selectBarangPromo
	*/
	function selectBarangPromo($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.status_barang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangTebus($keyword)
	{
		$select = "SELECT a.intid_barang, UPPER( a.strnama ) strnama, b . * , a.code
				FROM barang a, control_barang_tebus b
				WHERE a.intid_barang = b.intid_barang
				AND CURDATE( ) 
				BETWEEN b.tglawal
				AND b.tglakhir
				AND a.strnama LIKE  '$keyword%'
				AND a.status_barang =1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
		
	function selectBarangPenjualanCustom($keyword, $pencarian, $code = '')
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.* ,a.code
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang = b.intid_barang 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%'
				and b.status_pencarian = '$pencarian' group by a.intid_barang
				");
			return $query->result();
		}
	function selectBarangPenjualanCombo($keyword, $pencarian,$idpromo=0, $code = '')
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.* ,a.code
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang = b.intid_barang 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%'
				and b.status_pencarian like '$pencarian%'
				and b.id_control_promo = $idpromo
				GROUP BY b.intid_barang
				");
			return $query->result();
		}
		function selectBarangPenjualanFreeCustom($keyword, $intid_barang = 0, $pencarian = "", $id_control_promo = 0, $code = '')
		{
			$select = "select 
			a.intid_barang, 
			a.code,
			upper(a.strnama) strnama, 
			b.* 
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang 					= b.intid_barang_free 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%' 
				and b.intid_barang				=  $intid_barang 
				and b.status_pencarian		like	'$pencarian%'
				and b.id_control_promo	=	$id_control_promo
				AND a.status_barang		= 1 group by a.intid_barang
				";
			$query = $this->db->query($select);
			//return $select;
			return $query->result();
		}
}
	