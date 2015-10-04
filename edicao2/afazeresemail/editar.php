<?php

session_start();

include "config.php";
include "banco.php";
include "ajudantes.php";

$exibir_tabela = false;
$tem_erros = false;
$erros_validacao = array();

if (tem_post()) {
    $tarefa = array();

    $tarefa['id'] = $_POST['id'];

    if (array_key_exists('nome', $_POST) && $_POST['nome'] != '') {
        $tarefa['nome'] = $_POST['nome'];
    } else {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    } else {
        $tarefa['descricao'] = '';
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo'])) {
            $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
    } else {
        $tarefa['prazo'] = '';
    }

    $tarefa['prioridade'] = $_POST['prioridade'];

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = 1;
    } else {
        $tarefa['concluida'] = 0;
    }

    if (! $tem_erros) {
        editar_tarefa($conexao, $tarefa);

        if (array_key_exists('lembrete', $_POST) && $_POST['lembrete'] == '1') {
            $anexos = buscar_anexos($conexao, $tarefa['id']);

            enviar_email($tarefa, $anexos);
        }

        header('Location: tarefas.php');
        die();
    }
}

$tarefa = buscar_tarefa($conexao, $_GET['id']);

$tarefa['nome'] = (isset($_POST['nome'])) ? $_POST['nome'] : $tarefa['nome'];
$tarefa['descricao'] = (isset($_POST['descricao'])) ? $_POST['descricao'] : $tarefa['descricao'];
$tarefa['prazo'] = (isset($_POST['prazo'])) ? $_POST['prazo'] : $tarefa['prazo'];
$tarefa['prioridade'] = (isset($_POST['prioridade'])) ? $_POST['prioridade'] : $tarefa['prioridade'];
$tarefa['concluida'] = (isset($_POST['concluida'])) ? $_POST['concluida'] : $tarefa['concluida'];

include "template.php";
