<?php
class keuangan_model extends CI_Model
{
	function  __construct() 
	{
		parent::__construct();
	}

	/**
	* @see CetakKeuangan
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	private function CetakKeuangan($cabang,$tahun,$start,$end)
	{
		$this->db->from("nota");
		$this->db->where("nota.intid_cabang = ".$cabang."");
		$this->db->where("nota.datetgl >= '".$start."'");
		$this->db->where("nota.datetgl <= '".$end."'");
		$this->db->where("year(nota.datetgl) = ".$tahun."");
		$this->db->where("nota.is_dp = 0");


		$this->db->join("(select sum(nd.intquantity * (nd.intharga - nd.intvoucher)) total, nd.intid_nota, n.intvoucher from nota n inner join nota_detail nd on n.intid_nota = nd.intid_nota inner join barang b on b.intid_barang = nd.intid_barang where n.intid_cabang = ".$cabang." and n.datetgl >= '".$start."' and n.datetgl <= '".$end."' and b.intid_jbarang = 1 group by nd.intid_nota) omsetTulip","nota.intid_nota = omsetTulip.intid_nota","left");
		$this->db->join("(select sum(nd.intquantity * (nd.intharga - nd.intvoucher)) total, nd.intid_nota, n.intvoucher from nota n inner join nota_detail nd on n.intid_nota = nd.intid_nota inner join barang b on b.intid_barang = nd.intid_barang where n.intid_cabang = ".$cabang." and n.datetgl >= '".$start."' and n.datetgl <= '".$end."' and b.intid_jbarang = 2 group by nd.intid_nota) omsetMetal","nota.intid_nota = omsetMetal.intid_nota","left");
		$this->db->join("(select sum(nd.intquantity * (nd.intharga - nd.intvoucher)) total, nd.intid_nota, n.intvoucher from nota n inner join nota_detail nd on n.intid_nota = nd.intid_nota inner join barang b on b.intid_barang = nd.intid_barang where n.intid_cabang = ".$cabang." and n.datetgl >= '".$start."' and n.datetgl <= '".$end."' and b.intid_jbarang = 3 group by nd.intid_nota) omsetTc","nota.intid_nota = omsetTc.intid_nota","left");
	}
	/** end of function CetakKeuangan */
	/**
	* @see selectKeuangan
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	private function selectKeuangan()
	{
		//kondisi tulip
		$this->db->select("nota.intkomisi10");
		$this->db->select("nota.intkomisi15");
		$this->db->select("nota.intkomisi20");
		$this->db->select("nota.intid_nota");

		$this->db->select("if(omsetTulip.total >= omsetMetal.total, omsetTulip.total - nota.intvoucher, omsetTulip.total) omsettulip",false);
		$this->db->select("if(omsetMetal.total > omsetTulip.total, omsetMetal.total - nota.intvoucher, omsetMetal.total) omsetmetal",false);
		$this->db->select("omsetTc.total omsettc",false);
		$this->db->select("nota.inttotal_bayar + nota.intkomisi10 + nota.intkomisi15 + nota.intkomisi20 total");
	}
	/** end of function selectKeuangan */

	/**
	* @see getCetakKeuanganMingguanRedWhite
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanRedWhite($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 30");
		
		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanRedWhite */
	/**
	* @see getCetakKeuanganMingguanAvenger
	* ikhlas firlana ifirlana@gmail.com 03 Sept 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanAvenger($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 31");
		
		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanRedWhite */

	
	/**
	* @see getCetakKeuanganMingguanReguler
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanReguler($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 1");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanReguler */
	/**
	* @see getCetakKeuanganMingguanHut
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanHut($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 2");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanHut */

	/**
	* @see getCetakKeuanganMingguanChallenge
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanChallenge($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 3");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanChallenge */

	/**
	* @see getCetakKeuanganMingguan1free1
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguan1free1($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 6");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguan1free1 */

	
	/**
	* @see getCetakKeuanganMingguan1free1Hut
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguan1free1Hut($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 5");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguan1free1Hut */

	
	/**
	* @see getCetakKeuanganMingguanNetto
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanNetto($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 7");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanNetto */

	

	/**
	* @see getCetakKeuanganMingguanAgogo
	* ikhlas firlana ifirlana@gmail.com 18 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanAgogo($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 21");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanAgogo */

		/**
	* @see getCetakKeuanganMingguanSerbu
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanSerbu($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 22");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanSerbu */

	
	/**
	* @see getCetakKeuanganMingguanCEPEK
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanCEPEK($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 23");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanSerbu */

	
	/**
	* @see getCetakKeuanganMingguanHoki75
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanHoki75($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 28");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanHoki75 */

	

