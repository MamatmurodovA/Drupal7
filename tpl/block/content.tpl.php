<div class="col-md-12 content full-width">
    <?php if (isset($block_title)):?>
        <h3 class="title">
            <?php print $block_title; ?>
        </h3>
    <?php endif; ?>

    <?php include UFORUM_INC_PATH. "errors.inc"; ?>

    <?php if (isset($block_content)):?>
        <?php print $block_content; ?>
    <?php endif; ?>
</div>