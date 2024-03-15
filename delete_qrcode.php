<?php
include 'db_connection.php';

// Dados recebidos do frontend
$id = $_POST['id'];

// Recupera a URL da imagem associada ao QR code
$sql_select_image = "SELECT image_url FROM qrcodes WHERE id=$id";
$result_select_image = $conn->query($sql_select_image);
$row = $result_select_image->fetch_assoc();
$image_url = $row['image_url'];

// Exclusão do QR code do banco de dados
$sql_delete_qrcode = "DELETE FROM qrcodes WHERE id=$id";
if ($conn->query($sql_delete_qrcode) === TRUE) {
    // Exclusão da imagem associada
    // Não é necessário excluir a imagem, pois ela é gerada dinamicamente pela API do Google
    echo "QR code excluído com sucesso";
} else {
    echo "Erro ao excluir QR code: " . $conn->error;
}

$conn->close();
?>
