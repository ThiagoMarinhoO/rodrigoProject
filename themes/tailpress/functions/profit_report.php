<?php
add_action('wp_ajax_profit_report', 'profit_report');
add_action('wp_ajax_nopriv_profit_report', 'profit_report');
function profit_report(){
    $start_date = $_POST['startDate'];

    $args_products = array(
        'post_type' => 'transacoes',
        'posts_per_page' => -1,
        'post_status'  => 'publish',
        'meta_query' => array(
            array(
                'key' => 'tipo',
                'value' => 'saida',
                'compare' => '=',
            ),
        ),
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $start_date,
                'inclusive' => true,
            )
        )
    );
    $args_sales = array(
        'post_type' => 'sales',
        'posts_per_page' => -1,
        'post_status'  => 'publish',
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $start_date,
                'inclusive' => true,
            )
        )
    );
    $query_products = new WP_Query($args_products);
    $query_sales = new WP_Query($args_sales);
    $total_market_price = 0;
    $transacao_price = 0;
    while ($query_products->have_posts()) {
        $query_products->the_post();
        $transacao_id = get_the_ID();
        $transacao_price += get_field('valor_da_transacao' , $transacao_id);
    }
    $sales_total = 0;
    while ($query_sales->have_posts()) {
        $query_sales->the_post();
            $sales_total += get_field('valor_da_venda' , get_the_ID());
    }
    wp_reset_postdata();

    wp_send_json_success(array(
        'total_market_price' => $transacao_price,
        'sales_total' => $sales_total,
        'sales' => sales_table($start_date),
        'transacoes' => transacao_table($start_date)
    ));
}
add_action('wp_ajax_init_profit', 'init_profit');
add_action('wp_ajax_nopriv_init_profit', 'init_profit');
function init_profit(){
    $start_date = null;
    $args_products = array(
        'post_type' => 'transacoes',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'tipo',
                'value' => 'saida',
                'compare' => '=',
            ),
        ),
    );
    $args_sales = array(
        'post_type' => 'sales',
        'post_status'  => 'publish',
        'posts_per_page' => -1,
    );
    $query_products = new WP_Query($args_products);
    $query_sales = new WP_Query($args_sales);
    $transacao_price = 0;
    while ($query_products->have_posts()) {
        $query_products->the_post();
        $transacao_id = get_the_ID();
        $transacao_price += get_field('valor_da_transacao' , $transacao_id);
    }
    $profit_infos = array();
    $sales_total = 0;
    while ($query_sales->have_posts()) {
        $query_sales->the_post();
        $sales_total += get_field('valor_da_venda' , get_the_ID());
    }
    wp_reset_postdata();

    wp_send_json_success(array(
        'total_market_price' => $transacao_price,
        'sales_total' => $sales_total,
        'sales' => sales_table($start_date),
        'transacoes' => transacao_table($start_date)
    ));
}

function sales_table($start_date){

    $args_products = array(
        'post_type' => 'sales',
        'posts_per_page' => -1,
        'post_status' => array(
            'publish',
            'pending',
            'draft',
        ),
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $start_date,
                'inclusive' => true,
            )
        )
    );

    $dash_product_query = new WP_Query($args_products);

    ob_start();

    if ($dash_product_query->have_posts()) : ?>
        <?php while ($dash_product_query->have_posts()) : $dash_product_query->the_post(); ?>
            <tr class="bg-white border-b hover:bg-gray-50" sale-id="<?php echo get_the_ID()?>">
                <?php if (have_rows('produtos_da_venda')) : ?>
                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                        <?php echo get_the_ID() ?>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                        <?php while (have_rows('produtos_da_venda')) : the_row(); ?>
                            <?php
                            $nome_do_produto = get_sub_field('nome');
                            $qty_do_produto = get_sub_field('quantidade');
                            echo $nome_do_produto . ' ' . '(' . $qty_do_produto . ')';
                            ?>
                        <?php endwhile; ?>
                    </th>
                <?php endif; ?>
                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                    <?php echo get_the_date('d/m/Y'); ?>
                </td>
                <td class="px-6 py-4 text-gray-950 font-bold">
                    <?php echo 'R$' . number_format(get_field('valor_da_venda', get_the_ID()), 2, ',', '.'); ?>
                </td>
                <td class="px-6 py-4">
                    <?php the_author() ?>
                </td>
                <td class="px-6 py-4">
                    <?php if (get_post_status() == 'publish') {
                        echo '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Efetuada</span>';
                    } else if (get_post_status() == 'pending') {
                        echo '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Pendente</span>';
                    } else {
                        echo '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Cancelada</span>';
                    } ?>
                </td>
                <td class="px-6 py-4 flex justify-center">
                    <?php if (get_post_status() == 'publish') {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="deleteSale w-5 h-5 text-red-500 cursor-pointer" data-id="' . $post->ID . '" data-status="draft">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>';
                    } else {
                        echo '<a class="editSalesButton text-green-500 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer hover:underline" data-id="' . $post->ID . '" data-status="publish">Efetuar</a>';
                    } ?>

                </td>
            </tr>
        <?php endwhile; ?>
    <?php endif;

    $html = ob_get_clean();
    return $html;
}

function transacao_table($start_date){

    $args_products = array(
        'post_type' => 'transacoes',
        'posts_per_page' => -1,
        'post_status' => array(
            'publish',
            'pending',
            'draft',
        ),
        'date_query' => array(
            array(
                'after' => $start_date,
                'before' => $start_date,
                'inclusive' => true,
            )
        )
    );

    $dash_product_query = new WP_Query($args_products);

    ob_start();

     if($dash_product_query->have_posts()):?>
        <?php while($dash_product_query->have_posts()): $dash_product_query->the_post();?>
        <tr class="bg-white border-b hover:bg-gray-50" sale-id="<?php echo get_the_ID()?>">
            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                <?php echo get_the_ID()?>
            </td>
            <td class="px-6 py-4 text-gray-600">
                <?php echo the_title()?>
            </td>
            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                <?php echo get_the_date('d/m/Y'); ?>
            </td>
            <?php if (get_field('tipo' , get_the_ID()) == 'entrada') {
                    ?>
                    <td class="px-6 py-4 text-green-800 font-bold whitespace-nowrap">
                        <?php echo '+ R$' . number_format(get_field('valor_da_transacao' , get_the_ID()), 2, ',', '.');?>
                    </td>
                    <?php
            }else{
                ?>
                <td class="px-6 py-4 text-red-800 font-bold whitespace-nowrap">
                    <?php echo '- R$' . number_format(get_field('valor_da_transacao' , get_the_ID()), 2, ',', '.');?>
                </td>
                <?php
            }?>
            <td class="px-6 py-4 whitespace-nowrap">
                <?php if (get_field('tipo' , get_the_ID()) == 'entrada') {
                    echo '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Entrada</span>';
                } else {
                    echo '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Saída</span>';
                }?>
            </td>
            <!-- <td class="px-6 py-4 flex justify-center">
                <?php #if (get_post_status() == 'publish') {
                    #echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="deleteSale w-5 h-5 text-red-500 cursor-pointer" data-id="' . $post->ID . '" data-status="draft">
                    #<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                   # </svg>';
                #} else {
                    #echo '<a class="editSalesButton text-green-500 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer hover:underline" data-id="' . $post->ID . '" data-status="publish">Efetuar</a>';
                #}?>
                
            </td> -->
        </tr>
        <?php endwhile; ?>
    <?php endif; 

    $html = ob_get_clean();
    return $html;
}
?>