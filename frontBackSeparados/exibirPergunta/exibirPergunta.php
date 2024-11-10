<?php
$conn = new mysqli("localhost", "root", "", "perguntas"); // Conexão com o banco de dados

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$idPergunta = "";
$pergunta = null;
$msg = "";

// Função para buscar a pergunta pelo ID no banco de dados
function buscarPerguntaPorId($idBuscado, $conn) {
    $sql = "SELECT IdPergunta, TituloPergunta, RespostaA, RespostaB, RespostaC, RespostaD, RespostaCerta FROM perguntas WHERE IdPergunta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idBuscado);  // "i" para tipo inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Retorna a primeira linha como um array associativo
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["IdPergunta"];
    $pergunta = buscarPerguntaPorId($idPergunta, $conn);

    if (!$pergunta) {
        $msg = "Pergunta não encontrada!";
    }

    // Retorna os dados como JSON para o JavaScript manipular
    echo json_encode(['msg' => $msg, 'pergunta' => $pergunta]);
    exit();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
