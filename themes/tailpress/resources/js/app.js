
const axios = require('axios').default;
let cart = [];
let total = 0
const Datas = {
      dia: () => {
        let date = new Date();
        let ano = date.getFullYear();
        let mes = ('0' + (date.getMonth() + 1)).slice(-2);
        let dia = ('0' + date.getDate()).slice(-2);
    
        return `${ano}-${mes}-${dia}`;
      },
      primeiroDiaSemana: () => {
        let date = new Date();
        return new Date(date.setDate(date.getDate() - date.getDay()));
      },
      ultimoDiaSemana: () => {
        let date = new Date();
        return new Date(date.setDate(date.getDate() - date.getDay() + 6));
      },
      primeiroDiaMes: () => {
        let date = new Date();
        return new Date(date.getFullYear(), date.getMonth(), 1);
      },
      ultimoDiaMes: () => {
        let date = new Date();
        return new Date(date.getFullYear(), date.getMonth() + 1, 0);
      },
      recorteSemestre: () => {
        let date = new Date();
        let ano = date.getFullYear();
        let mes = date.getMonth();
    
        let mesInicioSemestre, mesFimSemestre;
        if (mes >= 0 && mes <= 5) {
          mesInicioSemestre = 0;
          mesFimSemestre = 5;
        } else {
          mesInicioSemestre = 6;
          mesFimSemestre = 11;
        }
    
        let primeiroDiaSemestre = new Date(ano, mesInicioSemestre, 1);
        let ultimoDiaSemestre = new Date(ano, mesFimSemestre + 1, 0);
    
        return {
          primeiroDia: primeiroDiaSemestre,
          ultimoDia: ultimoDiaSemestre
        };
      },
      recorteAnual: () => {
        let date = new Date();
        let ano = date.getFullYear();
    
        let primeiroDiaAno = new Date(ano, 0, 1);
        let ultimoDiaAno = new Date(ano, 11, 31);
    
        return {
          primeiroDia: primeiroDiaAno,
          ultimoDia: ultimoDiaAno
        };
      }
};
    

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
      const name = document.querySelector('#newUserName').value;
      const email = document.querySelector('#newUserEmail').value;
      const password = document.querySelector('#newUserPassword').value;
      
      try {
            const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/register`, {
                  name,
                  email,
                  password
            });
            window.location.reload();
      } catch(error) {
            alert(error.response.data.error);
      }
}

// Cadastrar produtos

async function PublishProduct() {

      const product = {
            author: tailpress_object.userID,
            title: document.querySelector('#productName').value,
            price: document.querySelector('#productPrice').value,
            marketPrice: document.querySelector('#marketPrice').value,
            barcode: document.querySelector('#barcode').value,
            estoque: document.querySelector('#estoque').value
      }

      let fixedValue = document.querySelector('#valueFixed')

      if(!fixedValue.checked) {
            let pricePercentage = product.marketPrice * product.price / 100
            product.price = parseFloat(pricePercentage) + parseFloat(product.marketPrice)
      }

      const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/products`, product);
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

function formatPrice(value) {
      var formattedValue = parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
      return formattedValue;
}

