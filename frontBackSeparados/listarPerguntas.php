<?php
// listarPerguntas.php
$file = fopen("FilePerguntas.txt", "r") or die("Erro ao abrir o arquivo.");

$perguntas = [];

// Pula o cabeçalho
$header = fgets($file);

while ($linha = fgets($file)) {
    $dados = explode(";", trim($linha));
    if (count($dados) == 7) {
        $perguntas[] = [
            'IdPergunta' => $dados[0],
            'tituloPergunta' => $dados[1],
            'respostaA' => $dados[2],
            'respostaB' => $dados[3],
            'respostaC' => $dados[4],
            'respostaD' => $dados[5],
            'respostaCorreta' => $dados[6]
        ];
    }
}

fclose($file);

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($perguntas);
?>
