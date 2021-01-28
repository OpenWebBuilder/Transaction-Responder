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
    public function __construct($string)
    {
        echo $string;
    }
}

if( class_exists( 'TransactionResponder' )){
    $transactionResponder = new TransactionResponder( 'Dr. Ford');
}