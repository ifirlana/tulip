<?php
class Unit_model extends CI_Model{
	
	function   __construct() 
	{
        parent::__construct();
		$this->table_unit	=	"unit";
	}

	function insert($data){
			$this->db->insert('unit', $data);
			return true;
	}

   function delete($idunit){
       $this->db->where('intid_unit', $idunit);
       $this->db->delete('unit');
    }

    function select($idunit){
       $query = $this->db->query("select * from Unit where intid_unit= $idunit");
	   return $query->result();
    }

	function update($idunit){
            $data = array(
            'strnama_unit' => $this->input->post('strnama_unit'));
            $this->db->where('intid_unit', $idunit);
            $this->db->update('unit',$data);
    }
	
	 function insert_babymanager($unit_baru, $unit_awal){
	$data = array(
            'intid_unit' => $unit_awal,
            'intid_unitbaby' => $unit_baru
		);
	
        $this->db->insert('baby_manager', $data);
	}
	  function Cari_unit($limit,$offset,$strnama_unit)
	{
	    $q = $this->db->query("SELECT *  FROM unit
            WHERE strnama_unit LIKE '%$strnama_unit%' LIMIT $offset,$limit");
	    return $q;

           }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
	
	function getDataUnit($data = array(), $escape = false)
	{
		$select	=	"select ";
		$from	=	"from unit ";
		$where	=	"where ";
		$groupby	=	" ";
		if(isset($data['select']) and !empty($data['select']))
		{
			for($i=0;$i<count($data['select']);$i++)
			{
				$select .= $data['select'][$i].", ";
			}
		}
		else
		{
			$select .= "unit.*, ";					
		}
		if(isset($data['where']) and !empty($data['where']))
		{
			for($i=0;$i<count($data['where']);$i++)
			{
				$where .= $data['where'][$i]." and ";
			}
		}
		else
		{
			$where = ""; //null
		}
		if(isset($data['groupby']) and !empty($data['groupby']))
		{
			$groupby	=	"group by ".$data['groupby'];
		}
		
		$query = substr($select,0,-2)." ".$from." ".substr($where,0, -5)." ".$groupby;
		
		if($escape == false)
		{
			return $this->db->query($query);
		}
		else if($escape == true)
		{
			return $query;
		}
	}
	function getTableUnit()
	{
		return $this->table_unit;
	}
}
?>
