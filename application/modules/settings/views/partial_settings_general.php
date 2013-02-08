<div class="content">

	<div class="control-group">
		<label class="control-label"><?php echo lang('language'); ?>: </label>
		<div class="controls">
			<select name="settings[default_language]">
				<?php foreach ($languages as $language) { ?>
				<option value="<?php echo $language; ?>" <?php if ($this->mdl_settings->setting('default_language') == $language) { ?>selected="selected"<?php } ?>><?php echo ucfirst($language); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
    
	<div class="control-group">
		<label class="control-label"><?php echo lang('date_format'); ?>: </label>
		<div class="controls">
			<select name="settings[date_format]">
				<?php foreach ($date_formats as $date_format) { ?>
				<option value="<?php echo $date_format['setting']; ?>" <?php if ($this->mdl_settings->setting('date_format') == $date_format['setting']) { ?>selected="selected"<?php } ?>><?php echo $current_date->format($date_format['setting']); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('currency_symbol'); ?>: </label>
		<div class="controls" style="text: bottom;">
			<input type="text" name="settings[currency_symbol]" class="input-small" value="<?php echo $this->mdl_settings->setting('currency_symbol'); ?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('currency_symbol_placement'); ?>: </label>
		<div class="controls">
			<select name="settings[currency_symbol_placement]">
				<option value="before" <?php if ($this->mdl_settings->setting('currency_symbol_placement') == 'before') { ?>selected="selected"<?php } ?>><?php echo lang('before_amount'); ?></option>
				<option value="after" <?php if ($this->mdl_settings->setting('currency_symbol_placement') == 'after') { ?>selected="selected"<?php } ?>><?php echo lang('after_amount'); ?></option>
			</select>
		</div>
	</div>

</div>