<?php
	class Scan_model extends CI_model{
		
		//set modulscan untuk index
		function setmodulScan($dataT){
			//set variable
			$data['id'] = "modulscan";
			//function
			//modulscanjavascript
			$data['status'] = "style='padding:5px 10px 5px 10px;font-size:20pt;margin:20px;border-radius:10px;box-shadow:0 0 10px white;'"; //style input type scanbarcode

			$data['hasilscan'] = "hasilscan"; //id untuk hasil scan html
			if($dataT['default'] == 1){ //
			//rules APLIKASI 
			//pertama auto focus ke fields text
			//kedua lakukan event keyup, stelah itu proses penginputan
				//Ajax di go ke server,
				/* versi rule 1.1
			$data['rules'] = "$(document).ready( function() {
									//alert('focus');
									$(\"#".$data['id']."\").focus();
									$(\"#intid_unit\").attr('readonly','readonly');
									$(\"#strnama_dealer\").attr('readonly','readonly');
									$(\"#".$data['id']."\").live('keyup',function(e){
										if(e.keyCode === 13){ //jika kondisi event adalah enter
											".$dataT['rules']."
											//$(\"#".$data['hasilscan']."\").html('scan : '+$(\"#".$data['id']."\").val()); //masukan data ke html
											$(\"#".$data['id']."\").val(''); //masukan value ke dalam hasilscan
											$(\"#".$data['id']."\").focus();
											}
										});
								});";
								*/
			$data['rules'] = "$(document).ready( function() {
									//alert('focus');
									$(\"#".$data['id']."\").focus();
									$(\"#intid_unit\").attr('readonly','readonly');
									$(\"#strnama_dealer\").attr('readonly','readonly');
										});
									function modulscanjavascript(e){
										if(e.keyCode === 13){ //jika kondisi event adalah enter
											".$dataT['rules']."
											//$(\"#".$data['hasilscan']."\").html('scan : '+$(\"#".$data['id']."\").val()); //masukan data ke html
											console.log($(\"#".$data['id']."\").val());
											$(\"#".$data['id']."\").val(''); //masukan value ke dalam hasilscan
											$(\"#".$data['id']."\").focus();
											}
										}";					
			}
			$variable = "<div sytle='width:100%;'>";
			$variable .= $this->modulScan($data);
			$variable .= "<div id='".$data['hasilscan']."'></div>";
			if(isset($dataT['trouble_shooting'])){
				$url = $dataT['trouble_shooting'];
				$variable .= "<div style='margin:20px auto;'><small><a href='".$url."'>trouble_shooting</a></small></div>";			
			}else{
				if(isset($dataT['form_trouble_shooting'])){
					$variable .= $dataT['form_trouble_shooting'];
				}
			}
			$variable .= "</div>";
			return $variable;
		}
		function modulScan($data){
			//set rules untuk modul scan
			if(isset($data['rules'])){
				$data['rules'] = "<script type=\"text/javascript\">".$data['rules']."</script>";
				}else{
					$data['rules'] = "NO RULES??";
					}
			$variable = "<div style='width:100%;'>";
			$variable .= $data['rules'];
			$variable .= $this->inputanScan($data);
			$variable .= "</div>";

			return $variable;
		}
		function inputanScan($data){
			//data value
			if(isset($data['value'])){
				$data['value'] = "value='".$data['value']."'";
			}else{
				$data['value'] = "";
			}
			//data name
			if(isset($data['name'])){
				$data['name'] = "name='".$data['name']."'";
			}else{
				$data['name'] = "name='modulScan'";
			}
			//data id
			if(isset($data['id'])){
				$data['id'] = "id='".$data['id']."'";
			}else{
				$data['id'] = "id='modulScan'";
			}
			//data class
			if(isset($data['class'])){
				$data['class'] = "class='".$data['class']."'";
			}else{
				$data['class'] = "class='modulScan'";
			}
			//data class
			if(isset($data['status'])){
				$data['status'] = $data['status'];
			}else{
				$data['status'] = "";
			}
			$variable = "Scan here :<input type='text' ".$data['id']." ".$data['class']." ".$data['name']." ".$data['value']." ".$data['status']." onkeypress='modulscanjavascript(event);' />";
			return $variable;
		}
		/*
		TABEL COUNTER_barcode
		--------------------------------------------------------------------------------------------------------
		|	counter_barcode
		|_______________________________________________________________________________________________________
		|
		|	value_1 :	int(11), 0		digunakan untuk menandakan cabang kelahiran member						
		|	value_2 :	int(11), 2014	digunakan untuk tahun kelahiran member 									
		|	value_3 :	int(11), 1 		digunakan untuk menandakan bulan kelahiran member
		|	counter :	int(11), 1 		digunakan untuk melakukan penambahan counter yang mendaftarkan diri
 		|_______________________________________________________________________________________________________
		description :
			tabel ini digunakan untuk memberikan identitas member yang mendaftarkan diri untuk mendapatkan data barcode,
			fungsi utama dari counter ini adalah memberikan hasil counter dengan atau tanpa memberikan pengulangan data. 
		
		@param counter_scanbarcode
		inputan : intid_cabang, tahun kelahiran, bulan kelahiran
		output : string data.
		*/
		function counter_scanbarcode($cabang, $year, $month){
			if(isset($cabang)){
			}else{
				$cabang = 0;
			}
			if(isset($year)){
				}else{
				$year = 0;
				}
			if(isset($month)){
				}else{$month = 0;
			}
			$select = "select counter from counter_barcode where value_1 = '".$cabang."' and value_2 = '".$year."' and value_3 = '".$month."'";
			$query	=	$this->db->query($select);
			$hasilQuery = $query->result();
			if($query->num_rows() > 0){
				$counter = $hasilQuery[0]->counter + 1;
				$select2 = "update counter_barcode set counter = '".$counter."' where value_1 = '".$cabang."' and value_2 = '".$year."' and value_3 = '".$month."' ";
				$this->db->query($select2);
				//set variable scanbarcode
				$data = array(
						'1' => $cabang,
						'2' => $year,
						'3' => $month,
						'4' => $counter,
					);
				$string_scanbarcode = $this->set_stringkeycode($data);//set string key code
				}
				else{
					$data_temp = array(
						'value_1' => $cabang,
						'value_2' => $year,
						'value_3' => $month,
						'counter' => 1,
						);
					$this->db->insert('counter_barcode',$data_temp);
					//set variable scanbarcode
					$data = array(
							'1' => $cabang,
							'2' => $year,
							'3' => $month,
							'4' => 1,
						);
					$string_scanbarcode = $this->set_stringkeycode($data);//set string key code
					}
			return $string_scanbarcode;
		}
		/*
		TABEL counter_barcode_ver_2
		--------------------------------------------------------------------------------------------------------
		|	counter_barcode_ver_2
		|_______________________________________________________________________________________________________
		|
		|	intid_cabang :	int(11), 0		digunakan untuk menandakan cabang kelahiran member						
		|	counter :	int(11), 1 		digunakan untuk melakukan penambahan counter yang mendaftarkan diri
 		|	keterangan :	int(11), text		digunakan untuk menjelaskan bagaimana sistem barcode bekerja						
		|_______________________________________________________________________________________________________
		description :
			tabel ini digunakan untuk memberikan identitas member yang mendaftarkan diri untuk mendapatkan data barcode,
			fungsi utama dari counter ini adalah memberikan hasil counter dengan atau tanpa memberikan pengulangan data. 
		
		@param counter_scan_barcode_ver_2
		inputan : intid_cabang, tahun kelahiran, bulan kelahiran
		output : string data.
		*/
		
		function counter_scan_barcode_ver_2($default){
			if(isset($default['default'])){ //kalau terset maka default yang lama diganti dengan default yang didefinisikan
				$default['default'] = $default['default'];
				}else{ // kalau default tidak ter-set maka dibuat yang default = 0
					$default['default'] = "0";
					}
			$query = $this->db->query("select * from counter_barcode_ver_2 where intid_cabang = '".$default['default']."'"); //memanggil counter_barcode_ver_2 untuk diambil		
			$hasilQuery = $query->result();
			
			if($query->num_rows() > 0){ //jika lebih dari nol baris maka update data, counter + 1
				$count = $hasilQuery[0]->counter + 1;
				$this->db->query("update counter_barcode_ver_2 set counter = '".$count."' where intid_cabang = ".$default['default'].""); 
				}

			$data_scan = array(
				'1'=>$default['intid_cabang'],
				'2'=>$count,
				'3'=>$default['revisi'],
				);
			$string_scanbarcode = $this->set_stringkeycode_ver_2($data_scan);
			return $string_scanbarcode;
		}
		/*
		descrption : 
			digunakan untuk menyusun string key code data.
		
		@param set_stringkeycode
		input : array 
		output : hasil query
		*/
		function set_stringkeycode($data){
			//untuk cabang
			if($data['1'] > 0 and $data['1'] < 10){
				$data['1'] = "00".$data['1'];
				}
				elseif($data['1'] >= 10 and $data['1'] < 100){
					$data['1'] = "0".$data['1'];
					}
			//kondisi untuk tahun
			if($data['2'] < 1000){
				$data['2'] = "ERRR";
				}
			//kondisi untuk bulan
			if($data['3'] > 0 and $data['3'] < 10){
				$data['3'] = "0".$data['3'];
				}
			//kondisi untuk counter 
			if($data['4'] < 10){
				$data['4'] = "000".$data['4'];
				}
				else if($data['4'] >= 10 and $data['4'] < 100){
					$data['4'] = "00".$data['4']; 
					}
					else if($data['4'] >= 100 and $data['4'] < 1000){
						$data['4'] = "0".$data['4']; 
						}else{ //kondisi diatas 1000
							$data['4'] = $data['4'];
						}
			$var = $data['1'].".".$data['2'].".".$data['3'].".".$data['4'];			
			return $var;
			}
		/*
		descrption : 
			digunakan untuk menyusun string key code data.
			revisi tahap 1 dengan pak daniel
		@param set_stringkeycode
		input : array 
		output : hasil query
		*/
		function set_stringkeycode_ver_2($data){
			//untuk cabang 000
			if($data['1'] > 0 and $data['1'] < 10){
				$data['1'] = "00".$data['1'];
				}
				elseif($data['1'] >= 10 and $data['1'] < 100){
					$data['1'] = "0".$data['1'];
					}
			//kondisi untuk counter 000000
			if($data['2'] < 10){
				$data['2'] = "00000".$data['2'];
				}
				else if($data['2'] >= 10 and $data['2'] < 100){
					$data['2'] = "0000".$data['2']; 
					}
					else if($data['2'] >= 100 and $data['2'] < 1000){
						$data['2'] = "000".$data['2']; 
						}
						else if($data['2'] >= 1000 and $data['2'] < 10000){
							$data['2'] = "00".$data['2']; 
							}
							else if($data['2'] >= 10000 and $data['2'] < 100000){
								$data['2'] = $data['2']; 
								}else{ //kondisi diatas 1000000
									$data['2'] = "ov".$data['2']."er";
								}
			//kondisi untuk kartu 00
			if(isset($data['3'])){
				if($data['3'] < 10){
				$data['3'] = $data['3'];
				}
			}
			$var['barcode'] = $data['1'].".".$data['2'].".".$data['3'];			
			$var['basic'] = $data['1'].".".$data['2'];
			return $var;
			}
	function set_stringkeycode_ver_2_revisi($basic,$revisi){
			//untuk cabang 000
			$barcode = $basic.".".$revisi;
			return $barcode;
		}
	function get_memberbarcode($intid_dealer){
		$query = $this->db->query("select barcode_basic from scan_barcode where kode = '".$intid_dealer."' group by kode");
		$hasilQuery = $query->result();
		return $hasilQuery[0]->barcode_basic;
		}
	}
?>