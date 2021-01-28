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

        add_action( 'save_post_email', array( $this, 'test_post_email' ), 10, 3 );

        add_action( 'paypal_ipn_for_wordpress_ipn_response_handler', array( $this, 'welcome_email' ), 10, 1);
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

    function welcome_email($posted) {

        $payer_email = isset($posted["payer_email"]) ? $posted["payer_email"] : '';
        $first_name = isset($posted["first_name"]) ? $posted["first_name"] : '';

        $body = <<<'EOD'
Welcome to the Pleasuredome!

Life goes on day after day, after day, after day
Who-ha who-ha
Who-ha who-ha
Ha
The animals are winding me up
The jungle call
The jungle call
Who-ha who-ha who-ha who-ha
In Xanadu did Kublai Khan
A pleasure dome erect
Moving on keep moving on-yeah
Moving at one million miles an hour
Using my power
I sell it by the hour
I have it so I market it
You really can't afford it-yeah
Really can't afford it

Shooting stars never stop
Even when they reach the top
Shooting stars never stop
Even when they reach the top

There goes a supernova
What a pushover-yeah
There goes a supernova
What a pushover

We're a long way from home
Welcome to the Pleasure dome
On our way home
Going home where lovers roam
Long way from home
Welcome to the Pleasure dome

Moving on keep moving on
I will give you diamonds by the shower
Love your body even when it's old
Do it just as only I can do it

Never, ever doing what I'm told
Shooting stars never stop
Even when they reach the top
Shooting stars never stop
Even when they reach the top
EOD;

        $backup_copy = 'synchronicity113@gmail.com';
        $to = array( $payer_email ); // list of your subscribers
        $headers[] = 'From: TimCast Support <members@timcast.com>';


        // Compose Email
        $subject     = 'Hi ' . $first_name . ', Welcome to TimCast.com!';
        $greeting     = 'Hello, ' . $first_name;
        $message     = $greeting . $body;

        wp_mail( $to, $subject, $message );
    }

    function test_post_email( $post_id, $post, $update ) {
      // Use a Custom content type (email) as an email template!
        if ( ! ( wp_is_post_revision( $post_id ) ) || wp_is_post_autosave( $post_id ) ) {
            return;
        }
        $subscribers = array( 'synchronicity113@gmail.com' ); // list of your subscribers
        $message     = sprintf( 'We\'ve added a new book, %s. Click <a href="%s">here</a> to see the book', get_the_title( $post ), get_permalink( $post ) );
        $subject = get_the_title( $post_id );
        $message = get_the_content( null, false, $post_id );

        wp_mail( $subscribers, $subject, $message, $headers );
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
