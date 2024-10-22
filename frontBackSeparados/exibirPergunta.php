<?php

$idPergunta = "";
$pergunta = null;
$msg = "";

function buscarPerguntaPorId($idBuscado){
    if (!file_exists("FilePerguntas.txt")) return null;

    $file = fopen("FilePerguntas.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] === $idBuscado) {
                fclose($file);

                return [
                    'IdPergunta' => $dados[0],
                    'TituloPergunta' => $dados[1],
                    'RespostaA' => $dados[2],
                    'RespostaB' => $dados[3],
                    'RespostaC' => $dados[4],
                    'RespostaD' => $dados[5],
                    'RespostaCorreta' => $dados[6]
                ];
            }
        }
    }
    fclose($file);
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["IdPergunta"];
    $pergunta = buscarPerguntaPorId($idPergunta);

    if (!$pergunta) {
        $msg = "Pergunta não encontrada!";
    }

    // Retornar os dados como JSON para o JavaScript manipular
    echo json_encode(['msg' => $msg, 'pergunta' => $pergunta]);
    exit();
}
?>
