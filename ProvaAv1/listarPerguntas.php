<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Perguntas</title>
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
    <h1>Lista de Perguntas</h1>

    <table>
        <thead>
            <tr>
                <th>Id Pergunta</th>
                <th>Pergunta</th>
                <th>Resposta A</th>
                <th>Resposta B</th>
                <th>Resposta C</th>
                <th>Resposta D</th>
                <th>Resposta Correta</th>

            </tr>
        </thead>
        <tbody>

            <?php

            $file = fopen("FilePerguntas.txt", "r") or die("erro ao abrir arquivo");

            $header = fgets($file);

            while ($linha = fgets($file)) {
                $dados = explode(";", $linha);

                if (count($dados) == 7) {
                    echo "<tr>";
                    echo "<td>" . $dados[0] . "</td>";
                    echo "<td>" . $dados[1] . "</td>";
                    echo "<td>" . $dados[2] . "</td>";
                    echo "<td>" . $dados[3] . "</td>";
                    echo "<td>" . $dados[4] . "</td>";
                    echo "<td>" . $dados[5] . "</td>";
                    echo "<td>" . $dados[6] . "</td>";
                    echo "</tr>";
                }
            }

            fclose($file);

            ?>
        </tbody>
    </table>

    <ul>
        <li>
            <a href="criarPergunta.php" target="_blank"> <button> Incluir Pergunta</button></a>
        </li>
        <li>
            <a href="alterarPerguntas.php" target="_blank"> <button> Alterar Pergunta</button></a>
        </li>
        <li>
            <a href="excluirPerguntas.php" target="_blank"> <button> Excluir Pergunta</button></a>
        </li>
        <li>
            <a href="exibirPergunta.php" target="_blank"> <button> Exibir Pergunta</button></a>
        </li>
    </ul>

</body>

</html>