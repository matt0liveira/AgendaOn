const URL_ADMIN = "http://localhost/serverphp/TCC/Server/Controllers/AdminController.php"
var btnOpen = document.getElementById('btn-add')
var btnClose = document.getElementById('btn-close')
var boxModal = document.getElementById('box-modal')
var forms = document.querySelector('.modal-cadastro')
var previewImg = document.getElementById('img-user')
var inputFile = document.querySelector('#foto')
var btnCancel = document.getElementById('btn-cancel')
var titleModal = document.querySelector('.title-modal')
var btnSubmit = document.querySelector('.btn-submit')
var btnLogout = document.getElementById('btnLogout')
var box = document.querySelector('.box')
//fechando modal
closeModal = () => {
    btnClose.addEventListener('click', () => {
        boxModal.classList.add('invisible')
        forms.classList.add('invisible')
    })
}
btnClose && closeModal()
//preview de img
previewFoto = () => {
    inputFile.addEventListener('change', () => {
        let [file] = inputFile.files
        if(file){
            previewImg.src = URL.createObjectURL(file)
        }
    })
}
inputFile && previewFoto()
//tornando img padrão
defaultImg = () => {
    btnCancel.addEventListener('click', () => { 
        previewImg.src = imgDefault
    })
}
btnCancel && defaultImg()
//Logout
logoutClick = () => {
    btnLogout.addEventListener('click', () => {
        let data = new FormData()
        data.append("tipo", "logout")
        Ajax("POST", URL_ADMIN, data, logout)
    })
}
btnLogout && logoutClick()
logout = (response) => {
    if(response.status == 1){
        window.open("login.html", "_top")
    }
}
var detailsRegister
var btnView
var btnUpdate
 //abrindo div de detalhes de registro
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
//Function for to reset the forms
resetForms = () => {
    forms.reset()
    previewImg.src = imgDefault
}