<link href="/<?php print SOUNDTRACK_PATH; ?>/css/style.css" rel="stylesheet">
<div id="sound_container" class="sound_div sound_div_basic size_1 speaker_32" title="">
    <div id="sound_text"></div>
</div>

<div id="sound_audio"></div>
<script src="/<?php print SOUNDTRACK_PATH; ?>/js/jQueryRotate-2.1.min.js" type="text/javascript"></script>
<script src="/<?php print SOUNDTRACK_PATH; ?>/js/gspeech-1.0.3.min.js"></script>
<script src="/<?php print SOUNDTRACK_PATH; ?>/js/mediaelement-and-player-2.16.4.min.js"></script>
<script type="text/javascript">
    $ = jQuery.noConflict();
</script>

    <script type="text/javascript">
        var site_lng = 'ru';
        var players = new Array(),
            blink_timer = new Array(),
            rotate_timer = new Array(),
            lang_identifier = '<?php print $GLOBALS['language']->language; ?>',
            selected_txt = '',
            sound_container_clicked = false,
            sound_container_visible = true,
            blinking_enable = true,
            basic_plg_enable = true,
            pro_container_clicked = false,
            streamerphp_folder = 'http://zvuk.dst.uz/wp-content/plugins/gspeech/',
            translation_tool = 'g',
            translation_audio_type = 'audio/mpeg',
            speech_text_length = 50,
            blink_start_enable_pro = true,
            createtriggerspeechcount = 0,
            speechtimeoutfinal = 0,
            speechtxt = '',
            userRegistered = "0",
            gspeech_bcp = ["rgba(0,0,0,0)","rgba(255,255,255,0)","rgba(255,255,255,0)","rgba(255,255,255,0)","rgba(255,255,255,0)"],
            gspeech_cp = ["#F0F0F0","#3284c7","#fc0000","#0d7300","#ea7d00"],
            gspeech_bca = ["rgba(0, 0, 0, 0.24)","#3284c7","#ff3333","#0f8901","#ea7d00"],
            gspeech_ca = ["#ffffff","#ffffff","#ffffff","#ffffff","#ffffff"],
            gspeech_spop = ["90","80","90","90","90"],
            gspeech_spoa = ["100","100","100","100","100"],
            gspeech_animation_time = ["400","400","400","400","400"];
    </script>