	/**
	* @see getCetakKeuanganMingguanHoki150
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanHoki150($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 29");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanHoki150 */

	
	/**
	* @see getCetakKeuanganMingguanDis40
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanDis40($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 16");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanDis40 */
	
	/**
	* @see getCetakKeuanganMingguanDis50
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanDis50($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 18");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanDis50 */

	
	/**
	* @see getCetakKeuanganMingguanSurprise
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanSurprise($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 25");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanSurprise */

	
	/**
	* @see getCetakKeuanganMingguanWafflePan
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanWafflePan($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 27");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanWafflePan */

	
	/**
	* @see getCetakKeuanganMingguanStarterkit
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanStarterkit($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 10");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanStarterkit */

	/**
	* @see getCetakKeuanganMingguanLevelGift
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanLevelGift($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_nota in (select nota.intid_nota from nota_detail inner join nota on nota_detail.intid_nota = nota.intid_nota inner join barang on nota_detail.intid_barang = barang.intid_barang where barang.intid_jbarang = 5 and nota.intid_cabang = ".$cabang." and nota.datetgl between '".$week[0]->dateweek_start."' and '".$week[0]->dateweek_end."')");
		$this->db->where("nota.intid_jpenjualan = 8");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanLevelGift */

	/**
	* @see getCetakKeuanganMingguanCharity
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanCharity($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 24");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanCharity */
	
	/**
	* @see getCetakKeuanganMingguanLainLain
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanLainLain($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 8");
		$this->db->where("nota.intid_nota in (select nota.intid_nota from nota_detail inner join nota on nota_detail.intid_nota = nota.intid_nota inner join barang on nota_detail.intid_barang = barang.intid_barang where barang.intid_jbarang not in (5) and nota.intid_cabang = ".$cabang." and nota.datetgl between '".$week[0]->dateweek_start."' and '".$week[0]->dateweek_end."')");
		

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanLainLain */

	
	/**
	* @see getCetakKeuanganMingguanSpecialPrice
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanSpecialPrice($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 11");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanSpecialPrice */
	/**
	* @see getCetakKeuanganMingguanPromoRekrut
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanPromoRekrut($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 17");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanPromoRekrut */
	/**
	* @see getCetakKeuanganMingguanPoint
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanPoint($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 12");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanPromoRekrut */

	/**
	* @see getCetakKeuanganMingguanMetal50
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanMetal50($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 13");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanMetal50 */

	/**
	* @see getCetakKeuanganMingguanSpecialBandung
	* ikhlas firlana ifirlana@gmail.com 19 Agust 2015
	* desc : 
	*/
	function getCetakKeuanganMingguanSpecialBandung($cabang, $week,$tahun,$result = 1)
	{

		$query = $this->db->query("select * from week where intid_week = ".$week." and inttahun = ".$tahun."");
		$week = $query->result();

		$this->db->start_cache();

		$this->selectKeuangan();
		$this->CetakKeuangan($cabang,$tahun,$week[0]->dateweek_start,$week[0]->dateweek_end); 
		
		$this->db->where("nota.intid_jpenjualan = 14");

		$query 	= $this->db->get();
		$string = $this->db->last_query();
		
		$this->db->stop_cache();

		$this->db->flush_cache();
		
		if($result == 0) // 0  untuk hasil query, 
		{
			return $query;
		}
		else if($result == 1) // 1 untuk hasil query->result
		{
			return $query->result();
		}
		else if($result == 2) // 2 untuk return string query
		{
			return $string;
		}
	}
	/** end of function getCetakKeuanganMingguanSpecialBandung*/
	
	function getCetakKeuanganBulananRedWhite($intid_cabang,$month,$tahun,$result)
	{
		$query = $this->db->query("select * from week where intbulan = $month and inttahun = $tahun");
		foreach($query->result() as $row)
		{
			$temp[] = $this->getCetakKeuanganMingguanRedWhite($intid_cabang, $row->intid_week,$tahun,$result);
		}
		return $temp;
	}
	
	function getCetakKeuanganBulananAvenger($intid_cabang,$month,$tahun,$result)
	{
		$query = $this->db->query("select * from week where intbulan = $month and inttahun = $tahun");
		foreach($query->result() as $row)
		{
			$temp[] = $this->getCetakKeuanganMingguanAvenger($intid_cabang, $row->intid_week,$tahun,$result);
		}
		return $temp;
	}
}