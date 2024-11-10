<?php
$conn = new mysqli("localhost", "root", "", "perguntas");

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados da requisição POST
    $tituloPergunta = $_POST["tituloPergunta"];
    $respostaA = $_POST["respostaA"];
    $respostaB = $_POST["respostaB"];
    $respostaC = $_POST["respostaC"];
    $respostaD = $_POST["respostaD"];
    $respostaCorreta = $_POST["respostaCorreta"];

    // Monta a query de inserção
    $sql = "INSERT INTO perguntas (tituloPergunta, respostaA, respostaB, respostaC, respostaD, respostaCerta) 
            VALUES ('$tituloPergunta', '$respostaA', '$respostaB', '$respostaC', '$respostaD', '$respostaCorreta')";

    if ($conn->query($sql) === TRUE) {
        echo "Nova pergunta inserida com sucesso!";
    } else {
        echo "Erro ao inserir a pergunta: " . $conn->error;
    }
}

$conn->close();
?>
