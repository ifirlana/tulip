<?php
	CLASS form_control_plugins EXTENDS CI_Controller
	{
		
		function  __construct() 
		{
			parent::__construct();
		}
		
		function getData()
		{
			$data	= array();
			$temp	= "";
			$intid_dealer 		=	$this->input->post("intid_dealer");
			$intid_cabang		=	$this->input->post("intid_cabang");
			$intid_promo		=	$this->input->post("intid_promo");
			$intid_penjualan	=	$this->input->post("intid_penjualan");
			$code_voucher	=	$this->input->post("code_voucher");
			$count					=	$this->input->post("count");
			$this->input->post("intid_jpenjualan");
			
			$isiPromo							=	$this->input->post("isiPromo");
			$idPromo							=	$this->input->post("idPromo");
			$idPenj							=	$this->input->post("idPenj");
			$isiPenjualan					=	$this->input->post("isiPenjualan");
					
			$pv								=	$this->input->post("pv");
			$omset						=	$this->input->post("omset");
			$kom10						=	$this->input->post("kom10");
			$kom15						=	$this->input->post("kom15");
			$kom20						=	$this->input->post("kom20");
			$diskon						=	$this->input->post("diskon");
					
					
			//$query1		=	$this->db->query("select * from control_class where id_jpenjualan = $intid_penjualan and id_control_promo =  $intid_promo");
			$findNota = $this->db->query("select * from nota where intid_dealer = $intid_dealer and intno_nota ='$code_voucher'");
			if($findNota->num_rows() > 0)
			{
				$error_text =  'Jenis promo penebusan tidak sama, promo harus sesuai dengan promo nota penebusan';
			}
			else
			{
				$error_text =  'Maaf Data Tidak Di Temukan';
			}

			$findNota = $this->db->query("select * from nota where intid_dealer = $intid_dealer and intno_nota ='$code_voucher' and intid_jpenjualan = $idPenj  ");
			if($findNota->num_rows() > 0):
			
			$findNotaVoucher = $this->db->query("select * from nota_tebus_voucher where code_voucher ='$code_voucher' ");
				if($findNotaVoucher->num_rows() == 0):
				
					$findVoucher	=	$this->db->query("select * from  control_nota_voucher left join barang on control_nota_voucher.intid_barang = barang.intid_barang where code_voucher = '$code_voucher' #and control_nota_voucher.id_promo = $idPromo");
					if($findVoucher->num_rows() == 0):
						echo "<table id='data' width='100%'><tr class='isiFormBarang'><td class='tdTampung'>". 'Jenis promo penebusan tidak sama, promo harus sesuai dengan promo nota penebusan'."<script>$('#nonotavoucher').attr('readonly', false);</script></td></tr></table>";
					else:
					foreach($findVoucher->result() as $Rok)
					{
						
							$form['count'] 						=	$count++;
							$form['data']['count'] 						=	$count;
							$form['data']['intid_barang'] 				=	$Rok->intid_barang;
							$form['data']['intid_jpenjualan']			=	$idPenj;
							$form['data']['nameBarang']				=	$Rok->strnama;
							$form['data']['intid_harga']					=	$Rok->intid_barang;
							
							$form['data']['isiPromo']					=	$isiPromo;
							$form['data']['idPromo']						=	$idPromo;
							$form['data']['idPenj']						=	$idPenj;
							$form['data']['isiPenjualan']				=	$isiPenjualan;
							$form['data']['intid_jbarang']				=	$Rok->intid_jbarang;
							//$form['data']['class_intqty']				=	$form['statusBarang'];
							$form['data']['intqty']							=	$Rok->qty;
							
							$form['data']['pv']						=	($pv == 0) ? 0 : number_format( $Rok->pv * $diskon * $Rok->qty , 2);
							$form['data']['intpv']						=	($pv == 0) ? 0 : number_format($Rok->pv * $diskon * $Rok->qty , 2);
							$form['data']['inttotal_omset']		=	($omset == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['intomset10']				=	($kom10 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['intomset15']				=	($kom15 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['intomset20']				=	($kom20 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['omset10']				=	($kom10 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['omset15']				=	($kom15 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['omset20']				=	($kom20 == 0) ? 0 : ($Rok->omset * $diskon) * $Rok->qty;
							$form['data']['komisi10']				=	$form['data']['omset10']  * 0.1;
							$form['data']['komisi15']				=	$form['data']['omset15']  * 0.15;
							$form['data']['komisi20']				=	$form['data']['omset20']  * 0.2;
							$totals = ($form['data']['intomset10'] + $form['data']['intomset15'] + $form['data']['intomset20']) - ($form['data']['komisi10']  + $form['data']['komisi15'] + $form['data']['komisi20']);
							$form['data']['inttotal_bayar']				=	($totals == 0) ? $Rok->price * $diskon * $Rok->qty: $totals;
							$form['data']['intharga']					=	$Rok->price ;
							$form['data']['intharganew']					=	$Rok->price ;
							$form['data']['diskon']					=	($diskon == 1) ? 1 : $diskon;
							$form['data']['intno_nota']				=	$code_voucher;
							
							$temp .= $this->load->view("template/form_hitung_barang",$form,true);
						
					}
					endif;
				//	$data["#formBarang"] = $temp;
						
					echo "<table id='data' width='100%'><tr class='isiFormBarang'><td class='tdTampung'>".$temp."</td></tr></table>";
					
					//echo json_encode($data);
					else:
					echo "<table id='data' width='100%'><tr class='isiFormBarang'><td class='tdTampung'> Maaf Nomor Tersebut Sudah Di Pakai.<br> Silahkan Hubungi Kantor Pusat<script>$('#nonotavoucher').attr('readonly', false);</script></td></tr></table>";
				endif;
				else:
				echo "<table id='data' width='100%'><tr class='isiFormBarang'><td class='tdTampung'>".$error_text."<script>$('#nonotavoucher').attr('readonly', false);</script></td></tr></table>";
			endif;
		}
		
		function getDataDB()
		{
			$data	=	array();
			$temp 	=	"";
			$data['intid_cabang'] 	= $this->input->post("intid_cabang");
			$data['id_promo'] 		= $this->input->post("id_promo"); 
			$data['id_penjualan'] 	= $this->input->post("id_penjualan");
			
			$this->load->model("control/control_model","ctm");
			$query	=	$this->ctm->control_plugin($data['intid_cabang'],$data['id_promo'],$data['id_penjualan']);
			
			foreach($query->result() as $row)
			{
				$temp	.=	$this->load->view($row->plugin,"",true);
			}
			echo $temp;
			//echo $query;
		}
		
		function getDataKodeVoucher()
		{
			$data	= array();
			$temp	= "";
			$intid_dealer 		=	$this->input->post("intid_dealer");
			$intid_cabang		=	$this->input->post("intid_cabang");
			$intid_promo		=	$this->input->post("intid_promo");
			$intid_penjualan	=	$this->input->post("intid_penjualan");
			$code_voucher	=	$this->input->post("code_voucher");
			$count					=	$this->input->post("count");
			$this->input->post("intid_jpenjualan");
			
			$isiPromo							=	$this->input->post("isiPromo");
			$idPromo							=	$this->input->post("idPromo");
			$idPenj							=	$this->input->post("idPenj");
			$isiPenjualan					=	$this->input->post("isiPenjualan");
					
			$pv								=	$this->input->post("pv");
			$omset						=	$this->input->post("omset");
			$kom10						=	$this->input->post("kom10");
			$kom15						=	$this->input->post("kom15");
			$kom20						=	$this->input->post("kom20");
			$diskon						=	$this->input->post("diskon");
					
			
			$select ="select * from  control_nota_voucher left join barang on control_nota_voucher.intid_barang = barang.intid_barang 
			where code_voucher = '$code_voucher' and intid_cabang = '$intid_cabang'";
			$findVoucher	=	$this->db->query($select);
			if($findVoucher->num_rows() > 0)
			{
				foreach($findVoucher->result() as $Rok)
				{	
					$form['count'] 						=	$count++;
					$form['data']['count'] 						=	$count;
					$form['data']['intid_barang'] 				=	$Rok->intid_barang;
					$form['data']['intid_jpenjualan']			=	$idPenj;
					$form['data']['nameBarang']				=	$Rok->strnama;
					$form['data']['intid_harga']					=	$Rok->intid_barang;
					
					$form['data']['isiPromo']					=	$isiPromo;
					$form['data']['idPromo']						=	$idPromo;
					$form['data']['idPenj']						=	$idPenj;
					$form['data']['isiPenjualan']				=	$isiPenjualan;
					$form['data']['intid_jbarang']				=	$Rok->intid_jbarang;
					//$form['data']['class_intqty']				=	$form['statusBarang'];
					$form['data']['intqty']							=	$Rok->qty;
					
					$form['data']['pv']						=	($pv == 0) ? 0 : $Rok->pv * $diskon * $Rok->qty;
					$form['data']['intpv']						=	($pv == 0) ? 0 : $Rok->pv * $diskon *  $Rok->qty;
					$form['data']['inttotal_omset']		=	($omset == 0) ? 0 : $Rok->omset * $diskon * $Rok->qty;
					$form['data']['intomset10']				=	($kom10 == 0) ? 0 : $Rok->omset * $diskon  * $Rok->qty;
					$form['data']['intomset15']				=	($kom15 == 0) ? 0 : $Rok->omset * $diskon * $Rok->qty;
					$form['data']['intomset20']				=	($kom20 == 0) ? 0 : $Rok->omset * $diskon * $Rok->qty;
					$form['data']['omset10']				=	($kom10 == 0) ? 0 : $Rok->omset *  $diskon * $Rok->qty;
					$form['data']['omset15']				=	($kom15 == 0) ? 0 : $Rok->omset * $diskon * $Rok->qty;
					$form['data']['omset20']				=	($kom20 == 0) ? 0 : $Rok->omset * $diskon * $Rok->qty;
					$form['data']['komisi10']				=	$form['data']['omset10']  * 0.1;
					$form['data']['komisi15']				=	$form['data']['omset15']  * 0.15;
					$form['data']['komisi20']				=	$form['data']['omset20']  * 0.2;
					$tots = ($form['data']['intomset10'] + $form['data']['intomset15'] + $form['data']['intomset20']) - ($form['data']['komisi10']  + $form['data']['komisi15'] + $form['data']['komisi20']);
					$form['data']['inttotal_bayar']				=	($tots == 0) ? $Rok->price * $diskon * $Rok->qty: $tots;
					$form['data']['intharga']					=	$Rok->omset ;
					$form['data']['intharganew']					=	$Rok->omset ;
					$form['data']['diskon']					=	($diskon == 0) ? 1 : $diskon;
					$form['data']['intno_nota']				=	$code_voucher;
					$temp .= $this->load->view("template/form_hitung_barang",$form,true);
						
				}
					
					//$data["#formBarang"] = $temp;
					echo "<table id='data' width='100%'><tr class='isiFormBarang'><td class='tdTampung'>".$temp."</td></tr></table>";
					//echo json_encode($data);
			}
			else
			{
				echo "VOUCHER TIDAK TERSEDIA. SILAHKAN HUBUNGI PUSAT.";
			}
				
		}
	}