<?php
class MY_Controller extends CI_Controller {

    public $webpage_access = array();
    public $webpage_name = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model('_login_model', 'login_model');
        $this->load->model('_general_model', 'general_model');
        $this->load->model('_purchase_model', 'purchase_model');
        date_default_timezone_set("Asia/Jakarta");
        $this->authentication();
        $this->activity_log('browse');
        $this->alertBrowser();
    }

    function authentication()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');

        if(!isset($is_logged_in) || $is_logged_in != true)
        {
          redirect('login');
          die();
        }
        
        $webpage_access['id_webpage'] = $this->session->userdata('id_webpage');
        $webpage_access['webpage_name'] = $this->session->userdata('webpage_name');
        $webpage_access['controller'] = $this->session->userdata('controller');
        $this->webpage_access = $webpage_access;
    }

    function activity_log($activity = '')
    {
        $session_data = $this->session->all_userdata();
        if(isset($session_data['id_authorise']) && $session_data['id_user'] != 1)
        {
            $uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $env_ip = $this->get_client_ip_env();
            $browser = $this->getBrowser();

            $ins = array(
                'id_user' => $session_data['id_user'],
                'name' => $session_data['name'],
                'activity' => $activity,
                'uri' => $uri,
                'env_ip' => $env_ip,
                'browser' => $browser['name'],
                'version' => $browser['version'],
                'platform' => $browser['platform'],
                'user_agent' => $browser['userAgent'],
                'date' => date('Y-m-d H:i:s')
                );
            $this->db->insert('_activity_log', $ins);
        }
    }

    // Function to get the client ip address
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

    function getBrowser() 
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
        
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
        
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        
        return array(
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'userAgent' => $u_agent,
            'pattern'    => $pattern
        );
    }

    function alertBrowser()
    {
        $browser = $this->getBrowser();
        if($browser['name'] == 'Internet Explorer')
        {
          echo '<script>alert("Sebisa mungkin hindarilah penggunaan browser Internet Explorer karena akan mengganggu tampilan sistem Twin Tulipware sementara ini");</script>';
        }
        if($browser['name'] == 'Google Chrome')
        {
          if($browser['version'] + 0 < 43)
          {
            echo '<script>alert("Versi browser anda perlu di update untuk menghindari error dalam menggunakan program Twin Tulipware");</script>';
          }
        }
        if($browser['name'] == 'Mozilla Firefox')
        {
          if($browser['version'] + 0 < 37)
          {
            echo '<script>alert("Versi browser anda perlu di update untuk menghindari error dalam menggunakan program Twin Tulipware");</script>';
          }
        }
        if($browser['name'] == 'Opera')
        {
          if($browser['version'] + 0 < 12)
          {
            echo '<script>alert("Versi browser anda perlu di update untuk menghindari error dalam menggunakan program Twin Tulipware");</script>';
          }
        }
    }

    function toCurrency($number)
    {
        $number = strval(floatval($number));
        $arr = array();
        $j = 0;
        $start = count(str_split($number))-1;
        if(strpos($number, '.'))
        {
            $end = strpos($number, '.');
            for($i=$start; $i>$end; $i--)
            {
                array_unshift($arr, $number[$i]);
            }
            //Tanda untuk angka desimal
            array_unshift($arr, '.');
            $start = $end-1;
        }
        for($i=$start; $i>=0; $i--)
        {
            if($j%3 == 0 && $j != 0)
            {
                //Tanda untuk angka ribuan
                array_unshift($arr, ',');
            }
            array_unshift($arr, $number[$i]);
            $j++;
        }
        $currency = '';
        foreach ($arr as $z)
        {
            $currency .= $z;
        }

        return $currency;
    }

    function delivery_status($arr)
    {
        $status = '';
        if(isset($arr['po_close']) && $arr['po_close'] != 1)
        {
            $status = 'Menunggu acc BS';
        }
        else if(isset($arr['pobs_close']) && $arr['pobs_close'] != 1)
        {
            $status = 'Menunggu acc SPV';
        }
        else if(isset($arr['spkb_close']) && $arr['spkb_close'] != 1)
        {
            $status = 'Menunggu konfirmasi Bizpark';
        }
        else if(isset($arr['spb_close']) && $arr['spb_close'] != 1)
        {
            $status = 'Barang sedang diambil';
        }
        else if(isset($arr['pl_close']) && $arr['pl_close'] != 1)
        {
            $status = 'Menunggu pengiriman selanjutnya';
        }
        else if(isset($arr['sj_close']) && $arr['sj_close'] != 1)
        {
            $status = 'Sedang dalam perjalanan';
        }
        else if(isset($arr['sttb_close']) && $arr['sttb_close'] != 1)
        {
            $status = 'Sudah diterima';
        }
        return $status;
    }

    function insert_nota($submit)
    {
        $type_nota = $submit['type_nota'];
        $id_branch = $submit['id_branch'];
        $id_user = $submit['id_user'];
        $type_purchase = $submit['type_purchase'];
        $id_promo = $submit['id_promo'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];
        $qty_given = $submit['qty'];
        $total_cost = $submit['total_cost'];
        $cash = $submit['cash'];
        $debit = $submit['debit'];
        $credit = $submit['credit'];
        $dp = 0;
        $close = 1;
        /*if($total_cost > $cash + $debit + $credit)
        {
            $dp = 1;
            $close = 0;
        }*/
        for($i=0; $i<count($id_product); $i++)
        {
            $price[$i] = 0;
            $pv[$i] = 0;
            $omset[$i] = 0;
            $komisi[$i] = 0;
            $omset_10[$i] = 0;
            $komisi_10[$i] = 0;
            $omset_15[$i] = 0;
            $komisi_15[$i] = 0;
            $omset_20[$i] = 0;
            $komisi_20[$i] = 0;
            $omset_extra[$i] = 0;
            $komisi_extra[$i] = 0;
            $voucher[$i] = 0;
        }
        if(!empty($submit['price']) && count($submit['price']) > 0)
        {
            $price = $submit['price'];
        }
        if(!empty($submit['pv']) && count($submit['pv']) > 0)
        {
            $pv = $submit['pv'];
        }
        if(!empty($submit['omset']) && count($submit['omset']) > 0)
        {
            $omset = $submit['omset'];
        }
        if(!empty($submit['komisi']) && count($submit['komisi']) > 0)
        {
            $komisi = $submit['komisi'];
        }
        if(!empty($submit['omset_10']) && count($submit['omset_10']) > 0)
        {
            $omset_10 = $submit['omset_10'];
        }
        if(!empty($submit['komisi_10']) && count($submit['komisi_10']) > 0)
        {
            $komisi_10 = $submit['komisi_10'];
        }
        if(!empty($submit['omset_15']) && count($submit['omset_15']) > 0)
        {
            $omset_15 = $submit['omset_15'];
        }
        if(!empty($submit['komisi_15']) && count($submit['komisi_15']) > 0)
        {
            $komisi_15 = $submit['komisi_15'];
        }
        if(!empty($submit['omset_20']) && count($submit['omset_20']) > 0)
        {
            $omset_20 = $submit['omset_20'];
        }
        if(!empty($submit['komisi_20']) && count($submit['komisi_20']) > 0)
        {
            $komisi_20 = $submit['komisi_20'];
        }
        if(!empty($submit['omset_extra']) && count($submit['omset_extra']) > 0)
        {
            $omset_extra = $submit['omset_extra'];
        }
        if(!empty($submit['komisi_extra']) && count($submit['komisi_extra']) > 0)
        {
            $komisi_extra = $submit['komisi_extra'];
        }
        if(!empty($submit['voucher']) && count($submit['voucher']) > 0)
        {
            $voucher = $submit['voucher'];
        }

        date_default_timezone_set("Asia/Jakarta");

        $week = $this->general_model->getWeek(date('Y-m-d'));
        if(empty($week))
        {
            echo 'Tidak dapat membuat nota di hari libur';
            return;
        }

        $date_saved = date('Y-m-d H:i:s');
        $nota_number = $id_branch.'/Nota/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $user = $this->user_model->getUser($id_user);
        
        /*vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv*/
        $intomset10 = array_sum($omset_10);
        $intomset15 = array_sum($omset_15);
        $intomset20 = array_sum($omset_20);
        $intkomisi10 = array_sum($komisi_10);
        $intkomisi15 = array_sum($komisi_15);
        $intkomisi20 = array_sum($komisi_20);
        $intpv = array_sum($pv);
        $inttotal_omset = $intomset10 + $intomset15 + $intomset20;
        $inttotal_bayar = $total_cost;
        $intcash = $cash;
        $intdebit = $debit;
        $intkkredit = $credit;
        $intsisa = $total_cost - $cash - $debit - $credit;
        /*if($intsisa > 0)
        {
            $is_dp = 1;
            $intdp = $intcash + $intdebit + $intkkredit;
            $intcash = 0;
            $intdebit = 0;
            $intkkredit = 0;
        }
        else
        {*/
            $is_dp = 0;
            $intdp = 0;
        //}
        $intvoucher = 0;
        $inttrade_in = 0;
        $persen = 0;
        $otherKom = $inttotal_bayar * $persen;

        $ins = array(
            'intno_nota' => $nota_number,
            'intid_jpenjualan' => $type_purchase[0],
            'intid_cabang' => $id_branch,
            'intid_dealer' => $id_user,
            'intid_unit' => $user['id_unit'][0],
            'datetgl' => $date_saved,
            'intid_week' => $week['week'],
            'intomset10' => $intomset10,
            'intomset15' => $intomset15,
            'intomset20' => $intomset20,
            'inttotal_omset' => $inttotal_omset,
            'inttotal_bayar' => $inttotal_bayar,
            'intdp' => $intdp,
            'intcash' => $intcash,
            'intdebit' => $intdebit,
            'intkkredit' => $intkkredit,
            'intsisa' => $intsisa,
            'intkomisi10' => $intkomisi10,
            'intkomisi15' => $intkomisi15,
            'intkomisi20' => $intkomisi20,
            'intpv' => $intpv,
            'intvoucher' => $intvoucher,
            'is_dp' => $is_dp,
            'inttrade_in' => $inttrade_in,
            'otherKom' => $otherKom,
            'persen' => $persen
            );
        $this->db->insert('nota', $ins);

        $intid_nota = $this->db->insert_id();

        for($i=0; $i<count($id_product); $i++)
        {
            $product = $this->product_model->getProductDetail($id_product[$i]);
            $intid_barang = $id_product[$i];
            $intquantity = $qty[$i];
            $intid_harga = $product['id_price'][0];
            if($price[$i] == 0)
            {
                $is_free = 1;
            }
            else
            {
                $is_free = 0;
            }
            $intharga = $price[$i] - $voucher[$i];
            $intnormal = $price[$i];
            $intvoucher = $voucher[$i];
            $id_jpenjualan = $type_purchase[$i];
            $intomset = $omset[$i] * $qty[$i];
            $intomset10 = $omset_10[$i] * $qty[$i];
            $intomset15 = $omset_15[$i] * $qty[$i];
            $intomset20 = $omset_20[$i] * $qty[$i];
            $intpv = $pv[$i] * $qty[$i];
            $intkomisi = ($komisi_10[$i] * $qty[$i]) + ($komisi_15[$i] * $qty[$i]) + ($komisi_20[$i] * $qty[$i]);
            $inttotal_bayar = ($intharga * $intquantity) - $intkomisi;
            $intid_control_promo = $id_promo[$i];

            $det = array(
                'intid_nota' => $intid_nota,
                'intid_barang' => $intid_barang,
                'intquantity' => $qty[$i],
                'intid_harga' => $product['id_price'][0],
                'is_free' => $is_free,
                'intharga' => $intharga,
                'nomor_nota' => $nota_number,
                'is_diskon' => 1,
                'intnormal' => $intnormal,
                'intvoucher' => $intvoucher,
                'id_jpenjualan' => $type_purchase[$i],
                'intomset' => $intomset,
                'intomset10' => $intomset10,
                'intomset15' => $intomset15,
                'intomset20' => $intomset20,
                'intpv' => $intpv,
                'intkomisi' => $intkomisi,
                'inttotal_bayar' => $inttotal_bayar,
                'intid_control_promo' => $intid_control_promo,
                'reduced' => 0
                );

            $this->db->insert('nota_detail', $det);
        }
        /*^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/

        return $nota_number;
    }

    function insert_po($submit)
    {
        $id_branch = $submit['id_branch'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];
        $price = $submit['price'];
        if(!empty($submit['info']) && count($submit['info']) > 0)
        {
            $info = $submit['info'];
        }
        else
        {
            for($i=0; $i<count($submit['id_product']); $i++)
            {
                $info[$i] = '-';
            }
        }

        $week = $this->general_model->getWeek(date('Y-m-d'));
        if(empty($week))
        {
            echo 'Tidak dapat membuat nota di hari libur, jika ini bukan hari libur mohon hubungi BS';
            return;
        }

        $date_saved = date('Y-m-d H:i:s');
        $po_number = $id_branch.'/PO/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'po_number' => $po_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_po', $ins);

        for($i=0; $i<count($id_product); $i++)
        {
            if($qty[$i] != 0)
            {
                $product = $this->product_model->getProductDetail($id_product[$i]);
                $det = array(
                    'po_number' => $po_number,
                    'id_price' => $product['id_price'][0],
                    'type_product' => $product['type_product'][0],
                    'product_type' => $product['product_type'][0],
                    'id_product' => $id_product[$i],
                    'code_product' => $product['code_product'][0],
                    'product_name' => $product['product_name'][0],
                    'qty' => $qty[$i],
                    'price' => $price[$i],
                    'info' => $info[$i]
                    );
                $this->db->insert('_po_details', $det);
            }
        }

        return $po_number;
    }

    function insert_pobs($submit)
    {
        $id_branch = $submit['id_branch'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];
        $price = $submit['price'];
        if(!empty($submit['info']) && count($submit['info']) > 0)
        {
            $info = $submit['info'];
        }
        else
        {
            for($i=0; $i<count($submit['id_product']); $i++)
            {
                $info[$i] = '-';
            }
        }
        $limit_price = $submit['limit_price'];
        $po_list = $submit['po_list'];

        $week = $this->general_model->getWeek(date('Y-m-d'));
        if(empty($week))
        {
            echo 'Tidak dapat membuat nota di hari libur';
            return;
        }

        $date_saved = date('Y-m-d H:i:s');
        $pobs_number = $id_branch.'/POBS/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'pobs_number' => $pobs_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'limit_price' => $limit_price,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_pobs', $ins);

        for($i=0; $i<count($id_product); $i++)
        {
            if($qty[$i] != 0)
            {
                $product = $this->product_model->getProductDetail($id_product[$i]);
                $det = array(
                    'pobs_number' => $pobs_number,
                    'id_price' => $product['id_price'][0],
                    'type_product' => $product['type_product'][0],
                    'product_type' => $product['product_type'][0],
                    'id_product' => $id_product[$i],
                    'code_product' => $product['code_product'][0],
                    'product_name' => $product['product_name'][0],
                    'qty' => $qty[$i],
                    'price' => $price[$i],
                    'info' => $info[$i]
                    );
                $this->db->insert('_pobs_details', $det);
            }
        }

        $this->db->flush_cache();
        for($i=0; $i<count($po_list); $i++)
        {
            $data = array('close' => 1);
            $this->db->where('po_number', $po_list[$i]);
            $this->db->update('_po', $data);
        }

        $this->db->flush_cache();
        for($i=0; $i<count($po_list); $i++)
        {
            $data = array(
                'pobs_number' => $pobs_number,
                'po_number' => $po_list[$i]
                );
            $this->db->insert('_pobs_po', $data);
        }

        return $pobs_number;
    }

    function insert_spkb($submit)
    {
        $id_branch = $submit['id_branch'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];
        $price = $submit['price'];
        if(!empty($submit['info']) && count($submit['info']) > 0)
        {
            $info = $submit['info'];
        }
        else
        {
            for($i=0; $i<count($submit['id_product']); $i++)
            {
                $info[$i] = '-';
            }
        }
        $limit_price = $submit['limit_price'];
        $pobs_list = $submit['pobs_list'];

        $week = $this->general_model->getWeek(date('Y-m-d'));
        if(empty($week))
        {
            echo 'Tidak dapat membuat nota di hari libur';
            return;
        }

        $date_saved = date('Y-m-d H:i:s');
        $spkb_number = $id_branch.'/SPKB/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'spkb_number' => $spkb_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'limit_price' => $limit_price,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_spkb', $ins);

        for($i=0; $i<count($id_product); $i++)
        {
            if($qty[$i] != 0)
            {
                $product = $this->product_model->getProductDetail($id_product[$i]);
                $det = array(
                    'spkb_number' => $spkb_number,
                    'id_price' => $product['id_price'][0],
                    'type_product' => $product['type_product'][0],
                    'product_type' => $product['product_type'][0],
                    'id_product' => $id_product[$i],
                    'code_product' => $product['code_product'][0],
                    'product_name' => $product['product_name'][0],
                    'qty' => $qty[$i],
                    'price' => $price[$i],
                    'info' => $info[$i]
                    );
                $this->db->insert('_spkb_details', $det);
            }
        }

        $this->db->flush_cache();
        for($i=0; $i<count($pobs_list); $i++)
        {
            $data = array('close' => 1);
            $this->db->where('pobs_number', $pobs_list[$i]);
            $this->db->update('_pobs', $data);
        }

        $this->db->flush_cache();
        for($i=0; $i<count($pobs_list); $i++)
        {
            $data = array(
                'spkb_number' => $spkb_number,
                'pobs_number' => $pobs_list[$i]
                );
            $this->db->insert('_spkb_pobs', $data);
        }

        return $spkb_number;
    }

    function insert_spb($submit)
    {
        $id_branch = $submit['id_branch'];
        $spkb_list = $submit['spkb_list'];

        $date_saved = date('Y-m-d H:i:s');
        $week = $this->general_model->getWeek(date('Y-m-d'));
        while(empty($week))
        {
            $y = date('Y');
            $m = date('m');
            $d = date('d') + 1;
            $week = $this->general_model->getWeek($y.'-'.$m.'-'.$d);
        }
        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $spb_number = $id_branch.'/SPB/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        //Kalau ada SPB yg masih active, pake nomornya
        $this->db->select('spb_number');
        $this->db->where('id_branch', $id_branch);
        $this->db->where('active', 1);
        $this->db->where('close', 0);
        $query = $this->db->get('_spb');
        if($query->num_rows >= 1)
        {
            foreach($query->list_fields() as $field)
            {
                foreach($query->result() as $row)
                {
                    $spb_number = $row->$field;
                }
            }
            $this->db->flush_cache();
            $this->db->where('spb_number', $spb_number);
            $this->db->delete('_spb');
            $this->db->where('spb_number', $spb_number);
            $this->db->delete('_spb_details');
            $this->db->where('spb_number', $spb_number);
            $this->db->delete('_spb_spkb');
        }

        //Insert SPB
        $this->db->flush_cache();
        $ins = array(
            'spb_number' => $spb_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_spb', $ins);

        $this->db->select('id_price,
            type_product,
            product_type,
            id_product,
            code_product,
            product_name,
            SUM(qty) as qty,
            price,
            GROUP_CONCAT(info SEPARATOR ";") as info');
        $this->db->where_in('spkb_number', $spkb_list);
        $this->db->group_by('id_product');
        $query = $this->db->get('_spkb_details');
        if($query->num_rows >= 1)
        {
            foreach($query->list_fields() as $field)
            {
                foreach($query->result() as $row)
                {
                    $temp[$field][] = $row->$field;
                }
            }

            for($j=0; $j<count($temp['id_product']); $j++)
            {
                $this->db->flush_cache();
                $this->db->set('spb_number', $spb_number);
                $this->db->set('id_price', $temp['id_price'][$j]);
                $this->db->set('type_product', $temp['type_product'][$j]);
                $this->db->set('product_type', $temp['product_type'][$j]);
                $this->db->set('id_product', $temp['id_product'][$j]);
                $this->db->set('code_product', $temp['code_product'][$j]);
                $this->db->set('product_name', $temp['product_name'][$j]);
                $this->db->set('qty', $temp['qty'][$j]);
                $this->db->set('price', $temp['price'][$j]);
                $this->db->set('info', $temp['info'][$j]);
                $this->db->insert('_spb_details');
            }
        }

        for($i=0; $i<count($spkb_list); $i++)
        {
            $this->db->flush_cache();
            $ins = array(
                'spb_number' => $spb_number,
                'spkb_number' => $spkb_list[$i]
                );
            $this->db->insert('_spb_spkb', $ins);
            $update = array(
                'close' => 1
                );
            $this->db->where('spkb_number', $spkb_list[$i]);
            $this->db->update('_spkb', $update);
        }

        return $spb_number;
    }

    function insert_pl($submit)
    {
        $id_branch = $submit['id_branch'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];
        $price = $submit['price'];
        if(!empty($submit['info']) && count($submit['info']) > 0)
        {
            $info = $submit['info'];
        }
        else
        {
            for($i=0; $i<count($submit['id_product']); $i++)
            {
                $info[$i] = '-';
            }
        }
        $spb_list = $submit['spb_list'];

        $week = $this->general_model->getWeek(date('Y-m-d'));
        while(empty($week))
        {
            $y = date('Y');
            $m = date('m');
            $d = date('d') + 1;
            $week = $this->general_model->getWeek($y.'-'.$m.'-'.$d);
        }

        $date_saved = date('Y-m-d H:i:s');
        $pl_number = $id_branch.'/PL/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'pl_number' => $pl_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_pl', $ins);

        for($i=0; $i<count($id_product); $i++)
        {
            if($qty[$i] != 0)
            {
                $product = $this->product_model->getProductDetail($id_product[$i]);
                $det = array(
                    'pl_number' => $pl_number,
                    'id_price' => $product['id_price'][0],
                    'type_product' => $product['type_product'][0],
                    'product_type' => $product['product_type'][0],
                    'id_product' => $id_product[$i],
                    'code_product' => $product['code_product'][0],
                    'product_name' => $product['product_name'][0],
                    'qty' => $qty[$i],
                    'price' => $price[$i],
                    'info' => $info[$i]
                    );
                $this->db->insert('_pl_details', $det);
            }
        }

        $this->db->flush_cache();
        for($i=0; $i<count($spb_list); $i++)
        {
            $data = array(
                'spb_number' => $spb_list[$i],
                'pl_number' => $pl_number
                );
            $this->db->insert('_spb_pl', $data);
        }

        return $pl_number;
    }

    function insert_sj($submit)
    {
        $id_branch = $submit['id_branch'];
        $pl_list = $submit['pl_list'];

        $week = $this->general_model->getWeek(date('Y-m-d'));
        while(empty($week))
        {
            $y = date('Y');
            $m = date('m');
            $d = date('d') + 1;
            $week = $this->general_model->getWeek($y.'-'.$m.'-'.$d);
        }

        $date_saved = date('Y-m-d H:i:s');
        $sj_number = $id_branch.'/SJ/'.$week['week'].'/'.$this->session->userdata('id_user').'/'.date('YmdHis');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'sj_number' => $sj_number,
            'id_branch' => 145,
            'branch_name' => 'Bizpark',
            'id_destination' => $id_branch,
            'destination_name' => $branch['branch_name'][0],
            'type_price' => $branch['type_price'][0],
            'price_type' => $branch['price_type'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'date_send' => $date_saved,
            'close' => 0,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('_sj', $ins);

        $this->db->select('id_price,
            type_product,
            product_type,
            id_product,
            code_product,
            product_name,
            SUM(qty) as qty,
            price,
            GROUP_CONCAT(info SEPARATOR ";") as info');
        $this->db->where_in('pl_number', $pl_list);
        $this->db->group_by('id_product');
        $query = $this->db->get('_pl_details');
        if($query->num_rows >= 1)
        {
            foreach($query->list_fields() as $field)
            {
                foreach($query->result() as $row)
                {
                    $temp[$field][] = $row->$field;
                }
            }

            for($j=0; $j<count($temp['id_product']); $j++)
            {
                $this->db->flush_cache();
                $this->db->set('sj_number', $sj_number);
                $this->db->set('id_price', $temp['id_price'][$j]);
                $this->db->set('type_product', $temp['type_product'][$j]);
                $this->db->set('product_type', $temp['product_type'][$j]);
                $this->db->set('id_product', $temp['id_product'][$j]);
                $this->db->set('code_product', $temp['code_product'][$j]);
                $this->db->set('product_name', $temp['product_name'][$j]);
                $this->db->set('qty', $temp['qty'][$j]);
                $this->db->set('price', $temp['price'][$j]);
                $this->db->set('info', $temp['info'][$j]);
                $this->db->insert('_sj_details');
            }
        }

        for($i=0; $i<count($pl_list); $i++)
        {
            $this->db->flush_cache();
            $ins = array(
                'sj_number' => $sj_number,
                'pl_number' => $pl_list[$i]
                );
            $this->db->insert('_sj_pl', $ins);
            $this->db->flush_cache();
            $update = array(
                'close' => 1
                );
            $this->db->where('pl_number', $pl_list[$i]);
            $this->db->update('_pl', $update);
        }
        $this->db->select('spb_number');
        $this->db->where_in('pl_number', $pl_list);
        $this->db->group_by('spb_number');
        $query = $this->db->get('_spb_pl');
        if($query->num_rows >= 1)
        {
            foreach($query->list_fields() as $field)
            {
                foreach($query->result() as $row)
                {
                    $spb_list[] = $row->$field;
                }
            }
            for($i=0; $i<count($spb_list); $i++)
            {
                $this->db->flush_cache();
                $update = array(
                    'close' => 1
                    );
                $this->db->where('spb_number', $spb_list[$i]);
                $this->db->update('_spb', $update);
            }
        }

        return $sj_number;
    }

    function getReceiptCounter($type)
    {
        $this->db->select('id');
        $this->db->where('keterangan', $type);
        $this->db->limit(1);
        $query = $this->db->get('counter_');
        if($query->num_rows == 1)
        {
            foreach($query->list_fields() as $field)
            {
                foreach($query->result() as $row)
                {
                    $counter = $row->$field;
                }
            }
            $this->db->flush_cache();
            $update = array(
                'id' => $counter+1
                );
            $this->db->where('keterangan', $type);
            $this->db->update('counter_', $update);
            return $counter+1;
        }
    }

    function insert_assemble($submit)
    {
        $id_branch = $submit['id_branch'];
        $id_product = $submit['id_product'];
        $qty = $submit['qty'];

        $week = $this->general_model->getWeek(date('Y-m-d'));
        if(empty($week))
        {
            echo 'Tidak dapat membuat nota di hari libur, jika ini bukan hari libur mohon hubungi BS';
            return;
        }

        $date_saved = date('Y-m-d H:i:s');
        $counter = $this->getReceiptCounter('kanibal');
        $assemble_number = $counter.'/CA/'.$id_branch.'/'.$week['week'].'/'.$this->session->userdata('id_user');

        $branch = $this->branch_model->getBranch(NULL, $id_branch);
        $ins = array(
            'assemble_number' => $assemble_number,
            'id_branch' => $id_branch,
            'branch_name' => $branch['branch_name'][0],
            'active' => 1,
            'week' => $week['week'],
            'date' => $date_saved,
            'close' => 1,
            'reg_by' => $this->session->userdata('id_user')
            );
        $this->db->insert('kanibal', $ins);

        for($i=0; $i<count($id_product); $i++)
        {
            if(!empty($qty[$i]) && $qty[$i] != 0)
            {
                $product = $this->product_model->getProductDetail($id_product[$i]);
                $det = array(
                    'assemble_number' => $assemble_number,
                    'type_product' => $product['type_product'][0],
                    'product_type' => $product['product_type'][0],
                    'id_product' => $id_product[$i],
                    'code_product' => $product['code_product'][0],
                    'product_name' => $product['product_name'][0],
                    'qty' => $qty[$i]
                    );
                $this->db->insert('kanibal_detail', $det);
            }
        }
        return $assemble_number;
    }
}