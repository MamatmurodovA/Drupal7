
<script src="/<?php print UFORUM_SRC_PATH; ?>/ckeditor/ckeditor.js"></script>
<div class="col-md-1"></div>
<div class="col-md-10">
    <?php print drupal_render($form); ?>
</div>
<div class="col-md-1"></div>

<?php if (isset($topic) && !empty($topic)): ?>
<script type="text/javascript">
    CKEDITOR.replace( 'description' );
    CKEDITOR.instances.description.setData(<?php print json_encode($topic->body['und'][0]['value']) ; ?>);
</script>
<?php endif; ?>