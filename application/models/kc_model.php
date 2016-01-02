<?php
class Kc_model extends CI_Model{
    function   __construct() {
        parent::__construct();
       }

       //page
	private $tbl = 'cabang';

        function Cari_kc($limit,$offset,$strkepala_cabang)
	{
	    $q = $this->db->query("SELECT DISTINCT a.*,b.strwilayah
FROM cabang a,wilayah b
 WHERE a.intid_wilayah = b.intid_wilayah and a.strkepala_cabang LIKE '%$strkepala_cabang%' LIMIT $offset,$limit");
	    return $q;
           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}

//end of test
//
//        function delete($intid_cabang){
//            $this->db->where('intid_cabang', $intid_cabang);
//            $this->db->delete('cabang');
//        }
}
?>
