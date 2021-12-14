<?php
    namespace Server\Controllers;
    use Server\Models\Admin;
    use Server\Models\Funcionario;
    require_once "../../vendor/autoload.php";
    require_once "../functionImg.php";
    //Resgatando valores
    extract($_POST);
    $response = array();
    //Function validation Login
    function validationLogin(){
        if(isset($_COOKIE['idadmin'], $_COOKIE['token'])){
            if(Admin::validationLogin()){
                return true;
            }
        } else{
            setcookie('idadmin', '0', time() - 1);
            setcookie('token', '0', time() - 1);
            return false;
        }
    }
    if($tipo){
        if($tipo == 'cadastrar'){
            if(validationLogin()){
                //Se escolher uma imagem
                if($_FILES['foto']['error'] == 0) {
                    $nomeImg = uniqid().'.jpg';
                    if(converterImagem($_FILES['foto'],"../img/funcionario/$nomeImg",70,300,300)){
                        Funcionario::setNome($nome);
                        Funcionario::setTelefone($telefone);
                        Funcionario::setDtNascimento($dtNascimento);
                        Funcionario::setEspecializacao($especializacao);
                        Funcionario::setFoto($nomeImg);
                        Funcionario::cadastrar();
                        $response['status'] = 1;
                        $response['success'] = 'Funcionário(a) cadastrado com sucesso';
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Tipo de imagem inválido';
                    }
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Obrigatório escolher uma foto';
                }
                
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == "listar") {
            if(validationLogin()){
                $lista = Funcionario::listar();
                $response['status'] = 1;
                $response['list'] = $lista;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'editar') {
            if(validationLogin()) {
                if($_FILES['foto']['error'] == 0) {
                    Funcionario::setIdfuncionario($idfuncionario);
                    $dataFoto = Funcionario::gettingFoto();
                    $nomeImg = uniqid().".jpg";
                    if(converterImagem($_FILES['foto'],"../img/funcionario/$nomeImg",70, 300, 300)){
                        unlink("../img/funcionario/".$dataFoto['foto']);
                        Funcionario::setNome($nome);
                        Funcionario::setTelefone($telefone);
                        Funcionario::setDtNascimento($dtNascimento);
                        Funcionario::setEspecializacao($especializacao);
                        Funcionario::setFoto($nomeImg);
                        if(Funcionario::editar()) {
                            $response['status'] = 1;
                            $response['success'] = 'Dado(s) do(a) funcionário(a) editado com sucesso';
                        } else {
                            $response['status'] = 0;
                            $response['error'] = 'Erro ao editar registro';
                        }
                    } else{
                        $response['status'] = 0;
                        $response['error'] = 'Tipo de imagem inválido';
                    }
                } elseif($_FILES['foto']['error'] == 4) {
                    Funcionario::setIdfuncionario($idfuncionario);
                    Funcionario::setNome($nome);
                    Funcionario::setTelefone($telefone);
                    Funcionario::setDtNascimento($dtNascimento);
                    Funcionario::setEspecializacao($especializacao);
                    if(Funcionario::editarSemfoto()) {
                        $response['status'] = 1;
                        $response['success'] = 'Dado(s) do(a) funcionário(a) editado com sucesso';
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Erro ao editar registro';
                    }
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao carregar imagem. Tente outra';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'excluir') {
            if(validationLogin()){
                Funcionario::setIdfuncionario($idfuncionario);
                $dataCheck = Funcionario::checkSql();
                if($dataCheck['qtd'] == 1) {
                    Funcionario::setIdfuncionario($idfuncionario);
                    Funcionario::excluir();
                    unlink("../img/funcionario/".$dataCheck['foto']);
                    $response['status'] = 1;
                    $response['success'] = 'Funcionário(a) excluído com sucesso';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Doador não encontrado';
                }
            } else{
                $response['status'] = 0;
            }
        } elseif($tipo == 'getDados') {
            if(validationLogin()){
                Funcionario::setIdfuncionario($idfuncionario);
                $data = Funcionario::getDados();
                if($data['qtd'] == 1) {
                    $response['status'] = 1;
                    $response['data'] = $data;
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Funcionário(a) não encontrado(a)';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'buscar') {
            if(validationLogin()) {
                Funcionario::setNome($nome);
                $resultSearch = Funcionario::buscar();
                if(count($resultSearch) > 0) {
                    $response['status'] = 1;
                    $response['resultSearch'] = $resultSearch;
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Nenhum registro encontrado';
                }
            } else {
                $response['status'] = 0;
            }
        }
    } else {
        $response['status'] = 0;
        $response['error'] = 'Informe o tipo de requisição';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>