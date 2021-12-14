const URL_AGENDAMENTO = "http://localhost/serverphp/TCC/Server/Controllers/AgendamentoController.php"
const enderecoImgServico = "http://localhost/serverphp/TCC/Server/img/servico/"
validationLogin((response) => {
    if(response.status == 0){
        window.open("login.html", "_top")
    }
})
//Setting attribute min of input date
var dateControl = document.querySelector('input[type="date"]')
const data = new Date()
var day = data.getDate()
var month = String(data.getMonth() + 1).padStart(2, '0')
var year = data.getFullYear()
var now = year + '-' + month + '-' + day
dateControl.min = now
//Listing serviços
listagemServico = () => {
    let data = new FormData()
    data.append('tipo', 'listar_servicos')
    Ajax('POST', URL_AGENDAMENTO, data, listarServicos)
}
var selectServico = document.querySelector('#servico')
listarServicos = (response) => {
    if(response.status === 1) {
        response.listaServico.forEach(servico => {
            selectServico.innerHTML += `
                <option value="${servico.idservico}">${servico.nome}</option>
            `
        })
    }
}
ServicoChange = () => {
    selectServico.addEventListener('change', () => {
        let data = new FormData()
        data.append('tipo', 'servico_funcionario')
        data.append('idservico', selectServico.value)
        Ajax('POST', URL_AGENDAMENTO, data, servicoFuncionario)
    })
}
selectServico && ServicoChange()
var detailsServico = document.querySelector('.view-servico')
var selectProfissional = document.querySelector('#profissional')
servicoFuncionario = (response) => {
    if(response.status === 1) {
        detailsServico.innerHTML = `
            <div class="foto-servico">
                <img src="${enderecoImgServico + response.detailsServico.foto}" loading="lazy">
            </div>
            <div class="value-servico">
                <h3>Valor:</h3>
                <p>R$ ${response.detailsServico.preco}</p>
            </div>
            <div class="duration-servico">
                <h3>Duração:</h3>
                <p>${response.detailsServico.duracao}</p>
            </div>
         `
         selectProfissional.innerHTML = `
            <option value="${response.funcionario.idfuncionario}">${response.funcionario.nome}</option>
         `
    }
}
//Function for to get horários from table 'agendamento'
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
    }
    listagemHorario()
}
//Listing horários for the cliente
listagemHorario = () => {
    let data = new FormData()
    data.append('tipo', 'listar_horario')
    Ajax('POST', URL_AGENDAMENTO, data, listarHorario)
}
var selectHorario = document.querySelector('#horario')
listarHorario = (response) => {
    selectHorario.innerHTML = `
        <option>Selecione um horário</option>
    `
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
//Submit forms of agendamento
var formCadastro = document.querySelector('#form-agendamento')
Cadastro = () => {
    formCadastro.addEventListener('submit', (e) => {
        e.preventDefault()
        let data = new FormData(formCadastro)
        data.append('tipo', 'cadastrar')
        Ajax('POST', URL_AGENDAMENTO, data, cadastrar)
    })   
}
formCadastro && Cadastro()
cadastrar = (response) => {
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
        formCadastro.reset()
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
listagemServico()
// listagemHorario()