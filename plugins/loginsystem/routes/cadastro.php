<?php

function login($request) {
    $nome = sanitize_text_field($request['name']);
    $email = sanitize_text_field($request['email']);
    $senha = sanitize_text_field($request['password']);

    $user_exists = username_exists($email);
    $email_exists = email_exists($email);


    if (!$user_exists && !$email_exists && $email && $senha) {
        $user_id = wp_create_user( $email, $senha, $email );

        $response = array(
            'ID' => $user_id,
            'display_name' => $nome,
            'first_name' => $nome,
            'role' => 'Vendedor',
        );
        wp_update_user( $response );
    }

    $response = array(
        'email' => $email,
    );
    return rest_ensure_response($response);
}


function register_api_login_endpoint() {
    register_rest_route('loginsystem/v1', '/register', array(
        array(
            'methods' => 'POST',
            'callback' => 'login',
        ),
    ));
}


add_action('rest_api_init', 'register_api_login_endpoint');