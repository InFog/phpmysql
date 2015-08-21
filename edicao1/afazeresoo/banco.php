<?php

$mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

if ($mysqli->connect_errno) {
    echo "Problemas para conectar no banco. Verifique os dados!";
    die();
}

function gravar_anexo($mysqli, $anexo)
{
    $sqlGravar = "INSERT INTO anexos
        (tarefa_id, nome, arquivo)
        VALUES
        (
            {$anexo['tarefa_id']},
            '{$anexo['nome']}',
            '{$anexo['arquivo']}'
        )
    ";

    $mysqli->query($sqlGravar);
}

function buscar_anexos($mysqli, $tarefa_id)
{
    $sqlBusca = "SELECT * FROM anexos WHERE tarefa_id = {$tarefa_id}";
    $resultado = $mysqli->query($sqlBusca);

    $anexos = array();

    if ($resultado) {
        while ($anexo = mysqli_fetch_assoc($resultado)) {
            $anexos[] = $anexo;
        }
    }

    return $anexos;
}

function remover_tarefa($mysqli, $id)
{
    $sqlRemover = "DELETE FROM tarefas WHERE id = {$id}";

    $mysqli->query($sqlRemover);
}
