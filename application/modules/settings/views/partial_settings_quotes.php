<div class="content">

	<div class="control-group">
		<label class="control-label"><?php echo lang('quotes_expire_after'); ?>: </label>
		<div class="controls">
			<input type="text" name="settings[quotes_expire_after]" class="input-small" value="<?php echo $this->mdl_settings->setting('quotes_expire_after'); ?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('default_quote_group'); ?>: </label>
		<div class="controls">
			<select name="settings[default_quote_group]">
				<option value=""></option>
				<?php foreach ($invoice_groups as $invoice_group) { ?>
				<option value="<?php echo $invoice_group->invoice_group_id; ?>" <?php if ($this->mdl_settings->setting('default_quote_group') == $invoice_group->invoice_group_id) { ?>selected="selected"<?php } ?>><?php echo $invoice_group->invoice_group_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_quote_template'); ?>: </label>
		<div class="controls">
			<select name="settings[default_quote_template]">
				<option value=""></option>
				<?php foreach ($quote_templates as $quote_template) { ?>
				<option value="<?php echo $quote_template; ?>" <?php if ($this->mdl_settings->setting('default_quote_template') == $quote_template) { ?>selected="selected"<?php } ?>><?php echo $quote_template; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

</div>