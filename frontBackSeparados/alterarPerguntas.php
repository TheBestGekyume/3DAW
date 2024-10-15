<?php

$IdPergunta = $tituloPergunta = $respostaA = $respostaB = $respostaC = $respostaD = $respostaCorreta = "";

function buscarPerguntaPorId($IdBuscado){

    if (!file_exists("FilePerguntas.txt")) return null;

    $file = fopen("FilePerguntas.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if (($dados[0]) == $IdBuscado) {
                fclose($file);

                return [
                    'IdPergunta' => $dados[0],
                    'TituloPergunta' => $dados[1],
                    'RespostaA' => $dados[2],
                    'RespostaB' => $dados[3],
                    'RespostaC' => $dados[4],
                    'RespostaD' => $dados[5],
                    'RespostaCorreta' => $dados[6]
                ];
            }
        }
    }
    fclose($file);
    return null;
}

function alterarPergunta($IdPergunta, $tituloPergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCorreta){

    if (!file_exists("FilePerguntas.txt")) {
        return "Arquivo de Perguntas não encontrado!";
    }

    $file = fopen("FilePerguntas.txt", "r");
    $fileNovo = fopen("FilePerguntas_temp.txt", "w");

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if (($dados[0]) == $IdPergunta) {
                $linha = $IdPergunta . ";" . $tituloPergunta . ";" . $respostaA . ";" . $respostaB . ";" . $respostaC . ";" . $respostaD . ";" . $respostaCorreta . "\n";
            }
            fwrite($fileNovo, $linha);
        }
    }

    fclose($file);
    fclose($fileNovo);
    rename("FilePerguntas_temp.txt", "FilePerguntas.txt");

    return "Dados da pergunta alterados com sucesso!";
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['buscar'])) {
        $buscarId = $_POST['buscarID'];
        $pergunta = buscarPerguntaPorId($buscarId);

        if ($pergunta) {
            $IdPergunta = $pergunta['IdPergunta'];
            $tituloPergunta = $pergunta['TituloPergunta'];
            $respostaA = $pergunta['RespostaA'];
            $respostaB = $pergunta['RespostaB'];
            $respostaC = $pergunta['RespostaC'];
            $respostaD = $pergunta['RespostaD'];
            $respostaCorreta = $pergunta['RespostaCorreta'];
            $msg = "Pergunta encontrada!";
        } else {
            $msg = "Pergunta não encontrada!";
        }
    } else if (isset($_POST['alterar'])) {
        $IdPergunta = $_POST["IdPergunta"];
        $tituloPergunta = $_POST["tituloPergunta"];
        $respostaA = $_POST["respostaA"];
        $respostaB = $_POST["respostaB"];
        $respostaC = $_POST["respostaC"];
        $respostaD = $_POST["respostaD"];
        $respostaCorreta = $_POST["respostaCorreta"];

        $msg = alterarPergunta($IdPergunta, $tituloPergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCorreta);
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Alterar Pergunta</title>
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
    <h1>Alterar Pergunta</h1>

    <form action="alterarPerguntas.php" method="POST">
        <label for="buscarID">Buscar pelo ID da Pergunta</label>
        <input id="buscarID" type="number" name="buscarID" value='<?php echo $IdPergunta ?>' required>
        <button type="submit" name="buscar" value="buscar">Buscar Pergunta</button>
    </form>

    <?php if ($IdPergunta): ?>
        <form action="alterarPerguntas.php" method="POST">

            <label for="IdPergunta">Id da Pergunta</label>
            <input id="IdPergunta" type="number" name="IdPergunta" value='<?php echo $IdPergunta ?>' readonly>

            <label for="tituloPergunta">Título da Pergunta</label>
            <input id="tituloPergunta" type="text" name="tituloPergunta" value='<?php echo $tituloPergunta ?>' required>

            <label for="respostaA">Resposta A</label>
            <input id="respostaA" type="text" name="respostaA" value='<?php echo $respostaA ?>' required>

            <label for="respostaB">Resposta B</label>
            <input id="respostaB" type="text" name="respostaB" value='<?php echo $respostaB ?>' required>

            <label for="respostaC">Resposta C</label>
            <input id="respostaC" type="text" name="respostaC" value='<?php echo $respostaC ?>' required>

            <label for="respostaD">Resposta D</label>
            <input id="respostaD" type="text" name="respostaD" value='<?php echo $respostaD ?>' required>

            <label for="respostaCorreta">Resposta Correta</label>
            <input id="respostaCorreta" type="text" name="respostaCorreta" value='<?php echo $respostaCorreta ?>' required>

            <button type="submit" name="alterar" value="alterar">Alterar Pergunta</button>
        </form>
    <?php endif; ?>

    <p><?php echo $msg ?></p>

    <ul>
        <li>
            <a href="criarPergunta.php" target="_blank"> <button>Criar Pergunta</button></a>
        </li>
        <li>
            <a href="listarPerguntas.php" target="_blank"> <button>Listar Perguntas</button></a>
        </li>
        <li>
            <a href="excluirPerguntas.php" target="_blank"> <button>Excluir Pergunta</button></a>
        </li>
        <li>
            <a href="exibirPergunta.php" target="_blank"> <button>Exibir Pergunta</button></a>
        </li>
    </ul>
</body>

</html>