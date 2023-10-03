<?php
add_action('wp_ajax_close_box', 'close_box');
add_action('wp_ajax_nopriv_close_box', 'close_box');

function close_box() {
    $author = $_POST['selectedSeller'];

    $current_date = date('Y-m-d');

    $args = array(
        'post_type'      => 'sales',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'author'         => $author,
        'date_query'     => array(
            array(
                'year'  => date('Y', strtotime($current_date)),
                'month' => date('m', strtotime($current_date)),
                'day'   => date('d', strtotime($current_date)),
            ),
        ),
    );

    $sales_query = new WP_Query($args);

    if ($sales_query->have_posts()) {

        $box_post = array(
            'post_type'    => 'caixa',
            'post_status'  => 'publish',
            'post_author'  => $author,
            'post_title'   => 'Fechamento de caixa - ' . $current_date,
            'post_content' => '',
        );

        $box_post_id = wp_insert_post($box_post);

        $total_vendas = 0;

        while ($sales_query->have_posts()) {
            $sales_query->the_post();
            $sale_id = get_the_ID();
            $sale_nome = get_the_title();
            $valor_da_venda = get_field('valor_da_venda', $sale_id);
            $metodo_de_pagamento = get_field('metodo_de_pagamento', $sale_id);

            $total_vendas += $valor_da_venda;

            $sale_data = array(
                'id_da_venda'         => $sale_id,
                'nome_da_venda'       => $sale_nome,
                'metodo_de_pagamento' => $metodo_de_pagamento,
                'valor_da_venda'      => $valor_da_venda,
            );

            if (isset($sale_data)) {
                $existing_vendas = get_field('vendas_do_dia', $box_post_id);
        
                $new_venda = array(
                    'id_da_venda'         => $sale_id,
                    'nome_da_venda'       => $sale_nome,
                    'metodo_de_pagamento' => $metodo_de_pagamento,
                    'valor_da_venda'      => $valor_da_venda,
                );
            
                $existing_vendas[] = $new_venda;
        
                update_field('vendas_do_dia', $existing_vendas, $box_post_id);
            }
        }

        update_field('total_de_vendas_do_dia', count($sales_query->posts), $box_post_id);
        update_field('valor_total_de_vendas', $total_vendas, $box_post_id);

        wp_reset_postdata();

        wp_send_json_success(array(
            'post_id' => $box_post_id,
            'author' => $author
        ));
    } else {
        wp_send_json_error('Nenhuma venda encontrada para o autor no dia atual.');
    }
}
?>
