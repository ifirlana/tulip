<?php
class STOCK_BARANG_MODEL extends CI_Model{
    
	function   __construct() {
        parent::__construct();
    }
	
	//-------------------- Penghitungan stock barang detik itu juga ---------------------//	
	function get_kartu_stock($cabang)
	{
		$query = $this->db->query("SELECT stok_barang.intid_barang, strnama, IF(set_fisik IS NULL, 0, set_fisik) AS set_fisik, IF(pcs_fisik IS NULL, 0, pcs_fisik) AS pcs_fisik, IF(set_hutang IS NULL, 0, set_hutang) AS set_hutang, IF(pcs_hutang IS NULL, 0, pcs_hutang) AS pcs_hutang, DATE((SELECT as_of_date FROM stok_barang WHERE intid_cabang = '$cabang' LIMIT 0,1)) AS as_of_date, intquantity, datetgl 
		FROM 
			(SELECT barang.intid_barang, strnama, set_fisik, pcs_fisik, set_hutang, pcs_hutang, as_of_date 
				FROM barang 
				LEFT JOIN 
					(SELECT * 
						FROM stok_barang WHERE intid_cabang = '$cabang') 
					AS stok_barang 
				ON barang.intid_barang = stok_barang.intid_barang ORDER BY intid_barang) 
			AS stok_barang 
		LEFT JOIN 
			(SELECT intid_barang, SUM(intquantity) AS intquantity, datetgl 
				FROM 
					(SELECT intid_barang, intquantity, datetgl 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						WHERE datetgl > (SELECT as_of_date FROM stok_barang WHERE intid_cabang = '$cabang' LIMIT 0,1) AND intid_cabang = '$cabang') 
					AS nota GROUP BY intid_barang) 
			AS nota
		ON stok_barang.intid_barang = nota.intid_barang 
		WHERE intquantity IS NOT NULL OR set_fisik IS NOT NULL ORDER BY strnama");
        return $query->result();
	}
	function delete_stock($cabang)
	{
		$this->db->where('intid_cabang', $cabang);
		$this->db->delete('stok_barang');
	}
	function stock_insert($data)
	{
		$this->db->insert('stok_barang', $data);
	}
	function date_update($cabang, $year, $month, $day, $time){
		$date = $year . "-" . $month . "-" . $day . " " . $time;
		$data = array(
			'as_of_date'=>$date,
			);
		$this->db->where('intid_cabang',$cabang);
		$this->db->update('stok_barang',$data);
	}
	
	///@ifirlana
	//29 jan 2014
	//desc : untuk penggunaan cabang stok_model.
	//
	function getLap_Stok_cab_START($intid_cabang, $week,$tahun){
	
			$weekbefore = $week-1;
			$query = $this->db->query('select barang.strnama,
									  		barang.intid_barang,
											barang.intid_jsatuan, 
											"0" as jum_barang_masuk_before, 
											"0" as jum_barang_keluar_before, 
											"0" as jum_barang_keluar_hadiah_before,
											"0" as jum_barang_masuk_after, 
											"0" as jum_barang_keluar_after,
											"0" as jum_barang_keluar_hadiah_after,
											if(stok_barang.set_fisik is NULL, 0,stok_barang.set_fisik) set_fisik, 
											if(stok_barang.pcs_fisik is NULL, 0,stok_barang.pcs_fisik) pcs_fisik,
											if(stok_barang.set_hutang is NULL, 0,stok_barang.set_hutang) set_hutang,  
											if(stok_barang.pcs_hutang is NULL, 0, stok_barang.pcs_hutang) pcs_hutang
									  from
									  barang
									   left join 
									   (select *
											from 
											stok_barang
											where intid_cabang = "'.$intid_cabang.'"
											and year(as_of_date) = "'.$tahun.'"
											)as stok_barang
									   on stok_barang.intid_barang = barang.intid_barang
									  order by barang.strnama asc
									  ');
			return $query->result();
		}
	//ending
	
	/*
	// ifirlana@gmail.com
	//desc : untuk penggunaaan stok gunakan continue
	*/
	function getLap_Stok_cab_4($intid_cabang, $week, $tahun){
			$hutang_barang_set = array();
			$hutang_barang_pcs = array();
			$sisa_barang_pcs = array();
			$sisa_barang_set = array();
			//coba lagi
			$hasil = array();
			//disini lakukan tracking hutang barang
			$select = "select * from stok_barang where intid_cabang = ".$intid_cabang." and year(as_of_date) = ".$tahun." ";
			$query = $this->db->query($select);
			foreach($query->result() as $row){
				//diset awal sebagai array multi dimensi
				$hasil[0][$row->intid_barang]['hutang_barang_set'] = $row->set_hutang;
				$hasil[0][$row->intid_barang]['hutang_barang_pcs'] = $row->pcs_hutang;
				$hasil[0][$row->intid_barang]['sisa_barang_pcs'] = $row->set_hutang;
				$hasil[0][$row->intid_barang]['sisa_barang_set'] = $row->pcs_hutang;
				}
			//
			$select2 = "select * from week where intid_week < ".$week." and inttahun = ".$tahun." and dateweek_start > (select date_format(as_of_date,'%Y-%m-%d') from stok_barang where intid_cabang = ".$intid_cabang." and year(as_of_date) = ".$tahun." limit 0,1) group by intid_week order by intid_week asc";
			$query_cek = $this->db->query($select2);
			if($query_cek->num_rows() == 0){
				$select2 = "select * from week where intid_week = ".$week." and inttahun = ".$tahun." group by intid_week order by intid_week asc";
				}
			$query2 = $this->db->query($select2);
			
			foreach($query2->result() as $row){
				//melakukan perhitungan mundur week
				//
				$select3 = "select barang.*, 
					if(nota.jum_barang_keluar_nota is NULL, 0 ,nota.jum_barang_keluar_nota) jum_barang_keluar_nota, 
					'0' as  jum_barang_keluar_nota_hadiah,
					if(surat_jalan.jum_barang_masuk_sj is NULL, 0,surat_jalan.jum_barang_masuk_sj) jum_barang_masuk_sj,
					if(retur.jum_barang_keluar_retur, 0,retur.jum_barang_keluar_retur) jum_barang_keluar_retur,
					if(stok.set_fisik is NULL, 0,stok.set_fisik) set_fisik, 
					if(stok.pcs_fisik, 0,stok.pcs_fisik) pcs_fisik,
					if(stok.set_hutang, 0,stok.set_hutang) set_hutang, 
					if(stok.pcs_hutang, 0,stok.pcs_hutang) pcs_hutang,
					if(sttb.jum_barang_masuk_sj_retur is NULL, 0, sttb.jum_barang_masuk_sj_retur) jum_barang_masuk_sj_retur, 
					if(retur_sparepart.jum_barang_keluar_sparepart is NULL, 0, retur_sparepart.jum_barang_keluar_sparepart) jum_barang_keluar_sparepart,
					if(sj_sparepart.jum_barang_masuk_sparepart is NULL, 0, sj_sparepart.jum_barang_masuk_sparepart) jum_barang_masuk_sparepart
					from barang 
					left join
					(select 
						sum(nd.intquantity) jum_barang_keluar_nota, nd.intid_barang
						from nota n inner join nota_detail nd
						on nd.intid_nota = n.intid_nota
						where n.intid_week = '$row->intid_week'
						and n.intid_cabang = '$intid_cabang'
						and year(n.datetgl) = '$tahun'
						and n.is_dp = 0
						and n.is_asi = 0
						group by nd.intid_barang) as nota on nota.intid_barang = barang.intid_barang
					left join
					(select
						sum(sd.quantity) jum_barang_masuk_sj, sd.intid_barang
						from spkb s inner join spkb_detail sd on s.no_spkb = sd.no_spkb
						where 
						s.week_sj = '$row->intid_week'	
						and year(s.tgl_kirim) = '$tahun'
						and s.intid_cabang = '$intid_cabang'
						and s.no_sj != ''
						and s.terkirim = 1
						group by sd.intid_barang) as surat_jalan on surat_jalan.intid_barang = barang.intid_barang
					left join
					(select 
						sum(rd.quantity) jum_barang_keluar_retur, rd.intid_barang
						from retur_ r inner join retur_detail_ rd on r.no_srb = rd.no_srb
						where 
						r.intid_week = '$row->intid_week'
						and year(r.datetgl) = '$tahun'
						and r.intid_cabang = '$intid_cabang'
						and r.is_verified = 1
						group by rd.intid_barang) as retur on retur.intid_barang = barang.intid_barang
					left join
					(select 
						* 
						from stok_barang s
						where 
						s.intid_cabang = '$intid_cabang'
						and year(s.as_of_date) = '$tahun'
						) as stok on stok.intid_barang = barang.intid_barang
					left join
					(select
						sum(std.quantity) jum_barang_masuk_sj_retur, std.intid_barang
						from sttb st inner join sttb_detail std on std.no_sttb = st.no_sttb
						where 
						st.week = '$row->intid_week'
						and st.intid_cabang_kirim = '$intid_cabang'
						and year(st.tgl_kirim) = '$tahun'
						and st.no_sj != ''
						and st.terkirim = 1
						group by std.intid_barang) as sttb on sttb.intid_barang = barang.intid_barang
					left join
					(select sum(rsptd.qty) jum_barang_keluar_sparepart, rsptd.intid_barang
						from retur_sparepart rspt inner join retur_sparepart_detail rsptd on rsptd.intid_retur_sparepart = rspt.intid_retur_sparepart
						where 
						rspt.intid_week = '$week'
						and rspt.intid_cabang = '$intid_cabang'
						and year(rspt.datetgl) = '$tahun'
						and (rspt.no_sttb !='' or rspt.no_sttb is not null)
						and rspt.is_verified = 1
						group by rsptd.intid_barang) as retur_sparepart on retur_sparepart.intid_barang = barang.intid_barang
					left join
					(select sum(stprd.qty) jum_barang_masuk_sparepart, stprd.intid_barang 
						from sttb_sparepart stpr inner join sttb_sparepart_detail stprd on stpr.no_sttb = stprd.no
						where 
						stpr.week_sj = '$week'
						and stpr.intid_cabang = '$intid_cabang'
						and year(stpr.tgl_kirim) = '$tahun'
						and (stpr.no_sj_sparepart !='' or stpr.no_sj_sparepart is not null)
						and stpr.terkirim = 1
						group by stprd.intid_barang) as sj_sparepart on sj_sparepart.intid_barang = barang.intid_barang 
					";
					//echo "<p>".$select3."</p>";
					$query3 = $this->db->query($select3);
					foreach($query3->result() as $rok){
						if(empty($hasil[$rok->intid_barang]['hutang_barang_set'])){
							$hasil[0][$rok->intid_barang]['hutang_barang_set'] = $rok->set_hutang;
						}
						if(empty($hasil[$rok->intid_barang]['hutang_barang_pcs'])){
							$hasil[0][$rok->intid_barang]['hutang_barang_pcs'] = $rok->pcs_hutang;
						}
						if(empty($hasil[$rok->intid_barang]['sisa_barang_pcs'])){
							$hasil[0][$rok->intid_barang]['sisa_barang_pcs'] = $rok->pcs_fisik;
						}
						if(empty($hasil[$rok->intid_barang]['sisa_barang_set'])){
							$hasil[0][$rok->intid_barang]['sisa_barang_set'] = $rok->set_fisik;
						}
						//perhitungan mulai ke sql
						$sisa 	= 0;
						$hutang = 0;
						 $cek = $rok->jum_barang_masuk_sj + $rok->jum_barang_masuk_sj_retur + $rok->jum_barang_keluar_retur - $rok->jum_barang_keluar_nota - $rok->jum_barang_keluar_nota_hadiah;
						 if($cek < 0){
						 	$hutang = $cek * (-1);
						 }else{
						 	$sisa = $cek;
						 }
						//simpan array multi dimensi
						if($rok->intid_jsatuan == 2){
							$hasil[0][$rok->intid_barang]['hutang_barang_set'] = $hasil[0][$rok->intid_barang]['hutang_barang_set'] + 0;
							$hasil[0][$rok->intid_barang]['hutang_barang_pcs'] = $hasil[0][$rok->intid_barang]['hutang_barang_pcs'] + $hutang;
							$hasil[0][$rok->intid_barang]['sisa_barang_pcs'] = $hasil[0][$rok->intid_barang]['sisa_barang_pcs']+ 0;
							$hasil[0][$rok->intid_barang]['sisa_barang_set'] = $hasil[0][$rok->intid_barang]['sisa_barang_set'] + $sisa;
						}else{
							$hasil[0][$rok->intid_barang]['hutang_barang_set'] = $hasil[0][$rok->intid_barang]['hutang_barang_set'] + $hutang ;
							$hasil[0][$rok->intid_barang]['hutang_barang_pcs'] = $hasil[0][$rok->intid_barang]['hutang_barang_pcs'] + 0;
							$hasil[0][$rok->intid_barang]['sisa_barang_pcs'] = $hasil[0][$rok->intid_barang]['sisa_barang_pcs']+ $sisa;
							$hasil[0][$rok->intid_barang]['sisa_barang_set'] = $hasil[0][$rok->intid_barang]['sisa_barang_set'] + 0;
						}
					}
					$select4 = "select 
							barang_hadiah.intid_barang_hadiah intid_barang,
							barang_hadiah.intid_jsatuan,
							barang_hadiah.strnama,
							barang_hadiah.intid_jbarang,
							'0' as intqty,
							barang_hadiah.status_barang,
							'0' jum_barang_keluar_nota, 
							if(nota_hadiah.jum_barang_keluar_nota_hadiah is NULL, 0,nota_hadiah.jum_barang_keluar_nota_hadiah) jum_barang_keluar_nota_hadiah,
							'0' as jum_barang_masuk_sj,
							'0' as jum_barang_keluar_retur,
							'0' as set_fisik, 
							'0' as pcs_fisik,
							'0' as set_hutang, 
							'0' as pcs_hutang,
							'0' jum_barang_masuk_sj_retur 
							from barang_hadiah
							left join
							(select 
								sum(ndh.intquantity) jum_barang_keluar_nota_hadiah, ndh.intid_barang
								from nota_hadiah nh inner join nota_detail_hadiah ndh
								on nh.intid_nota = ndh.intid_nota
								where nh.intid_week = '$week'
								and year(nh.datetgl) = '$tahun'
								and nh.intid_cabang = '$intid_cabang'
								group by ndh.intid_barang
								) as nota_hadiah on nota_hadiah.intid_barang = barang_hadiah.intid_barang_hadiah";
					$query4 = $this->db->query($select4);
					foreach($query4->result() as $rok){
						if(empty($hasil[$rok->intid_barang]['hutang_barang_set'])){
							$hasil[1][$rok->intid_barang]['hutang_barang_set'] = $rok->set_hutang;
						}
						if(empty($hasil[$rok->intid_barang]['hutang_barang_pcs'])){
							$hasil[1][$rok->intid_barang]['hutang_barang_pcs'] = $rok->pcs_hutang;
						}
						if(empty($hasil[$rok->intid_barang]['sisa_barang_pcs'])){
							$hasil[1][$rok->intid_barang]['sisa_barang_pcs'] = $rok->pcs_fisik;
						}
						if(empty($hasil[$rok->intid_barang]['sisa_barang_set'])){
							$hasil[1][$rok->intid_barang]['sisa_barang_set'] = $rok->set_fisik;
						}
						//perhitungan mulai ke sql
						$sisa 	= 0;
						$hutang = 0;
						 $cek = $rok->jum_barang_masuk_sj + $rok->jum_barang_masuk_sj_retur + $rok->jum_barang_keluar_retur - $rok->jum_barang_keluar_nota - $rok->jum_barang_keluar_nota_hadiah;
						 if($cek < 0){
						 	$hutang = $cek * (-1);
						 }else{
						 	$sisa = $cek;
						 }
						//simpan array multi dimensi
						if($rok->intid_jsatuan == 2){
							$hasil[1][$rok->intid_barang]['hutang_barang_set'] = $hasil[1][$rok->intid_barang]['hutang_barang_set'] + 0;
							$hasil[1][$rok->intid_barang]['hutang_barang_pcs'] = $hasil[1][$rok->intid_barang]['hutang_barang_pcs'] + $hutang;
							$hasil[1][$rok->intid_barang]['sisa_barang_pcs'] = $hasil[1][$rok->intid_barang]['sisa_barang_pcs']+ 0;
							$hasil[1][$rok->intid_barang]['sisa_barang_set'] = $hasil[1][$rok->intid_barang]['sisa_barang_set'] + $sisa;
						}else{
							$hasil[1][$rok->intid_barang]['hutang_barang_set'] = $hasil[1][$rok->intid_barang]['hutang_barang_set'] + $hutang ;
							$hasil[1][$rok->intid_barang]['hutang_barang_pcs'] = $hasil[1][$rok->intid_barang]['hutang_barang_pcs'] + 0;
							$hasil[1][$rok->intid_barang]['sisa_barang_pcs'] = $hasil[1][$rok->intid_barang]['sisa_barang_pcs']+ $sisa;
							$hasil[1][$rok->intid_barang]['sisa_barang_set'] = $hasil[1][$rok->intid_barang]['sisa_barang_set'] + 0;
						}
					}
			}
			return $hasil;
			//
			}
		//ending
		/**/
		function getLap_Stok_cab_5($intid_cabang, $week,$tahun){
		
			$select = "select barang.*, 
						if(nota.jum_barang_keluar_nota is NULL, 0, nota.jum_barang_keluar_nota) jum_barang_keluar_nota, 
						'0' as jum_barang_keluar_nota_hadiah, 
						if(surat_jalan.jum_barang_masuk_sj is NULL, 0,surat_jalan.jum_barang_masuk_sj) jum_barang_masuk_sj, 
						if(retur.jum_barang_keluar_retur is NULL, 0,retur.jum_barang_keluar_retur) jum_barang_keluar_retur,
						if(sttb.jum_barang_masuk_sj_retur is NULL, 0, sttb.jum_barang_masuk_sj_retur) jum_barang_masuk_sj_retur,
						if(retur_sparepart.jum_barang_keluar_sparepart is NULL, 0, retur_sparepart.jum_barang_keluar_sparepart) jum_barang_keluar_sparepart,
						if(sj_sparepart.jum_barang_masuk_sparepart is NULL, 0, sj_sparepart.jum_barang_masuk_sparepart) jum_barang_masuk_sparepart
					from barang left join
					(select 
						sum(nd.intquantity) jum_barang_keluar_nota, nd.intid_barang
						from nota n inner join nota_detail nd
						on nd.intid_nota = n.intid_nota
						where n.intid_week = '$week'
						and n.intid_cabang = '$intid_cabang'
						and year(n.datetgl) = '$tahun'
						and n.is_dp = 0
						and n.is_asi = 0
						group by nd.intid_barang) as nota on nota.intid_barang = barang.intid_barang
					left join
					(select
						sum(sd.quantity) jum_barang_masuk_sj, sd.intid_barang
						from spkb s inner join spkb_detail sd on s.no_spkb = sd.no_spkb
						where 
						s.week_sj = '$week'
						and s.intid_cabang = '$intid_cabang'
						and year(s.tgl_kirim) = '$tahun'
						and (s.no_sj != '' or s.no_sj is not null)
						and s.terkirim = 1
						group by sd.intid_barang) as surat_jalan on surat_jalan.intid_barang = barang.intid_barang
					left join
					(select 
						sum(rd.quantity) jum_barang_keluar_retur, rd.intid_barang
						from retur_ r inner join retur_detail_ rd on r.no_srb = rd.no_srb
						where 
						r.intid_week = '$week'
						and r.intid_cabang = '$intid_cabang'
						and year(r.datetgl) = '$tahun'
						and r.is_verified = 1
						group by rd.intid_barang) as retur on retur.intid_barang = barang.intid_barang
					left join
					(select
						sum(std.quantity) jum_barang_masuk_sj_retur, std.intid_barang
						from sttb st inner join sttb_detail std on std.no_sttb = st.no_sttb
						where 
						st.week = '$week'
						and st.intid_cabang_kirim = '$intid_cabang'
						and year(st.tgl_kirim) = '$tahun'
						and (st.no_sj != '' or st.no_sj is not null)
						and st.terkirim = 1
						group by std.intid_barang) as sttb on sttb.intid_barang = barang.intid_barang
					left join 
					(select sum(rsptd.qty) jum_barang_keluar_sparepart, rsptd.intid_barang
						from retur_sparepart rspt inner join retur_sparepart_detail rsptd on rsptd.intid_retur_sparepart = rspt.intid_retur_sparepart
						where 
						rspt.intid_week = '$week'
						and rspt.intid_cabang = '$intid_cabang'
						and year(rspt.datetgl) = '$tahun'
						and (rspt.no_sttb !='' or rspt.no_sttb is not null)
						and rspt.is_verified = 1
						group by rsptd.intid_barang) as retur_sparepart on retur_sparepart.intid_barang = barang.intid_barang
					left join
					(select sum(stprd.qty) jum_barang_masuk_sparepart, stprd.intid_barang 
						from sttb_sparepart stpr inner join sttb_sparepart_detail stprd on stpr.no_sttb = stprd.no
						where 
						stpr.week_sj = '$week'
						and stpr.intid_cabang = '$intid_cabang'
						and year(stpr.tgl_kirim) = '$tahun'
						and (stpr.no_sj_sparepart !='' or stpr.no_sj_sparepart is not null)
						and stpr.terkirim = 1
						group by stprd.intid_barang) as sj_sparepart on sj_sparepart.intid_barang = barang.intid_barang 
					order by barang.strnama asc";			
			$query = $this->db->query($select);
			return $query;
		}
		//ending
		/**/
		function getLap_Stok_cab_6($intid_cabang, $week,$tahun){
			$select = "select barang_hadiah.intid_barang_hadiah intid_barang,
						barang_hadiah.*,
						if(nota.jum_barang_keluar_nota is NULL, 0, nota.jum_barang_keluar_nota) jum_barang_keluar_nota, 
						'0' as jum_barang_keluar_nota_hadiah, 
						'0' as jum_barang_masuk_sj, 
						'0' as jum_barang_keluar_retur,
						'0' as jum_barang_masuk_sj_retur 
					from barang_hadiah left join
					(select 
						sum(nd.intquantity) jum_barang_keluar_nota, nd.intid_barang
						from nota_hadiah n inner join nota_detail_hadiah nd
						on nd.intid_nota = n.intid_nota
						where n.intid_week = '$week'
						and n.intid_cabang = '$intid_cabang'
						and year(n.datetgl) = '$tahun' 
						group by nd.intid_barang) as nota on nota.intid_barang = barang_hadiah.intid_barang_hadiah
					order by barang_hadiah.strnama asc
					";
			$query = $this->db->query($select);
			return $query;
		}
		//ending
	
	//starting
	function selectBarang($keyword, $jbarang,$intid_cabang){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
		
		$select = "select a.intid_barang, upper(a.strnama) strnama, b.*, t.intquantity jumlah_quantity
		from barang a 
		left join 
		(select * from temporary_stock where intid_cabang = ".$intid_cabang.")  t on a.intid_barang = t.intid_barang, 
		harga b 
		where a.intid_barang = b.intid_barang and CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%' AND (a.intid_barang < 5001 OR a.intid_barang > 5006) AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4 AND a.intid_jbarang != '$req'";
		$query = $this->db->query($select);
         return $query->result();
		//echo $select;
		}
	
	/**  
	* @param selectGetStockBarangWeek
	* @param selectGetStockBarangStart
	* date added 2014 11 26
	*/
	function selectGetStockBarangWeek($intid_cabang = 0, $intid_week = 0, $inttahun = 0)
	{
		$select	=	"select
								barang.*,
								nota.intquantity nota_qty,
								nota_hadiah.intquantity nota_hadiah_qty,
								surat_jalan_reguler.intquantity surat_jalan_reguler_qty,
								surat_jalan_sparepart.intquantity surat_jalan_sparepart_qty,
								surat_jalan_returcabang.intquantity surat_jalan_returcabang_qty,
								sttb_returcabang.intquantity sttb_returcabang_qty
							from 
							barang 
							left join
							(select 
								nota_detail.intid_barang, sum(nota_detail.intquantity) intquantity
								from 
									nota, nota_detail
								where
									nota.intid_nota = nota_detail.intid_nota
									and nota.intid_week = $intid_week
									and nota.intid_cabang = $intid_cabang
									and year(nota.datetgl) = $inttahun
									and nota.is_dp = 0
									and nota.is_arisan = 0
									group by nota_detail.intid_barang
								) nota
							on barang.intid_barang = nota.intid_barang
							(select
								nota_detail_hadiah.intid_barang, sum(nota_detail_hadiah.intquantity) intquantity
								from
									nota_hadiah, nota_detail_hadiah
								where
									nota_hadiah.intid_nota = nota_detail_hadiah.intid_nota
									and nota_hadiah.intid_cabang = $intid_cabang
									and nota_hadiah.intid_week = $intid_week
									and year(nota_hadiah.datetgl) = $inttahun 
									group by nota_detail_hadiah.intid_barang
								) nota_hadiah
								on barang.intid_barang = nota_detail_hadiah.intid_barang
							(select
								spkb_detail.intid_barang, sum(spkb_detail.quantity) intquantity
								from
									spkb, spkb_detail
								where
									spkb.no_spkb = spkb_detail.no_spkb
									and spkb.intid_cabang = $intid_cabang
									and spkb.week_sj = $intid_week
									and year(spkb.tgl_kirim) = $inttahun
									spkb.terkirim = 1
									group by spkb_detail.intid_barang
								) surat_jalan_reguler
								on barang.intid_barang = surat_jalan_reguler.intid_barang
							(select 
								sttb_sparepart_detail.intid_barang, sum(sttb_sparepart_detail.qty) intquantity
								from
									sttb_sparepart, sttb_sparepart_detail
								where
									sttb_sparepart.no_sj_sparepart =  sttb_sparepart_detail.no
									and sttb_sparepart.intid_cabang = $intid_cabang
									and sttb_sparepart.week_sj = $intid_week
									and year(sttb_sparepart.tgl_kirim) = $inttahun
									and sttb_sparepart.terkirim = 1
								group by sttb_sparepart_detail.intid_barang
								) surat_jalan_sparepart
								on barang.intid_barang = surat_jalan_sparepart.intid_barang
							(select 
								sttb_detail.intid_barang, sum(sttb_detail.quantity) intquantity
								from
									sttb, sttb_detail
								where
									sttb.no_sttb	=sttb_detail.no_sttb
									and sttb.intid_cabang_kirim = $intid_cabang
									and sttb.week = $intid_week
									and year(sttb.tgl_kirim) = $inttahun
									and sttb.terkirim = 1
								group by sttb_detail.intid_barang
								) surat_jalan_returcabang
								on barang.intid_barang = surat_jalan_returcabang.intid_barang
							(select
								retur_detail_.intid_barang, sum(retur_detail_.quantity) intquantity
								from 
									retur_, retur_detail_
								where
									retur_.no_srb = retur_detail_.no_srb
									and retur_.intid_cabang = $intid_cabang
									and retur_.intid_week_verified = $intid_week
									and year(retur_.datetgl) = $inttahun
									and (retur_.no_sttb is not null or retur_.no_sttb != '')
								group by retur_detail_.intid_barang
								) sttb_returcabang
							where
								barang.status_barang = 1";
		return $this->db->query($select);
	}
	//
	function selectGetStockBarangStart($intid_cabang = 0, $date_start = "", $date_end = "")
	{
		$select	=	"select
								barang.*,
								nota.intquantity nota_qty,
								nota_hadiah.intquantity nota_hadiah_qty,
								surat_jalan_reguler.intquantity surat_jalan_reguler_qty,
								surat_jalan_sparepart.intquantity surat_jalan_sparepart_qty,
								surat_jalan_returcabang.intquantity surat_jalan_returcabang_qty,
								sttb_returcabang.intquantity sttb_returcabang_qty
							from 
							barang 
							left join
							(select 
								nota_detail.intid_barang, sum(nota_detail.intquantity) intquantity
								from 
									nota, nota_detail
								where
									nota.intid_nota = nota_detail.intid_nota
									and nota.intid_cabang = $intid_cabang
									and nota.datetgl >= '$date_start'
									and nota.datetgl <= '$date_end'
									and nota.is_dp = 0
									and nota.is_arisan = 0
									group by nota_detail.intid_barang
								) nota
							on barang.intid_barang = nota.intid_barang
							(select
								nota_detail_hadiah.intid_barang, sum(nota_detail_hadiah.intquantity) intquantity
								from
									nota_hadiah, nota_detail_hadiah
								where
									nota_hadiah.intid_nota = nota_detail_hadiah.intid_nota
									and nota_hadiah.intid_cabang = $intid_cabang
									and nota_hadiah.datetgl >= '$date_start'
									and nota_hadiah.datetgl <= '$date_end' 
									group by nota_detail_hadiah.intid_barang
								) nota_hadiah
								on barang.intid_barang = nota_detail_hadiah.intid_barang
							(select
								spkb_detail.intid_barang, sum(spkb_detail.quantity) intquantity
								from
									spkb, spkb_detail
								where
									spkb.no_spkb = spkb_detail.no_spkb
									and spkb.intid_cabang = $intid_cabang
									and spkb.tgl_kirim >= '$date_start'
									and spkb.tgl_kirim <= '$date_end'
									spkb.terkirim = 1
									group by spkb_detail.intid_barang
								) surat_jalan_reguler
								on barang.intid_barang = surat_jalan_reguler.intid_barang
							(select 
								sttb_sparepart_detail.intid_barang, sum(sttb_sparepart_detail.qty) intquantity
								from
									sttb_sparepart, sttb_sparepart_detail
								where
									sttb_sparepart.no_sj_sparepart =  sttb_sparepart_detail.no
									and sttb_sparepart.intid_cabang = $intid_cabang
									and sttb_sparepart.tgl_kirim >= '$date_start'
									and sttb_sparepart.tgl_kirim <= '$date_end'
									and sttb_sparepart.terkirim = 1
								group by sttb_sparepart_detail.intid_barang
								) surat_jalan_sparepart
								on barang.intid_barang = surat_jalan_sparepart.intid_barang
							(select 
								sttb_detail.intid_barang, sum(sttb_detail.quantity) intquantity
								from
									sttb, sttb_detail
								where
									sttb.no_sttb	=sttb_detail.no_sttb
									and sttb.intid_cabang_kirim = $intid_cabang
									and sttb.tgl_kirim >= '$date_start'
									and sttb.tgl_kirim <= '$date_end'
									and sttb.terkirim = 1
								group by sttb_detail.intid_barang
								) surat_jalan_returcabang
								on barang.intid_barang = surat_jalan_returcabang.intid_barang
							(select
								retur_detail_.intid_barang, sum(retur_detail_.quantity) intquantity
								from 
									retur_, retur_detail_
								where
									retur_.no_srb = retur_detail_.no_srb
									and retur_.datetgl >= '$date_start'
									and retur_.datetgl <= '$date_end'
									and year(retur_.datetgl) = $inttahun
									and (retur_.no_sttb is not null or retur_.no_sttb != '')
								group by retur_detail_.intid_barang
								) sttb_returcabang
							where
								barang.status_barang = 1";
		return $this->db->query($select);
	}
	//end stock report model
	
}
?>
