<?php
add_action('wp_ajax_profit_report', 'profit_report');
add_action('wp_ajax_nopriv_profit_report', 'profit_report');
function profit_report(){
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];

    $args_products = array(
        'post_type' => 'transacoes',
        'posts_per_page' => -1,
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $end_date,
                'inclusive' => true,
            )
        )
    );
    $args_sales = array(
        'post_type' => 'sales',
        'posts_per_page' => -1,
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $end_date,
                'inclusive' => true,
            )
        )
    );
    $query_products = new WP_Query($args_products);
    $query_sales = new WP_Query($args_sales);
    $total_market_price = 0;
    $transacao_price = 0;
    while ($query_products->have_posts()) {
        $query_products->the_post();
        $transacao_id = get_the_ID();
        $transacao_price += get_field('valor_da_transacao' , $transacao_id);
    }
    $profit_infos = array();
    $i = 0;
    $sales_total = 0;
    while ($query_sales->have_posts()) {
        $query_sales->the_post();
            $products = get_field('produtos_da_venda' , get_the_ID());
            $sales_total += get_field('valor_da_venda' , get_the_ID());
            foreach($products as $product){
                $profit_infos[$i]['quantidade'] += $product['quantidade'];
                $profit_infos[$i]['marketPrice'] += $product['market_price'];
                $profit_infos[$i]['salesPrice'] += $product['preco'];
                $profit_infos[$i]['profit_price'] += $profit_infos[$i]['salesPrice'] - $profit_infos[$i]['marketPrice'];
                $i++;
            }
    }
    wp_reset_postdata();

    wp_send_json_success(array(
        'total_market_price' => $transacao_price,
        'sales_total' => $sales_total,
        'sales' => $profit_infos
    ));
}
?>