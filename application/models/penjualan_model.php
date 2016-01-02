<?php
class Penjualan_model extends CI_Model{
    
	function   __construct() {
        parent::__construct();
       	$this->load->model('User_model');
       }
	
	function getJenisPenjualanRekrut() {
		$query = $this->db->query("select strnama_jpenjualan,intid_jpenjualan from jenis_penjualan where intid_jpenjualan = 1");
		return $query->result();
	 }
	
	function selectDealer($strnama_dealer=null,$intunit = 0 ){
    	$query = $this->db->query("select unit.strnama_unit, member.* from member left join unit on unit.intid_unit = member.intid_unit where member.intid_unit=$intunit and member.strnama_dealer like '$strnama_dealer%'");
    	return $query->result();
    }
    function updateDealerStat($intid_dealer, $rule, $stat){
    	$data = array(
               $rule => $stat,
            );

		$this->db->where('intid_dealer', $intid_dealer);
		$this->db->update('member', $data); 
    }
	function selectCabangConf($strnama_cabang=null){
    	$query = $this->db->query("select * from cabang where strnama_cabang like '$strnama_cabang%'");
    	return $query->result();
    }
    function updateCabangStat($intid_cabang, $rule, $stat){
    	$data = array(
               $rule => $stat,
            );

		$this->db->where('intid_cabang', $intid_cabang);
		$this->db->update('cabang', $data); 
    }
    function get_all_arisan($data, $id_cabang) {
      		
		if ($id_cabang==1){
/*			$query = $this->db->query("select e.strnama_dealer, e.strnama_upline, g.strnama_unit, f.strnama, 
			sum(d.intquantity) intquantity, a.`group`, a.intid_arisan, a.winner, a.intjeniscicilan, b.tanggal
			from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g
			where a.intid_arisan = b.intid_arisan
			and a.intid_arisan_detail = c.intid_nota
			and c.intid_nota = d.intid_nota
			and d.intid_barang = f.intid_barang
			and c.intid_dealer = e.intid_dealer
			and c.intid_unit = g.intid_unit
			and (select intbulan from week where b.tanggal>= dateweek_start and b.tanggal <= dateweek_end) = '$data[bulan]' 
			and YEAR(b.tanggal) = '$data[tahun]'
			and a.`group`= $data[group]
			and d.is_free=0 
			and a.intjeniscicilan= $data[arisan]
			group by c.intid_nota");
*/

$query = $this->db->query("SELECT * FROM (select e.strnama_dealer, e.strnama_upline, g.strnama_unit, f.strnama, 
sum(d.intquantity) intquantity, a.`group`, a.intid_arisan, a.winner, a.intjeniscicilan, b.tanggal, g.intid_unit, e.intid_dealer 
from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g 
where a.intid_arisan = b.intid_arisan 
and a.intid_arisan_detail = c.intid_nota 
and c.intid_nota = d.intid_nota 
and d.intid_barang = f.intid_barang 
and c.intid_dealer = e.intid_dealer 
and c.intid_unit = g.intid_unit 
and d.is_free=0 
group by c.intid_nota) AS z 
WHERE YEAR(z.tanggal) = '$data[tahun]' 
AND MONTH(z.tanggal) = '$data[bulan]' 
AND z.group = $data[group]
and z.intjeniscicilan= $data[arisan]");

		} else {
/*			$query = $this->db->query("select e.strnama_dealer, e.strnama_upline, g.strnama_unit, f.strnama, 
			sum(d.intquantity) intquantity, a.`group`, a.intid_arisan, a.winner, a.intjeniscicilan, b.tanggal
			from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g
			where a.intid_arisan = b.intid_arisan
			and a.intid_arisan_detail = c.intid_nota
			and c.intid_nota = d.intid_nota
			and d.intid_barang = f.intid_barang
			and c.intid_dealer = e.intid_dealer
			and c.intid_unit = g.intid_unit
			and (select intbulan from week where b.tanggal>= dateweek_start and b.tanggal <= dateweek_end) = '$data[bulan]' 
			and YEAR(b.tanggal) = '$data[tahun]'
			and a.`group`= $data[group]
			and d.is_free=0 
			and a.intjeniscicilan= $data[arisan]
			and c.intid_cabang = $id_cabang
			group by c.intid_nota");
*/

$query = $this->db->query("SELECT * FROM (select e.strnama_dealer, e.strnama_upline, g.strnama_unit, f.strnama, 
sum(d.intquantity) intquantity, a.`group`, a.intid_arisan, a.winner, a.intjeniscicilan, b.tanggal , g.intid_unit,e.intid_dealer
from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g 
where a.intid_arisan = b.intid_arisan 
and a.intid_arisan_detail = c.intid_nota 
and c.intid_nota = d.intid_nota 
and d.intid_barang = f.intid_barang 
and c.intid_dealer = e.intid_dealer 
and c.intid_unit = g.intid_unit 
and d.is_free=0 
and c.intid_cabang = $id_cabang
group by c.intid_nota) AS z 
WHERE YEAR(z.tanggal) = '$data[tahun]' 
AND MONTH(z.tanggal) = '$data[bulan]' 
AND z.group = $data[group]
and z.intjeniscicilan= $data[arisan]");

		}

        return $query->result();
    }

   function get_all_arisan_session($b, $t, $g) {
        
        $this->db->select('member.strnama_dealer,member.strkode_upline, unit.strnama_unit, arisan.*, nota.*, barang.strnama, nota_detail.intquantity');
        $this->db->from('nota');
        $this->db->join('nota_detail', 'nota_detail.intid_nota = nota.intid_nota');
        $this->db->join('barang', 'barang.intid_barang = nota_detail.intid_barang');
        $this->db->join('member', 'member.intid_dealer = nota.intid_dealer');
        $this->db->join('unit','unit.intid_unit = nota.intid_unit');
        $this->db->join('arisan','arisan.intid_arisan_detail = nota.intid_nota');
        $this->db->where("MONTH(nota.datetgl) = '$b' and YEAR(nota.datetgl) = '$t' and arisan.group=$g and nota_detail.is_free=0");
        return $this->db->get()->result();
    }

    function viewDetailbayar($id) {
        $this->db->select('arisan.*');
        $this->db->from('arisan');
        $this->db->where("arisan.intid_arisan", $id);
        return $this->db->get()->result();
    }

    function viewTotalbayar($id) {
        $this->db->select('nota.inttotal_bayar, nota.intno_nota, member.strnama_dealer,member.intid_dealer, unit.strnama_unit, arisan.group, arisan.intjeniscicilan');
        $this->db->from('arisan_detail');
        $this->db->join('arisan', 'arisan.intid_arisan = arisan_detail.intid_arisan');
        $this->db->join('nota', 'arisan.intid_arisan_detail = nota.intid_nota');
        $this->db->join('member', 'member.intid_dealer = nota.intid_dealer');
        $this->db->join('unit','unit.intid_unit = nota.intid_unit');
        
        $this->db->where("arisan.intid_arisan", $id);
        return $this->db->get()->row();
    }

     function getBarangArisan($id) {
        $this->db->select('nota_detail.intid_barang');
        $this->db->from('nota_detail');
        $this->db->join('arisan', 'arisan.intid_arisan_detail 	 = nota_detail.intid_nota');
        $this->db->where("arisan.intid_arisan", $id);
        return $this->db->get()->row();
    }

    function delete_arisan($id) {
        $this->db->where('intid_arisan', $id);
        $this->db->delete('arisan');
		 $this->db->where('intid_arisan', $id);
        $this->db->delete('arisan_detail');
    }
    
    function cek_arisan($id, $bulan, $tahun) {
			$this->db->where('intid_arisan',$id);
			$this->db->where('intbulan',$bulan);
			$this->db->where('inttahun ',$tahun);
		
		return $this->db->get('arisan_detail');
	}

    function add_arisan_detail($id, $ket, $bulan, $tahun){
		$tgl = date("Y-m-d");
        
		$data = array(
            'intid_arisan' => $id,
            'strketerangan' => $ket,
			'tanggal' => $tgl,
			'intbulan' => $bulan,
            'inttahun' => $tahun
        );
        $this->db->insert('arisan_detail', $data);

	}

    function add_arisan_detail_langsung($id, $ket){
		$tgl = date("Y-m-d");

		$data = array(
            'intid_arisan' => $id,
            'strketerangan' => $ket,
			'tanggal' => $tgl,
			
        );
        $this->db->insert('arisan_detail', $data);

	}

    function add_arisan_detail_um($id, $ket){
		$tgl = date("Y-m-d");

		$data = array(
            'intid_arisan' => $id,
            'strketerangan' => $ket,
			'tanggal' => $tgl,
			
        );
        $this->db->insert('arisan_detail', $data);

	}

    function update_pemenang($id, $u){
         $data = array(
             'winner' => 1,
			 'urutan_pemenang' => $u
			 );
        $this->db->where('intid_arisan', $id);
		$this->db->update('arisan', $data);
    }

     function update_barang($id_brg){
         $data = array(
             'winner' => 1);
        $this->db->where('intid_arisan', $id);
		$this->db->update('arisan', $data);
    }

    function insert($data){
		$tgl = date("Y-m-d");
        $week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
        $level = $this->input->post('intlevel_dealer')+1;
		$data = array(
            'strkode_dealer' => $this->input->post('strkode_dealer'),
            'strnama_dealer' => $this->input->post('strnama_dealer'),
			'intlevel_dealer' => $level,
			'intparent_leveldealer' => $this->input->post('intlevel_dealer'),
            'intid_cabang' => $this->input->post('intid_cabang'),
            'datetanggal' => $tgl,
			'strno_ktp' => $this->input->post('strno_ktp'),
			'stralamat' => $this->input->post('stralamat'),
			'strtmp_lahir' => $this->input->post('strtmp_lahir'),
			'datetgl_lahir' => $this->input->post('datetgl_lahir'),
			'strtlp' => $this->input->post('strtlp'),
			'stragama' => $this->input->post('stragama'),
			'intno_rekening' => $this->input->post('intno_rekening'),
			'strnama_pemilikrekening' => $this->input->post('strnama_pemilikrekening'),
			'intid_bank' => $this->input->post('intid_bank'),
			'intid_unit' => $this->input->post('id_unit'),
			'strkode_upline' => $this->input->post('strkode_upline'),
			'strnama_upline' => $this->input->post('strnama_upline'),
            'strkode_manager' => $this->input->post('strkode_manager'),
			'intid_starterkit' => $this->input->post('intid_starterkit'),
			'strjk' => $this->input->post('strjk'),
			'strstatus' => $this->input->post('strstatus'),
			'stremail' => $this->input->post('stremail'),
			'strwarganegara' => $this->input->post('strwarganegara'),
			'strpekerjaan' => $this->input->post('strpekerjaan'),
            'strtelp_upline' => $this->input->post('strtelp_upline'),
			'intid_cabang_upline' => $this->input->post('intid_cabang_upline'),
            'intid_week' => $intid_week,
            'cabang_pengambilan' => $this->input->post('intid_cabang')
        );
        $this->db->insert('member', $data);
		        
	}

	
	function selectMember($id){
         $query = $this->db->query("select a.intid_starterkit, 
			a.intid_dealer, 
			a.strnama_dealer, 
			a.strnama_upline, 
			b.intkode_cabang, 
			b.intid_wilayah, 
			b.intid_cabang, 
			b.strnama_cabang, 
			c.intid_unit, 
			c.strnama_unit, 
			d.strnama, 
			e.intharga_jawa, 
			e.intharga_luarjawa,
			e.intharga_kualalumpur, 
			e.intharga_luarkualalumpur,
			e.intid_harga
					from member a, cabang b, unit c, barang d, harga e 
					where a.intid_cabang = b.intid_cabang 
					and a.intid_unit = c.intid_unit 
					and a.intid_starterkit = d.intid_barang 
					and d.intid_barang = e.intid_barang
					and a.intid_dealer = $id");
         return $query->result();
	}
	function selectKelengkapanSK($id){
         $query = $this->db->query("select b.strnama,a.intquantity
			from starter_kit a, barang b
			where a.intid_barang = b.intid_barang
			and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between intid_week_start and intid_week_end
			and a.intid_barang_starterkit = $id");
         return $query->result();
	}
	
	function selectHarga($id){
         $query = $this->db->query("select intid_harga from harga where intid_barang = $id");
         return $query->result();
	}
	
	function selectCabangBs($keyword, $user){
        $query = $this->db->query("select a.intid_cabang, upper(a.strnama_cabang) strnama_cabang 
from cabang a, system_user b 
where (a.intid_cabang = b.intid_cabang or a.intid_cabang = b.intid_cabang2 or a.intid_cabang = b.intid_cabang3 or a.intid_cabang = b.intid_cabang4 
or a.intid_cabang = b.intid_cabang5 or a.intid_cabang = b.intid_cabang6 or a.intid_cabang = b.intid_cabang7 or a.intid_cabang = b.intid_cabang8 
or a.intid_cabang = b.intid_cabang9 or a.intid_cabang = b.intid_cabang10 )and a.strnama_cabang like '$keyword%' and b.intid_user = $user");
        return $query->result();
	}
	
	function selectCabang($keyword){
        $query = $this->db->query("select a.intid_cabang, upper(a.strnama_cabang) strnama_cabang 
from cabang a where a.strnama_cabang like '$keyword%'");
        return $query->result();
	}
	
	function selectKC($keyword){
        $query = $this->db->query("select intid_cabang, upper(strnama_cabang) strnama_cabang from cabang where jenis_cabang like '%Cabang%'and strnama_cabang like '$keyword%'");
        return $query->result();
	}
	function selectbabyKC($keyword){
        $query = $this->db->query("select intid_cabang, upper(strnama_cabang) strnama_cabang from cabang where strnama_cabang like '$keyword%'");
        return $query->result();
	}
	function selectSC($keyword){
        $query = $this->db->query("select cabang.intid_cabang, upper(cabang.strnama_cabang) strnama_cabang, cabang_persen.nilai_persen_fee fee from cabang left join cabang_persen on cabang.intid_cabang = cabang_persen.intid_cabang where jenis_cabang like '%SC%' and strnama_cabang like '$keyword%'");
        return $query->result();
	}
	
	 function selectBank(){
       
	   $query = $this->db->query("select intid_bank, upper(strnama_bank) strnama_bank from bank order by intid_bank asc");
	   return $query->result();
    }
	
	function selectUnit($keyword){
            $query = $this->db->query("select a.intid_unit, upper(a.strnama_unit) strnama_unit, upper(b.strnama_dealer) strnama_dealer, strkode_dealer from unit a, member b where a.intid_unit = b.intid_unit and a.strnama_unit like '$keyword%' and b.intlevel_dealer = 1");
            return $query->result();
	}

	function selectUnitPerCabang001($keyword, $user){
            $query = $this->db->query("select DISTINCT a.intid_unit, upper(a.strnama_unit) strnama_unit, upper(b.strnama_dealer) strnama_dealer, strkode_dealer from unit a, member b, cabang c, system_user d where a.intid_unit = b.intid_unit AND a.intkode_cabang = c.intkode_cabang AND c.intid_cabang = d.intid_cabang AND d.strnama_user = '$user' and a.strnama_unit like '$keyword%' and b.intlevel_dealer = 1");
			
			/* $query = $this->db->query("select DISTINCT a.intid_unit, upper(a.strnama_unit) strnama_unit, upper(b.strnama_dealer) strnama_dealer, strkode_dealer from unit a, member b, cabang c, system_user d where a.intid_unit = b.intid_unit AND a.intkode_cabang = c.intkode_cabang AND c.intid_cabang = d.intid_cabang and a.strnama_unit like '$keyword%' and b.intlevel_dealer = 1"); */
            return $query->result();
	}

	function selectUpline($keyword, $unit){
		$cab = $this->session->userdata('id_cabang');
		
		/*if(!empty($cab)){
		$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit and intid_cabang=$cab");
		}else{*/
		//$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit");
		
		/* $query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit and intid_cabang=$cab"); */
//001
		$query = $this->db->query("SELECT a.strnama_dealer, a.strkode_dealer, a.intlevel_dealer, a.strnama_upline, a.strkode_upline, a.intid_dealer,
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 967) AS steamer, 
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 961) AS emc,
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 966) AS chooper,
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 971) AS metal_5lt,
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 970) AS metal_7lt,
		(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 969) AS metal_7in1,
		is_hut,is_promo, is_ng
		FROM member AS a LEFT JOIN nota ON a.intid_dealer = nota.intid_dealer AND intid_jpenjualan = 10 WHERE a.strnama_dealer LIKE '$keyword%' AND a.intid_unit = $unit AND a.is_banned = 0 and a.active = '1' AND IF(a.intid_dealer > 144403, intid_nota IS NOT NULL, 1)");

		//}
               
        return $query->result();
	}
	
