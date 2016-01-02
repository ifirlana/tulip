<?php
class Laporan_model extends CI_Model{
    public static $RET_MENU,$CHILD,$PARENT;
	
	function   __construct() {
        parent::__construct();

       }
	private $tbl = 'nota';
	function get_GroupbyAllCabang($cabang, $tgl,$intid_jpenjualan)
	{
		
		$select = "select 
					Z.strnama_cabang,
					sum(Z.totalcash) totalcash,
					sum(Z.intcash) 	intcash,
					sum(Z.intkkredit)	intkkredit,
					sum(Z.intdebit)	intdebit,
					sum(Z.intdp)		intdp,
					sum(Z.inttotal_bayar)	inttotal_bayar,
					sum(Z.inttotal_omset)	inttotal_omset,
					sum(Z.sk)			sk,
					sum(Z.lg)			lg,
					sum(Z.ll)			ll,
					Z.tgl,
					Z.is_dp,
					Z.strnama_jpenjualan
					from 
					(".$this->get_CetakPenjualanHarian($cabang,$tgl,true).") Z
					WHERE
					Z.intid_jpenjualan = $intid_jpenjualan
					group by Z.strnama_cabang, Z.strnama_jpenjualan";
		return $this->db->query($select);
		//return $select;
	}
	function get_GroupbyAllCabangUndangan($cabang, $tgl,$intid_jpenjualan)
	{
		
		$select = "select 
					Z.strnama_cabang,
					sum(Z.totalcash) totalcash,
					sum(Z.intcash) 	intcash,
					sum(Z.intkkredit)	intkkredit,
					sum(Z.intdebit)	intdebit,
					sum(Z.intdp)		intdp,
					sum(Z.inttotal_bayar)	inttotal_bayar,
					sum(Z.inttotal_omset)	inttotal_omset,
					sum(Z.sk)			sk,
					sum(Z.lg)			lg,
					sum(Z.ll)			ll,
					Z.tgl,
					Z.is_dp,
					Z.strnama_jpenjualan
					from 
					(".$this->get_CetakPenjualanHarianUndangan($cabang,$tgl,true).") Z
					WHERE
					Z.intid_jpenjualan = $intid_jpenjualan
					group by Z.strnama_cabang, Z.strnama_jpenjualan";
		return $this->db->query($select);
		//return $select;
	}
	function get_GroupUndanganbyAllCabang($cabang, $tgl)
	{
		
		$select = "select '' as intno_nota,
					(select strnama_unit from unit where unit.intid_unit = Y.intid_unit) strnama_unit,		
					0 as is_dp,		
					0 as inttotal_omset,		
					0 as sk,		
					0 as lg,		
					0 as ll,		
					0 as intdp,		
					sum(Y.undangan_nota_detail) inttotal_bayar,	
					sum(Y.undangan_nota_detail) totalcash,		
					0 as intkkredit,	
					0 as intdebit,		
					sum(Y.undangan_nota_detail + Y.undangan_nota) as intcash,		
					'undangan' as strnama_jpenjualan,		
					Y.*		
		from (".$this->getUndanganTotalDay($tgl, $cabang, true).") Y where Y.undangan_nota_detail != 0";
		return $this->db->query($select);
	}
	function get_CetakPenjualanHarian($cabang, $tgl, $string = false)
	{
		$select = "select 
			distinct(a.intno_nota), 
			upper(b.strnama_dealer) strnama_dealer, 
			b.strnama_upline, 
			upper(d.strnama_unit) strnama_unit, 
			upper(c.strnama_cabang) strnama_cabang, 
			a.inttotal_omset, 
			(select intcash from nota 
				where nota.datetgl = '$tgl'
					and nota.intid_cabang = $cabang
					and nota.intdp = 0 and nota.intid_nota = a.intid_nota
					) totalcash, 
					a.intcash, 
					a.intkkredit, 
					a.intdebit, 
					a.intdp, 
					a.inttotal_bayar, 
			(CASE WHEN f.intid_jbarang = 4 THEN a.inttotal_bayar ELSE 0 END) AS sk,
			(CASE WHEN f.intid_jbarang = 5 THEN a.inttotal_bayar ELSE 0 END) AS lg,
			(CASE WHEN a.intid_jpenjualan = 8 AND f.intid_jbarang != 5 THEN a.inttotal_bayar ELSE 0 END) AS ll, 
				a.datetgl tgl, 
				a.is_dp, 
				jenis_penjualan.strnama_jpenjualan,
				a.intid_jpenjualan
			from 
			nota a inner join cabang c on c.intid_cabang = a.intid_cabang
			inner join member b on b.intid_dealer = a.intid_dealer
			inner join unit d on d.intid_unit = b.intid_unit
			left outer join jenis_penjualan on a.intid_jpenjualan = jenis_penjualan.intid_jpenjualan, 
			nota_detail e, barang f
			where a.intid_nota = e.intid_nota
			and e.intid_barang = f.intid_barang
			and a.datetgl = '$tgl'
			and a.intid_cabang = $cabang
			and e.is_free = 0
UNION
			SELECT intno_nota, 
			strnama_dealer, 
			strnama_upline, 
			strnama_unit, 
			strnama_cabang, 
			'0' AS inttotal_omset, 
			'0' AS totalcash, 
			'0' AS intcash, 
			'0' AS intkkredit, 
			'0' AS intdebit, 
			'0' AS intdp , 
			'0' AS inttotal_bayar, 
			'0' AS sk, 
			'0' AS lg, 
			'0' AS ll, 
			datetgl AS tgl, 
			'0' AS is_dp, 
			'Hadiah' AS strnama_jpenjualan,
			'' AS intid_jpenjualan
			FROM 
			nota_hadiah INNER JOIN cabang ON nota_hadiah.intid_cabang = cabang.intid_cabang 
			INNER JOIN member ON nota_hadiah.intid_dealer = member.intid_dealer 
			INNER JOIN unit ON nota_hadiah.intid_unit = unit.intid_unit 
			WHERE 
			datetgl = '$tgl' AND nota_hadiah.intid_cabang = $cabang
			order by  strnama_jpenjualan asc";
		if($string == false)
		{
			$query = $this->db->query($select);
			return $query->result();
		}
		else if($string == true)
		{
			return $select;
		}
	}
	
	//@selectWeek
	//desc : digunakan untuk umum hampir disemua controller
	//
	function selectWeek() 
	{
		$query = $this->db->query("select * from week group by intid_week");
	    return $query->result();
	}
	//ending
	
	//ini untuk cabang khusus aja ----start-----
	function selectJPenjualanAll(){
       
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan order by intid_jpenjualan asc");
	   return $query->result();
	   }
	   //----end--------
	
	function selectJPenjualan(){
       
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where is_active = 1 order by intid_jpenjualan asc");
	   return $query->result();
	   }
	function get_CetakPenjualanMingguan($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("SELECT strnama_dealer, 
		strnama_upline, 
		strnama_cabang, strnama_unit, dateend, datestart, intid_week, intkomisi10, intkomisi20, intpv, inttotal_bayar,
		inttotal_omset, strnama_jpenjualan, 
		intid_jpenjualan, 
		IF(omsett >= v, omsett - v, IF(omsetm < omsett AND omsettc < omsett AND omsett < v, 0, omsett)) AS omsett,
		IF(omsett < v AND omsettc < v, omsetm - v, IF(omsett < omsetm AND omsettc < omsetm AND omsetm < v, 0, omsetm)) AS omsetm,
		IF(omsett < v AND omsettc >= v, omsettc - v, IF(omsett < omsettc AND omsetm < omsettc AND omsettc < v, 0, omsettc)) AS omsettc, 
		omsetlg, 
		omsetll,
		tradein_t,
		tradein_m 
		FROM 
			(SELECT strnama_dealer, strnama_upline, UPPER(strnama_cabang) AS strnama_cabang, 
				strnama_unit,
				(SELECT date_format(dateweek_end, '%d %M %Y') AS dateweek_end FROM week WHERE intid_week = $week) AS dateend,
				(SELECT date_format(dateweek_start, '%d %M %Y') AS dateweek_start FROM week WHERE intid_week = $week) AS datestart,
				z.* 
				FROM 
					(SELECT intid_week, 
						intid_cabang,
						a.intid_dealer, 
						intno_nota, 
						SUM(intkomisi10) AS intkomisi10, 
						SUM(intkomisi20) AS intkomisi20, 
						SUM(intpv) AS intpv, 
						SUM(inttotal_bayar) AS inttotal_bayar, 
						SUM(inttotal_omset) AS inttotal_omset, 
						UPPER(strnama_jpenjualan) AS strnama_jpenjualan, 
						a.intid_jpenjualan FROM nota a INNER JOIN jenis_penjualan ON jenis_penjualan.intid_jpenjualan = a.intid_jpenjualan 
					WHERE a.intid_week = $week AND a.intid_cabang = $cabang 
						AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer) 
					AS z 
INNER JOIN member ON z.intid_dealer = member.intid_dealer INNER JOIN cabang ON z.intid_cabang = cabang.intid_cabang INNER JOIN unit ON member.intid_unit = unit.intid_unit INNER JOIN week ON z.intid_week = week.intid_week) AS x
INNER JOIN
(SELECT intid_dealer, 
SUM(omsett) AS omsett, 
SUM(omsetm) AS omsetm, 
SUM(omsettc) AS omsettc, 
SUM(omsetlg) AS omsetlg, 
SUM(omsetll) AS omsetll FROM (SELECT intid_dealer, 
	IF(intid_jbarang = 1, totalharga, 0) AS omsett, 
	IF(intid_jbarang = 2, totalharga, 0) AS omsetm, 
	IF(intid_jbarang = 3, totalharga, 0) AS omsettc, 
	IF(intid_jbarang = 5, totalharga, 0) AS omsetlg, 
	IF(intid_jbarang = 6, totalharga, 0) AS omsetll FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intid_dealer, intid_jbarang) AS y) AS z GROUP BY intid_dealer) AS y
ON x.intid_dealer = y.intid_dealer
INNER JOIN
(SELECT intid_dealer, SUM(intvoucher) AS v FROM nota a WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer) AS z
ON x.intid_dealer = z.intid_dealer

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
ON z.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
");
        return $query->result();
	}
	/*
		
		ikhlas firlana ifirlana@gmail.com
		5 jan 2014
	*/
	function get_CetakPenjualanMingguan_tahun($week, $cabang, $jpenjualan,$tahun)
	{
		$query = $this->db->query("SELECT strnama_dealer, 
		strnama_upline, 
		strnama_cabang, strnama_unit, dateend, datestart, intid_week, intkomisi10, intkomisi15, intkomisi20, intpv, inttotal_bayar,
		inttotal_omset, strnama_jpenjualan, 
		intid_jpenjualan, 
		IF(omsett >= v, omsett - v, IF(omsetm < omsett AND omsettc < omsett AND omsett < v, 0, omsett)) AS omsett,
		IF(omsett < v AND omsettc < v, omsetm - v, IF(omsett < omsetm AND omsettc < omsetm AND omsetm < v, 0, omsetm)) AS omsetm,
		IF(omsett < v AND omsettc >= v, omsettc - v, IF(omsett < omsettc AND omsetm < omsettc AND omsettc < v, 0, omsettc)) AS omsettc, 
		omsetlg, 
		omsetll,
		tradein_t,
		tradein_m 
		FROM 
			(SELECT strnama_dealer, strnama_upline, UPPER(strnama_cabang) AS strnama_cabang, 
				strnama_unit,
				(SELECT date_format(dateweek_end, '%d %M %Y') AS dateweek_end FROM week WHERE intid_week = $week and inttahun = $tahun) AS dateend,
				(SELECT date_format(dateweek_start, '%d %M %Y') AS dateweek_start FROM week WHERE intid_week = $week and inttahun = $tahun) AS datestart,
				z.* 
				FROM 
					(SELECT intid_week, 
						intid_cabang,
						a.intid_dealer, 
						intno_nota, 
						SUM(intkomisi10) AS intkomisi10, 
						SUM(intkomisi10) AS intkomisi15, 
						SUM(intkomisi20) AS intkomisi20, 
						SUM(intpv) AS intpv, 
						SUM(inttotal_bayar) AS inttotal_bayar, 
						SUM(inttotal_omset) AS inttotal_omset, 
						UPPER(strnama_jpenjualan) AS strnama_jpenjualan, 
						a.intid_jpenjualan FROM nota a INNER JOIN jenis_penjualan ON jenis_penjualan.intid_jpenjualan = a.intid_jpenjualan 
					WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND year(a.datetgl) = $tahun 
						AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer
					) 
					AS z 
INNER JOIN member ON z.intid_dealer = member.intid_dealer INNER JOIN cabang ON z.intid_cabang = cabang.intid_cabang INNER JOIN unit ON member.intid_unit = unit.intid_unit INNER JOIN week ON z.intid_week = week.intid_week) AS x
INNER JOIN
(SELECT intid_dealer, 
SUM(omsett) AS omsett, 
SUM(omsetm) AS omsetm, 
SUM(omsettc) AS omsettc, 
SUM(omsetlg) AS omsetlg, 
SUM(omsetll) AS omsetll FROM (SELECT intid_dealer, 
	IF(intid_jbarang = 1, totalharga, 0) AS omsett, 
	IF(intid_jbarang = 2, totalharga, 0) AS omsetm, 
	IF(intid_jbarang = 3, totalharga, 0) AS omsettc, 
	IF(intid_jbarang = 5, totalharga, 0) AS omsetlg, 
	IF(intid_jbarang = 6, totalharga, 0) AS omsetll FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intid_dealer, intid_jbarang) AS y) AS z GROUP BY intid_dealer) AS y
ON x.intid_dealer = y.intid_dealer
INNER JOIN
(SELECT intid_dealer, SUM(intvoucher) AS v FROM nota a WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer) AS z
ON x.intid_dealer = z.intid_dealer

LEFT JOIN
(SELECT jbarangt.intid_dealer, jbarangt.hasil AS tradein_t, jbarangm.hasil AS tradein_m FROM 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week = $week AND YEAR(datetgl) = $tahun AND intid_jpenjualan = $jpenjualan
			GROUP BY intid_dealer, intid_jbarang,intid_cabang) AS asd 
	WHERE intid_jbarang = 1) AS jbarangt 
INNER JOIN 
	(SELECT * FROM 
		(SELECT intid_dealer, barang.intid_jbarang, SUM(intharga * intquantity * (1 - (inttrade_in * 0.01))) AS hasil, intid_cabang 
		FROM `nota` INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota 
		INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang 
		WHERE intid_week = $week AND YEAR(datetgl) = $tahun AND intid_jpenjualan = $jpenjualan 
		GROUP BY intid_dealer, intid_jbarang) AS asd 
	WHERE intid_jbarang = 2) AS jbarangm 
ON jbarangt.intid_dealer = jbarangm.intid_dealer
where jbarangt.intid_cabang = $cabang
	) AS kodebwtmisahinomsettulipdenganmetal
ON z.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer


