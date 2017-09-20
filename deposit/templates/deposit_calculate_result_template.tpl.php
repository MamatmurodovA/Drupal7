<div class="result_calculat">
    <div>
        <?php print t("The expected amount of accrued interest on the deposit for the entire period: @total_sum_for_full_period @currency_type", array("@total_sum_for_full_period" => $total_sum_for_full_period, '@currency_type' => $currency_type));?>
    </div> 
    <div>
        <?php print t("The expected amount of accrued interest on the deposit for a month: @sum_for_per_month @currency_type", array("@sum_for_per_month" => $sum_for_per_month, '@currency_type' => $currency_type));?>
    </div>
</div>

 
