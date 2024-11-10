<?php
$conn = new mysqli("localhost", "root", "", "3DAW");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['buscar']) && $data['buscar'] == true) {
        // Buscar pergunta pelo ID
        $idBuscar = $data['buscarID'] ?? null;

        if ($idBuscar) {
            $stmt = $conn->prepare("SELECT * FROM Perguntas WHERE id_perguntas = ?");
            $stmt->bind_param("i", $idBuscar);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $pergunta = $result->fetch_assoc();
                echo json_encode(['status' => 'success', 'data' => $pergunta]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Pergunta não encontrada.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID não fornecido.']);
        }
    } elseif (isset($data['alterar']) && $data['alterar'] == true) {
        // Atualizar pergunta
        $idAlterar = $data['idPergunta'] ?? null;
        $novaPergunta = $data['tituloPergunta'] ?? null;
        $novaOpcaoA = $data['respostaA'] ?? null;
        $novaOpcaoB = $data['respostaB'] ?? null;
        $novaOpcaoC = $data['respostaC'] ?? null;
        $novaOpcaoD = $data['respostaD'] ?? null;
        $opcaoCerta = $data['respostaCerta'] ?? null;

        if ($idAlterar && $novaPergunta && $novaOpcaoA && $novaOpcaoB && $novaOpcaoC && $novaOpcaoD && $opcaoCerta) {
            $stmt = $conn->prepare("UPDATE Perguntas SET questao = ?, opcaoA = ?, opcaoB = ?, opcaoC = ?, opcaoD = ?, opcaoCerta = ? WHERE id_perguntas = ?");
            $stmt->bind_param("issssss", $idAlterar, $novaPergunta, $novaOpcaoA, $novaOpcaoB, $novaOpcaoC, $novaOpcaoD, $opcaoCerta);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Pergunta atualizada com sucesso.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao atualizar a pergunta.']);
            }

            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Dados incompletos para atualização.']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}

$conn->close();
?>
