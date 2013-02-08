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

class Mdl_Quote_Amounts extends CI_Model {

	/**
	 * FI_QUOTE_AMOUNTS
	 * quote_amount_id
	 * quote_id
	 * quote_total			SUM(item_subtotal)
	 * 
	 * FI_QUOTE_ITEM_AMOUNTS
	 * item_amount_id
	 * item_id
	 * item_total
	 */
	public function calculate($quote_id)
	{
		// Get the basic totals
		$query = $this->db->query("SELECT SUM(item_total) AS quote_total
		FROM fi_quote_item_amounts WHERE item_id IN (SELECT item_id FROM fi_quote_items WHERE quote_id = " . $this->db->escape($quote_id) . ")");

		$quote_amounts = $query->row();

		// Create the database array and insert or update
		$db_array = array(
			'quote_id'		 => $quote_id,
			'quote_total'	 => $quote_amounts->quote_total
		);

		$this->db->where('quote_id', $quote_id);
		if ($this->db->get('fi_quote_amounts')->num_rows())
		{
			// The record already exists; update it
			$this->db->where('quote_id', $quote_id);
			$this->db->update('fi_quote_amounts', $db_array);
		}
		else
		{
			// The record does not yet exist; insert it
			$this->db->insert('fi_quote_amounts', $db_array);
		}
	}

}

?>