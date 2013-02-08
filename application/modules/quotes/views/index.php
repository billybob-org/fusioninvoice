<div class="headerbar">

	<h1><?php echo lang('quotes'); ?></h1>
	
	<div class="pull-right">
		<a class="create-quote btn btn-primary" href="#"><i class="icon-plus icon-white"></i> <?php echo lang('new'); ?></a>
	</div>

	<div class="pull-right">
		<?php echo pager(site_url('quotes/status/' . $this->uri->segment(3)), 'mdl_quotes'); ?>
	</div>

	<div class="pull-right">
		<ul class="nav nav-pills index-options">
			<li <?php if ($this->uri->segment(3) == 'open' or !$this->uri->segment(3)) { ?>class="active"<?php } ?>><a href="<?php echo site_url('quotes/status/open'); ?>"><?php echo lang('open'); ?></a></li>
			<li <?php if ($this->uri->segment(3) == 'invoiced') { ?>class="active"<?php } ?>><a href="<?php echo site_url('quotes/status/invoiced'); ?>"><?php echo lang('invoiced'); ?></a></li>
			<li <?php if ($this->uri->segment(3) == 'expired') { ?>class="active"<?php } ?>><a href="<?php echo site_url('quotes/status/expired'); ?>"><?php echo lang('expired'); ?></a></li>
		</ul>
	</div>

</div>

<?php $this->layout->load_view('quotes/partial_quote_table', array('quotes' => $quotes)); ?>