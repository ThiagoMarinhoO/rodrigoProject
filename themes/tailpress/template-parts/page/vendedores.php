<?php
get_header();

$args = array(
    'role' => 'subscriber',
);

$users = get_users($args);

?>

<div id="loading-animation"></div>
<div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
    <div class="mb-12">
        <h2 class="text-gray-950 text-3xl font-semibold">Bem vindo ao Dashboard de Vendedores</h2>
        <p class="text-gray-600 text-sm">Gerencie por aqui seus vendedores</p>
    </div>
    <div class="mb-12">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                    Vendedores
                    <p class="mt-1 text-sm font-normal text-gray-500">Esta é sua lista de vendedores</p>
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Nome do vendedor
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Próximo pagamento
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Salário (R$)
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Tipo de pagamento
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Total de vendas
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Ação
                        </th>
                    </tr>
                </thead>
                <tbody id="sellesTable">
                <?php if (!empty($users)) :
                    foreach ($users as $user) :
                        $args_posts = array(
                            'author' => $user->ID,
                            'post_type' => 'sales',
                            'post_status' => 'publish',
                            'posts_per_page' => -1
                        );
                        $user_posts = new WP_Query($args_posts);
                        $count_posts = $user_posts->found_posts;
                    ?>
                        <tr class="bg-white border-b hover:bg-gray-50" user-id="<?php echo $user->ID?>">
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                <?php echo $user->ID?>
                            </td>
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap username">
                                <?php echo $user->display_name?>
                            </td>
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                <?php echo get_field('data_do_pagamento', 'user_'.$user->ID);?>
                            </td>
                            <td class="px-6 py-4 text-gray-950 font-bold">
                                <?php echo 'R$' . number_format(get_field('salario' , 'user_'.$user->ID), 2, ',', '.');?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo get_field('tipo_de_pagamento' , 'user_'.$user->ID) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $count_posts ?>
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button type="button" class="paymentEfetued">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                </button> 
                                <button type="button" class="deleteSeller text-red-500">
                                    <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
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