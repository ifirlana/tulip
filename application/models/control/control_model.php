<?php
class control_model extends CI_Model{
    
	function   __construct() 
	{
        parent::__construct();
    }
	
	/**
	
	*/
		
	function selectKondisiClass($id_class)
		{
			$select = "
				select * 
				from 
					control_class
				where 
					control_class.id_control_class = $id_class
					group by id_control_class";
			$query = $this->db->query($select);
			return $query->result();
		}/**
	
	*/
		
	function selectKondisiClassDetail($id_class)
		{
			$select = "
				select * 
				from 
					control_class_baru
				where 
					control_class_baru.id_control_class = $id_class
					group by id_control_class";
			$query = $this->db->query($select);
			return $query->result();
		}
		
	//untuk mengambil data Plugin
		
	function control_plugin($intid_cabang, $intid_promo,$intid_jpenjualan)
	{
		$select = "select 
						* 
						from 
						control_plugin 
						where 
						(intid_cabang = '$intid_cabang' or intid_cabang = 0)
						and (intid_jpenjualan = 0 or intid_jpenjualan = '$intid_jpenjualan')
						and CURDATE() BETWEEN tgl_awal AND tgl_akhir";
		$query = $this->db->query($select);
		return $query;
		//return $select;
	}
}
	