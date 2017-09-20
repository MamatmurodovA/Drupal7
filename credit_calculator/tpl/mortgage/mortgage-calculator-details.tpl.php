<form action="<?php print url('mortgage/credit/'.arg(2).'/calculate');?>">
  	<div>
	  <label><?php print t('You chose'); ?></label>
	  <span><?php print $mortgage->title; ?></span>
	</div>
	<div>
	  <label class="credit-label">Сумма кредита​:</label>
	  <input type="text" id="credit_sum" class="form-control" name="credit_sum" data-first-payment="<?php print $mortgage->field_first_payment['und'][0]['value']; ?>"/>
	</div>
	<div>
		Процентная ставка по кредиту <?php print $mortgage->field_percent['und'][0]['value']; ?>% годовых
	</div>
  	<div>
	  Срок предоставления кредита - <?php print $mortgage->field_limitation['und'][0]['value']; ?>&nbsp;<?php print t('months period');?>
	</div>
  	<div>
	  Первоначальный взнос -
	  <span class="credit_first_payment">
		0
	  </span> сум
	</div>
  	<button class="btn btn-default">
	  Рассчитать
	</button>
</form>
<script>
  $('#credit_sum').keyup(function(){
	var value = this.value;
	var percent_first_payment = $(this).data('first-payment');
	var first_payment = value * percent_first_payment / 100;
	$('.credit_first_payment').text(first_payment);
  })
</script>
