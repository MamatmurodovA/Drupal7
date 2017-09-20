<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#national_currency" aria-controls="national" role="tab" data-toggle="tab">
            <?php print t('Deposits in national currency');?>
        </a>
    </li>
    <li role="presentation" >
        <a href="#abroad_currency" aria-controls="abroad" role="tab" data-toggle="tab">
            <?php print t('Deposits in foreign currency');?>
        </a>
    </li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="national_currency">
            <table class="deposit_calculator">
                <thead>
                    <tr>
                        <th><?php print t('Name');?></th>
                        <th><?php print t('Percent');?></th>
                        <th><?php print t('Limitation');?></th>
                        <th><?php print t('Minimal payment');?></th>
                        <th><?php print t('Payment contract in percent');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($deposits as $deposit):?>
                        <?php if($deposit->field_currency_type['und'][0]['value'] == 'national_currency'):?>
                            <tr>
                                <td class="deposit_title">
                                    <?php print l($deposit->title, 'deposits/calculate/'.$deposit->nid); ?>
                                </td>
                                <td class="deposit_percent">
                                    <?php print (!empty($deposit->field_deposit_percent))? $deposit->field_deposit_percent['und'][0]['value'] : 0; ?>%
                                </td>
                                <td class="deposit_limitation">
                                    <?php print (!empty($deposit->field_deposit_limit))? $deposit->field_deposit_limit['und'][0]['value'] : 0; ?>
                                </td>
                                <td class="deposit_minimal_sum">
                                    <?php print (!empty($deposit->field_minimal_sum))? $deposit->field_minimal_sum['und'][0]['value'] : 0; ?>
                                </td>
                                <td class="deposit_payment_contract">
                                    <?php print (!empty($deposit->field_payment_order))? $deposit->field_payment_order['und'][0]['value'] : 0; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="abroad_currency">
            <table class="deposit_calculator">
                <thead>
                    <tr>
                        <th><?php print t('Name');?></th>
                        <th><?php print t('Percent');?></th>
                        <th><?php print t('Limitation');?></th>
                        <th><?php print t('Minimal payment');?></th>
                        <th><?php print t('Payment contract in percent');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($deposits as $deposit_foreign):?>
                        <?php if($deposit_foreign->field_currency_type['und'][0]['value'] == 'foreign_currency'):?>
                            <tr>
                                <td class="deposit_title">
                                    <?php print l($deposit_foreign->title, 'deposits/calculate/'.$deposit_foreign->nid); ?>
                                </td>
                                <td class="deposit_percent">
                                    <?php print (!empty($deposit_foreign->field_deposit_percent))? $deposit_foreign->field_deposit_percent['und'][0]['value'] : 0; ?>%
                                </td>
                                <td class="deposit_limitation">
                                    <?php print (!empty($deposit_foreign->field_deposit_limit))? $deposit_foreign->field_deposit_limit['und'][0]['value'] : 0; ?>
                                </td>
                                <td class="deposit_minimal_sum">
                                    <?php print (!empty($deposit_foreign->field_minimal_sum))? $deposit_foreign->field_minimal_sum['und'][0]['value'] : 0; ?>
                                </td>
                                <td class="deposit_payment_contract">
                                    <?php print (!empty($deposit_foreign->field_payment_order))? $deposit_foreign->field_payment_order['und'][0]['value'] : 0; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>