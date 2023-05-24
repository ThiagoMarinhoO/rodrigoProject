<?php

function signUp($request) {
    $nome = sanitize_text_field($request['name']);
    $email = sanitize_text_field($request['email']);
    $senha = sanitize_text_field($request['password']);

    $user_exists = username_exists($email);
    $email_exists = email_exists($email);

    if ($user_exists) {
        $response = array(
            'error' => 'Nome de usuário já existente.',
        );
        return new WP_REST_Response( $response , 404 );
    }

    if ($email_exists) {
        $response = array(
            'error' => 'O email já está sendo usado por outro usuário.',
        );
        return new WP_REST_Response( $response , 404 );
    }

    if (empty($email) || empty($senha)) {
        $response = array(
            'error' => 'O email e a senha são obrigatórios.',
        );
        return new WP_REST_Response( $response , 404 );
    }

    $user_id = wp_create_user($email, $senha, $email);

    if (is_wp_error($user_id)) {
        $response = array(
            'error' => 'Ocorreu um erro ao criar o usuário: ' . $user_id->get_error_message(),
        );
        return new WP_REST_Response( $response , 500 );
    }

    $response = array(
        'ID' => $user_id,
        'display_name' => $nome,
        'first_name' => $nome,
        'role' => 'subscriber',
    );
    wp_update_user($response);
    return new WP_REST_Response($response, 200);
}


function register_api_signUp_endpoint() {
    register_rest_route('loginsystem/v1', '/register', array(
        array(
            'methods' => 'POST',
            'callback' => 'signUp',
        ),
    ));
}


add_action('rest_api_init', 'register_api_signUp_endpoint');