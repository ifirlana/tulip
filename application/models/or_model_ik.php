<?php
class OR_MODEL_IK extends CI_Model
{
   
	function   __construct() 
	{
        parent::__construct();
	}
	
	function laporanKewajiban($string = false, $dateStart = "", $dateEnd = "",$intid_cabang = 0)
	{
		$this->load->model("ik/db_model","dbm");
		
		$this->dbm->from("nota");
		$this->dbm->join("member","nota.intid_dealer = member.intid_dealer","inner");
		$this->dbm->join("unit","unit.intid_unit = nota.intid_unit","inner");
		$this->dbm->join("cabang","nota.intid_cabang = cabang.intid_cabang","inner");
		
		$this->dbm->where("nota.datetgl", $dateStart,">=");
		$this->dbm->where("nota.datetgl", $dateEnd,"<="); 
		$this->dbm->where("nota.is_dp",0,"="); 
		$this->dbm->where_not_in("member.intlevel_dealer",1);
		//$this->dbm->where_in("member.strkode_dealer");
		
		//kondisi query
		if($string)
		{
			$query = $this->dbm->last_query();
		}
		else
		{
			$query = $this->dbm->get();			
		}
		
		$this->dbm->free();
		return $query;	
	}
	
	function laporanKewajibanSubQuery($string = false, $dateStart = "",$dateEnd = "")
	{
		$this->dbm->from("nota");
		$this->dbm->join("nota_detail","nota.intid_nota = nota_detail.intid_nota","inner");
		
		$this->dbm->where("nota_detail.id_jpenjualan",1,"=");
		$this->dbm->where("nota.datetgl",$dateStart,">=");
		$this->dbm->where("nota.datetgl",$dateEnd,"<=");
		
		//kondisi query
		if($string)
		{
			$query = $this->dbm->last_query();
		}
		else
		{
			$query = $this->dbm->get();			
		}
		
		$this->dbm->free();
		return $query;
	}
}