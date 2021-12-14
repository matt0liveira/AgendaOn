const URL_WEBSERVICE = "http://localhost/serverphp/TCC/Server/Controllers/HorarioAtdController.php"
var inputId = document.querySelector('#idhorarioAtd')
validationLogin((response) => {
    if(response.status == 0){
        window.open("login.html", "_top")
    }
})
btnOpen.addEventListener('click', () => {
    boxModal.classList.remove('invisible')
    forms.classList.remove('invisible') 
    forms.reset()
    inputId.value = 'NOVO VALOR'
    titleModal.innerHTML = 'Horário de atendimento'
    btnSubmit.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i>Cadastrar'
    btnSubmit.style.backgroundColor = '#198754';
})
 //preenchendo select 'horario'
 var horario_entrada = document.getElementById('horarioEntrada')
 var horario_saida = document.getElementById('horarioSaida')
 var inicio = 0
 var fim = 23
 var intervalo = 0.50
 for(let i = inicio; i <= fim; i += intervalo) {
     let hr = i.toFixed(2)
     if(hr.split('.')[1] == 50){
         hr = hr.split('.')[0].concat(':30')
     }
     hr = hr.replace('.',':')
     horario_entrada.innerHTML += `
             <option value="${hr}">${hr}</option>
         `
     horario_saida.innerHTML += `
             <option value="${hr}">${hr}</option>
         `
 }
//Submit forms of register horário de atendimento
forms.addEventListener('submit', (e) => {
    e.preventDefault()
    let data = new FormData(forms)
    if(isNaN(data.get('idhorarioAtd'))) {
        data.append('tipo', 'cadastrar')
        Ajax("POST", URL_WEBSERVICE, data, cadastrar)
    } else {
        data.append('tipo', 'editar')
        Ajax("POST", URL_WEBSERVICE, data, editar)
    }
})
//Running cadastro
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
        forms.reset()
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
//Running listing
listar = () => {
    let data = new FormData()
    data.append("tipo", "listar")
    Ajax("POST", URL_WEBSERVICE, data, listagem)
}
//function of listing horários de atendimento
listagem = (response) => {
    box.innerHTML = `
        <h1>Últimos horários de atendimento adicionados</h1>
    `
    if(response.status == 1){
        let pos = 0
        let numeracao = 1
        response.lista.forEach(horarioAtd => {
            box.innerHTML += `
            <div class="box-list">
                <div class="preview-register">
                    <label for="nome" class="title-register">Horário de atendimento ${numeracao++}</label>
                    <button class="btn-view" onclick="openDetails(${pos++})">Ver mais</button>
                </div>
                <hr>
                <div id="details-horarioAtd" class="details-register">
                    <div class="field-list">
                        <label for=""><i class="fa fa-arrow-right" aria-hidden="true"></i>Horário de entrada:</label>
                        <p>${horarioAtd.horarioEntrada}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-arrow-left" aria-hidden="true"></i>Horário de saída:</label>
                        <p>${horarioAtd.horarioSaida}</p>
                    </div>
                    <div class="field-list">
                        <label for=""><i class="fa fa-pause" aria-hidden="true"></i>Intervalo de atendimento:</label>
                        <p>${horarioAtd.intervalo_atendimento}</p>
                    </div>
                    <div class="field-actions">
                        <button class="btn-update" onclick="getData(${horarioAtd.idhorario_atendimento})"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</button>
                        <button class="btn-delete" onclick="excluir(${horarioAtd.idhorario_atendimento})"><i class="fa fa-trash-o" aria-hidden="true"></i>Excluir</button>
                    </div>
                </div>
            </div>
            `
            })
    }
}
listar()
//Method delete horário de atendimento
excluir = (idhorarioAtd) => {
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
            data.append("idhorarioAtd", idhorarioAtd)
            Ajax("POST", URL_WEBSERVICE, data, exclusao)
        }
      })
}
//Running method delete
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
//getting data
getData = (idhorarioAtd) => {
    let data = new FormData()
    data.append('tipo', 'getData')
    data.append('idhorarioAtd', idhorarioAtd)
    Ajax("POST", URL_WEBSERVICE, data, preencherForms)
}
//filling in form to edit
preencherForms = (response) => {
    if(response.status === 0) {
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
    } else {
        boxModal.classList.remove('invisible')
        forms.classList.remove('invisible')
        titleModal.innerHTML = 'Editar registro' 
        btnSubmit.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i>Editar'
        btnSubmit.style.backgroundColor = '#FFCA2C'
        forms['idhorarioAtd'].value = response.data.idhorario_atendimento
        forms['horarioEntrada'].value = response.data.horarioEntrada
        forms['horarioSaida'].value = response.data.horarioSaida
        forms['intervaloAtendimento'].value = response.data.intervalo_atendimento
    }
}