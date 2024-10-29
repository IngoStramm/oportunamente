<?php

add_shortcode('imagem_podcast', 'op_imagem_podcast');

/**
 * op_imagem_podcast
 *
 * @return string
 */
function op_imagem_podcast()
{
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $imagem_id = get_term_meta($term_id, 'podcast_series_image_settings', true);
    $imagem_src = $imagem_id ? wp_get_attachment_url($imagem_id) : null;
    if (!$imagem_src) {
        $imagem_src = 'https://oportunamente.local/wp-content/uploads/2024/09/placeholder.png';
    }
    $imagem = '<img src="' . $imagem_src . '" class="podcast-image" />';
    return $imagem;
}

add_shortcode('rss_podcast', 'op_rss_podcast');

/**
 * op_rss_podcast
 *
 * @return string
 */
function op_rss_podcast()
{
    $queried_object = get_queried_object();
    $term_slug = $queried_object->slug;
    $term_id = $queried_object->term_id;
    // $feed_url = get_bloginfo('rss2_url') . 'podcast/' . $term_slug;
    $feed_url = get_rest_url(null, 'oportunamente/v1/feed/' . $term_id);
    return $feed_url;
}

add_shortcode('rss_episode', 'op_rss_episode');

/**
 * op_rss_episode
 *
 * @return string
 */
function op_rss_episode()
{
    $post_id = get_the_ID();
    $terms = get_the_terms($post_id, 'series');
    if (!$terms || count($terms) <= 0) {
        return;
    }
    $term_slug = $terms[0]->slug;
    $term_id = $terms[0]->term_id;
    // $feed_url = get_bloginfo('rss2_url') . 'podcast/' . $term_slug;
    $feed_url = get_rest_url(null, 'oportunamente/v1/feed/' . $term_id);
    return $feed_url;
}

add_shortcode('logout_url', 'op_logout_url');

/**
 * op_logout_url
 *
 * @return string
 */
function op_logout_url()
{
    return wp_logout_url();
}
