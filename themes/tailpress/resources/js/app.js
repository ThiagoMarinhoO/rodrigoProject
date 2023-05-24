
const axios = require('axios').default;
// window.products = []
// let products = window.products
let cart = [];
let total = 0

const date = new Date();
const Datas = {
      dia: () => {
            let date = new Date();
            let ano = date.getFullYear();
            let mes = ('0' + (date.getMonth() + 1)).slice(-2);
            let dia = ('0' + date.getDate()).slice(-2);

            return `${ano}-${mes}-${dia}`
      },
      primeiroDiaSemana: new Date(date.setDate(date.getDate() - date.getDay())),
      ultimoDiaSemana: new Date(date.setDate(date.getDate() - date.getDay() + 6)),
      primeiroDiaMes: new Date(date.getFullYear(), date.getMonth(), 1),
      ultimoDiaMes: new Date(date.getFullYear(), date.getMonth() + 1, 0),
      recorteSemestre: () => {
            var ano = date.getFullYear();
            var mes = date.getMonth();

            var mesInicioSemestre, mesFimSemestre;
            if (mes >= 0 && mes <= 5) {
            mesInicioSemestre = 0;
            mesFimSemestre = 5;
            } else {
            mesInicioSemestre = 6;
            mesFimSemestre = 11;
            }

            var primeiroDiaSemestre = new Date(ano, mesInicioSemestre, 1);

            var ultimoDiaSemestre = new Date(ano, mesFimSemestre + 1, 0);

            return {
                  primeiroDia: primeiroDiaSemestre,
                  ultimoDia: ultimoDiaSemestre
            };
      },
      recorteAnual: () => {
            var ano = date.getFullYear();

            var primeiroDiaAno = new Date(ano, 0, 1);

            var ultimoDiaAno = new Date(ano, 11, 31);

            return {
                  primeiroDia: primeiroDiaAno,
                  ultimoDia: ultimoDiaAno
            };
      }
}

async function SignIn() {
      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;
      const loginForm = document.querySelector('#loginForm')
      try {
            const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/login`, {
                  email,
                  password
            });
            if (data.role == "administrator") {
                  window.location.href = "/admin-dashboard";
            } else {
                  window.location.href = "/dashboard";
            }
      } catch(error) {
            const errorLabel = document.createElement('div')
            errorLabel.classList.add("absolute", "container", "p-4", "my-4", "text-sm", "text-red-800", "rounded-lg", "bg-red-50")
            errorLabel.innerHTML = error.response.data.message
            loginForm.appendChild(errorLabel)
            setTimeout(() => {errorLabel.remove()}, 5000)
      }
}

async function SignUp() {
      const name = document.querySelector('#name').value;
      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;
      
      try {
            const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/register`, {
                  name,
                  email,
                  password
            });
            window.location.href = "/dashboard";
            console.log(data);
      } catch(error) {
            console.log(error);
      }
}

async function PublishProduct() {

      const Product = {
            author: tailpress_object.userID,
            title: document.querySelector('#productName').value,
            description: document.querySelector('#productDescription').value,
            brand: document.querySelector('#productMarca').value,
            price: document.querySelector('#productPrice').value,
            category: document.querySelector('#productCategory').value,
      }

      const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/products`, Product);
      console.log(data);
      if (data.success == true) {
            Swal.fire({
                  title: 'Sucesso!',
                  text: 'Produto cadastrado!',
                  icon: 'success',
                  confirmButtonText: 'OK'
            })
            window.location.reload();
      }
}

async function getProducts() {
      const { data } = await axios.get(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/products`);
      return data;
}

