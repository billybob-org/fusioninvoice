<script type="text/javascript">

    $(function() {
        $('#btn_add_item').click(function() {
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        });

        <?php if (!$items) { ?>
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>

        $('#btn_save_invoice').click(function() {
            var items = [];
            $('table tr.item').each(function() {
                var row = {};
                $(this).find('input,select').each(function() {
                    row[$(this).attr('id')] = $(this).val();
                });
                items.push(row);
            });
            $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                invoice_id: <?php echo $invoice_id; ?>,
                invoice_number: $('#invoice_number').val(),
                invoice_date_created: $('#invoice_date_created').val(),
                invoice_date_due: $('#invoice_date_due').val(),
                items: JSON.stringify(items),
                invoice_terms: $('#invoice_terms').val(),
                custom: $('input[name^=custom]').serializeArray()
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success == '1') {
                    window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
                }
                else {
                    $('.control-group').removeClass('error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().parent().addClass('error');
                    }
                }
            });
        });

        $('#btn_generate_pdf').click(function() {
            window.location = '<?php echo site_url('invoices/generate_pdf/' . $invoice_id); ?>';
        });

    });

</script>

<?php echo $modal_add_payment; ?>
<?php echo $modal_delete_invoice; ?>
<?php echo $modal_add_invoice_tax; ?>

<div class="headerbar">
	<h1><?php echo lang('invoice'); ?> #<?php echo $invoice->invoice_number; ?></h1>

	<div class="pull-right">
		
		<div class="options btn-group pull-left">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="margin-right: 5px;"><i class="icon-cog"></i> <?php echo lang('options'); ?></a>
			<ul class="dropdown-menu">
				<li><a href="#add-invoice-tax" data-toggle="modal"><i class="icon-plus-sign"></i> <?php echo lang('add_invoice_tax'); ?></a></li>
				<li><a href="#enter-payment" data-toggle="modal"><i class="icon-shopping-cart"></i> <?php echo lang('enter_payment'); ?></a></li>
				<li><a href="#" id="btn_generate_pdf" data-invoice-id="<?php echo $invoice_id; ?>"><i class="icon-print"></i> <?php echo lang('open_pdf'); ?></a></li>
				<li><a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>"><i class="icon-envelope"></i> <?php echo lang('send_email'); ?></a></li>
				<li><a href="#" id="btn_copy_invoice" data-invoice-id="<?php echo $invoice_id; ?>"><i class="icon-repeat"></i> <?php echo lang('copy_invoice'); ?></a></li>
				<li><a href="#delete-invoice" data-toggle="modal"><i class="icon-remove"></i> <?php echo lang('delete'); ?></a></li>
			</ul>
		</div>
		
		<a href="#" class="btn" id="btn_add_item" style="margin-right: 5px;"><i class="icon-plus-sign"></i> <?php echo lang('add_item'); ?></a>
		
		<a href="#" class="btn btn-primary" id="btn_save_invoice"><i class="icon-ok icon-white"></i> <?php echo lang('save'); ?></a>
	</div>

</div>

<?php echo $this->layout->load_view('layout/alerts'); ?>

<div class="content">
	
	<form id="invoice_form" class="form-horizontal">

		<div class="invoice">

			<div class="cf">

				<div class="pull-left">

					<h2><?php echo $invoice->client_name; ?></h2><br>
					<span>
						<?php echo ($invoice->client_address_1) ? $invoice->client_address_1 . '<br>' : ''; ?>
						<?php echo ($invoice->client_address_2) ? $invoice->client_address_2 . '<br>' : ''; ?>
						<?php echo ($invoice->client_city) ? $invoice->client_city : ''; ?>
						<?php echo ($invoice->client_state) ? $invoice->client_state : ''; ?>
						<?php echo ($invoice->client_zip) ? $invoice->client_zip : ''; ?>
						<?php echo ($invoice->client_country) ? '<br>' . $invoice->client_country : ''; ?>
					</span>
					<br><br>
					<?php if ($invoice->client_phone) { ?>
					<span><strong><?php echo lang('phone'); ?>:</strong> <?php echo $invoice->client_phone; ?></span><br>
					<?php } ?>
					<?php if ($invoice->client_email) { ?>
					<span><strong><?php echo lang('email'); ?>:</strong> <?php echo $invoice->client_email; ?></span>
					<?php } ?>

				</div>

				<table style="width: auto" class="pull-right table table-striped table-bordered">
                    
                    <tbody>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang('invoice'); ?> #</label>
                                    <div class="controls">
                                        <input type="text" id="invoice_number" class="input-small" value="<?php echo $invoice->invoice_number; ?>" style="margin: 0px;">    
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang('date'); ?></label>
                                    <div class="controls">
                                        <input type="text" id="invoice_date_created" class="input-small" value="<?php echo date_from_mysql($invoice->invoice_date_created); ?>" style="margin: 0px;">    
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang('due_date'); ?></label>
                                    <div class="controls">
                                        <input type="text" id="invoice_date_due" class="input-small" value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>" style="margin: 0px;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>

				</table>

			</div>

			<?php $this->layout->load_view('invoices/partial_item_table'); ?>
			
			<p><strong><?php echo lang('invoice_terms'); ?></strong></p>
			<textarea id="invoice_terms" name="invoice_terms" style="width: 100%;"><?php echo $invoice->invoice_terms; ?></textarea>
            
            <br><br>
            
            <?php foreach ($custom_fields as $custom_field) { ?>
            <p><strong><?php echo $custom_field->custom_field_label; ?></strong></p>
                    <input type="text" name="custom[<?php echo $custom_field->custom_field_column; ?>]" id="<?php echo $custom_field->custom_field_column; ?>" value="<?php echo $this->mdl_invoices->form_value('custom[' . $custom_field->custom_field_column . ']'); ?>">
            <?php } ?>

            <p class="padded"><?php echo lang('guest_url'); ?>: <?php echo auto_link(site_url('guest/view/invoice/' . $invoice->invoice_url_key)); ?></p>
            
		</div>
		
	</form>

</div>