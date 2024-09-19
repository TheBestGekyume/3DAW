<?php
$cpf = $msg = "";

// Função para excluir um aluno
function excluirAluno($cpfExcluir) {
    if (!file_exists("alunos.txt")) {
        return "Arquivo de alunos não encontrado!";
    }

    $file = fopen("alunos.txt", "r") or die("Erro ao abrir arquivo");
    $fileTemp = fopen("alunos_temp.txt", "w") or die("Erro ao criar arquivo temporário");

    $alunoEncontrado = false;

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[1] !== $cpfExcluir) {
                fwrite($fileTemp, $linha);
            }else{
                $alunoEncontrado = true;
            }
            
        }
    }

    fclose($file);
    fclose($fileTemp);

    if ($alunoEncontrado) {
        rename("alunos_temp.txt", "alunos.txt");
        return "Aluno excluído com sucesso!";
    } else {
        unlink("alunos_temp.txt"); // Remove o arquivo temporário se o aluno não for encontrado
        return "Aluno não encontrado!";
    }
}

// Lógica principal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST["CPFAluno"];
    $msg = excluirAluno($cpf);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Excluir Aluno</title>
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
    <h1>Excluir Aluno</h1>
    <form action="excluirAluno.php" method="POST">

        <label for="CPFAluno">CPF</label>
        <input id="CPFAluno" type="number" name="CPFAluno" required>

        <button type="submit">Excluir</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $msg ?>

    <ul>
        <li>
            <a href="criarAluno.php" target="_blank"> <button> Criar Aluno</button></a>
        </li>
        <li>
            <a href="listarAlunos.php" target="_blank"> <button> Lista de Alunos</button></a>
        </li>
        <li>
            <a href="alterarAluno.php" target="_blank"> <button> Alterar Aluno</button></a>
        </li>
        <li>
            <a href="exibirAluno.php" target="_blank"> <button> Exibir Aluno</button></a>
        </li>
    </ul>

</body>

</html>
