<?php

session_start();

include "banco.php";
include "ajudantes.php";

$exibir_tabela = true;

if (array_key_exists('nome', $_POST) && $_POST['nome'] != '') {
    $tarefa = [];

    $tarefa['nome'] = $_POST['nome'];

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    } else {
        $tarefa['descricao'] = '';
    }

    if (array_key_exists('prazo', $_POST)) {
        $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
    } else {
        $tarefa['prazo'] = '';
    }

    $tarefa['prioridade'] = $_POST['prioridade'];

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = 1;
    } else {
        $tarefa['concluida'] = 0;
    }

    gravar_tarefa($conexao, $tarefa);
    header('Location: tarefas.php');
    die();
}

$lista_tarefas = buscar_tarefas($conexao);

$tarefa = [
    'id'         => 0,
    'nome'       => '',
    'descricao'  => '',
    'prazo'      => '',
    'prioridade' => 1,
    'concluida'  => ''
];

include "template.php";
