<?php

/*
Plugin Name: Transaction Response
Plugin URI: https://github.com/UnicornPaaS/Transaction-Response
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

class TransactionResponse
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'custom_post_type' ));

        add_action( 'save_post_email', array( $this, 'welcome_email' ), 10, 3 );
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

    function welcome_email( $post_id, $post, $update ) {

        // If an old book is being updated, exit
        if ( $update ) {
            return;
        }

        $subscribers = array( 'synchronicity113@gmail.com' ); // list of your subscribers
        $subject     = 'A new book has beed added!';
        $message     = sprintf( 'We\'ve added a new book, %s. Click <a href="%s">here</a> to see the book', get_the_title( $post ), get_permalink( $post ) );

        // $subject = get_the_title( $post_id );
        // $message = get_the_content( null, false, $post_id );

        wp_mail( $subscribers, $subject, $message );
    }
}

if( class_exists( 'TransactionResponse' )){
    $transactionResponse = new TransactionResponse();
}


register_activation_hook( __FILE__, array($transactionResponse, 'activate'));
register_deactivation_hook( __FILE__, array($transactionResponse, 'deactivate'));


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
