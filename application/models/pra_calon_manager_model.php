<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class pra_calon_manager_model extends CI_model {
	
	/**
	* @param cucu_luar_rekrut2_tahun
	* desc : 
	*/
	function hitung_omset_cucu_luar_rekrut($strkode_dealer,$bulan_sekarang,$title_penjualan,$tahun){
		//digunakan untuk mengubah peraturan maka disusun kayak gini.
		 
		$from		= "(select * from member 
								where member.strkode_upline = '".$strkode_dealer."'
								) x 
							left join 
							(select * from 
								(select * from member
									where member.strkode_upline = '".$strkode_dealer."'
									) member 
								inner join 
								(select * from calon_manager
									where calon_manager.bulan < ".$bulan_sekarang."
									) calon_manager
								) y on x.strkode_dealer = y.strkode_dealer
							(select * from
								(select * from member
									where member.strkode_upline = '".$strkode_dealer."'
										member.intid_week not in (select intid_week from week where intbulan = '".$bulan."' and inttahun = ".$tahun.")
									) member
								inner join 
								(select * from calon_manager) calon_manager
								on calon_manager.strkode_dealer = member.strkode_dealer
								) z";
							
		$where	= "where z.strkode_dealer is null 
								and y.strkode_dealer is null";
		
		$select 	= "select * from ".$from." ".$where;
		}
}
?>