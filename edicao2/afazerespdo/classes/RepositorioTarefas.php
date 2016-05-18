<?php

class RepositorioTarefas
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function salvar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();
        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $sqlGravar = "
            INSERT INTO tarefas
            (nome, descricao, prioridade, prazo, concluida)
            VALUES
            (:nome, :descricao, :prioridade, :prazo, :concluida)
        ";
        $query = $this->pdo->prepare($sqlGravar);
        $query->execute([
            'nome' => strip_tags($tarefa->getNome()),
            'descricao' => strip_tags($tarefa->getDescricao()),
            'prioridade' => $tarefa->getPrioridade(),
            'prazo' => $prazo,
            'concluida' => ($tarefa->getConcluida()) ? 1 : 0,
        ]);
    }

    public function atualizar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $sqlEditar = "
            UPDATE tarefas SET
                nome = :nome,
                descricao = :descricao,
                prioridade = :prioridade,
                prazo = :prazo,
                concluida = :concluida
            WHERE id = :id
        ";

        $query = $this->pdo->prepare($sqlEditar);

        $query->execute([
            'nome' => strip_tags($tarefa->getNome()),
            'descricao' => strip_tags($tarefa->getDescricao()),
            'prioridade' => $tarefa->getPrioridade(),
            'prazo' => $prazo,
            'concluida' => ($tarefa->getConcluida()) ? 1 : 0,
            'id' => $tarefa->getId(),
        ]);
    }

    public function buscar($tarefa_id = 0)
    {
        if ($tarefa_id > 0) {
            return $this->buscar_tarefa($tarefa_id);
        } else {
            return $this->buscar_tarefas();
        }
    }

    private function buscar_tarefas()
    {
        $sqlBusca = 'SELECT * FROM tarefas';
        $resultado = $this->pdo->query(
            $sqlBusca,
            PDO::FETCH_CLASS,
            'Tarefa'
        );

        $tarefas = [];

        foreach ($resultado as $tarefa) {
            $tarefa->setAnexos($this->buscar_anexos($tarefa->getId()));
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    private function buscar_tarefa($id)
    {
        $sqlBusca = "SELECT * FROM tarefas WHERE id = :id";
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute([
            'id' => $id,
        ]);

        $tarefa = $query->fetchObject('Tarefa');
        $tarefa->setAnexos($this->buscar_anexos($tarefa->getId()));

        return $tarefa;
    }

    public function salvar_anexo(Anexo $anexo)
    {
        $sqlGravar = "INSERT INTO anexos
            (tarefa_id, nome, arquivo)
            VALUES
            (:tarefa_id, :nome, :arquivo)
            ";
        $query = $this->pdo->prepare($sqlGravar);
        $query->execute([
            'tarefa_id' => $anexo->getTarefaId(),
            'nome' => $anexo->getNome(),
            'arquivo' => $anexo->getArquivo(),
        ]);
    }

    public function buscar_anexos($tarefa_id)
    {
        $sqlBusca = "SELECT * FROM anexos WHERE tarefa_id = :tarefa_id";
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute([
            "tarefa_id" => $tarefa_id,
        ]);

        $anexos = array();

        while ($anexo = $query->fetchObject('Anexo')) {
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    public function buscar_anexo($anexo_id)
    {
        $sqlBusca = "SELECT * FROM anexos WHERE id = :id";
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute([
            'id' => $anexo_id,
        ]);

        return $query->fetchObject('Anexo');
    }

    public function remover($id)
    {
        $sqlRemover = "DELETE FROM tarefas WHERE id = :id";

        $query = $this->pdo->prepare($sqlRemover);

        $query->execute([
            'id' => $id,
        ]);
    }

    public function remover_anexo($id)
    {
        $sqlRemover = "DELETE FROM anexos WHERE id = :id";
        $query = $this->pdo->prepare($sqlRemover);
        $query->execute([
            'id' => $id,
        ]);
    }
}
