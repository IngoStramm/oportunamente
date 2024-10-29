<?php
function op_get_rss_feed($data)
{

    $tag_id = $data['id'];
    $term = get_term($tag_id);

    if (is_wp_error($term) || is_null($term)) {
        return new WP_Error('podcast_not_found', __('Podcast não encontrado.'), array('status' => 404));
    }

    $protected_feed = get_term_meta($tag_id, 'op_protected_feed', true);
    if (!$protected_feed) {
        $feed_url = get_bloginfo('rss2_url') . 'podcast/' . $term->slug;
        return wp_redirect($feed_url);
    }

    $username = isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] ? $_SERVER['PHP_AUTH_USER'] : null;
    if (empty($username) || is_null($username)) {
        return new WP_Error('no_username', __('Usuário obrigatório.', 'op'), array('status' => 401));
    }

    $password = isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] ? $_SERVER['PHP_AUTH_PW'] : null;
    if (
        empty($password) || is_null($password)
    ) {
        return new WP_Error('no_password', __('Senha obrigatória.', 'op'), array('status' => 401));
    }

    $credentials = array(
        'user_login'            => $username,
        'user_password'         => $password,
    );

    $wp_user = wp_signon($credentials);

    if (is_wp_error($wp_user)) {
        return new WP_Error('login_failed', $wp_user->get_error_message(), array('status' => 401));
    }

    $user_id = $wp_user->ID;
    $mepr_user = new MeprUser($user_id);

    if (!$mepr_user->is_active()) {
        return new WP_Error('no_subscription', __('O usuário não possui uma assinatura ativa.', 'op'), array('status' => 401));
    }

    if ($term->taxonomy !== 'series') {
        return new WP_Error('not_a_podcast', __('Podcast inválido.'), array('status' => 404));
    }

    $feed_url = ssp_get_feed_url($term->slug, 'podcast');

    // $response = new WP_REST_Response($data);
    // $response->set_status(201);
    // return $response->header('Location', $feed_url);

    // return ssp_get_feed_url($term->slug, 'podcast');

    return wp_redirect($feed_url);
}

add_action('rest_api_init', function () {
    register_rest_route('oportunamente/v1', '/feed/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'op_get_rss_feed',
    ));
});
