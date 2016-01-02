<?php

class Membership_model extends CI_Model {

	function   __construct() {
        parent::__construct();
    	$this->load->model('scan_model','mdl_scan');
        $this->load->model('antrian_pemesanan_model','mdl_antrian');
    }
       	
	function validate($id)
	{
	//CREATE TABLE md5_tbl (md5_val BINARY(16), ...);
	//INSERT INTO md5_tbl (md5_val, ...) VALUES(UNHEX(MD5('abcdef')), ...);

		//$this->db->where('username', $this->input->post('username'));
		//$this->db->where('password', $this->input->post('password'));
		//$this->db->where('password', md5($this->input->post('password')));
		//$query = $this->db->get('membership');
		
		//$sql = "SELECT * FROM membership WHERE  username = ? AND password = ?"; 
		//$query = $this->db->query($sql, array($this->input->post('username'),$this->input->post('password')));
		
		$sql = "SELECT * FROM system_user WHERE  strnama_user = ? AND strpass_user = ?"; 
		$query = $this->db->query($sql, array($this->input->post('username'),$this->input->post('password')));
		
		if($query->num_rows == 1)
		{
			 foreach ($query->result() as $row)
			 {
				
				 $id = $row->intid_privilege;
				 
			 }
			return $id;
			
		}else{
			
			$id = "0";
			return $id;
		}
		
	}
	
	// function periksa_user($data_user){

		// $password=substr(md5($data_user['password']),0,16);
		// $this->db->where(‘username’, $data_user['username']);
		// $this->db->where(‘password’, $password);
		// $hasil_query=$this->db->get(‘user’);
		// return $hasil_query;