document.addEventListener('DOMContentLoaded', function () {
      const Modal = {
            modal: document.querySelector('#AdicionarProdutoModal'),
            adicionarProduto: document.querySelector('#adicionarProduto'),
            openModal: () => {
                  if(Modal.adicionarProduto) {
                        Modal.adicionarProduto.onclick = () => {
                              Modal.modal.classList.remove('hidden');
                              Modal.modal.classList.add('flex');
                        }
                  }
            },
            closeModal: () => {
                  if(Modal.modal){
                        Modal.modal.onclick = function(event) {
                              if(event.target == Modal.modal) {
                                    Modal.modal.classList.remove('flex');
                                    Modal.modal.classList.add('hidden');
                              }
                        }
                  }
            },
      }
      Modal.openModal();
      Modal.closeModal();

      const ModalImportar = {
            modalImportar: document.querySelector('#importarProdutoModal'),
            importarProduto: document.querySelector('#importarProdutos'),
            openModal: () => {
                  if(ModalImportar.importarProduto) {
                        ModalImportar.importarProduto.onclick = () => {
                              ModalImportar.modalImportar.classList.remove('hidden');
                              ModalImportar.modalImportar.classList.add('flex');
                        }
                  }
            },
            closeModal: () => {
                  if (ModalImportar.modalImportar) {
                        ModalImportar.modalImportar.onclick = function(event) {
                              if(event.target == ModalImportar.modalImportar) {
                                    ModalImportar.modalImportar.classList.add('hidden');
                                    ModalImportar.modalImportar.classList.remove('flex');
                              }
                        }
                  }
            },
      }
      ModalImportar.openModal();
      ModalImportar.closeModal();

      const publishButton = document.querySelector('#publishButton');
      if(publishButton) {
            publishButton.onclick = function() {
                  PublishProduct();
            }
            // console.log(publishButton)
      }     

      const SignInButton = document.querySelector('#signin');
      if(SignInButton) {
            SignInButton.onclick = () => {
                  SignIn();
            }
      }

      const signUpButton = document.querySelector('#signUpButton');
      if(signUpButton) {
            signUpButton.onclick = () => {
                  SignUp();
            }
      }
});

