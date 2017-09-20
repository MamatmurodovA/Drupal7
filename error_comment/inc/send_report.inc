<?php

function send_report(){
    if(isset($_POST['text']) && isset($_POST['comment'])){
        $err =  $_POST['text'];
        $cmnt = $_POST['comment'];
        $link = $_POST['link'];
        $to = "azam.mamatmurodov@datasite.uz,";
        $to .= "smi@mineconomy.uz";
        $message = "Xatolik: ".$err."\n";
        $message .= "Kommentariya: ".$cmnt."\n";
        $message .= "Link: ".$link."\n";
        $header = "MIME-Version: 1.0" . "\r\n" . "Content-type: text/plain; charset=UTF-8" . "\r\n" . "From: smi@mineconomy.uz ";

        mail($to,"Assalomu aleykum :",$message,$header);
        print_r($_POST);
    }
}