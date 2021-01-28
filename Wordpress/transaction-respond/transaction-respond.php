<?php

/*
Plugin Name: Transaction Respond
Plugin URI: https://github.com/UnicornPaaS/Transaction-Respond
Description: Fire off events like emails, on monetary transactions!
Version: 0.1
Author: DarkStar
Author URI: http://me.unisocial.net/darkstar
License: GPLv3 or later
Text Domain: transaction-respond-plugin
*/

if ( !function_exists( 'add_action' ) ) {
    echo "Hi there!  you can't access this";
    exit;
}

class TransactionRespond
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'custom_post_type' ));

        add_action( 'save_post_email', array( $this, 'welcome_email' ), 10, 3 );

        add_action( 'paypal_ipn_for_wordpress_ipn_response_handler', array( $this, 'test_email' ), 10, 1);
    }

    function activate(){
        // generate email Post_Type
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate(){
        // deactivate email Post_Type
        flush_rewrite_rules();
    }

    function uninstall(){
    }

    function custom_post_type() {
        register_post_type( 'email', ['public' => true, 'label' => 'Email' ]);
    }

    function test_email($posted) {

        $subscribers = array( 'synchronicity113@gmail.com' ); // list of your subscribers
        $subject     = 'A new Transaction';
        $message     = 'test it';

        wp_mail( $subscribers, $subject, $message );
    }

    function welcome_email( $post_id, $post, $update ) {
        if ( ! ( wp_is_post_revision( $post_id ) ) || wp_is_post_autosave( $post_id ) ) {
            return;
        }

        $subscribers = array( 'synchronicity113@gmail.com' ); // list of your subscribers
        // $subject     = 'A new book has beed added!';
        $message     = sprintf( 'We\'ve added a new book, %s. Click <a href="%s">here</a> to see the book', get_the_title( $post ), get_permalink( $post ) );

        $subject = get_the_title( $post_id );
        // $message = get_the_content( null, false, $post_id );

        wp_mail( $subscribers, $subject, $message );
    }
}

if( class_exists( 'TransactionRespond' )){
    $transactionRespond = new TransactionRespond();
}


register_activation_hook( __FILE__, array($transactionRespond, 'activate'));
register_deactivation_hook( __FILE__, array($transactionRespond, 'deactivate'));


/*
 * .PrimeSrc
 * Create a WordPress Plugin from Scratch - Part 4 - Custom Post Type
 * https://youtu.be/XTkbDBhXBQI?list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2
 *
 * WordPress Hooks Actions and Filters -Actions - Part 2
 * https://youtu.be/tlAukRR7tf4?list=PLD8nQCAhR3tTVcreVOlFteq0piaXq1jjk
 *
 * Part 1: Actions - WordPress Hooks Tutorial For Beginners 2019
 * https://youtu.be/9GuJi8dYuAs
 *
 * Is there a save_post hook for custom post types?
 * https://wordpress.stackexchange.com/questions/63478/is-there-a-save-post-hook-for-custom-post-types
 *
 * Notify your newsletter subscribers when a new book (custom post) is added-
 * https://developer.wordpress.org/reference/hooks/save_post_post-post_type/#comment-4311
 */
