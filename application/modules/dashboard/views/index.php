<div class="headerbar">
	<h1><?php echo lang('dashboard'); ?></h1>
</div>

<?php echo $this->layout->load_view('layout/alerts'); ?>

<div class="content">
	<div class="container-fluid">

		<div class="row-fluid">

			<div class="span6">
				
				<div id="current_activity" class="widget">

					<div class="widget-title">
						<h5><i class="icon-book"></i> <?php echo lang('current_activity'); ?></h5>
					</div>

					<table class="table table-striped no-margin">
						<thead>
							<tr>
								<th><?php echo lang('period'); ?></th>
								<th style="text-align: right;"><?php echo lang('invoiced'); ?></th>
								<th style="text-align: right;"><?php echo lang('paid'); ?></th>
								<th style="text-align: right;"><?php echo lang('unpaid'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo lang('this_month'); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_invoiced_month); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_paid_month); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_balance_month); ?></td>
							</tr>
							<tr>
								<td><?php echo lang('last_month'); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_invoiced_last_month); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_paid_last_month); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_balance_last_month); ?></td>
							</tr>
							<tr>
								<td><?php echo lang('this_year'); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_invoiced_year); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_paid_year); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_balance_year); ?></td>
							</tr>
							<tr>
								<td><?php echo lang('last_year'); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_invoiced_last_year); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_paid_last_year); ?></td>
								<td style="text-align: right;"><?php echo format_currency($total_balance_last_year); ?></td>
							</tr>
						</tbody>
					</table>

				</div>

				<div id="open_invoices" class="widget">

					<div class="widget-title">
						<h5><i class="icon-file"></i> <?php echo lang('open_invoices'); ?></h5>
					</div>

					<table class="table table-striped no-margin">
						<thead>
							<tr>
								<th><?php echo lang('due_date'); ?></th>
								<th><?php echo lang('invoice'); ?></th>
								<th><?php echo lang('client'); ?></th>
								<th><?php echo lang('amount'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($open_invoices as $open_invoice) { ?>
							<tr>
								<td><?php echo date_from_mysql($open_invoice->invoice_date_created); ?></td>
								<td><?php echo anchor('invoices/view/' . $open_invoice->invoice_id, $open_invoice->invoice_number); ?></td>
								<td><?php echo $open_invoice->client_name; ?></td>
								<td><?php echo format_currency($open_invoice->invoice_total); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>

				</div>
				
				<div id="overdue_invoices" class="widget">

					<div class="widget-title">
						<h5><i class="icon-file"></i> <?php echo lang('overdue_invoices'); ?></h5>
					</div>

					<table class="table table-striped no-margin">
						<thead>
							<tr>
								<th><?php echo lang('due_date'); ?></th>
								<th><?php echo lang('invoice'); ?></th>
								<th><?php echo lang('client'); ?></th>
								<th><?php echo lang('amount'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($overdue_invoices as $overdue_invoice) { ?>
							<tr>
								<td><?php echo date_from_mysql($overdue_invoice->invoice_date_created); ?></td>
								<td><?php echo anchor('invoices/view/' . $overdue_invoice->invoice_id, $overdue_invoice->invoice_number); ?></td>
								<td><?php echo $overdue_invoice->client_name; ?></td>
								<td><?php echo format_currency($overdue_invoice->invoice_total); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>

				</div>

			</div>

			<div class="span6">
				
				<div id="recent_clients" class="widget">

					<div class="widget-title">
						<h5><i class="icon-user"></i> <?php echo lang('recent_clients'); ?></h5>
					</div>

					<table class="table table-striped no-margin">
						<thead>
							<tr>
								<th><?php echo lang('name'); ?></th>
								<th><?php echo lang('phone'); ?></th>
								<th><?php echo lang('email'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($recent_clients as $recent_client) { ?>
							<tr>
								<td><?php echo anchor('clients/view/' . $recent_client->client_id, $recent_client->client_name); ?></td>
								<td><?php echo $recent_client->client_phone; ?></td>
								<td><?php echo auto_link($recent_client->client_email); ?></td>
							</tr>
							<?php } ?>
						</tbody>

					</table>
				</div>
				
				<div id="recent_payments" class="widget">

					<div class="widget-title">
						<h5><i class="icon-ok"></i> <?php echo lang('recent_payments'); ?></h5>
					</div>

					<table class="table table-striped no-margin">
						<thead>
							<tr>
								<th><?php echo lang('date'); ?></th>
								<th><?php echo lang('invoice'); ?></th>
								<th><?php echo lang('client'); ?></th>
								<th><?php echo lang('amount'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($recent_payments as $recent_payment) { ?>
							<tr>
								<td><?php echo date_from_mysql($recent_payment->payment_date); ?></td>
								<td><?php echo anchor('invoices/view/' . $recent_payment->invoice_id, $recent_payment->invoice_number); ?></td>
								<td><?php echo $recent_payment->client_name; ?></td>
								<td><?php echo format_currency($recent_payment->payment_amount); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					
				</div>

			</div>

		</div>

	</div>
</div>