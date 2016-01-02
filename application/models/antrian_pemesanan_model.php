<?php
 class antrian_pemesanan_model extends CI_model{
 	function insert_antrian($data){
	if(!isset($data['pengambilan'])){
		$data['pengambilan'] = 0;
	}
 		$data = array(
 			'intid_dealer' => $data['intid_dealer'],
 			'pengambilan' => $data['pengambilan'],
 			'date_added' => $data['date_added'],
 			'barcode_data' => $data['barcode_data'],
 			'is_printed'	=> $data['is_printed'],
 			);
 		$this->db->insert('antrian_pemesanan',$data);
 	}
}
?>