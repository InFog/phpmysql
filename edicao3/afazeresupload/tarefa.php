<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "banco.php";
include "ajudantes.php";

$tarefa = buscar_tarefa($conexao, $_GET['id']);

if (! is_array($tarefa)) {
    http_response_code(404);
    echo "Tarefa não encontrada.";
    die();
}

$tem_erros = false;
$erros_validacao = array();

if (tem_post()) {
    // upload dos anexos
    $tarefa_id = $_POST['tarefa_id'];

    if (! isset($_FILES['anexo'])) {
        $tem_erros = true;
        $erros_validacao['anexo'] = 'Você deve selecionar um arquivo para anexar';
    } else {
        if (tratar_anexo($_FILES['anexo'])) {
            $anexo = array();
            $anexo['tarefa_id'] = $tarefa_id;
            $anexo['nome'] = substr($_FILES['anexo']['name'], 0, -4);
            $anexo['arquivo'] = $_FILES['anexo']['name'];
        } else {
            $tem_erros = true;
            $erros_validacao['anexo'] = 'Envie apenas anexos nos formatos zip ou pdf';
        }
    }

    if (! $tem_erros) {
        gravar_anexo($conexao, $anexo);
    }
}

$anexos = buscar_anexos($conexao, $_GET['id']);

include "template_tarefa.php";
