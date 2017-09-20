jQuery(document).ready(function () {
    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }
        return text;
    }

    jQuery('body').keydown(function (e) {

        if (e.ctrlKey && e.keyCode == 13) {
            
            var errortext = getSelectionText();

            if(errortext.length>100){
                alert("Вы выделили очень много текстов !");
            }
            else{
                document.getElementById("er_txt").innerHTML = errortext;
                $(".comment_txt").val("");
                $("#error_textbtn").click();
            }
        }
    });
    jQuery("#send_comment").click(function(){
        var cmnt = jQuery(this).siblings(".comment_txt").val();
        var cmnts =  $.trim( cmnt );
        var txt =  jQuery(this).parent().siblings("#er_txt").text();
        var link = location.href;
        if(cmnts){
            data = {text:txt,comment:cmnt, link:link};
            jQuery.ajax({
                url:"/send/report",
                type: "POST",
                data: data,
                success: function (data,textStatus,jqXHR) {
                    console.log(data);
                    $("#error_text .close").click();
                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus);
                }
            });
        }
        return false;
    });
});
