<?php
$args = array(
    'post_type' => 'products',
    'posts_per_page' => 5
);
$dash_product_query = new WP_Query($args);
?>

<?php if ( is_user_logged_in() ) { ?>
    <div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mb-32">
            <div class="px-4 py-3 bg-white rounded-md shadow-md">
                <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="my-3">
                    <h1 class="text-2xl font-bold text-gray-800">R$2000,00</h1>
                    <p class="text-sm font-normal text-gray-500">Balanço Diário</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-white rounded-md shadow-md">
                <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="my-3">
                    <h1 class="text-2xl font-bold text-gray-800">R$2000,00</h1>
                    <p class="text-sm font-normal text-gray-500">Balanço Semanal</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-white rounded-md shadow-md">
                <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="my-3">
                    <h1 class="text-2xl font-bold text-gray-800">R$2000,00</h1>
                    <p class="text-sm font-normal text-gray-500">Balanço Mensal</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-white rounded-md shadow-md">
                <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="my-3">
                    <h1 class="text-2xl font-bold text-gray-800">R$2000,00</h1>
                    <p class="text-sm font-normal text-gray-500">Balanço Semestral</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-blue-700 rounded-md shadow-md col-span-3 flex justify-center items-center relative">
                <div class="absolute top-0 left-0">
                    <img src="/wp-content/themes/tailpress/assets/linessla.svg" alt="">
                </div>
                <div class="">
                    <h1 class="text-4xl font-bold text-white mb-3">R$2000,00</h1>
                    <p class="text-sm font-normal text-white text-center">Balanço Semestral</p>
                </div>
            </div>
            <div class="px-4 py-3 bg-white rounded-md shadow-md">
                <p class="text-lg font-semibold text-gray-950 mb-6">Mais Vendido</p>
                <div class="">
                    <img src="https://images.unsplash.com/photo-1634712282287-14ed57b9cc89?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1206&q=80" class="rounded-md" />
                </div>
                <div class="my-3">
                    <h1 class="text-lg font-bold text-gray-800">R$2000,00</h1>
                    <p class="text-sm font-normal text-gray-500">Nome de Produto</p>
                </div>
            </div>
        </div>
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