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

class Ajax extends Admin_Controller {
	
	public $ajax_controller = TRUE;

	public function add()
	{
		$this->load->model('payments/mdl_payments');
		
		if ($this->mdl_payments->run_validation())
		{
			$this->mdl_payments->save();

			$response = array(
				'success' => 1
			);
		}
		else
		{
			$this->load->helper('json_error');
			$response = array(
				'success' => 0,
				'validation_errors' => json_errors()
			);
		}

		echo json_encode($response);
	}

}

?>