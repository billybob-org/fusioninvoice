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

class Email_Templates extends Admin_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mdl_email_templates');
	}
	
	public function index()
	{
		$this->layout->set('email_templates', $this->mdl_email_templates->paginate()->result());
		$this->layout->buffer('content', 'email_templates/index');
		$this->layout->render();
	}
	
	public function form($id = NULL)
	{
		if ($this->input->post('btn_cancel'))
		{
			redirect('email_templates');
		}
		
		if ($this->mdl_email_templates->run_validation())
		{
			$this->mdl_email_templates->save($id);
			redirect('email_templates');
		}
		
		if ($id and !$this->input->post('btn_submit'))
		{
			$this->mdl_email_templates->prep_form($id);
		}
		
		$this->layout->buffer('content', 'email_templates/form');
		$this->layout->render();
	}
	
	public function delete($id)
	{
		$this->mdl_email_templates->delete($id);
		redirect('email_templates');
	}

}

?>