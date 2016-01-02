<?php

class _Login_model extends CI_Model {

	function validate()
	{
		$this->db->select('id_user, name, id_authorise');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$this->db->limit(1);
		$query = $this->db->get('_user');

		if($query->num_rows == 1)
		{
			foreach($query->result() as $row)
			{
				$data = array(
		          'id_user' => $row->id_user,
		          'name' => $row->name,
		          'id_authorise' => $row->id_authorise,
		          'is_logged_in' => true
		        );
			}
			return $data;
		}
	}

	function webpageAccess($id_authorise, $id_webpage = NULL)
	{
		$this->db->select('_webpage_code.id_webpage, webpage_name, controller');
		if($id_authorise != 1)
		{
			$this->db->join('_webpage_access', '_webpage_access.id_webpage = _webpage_code.id_webpage');
			$this->db->where('id_authorise', $id_authorise);
		}
		if($id_webpage != NULL)
		{
			$this->db->where_in('_webpage_code.id_webpage', $id_webpage);
		}
		$this->db->order_by('id_webpage');
		$query = $this->db->get('_webpage_code');

		if($query->num_rows >= 1)
		{
			foreach($query->list_fields() as $field)
			{
				foreach($query->result() as $row)
				{
					$data[$field][] = $row->$field;
				}
			}
			return $data;
		}
	}

	function branchAccess($id_user)
	{
		$this->db->select('id_authorise');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get('_user');
		if($query->num_rows >= 1)
		{
			foreach($query->result() as $row)
			{
				$au = $row->id_authorise;
			}
		}

		$this->db->select('cabang.intid_cabang as id_branch');
		if($au == 1){}
		else if($au == 2)
		{
			$test_branch = array(1,28,99,95,110,107,145);
			$this->db->where_not_in('cabang.intid_cabang', $test_branch);
		}
		else
		{
			$this->db->join('_branch_access', '_branch_access.id_branch = cabang.intid_cabang');
			$this->db->where('id_user', $id_user);
		}
		$query = $this->db->get('cabang');
		if($query->num_rows >= 1)
		{
			foreach($query->result() as $row)
			{
				$data['id_branch'][] = $row->id_branch;
			}
			return $data;
		}
	}
}