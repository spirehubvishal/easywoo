<?php
/**
 * Listar Child functions
 *
 * Customize your site by adding your custom PHP code below
 *
 * @package Listar
 */

/**
 *  Adds "style.css" from Listar Child Theme.
 *
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'listar_child_enqueue_main_style', 500 );

function listar_child_enqueue_main_style() {
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );
    wp_enqueue_style( 'listar-child-style', get_stylesheet_uri(), array( 'listar-main-style' ), wp_get_theme()->get('Version') );
    wp_enqueue_script('listar-child-js', get_stylesheet_directory_uri() . '/script.js',array('jquery'),'1.0',true);
}