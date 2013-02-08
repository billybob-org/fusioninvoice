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

    public function save()
    {
        $this->load->model('quotes/mdl_quote_items');

        $items = json_decode($this->input->post('items'));

        foreach ($items as $item)
        {
            if ($item->item_name)
            {
                $this->mdl_quote_items->save($this->input->post('quote_id'), isset($item->item_id) ? $item->item_id : NULL, $item);
            }
        }

        if ($this->input->post('custom'))
        {
            $db_array = array();

            foreach ($this->input->post('custom') as $custom)
            {
                // I hate myself for this...
                $db_array[str_replace(']', '', str_replace('custom[', '', $custom['name']))] = $custom['value'];
            }

            $this->load->model('custom_fields/mdl_quote_custom');
            $this->mdl_quote_custom->save_custom($this->input->post('quote_id'), $db_array);
        }
    }

    public function create()
    {
        $this->load->model('quotes/mdl_quotes');

        if ($this->mdl_quotes->run_validation())
        {
            $quote_id = $this->mdl_quotes->save();

            $response = array(
                'success'  => 1,
                'quote_id' => $quote_id
            );
        }
        else
        {
            $this->load->helper('json_error');
            $response = array(
                'success'           => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function get_item()
    {
        $this->load->model('quotes/mdl_quote_items');

        $item = $this->mdl_quote_items->get_by_id($this->input->post('item_id'));

        echo json_encode($item);
    }

    public function modal_create_quote()
    {
        $this->load->module('layout');

        $this->load->model('invoice_groups/mdl_invoice_groups');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'client_name'    => $this->input->post('client_name')
        );

        $this->layout->load_view('quotes/modal_create_quote', $data);
    }

    public function modal_quote_to_invoice($quote_id)
    {
        $this->load->module('layout');

        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('quotes/mdl_quotes');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'quote_id'       => $quote_id,
            'quote'          => $this->mdl_quotes->where('fi_quotes.quote_id', $quote_id)->get()->row()
        );

        $this->layout->load_view('quotes/modal_quote_to_invoice', $data);
    }

    public function quote_to_invoice()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quotes/mdl_quote_items');

        if ($this->mdl_invoices->run_validation())
        {
            $invoice_id = $this->mdl_invoices->create();

            $this->db->where('quote_id', $this->input->post('quote_id'));
            $this->db->set('invoice_id', $invoice_id);
            $this->db->update('fi_quotes');

            $quote_items = $this->mdl_quote_items->where('quote_id', $this->input->post('quote_id'))->get()->result();

            foreach ($quote_items as $quote_item)
            {
                $db_array = array(
                    'invoice_id'       => $invoice_id,
                    'item_tax_rate_id' => $this->mdl_settings->setting('default_invoice_item_tax_rate'),
                    'item_name'        => $quote_item->item_name,
                    'item_description' => $quote_item->item_description,
                    'item_quantity'    => $quote_item->item_quantity,
                    'item_price'       => $quote_item->item_price,
                    'item_order'       => $quote_item->item_order
                );

                $this->mdl_items->save($invoice_id, NULL, $db_array);
            }

            $response = array(
                'success'    => 1,
                'invoice_id' => $invoice_id
            );
        }
        else
        {
            $response = array(
                'success'           => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

}

?>