<?php
class lookuptebus_model extends CI_Model{
    
	function   __construct() 
	{
        parent::__construct();
    }


	function lookupBrgTebus($keyword,$pencarian,$oms_rule){
		$qry = "SELECT
					barang.strnama,
					barang.intid_jbarang,
					control_barang_tebus.*
				FROM
					control_barang_tebus
				LEFT JOIN barang ON barang.intid_barang = control_barang_tebus.intid_barang
				WHERE
					barang.strnama LIKE '".$keyword."%'
					AND curdate() BETWEEN control_barang_tebus.tglawal
					AND control_barang_tebus.tglakhir
					AND status_pencarian like '".$pencarian."'
					AND control_barang_tebus.omset_rule  <= ".$oms_rule."
					GROUP BY control_barang_tebus.intid_barang
					";
		$res = $this->db->query($qry)->result();
		//return $qry;
		return $res;
	}
}