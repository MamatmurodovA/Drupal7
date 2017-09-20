<?php if($messages = drupal_get_messages()): ?>
    <?php if(!empty($messages['error'])):?>
        <div class="alert alert-danger">
            <?php foreach ($messages['error'] as $error): ?>
                <div>
                    <?php print $error; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($messages['status'])):?>
        <div class="alert alert-success">
            <?php foreach ($messages['status'] as $status): ?>
                <div><?php print $status; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($messages['warning'])):?>
        <div class="alert alert-warning">
            <?php foreach ($messages['warning'] as $warning): ?>
                <div><?php print $warning; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>