<?php
    namespace Server\Controllers;
    use Server\Models\Admin;
    use Server\Models\HorarioAtd;
    require_once "../../vendor/autoload.php";
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
        if($tipo == 'cadastrar') {
            if(validationLogin()) {
                HorarioAtd::setHorarioEntrada($horarioEntrada);
                HorarioAtd::setHorarioSaida($horarioSaida);
                HorarioAtd::setIntervalo_atd($intervaloAtendimento);
                if(HorarioAtd::cadastrar()) {
                    $response['status'] = 1;
                    $response['success'] = 'Horário de atendimento cadastrado com sucesso';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao cadastrar horário de atendimento';
                }   
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar') {
            if(validationLogin()) {
                $lista = HorarioAtd::listar();
                $response['status'] = 1;
                $response['lista'] = $lista;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'excluir') {
            if(validationLogin()) {
                HorarioAtd::setIdhorario_atd($idhorarioAtd);
                if(HorarioAtd::excluir()) {
                    $response['status'] = 1;
                    $response['success'] = 'Horário de atendimento excluído com sucesso';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao excluir horário de atendimento';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'editar') {
            if(validationLogin()) {
                HorarioAtd::setIdhorario_atd($idhorarioAtd);
                HorarioAtd::setHorarioEntrada($horarioEntrada);
                HorarioAtd::setHorarioSaida($horarioSaida);
                HorarioAtd::setIntervalo_atd($intervaloAtendimento);
                if(HorarioAtd::editar()) {
                    $response['status'] = 1;
                    $response['success'] = 'Horário de atendimento editado com sucesso';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao editar horário de atendimento';
                }
            } else {    
                $response['status'] = 0;
            }
        } elseif($tipo == 'getData') {
            if(validationLogin()) {
                HorarioAtd::setIdhorario_atd($idhorarioAtd);
                $data = HorarioAtd::getData();
                $response['status'] = 1;
                $response['data'] = $data;
            } else {
                $response['status'] = 0;
            }
        }
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>