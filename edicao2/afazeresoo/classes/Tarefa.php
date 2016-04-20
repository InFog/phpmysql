<?php

class Tarefa
{
    private $id;
    private $nome;
    private $descricao;
    private $prazo;
    private $prioridade;
    private $concluida;

    /**
     * @var Array de Anexo
     */
    private $anexos;

    public function __construct()
    {
        $this->anexos = [];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setPrazo($prazo)
    {
        $this->prazo = $prazo;
    }

    public function getPrazo()
    {
        return $this->prazo;
    }

    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;
    }

    public function getPrioridade()
    {
        return $this->prioridade;
    }

    public function setConcluida($concluida)
    {
        $this->concluida = $concluida;
    }

    public function getConcluida()
    {
        return $this->concluida;
    }

    public function setAnexos(array $anexos)
    {
        foreach ($anexos as $anexo) {
            $this->adicionarAnexo($anexo);
        }
    }

    public function adicionarAnexo(Anexo $anexo)
    {
        array_push($this->anexos, $anexo);
    }

    public function getAnexos()
    {
        return $this->anexos;
    }
}
