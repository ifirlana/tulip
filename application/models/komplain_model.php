<?php
class komplain_model extends CI_Model{
    public static $RET_MENU,$CHILD,$PARENT;
	function   __construct() {
        parent::__construct();
		}
	function getAll($intid_cabang = 0){
		if($intid_cabang != 1){
		
			return $this->db->query("select komplain.*, cabang.strnama_cabang from komplain inner join cabang on cabang.intid_cabang = komplain.intid_cabang where komplain.intid_cabang = $intid_cabang");
			}else{
			
				return $this->db->query("select komplain.*,cabang.strnama_cabang from komplain inner join cabang on cabang.intid_cabang = komplain.intid_cabang order by date_added, cabang.strnama_cabang asc");
				}
		}
		function view_komplain($no_sj){
			
			//return $this->db->query("SELECT (select (select strnama_cabang from cabang where cabang.intid_cabang = komplain.intid_cabang) from komplain where komplain.no = komplain_detail.no) as strnama_cabang,(select strnama from barang where barang.intid_barang = komplain_detail.intid_barang) as strnama,komplain_detail.* FROM `komplain_detail` WHERE komplain_detail.no = '".$no_sj."'");
			return $this->db->query("SELECT (select cabang.intid_cabang from cabang where cabang.intid_cabang = komplain.intid_cabang) as intid_cabang,(select (select strnama_cabang from cabang where cabang.intid_cabang = komplain.intid_cabang) from komplain where komplain.no = komplain_detail.no) as strnama_cabang, (SELECT strnama FROM barang WHERE barang.intid_barang = komplain_detail.intid_barang) AS strnama,komplain_detail.*, komplain.jenis FROM komplain left join komplain_detail  on komplain.no = komplain_detail.no WHERE komplain.no = '".$no_sj."'");
		}
		function input_komplain($data=array()){
			return $this->db->insert('komplain',$data);
		}
		
		function get_nonota($id,$week){
			$var = "";
				$query = $this->db->query('select id from counter');
				$check0  = $query->result();
				
				$data = array(
					   'id' => $check0[0]->id +1
					);
				$this->db->update('counter', $data); 
				$query = $this->db->query('select id from counter');
				$check  = $query->result();
				$var = $id.'.'.$week.".".$check[0]->id;
				//$var = $check[0]->id.'/'.$week.'/'.$id.'/'.strtoupper($ket).'/'.date('m').'/'.date('Y');
				return $var;
			}
		
		function input_komplain_detail($data=array()){
			return $this->db->insert('komplain_detail',$data);
		}
		function cek_spkb($spkb){
		//$this->db->select('no_spkb');
		$query = $this->db->query("select * from spkb where no_spkb = '".$spkb."'");
        return $query;
		}
		function cek_sjkomplain($spkb){
		//$this->db->select('no_spkb');
		$query = $this->db->query("select * from spkb where no_spkb = '".$spkb."'");
        return $query;
		}
		function cek_hadiah($no_nota){
		//$this->db->select('no_spkb');
		$query = $this->db->query("select * from nota_hadiah where intno_nota = '".$no_nota."'");
        return $query;
		}
		function input_sj_baru_detail($data=array()){
			
			return $this->db->insert('spkb_detail',$data);;
		}
		function input_sj_baru($data=array()){
			
			return $this->db->insert('spkb',$data);
		}
		function input_sj_komplain($data=array()){
			//return $this->db->insert('sj_komplain',$data);
			$this->db->select('*');
			$this->db->where('no_sj_baru',$data['no_sj_baru']);
			$query = $this->db->get('sj_komplain');
				$check0  = $query->num_rows();
				if($check0<1):
					$this->db->insert('sj_komplain',$data);
				endif;
			return null;
		}
		function input_nota_hadiah($data=array()){
			$this->db->insert('nota_hadiah',$data);
			
			return null;
		}
		
		function input_nota_detail_hadiah($data=array(),$no_nota){
			/*$query = $this->db->query("select intid_nota from nota_hadiah where intno_nota='$no_nota.'");*/
			$this->db->select('intid_nota');
			$this->db->where('intno_nota',$no_nota);
			$query = $this->db->get('nota_hadiah');
				$check0  = $query->result();
				
				$data['intid_nota'] = $check0[0]->intid_nota ;
			//$data['intid_nota'] = $check0[0]->intid_nota;
			
			return  $this->db->insert('nota_detail_hadiah',$data);
		}
		function update_komplain($id){
			$data = array(
               'status' => 1,
               
            );
			$this->db->where('no', $id);
			return $this->db->update('komplain', $data); 
		}
		
		function get_komplain_cabang($intid_cabang = 0, $intid_week = 0, $tahun = 0){
			
			if($intid_cabang != 0){
				$select	=	"select *,(select strnama_cabang from cabang where cabang.intid_cabang = nota_hadiah.intid_cabang) strnama_cabang from nota_hadiah where jenis_nota = 'HDK13' and intid_cabang = '$intid_cabang' and year(datetgl) = '$tahun' order by intno_nota desc";
				}else{
					$select = "select *,(select strnama_cabang from cabang where cabang.intid_cabang = nota_hadiah.intid_cabang) strnama_cabang from nota_hadiah where jenis_nota = 'HDK13' and year(datetgl) = '$tahun' order by intno_nota,intid_cabang desc";
					}
			return $this->db->query($select);
			}
			
		//ikhlas firlana 2014 Agust 19
		
		function cek_sttb_sparepart($sparepart){
			
			$query = $this->db->query("select * from sttb_sparepart where no_sttb = '".$sparepart."'");
			return $query;
			}
		function cek_sjkomplain_sparepart($sparepart){
			
			$query = $this->db->query("select * from sttb_sparepart where no_sj_sparepart = '".$sparepart."'");
			return $query;
			}
		function input_sj_sparepart_baru($data=array()){
			
			return $this->db->insert('sttb_sparepart',$data);
		}
		
		function input_sj_sparepart_baru_detail($data=array()){
			
			return $this->db->insert('sttb_sparepart_detail',$data);
		}
	}
?>