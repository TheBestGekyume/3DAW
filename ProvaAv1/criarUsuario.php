<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nomeUsuario"];
    $email = $_POST["emailUsuario"];
    $cpf = $_POST["CPFUsuario"];
    $dataDeNascimento = $_POST["dataNascUsuario"];
    $msg = "";

    if (strlen($cpf) != 11) {
        $msg = "O CPF deve conter exatamente 11 dígitos!";
    } else {
        $dataDeNascimento = date("d/m/Y", strtotime($dataDeNascimento));

        if (!file_exists("usuarios.txt")) {
            $file = fopen("usuarios.txt", "w") or die("Erro ao criar arquivo");
            $linha = "nome;email;cpf;data\n";
            fwrite($file, $linha);
            fclose($file);
        }

        $file = fopen("usuarios.txt", "a") or die("Erro ao abrir arquivo");
        $linha = $nome . ";" . $email . ";" . $cpf . ";" . $dataDeNascimento . "\n";
        fwrite($file, $linha);
        fclose($file);
        $msg = "Usuário cadastrado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Usuário</title>
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
    <h1>Criar Usuário</h1>
    <form action="criarUsuario.php" method="POST">

        <label for="nomeUsuario">Nome</label>
        <input id="nomeUsuario" type="text" name="nomeUsuario" required>

        <label for="emailUsuario">E-mail</label>
        <input id="emailUsuario" type="email" name="emailUsuario" required>

        <label for="CPFUsuario">CPF</label>
        <input id="CPFUsuario" type="number" name="CPFUsuario" required>

        <label for="dataNascUsuario">Data de Nascimento</label>
        <input id="dataNascUsuario" type="date" name="dataNascUsuario" required>

        <button type="submit">Enviar</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>


</body>

</html>
