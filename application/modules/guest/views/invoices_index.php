<div class="headerbar">

	<h1><?php echo lang('invoices'); ?></h1>

	<div class="pull-right">
		<?php echo pager(site_url('guest/invoices/status/' . $this->uri->segment(4)), 'mdl_invoices'); ?>
	</div>

	<div class="pull-right">
		<ul class="nav nav-pills index-options">
			<li <?php if ($status == 'open') { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/invoices/status/open'); ?>"><?php echo lang('open'); ?></a></li>
			<li <?php if ($status == 'closed') { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/invoices/status/closed'); ?>"><?php echo lang('closed'); ?></a></li>
			<li <?php if ($status == 'overdue') { ?>class="active"<?php } ?>><a href="<?php echo site_url('guest/invoices/status/overdue'); ?>"><?php echo lang('overdue'); ?></a></li>
		</ul>
	</div>

</div>

<div id="filter_results">
    <table class="table table-striped">

        <thead>
            <tr>
                <th><?php echo lang('status'); ?></th>
                <th><?php echo lang('invoice'); ?></th>
                <th><?php echo lang('created'); ?></th>
                <th><?php echo lang('due_date'); ?></th>
                <th><?php echo lang('client_name'); ?></th>
                <th><?php echo lang('amount'); ?></th>
                <th><?php echo lang('balance'); ?></th>
                <th><?php echo lang('options'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($invoices as $invoice) { ?>
            <tr>
                <td>
                    <?php if ($invoice->invoice_status == 'Open') { ?>
                    <span class="label label-success"><?php echo lang('open'); ?></span>
                    <?php } elseif ($invoice->invoice_status == 'Closed') { ?>
                    <span class="label"><?php echo lang('closed'); ?></span>
                    <?php } elseif ($invoice->invoice_status == 'Overdue') { ?>
                    <span class="label label-important"><?php echo lang('overdue'); ?></span> 
                    <?php } else { ?>
                    <span class="label label-info"><?php echo lang('unknown'); ?></span> 
                    <?php } ?>
                </td>
                <td><?php echo $invoice->invoice_number; ?></td>
                <td><?php echo date_from_mysql($invoice->invoice_date_created); ?></td>
                <td><?php echo date_from_mysql($invoice->invoice_date_due); ?></td>
                <td><?php echo $invoice->client_name; ?></td>
                <td><?php echo format_currency($invoice->invoice_total); ?></td>
                <td><?php echo format_currency($invoice->invoice_balance); ?></td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <?php echo lang('options'); ?></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('guest/invoices/view/' . $invoice->invoice_id); ?>">
                                    <i class="icon-eye-open"></i> <?php echo lang('view'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('guest/invoices/generate_pdf/' . $invoice->invoice_id); ?>">
                                    <i class="icon-print"></i> <?php echo lang('open_pdf'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>

    </table>
</div>