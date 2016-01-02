<?php

class Coupon extends CI_Controller
{
	function index()
	{
		$this->load->model('Laporan_model');
		$this->load->model('User_model');
		$this->load->model('Cabang_model');
		$this->load->model('gathering_model','gth');
		
		$week = $this->Laporan_model->selectWeek();
		foreach ($week as $g)
		{
			$data['id'][]	 	= $g->id;
			$data['intid_week'][] 	= $g->intid_week;
			
		}
		
		$cabang = $this->User_model->getCabang($this->session->userdata('username'));
        $nm_cabang = $this->Cabang_model->select($cabang[0]->intid_cabang);

        $data['cabang'] = $nm_cabang[0]->strnama_cabang;
		$data['id_cabang'] = $nm_cabang[0]->intid_cabang;
		$data['tahun'] = $this->gth->selecttahun();
		
        $this->load->view('coupon/form-laporan',$data);
	}

	//laporannya
	function laporan()
	{
		//echo "<pre />";
		$week	=	$this->input->post("intid_week");
		$tahun	=	$this->input->post("tahun");
		$query	=	$this->db->query("select * from week where intid_week = $week and inttahun = $tahun");
		foreach ($query->result() as $rows) 
		{
			$start 	= $rows->dateweek_start;
			$end 	= $rows->dateweek_end;
		}
		 
		$this->load->model("coupon_model","cmodel");
		$temp = $this->cmodel->laporanMember(true,array("dateweek_start" => $start, "dateweek_end" => $end));
		if($temp->num_rows() > 0)
		{
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename=Laporan_coupon_'.$start.'_'.$end.'.xls');
			header('Cache-Control: max-age=0');

			echo "<table border='1' cellpadding='5' cellspacing='0'>";
			echo "<tr>";
				echo "<th>Cabang Kelahiran</th>";
				echo "<th>Cabang Pengambilan</th>";
				echo "<th>tanggal awar</th>";
				echo "<th>tanggal akhir</th>";
				echo "<th>Kode Program</th>";
				echo "<th>Kode Dealer</th>";
				echo "<th>Nama Dealer</th>";
				echo "<th>Nama Upline</th>";
				echo "<th>Detail</th>";
				echo "<th>Unit</th>";
				echo "<th>Total Kupon</th>";
			echo "</tr>";
			foreach ($temp->result() as $rows) 
			{
				echo "<tr>";
				echo "<td>".$rows->strnama_cabang."</td>";
				echo "<td>".$rows->strnama_cabang_pengambilan."</td>";
				echo "<td>".$rows->dateweek_start."</td>";
				echo "<td>".$rows->dateweek_end."</td>";
				echo "<td>".$rows->intid_dealer."</td>";
				echo "<td>".$rows->strkode_dealer."</td>";
				echo "<td>".$rows->strnama_dealer."</td>";
				echo "<td>".$rows->strnama_upline."</td>";
				echo "<td>";
				$query	=	$this->cmodel->laporanMember(false,array("intid_dealer" => $rows->intid_dealer,"dateweek_start" => $start, "dateweek_end" => $end),"nota-cabang");
				if($query->num_rows() > 0)
				{
					echo "<table  border='1' cellspacing='0'>";
					foreach ($query->result() as $rows_detail) 
					{
						echo "<tr>";
						echo "<td>".$rows_detail->strnama_cabang."</td>";
						echo "<td>".$rows_detail->total."</td>";
						echo "</tr>";
											
					}
					echo "</table>";
				}
				echo "</td>";
				echo "<td>".$rows->unit."</td>";
				echo "<td>".$rows->total."</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		function check()
		{
			$query	=	$this->cmodel->laporanMember(false,array("intid_dealer" => $rows->intid_dealer,"dateweek_start" => $start, "dateweek_end" => $end),"member-cabang");
		}
	}
} 