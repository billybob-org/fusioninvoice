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

class Custom_Fields extends Admin_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mdl_custom_fields');
	}
	
	public function index()
	{
		$this->layout->set('custom_fields', $this->mdl_custom_fields->paginate()->result());
		$this->layout->buffer('content', 'custom_fields/index');
		$this->layout->render();
	}
	
	public function form($id = NULL)
	{
		if ($this->input->post('btn_cancel'))
		{
			redirect('custom_fields');
		}
		
		if ($this->mdl_custom_fields->run_validation())
		{
			$this->mdl_custom_fields->save($id);
			redirect('custom_fields');
		}
		
		if ($id and !$this->input->post('btn_submit'))
		{
			$this->mdl_custom_fields->prep_form($id);
		}
		
        $this->layout->set('custom_field_tables', $this->mdl_custom_fields->custom_tables());
		$this->layout->buffer('content', 'custom_fields/form');
		$this->layout->render();
	}
	
	public function delete($id)
	{
		$this->mdl_custom_fields->delete($id);
		redirect('custom_fields');
	}

}

?>