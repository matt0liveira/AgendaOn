const URL_AGENDAMENTO = "http://localhost/serverphp/TCC/Server/Controllers/AgendamentoController.php"
var boxAgenda = document.querySelector('#box-agenda')
var formSearch
var dateControlValue
var dataFormatada
validationLogin((response) => {
    if (response.status == 0) {
        window.open("login.html", "_top")
    }
})

var dateControl
const data = new Date()
var day = data.getDate()
var month = String(data.getMonth() + 1).padStart(2, '0')
var year = data.getFullYear()
var dayweek 
if(data.getDay() == 0) {
    dayweek = 'Domingo'
} else if(data.getDay() == 1) {
    dayweek = 'Segunda-feira'
} else if (data.getDay() == 2) {
    dayweek = 'Terça-feira'
} else if (data.getDay() == 3) {
    dayweek = 'Quarta-feira'
} else if (data.getDay() == 4) {
    dayweek = 'Quinta-feira'
} else if (data.getDay() == 5) {
    dayweek = 'Sexta-feira'
} else {
    dayweek = 'Sábado'
}
var dateFormat = day + '/' + month + '/' + year

listar = () => {
    let data = new FormData()
    data.append('tipo', 'listar_agendamentos')
    Ajax('POST', URL_AGENDAMENTO, data, listagem)
}
listagem = (response) => {
    boxAgenda.innerHTML = `
        <div class="header-agendamento">
            <h1>${dayweek + ' ' + dateFormat}</h1>
            <form id="search-agendamento">
                <input type="date" name="data" id="data" required>
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <hr>
    `
    if (response.status === 1) {
        let pos = 0
        response.agenda.forEach(agenda => {
            boxAgenda.innerHTML += `
                <div class="box-list">
                    <div class="preview-register">
                        <div class="title-agendamento">
                            <label class="title-register">${agenda.servico}</label>
                            <p>Hoje ${agenda.horario}</p>
                        </div>
                        <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                    </div>
                    <hr>
                    <div id="details-agendamento" class="details-register">
                        <div class="field-list">
                            <label for=""><i class="fa fa-user-circle-o" aria-hidden="true"></i> Cliente:</label>
                            <p>${agenda.cliente}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-clock-o" aria-hidden="true"></i> Horário:</label>
                            <p>${agenda.horario}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-scissors" aria-hidden="true"></i> Serviço:</label>
                            <p>${agenda.servico}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-user-o" aria-hidden="true"></i> Profissional:</label>
                            <p>${agenda.funcionario}</p>
                        </div>
                        <div class="field-actions">
                            <button class="btn-delete" onclick="excluir(${agenda.idagendamento})"><i class="fa fa-trash-o" aria-hidden="true"></i> Excluir</button>
                        </div>
                    </div>
                </div>
            `
            formSearch = document.querySelector('#search-agendamento')
            Search()
        })
    } else {
        boxAgenda.innerHTML += `<h1>${response.message}</h1>`
        formSearch = document.querySelector('#search-agendamento')
        Search()
    }
    dateControl = document.querySelector('input[type="date"]')
    var now = year + '-' + month + '-' + day
    dateControl.min = now
    dateChange()
}

excluir = (idagendamento) => {
    Swal.fire({
        title: 'Você tem certeza que deseja cancelar este agendamento?',
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
                'Agendamento cancelado com sucesso',
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

Search = () => {
    formSearch.addEventListener('submit', (e) => {
        e.preventDefault()
        let data = new FormData()
        data.append('tipo', 'buscar')
        data.append('data', dateControl.value)
        Ajax('POST', URL_AGENDAMENTO, data, resultSearch)
    })
}

resultSearch = (response) => {
    boxAgenda.innerHTML = `
        <div class="header-agendamento">
            <h1>Dia ${dataFormatada}</h1>
            <form id="search-agendamento">
                <input type="date" name="data" id="data" required>
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <hr>
    `
    if(response.status === 1) {
        let pos = 0
        response.busca.forEach(agenda => {
            boxAgenda.innerHTML += `
                <div class="box-list">
                    <div class="preview-register">
                        <div class="title-agendamento">
                            <label class="title-register">${agenda.servico}</label>
                            <p>${agenda.data} ${agenda.horario}</p>
                        </div>
                        <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                    </div>
                    <hr>
                    <div id="details-agendamento" class="details-register">
                    <div class="field-list">
                            <label for=""><i class="fa fa-user-circle-o" aria-hidden="true"></i> Cliente:</label>
                            <p>${agenda.cliente}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-clock-o" aria-hidden="true"></i> Horário:</label>
                            <p>${agenda.horario}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-scissors" aria-hidden="true"></i> Serviço:</label>
                            <p>${agenda.servico}</p>
                        </div>
                        <div class="field-list">
                            <label for=""><i class="fa fa-user-o" aria-hidden="true"></i> Profissional:</label>
                            <p>${agenda.funcionario}</p>
                        </div>
                        <div class="field-actions">
                            <button class="btn-delete" onclick="excluir(${agenda.idagendamento})"><i class="fa fa-trash-o" aria-hidden="true"></i> Excluir</button>
                        </div>
                    </div>
                </div>
            `
            formSearch = document.querySelector('#search-agendamento')
            Search()
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
            title: response.message
          })
        listar()
    }
    dateControl = document.querySelector('input[type="date"]')
    var now = year + '-' + month + '-' + day
    dateControl.min = now
    dateChange()
}

var dataFormatada
dateChange = () => {
    dateControl.addEventListener('change', () => {
        dateControlValue = dateControl.value
        var date
        var ano
        var mes
        var dia
        date = dateControlValue.split('-')
        ano = date[0]
        mes = date[1]
        dia = date[2]
        dataFormatada = dia + '/' + mes + '/' + ano
        console.log(dataFormatada)
    })
}

listar()