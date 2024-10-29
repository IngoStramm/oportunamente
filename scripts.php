<?php

add_action('wp_enqueue_scripts', 'op_frontend_scripts');

function op_frontend_scripts()
{

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    if (empty($min)) :
        wp_enqueue_script('op-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    wp_register_script('op-script', OP_URL . 'assets/js/oportunamente' . $min . '.js', array('jquery'), '1.0.0', true);

    wp_enqueue_script('op-script');

    wp_localize_script('op-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('op-style', OP_URL . 'assets/css/oportunamente.css', array(), false, 'all');
}
