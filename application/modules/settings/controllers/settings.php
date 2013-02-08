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

class Settings extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_settings');
    }

    public function index()
    {
        if ($this->input->post('btn_submit'))
        {
            foreach ($this->input->post('settings') as $key => $value)
            {
                if ($key == 'smtp_password' or $key == 'merchant_password')
                {
                    if ($value <> '')
                    {
                        $this->load->library('encrypt');
                        $this->mdl_settings->save($key, $this->encrypt->encode($value));
                    }
                }
                else
                {
                    $this->mdl_settings->save($key, $value);
                }
            }

            $this->session->set_flashdata('alert_success', lang('settings_successfully_saved'));
            redirect('settings');
        }

        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('directory');
        $this->load->library('merchant');

        $invoice_templates = $this->get_templates('invoice');
        $quote_templates   = $this->get_templates('quote');

        $this->layout->set(
            array(
                'invoice_groups'          => $this->mdl_invoice_groups->get()->result(),
                'tax_rates'               => $this->mdl_tax_rates->get()->result(),
                'invoice_templates'       => $invoice_templates,
                'quote_templates'         => $quote_templates,
                'languages'               => directory_map(APPPATH . 'language', TRUE),
                'date_formats'            => date_formats(),
                'current_date'            => new DateTime(),
                'email_templates'         => $this->mdl_email_templates->get()->result(),
                'merchant_drivers'        => $this->merchant->valid_drivers(),
                'merchant_currency_codes' => Merchant::$NUMERIC_CURRENCY_CODES
            )
        );

        $this->layout->buffer('content', 'settings/index');
        $this->layout->render();
    }

    private function get_templates($type)
    {
        $templates = directory_map(APPPATH . 'views/' . $type . '_templates', TRUE);

        foreach ($templates as $key => $template)
        {
            $templates[$key] = str_replace('.php', '', strtolower($template));
        }

        return $templates;
    }

}

?>