<?php

class _logistic_model extends CI_Model {

	function getComponent($id_product = NULL)
	{
		$this->db->select('id_product,
			a.strnama as product_name,
			component,
			b.strnama as component_name,
			qty');
		$this->db->join('barang as a', 'a.intid_barang = id_product');
		$this->db->join('barang as b', 'b.intid_barang = component');
		if($id_product != NULL)
		{
			$this->db->where('id_product', $id_product);
		}
		$this->db->order_by('id_product', 'ASC');
		$query = $this->db->get('_component');
		if($query->num_rows >= 1)
		{
			foreach($query->result() as $row)
			{
				$data['id_product'][] = $row->id_product;
				$data['product_name'][] = $row->product_name;
				$data['component'][] = $row->component;
				$data['component_name'][] = $row->component_name;
				$data['qty'][] = $row->qty;
			}
			return $data;
		}
	}

	function getPO($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, _po.po_number, SUM(qty) as qty, SUM(qty * price) as price, _po.date, _po.close as po_close, _pobs.close as pobs_close, _spkb.close as spkb_close');
		$this->db->join('cabang', '_po.id_branch = cabang.intid_cabang');
		$this->db->join('_po_details', '_po.po_number = _po_details.po_number');
		$this->db->join('(SELECT _pobs_po.po_number, _pobs.* FROM _pobs_po JOIN _pobs ON _pobs.pobs_number = _pobs_po.pobs_number AND _pobs.active = 1) AS _pobs', '_po.po_number = _pobs.po_number', 'left');
		$this->db->join('(SELECT _spkb_pobs.pobs_number, _spkb.* FROM _spkb_pobs JOIN _spkb ON _spkb.spkb_number = _spkb_pobs.spkb_number AND _spkb.active = 1) AS _spkb', '_pobs.pobs_number = _spkb.pobs_number', 'left');
		$this->db->where('DATE(_po.date) >=', $start_date);
		$this->db->where('DATE(_po.date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_po.id_branch', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_po.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_po.close', 1);
		}
		$this->db->where('_po.active', 1);
		$this->db->group_by('_po.po_number');
		$this->db->order_by('_po.date', 'DESC');
		$query = $this->db->get('_po');
		if($query->num_rows >= 1)
		{
			foreach($query->list_fields() as $field)
			{
				foreach($query->result() as $row)
				{
					$data[$field][] = $row->$field;
				}
			}
			//Ambil daftar SJ
			$temp_list = $data['po_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_spb.close as spb_close, _pl.close as pl_close, _sj.sj_number, _sj.close as sj_close, _sj.date_send, _sttb.sttb_number, _sttb.close as sttb_close, _sttb.date as date_received');
				$this->db->join('_pobs', '_pobs_po.pobs_number = _pobs.pobs_number AND _pobs.active = 1', 'left');
				$this->db->join('(SELECT _spkb_pobs.pobs_number, _spkb.* FROM _spkb_pobs JOIN _spkb ON _spkb.spkb_number = _spkb_pobs.spkb_number AND _spkb.active = 1) AS _spkb', '_pobs.pobs_number = _spkb.pobs_number', 'left');
				$this->db->join('(SELECT _spb_spkb.spkb_number, _spb.* FROM _spb_spkb JOIN _spb ON _spb.spb_number = _spb_spkb.spb_number AND _spb.active = 1) AS _spb', '_spkb.spkb_number = _spb.spkb_number', 'left');
				$this->db->join('(SELECT _spb_pl.spb_number, _pl.* FROM _spb_pl JOIN _pl ON _pl.pl_number = _spb_pl.pl_number AND _pl.active = 1) AS _pl', '_spb.spb_number = _pl.spb_number', 'left');
				$this->db->join('(SELECT _sj_pl.pl_number, _sj.* FROM _sj_pl JOIN _sj ON _sj.sj_number = _sj_pl.sj_number AND _sj.active = 1) AS _sj', '_pl.pl_number = _sj.pl_number', 'left');
				$this->db->join('_sttb', '_sj.sj_number = _sttb.receipt_number AND _sttb.active = 1', 'left');
				$this->db->where('po_number', $temp_list[$i]);
				$this->db->where('sj_number IS NOT NULL');
				$this->db->group_by('_sj.sj_number');
				$query = $this->db->get('_pobs_po');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]][$field][] = $row->$field;
						}
					}
				}
			}
			return $data;
		}
	}

	function getLimitPO($id_branch = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, max');
		$this->db->join('cabang', '_limit_po.id_branch = cabang.intid_cabang');
		if($id_branch != NULL)
		{
			$this->db->where('id_branch', $id_branch);
		}
		$query = $this->db->get('_limit_po');
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

	function getPOBS($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, _pobs.pobs_number, SUM(qty) as qty, SUM(qty * price) as price, _pobs.date, _pobs.close as pobs_close, _spkb.close as spkb_close');
		$this->db->join('cabang', '_pobs.id_branch = cabang.intid_cabang');
		$this->db->join('_pobs_details', '_pobs.pobs_number = _pobs_details.pobs_number');
		$this->db->join('(SELECT _spkb_pobs.pobs_number, _spkb.* FROM _spkb_pobs JOIN _spkb ON _spkb.spkb_number = _spkb_pobs.spkb_number AND _spkb.active = 1) AS _spkb', '_pobs.pobs_number = _spkb.pobs_number', 'left');
		$this->db->where('DATE(_pobs.date) >=', $start_date);
		$this->db->where('DATE(_pobs.date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_pobs.id_branch', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_pobs.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_pobs.close', 1);
		}
		$this->db->where('_pobs.active', 1);
		$this->db->group_by('_pobs.pobs_number');
		$this->db->order_by('_pobs.date', 'DESC');
		$query = $this->db->get('_pobs');
		if($query->num_rows >= 1)
		{
			foreach($query->list_fields() as $field)
			{
				foreach($query->result() as $row)
				{
					$data[$field][] = $row->$field;
				}
			}
			//Ambil daftar SJ
			$temp_list = $data['pobs_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_spb.close as spb_close, _pl.close as pl_close, _sj.sj_number, _sj.close as sj_close, _sj.date_send, _sttb.sttb_number, _sttb.close as sttb_close, _sttb.date as date_received');
				$this->db->join('_spkb', '_spkb_pobs.spkb_number = _spkb.spkb_number AND _spkb.active = 1', 'left');
				$this->db->join('(SELECT _spb_spkb.spkb_number, _spb.* FROM _spb_spkb JOIN _spb ON _spb.spb_number = _spb_spkb.spb_number AND _spb.active = 1) AS _spb', '_spkb.spkb_number = _spb.spkb_number', 'left');
				$this->db->join('(SELECT _spb_pl.spb_number, _pl.* FROM _spb_pl JOIN _pl ON _pl.pl_number = _spb_pl.pl_number AND _pl.active = 1) AS _pl', '_spb.spb_number = _pl.spb_number', 'left');
				$this->db->join('(SELECT _sj_pl.pl_number, _sj.* FROM _sj_pl JOIN _sj ON _sj.sj_number = _sj_pl.sj_number AND _sj.active = 1) AS _sj', '_pl.pl_number = _sj.pl_number', 'left');
				$this->db->join('_sttb', '_sj.sj_number = _sttb.receipt_number AND _sttb.active = 1', 'left');
				$this->db->where('pobs_number', $temp_list[$i]);
				$this->db->where('sj_number IS NOT NULL');
				$this->db->group_by('_sj.sj_number');
				$query = $this->db->get('_spkb_pobs');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]][$field][] = $row->$field;
						}
					}
				}
			}
			//Ambil daftar PO yang digabung
			$temp_list = $data['pobs_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_po.po_number');
				$this->db->join('_po', '_pobs_po.po_number = _po.po_number');
				$this->db->where('pobs_number', $temp_list[$i]);
				$query = $this->db->get('_pobs_po');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]]['po_number'][] = $row->$field;
						}
					}
				}
			}
			return $data;
		}
	}

	function getSPKB($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, _spkb.spkb_number, SUM(qty) as qty, SUM(qty * price) as price, _spkb.date, _spkb.close as spkb_close');
		$this->db->join('cabang', '_spkb.id_branch = cabang.intid_cabang');
		$this->db->join('_spkb_details', '_spkb.spkb_number = _spkb_details.spkb_number');
		$this->db->where('DATE(_spkb.date) >=', $start_date);
		$this->db->where('DATE(_spkb.date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_spkb.id_branch', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_spkb.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_spkb.close', 1);
		}
		$this->db->where('_spkb.active', 1);
		$this->db->group_by('_spkb.spkb_number');
		$this->db->order_by('_spkb.date', 'DESC');
		$query = $this->db->get('_spkb');
		if($query->num_rows >= 1)
		{
			foreach($query->list_fields() as $field)
			{
				foreach($query->result() as $row)
				{
					$data[$field][] = $row->$field;
				}
			}
			//Ambil daftar SJ
			$temp_list = $data['spkb_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_spb.close as spb_close, _pl.close as pl_close, _sj.sj_number, _sj.close as sj_close, _sj.date_send, _sttb.sttb_number, _sttb.close as sttb_close, _sttb.date as date_received');
				$this->db->join('_spb', '_spb_spkb.spb_number = _spb.spb_number AND _spb.active = 1', 'left');
				$this->db->join('(SELECT _spb_pl.spb_number, _pl.* FROM _spb_pl JOIN _pl ON _pl.pl_number = _spb_pl.pl_number AND _pl.active = 1) AS _pl', '_spb.spb_number = _pl.spb_number', 'left');
				$this->db->join('(SELECT _sj_pl.pl_number, _sj.* FROM _sj_pl JOIN _sj ON _sj.sj_number = _sj_pl.sj_number AND _sj.active = 1) AS _sj', '_pl.pl_number = _sj.pl_number', 'left');
				$this->db->join('_sttb', '_sj.sj_number = _sttb.receipt_number AND _sttb.active = 1', 'left');
				$this->db->where('spkb_number', $temp_list[$i]);
				$this->db->where('sj_number IS NOT NULL');
				$this->db->group_by('_sj.sj_number');
				$query = $this->db->get('_spb_spkb');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]][$field][] = $row->$field;
						}
					}
				}
			}
			//Ambil daftar POBS yang digabung
			$temp_list = $data['spkb_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_pobs.pobs_number');
				$this->db->join('_pobs', '_spkb_pobs.pobs_number = _pobs.pobs_number');
				$this->db->where('spkb_number', $temp_list[$i]);
				$query = $this->db->get('_spkb_pobs');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]]['pobs_number'][] = $row->$field;
						}
					}
				}
			}
			//Ambil daftar PO yang digabung
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_po.po_number');
				$this->db->join('_po', '_pobs_po.po_number = _po.po_number');
				$this->db->where_in('pobs_number', $data[$temp_list[$i]]['pobs_number']);
				$query = $this->db->get('_pobs_po');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]]['po_number'][] = $row->$field;
						}
					}
				}
			}
			return $data;
		}
	}

	function getSPB($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, _spb.spb_number, SUM(qty) as qty, SUM(qty * price) as price, _spb.date, _spb.close as spb_close');
		$this->db->join('cabang', '_spb.id_branch = cabang.intid_cabang');
		$this->db->join('_spb_details', '_spb.spb_number = _spb_details.spb_number');
		$this->db->where('DATE(_spb.date) >=', $start_date);
		$this->db->where('DATE(_spb.date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_spb.id_branch', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_spb.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_spb.close', 1);
		}
		$this->db->where('_spb.active', 1);
		$this->db->group_by('_spb.spb_number');
		$this->db->order_by('_spb.date', 'DESC');
		$query = $this->db->get('_spb');
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

	function getPL($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, _pl.pl_number, SUM(qty) as qty, SUM(qty * price) as price, _pl.date, _pl.close as pl_close');
		$this->db->join('cabang', '_pl.id_branch = cabang.intid_cabang');
		$this->db->join('_pl_details', '_pl.pl_number = _pl_details.pl_number');
		$this->db->where('DATE(_pl.date) >=', $start_date);
		$this->db->where('DATE(_pl.date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_pl.id_branch', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_pl.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_pl.close', 1);
		}
		$this->db->where('_pl.active', 1);
		$this->db->group_by('_pl.pl_number');
		$this->db->order_by('_pl.date', 'DESC');
		$query = $this->db->get('_pl');
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

	function getSJ($start_date, $end_date, $id_branch = NULL, $open = NULL)
	{
		$this->db->select('a.strnama_cabang as branch_name, b.strnama_cabang as destination_name, _sj.sj_number, SUM(qty) as qty, SUM(qty * price) as price, _sj.date, _sj.date_send, _sj.close as sj_close, _sttb.sttb_number, _sttb.close as sttb_close, _sttb.date as date_received');
		$this->db->join('cabang as a', '_sj.id_branch = a.intid_cabang');
		$this->db->join('cabang as b', '_sj.id_destination = b.intid_cabang');
		$this->db->join('_sj_details', '_sj.sj_number = _sj_details.sj_number');
		$this->db->join('_sttb', '_sj.sj_number = _sttb.receipt_number AND _sttb.active = 1', 'left');
		$this->db->where('DATE(_sj.date_send) >=', $start_date);
		$this->db->where('DATE(_sj.date_send) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('_sj.id_destination', $id_branch);
		}
		if($open != NULL && $open)
		{
			$this->db->where('_sj.close', 0);
		}
		else if($open != NULL && !$open)
		{
			$this->db->where('_sj.close', 1);
		}
		$this->db->where('_sj.active', 1);
		$this->db->group_by('_sj.sj_number');
		$this->db->order_by('_sj.date_send', 'DESC');
		$query = $this->db->get('_sj');
		if($query->num_rows >= 1)
		{
			foreach($query->list_fields() as $field)
			{
				foreach($query->result() as $row)
				{
					$data[$field][] = $row->$field;
				}
			}
			//Ambil daftar PL yang digabung
			$temp_list = $data['sj_number'];
			for($i=0; $i<count($temp_list); $i++)
			{
				$this->db->flush_cache();
				$this->db->select('_pl.pl_number');
				$this->db->join('_pl', '_sj_pl.pl_number = _pl.pl_number');
				$this->db->where('sj_number', $temp_list[$i]);
				$query = $this->db->get('_sj_pl');
				if($query->num_rows >= 1)
				{
					foreach($query->list_fields() as $field)
					{
						foreach($query->result() as $row)
						{
							$data[$temp_list[$i]]['pl_number'][] = $row->$field;
						}
					}
				}
			}
			return $data;
		}
	}
	
	function getAssemble($start_date, $end_date, $id_branch = NULL)
	{
		$this->db->select('strnama_cabang as branch_name, kanibal.assemble_number, SUM(qty) as qty, kanibal.date');
		$this->db->join('cabang', 'kanibal.id_branch = cabang.intid_cabang');
		$this->db->join('kanibal_detail', 'kanibal.assemble_number = kanibal_detail.assemble_number');
		$this->db->where('DATE(date) >=', $start_date);
		$this->db->where('DATE(date) <=', $end_date);
		if($id_branch != NULL)
		{
			$this->db->where('kanibal.id_branch', $id_branch);
		}
		$this->db->where('kanibal.active', 1);
		$this->db->group_by('kanibal.assemble_number');
		$this->db->order_by('kanibal.date', 'DESC');
		$query = $this->db->get('kanibal');
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
}