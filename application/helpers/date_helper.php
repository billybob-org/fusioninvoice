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

function date_formats()
{
    return array(
        'm/d/Y' => array(
            'setting'    => 'm/d/Y',
            'datepicker' => 'mm/dd/yyyy'
        ),
        'm-d-Y' => array(
            'setting'    => 'm-d-Y',
            'datepicker' => 'mm-dd-yyyy'
        ),
        'm.d.Y' => array(
            'setting'    => 'm.d.Y',
            'datepicker' => 'mm.dd.yyyy'
        ),
        'Y/m/d' => array(
            'setting'    => 'Y/m/d',
            'datepicker' => 'yyyy/mm/dd'
        ),
        'Y-m-d' => array(
            'setting'    => 'Y-m-d',
            'datepicker' => 'yyyy-mm-dd'
        ),
        'Y.m.d' => array(
            'setting'    => 'Y.m.d',
            'datepicker' => 'yyyy.mm.dd'
        ),
        'd/m/Y' => array(
            'setting'    => 'd/m/Y',
            'datepicker' => 'dd/mm/yyyy'
        ),
        'd-m-Y' => array(
            'setting'    => 'd-m-Y',
            'datepicker' => 'dd-mm-yyyy'
        ),
        'd.m.Y' => array(
            'setting'    => 'd.m.Y',
            'datepicker' => 'dd.mm.yyyy'
        )
    );
}

function date_from_mysql($date, $ignore_post_check = FALSE)
{
    if (!$_POST or $ignore_post_check)
    {
        $CI = & get_instance();

        $date = DateTime::createFromFormat('Y-m-d', $date);
        return $date->format($CI->mdl_settings->setting('date_format'));
    }
    return $date;
}

function date_to_mysql($date)
{
    $CI = & get_instance();

    $date = DateTime::createFromFormat($CI->mdl_settings->setting('date_format'), $date);
    return $date->format('Y-m-d');
}

function date_format_setting()
{
    $CI = & get_instance();

    $date_format = $CI->mdl_settings->setting('date_format');

    $date_formats = date_formats();

    return $date_formats[$date_format]['setting'];
}

function date_format_datepicker()
{
    $CI = & get_instance();

    $date_format = $CI->mdl_settings->setting('date_format');

    $date_formats = date_formats();

    return $date_formats[$date_format]['datepicker'];
}

?>