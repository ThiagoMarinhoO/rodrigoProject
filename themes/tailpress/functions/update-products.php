<?php
add_action('wp_ajax_update_product', 'update_product');
add_action('wp_ajax_nopriv_update_product', 'update_product');

function update_product($post_id) {
    $post_id = $_POST['product_id'];
    $title = $_POST['title'] != '' ? $_POST['title'] : get_the_title($post_id);
    $price = $_POST['price'];
    $stock = get_field('estoque' , $post_id);
    $quantity = $_POST['estoque'] != '' ? $_POST['estoque'] : 0;
    $market_price = $_POST['marketPrice'] != '' ? $_POST['marketPrice'] : get_field('market_price' , $post_id);

    $new_stock = $stock + $quantity;

    $post_data = array(
        'ID' => $post_id,
        'post_title' => $title,
    );

    $transacao_value = $market_price != '' ? $market_price * $quantity : 0;

    $post_data['post_title'] != '' ? $post_updated = wp_update_post($post_data) : false;
    $price != '' ? update_field('product_price', $price, $post_id) : false;
    $market_price != '' ? update_field('market_price', $market_price, $post_id) : false;
    $stock != '' ? update_field('estoque' , $new_stock , $post_id) : false;

    if($quantity != 0){
        $transacao = array(
            'post_title'   => '[Saída] - Atualização de estoque do produto ' . $title,
            'post_status'  => 'publish',
            'post_type'    => 'transacoes',
          );
    
          $transacao_id = wp_insert_post( $transacao );
    
          update_field('tipo' , 'saida' , $transacao_id);
          $title != '' ? update_field('produto_cadastrado' , $title , $transacao_id) : false;
          update_field('valor_da_transacao' , $transacao_value , $transacao_id);
          $quantity != '' ? update_field('quantidade_cadastrada' , $quantity , $transacao_id) : false;
    }
    
    if ($post_updated instanceof WP_Error) {
        echo 'Ocorreu um erro ao atualizar o post: ' . $post_updated->get_error_message();
    } else {
        wp_send_json_success(array(
            'postID' => $post_id,
            'title' => $title,
            'price' => $price,
        ));
    }
    
}

add_action('wp_ajax_delete_product_post', 'delete_product_post');
add_action('wp_ajax_nopriv_delete_product_post', 'delete_product_post');

function delete_product_post() {
    $post_id = $_POST['product_id'];

    wp_delete_post($post_id, true);

    wp_send_json_success(array(
        'message' => 'post deletado com sucesso',
    ));
}