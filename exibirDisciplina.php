<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listar Disciplinas</title>
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
    </style>
</head>

<body>

<h1>Listar Disciplinas</h1>
<table>
    <tr>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Carga</th>
    </tr>
<?php
    $file = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");

    fgets($file);

    while (($linha = fgets($file))) {
        $colunaDados = explode(",", trim($linha));

        if (count($colunaDados) === 3) {
            echo "<tr><td>" . $colunaDados[0] . "</td>" .
                "<td>" . $colunaDados[1] . "</td>" .
                "<td>" . $colunaDados[2] . "</td></tr>";
        }
    }

    fclose($file);
?>
</table>

</body>
</html>