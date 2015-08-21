<?php

include "config.php";
include "banco.php";

remover_tarefa($conexao, $_GET['id']);

header('Location: tarefas.php');
