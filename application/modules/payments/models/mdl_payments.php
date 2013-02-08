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

class Mdl_Payments extends Response_Model {

    public $table            = 'fi_payments';
    public $primary_key      = 'fi_payments.payment_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            fi_payment_custom.*,
            fi_payment_methods.*,
            fi_invoice_amounts.*,
            fi_clients.client_name,
            fi_invoices.invoice_number,
            fi_payments.*");
    }

    public function default_order_by()
    {
        $this->db->order_by('fi_payments.payment_date DESC');
    }

    public function default_join()
    {
        $this->db->join('fi_invoices', 'fi_invoices.invoice_id = fi_payments.invoice_id');
        $this->db->join('fi_clients', 'fi_clients.client_id = fi_invoices.client_id');
        $this->db->join('fi_invoice_amounts', 'fi_invoice_amounts.invoice_id = fi_invoices.invoice_id');
        $this->db->join('fi_payment_methods', 'fi_payment_methods.payment_method_id = fi_payments.payment_method_id', 'left');
        $this->db->join('fi_payment_custom', 'fi_payment_custom.payment_id = fi_payments.payment_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'invoice_id'        => array(
                'field' => 'invoice_id',
                'label' => lang('invoice'),
                'rules' => 'required'
            ),
            'payment_date'      => array(
                'field' => 'payment_date',
                'label' => lang('date'),
                'rules' => 'required'
            ),
            'payment_amount'    => array(
                'field' => 'payment_amount',
                'label' => lang('payment'),
                'rules' => 'required|callback_validate_payment_amount'
            ),
            'payment_method_id' => array(
                'field' => 'payment_method_id',
                'label' => lang('payment_method')
            ),
            'payment_note'      => array(
                'field' => 'payment_note',
                'label' => lang('note')
            )
        );
    }

    public function validate_payment_amount($amount)
    {
        $invoice_id = $this->input->post('invoice_id');
        $payment_id = $this->input->post('payment_id');

        $invoice_balance = $this->db->where('invoice_id', $invoice_id)->get('fi_invoice_amounts')->row()->invoice_balance;

        if ($payment_id)
        {
            $payment = $this->db->where('payment_id', $payment_id)->get('fi_payments')->row();

            $invoice_balance = $invoice_balance + $payment->payment_amount;
        }

        if ($amount > $invoice_balance)
        {
            $this->form_validation->set_message('validate_payment_amount', lang('payment_cannot_exceed_balance'));
            return FALSE;
        }

        return TRUE;
    }

    public function save($id = NULL, $db_array = NULL)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the payment
        $id = parent::save($id, $db_array);

        // Recalculate invoice amounts
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($db_array['invoice_id']);

        return $id;
    }

    public function delete($id = NULL)
    {
        // Get the invoice id before deleting payment
        $this->db->select('invoice_id');
        $this->db->where('payment_id', $id);
        $invoice_id = $this->db->get('fi_payments')->row()->invoice_id;

        // Delete the payment
        parent::delete($id);

        // Recalculate invoice amounts
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);
        
        $this->load->helper('orphan');
        delete_orphans();
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['payment_date'] = date_to_mysql($db_array['payment_date']);

        return $db_array;
    }

    public function prep_form($id = NULL)
    {
        parent::prep_form($id);

        if (!$id)
        {
            parent::set_form_value('payment_date', date('Y-m-d'));
        }
    }

}

?>