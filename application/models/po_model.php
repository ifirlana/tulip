<?php
class Po_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    private $tbl = 'po';

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0, $nm_cabang)
  	{
        if($offset==""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.strnama_cabang LIKE '%$nm_cabang%' ORDER BY a.intid_po ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
	/*
	///fungsi yang lama
	function get_list_data_filter($limit = 10, $offset = 0, $filter)
  	{
		if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where cabang.strnama_cabang LIKE '%" . $filter['pencarian'] . "%' ORDER BY a.intid_po ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	*/
function get_list_data_pusat($limit = 10, $offset = 0)
  	{
		$temp = "";
        if($offset==""){ $offset=0; }
			$temp = "SELECT a.*, cabang.strnama_cabang 
							FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							where a.no_spkb = '' ORDER BY strnama_cabang ASC  LIMIT $offset,$limit";
		$query = $this->db->query($temp);
        return $query->result();
	}
	/*
	function get_data_sj($id_cabang, $week) {
        
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM surat_jalan a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang and a.intid_week = $week ORDER BY a.intid_sj ASC ");
        return $query->result();
     }
	 */
	 //PO_model
function get_data_sj($id_cabang, $week, $tahun ="" ) {
        
		if(!empty($tahun)){
			
			/* $query = $this->db->query("SELECT a.*, cabang.strnama_cabang 
				FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where cabang.intid_cabang ='".$id_cabang."' and a.week_sj = ".$week." and no_sj != '' and year(tgl_order) = ".$tahun."  ORDER BY time ASC "); */
									
			$query = $this->db->query("SELECT a.*, cabang.strnama_cabang 
				FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where cabang.intid_cabang ='".$id_cabang."' and a.week_sj = ".$week." and no_sj != '' and year(tgl_kirim) = ".$tahun."  ORDER BY time ASC ");
			
		}else{
			
			$query = $this->db->query("SELECT a.*, cabang.strnama_cabang 
					FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where cabang.intid_cabang ='".$id_cabang."' and a.week_sj = ".$week." and no_sj != '' ORDER BY time ASC ");
			}
		return $query->result();
     }
	 
 //PO_model
function get_data_sj_date($id_cabang, $tanggalawal, $tanggalakhir) {
        
			$query = $this->db->query("SELECT a.*, cabang.strnama_cabang 
				FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where cabang.intid_cabang ='".$id_cabang."' and a.tgl_kirim >= '".$tanggalawal."' and a.tgl_kirim <= '".$tanggalakhir."'  ORDER BY time ASC ");
			
		return $query->result();
     }
		
	function selectSpkb ($intid_cabang)
	{
		$query = $this->db->query("select a.intid_po, a.no_spkb, b.strnama_cabang, b.intid_cabang from po a, cabang b where a.intid_cabang = b.intid_cabang and a.is_sj = 0 and a.intid_cabang = $intid_cabang and a.no_spkb <> ' ' ");
	    return $query->result();
	}
	 
	
	function insert($data){
         	$tgl = date("Y-m-d");
       
            $data = array(
			'no_po' => $this->input->post('no_po'),
            'intid_cabang' => $this->input->post('intid_cabang'),
			'intid_week' => $this->input->post('intid_week'),
            'datetgl' => $tgl
            );
        $this->db->insert('po', $data);
        return $this->db->insert_id();
	}
	
	function add($data)
	{
        $this->db->insert("po_detail", $data);
	}
	
	function get_CetakPo($idPo) {
        $query = $this->db->query("SELECT DISTINCT po.intid_po, po.datetgl,po.no_po, po_detail.*,po.intid_cabang, cabang.strnama_cabang, barang.strnama, barang.intid_jsatuan
FROM po
INNER JOIN po_detail ON po.intid_po = po_detail.intid_po
INNER JOIN barang ON po_detail.intid_barang = barang.intid_barang
INNER JOIN cabang ON po.intid_cabang = cabang.intid_cabang
WHERE po.intid_po = '$idPo' order by  barang.strnama asc
");

        return $query->result();
    }
	
	function get_CetakRetur($idR) {
        $query = $this->db->query("SELECT DISTINCT retur.intid_retur, retur.intid_week, retur.datetgl,retur.no_srb, retur_detail.*,retur.intid_cabang, cabang.strnama_cabang, barang.strnama, barang.intid_jsatuan
FROM retur
INNER JOIN retur_detail ON retur.intid_retur = retur_detail.intid_retur
INNER JOIN barang ON retur_detail.intid_barang = barang.intid_barang
INNER JOIN cabang ON retur.intid_cabang = cabang.intid_cabang
WHERE retur.intid_retur = '$idR'");

        return $query->result();
    }
	
	function cek_spkb($id){
       $query = $this->db->query("select no_spkb from po where intid_po = '$id'");
	   return $query->row();
	 
    }
	
		
	function cek_sttb($id){
       $query = $this->db->query("select no_sttb from retur where intid_retur = '$id'");
	   return $query->row();
	 
    }
	
	 function update_spkb($no_spkb, $po){
        
		       $data = array(
            		'no_spkb' => $no_spkb
				);
        $this->db->where('intid_po', $po);
		$this->db->update('po', $data);   

    }
	
	function update_sttb($no_sttb, $retur){
        
		       $data = array(
            		'no_sttb' => $no_sttb, 
					'is_sttb' => 1
				);
        $this->db->where('intid_retur', $retur);
		$this->db->update('retur', $data);   

    }
	
	function get_MaxSj() {
        $this->db->select_max('intid_sj');
		$query = $this->db->get('surat_jalan');
        return $query->row();
     }
	
	function add_surat_jalan($data)
	{
        $this->db->insert("surat_jalan_detail", $data);
	}
	
	
	function get_list_data_sj($limit = 10, $offset = 0, $nm_cabang)
  	{
        if($offset==""){ $offset=0; }		
	
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM surat_jalan a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where a.no_spkb <> '' and a.intid_cabang = '$nm_cabang' ORDER BY a.intid_sj ASC  LIMIT $offset,$limit");
		
        return $query->result();
	} 
	
	function insert_surat_retur($data){
         	$tgl = date("Y-m-d");
       
            $data = array(
			'no_srb' => $this->input->post('no_srb'),
            'intid_cabang' => $this->input->post('intid_cabang'),
			'intid_week' => $this->input->post('intid_week'),
            'datetgl' => $tgl
            );
        $this->db->insert('retur', $data);
        return $this->db->insert_id();
	}
	
	function add_surat_retur($data)
	{
        $this->db->insert("retur_detail", $data);
	}
	
	function countDataRetur()
	{
	  	return $this->db->count_all('retur');
  	}
	
	function get_list_data_retur($limit = 10, $offset = 0, $id_cabang)
  	{
        if($offset==""){ $offset=0; }		
	
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang ORDER BY a.intid_retur ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	function getKartu_Stok($intid_cabang, $tgl, $id_barang){

	  //if($offset==""){ $offset=0; }
	  		
	    /*$query = $this->db->query("select DISTINCT nota.intno_nota,nota.intid_cabang,nota.intid_dealer,nota.datetgl,
		barang.strnama,barang.intid_barang, member.strnama_dealer, member.strkode_dealer,member.strnama_upline, unit.strnama_unit,
		barang.intid_jsatuan, 
		(select max(stok_history.intqty_begin) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang='$intid_cabang' 
		and stok_history.tanggal = '$tgl' and barang.intid_barang = $id_barang
		and stok_history.intno_nota = nota.intno_nota) intqty_begin, 
		(select sum(stok_history.intqty_in) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang='$intid_cabang' 
		and stok_history.tanggal = '$tgl' and barang.intid_barang = $id_barang
		and stok_history.intno_nota = nota.intno_nota) intqty_in, 
		(select sum(stok_history.intqty_out) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang='$intid_cabang' 
		and stok_history.tanggal = '$tgl' and barang.intid_barang = $id_barang
		and stok_history.intno_nota = nota.intno_nota) intqty_out, 
		(select min(stok_history.intqty_end) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang='$intid_cabang' 
		and stok_history.tanggal = '$tgl' and barang.intid_barang = $id_barang
		and stok_history.intno_nota = nota.intno_nota) intqty_end
		FROM nota
		INNER JOIN stok_history ON stok_history.intno_nota = nota.intno_nota
		INNER JOIN cabang ON cabang.intid_cabang = nota.intid_cabang
		INNER JOIN member ON member.intid_dealer = nota.intid_dealer
		INNER JOIN unit ON member.intid_unit = unit.intid_unit
		INNER JOIN nota_detail ON nota_detail.intid_nota = nota.intid_nota
		INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang
		WHERE nota.intid_cabang = '$intid_cabang'
		and nota.datetgl = '$tgl'
		and nota_detail.intid_barang = $id_barang
		ORDER BY nota.intid_nota");*/
		$query = $this->db->query("");
		
		return $query->result();
    }
	//////////////line ikhlas 03042013///////////////////////////
		/////fungsi sebelumnya
  /*
	function getLap_Stok_cab($intid_cabang, $week){

	   	$weekbefore = $week - 1;		
		$query = $this->db->query("SELECT a.strnama, a.intid_jsatuan, 
		(select intqty_begin
		from stok_history 
		where intid_barang = a.intid_barang
		and id = 
		(select max(id) 
		from stok_history 
		where intid_barang = a.intid_barang
		and stok_history.intid_week = $weekbefore and stok_history.intid_cabang = $intid_cabang)) intqty_begin,
		(select sum(stok_history.intqty_in) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang = $intid_cabang 
		and stok_history.intid_week = $week 
		and stok_history.intid_barang = a.intid_barang) intqty_in, 
		(select sum(stok_history.intqty_out) qty from stok_history
		inner join barang on barang.intid_barang = stok_history.intid_barang
		where stok_history.intid_cabang = $intid_cabang 
		and stok_history.intid_week = $week
		and stok_history.intid_barang = a.intid_barang) intqty_out
		FROM barang a
		ORDER BY a.strnama ASC");		
	    return $query->result();
    }
	*/
	///fungsi yang baru
	//line ikhlas 03042013 masih banyak yang diperbaiki
	//pa perlu di buat intquantity_skrg untuk mengurangi penjumalahan sebelumnya
	function getLap_Stok_cab($intid_cabang, $week){

	   	$weekbefore = $week-1;		
		$query = $this->db->query("SELECT a.strnama, a.intid_jsatuan, 
		(
		if((select count(jumlah) from stok_barang where  intid_cabang = $intid_cabang and stok_barang.intid_barang = a.intid_barang) > 0,
			(select jumlah from stok_barang where  intid_cabang = $intid_cabang and stok_barang.intid_barang = a.intid_barang),0) 
		- if((select count(z.total) from 
				(select ndt.intid_barang, na.intid_week intid_week,
					( select sum(nota_detail.intquantity)
							from nota  inner join nota_detail  on nota.intid_nota = nota_detail.intid_nota 
							where nota.intid_cabang = $intid_cabang
							and nota.intid_week <= $weekbefore
							and nota_detail.intid_barang = ndt.intid_barang) total
						from
							 nota na inner join nota_detail ndt on na.intid_nota = ndt.intid_nota
						where  na.intid_week <= $weekbefore
						and na.intid_cabang = $intid_cabang
						group by ndt.intid_barang
					)as z,
			(select as_of_date,week.intid_week,stok_barang.intid_barang
				from stok_barang inner join week on week.intbulan = stok_barang.as_of_date 
				where week.intid_week <= $weekbefore
				and stok_barang.intid_cabang = $intid_cabang
				)as x 
				where 
				x.intid_week = z.intid_week 
				and z.intid_barang = x.intid_barang
				and z.intid_barang = a.intid_barang) > 0,
			(select z.total from 
				(select ndt.intid_barang, na.intid_week intid_week,
					( select sum(nota_detail.intquantity)
							from nota  inner join nota_detail  on nota.intid_nota = nota_detail.intid_nota 
							where nota.intid_cabang = $intid_cabang
							and nota.intid_week <= $weekbefore
							and nota_detail.intid_barang = ndt.intid_barang) total
						from
							 nota na inner join nota_detail ndt on na.intid_nota = ndt.intid_nota
						where  na.intid_week <= $weekbefore
						and na.intid_cabang = $intid_cabang
						group by ndt.intid_barang
					)as z,
				(select as_of_date,week.intid_week,stok_barang.intid_barang	from 
					stok_barang inner join week on week.intbulan = stok_barang.as_of_date 
					where week.intid_week <= $weekbefore
					and stok_barang.intid_cabang = $intid_cabang
					)as x 
		where 
			x.intid_week = z.intid_week 
			and z.intid_barang = x.intid_barang
			and z.intid_barang = a.intid_barang),0)) intqty_begin,
		(select sum(stok_history.intqty_in) qty 
			from 
				stok_history inner join barang on barang.intid_barang = stok_history.intid_barang
			where stok_history.intid_cabang = $intid_cabang 
				and stok_history.intid_week = $week 
				and stok_history.intid_barang = a.intid_barang) intqty_in, 
		(select if((select count(intquantity) 
		from nota n inner join nota_detail nd on n.intid_nota=nd.intid_nota 
			where n.intid_week = $week 
			and n.intid_cabang = $intid_cabang 
			and nd.intid_barang = a.intid_barang) > 0,(select sum(intquantity) 
		from nota n inner join nota_detail nd on n.intid_nota=nd.intid_nota 
			where n.intid_week = $week 
			and n.intid_cabang = $intid_cabang 
			and nd.intid_barang = a.intid_barang),0)
		) intqty_out
		FROM barang a
		ORDER BY a.strnama ASC");		
	    return $query->result();
    }
		
	function getLap_Stok_Op($limit = 10, $offset = 0,$intid_cabang, $tgl){
		
		$thn = date("Y");
		if($offset==""){ $offset=0; }
		
	   $query = $this->db->query("SELECT a.intid_barang, a.strnama, a.intid_jsatuan,
		
		(select (sum(stok.intqty_begin)+sum(stok.intqty_in)-sum(stok.intqty_out)) qty from stok
		inner join barang on barang.intid_barang = stok.intid_barang
		where barang.intid_jsatuan=2 and stok.intid_cabang='$intid_cabang' 
		and stok.tanggal between '$thn-01-01' and '$tgl' and barang.intid_barang = a.intid_barang 
		)as pcs_akhir,
		
		(select (sum(stok.intqty_begin)+sum(stok.intqty_in)-sum(stok.intqty_out)) qty from stok
		inner join barang on barang.intid_barang = stok.intid_barang
		where barang.intid_jsatuan=1 and stok.intid_cabang='$intid_cabang' 
		and stok.tanggal between '$thn-01-01' and '$tgl' and barang.intid_barang = a.intid_barang 
		)as set_akhir
		
		FROM barang a
		ORDER BY a.intid_barang");
		
	   return $query->result();
    }
	
	function countDataSttb()
	{
	  	return $this->db->count_all('sttb');
  	}
	
	function get_list_data_cari($limit = 10, $offset = 0, $no_po)
  	{
        if($offset==""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang WHERE a.no_po LIKE '%$no_po%' ORDER BY a.intid_po ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	function get_list_data_detail($id)
  	{
       $query = $this->db->query("SELECT DISTINCT po.intid_po, po.no_spkb, po.datetgl, po_detail.*,po.intid_cabang, cabang.strnama_cabang, barang.strnama, barang.intid_jsatuan
		FROM po
		INNER JOIN po_detail ON po.intid_po = po_detail.intid_po
		INNER JOIN barang ON po_detail.intid_barang = barang.intid_barang
		INNER JOIN cabang ON po.intid_cabang = cabang.intid_cabang
		where po.intid_po = $id
		ORDER BY barang.strnama ASC");
        return $query->result();
	}
	
	function selectBarang($keyword){

        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama
		from barang a
		where  a.strnama like '$keyword%'");
        return $query->result();
		}
	
	function selectBarangSj($keyword){

        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, 0 AS intqty_end 
		from barang a
		where 
		a.status_barang = 1
		and a.strnama like '$keyword%'");
        return $query->result();
	}
    function selectBarangRetur($keyword){

        $query = $this->db->query("SELECT a.intid_barang, UPPER(a.strnama) strnama, b.strnama_jsatuan
                                    FROM barang a
                                    INNER JOIN jenis_satuan b  ON a.intid_jsatuan = b.intid_jsatuan
                                    WHERE a.strnama like '$keyword%'");
        return $query->result();
	}
	 function update_po($po){
        
		       $data = array(
            		'is_sj' => 1
				);
        $this->db->where('intid_po', $po);
		$this->db->update('po', $data);   

    }
	
	function spkb($id){
       $query = $this->db->query("select no_spkb from po where intid_po = '$id'");
	   return $query->result();
	 
    }
	
	function selectWeek()
	{
		$query = $this->db->query("select id, intid_week from week where curdate() between dateweek_start and dateweek_end");
	    return $query->result();
	}
	
	function insertSj($data){
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$data = array(
            'no_sj' => $this->input->post('no_sj'),
            'no_spkb' => $this->input->post('no_spkb'),
			'no_srb' => $this->input->post('no_srb'),
            'intid_cabang' => $this->input->post('intid_cabang'),
			'intid_week' => $intid_week,
			'tgl_order' => $this->input->post('tgl_order'),
			'tgl_kirim' => $this->input->post('tgl_kirim'),
			'via' => $this->input->post('via')
		);
        $this->db->insert('surat_jalan', $data);
		return $this->db->insert_id();
	}
	
	function selectCabang($keyword){
        $query = $this->db->query("select intid_cabang, upper(strnama_cabang) strnama_cabang from cabang where strnama_cabang like '$keyword%'");
        return $query->result();
	}
	
	function get_cetak_surat_jalan($idPo) {
        $query = $this->db->query("SELECT surat_jalan_detail.*,surat_jalan.intid_cabang,surat_jalan.no_sj, cabang.strnama_cabang, barang.strnama, surat_jalan.intid_week, surat_jalan.no_spkb, surat_jalan.via, surat_jalan.tgl_order, surat_jalan.tgl_kirim, barang.intid_jsatuan
FROM surat_jalan
INNER JOIN surat_jalan_detail ON surat_jalan.intid_sj = surat_jalan_detail.intid_sj
INNER JOIN barang ON surat_jalan_detail.intid_barang = barang.intid_barang
INNER JOIN cabang ON surat_jalan.intid_cabang = cabang.intid_cabang
                                    WHERE surat_jalan.intid_sj = '$idPo' order by barang.strnama asc");

        return $query->result();
     }
	 
	function get_cetak_surat_retur($id) {
        $query = $this->db->query("SELECT retur.datetgl, retur_detail.*,retur.intid_cabang,retur.no_srb, cabang.strnama_cabang, barang.strnama, retur.intid_week, barang.intid_jsatuan
FROM retur
INNER JOIN retur_detail ON retur.intid_retur = retur_detail.intid_retur
INNER JOIN barang ON retur_detail.intid_barang = barang.intid_barang
INNER JOIN cabang ON retur.intid_cabang = cabang.intid_cabang
                                    WHERE retur.intid_retur = '$id'");

        return $query->result();
     }
	 
	function get_list_data_filter_retur($limit = 10, $offset = 0, $filter)
  	{
		if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where a.is_sttb = 0 and cabang.strnama_cabang LIKE '%" . $filter['cari'] . "%' ORDER BY a.intid_retur ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	function get_list_retur_data($limit = 10, $offset = 0)
  	{
        if($offset==""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where a.is_sttb = 0 ORDER BY a.intid_retur ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
		
	function get_list_data_retur_detail($id)
  	{
       $query = $this->db->query("SELECT DISTINCT retur.intid_retur, retur.no_srb, retur.datetgl, retur_detail.*,retur.intid_cabang, cabang.strnama_cabang, barang.strnama, barang.intid_jsatuan
		FROM retur
		INNER JOIN retur_detail ON retur.intid_retur = retur_detail.intid_retur
		INNER JOIN barang ON retur_detail.intid_barang = barang.intid_barang
		INNER JOIN cabang ON retur.intid_cabang = cabang.intid_cabang
		where retur.intid_retur = $id
		ORDER BY retur.intid_retur ASC");
        return $query->result();
	}
	
	function selectSrb ($intid_cabang)
	{
		$query = $this->db->query("select a.intid_retur, a.no_srb, b.strnama_cabang, b.intid_cabang 
from retur a, cabang b where a.intid_cabang = b.intid_cabang and a.intid_cabang = $intid_cabang");
	    return $query->result();
	}
	
	function srb($id){
       $query = $this->db->query("select no_srb from retur where intid_retur = '$id'");
	   return $query->result();
	 
    }
	
	function insert_sttb($data){
        $this->db->insert('sttb', $data);
        return $this->db->insert_id();
	}
	
	function update_retur($po){
        
		       $data = array(
            		'is_sttb' => 1
				);
        $this->db->where('intid_retur', $po);
		$this->db->update('retur', $data);   

    }
	
	function add_sttb($data)
	{
        $this->db->insert("sttb_detail", $data);
	}
	
	function get_cetak_surat_sttb($id) {
        $query = $this->db->query("SELECT retur.datetgl, retur_detail.*,retur.intid_cabang, cabang.strnama_cabang, barang.strnama, retur.intid_week, retur.no_srb, retur.no_sttb, barang.intid_jsatuan
FROM retur
INNER JOIN retur_detail ON retur.intid_retur= retur_detail.intid_retur
INNER JOIN barang ON retur_detail.intid_barang = barang.intid_barang
INNER JOIN cabang ON retur.intid_cabang = cabang.intid_cabang
WHERE retur.intid_retur = '$id'");
        return $query->result();
     }
	 
	 function get_MaxSttb() {
        $this->db->select_max('intid_sttb');
		$query = $this->db->get('sttb');
        return $query->row();
    }
	
	function get_data_sttb($id_cabang, $week) {
        
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM sttb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where cabang.intid_cabang = $id_cabang and a.intid_week = $week ORDER BY a.intid_sttb ASC ");
        return $query->result();
    }
	
	function addStok($id, $reg_pcs, $reg_set, $free_pcs, $free_set, $id_cabang) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intid_jsatuan from barang where intid_barang = $id");
        $jsatuan = $i->result();
		
		if (!empty($reg_pcs)){
			$qty = $reg_pcs;
		} else if (!empty($reg_set)){
			$qty = $reg_set;
		} else if (!empty($free_pcs)){
			$qty = $free_pcs;
		}else if (!empty($free_set)){
			$qty = $free_set;
		}
	
		$data = array(
            'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_in' => $qty,
			'tanggal' => $tgl
		);
        $this->db->insert('stok', $data);
		$intid_stok =$this->db->insert_id();
		$data1 = array(
            'intid_stok' => $intid_stok,
			'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_in' => $qty,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data1);
     }
	 
	 function minusStok($id, $qty, $id_cabang) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intqty_end from stok where intid_barang = $id and intid_cabang = $id_cabang");
        $qtyendbefore = $i->result();
		$qtyend = $qtyendbefore[0]->intqty_end;
		$qtyendafter = $qtyend - $qty;
		
		$data = array(
            'intid_barang' => $id,
            'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'tanggal' => $tgl
		);
        $this->db->where('intid_barang', $id);
		$this->db->where('intid_cabang', $id_cabang);
		$this->db->update('stok', $data);
		$data1 = array(
            'intid_barang' => $id,
            'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data1);
	}	
	
	function addStokPusat($id, $qty, $free_set) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intqty_end from stok where intid_barang = $id and intid_cabang = 1");
        $qtyendbefore = $i->result();
		$qtyend = $qtyendbefore[0]->intqty_end;
		$qtyendpusat = $qtyend + $qty;
		$data2 = array(
            'intid_barang' => $id,
            'intid_cabang' => 1,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_in' => $qty,
			'intqty_end' => $qtyendpusat,
			'tanggal' => $tgl
		);
        $this->db->where('intid_barang', $id);
		$this->db->where('intid_cabang', 1);
		$this->db->update('stok', $data2);
		$data3 = array(
            'intid_barang' => $id,
            'intid_cabang' => 1,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_in' => $qty,
			'intqty_end' => $qtyendpusat,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data3);
		
     }
	 
	 function endStok($id, $selisihpcs, $selisihset, $id_cabang) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intid_jsatuan from barang where intid_barang = $id");
        $jsatuan = $i->result();
		
		if (!empty($selisihpcs)){
			$qty = $selisihpcs;
		} 
		if (!empty($selisihset)){
			$qty = $selisihset;
		} 
	
		/*$data = array(
            'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_end' => $qty,
			'tanggal' => $tgl
		);
        $this->db->insert('stok', $data);
		$intid_stok =$this->db->insert_id();
		$data1 = array(
            'intid_stok' => $intid_stok,
			'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => $id_cabang,
            'intid_week' => $intid_week,
			'intqty_end' => $qty,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data1);*/
		
		     $data = array(
             'intqty_end' => $qty
			 );
        $this->db->where('intid_stok', $id);
		$this->db->update('stok', $data);
     }
	 
	function get_CetakPengeluaranBarangMingguan($week, $cabang)
	{
		
		$query = $this->db->query("SELECT SUM(intquantity) AS intquantity, strnama, intid_jsatuan FROM (
						select c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and a.is_dp = 0
								and a.is_arisan = 0
								group by b.intid_barang
								UNION
								select c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_nota = e.intid_arisan_detail
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and a.is_dp = 0
								and a.is_arisan = 1
								and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
								group by b.intid_barang
								UNION
								select '' AS intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota_hadiah a, nota_detail_hadiah b, barang_hadiah c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang_hadiah
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								group by b.intid_barang
								UNION
								select c.intid_barang,sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
								from retur a, retur_detail b, barang c, jenis_satuan d
								where a.intid_retur = b.intid_retur
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								group by b.intid_barang
								UNION
								select b.intid_barang, sum(b.quantity) intquantity, c.strnama, d.intid_jsatuan
								from retur_ a inner join retur_detail_ b on b.no_srb = a.no_srb 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.intid_week = $week 
								and a.intid_cabang = $cabang
								group by b.intid_barang
								UNION
								select b.intid_barang, sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
								from retur_sparepart a inner join retur_sparepart_detail b on b.intid_retur_sparepart = a.intid_retur_sparepart 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.intid_week = $week 
								and a.intid_cabang = $cabang
								and a.is_sttb = 1
								and (a.no_sttb !='' or a.no_sttb is not null)
								group by b.intid_barang
						) AS RPB GROUP BY intid_barang");
        return $query->result();
	}
	
	function get_CetakPengeluaranBarangMingguanPusat($week)
	{
		
		$query = $this->db->query("select sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
		from surat_jalan a, surat_jalan_detail b, barang c, jenis_satuan d
		where a.intid_sj = b.intid_sj
		and b.intid_barang = c.intid_barang
		and c.intid_jsatuan = d.intid_jsatuan
		and a.intid_week = $week
		group by b.intid_barang; ");
        return $query->result();
	}
	
	function get_HutangBarang($week, $cabang)
	{
		
		$query = $this->db->query("select sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
		from po a, po_detail b, barang c, jenis_satuan d
		where a.intid_po = b.intid_po
		and b.intid_barang = c.intid_barang
		and c.intid_jsatuan = d.intid_jsatuan
		and a.intid_week = $week
		and a.intid_cabang = $cabang
		and b.`status` = '0'
		group by b.intid_barang");
        return $query->result();
	}
	
	function inputStok($id) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intid_jsatuan from barang where intid_barang = $id");
        $jsatuan = $i->result();
		
		$data = array(
            'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => 1,
            'intid_week' => $intid_week,
			'tanggal' => $tgl
		);
        $this->db->insert('stok', $data);
		/*$intid_stok =$this->db->insert_id();
		$data1 = array(
            'intid_stok' => $intid_stok,
			'intid_barang' => $id,
            'intid_jsatuan' => $jsatuan[0]->intid_jsatuan,
			'intid_cabang' => 1,
            'intid_week' => $intid_week,
			'intqty_begin' => $qty,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data1);*/
	}
	
	function get_Barang($id_po)
	{
		$query = $this->db->query("select upper(c.strnama) strnama, b.qty, b.ket, c.intid_jsatuan, d.intqty_end, b.intid_barang, a.intid_po, a.no_spkb
		from po a, po_detail b, barang c, stok d
		where a.intid_po = b.intid_po
		and b.intid_barang = c.intid_barang
		and c.intid_barang = d.intid_barang
		and d.intid_cabang = 1
		and a.intid_po in ($id_po)");
        return $query->result();
	}
	
	function getBarang()
	{
		$query = $this->db->query("select * from barang");
        return $query->result();
	}
     
    function get_MaxPo() {
        $this->db->select_max('intid_po');
		$query = $this->db->get('po');
        return $query->row();
    }
	
	function get_MaxPoNew() {
        $this->db->select('id');
		$query = $this->db->get('counter_po');
        return $query->result();
	}
	
	 function get_MaxPoUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_po', $data);

    } 
	
	function get_MaxRetur() {
        $this->db->select_max('intid_retur');
		$query = $this->db->get('retur');
        return $query->row();
    }
	
	function get_MaxReturNew() {
        $this->db->select('id');
		$query = $this->db->get('counter_retur');
        return $query->result();
	}
	
	function get_MaxReturUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_retur', $data);

    }
	
	function get_MaxSjNew() {
        $this->db->select('id');
		$query = $this->db->get('counter_sj');
        return $query->result();
	}
	
	function get_MaxSjUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_sj', $data);

    } 
	
	function tambahStok($id, $qty, $cabang, $no_nota) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intqty_end from stok where intid_barang = $id and intid_cabang = $cabang");
        $qtyendbefore = $i->result();
		$qtyend = $qtyendbefore[0]->intqty_end;
		$qtyendafter = $qtyend + $qty;
		$data = array(
            'intid_barang' => $id,
            'intid_cabang' => $cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'tanggal' => $tgl
		);
        $this->db->where('intid_barang', $id);
		$this->db->where('intid_cabang', $cabang);
		$this->db->update('stok', $data);
		$intid_stok =$this->db->insert_id();
		$data1 = array(
            'intid_stok' => $intid_stok,
			'intno_nota' => $no_nota,
			'intid_barang' => $id,
            'intid_cabang' => $cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history', $data1);
     }
	 
	function get_BarangRetur($id_retur)
	{
		$query = $this->db->query("select upper(c.strnama) strnama, b.qty, b.ket, c.intid_jsatuan, d.intqty_end, b.intid_barang, a.intid_retur, a.no_srb
		from retur a, retur_detail b, barang c, stok d
		where a.intid_retur = b.intid_retur
		and b.intid_barang = c.intid_barang
		and c.intid_barang = d.intid_barang
		and d.intid_cabang = 1
		and a.intid_retur in ($id_retur)");
        return $query->result();
	}
	
	function updatePo($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->update('po_detail',$data);
	}
	
	function updatePoSj($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->update('po',$data);
		
	}
	
	function add_surat_jalanid($data)
	{
		return $this->db->insert('surat_jalan_detail',$data);
	}
	//berkurangnya stok pusat
	function get_stokpusat($where) {
		/*if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		//return $this->db->get('stok', $data);
		return $this->db->get('stok');*/
		$query = $this->db->query("select * from stok where intid_barang = $where and intid_cabang = 1");
        return $query->result();
	}
	
	function updateStokPusat($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->update('stok',$data);
		
	}
	
	function insertstokhistory($data)
	{
		return $this->db->insert('stok_history',$data);
	}
	//bertambahnya stok cabang yang di kirim sj
	function get_stokcab($where, $data) {
		/*if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->get('stok', $data);*/
		$query = $this->db->query("select * from stok where intid_barang = $where and intid_cabang = $data");
        return $query->result();
	}
	
	function updateStokCab($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->update('stok',$data);
		
	}
	
	function insertstokhistorycab($data)
	{
		return $this->db->insert('stok_history',$data);
	}
	
	function selectNota($keyword){

        $query = $this->db->query("select b.strnama_dealer, b.strnama_upline, c.strnama_unit
		from nota a, member b, unit c
		where a.intid_dealer = b.intid_dealer 
		and a.intid_unit = c.intid_unit
		and a.intno_nota like '$keyword%'");
        return $query->result();
   }
   ////////////////ikhlas 05042013/////////
   function count_table_rows($table = ''){
		return $this->db->count_all($table);
   }
   function count_table_rows_po($var1){
		$temp = $this->db->query("select count(*) from po inner join cabang on cabang.intid_cabang = po.intid_cabang where cabang.strnama_cabang like '%".$var1."%' and po.no_spkb = '' ");
		return $temp->num_rows();
   }
   function get_list_data_filter($limit , $offset , $filter,$intid_week)
  	{
		if($limit == 0){
			$text = "";
		}else{
			$text = "LIMIT $offset,$limit";
		}
		if($offset==""){ $offset=0; }
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang 
							FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							where a.no_spkb = '' AND a.intid_week = '".$intid_week."' AND cabang.strnama_cabang LIKE '%" . $filter . "%'  ORDER BY strnama_cabang ASC ".$text);
	/*
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM po a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where cabang.strnama_cabang LIKE '%" . $filter . "%' ORDER BY a.intid_po ASC  LIMIT $offset,$limit");
	*/
        return $query->result();
	}
	///////////////////////////////////////ending//////////////
	///////////////////////////////line ikhlas 08042013 
	//////////digunakan untuk mencari stok barang dan po barang 
	/*
	function get_Barang_stok($id_po,$id_cabang)
	{
		$query = $this->db->query("select upper(c.strnama) strnama, 
												b.qty, 
												b.ket, 
												c.intid_jsatuan, 
												d.intqty_end, 
												b.intid_barang, 
												a.intid_po,
												a.no_spkb,
												(select jumlah - if((select sum(intquantity) jumlah from 
nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week  
where nota.intid_cabang = $id_cabang
and nota_detail.intid_barang = b.intid_barang
)>0,(select sum(intquantity) jumlah from 
nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week  
where nota.intid_cabang = $id_cabang
and nota_detail.intid_barang = b.intid_barang),0) jumlah 
from stok_barang 
where stok_barang.intid_cabang = $id_cabang 
and stok_barang.intid_barang = b.intid_barang) jumlah
		from po a, po_detail b, barang c, stok d
		where a.intid_po = b.intid_po
		and b.intid_barang = c.intid_barang
		and c.intid_barang = d.intid_barang
		and d.intid_cabang = $id_cabang
		and a.intid_po in ($id_po)");
       return $query->result();
	}
	*/
	//////tanggal 09042013 ikhlas firlana
	/////sudah dikurangi dengan stok_history
	function get_Barang_stok($id_po,$id_cabang)
	{
		$query = $this->db->query("select upper(c.strnama) strnama, 
												b.qty, 
												b.ket, 
												c.intid_jsatuan, 
												d.intqty_end, 
												b.intid_barang, 
												a.intid_po,
												a.no_spkb,
												(select jumlah - if((select sum(intquantity) jumlah 
																			from nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week  
																				where nota.intid_cabang = $id_cabang
																				and nota_detail.intid_barang = b.intid_barang
																				and week.intbulan >= stok_barang.as_of_date)>0,
																			(select sum(intquantity) jumlah 
																			from nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week  
																				where nota.intid_cabang = $id_cabang
																				and nota_detail.intid_barang = b.intid_barang
																				and week.intbulan >= stok_barang.as_of_date),0) 
																	+ if((select sum(stok_history.intqty_in) qty 
																				from stok_history inner join barang on barang.intid_barang = stok_history.intid_barang inner join week on week.intid_week = stok_history.intid_week
																				where stok_history.intid_cabang = $id_cabang 
																				and week.intbulan >= stok_barang.as_of_date
																				and stok_history.intid_barang = stok_barang.intid_barang) > 0,
																				(select sum(stok_history.intqty_in) qty 
																				from stok_history inner join barang on barang.intid_barang = stok_history.intid_barang inner join week on week.intid_week = stok_history.intid_week
																				where stok_history.intid_cabang = $id_cabang  
																				and week.intbulan >= stok_barang.as_of_date
																				and stok_history.intid_barang = stok_barang.intid_barang),0) jumlah
														from stok_barang 
														where stok_barang.intid_cabang = $id_cabang 
														and stok_barang.intid_barang = b.intid_barang) jumlah, 
												(select jumlah - if((select sum(intquantity) 
																				from nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week
																				where nota_detail.intid_barang = stok_barang.intid_barang
																				and week.intbulan >= stok_barang.as_of_date)>0,
																				(select sum(intquantity) 
																				from nota inner join nota_detail on nota.intid_nota = nota_detail.intid_nota inner join week on week.intid_week = nota.intid_week
																				where nota_detail.intid_barang = stok_barang.intid_barang
																				and week.intbulan >= stok_barang.as_of_date),0) 
																		+	if((select sum(stok_history.intqty_in) qty 
																				from stok_history inner join barang on barang.intid_barang = stok_history.intid_barang inner join week on week.intid_week = stok_history.intid_week
																				where stok_history.intid_cabang = 1 
																				and week.intbulan >= stok_barang.as_of_date
																				and stok_history.intid_barang = stok_barang.intid_barang) > 0,
																				(select sum(stok_history.intqty_in) qty 
																				from stok_history inner join barang on barang.intid_barang = stok_history.intid_barang inner join week on week.intid_week = stok_history.intid_week
																				where stok_history.intid_cabang = 1  
																				and week.intbulan >= stok_barang.as_of_date
																				and stok_history.intid_barang = stok_barang.intid_barang),0) 
													from stok_barang 
													where
													stok_barang.intid_cabang = 1 
													and stok_barang.intid_barang= b.intid_barang 
												) jumlah_pusat
		from po a, po_detail b, barang c, stok d
		where a.intid_po = b.intid_po
		and b.intid_barang = c.intid_barang
		and c.intid_barang = d.intid_barang
		and d.intid_cabang = $id_cabang
		and a.intid_po in ($id_po) order by c.strnama ASC");
       return $query->result();
	}
	////////////////////ending///////////////////
	//line ikhlas 26APRIL2013
	//009
	/**
	* untuk proses po sparepart
	* @param selectSrsp(intid_cabang)
	* @param get_retur_surat_jalan($id,$id_cabang,$week)
	* @param insertSj_SP($data)
	* @param updateSparepartdetail($where, $data)
	* @param add_Stok_history_Sparepart($no_srsp,$week,$id_sparepart,$id_cabang,$qty,$status)
	* @param get_MaxReturSparePart()
	* @param get_MaxReturSparePartUpdate($id)
	* @param insert_surat_retur_sparepart($data)
	* @param add_surat_retur_sparepart($data)
	* @param get_CetakRetur_Sparepart($idR)
	* @param cek_sttb_sparepart($id)
	* @param update_sttb_sparepart($no_sttb, $retur)
	* @param get_all_sparepartdetail($id)
	* TABLE retur_sparepart, cabang, retur_sparepart_detail, barang_sparepart, stok_history_sparepart
	*/
	function selectSrsp ($intid_cabang)
	{
		 $query = $this->db->query("select a.intid_retur_sparepart, 
			a.no_srsp, 
			b.strnama_cabang, 
			b.intid_cabang 
		from retur_sparepart a, cabang b 
		where a.intid_cabang = b.intid_cabang 
		and a.intid_cabang = $intid_cabang 
		and a.no_srsp <> '' 
		and  a.is_sj = 0
		and  a.is_sttb = 1
		");
	    return $query->result();
	}
	function get_retur_surat_jalan($id,$id_cabang,$week){
		$query = $this->db->query('select 
			bs.strnama_sparepart strnama,
			rsd.qty,
			rsd.ket,
			rsd.intid_barang intid_barang,
			rs.intid_retur_sparepart,
			rs.no_srsp
			from 
				retur_sparepart_detail rsd inner join retur_sparepart rs on rs.intid_retur_sparepart = rsd.intid_retur_sparepart, 
				barang_sparepart bs
			where 
				rs.intid_week = "'.$week.'" 
				and rs.intid_cabang = "'.$id_cabang.'" 
				and rs.intid_retur_sparepart = "'.$id.'"
				and rsd.intid_barang = bs.id_sparepart
				');
		return $query->result();
	}
	function insertSj_SP($data){
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$data = array(
            'no_sj' => $this->input->post('no_sj'),
            'no_spkb' => $this->input->post('no_spkb'),
			'no_srb' => $this->input->post('no_srb'),
			'no_srsp' => $this->input->post('no_srsp'),
            'intid_cabang' => $this->input->post('intid_cabang'),
			'intid_week' => $intid_week,
			'tgl_order' => $this->input->post('tgl_order'),
			'tgl_kirim' => $this->input->post('tgl_kirim'),
			'via' => $this->input->post('via')
		);
        $this->db->insert('surat_jalan', $data);
		return $this->db->insert_id();
	}
	function updateSparepartdetail($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
				//echo $key.", ".$val."<br />";
			endforeach;
		endif;
		return $this->db->update('retur_sparepart_detail',$data);
	}
	function updateSparepartSj($where, $data)
	{
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
				//echo $key.", ".$val."<br />";
			endforeach;
		endif;
		return $this->db->update('retur_sparepart',$data);
		
	}
	function add_Stok_history_Sparepart($no_srsp,$week,$id_sparepart,$id_cabang,$qty,$status){
		$data = array (
			'keterangan_surat' => $no_srsp,
			'date_added' => date('Y').'-'.date('m').'-'.date('d'),
			'intid_week' => $week,
			'id_sparepart' => $id_sparepart,
			'intid_cabang' => $id_cabang,
			'jumlah' => $qty,
			'status' => $status
		);
		$this->db->insert('stok_history_sparepart',$data);
	}
	//line ikhlas firlana 29April2013
	function get_MaxReturSparePart() {
        $this->db->select('id');
		$query = $this->db->get('counter_retur_sparepart');
        return $query->result();
	}
	function get_MaxReturSparePartUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_retur_sparepart', $data);

    }
	function insert_surat_retur_sparepart($data){
         	$tgl = date("Y-m-d");
       
            $data = array(
			'no_srsp' => $this->input->post('no_srsp'),
            'intid_cabang' => $this->input->post('intid_cabang'),
			'intid_week' => $this->input->post('intid_week'),
			'intid_dealer' => $this->input->post('intid_dealer'),
			'is_verified'	=> 1,
            'datetgl' => $tgl
            );
        $this->db->insert('retur_sparepart', $data);

        return $this->db->insert_id();
	}
	function insert_surat_retur_sparepart_copy($data)
	{
		$ins = array(
			'sj_number' => $this->input->post('no_srsp'),
			'id_branch' => $this->input->post('intid_cabang'),
			'branch_name' => $this->input->post('intid_cabang'),
			'id_destination' => 145,
			'destination_name' => 'Bizpark',
			'active' => 0,
			'week' => $this->input->post('intid_week'),
			'date' => date('Y-m-d H:i:s'),
			'info' => 0,
			'reg_by' => $this->input->post('intid_dealer')
			);
		//$this->db->insert('_sj', $ins);

		return $this->input->post('no_srsp');
	}
	function add_surat_retur_sparepart($data)
	{
        $this->db->insert("retur_sparepart_detail", $data);
	}
	function add_surat_retur_sparepart_copy($data)
	{
        $this->db->insert("_sj_details", $data);
	}
	function get_CetakRetur_Sparepart($idR) {
        $query = $this->db->query("SELECT DISTINCT retur_sparepart.intid_retur_sparepart, retur_sparepart.intid_week, retur_sparepart.datetgl,retur_sparepart.no_srsp, retur_sparepart_detail.*,retur_sparepart.intid_cabang, cabang.strnama_cabang, barang_sparepart.strnama, retur_sparepart.intid_dealer,
		(select strnama_dealer from member where member.intid_dealer = retur_sparepart.intid_dealer) nama_dealer 
FROM retur_sparepart
INNER JOIN retur_sparepart_detail ON retur_sparepart.intid_retur_sparepart = retur_sparepart_detail.intid_retur_sparepart
INNER JOIN barang barang_sparepart ON retur_sparepart_detail.intid_barang = barang_sparepart.intid_barang
INNER JOIN cabang ON retur_sparepart.intid_cabang = cabang.intid_cabang
WHERE retur_sparepart.intid_retur_sparepart = ".$idR."");

        return $query->result();
    }
	function cek_sttb_sparepart($id){
       $query = $this->db->query("select no_sttb from retur_sparepart where intid_retur_sparepart = '$id'");
	   return $query->row();
	 
    }
	function update_sttb_sparepart($no_sttb, $retur){
        
		       $data = array(
            		'no_sttb' => $no_sttb, 
					'is_sttb' => 1
				);
        $this->db->where('intid_retur_sparepart', $retur);
		$this->db->update('retur_sparepart', $data);   

    }
	function get_all_sparepartdetail($id){
		$query = $this->db->query('select *,(select strnama_dealer from member where member.intid_dealer = r.intid_dealer) nama_dealer from retur_sparepart r inner join retur_sparepart_detail rd on r.intid_retur_sparepart = rd.intid_retur_sparepart where rd.intid_retur_sparepart = '.$id.'');
		return $query->result();
	}
	function selectBarangSparePart($keyword){

        $query = $this->db->query("select a.id_sparepart, upper(a.strnama_sparepart) strnama
		from barang_sparepart a
		where  a.strnama_sparepart like '$keyword%'");
        return $query->result();
		}
	function get_cetak_surat_retur_sparepart($id) {
        $query = $this->db->query("SELECT retur_sparepart.datetgl, 
		retur_sparepart_detail.*,
		retur_sparepart.intid_cabang,
		retur_sparepart.no_srsp,
		if(retur_sparepart.intid_dealer =0,0,(select strnama_dealer from member where member.intid_dealer = retur_sparepart.intid_dealer)) nama_dealer,
		if(retur_sparepart.intid_dealer =0,0,(select strnama_unit from member,unit 
			where 
			unit.intid_unit = member.intid_unit
			and member.intid_dealer = retur_sparepart.intid_dealer))nama_unit,
		cabang.strnama_cabang, 
		barang_sparepart.strnama, 
		retur_sparepart.intid_week
			FROM retur_sparepart INNER JOIN retur_sparepart_detail ON retur_sparepart.intid_retur_sparepart = retur_sparepart_detail.intid_retur_sparepart
			INNER JOIN barang barang_sparepart ON retur_sparepart_detail.intid_barang = barang_sparepart.intid_barang
			INNER JOIN cabang ON retur_sparepart.intid_cabang = cabang.intid_cabang
                                    WHERE retur_sparepart.intid_retur_sparepart = '$id'");

        return $query->result();
     }
	function countDataReturSparepart()
	{
	  	return $this->db->count_all('retur_sparepart');
  	}
	function get_list_retur_data_sparepart($limit = 10, $offset = 0)
  	{
        if($offset == ""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where a.is_sttb = 0 ORDER BY a.intid_retur_sparepart ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	/**
	//added 2014-04-02 ifirlana@gmail.com
	//desc : controller po/index
	//menggantikan get_list_retur_data_sparepart
	*/
	
	function get_list_retur_data_sparepart_new($limit = 10, $offset = 0)
  	{
        if($offset == ""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where a.is_sttb = 0 and a.is_verified = 1 ORDER BY a.intid_retur_sparepart ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	function get_list_retur_data_sparepart_new_adi($limit = 10, $offset = 0)
  	{
        if($offset == ""){ $offset=0; }
			
		$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang where a.is_sttb = 0 and a.is_verified = 1 ORDER BY a.intid_retur_sparepart ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	
	function get_list_data_filter_retur_sparepart($limit = 10, $offset = 0, $filter)
  	{
		if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where a.is_sttb = 0 and cabang.strnama_cabang LIKE '%" . $filter['cari'] . "%' ORDER BY a.intid_retur_sparepart ASC  LIMIT $offset,$limit");
        return $query->result();
	}
	
	//added 2014-04-02 ifirlana@gmail.com
	//menggantikan get_list_data_filter_retur_sparepart
	
	function get_list_data_filter_retur_sparepart_new($limit = 10, $offset = 0, $filter)
  	{
		if($offset==""){ $offset=0; }
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where a.is_sttb = 0 and a.is_verified = 1 and cabang.strnama_cabang LIKE '%" . $filter['cari'] . "%' ORDER BY a.intid_retur_sparepart ASC");
        return $query->result();
	}
	function get_list_data_filter_retur_sparepart_new_adi($limit = 10, $offset = 0, $filter)
  	{
		if($offset==""){ $offset=0; }
		$xy = '';
		if(isset($filter['cariWeek'])){
			$xy .= " and a.intid_week= ".$filter['cariWeek'];
		} 
		if(isset($filter['cariTahun'])){
			$xy.=" and year(a.datetgl )= ".$filter['cariTahun'] ;
		} 
	$query = $this->db->query("SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
	where a.is_sttb = 0 and a.is_verified = 1 and cabang.strnama_cabang LIKE '%" . $filter['cari']  . "%'  $xy ORDER BY a.intid_retur_sparepart ASC");
        return $query->result();
	}
	
	//added 2014-04-02 ifirlana@gmail.com
	//menggantikan get_list_data_filter_retur_sparepart
	
	function get_list_data_filter_retur_sparepart_intid_cabang($limit = 10, $offset = 0, $filter = "", $intid_cabang = 0)
  	{
		if($offset==""){ $offset=0; }
		if($_POST){
			if($intid_cabang == 1){
				$select = "SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
								LEFT JOIN pra_sttb_sparepart on a.no_srsp = pra_sttb_sparepart.no_srsp
							where a.no_srsp LIKE '%" . $filter['cari'] . "%' or cabang.strnama_cabang like '".$filter['cari']."%' ORDER BY a.intid_retur_sparepart ASC  ";
					
				}else{
					$select = "SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							LEFT JOIN pra_sttb_sparepart on a.no_srsp = pra_sttb_sparepart.no_srsp
							where a.no_srsp LIKE '%" . $filter['cari'] . "%' and a.intid_cabang = '".$intid_cabang."' ORDER BY a.intid_retur_sparepart ASC  ";
					}
		}else{
		$select = "SELECT a.*, cabang.strnama_cabang FROM retur_sparepart a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang 
							LEFT JOIN pra_sttb_sparepart on a.no_srsp = pra_sttb_sparepart.no_srsp
							where a.datetgl = '" . date('Y-m-d'). "' and a.intid_cabang = '".$intid_cabang."' ORDER BY a.intid_retur_sparepart ASC ";
		
		}
		$query = $this->db->query($select);
		return $query->result();
		//return $select;
	}
	
	
	function get_list_data_retur_detail_sparepart($id)
  	{
       $query = $this->db->query("SELECT DISTINCT retur_sparepart.intid_retur_sparepart, retur_sparepart.no_srsp, retur_sparepart.datetgl, retur_sparepart_detail.*,retur_sparepart.intid_cabang, cabang.strnama_cabang, barang_sparepart.strnama_sparepart
		FROM retur_sparepart
		INNER JOIN retur_sparepart_detail ON retur_sparepart.intid_retur_sparepart = retur_sparepart_detail.intid_retur_sparepart
		INNER JOIN barang_sparepart ON retur_sparepart_detail.intid_barang = barang_sparepart.id_sparepart
		INNER JOIN cabang ON retur_sparepart.intid_cabang = cabang.intid_cabang
		where retur_sparepart.intid_retur_sparepart = $id
		ORDER BY retur_sparepart.intid_retur_sparepart ASC");
        return $query->result();
	}
	function get_MaxSttbNew() {
        $this->db->select('id');
		$query = $this->db->get('counter_sttb');
        return $query->result();
	}
	function get_MaxSttbUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_sttb', $data);

    }
	//line ikhlas 22April2013
	function selectBarangPO($keyword){

        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama
		from barang a
		where  a.strnama like '$keyword%' and status_barang = '1'");
        return $query->result();
		}
		//
	/*
	* @param get_PO_Cabang
	* input : intid_cabang
	* output : result query
	* desc : untuk menampilkan semua data po cabang, digunakan di controller po/po_look
	*/
	function get_PO_cabang($intid_cabang){
			$query = $this->db->query("select po.*, c.strnama_cabang from po inner join cabang c on c.intid_cabang = po.intid_cabang where po.intid_cabang = ".$intid_cabang." order by datetgl desc");
			return $query->result();
		}
	function selectBarangPOSparepart($keyword){

        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama
		from barang a
		where  a.strnama like '$keyword%' and is_sparepart = '1'");
        return $query->result();
		}
	 function insertSttbSparepart($data){

     	$data = array(
			'no_sttb' => $data['no_sttb'],
            'waktu' => $data['waktu'],
			'week' => $data['week'],
            'intid_cabang' =>$data['intid_cabang'],
            'intid_dealer' =>$data['intid_dealer'],
            );
        $this->db->insert('sttb_sparepart', $data);
        return $this->db->insert_id();
     }
	  function insertHutangSparepart($data){

     	$data = array(
			'no_sttb' => $data['no_sttb'],
            'waktu' => $data['waktu'],
			'week' => $data['week'],
            'intid_cabang' =>$data['intid_cabang']
            );
        $this->db->insert('hutang_sparepart', $data);
        return $this->db->insert_id();
     }
	 
	  function insertSttbSparepartDetail($array){

            $data = array(
			'no_sttb' => $array['no_sttb'],
            'intid_barang' => $array['intid_barang'],
			'qty' => $array['qty'],
            'ket' => $array['ket'],
            );
            //echo "array : 	".$array['no_sttb']."<br />";
        $this->db->insert('sttb_sparepart_detail', $data);
        return $this->db->insert_id();
	
     	//$query = $this->db->query("INSERT into sttb_sparepart_detail (no_sttb, intid_barang, quantity, keterangan) values ('$val1', '$val2', '$val3', '$val4')");
     }
	 function get_notifikasi_po($intid_cabang = ""){
		$select = "select * from po_ inner join spkb on po_.no_spkb = spkb.no_spkb where po_.intid_cabang='$intid_cabang' and spkb.week_sj = 0";
		return $this->db->query($select);
	 }
	 
	 //added 2014-03-21 ifirlana@gmail.com
	 //show_po_status sama dengan admintulip
	 
	 
	 public function show_po_status($intid_cabang,$verified = 0){
			$select	=	"select po_.*, spkb.no_sj, year(po_.time) tahun 
								from po_ left join spkb on po_.no_spkb = spkb.no_spkb  
								where po_.intid_cabang = '".$intid_cabang."' 
								and (spkb.terkirim = 0 or spkb.terkirim is null)";
			return $this->db->query($select);	
			}
	 
	  //added 2014-03-28 ifirlana@gmail.com
	 //show_po_status sama dengan admintulip, po notifikasi
	 
	 
	 public function show_po_status_antrian_all_brainsupport(){
			$select	=	"select po_.*, user.*,  spkb.no_sj, year(po_.time) tahun, (select strnama_cabang from cabang where cabang.intid_cabang = po_.intid_cabang) strnama_cabang 
								from po_ inner join brain_support on po_.intid_cabang = brain_support.intid_cabang
								inner join user on user.id = brain_support.id_user  left join spkb on po_.no_spkb = spkb.no_spkb 
								where po_.is_verified = 0 and user.privillage = 'BS' order by po_.time asc, user.strnama asc";
			return $this->db->query($select);	
			}
	 
	 
	 ///added 2014-03-21 ifirlana@gmail.com
	 //digunakan oleh po/cetak_brgmingguan
	  
	function get_CetakPengeluaranBarangMingguan_tahun($week, $cabang,$tahun)
	{
		/*
		
		$query = $this->db->query("SELECT SUM(intquantity) AS intquantity, strnama, intid_jsatuan FROM (
						select c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 0
								group by b.intid_barang
								UNION
								select c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_nota = e.intid_arisan_detail
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 1
								and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
								group by b.intid_barang
								UNION
								select b.intid_barang AS intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								group by b.intid_barang
								UNION
								select b.intid_barang, sum(b.quantity) intquantity, c.strnama, d.intid_jsatuan
								from retur_ a inner join retur_detail_ b on b.no_srb = a.no_srb 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.intid_week_verified = $week 
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_verified = 1
								group by b.intid_barang
								UNION
								select b.intid_barang, sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
								from pra_sttb_sparepart a inner join pra_sttb_sparepart_detail b on b.no = a.no 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.week = $week 
								and a.intid_cabang = $cabang
								and year(a.tgl_order) = $tahun	
								group by b.intid_barang
						) AS RPB GROUP BY intid_barang order by intid_barang asc");
        return $query->result();
		*/
		$query = $this->db->query("SELECT SUM(intquantity) AS intquantity, strnama, intid_jsatuan FROM (
						select b.intid_detail_nota id, c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 0
								group by b.intid_barang
								UNION
								select b.intid_detail_nota id,c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_nota = e.intid_arisan_detail
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 1
								and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
								group by b.intid_barang
								UNION
								select b.intid_detail_nota id,b.intid_barang AS intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								group by b.intid_barang
								UNION
								select b.id id, b.intid_barang, sum(b.quantity) intquantity, c.strnama, d.intid_jsatuan
								from retur_ a inner join retur_detail_ b on b.no_srb = a.no_srb 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.intid_week_verified = $week 
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_verified = 1
								group by b.intid_barang
								UNION
								select b.id id,b.intid_barang, sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
								from pra_sttb_sparepart a inner join pra_sttb_sparepart_detail b on b.no = a.no 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								where 
								a.week = $week 
								and a.intid_cabang = $cabang
								and year(a.tgl_order) = $tahun	
								group by b.intid_barang
						) AS RPB GROUP BY intid_barang order by intid_barang asc");
        return $query->result();
	}
	
	//po_model 2014 08 21
	//data barang di proses untuk laporan surat jalan merchandise
	
	function get_data_sj_merchandise($id_cabang, $week, $tahun ="") {
        
		if(!empty($tahun)){
			$select = "SELECT a.*, cabang.strnama_cabang 
					FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where 
				 a.week_sj = ".$week." 
				and no_sj != '' 
				and year(tgl_order) = ".$tahun." 
				and a.no_spkb in (select no_spkb from spkb_detail where intid_barang in (select intid_barang from merchandise))
				ORDER BY time ASC";
			$query = $this->db->query($select);
			
		}else{
			$select = "SELECT a.*, cabang.strnama_cabang 
					FROM spkb a INNER JOIN cabang ON a.intid_cabang = cabang.intid_cabang
				where a.week_sj = ".$week." 
				and no_sj != '' 
				and a.no_spkb in (select no_spkb from spkb_detail where intid_barang in (select intid_barang from merchandise))
				ORDER BY time ASC ";
			
			$query = $this->db->query($select);
			}
		//echo $select."<br />";
		return $query->result();
     }
	
	///added 2014-10-09 ifirlana@gmail.com
	 //digunakan oleh po/cetak_brgmingguan
	  
	function get_CetakPengeluaranBarangMingguan_tahun20141009($week, $cabang,$tahun)
	{
		$query = $this->db->query("SELECT GROUP_CONCAT(keterangan SEPARATOR ', ') keterangan, SUM(intquantity) AS intquantity, strnama, intid_jsatuan FROM (
						select '' as keterangan, b.intid_detail_nota id, c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 0
								group by b.intid_barang
								UNION
								select '' as keterangan, b.intid_detail_nota id,c.intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_nota = e.intid_arisan_detail
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								and a.is_dp = 0
								and a.is_arisan = 1
								and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
								group by b.intid_barang
								UNION
								select '' as keterangan, b.intid_detail_nota id,b.intid_barang AS intid_barang,sum(b.intquantity) intquantity, c.strnama, d.intid_jsatuan
								from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
								where a.intid_nota = b.intid_nota
								and b.intid_barang = c.intid_barang
								and c.intid_jsatuan = d.intid_jsatuan
								and a.intid_week = $week
								and a.intid_cabang = $cabang
								and year(a.datetgl) = $tahun
								group by b.intid_barang
								UNION
								select GROUP_CONCAT(a.no_srb SEPARATOR ', ') keterangan,  b.id id, b.intid_barang, sum(b.quantity) intquantity, c.strnama, d.intid_jsatuan
									from retur_  a
									
									inner join retur_detail_ b on b.no_srb = a.no_srb 
									inner join barang c on c.intid_barang = b.intid_barang
									inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
									where
									intid_week_verified = $week 
									and intid_cabang = $cabang
									and year(datetgl) = $tahun
									and is_verified = 1
									group by b.intid_barang
								UNION
								select a.keterangan, b.id id,b.intid_barang, sum(b.qty) intquantity, c.strnama, d.intid_jsatuan
								from 
								(select GROUP_CONCAT(no_srsp SEPARATOR ', ') keterangan, if(no is not null, no, '')no 
									from pra_sttb_sparepart
									where 
									week = $week 
									and intid_cabang = $cabang
									and year(tgl_order) = $tahun	
									) a 
								inner join pra_sttb_sparepart_detail b on b.no = a.no 
								inner join barang c on c.intid_barang = b.intid_barang
								inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
								group by b.intid_barang
						) AS RPB GROUP BY intid_barang order by intid_barang asc");
        return $query->result();
	}
	
	///added 2015-01-08 ifirlana@gmail.com
	 //digunakan oleh po/cetak_masukbrgmingguan
	  
	function get_CetakMasukBarangMingguan_tahun20150108($week, $cabang,$tahun)
	{
		$select = "Select
							barang.*,
							surat_jalan_masuk.keterangan	keterangan_surat_jalan_masuk,
							sttb_sparepart.keterangan	keterangan_sttb_sparepart_masuk,
							retur_sparepart.keterangan	keterangan_retur_sparepart_masuk,
							sttb.keterangan	keterangan_sttb_masuk,
							surat_jalan_masuk.qty	qty_surat_jalan_masuk,
							sttb_sparepart.qty	qty_sttb_sparepart_masuk,
							retur_sparepart.qty	qty_retur_sparepart_masuk,
							sttb.qty	qty_sttb_masuk
							from
								barang
								left join
								(select 
									sum(spkb_detail.quantity) qty, spkb_detail.intid_barang, GROUP_CONCAT(spkb.no_sj SEPARATOR ', ') keterangan
								from
									spkb,spkb_detail
								where
									spkb.no_spkb = spkb_detail.no_spkb
									and spkb.week_sj = $week
									and spkb.intid_cabang = $cabang
									and year(spkb.tgl_kirim) = $tahun
									and (spkb.no_sj != '' or spkb.no_sj is not null)
									and spkb.terkirim = 1
									group by spkb_detail.intid_barang
									) surat_jalan_masuk
								on barang.intid_barang = surat_jalan_masuk.intid_barang
								left join
								(select 
									sum(sttb_sparepart_detail.qty) qty, sttb_sparepart_detail.intid_barang, GROUP_CONCAT(sttb_sparepart.no_sj_sparepart SEPARATOR ', ') keterangan
								from 
									sttb_sparepart,sttb_sparepart_detail
								where
										sttb_sparepart.no_sj_sparepart = sttb_sparepart_detail.no
										and sttb_sparepart.week_sj = $week
										and sttb_sparepart.intid_cabang = $cabang
										and year(sttb_sparepart.tgl_kirim) = $tahun
										and sttb_sparepart.terkirim = 1
										group by sttb_sparepart_detail.intid_barang
									) sttb_sparepart
								on barang.intid_barang = sttb_sparepart.intid_barang
								left join 
								(select 
									sum(retur_sparepart_detail.qty) qty, retur_sparepart_detail.intid_barang, GROUP_CONCAT(retur_sparepart.no_srsp SEPARATOR ', ') keterangan
								from 
									retur_sparepart, retur_sparepart_detail
								where
									retur_sparepart.intid_retur_sparepart = retur_sparepart_detail.intid_retur_sparepart
									and retur_sparepart.intid_cabang = $cabang
									and retur_sparepart.intid_week = $week
									and year(retur_sparepart.datetgl) = $tahun
									group by retur_sparepart_detail.intid_barang
									) retur_sparepart
								on barang.intid_barang = retur_sparepart.intid_barang
								left join
								(select 
									sum(sttb_detail.quantity) qty, sttb_detail.intid_barang, GROUP_CONCAT(sttb.no_sj SEPARATOR ', ') keterangan
								from
									sttb, sttb_detail
								where
									sttb.no_sttb = sttb_detail.no_sttb
									and sttb.intid_cabang = $cabang
									and year(sttb.tgl_kirim) = $tahun
									and sttb.week = $week
									and (sttb.no_sj != '' or sttb.no_sj is not null)
									and sttb.terkirim = 1
									group by sttb_detail.intid_barang
									) sttb
								on barang.intid_barang = sttb.intid_barang
							#where
								#barang.status_barang = 1
								order by barang.intid_barang";
		//return $select;		
		 $query = $this->db->query($select);
        return $query->result();
	}
	///added 2014-10-09 ifirlana@gmail.com
	 //digunakan oleh po/cetak_brgmingguan
	  
	function get_CetakPengeluaranBarangMingguan_tahun20141029($week, $cabang,$tahun)
	{
		$select = "SELECT 
				retur_cabang.keterangan keterangan_returcabang, 
				sparepart.keterangan keterangan_sparepart, 
				kanibal.keterangan keterangan_kanibal, 
				nota.intquantity intquantity_nota,
				arisan.intquantity intquantity_arisan, 
				nota_hadiah.intquantity intquantity_hadiah,
				retur_cabang.intquantity intquantity_returcabang,
				sparepart.intquantity intquantity_sparepart, 
				kanibal.intquantity intquantity_kanibal, 
				 barang.strnama, 
				 barang.intid_jsatuan
			FROM 
			barang 
				left join
			(select b.intid_detail_nota id, c.intid_barang,if(sum(b.intquantity) is null, 0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 0
				group by b.intid_barang
				) nota
				on barang.intid_barang = nota.intid_barang
				left join
			(select b.intid_detail_nota id,c.intid_barang,if(sum(b.intquantity) is null ,0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_nota = e.intid_arisan_detail
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 1
				and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
				group by b.intid_barang
				) arisan
				on barang.intid_barang = arisan.intid_barang
				left join
			(select b.intid_detail_nota id,b.intid_barang AS intid_barang,if(sum(b.intquantity) is null,0,sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				group by b.intid_barang
				) nota_hadiah
				on barang.intid_barang = nota_hadiah.intid_barang
				left join 
			(select group_concat(a.no_srb) keterangan,  b.id id, b.intid_barang, if(sum(b.quantity) is null,0,sum(b.quantity)) intquantity, c.strnama, d.intid_jsatuan
				from retur_  a
				inner join retur_detail_ b on b.no_srb = a.no_srb 
				inner join barang c on c.intid_barang = b.intid_barang
				inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
				where
				intid_week_verified = $week 
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and is_verified = 1
				group by b.intid_barang
				) retur_cabang
				on barang.intid_barang = retur_cabang.intid_barang
				left join
			(select group_concat(a.keterangan) keterangan, b.id id,b.intid_barang, if( sum(b.qty) is null, 0,sum(b.qty)) intquantity, c.strnama, d.intid_jsatuan
				from 
				(select no_srsp keterangan, if(no is not null, no, '')no 
					from pra_sttb_sparepart
					where 
					week = $week 
					and intid_cabang = $cabang
					and year(tgl_order) = $tahun	
					) a 
				inner join pra_sttb_sparepart_detail b on b.no = a.no 
				inner join barang c on c.intid_barang = b.intid_barang
				inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
				group by b.intid_barang
				) sparepart
				on barang.intid_barang = sparepart.intid_barang
				left join
			(select 
				GROUP_CONCAT(k.assemble_number) keterangan, d.id_assemble_details id, d.id_product intid_barang, if(sum(d.qty * -1) is null, 0, sum(d.qty * -1)) intquantity, c.strnama, e.intid_jsatuan
				from 
				kanibal k
				inner join kanibal_detail d on k.assemble_number = d.assemble_number
				inner join barang c on c.intid_barang = d.id_product
				inner join jenis_satuan e on e.intid_jsatuan = c.intid_jsatuan
				where
					week = $week
					and k.id_branch 	= $cabang
					and year(k.date) 	= $tahun
				group by d.id_product
				) kanibal on barang.intid_barang = kanibal.intid_barang";
		//return $select;		
		 $query = $this->db->query($select);
        return $query->result();
	}
	///added 2014-10-09 ifirlana@gmail.com
	 //digunakan oleh po/cetak_brgmingguan
	  
	function get_CetakPengeluaranBarangTanggal($tanggalawal,$tanggalakhir, $cabang)
	{
		$select = "SELECT 
				retur_cabang.keterangan keterangan_returcabang, 
				sparepart.keterangan keterangan_sparepart, 
				nota.intquantity intquantity_nota,
				arisan.intquantity intquantity_arisan, 
				nota_hadiah.intquantity intquantity_hadiah,
				retur_cabang.intquantity intquantity_returcabang,
				sparepart.intquantity intquantity_sparepart, 
				 barang.strnama, 
				 barang.intid_jsatuan
			FROM 
			barang 
				left join
			(select b.intid_detail_nota id, c.intid_barang,if(sum(b.intquantity) is null, 0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.datetgl >= '$tanggalawal'
				and a.datetgl <= '$tanggalakhir'
				and a.intid_cabang = $cabang
				and a.is_dp = 0
				and a.is_arisan = 0
				group by b.intid_barang
				) nota
				on barang.intid_barang = nota.intid_barang
				left join
			(select b.intid_detail_nota id,c.intid_barang,if(sum(b.intquantity) is null ,0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_nota = e.intid_arisan_detail
				and a.datetgl >= '$tanggalawal'
				and a.datetgl <= '$tanggalakhir'
				and a.intid_cabang = $cabang
				and a.is_dp = 0
				and a.is_arisan = 1
				and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
				group by b.intid_barang
				) arisan
				on barang.intid_barang = arisan.intid_barang
				left join
			(select b.intid_detail_nota id,b.intid_barang AS intid_barang,if(sum(b.intquantity) is null,0,sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.datetgl >= '$tanggalawal'
				and a.datetgl <= '$tanggalakhir'
				and a.intid_cabang = $cabang
				group by b.intid_barang
				) nota_hadiah
				on barang.intid_barang = nota_hadiah.intid_barang
				left join 
			(select group_concat(a.no_srb) keterangan,  b.id id, b.intid_barang, if(sum(b.quantity) is null,0,sum(b.quantity)) intquantity, c.strnama, d.intid_jsatuan
				from retur_  a
				inner join retur_detail_ b on b.no_srb = a.no_srb 
				inner join barang c on c.intid_barang = b.intid_barang
				inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
				where
				a.datetgl >= '$tanggalawal'
				and a.datetgl <= '$tanggalakhir'
				and intid_cabang = $cabang
				and is_verified = 1
				group by b.intid_barang
				) retur_cabang
				on barang.intid_barang = retur_cabang.intid_barang
				left join
			(select group_concat(a.keterangan) keterangan, b.id id,b.intid_barang, if( sum(b.qty) is null, 0,sum(b.qty)) intquantity, c.strnama, d.intid_jsatuan
				from 
				(select no_srsp keterangan, if(no is not null, no, '')no 
					from pra_sttb_sparepart
					where 
					intid_cabang = $cabang
					and date(tgl_terima) >= '$tanggalawal'
					and date(tgl_terima) <= '$tanggalakhir'
					) a 
				inner join pra_sttb_sparepart_detail b on b.no = a.no 
				inner join barang c on c.intid_barang = b.intid_barang
				inner join jenis_satuan d on d.intid_jsatuan = c.intid_jsatuan
				group by b.intid_barang
				) sparepart
				on barang.intid_barang = sparepart.intid_barang
				";
		//return $select;		
		 $query = $this->db->query($select);
        return $query->result();
	}
	///added 2014-10-09 ifirlana@gmail.com
	 //digunakan oleh po/cetak_brgmingguan_tahun_noretur
	  
	function get_CetakPengeluaranBarangTahunanNoRetur($cabang,$tahun)
	{
		$select = "SELECT 
				'' as keterangan_returcabang, 
				'' as keterangan_sparepart, 
				nota.intquantity intquantity_nota,
				arisan.intquantity intquantity_arisan, 
				nota_hadiah.intquantity intquantity_hadiah,
				0 as intquantity_returcabang,
				0 as intquantity_sparepart, 
				 barang.strnama, 
				 barang.intid_jsatuan
			FROM 
			barang 
				left join
			(select b.intid_detail_nota id, c.intid_barang,if(sum(b.intquantity) is null, 0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 0
				group by b.intid_barang
				) nota
				on barang.intid_barang = nota.intid_barang
				left join
			(select b.intid_detail_nota id,c.intid_barang,if(sum(b.intquantity) is null ,0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_nota = e.intid_arisan_detail
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 1
				and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
				group by b.intid_barang
				) arisan
				on barang.intid_barang = arisan.intid_barang
				left join
			(select b.intid_detail_nota id,b.intid_barang AS intid_barang,if(sum(b.intquantity) is null,0,sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				group by b.intid_barang
				) nota_hadiah
				on barang.intid_barang = nota_hadiah.intid_barang
				";
		//return $select;		
		 $query = $this->db->query($select);
        return $query->result();
	}
	function get_CetakPengeluaranBarangTahunanTestNoRetur($cabang,$tahun)
	{
		$select = "SELECT 
				'' as keterangan_returcabang, 
				'' as keterangan_sparepart, 
				sum(nota.intquantity) intquantity_nota,
				SUM(arisan.intquantity) intquantity_arisan, 
				SUM(nota_hadiah.intquantity) intquantity_hadiah,
				0 as intquantity_returcabang,
				0 as intquantity_sparepart, 
				 barang.strnama, 
				 barang.intid_jsatuan
			FROM 
			barang 
				left join
			(select b.intid_detail_nota id, c.intid_barang,if(sum(b.intquantity) is null, 0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 0
				group by b.intid_barang
				) nota
				on barang.intid_barang = nota.intid_barang
				left join
			(select b.intid_detail_nota id,c.intid_barang,if(sum(b.intquantity) is null ,0, sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota a, nota_detail b, barang c, jenis_satuan d, arisan e
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_nota = e.intid_arisan_detail
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.is_dp = 0
				and a.is_arisan = 1
				and (IF(e.intjeniscicilan = 5, e.c5, e.c7) = 1 OR e.winner = 1)
				group by b.intid_barang
				) arisan
				on barang.intid_barang = arisan.intid_barang
				left join
			(select b.intid_detail_nota id,b.intid_barang AS intid_barang,if(sum(b.intquantity) is null,0,sum(b.intquantity)) intquantity, c.strnama, d.intid_jsatuan
				from nota_hadiah a, nota_detail_hadiah b, barang c, jenis_satuan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and c.intid_jsatuan = d.intid_jsatuan
				and a.intid_week in (select intid_week from week where inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				group by b.intid_barang
				) nota_hadiah
				on barang.intid_barang = nota_hadiah.intid_barang
				GROUP BY barang.CODE
				";
		//return $select;		
		 $query = $this->db->query($select);
        return $query->result();
	}
}
?>
