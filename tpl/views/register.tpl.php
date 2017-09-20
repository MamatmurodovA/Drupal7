<?php global $user, $language; ?>
<?php if ($user->uid): ?>
    <?php header("Location: /$language->language/forum/account");?>
<?php endif; ?>
<div class="col-12 col-sm-6 col-lg-8 register-page">
    <?php $form = drupal_get_form('register_form'); ?>
    <?php print render($form); ?>
</div>

<div class="col-6 col-lg-4">
    <?php if (isset($terms)): ?>
        <?php print $terms; ?>
    <?php endif; ?>
</div>
