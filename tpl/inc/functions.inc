<?php

function main_controller()
{
    global $language, $user;
    $options = array(
        'header' => theme('header'),
        'footer' => theme('footer'),
    );
    switch ($_GET['q']):

        case 'forum':

            $tree = get_category_tree();
            $block_title = t('Forum');
            $block_content =  theme('main_page', array('tree' => $tree));
        break;

        case 'forum/auth':

            $block_title = t('Sign In');
            $block_content = theme('auth');

        break;
        case 'forum/register':
            $terms = get_forum_terms()['terms'];
            $block_title = t('Sign Up');
            $block_content = theme('register', array('terms' => $terms));

        break;
        case 'forum/logout':
            $user_module_path = drupal_get_path('module','user');
            $inc_file_name =  'user.pages.inc';

            include_once $user_module_path . '/'. $inc_file_name;

            $block_title = '';
            $block_content = '';
            user_logout_current_user();
            header("Location: /$language->language/forum");
        break;
        case 'forum/ask/question':
            login_required();
            if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'):
                $inputs = $_POST;
                if($topic = create_topic($inputs)):
                    exit(0);
                    drupal_set_message('Successful created new topic', 'success');
                    $path = url('forum/topic/'.$topic->nid);
                    header("Location: {$path}");
                endif;
            endif;

            $form = drupal_get_form('ask_question_form');
            $tree = get_category_tree();
            $block_title = t('Ask question');
            $block_content = theme('ask_question', array('tree' => $tree, 'form' => $form));
        break;
        case 'forum/account':
            login_required();

            $user_topics = db_query('SELECT nid FROM node WHERE uid=:uid AND type=:type', array(
                ':uid' => $user->uid,
                ':type' => UFORUM_FORUM_CONTENT_TYPE_NAME
                ))->fetchCol(0);
            $topics = node_load_multiple($user_topics);
            $user_messages = db_query('SELECT cid FROM comment WHERE uid=:uid', array(':uid' => $user->uid))->fetchCol(0);

            $messages = comment_load_multiple($user_messages);

            $block_title = t('Account details');

            $block_content = theme('account', array(
                'user' => $user,
                'topics' => $topics,
                'messages' => $messages
            ));
        break;
        case 'forum/account/edit':
            login_required();
            if (isset($user->picture) && !empty($user->picture))
            {
                $picture_fid = $user->picture;
                $file = file_load($picture_fid);
                $user_picture = file_create_url($file->uri);
            }else
            {
                $user_picture = NULL;
            }

            $form = drupal_get_form('account_edit_form', $user->mail, $user_picture);
            $block_title = t('Account edit');
            $block_content = theme('account_edit', array(
                'user' => $user,
                'form' => $form
            ));
            break;
        case (check_url_with_regex("#forum\/category\/(\d+)$#", $_GET['q'])? true : false):
            $section = taxonomy_term_load(arg(2));

            $children = taxonomy_get_children($section->tid);
            $section_topics = get_section_topics($section->tid);
            $block_title = t($section->name);
            $block_content = theme('forum_section', array('children' => $children, 'section_topics' => $section_topics));
        break;
        case (check_url_with_regex("#forum\/topic\/(\d+)$#", $_GET['q'])? true : false):
            $topic = node_load(arg(2));

            $block_title = t($topic->title);
            $block_content = theme('forum_topic_tpl', array('topic' => $topic));

        break;
        case 'forum/api/create/message':
            login_required();
            $block_title = t('Comment saving');
            $block_content = theme('topic_comment_save');
        break;
        case 'forum/members':
            $members = db_query("SELECT u.* FROM users u INNER JOIN users_roles ur ON ur.uid = u.uid LEFT JOIN role ON role.rid = ur.rid WHERE role.name = 'forum user' AND u.status = 1")->fetchAll();
            $block_title = t('Our community');
            $block_content = theme('forum_members', array('members' => $members));
        break;
        case 'forum/topics/no-messages':
            $topics = get_topics_which_has_no_messages();
            $block_title = t('Topics without messages');
            $block_content = theme('forum_member_topics', array('topics' => $topics));
        break;
        case (check_url_with_regex("#forum\/member\/(\d+)$#", $_GET['q'])? true : false):
            if($member = user_load(arg(2))):
                $block_title = $member->name .' - ';
                $block_title.= (user_is_online($member->uid))? t('Online') : t('Offline');
                $block_content = theme('forum_member', array('member' => $member));
            else:
                header('Location: /forum/not_found');
                exit('exited');
            endif;
        break;
        case (check_url_with_regex("#forum\/topics\/by\/(\d+)$#", $_GET['q'])? true : false):
                $uid = arg(3);
                $member = user_load($uid);
                $topics = get_member_topics($uid);
                $block_title = t('Topics from @member_name', array('@member_name' => $member->name));
                $block_content = theme('forum_member_topics', array('member' => $member, 'topics' => $topics));

        break;
        case (check_url_with_regex("#forum\/topic\/(\d+)\/edit$#", $_GET['q'])? true : false):
                $topic_id = arg(2);
                $topic = node_load($topic_id);
                if (is_topic_owner($topic_id)) {
                    $block_title = t('Topic edit');
                    $form = drupal_get_form('ask_question_form', $topic->title, $topic->{UFORUM_FORUM_CONTENT_TYPE_CATEGORY_FIELD_NAME}['und'][0]['tid']);
                    $block_content = theme('forum_topic_edit', array('topic' => $topic, 'form' => $form));
                }
                else
                {
                    login_required();
                }
        break;
        case (check_url_with_regex("#forum\/message\/(\d+)\/edit$#", $_GET['q'])? true : false):
                $message_id = arg(2);
                $message = comment_load($message_id);
                if (is_message_owner($message_id)) {
                    $block_title = t('Message edit');
                    $form = drupal_get_form('message_form');
                    $block_content = theme('forum_message_edit', array('message' => $message, 'form' => $form));
                }
                else
                {
                    login_required();
                }
        break;
        case (check_url_with_regex("#forum\/message\/(\d+)\/delete#", $_GET['q'])? true : false):
                $message_id = arg(2);
                $message = comment_load($message_id);
                if (is_message_owner($message_id)) {
                    if (isset($_GET['yes']))
                    {
                        comment_delete($message_id);
                        $path_to_redirect = url('forum/account');
                        header("Location: $path_to_redirect");
                    }
                    $block_title = t('Message delete');
                    $block_content = theme('forum_message_delete', array('message' => $message));
                }
                else
                {
                    login_required();
                }
        break;
        case (check_url_with_regex("#forum\/topic\/(\d+)\/delete#", $_GET['q'])? true : false):
            $topic_id = arg(2);
            if (is_topic_owner($topic_id))
            {
                if (isset($_GET['yes']))
                {
                    node_delete($topic_id);
                    $path = url('forum/account');
                    drupal_set_message(t('Topic was successful deleted'), 'status');
                    header("Location: {$path}");
                }
                $topic = node_load($topic_id);
                $block_title = t('Topic delete');
                $block_content = theme('forum_message_delete', array('topic' => $topic));

            }
            else
            {
                login_required();
            }


        break;

        case 'forum/terms':
            $terms = get_forum_terms()['terms'];
            $nid = get_forum_terms()['nid'];
            $block_title = t('Forum terms');
            $block_content = theme('forum_terms', array('terms' => $terms, 'nid' => $nid));

            break;
        default:
            $block_title = t('404 Page not found');
            $block_content = "<h1> ".$block_title."</h1>";
        break;

    endswitch;

    $options['title'] = $block_title;
    $options['content'] = theme('content', array('block_content' => $block_content, 'block_title' => $block_title));

    print theme('main_html', $options);
}

