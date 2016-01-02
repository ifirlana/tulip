<?php
	class member_model extends CI_Model
	{
		var $temp =0;
		function  __construct() 
		{
			parent::__construct();
			$this->table_member				= "member";
		}
		
		function getTableMember()
		{
			return $this->table_member;
		}
	}
?>