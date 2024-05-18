<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meubanco";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, name FROM users";
$result = $conn->query($sql);

$users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} 

// Configurar o cabeçalho para indicar que estamos respondendo com JSON
header('Content-Type: application/json');

// Enviar a resposta JSON de volta para o cliente
echo json_encode($users);

$conn->close();
?>
