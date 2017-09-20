<?php global $user; ?>
<div class="col-12 col-sm-12 col-lg-12 header">
    <div class="header_part">
        <div class="site_logo col-lg-4 col-sm-4 col-4">
            <a href="<?php print url('forum'); ?>">
                <img class="forum_logo" src="<?php print UFORUM_THEME_LOGO; ?>" />
            </a>
        </div>
        <div class="site_slogan col-lg-5 col-sm-5 col-5 text-center">
            <h3> 
				<a href="<?php print url(''); ?>" >
                    <?php print UFORUM_SITE_NAME; ?>
                </a>
			</h3>
        </div>
        <div class="user_account col-lg-3 col-sm-3 col-3">
            <?php if ($user->uid): ?>
                <div class="dashboard">
                    <ul class="ul-dashboard">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <?php print t('Dashboard');?>
                            </a>
                            <ul  class="dropdown-menu">
                                <li class="item">
                                    <a href="<?php print url('forum/account'); ?>" class="account btn" title="<?php print t('Account details');?>">
                                        <i class="fa fa-newspaper-o"></i>
                                        <?php print t('My account');?>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="<?php print url('forum/ask/question'); ?>" class="btn ask_question" title="<?php print t('Ask question');?>">

                                        <i class="fa fa-pencil-square-o"></i>
                                        <?php print t('Create topic');?>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="<?php print url('forum/logout'); ?>" class="logout btn" title="<?php print t('Logout');?>">
                                        <i class="fa fa-sign-out"></i>
                                        <?php print t('Logout');?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php else:?>
                <div class="user-registration-login">
                    <a href="<?php print url('forum/auth'); ?>" class="login btn" title="<?php print t('Sign In');?>">
                        <i class="fa fa-sign-in"></i>
                        <?php print t('Sign In');?>
                    </a>
                    <a href="<?php print url('forum/register'); ?>" class="register btn"  title="<?php print t('Sign Up');?>">
                        <i class="fa fa-list-alt"></i>
                        <?php print t('Sign Up');?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="nav-bar-menu">
        <div class="nav nav-bar">
            <ul class="nav-bar-menu-ul">
                <li>
                    <a href="<?php print url('forum/topics/no-messages') ?>">
                        <i class="fa fa-commenting" aria-hidden="true"></i>
                        <?php print t('Topics without messages');?>
                    </a>
                </li>
                <li>
                    <a href="<?php print url('forum/members'); ?>">
                        <i class="fa fa-users"></i>
                        <?php print t('Community');?>
                    </a>
                </li>
                <li>
                    <a href="<?php print url('forum/terms'); ?>">
                        <i class="fa fa-info-circle"></i>
                        <?php print t('Forum terms');?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
