
const axios = require('axios').default;

async function SignIn() {
      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;
      
      const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/login`, {
            email,
            password
      });
      if (data.role == "administrator") {
            window.location.href = "/admin-dashboard";
      } else {
            window.location.href = "/dashboard";
      }
      console.log(data.role);
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
            alert('produto cadastrado')
            window.location.reload();
      }
}

async function getProducts() {
      const { data } = await axios.get(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/products`);
      return data;
}

document.addEventListener('DOMContentLoaded', async function() {
      const products = await getProducts();
      
      const cart = JSON.parse(localStorage.getItem('cart')) || [];

      function updateCartCounter() {
            document.querySelector('#cartCounter').innerText = cart.length;
            if ( cart.length > 0 ) {
                  document.querySelector('#cartButton')?.classList.remove('hidden');
            } else {
                  document.querySelector('#cartButton')?.classList.add('hidden');
            }
      }
      updateCartCounter();

      function createDrawerCart() {
            const cartList = document.querySelector('#productDrawerList');
            cartList.innerHTML = '';
            cart.forEach((product) => {
                  const row = document.createElement('div');
                  row.classList.add('py-4')
                  row.innerHTML = `
                        <div class="flex justify-between mb-3">
                              <p class="font-semibold">${product.title}</p>
                              <p class="font-bold">${product.price}</p>
                        </div>
                        <div class="flex justify-between">
                              <div class="flex items-center">
                                    <a id="qtyDecrease" class="relative inline-flex items-center rounded-l-md px-1 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                          </svg>                              
                                    </a>
                                    <a id="qty" class="relative inline-flex items-center px-2 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">${product.quantity}</a>
                                    <a id="qtyIncrease" class="relative inline-flex items-center rounded-r-md px-1 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                          </svg>                                  
                                    </a>
                              </div>
                              <button type="button" class="text-red-700 hover:text-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm">Delete</button>
                        </div>
                        
                  `;
                  cartList?.appendChild(row);
            });
      }
      createDrawerCart();

      const qtyElements = document.querySelectorAll('#qty');
      const increaseButtons = document.querySelectorAll('#qtyIncrease');
      const decreaseButtons = document.querySelectorAll('#qtyDecrease');

      increaseButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                  qtyElements[index].innerText++;
                  console.log(qtyElements[index].value)
            });
      })

      decreaseButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                  if (qtyElements[index].innerText > 1 ) {
                        qtyElements[index].innerText--;
                        console.log(qtyElements[index].value)
                  }
            });
      })

      const addToCartButtons = document.querySelectorAll('#productsTable tbody button');
      addToCartButtons.forEach((button) => {
            button.addEventListener('click', () => {
                  const productId = parseInt(button.dataset.id);
                  const productToAdd = products.find((product) => product.id == productId);
                  productToAdd["quantity"] = 1;
                  cart.push(productToAdd);
                  localStorage.setItem('cart', JSON.stringify(cart));
                  updateCartCounter();
                  createDrawerCart();
                  alert('Produto adicionado ao carrinho')
            });
      })
});

document.addEventListener('DOMContentLoaded', function () {
      const Modal = {
            modal: document.querySelector('#AdicionarProdutoModal'),
            adicionarProduto: document.querySelector('#adicionarProduto'),
            openModal: () => {
                  if(Modal.adicionarProduto) {
                        adicionarProduto.onclick = () => {
                              Modal.modal.classList.remove('hidden');
                              Modal.modal.classList.add('flex');
                        }
                  }
            },
            closeModal: () => {
                  window.onclick = function(event) {
                        if(event.target == Modal.modal) {
                              Modal.modal.classList.add('hidden');
                              Modal.modal.classList.remove('flex');
                        }
                  }
            },
      }
      Modal.openModal();
      Modal.closeModal();

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
