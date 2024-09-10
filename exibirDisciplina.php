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
        <th>ID</th>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Carga Horária</th>
    </tr>
<?php
    // Abre o arquivo para leitura
    $file = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");

    // Ignora a primeira linha (cabeçalho)
    fgets($file);

    // Lê cada linha do arquivo
    while (($linha = fgets($file))) {
        // Remove espaços em branco e separa os dados por vírgula
        $colunaDados = explode(",", trim($linha));

        // Verifica se há 4 colunas (ID, Nome, Sigla, Carga Horária)
        if (count($colunaDados) === 4) {
            echo "<tr><td>" . $colunaDados[0] . "</td>" . // ID
                "<td>" . $colunaDados[1] . "</td>" .     // Nome
                "<td>" . $colunaDados[2] . "</td>" .     // Sigla
                "<td>" . $colunaDados[3] . "</td></tr>"; // Carga Horária
        }
    }

    // Fecha o arquivo
    fclose($file);
?>
</table>

</body>
</html>