function get_category_tree()
{
    $category = taxonomy_get_tree(UFORUM_FORUM_CATEGORY_TAXONOMY_VID);

    $tree = array_filter($category, function($item)
    {
      if ($item->parents[0] == 0):
        $item->children = taxonomy_get_children($item->tid);
        return $item;
      endif;
    });
    return $tree;
}

function create_topic($inputs)
{
    $inputs = (object)$inputs;
    $title = $inputs->question;
    $tid = $inputs->category;
    $content = $inputs->description;

    global $user;
    $node = new stdClass;
    $node->title = $title;
    $node->type = UFORUM_FORUM_CONTENT_TYPE_NAME;
    $node->language = LANGUAGE_NONE;
    $node->created = time();
    $node->uid = $user->uid;
    $node->body[LANGUAGE_NONE][0]['value'] = $content;
    $node->body[LANGUAGE_NONE][0]['format'] = 'full_html';
    $node->field_forum_sections[LANGUAGE_NONE][0]['tid'] = $tid;
    $node->status = 1;
    $node->comment = 2;
    $node = node_save($node);
    return $node;
}

function auth_form()
{
    $form = array();
    $form['login'] = array(
        '#title' => t('Username'),
        '#type' => 'textfield',
        '#attributes' => array(
            'class' => array('form-control')
        ),
        '#required' => TRUE,
    );
    $form['pass'] = array(
        '#title' => t('Password'),
        '#type' => 'password',
        '#attributes' => array(
            'class' => array('form-control')
        ),
        '#required' => TRUE
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Sign In'),
        '#attributes' => array(
            'class' => array('form-control', 'btn', 'btn-primary')
        )
    );

    return $form;
}

