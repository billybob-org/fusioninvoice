<table id="item_table" class="items table table-striped table-bordered">
	<thead>
		<tr>
			<th><?php echo lang('item'); ?></th>
			<th><?php echo lang('description'); ?></th>
			<th style="width: 100px;"><?php echo lang('quantity'); ?></th>
			<th style="width: 100px;"><?php echo lang('price'); ?></th>
			<th><?php echo lang('total'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
		<tr id="new_item" style="display: none;">
			<td>
				<input type="hidden" id="quote_id" value="<?php echo $quote_id; ?>">
				<input type="hidden" id="item_id" value="">
				<input type="text" id="item_name" class="input-small" value="">
			</td>
			<td><input type="text" class="input-small" id="item_description" value=""></td>
			<td><input type="text" class="input-mini" id="item_quantity" value=""></td>
			<td><input type="text" class="input-mini" id="item_price" value=""></td>
			<td colspan="2"></td>
		</tr>
		
		<?php foreach ($items as $item) { ?>
		<tr class="item">
			<td>
				<input type="hidden" id="quote_id" value="<?php echo $quote_id; ?>">
				<input type="hidden" id="item_id" value="<?php echo $item->item_id; ?>">
				<input type="text" id="item_name" style="width: 90%;" value="<?php echo $item->item_name; ?>">
			</td>
			<td><input type="text" id="item_description" style="width: 90%;" value="<?php echo $item->item_description; ?>"></td>
			<td><input type="text" id="item_quantity" style="width: 90%;" value="<?php echo $item->item_quantity; ?>"></td>
			<td><input type="text" id="item_price" style="width: 90%;" value="<?php echo $item->item_price; ?>"></td>
			<td><?php echo format_currency($item->item_total); ?></td>
			<td>
				<a class="" href="<?php echo site_url('quotes/delete_item/' . $quote->quote_id . '/' . $item->item_id); ?>">
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
			<th><?php echo lang('total'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo format_currency($quote->quote_total); ?></td>
		</tr>
	</tbody>
</table>