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
    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
    
    fgets($arqDisc);

    while (($linha = fgets($arqDisc)) !== false) {
        $colunaDados = explode(",", trim($linha));

        if (count($colunaDados) === 3) {
            echo "<tr><td>" . htmlspecialchars($colunaDados[0]) . "</td>" .
                "<td>" . htmlspecialchars($colunaDados[1]) . "</td>" .
                "<td>" . htmlspecialchars($colunaDados[2]) . "</td></tr>";
        }
    }

    fclose($arqDisc);
?>
</table>

</body>
</html>
