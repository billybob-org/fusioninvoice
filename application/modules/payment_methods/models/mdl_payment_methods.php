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

class Mdl_Payment_Methods extends Response_Model {
	
	public $table = 'fi_payment_methods';
	public $primary_key = 'fi_payment_methods.payment_method_id';
	
	public function order_by()
	{
		$this->db->order_by('fi_payment_methods.payment_method_name');
	}
	
	public function validation_rules()
	{
		return array(
			'payment_method_name' => array(
				'field' => 'payment_method_name',
				'label' => lang('payment_method'),
				'rules' => 'required'
			)
		);
	}
	
}

?>