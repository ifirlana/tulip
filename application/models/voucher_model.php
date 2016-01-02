<?php
class voucher_model extends CI_Model{
    
	function   __construct() {
        parent::__construct();
    }
	
	function getKey_code ($key){
	$query = $this->db->query("select * from v_voucher_penjualan where kode_voucher = '".$key."' and is_active  = 1 and CURDATE() BETWEEN valid_date and exp_date");
		return $query->result();
	}
	
	function updateVoucher($key){
		$data = array(
               'is_active' => 0,
               
            );
			$this->db->where('kode_voucher', $key);
			return $this->db->update('voucher_penjualan', $data); 
	}
	function insertdetailvoucher($idvoucher,$strkodedealer){
		$data = array(
			'intid_voucher'=>$idvoucher,
			'strkode_dealer'=>$strkodedealer,
			
		);
		$this->db->insert('voucher_penjualan_detail', $data);
	}
}
?>
