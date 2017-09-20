<?php

switch ($GLOBALS['language']->language):
    case 'ru':
        $block_id = 8;
    break;
    case 'uz':
        $block_id = 10;
    break;
    default:
        $block_id = 11;
    break;
endswitch;
$block_hook = 'block';
?>
<footer class="col-md-12 footer">
    <div class="footer-inner">
        <?php print get_block($block_hook, $block_id); ?>
    </div>
</footer>
