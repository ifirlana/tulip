<?php
class control_registrasi_model extends CI_Model
{
	function   __construct() 
	{
        parent::__construct();
    }

	private $table 		= 'control_registrasi';
	private $select		=	array();
	private $from		=	array();
	private $where	=	array();
	private $groupby	=	"";

	function free_query()
	{
		$this->select	=	array();
		$this->from		=	array();
		$this->where	=	array();
		$this->groupby	=	"";
	}
	function query($escape = false)
	{
		$select	=	"select ";
		$from	=	"from ".$this->table." ";
		$where	=	"where ";
		$groupby	=	" ";
		if(isset($this->select) and !empty($this->select))
		{
			for($i=0;$i<count($this->select);$i++)
			{
				$select .= $this->select[$i].", ";
			}
		}
		else
		{
			$select .= $this->table.".*, ";					
		}
		if(isset($this->where) and !empty($this->where))
		{
			for($i=0;$i<count($this->where);$i++)
			{
				$where .= $this->where[$i]." and ";
			}
		}
		else
		{
			$where = ""; //null
		}
		if(isset($this->groupby) and !empty($this->groupby))
		{
			$groupby	=	"group by ".$this->groupby;
		}
		
		$query = substr($select,0,-2)." ".$from." ".substr($where,0, -5)." ".$groupby;
		
		if($escape == false)
		{
			return $this->db->query($query);
		}
		else if($escape == true)
		{
			return $query;
		}
	}
	
	//	
	function where_id($id = 0)
	{
		$this->where[]	=	$this->table.".id = ".$id;
	}
	
	//
	function active()
	{
		$this->where[]	=	$this->table.".active = '1'";
		$this->where[]	=	"CURDATE() BETWEEN ".$this->table.".date_start and ".$this->table.".date_end";
	}
}