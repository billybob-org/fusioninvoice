<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FusionInvoice</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link href="<?php echo base_url(); ?>assets/default/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/default/css/style.css" rel="stylesheet">
		<style>
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>

		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>

	<body>

	<div id="login">

		<h1><?php echo lang('login'); ?></h1>

<!--		<div class="alert alert-error">
		  <a class="close" data-dismiss="alert" href="#">&times;</a>
		  Wrong Password. Please try again.
		</div>-->
		
		<form class="form-horizontal" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

			<div class="control-group">
				<label class="control-label"><?php echo lang('email'); ?></label>
				<div class="controls">
					<input type="text" name="email" id="email" placeholder="Email">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('password'); ?></label>
				<div class="controls">
					<input type="password" name="password" id="password"  placeholder="Password">
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" name="btn_login" value="<?php echo lang('login'); ?>" class="btn btn-primary">
				</div>
			</div>

		</form>

	</div><!--end.container-->

	</body>
</html>