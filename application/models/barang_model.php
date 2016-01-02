<?php
class Barang_model extends CI_Model{

	function   __construct() 
	{
        parent::__construct();
		
		$this->table_barang= "barang";
		
	}

    //page
	private $tbl = 'barang';

	function insert($data){
	$data = array(
            'strnama' => $this->input->post('strnama'),
            'intid_jbarang' => $this->input->post('intid_jbarang'),
            'intid_jsatuan' => $this->input->post('intid_jsatuan'),
            'intqty' => $this->input->post('qty')
            );
        $this->db->insert('barang', $data);
		$intid_barang =$this->db->insert_id();
		$date_start = date('Y')."-01-01";
		$date_end = date('Y')."-12-31";
		
		$harga = array(
					   'intid_barang' => $intid_barang,
					   'date_start' => $date_start,
					   'date_end' => $date_end,
					   'intharga_jawa' =>$this->input->post('harga_jawa'),
					   'intharga_luarjawa' =>$this->input->post('harga_luar_jawa'),
					   'intpv_jawa' =>$this->input->post('pv_jawa'),
					   'intpv_luarjawa' =>$this->input->post('pv_luar_jawa'),
					   'intum_jawa' =>$this->input->post('um_jawa'),
					   'intum_luarjawa' =>$this->input->post('um_luar_jawa'),
					   'intcicilan_jawa' =>$this->input->post('cicilan_jawa'),
					   'intcicilan_luarjawa' =>$this->input->post('cicilan_luar_jawa'),
					   );
		 $this->db->insert('harga', $harga);
	}

    function selectDetail($id){
       $query = $this->db->query("SELECT a.*,d.*, b.strnama_jbarang, c.strnama_jsatuan
               FROM barang a, jenis_barang b, jenis_satuan c, harga d
               where a.intid_jbarang =b.intid_jbarang and a. intid_jsatuan = c.intid_jsatuan and
               a.intid_barang= '$id' and d.intid_barang = a.intid_barang");
	   return $query->result();
    }

    function selectJbarang(){

	   $query = $this->db->query("select * from jenis_barang order by intid_jbarang asc");
	   return $query->result();
    }

	function selectJsatuan(){

	   $query = $this->db->query("select * from jenis_satuan order by intid_jsatuan asc");
	   return $query->result();
    }

	function delete($intid_barang){
       $this->db->where('intid_barang', $intid_barang);
       $this->db->delete('barang');
    }

	function select($intid_barang){
       $query = $this->db->query("select barang.*, harga.* from barang, harga where harga.intid_barang = barang.intid_barang AND barang.intid_barang= $intid_barang");
	   return $query->result();
    }

	function update($intid_barang){
       $data = array(
            'intid_jbarang' => $this->input->post('intid_jbarang'),
           'strnama' => $this->input->post('strnama'),
            'intid_jsatuan' => $this->input->post('intid_jsatuan')

            );
        $this->db->where('intid_barang', $intid_barang);
		$this->db->update('barang', $data);   //tambahn , $data
		
				$harga = array(
					   'intid_barang' => $intid_barang,
					   'intharga_jawa' =>$this->input->post('harga_jawa'),
					   'intharga_luarjawa' =>$this->input->post('harga_luar_jawa'),
					   'intpv_jawa' =>$this->input->post('pv_jawa'),
					   'intpv_luarjawa' =>$this->input->post('pv_luar_jawa'),
					   'intum_jawa' =>$this->input->post('um_jawa'),
					   'intum_luarjawa' =>$this->input->post('um_luar_jawa'),
					   'intcicilan_jawa' =>$this->input->post('cicilan_jawa'),
					   'intcicilan_luarjawa' =>$this->input->post('cicilan_luar_jawa'),
					   );
		 $this->db->insert('harga', $harga);

	}
    
    function Cari_barang($limit,$offset,$barang)
	{
	    $q = $this->db->query("SELECT DISTINCT a.*,b.strnama_jsatuan, c.strnama_jbarang
FROM barang a
RIGHT JOIN jenis_satuan b ON a.intid_jsatuan = b.intid_jsatuan
JOIN jenis_barang c ON a.intid_jbarang = c.intid_jbarang WHERE a.strnama LIKE '%$barang%' LIMIT $offset,$limit");
	    return $q;
    }
	function Cari_baranghadiah($limit,$offset,$barang)
	{
	    $q = $this->db->query("SELECT DISTINCT a.*,b.strnama_jsatuan, c.strnama_jbarang
FROM barang_hadiah a
RIGHT JOIN jenis_satuan b ON a.intid_jsatuan = b.intid_jsatuan
JOIN jenis_barang c ON a.intid_jbarang = c.intid_jbarang WHERE a.strnama LIKE '%$barang%' LIMIT $offset,$limit");
	    return $q;
    }

	function tot_hal($tabel,$field,$kata)
	{
	    $q = $this->db->query("select * from $tabel where $field like '%$kata%'");
	    return $q;
	}
	
	function deletehadiah($intid_barang_hadiah){
       $this->db->where('intid_barang_hadiah', $intid_barang_hadiah);
       $this->db->delete('barang_hadiah');
    }
	
	function selecthadiah($intid_barang){
       $query = $this->db->query("select barang_hadiah.* from barang_hadiah where barang_hadiah.intid_barang_hadiah= $intid_barang");
	   return $query->result();
    }
	
	function updatehadiah($intid_barang){
       $data = array(
            'intid_jbarang' => $this->input->post('intid_jbarang'),
           'strnama' => $this->input->post('strnama'),
            'intid_jsatuan' => $this->input->post('intid_jsatuan')

            );
        $this->db->where('intid_barang_hadiah', $intid_barang);
		$this->db->update('barang_hadiah', $data);  
	}
	
	function inserthadiah($data){
	$data = array(
            'strnama' => $this->input->post('strnama'),
            'intid_jbarang' => $this->input->post('intid_jbarang'),
            'intid_jsatuan' => $this->input->post('intid_jsatuan')
            );
     $this->db->insert('barang_hadiah', $data);
	}
	
	function getAll(){
       $query = $this->db->query("select * from barang where status_barang = 1");
	   return $query;
    }

	//tambahan untuk tambah barang
	function getJenisBarang(){
		$query = $this->db->query("select intid_jbarang, upper(strnama_jbarang) strnama_jbarang from Jenis_barang");
		return $query;
	}
	
	function getJenisSatuan(){
		$query = $this->db->query("select intid_jsatuan, upper(strnama_jsatuan) strnama_jsatuan from jenis_satuan");
		return $query;
	}
	function getDataBarang($data = array(), $escape = false)
	{
		$select	=	"select ";
		$from	=	"from barang ";
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
			$select .= "barang.*, ";					
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
	function getTableBarang()
	{
		return $this->table_barang;
	}
}
?>
