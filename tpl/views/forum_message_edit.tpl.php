<script src="/<?php print UFORUM_SRC_PATH; ?>/ckeditor/ckeditor.js"></script>
<div class="col-md-1"></div>
<div class="col-md-10">
    <?php print drupal_render($form); ?>
</div>
<div class="col-md-1"></div>
<?php if (isset($message) && !empty($message)): ?>
    <script type="text/javascript">
        CKEDITOR.replace( 'message' );
        CKEDITOR.instances.message.setData(<?php print json_encode(get_comment($message->cid)) ; ?>);
    </script>
<?php endif; ?>