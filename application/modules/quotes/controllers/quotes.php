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

class Quotes extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_quotes');
    }

    public function index()
    {
        // Display open quotes by default
        redirect('quotes/status/open');
    }

    public function status($status = 'open')
    {
        // Determine which group of quotes to load
        switch ($status)
        {
            case 'expired':
                $this->layout->set('quotes', $this->mdl_quotes->is_expired()->paginate()->result());
                break;
            case 'invoiced':
                $this->layout->set('quotes', $this->mdl_quotes->is_invoiced()->paginate()->result());
                $this->layout->set('show_invoice_column', TRUE);
                break;
            default:
                $this->layout->set('quotes', $this->mdl_quotes->is_open()->paginate()->result());
                break;
        }

        $this->layout->buffer('content', 'quotes/index');
        $this->layout->render();
    }

    public function view($quote_id)
    {
        $this->load->model('mdl_quote_items');
        $this->load->module('payments');
        $this->load->model('custom_fields/mdl_custom_fields');

        $this->load->model('custom_fields/mdl_quote_custom');

        $quote_custom = $this->mdl_quote_custom->where('quote_id', $quote_id)->get();

        if ($quote_custom->num_rows())
        {
            $quote_custom = $quote_custom->row();

            unset($quote_custom->quote_id, $quote_custom->quote_custom_id);

            foreach ($quote_custom as $key => $val)
            {
                $this->mdl_quotes->set_form_value('custom[' . $key . ']', $val);
            }
        }

        $this->layout->set(
            array(
                'quote'         => $this->mdl_quotes->get_by_id($quote_id),
                'items'         => $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result(),
                'quote_id'      => $quote_id,
                'custom_fields' => $this->mdl_custom_fields->by_table('fi_quote_custom')->get()->result()
            )
        );

        $this->layout->buffer(
            array(
                array('modal_delete_quote', 'quotes/modal_delete_quote'),
                array('content', 'quotes/view')
            )
        );

        $this->layout->render();
    }

    public function delete($quote_id)
    {
        // Delete the quote
        $this->mdl_quotes->delete($quote_id);

        // Redirect to quote index
        redirect('quotes/index');
    }

    public function delete_item($quote_id, $item_id)
    {
        // Delete quote item
        $this->load->model('mdl_quote_items');
        $this->mdl_quote_items->delete($item_id);

        // Redirect to quote view
        redirect('quotes/view/' . $quote_id);
    }

    public function generate_pdf($quote_id, $stream = TRUE, $quote_template = NULL)
    {
        $this->load->model('mdl_quote_items');

        $quote = $this->mdl_quotes->get_by_id($quote_id);

        if (!$quote_template)
        {
            $quote_template = $this->mdl_settings->setting('default_quote_template');
        }

        $data = array(
            'quote'       => $quote,
            'items'       => $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result(),
            'output_type' => 'pdf'
        );

        $html = $this->load->view('quote_templates/' . $quote_template, $data, TRUE);

        $this->load->helper('dompdf');

        return pdf_create($html, 'Quote_' . $quote->quote_number, $stream);
    }

}

?>