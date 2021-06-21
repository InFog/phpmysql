<?php

use Tarefas\Models\RepositorioTarefas;

spl_autoload_register(function ($classe) {
    $partes = explode('\\', $classe);

    if (count($partes) == 1) {
        if (is_file(__DIR__ . "/models/{$classe}.php")) {
            require_once __DIR__ . "/models/{$classe}.php";
            return;
        }
    }

    if ($partes[0] !== 'Tarefas') {
        return;
    }

    array_shift($partes);
    $classe = array_pop($partes);
    $caminho = [];

    foreach ($partes as $pasta) {
        $caminho[] = strtolower($pasta);
    }
    $caminho[] = $classe . '.php';

    $arquivo = __DIR__ . '/' . implode('/', $caminho);

    if (is_file($arquivo)) {
        require_once $arquivo;
    }
});

require "vendor/autoload.php";
require "config.php";
require "helpers/banco.php";
require "helpers/ajudantes.php";

$repositorio_tarefas = new RepositorioTarefas($pdo);

$rota = "tarefas";

if (array_key_exists("rota", $_GET)) {
    $rota = (string) $_GET["rota"];
}

if (is_file("controllers/{$rota}.php")) {
    require "controllers/{$rota}.php";
} else {
    require "controllers/404.php";
}
