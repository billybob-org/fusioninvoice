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

function format_currency($amount)
{
	global $CI;
	$currency_symbol = $CI->mdl_settings->setting('currency_symbol');
	$currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement');
	
	if ($currency_symbol_placement == 'before')
	{
		return $currency_symbol . number_format($amount, 2);
	}
	else
	{
		return number_format($amount, 2) . $currency_symbol;
	}
}

?>