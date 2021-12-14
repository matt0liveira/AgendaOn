<?php
    namespace Server\Controllers;
    use Server\Models\Admin;
    require_once "../../vendor/autoload.php";
    //Resgatando valores
    extract($_POST);
    $response = array();
    // $connPDO = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
    // $sql = "INSERT INTO admin VALUES(0,:email,:senha)";
    // $stmt = $connPDO->prepare($sql);
    // $stmt->bindParam(':email', $email);
    // $senha = password_hash($senha, PASSWORD_DEFAULT);
    // $stmt->bindParam(':senha', $senha);
    // $stmt->execute();
    // exit;
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
    if(isset($tipo)){
        if($tipo == 'logar'){
            Admin::setEmail($email);
            Admin::setSenha($senha);
            $data = Admin::logar();
            if(isset($data['idadmin'])){
                if(password_verify($senha, $data['senha'])){
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
                    $stmt->bindValue(':fkcliente', null);
                    $stmt->bindParam(':fkadmin', $data['idadmin']);
                    $stmt->execute();
                    $response['status'] = 1;
                    $response['success'] = 'Login efetuado com sucesso';
                    setcookie('token', $token, $durationCookie, '/');
                    setCookie('idadmin', $data['idadmin'], $durationCookie, '/');
                } else{
                    $response['status'] = 0;
                    $response['error'] = 'Senha incorreta';
                }
            } else{
                $response['status'] = 0;
                $response['error'] = 'Administrador não encontrado';
            }   
        } elseif($tipo == "validar_login") {
            if(validationLogin()){
                $response['status'] = 1;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == "logout"){
            if(validationLogin()){
                Admin::logout();
                $response['status'] = 1;
            } else{
                $response['status'] = 0;
            }
        } else {
            $response['status'] = 0;
            $response['error'] = 'Requisição inválida';
        }
    } else{
        $response['status'] = 0;
        $response['error'] = 'Informe o tipo de requisição';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>