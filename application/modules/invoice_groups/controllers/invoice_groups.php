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

class Invoice_Groups extends Admin_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mdl_invoice_groups');
	}
	
	public function index()
	{
		$this->layout->set('invoice_groups', $this->mdl_invoice_groups->paginate()->result());
		$this->layout->buffer('content', 'invoice_groups/index');
		$this->layout->render();
	}
	
	public function form($id = NULL)
	{
		if ($this->input->post('btn_cancel'))
		{
			redirect('invoice_groups');
		}
		
		if ($this->mdl_invoice_groups->run_validation())
		{
			$this->mdl_invoice_groups->save($id);
			redirect('invoice_groups');
		}
		
		if ($id and !$this->input->post('btn_submit'))
		{
			$this->mdl_invoice_groups->prep_form($id);
		}
		
		$this->layout->buffer('content', 'invoice_groups/form');
		$this->layout->render();
	}
	
	public function delete($id)
	{
		$this->mdl_invoice_groups->delete($id);
		redirect('invoice_groups');
	}

}

?>