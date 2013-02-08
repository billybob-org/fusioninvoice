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

class Guest_Controller extends User_Controller {

    public $user_clients = array();

    public function __construct()
    {
        parent::__construct('user_type', 2);

        $this->load->model('users/mdl_user_clients');

        $user_clients = $this->mdl_user_clients->where('fi_user_clients.user_id', $this->session->userdata('user_id'))->get()->result();

        foreach ($user_clients as $user_client)
        {
            $this->user_clients[$user_client->client_id] = $user_client->client_id;
        }
    }

}

?>