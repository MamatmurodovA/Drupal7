<?php global $user, $language; ?>
<?php if (forum_user()): ?>
    <?php header("Location: /$language->language/forum/account");?>
<?php endif; ?>
<div class="col-md-1 col-sm-1"></div>
<div class="col-md-10 col-sm-10">
    <?php $form = drupal_get_form('auth_form');?>
    <?php print render($form); ?>
</div>
<div class="col-md-1 col-sm-1"></div>
