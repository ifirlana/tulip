<?php
	class db_model extends CI_Model
	{
		protected	$select =	" ";
		protected	$from	=	" ";
		protected	$join			=	false;
		protected	$where		= false;
		protected	$order_by	=	false;
		protected	$group_by	=	false;
		
		function  __construct() 
		{
			parent::__construct();
			
			$this->select 		=	" ";
			$this->from			=	" ";
			$this->join			=	false;
			$this->where		= 	false;
			$this->order_by	=	false;
			$this->group_by	=	false;
		}
		
		function free()
		{
			$this->select 		=	" ";
			$this->from			=	" ";
			$this->join			=	false;
			$this->where		= 	false;
			$this->order_by	=	false;
			$this->group_by	=	false;
		}
		
		function free_select()
		{
			$this->select 		=	" ";
		}
		
		// generate query
		function gen()
		{
			
			if($this->order_by)
			{
				$this->order_by	= " order by ".substr($this->order_by,0,-2);
			}
			
			if($this->where)
			{
				$this->where 		= substr($this->where,0,-5);
			}
			else
			{
				$this->where		=	" 1 ";
			}
			
			if($this->group_by)
			{
				$this->group_by 		= "group by ".substr($this->group_by,0,-2);
			}
			else
			{
				$this->group_by		=	" ";
			}
			
			if($this->join)
			{
				$this->join	=	" ".substr($this->join,0,-2)." ";
			}
			else
			{
				$this->join	=	" ";
			}
			
			$query = "select ".substr($this->select,0,-2)." from ".substr($this->from,0,-2)." ".$this->join." where ".$this->where." ".$this->group_by." ".$this->order_by;
			return $query;
		}
		//end.
		
		// return hasil query
		function get()
		{
			return $this->db->query($this->gen());
		}
		//end.
		
		// return string query
		function last_query()
		{
			return $this->gen();
		}
		//end.
		
		function select($var = true)
		{
				$this->select .= " ".$var.", ";
		}
		
		function order_by($cols, $option = false)
		{
			if($option)
			{
				$this->order_by .= " ".$cols." ".$option.", ";
			}
			else
			{
				$this->order_by .= " ".$cols.", ";
			}
		}
		
		function from($table)
		{
			$this->from .= " ".$table.", ";
		}
		
		// penggabungan antar table
		function join($table,$on,$options = false)
		{
			if($options)
			{
				$this->join .= " ".$options." JOIN ".$table." ON ".$on."  ";
			}
			else
			{
				$this->join .= " INNER JOIN ".$table." ON ".$on."  ";
			}
		}
		//end.
		
		function where($cols,$var,$options = false)
		{
			if($options)
			{
				$this->where .= " ".$cols." ".$options." '".$var."' and "; 
			}
			else
			{
				$this->where .= " ".$cols." = '".$var."' and ";
			}
		}
		
		function where_in($cols, $var)
		{
		
			$this->where	.=	" ".$cols." IN (".$var.") and ";
		}
		
		function where_not_in()
		{
			$this->where	.=	" ".$cols." NOT IN (".$var.") and ";
		}
		
		function group_by($cols)
		{
			$this->group_by .= " ".$cols.", ";
		}
	}