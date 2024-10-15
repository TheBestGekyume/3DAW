<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $IdPergunta = $_GET["IdPergunta"];
    $tituloPergunta = $_GET["tituloPergunta"];
    $respostaA = $_GET["respostaA"];
    $respostaB = $_GET["respostaB"];
    $respostaC = $_GET["respostaC"];
    $respostaD = $_GET["respostaD"];
    $respostaCorreta = $_GET["respostaCorreta"];
    $msg = "";


    if (!file_exists("FilePerguntas.txt")) {
        $file = fopen("FilePerguntas.txt", "w") or die("Erro ao criar arquivo");
        $linha = "IdPergunta;tituloPergunta;respostaA;respostaB;respostaC;respostaD;respostaCorreta\n";
        fwrite($file, $linha);
        fclose($file);
    }

    $file = fopen("FilePerguntas.txt", "a") or die("Erro ao abrir arquivo");
    $linha = $IdPergunta . ";" . $tituloPergunta . ";" . $respostaA . ";" . $respostaB . ";" . $respostaC . ";" . $respostaD . ";". $respostaCorreta . "\n";
    fwrite($file, $linha);
    fclose($file);
    $msg = "Pergunta cadastrada com sucesso!";
}

?>

