<?php

$anexo = $repositorio_tarefas->buscar_anexo($_GET['id']);
$repositorio_tarefas->remover_anexo($anexo->getId());
unlink(__DIR__ . '/../anexos/' . $anexo->getArquivo());

header('Location: /index.php?rota=tarefa&id=' . $anexo->getTarefaId());
