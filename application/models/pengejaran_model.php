<?php
	class pengejaran_model extends CI_Model{
		
		function show_pengejaran(){
			$where = "";
			
			//...code start here
			$where = "where ".$where." active = 1";
			
			return $this->db->query("select *,(select strnama_jpenjualan from jenis_penjualan where jenis_penjualan.intid_jpenjualan = pengejaran.intid_jpenjualan)strnama_jpenjualan from pengejaran ".$where);
			}
		function getData_pengejaran($id = ""){
			
			return $this->db->query("select *,(select strnama_jpenjualan from jenis_penjualan where jenis_penjualan.intid_jpenjualan = pengejaran.intid_jpenjualan)strnama_jpenjualan from pengejaran where id = ".$id);
			}
		}
?>