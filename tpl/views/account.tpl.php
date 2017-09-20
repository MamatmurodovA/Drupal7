<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#account_edit" aria-controls="account_edit" role="tab" data-toggle="tab">
                <?php print t('Account details'); ?>
            </a>
        </li>
        <li role="presentation">
            <a href="#my_posts" aria-controls="my_posts" role="tab" data-toggle="tab">
                <?php print t('My topics'); ?>
            </a>
        </li>
        <li role="presentation">
            <a href="#my_messages" aria-controls="my_messages" role="tab" data-toggle="tab">
                <?php print t('My messages'); ?>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="account_edit">
            <div class="text-right account-details-edit">
                <span class="account-edit">
                <a href="<?php print url('forum/account/edit'); ?>">
                    <i class="fa fa-pencil-square-o"></i>
                    <?php print t('Edit account'); ?>
                </a>
            </span>
            </div>
            <div class="col-md-12">
                <div class="list-group">
                    <div class="item">
                        <div class="col-md-3 list-group-item">
                          <?php
                              if($file = file_load($user->picture))
                              {
                                $image = file_create_url($file->uri);
                              }
                              else
                              {
                                $image = UFORUM_USER_DEFAULT_PICTURE;
                              }
                          ?>
                            <img class="image-responsive" src="<?php print $image; ?>" alt="">
                        </div>
                        <div class="col-md-9 list-group-item">
                            <?php print $user->name; ?>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-3 list-group-item">
                          <?php print t('Email'); ?>
                        </div>
                        <div class="col-md-9 list-group-item">
                          <?php print $user->mail; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="my_posts">
            <?php if (isset($topics) && !empty($topics)): ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th><?php print t('Topic'); ?></th>
                        <th><?php print t('Category'); ?></th>
                        <th><?php print t('Messages'); ?></th>
                        <th><?php print t('Posted in'); ?></th>
                        <th><?php print t('Operations'); ?></th>
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
                                <div class="topic-detail-message" data-parent-id="0">
                                    <?php if (is_topic_owner($topic->nid)): ?>
                                        <a class="btn btn-info btn-xs" href="<?php print url('forum/topic/'.$topic->nid.'/edit'); ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <?php print t('Edit'); ?>
                                        </a>
                                        <a class="btn btn-info btn-xs" href="<?php print url('forum/topic/'.$topic->nid.'/delete'); ?>">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                            <?php print t('Delete'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
            <div class="text-from-left ">
                <?php print t("You haven't created any topic yet."); ?>
            </div>
            <?php endif; ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="my_messages">
            <?php if (isset($messages) && !empty($messages)): ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th><?php print t('Message'); ?></th>
                        <th><?php print t('Topic'); ?></th>
                        <th><?php print t('Posted in'); ?></th>
                        <th><?php print t('Operations'); ?></th>
                    </tr>
                    <?php foreach ($messages as $message): ?>
                        <?php
                            $member = get_author($message->uid);
                            $message_topic = node_load($message->nid);
                        ?>
                        <tr>
                            <td>
                                <a href="<?php print url('forum/topic/').$message_topic->nid.'#comment'.$message->cid; ?>">
                                    <?php print $message_topic->title; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php print url('forum/topic/').$message_topic->nid; ?>">
                                    <?php print $message_topic->title; ?>
                                </a>
                            </td>
                            <td><?php print date('d.m.Y H:i', $message->created); ?></td>
                            <td>
                                <div class="topic-detail-message" data-parent-id="0">
                                    <?php if (is_message_owner($message->cid)): ?>
                                        <a class="btn btn-info btn-xs" href="<?php print url('forum/message/'.$message->cid.'/edit'); ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <?php print t('Edit'); ?>
                                        </a>
                                        <a class="btn btn-info btn-xs" href="<?php print url('forum/message/'.$message->cid.'/delete'); ?>">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                            <?php print t('Delete'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <div class="text-from-left ">
                    <?php print t("You haven't answered yet."); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
