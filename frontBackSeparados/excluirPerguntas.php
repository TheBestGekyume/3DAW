<?php
$IdPergunta = $msg = "";

// Função para excluir uma pergunta
function excluirPergunta($IdExcluir) {
    if (!file_exists("FilePerguntas.txt")) {
        return "Arquivo de perguntas não encontrado!";
    }

    $file = fopen("FilePerguntas.txt", "r") or die("Erro ao abrir arquivo");
    $fileTemp = fopen("FilePerguntas_temp.txt", "w") or die("Erro ao criar arquivo temporário");

    $perguntaEncontrada = false;

    while (!feof($file)) {
        $linha = fgets($file);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] !== $IdExcluir) {
                fwrite($fileTemp, $linha);
            } else {
                $perguntaEncontrada = true;
            }
        }
    }

    fclose($file);
    fclose($fileTemp);

    if ($perguntaEncontrada) {
        rename("FilePerguntas_temp.txt", "FilePerguntas.txt");
        return "Pergunta excluída com sucesso!";
    } else {
        unlink("FilePerguntas_temp.txt"); // Remove o arquivo temporário se a pergunta não for encontrada
        return "Pergunta não encontrada!";
    }
}

// Lógica principal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $IdPergunta = $_POST["IdPergunta"];
    $msg = excluirPergunta($IdPergunta);
    // Redirecionar para o HTML para evitar envio duplo
    header("Location: excluirPerguntas.html?msg=" . urlencode($msg));
    exit;
}
?>
