<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Dealers_model extends CI_Model{
    function   __construct() {
        parent::__construct();
       }

    function insert(){
	$data = array(
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama')
            );
        $this->db->insert('dealer', $data);
	}

        function getDealer(){
            $this->db->select('*');
            $query = $this->db->get('dealer');

            if ($query->num_rows() > 0 ){
                return $query->result_array();
            }
        }

        function  edit(){
            $data = array(
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama'),
            'nama' => $this->input->post('nama')
            );
            $this->db->where('name', $this->input->post('name'));
            $this->db->update('dealers', $data);
        }
		
		/* Tambahan ikhlas  
		* 2014 10 08
		*/
		function getDataDealer($intid_dealer){
			
			return $this->db->query("select * from member where intid_dealer = '$intid_dealer'");
			}
			
		/* function updateMember($hp = 0, $email = "" ,$intid_dealer){
			$query = ("update from member set strtlp = $hp, stremail = $email  where intid_dealer = $intid_dealer");
			
			return $query->result();
		}*/
} 
?>
