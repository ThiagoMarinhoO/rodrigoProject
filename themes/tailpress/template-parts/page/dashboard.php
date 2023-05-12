<?php
get_header();

$args = array(
    'post_type' => 'products',
    'posts_per_page' => 5
);
$dash_product_query = new WP_Query($args);
?>


<?php if ( is_user_logged_in() ) { ?>
    <div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
        <div class="mb-12">
            <h2 class="text-gray-950 text-3xl font-semibold">Nossos Produtos</h2>
            <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ultrices lectus sem.</p>
        </div>
        <div class="mb-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                                Categoria
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                                Preço
                            </th>
                        </tr>
                    </thead>
                    <?php if($dash_product_query->have_posts()):?>
                    <tbody>
                        <?php while($dash_product_query->have_posts()): $dash_product_query->the_post();?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?php the_title();?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo '#' . $post->ID;?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo get_field('product_category', $post->ID);?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo 'R$' . get_field('product_price', $post->ID);?>
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