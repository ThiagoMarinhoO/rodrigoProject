<?php
add_action('wp_ajax_create_seller', 'create_seller');
add_action('wp_ajax_nopriv_create_seller', 'create_seller');
function create_seller() {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = '123';
    $tipo_de_salario = $_POST['wageType'];
    $salario = $_POST['wage'];
    $payday = $_POST['payday'];
    $formattedPayday = date('d/m/Y', strtotime($payday));

    $email_exists = email_exists($email);

    if ($email_exists) {
        $response = 'O email já está sendo usado por outro usuário.';
        wp_send_json_error($response, 404);
    }

    if (empty($email) || empty($senha)) {
        $response = 'O email e a senha são obrigatórios.';
        wp_send_json_error($response, 404);
    }

    $user_id = wp_create_user($email, $senha, $email);

    if (is_wp_error($user_id)) {
        $response = 'Ocorreu um erro ao criar o usuário: ' . $user_id->get_error_message();
        wp_send_json_error($response, 500);
    }

    update_field('tipo_de_pagamento' , $tipo_de_salario , 'user_'.$user_id);
    update_field('salario' , $salario , 'user_'.$user_id);
    update_field('data_do_pagamento' , $formattedPayday , 'user_'.$user_id);

    $response = array(
        'ID' => $user_id,
        'display_name' => $nome,
        'first_name' => $nome,
        'role' => 'subscriber',
    );
    wp_update_user($response);

    wp_send_json_success(array(
        $response,
        'salario' => $salario,
        'tipo_de_salario' => $tipo_de_salario
    ));
}