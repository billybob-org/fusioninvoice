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

class Mdl_Quote_Item_Amounts extends CI_Model {
	
	public function calculate($item_id)
	{
		$this->load->model('quotes/mdl_quote_items');
		$item = $this->mdl_quote_items->get_by_id($item_id);
		
		$item_total = $item->item_quantity * $item->item_price;
		
		$db_array = array(
			'item_id' => $item_id,
			'item_total' => $item_total
		);
		
		$this->db->where('item_id', $item_id);
		if ($this->db->get('fi_quote_item_amounts')->num_rows())
		{
			$this->db->where('item_id', $item_id);
			$this->db->update('fi_quote_item_amounts', $db_array);
		}
		else
		{
			$this->db->insert('fi_quote_item_amounts', $db_array);
		}
	}
	
}

?>