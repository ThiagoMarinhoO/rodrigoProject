<?php
add_action('wp_ajax_daily_report', 'daily_report');
add_action('wp_ajax_nopriv_daily_report', 'daily_report');
function daily_report(){
    $data_inicio = $_POST['init_date'];
    $data_fim = $_POST['final_date'];
    $args = array(
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
    
    $query = new WP_Query( $args );
    
    $total_value = 0;
    $quantidade_mais_vendida = 0;
    $produto_mais_vendido = null;
    $produtos_quantidades = array();
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $valor_da_venda = get_field( 'valor_da_venda', get_the_ID() );
            $total_value += (float) $valor_da_venda;
            $produtos = get_field('produtos_da_venda' , get_the_ID());

            foreach ($produtos as $produto) {
                $produto_id = $produto['produto_id'];
                
                if(isset($produtos_quantidades[$produto_id])){
                    $produtos_quantidades[$produto_id]['quantidade'] += $produto['quantidade'];
                } else {
                    $produtos_quantidades[$produto_id] = array(
                        'produto_id' => $produto_id,
                        'quantidade' => $produto['quantidade'],
                        'produto_nome' => get_the_title(strval($produto_id)),
                        'produto_preco' => get_field('product_price' , strval($produto_id)),
                    );
                }
            }

            foreach ($produtos_quantidades as $produto) {
                if($produto['quantidade'] > $quantidade_mais_vendida) {
                    $quantidade_mais_vendida = $produto['quantidade'];
                    $produto_mais_vendido = $produto;
                }
            }
        }
    }

    wp_send_json_success(array(
        'Intervalo_de_data' => array(
            $data_inicio,
            $data_fim,
        ),
        'produto_mais_vendido' => $produto_mais_vendido,
        'valor_final' => $total_value,
    ));
    
    wp_reset_postdata();
}

?>