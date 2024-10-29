<?php

if (!is_plugin_active('cmb2/init.php')) {
    return;
}

add_action('cmb2_admin_init', 'op_register_series_metabox');

/**
 * op_register_series_metabox
 *
 * @return void
 */
function op_register_series_metabox()
{

    $cmb = new_cmb2_box(array(
        'id'           => 'op_podcast_metabox',
        'title'        => 'Opções de Podcast',
        'object_types' => array('term'),
        'taxonomies'    => array('series')
    ));

    $cmb->add_field(array(
        'name'    => __('Logo exibido na página do podcast', 'op'),
        'id'      => 'podcast_site_logo',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ));

    $cmb->add_field(array(
        'name'    => __('Banner exibido na página do podcast', 'op'),
        'id'      => 'podcast_banner',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Feed protegido', 'op'),
        'desc' => esc_html__('Apenas usuários logados e com uma assinatura ativa podem ter acesso a este feed', 'op'),
        'id'   => 'op_protected_feed',
        'type' => 'checkbox',
    ));
}

// add_action('cmb2_admin_init', 'op_register_podcast_metabox');

function op_register_podcast_metabox()
{

    $cmb = new_cmb2_box(array(
        'id'           => 'op_podcast_metabox',
        'title'        => 'Opções de Podcast',
        'object_types' => array('podcast'),
    ));

}
