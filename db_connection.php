<?php
// Configuração da conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "qrcode_db";

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
