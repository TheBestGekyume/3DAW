<?php
// Função para buscar os dados de uma disciplina pelo ID
function buscarDisciplina($id) {
    $file = "disciplinas.txt";
    if (!file_exists($file)) {
        return false;
    }

    $disciplinas = file($file);
    foreach ($disciplinas as $linha) {
        $dados = explode(",", $linha);
        if ((int)$dados[0] === $id) {
            return $dados;
        }
    }
    return false;
}

// Verifica se um ID foi passado via GET
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $dadosDisciplina = buscarDisciplina($id);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Disciplina</title>
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
        <h1>Editar Disciplina</h1>
        <?php if ($dadosDisciplina): ?>
        <form action="atualizarDisciplina.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $dadosDisciplina[0]; ?>">
            <div>
                <h3>Nome:</h3>
                <input type="text" name="nome" value="<?php echo $dadosDisciplina[1]; ?>" required>
            </div>
            <div>
                <h3>Sigla:</h3>
                <input type="text" name="sigla" value="<?php echo $dadosDisciplina[2]; ?>" required>
            </div>
            <div>
                <h3>Carga Horária:</h3>
                <input type="number" name="carga" value="<?php echo $dadosDisciplina[3]; ?>" required>
            </div>
            <button type="submit">Atualizar Disciplina</button>
        </form>
        <?php else: ?>
        <p>Disciplina não encontrada.</p>
        <?php endif; ?>
    </main>
</body>

</html>
