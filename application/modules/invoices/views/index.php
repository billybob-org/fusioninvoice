<div class="headerbar">

	<h1><?php echo lang('invoices'); ?></h1>
	
	<div class="pull-right">
		<a class="create-invoice btn btn-primary" href="#"><i class="icon-plus icon-white"></i> <?php echo lang('new'); ?></a>
	</div>

	<div class="pull-right">
		<?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
	</div>

	<div class="pull-right">
		<ul class="nav nav-pills index-options">
			<li <?php if ($status == 'open') { ?>class="active"<?php } ?>><a href="<?php echo site_url('invoices/status/open'); ?>"><?php echo lang('open'); ?></a></li>
			<li <?php if ($status == 'closed') { ?>class="active"<?php } ?>><a href="<?php echo site_url('invoices/status/closed'); ?>"><?php echo lang('closed'); ?></a></li>
			<li <?php if ($status == 'overdue') { ?>class="active"<?php } ?>><a href="<?php echo site_url('invoices/status/overdue'); ?>"><?php echo lang('overdue'); ?></a></li>
		</ul>
	</div>

</div>

<div id="filter_results">
<?php $this->layout->load_view('invoices/partial_invoice_table', array('invoices' => $invoices)); ?>
</div>