<?php
class Manager_model extends CI_Model{
    function   __construct() {
        parent::__construct();
       }

        function Cari_manager($limit,$offset,$strnama_dealer)
	{
	    $q = $this->db->query("SELECT a. * ,  c.strnama_unit
            FROM member a,unit c
            WHERE a.intid_unit = c.intid_unit
            AND a.intlevel_dealer = '1'
			AND a.strnama_dealer LIKE '%$strnama_dealer%' LIMIT $offset,$limit");
	    return $q;

           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
}
?>
