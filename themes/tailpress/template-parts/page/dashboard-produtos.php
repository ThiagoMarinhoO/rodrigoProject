<?php
get_header();

$args = array(
    'post_type' => 'products',
    'posts_per_page' => -1
);

$products_query = new WP_Query( $args );
?>


<?php if ( is_user_logged_in() ) { ?>
    <div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
        <div id="loading-animation"></div>
        <div class="mb-12">
            <h2 class="text-gray-950 text-3xl font-semibold">Seus Produtos</h2>
            <p class="text-gray-600 text-sm">Digite o nome do produto desejado.</p>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex items-center justify-between p-4 bg-white">
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
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Preço
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Estoque
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Ação
                        </th>
                    </tr>
                </thead>
                <?php if($products_query->have_posts()):?>
                <tbody>
                    <?php while($products_query->have_posts()): $products_query->the_post();?>
                    <tr class="bg-white border-b hover:bg-gray-50 product-table" product-id="<?php echo get_the_ID()?>">
                            <input type="hidden" name="quantidade" value="1">
                            <td class="px-6 py-4">
                                <?php echo '#' . $post->ID;?>
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap product-name">
                                <?php the_title();?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo 'R$' . number_format(get_field('product_price', $post->ID), 2, ',', '.');?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo get_field('estoque' , $post->ID)?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if(get_field('estoque' , $post->ID) != 0):?>
                                    <button class="font-medium text-blue-600 hover:underline add-to-cart-btn">Adicionar ao Carrinho</button>
                                <?php else: ?>
                                    <span class="text-red-600">Produto sem estoque</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <?php else: ?>
                    <?php echo 'Nenhum produto cadastrado'?>
                <?php endif; ?>
            </table>
        </div>
        <!-- drawer init and show -->
        <div class="text-center m-5">
            <button onclick="document.querySelector('#readProductDrawer').classList.remove('-translate-x-full')" id="cartButton" class="hidden bg-white hover:bg-gray-50 focus:ring-4 focus:ring-primary-300 p-3 mr-2 mb-2 rounded-full focus:outline-none fixed bottom-5 right-5" >
                <span id="cartCounter" class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-white bg-red-600 rounded-full absolute top-0 right-0"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </button>
        </div>

        <!-- drawer component -->
        <div id="readProductDrawer" class="overflow-y-auto fixed top-0 left-0 z-40 p-4 w-full max-w-xs h-screen bg-white transition-transform -translate-x-full">
            <div class="mb-5">
                <h4 id="drawer-label" class="mb-1.5 leading-none text-xl font-semibold text-gray-900">Carrinho de Compras</h4>
            </div>
            <button type="button" onclick="document.querySelector('#readProductDrawer').classList.add('-translate-x-full')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close menu</span>
            </button>
            <div id="productDrawerList" class="p-3 mb-3 divide-y divide-gray-200 border-b border-gray-200">
            </div>
            <div class="subtotal p-3 mb-3 flex justify-between">
                <p class="font-semibold">Subtotal</p>
                <p id="subtotal" class="font-lg font-extrabold">R$ 0,00</p>
            </div>
            <div class="mb-4">
                <label id="labelVendedores" for="vendedores" class="block mb-2 text-sm font-medium text-gray-900">Selecione um vendedor</label>
                <select id="vendedores" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected value="">Vendedor</option>
                    <?php
                        $vendedores = get_users( array(
                            'role'    => 'Subscriber',
                            'orderby' => 'user_nicename',
                            'order'   => 'ASC'
                        ) );

                        foreach($vendedores as $vendedor) {
                            $vendedor_id = $vendedor->ID;
                            $vendedor_name = $vendedor->user_nicename;

                            echo '<option value="' . $vendedor_id . '">' . $vendedor_name . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label id="labelPaymentMethod" for="paymentMethod" class="block mb-2 text-sm font-medium text-gray-900">Forma de pagamento</label>
                <select id="paymentMethod" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option disabled value="">Selecione a forma de pagamento</option>
                    <option value="Pix">Pix</option>
                    <option value="Débito">Débito</option>
                    <option value="Crédito">Crédito</option>
                    <option value="Dinheiro">Dinheiro</option>
                </select>
            </div>
            <!-- <div class="mb-4">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Possui desconto?</h3>
                <ul class="grid w-full gap-2 md:grid-cols-2">
                    <li>
                        <input type="radio" id="discountActive" name="discount" value="sim" class="hidden discountInput peer" required>
                        <label for="discountActive" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                            Sim
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="notDiscount" name="discount" value="nao" class="hidden discountInput peer">
                        <label for="notDiscount" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                            Não
                        </label>
                    </li>
                </ul>
            </div>
            <div class="mb-4 hidden discountValue">
                <label class="block mb-2 text-sm font-medium text-gray-900">Forma de pagamento</label>
                <input type="text" id="percentageValue" placeholder="Digite a porcentagem (%)" class="w-full bg-white text-black rounded-md border-x border-y border-b-gray-300 h-10 px-4">
            </div> -->
            <div class="flex justify-center pb-4 space-x-4 w-full md:px-4">
                <button id="close_sale" type="button" class="text-white w-full inline-flex items-center justify-center bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    confirmar venda
                </button> 
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