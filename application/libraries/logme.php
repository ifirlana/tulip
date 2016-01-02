<?php 
/**
* 
*/
class logme 
{
	var $ci;
		function __construct()
		{
			$this->ci = &get_instance();
			// $this->ci->load->helper('cookie');
			$this->ci->load->library('session');
		}
	function generateFormToken($form) {
    	/*$token = md5(base64_encode(uniqid(microtime(), true)));      	
    	return $token;*/
    	// generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
    	/* $token = md5(base64_encode(md5(base64_encode("dataTokenFahmi12@"),"$form")));  */
    	$token = md5(base64_encode(md5(base64_encode("dataTokenFahmi12@".rand()),"$form"))); 
    	/* $token =md5(uniqid(base64_encode('dataTokenFahmi12@'.rand()), true)); */
    	
    	$newdata = array(
                   $form.'_tokens'  => $token,
               );
		$this->ci->session->set_userdata($newdata);
    	//$this->ci->session->sess_destroy();
    	return $token;
    }
    function verifyFormToken($form) {
    	$inSes = $this->ci->input->post('token');
        $sestok = $this->ci->session->userdata($form.'_tokens');
        // check if a session is started and a token is transmitted, if not return an error
    	if(!isset($sestok)) { 
    		return false;
        }
    	
    	// check if the form is sent with token in it
    	if(!isset($inSes)) {
    		return false;
        }
    	
    	// compare the tokens against each other if they are still the same
    	if ($sestok !== $inSes) {
    		return false;
        }
    	
    	return true;
    }
    
}