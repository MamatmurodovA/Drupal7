<?php if (isset($member)): ?>
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#info" aria-controls="info" role="tab" data-toggle="tab">
                    <?php print t('About me');?>
                </a>
            </li>
            <li role="presentation">
                <a href="#statistics" aria-controls="statistics" role="tab" data-toggle="tab">
                    <?php print t('Statistics'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="info">
                <div class="member-info-in">
                    <p>
                        <strong><?php print t('Work at'); ?></strong>:
                        <?php print (isset($member->work_at))? $member->work_at['und'][0]['value']: t('Nowhere'); ?>
                    </p>
                    <p>
                        <strong><?php print t('Position'); ?></strong>:
                        <?php print (isset($member->position_at_work))? $member->position_at_work['und'][0]['value']: t('None'); ?>
                    </p>
                    <p>
                        <strong><?php print t('Age'); ?></strong>:
                        <?php print (isset($member->age))? $member->age['und'][0]['value']: t('0'); ?>
                    </p>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="statistics">
                <div class="member-statistics-in">
                    <p>
                        <strong><?php print t('All topics'); ?></strong>:
                            <?php print count(get_member_topics($member->uid)); ?>
                    </p>
                    <p>
                        <strong><?php print t('All messages'); ?></strong>:
                        <?php print get_user_all_comments_count($member->uid); ?>
                    </p>
                    <p>
                        <strong>
                            <?php print t('Registered at'); ?>
                        </strong>:
                        <?php print date('d.m.Y', $member->created); ?>
                    </p>
                    <p>
                        <strong>
                            <?php print t('Latest activity'); ?>
                        </strong>:
                        <?php print date('d.m.Y H:i', $member->access); ?>
                    </p>
                    <p>
                        <a href="<?php print url('forum/topics/by/').$member->uid; ?>">
                            <?php print t('Find all topics of @member_name', array('@member_name' => $member->name)); ?>
                        </a>
                    </p>
                </div>
            </div>
         </div>
    </div>
<?php endif; ?>