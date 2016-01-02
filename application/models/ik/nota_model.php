<?php
	class nota_model extends CI_Model
	{
		function  __construct() 
		{
			parent::__construct();
			$this->load->model("ik/db_model","dbm");
			$this->dbm->from('nota');
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
		
		function joinDetail($join = "inner")
		{
			$this->dbm->join('nota_detail', 'nota_detail.intid_nota = nota.intid_nota', $join);
		}
		
	}