document.addEventListener('DOMContentLoaded', function() {
      const editarProdutosModal = {
            modal: document.querySelectorAll("#editarProdutoModal"),
            openModalButton: document.querySelectorAll("#editarProdutoButton"),
            openModal: () => {
                  editarProdutosModal.openModalButton.forEach((button, index) => {
                        button.addEventListener('click', () => {
                              editarProdutosModal.modal[index].classList.remove('hidden');
                              editarProdutosModal.modal[index].classList.add('flex');
                        })
                  })
            },
            closeModal: () => {
                  editarProdutosModal.modal.forEach((modal, index) => {
                        modal.addEventListener('click', (event) => {
                              if(event.target == modal) {
                                    editarProdutosModal.modal[index].classList.remove('flex');
                                    editarProdutosModal.modal[index].classList.add('hidden');
                              }
                        })
                  })
            }
      }
      editarProdutosModal.openModal();
      editarProdutosModal.closeModal();


});

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

      const ModalNewUser = {
            modal: document.querySelector('#newUserModal'),
            registerButton: document.querySelector('#addNewUser'),
            openModal: () => {
                  if(ModalNewUser.registerButton) {
                        ModalNewUser.registerButton.onclick = () => {
                              ModalNewUser.modal?.classList.remove('hidden');
                              ModalNewUser.modal?.classList.add('flex');
                        }
                  }
            },
            closeModal: () => {
                  if (ModalNewUser.modal) {
                        ModalNewUser.modal.onclick = function(event) {
                              if(event.target == ModalNewUser.modal) {
                                    ModalNewUser.modal?.classList.remove('flex');
                                    ModalNewUser.modal?.classList.add('hidden');
                              }
                        }
                  }
            },
      }
      ModalNewUser.openModal();
      ModalNewUser.closeModal();

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

      const signUpButton = document.querySelector('#createNewUserButton');
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
                                          <a id="qty" class="relative inline-flex items-center px-2 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0" data-estoque="${product.estoque}">${product.quantity}</a>
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
            if(author){
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
            }else {
                  $('#vendedores').addClass('border-red-500');
                  $('#labelVendedores').addClass('text-red-500');
                  setTimeout(() => {
                        $('#vendedores').removeClass('border-red-500');
                        $('#labelVendedores').removeClass('text-red-500');
                  }, 5000)
                  Swal.fire({
                        title: 'Atenção!',
                        text: 'Selecione um vendedor!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                  })
            }
            
      }
      
      $('.add-to-cart-btn').on('click' , function(e){
            e.preventDefault()
            productID = $(this).closest('.product-table').attr('product-id');
            addProduct(productID)
      })

      $(document).on("click", "#qtyIncrease", function(e) {
            e.preventDefault();
            var $qtyElement = $(this).siblings('#qty');
            var estoque = parseInt($qtyElement.data('estoque'));
            var currentQty = parseInt($qtyElement.text());
            $qtyElement.next().attr('max', estoque);
            if (currentQty < estoque) {
                  var productID = $(this).attr("data-id");
                  addProduct(productID);
            }else{
                  Swal.fire({
                        title: 'Aviso!',
                        text: 'Você só possui ' + estoque + ' produtos no estoque',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                  });
            }
        });
        
        $(document).on("click", "#qtyDecrease", function(e) {
            e.preventDefault();
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
                    cart = response.data.products;
                    total = response.data.total_price;
                    updateCartCounter();
                    createDrawerCart();
                    updateCartTotal();
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
      });

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
                  // console.log(response)
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
              init_date: Datas.primeiroDiaSemana().toISOString().slice(0, 10),
              final_date: Datas.ultimoDiaSemana().toISOString().slice(0, 10)
            },
            success: function(response) {
                  // console.log(response)
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
              init_date: Datas.primeiroDiaMes().toISOString().slice(0, 10),
              final_date: Datas.ultimoDiaMes().toISOString().slice(0, 10)
            },
            success: function(response) {
                  // console.log(response)
                  $('#balanco_mensal').text(response.data.valor_final.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
                  $('#produtoMaisVendidoPreco').text(parseInt(response.data.produto_mais_vendido?.produto_preco)?.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }))
                  $('#produtoMaisVendidoNome').text(response.data.produto_mais_vendido?.produto_nome)
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
                  // console.log(response)
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
      
      //ATUALIZAR PRODUTOS (ADMIN)
      $('.atualizarProdutoButton').each(function(index, button) {
            $(button).on('click',function() {
                  let title = $(".updateProductName").eq(index).val();
                  let price = $(".updateProductPrice").eq(index).val();
                  let estoque = $(".updateStock").eq(index).val();
                  let marketPrice = $(".updateMarketPrice").eq(index).val() == '' ? $(".updateMarketPrice").attr('placeholder').replace(/^R\$(.*)/, "$1").replace(",", ".") : $(".updateMarketPrice").eq(index).val();
                  let product_id = $(".atualizarProdutoButton").eq(index).attr("data-id");
                  let valueFixed = $(".valueFixedAtualizar").eq(index).prop('checked')

                  if(valueFixed == false){
                        let pricePercentage = marketPrice * price / 100
                        price = parseFloat(pricePercentage) + parseFloat(marketPrice)
                  }
                  

                  $.ajax({
                        url: tailpress_object.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                        action: 'update_product',
                        product_id: product_id,
                        title: title,
                        price: price,
                        estoque: estoque,
                        marketPrice: marketPrice
                        },
                        beforeSend: function() {
                        loading(true);
                        },
                        success: function(response) {
                              Swal.fire({
                                    title: 'Sucesso!',
                                    text: 'Produto atualizado!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                              }).then(function(result) {
                                    if (result.isConfirmed) {
                                    $('#readProductDrawer').addClass('-translate-x-full');
                                    window.location.reload();
                                    }
                              });
                        },
                        error: function(xhr, status, error) {
                        console.log(error);
                        Swal.fire({
                              title: 'Erro!',
                              text: 'Erro ao atualizar produto',
                              icon: 'error',
                              confirmButtonText: 'OK'
                        });
                        },
                        complete: function() {
                              loading(false);
                        }
                  });
            });
      });

      //DELETAR PRODUTOS (ADMIN)
      $('.deletarProdutoButton').each(function(index, button) {
            $(button).on('click',function() {
                  let product_id = $(".atualizarProdutoButton").eq(index).attr("data-id");
                  if(product_id) {
                        $.ajax({
                              url: tailpress_object.ajaxurl,
                              type: 'POST',
                              dataType: 'json',
                              data: {
                              action: 'delete_product_post',
                              product_id,
                        },
                        beforeSend: function() {
                              loading(true);
                        },
                        success: function(response) {
                              Swal.fire({
                                    title: 'Sucesso!',
                                    text: 'Produto deletado!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                              }).then(function(result) {
                                    if (result.isConfirmed) {
                                    $('#readProductDrawer').addClass('-translate-x-full');
                                    window.location.reload();
                                    }
                              });
                        },
                        error: function(xhr, status, error) {
                              console.log(error);
                              Swal.fire({
                                    title: 'Erro!',
                                    text: 'Erro ao deletar produto',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                              });
                        },
                        complete: function() {
                              loading(false);
                        }
                        });
                  }
              }
            );
      });

      $('.deleteSale').each(function(index, button) {
            $(button).on('click', function() {
                  const product_id = $('.deleteSale').eq(index).attr('data-id')
                  const status_order = $('.deleteSale').eq(index).attr('data-status')
                  Swal.fire({
                        title: 'Confirmação',
                        text: 'Deseja cancelar esta venda ?',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                      }).then(function(result) {
                        if (result.isConfirmed) {
                              $.ajax({
                                    url: tailpress_object.ajaxurl,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                      action: 'status_order',
                                      product_id,
                                      status_order,
                                    },
                                    beforeSend: function() {
                                          loading(true)
                                    },
                                    success: function(response) {
                                      Swal.fire({
                                        title: 'Sucesso!',
                                        text: 'Venda cancelada!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                      }).then(function(result) {
                                        if (result.isConfirmed) {
                                          $('#readProductDrawer').addClass('-translate-x-full');
                                          window.location.reload();
                                        }
                                      });
                                    },
                                    error: function(xhr, status, error) {
                                      console.log(error);
                                      Swal.fire({
                                        title: 'Erro!',
                                        text: 'Erro ao cancelar venda',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                      });
                                    },
                                    complete: function() {
                                      loading(false);
                                    }
                              }); 
                        }
                      });
            })
      })

      $('.editSalesButton').each(function(index, button) {
            $(button).on('click', function() {
                  const product_id = $('.editSalesButton').eq(index).attr('data-id')
                  const status_order = $('.editSalesButton').eq(index).attr('data-status')
                  Swal.fire({
                        title: 'Confirmação',
                        text: 'Deseja efetuar esta venda ?',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                      }).then(function(result) {
                        if (result.isConfirmed) {
                              $.ajax({
                                    url: tailpress_object.ajaxurl,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                      action: 'status_order',
                                      product_id,
                                      status_order,
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
                                      }).then(function(result) {
                                        if (result.isConfirmed) {
                                          $('#readProductDrawer').addClass('-translate-x-full');
                                          window.location.reload();
                                        }
                                      });
                                    },
                                    error: function(xhr, status, error) {
                                      console.log(error);
                                      Swal.fire({
                                        title: 'Erro!',
                                        text: 'Erro ao efetuar venda',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                      });
                                    },
                                    complete: function() {
                                      loading(false);
                                    }
                              }); 
                        }
                      });
            })
      })
      // Relatório de lucro
      $('.profit-date').change(function() {
            loading(true)
            $('#clearFilter').attr('disabled' , false)
            var selectedDate = $(this).val();
            $.ajax({
                url: tailpress_object.ajaxurl,
                type: 'POST',
                data: { 
                  action: 'profit_report',
                  startDate: selectedDate,
                },
                dataType: 'json',
                success: function(response) {
                  console.log(JSON.stringify(response, null, 2));
                  $('#saidas_balanco').text('-' + formatPrice(response.data.total_market_price))
                  $('#entradas_balanco').text('+' + formatPrice(response.data.sales_total))
                  let indicator = response.data.total_market_price > response.data.sales_total ? '' : '+'
                  let profitColor = response.data.sales_total < response.data.total_market_price ? 'text-red-600' : 'text-green-600'
                  $('#profit_value').text(indicator + formatPrice(response.data.sales_total - response.data.total_market_price))
                  $('#profit_value').addClass(profitColor)
                  $('#salesTable').html(response.data.sales)
                  loading(false)
                },
                error: function(xhr, status, error) {
                }
            });
        });
      //   Relatório de lucro inicial
        function initProfit(){
            loading(true)
            $.ajax({
                  url: tailpress_object.ajaxurl,
                  type: 'POST',
                  data: { 
                    action: 'init_profit',
                  },
                  dataType: 'json',
                  success: function(response) {
                    console.log(JSON.stringify(response, null, 2));
                    $('#saidas_balanco').text('-' + formatPrice(response.data.total_market_price))
                    $('#entradas_balanco').text('+' + formatPrice(response.data.sales_total))
                    let indicator = response.data.total_market_price > response.data.sales_total ? '' : '+'
                    let profitColor = response.data.sales_total < response.data.total_market_price ? 'text-red-600' : 'text-green-600'
                    $('#profit_value').text(indicator + formatPrice(response.data.sales_total - response.data.total_market_price))
                    $('#profit_value').addClass(profitColor)
                    $('#salesTable').html(response.data.sales)
                    loading(false)
                  },
                  error: function(xhr, status, error) {
                  }
            })
        }
        initProfit()

      //   datepicker

      $('.clickable-date').click(function() {
            $(this).find('input').click();
      });

      // Limpar filtro

      $('#clearFilter').on('click' , function(e){
            e.preventDefault()
            $('.profit-date').val('')
            initProfit()
            $(this).attr('disabled' , true)
      })

      // Margem de Lucro

      $('.valueFixed').each((index, input) => {
            $(input).on('change', function() {
                  let isChecked = $(input).prop('checked');
                  let indicator = isChecked ? 'R$' : '%';
                  let LabelText = isChecked ? 'Digitar valor percentual' : 'Digitar valor fixo';
                  $('.digitarValor').eq(index).text(LabelText);
                  $('.labelForPrice').eq(index).text('Margem de Lucro (' + indicator + ')');
            })
      })
})

document.addEventListener('DOMContentLoaded', async function() {
      const products = await getProducts();
});