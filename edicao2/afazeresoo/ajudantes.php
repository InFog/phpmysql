<?php

function tem_post()
{
    if (count($_POST) > 0) {
        return true;
    }

    return false;
}

function enviar_email($tarefa)
{
    include "bibliotecas/PHPMailer/PHPMailerAutoload.php";

    $corpo = preparar_corpo_email($tarefa);

    $email = new PHPMailer();

    $email->isSMTP();
    $email->Host = "smtp.gmail.com";
    $email->Port = 587;
    $email->SMTPSecure = 'tls';
    $email->SMTPAuth = true;
    $email->Username = "seuemail@dominio.com";
    $email->Password = "senhasecreta";
    $email->setFrom("seuemail@dominio.com", "Avisador de Tarefas");
    $email->addAddress(EMAIL_NOTIFICACAO);
    $email->Subject = "Aviso de tarefa: {$tarefa->getNome()}";
    $email->msgHTML($corpo);

    foreach ($tarefa->getAnexos() as $anexo) {
        $email->addAttachment("anexos/{$anexo->getArquivo()}");
    }

    $email->send();
}

function preparar_corpo_email($tarefa)
{
    ob_start();
    include "template_email.php";

    $corpo = ob_get_contents();

    ob_end_clean();

    return $corpo;
}

function montar_email() {
    $tem_anexos = '';

    if (count($anexos) > 0) {
        $tem_anexos = "<p><strong>Atenção!</strong> Esta tarefa contém anexos!</p>";
    }

    $corpo = "
        <html>
            <head>
                <meta charset=\"utf-8\" />
                <title>Gerenciador de Tarefas</title>
                <link rel=\"stylesheet\" href=\"tarefas.css\" type=\"text/css\" />
            </head>
            <body>
                <h1>Tarefa: {$tarefa['nome']}</h1>

                <p><strong>Concluída:</strong> " . traduz_concluida($tarefa['concluida']) . "</p>
                <p><strong>Descrição:</strong> " . nl2br($tarefa['descricao']) . "</p>
                <p><strong>Prazo:</strong> " . traduz_data_para_exibir($tarefa['prazo']) . "</p>
                <p><strong>Prioridade:</strong> " . traduz_prioridade($tarefa['prioridade']) . "</p>

                {$tem_anexos}

            </body>
        </html>
    ";
}

function tratar_anexo($anexo) {
    $padrao = '/^.+(\.pdf$|\.zip$)$/';
    $resultado = preg_match($padrao, $anexo['name']);

    if (! $resultado) {
        return false;
    }

    move_uploaded_file($anexo['tmp_name'], "anexos/{$anexo['name']}");

    return true;
}

function validar_data($data)
{
    $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
    $resultado = preg_match($padrao, $data);

    if (! $resultado) {
        return false;
    }

    $dados = explode('/', $data);

    $dia = $dados[0];
    $mes = $dados[1];
    $ano = $dados[2];

    $resultado = checkdate($mes, $dia, $ano);

    return $resultado;
}

function traduz_concluida($concluida)
{
    if ($concluida == 1) {
        return 'Sim';
    }

    return 'Não';
}

function traduz_prioridade($codigo)
{
    $prioridade = '';
    switch ($codigo) {
        case 1:
            $prioridade = 'Baixa';
            break;
        case 2:
            $prioridade = 'Média';
            break;
        case 3:
            $prioridade = 'Alta';
            break;
    }

    return $prioridade;
}

function traduz_data_para_banco($data)
{
    if ($data == "") {
        return "";
    }

    $dados = explode("/", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";

    return $data_mysql;
}

function traduz_data_br_para_objeto($data)
{
    if ($data == "") {
        return "";
    }

    $dados = explode("/", $data);

    if (count($dados) != 3) {
        return $data;
    }

    return  DateTime::createFromFormat('d/m/Y', $data);
}

function traduz_data_para_exibir($data)
{
    if (is_object($data) && get_class($data) == "DateTime") {
        return $data->format("d/m/Y");
    }

    if ($data == "" OR $data == "0000-00-00") {
        return "";
    }

    $dados = explode("-", $data);

    if (count($dados) != 3) {
        return $data;
    }

    $data_exibir = "{$dados[2]}/{$dados[1]}/{$dados[0]}";

    return $data_exibir;
}
