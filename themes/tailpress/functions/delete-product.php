<?php
add_action('wp_ajax_delete_product', 'delete_product');
add_action('wp_ajax_nopriv_delete_product', 'delete_product');

function delete_product() {
    session_start();
    if(isset($_POST['produto_id'])) {
        $produto_id = $_POST['produto_id'];
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $key => $product) {
                if($product['produto_id'] == $produto_id) {
                            unset($_SESSION['cart'][$key]);
                            break;
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            
            $_SESSION['total_price'] = calculate_total_price();
            wp_send_json_success(array(
                'products' => $_SESSION['cart'],
                'total_price' => $_SESSION['total_price']
            ));
        }else {
            wp_send_json_success(array(
                'products' => array(),
                'total_price' => 0
            ));
        }
    }
}

add_action('wp_ajax_decrease_product', 'decrease_product');
add_action('wp_ajax_nopriv_decrease_product', 'decrease_product');

function decrease_product() {
    session_start();
    if(isset($_POST['produto_id'])) {
        $produto_id = $_POST['produto_id'];
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $key => $product) {
                if($product['produto_id'] == $produto_id) {
                    if($_SESSION['cart'][$key]['quantity'] > 1){
                        $_SESSION['cart'][$key]['quantity']--;
                        $_SESSION['cart'][$key]['total_price'] = $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['price'];
                    } else {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $_SESSION['total_price'] = calculate_total_price();
            
            wp_send_json_success(array(
                'products' => $_SESSION['cart'],
                'total_price' => $_SESSION['total_price']
            ));
        }
    }
}
?>