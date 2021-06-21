<?php

include "banco.php";

$anexo = buscar_anexo($conexao, $_GET['id']);

if (! is_array($anexo)) {
    http_response_code(404);
    echo "Anexo não encontrado.";
    die();
}

remover_anexo($conexao, $anexo['id']);
unlink('anexos/' . $anexo['arquivo']);

header('Location: tarefa.php?id=' . $anexo['tarefa_id']);
