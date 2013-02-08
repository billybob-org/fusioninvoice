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

class Mdl_Import extends Response_Model {

    public $table            = 'fi_imports';
    public $primary_key      = 'fi_imports.import_id';
    public $expected_headers = array(
        'clients.csv'       => array(
            'client_name',
            'client_address_1',
            'client_address_2',
            'client_city',
            'client_state',
            'client_zip',
            'client_country',
            'client_phone',
            'client_fax',
            'client_mobile',
            'client_email',
            'client_web',
            'client_active'
        ),
        'invoices.csv'      => array(
            'user_email',
            'client_name',
            'invoice_date_created',
            'invoice_date_due',
            'invoice_number',
            'invoice_terms'
        ),
        'invoice_items.csv' => array(
            'invoice_number',
            'item_tax_rate',
            'item_date_added',
            'item_name',
            'item_description',
            'item_quantity',
            'item_price'
        ),
        'payments.csv'      => array(
            'invoice_number',
            'payment_method',
            'payment_date',
            'payment_amount',
            'payment_note'
        )
    );
    public $primary_keys     = array(
        'fi_clients'       => 'client_id',
        'fi_invoices'      => 'invoice_id',
        'fi_invoice_items' => 'item_id',
        'fi_payments'      => 'payment_id'
    );

    public function __construct()
    {
        ini_set("auto_detect_line_endings", true);
    }

