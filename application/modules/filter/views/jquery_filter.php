<script type="text/javascript">

	$(function() {
		
		$('#filter').keyup(function() {
			
			$.post('<?php echo site_url('filter/ajax/' . $filter_method); ?>', 
			{
				filter_query: $('#filter').val()
			}, function(data) 
			{
				$('#filter_results').html(data);
			});
			
		});
		
	});

</script>