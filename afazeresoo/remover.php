<?php

include "config.php";
include "banco.php";

remover_tarefa($mysqli, $_GET['id']);

header('Location: tarefas.php');
