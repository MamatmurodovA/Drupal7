<table class="table table-responsive table-bordered">
	<thead>
		<tr>
			<th><?php print t('Credit name')?></th>
			<th><?php print t('Credit percent');?></th>
			<th><?php print t('Credit limitation');?></th>
			<th><?php print t('Credit maximal sum');?></th>
			<th><?php print t('Credit first payment');?></th>
			<th><?php print t('Credit order');?></th>
		</tr>
	</thead>
	<tbody >
		<?php foreach ($mortgages as $credit):?>
			<tr>
				<td><?php print l($credit->title, 'mortgage/credit/'.$credit->nid); ?></td>
				<td>
				  	<?php print (!empty($credit->field_percent))? $credit->field_percent['und'][0]['value'] : ''; ?>%
				</td>
				<td>
				  <?php print (!empty($credit->field_limitation))? $credit->field_limitation['und'][0]['value'] : ''; ?>
				  <?php print t('months');?>
				</td>
				<td>
				    <?php print (!empty($credit->field_maximal_sum))? $credit->field_maximal_sum['und'][0]['value'] : ''; ?>
				</td>
				<td>
				    не менее <?php print (!empty($credit->field_first_payment))? $credit->field_first_payment['und'][0]['value'] : ''; ?>% от суммы кредита
				</td>
				<td>
				  	<?php print (!empty($credit->body))? $credit->body['und'][0]['value'] : ''; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>