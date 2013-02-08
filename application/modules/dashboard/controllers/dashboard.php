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

class Dashboard extends Admin_Controller {

    public function index()
    {
        $this->load->model('payments/mdl_payments');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->load->model('clients/mdl_clients');

        $this->layout->set(
            array(
                'recent_payments'           => $this->mdl_payments->order_by('payment_date DESC')->limit(5)->get()->result(),
                'open_invoices'             => $this->mdl_invoices->is_open()->limit(5)->get()->result(),
                'overdue_invoices'          => $this->mdl_invoices->is_overdue()->limit(5)->get()->result(),
                'recent_clients'            => $this->mdl_clients->order_by('client_date_created DESC')->limit(5)->get()->result(),
                'total_invoiced_month'      => $this->mdl_invoice_amounts->get_total_invoiced('month'),
                'total_invoiced_last_month' => $this->mdl_invoice_amounts->get_total_invoiced('last_month'),
                'total_invoiced_year'       => $this->mdl_invoice_amounts->get_total_invoiced('year'),
                'total_invoiced_last_year'  => $this->mdl_invoice_amounts->get_total_invoiced('last_year'),
                'total_invoiced'            => $this->mdl_invoice_amounts->get_total_invoiced(),
                'total_paid_month'          => $this->mdl_invoice_amounts->get_total_paid('month'),
                'total_paid_last_month'     => $this->mdl_invoice_amounts->get_total_paid('last_month'),
                'total_paid_year'           => $this->mdl_invoice_amounts->get_total_paid('year'),
                'total_paid_last_year'      => $this->mdl_invoice_amounts->get_total_paid('last_year'),
                'total_paid'                => $this->mdl_invoice_amounts->get_total_paid(),
                'total_balance_month'       => $this->mdl_invoice_amounts->get_total_balance('month'),
                'total_balance_last_month'  => $this->mdl_invoice_amounts->get_total_balance('last_month'),
                'total_balance_year'        => $this->mdl_invoice_amounts->get_total_balance('year'),
                'total_balance_last_year'   => $this->mdl_invoice_amounts->get_total_balance('last_year'),
                'total_balance'             => $this->mdl_invoice_amounts->get_total_balance()
            )
        );

        $this->layout->buffer('content', 'dashboard/index');
        $this->layout->render();
    }

}

?>