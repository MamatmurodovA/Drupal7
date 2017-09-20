<?php if(isset($tree)): ?>
    <table id="main_section" class="table table-bordered forum-sections">
        <thead>
            <tr>
                <th><?php print t('Section');?></th>
                <th><?php print t('Latest topic');?></th>
                <th><?php print t('Topics');?></th>
                <th><?php print t('Messages');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tree as $section): ?>
                <?php if($section_tree = taxonomy_get_children($section->tid)): ?>
                    <tr class="section" style="background: #0085c8; color: #fff;">
                        <td class="section-intro" colspan="4">
                            <a style="color: #fff;" href="<?php print url('forum/category/').$section->tid; ?>">
                                <?php print $section->name; ?>
                            </a>
                            <p>
                                <?php print $section->description; ?>
                            </p>
                        </td>
                    </tr>
                    <?php foreach ($section_tree as $sub_section): ?>
                        <tr>
                            <td class="section-intro">
                                <a style="" href="<?php print url('forum/category/').$sub_section->tid; ?>">
                                    <?php print $sub_section->name; ?>
                                </a>
                                <p>
                                    <?php print $sub_section->description; ?>
                                </p>
                                <?php if ($sub_section_children = taxonomy_get_children($sub_section->tid)): ?>
                                    <p>
                                        <?php print t('Subsection'); ?>:
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
                    <?php endforeach;?>
                <?php else: ?>
                    <tr>
                        <td class="section-intro">
                            <a style="" href="<?php print url('forum/category/').$section->tid; ?>">
                                <?php print $section->name; ?>
                            </a>
                            <p>
                                <?php print $section->description; ?>
                            </p>
                        </td>
                        <td class="section-latest-message">
                            <?php if ($topic = get_latest_topic_of_section($section->tid)): ?>
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
                            <?php print get_nodes_count_by_section($section->tid); ?>
                        </td>
                        <td class="section-latest-messages">
                            <?php print get_messages_count_of_category($section->tid); ?>
                        </td>
                    </tr>
                <?php endif;?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
