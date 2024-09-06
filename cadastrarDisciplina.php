<?php

function verificarDados($sigla, $carga){

    $padrao = "/^[1-5][A-Z]{3}$/";

    if (preg_match($padrao, $sigla) && ($carga == 40 || $carga == 80)) return true;

    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];

    if (verificarDados($sigla, $carga)) {

        if (!file_exists("disciplinas.txt")) {
            $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao criar o arquivo");
            $linha = "Nome,Sigla,Carga\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
        }

        $arqDisc = fopen("disciplinas.txt", "a") or die("Erro ao abrir o arquivo");
        $linha = $nome . "," . $sigla . "," . $carga . "\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
        echo "<script> alert('Disciplina Cadastrada'); </script>";
    } else {
        echo "<script> alert('ERROR'); </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Nova Disciplina</title>

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
            padding: 5px 10px;
            background-color: #9df;
            font-size: 16px;
            border: 1px solid blue;
            border-radius: 6px;
        }

        button {
            background-color: #34d;
            cursor: pointer;
        }

        button:hover {
            background-color: #54d;
        }
    </style>

</head>

<body>

    <main>
        <h1>Criar Nova Disciplina</h1>
        <form action="cadastrarDisciplina.php" method="POST">
            <div>
                <h3>Nome:</h3>
                <input type="text" name="nome" required>
            </div>

            <div>
                <h3>Sigla:</h3>
                <input type="text" name="sigla" required>
            </div>

            <div>
                <h3>Carga Horaria:</h3>
                <input type="number" name="carga" required>
            </div>

            <button type="submit">Criar Nova Disciplina</button>
        </form>
    </main>

</body>

</html>