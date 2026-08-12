<?php
/**
 * APEPI Escola Theme Functions and Definitions
 * Author: Netlagos Consulting
 * URI: https://netlagos.com.br
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Setup Theme Defaults and Register Supports
 */
function apepi_escola_setup() {
    // Add default title tag support
    add_theme_support('title-tag');

    // Enable Featured Images (Thumbnails)
    add_theme_support('post-thumbnails');

    // Register Dynamic Navigation Menus
    register_nav_menus(array(
        'primary' => __('Menu Cabeçalho (Principal)', 'apepi-escola'),
        'footer'  => __('Menu Rodapé', 'apepi-escola'),
    ));

    // HTML5 Support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Custom Logo Support
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'apepi_escola_setup');

/**
 * Enqueue Theme Scripts & Styles
 */
function apepi_escola_scripts() {
    // Enqueue main stylesheet (style.css)
    wp_enqueue_style('apepi-escola-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue theme javascript
    wp_enqueue_script('apepi-escola-script', get_template_directory_uri() . '/script.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'apepi_escola_scripts');

/**
 * Register Custom Post Types (Cursos, Professores, Depoimentos)
 */
function apepi_escola_register_cpts() {
    // 1. CPT Cursos
    register_post_type('curso', array(
        'labels' => array(
            'name'          => __('Cursos', 'apepi-escola'),
            'singular_name' => __('Curso', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Curso', 'apepi-escola'),
            'edit_item'     => __('Editar Curso', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'cursos'),
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
    ));

    // 2. CPT Professores
    register_post_type('professor', array(
        'labels' => array(
            'name'          => __('Professores', 'apepi-escola'),
            'singular_name' => __('Professor', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Professor', 'apepi-escola'),
            'edit_item'     => __('Editar Professor', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-businessperson',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    ));

    // 3. CPT Depoimentos
    register_post_type('depoimento', array(
        'labels' => array(
            'name'          => __('Depoimentos', 'apepi-escola'),
            'singular_name' => __('Depoimento', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Depoimento', 'apepi-escola'),
            'edit_item'     => __('Editar Depoimento', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-video-alt3',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'apepi_escola_register_cpts');

/**
 * Custom Navigation Walker / Class Injector for Menu Links
 */
function apepi_escola_nav_menu_link_attributes($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' nav-link-item' : 'nav-link-item';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'apepi_escola_nav_menu_link_attributes', 10, 3);
