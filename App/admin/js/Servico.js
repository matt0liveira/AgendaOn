const URL_WEBSERVICE = "http://localhost/serverphp/TCC/Server/Controllers/ServicoController.php"
const enderecoImg = "http://localhost/serverphp/TCC/Server/img/servico/"
var inputId = document.querySelector('#idservico')
var imgDefault = "http://localhost/serverphp/TCC/App/admin/img/img-default-servico.jpg"
var formSearch
validationLogin((response) => {
    if(response.status == 0){
        window.open("login.html", "_top")
    }
})
btnOpen.addEventListener('click', () => {
    boxModal.classList.remove('invisible')
    forms.classList.remove('invisible') 
    resetForms()
    inputId.value = 'NOVO VALOR'
    titleModal.innerHTML = 'Adicionar serviço'
    btnSubmit.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i>Cadastrar'
    btnSubmit.style.backgroundColor = '#198754'
})
function listagemFuncionario() {
    let data = new FormData()
    data.append('tipo', 'listar_funcionarios')
    Ajax("POST", URL_WEBSERVICE, data, listarFuncionarios)
}
//Listing funcionários
var selectFuncionario = document.querySelector('#fkfuncionario')
listarFuncionarios = (response) => {
    if(response.status == 1) {
        response.listaFuncionario.forEach(funcionario => {
            selectFuncionario.innerHTML += `
            <option value="${funcionario.idfuncionario}">${funcionario.nome}</option>
            `
        })
    }
}
//Submit forms of register serviço
forms.addEventListener('submit', (e) => {
    e.preventDefault()
    let data = new FormData(forms)
    if(isNaN(data.get('idservico'))) {
        data.append('tipo', 'cadastrar')
        Ajax("POST", URL_WEBSERVICE, data, cadastrar)
    } else {
        data.append('tipo', 'editar')
        Ajax("POST", URL_WEBSERVICE, data, editar)
    }
})
//Running cadastro
cadastrar = (response) => {
    if(response.status === 1){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success',
            title: response.success
        })
        resetForms()
        listar()
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'warning',
            title: response.error
        })
    }
}
//Running edit
editar = (response) => {
    if(response.status === 1){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success',
            title: response.success
        })
        listar()
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'warning',
            title: response.error
        })
    }
}
//Listing serviços
listar = () => {
    let data = new FormData()
    data.append('tipo', 'listar')
    Ajax("POST", URL_WEBSERVICE, data, listagem)
}
//Getting data of serviços
getData = (idservico) => {
    let data = new FormData()
    data.append('tipo', 'getData')
    data.append('idservico', idservico)
    Ajax("POST", URL_WEBSERVICE, data, preencherForms)
}
//Preenchendo forms
preencherForms = (response) => {
    if(response.status == 1) {
        boxModal.classList.remove('invisible')
        forms.classList.remove('invisible')
        titleModal.innerHTML = 'Editar registro' 
        btnSubmit.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i>Editar'
        btnSubmit.style.backgroundColor = '#FFCA2C'
        forms['idservico'].value = response.data.idservico
        forms['nome'].value = response.data.nome
        forms['descricao'].value = response.data.descricao
        forms['fkfuncionario'].value = response.data.fkfuncionario
        forms['duracao'].value = response.data.duracao
        forms['preco'].value = response.data.preco
        previewImg.src = enderecoImg + response.data.foto
    }
}
listagem = (response) => {
    box.innerHTML = `
        <form id="forms-search" class="forms-search">
            <input type="search" name="nome" id="nome" placeholder="Buscar por nome">
            <button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    `
    if(response.status === 1) {
        let pos = 0
        response.lista.forEach(servico => {
            box.innerHTML += `
                <div class="box-list">
                    <div class="preview-register">
                        <label for="nome" class="title-register">${servico.nome}</label>
                        <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                    </div>
                    <hr>
                    <div id="details-servico" class="details-register">
                        <div class="field-list">
                            <img src="${enderecoImg + servico.foto}">
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-id-card-o" aria-hidden="true"></i>Nome:</label>
                            <p>${servico.nome}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-commenting-o" aria-hidden="true"></i>Descrição:</label>
                            <p>${servico.descricao}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-clock-o" aria-hidden="true"></i>Duração:</label>
                            <p>${servico.duracao}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-money" aria-hidden="true"></i>Preço:</label>
                            <p>${servico.preco}</p>
                        </div>
                        <div class="field-actions">
                            <button class="btn-update" onclick="getData(${servico.idservico})"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</button>
                            <button class="btn-delete" onclick="excluir(${servico.idservico})"><i class="fa fa-trash-o" aria-hidden="true"></i>Excluir</button>
                        </div>
                    </div>
                </div>
            `
            formSearch = document.querySelector('.forms-search')
            FormSearch()
        })
        formSearch = document.querySelector('.forms-search')
        FormSearch()
    }
}
//Delete funcionário
excluir = (idservico) => {
    Swal.fire({
        title: 'Você tem certeza que deseja excluir este registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Excluído!',
                'Seu registro foi excluído com sucesso.',
                'Sucesso'
            )
            let data = new FormData()
            data.append('tipo', 'excluir')
            data.append('idservico', idservico)
            Ajax("POST", URL_WEBSERVICE, data, exclusao)
        }
      })
}
exclusao = (response) => {
    if(response.status === 1) {
        listar()
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'warning',
            title: response.error
        })
    }
}
// Function search
FormSearch = () => {
    formSearch.addEventListener('submit', (e) => {
        e.preventDefault()
        let data = new FormData(formSearch)
        data.append('tipo', 'buscar')
        Ajax('POST', URL_WEBSERVICE, data, search)
    })
}
search = (response) => {
    box.innerHTML = `
        <form id="forms-search" class="forms-search">
            <input type="search" name="nome" id="nome" placeholder="Buscar por nome">
            <button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    `
    if(response.status == 1) {
        let pos = 0
        response.resultSearch.forEach(servico => {
            box.innerHTML += `
                <div class="box-list">
                    <div class="preview-register">
                        <label for="nome" class="title-register">${servico.nome}</label>
                        <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                    </div>
                    <hr>
                    <div id="details-servico" class="details-register">
                        <div class="field-list">
                            <img src="${enderecoImg + servico.foto}">
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-id-card-o" aria-hidden="true"></i>Nome:</label>
                            <p>${servico.nome}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-commenting-o" aria-hidden="true"></i>Descrição:</label>
                            <p>${servico.descricao}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-clock-o" aria-hidden="true"></i>Duração:</label>
                            <p>${servico.duracao}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-money" aria-hidden="true"></i>Preço:</label>
                            <p>${servico.preco}</p>
                        </div>
                        <div class="field-actions">
                            <button class="btn-update" onclick="getData(${servico.idservico})"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</button>
                            <button class="btn-delete" onclick="excluir(${servico.idservico})"><i class="fa fa-trash-o" aria-hidden="true"></i>Excluir</button>
                        </div>
                    </div>
                </div>
            `
            formSearch = document.querySelector('.forms-search')
            FormSearch()
        })
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'warning',
            title: response.error
        })
        listar()
    }
}
//running listings
listagemFuncionario()
listar()