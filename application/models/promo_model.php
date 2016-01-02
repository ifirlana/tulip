<?php
	class  promo_model EXTENDS CI_Model{
		
		var $where = " is_active = 1 ";
		
		function getPromoActive($jpen = null,$idcbg=0,$wilayah= 0, $promos = 0,  $ishut = 0)
		{
			$isi='';
			$cari = $this->db->query("select id_control_promo from control_cabang_promo where (intid_cabang = 0 or intid_cabang = $idcbg) and is_active=1 and curdate() between tgl_mulai and tgl_akhir")->result();
			
			if(!empty($jpen) || $jpen!=0):
			$isi ="and intid_jpenjualan like'%$jpen%'";
			endif;
			$temp = "";
			foreach($cari as $rok)
			{
				$temp .= $rok->id_control_promo.", ";
			}
			$temp = substr($temp, 0,-2);//(, $replace, $subject)($temp, 0, -2);
			$select = "select * from control_promo_baru where ".$this->where." ".$isi." and intid_control_promo in(".$temp." ) and curdate() between tanggal_mulai and tanggal_akhir and intid_wilayah like '%".$wilayah."%' and (is_pengejaran = 0 OR is_pengejaran = $promos ) and (is_pengejaranChall = 0 OR is_pengejaranChall = $ishut  ) and is_tebus =  '0' ";
			//var_dump($select);
			return $this->db->query($select)->result();
			
		}
		
		// load form_penjualan_20150204.php
		function selectPromoPenjualan($idconpromo=null)
		{
			$isi='';
			if($idconpromo!= 0 || $idconpromo != null):
				$isi="and intid_control_promo=$idconpromo";
			endif;
			$cari = $this->db->query("select * from control_promo_baru where ".$this->where." ".$isi)->result();
			$qry = $this->db->query("select * from jenis_penjualan where intid_jpenjualan in (".$cari[0]->intid_jpenjualan.")")->result();
			return $qry;
		}
		
		// load form_penjualan_20150205.php
		function selectPromoPenjualan_20150205($idconpromo=null, $intid_cabang = null)
		{
			$select = "select 
			group_concat(id_jenis_penjualan) id_jpenjualan
			from 
			control_cabang_jenis_penjualan
			where
			(intid_cabang = 0 or intid_cabang = $intid_cabang)
			and is_active = 1";
									
			$cari		=	$this->db->query($select)->result();
			
			$select2	=	"select
									jenis_penjualan.*
									from 
										jenis_penjualan, 
										control_class
									where
										jenis_penjualan.intid_jpenjualan = control_class.id_jpenjualan
										and jenis_penjualan.intid_jpenjualan in (".$cari[0]->id_jpenjualan.")
										and control_class.id_control_promo = ".$idconpromo."";
			
			return	$this->db->query($select2)->result();
		}
		
		function selectPromoPencarian($idconpromo=null){
			$isi='';
			if($idconpromo!= 0 || $idconpromo != null):
				$isi="and intid_control_promo=$idconpromo";
			endif;
			$qry = $this->db->query("select * from control_promo_baru where ".$this->where." ".$isi)->result();
			return $qry;
		}
		function selectJPenjualan($idjpenjual=null){
			$jpen="";
			if($idjpenjual==null):
			$jpen="1,2,3,4,5,6,7,8,13";
			else:
			$jpen=$idjpenjual;
			endif;
			if(strtoupper($this->session->userdata('username')) != "ADMIN"){
				$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in ($jpen) and is_active = 1  order by intid_jpenjualan asc");
			}else{
					$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in ($jpen)  order by intid_jpenjualan asc");
				}
			return $query->result();
		}
		function promoClass($idconpromo=null, $idpenjualan=null){
					/* if(!empty($idconpromo) || !empty($idpenjualan)):
					$select = "select 
								control_class.* from 
									control_class 
								where 
								control_class.id_control_promo =$idconpromo 
								and control_class.id_jpenjualan= $idpenjualan";
					return $this->db->query($select)->result();
					endif; */
					if(!empty($idconpromo) || !empty($idpenjualan)):
					/* $select = "select 
								control_class.* from 
									control_class 
								where 
								control_class.id_control_promo =$idconpromo 
								and control_class.id_jpenjualan= $idpenjualan"; */
					$select = "select 
								control_promo_baru.is_komtam, 
								control_promo_baru.is_voucher, 
								control_promo_baru.pencarian,control_class.* from 
									control_class LEFT JOIN control_promo_baru ON control_promo_baru.intid_control_promo = control_class.id_control_promo
								where 
								control_class.id_control_promo =$idconpromo 
								and control_class.id_jpenjualan= $idpenjualan";
					return $this->db->query($select)->result();
					endif;
				}
		function promoClassBaru($idconpromo=null, $idpenjualan=null,$id_group_class = null){
					/* if(!empty($idconpromo) || !empty($idpenjualan)):
					$select = "select 
								control_class.* from 
									control_class 
								where 
								control_class.id_control_promo =$idconpromo 
								and control_class.id_jpenjualan= $idpenjualan";
					return $this->db->query($select)->result();
					endif; */
					if(!empty($idconpromo) || !empty($idpenjualan)):
					/* $select = "select 
								control_class.* from 
									control_class 
								where 
								control_class.id_control_promo =$idconpromo 
								and control_class.id_jpenjualan= $idpenjualan"; */
					$select = "select 
								control_class_baru.* 
								from 
									control_class_baru
								where 
								control_class_baru.id_control_promo =$idconpromo 
								#and control_class_baru.id_jpenjualan= $idpenjualan
								and control_class_baru.id_control_class = $id_group_class";
					return $this->db->query($select)->result();
					endif;
				}
				
		function promoClassCustom($idconpromo=null, $idpenjualan=null){
			if(!empty($idconpromo) || !empty($idpenjualan)):
			$select = "select 
						control_class_baru.* from 
							control_class_baru 
						where 
						control_class_baru.id_control_promo =$idconpromo 
						and control_class_baru.id_jpenjualan= $idpenjualan";
			return $this->db->query($select)->result();
			endif;
		}
		function selectPromoControl($intid_control_promo, $intid_jpenjualan)
		{
			$where = "";
			if(isset($intid_control_promo) and !empty($intid_control_promo))
			{
				$where .= "control_class.id_control_promo = '$intid_control_promo'";
			}
			if(isset($intid_jpenjualan) and !empty($intid_jpenjualan))
			{
				$where .= " and control_class.id_jpenjualan = '$intid_jpenjualan'";
			}
			if(isset($where) and !empty($where)){ 
				
				$where = "where ".$where;
				}
				
			$select	=	"select * from control_promo_baru inner join control_class on control_promo_baru.intid_control_promo = control_class.id_control_promo ".$where;
			return $this->db->query($select);
		}
        function getComboPenjualan($idpromo = 0){
                    return $this->db->query("SELECT * 
                    FROM  `control_combo` 
                    WHERE  `id_control_promo` =$idpromo
                    AND CURDATE( ) 
                    BETWEEN  `tgl_awal` 
                    AND  `tgl_akhir` and is_active = '1' ORDER BY id_control_combo ASC")->result();
                }
        function getCombo($idpromo = 0){
            return $this->db->query("SELECT * 
            FROM  `control_combo` 
            WHERE  `id_control_combo` =$idpromo
            AND CURDATE( ) 
            BETWEEN  `tgl_awal` 
            AND  `tgl_akhir`  and is_active = '1'  ORDER BY id_control_combo ASC")->result();
        }
		/* function lookbarang($keyword, $ket='bayar', $status='default'){
				$isi = ''
		} */
		function getBatas($omset = 0,$idpromo = 0 ){
/*			return "SELECT * FROM `control_batas` WHERE 
									(`id_control_promo` = 0 or `id_control_promo` = $idpromo) 
									and `batas_min` <= $omset order by batas_min desc";*/
			return $this->db->query("SELECT * FROM `control_batas` WHERE 
									(`id_control_promo` = 0 or `id_control_promo` = $idpromo) 
									and $omset between batas_min and batas_max and is_active = 1 #`batas_min` <= $omset order by batas_min desc")->result();

		}
		function getBatasNew($omset = 0,$idpromo = 0 ){
			return $this->db->query("SELECT * FROM `control_batas` WHERE 
									(`id_control_promo` = 99) 
									and $omset between batas_min and batas_max and is_active = 1 ")->result();

		}
		/* Buat Cetak Nota */
		function getpenjualan(){
			return $this->db->query("select * from jenis_penjualan")->result();
		}
		function getNotaView($nota = 0, $idpenjualan = 0){
			return $this->db->query("SELECT
														b.strnama,
														jp.strnama_jpenjualan,
														m.strnama_dealer,
														c.strnama_cabang,
														u.strnama_unit,
														m.strnama_upline,
														nd.id_jpenjualan,
														nd.intid_barang,
														nd.intquantity,
														nd.intharga,
														nd.intvoucher as vochernd,
														n.*
													FROM
														nota n
													LEFT JOIN nota_detail nd ON n.intid_nota = nd.intid_nota
													LEFT JOIN member m ON m.intid_dealer = n.intid_dealer
													LEFT JOIN cabang c ON c.intid_cabang = n.intid_cabang
													LEFT JOIN unit u ON u.intid_unit = n.intid_unit
													LEFT JOIN barang b ON b.intid_barang = nd.intid_barang
													LEFT JOIN jenis_penjualan jp ON jp.intid_jpenjualan = nd.id_jpenjualan
													WHERE
														n.intid_nota = '$nota' and nd.id_jpenjualan = $idpenjualan")->result();
		}
	
	function selectJPenjualanTebus($idjpenjual=null){
			$jpen="";
			if($idjpenjual==null):
			$jpen="1,2,3,4,5,6,7,8,13";
			else:
			$jpen=$idjpenjual;
			endif;
			if(strtoupper($this->session->userdata('username')) != "ADMIN"){
				$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in ($jpen) and is_active = 1  order by intid_jpenjualan asc");
			}else{
					$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in ($jpen)  order by intid_jpenjualan asc");
				}
			return $query;
		}
	function promoClassDestiny($id){
			if(!empty($id))
			{
			$select = "select 
						control_class_baru.* from 
							control_class_baru 
						where 
						id_control_class = $id";
			return $this->db->query($select)->result();
			}
		}
	
	/**
	*	@param intid_control_promo (diambil dari table control_class_tebus), intid_jpenjualan (diambil dari table control_class_tebus)
	*	@see selectPromoControlTebus
	*/
	// @desc digunakan untuk menebus promo berasala dari table promo tebus
	function selectPromoControlTebus($intid_control_promo, $intid_jpenjualan)
	{
		$where = "";
		if(isset($intid_control_promo) and !empty($intid_control_promo))
		{
			$where .= "control_class_tebus.id_control_promo = '$intid_control_promo'";
		}
		if(isset($intid_jpenjualan) and !empty($intid_jpenjualan))
		{
			$where .= " and control_class_tebus.id_jpenjualan = '$intid_jpenjualan'";
		}
		if(isset($where) and !empty($where)){ 
			
			$where = "where ".$where;
			}
			
		$select	=	"select * from control_promo_tebus inner join control_class_tebus on control_promo_tebus.intid_control_promo_tebus = control_class_tebus.id_control_promo ".$where;
		return $this->db->query($select);
	}
	// end. selectPromoControlTebus
	}