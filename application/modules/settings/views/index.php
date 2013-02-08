<form method="post" class="form-horizontal">

	<div class="tabbable tabs-below">

		<div class="tab-content">

			<div id="settings_general" class="tab-pane active">
				<div class="headerbar">
					<h1><?php echo lang('settings') . ' - ' . lang('general'); ?></h1>
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
				<?php $this->layout->load_view('layout/alerts'); ?>
				
				<?php $this->layout->load_view('settings/partial_settings_general'); ?>
			</div>

			<div id="settings_invoices" class="tab-pane">
				<div class="headerbar">
					<h1><?php echo lang('settings') . ' - ' . lang('invoices'); ?></h1>
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
				<?php $this->layout->load_view('layout/alerts'); ?>
				
				<?php $this->layout->load_view('settings/partial_settings_invoices'); ?>
			</div>
			
			<div id="settings_quotes" class="tab-pane">
				<div class="headerbar">
					<h1><?php echo lang('settings') . ' - ' . lang('quotes'); ?></h1>
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
				<?php $this->layout->load_view('layout/alerts'); ?>
				
				<?php $this->layout->load_view('settings/partial_settings_quotes'); ?>
			</div>

			<div id="settings_email" class="tab-pane">
				<div class="headerbar">
					<h1><?php echo lang('settings') . ' - ' . lang('email'); ?></h1>
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
				<?php $this->layout->load_view('layout/alerts'); ?>
				
				<?php $this->layout->load_view('settings/partial_settings_email'); ?>
			</div>
            
			<div id="settings_merchant" class="tab-pane">
				<div class="headerbar">
					<h1><?php echo lang('settings') . ' - ' . lang('merchant_account'); ?></h1>
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
				<?php $this->layout->load_view('layout/alerts'); ?>
				
				<?php $this->layout->load_view('settings/partial_settings_merchant'); ?>
			</div>

		</div>

		<ul class="nav-tabs">
			<li class="active"><a data-toggle="tab" href="#settings_general"><?php echo lang('general'); ?></a></li>
			<li><a data-toggle="tab" href="#settings_invoices"><?php echo lang('invoices'); ?></a></li>
			<li><a data-toggle="tab" href="#settings_quotes"><?php echo lang('quotes'); ?></a></li>
			<li><a data-toggle="tab" href="#settings_email"><?php echo lang('email'); ?></a></li>
            <li><a data-toggle="tab" href="#settings_merchant"><?php echo lang('merchant_account'); ?></a></li>
		</ul>

	</div>
	
</form>