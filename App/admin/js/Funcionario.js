const URL_WEBSERVICE = "http://localhost/serverphp/TCC/Server/Controllers/FuncionarioController.php"
const enderecoImg = "http://localhost/serverphp/TCC/Server/img/funcionario/"
var inputId = document.querySelector('#idfuncionario')
var imgDefault = "http://localhost/serverphp/TCC/App/admin/img/user.png"
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
    titleModal.innerHTML = 'Adicionar funcionário'
    btnSubmit.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i>Cadastrar'
    btnSubmit.style.backgroundColor = '#198754';
})
//Submit forms of register funcionário
forms.addEventListener('submit', (e) => {
    e.preventDefault()
    let data = new FormData(forms)
    if(isNaN(data.get('idfuncionario'))) {
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
    } else  {
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
            icon: 'error',
            title: response.error
          })
    }
}
//Running edit
editar = (response) => {
    if(response.status == 1){
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
            icon: 'error',
            title: response.error
        })
    }
}
//Running listing
listar = () => {
    let data = new FormData()
    data.append("tipo", "listar")
    Ajax("POST", URL_WEBSERVICE, data, listagem)
}
//function of listing funcionários
listagem = (response) => {
    box.innerHTML = `
        <form id="forms-search" class="forms-search">
            <input type="search" name="nome" id="nome" placeholder="Buscar por nome">
            <button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    `
    if(response.status == 1){
        let pos = 0
        response.list.forEach(funcionario => {
            box.innerHTML += `
            <div class="box-list">
                <div class="preview-register">
                    <label for="nome" class="title-register">${funcionario.nome}</label>
                    <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                </div>
                <hr>
                <div id="details-funcionario" class="details-register">
                    <input type="hidden" name="idfuncionario" value="${funcionario.idfuncionario}">
                    <div class="field-profile">
                        <img src="${enderecoImg+funcionario.foto}">
                        <h3>${funcionario.nome}</h3>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-phone" aria-hidden="true"></i>Telefone:</label>
                        <p>${funcionario.telefone}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-birthday-cake" aria-hidden="true"></i>Data de nascimento:</label>
                        <p>${funcionario.dtNascimento}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-scissors" aria-hidden="true"></i>Especialização:</label>
                        <p>${funcionario.especializacao}</p>
                    </div>
                    <div class="field-actions">
                        <button class="btn-update" onclick="getDados(${funcionario.idfuncionario})"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</button>
                        <button class="btn-delete" onclick="excluir(${funcionario.idfuncionario})"><i class="fa fa-trash-o" aria-hidden="true"></i>Excluir</button>
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
//Method delete funcinário
excluir = (idfuncionario) => {
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
            data.append("tipo", "excluir")
            data.append("idfuncionario", idfuncionario)
            Ajax("POST", URL_WEBSERVICE, data, exclusao)
        }
      })
}
//Running method delete
exclusao = (response) => {
    if(response.status === 1){
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
            icon: 'error',
            title: response.error
        })
    }
}
//Getting data
getDados = (idfuncionario) => {
    let data = new FormData()
    data.append('tipo', 'getDados')
    data.append('idfuncionario', idfuncionario)
    Ajax("POST", URL_WEBSERVICE, data, preencherForms)
}
//filling in form to edit
preencherForms = (response) => {
    if(response.status === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.error,
        })
    } else {
        boxModal.classList.remove('invisible')
        forms.classList.remove('invisible')
        titleModal.innerHTML = 'Editar registro' 
        btnSubmit.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i>Editar'
        btnSubmit.style.backgroundColor = '#FFCA2C'
        forms['idfuncionario'].value = response.data.idfuncionario
        forms['nome'].value = response.data.nome
        forms['telefone'].value = response.data.telefone
        forms['dtNascimento'].value = response.data.dtNascimento
        forms['especializacao'].value = response.data.especializacao
        previewImg.src = enderecoImg + response.data.foto
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
        response.resultSearch.forEach(funcionario => {
            box.innerHTML += `
            <div class="box-list">
                <div class="preview-register">
                    <label for="nome" class="title-register">${funcionario.nome}</label>
                    <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                </div>
                <hr>
                <div id="details-funcionario" class="details-register">
                    <input type="hidden" name="idfuncionario" value="${funcionario.idfuncionario}">
                    <div class="field-profile">
                        <img src="${enderecoImg+funcionario.foto}">
                        <h3>${funcionario.nome}</h3>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-phone" aria-hidden="true"></i>Telefone:</label>
                        <p>${funcionario.telefone}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-birthday-cake" aria-hidden="true"></i>Data de nascimento:</label>
                        <p>${funcionario.dtNascimento}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-birthday-cake" aria-hidden="true"></i>Especialização:</label>
                        <p>${funcionario.especializacao}</p>
                    </div>
                    <div class="field-actions">
                        <button class="btn-update" onclick="getDados(${funcionario.idfuncionario})"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</button>
                        <button class="btn-delete" onclick="excluir(${funcionario.idfuncionario})"><i class="fa fa-trash-o" aria-hidden="true"></i>Excluir</button>
                    </div>
                </div>
            </div>
            `
            formSearch = document.querySelector('.forms-search')
            FormSearch()
            })   
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: response.error,
        })
        listar()
    }
}
listar()