jQuery(document).ready(function($){
      function loading(isLoading){
            if(isLoading){
              console.log('true')
              var animationData = {
                container: document.getElementById('loading-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/wp-content/themes/tailpress/resources/json/98288-loading.json',
                rendererSettings: {
                  scale: 0.1 
                },
                zIndex: 99999999
              };
              var anim = bodymovin.loadAnimation(animationData);
              $('#loading-animation').addClass('active')
        
              return anim
            }else{
              console.log('false')
              $('#loading-animation').fadeOut('fast', function() {
                $(this).remove();
                $(this).removeClass('active')
              });
            }
          }
      function addProduct(id) {
            if (id === '') {
                  Swal.fire({
                        title: 'Erro!',
                        text: 'Produto inválido',
                        icon: 'error',
                        confirmButtonText: 'OK'
                  });
              return;
            }
          
            $.ajax({
              url: tailpress_object.ajaxurl,
              type: 'POST',
              dataType: 'json',
              data: {
                action: 'add_product',
                produto_id: id
              },
              success: function(response) {
                cart = response.data.products
                total = response.data.total_price
                console.log(JSON.stringify(response, null, 2));
                  updateCartCounter();
                  createDrawerCart();        
                  updateCartTotal()
                  $('#readProductDrawer').removeClass('-translate-x-full')
              },
              error: function(xhr, status, error) {
                  console.log(error)
                  Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao adicionar o produto',
                        icon: 'error',
                        confirmButtonText: 'OK'
                      });
              },
            });
      }
      function updateCartCounter() {
            cartCount = cart.length
            $('#cartCounter').text(cartCount)
            if ( cart.length > 0 ) {
                  $('#cartButton').removeClass('hidden');
            } else {
                  $('#cartButton').addClass('hidden');
            }
      }
      function createDrawerCart() {
            let row = ''
            cart.forEach((product) => {
                   row += `
                   <div>
                        <div class="product py-3" data-id="${product.produto_id}">
                              <div class="flex justify-between mb-3">
                                    <p class="font-semibold">${product.title}</p>
                                    <p class="font-bold">${formatPrice(product.price)}</p>
                              </div>
                              <div class="flex justify-between">
                                    <div class="flex items-center">
                                          <a id="qtyDecrease" data-id="${product.produto_id}" class="relative inline-flex items-center rounded-l-md px-1 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                                </svg>                              
                                          </a>
                                          <a id="qty" class="relative inline-flex items-center px-2 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">${product.quantity}</a>
                                          <a id="qtyIncrease" data-id="${product.produto_id}" class="relative inline-flex items-center rounded-r-md px-1 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                                </svg>                                  
                                          </a>
                                    </div>
                                    <button id="deleteButton" type="button" data-id="${product.produto_id}" class="text-red-700 hover:text-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>
                              </div>
                        </div>
                  </div>
                  `;
            });
            $('#productDrawerList').html(row)
      }
      function updateCartTotal(){
            $('#subtotal').text(formatPrice(total))
      }
      function closeSale() {
            const author  = parseInt($('#vendedores').val());
            $.ajax({
                  url: tailpress_object.ajaxurl,
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    action: 'create_order',
                    products: cart,
                    total,
                    author
                  },
                  beforeSend: function() {
                        loading(true)
                        },
                  success: function(response) {
                        Swal.fire({
                              title: 'Sucesso!',
                              text: 'Venda efetuada!',
                              icon: 'success',
                              confirmButtonText: 'OK'
                            }).then((result) => {
                              if (result.isConfirmed) {
                                $('#readProductDrawer').addClass('-translate-x-full');
                                window.location.reload();
                              }
                            });
                  },
                  error: function(xhr, status, error) {
                      console.log(error)
                      Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao fechar a venda',
                        icon: 'error',
                        confirmButtonText: 'OK'
                      });
                  },
                  complete: function() {
                        loading(false)
                      }
                });
      }
      
      $('.add-to-cart-btn').on('click' , function(e){
            e.preventDefault()
            productID = $(this).closest('.product-table').attr('product-id');
            addProduct(productID)
      })

      $(document).on("click", "#qtyIncrease", function(e) {
            e.preventDefault()
            productID = $(this).attr("data-id");
            addProduct(productID)
            console.log(cart)
            console.log(total)
      });

      $(document).on("click", "#qtyDecrease", function(e) {
            var productID = $(this).attr("data-id");
            $.ajax({
              url: tailpress_object.ajaxurl,
              type: 'POST',
              dataType: 'json',
                  data: {
                  action: 'decrease_product',
                  produto_id: productID
                  },
                  success: function(response) {
                        cart = response.data.products
                        total = response.data.total_price
                        updateCartCounter()
                        createDrawerCart()
                        updateCartTotal()
                        console.log(JSON.stringify(response, null, 2));
                        // updateTableAndTotalPrice(products);
                  },
                  error: function(xhr, status, error) {
                        Swal.fire({
                              title: 'Erro!',
                              text: 'Erro ao excluir o produto',
                              icon: 'error',
                              confirmButtonText: 'OK'
                            });
            }
            });
      });

      $(document).on('click', '#deleteButton', function() {
            var productID = $(this).attr("data-id");
            // console.log(productID)
            $.ajax({
              url: tailpress_object.ajaxurl,
              type: 'POST',
              dataType: 'json',
                  data: {
                  action: 'delete_product',
                  produto_id: productID
                  },
                  success: function(response) {
                        cart = response.data.products
                        total = response.data.total_price
                        updateCartCounter()
                        createDrawerCart()
                        updateCartTotal()
                        // updateTableAndTotalPrice(products);
                  },
                  error: function(xhr, status, error) {
                        Swal.fire({
                              title: 'Erro!',
                              text: 'Erro ao excluir o produto',
                              icon: 'error',
                              confirmButtonText: 'OK'
                            });
            }
            });
      });

      $('#close_sale').on('click' , function(e){
            e.preventDefault()
            closeSale();
      })

      //balanço diario
      $.ajax({
            url: tailpress_object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'daily_report',
              init_date: Datas.dia(),
              final_date: Datas.dia()
            },
            beforeSend: function() {
                  loading(true)
                  },
            success: function(response) {
                  console.log(response)
                  $('#balanco_diario').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
                  // $('.nome-produto-daily').text(response.data.produto_mais_vendido.title)
                  // $('.barcode-produto-daily').text(response.data.produto_mais_vendido.barcode)
                  // $('.quantity-produto-daily').text(response.data.quantidade_mais_vendida)
                  // $('.total-produto-daily').text(response.data.produto_mais_vendido.unity_price * response.data.quantidade_mais_vendida)
            },
            error: function(xhr, status, error) {
                  console.log(error)
            },
      });
      //balanço semanal
      $.ajax({
            url: tailpress_object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'daily_report',
              init_date: Datas.primeiroDiaSemana.toISOString().slice(0, 10),
              final_date: Datas.ultimoDiaSemana.toISOString().slice(0, 10)
            },
            success: function(response) {
                  console.log(response)
                  $('#balanco_semanal').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
            },
            error: function(xhr, status, error) {
                  console.log(error)
            }
      });
      // //balanço mensal
      $.ajax({
            url: tailpress_object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'daily_report',
              init_date: Datas.primeiroDiaMes.toISOString().slice(0, 10),
              final_date: Datas.ultimoDiaMes.toISOString().slice(0, 10)
            },
            success: function(response) {
                  console.log(response)
                  $('#balanco_mensal').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
                  $('#produtoMaisVendidoPreco').text(parseInt(response.data.produto_mais_vendido.produto_preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
                  $('#produtoMaisVendidoNome').text(response.data.produto_mais_vendido.produto_nome)
            },
            error: function(xhr, status, error) {
                  console.log(error);
            }
      });
      // //balanço semestral
      $.ajax({
            url: tailpress_object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'daily_report',
              init_date: Datas.recorteSemestre().primeiroDia.toISOString().slice(0, 10),
              final_date: Datas.recorteSemestre().ultimoDia.toISOString().slice(0, 10)
            },
            success: function(response) {
                  console.log(response)
                  $('#balanco_semestral').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
            },
            error: function(xhr, status, error) {
                  console.log(error);
            }
      });
      // //balanço anual
      $.ajax({
            url: tailpress_object.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'daily_report',
              init_date: Datas.recorteAnual().primeiroDia.toISOString().slice(0, 10),
              final_date: Datas.recorteAnual().ultimoDia.toISOString().slice(0, 10)
            },
            success: function(response) {
                  $('#balanco_anual').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
            },
            error: function(xhr, status, error) {
                  console.log(error);
            },
            complete: function(){
                  loading(false)
            }
      });
      // search input
  $('#table-search-users').on('keyup', function() {
      var searchTerm = $(this).val().toLowerCase();
  
      $('#productsTable tbody tr').each(function() {
        var productName = $(this).find('.product-name').text().toLowerCase();
  
        if (productName.includes(searchTerm)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  
})

function formatPrice(value) {
      var formattedValue = parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
      return formattedValue;
}

document.addEventListener('DOMContentLoaded', async function() {
      const products = await getProducts();

      // const qtyElements = document.querySelectorAll('#qty');
      // const increaseButtons = document.querySelectorAll('#qtyIncrease');
      // const decreaseButtons = document.querySelectorAll('#qtyDecrease');

      // increaseButtons.forEach((button, index) => {
      //       button.addEventListener('click', () => {
      //             qtyElements[index].innerText++;
      //             console.log(qtyElements[index].value)
      //       });
      // })

      // decreaseButtons.forEach((button, index) => {
      //       button.addEventListener('click', () => {
      //             if (qtyElements[index].innerText > 1 ) {
      //                   qtyElements[index].innerText--;
      //                   console.log(qtyElements[index].value)
      //             }
      //       });
      // })

      // const addToCartButtons = document.querySelectorAll('#productsTable tbody button');
      // addToCartButtons.forEach((button) => {
      //       button.addEventListener('click', () => {
      //             const productId = parseInt(button.dataset.id);
      //             const productToAdd = products.find((product) => product.id == productId);
      //             productToAdd["quantity"] = 1;
      //             cart.push(productToAdd);
      //             localStorage.setItem('cart', JSON.stringify(cart));
      //             updateCartCounter();
      //             createDrawerCart();
      //             alert('Produto adicionado ao carrinho')
      //       });
      // })
});