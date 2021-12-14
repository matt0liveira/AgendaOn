const URL_WEBSERVICE = "http://localhost/serverphp/TCC/Server/Controllers/ClienteController.php"
function Ajax(method, url, data, action){
    let req = new XMLHttpRequest();
    req.onreadystatechange = () => {
        if(req.readyState === 4 && req.status === 200){
            //Resgatando resposta do servidor
            let response = JSON.parse(req.responseText)
            action(response)
        }
    }
    req.open(method, url, true);
    req.send(data)
}
//Function of validation login
validationLogin = (returnLogin) => {
    let data = new FormData()
    data.append("tipo", "validar_login")
    Ajax("POST", URL_WEBSERVICE, data, returnLogin)
}
//Logout
logoutClick = () => {
    let data = new FormData()
    data.append("tipo", "logout")
    Ajax("POST", URL_WEBSERVICE, data, logout)
}
logout = (response) => {
    if(response.status === 1){
        window.open("login.html", "_top")
    }
}