<?php

function modalNewUser(){
    echo '<div id="newUserModal" class="hidden fixed top-0 left-0 right-0 z-50 items-center justify-center p-4 overflow-x-hidden overflow-y-auto md:inset-0 max-h-full bg-gray-950 bg-opacity-50">
    <div class="container max-w-sm p-6 relative bg-white rounded-lg shadow">
        <form id="formNewUser" class="divide-y divide-gray-300">
            <h2 class="text-2xl font-semibold text-gray-950 pb-3">Adicione um novo vendedor</h2>
            <div class="flex flex-col gap-4 py-6">
                <div>
                    <label for="newUserName" class="block mb-2 text-sm font-medium text-gray-900">Nome</label>
                    <input type="text" id="newUserName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div>
                    <label for="newUserEmail" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" id="newUserEmail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div>
                    <label for="newUserWageType" class="block mb-2 text-sm font-medium text-gray-900">Tipo de pagamento</label>
                    <select id="newUserWageType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="diario">Diário</option>
                        <option value="semanal">Semanal</option>
                        <option value="quinzenal">Quinzenal</option>
                        <option value="mensal">Mensal</option>
                    </select>
                </div>
                <div>
                    <label for="newUserWage" class="block mb-2 text-sm font-medium text-gray-900">Salário</label>
                    <input type="number" id="newUserWage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div>
                    <label for="payday" class="block mb-2 text-sm font-medium text-gray-900">Data do pagamento</label>
                    <input type="date" id="payday" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
            <button id="createNewUserButton" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Cadastrar novo usuário</button>
        </form>
    </div>
</div>';
}

add_shortcode( 'modalNewUser', 'modalNewUser' );