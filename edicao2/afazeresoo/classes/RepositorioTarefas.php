<?php

class RepositorioTarefas
{
    private $bd;

    public function __construct($bd)
    {
        $this->bd = $bd;
    }

    public function gravar_tarefa(Tarefa $tarefa)
    {
        $nome = $tarefa->getNome();
        $descricao = $tarefa->getDescricao();
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo()->format('Y-m-d');
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        $sqlGravar = "
            INSERT INTO tarefas
            (nome, descricao, prioridade, prazo, concluida)
            VALUES
            (
                '{$nome}',
                '{$descricao}',
                {$prioridade},
                '{$prazo}',
                {$concluida}
            )
        ";

        $this->bd->query($sqlGravar);
    }

    public function editar_tarefa(Tarefa $tarefa)
    {
        $id = $tarefa->getId();
        $nome = $tarefa->getNome();
        $descricao = $tarefa->getDescricao();
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo()->format('Y-m-d');
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        $sqlEditar = "
            UPDATE tarefas SET
                nome = '{$nome}',
                descricao = '{$descricao}',
                prioridade = {$prioridade},
                prazo = '{$prazo}',
                concluida = {$concluida}
            WHERE id = {$id}
        ";

        $this->bd->query($sqlEditar);
    }

    public function buscar_tarefas()
    {
        $sqlBusca = 'SELECT * FROM tarefas';
        $resultado = $this->bd->query($sqlBusca);

        $tarefas = [];

        while ($tarefa = $resultado->fetch_object('Tarefa')) {
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    function buscar_tarefa($id)
    {
        $sqlBusca = 'SELECT * FROM tarefas WHERE id = ' . $id;
        $resultado = $this->bd->query($sqlBusca);

        return mysqli_fetch_assoc($resultado);
    }
}
