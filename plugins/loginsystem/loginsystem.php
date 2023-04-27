<?php
    /*
    Plugin Name: Login System
    Plugin URI: #
    Description: Sitema de funcionários do site seilá.
    Version: 1.0.0
    Author: Thiago Marinho
    Author URI: #
    License: GPL2
    */

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


    function create_products(WP_REST_Request $request) {
      // Recebe os dados da requisição
      $title = $request['title'];
      $excerpt = $request['description'];
      $author = $request['author'];
      $brand = $request['brand'];
      $price = $request['price'];
      $category = $request['category'];
  
      // Cria um novo post
      $post = array(
        'post_title'   => $title,
        'post_excerpt' => $excerpt,
        'post_status'  => 'publish',
        'post_type'    => 'products',
        'post_author'  => $author,
      );

      $post_id = wp_insert_post( $post );

      update_field('product_brand' , $brand , $post_id);
      update_field('product_price' , $price , $post_id);
      update_field('product_category' , $category , $post_id);
  
      // Retorna a resposta da API
      if ( $post_id ) {
        $response = array(
          'success' => true,
          'post_id' => $post_id
        );
        wp_send_json_success( $response );
      } else {
        $response = array(
          'success' => false,
          'error'   => 'Erro ao criar o post'
        );
        wp_send_json_error( $response );
      }
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'loginsystem/v1', '/products', array(
        'methods' => 'POST',
        'callback' => 'create_products',
      ) );
    } );

    function get_products(WP_REST_Request $request) {
      
      // Retorna a resposta da API
      $args = array(
        'post_type' => 'products',
        'post_status' => 'publish',
        'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
        'paged' => $request->get_param( 'page' ) ?: 1,
        'orderby' => $request->get_param( 'orderby' ) ?: 'date',
        'order' => $request->get_param( 'order' ) ?: 'desc',
        'category' => $request->get_param( 'categories' ),
        'tag' => $request->get_param( 'tags' ),
        's' => $request->get_param( 'search' ),
      );

      $query = new WP_Query( $args );
      $posts = array();

      if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
              $query->the_post();
              $post = get_post();
              $post_data = array(
                  'id' => $post->ID,
                  'date' => date('M d, Y', strtotime($post->post_date)),
                  'date_gmt' => $post->post_date_gmt,
                  'guid' => array(
                      'rendered' => get_permalink( $post->ID ),
                  ),
                  'modified' => $post->post_modified,
                  'modified_gmt' => $post->post_modified_gmt,
                  'slug' => $post->post_name,
                  'status' => $post->post_status,
                  'type' => $post->post_type,
                  'link' => get_permalink( $post->ID ),
                  'title' => array(
                      'rendered' => get_the_title( $post->ID ),
                  ),
                  'content' => array(
                      'rendered' => strip_tags(get_the_content($post->ID)),
                      'protected' => false,
                  ),
                  'excerpt' => array(
                      'rendered' => apply_filters( 'the_excerpt', $post->post_excerpt ),
                      'protected' => false,
                  ),
                  'author' => array(
                      'name' => get_the_author($post),
                      'bio' => get_the_author_meta('description', $post->post_author ),
                  ),
                  'featured_media' => $post->featured_media,
                  'comment_status' => $post->comment_status,
                  'ping_status' => $post->ping_status,
                  // 'sticky' => $post->is_sticky(),
                  'template' => $post->page_template,
                  'format' => get_post_format( $post->ID ),
                  'categories' => wp_get_post_categories( $post->ID, array( 'fields' => 'names' ) ),
                  'tags' => wp_get_post_tags( $post->ID, array( 'fields' => 'names' ) ),
                  'meta' => get_post_meta( $post->ID ),
              );
              $posts[] = $post_data;
          }
      }

      wp_reset_postdata();

      $response = new WP_REST_Response( $posts );
      $response->set_status( 200 );
      return $response;
    }

    add_action( 'rest_api_init', function () {
      register_rest_route( 'loginsystem/v1', '/products', array(
        'methods' => 'GET',
        'callback' => 'get_products',
      ) );
    } );