<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST["loginUsuario"];
    $senha = $_POST["senhaUsuario"];
    $msg = "";

    if (strlen($login) < 5) {
        $msg = "O login deve ter pelo menos 5 caracteres!";
    } elseif (strlen($senha) < 8) {
        $msg = "A senha deve ter pelo menos 8 caracteres!";
    } else {
        if (!file_exists("usuarios.txt")) {
            $file = fopen("usuarios.txt", "w") or die("Erro ao criar arquivo");
            $linha = "login;senha\n";
            fwrite($file, $linha);
            fclose($file);
        }

        $file = fopen("usuarios.txt", "a") or die("Erro ao abrir arquivo");
        $linha = $login . ";" . $senha . "\n";
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

        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <h1>Criar Usuário</h1>
    <form action="criarUsuario.php" method="POST">

        <label for="loginUsuario">Login</label>
        <input id="loginUsuario" type="text" name="loginUsuario" required>

        <label for="senhaUsuario">Senha</label>
        <input id="senhaUsuario" type="password" name="senhaUsuario" required>

        <button type="submit">Enviar</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>
</body>

</html>