function auth_form_validate($form, &$form_state)
{
    if (!isset($form_state['input']['login']))
    {
        form_error($form['login'], t('Login is required'));
    }elseif (!isset($form_state['input']['pass']))
    {
        form_error($form['pass']);
    }
}
function auth_form_submit($form, &$form_state)
{

    $login = filter_xss($form_state['input']['login']);
    $pass  = filter_xss($form_state['input']['pass']);
    if ($uid = user_authenticate($login, $pass))
    {
        global $user;
        $user = user_load($uid);

        $login_array = array ('name' => $user->name);
        user_login_finalize($login_array);
        $success_url = $_SERVER['HTTP_REFERER'];
        header("Location: {$success_url}");
        exit(0);
    }else{
        drupal_set_message(t("Sorry, such user does not exist."), "error");
    }
}


function register_form($form, $form_state)
{
    $allowed_extensions = 'jpg, jpeg, png, gif';
    $form = array();
    $form['user_picture'] = array(
        '#title' => t('Profile picture'),
        '#type' => 'managed_file',
        '#required' => TRUE,
        '#upload_validators' => array(
            'file_validate_extensions' => array('png gif jpg jpeg'),
            'file_validate_size' => array(2 * 1048576)
        ),
        '#description' => t('Upload a file, allowed extensions: @extensions', array(
            '@extensions' => $allowed_extensions
            )
        ),
        '#attributes' => array(
            'class' => array('form-control')
        )
    );
    $form['username'] = array(
        '#title' => t('Username'),
        '#type' => 'textfield',
        '#required' => TRUE,
        '#attributes' => array(
            'class' => array('form-control'),
            'placeholder' => t('Username')
        )
    );
    $form['email'] = array(
        '#title' => t('Email'),
        '#type' => 'textfield',
        '#required' => TRUE,
        '#attributes' => array(
            'class' => array('form-control'),
            'placeholder' => t('Email')
        )
    );
    $form['pass'] = array(
        '#type' => 'password_confirm',
        '#required' => TRUE,
        '#attributes' => array(
            'class' => array('form-control')
        )
    );
    $form['save'] = array(
        '#type' => 'submit',
        '#value' => t('Sign Up'),
        '#attributes' => array(
            'class' => array('btn', 'btn-primary')
        )
    );
    return $form;
}

function register_form_validate($form, &$form_state)
{
    if (isset($form_state['input']['username']) && isset($form_state['input']['email']))
    {
        if(user_load_by_name($form_state['input']['username']))
        {
            form_set_error('username', t('User already exists with this username.'));
            return $form;
        }
        elseif (user_load_by_mail($form_state['input']['email']))
        {
            form_set_error('email', t('User already exists with this email.'));
            return $form;
        }
    }else{
        form_set_error('username', t('All fields are required'));
        return $form;

    }
    return 0;
}

