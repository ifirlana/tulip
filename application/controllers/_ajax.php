<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _Ajax extends MY_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('_user_model', 'user_model');
    $this->load->model('_stock_model', 'stock_model');
    $this->load->model('_report_model', 'report_model');
    $this->load->model('_logistic_model', 'logistic_model');
    $this->load->model('_product_model', 'product_model');
    $this->load->model('_branch_model', 'branch_model');
    $this->load->model('_receipt_model', 'receipt_model');
  }

  function index()
  {
    $query1 = $this->logistic_model->getSJ('2015-07-01', '2015-08-01', 1);
    $query2 = $this->receipt_model->getSPKBDetail('1/SPB/30/1/20150731152354');
    echo '<pre>';
    print_r($query1);
    print_r($query2);
  }
  
  function checkSession()
  {
    $session_data = $this->session->all_userdata();

    echo '<pre>';
    print_r($session_data);
  }

  function checkBrowser()
  {
    $ua = $this->getBrowser();
    $yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
    print_r($yourbrowser);
  }

  function checkIP()
  {
    $env_ip = "Your IP: ".$this->get_client_ip_env();
    print_r($env_ip);
  }

  function getUser()
  {
    $id_user = $this->input->post('id_user');
    $id_unit = $this->input->post('id_unit');
    $query = $this->user_model->getUser($id_user, $id_unit);
    echo json_encode($query);
  }

  function getSavedStock()
  {
    $id_branch = $this->input->post('id_branch');

    $this->db->select('save_number');
    $this->db->where('id_branch', $id_branch);
    $this->db->group_by('date, date_saved');
    $this->db->order_by('date, date_saved');
    $query = $this->db->get('_stock_saved');
    if($query->num_rows >= 1)
    {
      foreach($query->result() as $row)
      {
        $data['save_number'][] = $row->save_number;
      }
      echo json_encode($data);
    }
  }

  function getSavedStockProduct()
  {
    $save_number = $this->input->post('save_number');

    $this->db->select('id_product, strnama as product_name, qty');
    $this->db->join('barang', '_stock_saved.id_product = barang.intid_barang');
    $this->db->where('save_number', $save_number);
    $query = $this->db->get('_stock_saved');
    if($query->num_rows >= 1)
    {
      foreach($query->result() as $row)
      {
        $data['id_product'][] = $row->id_product;
        $data['product_name'][] = $row->product_name;
        $data['qty'][] = $row->qty;
      }
      echo json_encode($data);
    }
  }

  function getComponent()
  {
    $id_product = $this->input->post('id_product');

    $query = $this->logistic_model->getComponent($id_product);
    
    echo json_encode($query);
  }

  function getCurrentStock()
  {
    $id_branch = $this->input->post('id_branch');
    $id_product = NULL;
    if($this->input->post('id_product'))
    {
      $id_product = $this->input->post('id_product');
    }
    $current_date = date('Y-m-d');
    $query = $this->stock_model->getStock($current_date, $current_date, $id_branch, $id_product);

    echo json_encode($query);
  }

  function updateStockGM5()
  {
    $stock_gm5 = $this->input->post('stock');
    if(!empty($stock_gm5['qty']))
    {
      for($i=0; $i<count($stock_gm5['id_product']); $i++)
      {
        $this->db->flush_cache();
        $this->db->where('intid_cabang', $stock_gm5['id_branch'][$i]);
        $this->db->where('intid_barang', $stock_gm5['id_product'][$i]);
        $this->db->delete('stock_gm5');
        $this->db->flush_cache();
        $ins = array(
          'intid_cabang' => $stock_gm5['id_branch'][$i],
          'intid_barang' => $stock_gm5['id_product'][$i],
          'qty' => $stock_gm5['qty'][$i]
          );
        $this->db->insert('stock_gm5', $ins);
      }
    }
  }

  function getPOBranch()
  {
    $id_branch = $this->input->post('id_branch');
    $current_date = date('Y-m-d');

    $query = $this->logistic_model->getPO('0000-00-00', $current_date, $id_branch, true);
    
    echo json_encode($query);
  }

  function getPOProduct()
  {
    $po_number = $this->input->post('po_number');

    $query = $this->receipt_model->getPODetail($po_number);

    echo json_encode($query);
  }

  function getLimitPO()
  {
    $id_branch = $this->input->post('id_branch');

    $query = $this->logistic_model->getLimitPO($id_branch);
    
    echo json_encode($query);
  }

  function getPOBSBranch()
  {
    $id_branch = $this->input->post('id_branch');
    $current_date = date('Y-m-d');

    $query = $this->logistic_model->getPOBS('0000-00-00', $current_date, $id_branch, true);
    
    echo json_encode($query);
  }

  function getPOBSProduct()
  {
    $pobs_number = $this->input->post('pobs_number');

    $query = $this->receipt_model->getPOBSDetail($pobs_number);

    echo json_encode($query);
  }

  function getSPKBBranch()
  {
    $id_branch = $this->input->post('id_branch');
    $current_date = date('Y-m-d');

    $query = $this->logistic_model->getSPKB('0000-00-00', $current_date, $id_branch);
    
    echo json_encode($query);
  }

  function getSPBBranch()
  {
    $id_branch = $this->input->post('id_branch');
    $current_date = date('Y-m-d');

    $query = $this->logistic_model->getSPB('0000-00-00', $current_date, $id_branch, true);
    
    echo json_encode($query);
  }

  function getSPBProduct()
  {
    $spb_number = $this->input->post('spb_number');

    $query = $this->receipt_model->getSPBDetail($spb_number);

    echo json_encode($query);
  }

  function deletePL()
  {
    $pl_number = $this->input->post('pl_number');

    $this->db->where('pl_number', $pl_number);
    $this->db->delete('_pl');
    $this->db->where('pl_number', $pl_number);
    $this->db->delete('_pl_details');
    $this->db->where('pl_number', $pl_number);
    $this->db->delete('_spb_pl');

    echo true;
  }

  function getPLBranch()
  {
    $id_branch = $this->input->post('id_branch');
    $current_date = date('Y-m-d');

    $query = $this->logistic_model->getPL('0000-00-00', $current_date, $id_branch, true);
    
    echo json_encode($query);
  }

  function getPromotionList()
  {
    $id_branch = $this->input->post('id_branch');
    $id_user = $this->input->post('id_user');
    $query = $this->purchase_model->getPromotionList($id_branch, $id_user);
    $result['promotion'] = $this->purchase_model->getPromotion($query['id_promo']);
    
    echo json_encode($result);
  }

  function getPurchaseTypeList()
  {
    $id_branch = $this->input->post('id_branch');
    $id_user = $this->input->post('id_user');
    $id_promo = $this->input->post('id_promo');
    $query = $this->purchase_model->getPromotionList($id_branch, $id_user, $id_promo);
    $result['purchase_type'] = $this->purchase_model->getPurchaseType($query['type_purchase']);

    echo json_encode($result);
  }

  function getProductPromo()
  {
    $id_promo = $this->input->post('id_promo');
    $type_purchase = $this->input->post('type_purchase');
    $id_branch = $this->input->post('id_branch');
    $id_user = $this->input->post('id_user');
    $id_product = $this->input->post('id_product'); //Array
    foreach($id_product as $id)
    {
      $temp_code = $this->product_model->getProductDetail($id);
      $code_product[] = $temp_code['code_product'][0];
    }
    $branch = $this->branch_model->getBranch(NULL, $id_branch);
    $type_price = $branch['type_price'][0];
    $temp_query = $this->product_model->getProductPromo($id_promo, $type_purchase, $id_branch, $type_price, $id_user, $code_product);
    $product = $this->product_model->getProductDetail($id_product);

    $var = array(
      
      );

    echo json_encode($query);
  }

  function getProductStarterkit()
  {
    $id_product = $this->input->post('id_product');
    $query = $this->product_model->getProductStarterkit($id_product);
    
    echo json_encode($query);
  }

  function getRedeemCriteria()
  {
    $id_redeem = $this->input->post('id_redeem');
    $id_user = $this->input->post('id_user');
    $query = $this->purchase_model->getNota('2015-06-09', '2015-06-30', NULL, $id_user);
    
    $article_table['id'] = 'product_content';
    $article_table['label'] = array(
      '',
      'Nomor Nota',
      'Total Omset');
    $article_table['style'] = array(
      '',
      '',
      '');
    $article_table['class'] = array(
      '',
      '',
      'right');


    echo json_encode($query);
  }
}