
<?php
redirecionar_admin_logado();
redirecionar_usuario_logado();
?>
<div id="loading-animation"></div>
<div class="min-h-screen flex items-center">
    <div class="container max-w-4xl mx-auto flex">
        <div class="lg:w-1/2 py-20 px-12 bg-white">
            <h2 class="text-3xl font-bold text-gray-950 mb-5">Acesse sua conta</h2>

            <form id="loginForm" action="#" class="relative">
                <div class="mt-4">
                    <div class="mb-5">
                        <label for="email" class="text-gray-400 text-sm pb-2">Seu email</label>
                        <input id="email" class="block w-full px-4 py-2 text-gray-700 placeholder-gray-400 bg-white border rounded-md focus:ring-opacity-40 focus:ring-blue-300 focus:outline-none focus:ring" type="email" placeholder="Email" aria-label="Email address">
                    </div>
                    <div class="">
                        <label for="password" class="text-gray-400 text-sm">Sua senha</label>
                        <input id="password" class="block w-full px-4 py-2 text-gray-700 placeholder-gray-400 bg-white border rounded-md focus:ring-opacity-40 focus:ring-blue-300 focus:outline-none focus:ring" type="password" placeholder="Senha" aria-label="Password">
                    </div>
                </div>

                <div class="mt-10">
                    <div class="cursor-pointer text-center px-6 py-2 font-medium text-white transition-colors duration-300 transform bg-blue-700 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-gray-800" id="signin">Entrar</div>
                </div>
            </form>

        </div>

        <div class="lg:w-1/2 bg-blue-700 relative flex overflow-hidden">
            <div class="w-[16rem] h-[16rem] rounded-full bg-gradient-to-l from-white/30 absolute top-0 -left-32"></div>
            <div class="w-[20rem] h-[20rem] rounded-full bg-gradient-to-l from-white/30 absolute -top-16 -left-16"></div>
            <div class="w-[6rem] h-[6rem] rounded-full bg-gradient-to-r from-white/20 absolute bottom-12 right-12"></div>
            <div class="container flex flex-1 self-end pl-6 pb-12">
                <h2 class="text-2xl font-semibold text-white w-1/4">Olá bem vindo de volta</h2>
            </div>
        </div>
    </div>
</div>