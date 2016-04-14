<?php

class Anexo
{
    private $id;
    private $tarefaId;
    private $nome;
    private $arquivo;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTarefaId($tarefaId)
    {
        $this->tarefaId = $tarefaId;
    }

    public function getTarefaId()
    {
        return $this->tarefaId;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    public function getArquivo()
    {
        return $this->arquivo;
    }
}
