<?php
add_action('wp_ajax_update_product', 'update_product');
add_action('wp_ajax_nopriv_update_product', 'update_product');

function update_product() {
    $post_id = $_POST['product_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $post_data = array(
        'ID' => $post_id,
        'post_title' => $title,
    );
    $post_updated = wp_update_post($post_data);
    update_field('product_price', $price, $post_id);
    
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