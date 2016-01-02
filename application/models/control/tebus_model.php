<?php
class tebus_model extends CI_Model
{
	private function conditionalPromo()
	{
		$this->db->from("control_promo_tebus");
		$this->db->where("CURDATE() between tanggal_mulai and tanggal_akhir");
	}
	/**
	* @see getPromo
	*	@param
	*	$string return string data
	* @log
	*	20150813 dibuat untuk mengambil data control_promo_tebus
	*/
	public function getPromo($string = false)
	{
		$this->conditionalPromo();
		
		$this->db->select("intid_control_promo_tebus");
		$this->db->select("intid_jpenjualan");
		$this->db->select("nama_promo");
		$this->db->select("nama_id");

		if($string == true)
		{
			$this->db->get();
			return $this->db->last_query();
		}
		else if($string == false)
		{
			return $this->db->get();
		}
	}
	/*	End of function getPromo() */
}   