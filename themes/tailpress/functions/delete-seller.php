<?php
add_action('wp_ajax_delete_seller', 'delete_seller');
add_action('wp_ajax_nopriv_delete_seller', 'delete_seller');

function delete_seller() {
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        
        if (wp_delete_user($user_id)) {
            wp_send_json_success('Usuário excluído com sucesso!');
        } else {
            wp_send_json_error('Falha ao excluir o usuário');
        }
    } else {
        wp_send_json_error('ID do usuário ausente');
    }
}
?>