<?php if(!empty($appeals)): ?>
    <table class="tabble responsive-table">
        <thead>
        <th><?php print  t('Submission number'); ?></th>
        <th><?php print t('Sent date');?></th>
        <th><?php print t('Appeal status');?></th>
        <th><?php print t('Check');?></th>
        </thead>
        <tbody>
        <?php foreach ($appeals as $appeal):?>
            <tr>
                <td><?php print $appeal->unique_number; ?></td>
                <td><?php print format_date($appeal->created); ?></td>
                <td><?php print $status_list[$appeal->status]; ?></td>
                <td><button class="btn-success check_chairman_appeal" data-appeal_id="<?php print $appeal->unique_number; ?>"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
<script type="text/javascript">
    $('.check_chairman_appeal').click(function () {
        $.ajax({
            url: '/virtual-reception-check-status',
            method: 'POST',
            data: {'check_unique_number': parseInt($(this).data('appeal_id'))},
            success: function (response) {
                let modal = $("#appeal_modal");
                $(modal).find(".modal-body p").html(response);
                $(modal).modal();
            },
            error: function (xhr) {
                console.log(xhr)
            }
        })
    });
</script>
<div class="modal fade" tabindex="-1" role="dialog" id="appeal_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php print t('Close');?>
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->