<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nomeAluno"];
    $cpf = $_POST["CPFAluno"];
    $matricula = $_POST["matriculaAluno"];
    $dataDeNascimento = $_POST["dataNascAluno"];
    $msg = "";

    if (!file_exists("alunos.txt")) {
        $file = fopen("alunos.txt", "w") or die("erro ao criar arquivo");
        $linha = "nome;cpf;matricula;data\n";
        fwrite($file, $linha);
        fclose($file);
    }

    $file = fopen("alunos.txt", "a") or die("erro ao criar arquivo");
    $linha =  $nome . ";" . $cpf . ";" . $matricula . ";" . $dataDeNascimento . "\n";
    fwrite($file, $linha);
    fclose($file);
    $msg = "<script> alert('Aluno Cadastrado')</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Aluno</title>
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

        ul{
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 2rem;   
        }
        li{
            list-style: none;
        }
    </style>
</head>

<body>
    <h1>Criar Aluno</h1>
    <form action="criarAluno.php" method="POST">

        <label for="nomeAluno">Nome</label>
        <input id="nomeAluno" type="text" name="nomeAluno" required>

        <label for="CPFAluno">CPF</label>
        <input id="CPFAluno" type="number" name="CPFAluno" required>

        <label for="matriculaAluno">Matrícula</label>
        <input id="matriculaAluno" type="number" name="matriculaAluno" required>

        <label for="dataNascAluno">Data de Nascimento</label>
        <input id="dataNascAluno" type="date" name="dataNascAluno" required>

        <button type="submit">Enviar</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>

    <ul>
        <li>
            <a href="listarAlunos.php" target="_blank"> <button> Lista de Alunos</button></a>
        </li>
        <li>
            <a href="alterarAluno.php" target="_blank"> <button> Alterar Aluno</button></a>
        </li>
    </ul>

</body>

</html>