<?php

class log_model extends CI_Model {

	function activity_log($activity = '')
    {
        $session_data = $this->session->all_userdata();

        $uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $env_ip = $this->get_client_ip_env();
        $browser = $this->getBrowser();

        $ins = array(
            'id_user' => $session_data['userid'],
            'name' => $session_data['username'],
            'activity' => $activity,
            'uri' => $uri,
            'env_ip' => $env_ip,
            'browser' => $browser['name'],
            'version' => $browser['version'],
            'platform' => $browser['platform'],
            'user_agent' => $browser['userAgent'],
            'date' => date('Y-m-d H:i:s')
            );
        $this->db->insert('activity_log', $ins);
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
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'userAgent' => $u_agent,
            'pattern' => $pattern
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
}