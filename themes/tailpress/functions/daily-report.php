<?php
add_action('wp_ajax_daily_report', 'daily_report');
add_action('wp_ajax_nopriv_daily_report', 'daily_report');
function daily_report(){
    $data_inicio = $_POST['init_date'];
    $data_fim = $_POST['final_date'];
    
    // Recupere todas as vendas do dia atual
    $args_vendas = array(
        'post_type' => 'sales',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'valor_da_venda',
                'compare' => 'EXISTS',
            ),
        ),
        'date_query' => array(
            'after' => $data_inicio,
            'before' => $data_fim,
            'inclusive' => true,
        ),
        'fields' => 'ids',
        'posts_per_page' => -1,
    );
    
    $query_vendas = new WP_Query($args_vendas);
    
    $total_value_vendas = 0;
    
    if ($query_vendas->have_posts()) {
        while ($query_vendas->have_posts()) {
            $query_vendas->the_post();
            $valor_da_venda = get_field('valor_da_venda', get_the_ID());
            $total_value_vendas += (float) $valor_da_venda;
        }
    }

    // Recupere todas as vendas relacionadas a um post "caixa"
    $args_caixa = array(
        'post_type' => 'caixa',
        'post_status' => 'publish',
        'date_query' => array(
            'after' => $data_inicio,
            'before' => $data_fim,
            'inclusive' => true,
        ),
        'posts_per_page' => -1,
    );
    
    $query_caixa = new WP_Query($args_caixa);
    
    $total_value_caixa = 0;
    
    if ($query_caixa->have_posts()) {
        while ($query_caixa->have_posts()) {
            $query_caixa->the_post();
            $venda_do_dia = get_field('venda_do_dia');
            if (is_array($venda_do_dia)) {
                foreach ($venda_do_dia as $venda) {
                    $id_da_venda_caixa = $venda['id_da_venda'];
                    foreach ($query_vendas->posts as $venda_post) {
                        $id_da_venda_vendas = get_field('id_da_venda', $venda_post);
                        
                        if ($id_da_venda_caixa === $id_da_venda_vendas) {
                            $total_value_caixa -= (float) $venda['valor_da_venda'];
                        }
                    }
                }
            }
        }
    }

    wp_send_json_success(array(
        'Intervalo_de_data' => array(
            $data_inicio,
            $data_fim,
        ),
        'valor_final' => $total_value_vendas + $total_value_caixa, // Valor total de vendas - Valor total das vendas relacionadas ao caixa
    ));
    
    wp_reset_postdata();
}



?>