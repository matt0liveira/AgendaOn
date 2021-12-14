const tel = document.getElementById('tel') // Seletor do campo de telefone
tel.addEventListener('keypress', (e) => mascaraTelefone(e.target.value)) // Dispara quando digitado no campo
tel.addEventListener('change', (e) => mascaraTelefone(e.target.value)) // Dispara quando autocompletado o campo
const mascaraTelefone = (valor) => {
    valor = valor.replace(/\D/g, "")
    valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2")
    valor = valor.replace(/(\d)(\d{4})$/, "$1-$2")
    tel.value = valor // Insere o(s) valor(es) no campo
}

var btnsVerSenha = document.getElementsByClassName("btnVerSenha")
btnsVerSenha = Array.from(btnsVerSenha)
var inputsSenha = document.getElementsByClassName("inputSenha")
inputsSenha = Array.from(inputsSenha)
btnsVerSenha.forEach(btn =>{
    btn.addEventListener("click",()=>{
        let pos = btnsVerSenha.indexOf(btn)
        if(btnsVerSenha[pos].classList.contains("fa-eye-slash")){
            btnsVerSenha[pos].classList.remove("fa-eye-slash")
            btnsVerSenha[pos].classList.add("fa-eye")
            inputsSenha[pos].type = "text"
        } else{
            inputsSenha[pos].type = "password"
            btnsVerSenha[pos].classList.remove("fa-eye")
            btnsVerSenha[pos].classList.add("fa-eye-slash")
        }
    })
})
//preview de img
var previewImg = document.querySelector('#img-user')
var inputFile = document.querySelector('#foto')
inputFile.addEventListener('change', () => {
    let [file] = inputFile.files
    if(file){   
        previewImg.src = URL.createObjectURL(file)
    }
})
validationLogin((response) => {
    redirection(response)
})