	// }	
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),			
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'password2' => md5($this->input->post('password2'))				
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);

		return $insert;
	}
	//@param insertMembershipBarcode
	//desc : untuk proses penginputan ke tabel barcode
	function insertMembershipBarcode($barcode,$basic,$intid_dealer){
		$data = array(
					'kode' => $intid_dealer,
					'barcode_data' => $barcode,
					'barcode_basic' => $basic,
					'date_added' => date('Y-m-d H:i:s'),
					'is_active' => 1);
		$this->db->insert('scan_barcode',$data);
		return $this->db->insert_id();
	}

	//@param insert_starterkit_barcode
	//desc : untuk proses penggunaan pendaftaran starterkit, sehingga mendapatkan barcode_scan
	function insert_starterkit_barcode($data = ""){
		$intid_dealer = $data['intid_dealer'];//data variable
		$intid_cabang = $data['intid_cabang'];//data variable

		$data_barcode['intid_cabang'] = $intid_cabang;
		$data_barcode['revisi'] = 1;
		$barcode = $this->mdl_scan->counter_scan_barcode_ver_2($data_barcode); //mencari barcode data O:array
	
		$data_antrian = array(
	        'intid_dealer'  =>  $intid_dealer,
	        'date_added'  =>  date('Y-m-d H:i:s'),
	        'barcode_data'  =>  $barcode['barcode'],
	        'is_printed'  => 1, 
	        );
	    $this->mdl_antrian->insert_antrian($data_antrian);//menyimpan data ke tabel antrian_pemesanan
    
		$this->insertMembershipBarcode($barcode['barcode'],$barcode['basic'],$intid_dealer);//menyimpan data membershipbarcode				
	}
	
	//@param update_data_memberbarcode
	//desc : digunakan untuk form pendaftaran barcode, kondisinya adalah jika sudah pernah mendapatkan barcode dan mendaftarkan kembali
	function update_data_memberbarcode($intid_dealer){
		$basic = $this->get_memberbarcode($intid_dealer); //mencari kode basic
    	$total = $this->counting_antrian($intid_dealer); //mencari kode revisi
    	$total = $total + 1;
    	$barcode = $this->mdl_scan->set_stringkeycode_ver_2_revisi($basic,$total); //set string barcode
    	
    	$this->update_active_barcode($intid_dealer); //mematikan barcode member
    	$this->insertMembershipBarcode($barcode,$basic,$intid_dealer); //memasukan member baru
    	
    	$data['barcode'] = $barcode;
    	$data['basic'] = $basic;
    	return $data;
    }

    //@param get_memberbarcode
    //digunakan untuk mencari barcode_basic
    function get_memberbarcode($intid_dealer){
    	$query = $this->db->query('select barcode_basic from scan_barcode where kode = '.$intid_dealer.' and is_active = 1');
    	$hasilQuery = $query->result();
    	return $hasilQuery[0]->barcode_basic;
    }
    //@param counting_antrian
    //digunakan untuk mencari jumlah pemesanan yang serupa
    function counting_antrian($intid_dealer){
    	$query = $this->db->query("select count(*) total from antrian_pemesanan where intid_dealer = '".$intid_dealer."'");
    	$hasilQuery = $query->result();
    	return $hasilQuery[0]->total;
    }
    //@param update_active_barcode
    //digunakan untuk mencari pengupdetan barcode_data
    function update_active_barcode($intid_dealer){
    	$this->db->query("update scan_barcode set is_active = 0 where kode = '".$intid_dealer."'");
    	return true;
    	}
	//@param get_laporan
    //digunakan untuk controllers
    function get_laporan($strkode_dealer="", $strnama_dealer = "", $intid_dealer = "", $intlevel_dealer = ""){
    	if($intlevel_dealer == 1){//kalau manajer
	    	$select = "select intid_week from week where intbulan = (select intbulan from week where CURDATE() between dateweek_start and dateweek_end) group by intid_week";
	    	$hasilQuery = $this->db->query($select);
			$hasilQuery = $this->db->query($select);
				$Q = $hasilQuery->num_rows();
				$QQ = $Q + 1;   	
				$var = "<table border='1' style='width:100%;background:white;' cellpadding='0' cellspacing='0'>
						<tr>
							<td colspan='".$QQ."' align='center'><b>".$strnama_dealer."</b></td>
						</tr>";
				$var .= "<tr><td>&nbsp;</td>";
				foreach($hasilQuery->result() as $row){
					$var .= "<td>".$row->intid_week."</td>";
					}
				//mencari omset perminggu
				$var .= "<tr>
						<td>Omset</td>";
				foreach($hasilQuery->result() as $row){
					$select2	= "select if(sum(inttotal_omset) is null,0,sum(inttotal_omset)) inttotal_omset from nota where intid_dealer = ".$intid_dealer." and intid_week = ".$row->intid_week.""; 
					$Q2			= $this->db->query($select2);
					$hasil = $Q2->result();
					$var .= "<td>".$hasil[0]->inttotal_omset."</td>";
					}
				$var .= "</tr>";
				$var .= "<tr>
						<td>PV</td>";
				foreach($hasilQuery->result() as $row){
					$select2	= "select if(sum(intpv) is null, 0, sum(intpv)) intpv from nota where intid_dealer = ".$intid_dealer." and intid_week = ".$row->intid_week.""; 
					$Q2			= $this->db->query($select2);
					$hasil = $Q2->result();
					$var .= "<td>".$hasil[0]->intpv."</td>";
					}
				$var .= "</tr>";
				$var .= "<tr>
							<td colspan='".$QQ."' align='center'>SYARAT MANAGER</td>
						</tr>";
				$var .= "<tr>
						<td>Rekrut dan Belanja</td>";
				foreach($hasilQuery->result() as $row){
					
					$select_rekrut = "select count(*) total from member where strkode_upline = '".$strkode_dealer."' and intid_week = ".$row->intid_week."";
					
					$query = $this->db->query($select_rekrut);
					$hasil_1 = $query->result();
					//$var .= "<td>".$hasil_1[0]->total."</td>";
					

					$select_rekrut2 = "select if(sum(inttotal_omset) is null, 0,sum(inttotal_omset)) inttotal_omset from member inner join nota on nota.intid_dealer = member.intid_dealer where member.strkode_upline = '".$strkode_dealer."' and member.intid_week = ".$row->intid_week."";
					//$var .= "<td>".$select_rekrut2."</td>";
					$query2 = $this->db->query($select_rekrut2);
					$hasil_2 = $query2->result();
					
					$var .= "<td>".$hasil_1[0]->total."<br />".$hasil_2[0]->inttotal_omset."</td>";
					}
				$var .= "<tr>
						<td>Omset Unit</td>";
				foreach($hasilQuery->result() as $row){
					
					$select_unit = "select if(sum(nota.inttotal_omset) is null, 0, sum(nota.inttotal_omset)) inttotal_omset from nota where nota.intid_unit = (select intid_unit from member where member.strkode_dealer = '".$strkode_dealer."') and nota.intid_week = ".$row->intid_week."";
					
					$query = $this->db->query($select_unit);
					$hasil_unit = $query->result();
					if(!empty($hasil_unit[0]->inttotal_omset)){
						$var .= "<td>".$hasil_unit[0]->inttotal_omset."</td>";
						}
						else{
						$var = "<td>&nbsp;</td>";
						}
					}						
				echo $var;
	    	}
	    	else{//kalau dealer
				$select = "select intid_week from week where intbulan = (select intbulan from week where CURDATE() between dateweek_start and dateweek_end) group by intid_week";

				$hasilQuery = $this->db->query($select);
				$Q = $hasilQuery->num_rows();
				$QQ = $Q + 1;   	
				$var = "<table border='1' style='width:100%;background:white;' cellpadding='0' cellspacing='0'>
						<tr>
							<td colspan='".$QQ."' align='center'><b>".$strnama_dealer."</b></td>
						</tr>";
				//lakukan proses pengulangan tanggal
				$var .= "<tr><td>&nbsp;</td>";
				foreach($hasilQuery->result() as $row){
					$var .= "<td>".$row->intid_week."</td>";
					}
				$var .= "</tr>";
				//mencari omset perminggu
				$var .= "<tr>
						<td>Omset</td>";
				foreach($hasilQuery->result() as $row){
					$select2	= "select sum(inttotal_omset) inttotal_omset from nota where intid_dealer = ".$intid_dealer." and intid_week = ".$row->intid_week.""; 
					$Q2			= $this->db->query($select2);
					$hasil = $Q2->result();
					$var .= "<td>".$hasil[0]->inttotal_omset."</td>";
					}
				$var .= "</tr>";
				//mencari omset perminggu
				$var .= "<tr>
						<td>PV</td>";
				foreach($hasilQuery->result() as $row){
					$select2	= "select sum(intpv) intpv from nota where intid_dealer = ".$intid_dealer." and intid_week = ".$row->intid_week.""; 
					$Q2			= $this->db->query($select2);
					$hasil = $Q2->result();
					$var .= "<td>".$hasil[0]->intpv."</td>";
					}
				$var .= "</tr>";
				$var .= "<tr>
							<td colspan='".$QQ."' align='center'>Omset Anak Langsung</td>
						</tr>";
				$select_member = "select * from member where member.strkode_upline = '$strkode_dealer'";
				$query_2 = $this->db->query($select_member);
				foreach($query_2->result() as $rok){
					$var .= "<tr><td>".$rok->strnama_dealer."</td>";
					foreach ($hasilQuery->result() as $row) {
						$var .= "<td>".$this->getharga_anak_langsung($rok->intid_dealer,$row->intid_week)."</td>";
					}
					$var .= "</tr>";
				}
				$var .= "</table>";

				echo $var;
					
				}
    }
    function getharga_anak_langsung($intid_dealer,$intid_week){
    	$select = "select sum(inttotal_omset) inttotal_omset from nota where nota.intid_dealer = ".$intid_dealer." and nota.intid_week = ".$intid_week."";
    	$query = $this->db->query($select);
    	$hasil = $query->result();
    	return $hasil[0]->inttotal_omset;
    }
}