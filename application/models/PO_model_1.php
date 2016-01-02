<?php
	class PO_Model_1 extends CI_Model {
		var $table = "po_";
		function getPO($no)
		{
			$select	=	"select po_detail_.*,barang.strnama from po_detail_,barang where barang.intid_barang = po_detail_.intid_barang and po_detail_.no_po = '".$no."'";
			return $this->db->query($select);
		}
		function get_barang(){
			 $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1'); 
				/* $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and CURDATE() BETWEEN harga.date_start and harga.date_end '); */
			return $query->result();
		}
		function get_barangVal($val){
			 $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and barang.strnama like "'.$val.'%"'); 
				/* $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and CURDATE() BETWEEN harga.date_start and harga.date_end '); */
			return $query->result();
		}
		
		/**
		* @param get_barang_po
		*/
		function get_barang_po($id = 0)
		{
			if($id == 0)
			{
			 $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and intid_jbarang != 8 and is_po = 1'); 
				/* $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and CURDATE() BETWEEN harga.date_start and harga.date_end '); */
			}
			else
			{
				 $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and intid_jbarang != 8 and is_po = 1 and barang.intid_barang = '.$id.''); 
			}
			return $query->result();
		}
		//end
		
		/**
		* @param get_barang_po
		*/
		function get_barang_po_autocomplete($val = null)
		{
			$select = "";
			if($val != null)
			{
				/* $select = 'select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and intid_jbarang != 8 and is_po = 1 and barang.strnama like "'.$val.'%"';
				*/ 
				
				//dirubah efan 24-06-2015 --> agar ga bisa di po cabang, tapi tetep bisa di inpput bizpark
				$select = 'select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join (select * from harga WHERE CURDATE() BETWEEN harga.date_start AND harga.date_end) harga on harga.intid_barang = barang.intid_barang 
				where CURDATE() BETWEEN barang.tanggal_awal AND barang.tanggal_akhir 
				AND barang.status_barang = 1 and intid_jbarang != 8 and barang.strnama like "'.$val.'%"';
			}
			$query	=	$this->db->query($select); 
			return $query->result();
		}
		//end
		
		/* barang untuk pengeluaran merchandise */
		/* ikhlas firlana ifirana@gmail.com 2014 08 21 */
		
		function get_barang_merchandise(){
			 $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang
				left join harga on harga.intid_barang = barang.intid_barang, merchandise where 
				merchandise.intid_barang = barang.intid_barang');
				/* $query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1 and CURDATE() BETWEEN harga.date_start and harga.date_end '); */
			return $query->result();
		}
		/* end  barang untuk pengeluaran merchandise*/
		
		/* barang untuk pengeluaran merchandise */
		/* ikhlas firlana ifirana@gmail.com 2015 05 10 */
		
		function get_barang_merchandise_autocomplete($val = null){
			$select = "";
			if($val != null)
			{
				$select = 'select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang
				left join harga on harga.intid_barang = barang.intid_barang, merchandise where 
				merchandise.intid_barang = barang.intid_barang and barang.strnama like "'.$val.'%"';
			}
			$query	=	$this->db->query($select);
			return $query->result();
		}
		/* end  barang untuk pengeluaran merchandise*/
		
		function get_barang_komplain(){
			$query	=	$this->db->query('select upper(barang.strnama) strnama, barang.intid_barang intid, harga.* from barang 
				left join harga on harga.intid_barang = barang.intid_barang where barang.status_barang = 1');
			return $query->result();
		}
		function get_nopo($id,$week,$ket){
			$var = "";
				$query = $this->db->query('select id from counter_ where keterangan = "'.$ket.'"');
				$check0  = $query->result();
				
				$data = array(
					   'id' => $check0[0]->id +1
					);
				$this->db->where('keterangan',$ket);
				$this->db->update('counter_', $data); 
				
				$query = $this->db->query('select id from counter_ where keterangan = "'.$ket.'"');
				$check  = $query->result();
				
				$var = $check[0]->id.'/'.$week.'/'.$id.'/'.strtoupper($ket).'/'.date('m').'/'.date('Y');
				return $var;
			}
		function insert_DataPO($var,$data){
			$table = "";
				if($var == 1){
					$table = "po_";
					}else{
						$table = "po_detail_";
						}
					$this->db->insert($table,$data);
			}
		function insert_DataPO_copy($var,$data){
			$table = "";
				if($var == 1){
					$table = "_po";
					}else{
						$table = "_po_details";
						}
					$this->db->insert($table,$data);
			}
		function insert_DataRetur($var,$data){
			$table = "";
				if($var == 1){
					$table = "retur_";
					}else{
						$table = "retur_detail_";
						}
					$this->db->insert($table,$data);
			}	
		function insert_DataRetur_copy($var,$data){
			$table = "";
				if($var == 1){
					$table = "_sj";
					}else{
						$table = "_sj_details";
						}
					$this->db->insert($table,$data);
			}	
		function DataPO(){
			$query = $this->db->query('select pod.*,
									  b.strnama,
									  (select strnama_cabang 
									   	from cabang c inner join po_ po on po.intid_cabang = c.intid_cabang where po.no_po = pod.no_po group by c.intid_cabang) strnama_cabang,
									  (select time 
									   	from  po_ po where po.no_po = pod.no_po group by po.no_po) timeNow,
									  b.intid_jsatuan
									  from po_detail_ pod inner join barang b on b.intid_barang = pod.intid_barang  
									  where pod.no_po = (select max(po.no_po) no_po
							 			from po_ po) order by b.strnama asc');
			return $query->result();
			}
		function check_po_week($intid_cabang,$intid_week){
			$query2	=	$this->db->query('select count(*) cek from po_ po where po.intid_cabang = "'.$intid_cabang.'" and po.intid_week = "'.$intid_week.'"');
			$cek = $query2->result();
			return $cek[0]->cek;
			}
		function selectWeek(){
			//$thn = date('Y');
			$query = $this->db->query("select intid_week from week where curdate() between dateweek_start and dateweek_end");
			return $query->result();
			}
		function OpenDB($query){
			return $this->db->query($query);
			}
		
		function pengecekanSPKB($no_spkb){
			$query = $this->db->query('select count(*) nomor from spkb where no_spkb = "'.$no_spkb.'"');
			$no = $query->result();
			return $no[0]->nomor;
			}
		///fungsi yang baru
		//line ikhlas 03042013 masih banyak yang diperbaiki
		//pa perlu di buat intquantity_skrg untuk mengurangi penjumalahan sebelumnya
		/*
		function getLap_Stok_cab_2($intid_cabang, $week){
	
			$weekbefore = $week-1;
			$query = $this->db->query('select barang.strnama,
									  		barang.intid_barang,
											barang.intid_jsatuan, 
											barang_masuk_before.jum_barang_masuk_before, 
											barang_keluar_before.jum_barang_keluar_before, 
											barang_masuk_after.jum_barang_masuk_after, 
											barang_keluar_after.jum_barang_keluar_after,
											barang_keluar_hadiah_after.jum_barang_keluar_hadiah_after,
											stok_barang.jumlah 
									  from
									  barang left join
									  (select sum(intquantity) jum_barang_keluar_before, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week <= "'.$weekbefore.'"
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang limit 0,1) group by nd.intid_barang
										  )as barang_keluar_before
									  on barang_keluar_before.intid_barang = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_before, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week <= "'.$weekbefore.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_before
									   on barang_masuk_before.intid_barang = barang.intid_barang
									   left join
									  (select sum(intquantity) jum_barang_keluar_after, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week = "'.$week.'"
										  and n.is_dp = 0
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by nd.intid_barang
										  )as barang_keluar_after
									  on barang_keluar_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(ndh.intquantity) jum_barang_keluar_hadiah_after, ndh.intid_barang 
										   from 
										   nota_hadiah nh inner join nota_detail_hadiah ndh on ndh.intid_nota = nh.intid_nota 
										   where nh.intid_cabang = "'.$intid_cabang.'"
										   and nh.intid_week = "'.$week.'"
										   and nh.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by nh.intid_barang
										   )as barang_keluar_hadiah_after
									  on barang_keluar_hadiah_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_after, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week = "'.$week.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_after
									   on barang_masuk_after.intid_barang = barang.intid_barang
									   left join 
									   (select *
											from 
											stok_barang
											where intid_cabang = "'.$intid_cabang.'"
											)as stok_barang
									   on stok_barang.intid_barang = barang.intid_barang
									  order by barang.strnama asc
									  ');
			return $query->result();
		}*/
		
		function getLap_Stok_cab_2($intid_cabang, $week){
			$query0 = $this->db->query("select date(as_of_date) start from stok_barang where intid_cabang = '".$intid_cabang."' limit 0,1 ");
			$hasil0 = $query0->result();
			$weekbefore = $week-1;
			$query1 = $this->db->query("select dateweek_end from week where intid_week = ".$weekbefore."");
			$hasil1 = $query1->result();
			if($hasil0[0]->start >= $hasil1[0]->dateweek_end){
				$weekbefore = 0 ;
			} else{
				//Do Nothing
			}
			$query = $this->db->query('select barang.strnama,
									  		barang.intid_barang,
											barang.intid_jsatuan, 
											barang_masuk_before.jum_barang_masuk_before, 
											barang_keluar_before.jum_barang_keluar_before, 
											barang_masuk_after.jum_barang_masuk_after, 
											barang_keluar_after.jum_barang_keluar_after,
											barang_keluar_hadiah_after.jum_barang_keluar_hadiah_after,
											stok_barang.set_fisik, 
											stok_barang.pcs_fisik 
									  from
									  barang left join
									  (select sum(intquantity) jum_barang_keluar_before, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week <= "'.$weekbefore.'"
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang limit 0,1) group by nd.intid_barang
										  )as barang_keluar_before
									  on barang_keluar_before.intid_barang = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_before, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week <= "'.$weekbefore.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_before
									   on barang_masuk_before.intid_barang = barang.intid_barang
									   left join
									  (select sum(intquantity) jum_barang_keluar_after, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week = "'.$week.'"
										  and n.is_dp = 0
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by nd.intid_barang
										  )as barang_keluar_after
									  on barang_keluar_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(ndh.intquantity) jum_barang_keluar_hadiah_after, ndh.intid_barang 
										   from 
										   nota_hadiah nh inner join nota_detail_hadiah ndh on ndh.intid_nota = nh.intid_nota 
										   where nh.intid_cabang = "'.$intid_cabang.'"
										   and nh.intid_week = "'.$week.'"
										   and nh.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by ndh.intid_barang
										   )as barang_keluar_hadiah_after
									  on barang_keluar_hadiah_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_after, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week = "'.$week.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_after
									   on barang_masuk_after.intid_barang = barang.intid_barang
									   left join 
									   (select *
											from 
											stok_barang
											where intid_cabang = "'.$intid_cabang.'"
											)as stok_barang
									   on stok_barang.intid_barang = barang.intid_barang
									  order by barang.strnama asc
									  ');
			return $query->result();
		}
		function selectWeek2($intid_cabang)
		{
		$query2 = $this->db->query("select as_of_date from stok_barang where intid_cabang = '".$intid_cabang."' limit 0,1");
		$hasil = $query2->result();
			if(isset($hasil[0]->as_of_date)){
				$temp = $hasil[0]->as_of_date;
			}else{
				$temp = "";
			}
			$query = $this->db->query("select id, intid_week 
									  from week 
									  where dateweek_start > date_format('".$temp."', '%Y-%m-%d')");
			return $query->result();
		}
		//POCO/lookup2
		function get_PO_cabang($intid_cabang){
			$query = $this->db->query("select po.*,po.time waktu,
																		c.strnama_cabang 
																		from po_ po inner join cabang c on c.intid_cabang = po.intid_cabang 
																		where po.intid_cabang = ".$intid_cabang." and
																		po.is_sj = 0
																		order by time desc");
			return $query->result();
		}
		
		//POCO/lookup2
		function get_PO_cabang_tanpa_verified($intid_cabang){
			$query = $this->db->query("select po.*,po.time waktu,
																		c.strnama_cabang 
																		from po_ po inner join cabang c on c.intid_cabang = po.intid_cabang 
																		where 
																		po.intid_cabang = ".$intid_cabang." 
																		and (po.is_verified = 1)  
																		and po.is_sj = 0
																		order by time desc");
			return $query->result();
		}
		
		//POCO/lookup2
		function get_PO_cabang_verified($intid_cabang){
			$query = $this->db->query("select po.*,po.time waktu,
																		c.strnama_cabang 
																		from po_ po inner join cabang c on c.intid_cabang = po.intid_cabang 
																		where 
																		po.intid_cabang = ".$intid_cabang." 
																		and (po.is_verified = 2 or po.is_verified = 0) 
																		and po.is_sj = 0
																		order by time desc");
			return $query->result();
		}
		
		
		//POCO/SJ_INSERT_SEARCH
		function SPKB_SJ_SEARCH($varcabang,$halaman,$limit){
			$query = $this->db->query('select spd.no_spkb, 
										spd.time waktu,
									  cabang.strnama_cabang 
									  from spkb spd inner join cabang on cabang.intid_cabang = spd.intid_cabang 
									  where (spd.no_sj = "" or spd.no_sj is NULL) 
									  and cabang.strnama_cabang like "'.$varcabang.'"
									  order by spd.time desc
									  limit '.$halaman.','.$limit.' ');
			return $query;
			}
		function SPKB_SJ($halaman,$limit){
			/* $query = $this->db->query('select spd.no_spkb, spd.time waktu,
									  (select strnama_cabang from cabang where intid_cabang = spd.intid_cabang) strnama_cabang 
									  from spkb spd where (spd.no_sj = "" or spd.no_sj is NULL) order by spd.time desc limit '.$halaman.','.$limit.''); */
									 //by fahmi 30 januari 2015
				$query = $this->db->query('select spd.no_spkb, spd.time waktu, cabang.strnama_cabang
									  #(select strnama_cabang from cabang where intid_cabang = spd.intid_cabang) strnama_cabang 
									  from spkb spd INNER JOIN cabang on cabang.intid_cabang = spd.intid_cabang
									  where (spd.no_sj = "" or spd.no_sj is NULL) and year(spd.time) = year(curdate()) order by spd.time desc limit '.$halaman.','.$limit.'');
			return $query;
			}
		function STTB_SJ($halaman,$limit,$where = ""){
			$query = $this->db->query('select spd.no_sttb, spd.waktu,
									  (select strnama_cabang from cabang where intid_cabang = spd.intid_cabang) strnama_cabang 
									  from sttb spd where (spd.no_sj = "" or spd.no_sj is NULL) and spd.is_kill != 1 and year(spd.waktu) = year(curdate())  '.$where.' order by spd.waktu desc limit '.$halaman.','.$limit.'');
			return $query;
			}
		function STTB_SJ_SEARCH($varcabang,$halaman,$limit){
			$query = $this->db->query('select spd.no_sttb, 
										spd.waktu,
									  cabang.strnama_cabang 
									  from sttb spd inner join cabang on cabang.intid_cabang = spd.intid_cabang 
									  where (spd.no_sj = "" or spd.no_sj is NULL) and spd.is_kill != 1 and year(spd.waktu) = year(curdate())
									  and cabang.strnama_cabang like "'.$varcabang.'"
									  order by spd.waktu desc
									  limit '.$halaman.','.$limit.' ');
			return $query;
			}
		/* function STTB_SJ_UPDATE_KILL($no){
			$query = $this->db->query('update sttb set is_kill = 1 where no_sttb = "'.$no.'" ');
			return $query;
		} */
		/*
		function get_list_data_retur($offset = 0, $id_cabang)
			{
				if($offset==""){ $offset=0; }		
			
			//	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang ORDER BY a.no_srb ASC  LIMIT $offset,$limit");
				$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang ORDER BY a.no_srb ASC");
				return $query;
			}
		*/
		function get_list_data_retur($offset = 0, $id_cabang = 0, $filter = "")
			{
				if($offset==""){ $offset=0; }		
				if(isset($filter['cari'])){ $filter['cari'] = $filter['cari']; }else{ $filter['cari'] = "";}		
			
			//	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang ORDER BY a.no_srb ASC  LIMIT $offset,$limit");
				if($_POST){
				if($id_cabang == 1){
					$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
						where 
						 (no_srb like '%".$filter['cari']."%' or datetgl like '".$filter['cari']."' or cabang.strnama_cabang like '".$filter['cari']."')
						ORDER BY a.no_srb DESC");
					}else{
					$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
						where 
						cabang.intid_cabang = $id_cabang 
						and (no_srb like '%".$filter['cari']."%' or datetgl like '".$filter['cari']."')
						ORDER BY a.no_srb DESC");
						}
				}else{
				if($id_cabang == 1){
					$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							where 
							 date(a.datetgl) = '".date('Y-m-d')."'
							ORDER BY a.no_srb DESC");
					}else{
						$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_ a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							where 
							cabang.intid_cabang = $id_cabang 
							and date(a.datetgl) = '".date('Y-m-d')."'
							ORDER BY a.no_srb DESC");
							}
					}
				return $query;
			}
		
		
		function countDataRetur()
			{
				return $this->db->count_all('retur_');
			}
			
		///tgl06 agustus 2013 untuk membuktikan laporan model sudah berbeda dengan fungsi yang disimpan ini
		//tgl 14 agustus 2013 sudah diubah lagi oleh ikhlas, untuk memperbaiki kesalahan tanggal kemarin
		function get_CetakPenjualanBulanan_lama($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select 
					X.intid_dealer, 
					sum(X.omsett) omsett, 
					sum(X.omsetm) omsetm, sum(X.omsettc)omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select  
						(select sum(if (nota.inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(nota.inttotal_omset =0, 0, nota.intvoucher))
							from nota
							where nota.intid_week in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan = $jpenjualan
							and nota.is_dp = 0
							and nota.is_arisan = 0
							and nota.intid_nota = a.intid_nota) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week  in (select intid_week from week where intbulan = $month)
						and nota.intid_cabang = $cabang
						and nota.intid_jpenjualan =  $jpenjualan
						and nota_detail.is_free = 0
						and barang.intid_jbarang=1
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsett,
						(select sum(if (nota.inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(nota.inttotal_omset =0, 0, nota.intvoucher))
							from nota
							where nota.intid_week in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan = $jpenjualan
							and nota.is_dp = 0
							and nota.is_arisan = 0
							and nota.intid_nota = a.intid_nota) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week  in (select intid_week from week where intbulan = $month)
						and nota.intid_cabang = $cabang
						and nota.intid_jpenjualan =  $jpenjualan
						and nota_detail.is_free = 0
						and barang.intid_jbarang=2
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsetm,
						(select sum(if (nota.inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(nota.inttotal_omset =0, 0, nota.intvoucher))
								from nota
								where nota.intid_week in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan = $jpenjualan
								and nota.is_arisan = 0
								and nota.intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=3
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=5
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=6
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetll,
							m.strnama_dealer, 
							m.strnama_upline,
							m.intid_dealer,
							cb.strnama_cabang, 
							u.strnama_unit,
							' ' AS dateend, ' ' AS datestart, 
							' ' AS intid_week, 
							(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
							a.intid_jpenjualan,
							a.intpv,
							a.inttotal_omset,
							a.inttotal_bayar,
							a.intkomisi10,
							a.intkomisi20
						from nota a inner join nota_detail b on 
									a.intid_nota = b.intid_nota 
								inner join barang c on 
									b.intid_barang = c.intid_barang
								inner join member m on 
									m.intid_dealer = a.intid_dealer 
								inner join unit u on 
									u.intid_unit = a.intid_unit
								inner join cabang cb on 
									cb.intid_cabang = a.intid_cabang
						where  a.intid_week  in (select intid_week from week where intbulan = $month)
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan = $jpenjualan
						and b.is_free = 0
						and a.is_arisan = 0
						and a.is_dp = 0 group by a.intid_nota) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and 
										is_arisan = 0
										and is_dp = 0
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
		INNER JOIN 
				(SELECT * FROM 
					(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
					FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
					INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
					WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and is_arisan = 0
									and is_dp = 0
										AND intid_cabang = $cabang
					GROUP BY intid_dealer, intid_jbarang) AS asd 
				WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        return $query->result();
	}
		function get_CetakPenjualanBulanan2($month, $cabang, $jpenjualan){
			$select = "select X.intid_dealer, 
							X.omsett, 
							X.omsetm, 
							X.omsettc, 
							X.omsetlg,
							X.omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, 
							X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							X.intkomisi10, 
							X.intkomisi20, 
							X.intpv, 
							X.inttotal_bayar,
							X.inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							X.tradein_t,
							X.tradein_m
							from (
							select 
								(select sum(if(nota.inttotal_omset = 0,0,(nota_detail.intquantity*nota_detail.intharga))) 
									from nota 
										inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
										inner join barang on barang.intid_barang = nota_detail.intid_barang
											where 
												nota.intid_nota = n.intid_nota and
												barang.intid_jbarang = 1
										group by nota.intid_nota
									) omsett,
									(select sum(if(nota.inttotal_omset = 0,0,(nota_detail.intquantity*nota_detail.intharga))) 
									from nota 
										inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
										inner join barang on barang.intid_barang = nota_detail.intid_barang
											where 
												nota.intid_nota = n.intid_nota and
												barang.intid_jbarang = 2
										group by nota.intid_nota
									) omsetm,
									(select sum(if(nota.inttotal_omset = 0,0,(nota_detail.intquantity*nota_detail.intharga))) 
									from nota 
										inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
										inner join barang on barang.intid_barang = nota_detail.intid_barang
											where 
												nota.intid_nota = n.intid_nota and
												barang.intid_jbarang = 3
										group by nota.intid_nota
									) omsettc,
									(select sum(if(nota.inttotal_omset = 0,0,(nota_detail.intquantity*nota_detail.intharga))) 
									from nota 
										inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
										inner join barang on barang.intid_barang = nota_detail.intid_barang
											where 
												nota.intid_nota = n.intid_nota and
												barang.intid_jbarang = 5
										group by nota.intid_nota
									) omsetlg,
									(select sum(if(nota.inttotal_omset = 0,0,(nota_detail.intquantity*nota_detail.intharga))) 
									from nota 
										inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
										inner join barang on barang.intid_barang = nota_detail.intid_barang
											where 
												nota.intid_nota = n.intid_nota and
												barang.intid_jbarang = 6
										group by nota.intid_nota
									) omsetll,
									(SELECT SUM(nota_detail.intharga * nota_detail.intquantity * (1 - (nota.inttrade_in * 0.01))) AS hasil
										FROM 
											`nota` 
											INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
											INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
										WHERE 
											barang.intid_jbarang = 1 and
											nota.intid_nota = n.intid_nota
										GROUP BY nota.intid_nota
									) tradein_t,
									(SELECT SUM(nota_detail.intharga * nota_detail.intquantity * (1 - (nota.inttrade_in * 0.01))) AS hasil
										FROM 
											`nota` 
											INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
											INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
										WHERE 
											barang.intid_jbarang = 2 and
											nota.intid_nota = n.intid_nota
										GROUP BY nota.intid_nota
									) tradein_m,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								c.strnama_cabang, 
								u.strnama_unit,
								n.intkomisi10, 
								n.intkomisi20, 
								n.intpv, 
								n.inttotal_bayar,
								n.inttotal_omset, 
								j.strnama_jpenjualan, 
								n.intid_jpenjualan,
								'' AS intid_week
								from nota n
									inner join nota_detail nd on nd.intid_nota = n.intid_nota
									inner join member m on m.intid_dealer = n.intid_dealer
									inner join unit u on u.intid_unit = n.intid_unit
									inner join cabang c on c.intid_cabang = n.intid_nota
									inner join jenis_penjualan j on j.intid_jpenjualan = n.intid_jpenjualan
								where
									n.is_dp = 0 and 
									n.is_arisan = 0 and
									n.intid_week in (select intid_week from week where intbulan = $month) and 
									n.intid_jpenjualan = $jpenjualan and
									n.intid_cabang = $cabang
								group by n.intid_nota
							) AS X
							";
			$query =  $this->db->query($select);
			return $query->result();
		}
	//tanggal diubah 14 agustus 2013 10:11am oleh ikhlas firlana
	/*
	function get_CetakPenjualanMingguan($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select X.intid_dealer, sum(X.omsett) omsett, sum(X.omsetm) omsetm, sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select  
						(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
							from nota
							where intid_week = $week
							and intid_cabang = $cabang
							and intid_jpenjualan = $jpenjualan
							and is_arisan = 0
							and intid_nota = a.intid_nota) 
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=1
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsett,
						(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
						from nota
						where intid_week = $week
						and intid_cabang = $cabang
						and intid_jpenjualan = $jpenjualan
						and is_arisan = 0
						and intid_nota = a.intid_nota) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week = $week
						and nota.intid_cabang = $cabang
						and nota.intid_jpenjualan =  $jpenjualan
						and nota_detail.is_free = 0
						and barang.intid_jbarang=2
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsetm,
						(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
								from nota
								where intid_week = $week
								and intid_cabang = $cabang
								and intid_jpenjualan = $jpenjualan
								and is_arisan = 0
								and intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=3
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) as omsettc,
							(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
								from nota
								where intid_week = $week
								and intid_cabang = $cabang
								and intid_jpenjualan = $jpenjualan
								and is_arisan = 0
								and intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=5
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetlg, 
							(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
								from nota
								where intid_week = $week
								and intid_cabang = $cabang
								and intid_jpenjualan = $jpenjualan
								and is_arisan = 0
								and intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=6
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetll,
							m.strnama_dealer, 
							m.strnama_upline,
							m.intid_dealer,
							cb.strnama_cabang, 
							u.strnama_unit,
							'".$week."' AS dateend, '".$week."' AS datestart, 
							a.intid_week, 
							(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
							a.intid_jpenjualan,
							a.intpv,
							a.inttotal_omset,
							a.inttotal_bayar,
							a.intkomisi10,
							a.intkomisi20
						from nota a inner join nota_detail b on 
									a.intid_nota = b.intid_nota 
								inner join barang c on 
									b.intid_barang = c.intid_barang
								inner join member m on 
									m.intid_dealer = a.intid_dealer 
								inner join unit u on 
									u.intid_unit = a.intid_unit
								inner join cabang cb on 
									cb.intid_cabang = a.intid_cabang
						where  a.intid_week = $week
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan = $jpenjualan
						and b.is_free = 0
						and a.is_dp = 0 group by a.intid_nota) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
			GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
	WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan 
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
	}*/
	function get_CetakPenjualanBulanan3($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select X.intid_dealer, sum(X.omsett) omsett, sum(X.omsetm) omsetm, sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week  in (select intid_week from week where intbulan = $month) order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week  in (select intid_week from week where intbulan = $month) order by intid_week DESC  limit 0,1)AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select  
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
							from nota
							where intid_week  in (select intid_week from week where intbulan = $month)
							and intid_cabang = $cabang
							and intid_jpenjualan = $jpenjualan
							and is_arisan = 0
							and a.is_dp = 0
							and a.is_arisan = 0
							and intid_nota = a.intid_nota) 
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=1
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsett,
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
						from nota
						where intid_week  in (select intid_week from week where intbulan = $month)
						and intid_cabang = $cabang
						and intid_jpenjualan = $jpenjualan
						and is_arisan = 0
						and a.is_dp = 0
						and a.is_arisan = 0
						and intid_nota = a.intid_nota) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week  in (select intid_week from week where intbulan = $month)
						and nota.intid_cabang = $cabang
						and nota.intid_jpenjualan =  $jpenjualan
						and nota_detail.is_free = 0
						and barang.intid_jbarang=2
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsetm,
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
								from nota
								where intid_week  in (select intid_week from week where intbulan = $month)
								and intid_cabang = $cabang
								and intid_jpenjualan = $jpenjualan
								and is_arisan = 0
								and a.is_dp = 0
								and a.is_arisan = 0
								and intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=3
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=5
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=6
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetll,
							m.strnama_dealer, 
							m.strnama_upline,
							m.intid_dealer,
							cb.strnama_cabang, 
							u.strnama_unit,
							'".$month."' AS dateend, '".$month."' AS datestart, 
							a.intid_week, 
							(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
							a.intid_jpenjualan,
							a.intpv,
							a.inttotal_omset,
							a.inttotal_bayar,
							a.intkomisi10,
							a.intkomisi20
						from nota a inner join nota_detail b on 
									a.intid_nota = b.intid_nota 
								inner join barang c on 
									b.intid_barang = c.intid_barang
								inner join member m on 
									m.intid_dealer = a.intid_dealer 
								inner join unit u on 
									u.intid_unit = a.intid_unit
								inner join cabang cb on 
									cb.intid_cabang = a.intid_cabang
						where  a.intid_week  in (select intid_week from week where intbulan = $month)
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan = $jpenjualan
						and b.is_free = 0
						and a.is_dp = 0
						and a.is_arisan = 0 group by a.intid_nota) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan
			GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
	WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan 
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
	}
	//tgl 16 agustus 2013
	function get_CetakPenjualanMingguan_lama($week, $cabang, $jpenjualan)
	{
	/*
		select X.intid_dealer, 
							sum(X.omsett) omsett, 
							sum(X.omsetm) omsetm, 
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v, 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						Z.intpv,
						Z.inttotal_omset,
						Z.inttotal_bayar,
						Z.intkomisi10,
						Z.intkomisi20
						from 
						(select  
							(select sum( nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select sum( nota_detail.intquantity*nota_detail.intharga)
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer
	*/
		$query = $this->db->query("select X.intid_dealer, sum(X.omsett) omsett, sum(X.omsetm) omsetm, sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select  
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
							from nota
							where intid_week = $week
							and intid_cabang = $cabang
							and intid_jpenjualan = $jpenjualan
							and is_arisan = 0
							and a.is_dp = 0
							and a.is_arisan = 0
							and intid_nota = a.intid_nota) 
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=1
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsett,
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
						from nota
						where intid_week = $week
						and intid_cabang = $cabang
						and intid_jpenjualan = $jpenjualan
						and is_arisan = 0
						and a.is_dp = 0
						and a.is_arisan = 0
						and intid_nota = a.intid_nota) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week = $week
						and nota.intid_cabang = $cabang
						and nota.intid_jpenjualan =  $jpenjualan
						and nota_detail.is_free = 0
						and barang.intid_jbarang=2
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsetm,
						(select sum( if(inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
								from nota
								where intid_week = $week
								and intid_cabang = $cabang
								and intid_jpenjualan = $jpenjualan
								and is_arisan = 0
								and a.is_dp = 0
								and a.is_arisan = 0
								and intid_nota = a.intid_nota) 
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=3
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=5
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=6
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota
							) AS omsetll,
							m.strnama_dealer, 
							m.strnama_upline,
							m.intid_dealer,
							cb.strnama_cabang, 
							u.strnama_unit,
							'".$week."' AS dateend, '".$week."' AS datestart, 
							a.intid_week, 
							(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
							a.intid_jpenjualan,
							a.intpv,
							a.inttotal_omset,
							a.inttotal_bayar,
							a.intkomisi10,
							a.intkomisi20
						from nota a inner join nota_detail b on 
									a.intid_nota = b.intid_nota 
								inner join barang c on 
									b.intid_barang = c.intid_barang
								inner join member m on 
									m.intid_dealer = a.intid_dealer 
								inner join unit u on 
									u.intid_unit = a.intid_unit
								inner join cabang cb on 
									cb.intid_cabang = a.intid_cabang
						where  a.intid_week = $week
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan = $jpenjualan
						and b.is_free = 0
						and a.is_dp = 0
						and a.is_arisan = 0 group by a.intid_nota) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
	}
	
	//end
	function get_periode($data){
			if(isset($data['week'])){
					$select = "select (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week =".$data['week'].") AS datestart, (select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = ".$data['week'].") AS dateend";
			}elseif(isset($data['month'])){
					$select = "select (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan =".$data['month']." order by intid_week asc limit 0,1) AS datestart, (select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = ".$data['month']." order by intid_week DESC limit 0,1) AS dateend";
			}
			$query = $this->db->query($select);
			return $query->result();
		}
	/*
		2 jan 2013
		desc : periode waktu yang sesuai dengan nota
	*/
	function get_periode_tahun($data){
			if(isset($data['week'])){
					$select = "select (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week =".$data['week'].") AS datestart, (select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = ".$data['week'].") AS dateend";
			}elseif(isset($data['month'])){
					if(isset($data['tahun'])){
						$select = "select 
											(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan =".$data['month']." and inttahun = ".$data['tahun']." order by intid_week asc limit 0,1) AS datestart, 
											(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = ".$data['month']." and inttahun = ".$data['tahun']." order by intid_week DESC limit 0,1) AS dateend";
						}else{
							$select = "select (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan =".$data['month']." order by intid_week asc limit 0,1) AS datestart, (select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = ".$data['month']." order by intid_week DESC limit 0,1) AS dateend";
						}
			}
			$query = $this->db->query($select);
			return $query->result();
		}	
	//tgl 19 agustus 2013
		function get_CetakPenjualanMingguan($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select X.intid_dealer, 
							sum(X.omsett) omsett, 
							sum(X.omsetm) omsetm, 
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
		}
	/*
		2 jan 2014
		ikhlas firlana ifirlana@gmail.com
		desc : perubahan ke bentuk tahun
	*/
		function get_CetakPenjualanMingguan_tahun($week, $cabang, $jpenjualan,$tahun)
	{
	/** 
	//	query yang akan dipasang
		select X.intid_dealer, 
							IF(sum(X.omsett) >= (sum(X.Vpiece) * -1), sum(X.omsett) + sum(X.Vpiece), IF(sum(X.omsetm) < sum(X.omsett) AND sum(X.omsettc) < sum(X.omsett) AND sum(X.omsett) < (sum(X.Vpiece) * -1), 0, sum(X.omsett))) AS omsett,
							IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) < (sum(X.Vpiece) * -1) AND sum(X.omsetm) >= (sum(X.Vpiece) * -1), sum(X.omsetm) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsetm) AND sum(X.omsettc) < sum(X.omsetm) AND sum(X.omsetm) < (sum(X.Vpiece) * -1), 0, sum(X.omsetm))) AS omsetm,
							IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) >= (sum(X.Vpiece) * -1), sum(X.omsettc) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsettc) AND sum(X.omsetm) < sum(X.omsettc) AND sum(X.omsettc) < (sum(X.Vpiece) * -1), 0, sum(X.omsettc))) AS omsettc, 
							sum(X.omsetlg) omsetlg,
							if(sum(X.omsetll) is null, 0,sum(X.omsetll)) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = 26 and inttahun = 2015) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = 26 and inttahun = 2015) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar)  + if(Y.undangan_nota_detail is null, 0,Y.undangan_nota_detail) + if(Y.undangan_nota is null, 0 , Y.undangan_nota) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m, 
							(select strnama_cabang from cabang where cabang.intid_cabang = 3) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						Z.is_omset,
						Z.Vpiece,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga)) - if(nota.is_vpromo = 1, nota.intvoucher,0)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = 26
								and nota.intid_cabang = 3
								and nota.intid_jpenjualan =  1
								and YEAR(nota.datetgl) =  2015
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = 26
							and nota.intid_cabang = 3
							and nota.intid_jpenjualan =  1
							and YEAR(nota.datetgl) =  2015
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									#and barang.intid_jbarang=6
									and barang.intid_jbarang in (6)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = 26
									and intid_cabang = 3
									and intid_jpenjualan = 1
									and YEAR(datetgl) =  2015
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									#and barang.intid_jbarang=6
									and barang.intid_jbarang in (9)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								 ) Vpiece,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = 1) as strnama_jpenjualan, 
								#diperbarui 05/03/2015
								(select is_omset from jenis_penjualan where intid_jpenjualan = 1) as is_omset, 
								#end
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = 26
							and a.intid_cabang = 3
							and a.intid_jpenjualan = 1
							and YEAR(a.datetgl) =  2015
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = 26 AND intid_jpenjualan = 1
										AND intid_cabang = 3 and YEAR(datetgl) =  2015
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = 26 AND intid_jpenjualan = 1 
										AND intid_cabang = 3 and YEAR(datetgl) =  2015
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
	LEFT JOIN
				(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (26)
						and nota.intid_cabang = 3
						and YEAR(nota.datetgl) =  2015
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_jpenjualan = 1
								and a.intid_week in (26)
								and a.intid_cabang = 3
								and YEAR(a.datetgl) =  2015
								and b.intvoucher !=0
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								 and a.intid_jpenjualan = 1
								and a.intid_week in (26)
								and a.intid_cabang = 3
								and YEAR(a.datetgl) =  2015
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit
						) Y
					ON X.intid_dealer = Y.intid_dealer
						group by X.intid_dealer
	*/
	/**
	select X.intid_dealer, 
							#sum(X.omsett) omsett, 
							#sum(X.omsetm) omsetm, 
							if(X.is_omset = 1, sum(X.omsett) , 0) omsett, 
							if(X.is_omset = 1, sum(X.omsetm) , 0) omsetm,
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							#if(sum(X.omsetll) is null, 0,sum(X.omsetll)) + Y. undangan_nota_detail + Y.undangan_nota omsetll,
							if(sum(X.omsetll) is null, 0,sum(X.omsetll)) + if(Y. undangan_nota_detail is null,0,Y. undangan_nota_detail) + if(Y.undangan_nota is null,0,Y.undangan_nota) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							#sum(X.inttotal_bayar)  + Y. undangan_nota_detail + Y.undangan_nota inttotal_bayar,
							sum(X.inttotal_bayar)  + if(Y.undangan_nota_detail is null, 0,Y.undangan_nota_detail) + if(Y.undangan_nota is null, 0 , Y.undangan_nota) inttotal_bayar,
							#sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m, 
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						Z.is_omset,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga)) - if(nota.is_vpromo = 1, nota.intvoucher,0)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									#and barang.intid_jbarang=6
									and barang.intid_jbarang in (6,9)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								#diperbarui 05/03/2015
								(select is_omset from jenis_penjualan where intid_jpenjualan = $jpenjualan) as is_omset, 
								#end
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
	LEFT JOIN
				(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in ($week)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and b.intvoucher !=0
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								 and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit
						) Y
					ON X.intid_dealer = Y.intid_dealer
						group by X.intid_dealer
	*/
		/* $query = $this->db->query("select X.intid_dealer, 
							sum(X.omsett) omsett, 
							sum(X.omsetm) omsetm, 
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer"); *//*
        $query = $this->db->query("select X.intid_dealer, 
							if(X.is_omset = 1,IF(sum(X.omsett) >= (sum(X.Vpiece) * -1), sum(X.omsett) + sum(X.Vpiece), IF(sum(X.omsetm) < sum(X.omsett) AND sum(X.omsettc) < sum(X.omsett) AND sum(X.omsett) < (sum(X.Vpiece) * -1), 0, sum(X.omsett))), 0) AS omsett,
							if(X.is_omset = 1,IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) < (sum(X.Vpiece) * -1) AND sum(X.omsetm) >= (sum(X.Vpiece) * -1), sum(X.omsetm) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsetm) AND sum(X.omsettc) < sum(X.omsetm) AND sum(X.omsetm) < (sum(X.Vpiece) * -1), 0, sum(X.omsetm))), 0) AS omsetm, 
							IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) >= (sum(X.Vpiece) * -1), sum(X.omsettc) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsettc) AND sum(X.omsetm) < sum(X.omsettc) AND sum(X.omsettc) < (sum(X.Vpiece) * -1), 0, sum(X.omsettc))) AS omsettc, 
							sum(X.omsetlg) omsetlg,
							if(sum(X.omsetll) is null, 0,sum(X.omsetll)) + if(Y. undangan_nota_detail is null,0,Y. undangan_nota_detail) + if(Y.undangan_nota is null,0,Y.undangan_nota) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar)  + if(Y.undangan_nota_detail is null, 0,Y.undangan_nota_detail) + if(Y.undangan_nota is null, 0 , Y.undangan_nota) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m, 
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						Z.is_omset,
						Z.Vpiece,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga)) - if(nota.is_vpromo = 1, nota.intvoucher,0)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang in (6)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								(select if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3 
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									#and barang.intid_jbarang=6
									and barang.intid_jbarang in (9)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								 ) Vpiece,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								(select is_omset from jenis_penjualan where intid_jpenjualan = $jpenjualan) as is_omset, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan AND is_dp = 0
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan  AND is_dp = 0
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
	LEFT JOIN
				(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in ($week)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and b.intvoucher !=0
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								 and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit
						) Y
					ON X.intid_dealer = Y.intid_dealer
						group by X.intid_dealer");
		return $query->result();
		penjualan minggian fhh
		*/
		$select = "
		select
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 							
		if(Z.is_omset = 1,sum(IF(Z.omsett >= Z.omsetm, if(Z.omsett + Z.Vpiece - Z.v < 0,0,Z.omsett + Z.Vpiece - Z.v), Z.omsett)),'0') omsett,
		if(Z.is_omset = 1,sum(IF(Z.omsett < Z.omsetm, if(Z.omsetm + Z.Vpiece - Z.v < 0,0,Z.omsetm + Z.Vpiece - Z.v), Z.omsetm)),'0') omsetm,
		sum(Z.omsettc) omsettc,
		if(Z.intid_jpenjualan != 8, sum(Z.Vpiece_tagihan), sum(Z.omsetll)) omsetll,
		sum(Z.omsetlg) omsetlg,
		sum(Z.tradein_t) tradein_t,
		sum(Z.tradein_m) tradein_m,
		Z.strnama_jpenjualan,
		Z.intid_jpenjualan,
		Z.strnama_dealer,
		Z.strnama_upline,
		Z.intid_dealer,
		Z.strnama_cabang strnama_cabang_asli,
		sum(Z.inttotal_omset) inttotal_omset,
		sum(Z.intpv) intpv,
		sum(Z.inttotal_bayar) + sum(Z.Vpiece_tagihan) inttotal_bayar,
		Z.strnama_unit,
		sum(Z.intkomisi10) intkomisi10,
		sum(Z.intkomisi15) intkomisi15,
		sum(Z.intkomisi20) intkomisi20,
		Z.intid_week,
		sum(Z.otherKom) otherKom
		from 
		(select 
		(select if(sum(nota_detail.intquantity * nota_detail.intharga) is null, 0,sum(nota_detail.intquantity * nota_detail.intharga)) from 
			nota_detail,barang 
			where 
			nota_detail.intid_nota = nota.intid_nota
			and barang.intid_barang = nota_detail.intid_barang 
			and barang.intid_jbarang = 1
			) omsett, 
		(select if(sum(nota_detail.intquantity * nota_detail.intharga) is null, 0,sum(nota_detail.intquantity * nota_detail.intharga)) from 
			nota_detail,barang 
			where 
			nota_detail.intid_nota = nota.intid_nota
			and barang.intid_barang = nota_detail.intid_barang 
			and barang.intid_jbarang = 2
			) omsetm, 
		(select sum(nota_detail.intquantity * nota_detail.intharga) from 
			nota_detail,barang 
			where 
			nota_detail.intid_nota = nota.intid_nota
			and barang.intid_barang = nota_detail.intid_barang 
			and barang.intid_jbarang = 3
			) omsettc,
		(select  if(sum(nota_detail.intquantity * nota_detail.intharga) is null, 0,sum(nota_detail.intquantity * nota_detail.intharga)) from 
			nota_detail,barang 
			where 
			nota_detail.intid_nota = nota.intid_nota
			and barang.intid_barang = nota_detail.intid_barang 
			and barang.intid_jbarang = 9
			) Vpiece,
		(select  if(sum(nota_detail.intquantity * nota_detail.intvoucher) is null and (nota_detail.intvoucher = 50000 or nota_detail.intvoucher = 60000), 0,sum(nota_detail.intquantity * nota_detail.intvoucher / 2)) from 
			nota_detail,barang 
			where 
			nota_detail.intid_nota = nota.intid_nota
			and barang.intid_barang = nota_detail.intid_barang 
			) Vpiece_tagihan,
		(select if(sum(nota_detail.intquantity * nota_detail.intharga) is null, 0,sum(nota_detail.intquantity * nota_detail.intharga))
			from nota_detail, barang
			where 
			nota_detail.intid_barang = barang.intid_barang
			and barang.intid_jbarang = 5
			and nota_detail.intid_nota = nota.intid_nota
			) omsetlg, 
		(select if(sum(nota_detail.intquantity * nota_detail.intharga) is null, 0,sum(nota_detail.intquantity * nota_detail.intharga))
			from nota_detail, barang, nota n
			where 
			nota_detail.intid_barang = barang.intid_barang
			and n.intid_nota = nota_detail.intid_nota
			and n.intid_jpenjualan = 8
			and barang.intid_jbarang not in (5)
			and nota_detail.intid_nota = nota.intid_nota
			) omsetll,
		(select sum(nota_detail.intharga * nota_detail.intquantity) * (1 - (nota.inttrade_in * 0.01))
			from nota_detail, barang
			where 
			nota_detail.intid_nota = nota.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and barang.intid_jbarang not in (5)
			and barang.intid_jbarang = 1
			) tradein_t,
		(select sum(nota_detail.intharga * nota_detail.intquantity) * (1 - (nota.inttrade_in * 0.01))
			from nota_detail, barang
			where 
			nota_detail.intid_nota = nota.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and barang.intid_jbarang not in (5)
			and barang.intid_jbarang = 2
			) tradein_m, 
		nota.intvoucher v, nota.intid_nota, nota.intid_jpenjualan,nota.inttotal_omset,nota.intpv, nota.inttotal_bayar,nota.intkomisi10,nota.intkomisi15,nota.intkomisi20,nota.intid_week,nota.otherKom,
		member.intid_dealer,member.strnama_dealer, member.strnama_upline,
		unit.strnama_unit,
		cabang.strnama_cabang,
		(select is_omset from jenis_penjualan where intid_jpenjualan = $jpenjualan) as is_omset,
		jenis_penjualan.strnama_jpenjualan
		from 
		nota left join member on nota.intid_dealer = member.intid_dealer 
		left join cabang on cabang.intid_cabang = nota.intid_cabang
		left join unit on nota.intid_unit = unit.intid_unit
		left join jenis_penjualan on  nota.intid_jpenjualan = jenis_penjualan.intid_jpenjualan
		where 
			nota.intid_week 		= $week
			and nota.intid_cabang 	= $cabang
			and nota.intid_jpenjualan	= $jpenjualan
			and year(datetgl) 			= $tahun
			and nota.is_dp = 0) Z group by Z.intid_dealer";
		$query = $this->db->query($select);
		return $query->result();
		}
		function get_CetakPenjualanBulanan($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select 
					X.intid_dealer, 
					sum(X.omsett) omsett, 
					sum(X.omsetm) omsetm, sum(X.omsettc)omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month)
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month)
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and 
										is_arisan = 0
										and is_dp = 0
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
		INNER JOIN 
				(SELECT * FROM 
					(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
					FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
					INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
					WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and is_arisan = 0
									and is_dp = 0
										AND intid_cabang = $cabang
					GROUP BY intid_dealer, intid_jbarang) AS asd 
				WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        return $query->result();
	}
	/*
	function get_CetakPenjualanBulanan11($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select 
					X.intid_dealer, 
					sum(X.omsett) omsett, 
					sum(X.omsetm) omsetm, sum(X.omsettc)omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							X.tradein_t,
							X.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month)
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month)
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota
						) AS Z 
						LEFT JOIN
						(SELECT jbarangt.intid_nota, jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
								(SELECT * FROM 
									(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
									FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
									INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
									WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and 
													is_arisan = 0
													and is_dp = 0
													AND intid_cabang = $cabang
										GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
								WHERE intid_jbarang = 1) AS jbarangt 
						INNER JOIN 
							(SELECT * FROM 
								(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
								FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
								INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
								WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and is_arisan = 0
												and is_dp = 0
													AND intid_cabang = $cabang
								GROUP BY intid_dealer, intid_jbarang) AS asd 
							WHERE intid_jbarang = 2) AS jbarangm 
						ON jbarangt.intid_nota = jbarangm.intid_nota
						where jbarangt.intid_cabang = $cabang
				) AS kodebwtmisahinomsettulipdenganmetal
	on Z.intid_nota = kodebwtmisahinomsettulipdenganmetal.intid_nota
					) AS X 
			
						group by X.intid_dealer");
        return $query->result();
	}
	*/
		function get_CetakKeuanganMingguanReguler($cabang, $week)
	{
		$query = $this->db->query("SELECT n AS intno_nota, 
												IF(ot >= v AND ot IS NOT NULL, ot - v, IF(om < ot AND otc < ot AND ot < v , 0, ot)) AS omsettulip,
												IF(ot < v AND otc < v AND om >= v AND om IS NOT NULL, om - v, IF(ot < om AND otc < om AND om < v, 0, om)) AS omsetmetal,
												IF(ot  < v AND otc >= v AND otc IS NOT NULL, otc - v, IF(ot < otc AND om < otc AND otc < v, 0, otc)) AS omsettc
										FROM 
										(SELECT 
											IF(dt IS NULL, IF(dm IS NULL,dtc,dm), dt) AS d, 
											IF(nt IS NULL, IF(nm IS NULL,ntc,nm), nt) AS n, 
											ot, 
											om, 
											otc 
											FROM 
												(SELECT * 
													FROM 
														(SELECT 
															intid_dealer AS dt, 
															intno_nota AS nt, 
															SUM(totalharga) AS ot
															FROM 
																(SELECT 
																	intid_dealer, 
																	intno_nota, 
																	SUM(intquantity * intharga) AS totalharga, 
																	intid_jbarang 
																	FROM 
																		nota a 
																			INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota 
																			INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang 
																	WHERE 
																		a.intid_week = $week 
																		AND a.intid_cabang = $cabang 
																		AND a.intid_jpenjualan = 1 
																		AND a.is_arisan = 0 
																		AND a.is_dp = 0 
																		AND a.inttotal_bayar > 0
																		AND nota_detail.is_free = 0 
																		GROUP BY intno_nota, intid_jbarang
																) AS z 
															WHERE 
															intid_jbarang = 1 
															
															GROUP BY intno_nota
														) AS omsettulip 
														LEFT JOIN 
														(SELECT 
															intid_dealer AS dm, 
															intno_nota AS nm, 
															SUM(totalharga) AS om 
														FROM 
															(SELECT 
																intid_dealer, 
																intno_nota, 
																SUM(intquantity * intharga) AS totalharga, 
																intid_jbarang 
															FROM 
																nota a 
																INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota 
																INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang 
															WHERE 
																a.intid_week = $week 
																AND a.intid_cabang = $cabang 
																AND a.intid_jpenjualan = 1 
																AND a.is_arisan = 0 
																AND a.is_dp = 0 
																AND a.inttotal_bayar > 0
																AND nota_detail.is_free = 0 
															GROUP BY intno_nota, intid_jbarang
															) AS z 
														WHERE intid_jbarang = 2 
														GROUP BY intno_nota
														) AS omsetmetal
													ON omsettulip.nt = omsetmetal.nm
													LEFT JOIN
														(SELECT 
															intid_dealer AS dtc, 
															intno_nota AS ntc, 
															SUM(totalharga) AS otc 
														FROM 
															(SELECT 
																intid_dealer, 
																intno_nota, 
																SUM(intquantity * intharga) AS totalharga, 
																intid_jbarang 
															FROM 
																nota a 
																INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota 
																INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang 
															WHERE 
																a.intid_week = $week 
																AND a.intid_cabang = $cabang 
																AND a.intid_jpenjualan = 1 
																AND a.is_arisan = 0 
																AND a.is_dp = 0
																AND a.inttotal_bayar > 0 
																AND nota_detail.is_free = 0 
															GROUP BY intno_nota, intid_jbarang
															) AS z 
														WHERE 
															intid_jbarang = 3 
														GROUP BY intno_nota
														) AS omsettc
														ON omsettulip.nt = omsettc.ntc OR omsetmetal.nm = omsettc.ntc
																	UNION
														SELECT * FROM 
																	(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
																		RIGHT JOIN 
																	(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal 
																	ON omsettulip.intno_nota = omsetmetal.intno_nota
																	LEFT JOIN
													(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
																	ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota
																	UNION 
																	SELECT * FROM 
																	(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
																	RIGHT JOIN 
																	(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
																	ON omsettulip.intno_nota = omsetmetal.intno_nota
																	RIGHT JOIN
																	(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
																	ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota) AS omset
															) AS omset
										LEFT JOIN 
										(SELECT intid_dealer AS dv, intno_nota AS nv, intvoucher AS v FROM nota) AS voucher
										ON omset.n = voucher.nv
							ORDER BY intno_nota");
        
		return $query->result();

	}
	function get_CetakSales($week, $cabang)
	{
//001
//009
		$query=$this->db->query("SELECT * FROM 
		(select a.datetgl, 
					a.intno_nota, 
					f.strnama_jpenjualan, 
					c.strnama_dealer, 
					c.strnama_upline, 
					d.strnama_unit, 
					a.inttotal_omset, 
					IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, 
					IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week = $week
						AND nota.intid_cabang = $cabang
						AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
						AND nota.intid_nota = a.intid_nota
					) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week = $week
						AND nota.intid_cabang = $cabang
						AND nota.intid_jpenjualan = 11
						AND nota.intid_nota = a.intid_nota
					) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week = $week
						AND nota.intid_cabang = $cabang
						AND nota.intid_jpenjualan = 12
						AND nota.intid_nota = a.intid_nota
					) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week = $week
						AND nota.intid_cabang = $cabang
						AND nota.intid_jpenjualan = 10
						AND nota.intid_nota = a.intid_nota
					) AS omsetsk,
					(select sum(nota_detail.intquantity*nota_detail.intharga) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week = $week
						and nota.intid_cabang = $cabang
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and barang.intid_jbarang=5
						and nota.intid_nota = a.intid_nota
					) as omsetlg,
					(select sum(nota_detail.intquantity*nota_detail.intharga) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week = $week
						and nota.intid_cabang = $cabang
						and barang.intid_jbarang=6
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota
					) as omsetll,
					a.inttotal_bayar, 
					a.intpv, 
					a.intid_nota, 
					b.strnama_cabang, 
					a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner
		from nota a, cabang b, member c, unit d, jenis_penjualan f
		where c.intid_unit = d.intid_unit
			and a.intid_cabang = b.intid_cabang
			and a.intid_dealer =  c.intid_dealer
			and a.intid_jpenjualan = f.intid_jpenjualan
			and a.intid_cabang = $cabang
			and a.intid_week = $week
			and a.is_dp = 0 
		order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
UNION
SELECT * FROM (
SELECT a.datetgl, a.intno_nota, 'Hadiah' AS strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
' ' AS inttotal_omset, ' ' AS intomset10, ' ' AS intomset20, ' ' AS omsetnetto, ' ' AS omsetspecialprice, 
' ' AS omsetpoint, ' ' AS omsetsk, ' ' AS omsetlg, ' ' AS omsetll, ' ' AS omsettotal_bayar, ' ' AS intpv, 
a.intid_nota, b.strnama_cabang, a.intid_week, 
(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart, 
(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
' ' AS is_arisan, ' ' AS winner 
FROM nota_hadiah a INNER JOIN cabang b ON a.intid_cabang = b.intid_cabang INNER JOIN member c ON a.intid_dealer = c.intid_dealer INNER JOIN unit d ON c.intid_unit = d.intid_unit 
WHERE a.intid_cabang = $cabang AND a.intid_week = $week) AS x");
        return $query->result();
	}
	function getLap_Stok_cab_3($intid_cabang, $week){
			$query0 = $this->db->query("select date(as_of_date) start from stok_barang where intid_cabang = '".$intid_cabang."' limit 0,1 ");
			$hasil0 = $query0->result();
			$weekbefore = $week-1;
			$query1 = $this->db->query("select dateweek_end from week where intid_week = ".$weekbefore."");
			$hasil1 = $query1->result();
			if($hasil0[0]->start >= $hasil1[0]->dateweek_end){
				$weekbefore = 0 ;
			} else{
				//Do Nothing
			}
			$select = 'select barang.strnama,
									  		barang.intid_barang,
											barang.intid_jsatuan, 
											barang_masuk_before.jum_barang_masuk_before, 
											barang_keluar_before.jum_barang_keluar_before,  
											retur_before.jum_barang_keluar_dari_retur_before,
											barang_keluar_hadiah_before.jum_barang_keluar_hadiah_before, 
											barang_masuk_after.jum_barang_masuk_after, 
											barang_keluar_after.jum_barang_keluar_after,
											retur.jum_barang_keluar_dari_retur,
											barang_keluar_hadiah_after.jum_barang_keluar_hadiah_after,
											stok_barang.set_fisik, 
											stok_barang.pcs_fisik 
									  from
									  barang left join
									  (select sum(intquantity) jum_barang_keluar_before, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week <= "'.$weekbefore.'"
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang limit 0,1) group by nd.intid_barang
										  )as barang_keluar_before
									  on barang_keluar_before.intid_barang = barang.intid_barang
									  left join 
									  (
									  select sum(intquantity) jum_barang_keluar_hadiah_before, nd.intid_barang 
										  from 
										  nota_hadiah n inner join nota_detail_hadiah nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week <= "'.$weekbefore.'"
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang limit 0,1) group by nd.intid_barang
										)as barang_keluar_hadiah_before 
									  on barang_keluar_hadiah_before.jum_barang_keluar_hadiah_before = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_before, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week <= "'.$weekbefore.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_before
									   on barang_masuk_before.intid_barang = barang.intid_barang
									   left join 
									   (
										select sum(rd.quantity) jum_barang_keluar_dari_retur_before, rd.intid_barang  
										from retur_ r inner join retur_detail_ rd on rd.no_srb = r.no_srb
										where r.intid_cabang = "'.$intid_cabang.'"
										and r.intid_week <= "'.$weekbefore.'" 
										and r.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang limit 0,1) 
										group by rd.intid_barang
									   ) as retur_before
									   on retur_before.intid_barang = barang.intid_barang
									   left join
									  (select sum(intquantity) jum_barang_keluar_after, nd.intid_barang 
										  from 
										  nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota 
										  where n.intid_cabang = "'.$intid_cabang.'"
										  and n.intid_week = "'.$week.'"
										  and n.is_dp = 0
										  and n.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by nd.intid_barang
										  )as barang_keluar_after
									  on barang_keluar_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(ndh.intquantity) jum_barang_keluar_hadiah_after, ndh.intid_barang 
										   from 
										   nota_hadiah nh inner join nota_detail_hadiah ndh on ndh.intid_nota = nh.intid_nota 
										   where nh.intid_cabang = "'.$intid_cabang.'"
										   and nh.intid_week = "'.$week.'"
										   and nh.datetgl > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) group by ndh.intid_barang
										   )as barang_keluar_hadiah_after
									  on barang_keluar_hadiah_after.intid_barang = barang.intid_barang
									  left join
									  (select sum(spd.quantity) jum_barang_masuk_after, spd.intid_barang 
									   		from 
											spkb inner join spkb_detail spd on spd.no_spkb = spkb.no_spkb
											where spkb.intid_cabang = "'.$intid_cabang.'"
											and spkb.week = "'.$week.'"
											and spkb.tgl_terima > (select date_format(as_of_date,"%Y-%m-%d") from stok_barang where intid_cabang = "'.$intid_cabang.'" limit 0,1) 
											and spkb.no_sj != ""
											and terkirim = 1
											group by spd.intid_barang	
									   	  )as barang_masuk_after
									   on barang_masuk_after.intid_barang = barang.intid_barang
									   left join 
									   (select *
											from 
											stok_barang
											where intid_cabang = "'.$intid_cabang.'"
											)as stok_barang
									   on stok_barang.intid_barang = barang.intid_barang
									   left join (
										select sum(rd.quantity) jum_barang_keluar_dari_retur, rd.intid_barang  
										from retur_ r inner join retur_detail_ rd on rd.no_srb = r.no_srb
										where r.intid_cabang = "'.$intid_cabang.'"
										and r.intid_week = "'.$week.'" 
										group by rd.intid_barang
									   ) as retur
									   on retur.intid_barang = barang.intid_barang
									  order by barang.strnama asc
									  ';
								//	  echo "".$select;
			$query = $this->db->query($select);
			return $query->result();
		}
		function get_jenis_notaHadiah($data){
		$SEL	=	$this->db->query('select upper(jenis_nota) jenis_nota, kode from jenis_nota_hadiah where is_view = 1 order by jenis_nota asc');
		$var = "<select name='".$data['name']."' id = ".$data['id']." class='".$data['id']."'>";
		$data = "";
		foreach($SEL->result() as $rok){
			if($data == ""){
				$data ="<option value='".$rok->kode."'selected>".$rok->jenis_nota."</option>";
			}else{
				$data .= "<option value='".$rok->kode."'>".$rok->jenis_nota."</option>";
			}
		}
		$var .= $data."</select>";
		return $var;
		}
		function selectBarangReturSparepart($keyword){
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama from barang a where a.strnama like '$keyword%'");
        return $query->result();
		}
		function getLap_Stok_cab_4($intid_cabang, $week){
			$hutang_barang_set = array();
			$hutang_barang_pcs = array();
			$sisa_barang_pcs = array();
			$sisa_barang_set = array();
			//coba lagi
			$hasil = array();
			//disini lakukan tracking hutang barang
			$select = "select * from stok_barang where intid_cabang = ".$intid_cabang."";
			$query = $this->db->query($select);
			foreach($query->result() as $row){
				//diset awal sebagai array multi dimensi
				$hasil[0][$row->intid_barang]['hutang_barang_set'] = $row->set_hutang;
				$hasil[0][$row->intid_barang]['hutang_barang_pcs'] = $row->pcs_hutang;
				$hasil[0][$row->intid_barang]['sisa_barang_pcs'] = $row->set_hutang;
				$hasil[0][$row->intid_barang]['sisa_barang_set'] = $row->pcs_hutang;
				}
			//
			$select2 = "select * from week where intid_week < ".$week." and dateweek_start > (select date_format(as_of_date,'%Y-%m-%d') from stok_barang where intid_cabang = ".$intid_cabang." limit 0,1) group by intid_week order by intid_week asc";
			$query_cek = $this->db->query($select2);
			if($query_cek->num_rows() == 0){
				$select2 = "select * from week where intid_week = ".$week." group by intid_week order by intid_week asc";
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
					if(sttb.jum_barang_masuk_sj_retur is NULL, 0, sttb.jum_barang_masuk_sj_retur) jum_barang_masuk_sj_retur 
					from barang 
					left join
					(select 
						sum(nd.intquantity) jum_barang_keluar_nota, nd.intid_barang
						from nota n inner join nota_detail nd
						on nd.intid_nota = n.intid_nota
						where n.intid_week = '$row->intid_week'
						and n.intid_cabang = '$intid_cabang'
						and n.is_dp = 0
						and n.is_asi = 0
						group by nd.intid_barang) as nota on nota.intid_barang = barang.intid_barang
					left join
					(select
						sum(sd.quantity) jum_barang_masuk_sj, sd.intid_barang
						from spkb s inner join spkb_detail sd on s.no_spkb = sd.no_spkb
						where 
						s.week_sj = '$row->intid_week'
						and s.intid_cabang = '$intid_cabang'
						and s.no_sj != ''
						group by sd.intid_barang) as surat_jalan on surat_jalan.intid_barang = barang.intid_barang
					left join
					(select 
						sum(rd.quantity) jum_barang_keluar_retur, rd.intid_barang
						from retur_ r inner join retur_detail_ rd on r.no_srb = rd.no_srb
						where 
						r.intid_week = '$row->intid_week'
						and r.intid_cabang = '$intid_cabang'
						group by rd.intid_barang) as retur on retur.intid_barang = barang.intid_barang
					left join
					(select 
						* 
						from stok_barang s
						where 
						s.intid_cabang = '$intid_cabang'
						) as stok on stok.intid_barang = barang.intid_barang
					left join
					(select
						sum(std.quantity) jum_barang_masuk_sj_retur, std.intid_barang
						from sttb st inner join sttb_detail std on std.no_sttb = st.no_sttb
						where 
						st.week = '$row->intid_week'
						and st.intid_cabang_kirim = '$intid_cabang'
						and st.no_sj != ''
						group by std.intid_barang) as sttb on sttb.intid_barang = barang.intid_barang
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
		function getLap_Stok_cab_5($intid_cabang, $week){
		/*
			$select = "select barang.*, 
						if(nota.jum_barang_keluar_nota is NULL, 0, nota.jum_barang_keluar_nota) jum_barang_keluar_nota, 
						'0' as jum_barang_keluar_nota_hadiah, 
						if(surat_jalan.jum_barang_masuk_sj is NULL, 0,surat_jalan.jum_barang_masuk_sj) jum_barang_masuk_sj, 
						if(retur.jum_barang_keluar_retur is NULL, 0,retur.jum_barang_keluar_retur) jum_barang_keluar_retur,
						if(sttb.jum_barang_masuk_sj_retur is NULL, 0, sttb.jum_barang_masuk_sj_retur) jum_barang_masuk_sj_retur 
					from barang left join
					(select 
						sum(nd.intquantity) jum_barang_keluar_nota, nd.intid_barang
						from nota n inner join nota_detail nd
						on nd.intid_nota = n.intid_nota
						where n.intid_week = '$week'
						and n.intid_cabang = '$intid_cabang'
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
						and s.no_sj != ''
						group by sd.intid_barang) as surat_jalan on surat_jalan.intid_barang = barang.intid_barang
					left join
					(select 
						sum(rd.quantity) jum_barang_keluar_retur, rd.intid_barang
						from retur_ r inner join retur_detail_ rd on r.no_srb = rd.no_srb
						where 
						r.intid_week = '$week'
						and r.intid_cabang = '$intid_cabang'
						group by rd.intid_barang) as retur on retur.intid_barang = barang.intid_barang
					left join
					(select
						sum(std.quantity) jum_barang_masuk_sj_retur, std.intid_barang
						from sttb st inner join sttb_detail std on std.no_sttb = st.no_sttb
						where 
						st.week = '$week'
						and st.intid_cabang_kirim = '$intid_cabang'
						and st.no_sj != ''
						group by std.intid_barang
						) as sttb on sttb.intid_barang = barang.intid_barang";
						*/
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
						and (s.no_sj != '' or s.no_sj is not null)
						group by sd.intid_barang) as surat_jalan on surat_jalan.intid_barang = barang.intid_barang
					left join
					(select 
						sum(rd.quantity) jum_barang_keluar_retur, rd.intid_barang
						from retur_ r inner join retur_detail_ rd on r.no_srb = rd.no_srb
						where 
						r.intid_week = '$week'
						and r.intid_cabang = '$intid_cabang'
						group by rd.intid_barang) as retur on retur.intid_barang = barang.intid_barang
					left join
					(select
						sum(std.quantity) jum_barang_masuk_sj_retur, std.intid_barang
						from sttb st inner join sttb_detail std on std.no_sttb = st.no_sttb
						where 
						st.week = '$week'
						and st.intid_cabang_kirim = '$intid_cabang'
						and (st.no_sj != '' or st.no_sj is not null)
						group by std.intid_barang) as sttb on sttb.intid_barang = barang.intid_barang
					left join 
					(select sum(rsptd.qty) jum_barang_keluar_sparepart, rsptd.intid_barang
						from retur_sparepart rspt inner join retur_sparepart_detail rsptd on rsptd.intid_retur_sparepart = rspt.intid_retur_sparepart
						where 
						rspt.intid_week = '$week'
						and rspt.intid_cabang = '$intid_cabang'
						and (rspt.no_sttb !='' or rspt.no_sttb is not null)
						group by rsptd.intid_barang) as retur_sparepart on retur_sparepart.intid_barang = barang.intid_barang
					left join
					(select sum(stprd.qty) jum_barang_masuk_sparepart, stprd.intid_barang 
						from sttb_sparepart stpr inner join sttb_sparepart_detail stprd on stpr.no_sttb = stprd.no_sttb
						where 
						stpr.week_sj = '$week'
						and stpr.intid_cabang = '$intid_cabang'
						and (stpr.no_sj_sparepart !='' or stpr.no_sj_sparepart is not null)
						group by stprd.intid_barang) as sj_sparepart on sj_sparepart.intid_barang = barang.intid_barang 
					order by barang.strnama asc";			
			$query = $this->db->query($select);
			return $query;
		}
		function getLap_Stok_cab_6($intid_cabang, $week){
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
						group by nd.intid_barang) as nota on nota.intid_barang = barang_hadiah.intid_barang_hadiah
					order by barang_hadiah.strnama asc
					";
			$query = $this->db->query($select);
			return $query;
		}
		function getLap_Stok_cab_START($intid_cabang, $week){
	
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
											)as stok_barang
									   on stok_barang.intid_barang = barang.intid_barang
									  order by barang.strnama asc
									  ');
			return $query->result();
		}
		function STTB2_SJ($halaman,$limit){
			$query = $this->db->query('select spd.no_sttb, spd.waktu waktu,
									  (select strnama_cabang from cabang where intid_cabang = spd.intid_cabang) strnama_cabang 
									  from sttb_sparepart spd where (spd.no_sj_sparepart = "" or spd.no_sj_sparepart is NULL) order by spd.waktu desc limit '.$halaman.','.$limit.'');
			return $query;
			}
			
		//
		
		function STTB3_SJ($halaman,$limit){
			$query = $this->db->query('select spd.no no_sttb, spd.waktu waktu,
									  (select strnama_cabang from cabang where intid_cabang = spd.intid_cabang) strnama_cabang 
									from 
										pra_sttb_sparepart spd
									where 
										spd.active = 1
										group by spd.no
										  order by spd.waktu desc limit '.$halaman.','.$limit.'');
			return $query;
			}
		function STTB3_SJ_SEARCH($cabang){
			$query = $this->db->query('select spd.no no_sttb, spd.waktu waktu,
										cabang.strnama_cabang 
									from 
										pra_sttb_sparepart spd,cabang
									where 
										spd.active = 1 and
										cabang.intid_cabang = spd.intid_cabang and
										cabang.strnama_cabang like "'.$cabang.'%"
										group by spd.no
										  order by spd.waktu');
			return $query;
			}
		////
		
		function get_CetakPenjualanMingguanspecialbandung($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select X.intid_dealer, 
							0 as omsett, 
							0 as omsetm, 
							0 as omsettc, 
							0 as omsetlg,
							(sum(X.omsett) + sum(X.omsetm)) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
	}
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
		function get_CetakPenjualanMingguanspecialbandung_tahun($week, $cabang, $jpenjualan,$tahun)
	{
		$query = $this->db->query("select X.intid_dealer, 
							0 as omsett, 
							0 as omsetm, 
							0 as omsettc, 
							0 as omsetlg,
							sum(X.inttotal_bayar) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m,
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) = $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) = $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) = $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) = $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) = $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(nota.datetgl) = $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) = $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang
										AND YEAR(datetgl) = $tahun
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang
										AND YEAR(datetgl) = $tahun
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        
		return $query->result();
	}
		//ifirlana@gmail.com
		function get_CetakPenjualanBulananspecialbandung($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select 
					X.intid_dealer, 
					0 as omsett, 
					0 as omsetm, 
					0 as omsettc, 
							0 as omsetlg,
							if((sum(X.omsett) + sum(X.omsetm) + kodebwtmisahinomsettulipdenganmetal.tradein_m + kodebwtmisahinomsettulipdenganmetal.tradein_t) > 0,(sum(X.omsett) + sum(X.omsetm) + kodebwtmisahinomsettulipdenganmetal.tradein_m + kodebwtmisahinomsettulipdenganmetal.tradein_t),sum(X.inttotal_bayar)) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month)
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month)
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and 
										is_arisan = 0
										and is_dp = 0
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
		INNER JOIN 
				(SELECT * FROM 
					(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
					FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
					INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
					WHERE intid_week  in (select intid_week from week where intbulan = $month) AND intid_jpenjualan = $jpenjualan and is_arisan = 0
									and is_dp = 0
										AND intid_cabang = $cabang
					GROUP BY intid_dealer, intid_jbarang) AS asd 
				WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        return $query->result();
	}
	//***
	// ifirlana@gmail.com
	//	8 jan 2014
	function get_CetakPenjualanBulananspecialbandung_tahun($month, $cabang, $jpenjualan,$tahun)
	{
		$query = $this->db->query("select 
					X.intid_dealer, 
					0 as omsett, 
					0 as omsetm, 
					0 as omsettc, 
							0 as omsetlg,
							sum(X.inttotal_bayar) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun = $tahun order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m,
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and nota.intid_cabang = $cabang
								and year(nota.datetgl) = $tahun
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
								and year(nota.datetgl) = $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
								and year(nota.datetgl) = $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
								and year(nota.datetgl) = $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
								and year(nota.datetgl) = $tahun
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and intid_cabang = $cabang
								and year(nota.datetgl) = $tahun
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan and 
										is_arisan = 0
										and is_dp = 0
										and year(datetgl) = $tahun
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
		INNER JOIN 
				(SELECT * FROM 
					(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
					FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
					INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
					WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan and is_arisan = 0
									and is_dp = 0
									and year(datetgl) = $tahun
										AND intid_cabang = $cabang
					GROUP BY intid_dealer, intid_jbarang) AS asd 
				WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
        return $query->result();
	}
	//ending
	
	//
	function get_CetakPenjualanBulanan_tahun($month, $cabang, $jpenjualan, $tahun)
	{
		/* $query = $this->db->query("select 
					X.intid_dealer, 
					sum(X.omsett) omsett, 
					sum(X.omsetm) omsetm, sum(X.omsettc)omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						Z.omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and year(nota.datetgl) = $tahun
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(nota.datetgl) = $tahun
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(datetgl) = $tahun
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi20
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) 
						and year(datetgl) = $tahun
						AND intid_jpenjualan = $jpenjualan and 
										is_arisan = 0
										and is_dp = 0
										AND intid_cabang = $cabang
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1) AS jbarangt 
		INNER JOIN 
				(SELECT * FROM 
					(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
					FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
					INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
					WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) and year(datetgl) = $tahun AND intid_jpenjualan = $jpenjualan and is_arisan = 0
									and is_dp = 0
										AND intid_cabang = $cabang
					GROUP BY intid_dealer, intid_jbarang) AS asd 
				WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer"); */
						/*
						$query = $this->db->query("select 
					X.intid_dealer, 
					sum(X.omsett) omsett, 
					sum(X.omsetm) omsetm, sum(X.omsettc)omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							'".$month."' AS intbulan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and year(nota.datetgl) = $tahun
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(nota.datetgl) = $tahun
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(datetgl) = $tahun
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20
						from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer");
						*/
		$select = "select X.intid_dealer, 
							sum(X.omsett) omsett, 
							sum(X.omsetm) omsetm, 
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							if(sum(X.omsetll) is null, 0,sum(X.omsetll)) + Y. undangan_nota_detail + Y.undangan_nota omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							#sum(X.inttotal_bayar)  + Y. undangan_nota_detail + Y.undangan_nota inttotal_bayar,
							sum(X.inttotal_bayar)  + if(Y.undangan_nota_detail is null, 0,Y.undangan_nota_detail) + if(Y.undangan_nota is null, 0 , Y.undangan_nota) inttotal_bayar,
							#sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m,
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga)) - if(nota.is_vpromo = 1, nota.intvoucher,0)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week   in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week   in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week   in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
	LEFT JOIN
				(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_jpenjualan = $jpenjualan
								and a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								 and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit
						) Y
					ON X.intid_dealer = Y.intid_dealer
						group by X.intid_dealer";
		$query = $this->db->query($select);
        return $query->result();
	}
	//
	function get_CetakPenjualanBulananLainLain_tahun($month, $cabang, $jpenjualan, $tahun)
	{
			/* $query = $this->db->query("
			select 
			* 
			from
		(select 
		Y.intid_dealer, 
		0 as omsett, 
			0 as omsetm, 
			0 as omsettc, 
			0 as omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll))+ Y.undangan_nota + Y.undangan_nota_detail omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			0 as intkomisi10, 
			0 as intkomisi15, 
			0 as intkomisi20, 
			0 as intpv, 
			0 as inttotal_bayar,
			0 as inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			'".$month."' AS intbulan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							0 AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
		where
			infinity.omsetll != 0"); */
			$query = $this->db->query("select 
			* 
			from
		(select 
		#Y.intid_dealer, 
		X.intid_dealer, 
		0 as omsett, 
			0 as omsetm, 
			0 as omsettc, 
			#0 as omsetlg,
			sum(X.omsetlg) omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll))+ if((Y.undangan_nota + Y.undangan_nota_detail) > X.omsetllUndangan, (Y.undangan_nota + Y.undangan_nota_detail), X.omsetllUndangan) omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			0 as intkomisi10, 
			0 as intkomisi15, 
			0 as intkomisi20, 
			0 as intpv, 
			0 as inttotal_bayar,
			0 as inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			'".$month."' AS intbulan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						if(Z.omsetllUndangan is null, 0, Z.omsetllUndangan) omsetllUndangan,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and barang.strnama not like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and barang.strnama like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetllUndangan,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
		where
			infinity.omsetll != 0
			or infinity.omsetlg != 0");
        return $query->result();
	}
	
	function get_CetakPenjualanBulananLainLain_tahun_ef ($month, $cabang, $jpenjualan, $tahun){
	
				$query = $this->db->query("select 
			* 
			from
		(select 
		#Y.intid_dealer, 
		X.intid_dealer, 
		sum(X.omsett) omsett, 
			sum(X.omsetm) omsetm, 
			sum(X.omsettc) omsettc, 
			#0 as omsetlg,
			sum(X.omsetlg) omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll)) omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			sum(X.intkomisi10) intkomisi10, 
			sum(X.intkomisi10) intkomisi15, 
			sum(X.intkomisi10) intkomisi20, 
			sum(X.otherKom) otherKom, 
			sum(X.intpv) intpv, 
			sum(X.inttotal_bayar) inttotal_bayar,
			sum(X.inttotal_omset) inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			'".$month."' AS intbulan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m,
			(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						if(Z.omsetllUndangan is null, 0, Z.omsetllUndangan) omsetllUndangan,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									#and barang.intid_jbarang = 6
									and barang.intid_jbarang not in (4,5,7)
									and barang.strnama not like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and barang.strnama like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetllUndangan,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
		where
			infinity.omsetll != 0
			or infinity.omsetlg != 0");
        return $query->result();
	}
	
	function get_CetakPenjualanMingguanLainLain_tahun($week, $cabang, $jpenjualan,$tahun)
	{
		/* $select = "select 
			* 
			from
		(select 
		Y.intid_dealer, 
		0 as omsett, 
			0 as omsetm, 
			0 as omsettc, 
			0 as omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll))+ Y.undangan_nota + Y.undangan_nota_detail omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			0 as intkomisi10, 
			0 as intkomisi15, 
			0 as intkomisi20, 
			0 as intpv, 
			0 as inttotal_bayar,
			0 as inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in ($week)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							0 AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in ($week)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in ($week) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in ($week) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
		where
			infinity.omsetll != 0"; */
/*
			$select = "select 
		X.intid_dealer, 
		0 as omsett, 
			0 as omsetm, 
			0 as omsettc, 
			sum(X.omsetlg) omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll)) omsetll,
			X.strnama_dealer, 
			X.strnama_upline,
			X.strnama_cabang, X.strnama_unit,
			X.strnama_cabang, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			0 as intkomisi10,  
			0 as intkomisi15, 
			0 as intkomisi20, 
			0 as intpv, 
			0 as inttotal_bayar,
			0 as inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m
	from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							#0 AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week =  $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll, 
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in ($week)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in ($week) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in ($week) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
		";
		/**
		"select X.intid_dealer, 
							sum(X.omsett) omsett, 
							sum(X.omsetm) omsetm, 
							sum(X.omsettc) omsettc, 
							sum(X.omsetlg) omsetlg,
							sum(X.omsetll + X.undangan_nota + X.undangan_nota_detail) omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
							(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.intpv) intpv, 
							sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week = $week
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week = $week
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and intid_nota = a.intid_nota
								) AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by X.intid_dealer"
		*/
//yang lama		
/*
 $select = "select 
			* 
			from
		(select 
		Y.intid_dealer, 
		0 as omsett, 
			0 as omsetm, 
			0 as omsettc, 
			sum(X.omsetlg) omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll)) omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			0 as intkomisi10, 
			0 as intkomisi15, 
			0 as intkomisi20, 
			0 as intpv, 
			0 as inttotal_bayar,
			0 as inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					(SELECT 
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY member.intid_dealer) as undangan_nota_detail,
					(SELECT 
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week in ($week)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY member.intid_dealer) as undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in ($week)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit
					where 
						 member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						if(Z.omsetllUndangan is null, 0, Z.omsetllUndangan) omsetllUndangan,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									#and barang.intid_jbarang=6
									and nota.intid_jbarang not in (4,5,7)
									and barang.strnama not like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and barang.strnama like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetllUndangan,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week  in ($week)
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week  in ($week) AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in ($week) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
		where
			infinity.omsetll != 0 or infinity.omsetlg != 0";
			*/
	//terbaru
	$select = "select 
			* 
			from
		(select 
		#Y.intid_dealer, 
		X.intid_dealer, 
		sum(X.omsett) omsett, 
			sum(X.omsetm) omsetm, 
			sum(X.omsettc) omsettc, 
			#0 as omsetlg,
			sum(X.omsetlg) omsetlg,
			if(sum(X.omsetll) is null,0, sum(X.omsetll))omsetll,
			Y.strnama_dealer, 
			Y.strnama_upline,
			Y.strnama_cabang, Y.strnama_unit,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun order by intid_week ASC limit 0,1) AS datestart,
			(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun =  $tahun order by intid_week DESC limit 0,1) AS dateend, 
			X.intid_week, 
			sum(X.intkomisi10) intkomisi10, 
			sum(X.intkomisi10) intkomisi15, 
			sum(X.intkomisi10) intkomisi20, 
			sum(X.otherKom) otherKom, 
			sum(X.intpv) intpv, 
			sum(X.inttotal_bayar) inttotal_bayar,
			sum(X.inttotal_omset) inttotal_omset, 
			X.strnama_jpenjualan, 
			X.intid_jpenjualan,
			kodebwtmisahinomsettulipdenganmetal.tradein_t,
			kodebwtmisahinomsettulipdenganmetal.tradein_m, 
			(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
	from 
					(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week = $week
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
							FROM
								NOTA a, CABANG cb 
							WHERE
								 cb.intid_cabang = a.intid_cabang
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit) Y
					LEFT JOIN
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null, 0, Z.omsetll) omsetll,
						if(Z.omsetllUndangan is null, 0, Z.omsetllUndangan) omsetllUndangan,
						Z.undangan_nota,
						Z.undangan_nota_detail,
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi15 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							0 as omsett,
							0 as omsetm,
							0 as omsettc,
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and year(nota.datetgl) = $tahun
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									#and barang.intid_jbarang nota = 6
									and barang.intid_jbarang not in (4,5,7)
									
									and barang.strnama not like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll, 
							(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail	.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and barang.strnama like 'undangan%'
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetllUndangan,
							0 AS v,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom,
								sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week = $week
							and year(a.datetgl) = $tahun
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z ) AS X 
			ON Y.intid_dealer = X.intid_dealer
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week = $week AND intid_jpenjualan = $jpenjualan and intid_jpenjualan not in (8)
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week = $week AND intid_jpenjualan = $jpenjualan and intid_jpenjualan not in (8)
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
						group by Y.intid_dealer) infinity
			where infinity.intid_dealer is not null";
        $query = $this->db->query($select);
		return $query->result();
		}
		
		function get_CetakPenjualanBulanan_tahun20150310($month, $cabang, $jpenjualan, $tahun) //get_CetakPenjualanMingguan_tahun20150310($week, $cabang, $jpenjualan,$tahun)
	{
		
        $query = $this->db->query("select X.intid_dealer, 
							#sum(X.omsett) omsett, 
							#sum(X.omsetm) omsetm, 
							#if(X.is_omset = 1, sum(X.omsett) , 0) omsett, 
							#if(X.is_omset = 1, sum(X.omsetm) , 0) omsetm,
							#sum(X.omsettc) omsettc, 
							if(X.is_omset = 1,IF(sum(X.omsett) >= (sum(X.Vpiece) * -1), sum(X.omsett) + sum(X.Vpiece), IF(sum(X.omsetm) < sum(X.omsett) AND sum(X.omsettc) < sum(X.omsett) AND sum(X.omsett) < (sum(X.Vpiece) * -1), 0, sum(X.omsett))), 0) AS omsett,
							if(X.is_omset = 1,IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) < (sum(X.Vpiece) * -1) AND sum(X.omsetm) >= (sum(X.Vpiece) * -1), sum(X.omsetm) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsetm) AND sum(X.omsettc) < sum(X.omsetm) AND sum(X.omsetm) < (sum(X.Vpiece) * -1), 0, sum(X.omsetm))), 0) AS omsetm,
							IF(sum(X.omsett) < (sum(X.Vpiece) * -1) AND sum(X.omsettc) >= (sum(X.Vpiece) * -1), sum(X.omsettc) + sum(X.Vpiece), IF(sum(X.omsett) < sum(X.omsettc) AND sum(X.omsetm) < sum(X.omsettc) AND sum(X.omsettc) < (sum(X.Vpiece) * -1), 0, sum(X.omsettc))) AS omsettc, 
							sum(X.omsetlg) omsetlg,
							if(sum(X.omsetll) is null, 0,sum(X.omsetll)) + Y. undangan_nota_detail + Y.undangan_nota omsetll,
							X.strnama_dealer, 
							X.strnama_upline,
							X.intid_dealer,
							X.strnama_cabang, X.strnama_unit,
							(select date_format(min(dateweek_start), '%d %M %Y') AS dateweek_start  from week where intbulan = $month and inttahun = $tahun) AS datestart,
							(select date_format(max(dateweek_end), '%d %M %Y') AS dateweek_end from week where intbulan = $month  and inttahun = $tahun) AS dateend, 
							X.intid_week, 
							sum(X.intkomisi10) intkomisi10, 
							sum(X.intkomisi15) intkomisi15, 
							sum(X.intkomisi20) intkomisi20, 
							sum(X.otherKom) otherKom, 
							sum(X.intpv) intpv, 
							#sum(X.inttotal_bayar)  + Y. undangan_nota_detail + Y.undangan_nota inttotal_bayar,
							sum(X.inttotal_bayar)  + if(Y.undangan_nota_detail is null, 0,Y.undangan_nota_detail) + if(Y.undangan_nota is null, 0 , Y.undangan_nota) inttotal_bayar,
							#sum(X.inttotal_bayar) inttotal_bayar,
							sum(X.inttotal_omset) inttotal_omset, 
							X.strnama_jpenjualan, 
							X.intid_jpenjualan,
							kodebwtmisahinomsettulipdenganmetal.tradein_t,
							kodebwtmisahinomsettulipdenganmetal.tradein_m, 
							(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang_asli
							from 
					(select 
						IF(Z.omsett >= Z.v, Z.omsett - Z.v, IF(Z.omsetm < Z.omsett AND Z.omsettc < Z.omsett AND Z.omsett < v , 0, Z.omsett)) AS omsett,
						IF(Z.omsett < v AND Z.omsettc < Z.v AND Z.omsetm >= Z.v, Z.omsetm - Z.v, IF(Z.omsett < Z.omsetm AND Z.omsettc < Z.omsetm AND Z.omsetm < Z.v, 0, Z.omsetm)) AS omsetm,
						IF(Z.omsett < v AND Z.omsettc >= Z.v, Z.omsettc - Z.v, IF(Z.omsett < Z.omsettc AND Z.omsetm < Z.omsettc AND Z.omsettc < Z.v, 0, Z.omsettc)) AS omsettc, 
						Z.omsetlg,
						if(Z.omsetll is null,0,Z.omsetll) omsetll, 
						Z.strnama_dealer,
						Z.strnama_upline,
						Z.intid_dealer,
						Z.strnama_cabang, 
						Z.strnama_unit,
						Z.intid_week, 
						Z.strnama_jpenjualan, 
						Z.intid_jpenjualan,
						Z.is_omset,
						Z.Vpiece,
						IF(Z.intpv < 0, 0, Z.intpv)AS intpv,
						IF(Z.inttotal_omset < 0, 0, Z.inttotal_omset) AS inttotal_omset,
						IF(Z.inttotal_bayar < 0, 0, Z.inttotal_bayar) AS inttotal_bayar,
						IF(Z.intkomisi10 < 0, 0, Z.intkomisi10)AS intkomisi10,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi15)AS intkomisi15,
						IF(Z.intkomisi20 < 0, 0, Z.intkomisi20)AS intkomisi20,
						IF(Z.otherKom < 0, 0, Z.otherKom)AS otherKom
						from 
						(select  
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga)) - if(nota.is_vpromo = 1, nota.intvoucher,0)
								from nota, nota_detail, barang 
								where nota.intid_nota = nota_detail.intid_nota
								and nota_detail.intid_barang = barang.intid_barang
								and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and nota.intid_cabang = $cabang
								and nota.intid_jpenjualan =  $jpenjualan
								and YEAR(nota.datetgl) =  $tahun
								and nota_detail.is_free = 0
								and barang.intid_jbarang=1
								and nota.is_arisan = 0
								and nota.is_dp = 0
								and nota.intid_nota = a.intid_nota) as omsett,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
							from nota, nota_detail, barang 
							where nota.intid_nota = nota_detail.intid_nota
							and nota_detail.intid_barang = barang.intid_barang
							and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and nota.intid_cabang = $cabang
							and nota.intid_jpenjualan =  $jpenjualan
							and YEAR(nota.datetgl) =  $tahun
							and nota_detail.is_free = 0
							and barang.intid_jbarang=2
							and nota.is_arisan = 0
							and nota.is_dp = 0
							and nota.intid_nota = a.intid_nota) as omsetm,
							(select  if(sum( nota_detail.intquantity*nota_detail.intharga) IS NULL,0,sum( nota_detail.intquantity*nota_detail.intharga))
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=3
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) as omsettc,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=5
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetlg, 
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and nota.intid_cabang = $cabang
									and nota.intid_jpenjualan =  $jpenjualan
									and YEAR(nota.datetgl) =  $tahun
									and nota_detail.is_free = 0
									and barang.intid_jbarang=6
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								) AS omsetll,
								(select sum(intvoucher)
									from nota
									where intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
									and intid_cabang = $cabang
									and intid_jpenjualan = $jpenjualan
									and YEAR(datetgl) =  $tahun
									and is_arisan = 0
									and is_dp = 0
									and is_arisan = 0
									and is_vpromo = 0
									and intid_nota = a.intid_nota
								) AS v,
								(select sum(nota_detail.intquantity*nota_detail.intharga)
									from nota, nota_detail, barang 
									where nota.intid_nota = nota_detail.intid_nota
									and nota_detail.intid_barang = barang.intid_barang
									and nota.intid_week = 26
									and nota.intid_cabang = 3
									and nota.intid_jpenjualan =  1
									and YEAR(nota.datetgl) =  2015
									and nota_detail.is_free = 0
									and barang.intid_jbarang in (9)
									and nota.is_arisan = 0
									and nota.is_dp = 0
									and nota.intid_nota = a.intid_nota
								 ) Vpiece,
								m.strnama_dealer, 
								m.strnama_upline,
								m.intid_dealer,
								cb.strnama_cabang, 
								u.strnama_unit,
								a.intid_week, 
								(select strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $jpenjualan) as strnama_jpenjualan, 
								#diperbarui 05/03/2015
								(select is_omset from jenis_penjualan where intid_jpenjualan = $jpenjualan) as is_omset, 
								#end
								a.intid_jpenjualan,
								a.intpv,
								a.inttotal_omset,
								a.inttotal_bayar,
								a.intkomisi10,
								a.intkomisi15,
								a.intkomisi20,
								a.otherKom
							from nota a inner join nota_detail b on 
										a.intid_nota = b.intid_nota 
									inner join barang c on 
										b.intid_barang = c.intid_barang
									inner join member m on 
										m.intid_dealer = a.intid_dealer 
									inner join unit u on 
										u.intid_unit = a.intid_unit
									inner join cabang cb on 
										cb.intid_cabang = a.intid_cabang
							where  a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
							and a.intid_cabang = $cabang
							and a.intid_jpenjualan = $jpenjualan
							and YEAR(a.datetgl) =  $tahun
							and b.is_free = 0
							and a.is_dp = 0
							and a.is_arisan = 0 group by a.intid_nota) AS Z 
							) AS X
			LEFT JOIN
				(SELECT intid_dealer, intid_jbarang, SUM(hasil) as tradein_t, SUM(asd) as tradein_m, intid_cabang FROM (
					(SELECT * FROM 
						(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, 0 as asd, intid_cabang 
						FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
						INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
						WHERE intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND is_dp = 0 AND intid_jpenjualan = $jpenjualan
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								
							GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
					WHERE intid_jbarang = 1)
UNION 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, 0 as asd, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM 
		`nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE 
			intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) AND intid_jpenjualan = $jpenjualan 
										AND intid_cabang = $cabang and YEAR(datetgl) =  $tahun
								AND is_dp = 0
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2)
) x GROUP BY intid_dealer

	) AS kodebwtmisahinomsettulipdenganmetal
	on X.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
	LEFT JOIN
				(select 
					member.*,
					unit.strnama_unit,
					cabang.strnama_cabang,
					v1.undangan_nota_detail,
					v2.undangan_nota
					from 
					(select 
						member.*
						from nota,member where
						nota.intid_dealer = member.intid_dealer	
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						and YEAR(nota.datetgl) =  $tahun
						group by intid_dealer) member,
					cabang,
					unit,
					(SELECT 
								a.intid_dealer,
								sum(if(b.intvoucher !=0 , 
											if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail
							FROM
								NOTA a, CABANG cb, NOTA_DETAIL b
							WHERE
								a.intid_nota = b.intid_nota
								and cb.intid_cabang = a.intid_cabang
								and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v1,
					(SELECT 
								a.intid_dealer,
								#sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * #if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota  
								'0' undangan_nota
							FROM
								NOTA a, CABANG cb
							WHERE
								 cb.intid_cabang = a.intid_cabang
								 and a.intid_jpenjualan = $jpenjualan
								and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
								and a.intid_cabang = $cabang
								and YEAR(a.datetgl) =  $tahun
								and a.is_vpromo = 0
								and a.is_dp = 0
							GROUP BY a.intid_dealer) as v2
					where 
						member.intid_dealer = v1.intid_dealer
						and member.intid_dealer = v2.intid_dealer
						and member.intid_cabang = cabang.intid_cabang
						and member.intid_unit = unit.intid_unit
						) Y
					ON X.intid_dealer = Y.intid_dealer
						group by X.intid_dealer");
		return $query->result();
		}
		
		function get_CetakPenjualanBulanan_tahun20150812($month, $cabang, $jpenjualan, $tahun) 
		{
			$query = $this->db->query("select intid_week from week where intbulan = $month and inttahun = $tahun");
			foreach($query->result() as $row)
			{
				$result[]['query'] = $this->get_CetakPenjualanMingguan_tahun($row->intid_week,$cabang,$jpenjualan, $tahun);
			
				//$result[]['query'] = $this->db->last_query();
			}
			return $result;
		}
	}
?>