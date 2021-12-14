URL_ADMIN = "http://localhost/serverphp/TCC/Server/Controllers/AdminController.php"
const formsLogin = document.getElementById('formsLogin')
//Function of redirection
redirection = (response) => {
    if(response.status === 1){
        window.open("home.html", "_top")
    }
}
//Function of confirmation login
confirmLogin = (response) => {
    if(response.status === 1){
        Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            text: response.success,
          })
        redirection(response)
    } else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.error,
        })
    }
}
//Submit formsLogin
formsLogin.addEventListener('submit', (e) => {
    e.preventDefault()
    let data = new FormData(formsLogin)
    data.append("tipo", "logar")
    Ajax("POST", URL_ADMIN, data, confirmLogin)
})
validationLogin((response) => {
    redirection(response)
})