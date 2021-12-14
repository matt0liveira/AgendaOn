//abrindo modal para editar registro
var detailsRegister = document.getElementsByClassName('details-register')
var arrayBtnView = document.getElementsByClassName('btn-view')
arrayBtnView = Array.from(arrayBtnView)
var arrayBtnUpdate = document.getElementsByClassName('btn-update')
arrayBtnUpdate = Array.from(arrayBtnUpdate)
var titleModal = document.querySelector('.title-modal')
var btnSubmit = document.querySelector('.btn-submit')
arrayBtnView.forEach((btnView) => {
    btnView.addEventListener('click', () => {
        let pos = arrayBtnView.indexOf(btnView)
        if(detailsRegister[pos].classList.contains('transition-unfold')){
            btnView.innerHTML = "Ver mais"
            detailsRegister[pos].classList.remove('transition-unfold')
        } else{
            btnView.innerHTML = "Fechar"
            detailsRegister[pos].classList.add('transition-unfold')
        }
    })
})
//Abrindo modal para editar registro
arrayBtnUpdate.forEach((btnUpdate) => {
    btnUpdate.addEventListener('click', () => {
        boxModal.classList.remove('invisible')
        modals.forEach(modal => {
            modal.classList.remove('invisible')
        })
        titleModal.innerHTML = 'Editar registro' 
        btnSubmit.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i>Editar'
        btnSubmit.style.backgroundColor = '#FFCA2C';
    })
})