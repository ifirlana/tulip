<?php
class MAIN_MODEL extends CI_Model{
    function insertNOTA($data){
    	$this->db->insert('nota',$data);
    	return $this->db->insert_id();
    }
    function insertNOTADETAIL($data)
	{
        $this->db->insert("nota_detail", $data);
	}
}
?>