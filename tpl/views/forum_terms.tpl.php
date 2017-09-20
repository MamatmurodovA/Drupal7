<?php if (isset($terms)): ?>
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?php if (function_exists('is_admin')): ?>
            <?php if (is_admin()): ?>
                <?php print l(t('Edit'), 'node/'.$nid.'/edit'); ?>
            <?php endif; ?>
        <?php endif; ?>
        <p class="text-justify">
            <?php print strip_tags($terms); ?>
        </p>
    </div>
    <div class="col-md-1"></div>
<?php endif; ?>