	function selectUplineCalon($keyword, $unit){
		$query = $this->db->query("select 
                                    distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline
                                   from
                                    member where strnama_dealer like '$keyword%' and intid_unit = $unit
                                    and member.strkode_dealer IN (select strkode_dealer from calon_manager)
                ");

        return $query->result();
	}
	
	function selectStarterkit(){
       
		$query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.intid_harga, b.intharga_jawa, b.intharga_luarjawa, b.intpv_jawa, b.intpv_luarjawa, b.intharga_kualalumpur, b.intharga_luarkualalumpur, b.intpv_kualalumpur, b.intpv_luarkualalumpur 
		from barang a, harga b, jenis_barang c where a.intid_barang = b.intid_barang 
		and a.intid_jbarang = c.intid_jbarang 
		and a.intid_jbarang = 4
		and CURDATE() BETWEEN b.date_start and b.date_end");
	   return $query->result();
    }  
	
		
	function selectMgr($intid_unit)
	{
        $query = $this->db->query("select strkode_dealer, strnama_dealer from member where intlevel_dealer = 1 and intid_unit = $intid_unit");
	    return $query->result();
	}
	
	function selectBarangSpcBintulu($keyword){
		$query = $this->db->query("SELECT cb.* , b.strnama
									from control_barang cb join barang b on(cb.intid_barang = b.intid_barang)
									where CURDATE() BETWEEN cb.tglawal and cb.tglakhir
									and b.strnama like '$keyword%'");
		return $query->result();
	}
	 
	function selectBarang($keyword, $jbarang){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.* from barang a, harga b where a.intid_barang = b.intid_barang and CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%' AND (a.intid_barang < 5001 OR a.intid_barang > 5006) AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4 AND a.intid_jbarang != '$req'");
        return $query->result();
	}
	function selectBarang2030($keyword, $jbarang){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, if(promo20.intid_barang_free is null ,0,1)as status_free,promo20.intid_barang_free,b.*  from barang a left join promo20 on a.intid_barang = promo20.intid_barang 	, harga b where a.intid_barang = b.intid_barang and CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%' AND (a.intid_barang < 5001 OR a.intid_barang > 5006) AND a.intid_jbarang != 5 AND a.intid_jbarang != 6 AND a.intid_jbarang != 4 AND a.intid_jbarang != $req group by a.intid_barang #promo20.intid_barang");
        return $query->result();
	}
	function selectPromoBarang($keyword, $jbarang,$intid_cabang=0,$statPencarian=''){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = '$statPencarian'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	function selectBarang203030($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = 'dis30'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	
	function selectBarang4010($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = 'dis4010'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	function selectBarang60net($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = 'dis60'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	function selectBarang2010($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = 'dis2010'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	
	function selectBarangAllItem($keyword){
		
		$query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.*, c.code_barang 
					from barang a left join barang_code_detail c on a.intid_barang = c.intid_barang, harga b 
					where 
					a.intid_barang = b.intid_barang 
					and CURDATE() BETWEEN b.date_start and b.date_end 
					and a.strnama like '$keyword%' 
					AND (a.intid_barang < 5001 OR a.intid_barang > 5006) 
					AND a.intid_jbarang != 5 AND a.intid_jbarang != 6");
        
		return $query->result();
	}
	
	function selectBarangLaunching($keyword){
		
		$query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.*, c.code_barang 
					from barang a left join barang_code_detail c on a.intid_barang = c.intid_barang, harga b 
					where 
					a.intid_barang = b.intid_barang 
					and CURDATE() BETWEEN b.date_start and b.date_end 
					and a.strnama like '$keyword%' 
					and a.status_barang = 1
					and c.is_launch = 1
					AND (a.intid_barang < 5001 OR a.intid_barang > 5006) 
					AND a.intid_jbarang != 5 ");
        
		return $query->result();
	}
	
	function selectBarangPromo20($keyword, $jbarang){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intharga_kualalumpur, c.intharga_luarkualalumpur, c.intpv_jawa, c.intpv_luarjawa, c.intpv_kualalumpur, c.intpv_luarkualalumpur,
									c.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa
									FROM promo20 a, barang b, harga c
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end
									and b.strnama like '%$keyword%' AND b.intid_jbarang != '$req'");


        return $query->result();
	}
	
	function selectBarangFree20($keyword, $state){
       
	    $query = $this->db->query("SELECT upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,c.intid_barang
									FROM promo20 a, barang b, harga c 
									where (a.intid_barang_free = b.intid_barang or a.intid_barang_free1= b.intid_barang or a.intid_barang_free2 = b.intid_barang)
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and a.intid_barang= $state
									and b.strnama like '$keyword%'");
        return $query->result();
	}
	
	function selectBarangPromo10($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intharga_kualalumpur, c.intharga_luarkualalumpur, c.intpv_jawa, c.intpv_luarjawa, c.intpv_kualalumpur, c.intpv_luarkualalumpur,
									b.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa
									FROM promo10 a, barang b, harga c
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end
									and b.strnama like '$keyword%'");
        return $query->result();
	}
	
	function selectBarangFree10($keyword, $state){
        $query = $this->db->query("SELECT a.intid_promo,upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,b.intid_barang
									FROM promo10 a, barang b, harga c 
									where a.intid_barang_free = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and a.intid_barang= $state
									and b.strnama like '$keyword%'");
        return $query->result();
	}

//001 PROMO MINI
	function selectBarangPromoMini($keyword, $cabang, $jbarang){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,
									b.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa
									FROM promomini a, barang b, harga c
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and b.strnama like '$keyword%'
									and a.intid_cabang = $cabang
									AND b.intid_jbarang != '$req'");
        return $query->result();
	}
	
	function insertNota($data){
		$tgl = date("Y-m-d");
		$dealer = $this->input->post('strkode_dealer');
		$unit = $this->input->post('id_unit');
		$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
        $intid_dealer = $i->result();
		if(isset($_POST['intdp'])){
			$is_dp = 1;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intdp');
		} else { 
			$is_dp = 0;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intcash');
			
		}
		if(isset($_POST['is_lg'])){
			$is_lg = 1;
		} else {
			$is_lg = 0;
		}
		if(isset($_POST['is_asi'])){
			$is_asi = 1;
			$kredit = $this->input->post('totalbayar1');
			$komisiasi = $this->input->post('intkomisiasi');
		} else {
			$is_asi = 0;
			$komisiasi = 0;
			$kredit = $this->input->post('intkkredit');
		}
		//071112 kenapa pake ini ya?? 
		/*if(isset($_POST['intid_jpenjualan'])){
			$jml20 = 0;
		} else {
			$jml20 = $this->input->post('jml20');
		}*/
		
		$data = array(
            'intno_nota' => $intid_nota,
            'intid_jpenjualan' => $this->input->post('intid_jpenjualan'),
			'intid_cabang' => $this->input->post('intid_cabang'),
            'datetgl' => $tgl,
			'intid_dealer' => $intid_dealer[0]->intid_dealer,
			'intid_unit' => $this->input->post('id_unit'),
			'intid_week' => $intid_week,
			'intomset10' => $this->input->post('jml10'),
			//'intomset20' => $jml20,
			'intomset20'=> $this->input->post('jml20'),
			'inttotal_omset' => $this->input->post('jumlah'),
			'inttotal_bayar' => $this->input->post('totalbayar1'),
			'intdp' => $this->input->post('intdp'),
			'intcash' => $cash,
			'intdebit' => $this->input->post('intdebit'),
			'intkkredit' => $kredit,
			'intsisa' => $this->input->post('intsisahidden'),
			'intkomisi10' => $this->input->post('komisi1hidden'),
			'intkomisi20' => $this->input->post('komisi2hidden'),
			'intpv' => $this->input->post('intpv'),
			'intvoucher' => $this->input->post('intvoucher'),
			'is_dp' => $is_dp,
			'is_lg' => $is_lg,
			'inttrade_in' => $this->input->post('komisitrade'),
			'is_asi' => $is_asi,
			'nokk' => $this->input->post('nokk'), 
			'intkomisi_asi' => $komisiasi,
			'is_arisan' => $this->input->post('is_arisan') 
		);
        $this->db->insert('nota', $data);
		$intid_nota =$this->db->insert_id();
				     //   return $intid_nota;
	}

    function insertSaveNota($data){
		$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$data = array(
            'intno_nota' => $this->input->post('intno_nota'),
            'intid_jpenjualan' => $this->input->post('intid_jpenjualan'),
			'intid_cabang' => $this->input->post('intid_cabang'),
            'datetgl' => $tgl,
			'intid_dealer' => $this->input->post('intid_dealer'),
			'intid_unit' => $this->input->post('intid_unit'),
			'intdp' => $this->input->post('intdp'),
			'intcash' => $this->input->post('intcash'),
			'inttotal_bayar' => $this->input->post('totalbayar1'),
			'intkkredit' => $this->input->post('intkkredit'),
            'intdebit' => $this->input->post('intdebit'),
			'intsisa' => $this->input->post('intsisa'),
            'intkomisi10' => $this->input->post('komisi1'),
            'intkomisi20' => $this->input->post('komisi2'),
			'intid_week' => $intid_week
		);
        $this->db->insert('nota', $data);
		
	}

    function add($data)
	{
        $this->db->insert("nota_detail", $data);
	}

    function add_arisan($data)
	{
        $this->db->insert("arisan", $data);
		        
	}
    
     function update_qtybarang($id_barang, $qty){
        $this->db->where('intid_barang', $id_barang);
		$this->db->update('barang', $qty);
    }
	
	 function get_MaxNota() {
        $this->db->select_max('intid_nota');
		$this->db->where('is_dp = 0');
		$query = $this->db->get('nota');
        return $query;
	}
	
	 function getNoNotaNew() {
        $this->db->select('id');
		$query = $this->db->get('counter');
        return $query->result();
	}
	
	 function getNoNotaUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter', $data);

    }
	
	function getNoMemberNew() {
        $this->db->select('id');
		$query = $this->db->get('counter_member');
        return $query->result();
	}
	
	 function getNoMemberUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_member', $data);

    }

     function get_MaxNotaArisan() {
        $this->db->select_max('intid_nota');
		$this->db->where('intid_jpenjualan = 9');
        $query = $this->db->get('nota');
        return $query;
     }
	 
	 function get_MaxNotaDp() {
        $this->db->select_max('intid_nota');
		$this->db->where('is_dp = 1');
        $query = $this->db->get('nota');
        return $query;
     }

     function getNoNota($id){
     if ($id)
	 { 
	   $query = $this->db->query("select * from nota where intid_nota = $id and is_dp = 0");
	   return $query->result();
	 }
    }

    function getNoNotaArisan($id){
     if ($id)
	 {
	   $query = $this->db->query("select * from nota where intid_nota = $id and intid_jpenjualan = 9");
	   return $query->result();
	 }
    }

	function getNoNotaDp(){
    	$this->db->select('id');
		$query = $this->db->get('counter_dp');
        return $query->result();
	}
	
	function getNoNotaDpUpdate($id){
        $data = array(
               'id' => $id
            );

		$this->db->update('counter_dp', $data);

    }

     function get_CetakNota($idNota) {
        $query = $this->db->query("select 
				nota.intno_nota, 
				nota.datetgl, 
				nota.intid_jpenjualan, 
				nota_detail.*, 
				nota.intdp,
				nota.is_arisan,
				nota_detail.intharga intharga_nota_detail, 
				barang.strnama, 
				harga.intharga_jawa,
                harga.intharga_luarjawa, cabang.intid_wilayah,
                cabang.strnama_cabang, 
				unit.strnama_unit, 
				member.strnama_dealer, 
				member.strnama_upline, nota.*,
				scan_barcode.barcode_data
                
                from nota
                inner join jenis_penjualan on nota.intid_jpenjualan = jenis_penjualan.intid_jpenjualan
				inner join cabang on cabang.intid_cabang = nota.intid_cabang
				inner join unit on unit.intid_unit = nota.intid_unit
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join member on member.intid_dealer = nota.intid_dealer
                left join barang on barang.intid_barang = nota_detail.intid_barang
                left join harga on harga.intid_barang = nota_detail.intid_barang
				left join 
				(select * from scan_barcode where scan_barcode.is_active = 1) scan_barcode on scan_barcode.kode = member.intid_dealer
                where #nota.is_dp = 0 and 
				nota.intid_nota = '$idNota'
				order by nota_detail.intid_nota");
        
        return $query->result();
     }

     function nama_bulan($bulan) {
        switch ($bulan) {
            case '1':
                $b = "Januari";
                break;
            case '2':
                $b = "Februari";
                break;
            case '3':
                $b = "Maret";
                break;
            case '4':
                $b = "April";
                break;
            case '5':
                $b = "Mei";
                break;
            case '6':
                $b = "Juni";
                break;
            case '7':
                $b = "Juli";
                break;
            case '8':
                $b = "Agustus";
                break;
            case '9':
                $b = "September";
                break;
            case '10':
                $b = "Oktober";
                break;
            case '11':
                $b = "November";
                break;
            case '12':
                $b = "Desember";
                break;

        }

        return $b;

    }
	 
	 function get_CetakNotaDp($idNota) {
        $query = $this->db->query("select nota.intno_nota, nota.datetgl, nota_detail.*, nota.intid_jpenjualan, barang.strnama, harga.intharga_jawa,
                harga.intharga_luarjawa, cabang.intid_wilayah,
                cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline, nota.*
                
                from nota
                
				inner join cabang on cabang.intid_cabang = nota.intid_cabang
				inner join unit on unit.intid_unit = nota.intid_unit
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join member on member.intid_dealer = nota.intid_dealer
                left join barang on barang.intid_barang = nota_detail.intid_barang
				inner join harga on harga.intid_barang = nota_detail.intid_barang
                where nota.is_dp = 1 
				and nota.intid_nota = '$idNota'");
        
        return $query->result();
     }

     function get_CetakNotaMember($idNota) {
      $query = $this->db->query("select nota.*, nota_detail.*, barang.strnama, 
							harga.intharga_jawa, harga.intharga_luarjawa, cabang.intid_wilayah, member.strnama_upline, 
							member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit
							from nota
							inner join cabang on cabang.intid_cabang = nota.intid_cabang
							inner join unit on unit.intid_unit = nota.intid_unit
							inner join member on member.intid_dealer = nota.intid_dealer
							inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
							left join barang on barang.intid_barang = nota_detail.intid_barang
							LEFT JOIN harga on harga.intid_barang = barang.intid_barang
							where nota.intid_nota = '$idNota'");
        return $query->result();
     }
	  function get_PV($kode, $bulan) {
         $thn = date('Y');
	     $query = $this->db->query("select 
		 	(select sum(n.intomset10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') 
				and n.is_dp = 0 
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer)intomset10, 
			(select sum(nota.intomset20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intomset20, 
			(select sum(nota.inttotal_omset) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) inttotal_omset, 
			(select sum(nota.intkomisi10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intkomisi10, 
			(select sum(nota.intkomisi20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intkomisi20,
			(select sum(nota.inttotal_bayar) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) inttotal_bayar, 
			(select sum(nota.intcash) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intcash,
			cabang.intid_wilayah, 
			member.strnama_upline,
			member.strnama_dealer,
			cabang.strnama_cabang,
			member.strkode_dealer,
			unit.strnama_unit
		from nota
			inner join cabang on cabang.intid_cabang = nota.intid_cabang
			inner join unit on unit.intid_unit = nota.intid_unit
			inner join member on member.intid_dealer = nota.intid_dealer
			where (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
			and member.strkode_upline = '$kode' 
			AND nota.intid_week in (select intid_week from week where intbulan = '$bulan') 
			AND nota.is_dp = 0
			group by member.strnama_dealer");
        return $query->result();
     }
	 /*
		desc : penambahan tahun untuk verifikasi waktu
	 */
	 function get_PV_tahun($kode, $bulan,$tahun) {
         $tahun = $tahun;
	     $query = $this->db->query("select 
		 	(select sum(n.intomset10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') 
				and n.is_dp = 0 
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer)intomset10, 
			(select sum(nota.intomset20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intomset20, 
			(select sum(nota.inttotal_omset) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) inttotal_omset, 
			(select sum(nota.intkomisi10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intkomisi10, 
			(select sum(nota.intkomisi20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intkomisi20,
			(select sum(nota.inttotal_bayar) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) inttotal_bayar, 
			(select sum(nota.intcash) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') and n.is_dp = 0
				and YEAR(n.datetgl) = '$tahun'
				and (n.intid_jpenjualan = 1 or n.intid_jpenjualan = 9) group by n.intid_dealer) intcash,
			cabang.intid_wilayah, 
			member.strnama_upline,
			member.strnama_dealer,
			cabang.strnama_cabang,
			member.strkode_dealer,
			unit.strnama_unit
		from nota
			inner join cabang on cabang.intid_cabang = nota.intid_cabang
			inner join unit on unit.intid_unit = nota.intid_unit
			inner join member on member.intid_dealer = nota.intid_dealer
			where (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
			and member.strkode_upline = '$kode' 
			AND nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun') 
			AND nota.is_dp = 0
			AND nota.intid_jpenjualan NOT IN (16)
			AND YEAR(nota.datetgl) = '$tahun'
			group by member.strnama_dealer");
        return $query->result();
     }
	 /*
	  function get_PV($kode, $bulan) {
         $thn = date('Y');
	     $query = $this->db->query("select 
		 	(select sum(n.intomset10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer )intomset10, 
			(select sum(nota.intomset20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer ) intomset20, 
			(select sum(nota.inttotal_omset) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer ) inttotal_omset, 
			(select sum(nota.intkomisi10) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer )  intkomisi10, 
			(select sum(nota.intkomisi20) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer ) intkomisi20,
			(select sum(nota.inttotal_bayar) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer ) inttotal_bayar, 
			(select sum(nota.intcash) from nota n where n.intid_dealer = member.intid_dealer 
				and n.intid_week in (select intid_week from week where intbulan = '$bulan') and n.is_dp = 0 group by member.intid_dealer ) intcash,
			cabang.intid_wilayah, 
			member.strnama_upline,
			member.strnama_dealer,
			cabang.strnama_cabang, 
			unit.strnama_unit
		from nota
			inner join cabang on cabang.intid_cabang = nota.intid_cabang
			inner join unit on unit.intid_unit = nota.intid_unit
			inner join member on member.intid_dealer = nota.intid_dealer
			where (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
			and member.strkode_upline = '$kode' 
			AND nota.intid_week in (select intid_week from week where intbulan = '$bulan') 
			AND nota.is_dp = 0
			group by member.strnama_dealer");
        return $query->result();
     }
	 */
	/*
     function get_PV($kode, $bulan) {
         $thn = date('Y');
	     $query = $this->db->query("select 
				sum(nota.intomset10) intomset10, 
				sum(nota.intomset20) intomset20, 
				sum(nota.inttotal_omset) inttotal_omset, 
				sum(nota.intkomisi10) intkomisi10, 
				sum(nota.intkomisi20) intkomisi20, 
				sum(nota.inttotal_bayar) inttotal_bayar, 
				sum(nota.intcash) intcash,
				cabang.intid_wilayah, 
				member.strnama_upline, 
				member.strnama_dealer,
				cabang.strnama_cabang, 
				unit.strnama_unit
			from nota
			inner join cabang on cabang.intid_cabang = nota.intid_cabang
			inner join unit on unit.intid_unit = nota.intid_unit
			inner join member on member.intid_dealer = nota.intid_dealer
			where (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
			and member.strkode_upline='$kode' 
			AND nota.intid_week in (select intid_week from week where intbulan = '$bulan')
			AND nota.is_dp = 0");
        return $query->result();
     }*/
	/*
     function get_unit_or($kode, $bulan, $unit) {
        $thn = date('Y');
     	/*		
		$query = $this->db->query("select distinct(nota.intomset10) intomset10, nota.intomset20, nota.inttotal_omset, nota.intkomisi10, nota.intkomisi20, nota.inttotal_bayar, nota.intcash,
		cabang.intid_wilayah, member.strnama_upline,member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit,
		unit.intid_unit
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		left join nota_detail on nota_detail.intid_nota = nota.intid_nota
		where member.intlevel_dealer not in (1) and (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) AND MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn'
		and nota.intid_unit = $unit");
		*
		
		$query = $this->db->query("select nota.intomset10, nota.intomset20, nota.inttotal_omset, nota.intkomisi10, nota.intkomisi20, nota.inttotal_bayar, nota.intcash,
		cabang.intid_wilayah, member.strnama_upline,member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit,
		unit.intid_unit
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		left join nota_detail on nota_detail.intid_nota = nota.intid_nota
		where member.intlevel_dealer not in (1) and (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) AND MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn'
		and nota.intid_unit = $unit group by nota_detail.intid_nota");
		
        return $query->result();
			
     }*/
	 /*
	 function getRekrut($kode, $bulan) {
        $thn = date('Y');
     	$query = $this->db->query("select distinct(member.intid_dealer), member.strkode_dealer, member.strnama_dealer, sum(nota.inttotal_omset) omset
		from member left join nota on member.intid_dealer = nota.intid_dealer 
		where MONTH(member.datetanggal)='$bulan' 
		and  YEAR(member.datetanggal)='$thn' 
		and member.strkode_upline='$kode'
		and member.intid_dealer in (select distinct(intid_dealer) from nota where MONTH(datetgl)='$bulan' 
		and YEAR(datetgl)='$thn')
		group by nota.intid_dealer;");
        return $query->result();
			
     }
*/
      function get_manager_unit($bulan) {
      $thn = date('Y');
      $query = $this->db->query("select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
		unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
		(select sum(a.inttotal_omset) total_omset
		from nota a
		where 
		a.intid_week in (select intid_week from week where intbulan='$bulan') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit 
		and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
		and a.is_dp = 0) omset_unit,
		(select sum(a.inttotal_omset) total_omset
		from nota a
		where 
		a.intid_week in (select intid_week from week where intbulan='$bulan') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit and a.intid_jpenjualan = 1
		and a.is_dp = 0) omset_unit_asli
		from nota, member, unit, cabang 
		where nota.intid_dealer = member.intid_dealer 
		and member.intid_unit = unit.intid_unit
		and member.intid_cabang = cabang.intid_cabang
		and member.intlevel_dealer = 1
		and nota.intid_week in (select intid_week from week where intbulan='$bulan')
		and YEAR(nota.datetgl)='$thn' 
		and nota.is_dp = 0
		group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer 
		order by cabang.strnama_cabang asc") ;
	/*
	   $query = $this->db->query("select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
		unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
		(select sum(a.inttotal_omset) total_omset
			from nota a
			where 
			a.intid_week in (select intid_week from week where intbulan='$bulan')
			and a.intid_unit = unit.intid_unit and a.intid_jpenjualan = 1
			and a.is_dp = 0) omset_unit
		from nota inner join member on member.intid_dealer = nota.intid_dealer 
		inner join unit on unit.intid_unit
		inner join cabang on cabang.intkode_cabang = unit.intkode_cabang
		where  member.intlevel_dealer = 1
		and nota.intid_week in (select intid_week from week where intbulan='$bulan')
		and nota.is_dp = 0
		group by member.strkode_dealer 
		order by cabang.strnama_cabang asc") ;
	*/
	return $query->result();
     }
	 /**
	 * @param get_manager_unit_tahun
	 * desc : menambahkan tahun di laporannya
	 */ 
	
	//modified 2014-04-02 ifirlana@gmail.com
	
	function get_manager_unit_tahun($bulan,$tahun) {
		$thn = $tahun;
		/**
		* before tunning 2014-04-02
		
		$select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
		unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
		(select sum(a.inttotal_omset) total_omset
		from nota a
		where 
		a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit 
		and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
		and a.is_dp = 0) omset_unit,
		(select sum(a.inttotal_omset) total_omset
		from nota a
		where 
		a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit and a.intid_jpenjualan = 1
		and a.is_dp = 0) omset_unit_asli
		from nota, member, unit, cabang 
		where nota.intid_dealer = member.intid_dealer 
		and member.intid_unit = unit.intid_unit
		and member.intid_cabang = cabang.intid_cabang
		and member.intlevel_dealer = 1
		and nota.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun')
		and YEAR(nota.datetgl)='$thn' 
		and nota.is_dp = 0
		group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer 
		order by cabang.strnama_cabang asc";
		*/
		/**
		* tuning query ifirlana@gmail.com*/
		/* $select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
				unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
				omset_u.total_omset omset_unit,
				(select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan,
				omset_asli.total_omset omset_unit_asli
				from 
				nota, 
				member, 
				cabang,
				unit left join 
				(select sum(a.inttotal_omset) total_omset, a.intid_unit
					from nota a
					where 
					a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn' 
					and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
					and a.is_dp = 0
					group by a.intid_unit
					) omset_u 
				on unit.intid_unit = omset_u.intid_unit
				left join 
				(select sum(a.inttotal_omset) total_omset,a.intid_unit
					from nota a
					where 
					a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn'  and a.intid_jpenjualan = 1
					and a.is_dp = 0
					group by a.intid_unit
					) omset_asli
				on unit.intid_unit = omset_asli.intid_unit
				where 
				nota.intid_dealer = member.intid_dealer 
				and member.intid_unit = unit.intid_unit
				and member.intid_cabang = cabang.intid_cabang
				and member.intlevel_dealer = 1
				and nota.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun')
				and YEAR(nota.datetgl)='$thn' 
				and nota.is_dp = 0
				group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer 
				order by cabang.strnama_cabang asc"; */
				$select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
				unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
				omset_u.total_omset omset_unit,
				(select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan,
				omset_asli.total_omset omset_unit_asli
				from 
				nota, 
				member, 
				cabang,
				unit left join 
				(select sum(a.inttotal_omset) total_omset, a.intid_unit
					from nota a
					where 
					a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn' 
					and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
					and a.is_dp = 0
					group by a.intid_unit
					) omset_u 
				on unit.intid_unit = omset_u.intid_unit
				left join 
				(select sum(a.inttotal_omset) total_omset,a.intid_unit
					from nota a
					where 
					a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun') AND YEAR(a.datetgl)='$thn'  and a.intid_jpenjualan in (1)#,16,18)
					and a.is_dp = 0
					group by a.intid_unit
					) omset_asli
				on unit.intid_unit = omset_asli.intid_unit
				where 
				nota.intid_dealer = member.intid_dealer 
				and member.intid_unit = unit.intid_unit
				and member.cabang_pengambilan = cabang.intid_cabang
				and member.intlevel_dealer = 1
				and nota.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun='$tahun')
				and YEAR(nota.datetgl)='$thn' 
				and nota.is_dp = 0
				group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer 
				order by cabang.strnama_cabang asc";
			 	
		$query = $this->db->query($select) ;
		return $query->result();
		 }
    function selectWeek()
	{
		$thn = date('Y');
		$query = $this->db->query("select intid_week from week where curdate() between dateweek_start and dateweek_end");
	    return $query->result();
	}
	
	function selectNoNota()
	{
		$query = $this->db->query("select substring(intno_nota, 7, 7) intno_nota from nota order by intno_nota desc limit 0, 1");
	    return $query->result();
	}
	
	function selectJPenjualan(){
		if(strtoupper($this->session->userdata('username')) != "ADMIN"){
			$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,4,5,6,7,8,13) and is_active = 1  order by intid_jpenjualan asc");
		}else{
				$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,4,5,6,7,8,13)  order by intid_jpenjualan asc");
			}
		return $query->result();
    }
	function selectJPenjualanPromo4010($promo = "dis402010"){
	$qry1 = $this->db->query("SELECT * FROM  `control_promo`where nama_promo =  '$promo' ")->result();
	foreach($qry1 as $row){
/* 		if(strtoupper($this->session->userdata('username')) != "ADMIN"){
 */			$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (".$row->intid_jpenjualan.") and is_active = 1  order by intid_jpenjualan asc");
/* 		}else{
				$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,4,5,6,7,8,13)  order by intid_jpenjualan asc");
			}
 */		
	}
	return $query->result();
    }
	/* pengaturan untuk penjualan mana saja yang akan aktif 
	*	created by: fahmi hilmansyah
	*	email: fahmi.hilmansyah@gmail.com
	*	untuk select jenis penjualan, akan di cari sesuai nama_promo nya
	*	untuk select barang, akan di cari di table promo_tanggal untuk mengambil barangnya
	*/
	/* function lookupcontrollbarang($nama='', $pencarian='', $cabang=0){
	return $this->db->query("SELECT
(SELECT barang.strnama from barang where barang.intid_barang = control_barang.intid_barang )strnama,
	control_barang.*
FROM
	control_barang
WHERE
	intid_barang IN (
		SELECT
			intid_barang
		FROM
			barang
		WHERE
			strnama LIKE 'medium square%'
	)
and CURDATE() BETWEEN tglawal and tglakhir
and status_pencarian = '$pencarian' and intid_cabang=$cabang");
	} */
	function selectJPenjualanControllPromo($promo = ""){
	$qry1 = $this->db->query("SELECT * FROM  `control_promo`where nama_promo =  '$promo' ")->result();
	foreach($qry1 as $row){
	/*if(strtoupper($this->session->userdata('username')) != "ADMIN"){*/
			$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (".$row->intid_jpenjualan.") and is_active = 1  order by intid_jpenjualan asc");
	/* }else{
					$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,4,5,6,7,8,13)  order by intid_jpenjualan asc");
				} */		
	}
	return $query->result();
    }
	function selectBarangControlPromo($keyword, $key, $intid_cabang = 0, $intid_wilayah = ""){
	//$qry1 = $this->db->query("SELECT * FROM  `control_promo`where nama_promo =  '$key' ")->result();
	//foreach($qry1 as $row){
		/* $query = $this->db->query( "SELECT UPPER( b.strnama ) promo, h.intharga_jawa, h.intcicilan_jawa,
						  h.intum_jawa,h.intum_luarjawa,b.strnama,h.intid_harga,
						  h.intcicilan_luarjawa,h.intharga_luarjawa, h.intpv_jawa, h.intpv_luarjawa, b.intid_barang,
						  h.intharga_kualalumpur, h.intharga_luarkualalumpur,
						  h.intpv_kualalumpur, h.intpv_luarkualalumpur,
						  b.intid_jbarang
							FROM barang b, harga h, promotanggal p 
							WHERE b.status_barang =1
							AND  h.intid_barang = b.intid_barang
							and b.intid_barang = p.intid_barang
							and curdate() between p.tanggal_mulai and p.tanggal_berakhir
							and p.status_pencarian = '".$qry1[0]->pencarian."'
							and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
							and p.intid_wilayah like '%".$intid_wilayah."%'
							AND b.strnama LIKE  '".$keyword."%'"); */
		$select = "SELECT UPPER( b.strnama ) promo, h.intharga_jawa, h.intcicilan_jawa,
						  h.intum_jawa,h.intum_luarjawa,b.strnama,h.intid_harga,
						  h.intcicilan_luarjawa,h.intharga_luarjawa, h.intpv_jawa, h.intpv_luarjawa, b.intid_barang,
						  h.intharga_kualalumpur, h.intharga_luarkualalumpur,
						  h.intpv_kualalumpur, h.intpv_luarkualalumpur,
						  b.intid_jbarang,
						  p.is_voucher 
							FROM barang b, harga h, promotanggal p 
							WHERE b.status_barang =1
							AND  h.intid_barang = b.intid_barang
							and b.intid_barang = p.intid_barang
							and curdate() between p.tanggal_mulai and p.tanggal_berakhir
							and p.status_pencarian = '".$key."'
							and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
							and p.intid_wilayah like '%".$intid_wilayah."%'
							AND b.strnama LIKE  '".$keyword."%'";
		$query = $this->db->query($select);
		return $query->result();
	//}
		
	}
	
	//added 2014-04-08 ifirlana@gmail.com
	//desc: mendadak untuk pemilu
	
	function selectJPenjualanReguler(){
       
	   if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
		$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (2,3) #(1,2,3) 
		and is_active = 1 order by intid_jpenjualan asc");
	   }else{
			$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (2,3) # (1,2,3)   
			order by intid_jpenjualan asc");
	  }
	   return $query->result();
    }
	
	function selectJPenjualanNotTrade(){
		if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3) and is_active = 1  order by intid_jpenjualan asc");
		}else{
			 $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3)  order by intid_jpenjualan asc");
			}
	   return $query->result();
    }

	function selectJPenjualanPromo(){
		if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
	    $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,7) and is_active = 1 order by intid_jpenjualan asc");
		}else{
			  $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3,7)  order by intid_jpenjualan asc");
		}
	   return $query->result();
    }
	
	function selectJPenjualanSpesial(){
       if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3, 11,12) and is_active = 1 order by intid_jpenjualan asc");
	   }else{
			 $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3, 11,12)  order by intid_jpenjualan asc");
	 }
	   return $query->result();
    }
	//perbaruan dari functiion selectJPenjualanSpesial
	//karena ada pembuatan jenis_penjualan netto
	function selectJPenjualanSpesial_ver2(){
       if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
		$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (7,11,12,14,24) and is_active = 1 order by intid_jpenjualan asc");
	   }else{
		$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (7,11,12,14,24)  order by intid_jpenjualan asc");
		}
	   return $query->result();
    }
	
	//@param selectJPenjualanDiskon20
	//desc : mendadak untuk penjualan diskon 20
	
	function selectJPenjualanDiskon20(){
       
	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3 )  order by intid_jpenjualan asc");
	   return $query->result();
    }
	
	//@param selectJPenjualanDiskon40
	//desc : mendadak untuk penjualan diskon 40
	
	function selectJPenjualanDiskon40(){
       
	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (16,2,3 )  order by intid_jpenjualan asc");
	   return $query->result();
    }
	
	
	//@param selectJPenjualanDiskon50
	//desc : mendadak untuk penjualan diskon 50
	
	function selectJPenjualanDiskon50(){
       
	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (18 )  order by intid_jpenjualan asc");
	   return $query->result();
    }
	//end selectJPenjualanDiskon50
	
	function selectJPenjualanVoucher(){
       
	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (7 )  order by intid_jpenjualan asc");
	   return $query->result();
    }
	function selectJPenjualan2030(){
       
	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3 )  order by intid_jpenjualan asc");
	   return $query->result();
    }
	function selectJPenjualan60net($promo = ""){
		$qry1 = $this->db->query("SELECT * FROM  `control_promo`where nama_promo =  '$promo' ")->result();
		foreach($qry1 as $row){
			$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (".$row->intid_jpenjualan.") and is_active = 1  order by intid_jpenjualan asc");
		}
	return $query->result();
/* 	   	$query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (1,2,3 )  order by intid_jpenjualan asc");
	   return $query->result();
 */    
	}
	
	
	function selectBarangLain($keyword){
        //$query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.intharga_jawa, b.intharga_luarjawa, b.intpv_jawa, b.intpv_luarjawa,b.intharga_luarkualalumpur from barang a, harga b where a.intid_barang = b.intid_barang and CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%' and a.strnama not like 'level gift%' and a.intid_jbarang in (5,6) and a.status_barang = 1");
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, 
		if( b.harga_lain != 0, b.harga_lain, b.intharga_jawa) intharga_jawa, if( b.harga_lain_luar_jawa != 0, b.harga_lain_luar_jawa,b.intharga_luarjawa) intharga_luarjawa, b.intpv_jawa, b.intpv_luarjawa,b.intharga_luarkualalumpur from barang a left JOIN 
	harga b on a.intid_barang = b.intid_barang where  CURDATE() BETWEEN b.date_start and b.date_end and a.strnama like '$keyword%' and a.strnama not like 'level gift%' and (a.intid_jbarang IN (6) or b.harga_lain != 0 or b.harga_lain_luar_jawa != 0) and a.status_barang = 1");
        return $query->result();
	}
	
	//ifirlana@gmail.com 2014 04 17
	//desc menggantikan selectBarangLain
	
	function selectBarangLaintipe2($keyword){
        $query = $this->db->query("select 
		a.intid_barang, upper(a.strnama) strnama, b.intharga_jawa, b.intharga_luarjawa, b.intpv_jawa, b.intpv_luarjawa, p.intid_barang_free 
		from barang a left join promolain p on p.intid_barang = a.intid_barang, 
		harga b 
		where a.intid_barang = b.intid_barang 
		and CURDATE() BETWEEN b.date_start and b.date_end 
		and a.strnama like '$keyword%' 
		and a.strnama not like 'level gift%' 
		and a.intid_jbarang in (5,6)");
        return $query->result();
	}
	
	
	function getOmset($kode)
	{
		$week = $this->db->query("select intid_week from week where curdate() between dateweek_start and dateweek_end");
        $id_week = $week->result();
		$week_now = $id_week[0]->intid_week;
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and a.intid_week = $week_now
								   and a.is_lg = 0
								   and a.is_dp = 0");
        return $query->result();
	}
	
	function getidDealer($strkode){
            $this->db->select('member.intid_dealer');
            $this->db->from('member');
            $this->db->where('member.strkode_dealer', $strkode);
            return $this->db->get()->result();
		
    }
	
	function selectBarangLg($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) lg, c.intharga_jawa, c.intharga_luarjawa,c.intharga_luarkualalumpur, b.intid_barang
									FROM tipe_lg a, barang b, harga c 
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and b.strnama like '$keyword%' and b.status_barang = 1 order by b.strnama");
        return $query->result();
	}
	
	function selectNotaDp($keyword, $id_cabang ){
        $query = $this->db->query("SELECT 
									a.*, 
									m.strnama_dealer,
									m.intlevel_dealer
									FROM nota a, 
									member m, nota_detail nd
									where
									a.intid_dealer = m.intid_dealer
									and a.intid_nota = nd.intid_nota
									and (a.datetgl >= date_sub(curdate(), interval 7 day) 
									OR (nd.intid_barang in (11400,11401,11402,11403,11404,11405))
									OR a.intid_cabang = '37'
									OR a.intid_nota=578470) 
									and a.is_dp = 1
									and a.intid_cabang = $id_cabang
									and a.intno_nota like '$keyword%'
									group by a.intid_nota
									");
		/*$query = $this->db->query("SELECT 
									a.*, 
									m.strnama_dealer,
									m.intlevel_dealer
									FROM nota a, 
									member m
									where
									a.intid_dealer = m.intid_dealer
									and a.is_dp = 1
									and a.intid_cabang = $id_cabang
									and a.intno_nota like '$keyword%'");*/
        return $query->result();
	}
	
	function getNotaDp($no)
	{
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_bayar , a.intdp, a.intsisa
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intno_nota = '$no'");
        return $query->result();
	}
	
	function pelunasanNotaDp($no)
	{
		$query = $this->db->query("select a.*, 
									c.strnama_dealer, 
									(select intid_dealer from member where member.strkode_dealer = c.strkode_dealer) intid_upline,
									c.strkode_dealer, c.strnama_upline, d.strnama_unit
								   from nota a, member c, unit d 
								   where a.intid_dealer = c.intid_dealer 
								   and a.intid_unit = d.intid_unit and a.intno_nota = '$no'");
        return $query->result();
	}
	
	function pelunasanNotaDetailDp($no)
	{
		$query = $this->db->query("select b.*, c.strnama
								   from nota a join nota_detail b on a.intid_nota = b.intid_nota, barang c 
								   where b.intid_barang = c.intid_barang 
								   and a.intno_nota = '$no'");
        return $query->result();
	}
	
	function updateNota($data)
	{
		$tgl = date("Y-m-d");
		$data = array(
            'intno_nota' => $this->input->post('intno_nota'),
			'intcash' => $this->input->post('intcash'),
			'intdebit' => $this->input->post('intdebit'),
			'intkkredit' => $this->input->post('intkkredit'),
			'intsisa' => $this->input->post('intsisahidden'),
			'is_dp' => 0, 
			'intid_week' => $this->input->post('intid_week'), 
			'datetgl' => $tgl
			
		);
       
	   $this->db->where('intid_nota', $this->input->post('intid_nota'));
       $this->db->update('nota',$data);
		
	}
	
	function updateNotaLg($id_nota)
	{
		$data = array(
            'is_lg' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intid_nota', $id_nota);
       $this->db->update('nota',$data);
		
	}
	
	function update_cicilan($id, $cicilan,$no_nota){
        $data = array(
            'c'.$cicilan => $no_nota,
			);

	   $this->db->where('intid_arisan', $id);
       $this->db->update('arisan',$data);
    }
	//notaArisanArea
	function SaveArisan(){
           $tgl = date("Y-m-d");
           
        $this->db->insert('arisan_detail', $data);
		$intid_nota =$this->db->insert_id();
		$data4 = array(
        'intid_cabang' => $this->input->post('intid_cabang'),
        'datetgl' => $tgl,
        'intid_dealer' => $this->input->post('intid_dealer'),
        'intid_barang' => $this->input->post('intid_barang'),
        'intid_peserta' => $this->input->post('intid_peserta'),
        'intid_pemenang' => $this->input->post('intid_pemenang'),
		'group' => $this->input->post('group'),
        'intdp' => $this->input->post('intdp'),
		'intcash' => $this->input->post('intcash'),
		'intkkredit' => $this->input->post('intkkredit'),
        'intdebit' => $this->input->post('intdebit'),
		'intsisa' => $this->input->post('intsisa'),
		'intc_1' => $this->input->post('intc_1'),
		'intc_2' => $this->input->post('intc_2'),
		'intc_3' => $this->input->post('intc_3'),
		'intc_4' => $this->input->post('intc_4'),
		'intc_5' => $this->input->post('intc_5'),
		'intc_6' => $this->input->post('intc_6'),
		'intc_7' => $this->input->post('intc_7')
			
		);
        $this->db->insert('arisan_detail', $data4);
        }
		
		function insertArisan($data){
		$tgl = date("Y-m-d");
		$dealer = $this->input->post('strnama_dealer');
		$i = $this->db->query("select intid_dealer from member where strnama_dealer like '$dealer%'");
        $intid_dealer = $i->result();
		$intid_nota = $this->input->post('intno_nota');
        $week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		if(!$_POST['intdp']){
			$is_dp = 0;
		} else { 
			$is_dp = 1;
		}
		$data = array(
            'intid_peserta' => $intid_dealer[0]->intid_dealer,
			'intkomisi10' => $this->input->post('komisi1hidden'),
			'intkomisi20' => $this->input->post('komisi2hidden'),
			'intpv' => $this->input->post('intpv'),
			'is_dp' => $is_dp
		);
        $this->db->insert('arisan_detail', $data);
		$intid_nota =$this->db->insert_id();
				        
	}
	
	function get_MaxArisan() {
        $this->db->select_max('	intid_darisan');
		$query = $this->db->get('arisan_detail');
        return $query;
     }
	/*
	//yang lama diubah 17April ama ikhlas
     function get_dealer_unit($bulan) {
         
		 $thn = date('Y');
		 $query = $this->db->query("select sum(inttotal_omset) omset, member.strnama_dealer, unit.strnama_unit, unit.intid_unit,
			member.strkode_dealer, member.strkode_upline, member.strnama_upline, cabang.strnama_cabang
			from nota, member, unit, cabang
			where member.intid_dealer = nota.intid_dealer 
			and nota.intid_unit = unit.intid_unit 
			and nota.intid_cabang = cabang.intid_cabang
			and nota.inttotal_omset >= 300000 
			and nota.intid_week in (select intid_week from week where intbulan ='$bulan') 
			and YEAR(nota.datetgl)='$thn' 
			and member.intlevel_dealer not in (1)
			and member.strkode_dealer in (select DISTINCT (b.strkode_upline)
			from nota a
			inner join member b on b.intid_dealer = a.intid_dealer
			inner join nota_detail c on c.intid_nota = a.intid_nota 
			where b.strkode_upline = member.strkode_dealer
			and (a.intid_jpenjualan = 1 or (a.intid_jpenjualan = 1 and a.is_arisan = 1))
			and a.intid_week in (select intid_week from week where intbulan ='$bulan')
			and YEAR(a.datetgl)='$thn')
			group by member.strnama_dealer, unit.strnama_unit");
		return $query->result();
     }
	 */
	 function get_dealer_unit($bulan) {
         
		 $thn = date('Y');
		 $query = $this->db->query("select 
					 sum(inttotal_omset) omset, 
					 member.strnama_dealer, 
					 unit.strnama_unit, 
					 unit.intid_unit,
					member.strkode_dealer, 
					member.strkode_upline, 
					member.strnama_upline, 
					cabang.strnama_cabang
					from nota, member, unit, cabang
			where member.intid_dealer = nota.intid_dealer 
				and nota.intid_unit = unit.intid_unit 
				and nota.intid_cabang = cabang.intid_cabang
				and nota.intid_week in (select intid_week from week where intbulan ='$bulan') 
				and nota.is_dp = 0
				and member.intlevel_dealer not in (1)
			and member.strkode_dealer in (select DISTINCT (b.strkode_upline)
											from nota a
												inner join member b on b.intid_dealer = a.intid_dealer
												inner join nota_detail c on c.intid_nota = a.intid_nota 
											where b.strkode_upline = member.strkode_dealer
												and (a.intid_jpenjualan = 1 or (a.intid_jpenjualan = 1 and a.is_arisan = 1))
												and a.intid_week in (select intid_week from week where intbulan ='$bulan'))
			group by member.strnama_dealer, unit.strnama_unit");
		return $query->result();
     }
	 /*
		2 jan 2013
		ikhlas firlana ifirlana@gmail.com
		desc ;  penambahan tahun 
	 */
	 function get_dealer_unit_tahun($bulan,$tahun) {
         
		 $thn = $tahun;
		 $query = $this->db->query("select 
					 sum(inttotal_omset) omset, 
					 member.strnama_dealer, 
					 unit.strnama_unit, 
					 unit.intid_unit,
					member.strkode_dealer, 
					member.strkode_upline, 
					member.strnama_upline, 
					(select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan,
					cabang.strnama_cabang
					from nota, member, unit, cabang
			where member.intid_dealer = nota.intid_dealer 
				and nota.intid_unit = unit.intid_unit 
				and nota.intid_cabang = cabang.intid_cabang
				and nota.intid_week in (select intid_week from week where intbulan ='$bulan' and inttahun = '$thn') 
				and nota.is_dp = 0
				and YEAR(nota.datetgl) = '$thn'
				and member.intlevel_dealer not in (1)
			and member.strkode_dealer in (select DISTINCT (b.strkode_upline)
											from nota a
												inner join member b on b.intid_dealer = a.intid_dealer
												inner join nota_detail c on c.intid_nota = a.intid_nota 
											where b.strkode_upline = member.strkode_dealer
												and (a.intid_jpenjualan = 1 or a.intid_jpenjualan = 16 or (a.intid_jpenjualan = 1 and a.is_arisan = 1))
												and a.intid_week in (select intid_week from week where intbulan ='$bulan' and inttahun = '$thn')
												and YEAR(a.datetgl) = '$thn')
			and (member.intid_starterkit is null or member.intid_starterkit != 0)
			group by member.strnama_dealer, unit.strnama_unit");
		return $query->result();
     }
	 function ordealer_member($strkode_upline, $bulan){
	 	
		$thn = date('Y');
		$query = $this->db->query("select DISTINCT(member.strnama_dealer),member.strkode_dealer, member.strkode_upline, member.strnama_upline, unit.strnama_unit, cabang.strnama_cabang
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		inner join nota_detail on nota_detail.intid_nota = nota.intid_nota 
		where member.strkode_upline = '$strkode_upline' 
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)
		and MONTH(nota.datetgl)='$bulan' 
		and YEAR(nota.datetgl)='$thn'");
        return $query;
	 }

     function getDealerByName($kode){
         $this->db->select('member.strnama_dealer, cabang.strnama_cabang, (select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan');
         $this->db->from('member');
		 $this->db->join('cabang', 'member.intid_cabang = cabang.intid_cabang' );
         $this->db->where('strkode_dealer', $kode);
         return $this->db->get()->row();
     }
	 
	 function get_reguler($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset10 TGroup10
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 1
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
		
		TAMBAHAN:
		- penambahan omset15 = 04-11-2014
	*/
	 function get_regulertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        //kondisi
        if($tahun > 2014)
        {
        	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, a.intomset15 TGroup15, intomset10 TGroup10, otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 1
			and a.is_dp = 0
			order by a.intno_nota asc");
        }else
        {
      		$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, a.intomset15 TGroup15, intomset10 TGroup10, otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 1
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
     function get_reguler_dealer($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select sum(inttotal_bayar) RegDealer
				from nota 
				where intid_jpenjualan = 1
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	  function get_reguler_dealertahun($kode, $bulan,$tahun) {
         $thn = $tahun;
        if($tahun > 2014)
       	{
      	 $query = $this->db->query("select sum(inttotal_bayar) RegDealer
				from nota 
				where intid_jpenjualan = 1
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}else
      	{
      	 $query = $this->db->query("select sum(inttotal_bayar) RegDealer
				from nota_2014 
				where intid_jpenjualan = 1
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}
        return $query->result();
     }
     //HUT

	  function get_hut($kode, $bulan) {
		$thn = date('Y');
		$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset10 TGroup10
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 2
		and a.is_dp = 0
		order by a.intno_nota asc");
		return $query->result();
	 }
	
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
		TAMBAHAN:
		omset 15 = 04-11-2014
	*/
	  function get_huttahun($kode, $bulan,$tahun) {
		$thn = $tahun;
		if($tahun > 2014)
		{
			$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 2
			and a.is_dp = 0
			order by a.intno_nota asc");
		}else
		{
			$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 2
			and a.is_dp = 0
			order by a.intno_nota asc");
		}
		return $query->result();
	 }

     function get_hut_dealer($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select sum(inttotal_bayar) HutDealer
				from nota 
				where intid_jpenjualan = 2
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	   function get_hut_dealertahun($kode, $bulan,$tahun) {
         $thn = $tahun;
        if($tahun > 2014)
        {
      	 $query = $this->db->query("select sum(inttotal_bayar) HutDealer
				from nota 
				where intid_jpenjualan = 2
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");        	
	    }else
	    {
      	 $query = $this->db->query("select sum(inttotal_bayar) HutDealer
				from nota_2014 
				where intid_jpenjualan = 2
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}
        return $query->result();
     }
//CHALLENGE

      function get_cal($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset10 TGroup10
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 3
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
		TAMABAHAN:
		omset 15 = 04-11-2014
	*/
	 function get_caltahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, otherKom
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 3
		and a.is_dp = 0
		order by a.intno_nota asc");
        }else
        {
        	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, otherKom
		from nota_2014 a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 3
		and a.is_dp = 0
		order by a.intno_nota asc");
        }
        return $query->result();
     }
     function get_cal_dealer($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select sum(inttotal_bayar) CalDealer
				from nota 
				where intid_jpenjualan = 3
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	 /*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	 
     function get_cal_dealertahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
      	 $query = $this->db->query("select sum(inttotal_bayar) CalDealer
				from nota 
				where intid_jpenjualan = 3
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}else
      	{
      	 $query = $this->db->query("select sum(inttotal_bayar) CalDealer
				from nota_2014 
				where intid_jpenjualan = 3
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}
        return $query->result();
     }
	 //TRADE IN
	//tgl 14 agustus 2013 pengubahan dengan menambahkan Total_Omset untuk menghitung data yang valid dan menampilkan nya dipenjualan omset10
      function get_tin($kode, $bulan) {
        $thn = date('Y');
        $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset10 TGroup10, inttotal_omset Total_Omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 4
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	function get_tintahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
        	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, inttotal_omset Total_Omset, otherKom, otherKom otherKomtin
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 4
			and a.is_dp = 0
			order by a.intno_nota asc");
    	}else
    	{
			$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset20 TGroup20, intomset15 TGroup15, intomset10 TGroup10, inttotal_omset Total_Omset, otherKom, otherKom otherKomtin
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 4
			and a.is_dp = 0
			order by a.intno_nota asc");
    	}
        return $query->result();
     }
     function get_tin_dealer($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select sum(inttotal_bayar) tinDealer
				from nota 
				where intid_jpenjualan = 4
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	  /*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
		
     function get_tin_dealertahun($kode, $bulan,$tahun) 
     {
         $thn = $tahun;
         if($tahun > 2014)
         {
         $query = $this->db->query("select sum(inttotal_bayar) tinDealer
				from nota 
				where intid_jpenjualan = 4
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
         	
	     }else
	     {
      	 $query = $this->db->query("select sum(inttotal_bayar) tinDealer
				from nota_2014 
				where intid_jpenjualan = 4
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
     	}
        return $query->result();
     }
	 //1 FREE 1 HUT

      function get_ifi($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 5
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	 /*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
      function get_ifitahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 5
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 5
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
     function get_ifi_dealer($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select sum(inttotal_bayar) ifiDealer
				from nota 
				where intid_jpenjualan = 5
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	  /*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	function get_ifi_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) ifiDealer
				from nota 
				where intid_jpenjualan = 5
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}else
      	{
      		$query = $this->db->query("select sum(inttotal_bayar) ifiDealer
				from nota _2014
				where intid_jpenjualan = 5
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}
        return $query->result();
     }
	 //1 FREE 1

      function get_ifo($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset10 TGroup10
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 6
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
		function get_ifotahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset10 TGroup10, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 6
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.intomset10 TGroup10, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 6
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
     function get_ifo_dealer($kode, $bulan) {
         $thn = date('Y');
     	 $query = $this->db->query("select sum(inttotal_bayar) ifoDealer
				from nota 
				where intid_jpenjualan = 6
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	function get_ifo_dealertahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
     		$query = $this->db->query("select sum(inttotal_bayar) ifoDealer
				from nota 
				where intid_jpenjualan = 6
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
     	}else
     	{
     		$query = $this->db->query("select sum(inttotal_bayar) ifoDealer
				from nota_2014 
				where intid_jpenjualan = 6
				and is_dp = 0
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");	
     	}
        return $query->result();
     }
//NETTO

      function get_net($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 7
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
      function get_nettahun($kode, $bulan,$tahun) {
         $thn = $tahun;
        if($tahun > 2014)
        {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 7
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{

	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 7
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
     function get_net_dealer($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 7
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	 
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
     function get_net_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 7
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}else
      	{
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 7
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
      	}
        return $query->result();
     }
	 //SPECIALPRICE

      function get_sp($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 11
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }

	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
      function get_sptahun($kode, $bulan,$tahun) {
         $thn = $tahun;
     	if($tahun > 2014)
     	{
      	 	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 11
			and a.is_dp = 0
			order by a.intno_nota asc");         
      	}else
        {
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 11
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
	 /*  
	 */
	function get_rekruttahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 17
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 17
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
	 //end
     function get_sp_dealer($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 11
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	 
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
     function get_sp_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 11
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 11
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        }
        return $query->result();
     }
	 /*  
		ifirlana@gmail.com
		2014 08 13
	 */
	  function get_rekrut_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 17
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");	
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 17
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        }
        return $query->result();
     }
	//end
	 
	 //POINT

      function get_p($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 12
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
      function get_ptahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 12
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 12
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
     function get_p_dealer($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 12
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        return $query->result();
     }
	
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
     function get_p_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 12
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        }else
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 12
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode");
        }
      	return $query->result();
     }
//001
	//METAL 50%

      function get_m50($kode, $bulan) {
         $thn = date('Y');
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 13
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result();
     }
	
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
      function get_m50tahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
			$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 13
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 13
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
	 function get_dis50tahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	 		$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 18
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 18
			and a.is_dp = 0
			order by a.intno_nota asc");
        }
         return $query->result();
     }
     function get_m50_dealer($kode, $bulan) {
        $thn = date('Y');
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 13
				and intid_week in (select intid_week from week where intbulan = '$bulan')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        return $query->result();
     }
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	function get_m50_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 13
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
 
        }else
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 13
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
 
        }
        return $query->result();
     }
	 function get_dis50_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
			$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 18
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");	
        }else
      	{
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 18
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	
	function get_dealer_cabang($kode, $bulan) {
      $thn = date('Y');
      $query = $this->db->query("select SUM(nota.inttotal_bayar) as RegDealer
				from nota
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join barang on barang.intid_barang = nota_detail.intid_barang
				inner join member on member.intid_dealer = nota.intid_dealer


				where nota.intid_cabang='$kode' and nota.inttotal_bayar >= 300000
                and nota.intid_week in (select intid_week from week where intbulan = '$bulan') AND YEAR(nota.datetgl)='$thn'
                and nota.intid_jpenjualan=1
                
              ");
        return $query->row();
     }
	 
	/*	
		02 januari 2014 
		ikhlas firlana
		desc : laporan dengan tahun
	*/
	
	function get_dealer_cabangtahun($kode, $bulan,$tahun) {
      $thn = $tahun;
    if($tahun > 2014)
    {
  		$query = $this->db->query("select SUM(nota.inttotal_bayar) as RegDealer
				from nota
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join barang on barang.intid_barang = nota_detail.intid_barang
				inner join member on member.intid_dealer = nota.intid_dealer


				where nota.intid_cabang='$kode' and nota.inttotal_bayar >= 300000
                and nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn') AND YEAR(nota.datetgl)='$thn'
                and nota.intid_jpenjualan=1
                
              ");
    
    }else
    {
    	  $query = $this->db->query("select SUM(nota_2014.inttotal_bayar) as RegDealer
				from nota_2014
                inner join nota_detail_2014 on nota_detail_2014.intid_nota = nota_2014.intid_nota
                inner join barang on barang.intid_barang = nota_detail_2014.intid_barang
				inner join member on member.intid_dealer = nota_2014.intid_dealer


				where nota_2014.intid_cabang='$kode' and nota_2014.inttotal_bayar >= 300000
                and nota_2014.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn') AND YEAR(nota.datetgl)='$thn'
                and nota.intid_jpenjualan=1
              ");
    
    }
     return $query->row();
     }
	 function get_cabang($kode){
         $this->db->select('cabang.strkepala_cabang, cabang.strnama_cabang');
         $this->db->from('cabang');
         $this->db->where('intid_cabang', $kode);
         return $this->db->get()->row();
     }
	  function get_CetakArisan($idNota) {
        $query = $this->db->query("select nota.intno_nota, nota.datetgl, nota.intid_jpenjualan, nota_detail.*, barang.strnama, nota_detail.intharga harga.intharga_jawa, nota_detail.intharga harga.intcicilan_jawa, if(harga.intcicilan_luarjawa is null, 0, harga.intcicilan_luarjawa) intcicilan_luarjawa,
if(harga.intharga_luarjawa is null,0, harga.intcicilan_luarjawa) intcicilan_luarjawa, cabang.intid_wilayah,
cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline, nota.*, arisan.intuang_muka, arisan.*, 
(select sum(intquantity) from nota_detail where is_free = 0 and intid_nota= nota.intid_nota) qty
from nota
inner join cabang on cabang.intid_cabang = nota.intid_cabang
inner join unit on unit.intid_unit = nota.intid_unit
inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
inner join member on member.intid_dealer = nota.intid_dealer
left join barang on barang.intid_barang = nota_detail.intid_barang
left join harga on harga.intid_barang = nota_detail.intid_barang
inner join arisan on arisan.intid_arisan_detail = nota.intid_nota
where nota.is_dp = 0 
and arisan.intid_arisan = '$idNota'
order by nota_detail.intid_nota");
				
		return $query->result();
     }
	 
	 function get_baby_cabang($kode){
         $this->db->select('cabang.strkepala_cabang,cabang.strnama_cabang, cabang.intid_cabang');
         $this->db->from('baby_cabang');
		 $this->db->join('cabang','baby_cabang.intid_cabang2 = cabang.intid_cabang');
         $this->db->where('baby_cabang.intid_cabang', $kode);
         return $this->db->get()->result();
     }

	 function get_baby_manager($kode){
		$query= $this->db->query("SELECT baby_manager.intid_unitbaby, (select unit.strnama_unit from unit where unit.intid_unit=baby_manager.intid_unitbaby) as strnama_unit from baby_manager where intid_unit='$kode'");
		return $query->result();
     }
	 
	  function get_rekrut_babymanager($kode, $bulan) {
         $thn = date('Y');
      $query = $this->db->query("select count(member.intid_dealer) as jlhrekut FROM member WHERE MONTH(member.datetanggal)='$bulan' AND YEAR(member.datetanggal)='$thn' AND member.intid_unit='$kode'");
        return $query->row();
     }

	     function get_unittotal($kode, $bulan) {
         $thn = date('Y');
      $query = $this->db->query("select sum(nota.intomset10) as intomset10, sum(nota.intomset20) as intomset20, sum(nota.inttotal_bayar) as inttotal_bayar, 
		sum(nota.intkomisi10) as intkomisi10, sum(nota.intkomisi20) as intkomisi20,sum(nota.intcash) as intcash																										
		from nota
				inner join unit on unit.intid_unit = nota.intid_unit
				inner join member on member.intid_dealer = nota.intid_dealer
				inner join nota_detail on nota_detail.intid_nota = nota.intid_nota

				where nota.intid_unit = '$kode' and MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn' 
				and nota.intid_jpenjualan not in (16) GROUP BY nota.intid_dealer");
        return $query->row();
     }
	 
	 //cetak nota buat data penjualan
	 function CetakNota($idNota) {
        $query = $this->db->query("select nota.intno_nota, nota.datetgl, nota.intid_jpenjualan, nota_detail.*, barang.strnama, harga.intharga_jawa,
                harga.intharga_luarjawa, cabang.intid_wilayah,
                cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline, nota.*
                
                from nota
                
				inner join cabang on cabang.intid_cabang = nota.intid_cabang
				inner join unit on unit.intid_unit = nota.intid_unit
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join member on member.intid_dealer = nota.intid_dealer
                left join barang on barang.intid_barang = nota_detail.intid_barang
                inner join harga on harga.intid_barang = nota_detail.intid_barang
                where nota.is_dp = 0 
				and nota.intno_nota = '$idNota'
				order by nota_detail.intid_nota");
        
        return $query->result();
     }
	 /*
	 function get_Omset($kode, $bulan) {
      $thn = date('Y');
		$query = $this->db->query("select sum(nota.intomset10) omset10, sum(nota.intomset20) omset20, sum(nota.inttotal_omset) total_omset, member.strnama_dealer, unit.strnama_unit, unit.intid_unit
		from nota, member, unit
		where member.intid_dealer = nota.intid_dealer 
		and nota.intid_unit = unit.intid_unit 
		and member.strkode_dealer='$kode' 
		AND MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn' 
		and nota.is_dp != 1
		group by member.strnama_dealer, unit.strnama_unit, unit.intid_unit");
        return $query->result();
     }
	 
	 function get_Omset_Group($kode, $bulan) {
      $thn = date('Y');
		$query = $this->db->query("select sum(nota.intomset10) omset10, sum(nota.intomset20) omset20, sum(nota.inttotal_omset) total_omset, member.strnama_dealer, unit.strnama_unit, unit.intid_unit
		from nota, member, unit
		where member.intid_dealer = nota.intid_dealer 
		and nota.intid_unit = unit.intid_unit 
		and member.strkode_dealer='$kode' 
		AND MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn' 
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan= 9)
		group by member.strnama_dealer, unit.strnama_unit, unit.intid_unit");
        return $query->result();
     }
	 */

	 function selectmaxkode() {
      $query = $this->db->query("select max(strkode_dealer) kodemax from member");
      return $query->result();
     }
	 
	  function LaporanNota($idNota) {
        $query = $this->db->query("select nota.intno_nota, nota.datetgl, nota.intid_jpenjualan, nota_detail.*, barang.strnama, harga.intharga_jawa,
                harga.intharga_luarjawa, cabang.intid_wilayah,
                cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline, nota.*,
                scan_barcode.barcode_data 	
                from nota
                
				inner join cabang on cabang.intid_cabang = nota.intid_cabang
				inner join unit on unit.intid_unit = nota.intid_unit
                inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
                inner join member on member.intid_dealer = nota.intid_dealer
                left join barang on barang.intid_barang = nota_detail.intid_barang
                left join harga on harga.intid_barang = nota_detail.intid_barang
				left join 
				(select * from scan_barcode where is_active = 1) scan_barcode on scan_barcode.kode = member.intid_dealer
                where nota.intno_nota = '$idNota'
				order by nota_detail.intid_nota");
        
        return $query->result();
     }
	 
	 function pemenang_terakhir($id, $group) {
      $query = $this->db->query("SELECT max(urutan_pemenang )as urutan
				FROM `arisan`
				WHERE `group` =$group and intid_arisan=$id");
      return $query->row();
     }
	 
	  function getJumlahArisanGroup($id, $group, $jenis, $bln, $tahun) {
      $query = $this->db->query("select (intjeniscicilan - urutan_pemenang) as jum_sisa from arisan, arisan_detail where arisan.intjeniscicilan=$jenis and arisan.group=$group and arisan.winner = 1 and MONTH(arisan_detail.tanggal)='$bln' and YEAR(arisan_detail.tanggal)='$tahun' and arisan.intid_arisan = arisan_detail.intid_arisan");
      return $query->row();
     }
	 
	 function addStok($id, $qty, $cabang, $no_nota) {
      
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intqty_end, inthutang_barang from stok where intid_barang = $id and intid_cabang = $cabang");
        $qtyendbefore = $i->result();
		if(isset($qtyendbefore[0]->intqty_end)){
			$qtyend = $qtyendbefore[0]->intqty_end;
		}else{
			$qtyend = 0;
		}
		if(isset($qtyendbefore[0]->inthutang_barang)){
			$qtyhutangbefore = $qtyendbefore[0]->inthutang_barang;
		}else{
			$qtyhutangbefore = 0;
		}
		if ($qtyend == 0)
		{
			$qtyendafter = 0;
			$qtyhutang = $qtyhutangbefore + $qty;
		} else if($qty < $qtyend){
			$qtyendafter = $qtyend - $qty;
			$qtyhutang = $qtyhutangbefore + 0;
		} 
		else if($qty > $qtyend){
			$qtyendafter = 0;
			$qtyhutang = $qtyhutangbefore + ($qty - $qtyend);
		}	
		$data = array(
				'intid_barang' => $id,
				'intid_cabang' => $cabang,
				'intid_week' => $intid_week,
				'intqty_begin' => $qtyend,
				'intqty_out' => $qty,
				'intqty_end' => $qtyendafter,
				'inthutang_barang' => $qtyhutang,
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
				'inthutang_barang' => $qtyhutang,
				'tanggal' => $tgl
			);
			$this->db->insert('stok_history', $data1);
	}
	 
	 function selectManager($keyword){
		
		$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline, intid_unit from member where strnama_dealer like '$keyword%' and intlevel_dealer = 1");
			
		return $query->result();
	}
	
	function getJumlahArisan($bln, $tahun) {
      $query = $this->db->query("select distinct((intjeniscicilan - urutan_pemenang)) as jum_sisa from arisan, arisan_detail where arisan.winner = 1 and MONTH(arisan_detail.tanggal)='$bln' and YEAR(arisan_detail.tanggal)='$tahun' and arisan.intid_arisan = arisan_detail.intid_arisan
	  ");
      return $query->row();
     }
	 
	function selectBarangHadiah($keyword){
        $query = $this->db->query("select a.intid_barang_hadiah, upper(a.strnama) strnama from barang_hadiah a where a.strnama like '$keyword%' and status_barang = 1");
        return $query->result();
	}
	
	//added 2014-03-21 ifirlana@gmail.com
	//mengatasi masalah barang_hadiah. Dan bermigrasi dari table barang-hadiah ke table barang
	
	function selectBarangHadiah_reguler($keyword){
        $query = $this->db->query("select a.intid_barang intid_barang_hadiah, upper(a.strnama) strnama from barang a where a.strnama like '$keyword%' and is_hadiah = 1 #and intid_barang not in(7608,7609,7610,7709,7710,7711,10864,10865,10866)
		");
        return $query->result();
	}
	function selectBarangHadiah_regulerGM5($keyword,$idcbg){
        $query = $this->db->query("select a.intid_barang intid_barang_hadiah, upper(a.strnama) strnama from barang a where a.strnama like '$keyword%' and is_hadiah = 1 and intid_barang in (SELECT intid_barang from stock_gm5 where intid_cabang = $idcbg and qty > 0)");
        return $query->result();
	}
	
	function insertNotaHadiah($data){
		$tgl = date("Y-m-d");
		$keterangan = $this->input->post('keterangan');
		$dealer = $this->input->post('strkode_dealer');
		$unit = $this->input->post('id_unit');
		$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
        $intid_dealer = $i->result();
		$intid_nota = $this->input->post('intno_nota');
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$kode =	$this->input->post('jenis_nota');
		$data = array(
            'intno_nota' => $intid_nota,
            'intid_cabang' => $this->input->post('intid_cabang'),
            'datetgl' => $tgl,
			'intid_dealer' => $intid_dealer[0]->intid_dealer,
			'intid_unit' => $this->input->post('id_unit'),
			'intid_week' => $intid_week,
			'jenis_nota' => $kode,
			'keterangan' => $keterangan
		);
        $this->db->insert('nota_hadiah', $data);
		$intid_nota =$this->db->insert_id();
				        
	} 
	
	 function get_MaxNotaHadiah() {
        $this->db->select_max('intid_nota');
		$query = $this->db->get('nota_hadiah');
        return $query;
    }
	
	function addhadiah($data)
	{
        $this->db->insert("nota_detail_hadiah", $data);
	}
	
	function addStokHadiah($id, $qty, $cabang, $no_nota) {
      /*
	  	$tgl = date("Y-m-d");
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$i = $this->db->query("select intqty_end, inthutang_barang from stok_hadiah where intid_barang_hadiah = $id and intid_cabang = $cabang");
        $qtyendbefore = $i->result();
		$qtyend = $qtyendbefore[0]->intqty_end;
		$qtyhutangbefore = $qtyendbefore[0]->inthutang_barang;
		if ($qtyend == 0)
		{
			$qtyendafter = 0;
			$qtyhutang = $qtyhutangbefore + $qty;
		} else if($qty < $qtyend){
			$qtyendafter = $qtyend - $qty;
			$qtyhutang = $qtyhutangbefore + 0;
		} else if($qty > $qtyend){
			$qtyendafter = 0;
			$qtyhutang = $qtyhutangbefore + ($qty - $qtyend);
		}
		if ($qtyend == null)
		{
			$qtyend = 0;
		}	
		$data = array(
            'intid_barang_hadiah' => $id,
            'intid_cabang' => $cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'inthutang_barang' => $qtyhutang,
			'tanggal' => $tgl
		);
        $this->db->where('intid_barang_hadiah', $id);
		$this->db->where('intid_cabang', $cabang);
		$this->db->update('stok_hadiah', $data);
		$intid_stok =$this->db->insert_id();
		$data1 = array(
            'intid_stok' => $intid_stok,
			'intno_nota' => $no_nota,
			'intid_barang_hadiah' => $id,
            'intid_cabang' => $cabang,
            'intid_week' => $intid_week,
			'intqty_begin' => $qtyend,
			'intqty_out' => $qty,
			'intqty_end' => $qtyendafter,
			'inthutang_barang' => $qtyhutang,
			'tanggal' => $tgl
		);
        $this->db->insert('stok_history_hadiah', $data1);
		*/
     }
	 
	 function get_CetakNotaHadiah($idNota) {
        $query = $this->db->query("select nota_hadiah.intno_nota, 
		nota_hadiah.datetgl, 
		nota_detail_hadiah.*, 
		barang.strnama, 
		cabang.strnama_cabang, 
		unit.strnama_unit, 
		member.strnama_dealer, 
		member.strnama_upline, 
		nota_hadiah.*,
		if(nota_hadiah.jenis_nota is NULL or nota_hadiah.jenis_nota = '','HADIAH',(select upper(jenis_nota) from jenis_nota_hadiah where kode = nota_hadiah.jenis_nota)) as strnama_penjualan
from nota_hadiah 
inner join cabang on cabang.intid_cabang = nota_hadiah.intid_cabang 
left join unit on unit.intid_unit = nota_hadiah.intid_unit 
inner join nota_detail_hadiah on nota_detail_hadiah.intid_nota = nota_hadiah.intid_nota 
left join member on member.intid_dealer = nota_hadiah.intid_dealer 
left join barang on barang.intid_barang = nota_detail_hadiah.intid_barang 
where nota_hadiah.intid_nota = '$idNota' order by nota_detail_hadiah.intid_nota");
        
        return $query->result();
     }
	 
	 function cekNota($dealer, $unit) {
     
	 $i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
     $intid_dealer = $i->result();
	 $kode = $intid_dealer[0]->intid_dealer;
     $query = $this->db->query("select  intno_nota from nota where intid_dealer = $kode 
and intid_week =(select intid_week from week where curdate() between dateweek_start and dateweek_end) 
and is_lg = 0");  
     return $query->result();
	 }

/*______________________________________________________________________
|									|
|									|
|									|
|									|
|				Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/

	function cekNota001($dealer, $unit, $totallg) {
     
		$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
		$intid_dealer = $i->result();
		$kode = $intid_dealer[0]->intid_dealer;
		$query = $this->db->query("SELECT intid_nota
			FROM (SELECT NULL AS intid_nota, NULL AS total
				FROM dual
				WHERE (@total := 0)
				UNION
				SELECT intid_nota, @total := @total + inttotal_omset AS total
				FROM (SELECT DISTINCT a.intid_nota, inttotal_omset 
				from nota a join nota_detail b on a.intid_nota=b.intid_nota 
				where a.intid_dealer = $kode and a.intid_week =(select intid_week from week where curdate() between dateweek_start and dateweek_end) and a.is_lg = 0 ORDER BY inttotal_omset ASC) AS nota WHERE @total < $totallg) AS nota");  
		return $query->result();
	}

/*______________________________________________________________________
|									|
|									|
|									|
|									|
|			End of Kode Baru				|
|									|
|									|
|									|
|______________________________________________________________________*/
	 
	 function GetBarang($id) {
        
		$query = $this->db->query("select intid_barang,	intquantity from nota_detail where intid_nota = $id");
        return $query->result();
     }
	 
	 function cekOmset($kode)
	{
		$week = $this->db->query("select intid_week from week where curdate() between dateweek_start and dateweek_end");
        $id_week = $week->result();
		$week_now = $id_week[0]->intid_week;
		$query = $this->db->query("select a.inttotal_omset
								   from nota a
								   where a.intno_nota = '$kode'
								   and a.intid_week = $week_now");
        return $query->result();
	}
	
	function insertNotaArisan($no_nota, $id){
		$tgl = date("Y-m-d");
		$query = $this->db->query("select nota.*, nota_detail.*, arisan.intcicilan
                from nota, arisan, nota_detail
                where arisan.intid_arisan = '$id'
				and arisan.intid_arisan_detail = nota.intid_nota
				and nota.intid_nota = nota_detail.intid_nota");
		$hasil = $query->result();
		$id_nota = $hasil[0]->intid_nota;
		if ($hasil[0]->intkomisi10==0)
		{
			$cash = $hasil[0]->intcicilan - $hasil[0]->intkomisi20;
		} else if($hasil[0]->intkomisi20==0)
		{
			$cash = $hasil[0]->intcicilan - $hasil[0]->intkomisi10;
		}
		$cabang = $hasil[0]->intid_cabang;
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$data = array(
            'intno_nota' => $no_nota,
            'intid_jpenjualan' => $hasil[0]->intid_jpenjualan,
			'intid_cabang' => $hasil[0]->intid_cabang,
            'datetgl' => $tgl,
			'intid_dealer' => $hasil[0]->intid_dealer,
			'intid_unit' => $hasil[0]->intid_unit,
			'intid_week' => $intid_week,
			'intomset10' => $hasil[0]->intomset10,
			'intomset20' => $hasil[0]->intomset20,
			'inttotal_omset' => $hasil[0]->inttotal_omset,
			'inttotal_bayar' => $cash,
			'intdp' => $hasil[0]->intdp,
			'intcash' => $cash,
			'intdebit' => $hasil[0]->intdebit,
			'intkkredit' => $hasil[0]->intkkredit,
			'intsisa' => $hasil[0]->intsisa,
			'intkomisi10' => $hasil[0]->intkomisi10,
			'intkomisi20' => $hasil[0]->intkomisi20,
			'intpv' => $hasil[0]->intpv,
			'intvoucher' => $hasil[0]->intvoucher,
			'is_dp' => $hasil[0]->is_dp,
			'is_lg' => $hasil[0]->is_lg,
			'inttrade_in' => $hasil[0]->inttrade_in,
			'is_asi' => $hasil[0]->is_asi,
			'nokk' => $hasil[0]->nokk, 
			'intkomisi_asi' => $hasil[0]->intkomisi_asi,
			'is_arisan' => $hasil[0]->is_arisan 
		);
        $this->db->insert('nota', $data);
		$intid_nota =$this->db->insert_id();
		$query1 = $this->db->query("select nota_detail.*
                from nota_detail
                where nota_detail.intid_nota = $id_nota");
		$result = $query1->result();
		for($i=0;$i<=sizeof($result);$i++){
			if(!empty($result[$i]->intid_barang)){
				$detail = array(
						'intid_nota' 			=> $intid_nota,
						'intid_barang'	        => $result[$i]->intid_barang,
						'intquantity'		    => $result[$i]->intquantity,
						'is_free' 				=> $result[$i]->is_free,
						'intid_harga'			=> $result[$i]->intid_harga,
						'intharga'			    => $result[$i]->intharga
				);
				$this->db->insert('nota_detail', $detail);
				
			}
		}
				        
	}
	
	function updatePo($id, $id_po)
	{
		$query = $this->db->query("update po_detail set status = 1 where intid_barang = $id and intid_po = $id_po");
        return $query->result();
	}
	
	//Batasan group arisan
	function Limitgroupsatu()
	{
		$query = $this->db->query("select count(a.`group`) group1 from arisan a where a.`group` = 1");
        return $query->result();
	}
	
	function Limitgroupdua()
	{
		$query = $this->db->query("select count(a.`group`) group2 from arisan a where a.`group` = 2");
        return $query->result();
	}
	
	function Limitgrouptiga()
	{
		$query = $this->db->query("select count(a.`group`) group3 from arisan a where a.`group` = 3");
        return $query->result();
	}
	
	function Limitgroupempat()
	{
		$query = $this->db->query("select count(a.`group`) group4 from arisan a where a.`group` = 4");
        return $query->result();
	}
	
	function Limitgrouplima()
	{
		$query = $this->db->query("select count(a.`group`) group5 from arisan a where a.`group` = 5");
        return $query->result();
	}
	
	function Limitgroupenam()
	{
		$query = $this->db->query("select count(a.`group`) group6 from arisan a where a.`group` = 6");
        return $query->result();
	}
	
	function Limitgrouptujuh()
	{
		$query = $this->db->query("select count(a.`group`) group7 from arisan a where a.`group` = 7");
        return $query->result();
	}
	
	function Limitgroupdelapan()
	{
		$query = $this->db->query("select count(a.`group`) group8 from arisan a where a.`group` = 8");
        return $query->result();
	}
	
	function Limitgroupsembilan()
	{
		$query = $this->db->query("select count(a.`group`) group9 from arisan a where a.`group` = 9");
        return $query->result();
	}
	
	function Limitgroupsepuluh()
	{
		$query = $this->db->query("select count(a.`group`) group10 from arisan a where a.`group` = 10");
        return $query->result();
	}

	function Limitgroupsebelas()
	{
		$query = $this->db->query("select count(a.`group`) group11 from arisan a where a.`group` = 11");
        return $query->result();
	}

	function Limitgroupduabelas()
	{
		$query = $this->db->query("select count(a.`group`) group12 from arisan a where a.`group` = 12");
        return $query->result();
	}
	
	function Limitgrouptigabelas()
	{
		$query = $this->db->query("select count(a.`group`) group13 from arisan a where a.`group` = 13");
        return $query->result();
	}
	
	function Limitgroupempatbelas()
	{
		$query = $this->db->query("select count(a.`group`) group14 from arisan a where a.`group` = 14");
        return $query->result();
	}

	function Limitgrouplimabelas()
	{
		$query = $this->db->query("select count(a.`group`) group15 from arisan a where a.`group` = 15");
        return $query->result();
	}


function updateArisan001($id, $no_nota) {
	$this->db->query("UPDATE arisan SET intid_arisan_detail = (SELECT intid_nota FROM nota WHERE intno_nota = '$no_nota' LIMIT 0,1) WHERE intid_arisan = $id");
	return 1;
}
	
	
function insertNotaArisanPemenang($no_nota, $id){
		$tgl = date("Y-m-d");
		$query = $this->db->query("select nota.*, nota_detail.*, arisan.*
                from nota, arisan, nota_detail
                where arisan.intid_arisan = '$id'
				and arisan.intid_arisan_detail = nota.intid_nota
				and nota.intid_nota = nota_detail.intid_nota");
		$hasil = $query->result();
		$id_nota = $hasil[0]->intid_nota;
		$jeniscicilan = $hasil[0]->intjeniscicilan;
		if($hasil[0]->c1!=0&&$hasil[0]->c2!=0&&$hasil[0]->c3!=0&&$hasil[0]->c4!=0&&$hasil[0]->c5!=0&&$hasil[0]->c6!=0&&$hasil[0]->c7!=0){
			$cicilan="7";
		}else if($hasil[0]->c1!=0&&$hasil[0]->c2!=0&&$hasil[0]->c3!=0&&$hasil[0]->c4!=0&&$hasil[0]->c5!=0&&$hasil[0]->c6!=0){
			$cicilan="6";
		}else if($hasil[0]->c1!=0&&$hasil[0]->c2!=0&&$hasil[0]->c3!=0&&$hasil[0]->c4!=0&&$hasil[0]->c5!=0){
			$cicilan="5";
		}else if($hasil[0]->c1!=0&&$hasil[0]->c2!=0&&$hasil[0]->c3!=0&&$hasil[0]->c4!=0){
			$cicilan="4";
		}else if($hasil[0]->c1!=0&&$hasil[0]->c2!=0&&$hasil[0]->c3!=0){
			$cicilan="3";
		}else if($hasil[0]->c1!=0&&$hasil[0]->c2!=0) {
			$cicilan="2";
		}else if($hasil[0]->c1!=0){
			$cicilan="1";
		} else {
			$cicilan="0";
		}
		
		$sisa = $jeniscicilan - $cicilan;
		$intomset10 = $sisa * $hasil[0]->intomset10;
		$intomset20 = $sisa * $hasil[0]->intomset20;
		$inttotal_omset = $sisa * $hasil[0]->inttotal_omset;
		$intpv = $sisa * $hasil[0]->intpv;
		$week = $this->selectWeek();
        $intid_week= $week[0]->intid_week;
		$cabang = $hasil[0]->intid_cabang;
		
		$data = array(
            'intno_nota' => $no_nota,
            'intid_jpenjualan' => $hasil[0]->intid_jpenjualan,
			'intid_cabang' => $hasil[0]->intid_cabang,
            'datetgl' => $tgl,
			'intid_dealer' => $hasil[0]->intid_dealer,
			'intid_unit' => $hasil[0]->intid_unit,
			'intid_week' => $intid_week,
			'intomset10' => $intomset10,
			'intomset20' => $intomset20,
			'inttotal_omset' => $inttotal_omset,
			'inttotal_bayar' => 0,
			'intdp' => $hasil[0]->intdp,
			'intcash' => 0,
			'intdebit' => 0,
			'intkkredit' => 0,
			'intsisa' => 0,
			'intkomisi10' => 0,
			'intkomisi20' => 0,
			'intpv' => $intpv,
			'intvoucher' => $hasil[0]->intvoucher,
			'is_dp' => $hasil[0]->is_dp,
			'is_lg' => $hasil[0]->is_lg,
			'inttrade_in' => $hasil[0]->inttrade_in,
			'is_asi' => $hasil[0]->is_asi,
			'nokk' => $hasil[0]->nokk, 
			'intkomisi_asi' => $hasil[0]->intkomisi_asi,
			'is_arisan' => $hasil[0]->is_arisan 
		);
        $this->db->insert('nota', $data);
		$intid_nota =$this->db->insert_id();
		$query1 = $this->db->query("select nota_detail.*
                from nota_detail
                where nota_detail.intid_nota = $id_nota");
		$res = $query1->result();
		if(is_array($res)):
			foreach($res as $key):
		//for($i=0;$i<=array($res);$i++){
			//if(!empty($res[$i]->intid_barang)){
				$detail = array(
						'intid_nota' 			=> $intid_nota,
						'intid_barang'	        => $key->intid_barang,
						'intquantity'		    => $key->intquantity,
						'is_free' 				=> $key->is_free,
						'intid_harga'			=> $key->intid_harga,
						'intharga'			    => $key->intharga
				);
				$this->db->insert('nota_detail', $detail);
				$id = $key->intid_barang;
				$qty = $key->intquantity;
				/*
				$i = $this->db->query("select intqty_end, inthutang_barang from stok where intid_barang = $id and intid_cabang = $cabang");
				$qtyendbefore = $i->result();
				$qtyend = $qtyendbefore[0]->intqty_end;
				$qtyhutangbefore = $qtyendbefore[0]->inthutang_barang;
				if ($qtyend == 0)
				{
					$qtyendafter = 0;
					$qtyhutang = $qtyhutangbefore + $qty;
				} else if($qty < $qtyend){
					$qtyendafter = $qtyend - $qty;
					$qtyhutang = $qtyhutangbefore + 0;
				} 
				else if($qty > $qtyend){
					$qtyendafter = 0;
					$qtyhutang = $qtyhutangbefore + ($qty - $qtyend);
				}
				$stok = array(
					'intid_barang' => $id,
					'intid_cabang' => $cabang,
					'intid_week' => $intid_week,
					'intqty_begin' => $qtyend,
					'intqty_out' => $qty,
					'intqty_end' => $qtyendafter,
					'inthutang_barang' => $qtyhutang,
					'tanggal' => $tgl
				);
				$this->db->where('intid_barang', $id);
				$this->db->where('intid_cabang', $cabang);
				$this->db->update('stok', $stok);
				$intid_stok =$this->db->insert_id();
				$stokhistory = array(
					'intid_stok' => $intid_stok,
					'intno_nota' => $no_nota,
					'intid_barang' => $id,
					'intid_cabang' => $cabang,
					'intid_week' => $intid_week,
					'intqty_begin' => $qtyend,
					'intqty_out' => $qty,
					'intqty_end' => $qtyendafter,
					'inthutang_barang' => $qtyhutang,
					'tanggal' => $tgl
				);
				$this->db->insert('stok_history', $stokhistory);
				*/
			endforeach;
		endif;
			//}
		//}
				        
	}	
	/*
	//
	function get_notaArisan($idNota) {
        $query = $this->db->query("select nota.*, nota_detail.*, barang.strnama, harga.intharga_jawa, harga.intcicilan_jawa,harga.intcicilan_luarjawa,
harga.intharga_luarjawa, cabang.intid_wilayah,
cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline
from nota 
inner join cabang on cabang.intid_cabang = nota.intid_cabang
inner join unit on unit.intid_unit = nota.intid_unit
inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
inner join member on member.intid_dealer = nota.intid_dealer
left join barang on barang.intid_barang = nota_detail.intid_barang
l join harga on harga.intid_barang = nota_detail.intid_barang
where intno_nota = '$idNota'");
		return $query->result();
     }
	 */
	 //revisi ikhlas firlana 
	 //2015 01 14
	 function get_notaArisan($idNota) {
      
$query = $this->db->query("select nota.*, nota_detail.*, barang.strnama, 
											nota_detail.intharga intharga_jawa, 
											nota_detail.intharga intcicilan_jawa,
											nota_detail.intharga intcicilan_luarjawa,
											nota_detail.intharga intharga_luarjawa, 
											cabang.intid_wilayah,
									cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline
									from nota 
									inner join cabang on cabang.intid_cabang = nota.intid_cabang
									inner join unit on unit.intid_unit = nota.intid_unit
									inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
									inner join member on member.intid_dealer = nota.intid_dealer
									left join barang on barang.intid_barang = nota_detail.intid_barang
									left join harga on harga.intid_barang = nota_detail.intid_barang
									where intno_nota = '$idNota'");
		return $query->result();
     }
	 function selectBarangFree($keyword, $state){
       
		$query = $this->db->query("SELECT upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,c.intid_barang
		FROM barang b, harga c 
		where  b.intid_barang = c.intid_barang
		and (c.intharga_jawa <= $state or c.intharga_luarjawa <= $state) 
		and b.strnama like '$keyword%' ");
        return $query->result();
	}
	 /*
	 ---------------------------------------------------
	 athur apple studio ifirlana@gmail.com
	 ---------------------------------------------------
	 */
	function selectfortracker003($keyword){
		$temp=0;
		$now = date("Y")."-".date("m")."-".date("d");
		$query = $this->db->query("SELECT intid_barang, intid_barang_free, intid_barang_free1, intid_barang_free2, z.intid_week AS intid_week_start, week.intid_week FROM (SELECT * FROM `promo20` INNER JOIN week ON promo20.intid_week_start = week.intid_week WHERE week.dateweek_start <= '".$now."') AS z INNER JOIN week ON week.intid_week = z.intid_week_end WHERE intid_barang = $keyword AND week.dateweek_end >= '".$now."' AND intid_barang_free > 14");
	  			if($query->num_rows() > 0 ){
					$temp = 1;
					$query_1 = $this->db->query("SELECT intid_barang, intid_barang_free, intid_barang_free1, intid_barang_free2, z.intid_week AS intid_week_start, week.intid_week FROM (SELECT * FROM `promo20` INNER JOIN week on promo20.intid_week_start = week.intid_week WHERE week.dateweek_start <= '".$now."') AS z INNER JOIN week ON week.intid_week = z.intid_week_end WHERE intid_barang = $keyword AND week.dateweek_end >= '".$now."' AND intid_barang_free1 > 14");
						if($query_1->num_rows() >0){							
							$temp = $temp + 1;
							$query_2 = $this->db->query("SELECT intid_barang, intid_barang_free, intid_barang_free1, intid_barang_free2, z.intid_week AS intid_week_start, week.intid_week FROM (SELECT * FROM `promo20` INNER JOIN week on promo20.intid_week_start = week.intid_week WHERE week.dateweek_start <= '".$now."') AS z INNER JOIN week ON week.intid_week = z.intid_week_end WHERE intid_barang = $keyword AND week.dateweek_end >= '".$now."' AND intid_barang_free2 > 14");
							if($query_2->num_rows() > 0){
								$temp = $temp + 1;
							}
						}	
				}
				
		return $temp;	
		}
	function get_password($option, $pass) {
		$query = $this->db->query("select * from password where password ='$pass' and nama_paket = '$option'");
		return $query->num_rows();
	}
	function selectNamaBarangB($id){
		$temp="";
		$temp = "select barang.strnama,barang.intid_barang,harga.intid_harga,harga.intharga_jawa,harga.intharga_luarjawa from barang,harga where barang.intid_barang = '".$id."' and harga.intid_barang = barang.intid_barang LIMIT 0,1";
		$query = $this->db->query($temp);
		return $query->result();
	}
	/*
	----------------------------------
	end coding
	----------------------------------
	*/
//////////30032013 line ikhlas//////////////////////////////
	function selectBarangGubrak($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,c.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa FROM promogubrak a, barang b, harga c where a.intid_barang = b.intid_barang and b.intid_barang = c.intid_barang and CURDATE() BETWEEN c.date_start and c.date_end and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end and b.strnama like '%$keyword%'");


        return $query->result();
	}
	//////////end///////////////////////
	//////04April2013 line ikhlas

	/*
	----------------------------------
	end coding
	----------------------------------
	*/
	//////////30032013 line ikhlas
	
	////end
	/////////////////03042013 line ikhlas
	function selectBarangFreeGubrak($keyword, $state){
       
	    $query = $this->db->query("SELECT upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,c.intid_barang
									FROM promogubrak a, barang b, harga c 
									where (a.intid_barang_free = b.intid_barang or a.intid_barang_free1= b.intid_barang or a.intid_barang_free2 = b.intid_barang)
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and a.intid_barang= $state
									and b.strnama like '$keyword%'");
        return $query->result();
	}
	/////////////end////////////
	////09042013 line ikhlas coding///////
	function get_all_arisan_ver1($data, $id_cabang) {
      		
		if ($id_cabang==1){

$query = $this->db->query("SELECT * FROM (select e.strnama_dealer, e.strnama_upline, g.strnama_unit, f.strnama, 
sum(d.intquantity) intquantity, a.`group`, a.intid_arisan, a.winner, a.intjeniscicilan, b.tanggal, a.intid_arisan_detail, g.intid_unit, e.intid_dealer 
from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g 
where a.intid_arisan = b.intid_arisan 
and a.intid_arisan_detail = c.intid_nota 
and c.intid_nota = d.intid_nota 
and d.intid_barang = f.intid_barang 
and c.intid_dealer = e.intid_dealer 
and c.intid_unit = g.intid_unit 
and d.is_free=0 
group by c.intid_nota) AS z 
WHERE z.strnama_dealer = '$data[strnama_dealer]'");

		} else {

$query = $this->db->query("SELECT * 
	FROM 
	(select e.strnama_dealer, 
		e.strnama_upline, 
		g.strnama_unit, 
		f.strnama, 
		sum(d.intquantity) intquantity, 
		a.`group`, 
		a.intid_arisan, 
		a.winner, 
		a.intjeniscicilan, 
		b.tanggal,
		g.intid_unit,
		e.intid_dealer,
		a.intid_arisan_detail
			from arisan a, arisan_detail b, nota c, nota_detail d, member e, barang f, unit g 
			where a.intid_arisan = b.intid_arisan 
			and a.intid_arisan_detail = c.intid_nota 
			and c.intid_nota = d.intid_nota 
			and d.intid_barang = f.intid_barang 
			and c.intid_dealer = e.intid_dealer 
			and c.intid_unit = g.intid_unit 
			and d.is_free=0 
			and c.intid_cabang = $id_cabang
			group by c.intid_nota) AS z 
		WHERE  z.strnama_dealer = '$data[strnama_dealer]'");

		}

        return $query->result();
    }
	//end////
	/// line baru ikhlas 09042013////
	/// line baru ikhlas 27092013////
	function get_manager_unit_cabang($bulan,$id_cabang) {
      
	  $thn = date('Y');
	  /*
	  * 09042013
      $query = $this->db->query("select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
		unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
		(select sum(a.inttotal_omset) total_omset
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' ) 
			AND YEAR(a.datetgl)='$thn' 
			and a.intid_unit = unit.intid_unit
			and a.intid_jpenjualan = 1 
			and a.is_dp = 0) omset_unit
		from nota, member, unit, cabang 
		where nota.intid_dealer = member.intid_dealer 
		and member.intid_unit = unit.intid_unit
		and member.intid_cabang = cabang.intid_cabang
		and member.intlevel_dealer = 1
		and cabang.intid_cabang = '$id_cabang'
		and nota.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(nota.datetgl) = '$thn'
		and nota.is_dp = 0
		group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer
		order by cabang.strnama_cabang asc") ;
		*/
		$query = $this->db->query("select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
		unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
		(select sum(a.inttotal_omset) total_omset
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' ) 
			AND YEAR(a.datetgl)='$thn' 
			and a.intid_unit = unit.intid_unit
			and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
			and a.is_dp = 0) omset_unit,
		(select sum(a.inttotal_omset) total_omset
			from nota a
			where 
			a.intid_week in (select intid_week from week where intbulan='$bulan') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit and a.intid_jpenjualan = 1
			and a.is_dp = 0) omset_unit_asli
		from nota, member, unit, cabang 
		where nota.intid_dealer = member.intid_dealer 
		and member.intid_unit = unit.intid_unit
		and member.intid_cabang = cabang.intid_cabang
		and member.intlevel_dealer = 1
		and cabang.intid_cabang = '$id_cabang'
		and nota.intid_week in (select intid_week from week where intbulan = '$bulan')
		and YEAR(nota.datetgl) = '$thn'
		and nota.is_dp = 0
		group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer
		order by cabang.strnama_cabang asc") ;
	  return $query->result();
     }
	 ////end////////
	 
	 /**
	 * @param get_manager_unit_cabang_tahun
	 * desc : menambahkan tahun di laporannya
	 */
	 
	 //date_modified 2014-04-01 ifirlana@gmail.com
	 
	 function get_manager_unit_cabang_tahun($bulan,$id_cabang,$tahun) {
      
	  $thn =$tahun;
		
		/* $select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
							unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
							(select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan,
							(select sum(a.inttotal_omset) total_omset
								from nota a
								where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn' ) 
								AND YEAR(a.datetgl)='$thn' 
								and a.intid_unit = unit.intid_unit
								and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
								and a.is_dp = 0) omset_unit,
							(select sum(a.inttotal_omset) total_omset
								from nota a
								where 
								a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun = '$thn') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit and a.intid_jpenjualan = 1
								and a.is_dp = 0) omset_unit_asli
							from nota, member, unit, cabang 
							where nota.intid_dealer = member.intid_dealer 
							and member.intid_unit = unit.intid_unit
							and member.intid_cabang = cabang.intid_cabang
							and member.intlevel_dealer = 1
							and cabang.intid_cabang = '$id_cabang'
							and nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
							and YEAR(nota.datetgl) = '$thn'
							and nota.is_dp = 0
							group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer
							order by cabang.strnama_cabang asc"; */
							$select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
							unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
							(select cabang.strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) pengambilan,
							(select sum(a.inttotal_omset) total_omset
								from nota a
								where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn' ) 
								AND YEAR(a.datetgl)='$thn' 
								and a.intid_unit = unit.intid_unit
								and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
								and a.is_dp = 0) omset_unit,
							(select sum(a.inttotal_omset) total_omset
								from nota a
								where 
								a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun = '$thn') AND YEAR(a.datetgl)='$thn' and a.intid_unit = unit.intid_unit and a.intid_jpenjualan in (1)#,16,18) 
								and a.is_dp = 0) omset_unit_asli
							from nota, member, unit, cabang 
							where nota.intid_dealer = member.intid_dealer 
							and member.intid_unit = unit.intid_unit
							and member.cabang_pengambilan = cabang.intid_cabang
							and member.intlevel_dealer = 1
							and cabang.intid_cabang = '$id_cabang'
							and nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
							and YEAR(nota.datetgl) = '$thn'
							and nota.is_dp = 0
							group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer
							order by cabang.strnama_cabang asc";
		/**
		
		$select	=	"select member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer, 
							unit.strnama_unit, unit.intid_unit, cabang.strnama_cabang, 
							unit_omset.total_omset omset_unit,
							omset.total_omset omset_unit_asli
							from 
							nota, 
							member, 
							unit,
							cabang,
							(select sum(a.inttotal_omset) total_omset, a.intid_unit
								from nota a
								where 
								a.intid_week in (select intid_week from week where intbulan='$bulan' and inttahun = '$thn') AND YEAR(a.datetgl)='$thn' and a.intid_jpenjualan = 1
								and a.is_dp = 0
								group by a.intid_unit
								) omset,
							(select sum(a.inttotal_omset) total_omset, a.intid_unit
								from nota a
								where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn' ) 
								AND YEAR(a.datetgl)='$thn' 
								and a.intid_jpenjualan != 8 and a.intid_jpenjualan != 10 and a.intid_jpenjualan != 11 and a.intid_jpenjualan != 12 
								and a.is_dp = 0
								group by a.intid_unit
								) unit_omset
							where
							omset.intid_unit = member.intid_unit
							and unit_omset.intid_unit = omset.intid_unit
							and nota.intid_dealer = member.intid_dealer 
							and member.intid_unit = unit.intid_unit
							and unit.intid_unit = omset.intid_unit
							and member.intid_cabang = cabang.intid_cabang
							and member.intlevel_dealer = 1
							and cabang.intid_cabang = '$id_cabang'
							and nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
							and YEAR(nota.datetgl) = '$thn'
							and nota.is_dp = 0
							group by member.strnama_dealer, member.strkode_dealer, member.strnama_upline, member.intid_dealer
							order by cabang.strnama_cabang asc";
		
		*/
		$query = $this->db->query($select) ;
	  return $query->result();
     }
	  /////line ikhlas 12042013///
	 function LaporanNotaHadiah($idNota) {
        $query = $this->db->query("select nota_hadiah.intno_nota, nota_hadiah.datetgl, nota_detail_hadiah.*, barang.strnama, harga.intharga_jawa,
                harga.intharga_luarjawa, cabang.intid_wilayah,
                cabang.strnama_cabang, unit.strnama_unit, member.strnama_dealer, member.strnama_upline, nota_hadiah.*
                
                from nota_hadiah
                
				inner join cabang on cabang.intid_cabang = nota_hadiah.intid_cabang
				inner join unit on unit.intid_unit = nota_hadiah.intid_unit
                inner join nota_detail_hadiah on nota_detail_hadiah.intid_nota = nota_hadiah.intid_nota
                inner join member on member.intid_dealer = nota_hadiah.intid_dealer
                left join barang on barang.intid_barang = nota_detail_hadiah.intid_barang
                inner join harga on harga.intid_barang = nota_detail_hadiah.intid_barang
                where nota_hadiah.intno_nota = '$idNota'
				order by nota_detail_hadiah.intid_nota");
        
        return $query->result();
     }
	 function cek_strkodedelaer($strkode_dealer){
		$query = $this->db->query('select * from member where strkode_dealer = "'.$strkode_dealer.'"');
		return $query->num_rows();
	 }
	 //line ikhlas 24April2013///
//009
	 /**
	 * untuk mencari iddealer 
	 * @param get_iddealer()
	 */
	 
	function get_iddealer($strkode_dealer){
		$query = $this->db->query('select intid_dealer from member where strkode_dealer = "'.$strkode_dealer.'"');
		$row = $query->result();
		return $row[0]->intid_dealer;
	}
	function insertNotaRekrutcoba($data){
		$this->db->insert('nota_hadiah',$data);
		return $this->db->insert_id();
	}
	function insertNotaRekrutdetail($data){

		$this->db->insert('nota_detail_hadiah',$data);		
		return $this->db->insert_id();
	}
	
	function updaterekrut_hadiah_detail($id,$intno_nota){
		$data = array(
               'is_tebus' => '1',
               'date' => date('Y-m-d')
            );

		$this->db->where('child_id', $id);
		$this->db->update('rekrut_hadiah_detail', $data); 
		$query = $this->db->query('select id_group from rekrut_hadiah_detail where	child_id = "'.$id.'"');
		return $query->result();
	}
	
	function updaterekrut_hadiah($id,$intno_nota,$id_group){
		$data = array(
               'is_hadiah' => '1',
               'intno_nota' => $intno_nota,
               'date_hadiah' => date('Y-m-d')
            );

		$this->db->where('parent_kode', $id);
		$this->db->where('id_group', $id_group);
		$this->db->update('rekrut_hadiah', $data); 

	}
	function selectUplinefromKode($id)
	{
		$query = $this->db->query('select strkode_upline from member where intid_dealer = "'.$id.'"');
	    return $query->result();
	}
	function get_rekrut_hadiah($kode,$intharga)
		{
			$query = $this->db->query('select 
				h.intharga_luarjawa, 
				h.intharga_jawa,
				rhd.intno_nota, 
				rhd.date tanggal, 
				rhd.child_kode,
				rhd.child_id,
				rhd.is_tebus,
				(select strnama_dealer from member where member.strkode_dealer = rhd.child_kode) strnama_dealer 
					from 
						nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota
						inner join harga h on h.intid_harga = nd.intid_harga
						inner join rekrut_hadiah_detail rhd on rhd.intno_nota = n.intno_nota
						inner join rekrut_hadiah rh on rh.id_group = rhd.id_group
					 where rh.is_hadiah = 0 
				and rh.parent_id ="'.$kode.'" and rh.intharga = "'.$intharga.'" LIMIT 0, 4'); 
				/*
			$query = $this->db->query('select 
				h.intharga_luarjawa, 
				h.intharga_jawa,
				rhd.intno_nota, 
				rhd.date tanggal, 
				rhd.child_kode,
				rhd.child_id,
				rhd.is_tebus,
				(select strnama_dealer from member where member.strkode_dealer = rhd.child_kode) strnama_dealer 
					from 
						nota n inner join nota_detail nd on nd.intid_nota = n.intid_nota
						inner join harga h on h.intid_harga = nd.intid_harga
						inner join rekrut_hadiah_detail rhd on rhd.intno_nota = n.intno_nota
						inner join rekrut_hadiah rh on rh.id_group = rhd.id_group
					 where rh.is_hadiah = 0 
				and rh.parent_id ="'.$kode.'" LIMIT 0, 4'); 
				*/				
			return $query->result();
		}
	function get_fromkodemember($id){
		$db = $this->db->query('select strkode_dealer from member where intid_dealer = "'.$id.'"');
		return $db->result();
	}
	function insertGroupRekrutHadiah($kode_upline,$kode,$intno_nota,$id,$intid){
	$cek = 0;
	$cek = $this->check_nota($intno_nota);
	if($cek > 0){
		$query = $this->db->query('select 
			distinct rh.id_group,
			(select count(*) 
				from rekrut_hadiah_detail rhd 
				where rhd.id_group = rh.id_group) total_rekrut 
			from rekrut_hadiah rh inner join rekrut_hadiah_detail rhd on rh.id_group = rhd.id_group 
			where parent_kode = "'.$kode_upline.'" and intharga = "'.$intid.'" order by rh.id_group ASC');
		$id_upline = $this->get_idmember($kode_upline);
		$id_ = $this->get_idmember($kode);
			
			foreach($query->result() as $row){
				if($row->total_rekrut == $id){
					//group baru untuk mereset group yang lebih dari $id
					//max id lalu dimasukan rekrut_hadiah dan rekrut_hadiah_detail
					//echo ('hello.<br />');		
					$cek = 1;
					//$id_group = 0;
					//echo "terjadi penambahan tabel rekrut_hadiah : ".$id."<br />";
				}else{
					$id_group = $row->id_group;
					$cek = 0;
				}				
			}
			if($cek == 1){
				$id = $this->insertGroupBaru($kode_upline,$id_upline[0]->intid_dealer,$kode,$id_[0]->intid_dealer,$intno_nota,$intid);
				$id_group = 0;
				//echo "terjadi penambahan tabel rekrut_hadiah : ".$id."<br />";	
			}
			if($id_group != 0){
				$row = $this->get_idmember($kode);
				$data = array(
					'id_group' => $id_group,
					'child_id' => $row[0]->intid_dealer,
					'child_kode' => $kode,
					'intno_nota' => $intno_nota,
					'date' => date('Y-m-d'),
					'is_tebus' => '0'
				);
				$this->db->insert('rekrut_hadiah_detail',$data);
				//$temp = $this->db->insert_id();
				//echo "terjadi penambahan rekrut hadiah detail : ".$temp."<br />";
			}
		}	
	}
	function insertGroupBaru($kode_upline,$id_upline,$kode_child,$id_child,$intno_nota,$intid){
		$temp =0;
		$data =array(
			'is_hadiah' => '0',
			'parent_kode' => $kode_upline,
			'parent_id' => $id_upline,
			'intharga' => $intid
		);
		$this->db->insert('rekrut_hadiah',$data);
		$temp = $this->db->insert_id();
		//echo "id rekrut_hadiah : ".$temp."<br />";
		if($temp > 0 ){
			$datadetail = array(
				'id_group' => $temp,
				'child_id' => $id_child,
				'child_kode'=> $kode_child,
				'date' => date('Y-m-d'),
				'intno_nota' => $intno_nota,
				'is_tebus' => '0'
				);
				$this->db->insert('rekrut_hadiah_detail',$datadetail);
				$temp = $this->db->insert_id();
		}
		return $temp;
	}	
	function get_idmember($kode){
		$db = $this->db->query('select intid_dealer from member where strkode_dealer = "'.$kode.'"');
		return $db->result();
	}
	
	function check_nota($intno_nota){
		$db = $this->db->query('select count(*) from nota where intno_nota = "'.$intno_nota.'"');
		return $db->num_rows();
	}
	////line 25April2013
	function selectBarangRekrutHadiahSatu($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "2"
			and brh.paket = "paket_215"');
		
		return $query->result();
	}
	function selectBarangRekrutHadiahDua($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "3"
			and brh.paket = "paket_215"');
		
		return $query->result();
	}
	function selectBarangRekrutHadiahTiga($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "4"
			and brh.paket = "paket_215"');
		
		return $query->result();
	}
	function selectBarangRekrutHadiahSatu108($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "2"
			and brh.paket = "paket_108"');
		
		return $query->result();
	}
	function selectBarangRekrutHadiahDua108($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "3"
			and brh.paket = "paket_108"');
		
		return $query->result();
	}
	function selectBarangRekrutHadiahTiga108($keyword){
		$query = $this->db->query('select brh.intid_barang, 
			upper(b.strnama) strnama,
			h.*
		from barang_rekrut_hadiah brh inner join barang b on b.intid_barang =  brh.intid_barang,
			harga h 
		where 
			brh.intid_barang = h.intid_barang 
			and b.strnama LIKE "'.$keyword.'%" 
			and brh.jumlah_rekrut = "4"
			and brh.paket = "paket_108"');
		
		return $query->result();
	}
	///////ending//////////////////////////
	function cek_nota($intno_nota){
		$query = $this->db->query('select count(*) cont from nota_hadiah where intno_nota = "'.$intno_nota.'"');
		$row = $query->result();
		return $row[0]->cont;
	}
	function selectBarangPromo10ALL($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,
									b.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa
									FROM promo10 a, barang b, harga c
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end
									and b.strnama like '$keyword%'");
        return $query->result();
	}
	
	function selectBarangFree10ALL($keyword, $state){
        $query = $this->db->query("SELECT a.intid_promo,upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intharga_kualalumpur,c.intharga_luarkualalumpur, c.intpv_jawa, c.intpv_luarjawa, c.intpv_kualalumpur, c.intpv_luarkualalumpur, b.intid_barang
									FROM promo10 a, barang b, harga c 
									where a.intid_barang_free = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and a.intid_barang= $state
									and b.strnama like '$keyword%'");
        return $query->result();
	}
	function insertNotaHal($data,$hal){
		$tgl = date("Y-m-d");
		$dealer = $this->input->post('strkode_dealer');
		$unit = $this->input->post('id_unit');
		$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
        $intid_dealer = $i->result();
		if(isset($_POST['intdp'])){
			$is_dp = 1;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intdp');
		} else { 
			$is_dp = 0;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intcash');
			
		}
		if(isset($_POST['is_lg'])){
			$is_lg = 1;
		} else {
			$is_lg = 0;
		}
		if(isset($_POST['is_lglain'])){
			$is_lglain = 1;
		} else {
			$is_lglain = 0;
		}
		if(isset($_POST['is_lgBaru'])){
			$is_lgBaru = 1;
		} else {
			$is_lgBaru = 0;
		}
		if(isset($_POST['is_lgOval'])){
			$is_lgOval = 1;
		} else {
			$is_lgOval = 0;
		}if(isset($_POST['is_ten'])){
			$is_ten = 1;
		} else {
			$is_ten = 0;
		}if(isset($_POST['is_think'])){
			$is_ten = 1;
		} else {
			$is_ten = 0;
		}
		if(isset($_POST['is_asi'])){
			$is_asi = 1;
			$kredit = $this->input->post('totalbayar1');
			$komisiasi = $this->input->post('intkomisiasi');
		} else {
			$is_asi = 0;
			$komisiasi = 0;
			$kredit = $this->input->post('intkkredit');
		}
		//071112 kenapa pake ini ya?? 
		/*if(isset($_POST['intid_jpenjualan'])){
			$jml20 = 0;
		} else {
			$jml20 = $this->input->post('jml20');
		}*/
		
		$data = array(
            'intno_nota' => $intid_nota,
            'intid_jpenjualan' => $this->input->post('intid_jpenjualan'),
			'intid_cabang' => $this->input->post('intid_cabang'),
            'datetgl' => $tgl,
			'intid_dealer' => $intid_dealer[0]->intid_dealer,
			'intid_unit' => $this->input->post('id_unit'),
			'intid_week' => $intid_week,
			'intomset10' => $this->input->post('jml10'),
			//'intomset20' => $jml20,
			'intomset20'=> $this->input->post('jml20'),
			'intomset15'=> $this->input->post('jml15'),
			'inttotal_omset' => $this->input->post('jumlah'),
			'inttotal_bayar' => $this->input->post('totalbayar1'),
			'intdp' => $this->input->post('intdp'),
			'intcash' => $cash,
			'intdebit' => $this->input->post('intdebit'),
			'intkkredit' => $kredit,
			'intsisa' => $this->input->post('intsisahidden'),
			'intkomisi10' => $this->input->post('komisi1hidden'),
			'intkomisi20' => $this->input->post('komisi2hidden'),
			'intkomisi15' => $this->input->post('komisi15hidden'),
			'intpv' => $this->input->post('intpv'),
			'intvoucher' => $this->input->post('intvoucher'),
			'is_dp' => $is_dp,
			'is_lg' => $is_lg,
			'inttrade_in' => $this->input->post('komisitrade'),
			'is_asi' => $is_asi,
			'nokk' => $this->input->post('nokk'), 
			'intkomisi_asi' => $komisiasi,
			'is_arisan' => $this->input->post('is_arisan') ,
			'is_lglain' => $this->input->post('is_lglain') ,
			'is_lgBaru' => $this->input->post('is_lgBaru') ,
			'is_lgOval' => $this->input->post('is_lgOval') ,
			'is_ten' => $this->input->post('is_ten') ,
			'is_think' => $this->input->post('is_think') ,
			'halaman' => $hal
		);
        $this->db->insert('nota', $data);
		$intid_nota =$this->db->insert_id();
				        return $intid_nota;
	}
	
	function tambahDataTebus(/* $no_nota,$idNota ,$hal */$data=array()){
		/* 
		if(isset($_POST['intdp'])){
			$is_dp = 1;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intdp');
		} else { 
			$is_dp = 0;
			$intid_nota = $this->input->post('intno_nota');
			$week = $this->selectWeek();
        	$intid_week= $week[0]->intid_week;
			$cash = $this->input->post('intcash');
			
		}
	
		$data = array(
			'intid_nota_old' 	=>$data[$i]('id'),
			'intno_nota_old' 	=>$data[$i] ('no_nota'),
			/* 'intid_nota_new' 	=>$idNota,
			'intno_nota_new' 	=>$this->input->post('intid_nota'),
			'intid_cabang' 		=>$this->input->post('intid_cabang'),
			'halaman' 				=>$hal 
		); */
		$this->db->insert('nota_tebus',$data);	
	}
	
	
	
	function cekNota009($dealer, $unit, $totallg) {
     
		$i = $this->db->query("select intid_dealer from member where strkode_dealer like '$dealer%' and intid_unit = $unit");
		$intid_dealer = $i->result();
		$kode = $intid_dealer[0]->intid_dealer;
		$query = $this->db->query("SELECT n.intid_nota, n.inttotal_omset
			FROM nota n 
			where n.intid_dealer = $kode 
			and n.intid_week =(select intid_week from week where curdate() between dateweek_start and dateweek_end)
			and n.is_lg = 0 ORDER BY inttotal_omset ASC");
		$temp = 0;
		$cek = array();
		foreach($query->result() as $row){
			$temp = $temp + $row->inttotal_omset;
			if($temp <= $totallg){
				$cek[]['intid_nota'] = $row->intid_nota;
			}
		}
		return $cek;
	}
	///lin ikhlas untuk lg manual
	function selectBarangLg1($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) lg, c.intharga_jawa, c.intharga_luarjawa, b.intid_barang
									FROM tipe_lg a, barang b, harga c 
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and b.strnama like 'LEVEL GIFT 1%'");
        return $query->result();
	}
	
	function selectBarangLg2($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) lg, c.intharga_jawa, c.intharga_luarjawa, b.intid_barang
									FROM tipe_lg a, barang b, harga c 
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and b.strnama like 'LEVEL GIFT 2%'");
        return $query->result();
	}
	
	function selectBarangLg3($keyword){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) lg, c.intharga_jawa, c.intharga_luarjawa, b.intid_barang
									FROM tipe_lg a, barang b, harga c 
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and b.strnama like 'LEVEL GIFT 3%'");
        return $query->result();
	}
	function updateNotaLg_intno_nota($no_nota)
	{
		$data = array(
            'is_lg' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}
	function updateNotaLgLain_intno_nota($no_nota)
	{
		$data = array(
            'is_lglain' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}
	function updateNotaLgLain_intno_nota_think($no_nota)
	{
		$data = array(
            'is_think' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}function updateNotaLgLain_intno_nota_new($no_nota)
	{
		$data = array(
            'is_lgBaru' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}function updateNotaLgLain_intno_nota_oval($no_nota)
	{
		$data = array(
            'is_lgOval' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}
		//untuk tebus rekrut yg sepuluh
	function updateNotaLgLain_intno_nota_ten($no_nota)
	{
		$data = array(
            'is_ten' => 1
			
		);
       //001 di sini dari intno_nota diganti jadi intid_nota
	   $this->db->where('intno_nota', $no_nota);
       $this->db->update('nota',$data);
		
	}
	function selectUplineNonManager($keyword, $unit){
		$cab = $this->session->userdata('id_cabang');
		
		/*if(!empty($cab)){
		$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit and intid_cabang=$cab");
		}else{*/
		//$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit");
		
//001
		$query = $this->db->query("SELECT strnama_dealer, strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline, 
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 967) AS steamer, 
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 961) AS emc,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 966) AS chooper,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 971) AS metal_5lt,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 970) AS metal_7lt,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 969) AS metal_7in1
FROM member AS a WHERE a.strnama_dealer LIKE '$keyword%' AND a.intid_unit = $unit and a.intparent_leveldealer != 0 ");

		//}
              
        return $query->result();
	}
	function getRekrut($kode, $bulan) {
        $thn = date('Y');
     	$query = $this->db->query("select distinct(member.intid_dealer), member.strkode_dealer, member.strnama_dealer, sum(nota.inttotal_omset) omset
		from member left join nota on member.intid_dealer = nota.intid_dealer 
		where MONTH(member.datetanggal) = '$bulan' 
		and  YEAR(member.datetanggal)='$thn' 
		and  nota.is_dp != 1 
		and member.strkode_upline='$kode'
		and member.intid_dealer in (select distinct(intid_dealer) from nota where MONTH(datetgl)='$bulan' 
		and YEAR(datetgl)='$thn')
		group by nota.intid_dealer;");
        return $query->result();
			
     }
	 
	 /*
		2 jan 2014
		ikhlas firlana ifirlana@gmail.com
		desc : laporan menambahkan tahun 
	 */
	 
	function getRekrut_tahun($kode, $bulan,$tahun) {
        $thn = $tahun;
     	$query = $this->db->query("select distinct(member.intid_dealer), member.strkode_dealer, member.strnama_dealer, sum(nota.inttotal_omset) omset
		from member left join nota on member.intid_dealer = nota.intid_dealer 
		where MONTH(member.datetanggal) = '$bulan' 
		and  YEAR(member.datetanggal)='$thn' 
		and  nota.is_dp != 1 
		and member.strkode_upline='$kode'
		and member.intid_dealer in (select distinct(intid_dealer) from nota where MONTH(datetgl)='$bulan' 
		and YEAR(datetgl)='$thn')
		group by nota.intid_dealer;");
        return $query->result();
			
     }
	 function get_Omset($kode, $bulan) {
      $thn = date('Y');
		$query = $this->db->query("select 
			sum(nota.intomset10) omset10, 
			sum(nota.intomset20) omset20, 
			sum(nota.inttotal_omset) total_omset, 
			member.strnama_dealer, 
			unit.strnama_unit, 
			unit.intid_unit,
			c.strnama_cabang
		from nota inner join member on member.intid_dealer = nota.intid_dealer inner join unit on unit.intid_unit = nota.intid_unit inner join cabang c on c.intid_cabang = member.intid_cabang
		where 
		nota.is_dp = 0
		and member.strkode_dealer='$kode' 
		AND nota.intid_week in (select intid_week from week where intbulan = '$bulan')");
        return $query->result();
     }
	 /*
		2 jan 2014
		ikhlas firlana ifirlana@gmail.com
		desc : laporan menambahkan tahun 
	 */
	 function get_Omset_tahun($kode, $bulan,$tahun) {
      $thn = $tahun;
	  $select = "select 
			sum(nota.intomset10) omset10, 
			sum(nota.intomset20) omset20, 
			sum(nota.inttotal_omset) total_omset, 
			member.strnama_dealer, 
			unit.strnama_unit, 
			unit.intid_unit,
			c.strnama_cabang
		from 
			nota inner join member on member.intid_dealer = nota.intid_dealer 
			inner join unit on unit.intid_unit = nota.intid_unit 
			inner join cabang c on c.intid_cabang = member.intid_cabang
		where 
		nota.is_dp = 0
		and member.strkode_dealer='$kode' 
		AND YEAR(nota.datetgl) = '$thn'
		AND nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')";
		/*
			
		*/
		$query = $this->db->query($select);
        return $query->result();
     }
function get_Omset_Group($kode, $bulan) {
      $thn = date('Y');
		$query = $this->db->query("select sum(nota.intomset10) omset10, sum(nota.intomset20) omset20, sum(nota.inttotal_omset) total_omset, member.strnama_dealer, unit.strnama_unit, unit.intid_unit
		from nota, member, unit
		where member.intid_dealer = nota.intid_dealer 
		and nota.intid_unit = unit.intid_unit 
		and nota.is_dp != 1
		and member.strkode_dealer='$kode' 
		AND nota.intid_week in (select intid_week from week where intbulan = '$bulan')
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan= 9)
		group by member.strnama_dealer, unit.strnama_unit, unit.intid_unit");
        return $query->result();
     }
function get_Omset_Group_tahun($kode, $bulan,$tahun) {
      $thn = $tahun;
		$query = $this->db->query("select sum(nota.intomset10) omset10, sum(nota.intomset20) omset20, sum(nota.inttotal_omset) total_omset, member.strnama_dealer, unit.strnama_unit, unit.intid_unit
		from nota, member, unit
		where member.intid_dealer = nota.intid_dealer 
		and nota.intid_unit = unit.intid_unit 
		and nota.is_dp != 1
		and member.strkode_dealer='$kode' 
		and year(nota.datetgl) = '$tahun'
		AND nota.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$tahun')
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 16 or nota.intid_jpenjualan= 9)
		group by member.strnama_dealer, unit.strnama_unit, unit.intid_unit");
        return $query->result();
     }
	 function get_unit_or($kode, $bulan, $unit) {
        $thn = date('Y');
     	/*		
		$query = $this->db->query("select distinct(nota.intomset10) intomset10, nota.intomset20, nota.inttotal_omset, nota.intkomisi10, nota.intkomisi20, nota.inttotal_bayar, nota.intcash,
		cabang.intid_wilayah, member.strnama_upline,member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit,
		unit.intid_unit
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		left join nota_detail on nota_detail.intid_nota = nota.intid_nota
		where member.intlevel_dealer not in (1) and (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) AND MONTH(nota.datetgl)='$bulan' AND YEAR(nota.datetgl)='$thn'
		and nota.intid_unit = $unit");
		*/
		
		$query = $this->db->query("select nota.intomset10, nota.intomset20, nota.inttotal_omset, nota.intkomisi10, nota.intkomisi20, nota.inttotal_bayar, nota.intcash,
		cabang.intid_wilayah, member.strnama_upline,member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit,
		unit.intid_unit
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		left join nota_detail on nota_detail.intid_nota = nota.intid_nota
		where member.intlevel_dealer not in (1) and (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
		AND nota.intid_week in (select intid_week from week where intbulan = $bulan) 
		and nota.is_dp != 1
		and nota.intid_unit = $unit group by nota_detail.intid_nota");
		
        return $query->result();
			
     }
	 
	/**
	* @param get_unit_or_tahun
	* input		: $kode, $bulan, $unit
	* output	: query result
	* desc		: digunakan untuk tahun bulan unit
	* author	: ikhlas, ifirlana@gmail.com 
	* created	: 2 januari 2014
	* responsible	: ikhlas firlana
	*/
	 function get_unit_or_tahun($kode, $bulan, $unit,$tahun) {
        $thn = $tahun;
		$query = $this->db->query("select nota.intomset10, nota.intomset20, nota.inttotal_omset, nota.intkomisi10, nota.intkomisi20, nota.inttotal_bayar, nota.intcash,
		cabang.intid_wilayah, member.strnama_upline,member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit,
		unit.intid_unit
		from nota
		inner join cabang on cabang.intid_cabang = nota.intid_cabang
		inner join unit on unit.intid_unit = nota.intid_unit
		inner join member on member.intid_dealer = nota.intid_dealer
		left join nota_detail on nota_detail.intid_nota = nota.intid_nota
		where member.intlevel_dealer not in (1) and (nota.intid_jpenjualan=1 or nota.intid_jpenjualan=9) 
		AND nota.intid_week in (select intid_week from week where intbulan = $bulan and inttahun = $thn)
		AND YEAR(nota.datetgl) = $thn
		and nota.is_dp != 1
		and nota.intid_jpenjualan not in (16)
		and nota.intid_unit = $unit group by nota_detail.intid_nota");
		
        return $query->result();
			
     }
	 ///////// promo1free1
	 /*
function selectBarangSatuFreeSatuBayar($keyword,$key){
       $query = $this->db->query("select a.intid_barang, 
		 	upper(a.strnama) strnama, 
			b.* 
			from barang a, harga b, promotanggal p 
			where a.intid_barang = b.intid_barang 
			and p.intid_barang = a.intid_barang
			and CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and a.strnama like '".$keyword."%' 
			and p.status_pencarian = '".$key."' group by p.intid_barang");
        return $query->result();
	}
	*/
////////////////promo1free1
function selectBarangSatuFreeSatu($keyword, $state,$key){
      $query = $this->db->query("select upper(b.strnama) promo, h.intharga_jawa, h.intharga_luarjawa, h.intpv_jawa, h.intpv_luarjawa, p.intid_barang from promotanggal p inner join barang b on b.intid_barang = p.intid_barang_free inner join harga h on h.intid_barang = p.intid_barang where b.status_barang = 1 
		and p.intid_barang = '".$state."' 
		and b.strnama like '".$keyword."%' 
		and p.status_pencarian = '".$key."'
		and CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir");
		
        return $query->result();
	}
	////////////////promo40%

	function selectBarang40($keyword, $key, $intid_cabang = 0, $intid_wilayah = ""){
		$select = "SELECT UPPER( b.strnama ) promo, h.intharga_jawa, h.intcicilan_jawa,
						  h.intum_jawa,h.intum_luarjawa,b.strnama,h.intid_harga,
						  h.intcicilan_luarjawa,h.intharga_luarjawa, h.intpv_jawa, h.intpv_luarjawa, b.intid_barang,
						  h.intharga_kualalumpur, h.intharga_luarkualalumpur,
						  h.intpv_kualalumpur, h.intpv_luarkualalumpur,
						  b.intid_jbarang
							FROM barang b, harga h, promotanggal p 
							WHERE b.status_barang =1
							AND  h.intid_barang = b.intid_barang
							and b.intid_barang = p.intid_barang
							and curdate() between p.tanggal_mulai and p.tanggal_berakhir
							and p.status_pencarian = '".$key."'
							and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
							and p.intid_wilayah like '%".$intid_wilayah."%'
							AND b.strnama LIKE  '".$keyword."%'";
		$query = $this->db->query($select);
		return $query->result();
		
	}
	//jenis penjualan di halaman promo 1 free 1
	function selectJPenjualanPromo1free1(){
       if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (5, 6) and is_active = 1 order by intid_jpenjualan asc");
	   }else{
			  $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (5, 6)  order by intid_jpenjualan asc");
		}
	   return $query->result();
    }
	/**
	* @param jumlahbaby_manager
	* input		: intid_unit(unit), bulan(week) intbulan
	* output	: query result
	* desc		: digunakan untuk menghitung off reading baby manager. digunakan di controller laporan/cetak_ormothermanager
	* author	: ikhlas, ifirlana@gmail.com 
	* created	: 8 Juni 2013
	* responsible	: bu elisabeth
	*/
	function jumlahbaby_manager($unit,$bulan){
		$select = "select unit.strnama_unit,
			unit.intid_unit,
			(select sum(n.intomset10) from nota n where n.intid_unit = nota.intid_unit and n.intid_week IN (select intid_week from week where intbulan=".$bulan.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As omset10,
			(select sum(n.intomset20) from nota n where n.intid_unit = nota.intid_unit and n.intid_week IN (select intid_week from week where intbulan=".$bulan.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As omset20,
			(select sum(n.inttotal_bayar) from nota n where n.intid_unit = nota.intid_unit and n.intid_week IN (select intid_week from week where intbulan=".$bulan.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As inttotal_bayar,
			unit.strnama_unit,
			 unit.intid_unit
			from nota inner join unit on nota.intid_unit = unit.intid_unit inner join baby_manager bm on bm.intid_unitbaby = nota.intid_unit
			where bm.intid_unit = ".$unit." 
			group by unit.intid_unit";
			
		$query = $this->db->query($select);
		return $query->result();
	}
	/**
	* @param jumlahbaby_manager_tahun
	* input		: intid_unit(unit), bulan(week) intbulan, tahun
	* output	: query result
	* desc		: digunakan untuk menghitung off reading baby manager. digunakan di controller laporan/cetak_ormothermanager
	* author	: ikhlas, ifirlana@gmail.com 
	* created	: 2 januari 2014
	* responsible	: ikhlas firlana
	*/
	function jumlahbaby_manager_tahun($unit,$bulan,$tahun){
	/*
		$select = "select unit.strnama_unit,
			unit.intid_unit,
			(select sum(n.intomset10) from nota n where n.intid_unit = nota.intid_unit and year(n.datetgl) = '$tahun' and n.intid_week IN (select intid_week from week where intbulan=".$bulan." and inttahun = ".$tahun.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As omset10,
			(select sum(n.intomset20) from nota n where n.intid_unit = nota.intid_unit and year(n.datetgl) = '$tahun' and n.intid_week IN (select intid_week from week where intbulan=".$bulan." and inttahun = ".$tahun.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As omset20,
			(select sum(n.inttotal_bayar) from nota n where n.intid_unit = nota.intid_unit and year(n.datetgl) = '$tahun' and n.intid_week IN (select intid_week from week where intbulan=".$bulan." and inttahun = ".$tahun.") and n.is_dp = 0 and n.intid_jpenjualan = 1)As inttotal_bayar,
			unit.strnama_unit,
			 unit.intid_unit
			from nota inner join unit on nota.intid_unit = unit.intid_unit inner join baby_manager bm on bm.intid_unitbaby = nota.intid_unit
			where bm.intid_unit = ".$unit." 
			group by unit.intid_unit";*/
		$select = "
select unit.strnama_unit,
			unit.intid_unit, nota.omset10, nota.omset20, nota.inttotal_bayar,
			unit.strnama_unit,
			 unit.intid_unit
			from 
			(select * 
				from baby_manager  
				where
				baby_manager.intid_unit = $unit
				)bm 
				left join 
			(SELECT sum(n.intomset10) omset10,  sum(n.intomset20) omset20, sum(n.inttotal_bayar) inttotal_bayar, n.intid_unit
					from nota n
					where 
					year(n.datetgl) = $tahun
					and n.intid_week in (select intid_week from week where intbulan = $bulan and inttahun = $tahun) 
					and n.is_dp = 0
					and n.intid_jpenjualan = 1
					and n.intid_jpenjualan not in (16)
					group by n.intid_unit
					)nota on bm.intid_unitbaby = nota.intid_unit, unit
			where  bm.intid_unitbaby = unit.intid_unit			
			group by unit.intid_unit";
		$query = $this->db->query($select);
		return $query->result();
	}
	function get_data($sel,$where,$kode,$table){
		$select = "select ".$sel." from ".$table." where ".$where." = '".$kode."' ";
		$query = $this->db->query($select);
		return $query->result();
	} 
	function omset_anak($strkode_dealer,$bulan){
	$HASIL = 0;
	$query = $this->db->query('select 
		sum(nota.inttotal_omset) omset_anak
		from nota inner join member on member.intid_dealer = nota.intid_dealer 
		where nota.intid_week in (select intid_week from week where intbulan = "'.$bulan.'")
		and member.strkode_upline = "'.$strkode_dealer.'" 
		and nota.is_dp = 0
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)');
		$HASIL = $query->result();
		return $HASIL[0]->omset_anak;
	}
	//ending
	
	/***
	*	ifirlana@gmail.coim 10 jan 2014
	*	@param omset_anak_tahun
	*  desc : digunakan untuk kewajiban dealer 
	*/
	function omset_anak_tahun($strkode_dealer,$bulan,$tahun){
		$query = $this->db->query('select 
		sum(nota.inttotal_omset) omset_anak
		from nota inner join member on member.intid_dealer = nota.intid_dealer 
		where nota.intid_week in (select intid_week from week where intbulan = "'.$bulan.'" and inttahun = "'.$tahun.'")
		and member.strkode_upline = "'.$strkode_dealer.'" 
		and nota.is_dp = 0
		and year(nota.datetgl) = "'.$tahun.'"
		and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)');
		$HASIL = $query->result();
		return $HASIL[0]->omset_anak;
		}
	//ending
	
	//kode baru
	//IKHLAS 10 AGUSTUS2013
	function lookupBarangSatuFreeSatufree($keyword,$state,$key,$intid_cabang = 0){
		$query = $this->db->query("select a.intid_barang, 
			 	upper(a.strnama) strnama, 
				b.* 
				from barang a left join harga b on b.intid_barang = a.intid_barang 
				left join promotanggal p on p.intid_barang_free = a.intid_barang
				where
				CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir 
				and a.strnama like '%$keyword%'
				and p.intid_barang = '$state' 
				and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
				and p.status_pencarian = '$key' group by p.intid_barang_free");
	        return $query->result();
	}
	
	//kode baru
	//IKHLAS 10 AGUSTUS2013
	function lookupBarangSatuFreeSatufreeALLITEM($keyword){
		$query = $this->db->query("select a.intid_barang, 
			 	upper(a.strnama) strnama, 
				b.* 
				from barang a left join harga b on b.intid_barang = a.intid_barang 
				where a.strnama like '$keyword%'
				and CURDATE() BETWEEN b.date_start and b.date_end 
				group by a.intid_barang"); 
	        return $query->result();
	}
	
	//kode baru
	//IKHLAS 10 AGUSTUS2013
	function lookupBarangSatuFreeSatufreeALLITEM_try($keyword,$temp){
	 
	if($temp == null or $temp != "" or isset($temp)){
		$query = $this->db->query("select  a.intid_barang, 
			 	upper(a.strnama) strnama, 
				b.* 
				from 
				barang a 
				left join harga b on b.intid_barang = a.intid_barang 
				left join barang_code_detail c on a.intid_barang = c.intid_barang
				where 
				a.strnama like '$keyword%'
				and CURDATE() BETWEEN b.date_start and b.date_end 
				group by a.intid_barang");
			
			}else{
				$query = $this->db->query("select  a.intid_barang, 
						upper(a.strnama) strnama, 
						b.* 
						from 
						barang a 
						left join harga b on b.intid_barang = a.intid_barang 
						left join barang_code_detail c on a.intid_barang = c.intid_barang
						where 
						a.strnama like '$keyword%'
						and c.code_barang like '%$temp%'
						and CURDATE() BETWEEN b.date_start and b.date_end 
						group by a.intid_barang");
					}				
	        return $query->result();
	}
	
	function lookupBarangTradeIn($keyword,$key,$intid_cabang = 0){
		 $query = $this->db->query("select a.intid_barang, 
		 	upper(a.strnama) strnama, 
			b.* 
			from barang a, harga b, promotanggal p 
			where a.intid_barang = b.intid_barang 
			and p.intid_barang = a.intid_barang
			and CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and a.strnama like '".$keyword."%' 
			and p.status_pencarian = '".$key."' 
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			group by p.intid_barang");
		 return $query->result();
	}
	function selectBarangSatuFreeSatuBayar($keyword,$key, $intid_cabang = 0){
       $query = $this->db->query("select a.intid_barang, 
		 	upper(a.strnama) strnama, 
			b.* 
			from barang a, harga b, promotanggal p 
			where a.intid_barang = b.intid_barang 
			and p.intid_barang = a.intid_barang
			and CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and a.strnama like '".$keyword."%' 
			and p.status_pencarian = '".$key."' 
			and (p.intid_cabang = '0' or p.intid_cabang = '".$intid_cabang."') 
			group by p.intid_barang");
        return $query->result();
	}
	function get_nota($no_nota){
	$select = "select * from nota where nota.intno_nota = '$no_nota'";
	return $this->db->query($select);
	}
	function selectBarangDuaFreeSatu($keyword,$key,$cabang){
     	$req = 0;
     	$jbarang = 1;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.* 
        		from barang a inner join harga b on b.intid_barang = a.intid_barang 
        		inner join promocabang on promocabang.intid_barang =  a.intid_barang
        		where a.strnama like '$keyword%'
        		and promocabang.status_pencarian like '%$key%'
        		and promocabang.intid_cabang = '$cabang'
        		and CURDATE() BETWEEN promocabang.tanggal_mulai and promocabang.tanggal_berakhir
        		group by a.intid_barang");
        return $query->result();
	}
	function selectBarangDis($keyword,$key,$cabang){
     	$req = 0;
     	$jbarang = 1;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.* 
        		from barang a inner join harga b on b.intid_barang = a.intid_barang 
        		inner join promocabang on promocabang.intid_barang =  a.intid_barang
        		where a.strnama like '$keyword%'
        		and promocabang.status_pencarian like '%$key%'
        		and (promocabang.intid_cabang = '$cabang' or promocabang.intid_cabang = 0) 
        		and CURDATE() BETWEEN promocabang.tanggal_mulai and promocabang.tanggal_berakhir
        		group by a.intid_barang");
        return $query->result();
	}
	function selectBarangDuaFreeSatu_free($keyword,$key,$cabang,$intid_barang){
     	$req = 0;
     	$jbarang = 1;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.* 
        		from barang a inner join harga b on b.intid_barang = a.intid_barang 
        		inner join promocabang on promocabang.intid_barang_free =  a.intid_barang
        		where a.strnama like '$keyword%'
        		and promocabang.status_pencarian like '%$key%'
        		and promocabang.intid_cabang = '$cabang'
        		and promocabang.intid_barang = '$intid_barang'
        		and CURDATE() BETWEEN promocabang.tanggal_mulai and promocabang.tanggal_berakhir");
        return $query->result();
	}
	//select
	function selectBarangPromoCabang($keyword, $key, $cabang ){
      $req = 0;
     	$jbarang = 1;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang, upper(a.strnama) strnama, b.*, promocabang.*
        		from barang a inner join harga b on b.intid_barang = a.intid_barang 
        		inner join promocabang on promocabang.intid_barang =  a.intid_barang
        		where a.strnama like '$keyword%'
        		and promocabang.status_pencarian like '%$key%'
        		and promocabang.intid_cabang = '$cabang'
        		and CURDATE() BETWEEN promocabang.tanggal_mulai and promocabang.tanggal_berakhir
        		group by a.intid_barang");
        return $query->result();
	}
	function selectBarangPromoCabangFree($keyword, $key, $cabang,$kode){
      $req = 0;
     	$jbarang = 1;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("select a.intid_barang intid_barang_pilih, 
				upper(a.strnama) strnama, 
				b.*, 
				promocabang.*
        		from barang a inner join harga b on b.intid_barang = a.intid_barang 
					inner join promocabang on promocabang.intid_barang_free =  a.intid_barang
        		where a.strnama like '$keyword%'
					and promocabang.status_pencarian like '%$key%'
					and promocabang.intid_cabang = '$cabang'
					and promocabang.intid_barang = '$kode'
					and CURDATE() BETWEEN promocabang.tanggal_mulai and promocabang.tanggal_berakhir
					group by a.intid_barang");
        return $query->result();
	}
	function selectBarangPromo10_jbarang($keyword,$intid_jbarang){
        $query = $this->db->query("SELECT distinct(upper(b.strnama)) promo, c.intid_harga, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,
									b.intid_barang, c.intum_jawa, c.intcicilan_jawa, c.intum_luarjawa, c.intcicilan_luarjawa
									FROM promo10 a, barang b, harga c
									where a.intid_barang = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end
									and b.strnama like '$keyword%'
									and b.intid_jbarang = $intid_jbarang");
        return $query->result();
	}
	function selectBarangFree10_jbarang($keyword, $state,$intid_jbarang){
        $query = $this->db->query("SELECT a.intid_promo,upper(b.strnama) promo, c.intharga_jawa, c.intharga_luarjawa, c.intpv_jawa, c.intpv_luarjawa,b.intid_barang
									FROM promo10 a, barang b, harga c 
									where a.intid_barang_free = b.intid_barang
									and b.intid_barang = c.intid_barang
									and CURDATE() BETWEEN c.date_start and c.date_end
									and (select intid_week from week where curdate() between dateweek_start and dateweek_end) between a.intid_week_start and a.intid_week_end 
									and a.intid_barang= $state
									and b.strnama like '$keyword%'
									and b.intid_jbarang = $intid_jbarang");
        return $query->result();
	}
	function selectJPenjualanCustom($data){
	$var = "";
	for($i=0;$i<count($data);$i++){
		$var .= $data[$i].", ";
		}
		if($var == ""){
		}else{
			$var = substr($var,0,-2);
		}
	if(strtoupper($this->session->userdata('username')) != "ADMIN" and strtoupper($this->session->userdata('username')) != "SOEKARNO HATTA"){
	$select = "select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan in (
		".$var.") and is_active = 1 order by intid_jpenjualan asc";
	   $query = $this->db->query($select);
	   }else{
			
			}
	   return $query->result();
    }
	function getno_nota(){
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $week = $this->selectWeek();
        
        $getnota = $this->getNoNotaNew();
		$nilai = $getnota[0]->id;
		$id = $nilai + 1;
		
		$this->getNoNotaUpdate($id);
		$kode = $cabang[0]->intid_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $nilai);
        
        return $kode;

	}
	///@param get_CetakNotaMember_ver2
	//pengganti get_CetakNotaMember untuk memunculkan barcode
	 function get_CetakNotaMember_ver2($idNota) {
      $query = $this->db->query("select nota.*, nota_detail.*, barang.strnama, 
							harga.intharga_jawa, harga.intharga_luarjawa, harga.intharga_kualalumpur,harga.intharga_luarkualalumpur,cabang.intid_wilayah, member.strnama_upline, 
							member.strnama_dealer,cabang.strnama_cabang, unit.strnama_unit, scan_barcode.barcode_data
							from nota
							inner join cabang on cabang.intid_cabang = nota.intid_cabang 
							inner join unit on unit.intid_unit = nota.intid_unit
							inner join member on member.intid_dealer = nota.intid_dealer
							inner join nota_detail on nota_detail.intid_nota = nota.intid_nota
							left join barang on barang.intid_barang = nota_detail.intid_barang
							LEFT JOIN harga on harga.intid_barang = barang.intid_barang
							left join scan_barcode on scan_barcode.kode = nota.intid_dealer
							where nota.intid_nota = '$idNota'");
        return $query->result();
     }
	 
	 //
	function selectUplineCalonNotGraduate($keyword, $unit){
		$query = $this->db->query("select 
                                    distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline, intid_dealer
                                   from
                                    member where strnama_dealer like '$keyword%' and intid_unit = $unit
                                    and member.strkode_dealer IN (select strkode_dealer from calon_manager where is_graduate  IN (1,0) )");

        return $query->result();
	}
	
	//
	function getOmset_tahun_lain($kode)
	{
		
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and (a.datetgl) = curdate()
								   and a.is_lglain = 0
								   and a.is_dp = 0");
        return $query->result();
	}
	function getOmset_tahun_lain_new($kode)
	{
		
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and (a.datetgl) = curdate()
								   and a.is_lgBaru = 0
								   and a.is_dp = 0");
        return $query->result();
	}
	function getOmset_tahun_lain_think($kode)
	{
		
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and (a.datetgl) = curdate()
								   and a.is_think = 0
								   and a.is_dp = 0");
        return $query->result();
	}
	//buat tebus rekrut yg 10
	
	function getOmset_tahun_rekrut10_new($kode)
	{
		
		/* $query = $this->db->query("select nota.intno_nota, member.strnama_dealer, member.intid_dealer,
													if(nota.intno_nota = nota_tebus.intno_nota_old,count(nota_tebus.intno_nota_old),'0') status_nota#,'1','0') status_nota
													from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
													LEFT JOIN nota_tebus on nota.intno_nota = nota_tebus.intno_nota_old
													WHERE nota.intid_jpenjualan = 10
													#and (nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."')
													and nota.datetgl BETWEEN '2015-05-05' and '2015-06-12'
													and member.strkode_upline = '$kode' GROUP BY nota.intno_nota
													and is_ten = 0"); */
		$query = $this->db->query("select distinct (nota.datetgl) tanggal, nota.intno_nota, member.strnama_dealer
													from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
													WHERE nota.intid_jpenjualan = 10
													and nota.datetgl BETWEEN '2015-05-05' and '2015-06-12'
													and member.strkode_upline = '$kode'
													and nota.is_ten = 0");
        return $query->result();
	}
	
	
	function getOmset_tahun_lain_oval($kode)
	{
		
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and (a.datetgl) = curdate()
								   and a.is_lgOval = 0
								   and a.is_dp = 0");
        return $query->result();
	}
	
		/**
		 * Berfungsi untuk: jika tanggal limit awal + 13 hari 
		 * dan tanggal sekarang kurang dari hasil penambahan 13 hari makas eksekusi
		 * By: fahmi
		 */
		function gettglrek($kode, $tglawal = "2015-05-05", $tglakhir = "2015-05-30"){
			/*pengambilan tanggal mulai*/
			$select = "select distinct (nota.datetgl) tanggal
									from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
									WHERE nota.intid_jpenjualan = 10
									and nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."'
									and member.strkode_upline = '$kode' LIMIT 1";
			//echo $select;			
			$gettglawal = $this->db->query($select)->result();
			return $gettglawal;
		}
	function getOmset_tahun_rekrut_new_1($kode, $tglawal = "2015-05-05", $tglakhir = "2015-05-30")
	{
		$xxx = self::gettglrek($kode,$tglawal, $tglakhir);
		//echo $xxx[0]->tanggal;
		$gettglawal= $xxx[0]->tanggal;
		/*jika tanggal awal > tanggal sekarang*/
		$select = "select ('".$gettglawal."' + interval 13 day) hariqry";
		//echo $select;
		$getperiodess = $this->db->query($select)->result();
		$tglskrg=date('Y-m-d');

			$tglawal = $gettglawal;
			$tglakhir = $getperiodess[0]->hariqry;
			if($tglskrg <= $getperiodess[0]->hariqry){
					$query = $this->db->query("select distinct (nota.datetgl) tanggal, '".$tglakhir."' as tanggal_akhir, nota.intno_nota, member.strnama_dealer, member.intid_dealer,
												if(nota.intno_nota = nota_tebus.intno_nota_old,'1','0') status_nota
												from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
												LEFT JOIN nota_tebus on nota.intno_nota = nota_tebus.intno_nota_old
												WHERE nota.intid_jpenjualan = 10
												and (nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."')
												#and nota.datetgl BETWEEN '2015-02-01' and '2015-04-11'
												and member.strkode_upline = '$kode'");
        		return $query->result(); 
			}	
			else{
			//	$xxx	=	self::gettglrek($kode,$tglawal,$tglakhir);
				$this->getOmset_tahun_rekrut_new_1($kode,$tglawal,$tglakhir);
			}			
	}
	/**
	* diperbaiki
		 * Berfungsi untuk: jika tanggal limit awal + 13 hari 
		 * dan tanggal sekarang kurang dari hasil penambahan 13 hari makas eksekusi
		 * By: fahmi
		 */
		function gettglrek2($kode, $tglawal = "2015-05-05", $tglakhir = "2015-05-30"){
			/*pengambilan tanggal mulai*/
			$select = "select distinct (nota.datetgl) tanggal
									from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
									WHERE nota.intid_jpenjualan = 10
									and nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."'
									and member.strkode_upline = '$kode' LIMIT 1";
			//echo $select;			
			$gettglawal = $this->db->query($select);
			return $gettglawal;
		}
	function getOmset_tahun_rekrut_new_2($kode, $tglawal = "2015-05-05", $tglakhir = "2015-05-30")
	{
		$check = self::gettglrek2($kode,$tglawal, $tglakhir);
		//echo $xxx[0]->tanggal;
		if($check->num_rows() > 0)
		{
			$xxx			=	$check->result();
			$gettglawal= $xxx[0]->tanggal;
			/*jika tanggal awal > tanggal sekarang*/
			$select = "select ('".$gettglawal."' + interval 14 day) hariqry";
			//echo $select;
			$getperiodess = $this->db->query($select)->result();
			$tglskrg=date('Y-m-d');

				$tglawal = $gettglawal;
				$tglakhir = $getperiodess[0]->hariqry;
				//var_dump($tglskrg);
				//var_dump($gettglawal);
				//var_dump($getperiodess[0]->hariqry);
				
				/* if($tglskrg <= $getperiodess[0]->hariqry){
				echo "<br>".$tglskrg." <> ".$getperiodess[0]->hariqry."<br>";
				}else{
					echo "<br>tglskr ".$tglskrg."<br>";
					$this->getOmset_tahun_rekrut_new_2($kode,$tglakhir,$tglskrg);
					
				} */
				if($tglskrg <= $getperiodess[0]->hariqry){
					$selx = "select distinct (nota.datetgl) tanggal, '".$tglakhir."' as tanggal_akhir, nota.intno_nota, member.strnama_dealer, member.intid_dealer,
													if(nota.intno_nota = nota_tebus.intno_nota_old,count(nota_tebus.intno_nota_old),'0') status_nota#,'1','0') status_nota
													from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
													LEFT JOIN nota_tebus on nota.intno_nota = nota_tebus.intno_nota_old
													WHERE nota.intid_jpenjualan = 10
													and (nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."')
													#and nota.datetgl BETWEEN '2015-02-01' and '2015-04-11'
													and member.strkode_upline = '$kode' GROUP BY nota.intno_nota";
						$query = $this->db->query($selx);
					//echo $selx."<pre>";
					return $query->result(); 
				}	
				else{
				//	$xxx	=	self::gettglrek($kode,$tglawal,$tglakhir);
					return $this->getOmset_tahun_rekrut_new_2($kode,$tglakhir,$tglskrg);
					//$this->getOmset_tahun_rekrut_new_2($kode,$tglawal,$tglakhir);
				}	
		}				
	}


	function getOmset_tahun_lain_new_1($kode)
	{
		$gettglawal = $this->db->query("select distinct (nota.datetgl) tanggal
									from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
									WHERE nota.intid_jpenjualan = 10
									and nota.datetgl BETWEEN '2015-03-02' and '2015-04-11'
									and member.strkode_upline = '$kode' LIMIT 1")->result();
		//var_dump($gettglawal);

		$getperiode2 = $this->db->query("select ('".$gettglawal[0]->tanggal."' + interval 14 day) hariini")->result();
		$getperiode3 = $this->db->query("select ('".$gettglawal[0]->tanggal."' + interval 29 day) hariini1")->result();
		//echo "<br> <br> select ('".$gettglawal[0]->tanggal."' + interval 28 day) hariini1";
		$tglakhir = '';
		$tglakhir1 = '';
		$tglawal = '';
		$tglawal1 = '';
		$tglskrg=date('Y-m-d');
		echo "<pre>";
		
		echo " tanggal sekarang : ". $tglskrg ;
		echo "<br> tgl awal rekrut : ".$gettglawal[0]->tanggal;
		echo "<br> tgl awal periode 2 : ".$getperiode2[0]->hariini;
		//echo "<br> tgl awal periode 3 : ".$getperiode3[0]->hariini1;
		 if ($getperiode3[0]->hariini1 < $tglskrg){
			echo "<br> no : 1 ";
			$tglawal1 = strtotime ('+28 day' , strtotime( $gettglawal[0]->tanggal ));//menambahkan 29 hari
			$tglakhir1 = strtotime ('+28 day' , strtotime( $getperiode2[0]->hariini )); //menambahkan 28 hari
			$tglawal = date('Y-m-d', $tglawal1);
			$tglakhir = date('Y-m-d', $tglakhir1);	
			echo "<br>tgl awal : ".$tglawal;
			echo "<br>tgl akhir : ".$tglakhir;
			//var_dump(date("Y-m-d", strtotime($tglawal))); 
		 }else if ($getperiode2[0]->hariini < $tglskrg ){
		    echo "<br> no : 2 ";
			$tglawal1 = strtotime ('+15 day' , strtotime( $gettglawal[0]->tanggal ));//menambahkan 15 hari
			$tglakhir1 = strtotime ('+15 day' , strtotime( $getperiode2[0]->hariini ));//menambahkan 14 hari
			$tglawal = date('Y-m-d', $tglawal1);
			$tglakhir = date('Y-m-d', $tglakhir1);
			echo "<br>tgl awal : ". $tglawal;
			echo "<br>tgl akhir : ".$tglakhir;
				//var_dump(date("Y-m-d", strtotime($tglawal))); 
		}else { 
			echo "<br> no : 3 "  ; //====ini periode pertama=====
			   $tglawal = $gettglawal[0]->tanggal;
			   $tglakhir = $getperiode2[0]->hariini;
			   echo "<br>tgl awal : ".$tglawal;
			   echo "<br>tgl akhir : ".$tglakhir;
				//var_dump(date("Y-m-d", strtotime($tglawal))); 
		}; 
		//var_dump($getperiode1); 
		//var_dump($getperiode2); 
		//var_dump($tglakhir); 
									
		$query = $this->db->query("select distinct (nota.datetgl) tanggal, nota.intno_nota, member.strnama_dealer,
									if(nota.intno_nota = nota_tebus.intno_nota_old,'1','0') status_nota
									from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
									LEFT JOIN nota_tebus on nota.intno_nota = nota_tebus.intno_nota_old
									WHERE nota.intid_jpenjualan = 10
									and (nota.datetgl BETWEEN '".$tglawal."' and '".$tglakhir."')
									#and nota.datetgl BETWEEN '2015-02-01' and '2015-04-11'
									and member.strkode_upline = '$kode'");
									
/* 		echo "<br><br>select distinct (nota.datetgl) tanggal, nota.intno_nota, member.strnama_dealer
									from nota INNER JOIN member on nota.intid_dealer = member.intid_dealer
									WHERE nota.intid_jpenjualan = 10
									and nota.datetgl BETWEEN '".$gettglawal[0]->tanggal."' and '".$getperiode1[0]->hariini."'
									and member.strkode_upline = '$kode' <br>";
 */		
		/* $query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and (a.datetgl) = curdate()
								   and a.is_lgBaru = 0
								   and a.is_dp = 0");*/
								   
        return $query->result(); 
	}
	
	function getOmset_tahun($kode,$tahun,$wilayah=0)
	{
		$qryother = '';
		if($wilayah>=3){
			$qryother = "and a.`intid_cabang` in (select intid_cabang from cabang where intid_wilayah >= 3 )";
		}else if($wilayah > 0 && $wilayah < 3){
			$qryother = "and a.`intid_cabang` in (select intid_cabang from cabang where intid_wilayah < 3 )";

		}
		$week = $this->db->query("select intid_week from week where curdate() between dateweek_start and dateweek_end and inttahun = $tahun");
        $id_week = $week->result();
		$week_now = $id_week[0]->intid_week;
		$query = $this->db->query("select distinct(a.datetgl) tanggal, a.intno_nota,a.inttotal_omset 
								   from nota a join nota_detail b on a.intid_nota=b.intid_nota 
								   where a.intid_dealer = $kode
								   and a.intid_week = $week_now
								   and year(a.datetgl) = $tahun
								   and a.is_lg = 0
								   and a.inttotal_omset > 0
								   and a.is_dp = 0 $qryother");
        return $query->result();
	}
	
	//added 2014 04 08 ifirlana
	//custom untuk penjualan ABO
	
	function selectDownline($keyword, $unit,$upline){ 
		$cab = $this->session->userdata('id_cabang');
		
		/*if(!empty($cab)){
		$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit and intid_cabang=$cab");
		}else{*/
		//$query = $this->db->query("select distinct(strnama_dealer), strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline from member where strnama_dealer like '$keyword%' and intid_unit = $unit");
		
//001
		$query = $this->db->query("SELECT strnama_dealer, strkode_dealer, intlevel_dealer, strnama_upline, strkode_upline, intid_dealer, intid_starterkit, intid_week,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 967) AS steamer, 
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 961) AS emc,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 966) AS chooper,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 971) AS metal_5lt,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 970) AS metal_7lt,
(SELECT COUNT(*) FROM member INNER JOIN nota ON member.intid_dealer = nota.intid_dealer INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota LEFT JOIN barang ON nota_detail.intid_barang = barang.intid_barang WHERE member.strnama_dealer = a.strnama_dealer AND member.intid_unit = a.intid_unit AND nota.intid_jpenjualan = 13 AND barang.intid_barang = 969) AS metal_7in1
FROM member AS a WHERE a.strnama_dealer LIKE '$keyword%' AND a.intid_unit = $unit AND a.strkode_upline LIKE '%$upline%' AND a.intid_week in (27, 28,29,30,31,32,33,34,35) and year(a.datetanggal) = '".date('Y')."' and a.is_abo = 0");

		//}
              
        return $query->result();
	}
	
	//get_starterkittahun digunakan untuk mengukur data fee penjualan starterkit.
	//date 2014 06 09
	//date modified 2015 06 10
	//ifirlana@gmail.com
	
	function get_starterkittahun($intid_cabang, $intbulan, $tahun, $status = ""){
		
		if($tahun > 2014)
		{
			$select = "select sum(nota_detail.intquantity * harga.intfee_jawa ) fee_jawa, sum(nota_detail.intquantity * harga.intfee_luarjawa ) fee_luarjawa
		from nota_detail, 
		(select barang_code_detail.* 
			from barang,  barang_code_detail 
			where 
			barang.intid_barang = barang_code_detail.intid_barang 
			and barang_code_detail.code_barang = '".$status."') barang left join
		(select harga.*  
			from harga
			) harga on harga.intid_barang = barang.intid_barang
		where 
		barang.intid_barang = nota_detail.intid_barang
		and nota_detail.intid_nota in (select intid_nota from nota 
																where intid_cabang = '$intid_cabang' 
																	and intid_jpenjualan = 10 
																	and year(datetgl) = '$tahun' 
																	and intid_week in (select intid_week from week where inttahun = '$tahun' and intbulan = '$intbulan')
																)";
		
		}else
		{
			$select = "select sum(nota_detail_2014.intquantity * harga.intfee_jawa ) fee_jawa, sum(nota_detail_2014.intquantity * harga.intfee_luarjawa ) fee_luarjawa
		from nota_detail_2014, 
		(select barang_code_detail.* 
			from barang,  barang_code_detail 
			where 
			barang.intid_barang = barang_code_detail.intid_barang 
			and barang_code_detail.code_barang = '".$status."') barang left join
		(select harga.*  
			from harga
			) harga on harga.intid_barang = barang.intid_barang
		where 
		barang.intid_barang = nota_detail_2014.intid_barang
		and nota_detail_2014.intid_nota in (select intid_nota from nota_2014 
																where intid_cabang = '$intid_cabang' 
																	and intid_jpenjualan = 10 
																	and year(datetgl) = '$tahun' 
																	and intid_week in (select intid_week from week where inttahun = '$tahun' and intbulan = '$intbulan')
																)";

		}
		/*
		$select = "select 
		sum(nota_detail.intquantity * nota_detail.intharga ) fee_jawa, 
		sum(nota_detail.intquantity * nota_detail.intharga ) fee_luarjawa
		from 
		(select * from nota_detail where is_free = 0) nota_detail, 
		(select barang_code_detail.* 
			from barang,  barang_code_detail 
			where 
			barang.intid_barang = barang_code_detail.intid_barang 
			and barang_code_detail.code_barang = '".$status."'
			and barang.intid_jbarang = 4 ) barang 
		where 
		barang.intid_barang = nota_detail.intid_barang
		and nota_detail.intid_nota in (select intid_nota from nota 
																where intid_cabang = '$intid_cabang' 
																	and intid_jpenjualan = 10 
																	and year(datetgl) = '$tahun' 
																	and intid_week in (select intid_week from week where inttahun = '$tahun' and intbulan = '$intbulan')
																)";
																*/
		$query	=	$this->db->query($select);
		return $query;
		}
	
	//get_starterkitdealertahun digunakan untuk mengukur data fee penjualan starterkit.
	//date 2014 06 09
	//ifirlana@gmail.com 
	
	function get_starterkitdealertahun($intid_cabang, $intbulan, $tahun){
		
		$select = "select sum(nota.inttotal_bayar) harga_dealer from nota 
							where intid_cabang = '$intid_cabang' 
								and intid_jpenjualan = 10 
								and year(datetgl) = '$tahun' 
								and intid_week in (select intid_week from week where inttahun = '$tahun' and intbulan = '$intbulan')
							";
		
		$query	=	$this->db->query($select);
		return $query;
		}
		
	/* 
	ikhlas firlana 
	2014 09 05
	*/
	function get_dis40tahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 16
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 16
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
	 
	 function get_dis40_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 16 
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 16 
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }
        return $query->result();
     }
	 
	/** 
	* mengurangi biar maksimal
	*/
	
	function insertNotaHal_terbaru($data,$hal){
		
		
		if(isset($_POST['intdp']) and $_POST['intdp'] != 0){
			$cash = $this->input->post('intdp');
		} else { 
			$cash = $this->input->post('intcash');
			
		}
		if(isset($_POST['is_lg'])){
			$is_lg = 1;
		} else {
			$is_lg = 0;
		}
		if(isset($_POST['is_asi'])){
			$is_asi = 1;
			$kredit = $this->input->post('totalbayar1');
			$komisiasi = $this->input->post('intkomisiasi');
		} else {
			$is_asi = 0;
			$komisiasi = 0;
			$kredit = $this->input->post('intkkredit');
		}
		//071112 kenapa pake ini ya?? 
		/*if(isset($_POST['intid_jpenjualan'])){
			$jml20 = 0;
		} else {
			$jml20 = $this->input->post('jml20');
		}*/
		
		$data = array(
            'intno_nota' => $this->input->post('dp_name').$this->input->post('intno_nota'),
            'intid_jpenjualan' => $this->input->post('intid_jpenjualan'),
			'intid_cabang' => $this->input->post('intid_cabang'),
            'datetgl' => $this->input->post('datetgl'),
			'intid_dealer' => $this->input->post('intid_dealer'),
			'intid_unit' => $this->input->post('id_unit'),
			'intid_week' => $this->input->post('intid_week'),
			'intomset10' => $this->input->post('jml10'),
			//'intomset20' => $jml20,
			'intomset20'=> $this->input->post('jml20'),
			'intomset15'=> $this->input->post('jml15'),
			'inttotal_omset' => $this->input->post('jumlah'),
			'inttotal_bayar' => $this->input->post('totalbayar1'),
			'intdp' => $this->input->post('intdp'),
			'intcash' => $cash,
			'intdebit' => $this->input->post('intdebit'),
			'intkkredit' => $kredit,
			'intsisa' => $this->input->post('intsisahidden'),
			'intkomisi10' => $this->input->post('komisi1hidden'),
			'intkomisi20' => $this->input->post('komisi2hidden'),
			'intkomisi15' => $this->input->post('komisi15hidden'),
			'intpv' => $this->input->post('intpv'),
			'intvoucher' => $this->input->post('intvoucher'),
			'is_dp' => $this->input->post('is_dp'),
			'is_lg' => $is_lg,
			'inttrade_in' => $this->input->post('komisitrade'),
			'is_asi' => $is_asi,
			'nokk' => $this->input->post('nokk'), 
			'intkomisi_asi' => $komisiasi,
			'is_arisan' => $this->input->post('is_arisan') ,
			'halaman' => $hal
		);
        $this->db->insert('nota', $data);
		$intid_nota =$this->db->insert_id();
		return $intid_nota;
	}
	
	function selectMini2030($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				'0' AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promomini p,
				harga h,
				barang b
			WHERE
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	/**
	*	@param update_cicilan_keluar_barang
	*/
	function update_cicilan_keluar_barang($id, $cicilan,$no_nota){
        $data = array(
            'keluar_barang' => $no_nota,
			);

	   $this->db->where('intid_arisan', $id);
       $this->db->update('arisan',$data);
    }
	
	function selectBarangHebohMetal($keyword, $jbarang,$intid_cabang=0){
		$req = 0;
		if ($jbarang == "1") { $req = 2; }
		else if ($jbarang == "2") { $req = 1; }
        $query = $this->db->query("
			SELECT
				upper(b.strnama) AS strnama,
				p.intid_barang_free AS status_free,
				h.intid_harga,
				h.intharga_jawa,
				h.intharga_luarjawa,
				h.intharga_kualalumpur,
				h.intharga_luarkualalumpur,
				h.intpv_jawa,
				h.intpv_luarjawa,
				h.intpv_kualalumpur,
				h.intpv_luarkualalumpur,
				h.intid_barang,
				h.intum_jawa,
				h.intcicilan_jawa,
				h.intum_luarjawa,
				h.intcicilan_luarjawa
			FROM
				promotanggal p,
				harga h,
				barang b
			WHERE
			CURDATE() BETWEEN p.tanggal_mulai and p.tanggal_berakhir and
			p.intid_barang = b.intid_barang
			AND p.intid_barang = h.intid_barang
			AND b.strnama LIKE '$keyword%'
			and (p.intid_cabang = 0 or p.intid_cabang = ".$intid_cabang.")
			AND p.status_pencarian = 'heboh'
			AND b.intid_jbarang != '$req'
		");
        return $query->result();
	}
	function selectCabangBsStok($keyword){
         $query = $this->db->query("select a.intid_cabang, upper(a.strnama_cabang) strnama_cabang, stok_barang.as_of_date tanggal_stok 
from cabang a left join (select * from stok_barang group by intid_cabang) stok_barang on a.intid_cabang = stok_barang.intid_cabang where a.strnama_cabang like '$keyword%'");
        return $query->result();
	}
	/* 
	ikhlas firlana 
	2014 12 02
	*/
	function get_agogotahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
      	 	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 21
		and a.is_dp = 0
		order by a.intno_nota asc");
        
         }else
         {
      		 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
		from nota_2014 a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 21
		and a.is_dp = 0
		order by a.intno_nota asc");
        	
         }
         return $query->result();
     }
	 function get_agogo_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
			$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 21
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 21
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }
      	return $query->result();
     }
	 /* 
	ikhlas firlana 
	2014 12 02
	*/
	function get_hoki75tahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 28
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
		  	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 28
			and a.is_dp = 0
			order by a.intno_nota asc");
         }
        return $query->result();
     }
	 function get_hoki75_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
			$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 28
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 28
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	 //
	  /* 
	ikhlas firlana 
	2014 12 02
	*/
	function get_hoki150tahun($kode, $bulan,$tahun) {
         $thn = $tahun;
	    if($tahun > 2014)
	    {
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 29
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 29
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
	 function get_hoki150_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 29
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}else
      	{
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 29
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");	
      	}
        return $query->result();
     }
	 //
	 function get_serbutahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 22
		and a.is_dp = 0
		order by a.intno_nota asc");
		}else
		{
	 	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
		from nota_2014 a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 22
		and a.is_dp = 0
		order by a.intno_nota asc");		
		}
        return $query->result();
     }
	 function get_serbu_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 22
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 22
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	 function get_cepek_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
        	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 23
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 23
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	
	 function get_cepektahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 23
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 23
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
	 
	 //surprise
	 function get_surprise_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 25
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      		$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 25
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");	
        }
        return $query->result();
     }
	
	 function get_surprisetahun($kode, $bulan,$tahun) {
        /*  $thn = $tahun;
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_bayar
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 25
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result(); */
		$thn = $tahun;
		if($tahun > 2014)
		{
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.inttotal_bayar, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 25
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{
	      	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.inttotal_bayar, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 25
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
	 
	 //waffle
	 function get_waffle_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota
				where intid_jpenjualan = 27
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 27
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	
	 function get_waffletahun($kode, $bulan,$tahun) {
        /*  $thn = $tahun;
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_bayar
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 27
		and a.is_dp = 0
		order by a.intno_nota asc");
        return $query->result(); */
		$thn = $tahun;
		if($tahun > 2014)
		{
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 27
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}else
      	{
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, '0' as inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 27
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
	 
	 
	 function get_challSCtahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 26
			and a.is_dp = 0
			order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 26
			and a.is_dp = 0
			order by a.intno_nota asc");
      	}
        return $query->result();
     }
     /*
	 * @see get_RedWhitetahun, get_RedWhite_dealertahun
     */
	 function get_RedWhitetahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         {
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset,a.inttotal_bayar, a.otherKom
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 30
		and a.is_dp = 0
		order by a.intno_nota asc");
         }else
         {
      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset,a.inttotal_bayar, a.otherKom
		from nota_2014 a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 30
		and a.is_dp = 0
		order by a.intno_nota asc");
         }
        return $query->result();
     }
	 function get_RedWhite_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 30
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}else
      	{
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 30
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
     // end Red White
	  /*
	 * @see get_avengertahun, get_avenger_dealertahun
     */
	 function get_avengertahun($kode, $bulan,$tahun) {
         $thn = $tahun;
         if($tahun > 2014)
         { 
         	$query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset,a.inttotal_bayar, a.otherKom
		from nota a
		where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
		and YEAR(a.datetgl)='$thn'
		and a.intid_cabang = $kode
		and a.intid_jpenjualan = 31
		and a.is_dp = 0
		order by a.intno_nota asc");
         }else
         {
	      	 $query = $this->db->query("select DISTINCT(a.intno_nota) intno_nota, a.inttotal_omset,a.inttotal_bayar, a.otherKom
			from nota_2014 a
			where a.intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
			and YEAR(a.datetgl)='$thn'
			and a.intid_cabang = $kode
			and a.intid_jpenjualan = 31
			and a.is_dp = 0
			order by a.intno_nota asc");
		}      	 
        return $query->result();
     }
	 function get_avenger_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 31
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
        }else
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 31
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      }
        return $query->result();
     }
     // end Red White
	 function get_challSC_dealertahun($kode, $bulan,$tahun) {
        $thn = $tahun;
        if($tahun > 2014)
        {
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota 
				where intid_jpenjualan = 26
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
      	else
      	{
      	$query = $this->db->query("select sum(inttotal_bayar) netDealer
				from nota_2014 
				where intid_jpenjualan = 26
				and intid_week in (select intid_week from week where intbulan = '$bulan' and inttahun = '$thn')
				and YEAR(datetgl)='$thn'
				and intid_cabang = $kode
				AND is_dp = 0");
      	}
        return $query->result();
     }
	 
	//
	function selectMemberNotGraduate($keyword, $unit){
		$query = $this->db->query("select 
									   strnama_dealer, 
									   strkode_dealer, 
									   intlevel_dealer, 
									   strnama_upline, 
									   strkode_upline
                                from
									calon_manager, member									
								where 
									calon_manager.strkode_dealer = member.strkode_dealer
									and member.strnama_dealer like '$keyword%' 
									and calon_manager.intid_unit = $unit
                                    and calon_manager.is_graduate  IN (1,0) )");
        return $query->result();
	}
	// end. selecUplineCalonNotGraduate
	function selectJumlahNama($keyword){
        $query = $this->db->query("select count(*) total, strnama_dealer 
																		from member where strnama_dealer like '$keyword%'");
        return $query->result();
	}
	/**
	*/
	function getBonusStarterkit()
	{
		$select = "select barang.* from barang where barang.strnama like 'splash bottle%' and  barang.strnama NOT like '%fun%' and  barang.strnama NOT like '%bubble%' and barang.status_barang = 1 and CURDATE() BETWEEN '2015-05-05' and '2015-05-01'";
		return $this->db->query($select);
	}
	// end getBonusStarterkit
}
?>
