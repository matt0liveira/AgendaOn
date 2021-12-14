var btnVerSenha = document.getElementById("btnVerSenha")
var inputSenha = document.getElementById("senha")
btnVerSenha.addEventListener("click", function(){
    if(btnVerSenha.classList.contains("fa-eye-slash")){
        inputSenha["type"] = "text"
        btnVerSenha.classList.remove("fa-eye-slash")
        btnVerSenha.classList.add("fa-eye")
    } else{
        inputSenha["type"] = "password"
        btnVerSenha.classList.remove("fa-eye")
        btnVerSenha.classList.add("fa-eye-slash")
    }
})
validationLogin((response) => {
    redirection(response)
})