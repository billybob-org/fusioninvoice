<script type="text/javascript">
$(function() {
	$('#smtp_password').val('');
});
</script>

<div class="content">

	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_server_address'); ?>: </label>
		<div class="controls">
			<input type="text" name="settings[smtp_server_address]" value="<?php echo $this->mdl_settings->setting('smtp_server_address'); ?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_requires_authentication'); ?>: </label>
		<div class="controls">
			<select name="settings[smtp_authentication]" >
				<option value="0" <?php if (!$this->mdl_settings->setting('smtp_authentication')) { ?>selected="selected"<?php } ?>><?php echo lang('no'); ?></option>
				<option value="1" <?php if ($this->mdl_settings->setting('smtp_authentication')) { ?>selected="selected"<?php } ?>><?php echo lang('yes'); ?></option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_username'); ?>: </label>
		<div class="controls">
			<input type="text" name="settings[smtp_username]" value="<?php echo $this->mdl_settings->setting('smtp_username'); ?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_password'); ?>: </label>
		<div class="controls">
			<input type="password" id="smtp_password" name="settings[smtp_password]">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_port'); ?>: </label>
		<div class="controls">
			<input type="text" name="settings[smtp_port]" value="<?php echo $this->mdl_settings->setting('smtp_port'); ?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('smtp_security'); ?>: </label>
		<div class="controls">
			<select name="settings[smtp_security]">
				<option value="" <?php if (!$this->mdl_settings->setting('smtp_security')) { ?>selected="selected"<?php } ?>><?php echo lang('none'); ?></option>
				<option value="ssl" <?php if ($this->mdl_settings->setting('smtp_security') == 'ssl') { ?>selected="selected"<?php } ?>><?php echo lang('smtp_ssl'); ?></option>
				<option value="tls" <?php if ($this->mdl_settings->setting('smtp_security') == 'tls') { ?>selected="selected"<?php } ?>><?php echo lang('smtp_tls'); ?></option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo lang('default_email_template'); ?>: </label>
		<div class="controls">
			<select name="settings[default_email_template]">
                <option value=""></option>
                <?php foreach ($email_templates as $email_template) { ?>
                <option value="<?php echo $email_template->email_template_id; ?>" <?php if ($this->mdl_settings->setting('default_email_template') == $email_template->email_template_id) { ?>selected="selected"<?php } ?>><?php echo $email_template->email_template_title; ?></option>
                <?php } ?>
			</select>
		</div>
	</div>
	
</div>