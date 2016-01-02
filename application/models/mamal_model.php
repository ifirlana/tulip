<?php
	class mamal_model extends CI_Model{
		function cat($username, $password){
			if($username == 'universe' and $password == 'admin'){
				return true;
			}else{
				return false;
			}
		}
		//get keyword akses
		function cheetah(){
			return md5("universe".date('D-m-Y'));
		}
		/**
		* elephant
		* i : data array, table from database, opt for customize
		* out : anything
		* Desc : for insert data to table, where and how
		*/
		function elephant($data,$table,$opt){
			$this->db->insert($table,$data);
			if($opt == 1){
				return $this->db->insert_id();			
			}else{
				return false;
			}
		}
		/**
		* monkey
		* i : String 
		* o : query
		* Desc : pengambilan data dengan select sendiri
		*/
		function monkey($data){
			$query = $this->db->query($data);
			return $query->result();
			}
		function excalibur($intid_dealer,$tglawal,$tglakhir){
			$data	= array();
			$var	= array();
			$temp	= array();
			$query = $this->db->query('select
			 		strkode_dealer,
					intid_dealer,
					upper(strnama_dealer) strnama_dealer,
					strkode_upline,
					intlevel_dealer,
					intparent_leveldealer,
					intid_unit,
					(select sum(nota.inttotal_omset) 
						from nota 
							where nota.datetgl >= "'.$tglawal.'" and nota.datetgl <= "'.$tglakhir.'"
							and nota.intid_dealer = "'.$intid_dealer.'" and nota.is_dp = 0 
							and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)
							) inttotal_omset
				from member
				where intid_dealer = "'.$intid_dealer.'"');
			foreach($query->result() as $row){
				//code in here
				$data[] = array('strkode_dealer' => $row->strkode_dealer,
						'intid_dealer' => $row->intid_dealer,
						'strnama_dealer' => $row->strnama_dealer,
						'strkode_upline' => $row->strkode_upline,
						'intlevel_dealer' => $row->intlevel_dealer,
						'intparent_leveldealer' => $row->intparent_leveldealer,
						'inttotal_omset' => $row->inttotal_omset,
						'intid_unit'	=> $row->intid_unit,
					);
				$temp = $this->katana($row->strkode_dealer,$row->intid_dealer,$tglawal,$tglakhir,$row->intid_unit);
				for($i=0;$i<sizeof($temp);$i++){
					if(isset($temp[$i]['strkode_dealer'])){
						$var[0]	=	$temp[$i]['strkode_dealer'];
					}
					if(isset($temp[$i]['intid_dealer'])){
						$var[1]	=	$temp[$i]['intid_dealer'];
					}
					if(isset($temp[$i]['strnama_dealer'])){
						$var[2]	=	$temp[$i]['strnama_dealer'];
					}
					if(isset($temp[$i]['strkode_upline'])){
						$var[3]	=	$temp[$i]['strkode_upline'];
					}
					if(isset($temp[$i]['intlevel_dealer'])){
						$var[4]	=	$temp[$i]['intlevel_dealer'];
					}
					if(isset($temp[$i]['intparent_leveldealer'])){
						$var[5]	=	$temp[$i]['intparent_leveldealer'];
					}
					if(isset($temp[$i]['inttotal_omset'])){
						$var[6]	=	$temp[$i]['inttotal_omset'];
					}
					if(isset($temp[$i]['intid_unit'])){
						$var[7]	=	$temp[$i]['intid_unit'];
					}
					$data[] = array('strkode_dealer' => $var[0],
							'intid_dealer' => $var[1],
							'strnama_dealer' => $var[2],
							'strkode_upline' => $var[3],
							'intlevel_dealer' => $var[4],
							'intparent_leveldealer' => $var[5],
							'inttotal_omset' => $var[6],
							'intid_unit'	=> $var[7],
						);
				}
			}
			return $data;
		}
		function katana($strkode_dealer,$intid_dealer,$tglawal,$tglakhir,$intid_unit){
			$data = array();
			$temp = array();
			$var	= array(); 
			$Query = $this->db->query('select 
					member.strkode_dealer,
					member.intid_dealer,
					upper(member.strnama_dealer) strnama_dealer,
					member.strkode_upline,
					member.intlevel_dealer,
					member.intparent_leveldealer,
					nota.intid_unit,
					(select sum(inttotal_omset) from nota 
						where nota.datetgl >= "'.$tglawal.'" and nota.datetgl <= "'.$tglakhir.'" 
						and nota.is_dp = 0 and (nota.intid_jpenjualan = 1 or nota.intid_jpenjualan = 9)
						and nota.intid_dealer = member.intid_dealer
						)inttotal_omset
				from nota inner join member on member.intid_dealer = nota.intid_dealer
				where member.strkode_upline = "'.$strkode_dealer.'"
				and nota.datetgl >= "'.$tglawal.'" and nota.datetgl <= "'.$tglakhir.'"
				and member.intlevel_dealer != 1
				and nota.intid_unit = "'.$intid_unit.'" 
				and nota.is_dp = 0 and (nota.intid_jpenjualan =1 or nota.intid_jpenjualan = 9)
				group by member.strkode_dealer,nota.intid_unit');
			foreach($Query->result() as $row){
				$data[] = array('strkode_dealer' => $row->strkode_dealer,
						'intid_dealer' => $row->intid_dealer,
						'strnama_dealer' => $row->strnama_dealer,
						'strkode_upline' => $row->strkode_upline,
						'intlevel_dealer' => $row->intlevel_dealer,
						'intparent_leveldealer' => $row->intparent_leveldealer,
						'inttotal_omset' => $row->inttotal_omset,
						'intid_unit'	=> $row->intid_unit,
					);
				
				$temp = $this->katana($row->strkode_dealer,$row->intid_dealer,$tglawal,$tglakhir,$intid_unit);
				for($i=0;$i<sizeof($temp);$i++){
					if(isset($temp[$i]['strkode_dealer'])){
						$var[0]	=	$temp[$i]['strkode_dealer'];
					}
					 if(isset($temp[$i]['intid_dealer'])){
						$var[1]	=	$temp[$i]['intid_dealer'];
					}
					if(isset($temp[$i]['strnama_dealer'])){
						$var[2]	=	$temp[$i]['strnama_dealer'];
					}
					if(isset($temp[$i]['strkode_upline'])){
						$var[3]	=	$temp[$i]['strkode_upline'];
					}
					if(isset($temp[$i]['intlevel_dealer'])){
						$var[4]	=	$temp[$i]['intlevel_dealer'];
					}
					if(isset($temp[$i]['intparent_leveldealer'])){
						$var[5]	=	$temp[$i]['intparent_leveldealer'];
					}
					if(isset($temp[$i]['inttotal_omset'])){
						$var[6]	=	$temp[$i]['inttotal_omset'];
					}
					if(isset($temp[$i]['intid_unit'])){
						$var[7]	=	$temp[$i]['intid_unit'];
					}
					$data[] = array('strkode_dealer' => $var[0],
							'intid_dealer' => $var[1],
							'strnama_dealer' => $var[2],
							'strkode_upline' => $var[3],
							'intlevel_dealer' => $var[4],
							'intparent_leveldealer' => $var[5],
							'inttotal_omset' => $var[6],
							'intid_unit'	=> $var[7]
						);
				}
			}
			return $data;
		}
	}
?>