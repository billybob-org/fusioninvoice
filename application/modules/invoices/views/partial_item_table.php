<table id="item_table" class="items table table-striped table-bordered">
	<thead>
		<tr>
			<th><?php echo lang('item'); ?></th>
			<th><?php echo lang('description'); ?></th>
			<th style="width: 100px;"><?php echo lang('quantity'); ?></th>
			<th style="width: 100px;"><?php echo lang('price'); ?></th>
			<th><?php echo lang('tax_rate'); ?></th>
			<th><?php echo lang('subtotal'); ?></th>
			<th><?php echo lang('tax'); ?></th>
			<th><?php echo lang('total'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
		<tr id="new_item" style="display: none;">
			<td>
				<input type="hidden" id="invoice_id" value="<?php echo $invoice_id; ?>">
				<input type="hidden" id="item_id" value="">
				<input type="text" id="item_name" class="input-small" value="">
			</td>
			<td><input type="text" class="input-small" id="item_description" value=""></td>
			<td><input type="text" class="input-mini" id="item_quantity" value=""></td>
			<td><input type="text" class="input-mini" id="item_price" value=""></td>
			<td>
				<select name="item_tax_rate_id" id="item_tax_rate_id" class="input-small">
					<option value="0"><?php echo lang('none'); ?></option>
					<?php foreach ($tax_rates as $tax_rate) { ?>
					<option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php if ($tax_rate->tax_rate_id == $this->mdl_settings->setting('default_item_tax_rate')) { ?>selected="selected"<?php } ?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?></option>
					<?php } ?>
				</select>
			</td>
			<td colspan="4"></td>
		</tr>
		
		<?php foreach ($items as $item) { ?>
		<tr class="item">
			<td>
				<input type="hidden" id="invoice_id" value="<?php echo $invoice_id; ?>">
				<input type="hidden" id="item_id" value="<?php echo $item->item_id; ?>">
				<input type="text" id="item_name" style="width: 90%;" value="<?php echo $item->item_name; ?>">
			</td>
			<td><input type="text" id="item_description" style="width: 90%;" value="<?php echo $item->item_description; ?>"></td>
			<td><input type="text" id="item_quantity" style="width: 90%;" value="<?php echo $item->item_quantity; ?>"></td>
			<td><input type="text" id="item_price" style="width: 90%;" value="<?php echo $item->item_price; ?>"></td>
			<td>
				<select name="item_tax_rate_id" id="item_tax_rate_id" style="width: 90%;">
					<option value="0"><?php echo lang('none'); ?></option>
					<?php foreach ($tax_rates as $tax_rate) { ?>
					<option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php if ($item->item_tax_rate_id == $tax_rate->tax_rate_id) { ?>selected="selected"<?php } ?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?></option>
					<?php } ?>
				</select>
			</td>
			<td><?php echo format_currency($item->item_subtotal); ?></td>
			<td><?php echo format_currency($item->item_tax_total); ?></td>
			<td><?php echo format_currency($item->item_total); ?></td>
			<td>
				<a class="" href="<?php echo site_url('invoices/delete_item/' . $invoice->invoice_id . '/' . $item->item_id); ?>">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
		<?php } ?>
		
	</tbody>

</table>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th><?php echo lang('subtotal'); ?></th>
			<th><?php echo lang('item_tax'); ?></th>
			<th><?php echo lang('invoice_tax'); ?></th>
			<th><?php echo lang('total'); ?></th>
			<th><?php echo lang('paid'); ?></th>
			<th><?php echo lang('balance'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
			<td><?php echo format_currency($invoice->invoice_item_tax_total); ?></td>
			<td>
				<?php if ($invoice_tax_rates) { foreach ($invoice_tax_rates as $invoice_tax_rate) { ?>
					<strong><?php echo anchor('invoices/delete_invoice_tax/' . $invoice->invoice_id . '/' . $invoice_tax_rate->invoice_tax_rate_id, lang('remove')) . ' ' . $invoice_tax_rate->invoice_tax_rate_name . ' ' . $invoice_tax_rate->invoice_tax_rate_percent; ?>%:</strong>				
					<?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?><br>
				<?php } } else { echo format_currency('0'); }?>
			</td>
			<td><?php echo format_currency($invoice->invoice_total); ?></td>
			<td><?php echo format_currency($invoice->invoice_paid); ?></td>
			<td><?php echo format_currency($invoice->invoice_balance); ?></td>
		</tr>
	</tbody>
</table>