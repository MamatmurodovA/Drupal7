<span class="deposit_title">
    <label><?php print t('Deposit name');?>:</label>
    <span><?php print $deposit->title; ?></span>
</span>
<form class="form-group" action="<?php print url('deposits/calculate/result');?>" method="post">
    <div class="deposit_total_sum">
        <label for=""><?php print t("Deposit som");?>:</label>
        <input type="text" name="total_sum" class="form-control"/>
    </div>
    <input type="hidden" name="deposit_num" value="<?php print $deposit->nid; ?>"/>
    <div>
        <div class="deposit_percent"> 
            <label> 
                <?php print t('Percent');?>:
            </label>
            <span id="percent_value">
                <?php print $deposit->field_deposit_percent['und'][0]['value']; ?>%
            </span>

            <div id="percent" class="deposit_slider defaultSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
            <script type="text/javascript">    
                $('#percent').slider({
                    value: <?php print $deposit->field_deposit_percent['und'][0]['value']; ?>,
                    disabled:true
                });
            </script>
            <style>
                div#percent:after {
                    content:'\A';
                    position:absolute;
                    background:black;
                    top:0;
                    bottom:0;
                    left:0;
                    width: <?php print $deposit->field_deposit_percent['und'][0]['value']; ?>%;
                }
            </style>
        </div>
    </div>
    <div>
        <div class="limitation">
            <label>
                <?php print t('Limitation');?>:
            </label>
            <span id="limitation_value">
                <?php print $deposit->field_deposit_limit['und'][0]['value']; ?>&nbsp;<?php print t('months');?>
            </span>
            <div id="limitation" class="deposit_slider defaultSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
            <script type="text/javascript">
                $('#limitation').slider({
                    value: <?php print $deposit->field_deposit_limit['und'][0]['value']; ?>,
                    disabled:true
                });
            </script>
            <style>
                div#limitation:after {
                    content:'\A';
                    position:absolute;
                    background:black;
                    top:0;
                    bottom:0;
                    left:0;
                    width: <?php print $deposit->field_deposit_limit['und'][0]['value']; ?>%;
                }
            </style>
        </div>
        
        
    </div>
    <input type="submit" value="<?php print t('Calculate');?>" class="btn "/>
</form>