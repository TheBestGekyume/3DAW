<?php
$cpf = $nome = $matricula = $dataDeNascimento = $msg = "";
$buscarCPF = "";


function buscarAlunoPorCpf($cpfBuscado){

    if (!file_exists("alunos.txt")) return null;

    $file = fopen("alunos.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if (($dados[1]) == $cpfBuscado) {
                fclose($file);

                $dataConvertida = DateTime::createFromFormat('d/m/Y', trim($dados[3]))->format('Y-m-d');

                return [
                    'nome' => $dados[0],
                    'cpf' => $dados[1],
                    'matricula' => $dados[2],
                    'dataDeNascimento' => $dataConvertida// Usar a data convertida
                ];
            }
        }
    }
    fclose($file);
    return null;
}


function alterarAluno($nome, $cpf, $matricula, $dataDeNascimento){

    if (!file_exists("alunos.txt")) {
        return "Arquivo de alunos não encontrado!";
    }

    $file = fopen("alunos.txt", "r");
    $fileNovo = fopen("alunos_temp.txt", "w");
    $dataDeNascimento = date("d/m/Y", strtotime($dataDeNascimento));

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if (($dados[1]) == $cpf) {
                $linha = $nome . ";" . $cpf . ";" . $matricula . ";" . $dataDeNascimento . "\n";
            }
            fwrite($fileNovo, $linha);
        }
    }

    fclose($file);
    fclose($fileNovo);
    rename("alunos_temp.txt", "alunos.txt");

    return "Dados do aluno alterados com sucesso!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['buscar'])) {
        $buscarCPF = $_POST['buscarCPF'];
        $aluno = buscarAlunoPorCpf($buscarCPF);

        if ($aluno) {
            $nome = $aluno['nome'];
            $cpf = $aluno['cpf'];
            $matricula = $aluno['matricula'];
            $dataDeNascimento = $aluno['dataDeNascimento'];
        } else {
            $msg = "CPF não encontrado!";
        }
    } else if (isset($_POST['alterar'])) {
        $cpf = $_POST["CPFAluno"];
        $nome = $_POST["nomeAluno"];
        $matricula = $_POST["matriculaAluno"];
        $dataDeNascimento = $_POST["dataNascAluno"];

        $msg = alterarAluno($nome, $cpf, $matricula, $dataDeNascimento);
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

    <form action="alterarAluno.php" method="POST">
        <label for="buscarCPF">Buscar pelo CPF</label>
        <input id="buscarCPF" type="number" name="buscarCPF" value='<?php echo $buscarCPF ?>' required>
        <button type="submit" name="buscar" value="buscar">Buscar Aluno</button>
    </form>

    <?php if ($cpf): ?>
        <form action="alterarAluno.php" method="POST">
            <label for="nomeAluno">Nome</label>
            <input id="nomeAluno" type="text" name="nomeAluno" value='<?php echo $nome ?>' required>

            <label for="CPFAluno">CPF</label>
            <input id="CPFAluno" type="text" name="CPFAluno" value='<?php echo $cpf ?>' readonly>

            <label for="matriculaAluno">Matrícula</label>
            <input id="matriculaAluno" type="number" name="matriculaAluno" value='<?php echo $matricula ?>' required>

            <label for="dataNascAluno">Data de Nascimento</label>
            <input id="dataNascAluno" type="date" name="dataNascAluno" value='<?php echo $dataDeNascimento ?>' required>

            <button type="submit" name="alterar" value="alterar">Alterar Aluno</button>
        </form>
    <?php endif; ?>

    <p><?php echo $msg ?></p>

    <ul>
        <li>
            <a href="criarAluno.php" target="_blank"> <button>Incluir Aluno</button></a>
        </li>
        <li>
            <a href="listarAlunos.php" target="_blank"> <button>Listar Alunos</button></a>
        </li>
        <li>
            <a href="excluirAluno.php" target="_blank"> <button> Excluir Aluno</button></a>
        </li>
        <li>
            <a href="exibirAluno.php" target="_blank"> <button> Exibir Aluno</button></a>
        </li>
    </ul>
</body>

</html>