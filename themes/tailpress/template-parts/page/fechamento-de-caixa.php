<?php get_header() ?>

<?php
get_header();

$args = array(
    'post_type' => 'caixa',
    'post_status' => array(
        'publish',
    ),
    'posts_per_page' => -1
);
$caixa = new WP_Query($args);
?>

<div id="loading-animation"></div>
<div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl mx-auto pt-12">
    <div class="mb-12">
        <h2 class="text-gray-950 text-3xl font-semibold">Bem vindo ao Dashboard de Fechamento de caixa</h2>
        <p class="text-gray-600 text-sm">Confira os últimos caixas</p>
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
                            ID do caixa
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Data
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Total de itens vendidos
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Valor total de vendas (R$)
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Vendedor
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold text-gray-600 whitespace-nowrap">
                            Vendas do dia
                        </th>
                    </tr>
                </thead>
                <tbody id="caixaTable">
                <?php if($caixa->have_posts()):?>
                    <?php while($caixa->have_posts()): $caixa->the_post();?>
                    <tr class="bg-white border-b hover:bg-gray-50" caixa-id="<?php echo get_the_ID()?>">
                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                            <?php echo get_the_ID()?>
                        </td>
                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                            <?php echo get_the_date('d/m/Y H:i:s'); ?>
                        </td>
                        <td class="px-6 py-4 text-gray-950 font-bold">
                            <?php echo get_field('total_de_vendas_do_dia' , get_the_ID())?>
                        </td>
                        <td class="px-6 py-4 text-gray-950 font-bold">
                            <?php echo 'R$' . number_format(get_field('valor_total_de_vendas' , get_the_ID()), 2, ',', '.');?>
                        </td>
                        <td class="px-6 py-4">
                            <?php the_author()?>
                        </td>
                        <td class="px-6 py-4">
                            <?php while( have_rows('vendas_do_dia') ) : the_row(); ?>
                                <?php 
                                    $id_venda = get_sub_field('id_da_venda');
                                    echo 'Venda ' . $id_venda;  
                                ?>
                            <?php endwhile; ?>
                        </td>
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

<?php get_footer()?>