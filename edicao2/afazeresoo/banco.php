<?php

$mysqli = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

if ($mysqli->connect_errno) {
    echo "Problemas para conectar no banco. Verifique os dados!";
    echo mysqli_connect_error();
    die();
}
