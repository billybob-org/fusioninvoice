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

class Mdl_Templates extends CI_Model {

	public function get_invoice_templates()
	{
		$this->load->helper('directory');

		$templates = directory_map(APPPATH . '/views/invoice_templates', TRUE);

		$templates = $this->remove_extension($templates);

		return $templates;
	}

	public function get_quote_templates()
	{
		$this->load->helper('directory');

		$templates = directory_map(APPPATH . '/views/quote_templates', TRUE);

		$templates = $this->remove_extension($templates);

		return $templates;
	}

	private function remove_extension($files)
	{
		foreach ($files as $key => $file)
		{
			$files[$key] = str_replace('.php', '', $file);
		}

		return $files;
	}

}

?>