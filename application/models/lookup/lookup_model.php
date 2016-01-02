<?php
class lookup_model extends CI_Model{
    
	function   __construct() 
	{
        parent::__construct();
    }
	
    /**
	*	@param selectBarangKode
	*/
	function selectBarangKode($keyword)
	{
		$select = "SELECT
						*
					FROM
						barang
					WHERE
						CODE = '$keyword'
					AND status_barang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	/**
	*	@param selectBarangHargaKode
	*/
	function selectBarangHargaKode($keyword)
	{
		$select = "
		select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				#AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.code like '$keyword' 
				#AND a.strnama not like '%maestro%'
				AND a.strnama not like '%tera%'
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	/**
	*	@param selectBarangKode
	*/
	function selectKode($keyword)
	{
		$select = "
					SELECT
						*
					FROM
						daftar_kode_barang
					WHERE
						nama_barang LIKE '$keyword%'
				";
		$query = $this->db->query($select);
		return $query->result();
	}

	/**
	
	*/
	function selectBarangPenjualan($keyword)
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code,
			a.intid_jbarang
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
			b.*,a.code, 
			a.intid_jbarang
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangPromoBlue($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1 AND a.intid_jbarang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangPromoMetal($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1  AND a.intid_jbarang = 2
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangPromoTulip($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1  AND a.intid_jbarang = 1 group by b.intid_barang
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangPromoTulipNoBlue($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.strnama NOT like '%blue diamond%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1  AND a.intid_jbarang = 1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangPromoLainlain($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.status_barang = 1
				AND a.intid_jbarang not in(5,4,3,8)
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangTebus($keyword)
	{
		$select = "SELECT a.intid_barang, UPPER( a.strnama ) strnama, b . * , a.code, 
			a.intid_jbarang
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
	function selectBarangTebusThink($keyword)
	{
		$select = "SELECT a.intid_barang, UPPER( a.strnama ) strnama, b . * , a.code, 
			a.intid_jbarang
				FROM barang a, control_barang_tebus b
				WHERE a.intid_barang = b.intid_barang
				AND CURDATE( ) 
				BETWEEN b.tglawal
				AND b.tglakhir
				AND a.strnama LIKE  '$keyword%'
				AND b.status_pencarian = 'lgthink'
				AND a.status_barang =1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectBarangTebusOval($keyword)
	{
		$select = "SELECT a.intid_barang, UPPER( a.strnama ) strnama, b . * , a.code, 
			a.intid_jbarang
				FROM barang a, control_barang_tebus b
				WHERE a.intid_barang = b.intid_barang
				AND CURDATE( ) 
				BETWEEN b.tglawal
				AND b.tglakhir
				AND a.strnama LIKE  '$keyword%'
				AND b.status_pencarian = 'lgoval'
				AND a.status_barang =1
				";
		$query = $this->db->query($select);
		return $query->result();
	}
		
	function selectBarangPenjualanCustom($keyword, $pencarian, $code = '',$idcbg=0)
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.* ,a.code, 
			a.intid_jbarang
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang = b.intid_barang 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%' 
				AND a.status_barang = 1
				and b.status_pencarian = '$pencarian' 
				AND
				(
					b.intid_cabang =0
					OR b.intid_cabang =$idcbg
				)
				group by a.intid_barang
				");
			return $query->result();
		}
	function selectBarangPenjualanCombo($keyword, $pencarian,$idpromo=0, $code = '', $intidcbg=0)
		{
			$req = 0;
			$query = $this->db->query("select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.* ,a.code, 
			a.intid_jbarang
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang = b.intid_barang 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%'
				and b.status_pencarian like '$pencarian%'
				and b.id_control_promo = $idpromo
				and (b.intid_cabang = 0 or b.intid_cabang =$intidcbg )
				and a.status_barang = 1
				GROUP BY b.intid_barang
				");
			return $query->result();
		}
		function selectBarangPenjualanFreeCustom($keyword, $intid_barang = 0, $pencarian = "", $id_control_promo = 0, $code = '',$idcbg=0)
		{
			$select = "select 
			a.intid_barang, 
			a.code,
			upper(a.strnama) strnama, 
			b.*, 
			a.intid_jbarang 
			from 
				barang a, control_barang_baru b 
			where 
				a.intid_barang 					= b.intid_barang_free 
				and CURDATE() BETWEEN b.tglawal AND b.tglakhir
				and a.strnama like '$keyword%' 
				and b.intid_barang				=  $intid_barang 
				and b.status_pencarian		like	'$pencarian%'
				AND a.status_barang = 1
				and b.id_control_promo	=	$id_control_promo
				and (
					b.intid_cabang =0
					OR b.intid_cabang =$idcbg
				)
				AND a.status_barang		= 1 group by a.intid_barang
				";
			$query = $this->db->query($select);
			//return $select;
			return $query->result();
		}
		/**
		@param selectBarangPromo
	*/
	function selectBarangSparepart($keyword)
	{
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang 
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang	= 1
				AND a.intid_jsatuan		=	2
				";
		$query = $this->db->query($select);
		return $query->result();
	}
	
	//
	/**
		@param selectBarangPromoCode
	*/
	function selectBarangPromoCode($keyword, $code = 0,$temp = "")
	{
		$arr = explode(" ",$temp);
		$like = $arr[0]." ";
		$code = 0;
		$select = "select 
			a.intid_barang, 
			upper(a.strnama) strnama, 
			b.*,a.code, 
			a.intid_jbarang
			from 
				barang a, harga b 
			where 
				a.intid_barang = b.intid_barang 
				AND CURDATE() BETWEEN b.date_start    and b.date_end 
				AND CURDATE() BETWEEN a.tanggal_awal and a.tanggal_akhir
				AND a.strnama like '$keyword%' 
				AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4
				AND a.status_barang = 1
				and a.strnama like '$like%'
				";
		$query = $this->db->query($select);
		return $query->result();
		//return $select;
	}	
	function selectBarangPenjualanCustomTebus($keyword, $pencarian, $code = '',$idcbg=0)
	{
		$req = 0;
		$query = $this->db->query("select 
		a.intid_barang, 
		upper(a.strnama) strnama, 
		b.* ,a.code, 
		a.intid_jbarang
		from 
			barang a, control_barang_tebus b 
		where 
			a.intid_barang = b.intid_barang 
			and CURDATE() BETWEEN b.tglawal AND b.tglakhir
			and a.strnama like '$keyword%' 
			AND a.status_barang = 1
			and b.status_pencarian = '$pencarian' 
			AND
			(
				b.intid_cabang =0
				OR b.intid_cabang =$idcbg
			)
			group by a.intid_barang
			");
		return $query->result();
	}
	
}
	