function register_form_submit($form, &$form_state)
{
    $username  = filter_xss($form_state['input']['username']);
    $email = filter_xss($form_state['input']['email']);
    $pass = filter_xss($form_state['input']['pass']['pass1']);

    $new_user = array(
        'name' => $username,
        'mail' => $email,
        'init' => $email,
        'pass' => $pass,
        'status' => 0,
        'access' => REQUEST_TIME,
        'roles' => array(
            2 => 2,
            UFORUM_FORUM_USER_ROLE_ID => UFORUM_FORUM_USER_ROLE_ID
        ),
    );

    $user = user_save(NULL, $new_user);
    $form['user_picture']['#file']->status = FILE_STATUS_PERMANENT;
    $form['user_picture']['#file']->uid = $user->uid;
    $f = file_save($form['user_picture']['#file']);
    $uploaded_file = file_move($f, 'public://forum-users-pictures');

    $user->picture = $uploaded_file;
    user_save($user);

    $redirect_url = url("forum");
    header("Location: {$redirect_url}");
    exit(0);
}

function get_nodes_count_by_section($section_id)
{
    $nodeQuery = new EntityFieldQuery();
    $count = $nodeQuery->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', UFORUM_FORUM_CONTENT_TYPE_NAME)
        ->fieldCondition('field_forum_sections','tid', $section_id, '=')
        ->entityOrderBy('entity_id', 'DESC')
        ->count()
        ->execute();
    return $count;
}

function check_url_with_regex($regex_pattern)
{
    return preg_match($regex_pattern, $_GET['q']);
}


function get_section_topics($section_id)
{
    $nodeQuery = new EntityFieldQuery();
    $entities = $nodeQuery->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', UFORUM_FORUM_CONTENT_TYPE_NAME)
        ->fieldCondition('field_forum_sections','tid', $section_id, '=')
        ->entityOrderBy('entity_id', 'DESC')
        ->execute();
    if (isset($entities['node']))
    {
        $nids = array_keys($entities['node']);
        return node_load_multiple($nids);
    }else
    {
        return array();
    }
}


function seen_count_set($topic_id)
{
    $node = node_load($topic_id);
    if (empty($node->field_seen))
    {
        $count = 1;
    }
    else
    {
        $count = (int)$node->field_seen['und'][0]['value'] + 1;
    }
    $node->field_seen['und'][0]['value'] = $count;
    field_attach_update('node', $node);
}

function user_is_online($uid)
{
    $user = user_load($uid);
    $last_access = $user->access;
    $date_f = date("d.m.Y, H:i", $last_access);
    $date = new DateTime('now');
    $access_date = new DateTime($date_f);
    $diff = $access_date->diff($date);
    if ($diff->i < 4)
    {
        return true;
    }
    return false;
}

function get_topic_messages($topic_id)
{
    $node = node_load($topic_id);
    $comments = comment_get_thread($node, 1, 10000);
    sort($comments);
    return comment_load_multiple($comments);
}

function get_user_all_comments_count($author_id)
{
    $all = db_select('comment', 'c')
        ->fields('c')
        ->condition('c.uid', $author_id, '=')
        ->execute();
    return $all->rowCount();
}

function get_author($author_id)
{
    $anonymous = new stdClass();
    $anonymous->name = 'Anonymous';
    $anonymous->uid = 0;
    $author = (user_load($author_id) && $author_id != 0)? user_load($author_id) : $anonymous;
    return $author;
}

function user_picture($user)
{
    if($img = file_load($user->picture)):
        $img_src = file_create_url($img->uri);
    else:
        $img_src = UFORUM_USER_DEFAULT_PICTURE;
    endif;
    return $img_src;
}


function get_member_topics($uid)
{
    return node_load_multiple(array(), array('uid' => $uid, 'type' => UFORUM_FORUM_CONTENT_TYPE_NAME));
}

function get_topic_category($topic)
{
    $term = taxonomy_term_load($topic->field_forum_sections['und'][0]['tid']);
    return $term;
}

