<?php

include "config.php";
include "banco.php";
include "classes/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($mysqli);
$repositorio_tarefas->remover_tarefa($_GET['id']);

header('Location: tarefas.php');
