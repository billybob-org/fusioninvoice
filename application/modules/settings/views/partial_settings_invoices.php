<div class="content">
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('invoices_due_after'); ?>: </label>
		<div class="controls">
			<input type="text" name="settings[invoices_due_after]" class="input-small" value="<?php echo $this->mdl_settings->setting('invoices_due_after'); ?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_invoice_group'); ?>: </label>
		<div class="controls">
			<select name="settings[default_invoice_group]">
				<option value=""></option>
				<?php foreach ($invoice_groups as $invoice_group) { ?>
				<option value="<?php echo $invoice_group->invoice_group_id; ?>" <?php if ($this->mdl_settings->setting('default_invoice_group') == $invoice_group->invoice_group_id) { ?>selected="selected"<?php } ?>><?php echo $invoice_group->invoice_group_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_invoice_template'); ?>: </label>
		<div class="controls">
			<select name="settings[default_invoice_template]">
				<option value=""></option>
				<?php foreach ($invoice_templates as $invoice_template) { ?>
				<option value="<?php echo $invoice_template; ?>" <?php if ($this->mdl_settings->setting('default_invoice_template') == $invoice_template) { ?>selected="selected"<?php } ?>><?php echo $invoice_template; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_invoice_tax_rate'); ?>: </label>
		<div class="controls">
			<select name="settings[default_invoice_tax_rate]">
				<option value=""><?php echo lang('none'); ?></option>
				<?php foreach ($tax_rates as $tax_rate) { ?>
				<option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php if ($this->mdl_settings->setting('default_invoice_tax_rate') == $tax_rate->tax_rate_id) { ?>selected="selected"<?php } ?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_invoice_tax_rate_placement'); ?>: </label>
		<div class="controls">
			<select name="settings[default_include_item_tax]">
				<option value=""><?php echo lang('none'); ?></option>
				<option value="0" <?php if ($this->mdl_settings->setting('default_include_item_tax') === '0') { ?>selected="selected"<?php } ?>><?php echo lang('apply_before_item_tax'); ?></option>
				<option value="1" <?php if ($this->mdl_settings->setting('default_include_item_tax') === '1') { ?>selected="selected"<?php } ?>><?php echo lang('apply_after_item_tax'); ?></option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_item_tax_rate'); ?>: </label>
		<div class="controls">
			<select name="settings[default_item_tax_rate]">
				<option value=""><?php echo lang('none'); ?></option>
				<?php foreach ($tax_rates as $tax_rate) { ?>
				<option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php if ($this->mdl_settings->setting('default_item_tax_rate') == $tax_rate->tax_rate_id) { ?>selected="selected"<?php } ?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_terms'); ?>: </label>
		<div class="controls">
			<textarea name="settings[default_invoice_terms]" style="width: 400px; height: 150px;"><?php echo $this->mdl_settings->setting('default_invoice_terms'); ?></textarea>
		</div>
	</div>

</div>