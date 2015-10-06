<?php

session_start();

include "banco.php";
include "ajudantes.php";

$exibir_tabela = false;

if (isset($_GET['nome']) && $_GET['nome'] != '') {
    $tarefa = array();

    $tarefa['id'] = $_GET['id'];

    $tarefa['nome'] = $_GET['nome'];

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_GET['descricao'];
    } else {
        $tarefa['descricao'] = '';
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        $tarefa['prazo'] = traduz_data_para_banco($_GET['prazo']);
    } else {
        $tarefa['prazo'] = '';
    }

    $tarefa['prioridade'] = $_GET['prioridade'];

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = 1;
    } else {
        $tarefa['concluida'] = 0;
    }

    editar_tarefa($conexao, $tarefa);
    header('Location: tarefas.php');
    die();
}

$tarefa = buscar_tarefa($conexao, $_GET['id']);

include "template.php";
