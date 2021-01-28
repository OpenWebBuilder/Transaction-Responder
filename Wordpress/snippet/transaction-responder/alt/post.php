<?php

function log_when_saved( $post_id ){
    /*

     */
    if ( ! ( wp_is_post_revision( $post_id ) ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }

    $log = get_home_path() . 'log/hook_log.txt';
    $message = get_the_title( $post_id );

    if (file_exists( $log)) {
        $file = fopen( $log, 'a');
        fwrite($file, $message ."\n");
    } else {
        $file = fopen( $log, 'w');
        fwrite( $file, $message ."\n");
    }
    fclose($file);
}

//------------------------------------------------------------
function log_when_saved( $post_id ){
    /*
     * https://youtu.be/tlAukRR7tf4?list=PLD8nQCAhR3tTVcreVOlFteq0piaXq1jjk
     * https://youtu.be/9GuJi8dYuAs
     */
    if ( ! ( wp_is_post_revision( $post_id ) ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }

    $log = get_home_path() . 'log/hook_log.txt';
    $title = get_the_title( $post_id );
    $message = get_the_content( $post_id );
    $entry = $title . " " . $message;

    if (file_exists( $log)) {
        $file = fopen( $log, 'a');
        fwrite($file, $entry."\n");
    } else {
        $file = fopen( $log, 'w');
        fwrite( $file, $entry."\n");
    }
    fclose($file);
}
