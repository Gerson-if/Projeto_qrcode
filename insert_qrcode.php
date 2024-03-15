<?php
include 'db_connection.php';

// Dados recebidos do frontend
$data = $_POST['data'];

// Geração do QR code usando a API do Google
$image_url = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . urlencode($data);

// Inserção do QR code no banco de dados
$sql = "INSERT INTO qrcodes (data, image_url) VALUES ('$data', '$image_url')";
if ($conn->query($sql) === TRUE) {
    echo "QR code inserido com sucesso";
} else {
    echo "Erro ao inserir QR code: " . $conn->error;
}

$conn->close();
?>
