<?php

function verificarDados($sigla, $carga) {
    $padrao = "/^[1-5][A-Z]{3}$/";
    if (preg_match($padrao, $sigla) && ($carga == 40 || $carga == 80)) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = isset($_POST["acao"]) ? $_POST["acao"] : '';

    if ($acao === 'editar') {
        $id = isset($_POST["id"]) ? $_POST["id"] : '';
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : '';
        $sigla = isset($_POST["sigla"]) ? $_POST["sigla"] : '';
        $carga = isset($_POST["carga"]) ? $_POST["carga"] : '';

        if (verificarDados($sigla, $carga)) {
            $disciplinas = file("disciplinas.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $arquivo = fopen("disciplinas.txt", "w") or die("Erro ao abrir o arquivo");

            foreach ($disciplinas as $linha) {
                $colunaDados = explode(",", trim($linha));
                if (count($colunaDados) === 3 && $colunaDados[1] === $id) {
                    fwrite($arquivo, $nome . "," . $sigla . "," . $carga . "\n");
                } else {
                    fwrite($arquivo, $linha . "\n");
                }
            }
            fclose($arquivo);
            echo "<script> alert('Disciplina Editada'); </script>";
        } else {
            echo "<script> alert('ERROR'); </script>";
        }
    } elseif ($acao === 'cadastrar') {
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : '';
        $sigla = isset($_POST["sigla"]) ? $_POST["sigla"] : '';
        $carga = isset($_POST["carga"]) ? $_POST["carga"] : '';

        if (verificarDados($sigla, $carga)) {
            if (!file_exists("disciplinas.txt")) {
                $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao criar o arquivo");
                $linha = "Nome,Sigla,Carga\n";
                fwrite($arqDisc, $linha);
                fclose($arqDisc);
            }

            $arqDisc = fopen("disciplinas.txt", "a") or die("Erro ao abrir o arquivo");
            $linha = "\n" . $nome . "," . $sigla . "," . $carga;
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
            echo "<script> alert('Disciplina Cadastrada'); </script>";
        } else {
            echo "<script> alert('ERROR'); </script>";
        }
    } elseif ($acao === 'excluir') {
        $id = isset($_POST["id"]) ? $_POST["id"] : '';

        $disciplinas = file("disciplinas.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $arquivo = fopen("disciplinas.txt", "w") or die("Erro ao abrir o arquivo");

        foreach ($disciplinas as $linha) {
            $colunaDados = explode(",", trim($linha));
            if (count($colunaDados) === 3 && $colunaDados[1] !== $id) {
                fwrite($arquivo, $linha . "\n");
            }
        }
        fclose($arquivo);
        echo "<script> alert('Disciplina Excluída'); </script>";
    }
}

function listarDisciplinas() {
    $disciplinas = [];
    if (file_exists("disciplinas.txt")) {
        $file = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
        fgets($file);

        while (($linha = fgets($file))) {
            $colunaDados = explode(",", trim($linha));
            if (count($colunaDados) === 3) {
                $disciplinas[] = $colunaDados;
            }
        }
        fclose($file);
    }
    return $disciplinas;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Disciplinas</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
        }
    </style>
</head>

<body>

    <main>
        <h1>Gerenciar Disciplinas</h1>

        <form action="" method="POST">
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
            <input type="hidden" name="acao" value="cadastrar">
        </form>

        <h2>Listar Disciplinas</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Carga</th>
                <th>Ações</th>
            </tr>
            <?php
                $disciplinas = listarDisciplinas();

                foreach ($disciplinas as $disciplina) {
                    echo "<tr><td>" . htmlspecialchars($disciplina[0]) . "</td>" .
                        "<td>" . htmlspecialchars($disciplina[1]) . "</td>" .
                        "<td>" . htmlspecialchars($disciplina[2]) . "</td>" .
                        "<td>" .
                        "<form action='' method='POST' style='display:inline;'>" .
                        "<input type='hidden' name='acao' value='editar'>" .
                        "<input type='hidden' name='id' value='" . htmlspecialchars($disciplina[1]) . "'>" .
                        "<button type='submit'>Editar</button>" .
                        "</form>" .
                        "<form action='' method='POST' style='display:inline;'>" .
                        "<input type='hidden' name='acao' value='excluir'>" .
                        "<input type='hidden' name='id' value='" . htmlspecialchars($disciplina[1]) . "'>" .
                        "<button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</button>" .
                        "</form>" .
                        "</td></tr>";
                }
            ?>
        </table>

        <h2>Editar Disciplina</h2>
        <?php
            if (isset($_POST["acao"]) && $_POST["acao"] === 'editar') {
                $id = isset($_POST["id"]) ? $_POST["id"] : '';
                $disciplinas = listarDisciplinas();
                $disciplinaParaEditar = null;

                foreach ($disciplinas as $disciplina) {
                    if ($disciplina[1] === $id) {
                        $disciplinaParaEditar = $disciplina;
                        break;
                    }
                }

                if ($disciplinaParaEditar) {
                    echo "<form action='' method='POST'>" .
                        "<input type='hidden' name='acao' value='editar'>" .
                        "<input type='hidden' name='id' value='" . htmlspecialchars($id) . "'>" .
                        "<div>" .
                        "<h3>Nome:</h3>" .
                        "<input type='text' name='nome' value='" . htmlspecialchars($disciplinaParaEditar[0]) . "' required>" .
                        "</div>" .
                        "<div>" .
                        "<h3>Sigla:</h3>" .
                        "<input type='text' name='sigla' value='" . htmlspecialchars($disciplinaParaEditar[1]) . "' required>" .
                        "</div>" .
                        "<div>" .
                        "<h3>Carga Horaria:</h3>" .
                        "<input type='number' name='carga' value='" . htmlspecialchars($disciplinaParaEditar[2]) . "' required>" .
                        "</div>" .
                        "<button type='submit'>Salvar Alterações</button>" .
                        "</form>";
                }
            }
        ?>

    </main>

</body>

</html>
