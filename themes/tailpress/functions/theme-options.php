<?php 

function cpt_produtos() {
	register_post_type('products',
		array(
			'labels'      => array(
				'name'          => __( 'Produtos', 'textdomain' ),
				'singular_name' => __( 'Produto', 'textdomain' ),
			),
			'public'      => true,
			'has_archive' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
			'rewrite'     => array( 'slug' => 'products' ), // my custom slug
            'query_var' => true,
            'menu_icon' => 'dashicons-products',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'author',
                'excerpt'
            ),
        )
	);
}
add_action('init', 'cpt_produtos');


?>