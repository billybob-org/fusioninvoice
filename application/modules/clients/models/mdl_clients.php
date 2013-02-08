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

class Mdl_Clients extends Response_Model {

    public $table               = 'fi_clients';
    public $primary_key         = 'fi_clients.client_id';
    public $date_created_field  = 'client_date_created';
    public $date_modified_field = 'client_date_modified';

    public function default_select()
    {
        $this->db->select('fi_client_custom.*, fi_clients.*');
    }

    public function default_join()
    {
        $this->db->join('fi_client_custom', 'fi_client_custom.client_id = fi_clients.client_id', 'left');
    }

    public function default_order_by()
    {
        $this->db->order_by('fi_clients.client_name');
    }

    public function validation_rules()
    {
        return array(
            'client_name'      => array(
                'field' => 'client_name',
                'label' => lang('client_name'),
                'rules' => 'required'
            ),
            'client_active'    => array(
                'field' => 'client_active'
            ),
            'client_address_1' => array(
                'field' => 'client_address_1'
            ),
            'client_address_2' => array(
                'field' => 'client_address_2'
            ),
            'client_city'      => array(
                'field' => 'client_city'
            ),
            'client_state'     => array(
                'field' => 'client_state'
            ),
            'client_zip'       => array(
                'field' => 'client_zip'
            ),
            'client_country'   => array(
                'field' => 'client_country'
            ),
            'client_phone'     => array(
                'field' => 'client_phone'
            ),
            'client_fax'       => array(
                'field' => 'client_fax'
            ),
            'client_mobile'    => array(
                'field' => 'client_mobile'
            ),
            'client_email'     => array(
                'field' => 'client_email'
            ),
            'client_web'       => array(
                'field' => 'client_web'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        if (!isset($db_array['client_active']))
        {
            $db_array['client_active'] = 0;
        }

        return $db_array;
    }
    
    public function delete($id)
    {
        parent::delete($id);
        
        $this->load->helper('orphan');
        delete_orphans();
    }

    /**
     * Returns client_id of existing or new record 
     */
    public function client_lookup($client_name)
    {
        $client = $this->mdl_clients->where('client_name', $client_name)->get();

        if ($client->num_rows())
        {
            $client_id = $client->row()->client_id;
        }
        else
        {
            $db_array = array(
                'client_name' => $client_name
            );

            $this->db->insert('fi_clients', $db_array);

            $client_id = $this->db->insert_id();
        }

        return $client_id;
    }

    public function with_totals()
    {
        $this->select("IFNULL((SELECT SUM(invoice_total) FROM fi_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM fi_invoices WHERE fi_invoices.client_id = fi_clients.client_id)), 0) AS client_invoice_total", false);
        $this->select("IFNULL((SELECT SUM(invoice_paid) FROM fi_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM fi_invoices WHERE fi_invoices.client_id = fi_clients.client_id)), 0) AS client_invoice_paid", false);
        $this->select("IFNULL((SELECT SUM(invoice_balance) FROM fi_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM fi_invoices WHERE fi_invoices.client_id = fi_clients.client_id)), 0) AS client_invoice_balance", false);
        return $this;
    }

    public function is_active()
    {
        $this->where('client_active', 1);
        return $this;
    }

    public function is_inactive()
    {
        $this->where('client_active', 0);
        return $this;
    }

}

?>