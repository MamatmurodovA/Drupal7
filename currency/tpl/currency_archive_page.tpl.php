<div class="currency_rate_block">
	<?php $currency_rate = module_invoke('currency', 'block_view', 'currency_rate_block'); ?>
	<?php print render($currency_rate['content']); ?>
    
<div id="datepicker"></div>
</div>

<script>
	$( "#datepicker" ).datepicker({
		onSelect: function (date) {
			document.location = "<?php print url('currency/archive');?>" + '/' + date;
		},
		dateFormat: "yy-mm-dd"
	});
</script>
