<?php
get_header();

$args = array(
    'post_type' => 'products'
);

$products_query = new WP_Query( $args );
?>


<?php if ( is_user_logged_in() ) { ?>
    <div id="loading-animation"></div>
    <div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
        <div class="mb-12">
            <h2 class="text-gray-950 text-3xl font-semibold">Seus Produtos</h2>
            <p class="text-gray-600 text-sm">Busque os produtos cadastrados no estoque ou adicione novos.</p>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex items-center justify-between p-4 bg-white">
                <div>
                    <button id="adicionarProduto" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center mr-2 inline-flex items-center cursor-pointer">
                        Adicionar Produto
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <!-- Modal content -->
                    <div id="AdicionarProdutoModal" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 max-h-full bg-gray-950 bg-opacity-50">
                        <div class="container max-w-3xl p-6 relative bg-white rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="py-2 border-b rounded-t mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Informações do Produto
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="mb-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="">
                                        <label for="productName" class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                                        <input type="text" name="product_name" id="productName" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Nome" required="">
                                    </div>
                                    <div class="">
                                        <label for="marca" class="block mb-2 text-sm font-medium text-gray-900">Marca</label>
                                        <input type="text" name="product_marca" id="productMarca" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Marca" required="">
                                    </div>
                                    <div class="">
                                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Preço</label>
                                        <input type="number" name="product_price" id="productPrice" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Preço" required="">
                                    </div>
                                    <div class="">
                                        <label for="productCategory" class="block mb-2 text-sm font-medium text-gray-900">Categoria</label>
                                        <input type="text" name="product_category" id="productCategory" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Categoria" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descrição</label>
                                        <input type="text" name="product_description" id="productDescription" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="adicione aqui uma breve descrição do produto" required="">
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div id="publishButton" class="pt-5 flex items-center space-x-2 border-t border-gray-200 rounded-b">
                                <button type="button"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cadastrar Produto</button>
                            </div>
                        </div>
                    </div>
                    <button id="importarProdutos" type="button" class="py-2 px-5 mr-2 text-sm font-medium text-blue-700 bg-white rounded-lg border border-blue-700 hover:bg-gray-100 hover:underline focus:z-10 focus:ring-2 focus:outline-none focus:ring-blue-700 focus:text-blue-700 inline-flex items-center cursor-pointer">
                        Importar Produtos
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <!-- Modal content -->
                    <div id="importarProdutoModal" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 max-h-full bg-gray-950 bg-opacity-50">
                        <div class="container max-w-3xl p-6 relative bg-white rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="py-2 border-b rounded-t mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Upload de Produtos
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="mb-5">
                            <div>
                                <!-- <input type="file" class="cursor-pointer file:cursor-pointer file:mr-3 block w-full mt-2 text-sm text-gray-950 bg-gray-100 border border-gray-200 rounded-lg file:bg-gray-900 file:text-white file:text-sm file:px-4 file:py-2 file:border-none file:rounded-md placeholder-gray-400/70 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" /> -->
                                <form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                                    <input type="hidden" name="action" value="import_products">
                                    <label for="csv_file">Arquivo CSV:</label>
                                    <input type="file" class="cursor-pointer file:cursor-pointer file:mr-3 block w-full mt-2 text-sm text-gray-950 bg-gray-100 border border-gray-200 rounded-lg file:bg-gray-900 file:text-white file:text-sm file:px-4 file:py-2 file:border-none file:rounded-md placeholder-gray-400/70 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" name="csv_file" id="csv_file">
                                    <?php wp_nonce_field( 'import_products_nonce', 'import_products_nonce' ); ?>
                                    <hr class="mt-8 mb-3">
                                    <input type="submit" class="admin-btn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" name="submit" value="Importar">
                                </form>
                            </div>
                            
                            </div>
                            <!-- Modal footer -->
                            <!-- <div class="pt-5 flex items-center space-x-2 border-t border-gray-200 rounded-b">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Importar Produtos</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar produtos">
                </div>
            </div>
            <table id="productsTable" class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Preço
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Ação
                        </th>
                    </tr>
                </thead>
                <?php if($products_query->have_posts()):?>
                <tbody>
                    <?php while($products_query->have_posts()): $products_query->the_post();?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap product-name">
                            <?php the_title();?>
                        </th>
                        <td class="px-6 py-4">
                            <?php echo '#' . $post->ID;?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo 'R$' . number_format(get_field('product_price', $post->ID), 2, ',', '.');?>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <?php endif; ?>
            </table>
        </div>
        <!-- Modal -->
        <!-- <div id="Modal" class=""></div> -->
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