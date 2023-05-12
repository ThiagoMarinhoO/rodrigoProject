<?php

function reset_cart_session() {
    if(!session_id()) {
        session_start();
    }
    $_SESSION['cart'] = array();
}

add_action('wp', 'reset_cart_session', 1);

add_action('wp_ajax_add_product', 'add_product');
add_action('wp_ajax_nopriv_add_product', 'add_product');


function add_product() {
    session_start();

    if(isset($_POST['produto_id'])) {
        $produto_id = $_POST['produto_id'];

        $args = array(
            'post_type' => 'products',
            'post__in' => array(intval($produto_id))
        );
        $query = new WP_Query($args);

        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();

                $price = floatval(str_replace(',', '.', get_field('product_price' , get_the_ID())));
                $title = get_the_title();
                $marca = get_field('product_brand' , get_the_ID());

                $product_found = false;
                $product_key = '';

                if(isset($_SESSION['cart'])) {
                    foreach($_SESSION['cart'] as $key => $product) {
                        if($product['produto_id'] == $produto_id) {
                            $product_key = $key;
                            $product_found = true;
                            break;
                        }
                    }
                }

                if($product_found) {
                    $_SESSION['cart'][$product_key]['quantity']++;
                    $_SESSION['cart'][$product_key]['total_price'] = $_SESSION['cart'][$product_key]['quantity'] * $price;
                    $_SESSION['total_price'] = calculate_total_price();
                }
                
                if(!$product_found) {
                    $product = array(
                        'produto_id' => $produto_id,
                        'title' => $title,
                        'price' => $price,
                        'quantity' => 1,
                        'marca' => $marca,
                        'total_price' => $price,
                    );
                    $_SESSION['cart'][] = $product;
                    $_SESSION['total_price'] = calculate_total_price();
                }
            }
            wp_reset_postdata();

            $products_in_cart = array();
            foreach($_SESSION['cart'] as $product) {
                $products_in_cart[] = array(
                    'produto_id' => $product['produto_id'],
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'marca' => $marca,
                    'total_price' => $product['total_price'],
                );
            }

            wp_send_json_success(array(
                'products' => $products_in_cart,
                'total_price' => calculate_total_price()
            ));
        }
        else {
            wp_send_json_error(array(
                'message' => 'Produto não encontrado',
                'product_id' => $produto_id,
                'query' => $query
            ));
        }
    }
}

function calculate_total_price() {
    $total_price = 0;
    foreach($_SESSION['cart'] as $product) {
        $total_price += $product['total_price'];
    }
    return $total_price;
}
?>