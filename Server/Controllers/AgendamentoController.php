<?php
    namespace Server\Controller;
    use Server\Models\Agendamento;
    use Server\Models\Cliente;
    use Server\Models\Servico;
    use Server\Models\Funcionario;
    use Server\Models\HorarioAtd;
    require_once "../../vendor/autoload.php";
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
        if($tipo == 'listar_servicos') {
            if(validationLogin()) {
                $listaServico = Servico::listing();
                $response['status'] = 1;
                $response['listaServico'] = $listaServico;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'servico_funcionario') {
            if(validationLogin()) {
                Servico::setIdservico($idservico);
                $details = Servico::details();
                $funcionario = Servico::listingFuncionario();
                $response['status'] = 1;
                $response['detailsServico'] = $details;
                $response['funcionario'] = $funcionario;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar_horario') {
            if(validationLogin()) {
                $data = HorarioAtd::listing();
                $response['status'] = 1;
                $response['horario'] = $data;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'cadastrar') {
            if(validationLogin()) {
                Agendamento::setFkcliente($_COOKIE['idcliente']);
                Agendamento::setFkservico($servico);
                Agendamento::setFkfuncionario($profissional);
                Agendamento::setData($data);
                Agendamento::setHorario($horario);
                if(Agendamento::cadastrar()) {
                    $data = date('d/m/Y', strtotime($data));
                    $response['status'] = 1;
                    $response['success'] = "Agendamento para $data às $horario marcado com sucesso";
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao realizar agendamento';
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar') {
            if(validationLogin()) {
                Agendamento::setFkcliente($_COOKIE['idcliente']);
                $agenda = Agendamento::listingAgendamento();
                $response['status'] = 1;
                $response['agenda'] = $agenda;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'getData') {
            if(validationLogin()) {
                Agendamento::setIdagendamento($idagendamento);
                $data = Agendamento::gettingData();
                $response['status'] = 1;
                $response['data'] = $data;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar_funcionario') {
            if(validationLogin()) {
                Servico::setIdservico($idservico);
                $funcionario = Servico::listingFuncionario();
                $response['status'] = 1;
                $response['funcionario'] = $funcionario;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listarFuncionario') {
            if(validationLogin()) {
                $funcionario = Funcionario::listing();
                $response['status'] = 1;
                $response['funcionario'] = $funcionario;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'editar') {
            if(validationLogin()) {
                Agendamento::setIdagendamento($idagendamento);
                Agendamento::setFkcliente($_COOKIE['idcliente']);
                Agendamento::setFkservico($fkservico);
                Agendamento::setFkfuncionario($fkfuncionario);
                Agendamento::setData($data);
                Agendamento::setHorario($horario);
                if(Agendamento::editar()) {
                    $response['status'] = 1;
                    $response['success'] = 'Sucesso ao alterar dados do agendamento';
                } else {
                    $response['status'] = 0;
                    $response['error'] = 'Erro ao alterar dados do agendamento';
                }
            } else {    
                $response['status'] = 0;
            }
        } elseif($tipo == 'excluir') {
            Agendamento::setIdagendamento($idagendamento);
            if(Agendamento::excluir()) {
                $response['status'] = 1;
                $response['success'] = 'Agendamento cancelado com sucesso';
            } else {
                $response['status'] = 0;
                $response['error'] = 'Erro ao cancelar agendamento';
            }
        } elseif($tipo == 'getHorario') {
            if(validationLogin()) {
                Agendamento::setData($data);
                $hr = Agendamento::gettingHorario();
                $response['status'] = 1;
                $response['horario'] = $hr;
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'excluir_agendamento') {
            if(validationLogin()) {
                if(Agendamento::excluir_agendamento()) {
                    $response['status'] = 1;
                } else {
                    $response['status'] = 0;
                }
            } else {
                $response['status'] = 0;
            }
        } elseif($tipo == 'listar_agendamentos') {
            $agenda = Agendamento::listar();
            if(empty($agenda)) {
                $response['status'] = 0;
                $response['message'] = 'Sem agendamentos para hoje :(';
            } else {
                $response['status'] = 1;
                $response['agenda'] = $agenda;
            }
        } elseif($tipo == 'buscar') {
            Agendamento::setData($data);
            $busca = Agendamento::buscar();
            if(empty($busca)) {
                $response['status'] = 0;
                $response['message'] = 'Nenhum agendamento encontrado';
            } else {
                $response['status'] = 1;
                $response['busca'] = $busca;
            }
        }
        else {
            $response['status'] = 0;
            $response['error'] = 'Requisição inválida';
        }
    } else {
        $response['status'] = 0;
        $response['error'] = 'Informe o tipo da requisição';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>