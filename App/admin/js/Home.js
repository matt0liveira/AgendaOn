const URL_WEBSERVICE = "http://localhost/serverphp/TCC/Server/Controllers/AdminController.php"
validationLogin((response) => {
    if(response.status == 0){
        window.open("login.html", "_top")
    }
})