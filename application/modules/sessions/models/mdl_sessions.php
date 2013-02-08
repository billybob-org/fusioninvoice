<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * FusionInvoice
 * 
 * A free and open source web based invoicing system
 *
 * @package		FusionInvoice
 * @author		Jesse Terry
 * @copyright	Copyright (c) 2012 - 2013, Jesse Terry
 * @license		http://www.fusioninvoice.com/license.txt
 * @link		http://www.fusioninvoice.
 * 
 */

class Mdl_Sessions extends CI_Model {

	public function auth($email, $password)
	{
		$this->db->where('user_email', $email);
		$this->db->where('user_password', md5($password));

		$query = $this->db->get('fi_users');

		if ($query->num_rows())
		{
			$user = $query->row();
			
			$session_data = array(
				'user_type'	 => $user->user_type,
				'user_id'	 => $user->user_id,
			);

			$this->session->set_userdata($session_data);

			return TRUE;
		}

		return FALSE;
	}

}

?>