<?php

add_action('wp_ajax_confirm_payment', 'confirm_payment');
add_action('wp_ajax_nopriv_confirm_payment', 'confirm_payment');
function confirm_payment() {
    $user_id = $_POST['userID'];
    $user_data = get_userdata($user_id);
    $salario = get_field('salario', 'user_' . $user_id);

    $next_payment_date = get_field('data_do_pagamento', 'user_' . $user_id);
    $tipo_pagamento = get_field('tipo_de_pagamento', 'user_' . $user_id);

    $next_payment_date = DateTime::createFromFormat('d/m/Y', $next_payment_date);

    switch ($tipo_pagamento) {
        case 'diario':
            $next_payment_date->modify('+1 day');
            break;
        case 'semanal':
            $next_payment_date->modify('+7 days');
            break;
        case 'quinzenal':
            $next_payment_date->modify('+15 days');
            break;
        case 'mensal':
            $next_payment_date->modify('+1 month');
            break;
        default:
            break;
    }

    $next_payment_date = $next_payment_date->format('d/m/Y');

    update_field('data_do_pagamento', $next_payment_date, 'user_' . $user_id);

    $transacao = array(
        'post_title'  => '[Saída] - Pagamento de salário ' . $user_data->display_name,
        'post_status' => 'publish',
        'post_type'   => 'transacoes',
    );

    $transacao_id = wp_insert_post($transacao);

    update_field('tipo' , 'saida' , $transacao_id);
    update_field('produto_cadastrado', $user_data->display_name, $transacao_id);
    update_field('valor_da_transacao', $salario, $transacao_id);
    update_field('quantidade_cadastrada', 1, $transacao_id);

    wp_send_json_success(array(
        'salario_pago' => $salario,
        'user_data'    => $user_data,
        'next_payment_date' => $next_payment_date,
    ));
}
?>