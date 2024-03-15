<?php
include 'db_connection.php';

// Dados recebidos do frontend
$title = $_POST['title'];
$data = $_POST['data'];

// URL da API do Google para gerar QR code
$api_url = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . urlencode($data);

// Insere o QR code no banco de dados
$sql = "INSERT INTO qrcodes (title, data, image_url) VALUES ('$title', '$data', '$api_url')";
if ($conn->query($sql) === TRUE) {
    echo "QR code gerado e inserido com sucesso";
} else {
    echo "Erro ao gerar QR code: " . $conn->error;
}

$conn->close();
?>