function get_topics_which_has_no_messages()
{
    $nodes = node_load_multiple(array(), array('type' => UFORUM_FORUM_CONTENT_TYPE_NAME));
    $nodes_without_message = array_filter($nodes, function($node){
       if ($node->comment_count == 0)
       {
           return $node;
       }
    });
    return $nodes_without_message;
}

function get_messages_count_of_category($category_id)
{
$sql = <<<SQL_CODE
SELECT COUNT(c.nid) as cnt
FROM comment c
INNER JOIN node n ON n.nid = c.nid
LEFT JOIN field_data_field_forum_sections fc on fc.entity_id = n.nid
WHERE fc.field_forum_sections_tid = :category_id
SQL_CODE;
$count = db_query($sql, array(':category_id' => $category_id))->fetchColumn(0);
 return $count;
}

function get_latest_message_of_topic($topic_id)
{
    $result = db_query("select c.subject, c.cid, c.created, c.uid, cb.comment_body_value as content from comment c
inner join field_data_comment_body cb on c.cid = cb.entity_id 
where nid = :topic_id", array(":topic_id" => $topic_id))->fetchAssoc();
    if (isset($result) && !empty($result))
    {
        $message = array(
            'author' => user_load($result['uid']),
            'message' => $result
        );
        return (object)$message;
    }
    else
    {
        return false;
    }
}

function get_latest_topic_of_section($category_id)
{
 $sql = <<<SQL_CODE
SELECT n.* FROM node n 
INNER JOIN field_data_field_forum_sections fc ON n.nid = fc.entity_id
WHERE fc.field_forum_sections_tid = :category_id
ORDER BY n.nid DESC LIMIT 1
SQL_CODE;
$result = db_query($sql, array(':category_id' => $category_id))->fetchAssoc();
$author = get_author((isset($result['uid']))? $result['uid'] : 0);
    $topic = array(
       'topic' => $result,
       'author' => $author
   );
   return $topic;
}

function get_block($module_name, $id)
{
    $block = block_load($module_name, $id);
    $block_rendered = _block_get_renderable_array(_block_render_blocks(array($block)));
    return drupal_render($block_rendered);
}

function forum_user()
{
    global $user;

    if (in_array(UFORUM_FORUM_USER_ROLE_NAME, $user->roles) || in_array('administrator', $user->roles)):
        return true;
    else:
        return false;
    endif;
}


function login_required()
{
  if (!forum_user()):
      $message = "<p class='text-center'>" . t('Please, try to login') . "</p>";
      drupal_set_message($message, 'error');
      drupal_goto('forum/auth');
  endif;
}

function get_forum_terms()
{
    switch ($GLOBALS['language']->language):
        case 'ru':
            $nid = 1759;
            break;
        case 'uz':
            $nid = 1760;
            break;
        default:
            $nid = 1761;
            break;
    endswitch;

    $terms = node_load($nid);
    return array('terms' => $terms->body['und'][0]['value'], 'nid' => $nid);
}


function ask_question_form($form, &$form_state, $question=NULL, $category=NULL)
{
    $tree = get_category_tree();
    $options = array();
    foreach ($tree as $item)
    {
        if (count($item->children) > 0)
        {
            $options[$item->name] = array();
            foreach (taxonomy_get_children($item->tid) as $child)
            {
                $options[$item->name][$child->tid] =  $child->name;
            }
        }
        else
        {
            $options[$item->tid] = $item->name;
        }
    }
    $form = array();
    $form['question'] = array(
        '#type' => 'textfield',
        '#title' => t('Question'),
        '#attributes' => array(
            'class' => array('form-control')
        ),
        '#required' => TRUE,
        '#default_value' => (isset($question))? $question : ''
    );
    $form['category'] = array(
        '#type' => 'select',
        '#title' => t('Category'),
        '#attributes' => array(
            'class' => array('form-control')
        ),
        '#options' => $options,
        '#required' => TRUE,
        '#default_value' => (isset($category))? $category : NULL
    );
    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => t('Description'),
        '#attributes' => array(
            'class' => array('form-control'),
            'id' => 'description'
        ),
        '#required' => TRUE
    );
    $form['save'] = array(
        '#type' => 'submit',
        '#value' => t('Save'),
        '#attributes' => array(
            'class' => array('col-lg-4', 'btn', 'btn-primary')
        )
    );
    return $form;
}

