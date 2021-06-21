<?php

class Tarefa
{
    private $id = 0;
    private $nome = '';
    private $descricao = '';
    private $prazo = null;
    private $prioridade = 1;
    private $concluida = false;

    /**
     * @var Array de Anexo
     */
    private $anexos;

    public function __construct()
    {
        $this->anexos = [];
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setPrazo(?DateTime $prazo)
    {
        $this->prazo = $prazo;
    }

    public function getPrazo(): ?DateTime
    {
        if (is_string($this->prazo) && ! empty($this->prazo)) {
            $this->prazo = DateTime::createFromFormat("Y-m-d", $this->prazo);
        } elseif ($this->prazo == "") {
            $this->prazo = null;
        }

        return $this->prazo;
    }

    public function setPrioridade(int $prioridade)
    {
        $this->prioridade = $prioridade;
    }

    public function getPrioridade(): int
    {
        return $this->prioridade;
    }

    public function setConcluida(bool $concluida)
    {
        $this->concluida = $concluida;
    }

    public function getConcluida(): bool
    {
        return $this->concluida;
    }

    public function setAnexos(array $anexos)
    {
        $this->anexos = [];

        foreach ($anexos as $anexo) {
            $this->adicionarAnexo($anexo);
        }
    }

    public function adicionarAnexo(Anexo $anexo)
    {
        array_push($this->anexos, $anexo);
    }

    public function getAnexos(): array
    {
        return $this->anexos;
    }
}
