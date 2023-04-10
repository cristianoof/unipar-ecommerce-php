function getHashPassword(value) {
  const hash = crypto.subtle
    .digest("SHA-256", new TextEncoder().encode(value))
    .then((buffer) => {
      const hashArray = Array.from(new Uint8Array(buffer));
      const hashHex = hashArray
        .map((b) => b.toString(16).padStart(2, "0"))
        .join("");
      return hashHex;
    });

  return hash;
}

function login() {
  const formElement = document.getElementById("formLogin");

  const formData = new FormData(formElement);
  const password = formData.get("senha");

  const hash = getHashPassword(password);

  hash.then((resultHash) => {
    formData.set("senha", resultHash);

    fetch(`/unipar-ecommerce-php/login.php`, {
      method: "POST",
      body: formData,
    }).then((res) => {
      res.text().then((message) => {
        if (message.includes("success"))
          window.location.replace("http://localhost/unipar-ecommerce-php/");
        else showToast(message);
      });
    });
  });
}

function logout() {
  localStorage.clear();
  window.location.href = "http://localhost/unipar-ecommerce-php/logout.php";
}

function createUser() {
  const formElement = document.getElementById("formUserRegister");

  const formData = new FormData(formElement);
  formData.append("action", "create");

  const password = formData.get("senha");
  const hash = getHashPassword(password);

  hash.then((resultHash) => {
    formData.set("senha", resultHash);

    fetch(`/unipar-ecommerce-php/cadastro-usuario.php`, {
      method: "POST",
      body: formData,
    }).then((res) => {
      formElement.reset();
      res.text().then((message) => showToast(message));
    });
  });
}

const url = window.location.pathname;
const isProducts = url.includes("produtos");
const isManufacturers = url.includes("fabricantes");
const isBasket = url.includes("cesta");

function findAllProducts() {
  fetch("/unipar-ecommerce-php/cadastro-produto.php").then((res) =>
    res.json().then((dataProducts) => createTableProducts(dataProducts))
  );
}

function findAllManufacturers() {
  fetch("/unipar-ecommerce-php/cadastro-fabricante.php").then((res) =>
    res.json().then((dataManufacturers) => {
      if (isManufacturers) createTableManufacturers(dataManufacturers);
      else createOptionsSelect(dataManufacturers);
    })
  );
}

function findLists() {
  if (isProducts) {
    findAllProducts();
    findAllManufacturers();
  }
  if (isManufacturers) findAllManufacturers();
}
findLists();

function createRegister(e, idForm, route) {
  const formElement = document.getElementById(idForm);

  e.preventDefault();

  const formData = new FormData(formElement);
  formData.append("action", "create");

  fetch(`/unipar-ecommerce-php/${route}.php`, {
    method: "POST",
    body: formData,
  }).then((res) => {
    formElement.reset();
    findLists();
    res.text().then((message) => showToast(message));
  });
}

let formSubmited = false;
function saveRegister(idForm, idItem, route, e) {
  const formElement = document.getElementById(idForm);

  e.preventDefault();
  if (!formSubmited) {
    formSubmited = true;

    const formData = new FormData(formElement);

    formData.append("action", "update");
    formData.append("id", parseInt(idItem));

    fetch(`/unipar-ecommerce-php/${route}.php`, {
      method: "POST",
      body: formData,
    }).then((res) => {
      formElement.reset();
      findLists();
      res.text().then((message) => showToast(message));
    });
  }
}

function deleteRegister(idItem, route) {
  if (confirm(`Deseja realente excluir o registro ID: ${idItem}?`)) {
    const data = new FormData();

    data.append("action", "delete");
    data.append("id", parseInt(idItem));

    fetch(`/unipar-ecommerce-php/${route}.php`, {
      method: "POST",
      body: data,
    }).then((res) => {
      findLists();
      res.text().then((message) => showToast(message));
    });
  }
}

function handleUpdateRegister(data, idForm, route) {
  formSubmited = false;
  const buttonSave = toogleButton("buttonSave");

  buttonSave.addEventListener("click", (e) => {
    saveRegister(idForm, data.id, route, e);
  });

  const formElement = document.getElementById(idForm);
  formElement.querySelectorAll("input, select").forEach((input) => {
    input.value = data[input.name];
  });
}

function toogleButton(idButtonVisible) {
  const buttonCreate = document.getElementById("buttonCreate");
  const buttonSave = document.getElementById("buttonSave");
  buttonCreate.style.display =
    idButtonVisible === "buttonCreate" ? "initial" : "none";
  buttonSave.style.display =
    idButtonVisible === "buttonSave" ? "initial" : "none";

  return idButtonVisible === "buttonCreate" ? buttonCreate : buttonSave;
}

function cancelRegister(idForm) {
  const formElement = document.getElementById(idForm);
  formElement.reset();
  toogleButton("buttonCreate");
}

function createOptionsSelect(data) {
  const select = document.getElementById("selectManufacturers");
  const optionNodes = select.querySelectorAll("option");
  if (optionNodes.length > 1) return;

  data.forEach((item) => {
    const option = document.createElement("option");
    option.innerHTML = `
      <option>${item.nome}</option>
    `;
    option.value = item.id;
    select.appendChild(option);
  });
}

