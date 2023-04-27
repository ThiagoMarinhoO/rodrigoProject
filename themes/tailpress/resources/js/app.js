
const axios = require('axios').default;

async function SignIn() {
      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;
      
      const { data } = await axios.post(`${tailpress_object.homeUrl}/wp-json/loginsystem/v1/login`, {
            email,
            password
      });
      window.location.href = "/dashboard";
      console.log(data);
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


      // const UserMenu = {
      //       menuButton: document.querySelector('#user-menu-button'),
      //       menu: document.querySelector('#user-dropdown'),
      //       openMenu: () => {
      //             UserMenu.menuButton.onclick = () => {
      //                   UserMenu.menu.classList.remove('hidden');
      //             }
      //       }
      // }

      // UserMenu.openMenu();
});
