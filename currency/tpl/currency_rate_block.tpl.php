<?php  
    if(arg(2) && arg(1) == 'archive'){
        $date = arg(2);
        $result = get_currency_rates($date);
    } else {
        $date = date('Y-m-d');
        $result = get_currency_rates();
    }
?>
<div><?php print t('Currency rate for @date', array('@date' => $date));?></div>
<div class='table-course'>
    <table>
        <thead>
            <tr>
                <th></th>
                <th><?php print t('CBU rate');?></th>
                <th><?php print t('Buying'); ?></th>
                <th><?php print t('Selling');?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach ($result as $rate):?>
                <tr>
                    <td class='sum'><?php print $rate['name'];?></td>
                    <td class='price'><?php print $rate['rate']; ?></td>
                    <td><?php print $rate['buying']; ?></td>
                    <td><?php print $rate['selling']; ?></td>
                </tr>
            <?php endforeach;?>            
        </tbody>
     </table>
 </div>