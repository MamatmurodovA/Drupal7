<table class="table table-bordered">
  <thead>
  	<tr>
	  <th>
		№
	  </th>
	  <th>
		Приблизительная дата выплат
	  </th>
	  <th>
		Сумма кредита
	  </th>
	  <th>
		Основной долг
	  </th>
	  <th>
		Процентные выплаты
	  </th>
	  <th>
		Всего выплат
	  </th>
	</tr>
  </thead>
  <tbody>
  		<?php if($mortgage->field_young_family['und'][0]['value'] == 0): ?>
		  <?php for($month = 1; $month <= $mortgage->field_limitation['und'][0]['value']; $month++):?>
			  <tr>
				<td><?php print $month; ?></td>
				<td><?php print date("d.m.Y", strtotime("+{$month} months", time())); ?></td>
				<td><?php print reformat_payment(get_calculator_data($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['credit_sum']);?></td>
				<td><?php print reformat_payment(get_calculator_data($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['main_debit_for_per_month']);?></td>
				<td><?php print reformat_payment(get_calculator_data($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['debit_percent']);?></td>
				<td><?php print reformat_payment(get_calculator_data($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['total_payment']);?></td>
			  </tr>
		  <?php endfor;?>
  		<?php else:?>
		  <?php for($month = 1; $month <= $mortgage->field_limitation['und'][0]['value']; $month++):?>
			<tr>
			  <td><?php print $month; ?></td>
			  <td><?php print date("d.m.Y", strtotime("+{$month} months", time())); ?></td>
			  <td><?php print reformat_payment(calculator_data_young_family($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['credit_sum'], 36);?></td>
			  <td><?php print reformat_payment(calculator_data_young_family($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['main_debit_for_per_month'], 36);?></td>
			  <td><?php print reformat_payment(calculator_data_young_family($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['debit_percent'], 36);?></td>
			  <td><?php print reformat_payment(calculator_data_young_family($credit_sum, $mortgage->field_percent['und'][0]['value'], $mortgage->field_limitation['und'][0]['value'], $month)['total_payment'], 36);?></td>
			</tr>
		  <?php endfor;?>
  		<?php endif;?>
  </tbody>
</table>