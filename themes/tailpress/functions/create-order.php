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
        $barcode = $product['barcode'];
        $marketPrice = $product['marketPrice'];

        add_row( 'produtos_da_venda', array(
            'barcode' => $barcode,
            'produto_id' => $produto_id,
            'nome' => $title,
            'market_price' => $marketPrice,
            'preco' => $price,
            'quantidade' => $quantity,
            'valor_total' => $total_price,
            'barcode' => $barcode
        ), $post_id );

        $product_id = null;
        $products_query = new WP_Query(array(
            'post_type' => 'products',
            'meta_query' => array(
                array(
                    'key' => 'barcode',
                    'value' => $barcode,
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

    $transacao = array(
        'post_title'  => '[Entrada] - Venda ' . $post_id,
        'post_status' => 'publish',
        'post_type'   => 'transacoes',
    );

    $transacao_id = wp_insert_post($transacao);

    update_field('tipo' , 'entrada' , $transacao_id);
    update_field('produto_cadastrado', $author, $transacao_id);
    update_field('valor_da_transacao', $total, $transacao_id);
    update_field('quantidade_cadastrada', $quantity, $transacao_id);

    wp_send_json_success(array(
        'venda' => $post_data,
    ));
}

add_action('wp_ajax_status_order', 'status_order');
add_action('wp_ajax_nopriv_status_order', 'status_order');

function status_order() {
    $post_id = $_POST['product_id'];
    $post_status = $_POST['status_order'];
    
    $post_data = array(
        'ID' => $post_id,
        'post_status' => $post_status,
    );
    $post_updated = wp_update_post($post_data);

    $products = get_field('produtos_da_venda' , $post_id);

    foreach($products as $product){
        $product_id = $product['produto_id'];

        $stock = intval(get_field('estoque' , $product_id));
        $sale_quantity = $product['quantidade'];

        if($post_status == 'draft'){
            $total_estoque = $stock + $sale_quantity;
        }else{
            $total_estoque = $stock - $sale_quantity;
        }

        update_field('estoque' , $total_estoque , $product_id);
    }
    
    if ($post_updated instanceof WP_Error) {
        echo 'Ocorreu um erro ao atualizar o post: ' . $post_updated->get_error_message();
    } else {
        wp_send_json_success(array(
            'postID' => $post_id,
            'post_status' => $post_status,
            'products' => $products,
            'total_estoque' => $total_estoque,
            'stock' => $stock,
            'sale_quantity' => $sale_quantity,
            'product_id' => $product_id
        ));
    }
}