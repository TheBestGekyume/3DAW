<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $login = $data["loginUsuario"];
    $senha = $data["senhaUsuario"];
    $msg = "";

    if (strlen($login) < 5) {
        $msg = "O login deve ter pelo menos 5 caracteres!";
        echo json_encode(['status' => 'error', 'message' => $msg]);
        exit;
    } elseif (strlen($senha) < 8) {
        $msg = "A senha deve ter pelo menos 8 caracteres!";
        echo json_encode(['status' => 'error', 'message' => $msg]);
        exit;
    } else {
        if (!file_exists("usuarios.txt")) {
            $file = fopen("usuarios.txt", "w") or die("Erro ao criar arquivo");
            $linha = "login;senha\n";
            fwrite($file, $linha);
            fclose($file);
        }

        $file = fopen("usuarios.txt", "a") or die("Erro ao abrir arquivo");
        $linha = $login . ";" . $senha . "\n";
        fwrite($file, $linha);
        fclose($file);
        $msg = "Usuário cadastrado com sucesso!";
        echo json_encode(['status' => 'success', 'message' => $msg]);
        exit;
    }
}
?>
