<?php
get_header();

$args = array(
    'post_type' => 'sales',
    'post_status' => array(
        'publish', // Published posts
        'pending', // Pending review posts
        'draft', // Pending review posts
    ),
    'posts_per_page' => 20
);
$dash_product_query = new WP_Query($args);
?>


<?php if ( is_user_logged_in() ) { ?>
    <div id="loading-animation"></div>
    <div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
        <div class="mb-12">
            <h2 class="text-gray-950 text-3xl font-semibold">Bem vindo ao Dashboard de Vendas</h2>
            <p class="text-gray-600 text-sm">Gerencie por aqui suas vendas</p>
        </div>
        <div class="mb-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                        Transações
                        <p class="mt-1 text-sm font-normal text-gray-500">Esta é sua lista de transações desenvolvida para te ajudar a se manter organizado e informados de suas vendas recentes</p>
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                Produtos
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                Data
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                Valor (R$)
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                Vendedor
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                                -
                            </th>
                        </tr>
                    </thead>
                    <?php if($dash_product_query->have_posts()):?>
                    <tbody>
                        <?php while($dash_product_query->have_posts()): $dash_product_query->the_post();?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <?php if( have_rows('produtos_da_venda') ): ?>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                                <?php while( have_rows('produtos_da_venda') ) : the_row(); ?>
                                    <?php 
                                        $nome_do_produto = get_sub_field('nome');
                                        $qty_do_produto = get_sub_field('quantidade');
                                        echo $nome_do_produto. ' ' . '(' . $qty_do_produto . ')';  
                                    ?>
                                <?php endwhile; ?>
                            </th>
                            <?php endif;?>
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                <?php echo get_the_date('d/m/Y'); ?>
                            </td>
                            <td class="px-6 py-4 text-gray-950 font-bold">
                                <?php echo 'R$' . number_format(get_field('valor_da_venda' , get_the_ID()), 2, ',', '.');?>
                            </td>
                            <td class="px-6 py-4">
                                <?php the_author()?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (get_post_status() == 'publish') {
                                    echo '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Efetuada</span>';
                                } else if(get_post_status() == 'pending') {
                                    echo '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Pendente</span>';
                                } else {
                                    echo '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Cancelada</span>';
                                }?>
                            </td>
                            <td class="px-6 py-4 flex justify-center">
                                <?php if (get_post_status() == 'publish') {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="deleteSale w-5 h-5 text-red-500 cursor-pointer" data-id="' . $post->ID . '" data-status="draft">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>';
                                } else {
                                    echo '<a class="editSalesButton text-green-500 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded cursor-pointer hover:underline" data-id="' . $post->ID . '" data-status="publish">Efetuar</a>';
                                }?>
                                
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="md:flex min-h-screen">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <div class="max-w-sm m-8">
            <div class="text-5xl md:text-15xl text-gray-800 border-primary border-b">Não autenticado</div>
            <div class="w-16 h-1 bg-purple-light my-3 md:my-6"></div>
            <p class="text-gray-800 text-2xl md:text-3xl font-light mb-8"><?php _e( 'Desculpe, use as suas credenciais para fazer login', 'tailpress' ); ?></p>
            <a href="<?php echo get_bloginfo( 'url' ); ?>" class="bg-primary px-4 py-2 rounded text-white">
                <?php _e( 'Fazer Login', 'tailpress' ); ?>
            </a>
        </div>
    </div>
</div>
<?php } ?>


<?php
get_footer();
?>