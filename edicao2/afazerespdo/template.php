<html>
    <head>
        <meta charset="utf-8" />
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" href="tarefas.css" type="text/css" />
    </head>
    <body>
        <div id="bloco_principal">
            <h1>Gerenciador de Tarefas</h1>

            <?php include('formulario.php'); ?>

            <?php if ($exibir_tabela) : ?>
                <?php include('tabela.php'); ?>
            <?php endif; ?>
        </div>
    </body>
</html>
