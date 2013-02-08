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

class View extends Base_Controller {

    public function invoice($invoice_url_key)
    {
        $this->load->model('invoices/mdl_invoices');

        $invoice = $this->mdl_invoices->where('invoice_url_key', $invoice_url_key)->get();

        if ($invoice->num_rows() == 1)
        {
            $this->load->model('invoices/mdl_items');
            $this->load->model('invoices/mdl_invoice_tax_rates');

            $invoice = $invoice->row();

            $data = array(
                'invoice'           => $invoice,
                'items'             => $this->mdl_items->where('invoice_id', $invoice->invoice_id)->get()->result(),
                'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice->invoice_id)->get()->result(),
                'invoice_url_key'   => $invoice_url_key,
                'flash_message'     => $this->session->flashdata('flash_message')
            );

            $html = $this->load->view('invoice_templates/public_invoice', $data, TRUE);

            echo $html;
        }
    }

    public function generate_invoice_pdf($invoice_url_key, $stream = TRUE, $invoice_template = NULL)
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        $invoice = $this->mdl_invoices->where('invoice_url_key', $invoice_url_key)->get();

        if ($invoice->num_rows() == 1)
        {
            $invoice = $invoice->row();

            if (!$invoice_template)
            {
                $invoice_template = $this->mdl_settings->setting('default_invoice_template');
            }

            $data = array(
                'invoice'           => $invoice,
                'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice->invoice_id)->get()->result(),
                'items'             => $this->mdl_items->where('invoice_id', $invoice->invoice_id)->get()->result(),
                'output_type'       => 'pdf'
            );

            $html = $this->load->view('invoice_templates/' . $invoice_template, $data, TRUE);

            $this->load->helper('dompdf');

            return pdf_create($html, 'Invoice_' . $invoice->invoice_number, $stream);
        }
    }

    public function quote($quote_url_key)
    {
        $this->load->model('quotes/mdl_quotes');

        $quote = $this->mdl_quotes->where('quote_url_key', $quote_url_key)->get();

        if ($quote->num_rows() == 1)
        {
            $this->load->model('quotes/mdl_quote_items');

            $quote = $quote->row();

            $data = array(
                'quote'           => $quote,
                'items'           => $this->mdl_quote_items->where('quote_id', $quote->quote_id)->get()->result(),
                'quote_url_key'   => $quote_url_key,
                'flash_message'   => $this->session->flashdata('flash_message')
            );

            $html = $this->load->view('quote_templates/public_quote', $data, TRUE);

            echo $html;
        }
    }

    public function generate_quote_pdf($quote_url_key, $stream = TRUE, $quote_template = NULL)
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quotes/mdl_quote_items');

        $quote = $this->mdl_quotes->where('quote_url_key', $quote_url_key)->get();

        if ($quote->num_rows() == 1)
        {
            $quote = $quote->row();

            if (!$quote_template)
            {
                $quote_template = $this->mdl_settings->setting('default_quote_template');
            }

            $data = array(
                'quote'           => $quote,
                'items'           => $this->mdl_quote_items->where('quote_id', $quote->quote_id)->get()->result(),
                'output_type'     => 'pdf'
            );

            $html = $this->load->view('quote_templates/' . $quote_template, $data, TRUE);

            $this->load->helper('dompdf');

            return pdf_create($html, 'Quote_' . $quote->quote_number, $stream);
        }
    }

}

?>