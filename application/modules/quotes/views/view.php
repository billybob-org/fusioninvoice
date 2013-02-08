<script type="text/javascript">

	$(function()
	{
		$('#btn_add_item').click(function() {
			$('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
		});
		
		<?php if (!$items) { ?>
			$('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();			
		<?php } ?>
		
		$('#btn_save_quote').click(function() {
			var items = [];      
			$('table tr.item').each(function(){
				var row = {};
				$(this).find('input,select').each(function(){
					row[$(this).attr('id')] = $(this).val();
				});
				items.push(row);
			});
			$.post("<?php echo site_url('quotes/ajax/save'); ?>", { 
                quote_id: <?php echo $quote_id; ?>, 
                items: JSON.stringify(items),
                custom: $('input[name^=custom]').serializeArray()
            }, function(data) {
				window.location = "<?php echo site_url('quotes/view'); ?>/" + <?php echo $quote_id; ?>;
			});
		});

	});
	
</script>

<?php echo $modal_delete_quote; ?>

<div class="headerbar">
	<h1><?php echo lang('quote'); ?> #<?php echo $quote->quote_number; ?></h1>
	
	<div class="pull-right">
		
		<div class="options btn-group pull-left">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="margin-right: 5px;"><i class="icon-cog"></i> <?php echo lang('options'); ?></a>
			<ul class="dropdown-menu">
                <li><a href="<?php echo site_url('quotes/generate_pdf/' . $quote->quote_id); ?>"><i class="icon-print"></i> <?php echo lang('open_pdf'); ?></a></li>
				<li><a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>"><i class="icon-envelope"></i> <?php echo lang('send_email'); ?></a></li>                
				<li><a href="#" id="btn_quote_to_invoice" data-quote-id="<?php echo $quote_id; ?>"><i class="icon-repeat"></i> <?php echo lang('quote_to_invoice'); ?></a></li>
				<li><a href="#delete-quote" data-toggle="modal"><i class="icon-remove"></i> <?php echo lang('delete'); ?></a></li>
			</ul>
		</div>
		
		<a href="#" class="btn" id="btn_add_item" style="margin-right: 5px;"><i class="icon-plus-sign"></i> <?php echo lang('add_item'); ?></a>
		<a href="#" class="btn btn-primary" id="btn_save_quote"><i class="icon-ok icon-white"></i> <?php echo lang('save'); ?></a>
	</div>

</div>

<?php echo $this->layout->load_view('layout/alerts'); ?>

<div class="content">
	
	<form id="quote_form">

		<div class="quote">

			<div class="cf">

				<div class="pull-left">

					<h2><?php echo $quote->client_name; ?></h2><br>
					<span>
						<?php echo ($quote->client_address_1) ? $quote->client_address_1 . '<br>' : ''; ?>
						<?php echo ($quote->client_address_2) ? $quote->client_address_2 . '<br>' : ''; ?>
						<?php echo ($quote->client_city) ? $quote->client_city : ''; ?>
						<?php echo ($quote->client_state) ? $quote->client_state : ''; ?>
						<?php echo ($quote->client_zip) ? $quote->client_zip : ''; ?>
						<?php echo ($quote->client_country) ? '<br>' . $quote->client_country : ''; ?>
					</span>
					<br><br>
					<?php if ($quote->client_phone) { ?>
					<span><strong><?php echo lang('phone'); ?>:</strong> <?php echo $quote->client_phone; ?></span><br>
					<?php } ?>
					<?php if ($quote->client_email) { ?>
					<span><strong><?php echo lang('email'); ?>:</strong> <?php echo $quote->client_email; ?></span>
					<?php } ?>

				</div>

				<table style="width: auto" class="pull-right table table-striped table-bordered">

					<tbody>
						<tr>
							<td scope="row" style="border-top: none"><strong><?php echo lang('quote'); ?> #</strong></td>
							<td style="border-top: none"><?php echo $quote->quote_number; ?></td>
						</tr>
						<tr>
							<td scope="row"><strong><?php echo lang('date'); ?></strong></td>
							<td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
						</tr>
						<tr>
							<td scope="row"><strong><?php echo lang('expires'); ?></strong></td>
							<td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>
						</tr>
					</tbody>

				</table>

			</div>

			<?php $this->layout->load_view('quotes/partial_item_table'); ?>
            
            <br><br>
            
            <?php foreach ($custom_fields as $custom_field) { ?>
            <p><strong><?php echo $custom_field->custom_field_label; ?></strong></p>
                    <input type="text" name="custom[<?php echo $custom_field->custom_field_column; ?>]" id="<?php echo $custom_field->custom_field_column; ?>" value="<?php echo $this->mdl_quotes->form_value('custom[' . $custom_field->custom_field_column . ']'); ?>">
            <?php } ?>

            <p class="padded"><?php echo lang('guest_url'); ?>: <?php echo auto_link(site_url('guest/view/quote/' . $quote->quote_url_key)); ?></p>
            
		</div>
		
	</form>

</div>