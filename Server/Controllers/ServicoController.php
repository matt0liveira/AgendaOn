<?php
    namespace Server\Controllers;
    use Server\Models\Admin;
    use Server\Models\Servico;
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
    if($tipo) {
        if($tipo == 'listar_funcionarios') {
            if(validationLogin()) {
                $lista_funcionario = Funcionario::listing();
                $response['status'] = 1;
                $response['listaFuncionario'] = $lista_funcionario;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'cadastrar') {
            if(validationLogin()) {
                if($_FILES['foto']['error'] == 0) {
                    $nomeImg = uniqid().".jpg";
                    if(converterImagem($_FILES['foto'],"../img/servico/$nomeImg",70,300,300)) {
                        Servico::setFkfuncionario($fkfuncionario);
                        Servico::setNome($nome);
                        Servico::setDescricao($descricao);  
                        Servico::setDuracao($duracao);
                        Servico::setPreco($preco);
                        Servico::setFoto($nomeImg);
                        Servico::cadastrar();
                        $response['status'] = 1;
                        $response['success'] = 'Serviço cadastrado com sucesso';
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
        } elseif($tipo == 'listar') {
            if(validationLogin()) {
                $lista = Servico::listar();
                $response['status'] = 1;
                $response['lista'] = $lista;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'getData') {
            if(validationLogin()) {
                Servico::setIdservico($idservico);
                $data = Servico::getData();
                $response['status'] = 1;
                $response['data'] = $data;
                
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'editar') {
            if(validationLogin()) { 
                if($_FILES['foto']['error'] == 0) {
                    Servico::setIdservico($idservico);
                    $dataFoto = Servico::gettingFoto();
                    $nomeImg = uniqid().".jpg";
                    if(converterImagem($_FILES['foto'],"../img/servico/$nomeImg",70, 300, 300)) {
                        unlink("../img/servico/".$dataFoto['foto']);
                        Servico::setFkfuncionario($fkfuncionario);
                        Servico::setNome($nome);
                        Servico::setDescricao($descricao);
                        Servico::setDuracao($duracao);
                        Servico::setPreco($preco);
                        Servico::setFoto($nomeImg);
                        if(Servico::editar()) {
                            $response['status'] = 1;
                            $response['success'] = 'Dados do serviço editado com sucesso';
                        } else {
                            $response['status'] = 0;
                            $response['error'] = 'Erro ao editar dados do serviço';
                        }

                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Tipo de imagem inválido';
                    }
                } elseif($_FILES['foto']['error'] == 4) {
                    Servico::setIdservico($idservico);
                    Servico::setFkfuncionario($fkfuncionario);
                    Servico::setNome($nome);
                    Servico::setDescricao($descricao);
                    Servico::setDuracao($duracao);
                    Servico::setPreco($preco);
                    if(Servico::editarSemfoto()) {
                        $response['status'] = 1;
                        $response['success'] = 'Dados do serviço editado com sucesso';
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Erro ao editar dados do serviço';
                    }
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao carregar imagem. Tente outra';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'excluir') {
            if(validationLogin()) {
                Servico::setIdservico($idservico);
                $dataFoto = Servico::gettingFoto();
                if(Servico::excluir()) {
                    $response['status'] = 1;
                    $response['success'] = 'Serviço excluído com sucesso';
                    unlink("../img/servico/".$dataFoto['foto']);
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao excluir serviço';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'buscar') {
            if(validationLogin()) {
                Servico::setNome($nome);
                $resultSearch = Servico::buscar();
                if(count($resultSearch) > 0) {
                    $response['status'] = 1;
                    $response['resultSearch'] = $resultSearch;
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Nenhum serviço encontrado';
                }   
            } else {
                $response['status'] = 0;
            }
        } else {
            $response['status'] = 0;
            $response['error'] = 'Tipo de requisição inválida';
        }
    } else {
        $response['status'] = 0;
        $response['error'] = 'Informe o tipo de requisição';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>