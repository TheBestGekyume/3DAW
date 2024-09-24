<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $IdPergunta = $_POST["IdPergunta"];
    $tituloPergunta = $_POST["tituloPergunta"];
    $respostaA = $_POST["respostaA"];
    $respostaB = $_POST["respostaB"];
    $respostaC = $_POST["respostaC"];
    $respostaD = $_POST["respostaD"];
    $respostaCorreta = $_POST["respostaCorreta"];
    $msg = "";


    if (!file_exists("FilePerguntas.txt")) {
        $file = fopen("FilePerguntas.txt", "w") or die("Erro ao criar arquivo");
        $linha = "IdPergunta;tituloPergunta;respostaA;respostaB;respostaC;respostaD;respostaCorreta\n";
        fwrite($file, $linha);
        fclose($file);
    }

    $file = fopen("FilePerguntas.txt", "a") or die("Erro ao abrir arquivo");
    $linha = $IdPergunta . ";" . $tituloPergunta . ";" . $respostaA . ";" . $respostaB . ";" . $respostaC . ";" . $respostaD . ";". $respostaCorreta . "\n";
    fwrite($file, $linha);
    fclose($file);
    $msg = "Pergunta cadastrada com sucesso!";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Perguntas</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        main {
            padding-inline-start: 15px;
        }

        div:last-of-type {
            margin-bottom: 20px;
        }

        button,
        input {
            max-width: fit-content;
            padding: 5px 10px;
            background-color: #9df;
            font-size: 16px;
            border: 1px solid blue;
            border-radius: 6px;
            margin-block: 5px 25px;
        }

        button {
            padding: 8px 25px;
            background-color: #34d;
            color: #fff;
            cursor: pointer;
            transition: 300ms;
        }

        button:hover {
            background-color: #54d;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        ul {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 2rem;
        }

        li {
            list-style: none;
        }
    </style>
</head>

<body>
    <h1>Criar Pergunta</h1>
    <form action="criarPergunta.php" method="POST">

        <label for="IdPergunta">Id da Pergunta</label>
        <input id="IdPergunta" type="number" name="IdPergunta" required>

        <label for="tituloPergunta">Titulo da Pergunta</label>
        <input id="tituloPergunta" type="text" name="tituloPergunta" required>

        <label for="respostaA">Resposta A</label>
        <input id="respostaA" type="text" name="respostaA" required>

        <label for="respostaB">Resposta B</label>
        <input id="respostaB" type="text" name="respostaB" required>

        <label for="respostaC">Resposta C</label>
        <input id="respostaC" type="text" name="respostaC" required>

        <label for="respostaD">Resposta D</label>
        <input id="respostaD" type="text" name="respostaD" required>

        <label for="respostaCorreta">Resposta da Pergunta</label>
        <input id="respostaCorreta" type="text" name="respostaCorreta" required>

        <button type="submit">Enviar</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>

    <ul>
        <li>
            <a href="listarPerguntas.php" target="_blank"> <button> Lista de Perguntas</button></a>
        </li>
        <li>
            <a href="alterarPerguntas.php" target="_blank"> <button> Alterar Perguntas</button></a>
        </li>
        <li>
            <a href="excluirPerguntas.php" target="_blank"> <button> Excluir Perguntas</button></a>
        </li>
        <li>
            <a href="exibirPergunta.php" target="_blank"> <button> Exibir Pergunta por Id</button></a>
        </li>
    </ul>

</body>

</html>