<?php
	class nota_model extends CI_Model{
		function  __construct() 
		{
			parent::__construct();
			$this->load->model('User_model');
			$this->load->model('Penjualan_model');
			$this->table_nota_detail	= "nota_detail";
			$this->table_nota				= "nota";
		}
		function getno_nota(){
			$cabang = $this->User_model->getCabang($this->session->userdata('username'));
			$week = $this->Penjualan_model->selectWeek();
			
			$getnota = $this->Penjualan_model->getNoNotaNew();
			$nilai = $getnota[0]->id;
			$id = $nilai + 1;
			$this->Penjualan_model->getNoNotaUpdate($id);
			
			$kode = $cabang[0]->intid_cabang.".".$week[0]->intid_week.".".sprintf("%05s", $nilai);
			return $kode;

		}
		function getDataNota($data = array(), $escape = false)
		{
			$select	=	"select ";
			$from	=	"from nota ";
			$where	=	"where ";
			$groupby	=	" ";
			$leftjoin	=	" ";
			if(isset($data['select']) and !empty($data['select']))
			{
				for($i=0;$i<count($data['select']);$i++)
				{
					$select .= $data['select'][$i].", ";
				}
			}
			else
			{
				$select .= "nota.*, ";					
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
			
			if(isset($data['leftjoin']) and !empty($data['leftjoin']))
			{
				for($i=0;$i<count($data['leftjoin']);$i++)
				{
					$leftjoin .= "left join ".$data['leftjoin'][$i]." on ".$data['lefton'][$i]." ";
				}
			}
			$query = substr($select,0,-2)." ".$from.$leftjoin." ".substr($where,0, -5)." ".$groupby;
			
			if($escape == false)
			{
				return $this->db->query($query);
			}
			else if($escape == true)
			{
				return $query;
			}
		}
		
		function getDataNotaDetail($data = array(), $escape = false)
		{
			$select	=	"select ";
			$from	=	"from nota_detail ";
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
				$select .= "nota_detail.*, ";					
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
		function getTableNota()
		{
			return $this->table_nota;
		}
		function getTableNotaDetail()
		{
			return $this->table_nota_detail;
		}
	}
?>