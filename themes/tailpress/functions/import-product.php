<?php
function add_product_submenu() {
	add_submenu_page(
		'edit.php?post_type=produtos',
		'Importar produtos',
		'Importar produtos',
		'manage_options',
		'importar-produtos',
		'import_products_page'
	);
}
add_action( 'admin_menu', 'add_product_submenu' );

function process_import() {
	if ( isset( $_POST['submit'] ) && isset( $_FILES['csv_file'] ) ) {
		if ( $_FILES['csv_file']['error'] == UPLOAD_ERR_OK && $_FILES['csv_file']['type'] == 'text/csv' ) {
			$file = fopen( $_FILES['csv_file']['tmp_name'], 'r' );
			fgetcsv($file);
			while ( ( $data = fgetcsv( $file ) ) !== FALSE ) {
				$product_name = $data[0];
				$market_price = $data[1];
				$stock = $data[2];
				$price = $data[3];
                $code = $data[4];
				$price_type = $data[5];

				$market_price = str_replace('R$', '', $market_price);
				$market_price = str_replace(',', '.', $market_price);

				$args = array(
					'post_type' => 'products',
					'post_title' => $product_name,
					'post_status' => 'publish',
				);	

				$existing_products = get_posts( $args );
				if ( ! empty( $existing_products ) ) {
					foreach ( $existing_products as $existing_product ) {
						$product_id = $existing_product->ID;
						$product_code = get_field( 'barcode', $product_id );
						if ( $product_code == $code ) {
							if ($price_type == 'Sim' || $price_type == 'sim') {
								$new_price = $market_price + ($market_price * $price / 100);
								update_field( 'product_price', $new_price, $product_id );
							} else {
								update_field( 'product_price', $price, $product_id );
							}
							update_field( 'estoque', $stock + get_field('estoque' , $product_id), $product_id );
							update_field( 'barcode', $code, $product_id );
							update_field( 'market_price', $market_price, $product_id );
							$transacao = array(
								'post_title'   => '[Saída] - Atualização de estoque do produto ' . $product_name,
								'post_status'  => 'publish',
								'post_type'    => 'transacoes',
							  );
						
							  $transacao_id = wp_insert_post( $transacao );
						
							  update_field('tipo' , 'saida' , $transacao_id);
							  update_field('produto_cadastrado' , $product_name , $transacao_id);
							  update_field('valor_da_transacao' , $market_price * $stock , $transacao_id);
							  $stock != 0 ? update_field('quantidade_cadastrada' ,$stock , $transacao_id) : 0;
							continue 2;
						}
					}
				}
				$new_post = array(
					'post_title' => $product_name,
					'post_status' => 'publish',
					'post_type' => 'products',
				);
				$product_id = wp_insert_post( $new_post );

				if ($price_type == 'sim' || $price_type == 'Sim') {
					$new_price = $market_price + ($market_price * $price / 100);
					update_field( 'product_price', $new_price, $product_id );
				} else {
					update_field( 'product_price', $price, $product_id );
				}

				update_field( 'market_price', $market_price, $product_id );

				update_field( 'estoque', $stock, $product_id );
				update_field( 'barcode', $code, $product_id );

				$transacao = array(
					'post_title'   => '[Saída] - Cadastro de estoque do novo produto ' . $product_name,
					'post_status'  => 'publish',
					'post_type'    => 'transacoes',
				  );
			
				  $transacao_id = wp_insert_post( $transacao );
			
				  update_field('tipo' , 'saida' , $transacao_id);
				  update_field('produto_cadastrado' , $product_name , $transacao_id);
				  update_field('valor_da_transacao' , $market_price * $stock , $transacao_id);
				  update_field('quantidade_cadastrada' ,$stock , $transacao_id);
			}
			fclose( $file );
		}
        wp_redirect( home_url( '/admin-produtos' ) );
        exit;
	}
}
add_action( 'admin_post_import_products', 'process_import' );

function import_products_capability( $capability ) {
	return 'manage_options';
}
add_filter( 'option_page_capability_importar-produtos', 'import_products_capability' );
?>