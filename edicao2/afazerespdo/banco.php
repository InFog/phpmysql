<?php

try {
    $pdo = new PDO(BD_DSN, BD_USUARIO, BD_SENHA);
} catch (PDOException $e) {
    echo "Falha na conexão com o banco de dados: "
        . $e->getMessage();
    die();
}
