<?php

include "config.php";
include "banco.php";
include "ajudantes.php";
include "classes/Tarefa.php";
include "classes/Anexo.php";
include "classes/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($mysqli);
$tarefa = $repositorio_tarefas->buscar_tarefa($_GET['id']);

$exibir_tabela = false;
$tem_erros = false;
$erros_validacao = array();

if (tem_post()) {

    if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
        $tarefa->setNome($_POST['nome']);
    } else {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    if (isset($_POST['descricao'])) {
        $tarefa->setDescricao($_POST['descricao']);
    } else {
        $tarefa->setDescricao('');
    }

    if (isset($_POST['prazo']) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo'])) {
            $tarefa->setPrazo(traduz_data_br_para_objeto($_POST['prazo']));
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
    } else {
        $tarefa->setPrazo('');
    }

    $tarefa->setPrioridade($_POST['prioridade']);

    if (isset($_POST['concluida'])) {
        $tarefa->setConcluida(true);
    } else {
        $tarefa->setConcluida(false);
    }

    if (! $tem_erros) {
        $repositorio_tarefas->editar_tarefa($tarefa);

        if (isset($_POST['lembrete']) && $_POST['lembrete'] == '1') {
            $anexos = $repositorio_tarefas->buscar_anexos($tarefa->getId());

            enviar_email($tarefa, $anexos);
        }

        header('Location: tarefas.php');
        die();
    }
}

include "template.php";
