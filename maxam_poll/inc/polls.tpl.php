<button class="btn" style="margin-bottom: 10px;">
    <?php print l(t('Add new poll'), 'admin/config/services/maxam_poll/create');?>
</button>

    <table class="table">
        <thead>
            <tr>
                <th><?php print t('Id');?></th>
                <th><?php print t('Question');?></th>
                <th><?php print t('Created');?></th>
                <th><?php print t('Operations');?></th>
            </tr>
        </thead>
        <tbody>
            <?php  foreach ($polls_list as $poll): ?>
                <tr>
                    <td><?php print $poll['pid']; ?></td>
                    <td><?php print $poll['question']; ?></td>
                    <td><?php print $poll['created']; ?></td>
                    <td>
                        <a href="<?php print url('admin/config/services/maxam_poll/poll/'.$poll['pid']); ?>">
                            <?php print t('Edit');?>
                        </a>
                        /
                        <a href="<?php print url('admin/config/services/maxam_poll/poll/'.$poll['pid'].'/delete'); ?>">
                            <?php print t('Delete');?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
