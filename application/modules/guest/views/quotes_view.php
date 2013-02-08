<div class="headerbar">
	<h1><?php echo lang('quote'); ?> #<?php echo $quote->quote_number; ?></h1>
	
	<div class="pull-right">
        <a href="<?php echo site_url('guest/quotes/generate_pdf/' . $quote_id); ?>" class="btn" id="btn_generate_pdf"><i class="icon-print"></i> <?php echo lang('open_pdf'); ?></a>
	</div>

</div>

<?php echo $this->layout->load_view('layout/alerts'); ?>

<div class="content">
	
	<form id="quote_form">

		<div class="quote">

			<div class="cf">

				<div class="pull-left">

					<h2><?php echo $quote->client_name; ?></h2><br>
					<span>
						<?php echo ($quote->client_address_1) ? $quote->client_address_1 . '<br>' : ''; ?>
						<?php echo ($quote->client_address_2) ? $quote->client_address_2 . '<br>' : ''; ?>
						<?php echo ($quote->client_city) ? $quote->client_city : ''; ?>
						<?php echo ($quote->client_state) ? $quote->client_state : ''; ?>
						<?php echo ($quote->client_zip) ? $quote->client_zip : ''; ?>
						<?php echo ($quote->client_country) ? '<br>' . $quote->client_country : ''; ?>
					</span>
					<br><br>
					<?php if ($quote->client_phone) { ?>
					<span><strong><?php echo lang('phone'); ?>:</strong> <?php echo $quote->client_phone; ?></span><br>
					<?php } ?>
					<?php if ($quote->client_email) { ?>
					<span><strong><?php echo lang('email'); ?>:</strong> <?php echo $quote->client_email; ?></span>
					<?php } ?>

				</div>

				<table style="width: auto" class="pull-right table table-striped table-bordered">

					<tbody>
						<tr>
							<td scope="row" style="border-top: none"><strong><?php echo lang('quote'); ?> #</strong></td>
							<td style="border-top: none"><?php echo $quote->quote_number; ?></td>
						</tr>
						<tr>
							<td scope="row"><strong><?php echo lang('date'); ?></strong></td>
							<td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
						</tr>
						<tr>
							<td scope="row"><strong><?php echo lang('expires'); ?></strong></td>
							<td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>
						</tr>
					</tbody>

				</table>

			</div>

            <table id="item_table" class="items table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?php echo lang('item'); ?></th>
                        <th><?php echo lang('description'); ?></th>
                        <th><?php echo lang('quantity'); ?></th>
                        <th><?php echo lang('price'); ?></th>
                        <th><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($items as $item) { ?>
                    <tr class="item">
                        <td><?php echo $item->item_name; ?></td>
                        <td><?php echo $item->item_description; ?></td>
                        <td><?php echo $item->item_quantity; ?></td>
                        <td><?php echo format_currency($item->item_price); ?></td>
                        <td><?php echo format_currency($item->item_total); ?></td>
                    </tr>
                    <?php } ?>

                </tbody>

            </table>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo format_currency($quote->quote_total); ?></td>
                    </tr>
                </tbody>
            </table>

		</div>
		
	</form>

</div>