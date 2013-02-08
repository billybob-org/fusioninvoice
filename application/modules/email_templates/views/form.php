<form method="post" class="form-horizontal">

	<div class="headerbar">
		<h1><?php echo lang('email_template_form'); ?></h1>
		<?php $this->layout->load_view('layout/header_buttons'); ?>
	</div>

	<div class="content">

		<?php $this->layout->load_view('layout/alerts'); ?>

			<div class="control-group">
				<label class="control-label"><?php echo lang('title'); ?>: </label>
				<div class="controls">
					<input type="text" name="email_template_title" id="email_template_title" value="<?php echo $this->mdl_email_templates->form_value('email_template_title'); ?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('body'); ?>: </label>
				<div class="controls">
					<textarea name="email_template_body" style="width: 450px; height: 200px;"><?php echo $this->mdl_email_templates->form_value('email_template_body'); ?></textarea>
				</div>
			</div>

	</div>

</form>