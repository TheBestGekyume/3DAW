<?php
$cpf = $nome = $matricula = $dataDeNascimento = $msg = "";
$buscarCPF = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se a solicitação foi para buscar o aluno ou para alterar os dados
    if (isset($_POST['buscar'])) {
        $buscarCPF = trim($_POST['buscarCPF']);

        // Verificar se o arquivo existe
        if (file_exists("alunos.txt")) {
            $arqAlunos = fopen("alunos.txt", "r");

            // Procurar o aluno pelo CPF
            while (!feof($arqAlunos)) {
                $linha = fgets($arqAlunos);
                if ($linha != "") {
                    $colunaDados = explode(";", $linha);
                    if (trim($colunaDados[1]) == $buscarCPF) {
                        $nome = $colunaDados[0];
                        $cpf = $colunaDados[1];
                        $matricula = $colunaDados[2];
                        $dataDeNascimento = trim($colunaDados[3]);
                        break;
                    }
                }
            }
            fclose($arqAlunos);

            // Verificar se encontrou o CPF
            if ($cpf == "") {
                $msg = "CPF não encontrado!";
            }
        } else {
            $msg = "Arquivo de alunos não encontrado!";
        }
    } elseif (isset($_POST['alterar'])) {
        // Ação de alterar o aluno
        $cpf = $_POST["CPFAluno"];
        $nome = $_POST["nomeAluno"];
        $matricula = $_POST["matriculaAluno"];
        $dataDeNascimento = $_POST["dataNascAluno"];
        $msg = "";

        if (file_exists("alunos.txt")) {
            $arqAlunos = fopen("alunos.txt", "r");
            $arqAlunosNovo = fopen("alunos_temp.txt", "w");

            while (!feof($arqAlunos)) {
                $linha = fgets($arqAlunos);
                if ($linha != "") {
                    $colunaDados = explode(";", $linha);

                    // Comparar o CPF após aplicar trim
                    if (trim($colunaDados[1]) == $cpf) {
                        $linha = $nome . ";" . $cpf . ";" . $matricula . ";" . $dataDeNascimento . "\n";
                    }
                    fwrite($arqAlunosNovo, $linha);
                }
            }

            fclose($arqAlunos);
            fclose($arqAlunosNovo);

            // Substituir o arquivo original
            rename("alunos_temp.txt", "alunos.txt");

            $msg = "Dados do aluno alterados com sucesso!";
        } else {
            $msg = "Arquivo de alunos não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Aluno</title>
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
    <h1>Alterar Aluno</h1>

    <!-- Formulário para buscar o aluno -->
    <form action="alterarAluno.php" method="POST">
        <label for="buscarCPF">Buscar pelo CPF</label>
        <input id="buscarCPF" type="number" name="buscarCPF" value='<?php echo $buscarCPF ?>' required>
        <button type="submit" name="buscar">Buscar Aluno</button>
    </form>

    <!-- Mostrar o formulário para alterar dados se o CPF foi encontrado -->
    <?php if ($cpf): ?>
        <form action="alterarAluno.php" method="POST">
            <label for="nomeAluno">Nome</label>
            <input id="nomeAluno" type="text" name="nomeAluno" value='<?php echo $nome ?>' required>

            <label for="CPFAluno">CPF</label>
            <input id="CPFAluno" type="text" name="CPFAluno" value='<?php echo $cpf ?>' readonly required>

            <label for="matriculaAluno">Matrícula</label>
            <input id="matriculaAluno" type="number" name="matriculaAluno" value='<?php echo $matricula ?>' required>

            <label for="dataNascAluno">Data de Nascimento</label>
            <input id="dataNascAluno" type="date" name="dataNascAluno" value='<?php echo $dataDeNascimento ?>' required>

            <button type="submit" name="alterar">Alterar Aluno</button>
        </form>
    <?php endif; ?>

    <p><?php echo $msg ?></p>

    <ul>
        <li><a href="criarAluno.php" target="_blank"> <button>Incluir Aluno</button></a></li>
        <li><a href="listarAlunos.php" target="_blank"> <button>Listar Alunos</button></a></li>
    </ul>
</body>
</html>
