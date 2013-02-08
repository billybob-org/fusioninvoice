<table class="table table-striped">

	<thead>
		<tr>
			<th><?php echo lang('quote'); ?></th>
			<?php if (isset($show_invoice_column)) { ?>
			<th><?php echo lang('invoice'); ?></th>
			<?php } ?>
			<th><?php echo lang('created'); ?></th>
			<th><?php echo lang('expires'); ?></th>
			<th><?php echo lang('client_name'); ?></th>
			<th><?php echo lang('amount'); ?></th>
			<th><?php echo lang('options'); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($quotes as $quote) { ?>
		<tr>
			<td><?php echo $quote->quote_number; ?></td>
			<?php if (isset($show_invoice_column)) { ?>
			<td><?php echo anchor('invoices/view/' . $quote->invoice_id, $quote->invoice_number); ?></td>
			<?php } ?>
			<td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
			<td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>
			<td><a href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"><?php echo $quote->client_name; ?></a></td>
			<td><?php echo format_currency($quote->quote_total); ?></td>
			<td>
				<div class="options btn-group">
					<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <?php echo lang('options'); ?></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>">
								<i class="icon-pencil"></i> <?php echo lang('edit'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('quotes/generate_pdf/' . $quote->quote_id); ?>">
								<i class="icon-print"></i> <?php echo lang('open_pdf'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>">
								<i class="icon-envelope"></i> <?php echo lang('send_email'); ?>
							</a>
						</li>
						<li>
							<a href="#" id="btn_quote_to_invoice" data-quote-id="<?php echo $quote->quote_id; ?>">
								<i class="icon-repeat"></i> <?php echo lang('quote_to_invoice'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('quotes/delete/' . $quote->quote_id); ?>" onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
								<i class="icon-trash"></i> <?php echo lang('delete'); ?>
							</a>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>

</table>