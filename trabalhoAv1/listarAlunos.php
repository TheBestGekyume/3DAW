<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
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
            background-color: #111;
        }

        tr:nth-child(even) {
            background-color: #444;
        }

        tr:hover {
            background-color: #336;
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
    <h1>Lista de Alunos</h1>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Matrícula</th>
                <th>Data de Nascimento</th>
            </tr>
        </thead>
        <tbody>

            <?php
            
            $file = fopen("alunos.txt","r") or die("erro ao abrir arquivo");

                $header = fgets($file);

                while ($linha = fgets($file)) {
                    $dados = explode(";", $linha);

                    if (count($dados) == 4) {
                        echo "<tr>";
                        echo "<td>" . $dados[0] . "</td>";
                        echo "<td>" . $dados[1] . "</td>";
                        echo "<td>" . $dados[2] . "</td>";
                        echo "<td>" . $dados[3] . "</td>";
                        echo "</tr>";
                    }
                }

                fclose($file);
            
            ?>
        </tbody>
    </table>

    <ul>
        <li>
            <a href="criarAluno.php" target="_blank"> <button> Incluir Aluno</button></a>
        </li>
        <li>
            <a href="alterarAluno.php" target="_blank"> <button> Alterar Aluno</button></a>
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
