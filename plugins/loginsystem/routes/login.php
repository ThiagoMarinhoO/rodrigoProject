<?php 

add_action( 'rest_api_init', function () {
    register_rest_route( 'loginsystem/v1', '/login', array(
      'methods' => 'POST',
      'callback' => 'custom_login',
    ) );
  } );
  
  function custom_login( WP_REST_Request $request ) {
    $creds = array();
    $creds['user_login'] = $request['email'];
    $creds['user_password'] = $request['password'];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
    if ( is_wp_error( $user ) ) {
      return $user;
    } else {
      return array(
        'user_id' => $user->ID,
        'username' => $user->user_login,
        'display_name' => $user->display_name,
        'email' => $user->user_email,
        'role' => $user->roles[0],
      );
    }
  }

?>