<?php
    namespace Server\Controller;
    use Server\Models\Cliente;
    require_once "../../vendor/autoload.php";
    require_once "../functionImg.php";
    //Resgatando valores
    extract($_POST);
    $response = array();
    //Function validation Login
    function validationLogin(){
        if(isset($_COOKIE['idcliente'], $_COOKIE['token'])){
            if(Cliente::validationLogin()){
                return true;
            }
        } else{
            setcookie('idcliente', '0', time() - 1);
            setcookie('token', '0', time() - 1);
            return false;
        }
    }
    if($tipo) {
        if($tipo == 'cadastrar') {
            if($senha == $confirmSenha) {
                if(strlen($senha) >= 5) {
                    if($_FILES['foto']['error'] == 0) {
                        $nomeImg = uniqid().".jpg";
                        if(converterImagem($_FILES["foto"],"../img/cliente/$nomeImg",70,300,300)) {
                            Cliente::setNome($nome);
                            Cliente::setEmail($email);
                            $senha = password_hash($senha, PASSWORD_DEFAULT);
                            Cliente::setSenha($senha);
                            Cliente::setTelefone($telefone);
                            Cliente::setFoto($nomeImg);
                            if(Cliente::cadastrar()) {
                                $response['status'] = 1;
                                $response['success'] = 'Cadastro realizado com sucesso';
                            } else {
                                $response['status'] = 0;
                                $response['error'] = 'Erro ao realizar cadastro';
                            }
                        } else {
                            $response['status'] = 0;
                            $response['error'] = 'Tipo de imagem inválido';
                        }
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Escolha uma imagem';
                    }
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'A senha deve ter pelo menos 5 caracteres';
                }
            } else {
                $response['status'] = 0;
                $response['error'] = "Campos 'Senha' e 'Confirmar senha' devem ser iguais";
            }
        } elseif($tipo == 'logar') {
            Cliente::setEmail($email);
            Cliente::setSenha($senha);
            $data = Cliente::logar();
            if(isset($data['idcliente'])) {
                if(password_verify($senha, $data['senha'])) {
                    //Getting data of device
                    $so = $_SERVER['HTTP_USER_AGENT'];
                    //generating token random
                    $token = bin2hex(random_bytes(32));
                    //determining duration of cookie
                    $durationCookie = time() + ((3600 * 24) * 30);
                    $sql = "INSERT INTO dispositivo VALUES(0,:so,:token,now(),:fkcliente,:fkadmin)";
                    $connPDO = new \PDO(DBDRIVE.":hostname=".DBHOST.";dbname=".DBNAME,DBUSER,DBPASS);
                    $stmt = $connPDO->prepare($sql);
                    $stmt->bindParam(':so', $so);
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':fkcliente', $data['idcliente']);
                    $stmt->bindValue(':fkadmin', null);
                    $stmt->execute();
                    setcookie('token', $token, $durationCookie, '/');
                    setCookie('idcliente', $data['idcliente'], $durationCookie, '/');
                    $response['status'] = 1;
                    $response['success'] = 'Login efetuado com sucesso';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Senha incorreta';
                }
            } else {
                $response['status'] = 0;
                $response['error'] = "Endereço de e-mail não cadastrado";
            }
        } elseif($tipo == 'validar_login') {
            if(validationLogin()) {
                $response['status'] = 1;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'logout') {
            if(validationLogin()) {
                Cliente::logout();
                $response['status'] = 1;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar') {
            if(validationLogin()) {
                $data = Cliente::listar();
                $response['status'] = 1;
                $response['data'] = $data;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'editar') {
            if(validationLogin()) {
                if($_FILES['foto']['error'] == 0) {
                    $dataFoto = Cliente::gettingFoto();
                    $nomeImg = uniqid().".jpg";
                    if(converterImagem($_FILES['foto'],"../img/cliente/$nomeImg",70, 300, 300)) {
                        unlink('../img/cliente/'.$dataFoto['foto']);
                        Cliente::setNome($nome);
                        Cliente::setTelefone($telefone);
                        Cliente::setFoto($nomeImg);
                        if(Cliente::editar()) {
                            $response['status'] = 1;
                            $response['success'] = 'Informações editadas com sucesso';
                        } else {
                            $response['status'] = 0;
                            $response['error'] = 'Erro ao editar informações';
                        }
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Tipo de imagem inválido';
                    }
                } elseif($_FILES['foto']['error'] == 4) {
                    Cliente::setNome($nome);
                    Cliente::setTelefone($telefone);
                    if(Cliente::editarSemfoto()) {
                        $response['status'] = 1;
                        $response['success'] = 'Informações editadas com sucesso';
                    } else {
                        $response['status'] = 0;
                        $response['error'] = 'Erro ao editar informações';
                    }
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao carregar imagem. Tente outra';
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