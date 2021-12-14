const URL_AGENDAMENTO = "http://localhost/serverphp/TCC/Server/Controllers/AgendamentoController.php"
var formEdit = document.querySelector('.form-edit')
var btnClose = document.querySelector('.btn-close')
var boxModal = document.querySelector('.box-modal')
//validation login
validationLogin((response) => {
    if(response.status == 0){
        window.open("login.html", "_top")
    }
})
//Open details of event
openDetails = (pos) => {
    detailsRegister = document.querySelectorAll('.details-register')
    btnView = document.querySelectorAll('.btn-view')
    btnUpdate = document.querySelectorAll('.btn-update')
    if(detailsRegister[pos].classList.contains('transition-unfold')){
        btnView[pos].innerHTML = "Ver mais"
        detailsRegister[pos].classList.remove('transition-unfold')
    } else{
        btnView[pos].innerHTML = "Fechar"
        detailsRegister[pos].classList.add('transition-unfold')
    }
}
//Setting attribute min of input date
var dateControl = document.querySelector('input[type="date"]')
const data = new Date()
var day = data.getDate()
var month = String(data.getMonth() + 1).padStart(2, '0')
var year = data.getFullYear()
var now = year + '-' + month + '-' + day
dateControl.min = now
//Listing events
listar = () => {
    let data = new FormData()
    data.append('tipo', 'listar')
    Ajax('POST', URL_AGENDAMENTO, data, listagem)
}
var box = document.querySelector('.box-general')
listagem = (response) => {
    box.innerHTML = `<h1>Minha Agenda</h1>`
    if(response.status === 1) {
        let pos = 0
        response.agenda.forEach(agenda => {
            box.innerHTML += `
                <div class="box-list">
                    <div class="preview-register">
                        <label for="nome" class="title-register">${agenda.nomeServico}</label>
                        <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                    </div>
                    <hr>
                    <div class="details-register">
                        <div class="field-list">
                            <label for=""><i class="fa fa-calendar-o" aria-hidden="true"></i> Data:</label>
                            <p>${agenda.data}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-clock-o" aria-hidden="true"></i> Horário:</label>
                            <p>${agenda.horario}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-scissors" aria-hidden="true"></i> Serviço:</label>
                            <p>${agenda.nomeServico}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-user-o" aria-hidden="true"></i> Profissional:</label>
                            <p>${agenda.nomeFuncionario}</p>
                        </div>
                        <div class="field-actions">
                            <button class="btn-edit" onclick="getData(${agenda.idagendamento})"><i class="fa fa-pencil" aria-hidden="true"></i> Alterar</button>
                            <button class="btn-delete" onclick="excluir(${agenda.idagendamento})"><i class="fa fa-trash-o" aria-hidden="true"></i> Excluir</button>
                        </div>
                    </div>
                </div>
            `
            btnEdit = document.querySelector('.btn-edit')
        })
    }
}
//Listing serviços
listarServices = () => {
    let data = new FormData()
    data.append('tipo', 'listar_servicos')
    Ajax('POST', URL_AGENDAMENTO, data, listagemServices)
}
var selectServico = document.querySelector('#servico')
listagemServices = (response) => {
    if(response.status === 1) {
        response.listaServico.forEach(servico => {
            selectServico.innerHTML += `
            <option value="${servico.idservico}">${servico.nome}</option>
        `
        })
    }
}
//Function for to get horários from table 'agendamento'
var dateValue
gettingHorario = () => {
    let data = new FormData()
    data.append('tipo', 'getHorario')
    data.append('data', dateValue)
    Ajax('POST', URL_AGENDAMENTO, data, listHorarios)
}
dateControl.addEventListener('change', () => {
    let data = new FormData()
    data.append('tipo', 'getHorario')
    data.append('data', dateControl.value)
    Ajax('POST', URL_AGENDAMENTO, data, listHorarios)
})
var horariosDisabled = new Array()
var enabled = ""
listHorarios = (response) => {
    //cleaning array
    horariosDisabled.splice(0, horariosDisabled.length)
    if(response.status === 1) {
        response.horario.forEach(hr => {
            horariosDisabled.push(hr.horario)
        })
        listarHorario()
    }
}
//Listing horários
listarHorario = () => {
    let data = new FormData()
    data.append('tipo', 'listar_horario')
    Ajax('POST', URL_AGENDAMENTO, data, listagemHorario)
}
var selectHorario = document.querySelector('#horario')
listagemHorario = (response) => {
    selectHorario.innerHTML = `<option>Selecione um novo horário</option>`
    if(response.status === 1) {
        var inicio = response.horario.horarioEntrada
        var fim = response.horario.horarioSaida
        var intervalo = response.horario.intervalo_atendimento
        inicio = inicio.replace(':', '.')
        fim = fim.replace(':','.')
        intervalo = intervalo.replace('min','')
        if(inicio.split('.')[1] == 30) {
            inicio = inicio.split('.')[0].concat('.50')
        }
        if(fim.split('.')[1] == 30) {
            fim = fim.split('.')[0].concat('.50')
        }
        if(intervalo == 30) {
            intervalo = 0.5
        } else if(intervalo == 45) {
            intervalo = 0.75
        } else if(intervalo == 60) {
            intervalo = 1
        } else if(intervalo == 90) {
            intervalo = 1.5
        } else if(intervalo == 105) {
            intervalo = 1.75
        } else if(intervalo == 120) {
            intervalo = 2
        } else if(intervalo == 135) {
            intervalo = 2.15
        } else {
            intervalo = 2.5
        }
        inicio = parseFloat(inicio)
        fim = parseFloat(fim)
        intervalo = parseFloat(intervalo)
        for(let i = inicio; i <= fim; i += intervalo) {
            let hr = i.toFixed(2)
            if(hr.split('.')[1] == 50) {
                hr = hr.split('.')[0].concat(':30')
            } else if(hr.split('.')[1] == 75) {
                hr = hr.split('.')[0].concat(':45')
            } else if(hr.split('.')[1] == 60) {
                hr = hr + 1
                hr = hr.split('.')[0].concat(":00")
            }
            hr = hr.replace('.', ':')
            horariosDisabled.includes(hr) ? enabled = 'disabled' : enabled = ""
            selectHorario.innerHTML += `
                <option value="${hr}" ${enabled}>${hr}</option>
            `
        }
    }
}
//Function for to list funcionário
selectServico.addEventListener('change', () => {
    let data = new FormData()
    data.append('tipo', 'listar_funcionario')
    data.append('idservico', selectServico.value)
    Ajax('POST', URL_AGENDAMENTO, data, listagemFuncionario)
})
selectFuncionario = document.querySelector('#profissional')
listagemFuncionario = (response) => {
    if(response.status === 1) {
        selectFuncionario.innerHTML = `<option value="${response.funcionario.idfuncionario}">${response.funcionario.nome}</option>`
    }
}
listarFuncionario = () => {
    let data = new FormData()
    data.append('tipo', 'listarFuncionario')
    Ajax('POST', URL_AGENDAMENTO, data, listFuncionario)
}
listFuncionario = (response) => {
    if(response.status === 1) {
        response.funcionario.forEach(funcionario => {
            selectFuncionario.innerHTML += `
                <option value="${funcionario.idfuncionario}">${funcionario.nome}</option>
            `
        })
    }
}
//Function for to open form of edit
var btnEdit
openFormEdit = () => {
    formEdit.classList.remove('invisible')
    boxModal.classList.remove('invisible')
}
//Function for to close form of edit
btnClose.addEventListener('click', () => {
    boxModal.classList.add('invisible')
    formEdit.classList.add('invisible')
})
//Getting data from database for to edit register
getData = (idagendamento) => {
    let data = new FormData()
    data.append('tipo', 'getData')
    data.append('idagendamento', idagendamento)
    Ajax('POST', URL_AGENDAMENTO, data, preencherForms)
}
var horarioSelected
preencherForms = (response) => {
    openFormEdit()
    if(response.status === 1) {
        formEdit['idagendamento'].value = response.data.idagendamento
        formEdit['data'].value = response.data.data
        formEdit['horario'].value = response.data.horario
        formEdit['fkservico'].value = response.data.idservico
        formEdit['fkfuncionario'].value = response.data.idfuncionario
        dateValue = response.data.data
        horarioSelected = response.data.horario
        gettingHorario()
    }

}
//Function for to edit agendamento
formEdit.addEventListener('submit', (e) => {
    e.preventDefault()
    let data = new FormData(formEdit)
    data.append('tipo', 'editar')
    Ajax('POST', URL_AGENDAMENTO, data, editar)
})
editar = (response) => {
    if(response.status === 1) {
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
        excluir_agendamento()
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
//Function for to delete agendamento
excluir = (idagendamento) => {
    Swal.fire({
        title: 'Você tem certeza que deseja cancelar o agendamento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Cancelado!',
                'Seu agendamento foi cancelado com sucesso.',
                'Sucesso'
            )
            let data = new FormData()
            data.append('tipo', 'excluir')
            data.append('idagendamento', idagendamento)
            Ajax('POST', URL_AGENDAMENTO, data, exclusao)
        }
      })
}
exclusao = (response) => {
    if(response.status === 1) {
        listar()
    }
}
excluir_agendamento = () => {
    let data = new FormData()
    data.append('tipo', 'excluir_agendamento')
    Ajax('POST', URL_AGENDAMENTO, data, exclusao_agendamento)
}
exclusao_agendamento = (response) => {
    if(response.status === 1) {
        listar()
    }
}
listar()
listarServices()
listarFuncionario()
excluir_agendamento()