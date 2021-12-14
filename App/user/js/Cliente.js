const enderecoImg = "http://localhost/serverphp/TCC/Server/img/cliente/"
const formCadastro = document.querySelector('#formCadastro')
const formLogin = document.querySelector('#formLogin')
var boxModal = document.getElementById('box-modal')
var formsProfile = document.getElementById('formsProfile')
var previewImg = document.getElementById('img-user')
var btnCancel = document.querySelector('#btnCancel')
var btnOpenEdit
//Submit in form of register
Cadastro = () => {
    formCadastro.addEventListener('submit', function(e) {
        e.preventDefault()
        let data = new FormData(formCadastro)
        data.append('tipo', 'cadastrar')
        Ajax("POST", URL_WEBSERVICE, data, cadastrar)
    })
}
formCadastro && Cadastro()
//Running register
cadastrar = (response) => {
    if(response.status === 1) {
        Swal.fire({
            icon: 'success',
            title: 'Bom trabalho!',
            text: response.success,
        })
        window.open('login.html', '_top')
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.error,
        })
    }
}
//Submit in form of login
Login = () => {
    formLogin.addEventListener('submit', function(e) {
        e.preventDefault()
        let data = new FormData(formLogin)
        data.append('tipo', 'logar')
        Ajax("POST", URL_WEBSERVICE, data, confirmLogin)
    })
}
formLogin && Login()
//Function of confirmation login
confirmLogin = (response) => {
    if(response.status === 1){
        Swal.fire({
            title: 'Bom trabalho!',
            text: response.success,
            icon: 'success'
        })
        redirection(response)
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.error,
        })
    }
}
//Function of redirection
redirection = (response) => {
    if(response.status === 1){
        window.open("home.html", "_top")
    }
}
//Function listar
listar = () => {
    let data = new FormData()
    data.append('tipo', 'listar')
    Ajax("POST", URL_WEBSERVICE, data, listagem)
}
//Listing cliente
var boxProfile = document.querySelector('#box-profile')
listagem = (response) => {
    boxProfile.innerHTML = ``
    if(response.status === 1) {
        boxProfile.innerHTML += `
            <div class="profile-imgPerfil">
                <img src="${enderecoImg + response.data.foto}" loading="lazy">
                <h1>${response.data.nome}</h1>
            </div>
            <div class="profile-actions">
                <button id="btn-editProfile" onclick="getData()"><i class="fa fa-pencil" aria-hidden="true"></i> Editar perfil</button>
                <button class="btnLogout" onclick="logoutClick()"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</button>
            </div>
            <div class="profile-list">
                <h3>E-mail:</h3>
                <p>${response.data.email}</p>
            </div>
            <div class="profile-list">
                <h3>Telefone:</h3>
                <p>${response.data.telefone}</p>
            </div>           
        `
        btnOpenEdit = document.querySelector('#btn-editProfile')
    }
}
//Getting customer data for to edit
getData = () => {
    let data = new FormData()
    data.append('tipo', 'listar')
    Ajax('POST', URL_WEBSERVICE, data, preencherForms)
}
//filling edit form
preencherForms = (response) => {
    if(response.status === 1) {
        boxModal.classList.remove('invisible')
        formsProfile.classList.remove('invisible')
        formsProfile['nome'].value = response.data.nome
        formsProfile['email'].value = response.data.email
        formsProfile['telefone'].value = response.data.telefone
        previewImg.src = enderecoImg + response.data.foto
    }
}
//Cancel edit
CancelEdit = () => {
    btnCancel.addEventListener('click', () => {
        boxModal.classList.add('invisible')
        formsProfile.classList.add('invisible')
    })
}
btnCancel && CancelEdit()