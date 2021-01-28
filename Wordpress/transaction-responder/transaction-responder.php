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
    }

    function activate(){
    }

    function deactivate(){
    }

    function uninstall(){

    }

    function custom_post_type() {
        register_post_type( 'email', ['public' => true, 'label' => 'Email' ]);
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