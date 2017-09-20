<?php
if (isset($_POST['topic_id']))
{
    $topic_id = (int)$_POST['topic_id'];
    $user_id = (int)$_POST['user_id'];
    $parent_id = (isset($_POST['parent_id']))? (int)$_POST['parent_id'] : 0;
    $topic_comment = filter_xss($_POST['answer']);
    $quote = filter_xss($_POST['quote']);
    $answer = '';

    if (!isset($quote) || empty($quote))
    {
        if ($parent_id != 0)
        {
            $quote = get_comment($parent_id);
        }
        else
        {
            $quote = get_topic_text($topic_id);
        }

    }
    $author = get_author($user_id);
    $path_to_parent = url('forum/topic/').$topic_id.'#comment'.$parent_id;
    $footer_message = t('Message from <a href="@path">@user_name</a>', array('@path' => $path_to_parent,'@user_name' => $author->name));
    $answer .= <<<HTML
        <blockquote>
            <p>
                $quote
            </p>
            <footer>
                $footer_message
            </footer>
        </blockquote>
        $topic_comment
HTML;


    $comment = (object) array(
        'nid' => $topic_id ,
        'cid' => 0,
        'pid' => $parent_id,
        'uid' => $user_id,
        'mail' => '',
        'is_anonymous' => 0,
        'homepage' => '',
        'status' => COMMENT_PUBLISHED,
        'subject' => '',
        'language' => LANGUAGE_NONE,
        'comment_body' => array(
            LANGUAGE_NONE => array(
                0 => array (
                    'value' => $answer,
                    'format' => 'full_html'
                )
            )
        ),
    );
    $new_comment = comment_submit($comment);
    comment_save($comment);
    $path_referer = $_SERVER['HTTP_REFERER'];

    header("Location: $path_referer#comment$new_comment->cid");
}

?>