function is_topic_owner($topic_id)
{
    global $user;
    $topic = node_load($topic_id);
    if ($user->uid == $topic->uid)
    {
        return true;
    }
    return false;
}

function first_sentence($content) {

    $content = html_entity_decode(strip_tags($content));
    $pos = strpos($content, '.');

    if($pos === false) {
        return $content;
    }
    else {
        return substr($content, 0, $pos+1);
    }

}

function get_comment($cid)
{
    $comment = comment_load($cid);
    return $comment->comment_body['und'][0]['safe_value'];
}

function get_topic_text($topic_id)
{
    $topic = node_load($topic_id);
    return $topic->{UFORUM_FORUM_CONTENT_TYPE_TOPIC_DESCRIPTION_FIELD_NAME}['und'][0]['safe_value'];
}

function is_message_owner($message_id)
{
    global $user;
    if (comment_load($message_id)->uid == $user->uid)
    {
        return true;
    }
    return false;
}

function message_form($form, &$form_state)
{
    $form = array();
    $form['message'] = array(
        '#type' => 'textarea',
        '#title' => t('Message'),
        '#attributes' => array(
            'class' => array('form-control'),
            'id' => 'message'
        )
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save'),
        '#attributes' => array(
            'class' => array('btn', 'btn-primary', 'form-control')
        )
    );
    return $form;
}

function message_form_submit($form, &$form_state)
{
    $message = filter_xss($form_state['values']['message']);
    $comment = comment_load(arg(2));

    $comment->comment_body['und'][0]['value'] = $message;
    comment_save($comment);
}



function account_edit_form($form, &$form_state, $email=NULL, $user_picture=NULL)
{
    $allowed_extensions = 'jpg, jpeg, png, gif';
    $form = array();
    if ($user_picture)
    {
      $form['user_picture_default'] = array(
        '#markup' => '<div class="user-picture-default"><img src="'.$user_picture.'" /></div>',
      );
    }
    $form['user_picture'] = array(
        '#title' => t('Profile picture'),
        '#type' => 'managed_file',
        '#upload_validators' => array(
            'file_validate_extensions' => array('png gif jpg jpeg'),
            'file_validate_size' => array(2 * 1048576)
        ),
        '#description' => t('Upload a file, allowed extensions: @extensions', array(
                '@extensions' => $allowed_extensions
            )
        ),
        '#attributes' => array(
            'class' => array('form-control')
        ),
    );
    $form['email'] = array(
        '#title' => t('Email'),
        '#type' => 'textfield',
        '#required' => TRUE,
        '#attributes' => array(
            'class' => array('form-control'),
            'placeholder' => t('Email')
        ),
        '#default_value' => ((isset($email))? $email : '')
    );
    $form['pass'] = array(
        '#type' => 'password_confirm',
        '#required' => TRUE,
        '#attributes' => array(
            'class' => array('form-control')
        )
    );
    $form['save'] = array(
        '#type' => 'submit',
        '#value' => t('Save'),
        '#attributes' => array(
            'class' => array('btn', 'btn-primary')
        )
    );
    return $form;
}

function account_edit_form_submit($form, &$form_state)
{
    global $user;
    $edit = array();
    $email = filter_xss($form_state['values']['email']);
    $pass = filter_xss($form_state['values']['pass']);

    if ($form_state['values']['user_picture'] != 0)
    {
        if($user->picture != 0)
        {
          $file = file_load($user->picture);
          file_delete($file);
        }
      $form['user_picture']['#file']->status = FILE_STATUS_PERMANENT;
      $form['user_picture']['#file']->uid = $user->uid;
      $f = file_save($form['user_picture']['#file']);
      $uploaded_file = file_move($f, 'public://forum-users-pictures');

    }else
    {
      $uploaded_file = file_load($user->picture);
    }

    $edit['picture'] = $uploaded_file;
    $edit['mail'] = $email;
    $edit['pass'] = $pass;
    user_save($user, $edit);
    $path = url('forum/account');
    header("Location: $path");
}
