<?php
get_header();

$args = array(
    'post_type' => 'transacoes',
    'post_status' => array(
        'publish',
        'pending',
        'draft',
    ),
    'posts_per_page' => 20
);
$dash_product_query = new WP_Query($args);
?>

<div id="loading-animation"></div>
<div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
    <div class="mb-12">
        <h2 class="text-gray-950 text-3xl font-semibold">Bem vindo ao Dashboard de transações</h2>
        <p class="text-gray-600 text-sm">Gerencie por aqui suas transações</p>
    </div>
    <div class="w-full mb-3 flex justify-between gap-5 items-center">
        <div class="w-4/5">
            <label>Selecione a data da venda</label>
            <input type="date" name="profit_date" class="profit-date w-full py-2 px-5 bg-white rounded-md shadow-md">
        </div>
        <div class="w-1/5 flex justify-center items-center">
            <button type="button" id="clearFilter" disabled class="py-2 px-5 bg-blue-700 rounded-md mt-6 text-white w-full disabled:bg-gray-300 disabled:opacity-80 shadow-md">Limpar filtro</button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7 mb-5">
        <div class="px-4 py-3 bg-white rounded-md shadow-md">
            <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
            <div class="my-3">
                <h1 id="saidas_balanco" class="text-2xl font-bold text-red-600 ">-R$0,00</h1>
                <p class="text-sm font-normal text-gray-500">Saídas</p>
            </div>
        </div>
        <div class="px-4 py-3 bg-white rounded-md shadow-md">
            <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
            <div class="my-3">
                <h1 id="entradas_balanco" class="text-2xl font-bold text-green-600">+R$0,00</h1>
                <p class="text-sm font-normal text-gray-500">Entradas</p>
            </div>
        </div>
        <div class="px-4 py-3 bg-white rounded-md shadow-md">
            <div class="w-fit p-2.5 bg-indigo-50 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
            <div class="my-3">
                <h1 id="profit_value" class="text-2xl font-bold text-gray-800">R$0,00</h1>
                <p class="text-sm font-normal text-gray-500">Lucro</p>
            </div>
        </div>
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
                            ID da transação
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600">
                            Identificação
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Data
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Valor (R$)
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Tipo
                        </th>
                        <!-- <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Ação
                        </th> -->
                    </tr>
                </thead>
                <tbody id="transacaoTable">
                <?php if($dash_product_query->have_posts()):?>
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
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo do_shortcode('[modalNewUser]')?>
<?php
get_footer();
?>