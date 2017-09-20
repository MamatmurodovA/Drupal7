<?php if (!empty($children)): ?>
<table id="main_section" class="table table-bordered forum-sections">
    <thead>
    <tr>
        <th>#</th>
        <th><?php print t('Section');?></th>
        <th><?php print t('Latest message');?></th>
        <th><?php print t('Topics');?></th>
        <th><?php print t('Messages');?></th>
    </tr>
    </thead>
    <tbody>

        <?php $i = 1; foreach ($children as $sub_section): ?>
            <tr>
                <td class="section_numeration">
                    <?php print $i; ?>
                </td>
                <td class="section-intro">
                    <a style="" href="<?php print url('forum/category/').$sub_section->tid; ?>">
                        <?php print $sub_section->name; ?>
                    </a>
                    <p>
                        <?php print $sub_section->description; ?>
                    </p>
                    <?php if ($sub_section_children = taxonomy_get_children($sub_section->tid)): ?>
                        <p>
                            <?php print t('Subsections'); ?>:
                            <?php foreach ($sub_section_children as $sub_section_child):?>
                                <?php print l($sub_section_child->name, 'forum/category/'.$sub_section_child->tid);?>
                            <?php endforeach;?>
                        </p>
                    <?php endif;?>
                </td>
                <td class="section-latest-message">
                    <?php if ($topic = get_latest_topic_of_section($sub_section->tid)): ?>
                        <?php if(isset($topic['topic']['title']) && isset($topic['author']->uid)): ?>

                            <?php
                                $path_to_topic = url('forum/topic/').$topic['topic']['nid'];
                                $topic_title = $topic['topic']['title'];
                                $path_to_author = url('forum/member/').$topic['author']->uid;
                                $author_name = $topic['author']->name;
                                print t('<a href="@path_to_topic">@topic_title</a> from <a href="@path_to_author">@author_name</a>',
                                    array('@path_to_topic' => $path_to_topic,
                                        '@path_to_author' => $path_to_author,
                                        '@topic_title' => $topic_title,
                                        '@author_name' => $author_name
                                        ));
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td class="section-latest-topics">
                    <?php print get_nodes_count_by_section($sub_section->tid); ?>
                </td>
                <td class="section-latest-messages">
                    <?php print get_messages_count_of_category($sub_section->tid); ?>
                </td>
            </tr>
        <?php $i++; endforeach;?>
    </tbody>
</table>
<?php endif; ?>
<?php if (!empty($section_topics)): ?>
<table id="section_topics" class="table table-bordered forum-sections">
    <thead>
        <tr>
            <th><?php print t('Topic/Author');?></th>
            <th><?php print t('Latest message');?></th>
            <th><?php print t('Messages');?></th>
            <th><?php print t('View');?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($section_topics as $topic): ?>
        <tr>
            <td class="section-intro">
                <?php $author = user_load($topic->uid);
                    if ($author->picture):
                        $img_src = file_create_url($author->picture->uri);
                    else:
                        $img_src = '/'.UFORUM_SRC_PATH . '/img/user.svg';
                    endif;
                ?>
                <a class="forum-user-page" href="<?php print url('forum/member/').$author->uid; ?>">
                    <img class="forum-user-picture" src="<?php print $img_src; ?>" alt="">
                </a>
                <div class="section-topic-attrs">
                    <p>
                        <?php print t('Topic'); ?>:
                        <a href="<?php print url('forum/topic/').$topic->nid; ?>">
                            <?php print $topic->title; ?>
                        </a>
                    </p>
                    <p>
                        <a class="forum-user-page" href="<?php print url('forum/member/').$author->uid; ?>">
                            <?php print $author->name; ?>
                        </a>
                    </p>
                </div>
            </td>
            <td class="section-latest-message">
                <?php if ($latest_message = get_latest_message_of_topic($topic->nid)): ?>
                    <?php if(isset($latest_message->message['subject']) && isset($latest_message->message['uid'])): ?>
                        <?php

                            $author_name = $latest_message->author->name;
                            $message_link = url('forum/topic/'. $topic->nid). '#comment'.$latest_message->message['cid'];
                        ?>
                        <?php print first_sentence($latest_message->message['content']); ?>
                        <a href="<?php print $message_link; ?>">
                           <?php print t('More'); ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td class="section-latest-answers">
                <?php print $topic->comment_count; ?>
            </td>
            <td class="section-latest-seen">
                <?php print (!empty($topic->field_seen))? $topic->field_seen['und'][0]['value'] : 0; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
