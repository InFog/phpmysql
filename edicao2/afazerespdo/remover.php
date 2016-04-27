<?php

require "config.php";
require "banco.php";
require "classes/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($pdo);
$repositorio_tarefas->remover($_GET['id']);

header('Location: tarefas.php');
