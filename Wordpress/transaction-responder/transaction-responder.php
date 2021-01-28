<?php

/*
Plugin Name: Transaction Responder
Plugin URI: https://github.com/UnicornPaaS/Transaction-Responder
Description: Fire off events like emails, on monetary transactions!
Version: 0.1
Author: DarkStar
Author URI: http://me.unisocial.net/darkstar
License: GPLv3 or later
Text Domain: transaction-responder-plugin
*/



if ( !function_exists( 'add_action' ) ) {
    echo "Hi there!  you can't access this";
    exit;
}

class TransactionResponder
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'custom_post_type' ));
        add_action( 'save_post', array( $this, 'log_when_saved' ));
    }

    function activate(){
        flush_rewrite_rules();
    }

    function deactivate(){
        // generate email Post_Type
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function uninstall(){
    }

    function custom_post_type() {
        register_post_type( 'email', ['public' => true, 'label' => 'Email' ]);
    }


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

    function mailResponse(){
        $address = 'synchronicity113@gmail.com';
        $subject = 'hello';
        $message = 'world';
        wp_mail( $to, $subject, $message );
    }
}

if( class_exists( 'TransactionResponder' )){
    $transactionResponder = new TransactionResponder();
}

// activation
register_activation_hook( __FILE__, array($transactionResponder, 'activate'));
// deactivation
register_deactivation_hook( __FILE__, array($transactionResponder, 'deactivate'));
// uninstall