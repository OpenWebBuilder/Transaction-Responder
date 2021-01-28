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
        $post_log = get_stylesheet_directory() . '/post_log.txt';
        $message = get_the_title( $post_id ) . 'was saved.';

        if (file_exists( $post_log)) {
            $file = fopen( $post_log, 'a');
            fwrite($file, $message."\n");
        } else {
            $file = fopen( $post_log, 'w');
            fwrite( $file, $message."\n");
        }
        fclose($file);
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