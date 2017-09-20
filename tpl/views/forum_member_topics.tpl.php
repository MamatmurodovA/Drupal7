<?php if (isset($topics)): ?>
    <table class="table table-bordered table-responsive">
        <tr>
            <th><?php print t('Topic'); ?></th>
            <th><?php print t('Category'); ?></th>
            <th><?php print t('Messages'); ?></th>
            <th><?php print t('Posted in'); ?></th>
            <th><?php print t('Author'); ?></th>
        </tr>
        <?php foreach ($topics as $topic): ?>
            <?php $member = get_author($topic->uid); ?>
            <tr>
                <td>
                    <a href="<?php print url('forum/topic/').$topic->nid; ?>">
                        <?php print $topic->title; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php print url('forum/category/').get_topic_category($topic)->tid; ?>">
                        <?php print get_topic_category($topic)->name; ?>
                    </a>
                </td>
                <td><?php print count(get_topic_messages($topic->nid)); ?></td>
                <td><?php print date('d.m.Y H:i', $topic->created); ?></td>
                <td>
                    <a href="<?php print url('forum/member/').$member->uid; ?>">
                        <?php print $member->name; ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>

<?php endif; ?>
