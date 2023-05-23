<?php
add_action('wp_ajax_create_order', 'create_order');
add_action('wp_ajax_nopriv_create_order', 'create_order');
function create_order(){

    if(isset($_POST['products'])) {
        $products = $_POST['products'];
    }
    if(isset($_POST['total'])) {
        $total = $_POST['total'];
    }
    if(isset($_POST['author'])) {
        $author = $_POST['author'];
    }else {
        $author = 6;
    }

    $post_data = array(
        'post_title'   => date('d-m-Y'), 
        'post_status'  => 'publish', 
        'post_type'    => 'sales',
        'post_author'  => $author,
    );
    
    $post_id = wp_insert_post( $post_data );
    
    update_field( 'valor_da_venda', $total, $post_id );
    
    foreach ( $products as $product ) {
        $produto_id = $product['produto_id'];
        $title = $product['title'];
        $price = $product['price'];
        $quantity = $product['quantity'];
        $total_price = $product['total_price'];
        $marca = $product['marca'];

        add_row( 'produtos_da_venda', array(
            'produto_id' => $produto_id,
            'nome' => $title,
            'preco' => $price,
            'quantidade' => $quantity,
            'marca' => $marca,
            'valor_total' => $total_price,
        ), $post_id );

        $product_id = null;
        $products_query = new WP_Query(array(
            'post_type' => 'sales',
            'meta_query' => array(
                array(
                    'key' => 'produto_id',
                    'value' => $produto_id,
                    'compare' => '=',
                ),
            ),
        ));
        
        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
                $product_id = get_the_ID();
            }
            wp_reset_postdata();
        }
        
        if ($product_id) {
            $stock = get_field('estoque', $product_id);
            if ($stock >= $quantity) {
                $new_stock = $stock - $quantity;
                update_field('estoque', $new_stock, $product_id);
                reset_cart_session();
            } else {
            }
        } else {
            
        }
    }
    wp_send_json_success(array(
        'venda' => $post_data,
    ));
}