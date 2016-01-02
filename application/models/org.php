<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Bank_model extends CI_Model{
    function   __construct() {
        parent::__construct();
       }

    function insert(){
	$data = array(
            'intid_bank' => $this->input->post('intid_bank'),
            'strnama_bank' => $this->input->post('strnama_bank')
            );
        $this->db->insert('bank', $data);
	}

        function getBank(){
            $this->db->select('*');
            $query = $this->db->get('bank');

            if ($query->num_rows() > 0 ){
                return $query->result_array();
            }
        }

        function  edit(){
            $data = array(
            'intid_bank' => $this->input->post('intid_bank'),
            'strnama_bank' => $this->input->post('strnama_bank')
            );
            $this->db->where('intid_bank', $this->input->post('intid_bank'));
            $this->db->update('bank', $data);
        }

        function getBank('$intid_bank'){
            $this->db->where('intid_bank', $intid_bank);
            $query = $this->db->get('bank', 1);
            if ($query->num_rows() > 0)
            {
                return $query->row_array();
            }
        }

        function delete($intid_bank){
            $this->db->where('intid_bank', $intid_bank);
            $this->db->delete('bank');
        }
        //*****************just  4 testing*************************\\

       // Inisialisasi nama tabel yang digunakan
	//var $table = 'bank';
//
//	/**
//	 * Mendapatkan semua data bank, diurutkan berdasarkan intid_bank
//	 */
//	function get_bank()
//	{
//		$this->db->order_by('intid_bank');
//		return $this->db->get('bank');
//	}
//
//	/**
//	 * Mendapatkan data sebuah bank
//	 */
//	function get_bank_by_id($intid_bank)
//	{
//		return $this->db->get_where($this->table, array('intid_bank' => $intid_bank), 1)->row();
//	}
//
//	function get_all()
//	{
//		$this->db->order_by('intid_bank');
//		return $this->db->get($this->table);
//	}
//
//	/**
//	 * Menghapus sebuah data bank
//	 */
//	function delete($intid_bank)
//	{
//		$this->db->delete($this->table, array('intid_bank' => $intid_bank));
//	}
//
//	/**
//	 * Tambah data bank
//	 */
//	function add($bank)
//	{
//		$this->db->insert($this->table, $bank);
//	}
//
//	/**
//	 * Update data bank
//	 */
//	function update($intid_bank, $strnama_bank)
//	{
//		$this->db->where('intid_bank', $intid_bank);
//		$this->db->update($this->table, $bank);
//	}
//
//	/**
//	 * Validasi agar tidak ada bank dengan id ganda
//	 */
//	function valid_id($intid_bank)
//	{
//		$query = $this->db->get_where($this->table, array('intid_bank' => $intid_bank));
//		if ($query->num_rows() > 0)
//		{
//			return TRUE;
//		}
//		else
//		{
//			return FALSE;
//		}
//	}

}
?>
