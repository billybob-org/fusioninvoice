<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/bootstrap.min.css">
        
        <style>
            * {
                margin:0px;
                padding:5px;
            }
            body {
                color: #000 !important;
            }
            table {
                width:100%;
            }
            #header table {
                width:100%;
                padding: 0px;
            }
            #header table td {
                vertical-align: text-top;
                padding: 5px;
            }
            #company-name{
                color:#000;
                font-size: 18px;
            }
            #invoice-to {
                /*                display: table;*/
                /*                content: "";*/
            }
            #invoice-to td {
                text-align: left
            }
            .seperator {
                height: 25px
            }
            .top-border {
                border-top: none;
            }
            .no-bottom-border {
                border:none !important;
                background-color: white !important;
            }
            .alignr {
                text-align: right;
            }
        </style>
        
	</head>
	<body>
        <div id="header">
            <table>
                <tr>
                    <td id="company-name">
                        <h2><?php echo $quote->user_name; ?></h2>
                        <p>
                            <?php if ($quote->user_address_1) { echo $quote->user_address_1 . '<br>'; } ?>
                            <?php if ($quote->user_address_2) { echo $quote->user_address_2 . '<br>'; } ?>
                            <?php if ($quote->user_city) { echo $quote->user_city . ' '; } ?>
                            <?php if ($quote->user_state) { echo $quote->user_state . ' '; } ?>
                            <?php if ($quote->user_zip) { echo $quote->user_zip . '<br>'; } ?>
                            <?php if ($quote->user_phone) { ?><abbr>P:</abbr><?php echo $quote->user_phone; ?><br><?php } ?>
                            <?php if ($quote->user_fax) { ?><abbr>F:</abbr><?php echo $quote->user_fax; ?><?php } ?>
                        </p>
                    </td>
                    <td class="alignr"><h2><?php echo lang('quote'); ?> <?php echo $quote->quote_number; ?></h2></td>
                </tr>
            </table>
        </div>
        <div id="invoice-to">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <h2><?php echo $quote->client_name; ?></h2>
                        <p>
                            <?php if ($quote->client_address_1) { echo $quote->client_address_1 . '<br>'; } ?>
                            <?php if ($quote->client_address_2) { echo $quote->client_address_2 . '<br>'; } ?>
                            <?php if ($quote->client_city) { echo $quote->client_city . ' '; } ?>
                            <?php if ($quote->client_state) { echo $quote->client_state . ' '; } ?>
                            <?php if ($quote->client_zip) { echo $quote->client_zip . '<br>'; } ?>
                            <?php if ($quote->client_phone) { ?><abbr>P:</abbr><?php echo $quote->client_phone; ?><br><?php } ?>

                        </p>
                    </td>
                    <td style="width:40%;"></td>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php echo lang('quote_date'); ?></td>
                                    <td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('expires'); ?></td>
                                    <td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('total'); ?></td>
                                    <td><?php echo format_currency($quote->quote_total); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div id="invoice-items">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php echo lang('qty'); ?></th>
                        <th><?php echo lang('item'); ?></th>
                        <th><?php echo lang('description'); ?></th>
                        <th><?php echo lang('price'); ?></th>
                        <th><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <td><?php echo $item->item_quantity; ?></td>
                            <td><?php echo $item->item_name; ?></td>
                            <td><?php echo $item->item_description; ?></td>
                            <td><?php echo format_currency($item->item_price); ?></td>
                            <td><?php echo format_currency($item->item_total); ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td class="no-bottom-border" colspan="3"></td>
                        <td><?php echo lang('total'); ?>:</td>
                        <td><?php echo format_currency($quote->quote_total); ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="seperator"></div>
        </div>
	</body>
</html>