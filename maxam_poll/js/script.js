/**
 * Created by max on 7/10/17.
 */

function new_fieldset(id, languages, is_edit_page) {
    var input_id = id + 2;
    var inner_html = '';
    var i;
    for (i = 0; i < languages.length; i++)
    {
        var input_field = '';
        if (is_edit_page === true)
        {
            input_field += '<input type="text" lang="' + languages[i].code + '" required id="edit-' + languages[i].code +'--'+ input_id +'" name="choices[new]['+id+'][' + languages[i].code +']" value="" size="60" maxlength="128" class="form-text">';
        }else
        {
            input_field += '<input type="text" lang="' + languages[i].code + '" required id="edit-' + languages[i].code +'--'+ input_id +'" name="choice['+id+'][' + languages[i].code +']" value="" size="60" maxlength="128" class="form-text">';
        }

        inner_html += '<div class="form-item form-type-textfield form-item-poll-' + id +'-' + languages[i].code +'">' +
            '<label for="edit-' + languages[i].code +'--'+ input_id +'">' + languages[i].code +' </label>' +
            input_field +
            '</div>';
    }
    var html = '<fieldset class="poll_item form-wrapper" id="edit-' + id + '">' +
        '<legend>' +
            '<span class="fieldset-legend">' +
                'Choice ' + (id + 1)+
            '</span>' +
            '<span class="remove_poll_choice">x</span>'+
        '</legend>' +
        '<div class="fieldset-wrapper">' +
            inner_html+
        '</div>' +
        '</fieldset>';
    return html;
}

jQuery(document).ready(function ($) {

    $('#maxam-poll-create input[type="text"]').attr('required', true);

    $('#add_more_action').click(function () {
        var id = $(this).siblings('fieldset').length;
        var first_fieldset = $(this).siblings('fieldset')[0];
        var languages = [];
        var inputs = $(first_fieldset).find('input[type="text"]');
        $.each(inputs, function (key, input) {
            languages.push({
                'code': $(input).attr('lang').trim()
            })
        });
        $(new_fieldset(id, languages)).insertBefore($(this));
    });
    
    $('#add_more_action_edit_page').click(function () {
        var id = $(this).siblings('fieldset').length;
        var first_fieldset = $(this).siblings('fieldset')[0];
        var languages = [];
        var inputs = $(first_fieldset).find('input[type="text"]');
        $.each(inputs, function (key, input) {
            languages.push({
                'code': $(input).attr('lang').trim()
            })
        });
        $(new_fieldset(id, languages, true)).insertBefore($(this));
    });

    $(document.body).delegate('.remove_poll_choice', 'click', function () {
        $(this).parent().parent('fieldset').remove();
    });

    $.each($('#maxam-poll-edit').find('.poll_item'), function (key, item) {
        if (key > 0)
        {
            $(item).children('legend').append('<span class="remove_poll_choice">x</span>');
            console.log('item', item);
        }
    })

});
