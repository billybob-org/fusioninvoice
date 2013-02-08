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

class Mailer extends Admin_Controller {

    private $mailer_configured;

    public function __construct()
    {
        parent::__construct();

        $this->mailer_configured = ($this->mdl_settings->setting('smtp_server_address')) ? TRUE : FALSE;
    }

    public function invoice($invoice_id)
    {
        if ($this->mailer_configured == TRUE)
        {
            if ($this->input->post('btn_send'))
            {
                $this->load->helper('phpmailer');

                $invoice = modules::run('invoices/generate_pdf', $invoice_id, FALSE);

                $from    = ($this->input->post('from_name')) ? array($this->input->post('from_email'), $this->input->post('from_name')) : $this->input->post('from_email');
                $to      = $this->input->post('to_email');
                $subject = $this->input->post('subject');
                $message = $this->input->post('body');
                $cc      = $this->input->post('to_cc');
                $bcc     = $this->input->post('to_bcc');

                if (phpmail_send($from, $to, $subject, $message, $invoice, $cc, $bcc))
                {
                    redirect('dashboard');
                }
                else
                {
                    redirect('mailer/invoice/' . $invoice_id);
                }

                $this->session->set_flashdata('alert_success', 'Email successfully sent');

                redirect('dashboard');
            }

            $this->load->model('invoices/mdl_templates');
            $this->load->model('invoices/mdl_invoices');
            $this->load->model('email_templates/mdl_email_templates');

            if ($email_template_id = $this->mdl_settings->setting('default_email_template'))
            {
                $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

                if ($email_template->num_rows())
                {
                    $this->layout->set('body', $email_template->row()->email_template_body);
                }
                else
                {
                    $this->layout->set('body', '');
                }
            }
            else
            {
                $this->layout->set('body', '');
            }

            $this->layout->set('invoice', $this->mdl_invoices->where('fi_invoices.invoice_id', $invoice_id)->get()->row());
            $this->layout->set('invoice_templates', $this->mdl_templates->get_invoice_templates());
            $this->layout->buffer('content', 'mailer/invoice');
            $this->layout->render();
        }
        else
        {
            $this->layout->buffer('content', 'mailer/not_configured');
            $this->layout->render();
        }
    }
    
    public function quote($quote_id)
    {
        if ($this->mailer_configured == TRUE)
        {
            if ($this->input->post('btn_send'))
            {
                $this->load->helper('phpmailer');

                $quote = modules::run('quotes/generate_pdf', $quote_id, FALSE);

                $from    = ($this->input->post('from_name')) ? array($this->input->post('from_email'), $this->input->post('from_name')) : $this->input->post('from_email');
                $to      = $this->input->post('to_email');
                $subject = $this->input->post('subject');
                $message = $this->input->post('body');
                $cc      = $this->input->post('to_cc');
                $bcc     = $this->input->post('to_bcc');

                if (phpmail_send($from, $to, $subject, $message, $quote, $cc, $bcc))
                {
                    redirect('dashboard');
                }
                else
                {
                    redirect('mailer/quote/' . $quote_id);
                }

                $this->session->set_flashdata('alert_success', 'Email successfully sent');

                redirect('dashboard');
            }

            $this->load->model('invoices/mdl_templates');
            $this->load->model('quotes/mdl_quotes');
            $this->load->model('email_templates/mdl_email_templates');

            if ($email_template_id = $this->mdl_settings->setting('default_email_template'))
            {
                $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

                if ($email_template->num_rows())
                {
                    $this->layout->set('body', $email_template->row()->email_template_body);
                }
                else
                {
                    $this->layout->set('body', '');
                }
            }
            else
            {
                $this->layout->set('body', '');
            }

            $this->layout->set('quote', $this->mdl_quotes->where('fi_quotes.quote_id', $quote_id)->get()->row());
            $this->layout->set('quote_templates', $this->mdl_templates->get_quote_templates());
            $this->layout->buffer('content', 'mailer/quote');
            $this->layout->render();
        }
        else
        {
            $this->layout->buffer('content', 'mailer/not_configured');
            $this->layout->render();
        }
    }

}

?>