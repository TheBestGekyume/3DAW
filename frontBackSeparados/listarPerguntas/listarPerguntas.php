<?php

$conn = new mysqli("localhost", "root", "", "perguntas");

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta para pegar todas as perguntas
$sql = "SELECT IdPergunta, tituloPergunta, respostaA, respostaB, respostaC, respostaD, respostaCerta FROM perguntas";
$result = $conn->query($sql);

$perguntas = [];

// Verifica se há resultados e popula o array de perguntas
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $perguntas[] = [
            'IdPergunta' => $row['IdPergunta'],
            'tituloPergunta' => $row['tituloPergunta'],
            'respostaA' => $row['respostaA'],
            'respostaB' => $row['respostaB'],
            'respostaC' => $row['respostaC'],
            'respostaD' => $row['respostaD'],
            'respostaCerta' => $row['respostaCerta']
        ];
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

header('Content-Type: application/json');
echo json_encode($perguntas);
?>
