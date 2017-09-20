<?php  seen_count_set($topic->nid);
global $user;
$comments = get_topic_messages($topic->nid);
?>
<div class="forum-topic-page">
    <table class="table table-bordered">
        <tr id="comment0">
            <td width="15%">
                <div>
                    <p class="first-line-of-topic">
                        <?php print date('d.m.Y H:i', $topic->created);?>
                    </p>
                    <div class="user">
                        <?php $topic_author = user_load($topic->uid); ?>
                        <span class="user-name">
                            <a href="<?php print url('forum/member/').$topic_author->uid;?>" title="<?php print $topic_author->name; ?>">
                                <?php print $topic_author->name; ?>
                            </a>
                        </span>
                        <?php if ($topic_author->picture): ?>
                            <?php $src = ""; ?>
                        <?php else: ?>
                            <?php $src =  UFORUM_USER_DEFAULT_PICTURE; ?>
                        <?php endif; ?>
                        <div>
                            <a href="<?php print url('forum/member/').$topic_author->uid;?>" title="<?php print $topic_author->name; ?>">
                                <img style="width: 86px;" class="forum-user-picture" src="<?php print $src; ?>" title="<?php print $topic_author->name; ?>">
                            </a>
                            <span class="is_online">
                            <?php print (user_is_online($topic_author->uid))? 'Online' : 'Offline'; ?>
                        </div>
                        <div class="other-user-details">
                            <span>
                                <?php print t('Messages');?>:
                                <?php print get_user_all_comments_count($topic_author->uid); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </td>
            <td class="topic-description">
                <div>
                    <p class="first-line-of-topic">
                        <a href="<?php print url('forum/topic/') . $topic->nid.'#comment1'; ?>">
                            #1
                        </a>
                    </p>
                    <div class="topic-detail-message">
                        <div class="topic-detail-message-content" id="topic_message">
                            <?php print $topic->body['und'][0]['value']; ?>
                        </div>
                        <div class="topic-detail-message-btn" data-parent-id="0">
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
                            <p class="btn btn-info btn-xs answer"  data-toggle="modal" data-target="#topic_answer_form_modal">
                                <i class="fa fa-reply"></i>
                                <?php print t('Answer');?>
                            </p>
                        </div>
                    </div>

                </div>
            </td>
        </tr>
        <?php $number = 2; foreach ($comments as $comment): ?>
            <?php $comment_author = user_load($comment->uid); ?>
            <tr id="comment<?php print $comment->cid; ?>">
                <td width="15%">
                    <div>
                        <p class="first-line-of-topic">
                            <?php print date('d.m.Y H:i', $comment->created);?>
                        </p>
                        <div class="user">
                            <?php $topic_author = user_load($comment->uid); ?>
                            <span class="user-name">
                            <a href="<?php print url('forum/member/').$comment->uid;?>" title="<?php print $comment_author->name; ?>">
                                <?php print $comment_author->name; ?>
                            </a>
                        </span>
                            <?php if ($comment_author->picture): ?>
                                <?php $src = ""; ?>
                            <?php else: ?>
                                <?php $src = UFORUM_USER_DEFAULT_PICTURE; ?>
                            <?php endif; ?>
                            <div>
                                <a href="<?php print url('forum/member/').$comment_author->uid;?>" title="<?php print $comment_author->name; ?>">
                                    <img style="width: 86px;" class="forum-user-picture" src="<?php print $src; ?>" title="<?php print $comment_author->name; ?>">
                                </a>
                                <span class="is_online">
                            <?php print (user_is_online($comment_author->uid))? 'Online' : 'Offline'; ?>
                            </div>
                            <div class="other-user-details">
                            <span>
                                <?php print t('Messages');?>:
                                <?php print get_user_all_comments_count($comment_author->uid); ?>
                            </span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="topic-description">
                    <div>
                        <p class="first-line-of-topic">
                            <a href="<?php print url('forum/topic/') . $topic->nid.'#comment'.$number; ?>">
                                # <?php print $number; ?>
                            </a>
                        </p>
                        <div class="topic-detail-message">
                            <div class="topic-detail-message-content" id="topic_message">
                                <?php print $comment->comment_body['und'][0]['value']; ?>
                            </div>
                            <div class="topic-detail-message-btn" data-parent-id="<?php print $comment->cid; ?>">
                                <?php if (is_message_owner($comment->cid)): ?>
                                    <a class="btn btn-info btn-xs" href="<?php print url('forum/message/'.$comment->cid.'/edit'); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        <?php print t('Edit'); ?>
                                    </a>
                                    <a class="btn btn-info btn-xs" href="<?php print url('forum/message/'.$comment->cid.'/delete'); ?>">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <?php print t('Delete'); ?>
                                    </a>
                                <?php endif; ?>
                                <p class="btn btn-info btn-xs answer"  data-toggle="modal" data-target="#topic_answer_form_modal">
                                    <i class="fa fa-reply"></i>
                                    <?php print t('Answer');?>
                                </p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $number++; endforeach; ?>
    </table>
</div>

<div id="topic_answer_form_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="topic_answer_form" action="<?php print url('forum/api/create/message') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="topic_title">Modal Header</h4>
                </div>
                <input type="hidden" value="<?php print $topic->nid; ?>" name="topic_id">
                <input type="hidden" value="<?php print $user->uid; ?>" name="user_id">
                <input type="hidden" value="0" name="parent_id" id="parent_id" >
                <input type="hidden" value="" name="quote" id="quote">
                <div class="modal-body body">
                    <textarea  class="form-control" name="answer" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="col-sm-6 col-md-6  btn-default" data-dismiss="modal"><?php print t('Close');?></button>
                        <button class="col-sm-6 col-md-6  btn-primary" ><?php print t('Answer'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>