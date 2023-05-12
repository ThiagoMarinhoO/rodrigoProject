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

    
    $plugin_dir_path = plugin_dir_path( __FILE__ );

    require_once($plugin_dir_path . "/routes/login.php");
    require_once($plugin_dir_path . "/routes/cadastro.php");

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
                  'title' =>  get_the_title( $post->ID ),
                  'price' => get_field('product_price', $post->ID),
                  'category' => get_field('product_category', $post->ID),
                  'brand' => get_field('product_brand', $post->ID),
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