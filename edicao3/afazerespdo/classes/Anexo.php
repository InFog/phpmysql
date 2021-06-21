<?php

class Anexo
{
    private $id;
    private $tarefa_id;
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

    public function setTarefaId($tarefa_id)
    {
        $this->tarefa_id = $tarefa_id;
    }

    public function getTarefaId()
    {
        return $this->tarefa_id;
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
