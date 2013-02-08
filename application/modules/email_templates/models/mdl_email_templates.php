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

class Mdl_Email_Templates extends Response_Model {
	
	public $table = 'fi_email_templates';
	public $primary_key = 'fi_email_templates.email_template_id';
	
	public function default_order_by()
	{
		$this->db->order_by('email_template_title');
	}
	
	public function validation_rules()
	{
		return array(
			'email_template_title' => array(
				'field' => 'email_template_title',
				'label' => lang('title'),
				'rules' => 'required'
			),
			'email_template_body' => array(
				'field' => 'email_template_body',
				'label' => lang('body')
			)
		);
	}
}

?>