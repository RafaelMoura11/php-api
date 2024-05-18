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

$name = $_POST["name"];

$sql = "INSERT INTO users (name) VALUES ('$name')";
$result = $conn->query($sql);

$conn->close();
?>