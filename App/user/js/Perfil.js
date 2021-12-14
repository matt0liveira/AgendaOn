validationLogin((response) => {
    if(response.status === 0){
        window.open("login.html", "_top")
    }
})
//preview de img
var inputFile = document.getElementById('foto')
inputFile.addEventListener('change', (e) => {
    let [file] = inputFile.files
    if(file){
        previewImg.src = URL.createObjectURL(file)
    }
})
toEdit = () => {
    formsProfile.addEventListener('submit', (e) => {
        e.preventDefault()
        let data = new FormData(formsProfile)
        data.append('tipo', 'editar')
        Ajax('POST', URL_WEBSERVICE, data, editar)
    })
}
formsProfile && toEdit()
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
            icon: 'error',
            title: response.error
        })
    }
}
listar()