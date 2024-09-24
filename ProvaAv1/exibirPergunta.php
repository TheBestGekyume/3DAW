<?php

$idPergunta = "";
$pergunta = null;
$msg = "";

function buscarPerguntaPorId($idBuscado){
    if (!file_exists("FilePerguntas.txt")) return null;

    $file = fopen("FilePerguntas.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] === $idBuscado) {
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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["IdPergunta"];
    $pergunta = buscarPerguntaPorId($idPergunta);

    if (!$pergunta) {
        $msg = "Pergunta não encontrada!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Exibir Pergunta</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        main {
            padding-inline-start: 15px;
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
    <h1>Exibir Pergunta</h1>
    <form action="exibirPergunta.php" method="POST">
        <label for="IdPergunta">ID da Pergunta</label>
        <input id="IdPergunta" type="text" name="IdPergunta" required>
        <button type="submit">Buscar Pergunta</button>
    </form>

    <?php if ($msg): ?>
        <p><?php echo $msg; ?></p>
    <?php elseif ($pergunta): ?>
        <table>
        <tr>
            <th>ID da Pergunta</th>
            <td><?php echo $pergunta['IdPergunta']; ?></td>
        </tr>
        <tr>
            <th>Título da Pergunta</th>
            <td><?php echo $pergunta['TituloPergunta']; ?></td>
        </tr>
        <tr>
            <th>Resposta A</th>
            <td><?php echo $pergunta['RespostaA']; ?></td>
        </tr>
        <tr>
            <th>Resposta B</th>
            <td><?php echo $pergunta['RespostaB']; ?></td>
        </tr>
        <tr>
            <th>Resposta C</th>
            <td><?php echo $pergunta['RespostaC']; ?></td>
        </tr>
        <tr>
            <th>Resposta D</th>
            <td><?php echo $pergunta['RespostaD']; ?></td>
        </tr>
        <tr>
            <th>Resposta Correta</th>
            <td><?php echo $pergunta['RespostaCorreta']; ?></td>
        </tr>
    </table>
    <?php endif; ?>

    


    <ul>
        <li>
            <a href="criarPergunta.php" target="_blank"> <button> Criar Perguntas</button></a>
        </li>
        <li>
            <a href="listarPerguntas.php" target="_blank"> <button> Lista de Perguntas</button></a>
        </li>
        <li>
            <a href="alterarPerguntas.php" target="_blank"> <button> Alterar Perguntas</button></a>
        </li>
        <li>
            <a href="excluirPerguntas.php" target="_blank"> <button> Excluir Perguntas</button></a>
        </li>
    </ul>

</body>

</html>