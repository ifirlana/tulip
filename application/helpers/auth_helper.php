<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Cek login
if ( ! function_exists('is_login'))
{
	function is_login()
	{
		$token = get_instance()->session->userdata('token');
		
		if ($token){
			$row = get_instance()->Login_model->get_userByToken($token);
			
			if ($row->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		return FALSE;
	}
}

# get Logged as
if ( ! function_exists('logged_as'))
{
	function logged_as()
	{
		return get_instance()->session->userdata('logged_as');
	}
}

# get User ID
if ( ! function_exists('get_userid'))
{
	function get_userid()
	{
		return get_instance()->session->userdata('intid_user');
	}
}