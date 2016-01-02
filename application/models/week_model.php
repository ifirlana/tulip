<?php
class Week_model extends CI_Model{

	function   __construct() {
        parent::__construct();
    }

    //page
	private $tbl = 'week';

    function nama_bulan($bulan) {
        switch ($bulan) {
            case '0':
                $b="Januari";
                break;
            case '1':
                $b = "Januari";
                break;
            case '2':
                $b = "Februari";
                break;
            case '3':
                $b = "Maret";
                break;
            case '4':
                $b = "April";
                break;
            case '5':
                $b = "Mei";
                break;
            case '6':
                $b = "Juni";
                break;
            case '7':
                $b = "Juli";
                break;
            case '8':
                $b = "Agustus";
                break;
            case '9':
                $b = "September";
                break;
            case '10':
                $b = "Oktober";
                break;
            case '11':
                $b = "November";
                break;
            case '12':
                $b = "Desember";
                break;

        }

        return $b;

    }

	function selectAll()
	{
		return $this->db->get($this->tbl)->result();
	}

	function get_list_data($limit = 10, $offset = 0)
  	{
		$this->db->limit($limit, $offset);
  		$this->db->order_by('intid_week','desc');
		return $this->db->get($this->tbl,$limit,$offset);
  	}

    function get_list_data_search($limit = 10, $offset = 0, $s)
  	{
        if(empty($s['bulan'])){
        $this->db->limit($limit, $offset);
  		$this->db->order_by('intid_week','desc');
        }else{
        $this->db->where('intbulan', $s['bulan']);
		$this->db->limit($limit, $offset);
  		$this->db->order_by('intid_week','desc');
        }
		return $this->db->get($this->tbl,$limit,$offset);
  	}

	function countData()
	{
	  	return $this->db->count_all($this->tbl);
  	}
//end page
    function getWeek(){

	   $query = $this->db->query("SELECT *  FROM week
               ORDER BY intid_week ASC");
	   return $query->result();
    }

	function insert($data){
	$data = array(
            'intid_week' => $this->input->post('week'),
            'intbulan' => $this->input->post('bulan'),
            'dateweek_start' => $this->input->post('dateweek_start'),
            'dateweek_end' => $this->input->post('dateweek_end'));
        $this->db->insert('week', $data);
	}

   function delete($idweek){
       $this->db->where('intid_week', $idweek);
       $this->db->delete('week');
    }

    function select($idweek){
       $query = $this->db->query("select * from week where id = $idweek");
	   return $query->result();
    }

    function selectenddate($idweek, $tahun){
       $query = $this->db->query("select dateweek_end from week where intid_week = $idweek and inttahun = $tahun");
	   return $query->result();
    }
	
	function update($idweek){
            $data = array(
            'intid_week' => $this->input->post('week'),
            'intbulan' => $this->input->post('bulan'),
            'dateweek_start' => $this->input->post('dateweek_start'),
            'dateweek_end' => $this->input->post('dateweek_end'));
            $this->db->where('id', $idweek);
            $this->db->update('week',$data);
    }
	
	function selectWeek($data = array()){
		
		if(isset($data['tahun']) and $data['tahun'] != ""){
			
			return $this->db->query("select * from week where inttahun = ".$data['tahun']." group by intid_week");
			}
			else{
				
				return $this->db->query("select * from week group by intid_week");
				}
		}
	
	//
	function selectTahun($data = array()){
		
		if(isset($data['tahun']) and $data['tahun'] != ""){
			
			return $this->db->query("select inttahun from week where inttahun >= ".$data['tahun']." group by inttahun");
			}
			else{
				
				return $this->db->query("select inttahun from week group by inttahun");
				}
		}
	function getWeekYear($intid_week = 0, $tahun = 0){
		$select = "select * from week where inttahun = $tahun and intid_week = $intid_week";
		return $this->db->query($select);
		}
	function getAllYear($tahun)
	{
		$select = "select * from week where inttahun = $tahun";
		return $this->db->query($select);
	}
	function getDateFromWeek($date)
	{
		$select = "select * from week where dateweek_start >= '$date' and dateweek_end <= '$date'";
		return $this->db->query($select);
	}
}
?>
