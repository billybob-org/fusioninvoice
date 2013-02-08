<div class="headerbar">

	<h1><?php echo lang('quotes'); ?></h1>

	<div class="pull-right">
		<?php echo pager(site_url('guest/quotes/status/' . $this->uri->segment(4)), 'mdl_quotes'); ?>
	</div>

	<div class="pull-right">
		<ul class="nav nav-pills index-options">
			<li <?php if ($this->uri->segment(4) == 'open' or !$this->uri->segment(3)) { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/quotes/status/open'); ?>"><?php echo lang('open'); ?></a></li>
			<li <?php if ($this->uri->segment(4) == 'invoiced') { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/quotes/status/invoiced'); ?>"><?php echo lang('invoiced'); ?></a></li>
			<li <?php if ($this->uri->segment(4) == 'expired') { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/quotes/status/expired'); ?>"><?php echo lang('expired'); ?></a></li>
		</ul>
	</div>

</div>

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
			<td><?php echo anchor('guest/invoices/view/' . $quote->invoice_id, $quote->invoice_number); ?></td>
			<?php } ?>
			<td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
			<td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>
			<td><?php echo $quote->client_name; ?></td>
			<td><?php echo format_currency($quote->quote_total); ?></td>
			<td>
				<div class="options btn-group">
					<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <?php echo lang('options'); ?></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo site_url('guest/quotes/view/' . $quote->quote_id); ?>">
								<i class="icon-eye-open"></i> <?php echo lang('view'); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('guest/quotes/generate_pdf/' . $quote->quote_id); ?>">
								<i class="icon-file"></i> <?php echo lang('open_pdf'); ?>
							</a>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>

</table>