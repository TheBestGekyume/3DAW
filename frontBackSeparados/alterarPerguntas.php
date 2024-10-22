<?php

function buscarPerguntaPorId($IdBuscado){
    if (!file_exists("FilePerguntas.txt")) return null;

    $file = fopen("FilePerguntas.txt", "r");
    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == $IdBuscado) {
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

function alterarPergunta($IdPergunta, $tituloPergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCorreta){
    if (!file_exists("FilePerguntas.txt")) {
        return "Arquivo de Perguntas não encontrado!";
    }

    $file = fopen("FilePerguntas.txt", "r");
    $fileNovo = fopen("FilePerguntas_temp.txt", "w");

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == $IdPergunta) {
                $linha = $IdPergunta . ";" . $tituloPergunta . ";" . $respostaA . ";" . $respostaB . ";" . $respostaC . ";" . $respostaD . ";" . $respostaCorreta . "\n";
            }
            fwrite($fileNovo, $linha);
        }
    }

    fclose($file);
    fclose($fileNovo);
    rename("FilePerguntas_temp.txt", "FilePerguntas.txt");

    return "Dados da pergunta alterados com sucesso!";
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['buscar'])) {
        $buscarId = $data['buscarID'];
        $pergunta = buscarPerguntaPorId($buscarId);
        echo json_encode($pergunta ? ['status' => 'success', 'data' => $pergunta] : ['status' => 'error', 'message' => 'Pergunta não encontrada']);
    } else if (isset($data['alterar'])) {
        $IdPergunta = $data["IdPergunta"];
        $tituloPergunta = $data["tituloPergunta"];
        $respostaA = $data["respostaA"];
        $respostaB = $data["respostaB"];
        $respostaC = $data["respostaC"];
        $respostaD = $data["respostaD"];
        $respostaCorreta = $data["respostaCorreta"];

        $msg = alterarPergunta($IdPergunta, $tituloPergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCorreta);
        echo json_encode(['status' => 'success', 'message' => $msg]);
    }
}

?>