    public function default_select()
    {
        $this->db->select("fi_imports.*, 
            (SELECT COUNT(*) FROM fi_import_details WHERE import_table_name = 'fi_clients' AND fi_import_details.import_id = fi_imports.import_id) AS num_clients,
            (SELECT COUNT(*) FROM fi_import_details WHERE import_table_name = 'fi_invoices' AND fi_import_details.import_id = fi_imports.import_id) AS num_invoices,
            (SELECT COUNT(*) FROM fi_import_details WHERE import_table_name = 'fi_invoice_items' AND fi_import_details.import_id = fi_imports.import_id) AS num_invoice_items,
            (SELECT COUNT(*) FROM fi_import_details WHERE import_table_name = 'fi_payments' AND fi_import_details.import_id = fi_imports.import_id) AS num_payments");
    }

    public function default_order_by()
    {
        $this->db->order_by('fi_imports.import_date DESC');
    }

    public function start_import()
    {
        $db_array = array(
            'import_date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('fi_imports', $db_array);

        return $this->db->insert_id();
    }

    public function import_data($file, $table)
    {
        $handle = fopen('./uploads/import/' . $file, 'r');

        $row = 1;

        $headers = $this->expected_headers[$file];

        $ids = array();

        while (($data = fgetcsv($handle, 1000, ",")) <> FALSE)
        {
            if ($row == 1 and $data <> $headers)
            {
                return FALSE;
            }
            elseif ($row > 1)
            {
                $db_array = array();

                foreach ($headers as $key => $header)
                {
                    $db_array[$header] = $data[$key];
                }

                $this->db->insert($table, $db_array);

                $ids[] = $this->db->insert_id();
            }

            $row++;
        }

        return $ids;
    }

    public function import_invoices()
    {
        $handle = fopen('./uploads/import/invoices.csv', 'r');

        $row = 1;

        $headers = $this->expected_headers['invoices.csv'];

        $ids = array();

        while (($data = fgetcsv($handle, 1000, ",")) <> FALSE)
        {
            $record_error = FALSE;

            if ($row == 1 and $data <> $headers)
            {
                return FALSE;
            }
            elseif ($row > 1)
            {
                $db_array = array();

                foreach ($headers as $key => $header)
                {
                    if ($header == 'user_email')
                    {
                        $this->db->where('user_email', $data[$key]);
                        $user = $this->db->get('fi_users');
                        if ($user->num_rows())
                        {
                            $header     = 'user_id';
                            $data[$key] = $user->row()->user_id;
                        }
                        else
                        {
                            $record_error = TRUE;
                        }
                    }
                    elseif ($header == 'client_name')
                    {
                        $header = 'client_id';
                        $this->db->where('client_name', $data[$key]);
                        $client = $this->db->get('fi_clients');
                        if ($client->num_rows())
                        {
                            $data[$key] = $client->row()->client_id;
                        }
                        else
                        {
                            $this->db->insert('fi_clients', array('client_name' => $data[$key]));
                            $data[$key]                  = $this->db->insert_id();
                        }
                    }
                    $db_array['invoice_url_key'] = $this->mdl_invoices->get_url_key();

                    $db_array[$header] = $data[$key];
                }

                if (!$record_error)
                {
                    $ids[] = $this->mdl_invoices->create($db_array);
                }
            }

            $row++;
        }

        return $ids;
    }

    public function import_invoice_items()
    {
        $handle = fopen('./uploads/import/invoice_items.csv', 'r');

        $row = 1;

        $headers = $this->expected_headers['invoice_items.csv'];

        $ids = array();

        while (($data = fgetcsv($handle, 1000, ",")) <> FALSE)
        {
            $record_error = FALSE;

            if ($row == 1 and $data <> $headers)
            {
                return FALSE;
            }
            elseif ($row > 1)
            {
                $db_array = array();

                foreach ($headers as $key => $header)
                {
                    if ($header == 'invoice_number')
                    {
                        $this->db->where('invoice_number', $data[$key]);
                        $user = $this->db->get('fi_invoices');
                        if ($user->num_rows())
                        {
                            $header     = 'invoice_id';
                            $data[$key] = $user->row()->invoice_id;
                        }
                        else
                        {
                            $record_error = TRUE;
                        }
                    }
                    elseif ($header == 'item_tax_rate')
                    {
                        $header = 'item_tax_rate_id';
                        if ($data[$key] > 0)
                        {
                            $this->db->where('tax_rate_percent', $data[$key]);
                            $tax_rate = $this->db->get('fi_tax_rates');
                            if ($tax_rate->num_rows())
                            {
                                $data[$key] = $tax_rate->row()->tax_rate_id;
                            }
                            else
                            {
                                $this->db->insert('fi_tax_rates', array('tax_rate_name'    => $data[$key], 'tax_rate_percent' => $data[$key]));
                                $data[$key] = $this->db->insert_id();
                            }
                        }
                        else
                        {
                            $data[$key] = 0;
                        }
                    }

                    $db_array[$header] = $data[$key];
                }

                if (!$record_error)
                {
                    $ids[] = $this->mdl_items->save($db_array['invoice_id'], NULL, $db_array);
                }
            }

            $row++;
        }

        return $ids;
    }

    public function import_payments()
    {
        $handle = fopen('./uploads/import/payments.csv', 'r');

        $row = 1;

        $headers = $this->expected_headers['payments.csv'];

        $ids = array();

        while (($data = fgetcsv($handle, 1000, ",")) <> FALSE)
        {
            $record_error = FALSE;

            if ($row == 1 and $data <> $headers)
            {
                return FALSE;
            }
            elseif ($row > 1)
            {
                $db_array = array();

                foreach ($headers as $key => $header)
                {
                    if ($header == 'invoice_number')
                    {
                        $this->db->where('invoice_number', $data[$key]);
                        $user = $this->db->get('fi_invoices');
                        if ($user->num_rows())
                        {
                            $header     = 'invoice_id';
                            $data[$key] = $user->row()->invoice_id;
                        }
                        else
                        {
                            $record_error = TRUE;
                        }
                    }
                    elseif ($header == 'payment_method')
                    {
                        $header = 'payment_method_id';

                        if ($data[$key])
                        {
                            $this->db->where('payment_method_name', $data[$key]);
                            $payment_method = $this->db->get('fi_payment_methods');
                            if ($payment_method->num_rows())
                            {
                                $data[$key] = $payment_method->row()->payment_method_id;
                            }
                            else
                            {
                                $this->db->insert('fi_payment_methods', array('payment_method_name' => $data[$key]));
                                $data[$key] = $this->db->insert_id();
                            }
                        }
                    }

                    $db_array[$header] = $data[$key];
                }

                if (!$record_error)
                {
                    $ids[] = $this->mdl_payments->save(NULL, $db_array);
                }
            }

            $row++;
        }

        return $ids;
    }

    public function record_import_details($import_id, $table_name, $import_lang_key, $ids)
    {
        foreach ($ids as $id)
        {
            $db_array = array(
                'import_id'         => $import_id,
                'import_table_name' => $table_name,
                'import_lang_key'   => $import_lang_key,
                'import_record_id'  => $id
            );

            $this->db->insert('fi_import_details', $db_array);
        }
    }

    public function delete($import_id)
    {
        $import_details = $this->db->where('import_id', $import_id)->get('fi_import_details')->result();

        foreach ($import_details as $import_detail)
        {
            $this->db->query("DELETE FROM " . $import_detail->import_table_name . " WHERE " . $this->primary_keys[$import_detail->import_table_name] . ' = ' . $import_detail->import_record_id);
        }

        parent::delete($import_id);

        $this->db->query('DELETE FROM fi_invoice_amounts WHERE invoice_id NOT IN (SELECT invoice_id FROM fi_invoices)');
    }

}

?>