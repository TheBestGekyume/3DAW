<?php
$IdPergunta = $msg = "";

function excluirPergunta($IdExcluir) {
    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "", "perguntas");

    // Verificar conexão
    if ($conn->connect_error) {
        return "Erro ao conectar ao banco de dados: " . $conn->connect_error;
    }

    // Preparar a consulta SQL para excluir a pergunta
    $sql = "DELETE FROM perguntas WHERE idPergunta = ?";

    // Preparar e vincular
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $IdExcluir);

        // Executar e verificar se foi bem-sucedido
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Pergunta excluída com sucesso!";
        } else {
            $stmt->close();
            $conn->close();
            return "Erro ao excluir a pergunta: " . $stmt->error;
        }
    } else {
        $conn->close();
        return "Erro ao preparar a consulta: " . $conn->error;
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
