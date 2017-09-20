<script src="/<?php print UFORUM_SRC_PATH; ?>/ckeditor/ckeditor.js"></script>
<div class="col-md-1"></div>
<div class="col-md-10">
    <?php print drupal_render($form); ?>
</div>
<div class="col-md-1"></div>
<br>
<script type="text/javascript">
    CKEDITOR.replace( 'description' );
</script>