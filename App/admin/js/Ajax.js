function Ajax(method, url, data, action){
    let req = new XMLHttpRequest()
    req.onreadystatechange = () => {
        if(req.readyState === 4 && req.status === 200){
            //Resgatando resposta do servidor
            let response = JSON.parse(req.responseText)
            action(response)
        }
    }
    req.open(method, url, true)
    req.send(data)
}
//Function of validation login
validationLogin = (returnLogin) => {
    let data = new FormData()
    data.append("tipo", "validar_login")
    Ajax("POST", URL_ADMIN, data, returnLogin)
}