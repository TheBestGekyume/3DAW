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

                // Ignora a primeira linha que contém os cabeçalhos
                $header = fgets($file);

                // Lê o restante do arquivo
                while ($linha = fgets($file)) {
                    $dados = explode(";", $linha);

                    // Verifica se o array tem o número correto de colunas
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
</body>

</html>
