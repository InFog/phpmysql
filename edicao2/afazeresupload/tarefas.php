<?php

include "banco.php";
include "ajudantes.php";

$exibir_tabela = true;

$tem_erros = false;
$erros_validacao = [];

if (tem_post()) {
    $tarefa = array();

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
        gravar_tarefa($conexao, $tarefa);
        header('Location: tarefas.php');
        die();
    }
}

$lista_tarefas = buscar_tarefas($conexao);

$tarefa = [
    'id'         => 0,
    'nome'       => (isset($_POST['nome'])) ? $_POST['nome'] : '',
    'descricao'  => (isset($_POST['descricao'])) ? $_POST['descricao'] : '',
    'prazo'      => (isset($_POST['prazo'])) ? traduz_data_para_banco($_POST['prazo']) : '',
    'prioridade' => (isset($_POST['prioridade'])) ? $_POST['prioridade'] : 1,
    'concluida'  => (isset($_POST['concluida'])) ? $_POST['concluida'] : ''
];

include "template.php";
