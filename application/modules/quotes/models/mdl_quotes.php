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

class Mdl_Quotes extends Response_Model {

    public $table               = 'fi_quotes';
    public $primary_key         = 'fi_quotes.quote_id';
    public $date_modified_field = 'invoice_date_modified';

    public function default_select()
    {
        $this->db->select("
            fi_quote_custom.*,
            fi_client_custom.*, 
            fi_user_custom.*,
            fi_users.user_name, 
			fi_users.user_company,
			fi_users.user_address_1,
			fi_users.user_address_2,
			fi_users.user_city,
			fi_users.user_state,
			fi_users.user_zip,
			fi_users.user_country,
			fi_users.user_phone,
			fi_users.user_fax,
			fi_users.user_mobile,
			fi_users.user_email,
			fi_users.user_web,
			fi_clients.*,
			fi_quote_amounts.quote_amount_id,
			IFNULL(fi_quote_amounts.quote_total, '0.00') AS quote_total,
			fi_quotes.*,
			fi_invoices.invoice_number", FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('fi_quotes.quote_date_created DESC');
    }

    public function default_join()
    {
        $this->db->join('fi_clients', 'fi_clients.client_id = fi_quotes.client_id');
        $this->db->join('fi_users', 'fi_users.user_id = fi_quotes.user_id');
        $this->db->join('fi_quote_amounts', 'fi_quote_amounts.quote_id = fi_quotes.quote_id', 'left');
        $this->db->join('fi_invoices', 'fi_invoices.invoice_id = fi_quotes.invoice_id', 'left');
        $this->db->join('fi_client_custom', 'fi_client_custom.client_id = fi_clients.client_id', 'left');
        $this->db->join('fi_user_custom', 'fi_user_custom.user_id = fi_users.user_id', 'left');
        $this->db->join('fi_quote_custom', 'fi_quote_custom.quote_id = fi_quotes.quote_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'client_name'        => array(
                'field' => 'client_name',
                'label' => lang('client'),
                'rules' => 'required'
            ),
            'quote_date_created' => array(
                'field' => 'quote_date_created',
                'label' => lang('date'),
                'rules' => 'required'
            ),
            'invoice_group_id'   => array(
                'field' => 'invoice_group_id',
                'label' => lang('quote_group'),
                'rules' => 'required'
            ),
            'user_id'            => array(
                'field' => 'user_id',
                'label' => lang('user'),
                'rule'  => 'required'
            )
        );
    }
    
    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('unique');
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        // Get the client id for the submitted quote
        $this->load->model('clients/mdl_clients');
        $db_array['client_id'] = $this->mdl_clients->client_lookup($db_array['client_name']);
        unset($db_array['client_name']);
        
        $db_array['quote_date_created'] = date_to_mysql($db_array['quote_date_created']);

        // Calculate the quote date due
        $quote_due_date                 = new DateTime($db_array['quote_date_created']);
        $quote_due_date->add(new DateInterval('P' . $this->mdl_settings->setting('quotes_expire_after') . 'D'));
        $db_array['quote_date_expires'] = $quote_due_date->format('Y-m-d');

        // Get the next quote number for the selected quote group
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $db_array['quote_number'] = $this->mdl_invoice_groups->generate_invoice_number($db_array['invoice_group_id']);
        
        // Generate the unique url key
        $this->load->helper('string');
        $db_array['quote_url_key'] = $this->get_url_key();

        return $db_array;
    }

    public function save($id = NULL, $db_array = NULL)
    {
        $id = parent::save($id, $db_array);

        $db_array = array(
            'quote_id' => $id
        );

        $this->db->insert('fi_quote_amounts', $db_array);

        return $id;
    }

    public function delete($quote_id)
    {
        parent::delete($quote_id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    public function is_open()
    {
        $this->where('quote_date_expires > NOW()');
        $this->where('fi_quotes.invoice_id', 0);
        return $this;
    }

    public function is_expired()
    {
        $this->where('quote_date_expires <= NOW()');
        $this->where('fi_quotes.invoice_id', 0);
        return $this;
    }

    public function is_invoiced()
    {
        $this->where('fi_quotes.invoice_id <>', 0);
        return $this;
    }

    public function by_client($client_id)
    {
        $this->where('fi_quotes.client_id', $client_id);
        return $this;
    }

}

?>