");
        return $query->result();
	}
	//end
	/*
	//2012 12 23
	function get_CetakPenjualanMingguan($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select x.strnama_dealer, x.strnama_upline, upper(x.strnama_cabang) strnama_cabang, x.strnama_unit, x.dateend, x.datestart, x.intid_week, x.intkomisi10, x.intkomisi20, x.intpv, x.inttotal_bayar,
		x.inttotal_omset, upper(x.strnama_jpenjualan) strnama_jpenjualan, 
		IF(y.omsett >= y.v, y.omsett - y.v, IF(y.omsetm < y.omsett AND y.omsettc < y.omsett AND y.omsett < y.v, 0, y.omsett)) AS omsett,
		IF(y.omsett < y.v AND y.omsettc < y.v, y.omsetm - y.v, IF(y.omsett < y.omsetm AND y.omsettc < y.omsetm AND y.omsetm < y.v, 0, y.omsetm)) AS omsetm,
		IF(y.omsett < y.v AND y.omsettc >= y.v, y.omsettc - y.v, IF(y.omsett < y.omsettc AND y.omsetm < y.omsettc AND y.omsettc < y.v, 0, y.omsettc)) AS omsettc,
		IF(y.omsett < y.v AND y.omsettc < y.v AND y.omsetm < y.v AND y.omsetlg >= y.omsetll, IF(y.omsetlg < y.v, 0, y.omsetlg - y.v), y.omsetlg) AS omsetlg,
		IF(y.omsett < y.v AND y.omsettc < y.v AND y.omsetm < y.v AND y.omsetlg < y.omsetll, IF(y.omsetll < y.v, 0, y.omsetll - y.v), y.omsetll) AS omsetll
		from (select b.intid_dealer,a.intno_nota, sum(a.inttotal_omset) inttotal_omset, b.strnama_dealer, b.strnama_upline,  sum(a.intkomisi10) intkomisi10, sum(a.intkomisi20) intkomisi20, 
		sum(a.intpv) intpv, sum(a.inttotal_bayar) inttotal_bayar, a.intid_week,e.strnama_jpenjualan,
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend,
		c.strnama_unit, d.strnama_cabang  
		from nota a, member b, unit c, cabang d, jenis_penjualan e
		where a.intid_dealer = b.intid_dealer 
		and a.intid_cabang = d.intid_cabang
		and a.intid_unit = c.intid_unit
		and a.intid_jpenjualan = e.intid_jpenjualan
		and a.is_dp = 0
		and a.intid_week = $week
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = $jpenjualan
		group by b.intid_dealer
		order by a.intno_nota asc ) x, (select a.intid_dealer, 
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=1
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsett,
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=2
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsetm,
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=3
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsettc,
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and nota.is_arisan = 0
and barang.intid_jbarang=5
and nota.intid_dealer = a.intid_dealer) as omsetlg,
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=6
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsetll,
(SELECT SUM(intvoucher) AS v 
FROM nota 
WHERE nota.intid_week = $week 
AND nota.intid_cabang = $cabang 
AND nota.intid_jpenjualan = $jpenjualan 
AND nota.is_arisan = 0 AND nota.is_dp = 0 
AND nota.intid_dealer = a.intid_dealer) AS v
from nota a, nota_detail b, barang c
where a.intid_nota = b.intid_nota
and b.intid_barang = c.intid_barang
and a.intid_week = $week
and a.intid_cabang = $cabang
and a.intid_jpenjualan = $jpenjualan
and b.is_free = 0
and a.is_arisan = 0
group by a.intid_dealer)y,
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
	where x.intid_dealer = y.intid_dealer
	AND kodebwtmisahinomsettulipdenganmetal.intid_dealer = x.intid_dealer");
        return $query->result();
	}
	/*
	// 2013 03 18
	function get_CetakPenjualanMingguan($week, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select x.strnama_dealer, x.strnama_upline, upper(x.strnama_cabang) strnama_cabang, x.strnama_unit, x.dateend, x.datestart, x.intid_week, x.intkomisi10, x.intkomisi20, x.intpv, x.inttotal_bayar,
		x.inttotal_omset, upper(x.strnama_jpenjualan) strnama_jpenjualan, x.intid_jpenjualan, y.omsett, y.omsetm, y.omsettc, y.omsetlg, y.omsetll
		from (select b.intid_dealer,a.intno_nota, (select sum(inttotal_omset) 
		from nota 
		where intid_week = $week
		and intid_cabang = $cabang
		and intid_jpenjualan = $jpenjualan
		and is_arisan = 0
		and is_dp = 0 and intid_dealer = a.intid_dealer) inttotal_omset, b.strnama_dealer, b.strnama_upline,  (select sum(intkomisi10) 
		from nota 
		where intid_week = $week
		and intid_cabang = $cabang
		and intid_jpenjualan = $jpenjualan
		and is_arisan = 0
		and is_dp = 0 and intid_dealer = a.intid_dealer) intkomisi10, (select sum(intkomisi20) 
		from nota 
		where intid_week = $week
		and intid_cabang = $cabang
		and intid_jpenjualan = $jpenjualan
		and is_arisan = 0
		and is_dp = 0 and intid_dealer = a.intid_dealer) intkomisi20, 
		(select sum(intpv) 
		from nota 
		where intid_week = $week
		and intid_cabang = $cabang
		and intid_jpenjualan = $jpenjualan
		and is_arisan = 0
		and is_dp = 0 and intid_dealer = a.intid_dealer) intpv, (select sum(inttotal_bayar) 
		from nota 
		where intid_week = $week
		and intid_cabang = $cabang
		and intid_jpenjualan = $jpenjualan
		and is_arisan = 0
		and is_dp = 0 and intid_dealer = a.intid_dealer) inttotal_bayar, a.intid_week,e.strnama_jpenjualan, e.intid_jpenjualan, 
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend,
		c.strnama_unit, d.strnama_cabang  
		from nota a, member b, unit c, cabang d, jenis_penjualan e
		where a.intid_dealer = b.intid_dealer 
		and a.intid_cabang = d.intid_cabang
		and b.intid_unit = c.intid_unit
		and a.intid_jpenjualan = e.intid_jpenjualan
		and a.is_dp = 0
		and a.intid_week = $week
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = $jpenjualan
		group by b.intid_dealer
		order by a.intno_nota asc ) x, (select a.intid_dealer, 
(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
from nota
where intid_week = $week
and intid_cabang = $cabang
and intid_jpenjualan = $jpenjualan
and is_arisan = 0
and intid_dealer = a.intid_dealer) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=1
and nota.is_arisan = 0
and nota.is_dp = 0
and nota.intid_dealer = a.intid_dealer) as omsett,
(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
from nota
where intid_week = $week
and intid_cabang = $cabang
and intid_jpenjualan = $jpenjualan
and is_arisan = 0
and intid_dealer = a.intid_dealer) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=2
and nota.is_arisan = 0
and nota.is_dp = 0
and nota.intid_dealer = a.intid_dealer) as omsetm,
(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
from nota
where intid_week = $week
and intid_cabang = $cabang
and intid_jpenjualan = $jpenjualan
and is_arisan = 0
and intid_dealer = a.intid_dealer) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=3
and nota.is_arisan = 0
and nota.is_dp = 0
and nota.intid_dealer = a.intid_dealer) as omsettc,
(select sum(nota_detail.intquantity*nota_detail.intharga)
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and nota.is_arisan = 0
and nota.is_dp = 0
and barang.intid_jbarang=5
and nota.intid_dealer = a.intid_dealer) as omsetlg,
(select sum(nota_detail.intquantity*nota_detail.intharga)
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=6
and nota.is_arisan = 0
and nota.is_dp = 0
and nota.intid_dealer = a.intid_dealer) as omsetll
from nota a, nota_detail b, barang c
where a.intid_nota = b.intid_nota
and b.intid_barang = c.intid_barang
and a.intid_week = $week
and a.intid_cabang = $cabang
and a.intid_jpenjualan = $jpenjualan
and b.is_free = 0
and a.is_arisan = 0
and a.is_dp = 0
group by a.intid_dealer)y
where x.intid_dealer = y.intid_dealer");
        return $query->result();
	} */
	function get_CetakPenjualanSKMingguan($week, $cabang)
	{
		$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
		f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah, sum(a.inttotal_bayar)inttotal_bayar 
		from nota a inner join cabang c on c.intid_cabang = a.intid_cabang
		inner join member b on b.intid_dealer = a.intid_dealer
		inner join unit d on d.intid_unit = b.intid_unit,
		nota_detail e, barang f, jenis_barang g, harga h
		where a.intid_nota = e.intid_nota
		and e.intid_barang = f.intid_barang
		and f.intid_jbarang = g.intid_jbarang
		and f.intid_barang = h.intid_barang
		and a.intid_week = $week
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = 10
		and e.is_free = 0
		group by a.datetgl, a.intno_nota, b.strnama_dealer, b.strnama_upline, d.strnama_unit,
		d.strnama_unit, a.intid_week, f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah
		order by d.strnama_unit asc, b.strnama_upline asc");
        return $query->result();
	}
	/*get_CetakPenjualanSKMingguan_tahun
		ikhlas firlana 
		2 jan 2014
		desc : laporan ditambahkan tahun untuk data yang konkret.
		kekurangan : kurangnya tahun di tabel nota untuk data yang lebih konkret
	*/
	function get_CetakPenjualanSKMingguan_tahun($week, $cabang,$tahun)
	{
		/** 
		// yang lama 2014 08 22
		$select = "select 
			a.datetgl, 
			a.intno_nota, 
			upper(b.strnama_dealer) strnama_dealer, 
			upper(b.strnama_upline) strnama_upline, 
			upper(d.strnama_unit)strnama_unit,
			upper(c.strnama_cabang) strnama_cabang, 
			a.intid_week,  
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun=$tahun) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun=$tahun) AS dateend, 
			f.strnama, 
			e.intquantity, 
			h.intharga_jawa, 
			h.intharga_luarjawa, 
			c.intid_wilayah, 
			sum(a.inttotal_bayar)inttotal_bayar 
		from 
			nota a inner join cabang c on c.intid_cabang = a.intid_cabang
			inner join member b on b.intid_dealer = a.intid_dealer
			inner join unit d on d.intid_unit = b.intid_unit,
			nota_detail e, barang f, jenis_barang g, harga h
		where 
			a.intid_nota = e.intid_nota
			and e.intid_barang = f.intid_barang
			and f.intid_jbarang = g.intid_jbarang
			and f.intid_barang = h.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and YEAR(a.datetgl)= $tahun
			and a.intid_jpenjualan = 10
			and e.is_free = 0
		group by a.datetgl, a.intno_nota, b.strnama_dealer, b.strnama_upline, d.strnama_unit,
		d.strnama_unit, a.intid_week, f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah
		order by d.strnama_unit asc, b.strnama_upline asc";
		*/		
		/* $select = "select 
			a.datetgl, 
			a.intno_nota, 
			upper(b.strnama_dealer) strnama_dealer, 
			upper(b.strnama_upline) strnama_upline, 
			upper(d.strnama_unit)strnama_unit,
			upper(c.strnama_cabang) strnama_cabang, 
			a.intid_week,  
		(select dateweek_start  from week where intid_week = $week and inttahun=$tahun) AS datestart,
		(select dateweek_end from week where intid_week = $week and inttahun=$tahun) AS dateend, 
			f.strnama, 
			e.intquantity,  
			c.intid_wilayah, 
			sum(a.inttotal_bayar)inttotal_bayar,
			h.intharga_jawa, 
			h.intharga_luarjawa 			
		from 
			nota a,
			cabang c,
			member b, 
			unit d,
			nota_detail e, 
			barang f,
			(select * from harga) h
		where  
			a.intid_cabang = c.intid_cabang
			and a.intid_dealer = b.intid_dealer
			and b.intid_unit = d.intid_unit
			and a.intid_nota = e.intid_nota
			and e.intid_barang = f.intid_barang
			and f.intid_barang = h.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and YEAR(a.datetgl)= $tahun
			and a.intid_jpenjualan = 10
			and e.is_free = 0
		group by a.intno_nota 		
		order by d.strnama_unit asc, b.strnama_upline asc"; */
		$select = "
				SELECT
			nota.datetgl,
			nota.intno_nota,
					upper(member.strnama_dealer) strnama_dealer, 
					upper(member.strnama_upline) strnama_upline, 
					upper(unit.strnama_unit)strnama_unit,
					upper(cabang.strnama_cabang) strnama_cabang, 
		nota.intid_week,
				(select dateweek_start  from week where intid_week = $week and inttahun=$tahun) AS datestart,
				(select dateweek_end from week where intid_week = $week and inttahun=$tahun) AS dateend, 
		barang.strnama, 
					nota_detail.intquantity,  
					cabang.intid_wilayah, 
					sum(nota.inttotal_bayar)inttotal_bayar,
					harga.intharga_jawa, 
					harga.intharga_luarjawa, 
					harga.intharga_luarkualalumpur
		FROM
			nota
		LEFT JOIN nota_detail ON nota_detail.intid_nota = nota.intid_nota
		LEFT JOIN barang ON barang.intid_barang = nota_detail.intid_barang
		LEFT JOIN unit on unit.intid_unit = nota.intid_unit 
		LEFT JOIN member on member.intid_dealer = nota.intid_dealer
		LEFT JOIN cabang on cabang.intid_cabang = nota.intid_cabang
		LEFT JOIN harga ON harga.intid_barang = nota_detail.intid_barang
		WHERE
		nota.intid_week = $week
		AND year(nota.datetgl) = $tahun
		and nota.intid_cabang = $cabang
		and nota_detail.is_free = 0
		and nota.intid_jpenjualan = 10
		GROUP BY nota.intno_nota
		ORDER BY unit.strnama_unit asc, member.strnama_upline asc
		";
		
		$query = $this->db->query($select);
        return $query->result();
	}
	function get_CetakPenjualanArisanMingguan($week, $cabang)
	{
		
		$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
		c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, 
		(select sum(inttotal_omset) from nota where nota.intid_week = $week and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as inttotal_omset, 
		a.intid_jpenjualan, (select sum(intpv) from nota where nota.intid_week = $week and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota)as intpv, 
		sum(e.intquantity)intquantity, (select sum(inttotal_bayar) from nota where nota.intid_week = $week and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) inttotal_bayar,	
		(h.intcicilan_jawa*(sum(e.intquantity))*1) as cicilan, 
		(select sum(intkomisi10) from nota where nota.intid_week = $week and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi10, 
		(select sum(intkomisi20) from nota where nota.intid_week = $week and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi20,
		(select sum(nota_detail.intharga*nota_detail.intquantity) from nota_detail where nota_detail.intid_nota = a.intid_nota) retail
		from nota a, member b, cabang c, unit d, nota_detail e, 
		barang f, harga h
		where a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and e.is_free = 0
		and a.intid_week = $week
		and a.intid_dealer = b.intid_dealer
		and a.intid_cabang = $cabang
		and a.intid_nota = e.intid_nota
		and a.intid_cabang = c.intid_cabang
		and a.intid_unit = d.intid_unit
		and e.intid_barang = f.intid_barang
		and f.intid_barang = h.intid_barang
		group by a.intid_nota
		order by d.strnama_unit asc, b.strnama_upline asc");
		return $query->result();

			
	}
	/*get_CetakPenjualanArisanMingguan_tahun
		ikhlas firlana 
		2 jan 2014
		desc : laporan ditambahkan tahun untuk data yang konkret.
		kekurangan : kurangnya tahun di tabel nota untuk data yang lebih konkret
	*/
	function get_CetakPenjualanArisanMingguan_tahun($week, $cabang,$tahun)
	{
		$select	= "select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, 
		c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, 
		(select sum(inttotal_omset) from nota where nota.intid_week = $week and YEAR(nota.datetgl) = $tahun and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as inttotal_omset, 
		a.intid_jpenjualan, (select sum(intpv) from nota where nota.intid_week = $week and YEAR(nota.datetgl) = $tahun and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota)as intpv, 
		sum(e.intquantity)intquantity, (select sum(inttotal_bayar) from nota where nota.intid_week = $week and YEAR(nota.datetgl) = $tahun and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) inttotal_bayar,	
		(h.intcicilan_jawa*(sum(e.intquantity))*1) as cicilan, 
		(select sum(intkomisi10) from nota where nota.intid_week = $week and YEAR(nota.datetgl) = $tahun and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi10, 
		(select sum(intkomisi20) from nota where nota.intid_week = $week and YEAR(nota.datetgl) = $tahun and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi20,
		(select sum(nota_detail.intharga*nota_detail.intquantity) from nota_detail where nota_detail.intid_nota = a.intid_nota) retail
		from #nota a, member b, cabang c, unit d, nota_detail e, 	barang f, harga h
		nota a LEFT JOIN
		member b ON a.intid_dealer = b.intid_dealer
		left JOIN cabang c ON a.intid_cabang = c.intid_cabang
		LEFT JOIN unit d on a.intid_unit = d.intid_unit
		LEFT JOIN nota_detail e on a.intid_nota = e.intid_nota
		LEFT JOIN barang f ON e.intid_barang = f.intid_barang
		LEFT JOIN harga h ON f.intid_barang = h.intid_barang
		where a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and e.is_free = 0
		and a.intid_week = $week
		and YEAR(a.datetgl) = $tahun
		#and a.intid_dealer = b.intid_dealer
		and a.intid_cabang = $cabang
		#and a.intid_nota = e.intid_nota
		#and a.intid_cabang = c.intid_cabang
		#and a.intid_unit = d.intid_unit
		#and e.intid_barang = f.intid_barang
		#and f.intid_barang = h.intid_barang
		group by a.intid_nota
		order by d.strnama_unit asc, b.strnama_upline asc";
		$query = $this->db->query($select);
		return $query->result();
		//return $select; 
			
	}
	function selectJPenjualanById($id){
       
	   $query = $this->db->query("select intid_jpenjualan, upper(strnama_jpenjualan) strnama_jpenjualan from jenis_penjualan where intid_jpenjualan = $id");
	   return $query->result();
    }

	function get_CetakPenjualanBulanan($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("SELECT strnama_dealer, strnama_upline, strnama_cabang, strnama_unit, intid_week, intkomisi10, intkomisi20, intpv, inttotal_bayar, inttotal_omset, strnama_jpenjualan, intid_jpenjualan, 
		IF(omsett >= v, omsett - v, IF(omsetm < omsett AND omsettc < omsett AND omsett < v, 0, omsett)) AS omsett,
		IF(omsett < v AND omsettc < v, omsetm - v, IF(omsett < omsetm AND omsettc < omsetm AND omsetm < v, 0, omsetm)) AS omsetm,
		IF(omsett < v AND omsettc >= v, omsettc - v, IF(omsett < omsettc AND omsetm < omsettc AND omsettc < v, 0, omsettc)) AS omsettc, 
		omsetlg, omsetll FROM 
(SELECT strnama_dealer, strnama_upline, UPPER(strnama_cabang) AS strnama_cabang, strnama_unit, z.* 
FROM (SELECT intid_week, intid_cabang, a.intid_dealer, intno_nota, SUM(intkomisi10) AS intkomisi10, SUM(intkomisi20) AS intkomisi20, SUM(intpv) AS intpv, SUM(inttotal_bayar) AS inttotal_bayar, SUM(inttotal_omset) AS inttotal_omset, UPPER(strnama_jpenjualan) AS strnama_jpenjualan, a.intid_jpenjualan FROM nota a INNER JOIN jenis_penjualan ON jenis_penjualan.intid_jpenjualan = a.intid_jpenjualan WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer) AS z 
INNER JOIN member ON z.intid_dealer = member.intid_dealer INNER JOIN cabang ON z.intid_cabang = cabang.intid_cabang INNER JOIN unit ON member.intid_unit = unit.intid_unit INNER JOIN week ON z.intid_week = week.intid_week) AS x
INNER JOIN
(SELECT intid_dealer, SUM(omsett) AS omsett, SUM(omsetm) AS omsetm, SUM(omsettc) AS omsettc, SUM(omsetlg) AS omsetlg, SUM(omsetll) AS omsetll FROM (SELECT intid_dealer, IF(intid_jbarang = 1, totalharga, 0) AS omsett, IF(intid_jbarang = 2, totalharga, 0) AS omsetm, IF(intid_jbarang = 3, totalharga, 0) AS omsettc, IF(intid_jbarang = 5, totalharga, 0) AS omsetlg, IF(intid_jbarang = 6, totalharga, 0) AS omsetll FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intid_dealer, intid_jbarang) AS y) AS z GROUP BY intid_dealer) AS y
ON x.intid_dealer = y.intid_dealer
INNER JOIN
(SELECT intid_dealer, SUM(intvoucher) AS v FROM nota a WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 0 GROUP BY intid_dealer) AS z
ON x.intid_dealer = z.intid_dealer");
        return $query->result();
	}	
/*
	//2012 12 23
	function get_CetakPenjualanBulanan($month, $cabang, $jpenjualan)
	{
		$query = $this->db->query("select x.strnama_dealer, x.strnama_upline, upper(x.strnama_cabang) strnama_cabang, x.strnama_unit, x.intkomisi10, x.intkomisi20, x.intpv, x.inttotal_bayar,
		x.inttotal_omset, upper(x.strnama_jpenjualan) strnama_jpenjualan, y.omsett, y.omsetm, y.omsettc, y.omsetlg, y.omsetll
		from (select b.intid_dealer,a.intno_nota, sum(a.inttotal_omset) inttotal_omset, b.strnama_dealer, b.strnama_upline,  sum(a.intkomisi10) intkomisi10, sum(a.intkomisi20) intkomisi20, 
		sum(a.intpv) intpv, sum(a.inttotal_bayar) inttotal_bayar, a.intid_week,e.strnama_jpenjualan,
		c.strnama_unit, d.strnama_cabang  
		from nota a, member b, unit c, cabang d, jenis_penjualan e
		where a.intid_dealer = b.intid_dealer 
		and a.intid_cabang = d.intid_cabang
		and a.intid_unit = c.intid_unit
		and a.intid_jpenjualan = e.intid_jpenjualan
		and a.is_dp = 0
		and substr(a.datetgl,6,2) = '$month'
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = $jpenjualan
		group by b.intid_dealer
		order by a.intno_nota asc ) x, (select a.intid_dealer, 
(select sum(nota_detail.intquantity*nota_detail.intharga-nota.intvoucher) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and substr(nota.datetgl,6,2) = '$month'
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=1
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsett,
(select sum(nota_detail.intquantity*nota_detail.intharga-nota.intvoucher) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and substr(nota.datetgl,6,2) = '$month'
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and nota.is_arisan = 0
and barang.intid_jbarang=2
and nota.intid_dealer = a.intid_dealer) as omsetm,
(select sum(nota_detail.intquantity*nota_detail.intharga-nota.intvoucher) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and substr(nota.datetgl,6,2) = '$month'
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=3
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsettc,
(select sum(nota_detail.intquantity*nota_detail.intharga-nota.intvoucher) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and substr(nota.datetgl,6,2) = '$month'
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=5
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsetlg,
(select sum(nota_detail.intquantity*nota_detail.intharga-nota.intvoucher) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and substr(nota.datetgl,6,2) = '$month'
and nota.intid_cabang = $cabang
and nota.intid_jpenjualan = $jpenjualan
and nota_detail.is_free = 0
and barang.intid_jbarang=6
and nota.is_arisan = 0
and nota.intid_dealer = a.intid_dealer) as omsetll
		from nota a, nota_detail b, barang c
		where a.intid_nota = b.intid_nota
		and b.intid_barang = c.intid_barang
		and substr(a.datetgl,6,2) = '$month'
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = $jpenjualan
		and b.is_free = 0
		and a.is_arisan = 0
		group by a.intid_dealer)y
		where x.intid_dealer = y.intid_dealer");
        return $query->result();
	}*/
	function get_CetakPenjualanSKBulanan($month, $cabang)
	{
			$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah, sum(a.inttotal_bayar)inttotal_bayar 
		from nota a inner join cabang c on c.intid_cabang = a.intid_cabang
		inner join member b on b.intid_dealer = a.intid_dealer
		inner join unit d on d.intid_unit = b.intid_unit,
		nota_detail e, barang f, jenis_barang g, harga h
		where a.intid_nota = e.intid_nota
		and e.intid_barang = f.intid_barang
		and f.intid_jbarang = g.intid_jbarang
		and f.intid_barang = h.intid_barang
		and a.intid_week in (select intid_week from week where intbulan = '$month')
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = 10
		and e.is_free = 0
		group by a.datetgl, a.intno_nota, b.strnama_dealer, b.strnama_upline, d.strnama_unit,
		d.strnama_unit, a.intid_week, f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah
		order by d.strnama_unit asc, b.strnama_upline asc");
        return $query->result();
	}
	
	function get_CetakPenjualanSKBulanan_tahun($month, $cabang, $tahun)
	{
	
			/*query lama*/
			/*
			$select = "select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
				upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
				f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah, sum(a.inttotal_bayar)inttotal_bayar 
				from nota a inner join cabang c on c.intid_cabang = a.intid_cabang
				inner join member b on b.intid_dealer = a.intid_dealer
				inner join unit d on d.intid_unit = b.intid_unit,
				nota_detail e, barang f, jenis_barang g, harga h
				where a.intid_nota = e.intid_nota
				and e.intid_barang = f.intid_barang
				and f.intid_jbarang = g.intid_jbarang
				and f.intid_barang = h.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 10
				and e.is_free = 0
				group by a.datetgl, a.intno_nota, b.strnama_dealer, b.strnama_upline, d.strnama_unit,
				d.strnama_unit, a.intid_week, f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah
				order by d.strnama_unit asc, b.strnama_upline asc";
			*/	
			//query tahap kedua
			$select = "select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
				upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
				f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah, sum(a.inttotal_bayar)inttotal_bayar 
				from 
					nota a, 
					cabang c,
					member b,
					unit d,
					nota_detail e, 
					barang f LEFT JOIN harga h on f.intid_barang = h.intid_barang, 
					jenis_barang g
				where 
					a.intid_nota = e.intid_nota
					and a.intid_dealer = b.intid_dealer
					and a.intid_cabang = c.intid_cabang
					and b.intid_unit = d.intid_unit
					and e.intid_barang = f.intid_barang
					and f.intid_jbarang = g.intid_jbarang
					and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
					and year(a.datetgl) = '$tahun'
					and a.intid_cabang = $cabang
					and a.intid_jpenjualan = 10
					and e.is_free = 0
					group by 
						a.datetgl, 
						a.intno_nota, 
						b.strnama_dealer, 
						b.strnama_upline, 
						d.strnama_unit, 
						a.intid_week, 
						f.strnama, 
						e.intquantity, 
						h.intharga_jawa, 
						h.intharga_luarjawa, 
						c.intid_wilayah
						order by d.strnama_unit asc, b.strnama_upline asc";
				
			$query = $this->db->query($select);
        return $query->result();
	}
	
	function get_CetakPenjualanCountSKBulanan_tahun($month, $cabang, $tahun)
	{
	
			$select = "select  
				f.strnama, sum(e.intquantity) intquantity, h.intfee_jawa fee_jawa, h.intfee_luarjawa fee_luarjawa, a.inttotal_bayar	
				from 
					nota a, 
					member b,
					nota_detail e, 
					barang f left join
					harga h on f.intid_barang = h.intid_barang
				where 
					a.intid_nota = e.intid_nota
					and a.intid_dealer = b.intid_dealer
					and e.intid_barang = f.intid_barang
					and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
					and year(a.datetgl) = '$tahun'
					and a.intid_cabang = $cabang
					and a.intid_jpenjualan = 10
					and e.is_free = 0
					group by 
						f.intid_barang";
				
			$query = $this->db->query($select);
        return $query->result();
	}
	function get_CetakPenjualanCountSKMingguan_tahun($week, $cabang, $tahun)
	{
	
			$select = "select  
				f.strnama, sum(e.intquantity) intquantity, h.intfee_jawa fee_jawa, h.intfee_luarjawa fee_luarjawa, a.inttotal_bayar	
				from 
					nota a, 
					member b,
					nota_detail e, 
					barang f left join
					harga h on f.intid_barang = h.intid_barang
				where 
					a.intid_nota = e.intid_nota
					and a.intid_dealer = b.intid_dealer
					and e.intid_barang = f.intid_barang
					and a.intid_week in ('$week')
					and year(a.datetgl) = '$tahun'
					and a.intid_cabang = $cabang
					and a.intid_jpenjualan = 10
					and e.is_free = 0
					group by 
						f.intid_barang";
				
			$query = $this->db->query($select);
        return $query->result();
	}
	
	function get_CetakPenjualanArisanBulanan($month, $cabang)
	{
		$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, h.intharga_jawa, 
		(select sum(inttotal_omset) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as inttotal_omset, 
		a.intid_jpenjualan, (select sum(intpv) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota)as intpv, 
		sum(e.intquantity)intquantity, (select sum(inttotal_bayar) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) inttotal_bayar,	
		(h.intcicilan_jawa*(sum(e.intquantity))*1) as cicilan, 
		(select sum(intkomisi10) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi10, 
		(select sum(intkomisi20) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and nota.intid_nota = a.intid_nota) as intkomisi20,
		(select sum(nota_detail.intharga*nota_detail.intquantity) from nota_detail where nota_detail.intid_nota = a.intid_nota) retail
		from nota a, member b, cabang c, unit d, nota_detail e, 
		barang f, harga h
		where a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and e.is_free = 0
		and a.intid_week in (select intid_week from week where intbulan = '$month')
		and a.intid_dealer = b.intid_dealer
		and a.intid_cabang = $cabang
		and a.intid_nota = e.intid_nota
		and a.intid_cabang = c.intid_cabang
		and a.intid_unit = d.intid_unit
		and e.intid_barang = f.intid_barang
		and f.intid_barang = h.intid_barang
		group by a.intid_nota
		order by d.strnama_unit asc, b.strnama_upline asc");
        return $query->result();
	}
	//Laporan Keuangan Harian
	function get_CetakKeuanganHarianReguler($cabang, $tgl)
	{
		/*$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc, 
				a.datetgl tgl
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 1 
				and b.is_free = 0
				and a.is_dp = 0");*/
		$query = $this->db->query("select a.intno_nota, a.intid_dealer, 
				(case when c.intid_jbarang = 1 then sum(b.intquantity*b.intharga) end) as omsettulip,
				(case when c.intid_jbarang = 2 then sum(b.intquantity*b.intharga) end) as omsetmetal,
				(case when c.intid_jbarang = 3 then sum(b.intquantity*b.intharga) end) as omsettc,
				a.datetgl tgl
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 1
				and b.is_free = 0
				and a.is_dp = 0
				group by a.intid_dealer");
        
		return $query->result();
				
	}
	
	function get_CetakKeuanganHarianHut($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 2
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
				 
	}
	
	function get_CetakKeuanganHarianChallenge($cabang, $tgl)
	{
		/*$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 3
				and b.is_free = 0
				and a.is_dp = 0");*/
        $query = $this->db->query("select a.intid_dealer, 
		(case when c.intid_jbarang = 1 then ((sum(b.intquantity*b.intharga))-a.intvoucher) end) as omsettulip,
		(case when c.intid_jbarang = 2 then ((sum(b.intquantity*b.intharga))-a.intvoucher) end) as omsetmetal,
		(case when c.intid_jbarang = 3 then ((sum(b.intquantity*b.intharga))-a.intvoucher) end) as omsettc
		from nota a, nota_detail b, barang c
		where a.intid_nota = b.intid_nota
		and b.intid_barang = c.intid_barang
		and a.datetgl = '$tgl'
		and a.intid_cabang = $cabang
		and a.intid_jpenjualan = 3
		and b.is_free = 0
		group by a.intid_dealer");
		return $query->result();
	}
	
	function get_CetakKeuanganHarianTrade($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 50 THEN a.inttotal_omset ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHarianFreeHut($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 5
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHarianFree($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 6
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHarianNetto($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal,
				CASE WHEN c.intid_jbarang = 3 THEN a.inttotal_omset ELSE 0 END AS omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 7
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHarianLain($cabang, $tgl)
	{
		$query = $this->db->query("select(select sum(inttotal_bayar) from nota where intid_jpenjualan=10 and datetgl='$tgl' and intid_cabang= $cabang) omsetsk,
						SUM(CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar ELSE 0 END) AS omsetlg,
						SUM(CASE WHEN c.intid_jbarang = 6 THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHarianArisan($cabang, $tgl)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN c.intid_jbarang = 1 THEN a.inttotal_omset ELSE 0 END AS omsettulip,
				CASE WHEN c.intid_jbarang = 2 THEN a.inttotal_omset ELSE 0 END AS omsetmetal, 
				d.intjeniscicilan, d.winner
				from nota a, nota_detail b, barang c, arisan d
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_nota = d.intid_arisan_detail
				and a.datetgl = '$tgl'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 9
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	
	function get_CetakKeuanganHarianKomisi($cabang, $tgl)
	{
		$query = $this->db->query("select SUM(distinct(a.intkomisi10)) AS komisi10, SUM(distinct(a.intkomisi20)) AS komisi20
						from nota a, nota_detail b, barang c, jenis_barang d, jenis_penjualan e
						where a.intid_nota = b.intid_nota
						and a.intid_jpenjualan = e.intid_jpenjualan
						and b.intid_barang = c.intid_barang
						and c.intid_jbarang = d.intid_jbarang
						and a.is_dp = 0
						and a.datetgl = '$tgl'
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan <>9");
        return $query->result();
	}
	
	function get_CetakKeuanganHarianKomisiArisan($cabang, $tgl)
	{
		$query = $this->db->query("select SUM(distinct(a.intkomisi10)) AS komisi10, SUM(distinct(a.intkomisi20)) AS komisi20
						from nota a, nota_detail b, barang c, jenis_barang d, jenis_penjualan e
						where a.intid_nota = b.intid_nota
						and a.intid_jpenjualan = e.intid_jpenjualan
						and b.intid_barang = c.intid_barang
						and c.intid_jbarang = d.intid_jbarang
						and a.is_dp = 0
						and a.datetgl = '$tgl'
						and a.intid_cabang = $cabang
						and a.intid_jpenjualan =9");
        return $query->result();
	}
	
	function get_CetakKeuanganHarianDP($cabang, $tgl)
	{
		$query = $this->db->query("select sum(intdp) intcash
					from nota a
					where a.is_dp = 1
					and a.datetgl = '$tgl'
					and a.intid_cabang = $cabang");
        return $query->result();
	}
	//End Laporan Keuangan Harian

	function insertpembayaran($data){
		        
		$tgl = $this->input->post('tanggal');
		$i = $this->db->query("select intid_week from week where '$tgl' between dateweek_start and dateweek_end");
        $week = $i->result();
		$data = array(
            'intid_cabang' => $this->input->post('id_cabang'),
            'nama_bank' => $this->input->post('nama_bank'),
			'datetanggal' => $this->input->post('tanggal'),
			'nominal_bayar' => $this->input->post('nominal_bayar'),
			'intid_week' => $week[0]->intid_week,
			'keterangan' => $this->input->post('keterangan')
            
        );
        $this->db->insert('pembayaran', $data);
		        
	}
	
	function selectPembayaran($cabang)
	{
		$query = $this->db->query("select * from pembayaran where intid_cabang = $cabang");
        return $query->result();
	}
	
	//not used in laporan keuangan bulanan
	function get_Week($month){
		
		$query = $this->db->query("select intbulan, intid_week, date_format(dateweek_start, '%d %M %Y') AS dateweek_start, date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month");
        return $query->result();
	}
	
	//Laporan Keuangan Mingguan
	function get_DateWeek($week){
		
		$query = $this->db->query("select intid_week, date_format(dateweek_start, '%d %M %Y') AS dateweek_start, date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week");
        return $query->result();
	}
	
	//Laporan Keuangan Mingguan
	function get_DateWeek_tahun($week,$tahun){
		
		$query = $this->db->query("select intid_week, date_format(dateweek_start, '%d %M %Y') AS dateweek_start, date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun");
        return $query->result();
	}
	//fungsi disini dipindahkan ke PO_Model_1
	function get_CetakKeuanganMingguanReguler($cabang, $week)
	{
		
		$query = $this->db->query("SELECT n AS intno_nota, IF(ot > 0 AND ot IS NOT NULL, ot - v, ot) AS omsettulip, IF((ot IS NULL OR ot < v) AND (otc IS NULL OR otc < v), om - v, om) AS omsetmetal, IF((ot IS NULL OR ot < v) AND (otc > v AND otc IS NOT NULL), otc - v, otc) AS omsettc FROM 
(SELECT IF(dt IS NULL, IF(dm IS NULL,dtc,dm), dt) AS d, IF(nt IS NULL, IF(nm IS NULL,ntc,nm), nt) AS n, ot, om, otc FROM (SELECT * FROM 
(SELECT intid_dealer AS dt, intno_nota AS nt, SUM(totalharga) AS ot FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
LEFT JOIN 
(SELECT intid_dealer AS dm, intno_nota AS nm, SUM(totalharga) AS om FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
ON omsettulip.nt = omsetmetal.nm
LEFT JOIN
(SELECT intid_dealer AS dtc, intno_nota AS ntc, SUM(totalharga) AS otc FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
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
	/**
	* @param get_CetakKeuanganMingguanReguler_tahun
	* ikhlas firlana ifirlana@gmail.com
	* desc : 
	*/
	function get_CetakKeuanganMingguanReguler_tahun($cabang, $week,$tahun)
	{
		
		$query = $this->db->query("SELECT n AS intno_nota, IF(ot > 0 AND ot IS NOT NULL, ot - v, ot) AS omsettulip, IF((ot IS NULL OR ot < v) AND (otc IS NULL OR otc < v), om - v, om) AS omsetmetal, IF((ot IS NULL OR ot < v) AND (otc > v AND otc IS NOT NULL), otc - v, otc) AS omsettc FROM 
(SELECT IF(dt IS NULL, IF(dm IS NULL,dtc,dm), dt) AS d, IF(nt IS NULL, IF(nm IS NULL,ntc,nm), nt) AS n, ot, om, otc FROM (SELECT * FROM 
(SELECT intid_dealer AS dt, intno_nota AS nt, SUM(totalharga) AS ot FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in(1,9) GROUP BY intno_nota) AS omsettulip 
LEFT JOIN 
(SELECT intid_dealer AS dm, intno_nota AS nm, SUM(totalharga) AS om FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in( 2,9) GROUP BY intno_nota) AS omsetmetal
ON omsettulip.nt = omsetmetal.nm
LEFT JOIN
(SELECT intid_dealer AS dtc, intno_nota AS ntc, SUM(totalharga) AS otc FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in(3,9) GROUP BY intno_nota) AS omsettc
ON omsettulip.nt = omsettc.ntc OR omsetmetal.nm = omsettc.ntc
UNION
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in(1,9) GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in( 2,9) GROUP BY intno_nota) AS omsetmetal 
ON omsettulip.intno_nota = omsetmetal.intno_nota
LEFT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in(3,9) GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota
UNION 
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in (1,9) GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in (2,9) GROUP BY intno_nota) AS omsetmetal
ON omsettulip.intno_nota = omsetmetal.intno_nota
RIGHT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND a.is_dp = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang in (3,9)  GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota) AS omset
) AS omset
LEFT JOIN 
(SELECT intid_dealer AS dv, intno_nota AS nv, intvoucher AS v FROM nota) AS voucher
ON omset.n = voucher.nv
ORDER BY intno_nota");
        
		return $query->result();	
	}
	
	function get_CetakKeuanganMingguanHut($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and a.intid_jpenjualan = 2
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
		 
	}
	/**
	* @param get_CetakKeuanganMingguanHut_tahun
	* ikhlas firlana 6 jan 2014
	* desc : ditambahin tahun
	*/
	function get_CetakKeuanganMingguanHut_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and a.intid_jpenjualan = 2
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
		 
	}
	function get_CetakKeuanganMingguanChallenge($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and a.intid_jpenjualan = 3
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	* @param get_CetakKeuanganMingguanChallenge
	* ikhlas firlana ifirlana@gmail.com
	* desc : penambahan tahun
	*/
	function get_CetakKeuanganMingguanChallenge_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 3
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 3
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(a.datetgl) = $tahun
			and a.intid_jpenjualan = 3
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganMingguanTrade($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 THEN a.inttotal_omset ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 THEN a.inttotal_omset ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	@param get_CetakKeuanganMingguanTrade_tahun
	ikhlas firlana ifirlana@gmail.com 6 jan 2014
	desc : menambahkan tahun di laporannya
	*/
	function get_CetakKeuanganMingguanTrade_tahun($cabang, $week,$tahun)
	{
		/* $query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 OR b.is_diskon = 0.70 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 OR b.is_diskon = 0.60 THEN a.inttotal_omset ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 OR b.is_diskon = 0.50 THEN a.inttotal_omset ELSE IF (a.inttotal_omset = 0, a.inttotal_bayar, 0) END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0"); */
				$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 OR b.is_diskon = 0.70 THEN sum(b.intomset) ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 OR b.is_diskon = 0.60 THEN sum(b.intomset) ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 OR b.is_diskon = 0.50 THEN sum(b.intomset) ELSE IF (a.inttotal_omset = 0, a.inttotal_bayar, 0) END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0
				group by b.is_diskon,b.intid_nota
				");
        
		return $query->result();
	}
	////end
	function get_CetakKeuanganMingguanFreeHut($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and a.intid_jpenjualan = 5
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	@param get_CetakKeuanganMingguanTrade_tahun
	ikhlas firlana ifirlana@gmail.com 6 jan 2014
	desc : menambahkan tahun di laporannya
	*/
	function get_CetakKeuanganMingguanFreeHut_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 5
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 5
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and a.intid_jpenjualan = 5
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	///ending
	function get_CetakKeuanganMingguanFree($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and a.intid_jpenjualan = 6
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	@param get_CetakKeuanganMingguanFree_tahun
	ikhlas firlana ifirlana@gmail.com 6 jan 2014
	desc : menambahkan tahun di laporannya
	*/
	function get_CetakKeuanganMingguanFree_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 6
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 6
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(a.datetgl) = $tahun
			and a.intid_jpenjualan = 6
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	////ending
	function get_CetakKeuanganMingguanNetto($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and a.intid_jpenjualan = 7
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	@param get_CetakKeuanganMingguanNetto_tahun
	ikhlas firlana ifirlana@gmail.com 6 jan 2014
	desc : menambahkan tahun di laporannya
	*/
	function get_CetakKeuanganMingguanNetto_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 7
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(nota.datetgl) = $tahun
			and nota.intid_jpenjualan = 7
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(a.datetgl) = $tahun
			and a.intid_jpenjualan = 7
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
	}
	///////ending
	function get_CetakKeuanganMingguanLain($cabang, $week)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang = 6 THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and a.is_dp = 0
				group by a.intid_nota");
        
		return $query->result();
	}
	
	/**
	@param get_CetakKeuanganMingguanLain_tahun
	ikhlas firlana ifirlana@gmail.com 6 jan 2014
	desc : menambahkan tahun di laporannya
	*/
	function get_CetakKeuanganMingguanLain_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang not in (4,5,7) THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and c.strnama not like 'undangan%'
				and a.is_dp = 0
				and a.is_lgOval = 0
				group by a.intid_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganMingguanLainOval_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang not in (4,5,7) THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and c.strnama not like 'undangan%'
				and a.is_dp = 0
				and a.is_lgOval = 1
				group by a.intid_nota");
        
		return $query->result();
	}
	function get_CetakKeuanganMingguanUndangan_tahun($cabang, $week,$tahun)
	{

		$query = $this->db->query("select 
			(CASE WHEN c.intid_jbarang = 6 THEN a.inttotal_bayar ELSE 0 END) AS omsetlainundangan
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and c.strnama like 'undangan%'
				and a.is_dp = 0
				group by a.intid_nota");
        
		return $query->result();
	}
	//ending
	function selectTotalDpLunasMingguan($cabang, $week)
	{
		$query = $this->db->query("select sum(intdp) dp from nota where (intid_week = ($week-1) or intid_week = $week) and intid_cabang = $cabang and is_dp = 0");
        	return $query->result();
	}
	//6 jan 2014 ifirlana@gmail.com
	//11 agus 2015 ifirlana@gmail.com
	function selectTotalDpLunasMingguan_tahun($cabang, $week,$tahun)
	{
		/*
		$query = $this->db->query("select sum(intdp) dp 
				from nota where (intid_week = ($week-1)) 
				and intid_cabang = $cabang 
				and year(datetgl) = $tahun 
				and is_dp = 0");
				*/
		$select = "select 
				sum(dp) dp 
				from
				(select 
					sum(intdp) dp 
				from nota 
					where (intid_week = ($week-1)) 
					and intid_cabang = $cabang 
					and year(datetgl) = $tahun 
					and is_dp = 0
				UNION
				select 
				sum(total_cost - cash) dp
				from _instalment
					where 	
					id_branch = $cabang
					and _instalment.date >= (select dateweek_start from week where intid_week = ($week-1) and inttahun = $tahun)
					and _instalment.date <= (select dateweek_end from week where intid_week = ($week-1) and inttahun = $tahun)			 
				) X";
		$query = $this->db->query($select);
        	return $query->result();
	}
	//ending
	function get_CetakKeuanganMingguanSK($cabang, $week)
	{
		$query = $this->db->query("select sum(inttotal_bayar) total from nota where intid_jpenjualan=10 and intid_week = $week and intid_cabang= $cabang");
        
		return $query->result();
	}
	/**
	* @param get_CetakKeuanganMingguanSK_tahun
	* ikhlas firlana 6 jan 2014 ifirlana@gmail.com
	* desc :
	*/
	function get_CetakKeuanganMingguanSK_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select sum(inttotal_bayar) total from nota where intid_jpenjualan=10 and intid_week = $week and year(datetgl) = $tahun and intid_cabang= $cabang");
        
		return $query->result();
	}
	///ending
	function get_CetakKeuanganMingguanSpecialPrice($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 11
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	/**
	* @param get_CetakKeuanganMingguanSpecialPrice_tahun
	* ikhlas firlana 6 jan 2014 ifirlana@gmail.com
	* desc :
	*/
	function get_CetakKeuanganMingguanSpecialPrice_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 11
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
//001
	function get_CetakKeuanganMingguanPoint($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 12
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	* @param get_CetakKeuanganMingguanPoint_tahun
	* ikhlas firlana 6 jan 2014 ifirlana@gmail.com
	* desc :
	*/
	
	function get_CetakKeuanganMingguanPoint_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 12
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	////ending
	function get_CetakKeuanganMingguanMetal50($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 13
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	///////////////Diskon40% hitung omset mingguan///////////////////////
	/* 
		ikhlas line 
		ifirlana@gmail.com 2014 12 08
		desc : membuat perhitungan keuangan week.
	*/
		function get_CetakKeuanganMingguanDiskon40($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 16
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganMingguanDiskon50($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 18
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganMingguanDiskon60($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 19
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
function get_CetakKeuanganMingguanDiskon35($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 20
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	/**
	* @param get_CetakKeuanganMingguanPoint_tahun
	* ikhlas firlana 6 jan 2014 ifirlana@gmail.com
	* desc :
	*/
		function get_CetakKeuanganMingguanMetal50_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 13
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	///ending
	function get_CetakKeuanganMingguanArisan($cabang, $week)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 1
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_arisan = 1");
        
		return $query->result();
	}
	//6 jan 2014 ifirlana@gmail.com
	
	function get_CetakKeuanganMingguanArisan_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 1
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_arisan = 1");
        
		return $query->result();
	}
	//ending
	function get_CetakKeuanganMingguanKomisi($cabang, $week)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20 
									from nota 
									where nota.is_dp = 0
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.is_arisan = 0 ");
        return $query->result();
	}
	//6 jan 2013 ifirlana@gmail.com
	function get_CetakKeuanganMingguanKomisi_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi15) komisi15, sum(nota.intkomisi20) komisi20 , sum(nota.otherKom) kotam
									from nota 
									where nota.is_dp = 0
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and year(nota.datetgl) = $tahun
									and nota.is_arisan = 0 ");
        return $query->result();
	}
	//ending
	function get_CetakKeuanganMingguanKomisiArisan($cabang, $week)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20, sum(nota.inttotal_omset) omset,  sum(nota.inttotal_bayar) netto
									from nota 
									where nota.is_dp = 0
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and nota.is_arisan = 1
									and nota.intid_jpenjualan = 1");
        return $query->result();
	}
	
	function get_CetakKeuanganMingguanKomisiArisan_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20, sum(nota.inttotal_omset) omset,  sum(nota.inttotal_bayar) netto
									from nota 
									where nota.is_dp = 0
									and nota.intid_week = $week
									and nota.intid_cabang = $cabang
									and year(nota.datetgl) = $tahun
									and nota.is_arisan = 1
									and nota.intid_jpenjualan = 1");
        return $query->result();
	}
	function get_CetakKeuanganMingguanDP($cabang, $week)
	{
		$query = $this->db->query("select sum(intdp) intcash
					from nota a
					where a.is_dp = 1
					and a.intid_week = '$week'
					and a.intid_cabang = $cabang");
        return $query->result();
	}
	
	function get_CetakKeuanganMingguanDP_tahun($cabang, $week,$tahun)
	{
		/*
		$query = $this->db->query("select sum(intdp) intcash
					from nota a
					where a.is_dp = 1
					and a.intid_week = '$week'
					and a.intid_cabang = $cabang
					and year(datetgl) = $tahun");
		/**/
		$select = " select sum(intcash) intcash 
					from
					(select sum(intdp) intcash 
						from nota 
						where 
						nota.is_dp = 1
						and nota.intid_week = '$week'
						and nota.intid_cabang = $cabang
						and year(datetgl) = $tahun
					UNION
						SELECT sum(total_cost - cash) intcash
						from 
						_instalment 
						where 
							_instalment.date >= (select dateweek_start from week where intid_week = $week and inttahun = $tahun)
							and _instalment.date <= (select dateweek_end from week where intid_week = $week and inttahun = $tahun)
							and _instalment.id_branch = $cabang) x";
		$query = $this->db->query($select);
		return $query->result();
	}
	function selectPembayaranMingguan($cabang, $week)
	{
		$query = $this->db->query("select * from pembayaran where intid_cabang = $cabang and intid_week = $week");
        return $query->result();
	}
	/**
	*/
	
	function selectPembayaranMingguan_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select * from pembayaran where intid_cabang = $cabang and intid_week = $week and year(datetanggal) = $tahun");
        return $query->result();
	}
	//ending
	function selectTotalPembayaranMingguan($cabang, $week)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week < $week and a.intid_cabang = $cabang and is_dp = 0 and a.intid_jpenjualan <> 4) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week < $week and intid_cabang = $cabang and is_dp = 1 and intid_jpenjualan <> 4) b
		");
        return $query->result();
	}
	
	function selectTotalPembayaranMingguan_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week < $week and a.intid_cabang = $cabang and year(a.datetgl) = $tahun and is_dp = 0) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week < $week and intid_cabang = $cabang and year(datetgl) = $tahun and is_dp = 1) b
		");
        return $query->result();
	}
	function selectTotalPembayaranMingguan_tahunsebelum($cabang, $week,$tahun)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where  a.intid_cabang = $cabang and year(datetgl) >= 2014 and year(a.datetgl) < $tahun and is_dp = 0) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_cabang = $cabang and year(datetgl) >= 2014 and year(datetgl) < $tahun and is_dp = 1) b
		");
        return $query->result();
	}
	function selectTotalPembayaranMingguanTrade($cabang, $week)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week < $week and a.intid_cabang = $cabang and is_dp = 0 and a.intid_jpenjualan = 4) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week < $week and intid_cabang = $cabang and is_dp = 1 and intid_jpenjualan = 4) b
		");
        return $query->result();
	}
	
	function selectTotalPembayaranMingguanTrade_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week < $week and a.intid_cabang = $cabang and year(a.datetgl) = $tahun and is_dp = 0 and a.intid_jpenjualan = 4) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week < $week and intid_cabang = $cabang and year(datetgl) = $tahun and is_dp = 1 and intid_jpenjualan = 4) b
		");
        return $query->result();
	}
	function selectTotalBayarMingguan($cabang, $week)
	{
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where intid_week < $week and intid_cabang = $cabang");
        return $query->result();
	}
	function selectTotalBayarMingguan_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where intid_week < $week and intid_cabang = $cabang and year(datetanggal) = $tahun");
        return $query->result();
	}
	function selectTotalBayarMingguan_tahunsebelum($cabang, $week,$tahun)
	{
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where intid_cabang = $cabang and year(datetanggal) >= 2014 and year(datetanggal) < $tahun");
        return $query->result();
	}
	//End Laporan Keuangan Mingguan
	//Laporan Keuangan Bulanan
	function get_CetakKeuanganBulananReguler($cabang, $month)
	{
		$query = $this->db->query("SELECT n AS intno_nota, IF(ot > 0 AND ot IS NOT NULL, ot - v, ot) AS omsettulip, IF((ot IS NULL OR ot < v) AND (otc IS NULL OR otc < v), om - v, om) AS omsetmetal, IF((ot IS NULL OR ot < v) AND (otc > v AND otc IS NOT NULL), otc - v, otc) AS omsettc FROM 
(SELECT IF(dt IS NULL, IF(dm IS NULL,dtc,dm), dt) AS d, IF(nt IS NULL, IF(nm IS NULL,ntc,nm), nt) AS n, ot, om, otc FROM (SELECT * FROM 
(SELECT intid_dealer AS dt, intno_nota AS nt, SUM(totalharga) AS ot FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
LEFT JOIN 
(SELECT intid_dealer AS dm, intno_nota AS nm, SUM(totalharga) AS om FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
ON omsettulip.nt = omsetmetal.nm
LEFT JOIN
(SELECT intid_dealer AS dtc, intno_nota AS ntc, SUM(totalharga) AS otc FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.nt = omsettc.ntc OR omsetmetal.nm = omsettc.ntc
UNION
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal 
ON omsettulip.intno_nota = omsetmetal.intno_nota
LEFT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota
UNION 
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
ON omsettulip.intno_nota = omsetmetal.intno_nota
RIGHT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota) AS omset
) AS omset
LEFT JOIN 
(SELECT intid_dealer AS dv, intno_nota AS nv, intvoucher AS v FROM nota) AS voucher
ON omset.n = voucher.nv
ORDER BY intno_nota");
        
		return $query->result(); 
		
	}
	
	function get_CetakKeuanganBulananHut($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 2
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
		 
	}
	
	function get_CetakKeuanganBulananChallenge($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 3
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananTrade($cabang, $month)
	{
		
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 THEN a.inttotal_omset ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 THEN a.inttotal_omset ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	
	
	function get_CetakKeuanganBulananFreeHut($cabang, $month,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and year(datetgl) =$tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 5
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananFree($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 6
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananNetto($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 7
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananLain($cabang, $month)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang = 6 THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and a.is_dp = 0
				group by a.intid_nota");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananSK($cabang, $month)
	{
		$query = $this->db->query("select sum(inttotal_bayar) total from nota where intid_jpenjualan=10 and substr(datetgl,6,2) = '$month' and intid_cabang= $cabang");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananSpesial($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 11
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
//001
	function get_CetakKeuanganBulananPoint($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 12
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/* 

	
	*/
	function get_CetakKeuanganBulananDiskon40($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week 
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 16
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananMetal50($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 13
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananArisan($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 1
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_arisan = 1");
        
		return $query->result();
	}
		
	function get_CetakKeuanganBulananKomisi($cabang, $month)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20 
									from nota 
									where nota.is_dp = 0
									and nota.intid_week in (select intid_week from week where intbulan = '$month')
									and nota.intid_cabang = $cabang
									and nota.is_arisan = 0");
        return $query->result();
	}
	
	function get_CetakKeuanganBulananKomisiArisan($cabang, $month)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20, sum(nota.inttotal_omset) omset,  sum(nota.inttotal_bayar) netto
									from nota 
									where nota.is_dp = 0
									and nota.intid_week in (select intid_week from week where intbulan = '$month')
									and nota.intid_cabang = $cabang
									and nota.is_arisan = 1
									and nota.intid_jpenjualan = 1");
        return $query->result();
	}
	
	function get_CetakKeuanganBulananDP($cabang, $month)
	{
		$query = $this->db->query("select sum(intdp) intcash
					from nota a
					where a.is_dp = 1
					and a.intid_week in (select intid_week from week where intbulan = '$month')
					and a.intid_cabang = $cabang");
        return $query->result();
	}
	
	function selectPembayaranBulanan($cabang, $month)
	{
		$query = $this->db->query("select * from pembayaran where intid_cabang = $cabang and substr(datetanggal,6,2) = '$month'");
        return $query->result();
	}
	
	/*function selectTotalPembayaranBulanan($cabang, $month)
	{
		$query = $this->db->query("select SUM(a.inttotal_bayar) total_bayar from nota a where substr(a.datetgl,6,2) = ($month-1) and a.intid_cabang = $cabang");
        return $query->result();
	}*/
	
	function selectTotalPembayaranBulanan($cabang, $month)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week in (select intid_week from week where intbulan = ($month-1)) and a.intid_cabang = $cabang and is_dp = 0 and a.intid_jpenjualan <> 4) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week in (select intid_week from week where intbulan = ($month-1)) and intid_cabang = $cabang and is_dp = 1 and intid_jpenjualan <> 4) b
		");
        return $query->result();
	}
	
	function selectTotalPembayaranBulananTrade($cabang, $month)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week in (select intid_week from week where intbulan = ($month-1)) and a.intid_cabang = $cabang and is_dp = 0 and a.intid_jpenjualan = 4) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week in (select intid_week from week where intbulan = ($month-1)) and intid_cabang = $cabang and is_dp = 1 and intid_jpenjualan = 4) b
		");
        return $query->result();
	}
	
	function selectTotalBayarBulanan($cabang, $month)
	{
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where substr(datetanggal,6,2) = ($month-1) and intid_cabang = $cabang");
        return $query->result();
	}
	//End Laporan Keuangan Bulanan	
	//PV
	
	function pv_tree($unit)
	{
	   $sql = "select M.strkode_dealer,  
				IF (M.intlevel_dealer=1, M.strnama_dealer, '') as Level1,
				IF (M.intlevel_dealer=2, M.strnama_dealer, '') as Level2,
				IF (M.intlevel_dealer=3, M.strnama_dealer, '') as Level3,
				IF (M.intlevel_dealer=4, M.strnama_dealer, '') as Level4,
				IF (M.intlevel_dealer=5, M.strnama_dealer, '') as Level5,
				IF (M.intlevel_dealer=6, M.strnama_dealer, '') as Level6,
				IF (M.intlevel_dealer=7, M.strnama_dealer, '') as Level7,
				IF (M.intlevel_dealer=8, M.strnama_dealer, '') as Level8,
				IF (M.intlevel_dealer=9, M.strnama_dealer, '') as Level9,
				IF (M.intlevel_dealer=10, M.strnama_dealer, '') as Level10,
				IF (M.intlevel_dealer=11, M.strnama_dealer, '') as Level11,
				IF (M.intlevel_dealer=12, M.strnama_dealer, '') as Level12,
				IF (M.intlevel_dealer=13, M.strnama_dealer, '') as Level13,
				IF (M.intlevel_dealer=14, M.strnama_dealer, '') as Level14,
				IF (M.intlevel_dealer=15, M.strnama_dealer, '') as Level15,
				IF (M.intlevel_dealer=16, M.strnama_dealer, '') as Level16,
				IF (M.intlevel_dealer=17, M.strnama_dealer, '') as Level17,
				IF (M.intlevel_dealer=18, M.strnama_dealer, '') as Level18,
				IF (M.intlevel_dealer=19, M.strnama_dealer, '') as Level19,
				IF (M.intlevel_dealer=20, M.strnama_dealer, '') as Level20
				from member M
				where M.intid_unit=$unit";
       $query = $this->db->query($sql);
	}
	function pv_levelDealer($unit)
	{
	   //CREATE HEADER
	   $del ="delete from temp_header";
	   $querydel = $this->db->query($del); 
		
	   $sql = "insert into temp_header(strjudul, intvalue) values ('KODE',0)";
       $query = $this->db->query($sql);
	   
	   $sql1 = "select DISTINCT(intlevel_dealer) level from member where intid_unit=$unit";
       $query1 = $this->db->query($sql1); 
		foreach ($query1->result() as $row) {
			$level = $row->level;
			$sql = "insert into temp_header(strjudul, intvalue) values ('DEALER$level',$level)";
       		$query = $this->db->query($sql);
		}
		
	   $max = "select max(intlevel_dealer) maxlevel from member where intid_unit=$unit";
       $querymax = $this->db->query($max);
	   foreach ($querymax->result() as $row) {
			$maxlevel = $row->maxlevel;
			
		}
	   
	   $sql2 = "insert into temp_header(strjudul, intvalue) values ('JMLPRIBADI',$maxlevel+1)";
       $query2 = $this->db->query($sql2);
	   $sql3 = "insert into temp_header(strjudul, intvalue) values ('JMLUNIT',$maxlevel+2)";
       $query3 = $this->db->query($sql3);
	   $sql4 = "insert into temp_header(strjudul, intvalue) values ('PV UNIT',$maxlevel+3)";
       $query4 = $this->db->query($sql4);
	   
	   //DATA
	   $del1 ="delete from temp_pv";
	   $querydel1 = $this->db->query($del1);
	   
	   $sql5 = "insert into temp_pv(strkode_dealer, strnama_dealer, intlevel_dealer, intparent_leveldealer, strkode_upline, omset, pv)(select a.strkode_dealer, a.strnama_dealer, a.intlevel_dealer,
				a.intparent_leveldealer, a.strkode_upline,
				sum(b.inttotal_omset) omset,sum(b.intpv) pv 
				from member a LEFT JOIN nota b on a.intid_dealer=b.intid_dealer
				where a.intid_unit = $unit
				GROUP BY a.strnama_dealer
				order by a.intlevel_dealer asc)";
       $query5 = $this->db->query($sql5); 
		
   }
   
   function get_Header()
	{
		$query = $this->db->query("select * from temp_header");
        return $query->result();
	}
	
	function get_DataPv()
	{
		$query = $this->db->query("select * from temp_pv");
        return $query->result();
	}
	//BOOM
	function cek_level($menu_id) {
		$this->db->select('count(strkode_upline) as record_count');
		$this->db->where('strkode_upline',$menu_id);
		$this->db->from('member');
		return $this->db->get()->row()->record_count;
	}
    
    function child($strkode_upline, $lvl = 0, $slvl = 0) {
		//print_r($level_parent);
		$br = '';
		$lvl++;
		$sql_p = "select * from member where strkode_upline = '$strkode_upline'";
		//var_dump("select * from member where strkode_upline = 'M01027666'");
		$get_p = $this->db->query($sql_p);
		foreach ($get_p->result() as $r_p):
			$set_child = '';
			$folder = '';
			if ($this->cek_level($r_p->strkode_upline) > 0 ):
				$set_child = ', children: ['.$br;
				$slvl = $r_p->intid_dealer;
				$folder = ', isFolder: true';
			else:
				$slvl = 0;
			endif;
			//echo $slvl;
			$selected = '';
			//print_r($r_p);
			//$sql_u = "select * from prc_sys_user_menu where usr_id = '".$usrid."' and menu_id = '".$r_p->menu_id."'";
			//$get_u = $this->db->query($sql_u);
			//if($get_u->num_rows() > 0):
//				$selected = 'select: true, ';
			//endif;
			$selected = 'select: true, ';
			self::$CHILD .= '{'.$selected.'title: "'.$r_p->strnama_dealer.'",
                key: "'.$r_p->intid_dealer	.'"'.$folder.$set_child;
			$this->child($r_p->strkode_dealer, $lvl, $slvl);
			if ($r_p->intid_dealer == $slvl):
				self::$CHILD .= ']},'.$br;
			else:
				self::$CHILD .= '},'.$br;
			endif;
		endforeach;
	}

	function get_child() {
		return self::$CHILD;
	}

    function display_children() {
        
        $query = $this->db->query("SELECT strnama_dealer , CONCAT_WS('_', level3, level2, level1) as level  FROM (SELECT
			t1.strnama_dealer as strnama_dealer,
			t3.strnama_dealer AS level3,
			t2.strnama_dealer AS level2,
			t1.strnama_dealer AS level1
			FROM 
			member  as t1
			LEFT JOIN
			member  as t2
			on 
			t1.strkode_upline = t2.strkode_dealer
			LEFT JOIN
			member  as t3
			on
			t2.strkode_upline = t3.strkode_dealer
			) as depth_table
			
			WHERE
							t1.strkode_upline = '$strkode_upline'
			ORDER BY
			strkode_dealer");

        return $query->result();
    }
	
	 function getTotalParent($kode) {
        $this->db->select('member.intlevel_dealer');
        $this->db->from('member');
        $this->db->where('member.strkode_dealer', $kode);
        return $this->db->get()->result();
    }
	
	 function cek_bulan_start($bulan) {
        $this->db->select('week.intid_week, week.dateweek_start');
        $this->db->from('week');
        $this->db->where('week.intbulan', $bulan);
        $this->db->order_by('week.intid_week');
        return $this->db->get()->result();
    }
	
	function cek_bulan_end($bulan) {
        $this->db->select('max(week.intid_week) intid_week, max(week.dateweek_end) dateweek_end');
        $this->db->from('week');
        $this->db->where('week.intbulan', $bulan);
        $this->db->order_by('week.intid_week');
        return $this->db->get()->result();
    }
	
    function Cari_tanggal($limit,$offset,$tanggal, $dealer, $cabang)
	{
	  if ($cabang ==1)
	  {
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where (a.datetgl like '$tanggal%' or b.strnama_dealer like '$dealer%') 
									LIMIT $offset,$limit");
	  } else {
	  if (!empty($tanggal)){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where a.datetgl like '$tanggal%' 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  } else  if (!empty($dealer)){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where b.strnama_dealer like '$dealer%' 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  } else {
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where (a.datetgl like '$tanggal%' or b.strnama_dealer like '$dealer%') 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  }
	  }
	 
	  return $q;
		
	}

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}

	function selectnota($intno_nota){
		$i = $this->db->query("select b.intid_barang,b.intquantity 
			from nota a, nota_detail b 
			where a.intid_nota = b.intid_nota 
			and a.intno_nota = '$intno_nota'");
		return $i->result();
	}
	
	function get_stokpusat($where) {
		if(is_array($where)):
			foreach($where as $key=>$val):
				$this->db->where($key,$val);
			endforeach;
		endif;
		return $this->db->get('stok');
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
	
	function hapus($intno_nota){
      
	   $i = $this->db->query("select a.intid_nota, a.intid_jpenjualan, a.intid_dealer, a.intid_cabang, b.intquantity, b.intid_barang 
			from nota a, nota_detail b 
			where a.intid_nota = b.intid_nota 
			and a.intno_nota = '$intno_nota'");
       $nota = $i->result();
	   $id_nota = $nota[0]->intid_nota;
	   $jenis_penjualan = $nota[0]->intid_jpenjualan;
	   $dealer = $nota[0]->intid_dealer;
	   $this->db->where('intid_nota', $id_nota);
	   $this->db->delete('nota_detail');
	   $this->db->where('intno_nota', $intno_nota);
       $this->db->delete('nota');
	   if ($jenis_penjualan==10){
	   		$this->db->where('intid_dealer', $dealer);
	   		$this->db->delete('member');
	   }
	}
	
	function get_pemenang_arisan($bln, $thn) {
		$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		f.strnama, e.intquantity, h.intharga_jawa, h.intharga_luarjawa, c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, i.*, a.inttotal_omset, a.intid_jpenjualan, a.intpv, a.intkomisi10, a.intkomisi20  
		from nota a inner join cabang c on c.intid_cabang = a.intid_cabang
		inner join arisan i on i.intid_arisan_detail = a.intid_nota
		inner join member b on b.intid_dealer = a.intid_dealer
		inner join unit d on d.intid_unit = b.intid_unit,
		nota_detail e, barang f, jenis_barang g, harga h
		where a.intid_nota = e.intid_nota
		and e.intid_barang = f.intid_barang
		and f.intid_jbarang = g.intid_jbarang
		and f.intid_barang = h.intid_barang
		and MONTH(a.datetgl)='$bln' AND YEAR(a.datetgl)='$thn'
		and a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and i.urutan_pemenang <> 0
		and e.is_free = 0
		order by d.strnama_unit asc, b.strnama_upline asc");
        return $query->result();
    }
	
	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
	
	function rekapPV($tglstart, $tglend, $intid_jpenjualan) {
		$query = $this->db->query("select a.strnama_dealer, a.strnama_upline, b.strnama_unit, (select sum(inttotal_omset)
from nota where nota.datetgl BETWEEN '$tglstart' and '$tglend' and intid_jpenjualan = $intid_jpenjualan and nota.intid_unit = b.intid_unit) inttotal_omset,
(select sum(intpv)
from nota where nota.datetgl BETWEEN '$tglstart' and '$tglend' and intid_jpenjualan = $intid_jpenjualan and nota.intid_unit = b.intid_unit) intpv
from member a, unit b
where a.intid_unit = b.intid_unit
and a.intlevel_dealer = 1;");
        return $query->result();
    }
	
	function get_CetakPenjualanKomisi($week, $cabang)
	{
		$query=$this->db->query("select b.intid_dealer,a.intno_nota, a.inttotal_omset, b.strnama_dealer, b.strnama_upline,  a.intkomisi10, a.intkomisi20, 
		a.intpv, a.inttotal_bayar, a.intid_week,e.strnama_jpenjualan,
		(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
		(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend,
		c.strnama_unit, d.strnama_cabang,
		(case when g.intid_jbarang = 1 then (f.intquantity*f.intharga) end) as omsett,
		(case when g.intid_jbarang = 2 then (f.intquantity*f.intharga) end) as omsetm,
		(case when g.intid_jbarang = 3 then (f.intquantity*f.intharga) end) as omsettc,
		(case when g.intid_jbarang = 5 then (f.intquantity*f.intharga) end) as omsetlg,
		(case when g.intid_jbarang = 6 then (f.intquantity*f.intharga) end) as omsetll   
		from nota a, member b, unit c, cabang d, jenis_penjualan e, nota_detail f, barang g
		where a.intid_dealer = b.intid_dealer 
		and a.intid_cabang = d.intid_cabang
		and b.intid_unit = c.intid_unit
		and a.intid_jpenjualan = e.intid_jpenjualan
		and a.intid_nota = f.intid_nota
		and f.intid_barang = g.intid_barang
		and (a.nokk <> ''or a.is_asi = 1)
		and a.intid_week = $week
		and a.intid_cabang = $cabang
		order by a.intno_nota asc");
        return $query->result();
	}
	/*
	//diubah tgl 28 agustus 2013 oleh ikhlas
	function get_CetakSales($week, $cabang)
	{
//001
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intno_nota, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
WHERE nota.intid_week = $week
AND nota.intid_cabang = $cabang
AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
AND nota.intid_nota = a.intid_nota) AS omsetnetto,
(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
WHERE nota.intid_week = $week
AND nota.intid_cabang = $cabang
AND nota.intid_jpenjualan = 11
AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
WHERE nota.intid_week = $week
AND nota.intid_cabang = $cabang
AND nota.intid_jpenjualan = 12
AND nota.intid_nota = a.intid_nota) AS omsetpoint,
(SELECT DISTINCT nota.inttotal_bayar 
FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
WHERE nota.intid_week = $week
AND nota.intid_cabang = $cabang
AND nota.intid_jpenjualan = 10
AND nota.intid_nota = a.intid_nota) AS omsetsk,

(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and nota.is_arisan = 0
and nota.is_dp = 0
and barang.intid_jbarang=5
and nota.intid_nota = a.intid_nota) as omsetlg,
(select sum(nota_detail.intquantity*nota_detail.intharga) 
from nota, nota_detail, barang 
where nota.intid_nota = nota_detail.intid_nota
and nota_detail.intid_barang = barang.intid_barang
and nota.intid_week = $week
and nota.intid_cabang = $cabang
and barang.intid_jbarang=6
and nota.is_arisan = 0
and nota.is_dp = 0
and nota.intid_nota = a.intid_nota) as omsetll,
a.inttotal_bayar, a.intpv, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
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
	*/
	function get_CetakSales($week, $cabang)
	{
//001
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					and barang.intid_jbarang=6
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.intpv, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week = $week
					and a.is_dp = 0 
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					UNION
					SELECT * FROM (
					SELECT a.datetgl, a.intno_nota,  '0' as intid_jpenjualan,
					if(a.jenis_nota is null or a.jenis_nota = '','Hadiah',(select jenis_nota from jenis_nota_hadiah jnh where jnh.kode = a.jenis_nota limit 0,1)) AS strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					' ' AS inttotal_omset, ' ' AS intomset10, ' ' AS intomset20, ' ' AS omsetnetto, ' ' AS omsetspecialprice, 
					' ' AS omsetpoint, ' ' AS omsetsk, ' ' AS omsetlg, ' ' AS omsetll, ' ' AS omsettotal_bayar, ' ' AS intpv, 
					a.intid_nota, b.strnama_cabang, a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week) AS datestart, 
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week) AS dateend, 
					' ' AS is_arisan, ' ' AS winner 
					FROM nota_hadiah a left JOIN cabang b ON a.intid_cabang = b.intid_cabang left JOIN member c ON a.intid_dealer = c.intid_dealer left JOIN unit d ON c.intid_unit = d.intid_unit 
					WHERE a.intid_cabang = $cabang AND a.intid_week = $week) AS x");
        return $query->result();
	}
/*
	get_CetakSales_tahun
	2 jan 2013
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan tahun dari pembuatannya
*/	
function get_CetakSales_tahun($week, $cabang,$tahun)
	{
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and barang.intid_jbarang=6
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.intpv, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
					'' as keterangan_tambahan
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week = $week
					AND YEAR(a.datetgl) = $tahun
					and a.is_dp = 0 
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					UNION
					SELECT * FROM (
					SELECT a.datetgl, a.intno_nota,  '0' as intid_jpenjualan,
					if(a.jenis_nota is null or a.jenis_nota = '','Hadiah',(select jenis_nota from jenis_nota_hadiah jnh where jnh.kode = a.jenis_nota limit 0,1)) AS strnama_jpenjualan, 
					c.strnama_dealer, 
					c.strnama_upline, 
					d.strnama_unit, 
					' ' AS inttotal_omset,
					' ' AS intomset10, 
					' ' AS intomset15, 
					' ' AS intomset20, 
					' ' AS omsetnetto, 
					' ' AS omsetspecialprice, 
					' ' AS omsetpoint, 
					' ' AS omsetsk, 
					' ' AS omsetlg, 
					' ' AS omsetll, 
					' ' AS omsettotal_bayar, 
					' ' AS intpv, 
					a.intid_nota, 
					b.strnama_cabang, 
					a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart, 
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week  and inttahun = $tahun) AS dateend, 
					' ' AS is_arisan,
					' ' AS winner,
					a.keterangan keterangan_tambahan
					FROM nota_hadiah a left JOIN cabang b ON a.intid_cabang = b.intid_cabang left JOIN member c ON a.intid_dealer = c.intid_dealer left JOIN unit d ON c.intid_unit = d.intid_unit 
					WHERE a.intid_cabang = $cabang AND a.intid_week = $week and  YEAR(a.datetgl) = $tahun) AS x");
        return $query->result();
	}
//001
/*
//diubah tanggal 28agustus 2013 oleh ikhlas untuk mengakurasi laporan lebih baik
	function get_DetailCetakSales($nota,$jenis)
	{
		if ($jenis == "Hadiah")
		{
			$query=$this->db->query("SELECT c.strnama, b.intquantity, '0' AS is_arisan, '0' AS winner, '' AS intjeniscicilan, '' AS c5, '' AS c7
FROM nota_hadiah a INNER JOIN nota_detail_hadiah b ON a.intid_nota = b.intid_nota INNER JOIN barang c ON b.intid_barang = c.intid_barang
WHERE a.intid_nota = $nota");
		}
		else {
		$query=$this->db->query("select c.strnama, b.intquantity,  a.is_arisan, d.winner, d.intjeniscicilan, d.c5, d.c7
from nota a left join arisan d on a.intid_nota = d.intid_arisan_detail, 
nota_detail b, barang c
where a.intid_nota = b.intid_nota
and b.intid_barang = c.intid_barang
and a.intid_nota = $nota");
}
        return $query->result();
	}
	*/
	
	//modified 2014-03-21 ifirlana@gmail.com
	//membuat laporan hadiah mengacu ke table barang. karena ada migrasi table barang_hadiah ke table barang 
	
	function get_DetailCetakSales($nota,$jenis = 0)
	{
		$select = 'select * from jenis_nota_hadiah where jenis_nota_hadiah.jenis_nota like "%'.$jenis.'%"';
		//echo $select;
		$query_ = $this->db->query($select);
		if ($query_->num_rows() > 0 )
		{
			/*
			//old
			$query=$this->db->query("SELECT c.strnama, b.intquantity, '0' AS is_arisan, '0' AS winner, '' AS intjeniscicilan, '' AS c5, '' AS c7, b.ket as keterangan
				FROM nota_hadiah a INNER JOIN nota_detail_hadiah b ON a.intid_nota = b.intid_nota INNER JOIN barang_hadiah c ON b.intid_barang = c.intid_barang_hadiah
				WHERE a.intid_nota = $nota");
				*/
				
			//new	2014-03-21
			
			$query=$this->db->query("SELECT '0' as otherKom, '0' as persen,c.strnama, b.intquantity, '0' AS is_arisan, '0' AS winner, '' AS intjeniscicilan, '' AS c5, '' AS c7, b.ket as keterangan,b.intid_barang
				FROM nota_hadiah a INNER JOIN nota_detail_hadiah b ON a.intid_nota = b.intid_nota INNER JOIN barang c ON b.intid_barang = c.intid_barang
				WHERE a.intid_nota = $nota");
				
		}
		else {
		$query=$this->db->query("select '0' as otherKom, '0' as persen, c.strnama, b.intquantity,  a.is_arisan, d.winner, d.intjeniscicilan, d.c5, d.c7, '' as keterangan,b.intid_barang
							from nota a left join arisan d on a.intid_nota = d.intid_arisan_detail, 
							nota_detail b, barang c
							where a.intid_nota = b.intid_nota
							and b.intid_barang = c.intid_barang
							and a.intid_nota = $nota");
							}
        return $query->result();
	}
	function get_DetailCetakSalesTipe1($nota,$jenis)
	{
		if ($jenis == "Hadiah")
		{
			$select = "SELECT 
			bh.strnama, 
			b.intquantity, 
			'0' AS is_arisan, 
			'0' AS winner, 
			'' AS intjeniscicilan, 
			'' AS c5, 
			'' AS c7,
			'0' AS intharga_jawa,
			'0' AS intharga_luarjawa
FROM nota_hadiah a INNER JOIN nota_detail_hadiah b ON a.intid_nota = b.intid_nota left join barang_hadiah bh on bh.intid_barang_hadiah = b.intid_barang
WHERE a.intid_nota = '".$nota."'";
		}
		else {
		$select = "select c.strnama, b.intquantity,  a.is_arisan, d.winner, d.intjeniscicilan, d.c5, d.c7,
					b.intharga intharga_jawa,
					b.intharga intharga_luarjawa
from nota a left join arisan d on a.intid_nota = d.intid_arisan_detail, 
nota_detail b, barang c
where a.intid_nota = b.intid_nota
and b.intid_barang = c.intid_barang
and a.intid_nota = $nota";
	}
		$query=$this->db->query($select);
        return $query->result();
	}
	////////////line ikhlas 12042013
function Cari_tanggal_nota_hadiah($limit,$offset,$tanggal, $dealer, $cabang)
	{
	  if ($cabang ==1)
	  {
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl,a.intid_nota
									from nota_hadiah a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit 
									where (a.datetgl like '$tanggal%' or b.strnama_dealer like '$dealer%') 
									LIMIT $offset,$limit");
	  } else {
	  if (!empty($tanggal)){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl,a.intid_nota
									from nota_hadiah a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where a.datetgl like '$tanggal%' 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  } else  if (!empty($dealer)){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl,a.intid_nota
									from nota_hadiah a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where b.strnama_dealer like '$dealer%' 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  } else {
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl,a.intid_nota
									from nota_hadiah a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where (a.datetgl like '$tanggal%' or b.strnama_dealer like '$dealer%') 
									and a.intid_cabang = $cabang
									LIMIT $offset,$limit");
	  }
	  }
	 
	  return $q;
		
	}
	function Cari_nota_hadiah($nota)
	{
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl,a.intid_nota
									from nota_hadiah a left join member b on b.intid_dealer = a.intid_dealer
									left join unit d on d.intid_unit = b.intid_unit 
									where a.intno_nota = '$nota'");
			return $q;
	  }
	/**
	* untuk halaman audit
	* @param get_CetakSalesAudit >>$month, $cabang
	*/
	///line ikhlas 23April2013
	function get_CetakSalesAudit($month, $cabang,$tahun)
	{
//009
	/*
		$query=$this->db->query("
		select * from (select 
			a.datetgl, 
			a.intno_nota, 
			f.strnama_jpenjualan,
			c.strnama_dealer, 
			c.strnama_upline, 
			d.strnama_unit, 
			a.inttotal_omset,
			w.intbulan,
			b.intid_wilayah,
			IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', a.intomset10) AS intomset10, 
			IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20,
			(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
				FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
				WHERE nota.intid_week = w.intid_week
				AND nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
				AND nota.intid_nota = a.intid_nota) AS omsetnetto,
			(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
				FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
				WHERE nota.intid_week = w.intid_week
				AND nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				AND nota.intid_jpenjualan = 11
				AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
			(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
				FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
				WHERE nota.intid_week = w.intid_week
				AND nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				AND nota.intid_jpenjualan = 12
				AND nota.intid_nota = a.intid_nota) AS omsetpoint,
			(SELECT DISTINCT nota.inttotal_bayar 
				FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
				WHERE nota.intid_week = w.intid_week
				AND nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				AND nota.intid_jpenjualan = 10
				AND nota.intid_nota = a.intid_nota) AS omsetsk,
			(select sum(nota_detail.intquantity*nota_detail.intharga) 
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week = w.intid_week
				and nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and barang.intid_jbarang=5
				and nota.intid_nota = a.intid_nota) as omsetlg,
			(select sum(nota_detail.intquantity*nota_detail.intharga) 
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week = w.intid_week
				and nota.intid_cabang = '$cabang'
				AND year(nota.datetgl) = '$tahun'
				and barang.intid_jbarang=6
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetll,
			a.inttotal_bayar, 
			a.intpv, 
			a.intid_nota, 
			b.strnama_cabang, 
			a.intid_week,
			a.is_arisan, 
			(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
			(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = w.intid_week and inttahun = '$tahun') AS datestart,
(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = w.intid_week and inttahun = '$tahun') AS dateend
from nota a, cabang b, member c, unit d, jenis_penjualan f,week w
where c.intid_unit = d.intid_unit
and a.intid_cabang = b.intid_cabang
and a.intid_dealer =  c.intid_dealer
and a.intid_jpenjualan = f.intid_jpenjualan
and year(a.datetgl) = '$tahun'
and a.intid_cabang = '$cabang'
and a.intid_week = w.intid_week
and w.intbulan = '$month'
and w.inttahun = '$tahun'
and a.is_dp = 0 
order by a.intid_jpenjualan asc, a.intno_nota asc) AS Z
UNION
SELECT * FROM (
	SELECT 
		a.datetgl, 
		a.intno_nota, 
		'Hadiah' AS strnama_jpenjualan,
		c.strnama_dealer, 
		c.strnama_upline, 
		d.strnama_unit, 
		' ' AS inttotal_omset,
		' ' AS intbulan,
		' '	AS intid_wilayah,
		' ' AS intomset10, 
		' ' AS intomset20, 
		' ' AS omsetnetto, 
		' ' AS omsetspecialprice, 
		' ' AS omsetpoint, 
		' ' AS omsetsk, 
		' ' AS omsetlg, 
		' ' AS omsetll, 
		' ' AS inttotal_bayar, 
		' ' AS intpv, 
		a.intid_nota, 
		b.strnama_cabang, 
		a.intid_week,  
		' ' AS is_arisan, 
		' ' AS winner,
		' ' AS datestart,
		' ' AS dateend
	FROM nota_hadiah a INNER JOIN cabang b ON a.intid_cabang = b.intid_cabang INNER JOIN member c ON a.intid_dealer = c.intid_dealer INNER JOIN unit d ON c.intid_unit = d.intid_unit INNER JOIN week w ON w.intid_week = a.intid_week 
	WHERE a.intid_cabang = '$cabang' AND w.intbulan = '$month' and year(w.inttahun) = '$tahun' and year(a.datetgl) = '$tahun'
	) AS X");
	*/
	/*
		$select = "SELECT * FROM 
					(select 
						a.datetgl, 
						a.intno_nota, 
						f.intid_jpenjualan, 
						f.strnama_jpenjualan, 
						c.strnama_dealer, 
						c.strnama_upline, 
						d.strnama_unit, 
						a.inttotal_omset, 
						'$month' as intbulan, 
						b.intid_wilayah,
						IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, 
						IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  
						IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						AND nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
						AND nota.intid_nota = a.intid_nota
						) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						AND nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						AND nota.intid_jpenjualan = 11
						AND nota.intid_nota = a.intid_nota
						) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						AND nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						AND nota.intid_jpenjualan = 12
						AND nota.intid_nota = a.intid_nota
						) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
						FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
						WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						AND nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						AND nota.intid_jpenjualan = 10
						AND nota.intid_nota = a.intid_nota
						) AS omsetsk,
					(select sum(nota_detail.intquantity*nota_detail.intharga) 
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and barang.intid_jbarang=5
						and nota.intid_nota = a.intid_nota) as omsetlg,
					(select if(nota.intid_jpenjualan = 8, sum(nota_detail.intquantity*nota_detail.intharga), 0)
						from nota, nota_detail, barang 
						where nota.intid_nota = nota_detail.intid_nota
						and nota_detail.intid_barang = barang.intid_barang
						and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
						and nota.intid_cabang = $cabang
						AND YEAR(nota.datetgl) = $tahun
						and barang.intid_jbarang not in (4,5,7)
						and nota.is_arisan = 0
						and nota.is_dp = 0
						and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, 
					a.intpv, 
					a.intid_nota, 
					b.strnama_cabang, 
					a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun
					order by dateweek_start asc limit 0,1) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun 
					order by dateweek_start desc limit 0,1
					) AS dateend, 
					a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota
					) winner,
					'' as keterangan_tambahan
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND YEAR(a.datetgl) = $tahun
					and a.is_dp = 0 
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					UNION
SELECT * FROM (
	SELECT 
		a.datetgl, 
		a.intno_nota, 
		'Hadiah' AS strnama_jpenjualan,
		c.strnama_dealer, 
		c.strnama_upline, 
		d.strnama_unit, 
		' ' AS inttotal_omset,
		' ' AS intbulan,
		' '	AS intid_wilayah,
		' ' AS intomset10, 
		' ' AS intomset15, 
		' ' AS intomset20, 
		' ' AS omsetnetto, 
		' ' AS omsetspecialprice, 
		' ' AS omsetpoint, 
		' ' AS omsetsk, 
		' ' AS omsetlg, 
		' ' AS omsetll, 
		' ' AS inttotal_bayar, 
		' ' AS intpv, 
		a.intid_nota, 
		b.strnama_cabang, 
		a.intid_week,  
		' ' AS is_arisan, 
		' ' AS winner,
		' ' AS datestart,
		' ' AS dateend,
		' ' AS keterangan_tambahan
	FROM nota_hadiah a INNER JOIN cabang b ON a.intid_cabang = b.intid_cabang INNER JOIN member c ON a.intid_dealer = c.intid_dealer INNER JOIN unit d ON c.intid_unit = d.intid_unit INNER JOIN week w ON w.intid_week = a.intid_week 
	WHERE a.intid_cabang = '$cabang' AND w.intbulan = '$month' and year(w.inttahun) = '$tahun' and year(a.datetgl) = '$tahun'
	) AS X";
	*/
	$select = "SELECT * FROM (select $month as intbulan, a.datetgl, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select if(nota.intid_jpenjualan = 8, sum(nota_detail.intquantity*nota_detail.intharga), 0)
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and barang.intid_jbarang not in (4,5,7)
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.intpv, a.intid_nota, 
					(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun order by dateweek_start limit 0,1) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun order by dateweek_end limit 0,1) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
					'' as keterangan_tambahan
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun)
					AND YEAR(a.datetgl) = $tahun
					and a.is_dp = 0 
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					UNION
					SELECT * FROM (
					SELECT $month as intbulan, a.datetgl, a.intno_nota,  '0' as intid_jpenjualan,
					if(a.jenis_nota is null or a.jenis_nota = '','Hadiah',(select jenis_nota from jenis_nota_hadiah jnh where jnh.kode = a.jenis_nota limit 0,1)) AS strnama_jpenjualan, 
					c.strnama_dealer, 
					c.strnama_upline, 
					d.strnama_unit, 
					' ' AS inttotal_omset,
					' ' AS intomset10, 
					' ' AS intomset15, 
					' ' AS intomset20, 
					' ' AS omsetnetto, 
					' ' AS omsetspecialprice, 
					' ' AS omsetpoint, 
					' ' AS omsetsk, 
					' ' AS omsetlg, 
					' ' AS omsetll, 
					' ' AS omsettotal_bayar, 
					' ' AS intpv, 
					a.intid_nota, 
					(select strnama_cabang from cabang where cabang.intid_cabang = $cabang) strnama_cabang, 
					a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun order by dateweek_start limit 0,1) AS datestart, 
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week   in (select intid_week from week where intbulan = $month and inttahun = $tahun) and inttahun = $tahun order by dateweek_end limit 0,1) AS dateend, 
					' ' AS is_arisan,
					' ' AS winner,
					a.keterangan keterangan_tambahan
					FROM nota_hadiah a left JOIN cabang b ON a.intid_cabang = b.intid_cabang left JOIN member c ON a.intid_dealer = c.intid_dealer left JOIN unit d ON c.intid_unit = d.intid_unit 
					WHERE a.intid_cabang = $cabang AND a.intid_week  in (select intid_week from week where intbulan = $month and inttahun = $tahun) and  YEAR(a.datetgl) = $tahun) AS x";
		$query=$this->db->query($select);
        return $query->result();
	}
	function all_or_dealer($intid_cabang,$bulan){
		$temp = "";
		$tot = 0;
		$over = 0;
		$t20 =0;
		$t10 = 0;
		$temp = "<table width='100%'>
		<tr><th>strkode_dealer</th><th>Nama dealer</th><th>OR</th></tr>
		";
		$query = $this->db->query('select strnama_dealer, strkode_dealer,intid_dealer from member m where m.intid_cabang = "'.$intid_cabang.'"');
		//$row = $query->result();
		foreach($query->result() as $row){
			$query2 = $this->db->query('select intomset10, intomset20 from nota n inner join week w on w.intid_week = n.intid_week where n.intid_dealer = "'.$row->intid_dealer.'" and w.intbulan = "'.$bulan.'"');
			foreach($query2->result() as $rok){
				$t20 = $rok->intomset20 - ($rok->intomset20 * 20 / 100);
				$t10 = $rok->intomset10 - ($rok->intomset10 * 10 / 100);
				
				$tot = $t20 + $t10; 
				$over = ($tot * 3 )/ 100;      
			}
			$temp .="<tr><td>".$row->strkode_dealer."</td><td>".$row->strnama_dealer."</td><td>".$over."</td>
			</tr>";
		}
		$temp .= "</table>";
		return $temp;
	}
	//line ikhlas 15MEI2013
	/**
	* @param selectAllMemberORCabang
	* input : intid_cabang, intbulan
	* output : query result
	* desc : untuk menampilkan OR DEALER yang berasal dari cabang tertentu
	* using : laporan/print_or_dealer_all
	* update : 13 juni 2013,12 Juni2013 ikhlas, 
	*/
	/*
	function selectAllMemberORCabang($bulan){
		$select = "select m.strnama_dealer,
			(select strnama_unit from unit where intid_unit = m.intid_unit) strnama_unit,
			(select sum(intomset10) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group10,
			(select sum(intomset20) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group20,
			(select sum(nota.intomset10) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by mb.intid_dealer) group10downline,
			(select sum(nota.intomset20) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by mb.intid_dealer) group20downline,
			(select c.strnama_cabang from member mb inner join cabang c on c.intid_cabang = mb.intid_cabang 
				where mb.strkode_dealer = m.strkode_dealer group by mb.strkode_dealer) strnama_cabang
			from member m where m.intlevel_dealer != 1 and m.intparent_leveldealer != 0 order by strnama_cabang ASC";
			
		$query = $this->db->query($select);
		return $query->result();
	}*/
	function selectAllMemberORCabang($bulan){
		$select = "select m.strnama_dealer,
			(select strnama_unit from unit where intid_unit = m.intid_unit) strnama_unit,
			(select sum(nota.intomset10) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group10,
			(select sum(nota.intomset20) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group20,
			(select sum(nota.inttotal_omset) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) total_omset,
			(select sum(nota.intomset10) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by m.strkode_dealer) group10downline,
			(select sum(nota.intomset20) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by m.strkode_dealer) group20downline,
			(select c.strnama_cabang from member mb inner join cabang c on c.intid_cabang = mb.intid_cabang 
				where mb.strkode_dealer = m.strkode_dealer group by mb.strkode_dealer) strnama_cabang
			from member m where m.intlevel_dealer != 1 and m.intparent_leveldealer != 0 order by strnama_cabang ASC";
			
		$query = $this->db->query($select);
		return $query->result();
	}
	
	function selectAllMemberORCabangTahun($bulan,$tahun){
		$select = "select m.strnama_dealer,
			(select strnama_unit from unit where intid_unit = m.intid_unit) strnama_unit,
			(select sum(nota.intomset10) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and year(nota.datetgl) = ".$tahun."
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan." and inttahun = ".$tahun.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group10,
			(select sum(nota.intomset20) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and year(nota.datetgl) = ".$tahun."
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan." and inttahun = ".$tahun.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) group20,
			(select sum(nota.inttotal_omset) from nota 
				where nota.intid_dealer = m.intid_dealer 
					and year(nota.datetgl) = ".$tahun."
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan." and inttahun = ".$tahun.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by nota.intid_dealer) total_omset,
			(select sum(nota.intomset10) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and year(nota.datetgl) = ".$tahun."
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan." and inttahun = ".$tahun.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by m.strkode_dealer) group10downline,
			(select sum(nota.intomset20) from member mb inner join nota on nota.intid_dealer = mb.intid_dealer 
				where mb.strkode_upline = m.strkode_dealer 
				and year(nota.datetgl) = ".$tahun."
					and nota.intid_week IN (select intid_week from week where intbulan = ".$bulan." and inttahun = ".$tahun.") and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9) group by m.strkode_dealer) group20downline,
			(select c.strnama_cabang from member mb inner join cabang c on c.intid_cabang = mb.intid_cabang 
				where mb.strkode_dealer = m.strkode_dealer group by mb.strkode_dealer) strnama_cabang
			from member m where m.intlevel_dealer != 1 and m.intparent_leveldealer != 0 order by strnama_cabang ASC";
			
		$query = $this->db->query($select);
		return $query->result();
	}
	
	//line ikhlas 16APril2013
	/**
	* @param Show_list_data_penjualan_nota, 
	* input : nonota, cabang
	* output : query 
	* desc : untuk menampilkandata penjualan
	* using : laporan/data_penjualan
	*/

	function Show_list_data_penjualan_nota($nonota, $cabang)
	{
		$query ="";
		if($cabang == 1){
	  		$query = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where a.intno_nota = '".$nonota."'
									");
								}else{
	  		$query = $this->db->query("select a.intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where a.intid_cabang = '".$cabang."' and a.intno_nota = '".$nonota."'");
								}
			
			return $query;						
	} 
	//line ikhlas 16APril2013
	/**
	* @param Show_list_data_penjualan_dealer, 
	* input : postkata, postkata1, cabang
	* output : query 
	* desc : untuk menampilkandata penjualan
	* using : laporan/data_penjualan
	*/
	function Show_list_data_penjualan_dealer($postkata, $postkata1,  $cabang)
	{
		if($cabang == 1){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where (a.datetgl = '".$postkata."' and b.strnama_dealer like '".$postkata1."%')
									order by b.strnama_dealer desc
									");
								}else{
								
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a inner join member b on b.intid_dealer = a.intid_dealer
									inner join unit d on d.intid_unit = b.intid_unit
                                    where a.intid_cabang = '".$cabang."' and (a.datetgl = ".$postkata." and b.strnama_dealer like '".$postkata1."%')
									order by b.strnama_dealer desc
									");
								}
			
			return $q;						
	}
function Show_list_data_penjualan_kondisi($postkata, $postkata1,  $cabang)
	{
		if($cabang == 1){
							if($postkata == 0){
									$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
															from nota a inner join member b on b.intid_dealer = a.intid_dealer
															inner join unit d on d.intid_unit = b.intid_unit
															where a.datetgl = '".$postkata1."' 
															order by b.strnama_dealer desc
															");
								}elseif($postkata == 1){
									$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
										from nota a inner join member b on b.intid_dealer = a.intid_dealer
										inner join unit d on d.intid_unit = b.intid_unit
										where b.strnama_dealer like '".$postkata1."%'  order by b.strnama_dealer, a.datetgl desc
										");
									}
						}else{
								if($postkata == 0){
									
									$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
															from nota a inner join member b on b.intid_dealer = a.intid_dealer
															inner join unit d on d.intid_unit = b.intid_unit
															where a.intid_cabang = '".$cabang."' and a.datetgl = '".$postkata1."' 
															order by b.strnama_dealer desc
															");
									}elseif($postkata == 1){
										$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
															from nota a inner join member b on b.intid_dealer = a.intid_dealer
															inner join unit d on d.intid_unit = b.intid_unit
															where a.intid_cabang = '".$cabang."' and b.strnama_dealer like '".$postkata1."%' order by b.strnama_dealer, a.datetgl desc
															");
										}
									
								}
			
			return $q;						
	} 	
function Show_list_data_penjualan_this_day($postkata,  $cabang)
	{
		if($cabang == 1){
	  		$q = $this->db->query("select distinct(a.intno_nota) intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a,member b, unit d
                                    where
									a.intid_dealer = b.intid_dealer
									and d.intid_unit = b.intid_unit
									and a.datetgl = '".$postkata."'
									order by b.strnama_dealer desc
									");
								}else{
								
	  		$q = $this->db->query("select a.intno_nota intno_nota, a.intid_nota, upper(b.strnama_dealer) strnama_dealer, b.strnama_upline, upper(d.strnama_unit) strnama_unit, a.datetgl, a.is_asi
									from nota a,member b,unit d
                                    where
									a.intid_dealer = b.intid_dealer
									and d.intid_unit = b.intid_unit
									and a.intid_cabang = '".$cabang."' and a.datetgl = '".$postkata."'
									order by b.strnama_dealer desc
									");
								}
			
			return $q;						
	}
	//	@param show_boom_member_data
	//	desc : untuk perulangan boom, mendapatkan nilai
	//	author : ikhlas firlana ifirlana@gmail.com
	//	pembuatan : 10 agustus 2013
	//	tanggal : 13 september 2013 - 09:15
	//	
	function show_boom_member_data($data){
		$select = "select if(sum(nota.inttotal_omset) is null, 0, sum(nota.inttotal_omset)) inttotal_omset, 
						member.strkode_dealer, 
						member.strkode_upline, 
						member.strnama_dealer,
						member.intlevel_dealer,
						member.intparent_leveldealer,
						member.intid_dealer,
						nota.intid_unit 

					from 
					(select * from member where member.strkode_dealer = '".$data['strkode_dealer']."'
						) AS member 
					left join nota on member.intid_dealer = nota.intid_dealer 
					where
						nota.datetgl BETWEEN '".$data['tglstart']."' AND '".$data['tglend']."' 
					and nota.is_dp = 0
					and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9 or nota.intid_jpenjualan = 16)";
		//echo $select."<br />";
		$query = $this->db->query($select);
		return $query;
	}
	function get_anak_langsung($strkode_dealer){
		$select = "select * from member where strkode_upline = '$strkode_dealer' order by intid_week";
		return $this->db->query($select);
	} 	
//end 
	//@param get_CetakKeuanganMingguanSpecialBandung
	// desc : digunakan untuk bandung only
	function get_CetakKeuanganMingguanSpecialBandung($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 14
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	//@param get_CetakKeuanganBulananSpecialBandung
	// desc : digunakan untuk bandung only
	function get_CetakKeuanganBulananSpecialBandung($cabang, $month)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 14
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	//added 20140314
	//@param get_CetakKeuanganBulananSpecialBandung
	// desc : digunakan untuk bandung only
	function get_CetakKeuanganBulananSpecialBandung_tahun($cabang, $month, $tahun)
	{ 
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang 
				and a.intid_jpenjualan = 14
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	//@param get_CetakPenjualanArisanBulanan_tahun
	//desc :
		function get_CetakPenjualanArisanBulanan_tahun($month, $cabang,$tahun)
	{
		
		$select	= "select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, h.intharga_jawa, 
		(select sum(inttotal_omset) 
			from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
			and YEAR(nota.datetgl) = $tahun 
			and nota.intid_cabang 	= $cabang 
			and nota.intid_jpenjualan	= 1 
			and nota.is_arisan 		= 1 
			and nota.intid_nota = a.intid_nota) as inttotal_omset, 
		a.intid_jpenjualan, 
		(select sum(intpv) 
			from nota where nota.intid_week	 in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')  
			and YEAR(nota.datetgl)					= $tahun 
			and nota.intid_cabang					= $cabang 
			and nota.intid_jpenjualan				= 1 
			and nota.is_arisan 						= 1 
			and nota.intid_nota = a.intid_nota)as intpv, 
		sum(e.intquantity)intquantity, 
		(select sum(inttotal_bayar) 
			from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')  
			and YEAR(nota.datetgl) = $tahun 
			and nota.intid_cabang = $cabang 
			and nota.intid_jpenjualan = 1 
			and nota.is_arisan = 1
			and nota.intid_nota = a.intid_nota) inttotal_bayar,	
		(h.intcicilan_jawa*(sum(e.intquantity))*1) as cicilan, 
		(select sum(intkomisi10) 
			from nota where nota.intid_week  in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
			and YEAR(nota.datetgl) = $tahun 
			and nota.intid_cabang = $cabang 
			and nota.intid_jpenjualan = 1 
			and nota.is_arisan = 1 
			and nota.intid_nota = a.intid_nota) as intkomisi10, 
		(select sum(intkomisi20) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')  
			and YEAR(nota.datetgl) = $tahun 
			and nota.intid_cabang = $cabang 
			and nota.intid_jpenjualan = 1 
			and nota.is_arisan = 1 
			and nota.intid_nota = a.intid_nota) as intkomisi20,
		(select sum(nota_detail.intharga*nota_detail.intquantity) from nota_detail where nota_detail.intid_nota = a.intid_nota) retail
		from 
		nota a LEFT JOIN
		member b ON a.intid_dealer = b.intid_dealer
		left JOIN cabang c ON a.intid_cabang = c.intid_cabang
		LEFT JOIN unit d on a.intid_unit = d.intid_unit
		LEFT JOIN nota_detail e on a.intid_nota = e.intid_nota
		LEFT JOIN barang f ON e.intid_barang = f.intid_barang
		LEFT JOIN harga h ON f.intid_barang = h.intid_barang
		where a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and e.is_free = 0
		and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
		and YEAR(a.datetgl) = $tahun
		#and a.intid_dealer = b.intid_dealer
		and a.intid_cabang = $cabang
		#and a.intid_nota = e.intid_nota
		#and a.intid_cabang = c.intid_cabang
		#and a.intid_unit = d.intid_unit
		#and e.intid_barang = f.intid_barang
		#and f.intid_barang = h.intid_barang
		group by a.intid_nota
		order by d.strnama_unit asc, b.strnama_upline asc";
		/*
		$query = $this->db->query("select a.datetgl, a.intno_nota, upper(b.strnama_dealer) strnama_dealer, upper(b.strnama_upline) strnama_upline, 
		upper(d.strnama_unit)strnama_unit,upper(c.strnama_cabang) strnama_cabang, a.intid_week,  
		c.intid_wilayah, h.intcicilan_jawa, h.intcicilan_luarjawa, 
		h.intum_jawa, h.intum_luarjawa, h.intharga_jawa, 
		(select sum(inttotal_omset) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
			and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 
			and nota.is_arisan = 1 
			and year(nota.datetgl) = '$tahun' 
			and nota.intid_nota = a.intid_nota) as inttotal_omset, 
		a.intid_jpenjualan,
		(select sum(intpv) from nota 
			where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
			and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 
			and nota.is_arisan = 1 
			and year(nota.datetgl) = $tahun
			and nota.intid_nota = a.intid_nota)as intpv, 
		sum(e.intquantity)intquantity, 
		(select sum(inttotal_bayar) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') 
			and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 
			and year(nota.datetgl) = $tahun
			and nota.intid_nota = a.intid_nota) inttotal_bayar,	
		(h.intcicilan_jawa*(sum(e.intquantity))*1) as cicilan, 
		(select sum(intkomisi10) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and year(nota.datetgl) = '$tahun' and nota.intid_nota = a.intid_nota) as intkomisi10, 
		(select sum(intkomisi20) from nota where nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun') and nota.intid_cabang = $cabang and nota.intid_jpenjualan = 1 and nota.is_arisan = 1 and year(nota.datetgl) = '$tahun' and nota.intid_nota = a.intid_nota) as intkomisi20,
		(select sum(nota_detail.intharga*nota_detail.intquantity) from nota_detail where nota_detail.intid_nota = a.intid_nota) retail
		from #nota a, member b, cabang c, unit d, nota_detail e, barang f, harga h
		nota a 
LEFT JOIN member b ON a.intid_dealer = b.intid_dealer 
LEFT JOIN cabang c ON a.intid_cabang = c.intid_cabang 
LEFT JOIN unit d ON a.intid_unit = d.intid_unit 
LEFT JOIN nota_detail e ON a.intid_nota = e.intid_nota
LEFT JOIN barang f ON e.intid_barang = f.intid_barang
LEFT JOIN harga h ON f.intid_barang = h.intid_barang
		where a.intid_jpenjualan = 1
		and a.is_arisan = 1
		and e.is_free = 0
		and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
		and year(a.datetgl) = '$tahun'
		and a.intid_dealer = b.intid_dealer
		and a.intid_cabang = $cabang
		#and a.intid_nota = e.intid_nota
		#and a.intid_cabang = c.intid_cabang
		#and a.intid_unit = d.intid_unit
		#and e.intid_barang = f.intid_barang
		#and f.intid_barang = h.intid_barang
		group by a.intid_nota
		order by d.strnama_unit asc, b.strnama_upline asc");
		*/
		$query = $this->db->query($select);
        return $query->result();
	}
	
	//added 20140314
	//used 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananReguler_tahun($cabang, $month,$tahun)
	{
		$query = $this->db->query("SELECT n AS intno_nota, IF(ot > 0 AND ot IS NOT NULL, ot - v, ot) AS omsettulip, IF((ot IS NULL OR ot < v) AND (otc IS NULL OR otc < v), om - v, om) AS omsetmetal, IF((ot IS NULL OR ot < v) AND (otc > v AND otc IS NOT NULL), otc - v, otc) AS omsettc FROM 
(SELECT IF(dt IS NULL, IF(dm IS NULL,dtc,dm), dt) AS d, IF(nt IS NULL, IF(nm IS NULL,ntc,nm), nt) AS n, ot, om, otc FROM (SELECT * FROM 
(SELECT intid_dealer AS dt, intno_nota AS nt, SUM(totalharga) AS ot FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
LEFT JOIN 
(SELECT intid_dealer AS dm, intno_nota AS nm, SUM(totalharga) AS om FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month')  AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
ON omsettulip.nt = omsetmetal.nm
LEFT JOIN
(SELECT intid_dealer AS dtc, intno_nota AS ntc, SUM(totalharga) AS otc FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.nt = omsettc.ntc OR omsetmetal.nm = omsettc.ntc
UNION
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal 
ON omsettulip.intno_nota = omsetmetal.intno_nota
LEFT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota
UNION 
SELECT * FROM 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 1 GROUP BY intno_nota) AS omsettulip 
RIGHT JOIN 
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 2 GROUP BY intno_nota) AS omsetmetal
ON omsettulip.intno_nota = omsetmetal.intno_nota
RIGHT JOIN
(SELECT intid_dealer, intno_nota, SUM(totalharga) AS omsettulip FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week in (select intid_week from week where intbulan = '$month') AND year(a.datetgl) = $tahun AND a.intid_cabang = $cabang AND a.intid_jpenjualan = 1 AND a.is_arisan = 0 AND nota_detail.is_free = 0 GROUP BY intno_nota, intid_jbarang) AS z WHERE intid_jbarang = 3 GROUP BY intno_nota) AS omsettc
ON omsettulip.intno_nota = omsettc.intno_nota OR omsetmetal.intno_nota = omsettc.intno_nota) AS omset
) AS omset
LEFT JOIN 
(SELECT intid_dealer AS dv, intno_nota AS nv, intvoucher AS v FROM nota) AS voucher
ON omset.n = voucher.nv
ORDER BY intno_nota");
        
		return $query->result(); 
		
	}
	
	//added 20140314
	//used 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananHut_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 2
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 2
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 2
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
		 
	}
	
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananChallenge_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) = $tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) = $tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) = $tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) = $tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) = $tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 3
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(nota.datetgl) = $tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 3
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 3
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
         
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananTrade_tahun($cabang, $month, $tahun)
	{
		
		/* $query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 OR b.is_diskon = 0.70 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 OR b.is_diskon = 0.60 THEN a.inttotal_omset ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 OR b.is_diskon = 0.50 THEN a.inttotal_omset ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0");
         */$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 OR b.is_diskon = 0.70 THEN sum(b.intomset) ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 OR b.is_diskon = 0.60 THEN sum(b.intomset) ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 OR b.is_diskon = 0.50 THEN sum(b.intomset) ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 4
				and b.is_free = 0
				and a.is_dp = 0
				group by b.is_diskon,b.intid_nota
				");
        
		return $query->result();
	}
	/* function get_CetakKeuanganBulananSerbu_tahun($cabang, $month, $tahun)
	{
		
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				CASE WHEN a.inttrade_in = 30 THEN a.inttotal_omset ELSE 0 END AS omsett30,
				CASE WHEN a.inttrade_in = 40 THEN a.inttotal_omset ELSE 0 END AS omsett40,
				CASE WHEN a.inttrade_in = 50 THEN a.inttotal_omset ELSE 0 END AS omsett50
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 22
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	} */
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananFreeHut_tahun($cabang, $month,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and intid_cabang = $cabang
				and intid_jpenjualan = 5
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and nota.intid_cabang = $cabang
				and nota.intid_jpenjualan = 5
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and year(datetgl) =$tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 5
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan  
	function get_CetakKeuanganBulananFree_tahun($cabang, $month,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang 
				and year(datetgl) = $tahun
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(datetgl) = $tahun
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 6
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 6
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun)
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 6
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananNetto_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=1
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettulip,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=2
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsetmetal,
				(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
				from nota
				where intid_week in (select intid_week from week where intbulan = '$month')
				and intid_cabang = $cabang
				and year(datetgl) = $tahun
				and intid_jpenjualan = 7
				and is_arisan = 0
				and intid_nota = a.intid_nota)
				from nota, nota_detail, barang 
				where nota.intid_nota = nota_detail.intid_nota
				and nota_detail.intid_barang = barang.intid_barang
				and nota.intid_week in (select intid_week from week where intbulan = '$month')
				and nota.intid_cabang = $cabang
				and year(nota.datetgl) = $tahun
				and nota.intid_jpenjualan = 7
				and nota_detail.is_free = 0
				and barang.intid_jbarang=3
				and nota.is_arisan = 0
				and nota.is_dp = 0
				and nota.intid_nota = a.intid_nota) as omsettc
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 7
				and b.is_free = 0
				and a.is_dp = 0
				order by a.intno_nota");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuagan bulanan
	function get_CetakKeuanganBulananSK_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select sum(inttotal_bayar) total from nota where intid_jpenjualan=10 and substr(datetgl,6,2) = '$month' and intid_cabang= $cabang and year(datetgl) = $tahun");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananLain_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang not in (4,5,7) #= 6 
						THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_lgOval = 0
				group by a.intid_nota");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananLain_Ovaltahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						#(CASE WHEN c.intid_jbarang = 6 THEN a.inttotal_bayar ELSE 0 END) AS omsetll
						(CASE WHEN c.intid_jbarang not in (4,5,7) THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and year(a.datetgl) = $tahun
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 8
				and c.strnama not like 'undangan%'
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_lgOval = 1
				
				group by a.intid_nota");
        
		return $query->result();
	}
	/* tambahan buat charity
	keuangan bulanan
	19 mei 2015 --------------ef*/
	 function get_CetakKeuanganBulananLainOval_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select (CASE WHEN c.intid_jbarang = 5 THEN a.inttotal_bayar  ELSE 0 END) AS omsetlg,
						(CASE WHEN c.intid_jbarang not in (4,5,7) THEN a.inttotal_bayar ELSE 0 END) AS omsetll
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				#and a.intid_week = $week
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 8
				and b.is_free = 0
				and c.strnama not like 'undangan%'
				and a.is_dp = 0
				and a.is_lgOval = 1
				group by a.intid_nota");
        
		return $query->result();
	} 
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananSpesial_tahun($cabang, $month, $tahun) 
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 11
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananPoint_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 12
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/* 
		added 2014 08 2014
		laporan keuangan bulanan diskon 40%
	*/
	function get_CetakKeuanganBulananDiskon40_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 16
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/* 
		added 2014 08 2014
		laporan keuangan bulanan diskon 40%
	*/
	function get_CetakKeuanganBulananAgogo_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 21
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}function get_CetakKeuanganBulananSerbu_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 22
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananCepek_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 23
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananHoki75_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 28
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananHoki150_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 29
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananSurprise_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select sum(a.inttotal_bayar) inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 25
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananWaffle_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select sum(a.inttotal_bayar) inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 27
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananChallSC_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 26
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganBulananDiskon50_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 18
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananDiskon60_tahun($cabang, $month, $tahun)
	{ 
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 19
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	function get_CetakKeuanganBulananDiskon35_tahun($cabang, $month, $tahun)
	{ 
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month' and inttahun = '$tahun')
				and year(a.datetgl) = '$tahun'
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 20
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananMetal50_tahun($cabang, $month,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 13
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananKomisi_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi15) komisi15,  sum(nota.intkomisi20) komisi20 , sum(nota.otherKom) kotam
									from nota 
									where nota.is_dp = 0
									and nota.intid_week in (select intid_week from week where intbulan = '$month')
									and nota.intid_cabang = $cabang
									and year(nota.datetgl) = $tahun
									and nota.is_arisan = 0"); 
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function selectPembayaranBulanan_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select * from pembayaran where intid_cabang = $cabang and intid_week in (select intid_week from week where intbulan = '$month' and inttahun = $tahun) and year(datetanggal) = $tahun");
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function selectTotalPembayaranBulanan_tahun($cabang, $month,$tahun)
	{
		$month = $month-1;
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week in (select intid_week from week where intbulan = ($month) and inttahun = $tahun) and a.intid_cabang = $cabang and year(a.datetgl) = $tahun and is_dp = 0 ) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week in (select intid_week from week where intbulan = ($month)  and inttahun = $tahun) and year(datetgl) = $tahun and intid_cabang = $cabang and is_dp = 1 ) b  
		");
        return $query->result();
	}
	function selectTotalPembayaranBulanan_tahunsebelum($cabang, $month,$tahun)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where  a.intid_cabang = $cabang and year(a.datetgl) >= 2014 and year(a.datetgl) < $tahun and is_dp = 0 ) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where year(datetgl) >= 2014 and year(datetgl) < $tahun and intid_cabang = $cabang and is_dp = 1 ) b  
		");
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function selectTotalPembayaranBulananTrade_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select a.total_bayar + b.total_dp total_bayar
		from 
		(select ifnull(sum(a.inttotal_bayar), 0) total_bayar from nota a where a.intid_week in (select intid_week from week where intbulan = ($month-1)) and a.intid_cabang = $cabang and is_dp = 0 and a.intid_jpenjualan = 4 and year(a.datetgl) = $tahun) a, 
		(select ifnull(sum(intdp), 0) total_dp from nota where intid_week in (select intid_week from week where intbulan = ($month-1)) and intid_cabang = $cabang and year(datetgl) = $tahun and is_dp = 1 and intid_jpenjualan = 4) b
		");
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function selectTotalBayarBulanan_tahun($cabang, $month,$tahun)
	{
		$month = $month - 1;
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where intid_week in (select intid_week from week where intbulan = ($month) and inttahun = $tahun) and  year(datetanggal) = $tahun and intid_cabang = $cabang");
        return $query->result();
	}
	function selectTotalBayarBulanan_tahunsebelum($cabang, $month,$tahun)
	{
		$query = $this->db->query("select sum(nominal_bayar) sudah_bayar from pembayaran where  year(datetanggal) >= 2014 and  year(datetanggal) < $tahun and intid_cabang = $cabang");
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	 function cek_bulan_start_tahun($bulan, $tahun) {
        $this->db->select('week.intid_week, week.dateweek_start');
        $this->db->from('week');
        $this->db->where('week.intbulan', $bulan);
        $this->db->where('week.inttahun', $tahun);
        $this->db->order_by('week.intid_week');
        return $this->db->get()->result();
    } 
	
	//added 20140314
	//laporan keuangan bulanan
	function cek_bulan_end_tahun($bulan, $tahun) {
        $this->db->select('max(week.intid_week) intid_week, max(week.dateweek_end) dateweek_end');
        $this->db->from('week');
        $this->db->where('week.intbulan', $bulan);
        $this->db->where('week.inttahun', $tahun);
        $this->db->order_by('week.intid_week');
        return $this->db->get()->result();
    }
	
	//added 20140314
	//laporan keuangan bulanan
	//modified 2015 08 11
	function get_CetakKeuanganBulananDP_tahun($cabang, $month, $tahun)
	{
		/*
		$select = " select sum(intcash) intcash 
					from
					(select sum(intdp) intcash 
						from nota 
						where 
						nota.is_dp = 1
						and nota.intid_week in (select intid_week from week where intbulan = '$month')
						and nota.intid_cabang = $cabang
						and year(datetgl) = $tahun
					UNION
						SELECT sum(total_cost - cash) intcash
						from 
						_instalment 
						where 
							_instalment.date >= (select min(dateweek_start) from week where intbulan = '$month' and inttahun = $tahun)
							and _instalment.date <= (select max(dateweek_end) from week where intbulan = '$month' and inttahun = $tahun)
							and _instalment.id_branch = $cabang) x";
		/*
		$query = $this->db->query("select sum(intdp) intcash
					from nota a
					where a.is_dp = 1
					and a.intid_week in (select intid_week from week where intbulan = '$month')
					and a.intid_cabang = $cabang
					and year(a.datetgl) = $tahun");
		*
		$query = $this->db->query($select);
        return $query->result();
        */
        $dp = array();
        $query = $this->db->query("select intid_week from week where intbulan = $month and inttahun = $tahun");
        foreach ($query->result() as $row) 
        {
        	$dp[]['result'] = $this->get_CetakKeuanganMingguanDP_tahun($cabang, $row->intid_week,$tahun);
      	}
      	return $dp;
 	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananKomisiArisan_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select sum(nota.intkomisi10) komisi10, sum(nota.intkomisi20) komisi20, sum(nota.inttotal_omset) omset,  sum(nota.inttotal_bayar) netto
									from nota 
									where nota.is_dp = 0
									and nota.intid_week in (select intid_week from week where intbulan = '$month')
									and nota.intid_cabang = $cabang
									and year(nota.datetgl) = $tahun
									and nota.is_arisan = 1
									and nota.intid_jpenjualan = 1");
        return $query->result();
	}
	
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananArisan_tahun($cabang, $month, $tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 1
				and b.is_free = 0
				and a.is_dp = 0
				and a.is_arisan = 1");
        
		return $query->result();
	}
	
	//added 20140314
	//used 20140314
	//laporan keuangan bulanan
	function get_Week_tahun($month, $tahun){
		
		$query = $this->db->query("select intbulan, intid_week, date_format(dateweek_start, '%d %M %Y') AS dateweek_start, date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intbulan = $month and inttahun = $tahun");
        return $query->result();
	}
	
	/**
	* @param get_CetakKeuanganMingguanPromoRekrut_tahun
	* ikhlas firlana 6 jan 2014 ifirlana@gmail.com
	* desc :
	*/
	function get_CetakKeuanganMingguanPromoRekrut_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 17
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	//added 20140314
	//laporan keuangan bulanan
	function get_CetakKeuanganBulananPromoRekrut_tahun($cabang, $month, $tahun) 
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_bayar 
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week in (select intid_week from week where intbulan = '$month')
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 17
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	///////////////Tulip Agogo///////////////////////
	/* 
		ikhlas line 
		ifirlana@gmail.com 2014 11 25
		desc : membuat perhitungan keuangan week.
	*/
		function get_CetakKeuanganAgogo($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 21
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}	
	function get_CetakKeuanganSerbu($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 22
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganCepek($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 23
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHoki75($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 28
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
	function get_CetakKeuanganHoki150($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 29
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	
		function get_CetakKeuanganSurprise($cabang, $week,$tahun)
	{
		/* $query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and a.intid_jpenjualan = 25
				and b.is_free = 0
				and a.is_dp = 0"); */
			$query = $this->db->query("select sum(inttotal_bayar) inttotal_bayar from nota
									where 
									intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = 25
									and year(datetgl) = $tahun
									and is_dp = 0");
		return $query->result();
	}
	
	function get_CetakKeuanganWaffle($cabang, $week,$tahun)
	{
			$query = $this->db->query("select sum(inttotal_bayar) inttotal_bayar from nota
									where 
									intid_week = $week
									and intid_cabang = $cabang
									and intid_jpenjualan = 27
									and year(datetgl) = $tahun
									and is_dp = 0");
		return $query->result();
	}
	
	function get_CetakKeuanganChallSC($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota), a.inttotal_omset, a.intkomisi10, a.intkomisi20 , a.inttotal_bayar
				from nota a, nota_detail b, barang c
				where a.intid_nota = b.intid_nota
				and b.intid_barang = c.intid_barang 
				and a.intid_week = $week
				and a.intid_cabang = $cabang
				and year(a.datetgl) = $tahun
				and a.intid_jpenjualan = 26
				and b.is_free = 0
				and a.is_dp = 0");
        
		return $query->result();
	}
	/**
	* ifirlana@gmail ikhlas firlana
	* 10 desember 2014
	*	UNDANGAN / VOUCHER
	*/
	function getUndanganTotalHarian($datetgl = 0,$intid_cabang)
	{
		$select = "SELECT
								cabang.strnama_cabang,
								member.intid_dealer,
								member.strkode_dealer,
								member.strnama_dealer,
								sum(nota.intvoucher) intvoucher_nota,
								sum(nota_detail.intquantity * nota_detail.intvoucher) intvoucher_nota_detail,		
								sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1)) * if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,1))) undangan_nota,
								sum(if(nota_detail.intvoucher !=0 , 
											if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,0)) * nota_detail.intquantity,0)) undangan_nota_detail,	
								sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1))) total_undangan_nota,
								sum(if(nota_detail.intvoucher !=0,nota_detail.intquantity,0)) total_undangan_nota_detail
							FROM
								nota, nota_detail, member, cabang
							WHERE
								nota.intid_nota = nota_detail.intid_nota
								and member.intid_dealer = nota.intid_dealer
								and cabang.intid_cabang = nota.intid_cabang
								and nota.intid_cabang = ".$intid_cabang."
								and nota.datetgl ='".$datetgl."'
								group by nota.intid_dealer";
		return $this->db->query($select);		
	}
	
	//
	function getUndanganTotalWeek($intid_week = 0, $inttahun = 0,$intid_cabang)
	{
	/**
		$select = "SELECT
							nota.intno_nota,
							nota.datetgl,
							cabang.strnama_cabang,
							member.intid_dealer,
							member.strkode_dealer,
							member.strnama_upline,
							unit.strnama_unit,
							member.strnama_dealer,
							sum(nota.intvoucher) intvoucher_nota,
							sum(nota_detail.intquantity * nota_detail.intvoucher) intvoucher_nota_detail,		
							sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1)) * if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,1))) undangan_nota,
							sum(if(nota_detail.intvoucher !=0 , 
										if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,0)) * nota_detail.intquantity,0)) undangan_nota_detail,	
							sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1))) total_undangan_nota,
							sum(if(nota_detail.intvoucher !=0,nota_detail.intquantity,0)) total_undangan_nota_detail
						FROM
							nota, nota_detail, member, cabang, unit
						WHERE
							nota.intid_nota = nota_detail.intid_nota
							and member.intid_dealer = nota.intid_dealer
							and cabang.intid_cabang = nota.intid_cabang
							and nota.intid_unit = unit.intid_unit
							and nota.intid_cabang = ".$intid_cabang."
							and nota.intid_week in (".$intid_week.")
							and year(datetgl) = ".$inttahun."
							group by nota.intid_nota";
							*/
		$select = "select *
							FROM
							(select 
							member.*,
							unit.strnama_unit,
							cabang.strnama_cabang,
							v1.undangan_nota_detail,
							v1.intvoucher_nota_detail,
							v1.total_undangan_nota_detail,
							'0' as undangan_nota,
							'0' as intvoucher_nota,
							'0' as total_undangan_nota
							from 
							(select 
								member.*,
								nota.datetgl,
								nota.intno_nota,
								nota.intid_nota
								from nota,member where
								nota.intid_dealer = member.intid_dealer	
								and nota.intid_week in ($intid_week)
								and nota.intid_cabang = $intid_cabang
								and YEAR(nota.datetgl) =  $inttahun
								group by nota.intid_nota) member,
							cabang,
							unit,
							(SELECT 
										a.intid_nota,
										sum(if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity)  undangan_nota_detail,
										sum(b.intquantity * b.intvoucher) intvoucher_nota_detail,
										sum(if(b.intvoucher !=0,b.intquantity,0)) total_undangan_nota_detail
									FROM
										NOTA a, CABANG cb, NOTA_DETAIL b
									WHERE
										a.intid_nota = b.intid_nota
										and cb.intid_cabang = a.intid_cabang
										and a.intid_week in ($intid_week)
										and a.intid_cabang = $intid_cabang
										and YEAR(a.datetgl) =  $inttahun
										and a.is_vpromo = 0
										and a.is_dp = 0
										and b.intvoucher != 0
									GROUP BY a.intid_nota) as v1 
							where 
								member.intid_nota = v1.intid_nota
								and member.intid_cabang = cabang.intid_cabang
								and member.intid_unit = unit.intid_unit) Y";
	return $this->db->query($select);
	//return $select;
	}
	
	// 
	function getUndanganTotalMonth($intbulan = 0, $inttahun = 0,$intid_cabang)
	{
		/**
		$select = "SELECT
							nota.intno_nota,
							nota.datetgl,
							cabang.strnama_cabang,
							member.intid_dealer,
							member.strkode_dealer,
							member.strnama_upline,
							unit.strnama_unit,
							member.strnama_dealer,
							sum(nota.intvoucher) intvoucher_nota,
							sum(nota_detail.intquantity * nota_detail.intvoucher) intvoucher_nota_detail,		
							sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1)) * if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,1))) undangan_nota,
							sum(if(nota_detail.intvoucher !=0 , 
										if(cabang.intid_wilayah = 1, 25000,if(cabang.intid_wilayah = 2, 30000,0)) * nota_detail.intquantity,0)) undangan_nota_detail,	
							sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1))) total_undangan_nota,
							sum(if(nota_detail.intvoucher !=0,nota_detail.intquantity,0)) total_undangan_nota_detail
						FROM
							nota, nota_detail, member, cabang, unit
						WHERE
							nota.intid_nota = nota_detail.intid_nota
							and member.intid_dealer = nota.intid_dealer
							and cabang.intid_cabang = nota.intid_cabang
							and nota.intid_unit = unit.intid_unit
							and nota.intid_cabang = ".$intid_cabang."
							and nota.intid_week in (select intid_week from week where intbulan = ".$intbulan." and inttahun = ".$inttahun.")
							and year(datetgl) = ".$inttahun."
							group by nota.intid_nota";
							*/
	
		$select = "select *
							FROM
							(select 
							member.*,
							unit.strnama_unit,
							cabang.strnama_cabang,
							v1.undangan_nota_detail,
							v1.intvoucher_nota_detail,
							v1.total_undangan_nota_detail,
							v2.undangan_nota,
							v2.intvoucher_nota,
							v2.total_undangan_nota
							from 
							(select 
								member.*,
								nota.datetgl,
								nota.intno_nota,
								nota.intid_nota
								from nota,member where
								nota.intid_dealer = member.intid_dealer	
								and nota.intid_week in (select intid_week from week where intbulan = ".$intbulan." and inttahun = ".$inttahun.")
								and nota.intid_cabang = $intid_cabang
								and YEAR(nota.datetgl) =  $inttahun
								group by nota.intid_nota) member,
							cabang,
							unit,
							(SELECT 
										a.intid_nota,
										sum(if(b.intvoucher !=0 , 
													if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail,
										sum(b.intquantity * b.intvoucher) intvoucher_nota_detail,
										sum(if(b.intvoucher !=0,b.intquantity,0)) total_undangan_nota_detail
									FROM
										NOTA a, CABANG cb, NOTA_DETAIL b
									WHERE
										a.intid_nota = b.intid_nota
										and cb.intid_cabang = a.intid_cabang
										and a.intid_week in (select intid_week from week where intbulan = ".$intbulan." and inttahun = ".$inttahun.")
										and a.intid_cabang = $intid_cabang
										and YEAR(a.datetgl) =  $inttahun
										and a.is_vpromo = 0
									GROUP BY a.intid_nota) as v1,
							(SELECT 
										a.intid_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1))) total_undangan_nota,
										sum(a.intvoucher) intvoucher_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
									FROM
										NOTA a, CABANG cb
									WHERE
										 cb.intid_cabang = a.intid_cabang
										and a.intid_week in (select intid_week from week where intbulan = ".$intbulan." and inttahun = ".$inttahun.")
										and a.intid_cabang = $intid_cabang
										and YEAR(a.datetgl) =  $inttahun
										and a.is_vpromo = 0
									GROUP BY a.intid_nota) as v2
							where 
								member.intid_nota = v1.intid_nota
								and member.intid_nota = v2.intid_nota
								and member.intid_cabang = cabang.intid_cabang
								and member.intid_unit = unit.intid_unit) Y";
	return $this->db->query($select);
	}	 
	function getUndanganTotalDayHarian($datetgl, $intid_cabang,$string = false)
	{
		$select = "select '' as intno_nota,
					(select strnama_unit from unit where unit.intid_unit = Y.intid_unit) strnama_unit,		
					0 as is_dp,		
					0 as inttotal_omset,		
					0 as sk,		
					0 as lg,		
					0 as ll,		
					0 as intdp,		
					(Y.undangan_nota_detail) inttotal_bayar,		
					0 as intkkredit,		
					0 as intdebit,		
					(Y.undangan_nota_detail) as intcash,		
					'undangan' as strnama_jpenjualan,		
					Y.*		
		from (".$this->getUndanganTotalDay($datetgl, $intid_cabang, true).") Y where Y.undangan_nota_detail != 0";
		if($string == false)
		{
			return $this->db->query($select);
		}else if($string == true)
		{
			return $select;
		}
	}
	//
	function getUndanganTotalDay($datetgl = "",$intid_cabang, $string = false)
	{
		/*
		$select = "select *
							FROM
							(select 
							member.*,
							unit.strnama_unit,
							cabang.strnama_cabang,
							v1.undangan_nota_detail,
							v1.intvoucher_nota_detail,
							v1.total_undangan_nota_detail,
							v2.undangan_nota,
							v2.intvoucher_nota,
							v2.total_undangan_nota
							from 
							(select 
								member.*,
								nota.datetgl,
								nota.intno_nota,
								nota.intid_nota
								from nota,member where
								nota.intid_dealer = member.intid_dealer	
								and nota.datetgl = '$datetgl'
								and nota.intid_cabang = $intid_cabang
								group by nota.intid_nota) member,
							cabang,
							unit,
							(SELECT 
										a.intid_nota,
										sum(if(b.intvoucher !=0 , 
													if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail,
										sum(b.intquantity * b.intvoucher) intvoucher_nota_detail,
										sum(if(b.intvoucher !=0,b.intquantity,0)) total_undangan_nota_detail
									FROM
										NOTA a, CABANG cb, NOTA_DETAIL b
									WHERE
										a.intid_nota = b.intid_nota
										and cb.intid_cabang = a.intid_cabang
										and a.datetgl = '$datetgl'
										and a.intid_cabang = $intid_cabang
									GROUP BY a.intid_nota) as v1,
							(SELECT 
										a.intid_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1))) total_undangan_nota,
										sum(a.intvoucher) intvoucher_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
									FROM
										NOTA a, CABANG cb
									WHERE
										 cb.intid_cabang = a.intid_cabang
										and a.datetgl = '$datetgl'
										and a.intid_cabang = $intid_cabang
									GROUP BY a.intid_nota) as v2
							where 
								member.intid_nota = v1.intid_nota
								and member.intid_nota = v2.intid_nota
								and member.intid_cabang = cabang.intid_cabang
								and member.intid_unit = unit.intid_unit) Y";
								*/
		$select = "select *
							FROM
							(select 
							member.*,
							unit.strnama_unit,
							cabang.strnama_cabang,
							v1.undangan_nota_detail,
							v1.intvoucher_nota_detail,
							v1.total_undangan_nota_detail
							from 
							(select 
								member.*,
								nota.datetgl,
								nota.intno_nota,
								nota.intid_nota
								from nota,member where
								nota.intid_dealer = member.intid_dealer	
								and nota.datetgl = '$datetgl'
								and nota.intid_cabang = $intid_cabang
								group by nota.intid_nota) member,
							cabang,
							unit,
							(SELECT 
										a.intid_nota,
										sum(if(b.intvoucher !=0 , 
													if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity,0)) undangan_nota_detail,
										sum(b.intquantity * b.intvoucher) intvoucher_nota_detail,
										sum(if(b.intvoucher !=0,b.intquantity,0)) total_undangan_nota_detail
									FROM
										NOTA a, CABANG cb, NOTA_DETAIL b
									WHERE
										a.intid_nota = b.intid_nota
										and cb.intid_cabang = a.intid_cabang
										and a.datetgl = '$datetgl'
										and a.intid_cabang = $intid_cabang
									GROUP BY a.intid_nota) as v1
							where 
								member.intid_nota = v1.intid_nota
								and member.intid_cabang = cabang.intid_cabang
								and member.intid_unit = unit.intid_unit) Y";
		if($string == false)
		{
			return $this->db->query($select);
		}
		else if($string == true)
		{
			return $select;
		}
	}
	//laporan added view sales
	function getVoucher($intid_nota)
	{
		$select =	"select 
							nota.intid_nota, 
							v1+v2 total, 
							(if(nota.intid_wilayah = 1, (v1+v2)*25000,if(nota.intid_wilayah = 2, (v1+v2)*30000,0))) omsetUndangan
							from 
							(select 
								nota.intid_nota, 
								sum(nota.intvoucher / if(cabang.intid_wilayah = 1, 50000,if(cabang.intid_wilayah = 2, 60000,1))) v1,
								cabang.intid_wilayah
								from 
								nota, cabang
								where
								nota.intid_nota = $intid_nota
								and nota.intid_cabang = cabang.intid_cabang
								group by nota.intid_nota
								) nota, 
							(select 
								nota_detail.intid_nota,
									sum(nota_detail.intquantity) v2,
									cabang.intid_wilayah
								from 
								nota,nota_detail, cabang
								where 
								nota_detail.intid_nota = $intid_nota
								and nota.intid_nota = nota_detail.intid_nota
								and nota.intid_cabang = cabang.intid_cabang
								and nota_detail.intvoucher !=0
								group by nota_detail.intid_nota
								) nota_detail
							where
							nota.intid_nota = nota_detail.intid_nota";
		$query = $this->db->query($select);
		$this->db->close();
		return $query;
	}
	//end undangan
	
/*
	get_CetakSales_tahun_jenis_penjualan
	31 Desember 2014
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan diganti keunikannya
*/	
function get_CetakSales_tahun_jenis_penjualan($week, $cabang,$tahun,$jpenjualan)
	{
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7 OR nota.intid_jpenjualan = 26)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select if(nota.intid_jpenjualan = 8, sum(nota_detail.intquantity*nota_detail.intharga), 0)
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and barang.intid_jbarang not in (4,5,7)
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.is_dp, a.intdp, a.intsisa, a.intpv, a.otherKom,a.persen, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
					'' as keterangan_tambahan
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week = $week
					AND YEAR(a.datetgl) = $tahun
					and a.is_dp = 0 
					AND a.intid_jpenjualan = $jpenjualan
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					");
		$this->db->close();
        return $query->result();
	}
	/*
	get_CetakSales_tahun_jenis_penjualan
	31 Desember 2014
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan diganti keunikannya
*/	
function get_CetakDpSales_tahun_jenis_penjualan($week, $cabang,$tahun)
	{
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intsisa, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7 OR nota.intid_jpenjualan = 26)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select if(nota.intid_jpenjualan = 8, sum(nota_detail.intquantity*nota_detail.intharga), 0)
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and barang.intid_jbarang not in (4,5,7)
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.intdp, a.intcash, a.intpv,a.otherKom,a.persen, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
					'' as keterangan_tambahan
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week = $week
					AND YEAR(a.datetgl) = $tahun
					and a.is_dp = 1 
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					");
		$this->db->close();
        return $query->result();
	}
/*
	get_CetakSales_tahun_jenis_penjualan
	31 Desember 2014
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan diganti keunikannya
*/	
function get_CetakSales_tahun_jenis_penjualan_hadiah($week, $cabang,$tahun)
	{
		$query=$this->db->query("SELECT * FROM (
					SELECT a.datetgl, a.intno_nota,  '0' as intid_jpenjualan,
					if(a.jenis_nota is null or a.jenis_nota = '','Hadiah',(select jenis_nota from jenis_nota_hadiah jnh where jnh.kode = a.jenis_nota limit 0,1)) AS strnama_jpenjualan, 
					c.strnama_dealer, 
					c.strnama_upline, 
					d.strnama_unit, 
					' ' AS otherKom,
					' ' AS persen,
					' ' AS inttotal_omset,
					' ' AS intomset10, 
					' ' AS intomset15, 
					' ' AS intomset20, 
					' ' AS omsetnetto, 
					' ' AS omsetspecialprice, 
					' ' AS omsetpoint, 
					' ' AS omsetsk, 
					' ' AS omsetlg, 
					' ' AS omsetll, 
					' ' AS omsettotal_bayar, 
					' ' AS intpv, 
					'0' AS intdp,
					'0' AS is_dp,
					'0' AS inttotal_bayar,
					a.intid_nota, 
					b.strnama_cabang, 
					a.intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart, 
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week  and inttahun = $tahun) AS dateend, 
					' ' AS is_arisan,
					' ' AS winner,
					a.keterangan keterangan_tambahan
					FROM nota_hadiah a left JOIN cabang b ON a.intid_cabang = b.intid_cabang left JOIN member c ON a.intid_dealer = c.intid_dealer left JOIN unit d ON c.intid_unit = d.intid_unit 
					WHERE a.intid_cabang = $cabang AND a.intid_week = $week and  YEAR(a.datetgl) = $tahun) AS x");
		$this->db->close();
        return $query->result();
	}
/*
	get_CetakSales_tahun_jenis_penjualan
	31 Desember 2014
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan diganti keunikannya
*/	
function get_CetakSales_tahun_jenis_penjualan_instalment($week, $cabang,$tahun)
	{
		$query=$this->db->query("SELECT * FROM (
					SELECT 
					a.date datetgl, 
					instalment_number intno_nota,  
					(select nota.intid_jpenjualan from nota, jenis_penjualan where nota.intid_jpenjualan = jenis_penjualan.intid_jpenjualan and nota.intno_nota = a.nota_number) AS intid_jpenjualan,
					(select strnama_jpenjualan from nota, jenis_penjualan where nota.intid_jpenjualan = jenis_penjualan.intid_jpenjualan and nota.intno_nota = a.nota_number) AS strnama_jpenjualan, 
					membership_name strnama_dealer, 
					upline_name strnama_upline, 
					unit_name strnama_unit, 
					' ' AS otherKom,
					' ' AS persen,
					' ' AS inttotal_omset,
					' ' AS intomset10, 
					' ' AS intomset15, 
					' ' AS intomset20, 
					' ' AS omsetnetto, 
					' ' AS omsetspecialprice, 
					' ' AS omsetpoint, 
					' ' AS omsetsk, 
					' ' AS omsetlg, 
					' ' AS omsetll, 
					' ' AS omsettotal_bayar, 
					' ' AS intpv, 
					'0' AS intdp,
					'0' AS is_dp,
					'0' AS inttotal_bayar,
					a.id_nota intid_nota, 
					a.branch_name strnama_cabang, 
					a.week intid_week, 
					(select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart, 
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week  and inttahun = $tahun) AS dateend, 
					' ' AS is_arisan,
					' ' AS winner,
					a.nota_number keterangan_tambahan
					FROM _instalment a 
					left JOIN cabang b ON a.id_branch = b.intid_cabang 
					left JOIN member c ON a.id_user = c.intid_dealer 
					left JOIN unit d ON c.intid_unit = d.intid_unit 
					WHERE a.id_branch = $cabang AND a.week = $week and  YEAR(a.date) = $tahun) AS x");
		$this->db->close();
        return $query->result();
	}
// end.
	/**
	* @param get_CetakKeuanganMingguanChallSC_tahun
	* ikhlas firlana 6 jan 2014
	* desc : ditambahin tahun
	*/
	function get_CetakKeuanganMingguanChallSC_tahun($cabang, $week,$tahun)
	{
		$query = $this->db->query("select DISTINCT(a.intno_nota),
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=1
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettulip,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=2
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsetmetal,
			(select sum(if (inttotal_omset = 0, 0, (nota_detail.intquantity*nota_detail.intharga)))- (select sum(if(inttotal_omset =0, 0, intvoucher))
			from nota
			where intid_week = $week
			and intid_cabang = $cabang
			and year(datetgl) = $tahun
			and intid_jpenjualan = 2
			and is_arisan = 0
			and intid_nota = a.intid_nota) 
			from nota, nota_detail, barang 
			where nota.intid_nota = nota_detail.intid_nota
			and nota_detail.intid_barang = barang.intid_barang
			and nota.intid_week = $week
			and nota.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and nota.intid_jpenjualan = 2
			and nota_detail.is_free = 0
			and barang.intid_jbarang=3
			and nota.is_arisan = 0
			and nota.is_dp = 0
			and nota.intid_nota = a.intid_nota) as omsettc
			from nota a, nota_detail b, barang c
			where a.intid_nota = b.intid_nota
			and b.intid_barang = c.intid_barang
			and a.intid_week = $week
			and a.intid_cabang = $cabang
			and year(datetgl) = $tahun
			and a.intid_jpenjualan = 26
			and b.is_free = 0
			and a.is_dp = 0");
        
		return $query->result();
		 
	}
	/*
	*	@param
	*	@desc laporan mingguan
	*/
	function cetak_laporan_penjualan_mingguan($data = array())
	{
		$select = 
				"select
				omsettulip.intomset10 + omsettulip.intomset15 + omsettulip.intomset20 omsetT,
				n.intid_dealer,
				n.intid_unit
			from
				nota n left join
				(
					".$this->omsettulip($data)."
				) omsettulip
				on n.intid_dealer = omsettulip.intid_dealer
			where
				n.intid_cabang 						= '".$data['intid_cabang']."'
				and	n.intid_week					= '".$data['intid_week']."'
				and	year(n.datetgl)				= '".$data['inttahun']."'
				and omsettulip.intid_dealer	=	n.intid_dealer
			group by
				n.intid_dealer, n.intid_unit";
		return $select;
		//return $this->db->query($select);
	}
	
	//
	// @param omsettulip
	function omsettulip($data)
	{
		$select =	"select 
								sum(nd.intomset10) intomset10,
								sum(nd.intomset15) intomset15,
								sum(nd.intomset20) intomset20,
								n.intid_cabang,
								n.intid_dealer
							from 
								nota n,
								nota_detail nd
							where
								n.intid_cabang 			= ".$data['intid_cabang']."
								and n.intid_week in 	  (".$data['intid_week'].")
								and year(n.datetgl) 	= ".$data['inttahun']."
								and nd.id_jpenjualan	= ".$data['intid_jpenjualan']."
								and n.intno_nota 		= nd.nomor_nota
							group by
								n.intid_dealer, n.intid_cabang";
		return $select;
	}
	//..
	//	@param show_boom_member_data_allmanager
	//	desc : untuk perulangan boom, mendapatkan nilai
	//	author : ikhlas firlana ifirlana@gmail.com
	//	pembuatan : 25 februari 2015
	//	tanggal : 13 september 2013 - 09:15
	//	
	function show_boom_member_data_allmanager($data){
		$select = "select 0 as inttotal_omset, 
						member.strkode_dealer, 
						member.strkode_upline, 
						member.strnama_dealer,
						member.intlevel_dealer,
						member.intparent_leveldealer,
						member.intid_dealer,
						nota.intid_unit 

					from 
					(select * from member where member.intlevel_dealer = 1 and member.intparent_leveldealer =0) AS member 
					left join nota on member.intid_dealer = nota.intid_dealer 
					where
						nota.datetgl BETWEEN '".$data['tglstart']."' AND '".$data['tglend']."' 
					and nota.is_dp = 0
					and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)";
		//echo $select."<br />";
		$query = $this->db->query($select);
		return $query;
	}
	//	@param show_boom_member_data
	//	desc : untuk perulangan boom, mendapatkan nilai
	//	author : ikhlas firlana ifirlana@gmail.com
	//	pembuatan : 10 agustus 2013
	//	tanggal : 13 september 2013 - 09:15
	//	
	function show_boom_member_dataTotal($data){
		$select = "select '0' as  inttotal_omset, 
						member.strkode_dealer, 
						member.strkode_upline, 
						member.strnama_dealer,
						member.intlevel_dealer,
						member.intparent_leveldealer,
						member.intid_dealer,
						nota.intid_unit 

					from 
					(select * from member where member.strkode_dealer = '".$data['strkode_dealer']."'
						) AS member 
					left join nota on member.intid_dealer = nota.intid_dealer 
					where
						nota.datetgl BETWEEN '".$data['tglstart']."' AND '".$data['tglend']."' 
					and nota.is_dp = 0
					and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)";
		//echo $select."<br />";
		$query = $this->db->query($select);
		return $query;
	}
	
	/**
	*
	*	@param getNotaBetween
	*	Desc : mengambil data nota
	*	return string
	*/
	function getNotaBetween($data = array(), $select = "")
	{
		$where = "";
		if(isset($data['intid_cabang']))
		{
			$where .= " nota.intid_cabang = ".$data['intid_cabang']." and";
		}
		
		if(isset($data['intid_jpenjualan']))
		{
			$where .= " nota.intid_jpenjualan = ".$data['intid_jpenjualan']." and";
		}
		
		if(isset($data['dateweek_start']))
		{
			$where .= " nota.dateweek_start >= ".$data['dateweek_start']." and";
		}
		
		if(isset($data['dateweek_end']))
		{
			$where .= " nota.dateweek_end <= ".$data['dateweek_end']." and";
		}
		
		if(isset($data['bulan']) and isset($data['tahun']))
		{
			$where .= " nota.intid_week in (select intid_week from week where intbulan = ".$data['bulan']." and inttahun = ".$data['tahun'].") and";
		}
		
		if(isset($data['tahun']))
		{
			$where .= " year(nota.datetgl) = ".$data['tahun']." and";
		}
		
		if(!isset($data['is_dp']))
		{
			$where .= " nota.is_dp = 0 and";
		}
		else
		{
			$where .= " nota.is_dp = ".$data['is_dp']." and";
		}
		
		$where = substr($where, 0,strlen($where)-4);
		
		if(!isset($select) or $select == "")
		{
			$select	=	"*";
		}
		$where = "where ".$where;
		$select	=	"select ".$select." 
							from
								nota
							".$where;
		return $select;
		//return $this->db->query($select);
	}
	// end..
	
	//untuk semua laporan
	function getLaporanNotaBetween($data)
	{
		$select = $this->getNotaBetween($data);
		return $this->db->query($select);
	}
	/*
	function get_CetakPenjualanUndanganHarian($cabang, $tgl, $string = false)
	{
		$select = "select 
			distinct(a.intno_nota), 
			upper(b.strnama_dealer) strnama_dealer, 
			b.strnama_upline, 
			upper(d.strnama_unit) strnama_unit, 
			upper(c.strnama_cabang) strnama_cabang, 
			a.inttotal_omset, 
			(select intcash from nota 
				where nota.datetgl = '$tgl'
					and nota.intid_cabang = $cabang
					and nota.intdp = 0 and nota.intid_nota = a.intid_nota
					) totalcash, 
					a.intcash, 
					a.intkkredit, 
					a.intdebit, 
					a.intdp, 
					a.inttotal_bayar, 
			(CASE WHEN f.intid_jbarang = 4 THEN a.inttotal_bayar ELSE 0 END) AS sk,
			(CASE WHEN f.intid_jbarang = 5 THEN a.inttotal_bayar ELSE 0 END) AS lg,
			(CASE WHEN a.intid_jpenjualan = 8 AND f.intid_jbarang != 5 THEN a.inttotal_bayar ELSE (select (".$this->getUndanganTotalDay($tgl, $cabang, true).") Z ) END) AS ll, 
				a.datetgl tgl, 
				a.is_dp, 
				jenis_penjualan.strnama_jpenjualan,
				a.intid_jpenjualan
			from 
			nota a inner join cabang c on c.intid_cabang = a.intid_cabang
			inner join member b on b.intid_dealer = a.intid_dealer
			inner join unit d on d.intid_unit = b.intid_unit
			left outer join jenis_penjualan on a.intid_jpenjualan = jenis_penjualan.intid_jpenjualan, 
			nota_detail e, barang f
			where a.intid_nota = e.intid_nota
			and e.intid_barang = f.intid_barang
			and a.datetgl = '$tgl'
			and a.intid_cabang = $cabang
			and e.is_free = 0
UNION
			SELECT intno_nota, 
			strnama_dealer, 
			strnama_upline, 
			strnama_unit, 
			strnama_cabang, 
			'0' AS inttotal_omset, 
			'0' AS totalcash, 
			'0' AS intcash, 
			'0' AS intkkredit, 
			'0' AS intdebit, 
			'0' AS intdp , 
			'0' AS inttotal_bayar, 
			'0' AS sk, 
			'0' AS lg, 
			'0' AS ll, 
			datetgl AS tgl, 
			'0' AS is_dp, 
			'Hadiah' AS strnama_jpenjualan,
			'' AS intid_jpenjualan
			FROM 
			nota_hadiah INNER JOIN cabang ON nota_hadiah.intid_cabang = cabang.intid_cabang 
			INNER JOIN member ON nota_hadiah.intid_dealer = member.intid_dealer 
			INNER JOIN unit ON nota_hadiah.intid_unit = unit.intid_unit 
			WHERE 
			datetgl = '$tgl' AND nota_hadiah.intid_cabang = $cabang
			order by  strnama_jpenjualan asc";
		if($string == false)
		{
			$query = $this->db->query($select);
			return $query->result();
		}
		else if($string == true)
		{
			return $select;
		}
	}
	*/
	function get_CetakPenjualanHarianUndangan($cabang, $tgl, $string = false)
	{
		$select = "select 
			distinct(a.intno_nota), 
			upper(b.strnama_dealer) strnama_dealer, 
			b.strnama_upline, 
			upper(d.strnama_unit) strnama_unit, 
			upper(c.strnama_cabang) strnama_cabang, 
			a.inttotal_omset, 
			(select intcash from nota 
				where nota.datetgl = '$tgl'
					and nota.intid_cabang = $cabang
					and nota.intdp = 0 and nota.intid_nota = a.intid_nota
					) totalcash, 
					a.intcash, 
					a.intkkredit, 
					a.intdebit, 
					a.intdp, 
					a.inttotal_bayar, 
			(CASE WHEN f.intid_jbarang = 4 THEN a.inttotal_bayar ELSE 0 END) AS sk,
			(CASE WHEN f.intid_jbarang = 5 THEN a.inttotal_bayar ELSE 0 END) AS lg,
			(CASE WHEN a.intid_jpenjualan = 8 AND f.intid_jbarang != 5 THEN a.inttotal_bayar ELSE (select if(cabang.intid_wilayah = 1,sum(nota_detail.intquantity) * 25000,sum(nota_detail.intquantity) * 30000) from cabang,nota,nota_detail where nota.intid_nota = nota_detail.intid_nota and nota.intid_cabang = cabang.intid_cabang and nota_detail.intid_nota = a.intid_nota and nota_detail.intvoucher > 0 group by nota_detail.intid_nota) END) AS ll, 
				a.datetgl tgl, 
				a.is_dp, 
				jenis_penjualan.strnama_jpenjualan,
				a.intid_jpenjualan
			from 
			nota a inner join cabang c on c.intid_cabang = a.intid_cabang
			inner join member b on b.intid_dealer = a.intid_dealer
			inner join unit d on d.intid_unit = b.intid_unit
			left outer join jenis_penjualan on a.intid_jpenjualan = jenis_penjualan.intid_jpenjualan, 
			nota_detail e, barang f
			where a.intid_nota = e.intid_nota
			and e.intid_barang = f.intid_barang
			and a.datetgl = '$tgl'
			and a.intid_cabang = $cabang
			and e.is_free = 0
UNION
			SELECT intno_nota, 
			strnama_dealer, 
			strnama_upline, 
			strnama_unit, 
			strnama_cabang, 
			'0' AS inttotal_omset, 
			'0' AS totalcash, 
			'0' AS intcash, 
			'0' AS intkkredit, 
			'0' AS intdebit, 
			'0' AS intdp , 
			'0' AS inttotal_bayar, 
			'0' AS sk, 
			'0' AS lg, 
			'0' AS ll, 
			datetgl AS tgl, 
			'0' AS is_dp, 
			'Hadiah' AS strnama_jpenjualan,
			'' AS intid_jpenjualan
			FROM 
			nota_hadiah INNER JOIN cabang ON nota_hadiah.intid_cabang = cabang.intid_cabang 
			INNER JOIN member ON nota_hadiah.intid_dealer = member.intid_dealer 
			INNER JOIN unit ON nota_hadiah.intid_unit = unit.intid_unit 
			WHERE 
			datetgl = '$tgl' AND nota_hadiah.intid_cabang = $cabang
			order by  strnama_jpenjualan asc";
		if($string == false)
		{
			$query = $this->db->query($select);
			return $query->result();
		}
		else if($string == true)
		{
			return $select;
		}
	}
	
/**
	get_CetakSales_tahun_jenis_penjualan_withdp
	ikhlas firlana ifirlana@gmail.com
	desc : laporan ditambahkan diganti keunikannya
*/	
function get_CetakSales_tahun_jenis_penjualan_withdp($week, $cabang,$tahun,$jpenjualan)
	{
		$query=$this->db->query("SELECT * FROM (select a.datetgl, a.intno_nota, f.intid_jpenjualan, f.strnama_jpenjualan, c.strnama_dealer, c.strnama_upline, d.strnama_unit, 
					a.inttotal_omset, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 5 OR `intid_jpenjualan` = 7), '0', IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 4), a.inttotal_omset, a.intomset10)) AS intomset10, IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset15) AS intomset15,  IF(intid_nota = ANY (SELECT nota.intid_nota FROM `nota` WHERE `intid_jpenjualan` = 7), '0', a.intomset20) AS intomset20, 

					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) - nota.intvoucher 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND (nota.intid_jpenjualan = 5 OR nota.intid_jpenjualan = 7 OR nota.intid_jpenjualan = 26)
					AND nota.intid_nota = a.intid_nota) AS omsetnetto,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 11
					AND nota.intid_nota = a.intid_nota) AS omsetspecialprice,
					(SELECT SUM(nota_detail.intquantity*nota_detail.intharga) 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 12
					AND nota.intid_nota = a.intid_nota) AS omsetpoint,
					(SELECT DISTINCT nota.inttotal_bayar 
					FROM nota INNER JOIN nota_detail ON nota.intid_nota = nota_detail.intid_nota INNER JOIN barang ON nota_detail.intid_barang = barang.intid_barang
					WHERE nota.intid_week = $week
					AND nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					AND nota.intid_jpenjualan = 10
					AND nota.intid_nota = a.intid_nota) AS omsetsk,

					(select sum(nota_detail.intquantity*nota_detail.intharga) 
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and barang.intid_jbarang=5
					and nota.intid_nota = a.intid_nota) as omsetlg,
					(select if(nota.intid_jpenjualan = 8, sum(nota_detail.intquantity*nota_detail.intharga), 0)
					from nota, nota_detail, barang 
					where nota.intid_nota = nota_detail.intid_nota
					and nota_detail.intid_barang = barang.intid_barang
					and nota.intid_week = $week
					and nota.intid_cabang = $cabang
					AND YEAR(nota.datetgl) = $tahun
					and barang.intid_jbarang not in (4,5,7)
					and nota.is_arisan = 0
					and nota.is_dp = 0
					and nota.intid_nota = a.intid_nota) as omsetll,
					a.inttotal_bayar, a.is_dp, a.intdp, a.intsisa, a.intpv, a.otherKom, a.intcash, a.persen, a.intid_nota, b.strnama_cabang, a.intid_week, (select date_format(dateweek_start, '%d %M %Y') AS dateweek_start  from week where intid_week = $week and inttahun = $tahun) AS datestart,
					(select date_format(dateweek_end, '%d %M %Y') AS dateweek_end from week where intid_week = $week and inttahun = $tahun) AS dateend, a.is_arisan, 
					(select winner from arisan where intid_arisan_detail= a.intid_nota) winner,
					'' as keterangan_tambahan,
					(select nomor_nota from nota_detail where nota_detail.intid_nota = a.intid_nota group by nota_detail.intid_nota) nomor_nota
					from 
					nota a left join cabang b on b.intid_cabang = a.intid_cabang 
					left join unit d on d.intid_unit = a.intid_unit 
					left join  jenis_penjualan f on  f.intid_jpenjualan = a.intid_jpenjualan 
					left join member c on c.intid_dealer = a.intid_dealer
					where
					a.intid_cabang = $cabang
					and a.intid_week = $week
					AND YEAR(a.datetgl) = $tahun
					AND a.intid_jpenjualan = $jpenjualan
					order by a.intid_jpenjualan asc, a.intno_nota asc) AS z
					");
		$this->db->close();
        return $query->result();
	}
	function get_CetakPenjualanBetweenDP($dateStart,$dateEnd, $cabang, $jpenjualan)
	{
		$query = $this->db->query("SELECT strnama_dealer, 
		strnama_upline, 
		strnama_cabang, strnama_unit, dateend, datestart, intid_week, intkomisi10, intkomisi20, intpv, inttotal_bayar,
		inttotal_omset, strnama_jpenjualan, 
		intid_jpenjualan, 
		IF(omsett >= v, omsett - v, IF(omsetm < omsett AND omsettc < omsett AND omsett < v, 0, omsett)) AS omsett,
		IF(omsett < v AND omsettc < v, omsetm - v, IF(omsett < omsetm AND omsettc < omsetm AND omsetm < v, 0, omsetm)) AS omsetm,
		IF(omsett < v AND omsettc >= v, omsettc - v, IF(omsett < omsettc AND omsetm < omsettc AND omsettc < v, 0, omsettc)) AS omsettc, 
		omsetlg, 
		omsetll,
		tradein_t,
		tradein_m 
		FROM 
			(SELECT strnama_dealer, strnama_upline, UPPER(strnama_cabang) AS strnama_cabang, 
				strnama_unit,
				(SELECT date_format(dateweek_end, '%d %M %Y') AS dateweek_end FROM week WHERE intid_week = $week) AS dateend,
				(SELECT date_format(dateweek_start, '%d %M %Y') AS dateweek_start FROM week WHERE intid_week = $week) AS datestart,
				z.* 
				FROM 
					(SELECT intid_week, 
						intid_cabang,
						a.intid_dealer, 
						intno_nota, 
						SUM(intkomisi10) AS intkomisi10, 
						SUM(intkomisi20) AS intkomisi20, 
						SUM(intpv) AS intpv, 
						SUM(inttotal_bayar) AS inttotal_bayar, 
						SUM(inttotal_omset) AS inttotal_omset, 
						UPPER(strnama_jpenjualan) AS strnama_jpenjualan, 
						a.intid_jpenjualan FROM nota a INNER JOIN jenis_penjualan ON jenis_penjualan.intid_jpenjualan = a.intid_jpenjualan 
					WHERE a.intid_week = $week AND a.intid_cabang = $cabang 
						AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 1 GROUP BY intid_dealer) 
					AS z 
INNER JOIN member ON z.intid_dealer = member.intid_dealer INNER JOIN cabang ON z.intid_cabang = cabang.intid_cabang INNER JOIN unit ON member.intid_unit = unit.intid_unit INNER JOIN week ON z.intid_week = week.intid_week) AS x
INNER JOIN
(SELECT intid_dealer, 
SUM(omsett) AS omsett, 
SUM(omsetm) AS omsetm, 
SUM(omsettc) AS omsettc, 
SUM(omsetlg) AS omsetlg, 
SUM(omsetll) AS omsetll FROM (SELECT intid_dealer, 
	IF(intid_jbarang = 1, totalharga, 0) AS omsett, 
	IF(intid_jbarang = 2, totalharga, 0) AS omsetm, 
	IF(intid_jbarang = 3, totalharga, 0) AS omsettc, 
	IF(intid_jbarang = 5, totalharga, 0) AS omsetlg, 
	IF(intid_jbarang = 6, totalharga, 0) AS omsetll FROM (SELECT intid_dealer, intno_nota, SUM(intquantity * intharga) AS totalharga, intid_jbarang FROM nota a INNER JOIN nota_detail ON a.intid_nota = nota_detail.intid_nota INNER JOIN barang ON barang.intid_barang = nota_detail.intid_barang WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 1 AND nota_detail.is_free = 0 GROUP BY intid_dealer, intid_jbarang) AS y) AS z GROUP BY intid_dealer) AS y
ON x.intid_dealer = y.intid_dealer
INNER JOIN
(SELECT intid_dealer, SUM(intvoucher) AS v FROM nota a WHERE a.intid_week = $week AND a.intid_cabang = $cabang AND a.intid_jpenjualan = $jpenjualan AND a.is_arisan = 0 AND a.is_dp = 1 GROUP BY intid_dealer) AS z
ON x.intid_dealer = z.intid_dealer

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
ON z.intid_dealer = kodebwtmisahinomsettulipdenganmetal.intid_dealer
");
        return $query->result();
	}
	
	//
	function getUndanganTotalTanggal($tanggalstart = 0, $tanggalend = 0,$intid_cabang)
	{
		$select = "select *
							FROM
							(select 
							member.*,
							unit.strnama_unit,
							cabang.strnama_cabang,
							v1.undangan_nota_detail,
							v1.intvoucher_nota_detail,
							v1.total_undangan_nota_detail,
							v2.undangan_nota,
							v2.intvoucher_nota,
							v2.total_undangan_nota
							from 
							(select 
								member.*,
								nota.datetgl,
								nota.intno_nota,
								nota.intid_nota
								from nota,member where
								nota.intid_dealer = member.intid_dealer	
								and nota.datetgl >= '$tanggalstart'
								and nota.datetgl <= '$tanggalend'
								and nota.intid_cabang = $intid_cabang
								group by nota.intid_nota) member,
							cabang,
							unit,
							(SELECT 
										a.intid_nota,
										sum(if(cb.intid_wilayah =1, 25000,if(cb.intid_wilayah = 2, 30000,0)) * b.intquantity)  undangan_nota_detail,
										sum(b.intquantity * b.intvoucher) intvoucher_nota_detail,
										sum(if(b.intvoucher !=0,b.intquantity,0)) total_undangan_nota_detail
									FROM
										NOTA a, CABANG cb, NOTA_DETAIL b
									WHERE
										a.intid_nota = b.intid_nota
										and cb.intid_cabang = a.intid_cabang
										and a.datetgl >= '$tanggalstart'
										and a.datetgl <= '$tanggalend'
										and a.intid_cabang = $intid_cabang
										and a.is_vpromo = 0
										and a.is_dp = 0
										and b.intvoucher != 0
									GROUP BY a.intid_nota) as v1,
							(SELECT 
										a.intid_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1))) total_undangan_nota,
										sum(a.intvoucher) intvoucher_nota,
										sum(a.intvoucher / if(cb.intid_wilayah = 1, 50000,if(cb.intid_wilayah = 2, 60000,1)) * if(cb.intid_wilayah = 1, 25000,if(cb.intid_wilayah = 2, 30000,1))) undangan_nota
									FROM
										NOTA a, CABANG cb
									WHERE
										 cb.intid_cabang = a.intid_cabang
										and a.datetgl >= '$tanggalstart'
										and a.datetgl <= '$tanggalend'
										and a.intid_cabang = $intid_cabang
										and a.is_vpromo = 0 
										and a.is_dp = 0
									GROUP BY a.intid_nota) as v2
							where 
								member.intid_nota = v1.intid_nota
								and member.intid_nota = v2.intid_nota
								and member.intid_cabang = cabang.intid_cabang
								and member.intid_unit = unit.intid_unit) Y";
	return $this->db->query($select);
	//return $select;
	}
	function get_CetakPenjualanHarian_installment($cabang, $tgl, $string = false)
	{
		$this->db->select("'0' AS sk",false);
		$this->db->select("'0' AS lg",false);
		$this->db->select("'0' AS ll",false);
		
		$this->db->select("instalment_number intno_nota");
		$this->db->select("membership_name strnama_dealer");
		$this->db->select("upline_name strnama_upline");
		$this->db->select("unit_name strnama_unit");
		$this->db->select("branch_name strnama_cabang");
		$this->db->select("'0' as inttotal_omset",false);
		$this->db->select("'0' as intcash",false);
		$this->db->select("'0' as total_cash",false);
		$this->db->select("debit intdebit");
		$this->db->select("credit intkkredit");
		$this->db->select("cash intdp");
		$this->db->select("total_cost inttotal_bayar");
		$this->db->select("date datetgl");
		$this->db->select("'1' as is_dp");
		$this->db->select("strnama_jpenjualan");
		$this->db->select("intid_jpenjualan");

		$this->db->from(" _instalment");
		$this->db->join("jenis_penjualan","_instalment.type_nota = jenis_penjualan.intid_jpenjualan","left");
		$this->db->where("_instalment.date = '".$tgl."'");
		$this->db->where("_instalment.id_branch = '".$cabang."'");
		return $this->db->get();
	}
	//11 agus 2015 ifirlana@gmail.com
	function selectTotalDpLunasBulanan_tahun($cabang, $month,$tahun)
	{
		$lunasdp = array();

		$query =	$this->db->query("select intid_week from week where intbulan = $month and inttahun = $tahun");
		foreach ($query->result() as $row) 
		{
			$lunasdp[]['result'] =	$this->selectTotalDpLunasMingguan_tahun($cabang,$row->intid_week,$tahun);
			
		}
		return $lunasdp;
	}
	//ending

	/**
	*	
	*/
	function getVoucherDate($intid_cabang, $dateStart, $dateEnd)
	{
		$this->db->from("nota");
		$this->db->join("nota_detail","nota.intid_nota = nota_detail.intid_nota");
		$this->db->where("nota.datetgl between '$dateStart' and '$dateEnd'");
		$this->db->where("nota.intid_cabang = $intid_cabang");
	}
	/* End of function */
}
?>