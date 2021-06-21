<?php

$repositorio_tarefas->remover($_GET['id']);

header('Location: index.php?rota=tarefas');
