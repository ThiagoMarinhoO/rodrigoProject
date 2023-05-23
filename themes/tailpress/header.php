<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-white text-gray-900 antialiased' ); ?>>

<?php do_action( 'tailpress_site_before' ); ?>

<div id="page" class="min-h-screen flex flex-col bg-gray-200">

	<?php do_action( 'tailpress_header' ); ?>

	<header class="bg-white border-gray-200">
		<?php if (!is_page( 54 ) && !is_front_page() ) { ?>
			<div class="max-w-xs sm:max-w-lg md:max-w-3xl lg:max-w-5xl max-2xl:max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
				<a href="https://flowbite.com/" class="flex items-center">
					<img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
					<span class="self-center text-2xl font-semibold whitespace-nowrap">Flowbite</span>
				</a>
				<div class="flex items-center md:order-2 group relative">
					<div class="flex-column gap-2 mr-3 cursor-pointer">
						<p class="text-sm font-semibold"><?php echo wp_get_current_user()->display_name;?></p>
						<p class="text-xs text-gray-500"><?php echo wp_get_current_user()->roles[0];?></p>
					</div>
					<button type="button" class="flex mr-3 text-sm rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 hover:bg-gray-400" id="user-menu-button">
						<span class="sr-only">Open user menu</span>
						<div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center" alt="user photo">
							<p class="text-gray-900 font-bold">
								<?php
									$name = wp_get_current_user()->display_name;
									$palavras = explode(" ", $name);
									$iniciais = "";
									foreach ($palavras as $palavra) {
										$iniciais .= substr($palavra, 0, 1);
									}
									echo $iniciais;
								?>
							</p>
						</div>
					</button>
					<!-- Dropdown menu -->
					<div class="hidden z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow group-hover:block absolute right-0 top-full" id="user-dropdown">
						<div class="px-4 py-3">
						<span class="block text-sm text-gray-900"><?php echo wp_get_current_user()->display_name;?></span>
						<span class="block text-sm  text-gray-500 truncate"><?php echo wp_get_current_user()->user_email;?></span>
						</div>
						<ul class="py-2" aria-labelledby="user-menu-button">
							<li>
								<a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
							</li>
						</ul>
					</div>
					<button type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200>
						<span class="sr-only">Open main menu</span>
						<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
					</button>
				</div>
				<?php if( current_user_can( 'manage_options' ) ) {
					wp_nav_menu(
						array(
							'menu'			  => 'Menu Admin Dashboard',
							'container_id'    => 'primary-menu',
							'container_class' => 'items-center justify-between hidden w-full md:flex md:w-auto md:order-1',
							'menu_class'      => 'flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white',
							'theme_location'  => 'primary',
							'li_class'        => '',
							'fallback_cb'     => false,
							'add_a_class'     => 'flex items-center py-2 pl-3 pr-4 text-sm text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0',
						)
					);
				} else {
					wp_nav_menu(
						array(
							'menu'			  => 'Menu Vendedor Dashboard',
							'container_id'    => 'secondary-menu',
							'container_class' => 'items-center justify-between hidden w-full md:flex md:w-auto md:order-1',
							'menu_class'      => 'flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white',
							'theme_location'  => 'primary',
							'li_class'        => '',
							'fallback_cb'     => false,
							'add_a_class'     => 'flex items-center py-2 pl-3 pr-4 text-sm text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0',
						)
					);
				}
				?>
			</div>
		<?php } ?>
	</header>

	<div id="content" class="site-content flex-grow">

		<?php if ( is_front_page() ) { ?>
			
		<?php } ?>

		<?php do_action( 'tailpress_content_start' ); ?>

		<main>
