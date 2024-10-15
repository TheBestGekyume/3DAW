<?php
$IdPergunta = $msg = "";

// Função para excluir uma pergunta
function excluirPergunta($IdExcluir) {
    if (!file_exists("FilePerguntas.txt")) {
        return "Arquivo de perguntas não encontrado!";
    }

    $file = fopen("FilePerguntas.txt", "r") or die("Erro ao abrir arquivo");
    $fileTemp = fopen("FilePerguntas_temp.txt", "w") or die("Erro ao criar arquivo temporário");

    $perguntaEncontrada = false;

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] !== $IdExcluir) {
                fwrite($fileTemp, $linha);
            } else {
                $perguntaEncontrada = true;
            }
        }
    }

    fclose($file);
    fclose($fileTemp);

    if ($perguntaEncontrada) {
        rename("FilePerguntas_temp.txt", "FilePerguntas.txt");
        return "Pergunta excluída com sucesso!";
    } else {
        unlink("FilePerguntas_temp.txt"); // Remove o arquivo temporário se a pergunta não for encontrada
        return "Pergunta não encontrada!";
    }
}

// Lógica principal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $IdPergunta = $_POST["IdPergunta"];
    $msg = excluirPergunta($IdPergunta);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Excluir Pergunta</title>
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
    <h1>Excluir Pergunta</h1>
    <form action="excluirPerguntas.php" method="POST">

        <label for="IdPergunta">ID da Pergunta</label>
        <input id="IdPergunta" type="number" name="IdPergunta" required>

        <button type="submit">Excluir</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>

    <ul>
        <li>
            <a href="criarPergunta.php" target="_blank"> <button>Criar Pergunta</button></a>
        </li>
        <li>
            <a href="listarPerguntas.php" target="_blank"> <button>Lista de Perguntas</button></a>
        </li>
        <li>
            <a href="alterarPerguntas.php" target="_blank"> <button>Alterar Pergunta</button></a>
        </li>
        <li>
            <a href="exibirPergunta.php" target="_blank"> <button>Exibir Pergunta</button></a>
        </li>
    </ul>

</body>

</html>
