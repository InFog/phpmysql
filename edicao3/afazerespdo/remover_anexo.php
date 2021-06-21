<?php

require "config.php";
require "banco.php";
require "classes/Anexo.php";
require "classes/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($pdo);

try {
    $anexo = $repositorio_tarefas->buscar_anexo($_GET['id']);
} catch (Exception $e) {
    http_response_code(404);
    echo "Erro ao buscar anexo: " . $e->getMessage();
    die();
}

$repositorio_tarefas->remover_anexo($anexo->getId());
unlink('anexos/' . $anexo->getArquivo());

header('Location: tarefa.php?id=' . $anexo->getTarefaId());
