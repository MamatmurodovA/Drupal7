<?php global $language; ?>
<div class="poll-block" id="poll_block">
    <h3>
        <?php print $poll->question?>
    </h3>
    <form id="poll_form" action="<?php print url('poll/vote'); ?>" method="post" <?php print ($poll->voted)? 'hidden' : '';?>>
        <?php foreach ($poll->choices as $chid => $choice): ?>
            <div class="form-group">
                <input <?php print ($poll->voted && $chid == $poll->voted['chid'])? 'checked' : '';?> type="radio" name="choice" id="choice_<?php print $chid; ?>" value="<?php print $chid; ?>">
                <label for="choice_<?php print $chid; ?>"><?php print $choice; ?></label>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="pid" value="<?php print $poll->pid; ?>">
        <a class="btn" id="poll_vote">Vote</a>
    </form>
    <div id="poll_bar" <?php  print (!$poll->voted)? 'hidden' : ''; ?>>
        <?php print generate_html_poll_bar($poll->answers, $poll->total_vote);?>
    </div>
</div>
<script type="text/javascript">

    (function ($) {
        $(document.body).delegate('#poll_vote', 'click', function () {
            var choice = document.querySelector('input[name="choice"]:checked');
            var pid = document.querySelector('input[name="pid"]').value;
            if (choice !== null)
            {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        var response = JSON.parse(this.responseText);
                        if (response.status === 'success')
                        {
                            document.getElementById('poll_form').style.display = 'none';
                            var poll_bar = document.getElementById('poll_bar');
                            poll_bar.innerHTML = response.message;
                            poll_bar.style.display = 'block';
                        }else
                        {
                            console.log('Error status: ' + response.status + ', Error message: ' + response.message);
                        }
                    }
                };
                xhttp.open("POST", "/poll/vote", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("choice=" + choice.value + '&pid=' + pid);
                console.log("choice=" + choice.value);
            }else
            {
                alert("<?php print t('Check one of item'); ?>");
            }
        });
        $(document.body).delegate('#poll_reset_vote', 'click',function(){
            $(this).parent('#poll_bar').siblings('#poll_form').slideDown();
            $(this).parent('#poll_bar').slideUp();
        });
        $(document.body).delegate('#poll_new_vote', 'click',function(){
            $.get($(this).attr('href'), function (data, status) {
                var element = '#poll_block';
                var html = $(data).find(element).html();
                $(element).html(html);
            });
            return false;
        });
    })(jQuery)
</script>
