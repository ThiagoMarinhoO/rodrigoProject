<?php get_header();
?>
    <div id="loading-animation"></div>
    <header class="bg-gray-900 pattern min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md bg-white rounded-lg">
            <div class="px-6 py-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-white fo">Criar Conta</h2>
                <form action="#">
                    <div class="mt-4">
                        <input id="name" class="block w-full px-4 py-2 text-gray-700 placeholder-gray-400 bg-white border rounded-md focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:ring-blue-300 focus:outline-none focus:ring" type="text" placeholder="Nome" aria-label="Nome">
                        <input id="email" class="block w-full px-4 py-2 mt-4 text-gray-700 placeholder-gray-400 bg-white border rounded-md dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-500 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:ring-blue-300 focus:outline-none focus:ring" type="email" placeholder="Email" aria-label="Email address">
                        <input id="password" class="block w-full px-4 py-2 mt-4 text-gray-700 placeholder-gray-400 bg-white border rounded-md dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-500 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:ring-blue-300 focus:outline-none focus:ring" type="password" placeholder="Senha" aria-label="Password">
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        

                        <div class="container cursor-pointer px-6 py-2 font-medium text-white transition-colors duration-300 transform bg-gray-900 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-gray-800" id="signUpButton">Cadastrar</div>
                    </div>
                </form>
            </div>
        </div>
    </header>

<?php get_footer(); ?>