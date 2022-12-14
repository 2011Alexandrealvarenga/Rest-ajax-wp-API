<?php
/**
 * Plugin Name: Rest Ajax 
 * Plugin URI: https://github.com/yttechiepress/rest-ajx
 * Author: Techiepress
 * Author URI: https://github.com/yttechiepress/rest-ajx
 * Description: Work Rest API and Ajax together
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: rest-ajax
*/

defined( 'ABSPATH' ) or die( 'Unauthorized access' );

// Create Shortcode for rest-ajax.
add_shortcode( 'rest-ajax', 'techiepress_rest_ajax_shortcode' );

function techiepress_rest_ajax_shortcode () {
    $res = techiepress_rest_ajax_callback();
    foreach($res as $result){
        echo 'Titulo: '. $result->title.'<br>';
    }

}

// Create new endpoint to provide data.
add_action( 'rest_api_init', 'techiepress_rest_ajax_endpoint' );

function techiepress_rest_ajax_endpoint() {
    register_rest_route(
        'techiepress',
        'rest-ajax',
        [
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'            => 'techiepress_rest_ajax_callback',
        ]
    );
}

// REST Endpoint information.
function techiepress_rest_ajax_callback() {

    $args = [
        'methods' => 'GET',
    ];

    $reponse = wp_remote_get( 'https://jsonplaceholder.typicode.com/posts', $args );
    $reponse = wp_remote_retrieve_body($reponse);
    $reponse = json_decode($reponse);

    return $reponse;
}