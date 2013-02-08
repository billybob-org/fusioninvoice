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

class Quotes extends Guest_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('quotes/mdl_quotes');
    }

    public function index()
    {
        // Display open quotes by default
        redirect('guest/quotes/status/open');
    }

    public function status($status = 'open')
    {
        // Determine which group of quotes to load
        switch ($status)
        {
            case 'expired':
                $this->layout->set('quotes', $this->mdl_quotes->is_expired()->where_in('fi_quotes.client_id', $this->user_clients)->paginate()->result());
                break;
            case 'invoiced':
                $this->layout->set('quotes', $this->mdl_quotes->is_invoiced()->where_in('fi_quotes.client_id', $this->user_clients)->paginate()->result());
                $this->layout->set('show_invoice_column', TRUE);
                break;
            default:
                $this->layout->set('quotes', $this->mdl_quotes->is_open()->where_in('fi_quotes.client_id', $this->user_clients)->paginate()->result());
                break;
        }

        $this->layout->buffer('content', 'guest/quotes_index');
        $this->layout->render('layout_guest');
    }

    public function view($quote_id)
    {
        $this->load->model('quotes/mdl_quote_items');

        $this->layout->set(
            array(
                'quote'    => $this->mdl_quotes->where('fi_quotes.quote_id', $quote_id)->where_in('fi_quotes.client_id', $this->user_clients)->get()->row(),
                'items'    => $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result(),
                'quote_id' => $quote_id
            )
        );

        $this->layout->buffer('content', 'guest/quotes_view');
        $this->layout->render('layout_guest');
    }

    public function generate_pdf($quote_id, $stream = TRUE, $quote_template = NULL)
    {
        $this->load->model('quotes/mdl_quote_items');

        $quote = $this->mdl_quotes->get_by_id($quote_id);

        if (!$quote_template)
        {
            $quote_template = $this->mdl_settings->setting('default_quote_template');
        }

        $data = array(
            'quote'       => $this->mdl_quotes->where('fi_quotes.quote_id', $quote_id)->where_in('fi_quotes.client_id', $this->user_clients)->get()->row(),
            'items'       => $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result(),
            'output_type' => 'pdf'
        );

        $html = $this->load->view('quote_templates/' . $quote_template, $data, TRUE);

        $this->load->helper('dompdf');

        return pdf_create($html, 'Quote_' . $quote->quote_number, $stream);
    }

}

?>