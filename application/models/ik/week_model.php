<?php
class WEEK_MODEL extends CI_Model
{
   
	function   __construct() 
	{
        parent::__construct();
		$this->load->model("ik/db_model","dbm");
		$this->dbm->from('week');
	}
	
	function get($string=true)
	{		
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
	
	function whereWeek($intid_week)
	{
		$this->dbm->where_in('week.intid_week', $intid_week); 
	}
	
	function whereMonth($bulan)
	{
		$this->dbm->where_in('week.intbulan', $bulan); 
	}
	
	function whereTahun($tahun)
	{
		$this->dbm->where_in('week.inttahun', $tahun); 
	}
	
	function selectDate()
	{
		$this->dbm->select("MIN(week.dateweek_start) as 'datestart'");
		$this->dbm->select("MAX(week.dateweek_end) as 'dateend'");		
	}
	
	
}