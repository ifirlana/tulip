<?php
class surat_jalan_model extends CI_Model{
	
	function laporan_barang_keluar($data = array()){
		$intid_cabang	=	$data['intid_cabang'];
		$intid_week	=	$data['intid_week'];
		$select = "select
								*
								from
								(select *
								from spkb_detail
								where
								no_spkb in 
								(select no_spkb
									from 
										spkb 
									where
										(no_sj is not null or no_sj != '')
										and intid_cabang = ".$intid_cabang."
										and intid_week = ".$intid_week.")
										)";
		return $this->load->query($select);
		}
	}
?>