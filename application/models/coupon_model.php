<?php
	class coupon_model extends CI_Model
	{
		// 
		function laporanMember($all = true, $variable = null,$group = null)
		{	
			//default set query
			$where 	= 	"where 1 ";
			$from	=	"_coupon";
			$select = "count(*) total";
			$groupby = "";
			$orderby = "";

			//kalau ingin group
			if($group != null)
			{
				if($group == "nota-cabang")
				{
					$select 	.= ", (select strnama_cabang from cabang where cabang.intid_cabang = nota.intid_cabang) strnama_cabang";
					$groupby 	.= "group by nota.intid_cabang";
				}
			}
			// variable berisi custom
			if($variable != null)
			{
				if(isset($variable['dateweek_start']) and isset($variable['dateweek_end'])) // jika ditemukan waktu pencariannya
				{
					$select .= ", '".$variable['dateweek_start']."' as dateweek_start, '".$variable['dateweek_end']."' as dateweek_end";
					$where 	.= "and _coupon.intid_nota in (select intid_nota from nota where datetgl between '".$variable['dateweek_start']."' and '".$variable['dateweek_end']."') ";
				}
				if(isset($variable['intid_dealer']))
				{
					$where .= "and member.intid_dealer = ".$variable['intid_dealer']." ";
				}
			}

			if($all == true)
			{
				$select		.=	", member.strkode_dealer, member.intid_dealer, member.strnama_dealer, member.strnama_upline";
				$select		.=	", (select strnama_unit from unit where unit.intid_unit = member.intid_unit) unit";
				$select		.=	", (select strnama_cabang from cabang where cabang.intid_cabang = member.intid_cabang) strnama_cabang";
				$select		.=	",(select strnama_cabang from cabang where cabang.intid_cabang = member.cabang_pengambilan) strnama_cabang_pengambilan";
				$from 		= "_coupon,member ";
				$where 		.= "and _coupon.id_user = member.intid_dealer ";
				$groupby 	.= "group by member.intid_dealer ";
				$orderby 	= "order by member.intid_cabang asc, total desc";
			}
			elseif($all == false)
			{
				$from = "_coupon left join nota on _coupon.intid_nota = nota.intid_nota,member";
				$where 		.= "and _coupon.id_user = member.intid_dealer ";
			}
			
			$select = "select ".$select." from ".$from." ".$where." ".$groupby.$orderby;
			//return $select;
			return $this->db->query($select);
		}
	}