function createTableProducts(dataProducts) {
  const tbody = document.getElementById("tbodyProducts");
  const trNodes = tbody.querySelectorAll("tr");

  if (trNodes.length > 0)
    trNodes.forEach((tr) => {
      tbody.removeChild(tr);
    });

  dataProducts.forEach((data) => {
    const tr = document.createElement("tr");
    const idBtnEditar = `btnEditar${data.id}`;
    const idCheckbox = `checkbox${data.id}`;

    const tableData = `
      <td><input type="checkbox" id="${idCheckbox}"></td>
      <td>${data.id}</td>
      <td style="text-align: center;">
        <img src="${data.urlImagem}" alt="${data.nome}">
      </td>
      <td>${data.nome}</td>
      <td>${formatCurrency(data.preco)}</td>
      <td>${data.nomeFabricante}</td>
      <td>
        <button 
          type="button" 
          class="btn btn-secondary btn-small" 
          id="${idBtnEditar}"
        >
          <i class="ph ph-pencil"></i>
          editar
        </button>
      </td>
      <td>
        <button 
          type="button" 
          class="btn btn-secondary 
          btn-small" 
          onclick="deleteRegister(${data.id}, 'cadastro-produto')"
        >
          <i class="ph ph-trash"></i>
          Excluir
        </button>
      </td>
    `;

    tr.innerHTML = tableData;
    tbody.appendChild(tr);

    document.getElementById(idBtnEditar).addEventListener("click", () => {
      handleUpdateRegister(data, "formProduct", "cadastro-produto");
    });
    document.getElementById(idCheckbox).addEventListener("change", (e) => {
      handleChangeCheckbox(e.target, data);
    });
  });

  toogleButton("buttonCreate");
}

function createTableManufacturers(dataManufacturers) {
  const tbody = document.getElementById("tbodyManufacturers");
  const trNodes = tbody.querySelectorAll("tr");

  if (trNodes.length > 0)
    trNodes.forEach((tr) => {
      tbody.removeChild(tr);
    });

  dataManufacturers.forEach((data) => {
    const tr = document.createElement("tr");
    const idBtnEditar = `btnEditar${data.id}`;

    const tableData = `
      <td>${data.id}</td>
      <td>${data.nome}</td>
      <td>
        <button 
          type="button" 
          class="btn btn-secondary btn-small" 
          id="${idBtnEditar}"
        >
          <i class="ph ph-pencil"></i>
          editar
        </button>
      </td>
      <td>
        <button 
          type="button" 
          class="btn btn-secondary 
          btn-small" 
          onclick="deleteRegister(${data.id}, 'cadastro-fabricante')"
        >
          <i class="ph ph-trash"></i>
          Excluir
        </button>
      </td>
    `;

    tr.innerHTML = tableData;
    tbody.appendChild(tr);
    document.getElementById(idBtnEditar).addEventListener("click", () => {
      handleUpdateRegister(data, "formManufacturers", "cadastro-fabricante");
    });
  });

  toogleButton("buttonCreate");
}

const productsToAddBascket = new Set();
function handleChangeCheckbox(checkbox, data) {
  const product = Object.assign(data, { checked: checkbox.checked });
  productsToAddBascket.add(product);
}

function handleAddProductToBasket() {
  const products = [];
  productsToAddBascket.forEach((product, i) => {
    products.push(product);
  });
  localStorage.setItem("basket", JSON.stringify(products));
  checkProductBascket();
}

function clearProductBasket() {
  localStorage.clear();
  createTableBasket();
  checkProductBascket();
}

function checkProductBascket() {
  const products = JSON.parse(localStorage.getItem("basket"));
  const quantityBasket = document.querySelector(".basket-quantity");

  if (products) {
    quantityBasket.style.display = "block";
    quantityBasket.textContent = products.length;
  } else {
    quantityBasket.style.display = "none";
  }
}
checkProductBascket();

function createTableBasket() {
  const dataProducts = JSON.parse(localStorage.getItem("basket"));
  const tbody = document.getElementById("tbodyProductBasket");
  const trNodes = tbody.querySelectorAll("tr");

  trNodes.forEach((tr) => {
    tbody.removeChild(tr);
  });

  if (!dataProducts) return;

  dataProducts.forEach((data) => {
    const tr = document.createElement("tr");
    const idBtnRemove = `remove${data.id}`;

    const tableData = `
      <td>${data.id}</td>
      <td style="text-align: center;">
        <img src="${data.urlImagem}" alt="${data.nome}">
      </td>
      <td>${data.nome}</td>
      <td>${formatCurrency(data.preco)}</td>
      <td>${data.nomeFabricante}</td>
      <td>
        <button 
          type="button" 
          class="btn btn-secondary 
          btn-small" 
          id="${idBtnRemove}"
        >
          <i class="ph ph-trash"></i>
          Remover
        </button>
      </td>
    `;

    tr.innerHTML = tableData;
    tbody.appendChild(tr);

    document.getElementById(idBtnRemove).addEventListener("click", () => {
      removeProductBasket(data.id, dataProducts);
    });
  });
}

if (isBasket) createTableBasket();

function removeProductBasket(idProduct, data) {
  const products = data.filter((item) => item.id !== idProduct);
  if (products.length > 0) {
    localStorage.setItem("basket", JSON.stringify(products));
  } else {
    localStorage.clear();
  }

  createTableBasket();
  checkProductBascket();
}

function formatCurrency(value) {
  return value.toLocaleString("pt-br", { style: "currency", currency: "BRL" });
}

function showToast(message) {
  const bgColor = message.includes("Erro") ? "#E74C3C" : "#27AE60";

  Toastify({
    text: message,
    duration: 5000,
    close: true,
    style: {
      background: bgColor,
    },
  }).showToast();
}
