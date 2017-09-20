<?php if (!empty($members)): ?>
    <div class="forum-members">
        <?php foreach ($members as $member): ?>
            <div class="member">
                <img src="<?php print user_picture($member); ?>" class="img-responsive img-thumbnail" title="<?php print $member->name; ?>">
                <a href="<?php print url('forum/member/').$member->uid;  ?>">
                    <?php print $member->name; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
