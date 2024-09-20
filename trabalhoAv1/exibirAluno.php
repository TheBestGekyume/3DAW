<?php

$cpf = "";
$aluno = null;
$msg = "";

function buscarAlunoPorCpf($cpfBuscado) {
    if (!file_exists("alunos.txt")) return null;

    $file = fopen("alunos.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[1] === $cpfBuscado) {
                fclose($file);

                return [
                    'nome' => $dados[0],
                    'cpf' => $dados[1],
                    'matricula' => $dados[2],
                    'dataDeNascimento' => $dados[3]
                ];
            }
        }
    }
    fclose($file);
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST["CPFAluno"];
    $aluno = buscarAlunoPorCpf($cpf);

    if (!$aluno) {
        $msg = "Aluno não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exibir Aluno</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        main {
            padding-inline-start: 15px;
        }
        button, input {
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
        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <h1>Exibir Aluno</h1>
    <form action="exibirAluno.php" method="POST">
        <label for="CPFAluno">CPF</label>
        <input id="CPFAluno" type="text" name="CPFAluno" required>
        <button type="submit">Buscar Aluno</button>
    </form>

    <?php if ($msg): ?>
        <p><?php echo $msg; ?></p>
    <?php elseif ($aluno): ?>
        <table>
            <tr>
                <th>Nome</th>
                <td><?php echo $aluno['nome']; ?></td>
            </tr>
            <tr>
                <th>CPF</th>
                <td><?php echo $aluno['cpf']; ?></td>
            </tr>
            <tr>
                <th>Matrícula</th>
                <td><?php echo $aluno['matricula']; ?></td>
            </tr>
            <tr>
                <th>Data de Nascimento</th>
                <td><?php echo $aluno['dataDeNascimento']; ?></td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>
