<?php
class Promosi_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

	private $tbl = 'promo10';

	
 function selectWeek(){

	   $query = $this->db->query("select * from week order by intid_week asc");
	   return $query->result();
    }

    function getPromo(){

	   $query = $this->db->query("SELECT a. * , b.strnama, c.strnama as nama
            FROM promo10 a, barang b, barang c
            WHERE a.intid_barang = b.intid_barang
                   AND a.intid_barang_free = c.intid_barang
            ORDER BY intid_promo ASC"
              );
	   return $query->result();
    }
   

    function insert($data){

       
	$data = array(
            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
            'intid_barang' => $this->input->post('intid_barang'),
            'intid_barang_free' => $this->input->post('intid_barang_free')
			);
        $this->db->insert('promo10', $data);
	}

   function delete($idpromo){
       $this->db->where('intid_promo', $idpromo);
       $this->db->delete('promo10');
    }
    function select($idpromo){
       $query = $this->db->query("select a.*, b.strnama, c.strnama as nama 
		from promo10 a, barang b, barang c
		where a.intid_promo = $idpromo
		and a.intid_barang = b.intid_barang
		and a.intid_barang_free = c.intid_barang");
	   return $query->result();
    }

	function update($idpromo){

            $data = array(
            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
           'intid_barang' => $this->input->post('intid_barang'),
            'intid_barang_free' => $this->input->post('intid_barang_free')
		);
            $this->db->where('intid_promo', $idpromo);
            $this->db->update('promo10',$data);
    }
	
	 function selectBarang($keyword){
        $query = $this->db->query("select intid_barang, upper(strnama) strnama from barang where strnama like '$keyword%'");
        return $query->result();
	}
	function selectBarangFree($keyword){
        $query = $this->db->query("select intid_barang, upper(strnama) strnama from barang where strnama like '$keyword%'");
        return $query->result();
	}
/********Promosi 20**************************/
 function getPromo20(){

	   $query = $this->db->query("SELECT a. * , b.strnama, c.strnama as nama
            FROM promo20 a, barang b, barang c
            WHERE a.intid_barang = b.intid_barang
                   AND a.intid_barang_free = c.intid_barang
            ORDER BY intid_promo ASC"
              );
	   return $query->result();
    }
     //page
	private $tbl2 = 'promo20';

	
          function insert2($data){


	$data = array(

            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
            'intid_barang' => $this->input->post('intid_barang'),
            'intid_barang_free' => $this->input->post('intid_barang_free'),
            'intid_barang_free1' => $this->input->post('intid_barang_free1'),
	    'intid_barang_free2' => $this->input->post('intid_barang_free2')
			);
        $this->db->insert('promo20', $data);
	}


     function select2($idpromo2){
       $query = $this->db->query("select a.*, b.strnama, c.strnama as nama 
		from promo20 a, barang b, barang c
		where a.intid_promo = $idpromo2
		and a.intid_barang = b.intid_barang
		and a.intid_barang_free = c.intid_barang");
	   return $query->result();
     }

	function update2($idpromo){


            $data = array(
            'intid_week_start' => $this->input->post('intid_week_start'),
            'intid_week_end' => $this->input->post('intid_week_end'),
           'intid_barang' => $this->input->post('intid_barang'),
            'intid_barang_free' => $this->input->post('intid_barang_free'),
            'intid_barang_free1' => $this->input->post('intid_barang_free1'),
            'intid_barang_free2' => $this->input->post('intid_barang_free2')
		);
            $this->db->where('intid_promo', $idpromo);
            $this->db->update('promo20',$data);
    }
     function delete2($idpromo){
       $this->db->where('intid_promo', $idpromo);
       $this->db->delete('promo20');
    }

    //test az
        function Cari_promo10($limit,$offset,$strnama)
	{
	    $q = $this->db->query("SELECT a. * , b.strnama, c.strnama as nama
            FROM promo10 a, barang b, barang c
            WHERE a.intid_barang = b.intid_barang
            AND a.intid_barang_free = c.intid_barang
			AND b.strnama LIKE '%$strnama%' LIMIT $offset,$limit");
	    return $q;
           
           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
//promo20
    function Cari_promo20($limit,$offset,$strnama)
	{
	    $q = $this->db->query("SELECT a. * , b.strnama, c.strnama as nama
            FROM promo20 a, barang b, barang c
            WHERE a.intid_barang = b.intid_barang
            AND a.intid_barang_free = c.intid_barang
			AND b.strnama LIKE '%$strnama%' LIMIT $offset,$limit");
	    return $q;

    }

	function tot_hal2($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
//end of test
//digunakan untuk PROMOSI/PROMOSI_STARTTERKIT_ABO
//build 3 agustus 2013
	function get_Promosi_starterkit_ABO($data){
		if(isset($data['intid_starterkit']) and isset($data['intid_week'])){
		$select = 'select *,
					if((select count(*) 
						from member m
						where m.intid_starterkit = "'.$data['intid_starterkit'].'" 
						and m.strkode_dealer = member.strkode_upline) > 0 ,1,0) as status 
					from member where year(member.datetanggal) = "'.$data['tahun'].'" and member.intid_starterkit = "'.$data['intid_starterkit'].'" and intid_week = "'.$data['intid_week'].'" and intid_cabang = "'.$data['intid_cabang'].'" order by member.datetanggal asc';
		//echo $select;
		}
		$query	=	$this->db->query($select);
		return $query;
	}
	function get_Promosi_starterkit_ABO_all($data){
		if(isset($data['intid_starterkit']) and isset($data['intid_week'])){
		$select = 'select *, cabang.strnama_cabang,
					if((select count(*) 
						from member m
						where m.intid_starterkit = "'.$data['intid_starterkit'].'" 
						and m.strkode_dealer = member.strkode_upline) > 0 ,1,0) as status 
					from member, cabang where cabang.intid_cabang = member.intid_cabang and year(member.datetanggal) = "'.$data['tahun'].'" and member.intid_starterkit = "'.$data['intid_starterkit'].'" and intid_week = "'.$data['intid_week'].'" order by cabang.intid_cabang, member.datetanggal asc';
		//echo $select;
		}
		$query	=	$this->db->query($select);
		return $query;
	}
	function get_omset_week($data){
		$query = $this->db->query('select sum(inttotal_omset) inttotal_omset from nota 
		where intid_week = '.$data['intid_week'].' 
			and intid_dealer = '.$data['intid_dealer'].' 
			and is_dp = 0
			and (intid_jpenjualan = 1 or intid_jpenjualan = 2 or intid_jpenjualan = 3 or intid_jpenjualan = 4 or intid_jpenjualan = 5 or intid_jpenjualan = 6 or intid_jpenjualan = 7)');
		return $query;	
	}
	function get_nota_dealer($data){
		$select = "select * from nota where intid_dealer = '".$data['intid_dealer']."' order by nota.datetgl asc";
		return $this->db->query($select);
	}
	function  get_dealer($data){
		$select  = "select *,(select intid_dealer from member m where m.strkode_dealer = member.strkode_upline )intid_upline  from member where intid_dealer = '".$data['intid_dealer']."'";
		return $this->db->query($select);
	}
	function update_nota($data){
		$update	=	"update nota set intid_dealer = '".$data['intid_dealer']."' where intid_nota = '".$data['intid_nota']."' and intid_jpenjualan != 10";
		//echo $update."<br />";
		$this->db->query($update);
	}
	function insert_nota_history_from_nota($dataTemp){
			$select = "select * from nota where intid_nota = ".$dataTemp['intid_nota']."";
			$query = $this->db->query($select);
		$ket = "NOTA ";
		foreach($query->result() as $row){
			$ket .= "(".$row->intid_nota.", ".$row->intno_nota.", ".$row->intid_jpenjualan.", ".$row->intid_cabang.", ".$row->intid_dealer.", ".$row->intid_unit.", ".$row->datetgl.", ".$row->intid_week.", ".$row->intomset10.", ".$row->intomset20.", ".$row->inttotal_omset.", ".$row->inttotal_bayar.", ".$row->intdp.", ".$row->intcash.", ".$row->intdebit.", ".$row->intkkredit.", ".$row->intsisa.", ".$row->intkomisi10.", ".$row->intkomisi20.", ".$row->intpv.", ".$row->intvoucher.", ".$row->is_dp.", ".$row->inttrade_in.", ".$row->is_lg.", ".$row->nokk.", ".$row->is_asi.", ".$row->intkomisi_asi.", ".$row->is_arisan.", ".$row->halaman.")";
			}
			$ket1 = " NOTA_DETAIL ( ";
			$select2 = "select * from nota_detail where intid_nota = ".$row->intid_nota."";
			$query2 = $this->db->query($select2);
			foreach($query2->result() as $row){
					$ket1 .= "(".$row->intid_detail_nota.", ".$row->intid_nota.", ".$row->intid_barang.", ".$row->intquantity.", ".$row->intid_harga.", ".$row->is_free.", ".$row->intharga.") ";
					}
			$ket1 .= ") ";
		//echo $ket.$ket1."<br />";
		$selectall = "insert into nota_history (status,keterangan_history) values ('DELETE ABO','".$ket.$ket1."');";
		$this->db->query($selectall);
		//echo $selectall."<br />";
	}
	//function de
	function delete_member($data){
			$select2 = "select * from member where intid_dealer = ".$data['intid_dealer']."";
			$query2 = $this->db->query($select2);
			$ket1 = "MEMBER ";
			foreach($query2->result() as $row){
					$ket1 .= "(".$row->intid_dealer.", ".$row->strkode_dealer.", ".$row->strnama_dealer.", ".$row->intid_cabang.", ".$row->datetanggal.", ".$row->strkode_upline.", ".$row->strnama_upline.", ".$row->intlevel_dealer.", ".$row->intparent_leveldealer.", ".$row->intid_unit.", ".$row->strno_ktp.", ".$row->stralamat.", ".$row->strtlp.", ".$row->strtmp_lahir.", ".$row->datetgl_lahir.", ".$row->stragama.", ".$row->intid_bank.", ".$row->intno_rekening.", ".$row->strnama_pemilikrekening.", ".$row->strkode_manager.", ".$row->intid_starterkit.", ".$row->intid_posisi.", ".$row->strjk.", ".$row->strstatus.", ".$row->stremail.", ".$row->strwarganegara.", ".$row->strpekerjaan.", ".$row->strtelp_upline.", ".$row->intid_unit_upline.", ".$row->intid_cabang_upline.", ".$row->intid_week.", ".$row->is_cm.") ";
					}
			$ket1 .= ") ";
	$selectall = "insert into nota_history (status,keterangan_history) values ('DELETE ABO','".$ket1."');";
	$this->db->query($selectall);
	
	$delete = 'delete from member where intid_dealer = "'.$data['intid_dealer'].'"';
	//echo $delete."<br />";
	$this->db->query($delete);
	}
	//tambahan untuk kelengkapan starterkit
	function insert_kelengkapanABO($data){
		$select = "select * from nota inner join nota_detail on nota_detail.intid_nota = nota.intid_nota where nota.intid_jpenjualan = 10 and nota_detail.intid_nota = '".$data['intid_nota']."' group by nota.intid_nota";
		//echo $select."<br>";
		$query = $this->db->query($select);
		$hasil = $query->result();
		if(isset($hasil[0]->intid_barang) and $hasil[0]->intid_barang == 6135){
			$intid_nota = $hasil[0]->intid_nota;
			$intno_nota = $hasil[0]->intno_nota;
			//flyer POD
			$data1[0] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 6,
								'intquantity'	=> 1,
								'intid_harga'	=> 6,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//flyer exotic
			$data1[1] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 2022,
								'intquantity'	=> 1,
								'intid_harga'	=> 2022,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//kalender 2013
			$data1[2] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 2328,
								'intquantity'	=> 1,
								'intid_harga'	=> 2328,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//flyer boom 36-44 2013
			$data1[3] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 6130,
								'intquantity'	=> 1,
								'intid_harga'	=> 6130,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//flyer gift week 36 - 44 2013
			$data1[4] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 6131,
								'intquantity'	=> 1,
								'intid_harga'	=> 6131,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//flyer promo week
			$data1[5] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 6132,
								'intquantity'	=> 1,
								'intid_harga'	=> 6132,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			//kalender 2013
			$data1[6] = array(
								'intid_nota' => $intid_nota,
								'intid_barang' => 5933,
								'intquantity'	=> 1,
								'intid_harga'	=> 5933,
								'is_free'	=> 1,
								'intharga' => 0,
								'nomor_nota' => $intno_nota,
								);
			$this->db->insert_batch('nota_detail',$data1);
			}
		}
	//end of promosi building
}
?>
