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

class Mdl_Custom_Fields extends MY_Model {

    public $table       = 'fi_custom_fields';
    public $primary_key = 'fi_custom_fields.custom_field_id';

    public function custom_tables()
    {
        return array(
            'fi_client_custom'  => lang('client'),
            'fi_invoice_custom' => lang('invoice'),
            'fi_payment_custom' => lang('payment'),
            'fi_quote_custom'   => lang('quote'),
            'fi_user_custom'    => lang('user')
        );
    }

    public function validation_rules()
    {
        return array(
            'custom_field_table' => array(
                'field' => 'custom_field_table',
                'label' => lang('table'),
                'rules' => 'required'
            ),
            'custom_field_label' => array(
                'field' => 'custom_field_label',
                'label' => lang('label'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $custom_tables = $this->custom_tables();

        $custom_field_column = strtolower($custom_tables[$db_array['custom_field_table']]) . '_custom_' . preg_replace('/[^a-zA-Z0-9_\s]/', '', strtolower(str_replace(' ', '_', $db_array['custom_field_label'])));

        $db_array['custom_field_column'] = $custom_field_column;

        return $db_array;
    }

    public function save($id = NULL, $db_array = NULL)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        $id = parent::save($id, $db_array);

        $this->db->query('ALTER TABLE `' . $db_array['custom_field_table'] . '` ADD `' . $db_array['custom_field_column'] . '` VARCHAR( 255 ) NOT NULL');

        return $id;
    }

    public function delete($id)
    {
        $custom_field = $this->get_by_id($id);

        $exists = $this->db->query("SHOW COLUMNS FROM `" . $custom_field->custom_field_table . "` LIKE " . $this->db->escape($custom_field->custom_field_column));

        if ($exists->num_rows() == 1)
        {
            $this->db->query("ALTER TABLE `" . $custom_field->custom_field_table . "` DROP `" . $custom_field->custom_field_column . "`");
        }

        parent::delete($id);
    }

    public function by_table($table)
    {
        $this->where('custom_field_table', $table);
        return $this;
    }

}

?>