<?php

function verificarDados($sigla, $carga)
{
    $padrao = "/^[1-5][A-Z]{3}$/";
    return preg_match($padrao, $sigla) && ($carga == 40 || $carga == 80);
}

function carregarDisciplinas()
{
    $disciplinas = [];
    if (file_exists("disciplinas.txt")) {
        $file = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
        fgets($file); // Pular o cabeçalho
        while (($linha = fgets($file))) {
            list($id, $nome, $sigla, $carga) = explode(",", trim($linha));
            $disciplinas[] = ["id" => $id, "nome" => $nome, "sigla" => $sigla, "carga" => $carga];
        }
        fclose($file);
    }
    return $disciplinas;
}

function carregarDisciplina($id)
{
    $disciplinas = carregarDisciplinas();
    foreach ($disciplinas as $disciplina) {
        if ($disciplina['id'] == $id) {
            return $disciplina;
        }
    }
    return null;
}

function salvarAlteracao($id, $nome, $sigla, $carga)
{
    if (file_exists("disciplinas.txt")) {
        $disciplinas = carregarDisciplinas();
        $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao abrir o arquivo");

        foreach ($disciplinas as $disciplina) {
            if ($disciplina['id'] == $id) {
                // Atualiza a linha com as novas informações
                $linha = $id . "," . $nome . "," . $sigla . "," . $carga . "\n";
            } else {
                // Mantém as informações das outras disciplinas
                $linha = $disciplina['id'] . "," . $disciplina['nome'] . "," . $disciplina['sigla'] . "," . $disciplina['carga'] . "\n";
            }
            fwrite($arqDisc, $linha);
        }
        fclose($arqDisc);
        echo "<script> alert('Disciplina Alterada'); </script>";
    } else {
        echo "<script> alert('Erro: Arquivo não encontrado'); </script>";
    }
}


// Verifica se a requisição é do tipo POST para atualizar a disciplina
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];

    if (verificarDados($sigla, $carga)) {
        salvarAlteracao($id, $nome, $sigla, $carga);
    } else {
        echo "<script> alert('ERROR'); </script>";
    }
}

// Carregar a disciplina selecionada, se houver
$disciplina = null;
if (isset($_GET['id'])) {
    $disciplina = carregarDisciplina($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Alterar Disciplina</title>

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

        select {
            padding: 5px 10px;
            background-color: #9df;
            font-size: 16px;
            border: 1px solid blue;
            border-radius: 6px;
        }
    </style>

</head>

<body>

    <main>
        <h1>Selecionar e Alterar Disciplina</h1>
        
        <!-- Formulário para selecionar a disciplina -->
        <form action="editarDisciplina.php" method="GET">
            <div>
                <h3>Escolha a Disciplina:</h3>
                <select name="id" required onchange="this.form.submit()">
                    <option value="">Selecione uma disciplina</option>
                    <?php
                    $disciplinas = carregarDisciplinas();
                    foreach ($disciplinas as $disciplina) {
                        $selected = (isset($disciplina) && $disciplina['id'] == $_GET['id']) ? 'selected' : '';
                        echo "<option value=\"{$disciplina['id']}\" $selected>{$disciplina['id']} - {$disciplina['nome']} ({$disciplina['sigla']})</option>";
                    }
                    ?>
                </select>
            </div>
        </form>

        <?php if ($disciplina): ?>
        <!-- Formulário de edição da disciplina -->
        <form action="editarDisciplina.php" method="POST">
            <div>
                <h3>Nome:</h3>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($disciplina['nome']); ?>" required>
            </div>

            <div>
                <h3>Sigla:</h3>
                <input type="text" name="sigla" value="<?php echo htmlspecialchars($disciplina['sigla']); ?>" required>
            </div>

            <div>
                <h3>Carga Horária:</h3>
                <input type="number" name="carga" value="<?php echo htmlspecialchars($disciplina['carga']); ?>" required>
            </div>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($disciplina['id']); ?>">

            <button type="submit">Alterar Disciplina</button>
        </form>
        <?php endif; ?>

    </main>

</body>

</html>
